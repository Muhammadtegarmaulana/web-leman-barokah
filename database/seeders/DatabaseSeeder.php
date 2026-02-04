<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            DummyOrderSeeder::class,
        ]);
        
        // Buat Akun Admin
        // User::create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('password'), // passwordnya: password
        //     'role' => 'admin',
        // ]);

        // Buat Akun Dummy Customer (Untuk Test)
        // User::create([
        //     'name' => 'Customer Test',
        //     'email' => 'customer@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'customer',
        // ]);
    }
}