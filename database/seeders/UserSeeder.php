<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('username', 'superadmin')->exists()) {
            User::create([
                'username' => 'superadmin',
                'password' => Hash::make('super321'),
                'role' => 'superadmin',
                'can_add' => true,
                'can_edit' => true,
                'can_delete' => true,
            ]);
        }
    }
}
