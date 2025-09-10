<?php

namespace App\Http\Controllers;

use TCPDF;
use App\Models\FormulirPendaftaran;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TCPDFController extends Controller
{
    public function generateFormulir($submissionId)
    {
        // Get the formulir
        $formulir = FormulirPendaftaran::where('submission_id', $submissionId)->first();
        
        if (!$formulir) {
            return redirect()->back()->with('error', 'Formulir not found');
        }

        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('SIMANTAP');
        $pdf->SetAuthor('SIMANTAP');
        $pdf->SetTitle('Formulir Pendaftaran Ujian');
        $pdf->SetSubject('Formulir Pendaftaran Ujian');
        
        // Set default header data
        $pdf->SetHeaderData('', 0, 'FORMULIR PENDAFTARAN UJIAN', 'Sistem Informasi Manajemen Tugas Akhir Program (SIMANTAP)');
        
        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', '', 12);
        
        // Add content
        $html = $this->generateHTML($formulir);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Close and output PDF document
        $filename = 'Formulir_Pendaftaran_' . $formulir->student_nim . '_' . now()->format('Y-m-d') . '.pdf';
        $pdf->Output($filename, 'D');
    }
    
    private function generateHTML($formulir)
    {
        $html = '
        <h2 style="text-align: center;">FORMULIR PENDAFTARAN UJIAN</h2>
        <p style="text-align: center;">Sistem Informasi Manajemen Tugas Akhir Program (SIMANTAP)</p>
        <p style="text-align: center;">Tanggal: ' . now()->format('d F Y') . '</p>
        
        <br>
        
        <h3>Data Mahasiswa:</h3>
        <table cellpadding="5" cellspacing="0" border="0">
            <tr>
                <td><strong>Nama Lengkap:</strong></td>
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
        <table border="1" cellpadding="8" cellspacing="0">
            <tr style="background-color: #f0f0f0;">
                <th>No</th>
                <th>Nama Berkas</th>
                <th>Keterangan</th>
                <th>Status Unggah</th>
            </tr>';
            
        if(isset($formulir->document_status) && is_array($formulir->document_status)) {
            $counter = 1;
            foreach($formulir->document_status as $index => $status) {
                $html .= '
                <tr>
                    <td>' . $counter . '</td>
                    <td>' . $index . '</td>
                    <td>Wajib</td>
                    <td>' . $status . '</td>
                </tr>';
                $counter++;
            }
        } else {
            $html .= '
            <tr>
                <td>1</td>
                <td>Formulir Pendaftaran Ujian Komprehensif</td>
                <td>Wajib</td>
                <td>Terunggah</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Transkrip Nilai Akademik</td>
                <td>Wajib</td>
                <td>Terunggah</td>
            </tr>';
        }
        
        $html .= '
        </table>
        
        <br><br>
        
        <h3>Tanda Tangan:</h3>
        <table cellpadding="10" cellspacing="0" border="0">
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
        </table>';
        
        return $html;
    }
}
