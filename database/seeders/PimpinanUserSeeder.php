<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PimpinanUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Pimpinan KOMINFO',
            'email' => 'pimpinan@kominfo.go.id',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
