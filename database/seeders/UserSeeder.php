<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Notifications\SuperAdminAssignedNotification;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => config('mail.superadmin_email'),
                'password' => bcrypt('1234'),
                'role' => User::ROLE_SUPERADMIN, 
                'status' => 'approved',
                'email_verified_at' => Carbon::now()
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
        }
    }
}
