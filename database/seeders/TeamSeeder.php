<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::factory()->create(['user_id' => User::query()->first()->id]);
        User::inRandomOrder()->limit(rand(5, 7))->get()->each(fn ($user) => Team::factory()->create(['user_id' => $user->id]));
    }
}
