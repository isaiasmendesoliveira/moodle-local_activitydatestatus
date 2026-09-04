// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <https://www.gnu.org/licenses/>.

const BLOCK_ATTRIBUTE = 'data-local-activitydatestatus';
const SVG_NS = 'http://www.w3.org/2000/svg';
const REFRESH_INTERVAL = 60000;
const NATIVE_DATES_SELECTOR = '[data-region="activity-dates"], .activity-dates';
const NATIVE_HIDDEN_ATTRIBUTE = 'data-local-activitydatestatus-native-hidden';

const STATE_TEXT_CLASSES = {
    upcoming: ['text-info'],
    available: ['text-success'],
    warning: ['text-warning'],
    overdue: ['text-warning'],
    critical: ['text-danger'],
    closed: ['text-danger'],
    neutral: ['text-secondary'],
};

const STATE_BADGE_CLASSES = {
    upcoming: ['badge', 'bg-info', 'text-dark'],
    available: ['badge', 'bg-success', 'text-white'],
    warning: ['badge', 'bg-warning', 'text-dark'],
    overdue: ['badge', 'bg-warning', 'text-dark'],
    critical: ['badge', 'bg-danger', 'text-white'],
    closed: ['badge', 'bg-danger', 'text-white'],
    neutral: ['badge', 'bg-secondary', 'text-white'],
};

/**
 * Choose the activity date which is most relevant at the current moment.
 *
 * @param {Object} item Activity payload.
 * @param {Number} now Server-adjusted Unix timestamp in seconds.
 * @returns {{date: Object, future: Boolean}|null}
 */
const selectRelevantDate = (item, now) => {
    if (!Array.isArray(item.dates) || item.dates.length === 0) {
        return null;
    }

    const future = item.dates.find((date) => Number(date.timestamp) > now);
    if (future) {
        return {date: future, future: true};
    }

    return {date: item.dates[item.dates.length - 1], future: false};
};

/**
 * Convert a date into a semantic presentation state.
 *
 * @param {Object} selected Selected date wrapper.
 * @param {Object} item Activity payload.
 * @param {Number} now Current server-adjusted timestamp.
 * @returns {String}
 */
const getState = (selected, item, now) => {
    const date = selected.date;
    const kind = date.kind || 'neutral';

    if (!selected.future) {
        if (kind === 'opening') {
            return 'available';
        }
        if (kind === 'due') {
            return 'overdue';
        }
        if (kind === 'closing') {
            return 'closed';
        }
        return 'neutral';
    }

    if (kind === 'opening') {
        return 'upcoming';
    }

    if (kind === 'due' || kind === 'closing') {
        const remaining = Number(date.timestamp) - now;
        const warning = Math.max(0, Number(item.warningseconds) || 0);
        const critical = Math.max(0, Math.min(Number(item.criticalseconds) || 0, warning || Number.MAX_SAFE_INTEGER));

        if (critical > 0 && remaining <= critical) {
            return 'critical';
        }
        if (warning > 0 && remaining <= warning) {
            return 'warning';
        }
        return 'available';
    }

    return 'upcoming';
};

/**
 * Pick a useful unit for Intl.RelativeTimeFormat.
 *
 * @param {Number} seconds Signed number of seconds to the target date.
 * @returns {{value: Number, unit: String}}
 */
const relativeUnit = (seconds) => {
    const absolute = Math.abs(seconds);

    if (absolute < 60) {
        return {value: 0, unit: 'second'};
    }
    if (absolute < 90 * 60) {
        return {value: Math.round(seconds / 60), unit: 'minute'};
    }
    if (absolute < 36 * 60 * 60) {
        return {value: Math.round(seconds / (60 * 60)), unit: 'hour'};
    }
    if (absolute < 14 * 24 * 60 * 60) {
        return {value: Math.round(seconds / (24 * 60 * 60)), unit: 'day'};
    }
    if (absolute < 8 * 7 * 24 * 60 * 60) {
        return {value: Math.round(seconds / (7 * 24 * 60 * 60)), unit: 'week'};
    }
    if (absolute < 18 * 30.4375 * 24 * 60 * 60) {
        return {value: Math.round(seconds / (30.4375 * 24 * 60 * 60)), unit: 'month'};
    }

    return {value: Math.round(seconds / (365.25 * 24 * 60 * 60)), unit: 'year'};
};

