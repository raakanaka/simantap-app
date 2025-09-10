<?php

namespace App\Http\Controllers;

use mPDF;
use App\Models\FormulirPendaftaran;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MPDFController extends Controller
{
    public function generateFormulir($submissionId)
    {
        // Get the formulir
        $formulir = FormulirPendaftaran::where('submission_id', $submissionId)->first();
        
        if (!$formulir) {
            return redirect()->back()->with('error', 'Formulir not found');
        }

        // Create new PDF document
        $mpdf = new mPDF('c', 'A4', '', '', 10, 10, 10, 10, 6, 3);
        
        // Set document information
        $mpdf->SetTitle('Formulir Pendaftaran Ujian');
        $mpdf->SetAuthor('SIMANTAP');
        $mpdf->SetCreator('SIMANTAP');
        $mpdf->SetSubject('Formulir Pendaftaran Ujian');
        
        // Generate HTML content
        $html = $this->generateHTMLContent($formulir);
        
        // Write HTML content
        $mpdf->WriteHTML($html);
        
        // Output PDF
        $filename = 'Formulir_Pendaftaran_' . $formulir->student_nim . '_' . now()->format('Y-m-d') . '.pdf';
        $mpdf->Output($filename, 'D');
    }
    
    private function generateHTMLContent($formulir)
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Formulir Pendaftaran Ujian</title>
        </head>
        <body style="font-family: Arial, sans-serif; font-size: 12px; margin: 20px; line-height: 1.4;">
            <h1 style="text-align: center;">FORMULIR PENDAFTARAN UJIAN</h1>
            <p style="text-align: center;">Sistem Informasi Manajemen Tugas Akhir Program (SIMANTAP)</p>
            <p style="text-align: center;">Tanggal: ' . now()->format('d F Y') . '</p>
            
            <br>
            
            <h3>Data Mahasiswa:</h3>
            <table cellpadding="5" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td style="width: 150px;"><strong>Nama Lengkap:</strong></td>
                    <td>' . ($formulir->student_name ?? 'Test Student') . '</td>
                </tr>
                <tr>
                    <td><strong>NIM:</strong></td>
                    <td>' . ($formulir->student_nim ?? '2021001') . '</td>
                </tr>
                <tr>
                    <td><strong>Tempat/Tgl. Lahir:</strong></td>
                    <td>' . ($formulir->place_of_birth ?? 'Jakarta') . ', ' . ($formulir->date_of_birth ?? '01 Januari 2000') . '</td>
                </tr>
                <tr>
                    <td><strong>Semester/Jurusan:</strong></td>
                    <td>' . ($formulir->semester ?? '8') . ' / ' . ($formulir->study_program ?? 'Teknik Informatika') . '</td>
                </tr>
                <tr>
                    <td><strong>No. HP:</strong></td>
                    <td>' . ($formulir->phone_number ?? '08123456789') . '</td>
                </tr>
                <tr>
                    <td><strong>Judul Skripsi:</strong></td>
                    <td>' . ($formulir->thesis_title ?? 'Test Thesis') . '</td>
                </tr>
                <tr>
                    <td><strong>Pembimbing:</strong></td>
                    <td>' . ($formulir->supervisor ?? 'Test Supervisor') . '</td>
                </tr>
            </table>
            
            <br>
            
            <h3>Dokumen yang Diperlukan:</h3>
            <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <tr style="background-color: #f0f0f0;">
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Nama Berkas</th>
                    <th style="width: 25%;">Keterangan</th>
                    <th style="width: 20%;">Status Unggah</th>
                </tr>';
                
        if(isset($formulir->document_status) && is_array($formulir->document_status)) {
            $counter = 1;
            foreach($formulir->document_status as $index => $status) {
                $html .= '
                <tr>
                    <td style="text-align: center;">' . $counter . '</td>
                    <td>' . $index . '</td>
                    <td style="text-align: center;">Wajib</td>
                    <td style="text-align: center;">' . $status . '</td>
                </tr>';
                $counter++;
            }
        } else {
            $html .= '
            <tr>
                <td style="text-align: center;">1</td>
                <td>Formulir Pendaftaran Ujian Komprehensif</td>
                <td style="text-align: center;">Wajib</td>
                <td style="text-align: center;">Terunggah</td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td>Transkrip Nilai Akademik</td>
                <td style="text-align: center;">Wajib</td>
                <td style="text-align: center;">Terunggah</td>
            </tr>';
        }
        
        $html .= '
            </table>
            
            <br><br>
            
            <h3>Tanda Tangan:</h3>
            <table cellpadding="10" cellspacing="0" border="0" style="width: 100%;">
                <tr>
                    <td style="width: 45%;">
                        <p style="border-bottom: 1px solid black; height: 40px; margin-bottom: 10px;"></p>
                        <p><strong>M.Fachran Haikal, STP., MM</strong></p>
                        <p>NIP. 198002272009121004</p>
                        <p>Sekretaris Jurusan MD</p>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%;">
                        <p style="border-bottom: 1px solid black; height: 40px; margin-bottom: 10px;"></p>
                        <p><strong>' . ($formulir->student_name ?? 'Test Student') . '</strong></p>
                        <p>NIM. ' . ($formulir->student_nim ?? '2021001') . '</p>
                        <p>Mahasiswa</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
        
        return $html;
    }
}
