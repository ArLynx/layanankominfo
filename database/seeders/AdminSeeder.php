<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@kominfo.go.id',
            'password' => 'password',
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        Admin::create([
            'name' => 'Pimpinan',
            'email' => 'pimpinan@kominfo.go.id',
            'password' => 'password',
            'role' => 'pimpinan',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
