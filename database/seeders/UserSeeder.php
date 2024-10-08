<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
                'status' => 'pending'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234'),
                'role' => 2,
                'status' => 'pending'
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@admin.com',
                'password' => bcrypt('1234'),
                'role' => 3,
                'status' => 'approved'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}