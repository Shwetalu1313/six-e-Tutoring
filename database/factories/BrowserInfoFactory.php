<?php

namespace Database\Factories;

use App\Models\BrowserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrowserInfo>
 */
class BrowserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = BrowserInfo::class;
    public function definition(): array
    {
        return [
            'browser' => fake()->userAgent,
            'ip' => fake()->ipv4,
            'user_id' => rand(1,61),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }
}
