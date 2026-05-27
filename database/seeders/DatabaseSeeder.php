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
        DB::table('users')->insert([
            'username' => 'adminq',
            'email' => 'a@qq',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'adminw',
            'email' => 'a@qw',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'admine',
            'email' => 'a@qe',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'adminr',
            'email' => 'a@qr',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'admint',
            'email' => 'a@qt',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'adminy',
            'email' => 'a@qy',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'adminu',
            'email' => 'a@qu',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'admini',
            'email' => 'a@qi',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'admino',
            'email' => 'a@qo',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);
        DB::table('users')->insert([
            'username' => 'adminp',
            'email' => 'a@qp',
            'role' => 'teacher',
            'password' => Hash::make('qweqwe')
        ]);

        
        DB::table('subjects')->insert([
            'name' => 'ENGLISH',
        ]);
        DB::table('subjects')->insert([
            'name' => 'MATHEMATICS',
        ]);
        DB::table('subjects')->insert([
            'name' => 'SCIENCE',
        ]);
        DB::table('subjects')->insert([
            'name' => 'ARALING PANLIPUNAN',
        ]);
        DB::table('subjects')->insert([
            'name' => 'FILIPINO',
        ]);
        DB::table('subjects')->insert([
            'name' => 'ESP',
        ]);
        DB::table('subjects')->insert([
            'name' => 'TLE',
        ]);
        DB::table('subjects')->insert([
            'name' => 'MAPEH',
        ]);
    }
}