/**
 * Format a relative interval using the page language.
 *
 * @param {Intl.RelativeTimeFormat} formatter Formatter instance.
 * @param {Number} timestamp Target timestamp.
 * @param {Number} now Current timestamp.
 * @returns {String}
 */
const formatRelative = (formatter, timestamp, now) => {
    const relative = relativeUnit(Number(timestamp) - now);
    return formatter.format(relative.value, relative.unit);
};

/**
 * Create a dependency-free SVG icon which inherits currentColor.
 *
 * @param {String} state Status state.
 * @returns {SVGElement}
 */
const buildStatusIcon = (state) => {
    const svg = document.createElementNS(SVG_NS, 'svg');
    svg.setAttribute('viewBox', '0 0 24 24');
    svg.setAttribute('focusable', 'false');
    svg.setAttribute('aria-hidden', 'true');
    svg.classList.add('local-activitydatestatus__icon');

    const addPath = (d) => {
        const path = document.createElementNS(SVG_NS, 'path');
        path.setAttribute('d', d);
        svg.appendChild(path);
    };

    if (state === 'available') {
        const circle = document.createElementNS(SVG_NS, 'circle');
        circle.setAttribute('cx', '12');
        circle.setAttribute('cy', '12');
        circle.setAttribute('r', '9');
        svg.appendChild(circle);
        addPath('m8 12 2.6 2.6L16.5 9');
    } else if (state === 'warning' || state === 'critical' || state === 'overdue') {
        addPath('M12 3 2.8 20h18.4L12 3Z');
        addPath('M12 9v4');
        addPath('M12 16.5h.01');
    } else if (state === 'closed') {
        const rect = document.createElementNS(SVG_NS, 'rect');
        rect.setAttribute('x', '6');
        rect.setAttribute('y', '10');
        rect.setAttribute('width', '12');
        rect.setAttribute('height', '9');
        rect.setAttribute('rx', '2');
        svg.appendChild(rect);
        addPath('M8.5 10V7.5a3.5 3.5 0 0 1 7 0V10');
    } else if (state === 'neutral') {
        const rect = document.createElementNS(SVG_NS, 'rect');
        rect.setAttribute('x', '4');
        rect.setAttribute('y', '5');
        rect.setAttribute('width', '16');
        rect.setAttribute('height', '15');
        rect.setAttribute('rx', '2');
        svg.appendChild(rect);
        addPath('M8 3v4M16 3v4M4 9h16');
    } else {
        const circle = document.createElementNS(SVG_NS, 'circle');
        circle.setAttribute('cx', '12');
        circle.setAttribute('cy', '12');
        circle.setAttribute('r', '9');
        svg.appendChild(circle);
        addPath('M12 7v5l3 2');
    }

    return svg;
};

/**
 * Add a label consistently, preserving labels which already contain punctuation.
 *
 * @param {HTMLElement} parent Target element.
 * @param {String} value Label.
 */
const appendLabel = (parent, value) => {
    const label = document.createElement('strong');
    label.textContent = /[:：]\s*$/.test(value) ? `${value} ` : `${value}: `;
    parent.appendChild(label);
};

/**
 * Build exact-date lines in a restrained Moodle-like presentation.
 *
 * @param {Object} item Activity payload.
 * @returns {HTMLElement|null}
 */
const buildDates = (item) => {
    if (!Array.isArray(item.dates) || item.dates.length === 0) {
        return null;
    }

    const dates = document.createElement('div');
    dates.className = 'local-activitydatestatus__dates';

    item.dates.forEach((date) => {
        const row = document.createElement('div');
        row.className = 'local-activitydatestatus__date';
        appendLabel(row, date.label);

        const exact = document.createElement('span');
        exact.textContent = date.exact;
        row.appendChild(exact);
        dates.appendChild(row);
    });

    return dates;
};

/**
 * Build the relative status line or Bootstrap 5 badge.
 *
 * @param {Object} item Activity payload.
 * @param {Number} now Current timestamp.
 * @param {Intl.RelativeTimeFormat} formatter Relative-time formatter.
 * @returns {{element: HTMLElement, key: String}|null}
 */
