# Activity Date Status

<p align="center">
  <img src="docs/images/activity-date-status-logo.png" alt="Activity Date Status logo" width="260">
</p>

**Activity Date Status** (`local_activitydatestatus`) é um plugin local para Moodle que transforma as datas nativas das atividades em informações mais claras de data exata e status relativo na página do curso, sem alterar regras de acesso, prazos ou sobreposições definidas pelo Moodle.

> **Versão pública:** 1.0.0  
> **Moodle:** 4.5–5.2  
> **Licença:** GNU GPL v3 ou posterior

## Principais recursos

- Controle individual por atividade.
- Três modos de exibição:
  - **Somente datas**;
  - **Somente status**;
  - **Datas + status** (recomendado).
- Duas aparências de status:
  - **Badge Bootstrap 5** (recomendado);
  - **Texto colorido com ícone**.
- Destaque de proximidade do prazo configurável por atividade, com padrão de **48 horas**.
- Destaque crítico opcional, com padrão de **12 horas**.
- Padrões administrativos que podem ser sobrescritos pelo professor em cada atividade.
- Estados semânticos nativos do Bootstrap 5: `info`, `success`, `warning`, `danger` e `secondary`.
- Datas específicas do usuário obtidas diretamente da API nativa do Moodle.
- Comportamento seguro: as datas nativas do Moodle só são ocultadas depois que o conteúdo do plugin é renderizado com sucesso.
- Sem serviços externos e sem dependências adicionais.

## Como funciona

O plugin utiliza:

```php
\core\activity_dates::get_dates_for_module($cm, $userid);
```

O Moodle continua sendo a única fonte das datas. O plugin armazena apenas preferências de apresentação por atividade e não duplica datas de abertura, fechamento, entrega ou regras de acesso.

## Configuração pelo professor

Ao editar uma atividade ou recurso, o professor pode definir:

- **Exibir indicador de estado e prazo**;
- **Modo de exibição**;
- **Aparência do status**;
- **Destacar proximidade do prazo**;
- **Destacar urgência crítica**.

Os padrões do site ficam em:

**Administração do site → Plugins → Plugins locais → Status das datas das atividades**

Esses valores são apenas padrões. O professor mantém o controle em cada atividade.

## Instalação

1. Baixe o ZIP da versão.
2. Acesse **Administração do site → Plugins → Instalar plugins**.
3. Envie o arquivo ZIP e conclua a validação.
4. Acesse **Administração do site → Notificações** para concluir a instalação.

## Acessibilidade

- A cor nunca é a única forma de comunicar o estado.
- Os ícones são decorativos para tecnologias assistivas.
- O plugin herda tipografia e estrutura visual do tema Moodle.
- Utiliza classes semânticas do Bootstrap 5.

## Privacidade

O plugin não armazena dados pessoais. São armazenadas apenas configurações de apresentação vinculadas ao módulo da atividade.

[Voltar para README em inglês](../README.md)
