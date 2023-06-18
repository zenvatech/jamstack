<?php

namespace Database\Factories;

use App\Jobs\ProcessMedia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    public function configure()
    {
        return $this->afterCreating(function ($post) {
            $file = $this->faker->randomElement(Storage::disk('private')->files('posts'));

            $path = Storage::disk('private')->path($file);

            dispatch(new ProcessMedia($path, $post, 'thumbnail'));
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->words(rand(10, 20), true);
        $this->faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($this->faker));

        return [
            'title' => $title,
            'category_id' => null,
            'user_id' => null,
            'excerpt' => str($title)->limit(50)->toString(),
            'slug' => str($title)->slug()->toString(),
            'body' => $this->faker->markdown(),
            'created_at' => $this->faker->dateTimeBetween('-14 days', 'now')
        ];
    }
}
