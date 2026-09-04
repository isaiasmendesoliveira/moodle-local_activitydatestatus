# Activity Date Status
<p align="center">
  <img
    src="docs/images/activity-date-status-logo.png"
    alt="Activity Date Status"
    width="320">
</p>
**Activity Date Status** (`local_activitydatestatus`) es un complemento local para Moodle que convierte las fechas nativas de las actividades en información más clara, de fecha exacta y estado relativo, en la página del curso, sin modificar las reglas de acceso, los plazos ni las excepciones gestionadas por Moodle.

> **Versión pública:** 1.0.0  
> **Moodle:** 4.5–5.2  
> **Licencia:** GNU GPL v3 o posterior

## Funciones principales

- Control individual por actividad.
- Tres modos de visualización:
  - **Solo fechas**;
  - **Solo estado**;
  - **Fechas + estado** (recomendado).
- Dos apariencias de estado:
  - **Badge Bootstrap 5** (recomendado);
  - **Texto coloreado con icono**.
- Umbral de proximidad del plazo, configurable por actividad, con un valor predeterminado de **48 horas**.
- Umbral crítico opcional, con valor predeterminado de **12 horas**.
- Valores predeterminados del sitio que el profesorado puede modificar en cada actividad.
- Estados semánticos estándar de Bootstrap 5: `info`, `success`, `warning`, `danger` y `secondary`.
- Fechas específicas del usuario obtenidas directamente de la API nativa de Moodle.
- Comportamiento seguro: las fechas nativas de Moodle solo se ocultan después de que el complemento haya generado correctamente su contenido.
- Sin servicios externos ni dependencias adicionales.

## Cómo funciona

El complemento utiliza:

```php
\core\activity_dates::get_dates_for_module($cm, $userid);
```

Moodle sigue siendo la única fuente de las fechas. El complemento almacena únicamente preferencias de presentación por actividad y no duplica fechas de apertura, cierre, entrega ni reglas de acceso.

## Configuración por el profesorado

Al editar una actividad o recurso se puede configurar:

- **Mostrar indicador de estado y plazo**;
- **Modo de visualización**;
- **Apariencia del estado**;
- **Destacar proximidad del plazo**;
- **Destacar urgencia crítica**.

Los valores predeterminados del sitio se encuentran en:

**Administración del sitio → Plugins → Plugins locales → Activity Date Status**

Estos valores son solo predeterminados. El profesorado mantiene el control en cada actividad.

## Instalación

1. Descargue el archivo ZIP de la versión.
2. Vaya a **Administración del sitio → Plugins → Instalar plugins**.
3. Suba el archivo ZIP y complete la validación.
4. Visite **Administración del sitio → Notificaciones** para finalizar la instalación.

## Accesibilidad

- El color nunca es la única forma de comunicar el estado.
- Los iconos son decorativos en las tecnologías de asistencia.
- El complemento hereda la tipografía y la estructura visual del tema de Moodle.
- Utiliza clases semánticas de Bootstrap 5.

## Privacidad

El complemento no almacena datos personales. Solo almacena las configuraciones de presentación vinculadas al módulo de curso.

[Volver al README en inglés](../README.md)
