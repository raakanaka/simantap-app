<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'nim' => '2021001',
                'password' => Hash::make('password123'),
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@example.com',
                'study_program' => 'Teknik Informatika',
                'faculty' => 'Fakultas Teknik',
                'semester' => '8',
                'phone' => '081234567890',
                'address' => 'Jl. Contoh No. 123, Jakarta',
                'status' => 'active'
            ],
            [
                'nim' => '2021002',
                'password' => Hash::make('password123'),
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@example.com',
                'study_program' => 'Sistem Informasi',
                'faculty' => 'Fakultas Teknik',
                'semester' => '8',
                'phone' => '081234567891',
                'address' => 'Jl. Contoh No. 124, Jakarta',
                'status' => 'active'
            ],
            [
                'nim' => '2021003',
                'password' => Hash::make('password123'),
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'study_program' => 'Teknik Informatika',
                'faculty' => 'Fakultas Teknik',
                'semester' => '8',
                'phone' => '081234567892',
                'address' => 'Jl. Contoh No. 125, Jakarta',
                'status' => 'active'
            ]
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
