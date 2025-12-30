<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@larafy.com',
            'role' => 'admin',
        ]);

        // Create 5 authors
        $authors = User::factory(5)->create(['role' => 'author']);

        // Create 10 categories
        $categories = Category::factory(10)->create();

        // Create 50 posts distributed among authors and categories
        Post::factory(50)->make()->each(function ($post) use ($authors, $categories) {
            $post->user_id = $authors->random()->id;
            $post->category_id = $categories->random()->id;
            $post->save();
        });
    }
}
