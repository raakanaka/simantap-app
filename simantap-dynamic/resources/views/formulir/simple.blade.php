<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran Ujian</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 12px; margin: 20px; line-height: 1.4;">
    <h1 style="text-align: center;">FORMULIR PENDAFTARAN UJIAN</h1>
    <p style="text-align: center;">Sistem Informasi Manajemen Tugas Akhir Program (SIMANTAP)</p>
    <p style="text-align: center;">Tanggal: {{ $current_date ?? '09 September 2025' }}</p>
    
    <br>
    
    <h3>Data Mahasiswa:</h3>
    <p><strong>Nama Lengkap:</strong> {{ $formulir->student_name ?? 'Test Student' }}</p>
    <p><strong>NIM:</strong> {{ $formulir->student_nim ?? '2021001' }}</p>
    <p><strong>Tempat/Tgl. Lahir:</strong> {{ $formulir->place_of_birth ?? 'Jakarta' }}, {{ $formulir->date_of_birth ?? '01 Januari 2000' }}</p>
    <p><strong>Semester/Jurusan:</strong> {{ $formulir->semester ?? '8' }} / {{ $formulir->study_program ?? 'Teknik Informatika' }}</p>
    <p><strong>No. HP:</strong> {{ $formulir->phone_number ?? '08123456789' }}</p>
    <p><strong>Judul Skripsi:</strong> {{ $formulir->thesis_title ?? 'Test Thesis' }}</p>
    <p><strong>Pembimbing:</strong> {{ $formulir->supervisor ?? 'Test Supervisor' }}</p>
    
    <br>
    
    <h3>Dokumen yang Diperlukan:</h3>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr style="background-color: #f0f0f0;">
            <th style="padding: 8px;">No</th>
            <th style="padding: 8px;">Nama Berkas</th>
            <th style="padding: 8px;">Keterangan</th>
            <th style="padding: 8px;">Status Unggah</th>
        </tr>
        @if(isset($formulir->document_status) && is_array($formulir->document_status))
            @foreach($formulir->document_status as $index => $status)
            <tr>
                <td style="padding: 8px; text-align: center;">{{ $loop->iteration }}</td>
                <td style="padding: 8px;">{{ $index }}</td>
                <td style="padding: 8px; text-align: center;">Wajib</td>
                <td style="padding: 8px; text-align: center;">{{ $status }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td style="padding: 8px; text-align: center;">1</td>
                <td style="padding: 8px;">Formulir Pendaftaran Ujian Komprehensif</td>
                <td style="padding: 8px; text-align: center;">Wajib</td>
                <td style="padding: 8px; text-align: center;">Terunggah</td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: center;">2</td>
                <td style="padding: 8px;">Transkrip Nilai Akademik</td>
                <td style="padding: 8px; text-align: center;">Wajib</td>
                <td style="padding: 8px; text-align: center;">Terunggah</td>
            </tr>
        @endif
    </table>
    
    <br><br>
    
    <h3>Tanda Tangan:</h3>
    <div style="width: 45%; display: inline-block; margin-right: 5%;">
        <p style="border-bottom: 1px solid black; height: 40px; margin-bottom: 10px;"></p>
        <p><strong>{{ $secretary_name ?? 'M.Fachran Haikal, STP., MM' }}</strong></p>
        <p>NIP. {{ $secretary_nip ?? '198002272009121004' }}</p>
        <p>Sekretaris Jurusan MD</p>
    </div>
    
    <div style="width: 45%; display: inline-block;">
        <p style="border-bottom: 1px solid black; height: 40px; margin-bottom: 10px;"></p>
        <p><strong>{{ $formulir->student_name ?? 'Test Student' }}</strong></p>
        <p>NIM. {{ $formulir->student_nim ?? '2021001' }}</p>
        <p>Mahasiswa</p>
    </div>
</body>
</html>
