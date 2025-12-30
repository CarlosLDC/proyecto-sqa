<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_localized_in_spanish(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Últimas Publicaciones');
        $response->assertSee('LaraFy CMS');
    }

    public function test_login_page_is_localized_in_spanish(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
        $response->assertSee('Correo Electrónico');
        $response->assertSee('Contraseña');
    }

    public function test_dashboard_is_localized_in_spanish(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Panel de Control');
        $response->assertSee('Bienvenido de nuevo');
        $response->assertSee('Crear Nueva Publicación');
    }
}
