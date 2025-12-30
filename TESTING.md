# Plan de Pruebas Automatizadas con PestPHP para LaraFy CMS

Este documento detalla la estrategia de pruebas automatizadas implementada en LaraFy CMS utilizando PestPHP. El objetivo es garantizar la calidad del software, la estabilidad de las funcionalidades críticas y la correcta localización de la aplicación.

## 1. Alcance de las Pruebas

El plan de pruebas cubre los siguientes aspectos críticos de la aplicación:

*   **Funcionalidad del Backend (Feature Tests):**
    *   Verificación de rutas públicas y protegidas.
    *   Gestión de publicaciones (CRUD completo: Crear, Leer, Actualizar, Borrar).
    *   Soporte para imágenes destacadas (`featured_image`) y su persistencia.
    *   Control de Acceso Basado en Roles (RBAC): Asegurar que los autores solo puedan editar sus propios posts y que los administradores tengan control total.
    *   Validación exhaustiva de datos de entrada (incluyendo URLs de imagen y formatos de fecha).

*   **Interfaz de Usuario (UI Tests & Localization):**
    *   Verificación de la presencia de elementos clave de la interfaz mediante selectores `data-testid`.
    *   Validación del renderizado de imágenes destacadas y estilos tipográficos profesionales (`prose`).
    *   Verificación de notificaciones persistentes (Toasts) tras acciones del usuario.
    *   Validación de la localización al español en vistas públicas y privadas.
    *   Comprobación de flujos de navegación básicos.

*   **Pruebas de Unidad (Unit Tests):**
    *   Verificación de lógica aislada (actualmente mínima, enfocada en Feature Tests por la naturaleza monolítica del CMS).

## 2. Profundidad de las Pruebas

Las pruebas están diseñadas para ser **exhaustivas en las rutas críticas**. No buscamos una cobertura del 100% de líneas de código por el mero hecho de tenerla, sino una cobertura del 100% de los **casos de uso críticos**.

### Niveles de Profundidad:
*   **Happy Path:** Verificar que las funciones principales funcionan como se espera (ej. un usuario puede crear un post).
*   **Edge Cases:** Verificar límites y condiciones inusuales (ej. validación de fechas futuras, campos vacíos requeridos).
*   **Security & Authorization:** Verificar activamente que las acciones no autorizadas sean rechazada (ej. un autor intentando borrar el post de otro autor).

## 3. Estructura y Ejemplos de Pruebas

Las pruebas se encuentran en el directorio `tests/Feature` y utilizan la sintaxis elegante de PestPHP (aunque actualmente se mantienen clases PHPUnit estándar, Pest es totalmente compatible y corre sobre ellas).

### A. Gestión de Publicaciones (`PostManagementTest.php`)
Este archivo contiene las pruebas más críticas del negocio.

*   **Ejemplo: Admin puede crear post**
    ```php
    public function test_admin_can_create_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        // ... (setup)
        $response = $this->actingAs($admin)->post(route('posts.store'), [ ... ]);
        
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('posts', ['title' => 'Admin Post']);
    }
    ```
    *Por qué:* Garantiza que la funcionalidad principal del CMS funciona para el rol con mayores privilegios.

*   **Ejemplo: Autor NO puede editar posts ajenos**
    ```php
    public function test_author_cannot_update_others_post(): void
    {
        // ... (setup de dos autores)
        $response = $this->actingAs($author1)->put(route('posts.update', $postDeAuthor2), [ ... ]);
        
        $response->assertStatus(403); // Forbidden
    }
    ```
    *Por qué:* Crítico para la seguridad y la integridad de los datos en un entorno multi-usuario.

### B. Pruebas de Frontend (`FrontendTest.php`)
Verifica que la aplicación entregue el HTML correcto y que los elementos de UI necesarios para la interacción (y futuros tests E2E) estén presentes.

*   **Ejemplo: Verificar selectores QA**
    ```php
    $response->assertSee('data-testid="post-item-' . $post->id . '"', false);
    ```
    *Por qué:* Facilita la automatización futura con herramientas como Cypress o Playwright y asegura que no se rompa la estructura del DOM accidentalmente.

### C. Pruebas de Localización (`LocalizationTest.php`)
Específico para este proyecto, valida que la configuración regional (Español) se aplique correctamente.

*   **Ejemplo:**
    ```php
    $response->assertSee('Últimas Publicaciones'); // En lugar de "Latest Posts"
    ```
    *Por qué:* Asegura que los cambios de configuración y archivos de traducción se carguen correctamente y se muestren al usuario final.

## 4. Importancia de este Plan

1.  **Confianza en el Refactoring:** Permite realizar cambios grandes en el código (como cambiar el diseño o la lógica del controlador) sabiendo que si algo deja de funcionar, las pruebas avisarán inmediatamente.
2.  **Seguridad:** Valida automáticamente que las reglas de negocio (quién puede hacer qué) se cumplan siempre.
3.  **Documentación Viva:** Los tests sirven como documentación técnica de cómo *debe* comportarse el sistema.
4.  **Calidad Percibida:** Al validar la UI y la localización, aseguramos que la experiencia del usuario final sea consistente.

## 5. Ejecución

Para ejecutar todas las pruebas, utilice el comando estándar de Laravel/Pest desde la terminal:

```bash
php artisan test
```
o
```bash
./vendor/bin/pest
```
