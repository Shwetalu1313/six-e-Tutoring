<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateTime = fake()->dateTimeBetween('-1 year','+1year');
        $date = $dateTime->format('Y-m-d');
        $time = $dateTime->format('H:i:s');


        $locationTypes = ['reality','virtual','none'];
        $locationType = fake()->randomElement($locationTypes);

        if($locationType === 'reality'){
            $location = fake()->address;
        }
        elseif ($locationType === 'virtual'){
            $location = fake()->url;
        }
        else{
            $location = NULL;
        }

        $expired = $dateTime < now();
        return [
            'title' => 'Meeting with '. fake()->name,
            'date' => $date,
            'time' => $time,
            'locationType' => $locationType,
            'location' => $location,
            'expired' => $expired,
            'status' => fake()->randomElement(['pending', 'confirmed']),
            'notify' => fake()->boolean(),
            'description' => fake()->sentence(20),
            'important' => fake()->boolean(),
            'user_id' => rand(1,16),
        ];
    }
}
