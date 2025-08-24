<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'name' => 'Administrator',
            'email' => 'admin@simantap.com',
            'role' => 'super_admin',
            'phone' => '081234567890',
            'address' => 'Jl. Kampus No. 1',
            'status' => 'active',
        ]);

        Admin::create([
            'username' => 'verifikator',
            'password' => Hash::make('verifikator123'),
            'name' => 'Verifikator',
            'email' => 'verifikator@simantap.com',
            'role' => 'admin',
            'phone' => '081234567891',
            'address' => 'Jl. Kampus No. 2',
            'status' => 'active',
        ]);

        Admin::create([
            'username' => 'staff',
            'password' => Hash::make('staff123'),
            'name' => 'Staff Administrasi',
            'email' => 'staff@simantap.com',
            'role' => 'admin',
            'phone' => '081234567892',
            'address' => 'Jl. Kampus No. 3',
            'status' => 'active',
        ]);
    }
}
