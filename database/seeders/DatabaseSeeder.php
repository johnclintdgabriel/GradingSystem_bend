<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'clint',
            'role' => 'admin',
            'email' => 'johnclintgabriel26@gmail.com',
            'password' => Hash::make('admin123'),
        ]);
        DB::table('users')->insert([
            'username' => 'q',
            'role' => 'teacher',
            'email' => 'q@q',   
            'password' => Hash::make('admin123'),
        ]);
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'a@q',
            'role' => 'admin',
            'password' => Hash::make('qweqwe')
        ]);
    }
}


