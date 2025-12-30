<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('posts.store'), [
            'title' => 'Admin Post',
            'category_id' => $category->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'published',
            'user_id' => $admin->id, // Admin must provide user_id
            'featured_image' => 'https://example.com/image.jpg',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Admin Post',
            'featured_image' => 'https://example.com/image.jpg'
        ]);
    }

    public function test_author_can_save_featured_image(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();
        $imageUrl = 'https://example.com/author-image.jpg';

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Author Post With Image',
            'category_id' => $category->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $imageUrl,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Author Post With Image',
            'featured_image' => $imageUrl
        ]);
    }

    public function test_post_can_be_updated_with_featured_image(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author->id]);
        $newImageUrl = 'https://example.com/updated-image.jpg';

        $response = $this->actingAs($author)->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'category_id' => $post->category_id,
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'status' => 'published',
            'featured_image' => $newImageUrl,
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'featured_image' => $newImageUrl
        ]);
    }

    public function test_author_can_create_post(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Author Post',
            'category_id' => $category->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('posts', ['title' => 'Author Post', 'user_id' => $author->id]);
    }

    public function test_slug_is_generated_automatically(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'My Unique Title',
            'category_id' => $category->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('posts', ['slug' => 'my-unique-title-' . time()]); // Approximate check due to time()
    }

    public function test_author_can_update_own_post(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($author)->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'category_id' => $post->category_id,
            'excerpt' => 'New Excerpt',
            'content' => 'New Content',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Updated Title']);
    }

    public function test_author_cannot_update_others_post(): void
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author2->id]);

        $response = $this->actingAs($author1)->put(route('posts.update', $post), [
            'title' => 'Hacked Title',
            'category_id' => $post->category_id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'published',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' => 'Hacked Title']);
    }

    public function test_admin_can_update_any_post(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($admin)->put(route('posts.update', $post), [
            'title' => 'Admin Edited',
            'category_id' => $post->category_id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'published',
            'user_id' => $author->id, // Admin must provide user_id
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Admin Edited']);
    }

    public function test_author_can_delete_own_post(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($author)->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_author_cannot_delete_others_post(): void
    {
        $author1 = User::factory()->create(['role' => 'author']);
        $author2 = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author2->id]);

        $response = $this->actingAs($author1)->delete(route('posts.destroy', $post));

        $response->assertStatus(403);
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    public function test_create_page_loads(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $response = $this->actingAs($author)->get(route('posts.create'));
        $response->assertOk();
        $response->assertSee('data-testid="create-post-form"', false);
    }

    public function test_edit_page_loads_for_own_post(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($author)->get(route('posts.edit', $post));
        $response->assertOk();
        $response->assertSee('data-testid="edit-post-form"', false);
    }

    public function test_edit_page_shows_published_at_value(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $date = now()->subDays(5);
        $post = Post::factory()->create([
            'user_id' => $admin->id,
            'status' => 'published',
            'published_at' => $date,
        ]);

        $response = $this->actingAs($admin)->get(route('posts.edit', $post));

        // Check if the input has the formatted date value
        // value="2025-12-24T18:21" (example)
        $formattedDate = $date->format('Y-m-d\TH:i');
        $response->assertSee('value="' . $formattedDate . '"', false);
    }
}
