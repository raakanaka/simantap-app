<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran {{ $formulir->exam_type->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .institution {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-row {
            margin-bottom: 8px;
            display: flex;
        }
        .form-label {
            width: 150px;
            font-weight: bold;
        }
        .form-value {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 16px;
        }
        .documents-section {
            margin: 30px 0;
        }
        .documents-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .documents-table th,
        .documents-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .documents-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .signature-cell {
            width: 50%;
            vertical-align: top;
            padding: 10px;
            height: 120px;
        }
        .signature-cell:first-child {
            text-align: left;
        }
        .signature-cell:last-child {
            text-align: right;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 40px;
            margin: 20px 0 10px 0;
            width: 200px;
        }
        .signature-cell:last-child .signature-line {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">FORMULIR PENDAFTARAN</div>
        <div class="subtitle">{{ strtoupper($formulir->exam_type->name) }}</div>
        <div class="institution">MAHASISWA FAKULTAS DAKWAH DAN KOMUNIKASI UIN SU</div>
    </div>

    <div class="form-section">
        <p>Saya yang bertanda tangan di bawah ini:</p>
        
        <div class="form-row">
            <div class="form-label">Nama</div>
            <div class="form-value">{{ $formulir->student_name ?? 'Test Student' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">NIM</div>
            <div class="form-value">{{ $formulir->student_nim ?? '2021001' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Tempat/Tgl.Lahir</div>
            <div class="form-value">{{ $formulir->place_of_birth ?? 'Jakarta' }}, {{ $formulir->date_of_birth ?? '01 Januari 2000' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Semester/Jurusan</div>
            <div class="form-value">{{ $formulir->semester ?? '8' }} / {{ $formulir->study_program ?? 'Teknik Informatika' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">No.HP</div>
            <div class="form-value">{{ $formulir->phone_number ?? '08123456789' }}</div>
        </div>
        
        @if(in_array($formulir->exam_type->code, ['SKJ', 'SHJ']))
        <div class="form-row">
            <div class="form-label">Judul Artikel</div>
            <div class="form-value">{{ $formulir->thesis_title ?? 'Test Article' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Jurnal Sinta</div>
            <div class="form-value">{{ $formulir->journal_name ?? 'Test Journal' }}</div>
        </div>
        @else
        <div class="form-row">
            <div class="form-label">Judul {{ $formulir->exam_type->code === 'SMS' ? 'Skripsi' : 'Penelitian' }}</div>
            <div class="form-value">{{ $formulir->thesis_title ?? 'Test Title' }}</div>
        </div>
        @endif
        
        <div class="form-row">
            <div class="form-label">Pembimbing</div>
            <div class="form-value">{{ $formulir->supervisor ?? 'Test Supervisor' }}</div>
        </div>
    </div>

    <div class="documents-section">
        <p>Dengan ini mendaftar untuk mengikuti {{ $formulir->exam_type->name }}. Bersama ini saya lampirkan:</p>
        
        <table class="documents-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 60%;">Nama Berkas</th>
                    <th style="width: 15%;">Keterangan</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulir->requirements as $index => $requirement)
                @php
                    $uploadedDoc = $formulir->submission->documents->where('requirement_id', $requirement->id)->first();
                    $status = $uploadedDoc ? 'Terunggah' : 'Belum diunggah';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $requirement->document_name }}</td>
                    <td>{{ $requirement->is_required ? 'Wajib' : 'Opsional' }}</td>
                    <td>{{ $status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <p><strong>Menerima</strong></p>
                    <p><strong>Sekretaris Jurusan MD</strong></p>
                    <div class="signature-line"></div>
                    <p><strong>{{ $formulir->secretary_name }}</strong></p>
                    <p>NIP. {{ $formulir->secretary_nip }}</p>
                </td>
                <td class="signature-cell">
                    <p><strong>Medan, {{ $formulir->current_date ?? now()->format('d F Y') }}</strong></p>
                    <p><strong>Mahasiswa ybs</strong></p>
                    <div class="signature-line"></div>
                    <p><strong>{{ $formulir->student_name ?? 'Test Student' }}</strong></p>
                    <p>NIM. {{ $formulir->student_nim ?? '2021001' }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>


