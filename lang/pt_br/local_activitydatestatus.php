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

$string['pluginname'] = 'Status das datas das atividades';

$string['formsection'] = 'Indicador de datas e prazos';
$string['enabledlabel'] = 'Exibir indicador de estado e prazo';
$string['enabledlabel_help'] = 'Quando habilitado, o plugin usa exclusivamente as datas fornecidas pela API nativa de datas das atividades do Moodle. As datas e regras de acesso continuam sendo definidas pela própria atividade e podem variar conforme o usuário, inclusive quando o módulo oferece sobreposições.';
$string['enableddescription'] = 'Exibe, na página do curso, as datas exatas, o status relativo ou ambos, conforme a configuração abaixo.';

$string['displaymode'] = 'Modo de exibição';
$string['displaymode_help'] = 'Escolha exatamente o que esta atividade deve exibir. Em todos os modos, o plugin substitui somente o bloco nativo de datas desta atividade depois de montar seu próprio conteúdo com sucesso, evitando duplicação. Se o plugin não conseguir montar a saída, as datas nativas do Moodle permanecem visíveis.';
$string['displaymode_dates'] = 'Somente datas';
$string['displaymode_status'] = 'Somente status';
$string['displaymode_both'] = 'Datas + status (recomendado)';

$string['statusstyle'] = 'Aparência do status';
$string['statusstyle_help'] = 'Escolha como o status relativo será apresentado. Badge Bootstrap 5 utiliza classes nativas do tema/Moodle, como badge, bg-success, bg-warning e bg-danger. Texto colorido utiliza as classes text-* correspondentes. Os ícones herdam a mesma cor.';
$string['statusstyle_badge'] = 'Badge Bootstrap 5 (recomendado)';
$string['statusstyle_text'] = 'Texto colorido com ícone';

$string['warninghoursactivity'] = 'Destacar proximidade do prazo';
$string['warninghoursactivity_help'] = 'Quando uma data de prazo ou fechamento estiver dentro deste intervalo, o status passa para o estado de atenção (Bootstrap warning). Informe 0 para desativar esse destaque. Exemplo: 48 horas.';
$string['criticalhoursactivity'] = 'Destacar urgência crítica';
$string['criticalhoursactivity_help'] = 'Opcional. Quando uma data de prazo ou fechamento estiver dentro deste intervalo, o status passa para o estado crítico (Bootstrap danger). Informe 0 para desativar. O valor efetivo nunca será maior que o intervalo de proximidade do prazo.';
$string['hoursbefore'] = 'horas antes';
$string['sourcenote'] = '<small class="text-muted">As datas são obtidas da API nativa do Moodle. O plugin substitui apenas a apresentação das datas desta atividade; abertura, fechamento, prazos, sobreposições e regras de acesso não são alterados.</small>';

$string['defaultsheading'] = 'Padrões para novas atividades';
$string['defaultsheading_desc'] = 'Estes valores servem apenas como ponto de partida quando uma atividade é criada ou configurada pela primeira vez. O professor pode alterar todas as opções individualmente em cada atividade.';
$string['defaultenabled'] = 'Ativar por padrão';
$string['defaultenabled_desc'] = 'Define o estado inicial da opção “Exibir indicador de estado e prazo”. Não altera retroativamente atividades já configuradas.';
$string['defaultdisplaymode'] = 'Modo de exibição padrão';
$string['defaultdisplaymode_desc'] = 'Modo inicialmente selecionado nas configurações de cada atividade. O professor pode alterá-lo individualmente.';
$string['defaultstatusstyle'] = 'Aparência padrão do status';
$string['defaultstatusstyle_desc'] = 'Define a apresentação inicial do status. Badge Bootstrap 5 é o padrão recomendado e pode ser alterado pelo professor em cada atividade.';
$string['defaultwarninghours'] = 'Proximidade do prazo padrão (horas)';
$string['defaultwarninghours_desc'] = 'Valor inicial para o destaque de atenção. Padrão: 48 horas. Use 0 para desativar.';
$string['defaultcriticalhours'] = 'Urgência crítica padrão (horas)';
$string['defaultcriticalhours_desc'] = 'Valor inicial para o destaque crítico. Padrão: 12 horas. Use 0 para desativar.';

$string['privacy:metadata'] = 'O plugin Status das datas das atividades não armazena dados pessoais.';
