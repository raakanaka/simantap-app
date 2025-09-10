@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="flex h-screen bg-gray-50">
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/logo-simantap-small.png') }}" alt="SIMANTAP Logo" class="w-6 h-6 object-contain">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">SIMANTAP</h2>
                    <p class="text-sm text-gray-600">Admin</p>
                </div>
            </div>
        </div>
        <nav class="mt-6">
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.submissions') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-list w-5 h-5 mr-3"></i>
                    <span>Daftar Pengajuan</span>
                </a>
                <a href="{{ route('admin.students') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-user-check w-5 h-5 mr-3"></i>
                    <span>Verifikasi Mahasiswa</span>
                </a>
                <a href="{{ route('admin.lecturers') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Pengolahan Akun</span>
                </a>
                <a href="{{ route('admin.study-programs') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Program Studi</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200 bg-blue-50 text-blue-700">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition duration-200">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span>Pengaturan Akun</span>
                </a>
                <form action="{{ route('auth.logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 transition duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
    
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Laporan Sistem</h1>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">Selamat datang, {{ session('user_name') }}</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto p-6">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">Generate Laporan</h2>
                    <div class="text-sm text-gray-500">
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
                
                <!-- Report Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Diterima</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'berkas_diterima')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Menunggu</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'menunggu_verifikasi')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-times text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Ditolak</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'berkas_ditolak')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Generation Options -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Laporan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Laporan Pengajuan</h4>
                            <p class="text-sm text-gray-500 mb-4">Generate laporan semua pengajuan ujian</p>
                            <button id="generateSubmissionsReport" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-download mr-2"></i>Download PDF
                            </button>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Laporan Statistik</h4>
                            <p class="text-sm text-gray-500 mb-4">Generate laporan statistik sistem</p>
                            <button id="generateStatsReport" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-chart-bar mr-2"></i>Download Excel
                            </button>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Laporan Mahasiswa</h4>
                            <p class="text-sm text-gray-500 mb-4">Generate laporan data mahasiswa</p>
                            <button id="generateStudentsReport" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-users mr-2"></i>Download PDF
                            </button>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Laporan Dosen</h4>
                            <p class="text-sm text-gray-500 mb-4">Generate laporan data dosen</p>
                            <button id="generateLecturersReport" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Download PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pengajuan Terbaru</h3>
                    @if($submissions->count() === 0)
                    <div class="text-center py-8">
                        <i class="fas fa-file-alt text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada pengajuan</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pengajuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Ujian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($submissions->take(10) as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $submission->submission_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $submission->student_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->examType->name ?? 'Unknown' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($submission->status === 'menunggu_verifikasi')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @elseif($submission->status === 'berkas_diterima')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Diterima</span>
                                        @elseif($submission->status === 'berkas_ditolak')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $submission->submitted_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
        </main>

