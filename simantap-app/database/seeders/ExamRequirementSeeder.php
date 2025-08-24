<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExamType;
use App\Models\ExamRequirement;

class ExamRequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get exam types
        $uk = ExamType::where('code', 'UK')->first();
        $spdaji = ExamType::where('code', 'SPDAJI')->first();
        $sps = ExamType::where('code', 'SPS')->first();
        $skj = ExamType::where('code', 'SKJ')->first();
        $sms = ExamType::where('code', 'SMS')->first();

        // Requirements untuk Ujian Komprehensif
        if ($uk) {
            $requirements = [
                [
                    'document_name' => 'Form Pengajuan Ujian Komprehensif',
                    'description' => 'Form pengajuan yang sudah diisi lengkap',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 1
                ],
                [
                    'document_name' => 'Kartu Hasil Studi (KHS)',
                    'description' => 'KHS terbaru yang menunjukkan IPK minimal 2.75',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 2
                ],
                [
                    'document_name' => 'Surat Rekomendasi Dosen Pembimbing',
                    'description' => 'Surat rekomendasi dari dosen pembimbing',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 3
                ]
            ];

            foreach ($requirements as $requirement) {
                $requirement['exam_type_id'] = $uk->id;
                $requirement['status'] = 'active';
                ExamRequirement::create($requirement);
            }
        }

        // Requirements untuk Seminar Proposal Draf Artikel Jurnal Ilmiah
        if ($spdaji) {
            $requirements = [
                [
                    'document_name' => 'Form Pengajuan Seminar Proposal',
                    'description' => 'Form pengajuan yang sudah diisi lengkap',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 1
                ],
                [
                    'document_name' => 'Draf Artikel Jurnal Ilmiah',
                    'description' => 'Draf artikel jurnal ilmiah yang akan diseminarkan',
                    'is_required' => true,
                    'file_types' => 'pdf,doc,docx',
                    'max_size' => 10240,
                    'order' => 2
                ],
                [
                    'document_name' => 'Surat Rekomendasi Dosen Pembimbing',
                    'description' => 'Surat rekomendasi dari dosen pembimbing',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 3
                ],
                [
                    'document_name' => 'Kartu Hasil Studi (KHS)',
                    'description' => 'KHS terbaru',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 4
                ]
            ];

            foreach ($requirements as $requirement) {
                $requirement['exam_type_id'] = $spdaji->id;
                $requirement['status'] = 'active';
                ExamRequirement::create($requirement);
            }
        }

        // Requirements untuk Seminar Proposal Skripsi
        if ($sps) {
            $requirements = [
                [
                    'document_name' => 'Form Pengajuan Seminar Proposal',
                    'description' => 'Form pengajuan yang sudah diisi lengkap',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 1
                ],
                [
                    'document_name' => 'Proposal Skripsi',
                    'description' => 'Proposal skripsi yang akan diseminarkan',
                    'is_required' => true,
                    'file_types' => 'pdf,doc,docx',
                    'max_size' => 10240,
                    'order' => 2
                ],
                [
                    'document_name' => 'Surat Rekomendasi Dosen Pembimbing',
                    'description' => 'Surat rekomendasi dari dosen pembimbing',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 3
                ],
                [
                    'document_name' => 'Kartu Hasil Studi (KHS)',
                    'description' => 'KHS terbaru',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 4
                ]
            ];

            foreach ($requirements as $requirement) {
                $requirement['exam_type_id'] = $sps->id;
                $requirement['status'] = 'active';
                ExamRequirement::create($requirement);
            }
        }

        // Requirements untuk Sidang Kolokium Jurnal
        if ($skj) {
            $requirements = [
                [
                    'document_name' => 'Form Pengajuan Sidang Kolokium',
                    'description' => 'Form pengajuan yang sudah diisi lengkap',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 1
                ],
                [
                    'document_name' => 'Artikel Jurnal Ilmiah',
                    'description' => 'Artikel jurnal ilmiah yang akan disidangkan',
                    'is_required' => true,
                    'file_types' => 'pdf,doc,docx',
                    'max_size' => 10240,
                    'order' => 2
                ],
                [
                    'document_name' => 'Surat Rekomendasi Dosen Pembimbing',
                    'description' => 'Surat rekomendasi dari dosen pembimbing',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 3
                ],
                [
                    'document_name' => 'Kartu Hasil Studi (KHS)',
                    'description' => 'KHS terbaru',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 4
                ]
            ];

            foreach ($requirements as $requirement) {
                $requirement['exam_type_id'] = $skj->id;
                $requirement['status'] = 'active';
                ExamRequirement::create($requirement);
            }
        }

        // Requirements untuk Sidang Munaqasyah Skripsi
        if ($sms) {
            $requirements = [
                [
                    'document_name' => 'Form Pengajuan Sidang Munaqasyah',
                    'description' => 'Form pengajuan yang sudah diisi lengkap',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 1
                ],
                [
                    'document_name' => 'Skripsi Lengkap',
                    'description' => 'Skripsi lengkap yang akan disidangkan',
                    'is_required' => true,
                    'file_types' => 'pdf,doc,docx',
                    'max_size' => 20480,
                    'order' => 2
                ],
                [
                    'document_name' => 'Surat Rekomendasi Dosen Pembimbing',
                    'description' => 'Surat rekomendasi dari dosen pembimbing',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 3
                ],
                [
                    'document_name' => 'Kartu Hasil Studi (KHS)',
                    'description' => 'KHS terbaru',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 4
                ],
                [
                    'document_name' => 'Sertifikat TOEFL/IELTS',
                    'description' => 'Sertifikat TOEFL minimal 450 atau IELTS minimal 5.0',
                    'is_required' => true,
                    'file_types' => 'pdf',
                    'max_size' => 2048,
                    'order' => 5
                ]
            ];

            foreach ($requirements as $requirement) {
                $requirement['exam_type_id'] = $sms->id;
                $requirement['status'] = 'active';
                ExamRequirement::create($requirement);
            }
        }
    }
}
