<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Putri Sundari',
                'username' => 'putri_sundari',
                'email' => 'putri@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Mahasiswi psikologi yang suka menulis',
                'avatar' => null,
                'cover_photo' => null,
            ],
            [
                'name' => 'Andi Pratama',
                'username' => 'andi_pratama',
                'email' => 'andi@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Pengembang software freelance',
                'avatar' => null,
                'cover_photo' => null,
            ],
            [
                'name' => 'Dewi Lestari',
                'username' => 'dewi_lestari',
                'email' => 'dewi@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Konselor profesional',
                'avatar' => null,
                'cover_photo' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