const buildStatus = (item, now, formatter) => {
    const selected = selectRelevantDate(item, now);
    if (!selected) {
        return null;
    }

    const state = getState(selected, item, now);
    const date = selected.date;
    const relative = formatRelative(formatter, date.timestamp, now);
    const style = item.statusstyle === 'text' ? 'text' : 'badge';

    const row = document.createElement('div');
    row.className = 'local-activitydatestatus__statusrow';
    row.setAttribute('aria-live', 'polite');

    const status = document.createElement('span');
    status.className = [
        'local-activitydatestatus__status',
        `local-activitydatestatus__status--${style}`,
        `local-activitydatestatus__status--${state}`,
    ].join(' ');
    const classes = style === 'badge'
        ? (STATE_BADGE_CLASSES[state] || STATE_BADGE_CLASSES.neutral)
        : (STATE_TEXT_CLASSES[state] || STATE_TEXT_CLASSES.neutral);
    status.classList.add(...classes, 'd-inline-flex', 'align-items-center', 'flex-nowrap');
    status.appendChild(buildStatusIcon(state));

    // Keep an explicit two-space visual separator between icon and message.
    // NBSP is used because ordinary HTML whitespace collapses to a single space.
    const spacer = document.createElement('span');
    spacer.className = 'local-activitydatestatus__double-space';
    spacer.setAttribute('aria-hidden', 'true');
    spacer.textContent = '\u00a0\u00a0';
    status.appendChild(spacer);

    // Keep the complete "Message: value" phrase as one horizontal flex item.
    const message = document.createElement('span');
    message.className = 'local-activitydatestatus__message';

    const label = document.createElement('strong');
    const cleanLabel = String(date.label || '').replace(/[:：]\s*$/, '');
    label.textContent = `${cleanLabel}:`;
    message.appendChild(label);
    message.appendChild(document.createTextNode(' '));

    const relativeText = document.createElement('span');
    relativeText.className = 'local-activitydatestatus__value';
    relativeText.textContent = relative;
    message.appendChild(relativeText);

    status.appendChild(message);
    row.appendChild(status);

    return {
        element: row,
        key: `${style}|${state}|${date.timestamp}|${relative}`,
    };
};

/**
 * Build the configured activity block.
 *
 * @param {Object} item Activity payload.
 * @param {Number} now Current timestamp.
 * @param {Intl.RelativeTimeFormat} formatter Relative-time formatter.
 * @returns {HTMLElement|null}
 */
const buildBlock = (item, now, formatter) => {
    const mode = ['dates', 'status', 'both'].includes(item.displaymode) ? item.displaymode : 'both';
    const showDates = mode === 'dates' || mode === 'both';
    const showStatus = mode === 'status' || mode === 'both';

    const block = document.createElement('div');
    block.className = `local-activitydatestatus local-activitydatestatus--mode-${mode}`;
    block.setAttribute(BLOCK_ATTRIBUTE, String(item.cmid));

    const keys = [mode, item.statusstyle || 'badge'];
    let contentCount = 0;

    if (showDates) {
        const dates = buildDates(item);
        if (dates) {
            block.appendChild(dates);
            keys.push(item.dates.map((date) => `${date.label}|${date.timestamp}|${date.exact}`).join('~'));
            contentCount++;
        }
    }

    if (showStatus) {
        const status = buildStatus(item, now, formatter);
        if (status) {
            block.appendChild(status.element);
            keys.push(status.key);
            contentCount++;
        }
    }

    if (contentCount === 0) {
        return null;
    }

    block.dataset.stateKey = keys.join('||');
    return block;
};

/**
 * Locate the standard Moodle activity grid.
 *
 * @param {HTMLElement} cmitem Course module item.
 * @returns {HTMLElement|null}
 */
const findContainer = (cmitem) => cmitem.querySelector('.activity-grid');

/**
 * Find Moodle's native activity-date region for one course module.
 *
 * @param {HTMLElement} cmitem Course module item.
 * @returns {HTMLElement|null}
 */
const findNativeDates = (cmitem) => cmitem.querySelector(NATIVE_DATES_SELECTOR);

/**
 * Restore a native date region only when this plugin hid it previously.
 *
 * @param {HTMLElement|null} nativeDates Moodle native date region.
 */
const restoreNativeDates = (nativeDates) => {
    if (!nativeDates || !nativeDates.hasAttribute(NATIVE_HIDDEN_ATTRIBUTE)) {
        return;
    }

    nativeDates.hidden = false;
    nativeDates.removeAttribute(NATIVE_HIDDEN_ATTRIBUTE);
};

