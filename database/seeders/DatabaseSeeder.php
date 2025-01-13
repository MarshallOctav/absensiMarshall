<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@co.id',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Guru',
            'email' => 'guru@co.id',
            'password' => bcrypt('12345678'),
            'role' => 'guru',
        ]);
    }
}
