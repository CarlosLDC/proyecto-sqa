<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_posts_with_qa_selectors(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('data-testid="main-layout"', false);
        $response->assertSee('data-testid="post-list"', false);
        $response->assertSee('data-testid="post-item-' . $post->id . '"', false);
        $response->assertSee('data-testid="read-more-' . $post->id . '"', false);
        $response->assertSee($post->title);
    }

    public function test_post_show_page_displays_content_with_qa_selectors(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('posts.show', $post));

        $response->assertStatus(200);
        $response->assertSee('data-testid="post-detail"', false);
        $response->assertSee('data-testid="post-title"', false);
        $response->assertSee('data-testid="post-content"', false);
        $response->assertSee($post->title);
    }

    public function test_auth_links_presence(): void
    {
        $response = $this->get('/');
        $response->assertSee('data-testid="nav-login"', false);
    }

    public function test_date_is_localized_in_spanish(): void
    {
        \Illuminate\Support\Carbon::setTestNow('2025-12-25 10:00:00');
        $post = Post::factory()->create([
            'published_at' => now(),
            'status' => 'published',
        ]);

        $response = $this->get('/');
        // 25 de diciembre, 2025
        $response->assertSee('25 de diciembre, 2025');
    }

    public function test_featured_image_is_rendered_on_homepage(): void
    {
        $imageUrl = 'https://example.com/unique-image.jpg';
        Post::factory()->create([
            'status' => 'published',
            'published_at' => now(),
            'featured_image' => $imageUrl,
        ]);

        $response = $this->get('/');
        $response->assertSee($imageUrl);
    }

    public function test_featured_image_is_rendered_on_show_page(): void
    {
        $imageUrl = 'https://example.com/hero-image.jpg';
        $post = Post::factory()->create([
            'status' => 'published',
            'published_at' => now(),
            'featured_image' => $imageUrl,
        ]);

        $response = $this->get(route('posts.show', $post));
        $response->assertSee($imageUrl);
    }

    public function test_toast_notification_is_visible_after_action(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'New Post',
            'category_id' => $category->id,
            'content' => 'Content',
            'status' => 'published',
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('dashboard'));
        $response = $this->get(route('dashboard'));

        // The toast component shows the success message from session
        $response->assertSee('Publicación creada con éxito.');
        $response->assertSee('data-testid="toast"', false);
    }
}
