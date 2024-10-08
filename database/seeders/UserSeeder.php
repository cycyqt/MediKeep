<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Staff',
                'email' => 'staff@staff.com',
                'password' => bcrypt('1234'),
                'role' => 1,
                'status' => 'pending',
                'email_verified_at' => null
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234'),
                'role' => 2,
                'status' => 'pending',
                'email_verified_at' => null
            ],
            [
                'name' => 'Super Admin',
                'email' => 'ainzsama0006@gmail.com',
                'password' => bcrypt('1234'),
                'role' => 3,
                'status' => 'approved',
                'email_verified_at' => Carbon::now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}