<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Formulir Pendaftaran Ujian</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .title {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .subtitle {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .form-container {
            width: 100%;
            border: 2px solid #000;
            padding: 20px;
        }
        
        .student-info {
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 8px;
        }
        
        .info-label {
            width: 200px;
            font-weight: bold;
        }
        
        .info-value {
            flex: 1;
            border-bottom: 1px solid #000;
            padding-left: 10px;
        }
        
        .documents-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .documents-table th,
        .documents-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        
        .documents-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-box {
            text-align: center;
            width: 45%;
            margin-bottom: 20px;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            height: 40px;
            margin-bottom: 10px;
        }
        
        .signature-info {
            font-size: 10pt;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10pt;
        }
        
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Formulir Pendaftaran Ujian</div>
        <div class="subtitle">Sistem Informasi Manajemen Tugas Akhir Program (SIMANTAP)</div>
    </div>

    <div class="date">
        {{ $current_date }}
    </div>

    <div class="form-container">
        <div class="student-info">
            <div class="info-row">
                <div class="info-label">Nama Lengkap:</div>
                <div class="info-value">{{ $formulir->student_name }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">NIM:</div>
                <div class="info-value">{{ $formulir->student_nim }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Tempat/Tgl. Lahir:</div>
                <div class="info-value">{{ $formulir->place_of_birth }}, {{ $formulir->date_of_birth->format('d F Y') }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Semester/Jurusan:</div>
                <div class="info-value">{{ $formulir->semester }} / {{ $formulir->study_program }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">No. HP:</div>
                <div class="info-value">{{ $formulir->phone_number }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Judul Skripsi:</div>
                <div class="info-value">{{ $formulir->thesis_title }}</div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Pembimbing:</div>
                <div class="info-value">{{ $formulir->supervisor }}</div>
            </div>
        </div>

        <table class="documents-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Nama Berkas</th>
                    <th style="width: 25%;">Keterangan</th>
                    <th style="width: 20%;">Status Unggah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulir->document_status as $index => $status)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: left;">{{ $index }}</td>
                    <td>Wajib</td>
                    <td>{{ $status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-info">
                    <strong>{{ $secretary_name }}</strong><br>
                    NIP. {{ $secretary_nip }}<br>
                    Sekretaris Jurusan MD
                </div>
            </div>
            
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-info">
                    <strong>{{ $formulir->student_name }}</strong><br>
                    NIM. {{ $formulir->student_nim }}<br>
                    Mahasiswa
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><em>Formulir ini dibuat secara otomatis oleh sistem SIMANTAP</em></p>
    </div>
</body>
</html>