@push('scripts')
<script>
function showAlert(message, type = 'info') {
    const alertColors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        danger: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };

    const alertHTML = `
        <div class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div class="border rounded-lg p-4 ${alertColors[type]} shadow-lg" id="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-3"></i>
                        <span class="font-medium">${message}</span>
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHTML);
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) alert.remove();
    }, 5000);
}

// Report Generation Functions
function generateSubmissionsReport() {
    showAlert('Sedang memproses laporan pengajuan...', 'info');
    
    // Generate PDF untuk laporan pengajuan
    setTimeout(() => {
        const data = @json($submissions);
        generatePDFReport(data, 'Laporan_Pengajuan_' + getCurrentDate() + '.pdf', 'submissions');
        showAlert('Laporan pengajuan PDF berhasil diunduh!', 'success');
    }, 2000);
}

function generateStatsReport() {
    showAlert('Sedang memproses laporan statistik...', 'info');
    
    setTimeout(() => {
        const stats = {
            total: {{ $submissions->count() }},
            approved: {{ $submissions->where('status', 'berkas_diterima')->count() }},
            pending: {{ $submissions->where('status', 'menunggu_verifikasi')->count() }},
            rejected: {{ $submissions->where('status', 'berkas_ditolak')->count() }}
        };
        
        // Generate Excel untuk statistik
        const csvContent = convertStatsToCSV(stats);
        downloadFile(csvContent, 'Laporan_Statistik_' + getCurrentDate() + '.csv', 'text/csv');
        showAlert('Laporan statistik Excel berhasil diunduh!', 'success');
    }, 2000);
}

function generateStudentsReport() {
    showAlert('Sedang memproses laporan mahasiswa...', 'info');
    
    setTimeout(() => {
        // Simulasi data mahasiswa untuk PDF
        const studentsData = [
            {nim: '2021001', name: 'Ahmad Rizki', program: 'Teknik Informatika', email: 'ahmad@email.com', status: 'Aktif'},
            {nim: '2021002', name: 'Siti Nurhaliza', program: 'Sistem Informasi', email: 'siti@email.com', status: 'Aktif'},
            {nim: '2021003', name: 'Budi Santoso', program: 'Teknik Komputer', email: 'budi@email.com', status: 'Aktif'}
        ];
        
        generatePDFReport(studentsData, 'Laporan_Mahasiswa_' + getCurrentDate() + '.pdf', 'students');
        showAlert('Laporan mahasiswa PDF berhasil diunduh!', 'success');
    }, 2000);
}

function generateLecturersReport() {
    showAlert('Sedang memproses laporan dosen...', 'info');
    
    setTimeout(() => {
        // Simulasi data dosen untuk PDF
        const lecturersData = [
            {nidn: '0012345678', name: 'Dr. John Doe', email: 'john@email.com', expertise: 'Teknik Informatika', status: 'Aktif'},
            {nidn: '0012345679', name: 'Dr. Jane Smith', email: 'jane@email.com', expertise: 'Sistem Informasi', status: 'Aktif'},
            {nidn: '0012345680', name: 'Prof. Ahmad Rizki', email: 'ahmad@email.com', expertise: 'Teknik Komputer', status: 'Aktif'}
        ];
        
        generatePDFReport(lecturersData, 'Laporan_Dosen_' + getCurrentDate() + '.pdf', 'lecturers');
        showAlert('Laporan dosen PDF berhasil diunduh!', 'success');
    }, 2000);
}

function convertToCSV(data) {
    if (!data || data.length === 0) return '';
    
    const headers = ['No. Pengajuan', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Jenis Ujian', 'Status', 'Tanggal Pengajuan'];
    const csvRows = [headers.join(',')];
    
    data.forEach(submission => {
        const row = [
            submission.submission_number || '',
            submission.student_name || '',
            submission.student_nim || '',
            submission.student_study_program || '',
            submission.examType?.name || 'Unknown',
            submission.status || '',
            submission.submitted_at ? new Date(submission.submitted_at).toLocaleDateString('id-ID') : ''
        ];
        csvRows.push(row.map(field => `"${field}"`).join(','));
    });
    
    return csvRows.join('\n');
}

function convertStatsToCSV(stats) {
    const headers = ['Kategori', 'Jumlah'];
    const csvRows = [
        headers.join(','),
        `"Total Pengajuan","${stats.total}"`,
        `"Diterima","${stats.approved}"`,
        `"Menunggu Verifikasi","${stats.pending}"`,
        `"Ditolak","${stats.rejected}"`
    ];
    
    return csvRows.join('\n');
}

function generatePDFReport(data, filename, type) {
    // Load jsPDF library dynamically
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
    script.onload = function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Set font
        doc.setFont('helvetica');
        
        // Add title
        doc.setFontSize(18);
        doc.text('LAPORAN SISTEM SIMANTAP', 20, 20);
        
        // Add subtitle based on type
        let subtitle = '';
        switch(type) {
            case 'submissions':
                subtitle = 'Laporan Pengajuan Ujian';
                break;
            case 'students':
                subtitle = 'Laporan Data Mahasiswa';
                break;
            case 'lecturers':
                subtitle = 'Laporan Data Dosen';
                break;
        }
        
        doc.setFontSize(14);
        doc.text(subtitle, 20, 30);
        
        // Add date
        doc.setFontSize(10);
        doc.text('Tanggal: ' + new Date().toLocaleDateString('id-ID'), 20, 40);
        
        // Add content based on type
        let yPosition = 50;
        
        if (type === 'submissions') {
            generateSubmissionsPDF(doc, data, yPosition);
        } else if (type === 'students') {
            generateStudentsPDF(doc, data, yPosition);
        } else if (type === 'lecturers') {
            generateLecturersPDF(doc, data, yPosition);
        }
        
        // Save the PDF
        doc.save(filename);
    };
    document.head.appendChild(script);
}

function generateSubmissionsPDF(doc, data, startY) {
    let y = startY;
    
    // Table headers
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    
    const headers = ['No. Pengajuan', 'Nama Mahasiswa', 'NIM', 'Jenis Ujian', 'Status', 'Tanggal'];
    const colWidths = [30, 50, 25, 40, 25, 25];
    let x = 20;
    
    // Draw headers
    headers.forEach((header, index) => {
        doc.rect(x, y - 5, colWidths[index], 8);
        doc.text(header, x + 2, y);
        x += colWidths[index];
    });
    
    y += 10;
    doc.setFont('helvetica', 'normal');
    
    // Draw data rows
    data.forEach((submission, index) => {
        if (y > 280) {
            doc.addPage();
            y = 20;
        }
        
        x = 20;
        const rowData = [
            submission.submission_number || '',
            submission.student_name || '',
            submission.student_nim || '',
            submission.examType?.name || 'Unknown',
            submission.status || '',
            submission.submitted_at ? new Date(submission.submitted_at).toLocaleDateString('id-ID') : ''
        ];
        
        rowData.forEach((cell, cellIndex) => {
            doc.rect(x, y - 5, colWidths[cellIndex], 8);
            doc.text(cell.substring(0, 20), x + 2, y); // Truncate long text
            x += colWidths[cellIndex];
        });
        
        y += 10;
    });
}

function generateStudentsPDF(doc, data, startY) {
    let y = startY;
    
    // Table headers
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    
    const headers = ['NIM', 'Nama', 'Program Studi', 'Email', 'Status'];
    const colWidths = [25, 50, 40, 50, 20];
    let x = 20;
    
    // Draw headers
    headers.forEach((header, index) => {
        doc.rect(x, y - 5, colWidths[index], 8);
        doc.text(header, x + 2, y);
        x += colWidths[index];
    });
    
    y += 10;
    doc.setFont('helvetica', 'normal');
    
    // Draw data rows
    data.forEach((student, index) => {
        if (y > 280) {
            doc.addPage();
            y = 20;
        }
        
        x = 20;
        const rowData = [
            student.nim || '',
            student.name || '',
            student.program || '',
            student.email || '',
            student.status || ''
        ];
        
        rowData.forEach((cell, cellIndex) => {
            doc.rect(x, y - 5, colWidths[cellIndex], 8);
            doc.text(cell.substring(0, 20), x + 2, y); // Truncate long text
            x += colWidths[cellIndex];
        });
        
        y += 10;
    });
}

function generateLecturersPDF(doc, data, startY) {
    let y = startY;
    
    // Table headers
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    
    const headers = ['NIDN', 'Nama', 'Email', 'Bidang Keahlian', 'Status'];
    const colWidths = [30, 50, 50, 40, 20];
    let x = 20;
    
    // Draw headers
    headers.forEach((header, index) => {
        doc.rect(x, y - 5, colWidths[index], 8);
        doc.text(header, x + 2, y);
        x += colWidths[index];
    });
    
    y += 10;
    doc.setFont('helvetica', 'normal');
    
    // Draw data rows
    data.forEach((lecturer, index) => {
        if (y > 280) {
            doc.addPage();
            y = 20;
        }
        
        x = 20;
        const rowData = [
            lecturer.nidn || '',
            lecturer.name || '',
            lecturer.email || '',
            lecturer.expertise || '',
            lecturer.status || ''
        ];
        
        rowData.forEach((cell, cellIndex) => {
            doc.rect(x, y - 5, colWidths[cellIndex], 8);
            doc.text(cell.substring(0, 20), x + 2, y); // Truncate long text
            x += colWidths[cellIndex];
        });
        
        y += 10;
    });
}

function downloadFile(content, filename, mimeType) {
    const blob = new Blob([content], { type: mimeType + ';charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function getCurrentDate() {
    return new Date().toISOString().split('T')[0];
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Attach event listeners to buttons
    const generateSubmissionsBtn = document.getElementById('generateSubmissionsReport');
    const generateStatsBtn = document.getElementById('generateStatsReport');
    const generateStudentsBtn = document.getElementById('generateStudentsReport');
    const generateLecturersBtn = document.getElementById('generateLecturersReport');
    
    if (generateSubmissionsBtn) {
        generateSubmissionsBtn.addEventListener('click', generateSubmissionsReport);
    }
    
    if (generateStatsBtn) {
        generateStatsBtn.addEventListener('click', generateStatsReport);
    }
    
    if (generateStudentsBtn) {
        generateStudentsBtn.addEventListener('click', generateStudentsReport);
    }
    
    if (generateLecturersBtn) {
        generateLecturersBtn.addEventListener('click', generateLecturersReport);
    }
});

@if(session('success'))
showAlert('{{ session('success') }}', 'success');
@endif

@if(session('error'))
showAlert('{{ session('error') }}', 'danger');
@endif
</script>
@endpush
@endsection
