<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamType;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $examTypes = [
            [
                'name' => 'Ujian Komprehensif',
                'code' => 'UK',
                'description' => 'Ujian komprehensif untuk menguji pemahaman mahasiswa terhadap mata kuliah yang telah dipelajari',
                'status' => 'active'
            ],
            [
                'name' => 'Seminar Proposal Draf Artikel Jurnal Ilmiah',
                'code' => 'SPDAJI',
                'description' => 'Seminar proposal untuk draf artikel jurnal ilmiah',
                'status' => 'active'
            ],
            [
                'name' => 'Seminar Proposal Skripsi',
                'code' => 'SPS',
                'description' => 'Seminar proposal skripsi',
                'status' => 'active'
            ],
            [
                'name' => 'Sidang Kolokium Jurnal',
                'code' => 'SKJ',
                'description' => 'Sidang kolokium untuk jurnal',
                'status' => 'active'
            ],
            [
                'name' => 'Sidang Munaqasyah Skripsi',
                'code' => 'SMS',
                'description' => 'Sidang munaqasyah untuk skripsi',
                'status' => 'active'
            ]
        ];

        foreach ($examTypes as $examType) {
            ExamType::create($examType);
        }
    }
}
