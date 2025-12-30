# LaraFy CMS

Bienvenido a **LaraFy CMS**, una plataforma de blogging monolítica diseñada para ofrecer una experiencia profesional y premium.

## Resumen del Proyecto
LaraFy CMS está construido sobre Laravel 12 y se enfoca en la elegancia visual, la seguridad robusta y la facilidad de uso para autores y administradores.

## Documentación Detallada

- [**Acerca de LaraFy CMS**](LaraFy_CMS.md): Conoce los objetivos del proyecto, sus características y el stack tecnológico.
- [**Plan de Pruebas**](Plan_de_Pruebas.md): Detalles sobre el alcance, la profundidad y la estrategia de aseguramiento de calidad (QA).
- [**Guía Técnica de Testing**](TESTING.md): Documentación detallada para desarrolladores sobre cómo ejecutar y ampliar la suite de pruebas.

## Ejecución Rápida

1. Instalar dependencias: `composer install && npm install`
2. Configurar entorno: `cp .env.example .env` (y configurar DB)
3. Correr migraciones y seeds: `php artisan migrate --seed`
4. Ejecutar tests: `php artisan test`
5. Levantar servidor: `php artisan serve` y `npm run dev`

---
Desarrollado con pasión utilizando Laravel, Tailwind CSS y Pest.

# proyecto-sqa
