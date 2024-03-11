<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wordCount = [200, 500];
        return [
            'author_id' => rand(4, 8),
            'receiver_id' => rand(9, 16),
            'title' => fake()->catchPhrase(),
            'content' => fake()->realText($wordCount[rand(0, count($wordCount) - 1)], 2)
        ];
    }
}
