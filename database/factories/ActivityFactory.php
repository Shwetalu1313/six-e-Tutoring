<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{

    protected $model = Activity::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = Carbon::now()->subDays(rand(1, 90));

        return [
            'user_id' => rand(1,61),
            'type' => fake()->randomElement(['user', 'Blog', 'schedule', 'login']),
            'description' => fake()->sentence,
            'created_at' => $createdAt,
            'updated_at' => now(), // Optionally set updated_at to current time
        ];
    }
}