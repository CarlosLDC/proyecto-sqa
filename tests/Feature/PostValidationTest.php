<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_title_is_required(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'category_id' => $category->id,
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_category_is_required(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('category_id');
    }

    public function test_status_must_be_valid(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Title',
            'category_id' => $category->id,
            'content' => 'Content',
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_published_at_must_be_valid_date(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Title',
            'category_id' => $category->id,
            'content' => 'Content',
            'status' => 'published',
            'published_at' => 'not-a-date',
        ]);

        $response->assertSessionHasErrors('published_at');
    }

    public function test_featured_image_must_be_a_valid_url(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $category = Category::factory()->create();

        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'Title',
            'category_id' => $category->id,
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('featured_image');
    }
}
