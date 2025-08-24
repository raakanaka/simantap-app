# SIMANTAP (Sistem Informasi Manajemen Terintegrasi Administrasi Penyelesaian Studi)

SIMANTAP adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola pengajuan ujian akhir mahasiswa. Aplikasi ini memungkinkan mahasiswa untuk mengajukan berbagai jenis ujian akhir dengan mengupload dokumen persyaratan yang diperlukan.

## Fitur Utama

### Untuk Mahasiswa:
1. **Login dengan NIM** - Mahasiswa dapat login menggunakan NIM sebagai username
2. **Dashboard Mahasiswa** - Melihat informasi pribadi dan statistik pengajuan
3. **Pilih Jenis Ujian** - 5 jenis ujian akhir yang tersedia:
   - Ujian Komprehensif
   - Seminar Proposal Draf Artikel Jurnal Ilmiah
   - Seminar Proposal Skripsi
   - Sidang Kolokium Jurnal
   - Sidang Munaqasyah Skripsi
4. **Upload Berkas Persyaratan** - Upload dokumen sesuai persyaratan masing-masing jenis ujian
5. **Submit Pengajuan** - Submit pengajuan untuk diverifikasi
6. **Cek Status Pengajuan** - Melihat status pengajuan (Menunggu Verifikasi/Berkas Diterima/Berkas Ditolak)
7. **Edit & Submit Ulang** - Revisi pengajuan yang ditolak

### Untuk Admin:
1. **Login Admin** - Admin login menggunakan username dan password
2. **Dashboard Admin** - Melihat statistik dan informasi pengajuan
3. **Verifikasi Pengajuan** - Melihat dan memverifikasi pengajuan mahasiswa
4. **Approve/Reject** - Menyetujui atau menolak pengajuan dengan alasan
5. **Monitor Pengajuan** - Memantau status semua pengajuan
6. **Generate Laporan** - Export laporan dalam format CSV
7. **Notifikasi** - Memberikan feedback kepada mahasiswa

## Alur Penggunaan Aplikasi

### 1. Login Mahasiswa
- Mahasiswa masuk ke aplikasi menggunakan NIM sebagai username dan password

### 2. Dashboard Mahasiswa
- Setelah berhasil login, mahasiswa akan diarahkan ke halaman dashboard
- Melihat berbagai pilihan menu dan informasi terkait pengajuan ujian akhir

### 3. Pilih Jenis Pengajuan
- Mahasiswa memilih salah satu dari 5 jenis pengajuan ujian akhir

### 4. Tampil Persyaratan Berkas
- Aplikasi menampilkan daftar persyaratan berkas yang harus diunggah

### 5. Upload Berkas Persyaratan
- Mahasiswa mengunggah semua berkas yang dibutuhkan

### 6. Submit Pengajuan
- Mahasiswa melakukan submit untuk mengajukan ujian akhir

### 7. Cek Status Pengajuan
- Mahasiswa memeriksa status pengajuan mereka

### 8. Status Pengajuan
- **Menunggu Verifikasi**: Pengajuan sedang dalam proses pemeriksaan
- **Berkas Diterima**: Pengajuan diterima dan siap untuk dilanjutkan
- **Berkas Ditolak**: Pengajuan ditolak karena ada kekurangan atau kesalahan

### 9. Alasan Revisi
- Jika berkas ditolak, mahasiswa mendapatkan penjelasan alasan revisi

### 10. Edit Berkas & Submit Ulang
- Mahasiswa dapat memperbaiki berkas dan submit ulang

## Alur Penggunaan Admin

### 1. Login Admin
- Admin login menggunakan username dan password yang telah disediakan

### 2. Dashboard Admin
- Melihat informasi utama dan status pengajuan ujian akhir mahasiswa
- Statistik pengajuan (total, menunggu, diterima, ditolak)
- Pengajuan terbaru

### 3. Verifikasi Pengajuan
- Melihat daftar pengajuan ujian akhir dari mahasiswa
- Melakukan verifikasi kelengkapan berkas
- Memberikan notifikasi revisi jika ada kekurangan

### 4. Approve/Reject Pengajuan
- **Approve**: Menyetujui pengajuan jika semua berkas lengkap
- **Reject**: Menolak pengajuan dengan memberikan alasan revisi

### 5. Monitor Pengajuan
- Memantau status pengajuan mahasiswa
- Melihat progres verifikasi

### 6. Generate Laporan
- Export laporan pengajuan dalam format CSV
- Filter berdasarkan status, jenis ujian, dan tanggal

### 7. Notifikasi dan Pengingat
- Memberikan feedback kepada mahasiswa
- Memberikan instruksi selanjutnya

## Teknologi yang Digunakan

- **Framework**: Laravel 12.x
- **Database**: SQLite (development) / MySQL/PostgreSQL (production)
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Built-in Authentication
- **File Upload**: Laravel Storage

## Instalasi

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd simantap-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Create storage link**
   ```bash
   php artisan storage:link
   ```

6. **Compile assets (optional)**
   ```bash
   npm run dev
   ```

7. **Jalankan server**
   ```bash
   php artisan serve
   ```

## Data Sample

Aplikasi sudah dilengkapi dengan data sample:

### Mahasiswa Sample:
- NIM: 2021001, Password: password123
- NIM: 2021002, Password: password123
- NIM: 2021003, Password: password123

### Admin Sample:
- Username: admin, Password: admin123 (Super Admin)
- Username: verifikator, Password: verifikator123 (Admin)
- Username: staff, Password: staff123 (Admin)

### Jenis Ujian:
1. Ujian Komprehensif (UK)
2. Seminar Proposal Draf Artikel Jurnal Ilmiah (SPDAJI)
3. Seminar Proposal Skripsi (SPS)
4. Sidang Kolokium Jurnal (SKJ)
5. Sidang Munaqasyah Skripsi (SMS)

## Struktur Database

### Tabel Utama:
- `students` - Data mahasiswa
- `exam_types` - Jenis ujian akhir
- `exam_requirements` - Persyaratan dokumen untuk setiap jenis ujian
- `exam_submissions` - Pengajuan ujian mahasiswa
- `submission_documents` - Dokumen yang diupload mahasiswa

## API Endpoints

### Authentication:
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Dashboard:
- `GET /dashboard` - Dashboard mahasiswa
- `GET /exam-types` - Daftar jenis ujian
- `GET /exam-types/{id}/requirements` - Persyaratan jenis ujian

### Submissions:
- `GET /submissions` - Daftar pengajuan mahasiswa
- `GET /submissions/create/{examType}` - Form upload berkas
- `POST /submissions/{examType}` - Submit pengajuan
- `GET /submissions/{id}` - Detail pengajuan
- `GET /submissions/{id}/edit` - Form edit pengajuan
- `PUT /submissions/{id}` - Update pengajuan

## Konfigurasi

### File Upload:
- Maksimal ukuran file: 20MB
- Format yang didukung: PDF, DOC, DOCX
- File disimpan di: `storage/app/public/submissions/`

### Authentication:
- Menggunakan NIM sebagai username
- Password di-hash menggunakan bcrypt

## Deployment

### Production Setup:
1. Set environment ke production
2. Optimize Laravel:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Setup web server (Apache/Nginx)
4. Setup database production
5. Setup SSL certificate

## Kontribusi

1. Fork repository
2. Buat feature branch
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi

Aplikasi ini dikembangkan untuk keperluan akademik.

## Support

Untuk pertanyaan atau bantuan, silakan hubungi tim pengembang.

---

**SIMANTAP** - Sistem Informasi Manajemen Terintegrasi Administrasi Penyelesaian Studi
