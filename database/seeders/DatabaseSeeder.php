<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'user_name' => 'username',
            'password' => bcrypt('password'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        Book::factory(10)->create();
    }
}
