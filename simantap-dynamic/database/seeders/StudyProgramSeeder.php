<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyProgram;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = [
            // Teknologi Informasi
            [
                'code' => 'TI',
                'name' => 'Teknik Informatika',
                'faculty' => 'Fakultas Teknik',
                'description' => 'Program studi yang mempelajari teknologi informasi dan komputer',
                'is_active' => true
            ],
            [
                'code' => 'SI',
                'name' => 'Sistem Informasi',
                'faculty' => 'Fakultas Teknik',
                'description' => 'Program studi yang mempelajari sistem informasi bisnis',
                'is_active' => true
            ],
            [
                'code' => 'MI',
                'name' => 'Manajemen Informatika',
                'faculty' => 'Fakultas Teknik',
                'description' => 'Program studi yang mempelajari manajemen dan teknologi informasi',
                'is_active' => true
            ],
            [
                'code' => 'KP',
                'name' => 'Komputerisasi Perkantoran',
                'faculty' => 'Fakultas Teknik',
                'description' => 'Program studi yang mempelajari komputerisasi perkantoran',
                'is_active' => true
            ],
            
            // Ekonomi dan Bisnis
            [
                'code' => 'AK',
                'name' => 'Akuntansi',
                'faculty' => 'Fakultas Ekonomi',
                'description' => 'Program studi yang mempelajari akuntansi dan keuangan',
                'is_active' => true
            ],
            [
                'code' => 'MN',
                'name' => 'Manajemen',
                'faculty' => 'Fakultas Ekonomi',
                'description' => 'Program studi yang mempelajari manajemen bisnis',
                'is_active' => true
            ],
            [
                'code' => 'EP',
                'name' => 'Ekonomi Pembangunan',
                'faculty' => 'Fakultas Ekonomi',
                'description' => 'Program studi yang mempelajari ekonomi pembangunan',
                'is_active' => true
            ],
            
            // Agama dan Dakwah
            [
                'code' => 'MD',
                'name' => 'Manajemen Dakwah',
                'faculty' => 'Fakultas Dakwah',
                'description' => 'Program studi yang mempelajari manajemen dakwah dan komunikasi Islam',
                'is_active' => true
            ],
            [
                'code' => 'KI',
                'name' => 'Komunikasi Islam',
                'faculty' => 'Fakultas Dakwah',
                'description' => 'Program studi yang mempelajari komunikasi dalam perspektif Islam',
                'is_active' => true
            ],
            [
                'code' => 'PD',
                'name' => 'Pengembangan Masyarakat Islam',
                'faculty' => 'Fakultas Dakwah',
                'description' => 'Program studi yang mempelajari pengembangan masyarakat Islam',
                'is_active' => true
            ],
            [
                'code' => 'BA',
                'name' => 'Bimbingan dan Konseling Islam',
                'faculty' => 'Fakultas Dakwah',
                'description' => 'Program studi yang mempelajari bimbingan dan konseling Islam',
                'is_active' => true
            ],
            
            // Pendidikan
            [
                'code' => 'PAI',
                'name' => 'Pendidikan Agama Islam',
                'faculty' => 'Fakultas Tarbiyah',
                'description' => 'Program studi yang mempelajari pendidikan agama Islam',
                'is_active' => true
            ],
            [
                'code' => 'PGMI',
                'name' => 'Pendidikan Guru Madrasah Ibtidaiyah',
                'faculty' => 'Fakultas Tarbiyah',
                'description' => 'Program studi yang mempelajari pendidikan guru madrasah ibtidaiyah',
                'is_active' => true
            ],
            [
                'code' => 'PBA',
                'name' => 'Pendidikan Bahasa Arab',
                'faculty' => 'Fakultas Tarbiyah',
                'description' => 'Program studi yang mempelajari pendidikan bahasa Arab',
                'is_active' => true
            ],
            
            // Syariah dan Hukum
            [
                'code' => 'AS',
                'name' => 'Ahwal Syakhsiyah',
                'faculty' => 'Fakultas Syariah',
                'description' => 'Program studi yang mempelajari hukum keluarga Islam',
                'is_active' => true
            ],
            [
                'code' => 'ES',
                'name' => 'Ekonomi Syariah',
                'faculty' => 'Fakultas Syariah',
                'description' => 'Program studi yang mempelajari ekonomi syariah',
                'is_active' => true
            ],
            [
                'code' => 'MS',
                'name' => 'Manajemen Syariah',
                'faculty' => 'Fakultas Syariah',
                'description' => 'Program studi yang mempelajari manajemen syariah',
                'is_active' => true
            ],
            
            // Ushuluddin
            [
                'code' => 'Aq',
                'name' => 'Aqidah dan Filsafat Islam',
                'faculty' => 'Fakultas Ushuluddin',
                'description' => 'Program studi yang mempelajari aqidah dan filsafat Islam',
                'is_active' => true
            ],
            [
                'code' => 'TH',
                'name' => 'Tafsir Hadis',
                'faculty' => 'Fakultas Ushuluddin',
                'description' => 'Program studi yang mempelajari tafsir dan hadis',
                'is_active' => true
            ],
            [
                'code' => 'PS',
                'name' => 'Perbandingan Agama',
                'faculty' => 'Fakultas Ushuluddin',
                'description' => 'Program studi yang mempelajari perbandingan agama',
                'is_active' => true
            ]
        ];

        foreach ($studyPrograms as $program) {
            StudyProgram::create($program);
        }
    }
}