/**
 * Hide Moodle's native date region while recording that this plugin owns the change.
 *
 * @param {HTMLElement|null} nativeDates Moodle native date region.
 */
const hideNativeDates = (nativeDates) => {
    if (!nativeDates) {
        return;
    }

    nativeDates.hidden = true;
    nativeDates.setAttribute(NATIVE_HIDDEN_ATTRIBUTE, '1');
};

/**
 * Insert the plugin output near Moodle's own metadata.
 *
 * @param {HTMLElement} container Activity grid.
 * @param {HTMLElement} block Status block.
 */
const insertBlock = (container, block) => {
    const nativeDates = container.querySelector(NATIVE_DATES_SELECTOR);
    if (nativeDates) {
        nativeDates.insertAdjacentElement('afterend', block);
        return;
    }

    const description = container.querySelector('.activity-description');
    if (description) {
        description.insertAdjacentElement('afterend', block);
        return;
    }

    const availability = container.querySelector('[data-region="availability"]');
    if (availability) {
        availability.insertAdjacentElement('beforebegin', block);
        return;
    }

    const afterlink = container.querySelector('.activity-afterlink');
    if (afterlink) {
        afterlink.insertAdjacentElement('beforebegin', block);
        return;
    }

    container.appendChild(block);
};

/**
 * Render configured blocks currently present in the course DOM.
 *
 * All display modes are explicit. Native Moodle dates are hidden only after the
 * plugin successfully renders replacement content for that activity.
 *
 * @param {Array} items Activity payloads.
 * @param {Number} now Current timestamp.
 * @param {Intl.RelativeTimeFormat} formatter Relative-time formatter.
 */
const render = (items, now, formatter) => {
    items.forEach((item) => {
        const cmitem = document.querySelector(`[data-for="cmitem"][data-id="${item.cmid}"]`);
        if (!cmitem) {
            return;
        }

        const selector = `[${BLOCK_ATTRIBUTE}="${item.cmid}"]`;
        const existing = cmitem.querySelector(selector);
        const nativeDates = findNativeDates(cmitem);
        const block = buildBlock(item, now, formatter);

        // Fail-safe: if the plugin cannot build useful output, never suppress Moodle's dates.
        if (!block) {
            if (existing) {
                existing.remove();
            }
            restoreNativeDates(nativeDates);
            return;
        }

        let rendered = false;
        if (existing && existing.dataset.stateKey === block.dataset.stateKey) {
            rendered = true;
        } else if (existing) {
            existing.replaceWith(block);
            rendered = true;
        } else {
            const container = findContainer(cmitem);
            if (container) {
                insertBlock(container, block);
                rendered = true;
            }
        }

        if (!rendered) {
            restoreNativeDates(nativeDates);
            return;
        }

        hideNativeDates(nativeDates);
    });
};

/**
 * Initialise Activity Date Status on a Moodle course page.
 *
 * Relative text is refreshed every minute using a server-time offset. Standard
 * Moodle AJAX activity replacements are handled through MutationObserver.
 *
 * @param {Array} items Activity payloads.
 * @param {Number} serverNow Server Unix timestamp at page generation.
 * @param {String} locale Moodle language converted to BCP-47 form.
 */
export const init = (items, serverNow, locale) => {
    if (!Array.isArray(items) || items.length === 0) {
        return;
    }

    const serverOffsetMs = (Number(serverNow) * 1000) - Date.now();
    const currentServerTime = () => Math.floor((Date.now() + serverOffsetMs) / 1000);
    let formatter;

    try {
        formatter = new Intl.RelativeTimeFormat(locale || undefined, {numeric: 'auto'});
    } catch (error) {
        formatter = new Intl.RelativeTimeFormat(undefined, {numeric: 'auto'});
    }

    const refresh = () => render(items, currentServerTime(), formatter);
    refresh();
    window.setInterval(refresh, REFRESH_INTERVAL);

    let scheduled = false;
    const observerRoot = document.querySelector('.course-content') || document.body;
    const observer = new MutationObserver(() => {
        if (scheduled) {
            return;
        }
        scheduled = true;
        window.requestAnimationFrame(() => {
            scheduled = false;
            refresh();
        });
    });

    observer.observe(observerRoot, {
        childList: true,
        subtree: true,
    });
};