<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Meychel',
            'email' => 'Meychel@test.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
