<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['email' => 'admin@jamstack.test', 'password' => '!password', 'email_verified_at' => now()]);

        User::factory(70)->create();
    }
}
