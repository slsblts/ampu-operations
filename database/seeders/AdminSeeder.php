<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ampustudio.id'],
            [
                'name' => 'Admin Tania S.',
                'password' => Hash::make('ampu12345'),
            ]
        );
    }
}