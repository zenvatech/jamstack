<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('uploads')->deleteDirectory('posts');
        Storage::disk('public')->deleteDirectory('posts');
        Category::inRandomOrder()->get()->each(fn ($category) => Post::factory(rand(15, 20))->create(['category_id' => $category->id, 'user_id' => 1]));
    }
}
