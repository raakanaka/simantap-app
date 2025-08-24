<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create([
            'username' => 'dosen1',
            'password' => Hash::make('dosen123'),
            'name' => 'Dr. Ahmad Supriyadi, M.Kom',
            'email' => 'ahmad.supriyadi@university.ac.id',
            'nip' => '198501012010011001',
            'study_program' => 'Teknik Informatika',
            'faculty' => 'Fakultas Teknik',
            'position' => 'Ketua Program Studi',
            'status' => 'active',
            'phone' => '081234567890',
            'address' => 'Jl. Kampus No. 1, Gedung FTI Lt. 2',
        ]);

        Lecturer::create([
            'username' => 'dosen2',
            'password' => Hash::make('dosen123'),
            'name' => 'Dr. Siti Nurhaliza, M.T',
            'email' => 'siti.nurhaliza@university.ac.id',
            'nip' => '198602152010012002',
            'study_program' => 'Sistem Informasi',
            'faculty' => 'Fakultas Teknik',
            'position' => 'Dosen',
            'status' => 'active',
            'phone' => '081234567891',
            'address' => 'Jl. Kampus No. 1, Gedung FTI Lt. 3',
        ]);

        Lecturer::create([
            'username' => 'dosen3',
            'password' => Hash::make('dosen123'),
            'name' => 'Prof. Dr. Bambang Sutrisno, M.Sc',
            'email' => 'bambang.sutrisno@university.ac.id',
            'nip' => '197003101990031001',
            'study_program' => 'Teknik Informatika',
            'faculty' => 'Fakultas Teknik',
            'position' => 'Dekan',
            'status' => 'active',
            'phone' => '081234567892',
            'address' => 'Jl. Kampus No. 1, Gedung FTI Lt. 1',
        ]);

        Lecturer::create([
            'username' => 'dosen4',
            'password' => Hash::make('dosen123'),
            'name' => 'Drs. Muhammad Rizki, M.Kom',
            'email' => 'muhammad.rizki@university.ac.id',
            'nip' => '198803202010011003',
            'study_program' => 'Sistem Informasi',
            'faculty' => 'Fakultas Teknik',
            'position' => 'Dosen',
            'status' => 'active',
            'phone' => '081234567893',
            'address' => 'Jl. Kampus No. 1, Gedung FTI Lt. 2',
        ]);

        Lecturer::create([
            'username' => 'dosen5',
            'password' => Hash::make('dosen123'),
            'name' => 'Ir. Diana Putri, M.T',
            'email' => 'diana.putri@university.ac.id',
            'nip' => '198904152010012004',
            'study_program' => 'Teknik Informatika',
            'faculty' => 'Fakultas Teknik',
            'position' => 'Dosen',
            'status' => 'active',
            'phone' => '081234567894',
            'address' => 'Jl. Kampus No. 1, Gedung FTI Lt. 3',
        ]);
    }
}
