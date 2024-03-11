<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Schedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('roles')->insert([
            ['name' => 'Staff'],
            ['name' => 'Tutor'],
            ['name' => 'Student'],
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => 1,
            'suspended' => false,
            'current_tutor' => null
        ]);
        \App\Models\User::factory(2)->create(['role_id' => 1, 'current_tutor' => null]);
        \App\Models\User::factory(5)->create(['role_id' => 2, 'current_tutor' => null]);
        \App\Models\User::factory(30)->create(['role_id' => 3]);
        \App\Models\User::factory(20)->create(['role_id' => 3, 'last_action_at' => now()->subDays(29)]);
        \App\Models\User::factory(3)->create(['role_id' => 3, 'current_tutor' => null]);

        // \app\Models\Blog::factory(30)->create();
        \App\Models\Blog::factory(50)->create();
        \App\Models\BlogComment::factory(40)->create();

        $emojis = ['❤️', '😆', '😲', '😢', '😠', '👍🏻'];
        foreach ($emojis as $emoji) {
            \App\Models\Emoji::factory()->create(['emoji' => $emoji]);
        }
        // \App\Models\Emoji::factory(10)->create();

        Schedule::factory(50)->create();
    }
}
