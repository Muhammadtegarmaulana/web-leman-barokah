<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Leman',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Akun Customer (Rangga)
        User::create([
            'name' => 'Rangga Rafandi',
            'email' => 'rangga@gmail.com',
            'role' => 'customer',
            'password' => Hash::make('password'),
        ]);

        // 3. Akun Customer Tambahan (Untuk meramaikan data)
        User::create([
            'name' => 'Tegar Maulana',
            'email' => 'tegar@gmail.com',
            'role' => 'customer',
            'password' => Hash::make('password'),
        ]);
    }
}