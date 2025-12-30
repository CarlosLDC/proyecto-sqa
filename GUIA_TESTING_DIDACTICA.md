# 🧪 Guía Didáctica: ¿Cómo probamos LaraFy CMS?

Si alguna vez te has preguntado cómo aseguramos que LaraFy CMS no se rompa cuando añadimos una nueva función, estás en el lugar correcto. Esta guía explica el **qué**, el **cómo** y el **por qué** de nuestras pruebas.

## 1. El Framework: PestPHP
En este proyecto utilizamos **PestPHP**. Imagina que PHPUnit (el estándar de siempre) fue al gimnasio y aprendió a ser más elegante y legible. Pest nos permite escribir pruebas que casi parecen oraciones en inglés/español.

## 2. La Regla de Oro: AAA (Arrange, Act, Assert)
Casi todos nuestros tests siguen este patrón simple:

1.  **Arrange (Preparar)**: Creamos los datos necesarios (usuarios, categorías, posts).
2.  **Act (Actuar)**: Realizamos la acción que queremos probar (una petición GET, un POST al formulario, etc.).
3.  **Assert (Asegurar)**: Verificamos que el resultado sea el esperado.

---

## 3. Ejemplo Práctico: Creación de un Post
Analicemos un test real del archivo `PostManagementTest.php`:

```php
public function test_admin_can_create_post(): void
{
    // --- PREPARAR (Arrange) ---
    // Creamos un Administrador y una Categoría en una base de datos temporal
    $admin = User::factory()->create(['role' => 'admin']);
    $category = Category::factory()->create();

    // --- ACTUAR (Act) ---
    // Actuamos "como" el administrador y enviamos datos al formulario
    $response = $this->actingAs($admin)->post(route('posts.store'), [
        'title' => 'Mi Nuevo Post',
        'category_id' => $category->id,
        'content' => 'Contenido Increíble',
        'status' => 'published',
    ]);

    // --- ASEGURAR (Assert) ---
    // 1. Verificamos que el sitio nos redirija al Panel de Control (éxito)
    $response->assertRedirect(route('dashboard'));
    
    // 2. ¡Lo más importante! Verificamos que el post REALMENTE exista en la base de datos
    $this->assertDatabaseHas('posts', [
        'title' => 'Mi Nuevo Post'
    ]);
}
```

### ¿Qué aprendemos aquí?
- **actingAs($user)**: Simula que un usuario ha iniciado sesión.
- **assertDatabaseHas**: Es como meterse a la base de datos y decir: "¿Está esto aquí?". Si no está, el test falla.

---

## 4. Tipos de Tests en LaraFy CMS

| Tipo | Propósito | Ejemplo en el proyecto |
| :--- | :--- | :--- |
| **Feature (Funcionalidad)** | Prueban una "pestaña" o "acción" completa del sitio. | `AuthTest.php`, `PostManagementTest.php` |
| **Localization (Localización)** | Aseguran que la traducción al español no se rompa. | `LocalizationTest.php` |
| **Validation (Validación)** | Verifican que los formularios no acepten basura. | `PostValidationTest.php` |

---

## 5. Pruebas de Interfaz (UI) con `data-testid`
A veces no solo queremos saber si el dato se guardó, sino si el usuario **ve** lo que debe ver. Usamos atributos especiales llamados `data-testid` en el HTML:

```php
// En FrontendTest.php
$response->assertSee('data-testid="toast"', false);
```

**¿Por qué?** Porque si cambiamos el diseño (CSS) o el ID de un elemento, el test de UI seguirá funcionando gracias a que el `data-testid` es exclusivo para pruebas.

---

## 6. ¿Cómo correr los tests?
Abre tu terminal y escribe:

```bash
php artisan test
```

Verás una lista de "Checks" verdes. Si ves una "X" roja, significa que algo cambió y rompió una regla de negocio. **¡Es mejor que el test falle antes de que el usuario lo note!**

---
*Recuerda: Un buen programador no es el que no tiene errores, sino el que escribe tests para capturarlos antes de que salgan a la luz.*
