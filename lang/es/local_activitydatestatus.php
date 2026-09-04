<?php
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

$string['pluginname'] = 'Estado de fechas de actividades';

$string['formsection'] = 'Indicador de fechas y plazos';
$string['enabledlabel'] = 'Mostrar indicador de estado y plazo';
$string['enabledlabel_help'] = 'Cuando está habilitado, el complemento utiliza exclusivamente las fechas proporcionadas por la API nativa de fechas de actividades de Moodle. Las fechas y reglas de acceso siguen siendo controladas por la propia actividad y pueden variar según el usuario, incluidas las excepciones admitidas por el módulo.';
$string['enableddescription'] = 'Muestra en la página del curso las fechas exactas, el estado relativo o ambos, según la configuración siguiente.';

$string['displaymode'] = 'Modo de visualización';
$string['displaymode_help'] = 'Elija exactamente qué debe mostrar esta actividad. En todos los modos, el complemento reemplaza únicamente el bloque nativo de fechas de esta actividad después de generar correctamente su propio contenido, evitando duplicaciones. Si no puede generar la salida, las fechas nativas de Moodle permanecen visibles.';
$string['displaymode_dates'] = 'Solo fechas';
$string['displaymode_status'] = 'Solo estado';
$string['displaymode_both'] = 'Fechas + estado (recomendado)';

$string['statusstyle'] = 'Apariencia del estado';
$string['statusstyle_help'] = 'Elija cómo se presenta el estado relativo. Badge Bootstrap 5 utiliza clases nativas del tema/Moodle como badge, bg-success, bg-warning y bg-danger. Texto coloreado utiliza las clases text-* correspondientes. Los iconos heredan el mismo color.';
$string['statusstyle_badge'] = 'Badge Bootstrap 5 (recomendado)';
$string['statusstyle_text'] = 'Texto coloreado con icono';

$string['warninghoursactivity'] = 'Destacar proximidad del plazo';
$string['warninghoursactivity_help'] = 'Cuando una fecha de entrega o cierre esté dentro de este intervalo, el estado pasa al nivel de atención (Bootstrap warning). Introduzca 0 para desactivar este destaque. Ejemplo: 48 horas.';
$string['criticalhoursactivity'] = 'Destacar urgencia crítica';
$string['criticalhoursactivity_help'] = 'Opcional. Cuando una fecha de entrega o cierre esté dentro de este intervalo, el estado pasa al nivel crítico (Bootstrap danger). Introduzca 0 para desactivarlo. El valor efectivo nunca será mayor que el intervalo de proximidad del plazo.';
$string['hoursbefore'] = 'horas antes';
$string['sourcenote'] = '<small class="text-muted">Las fechas proceden de la API nativa de Moodle. El complemento sustituye únicamente la presentación de fechas de esta actividad; no modifica apertura, cierre, plazos, excepciones ni reglas de acceso.</small>';

$string['defaultsheading'] = 'Valores predeterminados para nuevas actividades';
$string['defaultsheading_desc'] = 'Estos valores sirven únicamente como punto de partida cuando una actividad se crea o se configura por primera vez. El profesorado puede modificar todas las opciones individualmente en cada actividad.';
$string['defaultenabled'] = 'Activar de forma predeterminada';
$string['defaultenabled_desc'] = 'Define el estado inicial de “Mostrar indicador de estado y plazo”. No modifica retroactivamente actividades ya configuradas.';
$string['defaultdisplaymode'] = 'Modo de visualización predeterminado';
$string['defaultdisplaymode_desc'] = 'Modo seleccionado inicialmente en la configuración de cada actividad. El profesorado puede cambiarlo individualmente.';
$string['defaultstatusstyle'] = 'Apariencia predeterminada del estado';
$string['defaultstatusstyle_desc'] = 'Define la presentación inicial del estado. Badge Bootstrap 5 es la opción recomendada y el profesorado puede cambiarla en cada actividad.';
$string['defaultwarninghours'] = 'Proximidad del plazo predeterminada (horas)';
$string['defaultwarninghours_desc'] = 'Valor inicial para el nivel de atención. Predeterminado: 48 horas. Use 0 para desactivarlo.';
$string['defaultcriticalhours'] = 'Urgencia crítica predeterminada (horas)';
$string['defaultcriticalhours_desc'] = 'Valor inicial para el nivel crítico. Predeterminado: 12 horas. Use 0 para desactivarlo.';

$string['privacy:metadata'] = 'El complemento Estado de fechas de actividades no almacena datos personales.';
