# Alcance y Profundidad del Plan de Pruebas

Este documento explica la filosofía y el rigor técnico detrás de la suite de pruebas automatizadas de LaraFy CMS.

## 1. Alcance de las Pruebas (Scope)
Nuestro plan no se limita a verificar que la aplicación "funcione", sino que garantiza la integridad en múltiples capas:

- **Seguridad y Autorización**: Validamos activamente que un `Author` no pueda manipular contenido de terceros y que solo el `Admin` tenga privilegios globales.
- **Integridad de Datos**: Cada validación de formulario (títulos, campos obligatorios, formatos de fecha, URLs de imagen) está respaldada por un test.
- **Experiencia de Usuario (UI)**: Utilizamos selectores de QA (`data-testid`) para asegurar que los elementos críticos estén presentes y sean accesibles para futuras automatizaciones E2E.
- **Consistencia Visual**: Verificamos el renderizado de imágenes y componentes dinámicos como las notificaciones Toast.
- **Internacionalización**: Cada cadena de texto crítica en español es verificada para asegurar que la localización no se rompa tras cambios en el código.

## 2. Profundidad de las Pruebas (Depth)
Adoptamos un enfoque de **cobertura por criticidad**:

- **Happy Paths**: Pruebas de los flujos principales de usuario (crear, editar, borrar).
- **Edge Cases**: Manejo de errores y entradas inesperadas (formatos inválidos, intentos de acceso prohibido).
- **Regresión Automática**: Con más de 35 tests y 80 aserciones, cualquier cambio en la arquitectura o el diseño que rompa la funcionalidad es detectado en segundos.
- **Fidelidad del Backend**: Pruebas de persistencia real en base de datos (`assertDatabaseHas`) para garantizar que lo que el usuario ve es lo que realmente se guarda.

## 3. Herramientas y Metodología
- **PestPHP**: Para una sintaxis de pruebas moderna y legible.
- **Ambiente Controlado**: Uso de `RefreshDatabase` para garantizar que cada prueba se ejecute en un estado limpio.
- **Documentación Viva**: El archivo `TESTING.md` sirve como guía técnica detallada para desarrolladores.

---
*La calidad de LaraFy CMS no es un accidente, es el resultado de una suite de pruebas obsesiva y bien planificada.*
