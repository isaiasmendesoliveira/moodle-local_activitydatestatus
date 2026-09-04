#!/usr/bin/env bash
set -euo pipefail

VERSION="${1:-1.0.0}"
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIST="$ROOT/dist"
WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

rm -rf "$DIST"
mkdir -p "$DIST"

copy_plugin() {
    local target="$1"
    mkdir -p "$target/activitydatestatus"
    rsync -a "$ROOT/" "$target/activitydatestatus/" \
        --exclude '.git/' \
        --exclude '.github/' \
        --exclude 'dist/' \
        --exclude 'tools/' \
        --exclude '.gitignore'
}

# Full multilingual release for GitHub/direct installation.
copy_plugin "$WORK/full"
(
    cd "$WORK/full"
    zip -qr "$DIST/activitydatestatus_v${VERSION}.zip" activitydatestatus
)

# Marketplace package: same multilingual plugin package (English, Brazilian Portuguese, and Spanish).
copy_plugin "$WORK/marketplace"
(
    cd "$WORK/marketplace"
    zip -qr "$DIST/activitydatestatus_v${VERSION}_marketplace.zip" activitydatestatus
)

echo "Built:"
ls -lh "$DIST"/*.zip
