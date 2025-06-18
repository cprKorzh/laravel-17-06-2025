<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'login' => 'admin',
            'fullname' => 'Администратор',
            'tel' => '+7(000)-000-00-00',
            'email' => 'admin@gruzovozoff.ru',
            'password' => Hash::make('gruzovik2024'),
            'role' => 'admin',
        ]);
    }
}
