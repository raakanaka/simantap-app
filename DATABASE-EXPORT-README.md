# Database Export SIMANTAP Dynamic

## File Export yang Tersedia

### 1. `simantap-dynamic-complete.sql`
- Export database lengkap dengan struktur dan data
- Ukuran: 32KB
- Berisi semua tabel, data, dan konfigurasi

### 2. `simantap-dynamic-full-export.sql`
- Export database dengan opsi lengkap (routines, triggers, single-transaction)
- Ukuran: 32KB
- Sama dengan file di atas, tapi dengan opsi export yang lebih lengkap

### 3. `simantap-dynamic-structure-only.sql`
- Hanya struktur tabel (tanpa data)
- Ukuran: 18KB
- Berguna untuk development atau testing

### 4. `simantap-dynamic-data-only.sql`
- Hanya data (tanpa struktur)
- Ukuran: 15KB
- Berguna untuk mengisi database yang sudah ada

## Data yang Sudah Tersedia

### 1. **Jenis Ujian (5 jenis)**
- Ujian Komprehensif (5 requirements)
- Seminar Hasil Jurnal (4 requirements)
- Seminar Proposal Skripsi (4 requirements)
- Sidang Kolokium Jurnal (15 requirements)
- Sidang Munaqasyah Skripsi (14 requirements)

### 2. **Requirements (42 total)**
- Semua requirements untuk setiap jenis ujian
- Format file: PDF dan JPG
- Validasi ukuran file: 10MB maksimal

### 3. **Program Studi**
- Manajemen Dakwah (PAI) - Fakultas Dakwah

### 4. **Akun Testing**
- **Admin:** username: `admin`, password: `admin123`
- **Mahasiswa:** NIM: `1234567890`, password: `password123`

## Cara Menggunakan Export Database

### 1. **Import ke Database Baru**
```bash
# Buat database baru
mysql -u root -p -e "CREATE DATABASE simantap_dynamic_new;"

# Import data
mysql -u root -p simantap_dynamic_new < simantap-dynamic-complete.sql
```

### 2. **Restore ke Database yang Ada**
```bash
# Backup database lama (opsional)
mysqldump -u root -p simantap_dynamic > backup-$(date +%Y%m%d).sql

# Import data baru
mysql -u root -p simantap_dynamic < simantap-dynamic-complete.sql
```

### 3. **Setup Aplikasi Laravel**
```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Update konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simantap_dynamic
DB_USERNAME=root
DB_PASSWORD=your_password

# Jalankan migrasi (jika diperlukan)
php artisan migrate

# Jalankan seeder (jika diperlukan)
php artisan db:seed
```

## Struktur Database

### Tabel Utama
- `users` - Tabel user sistem
- `students` - Data mahasiswa
- `admins` - Data admin
- `lecturers` - Data dosen
- `exam_types` - Jenis ujian
- `exam_requirements` - Requirements ujian
- `submissions` - Pengajuan ujian
- `submission_documents` - Dokumen pengajuan
- `study_programs` - Program studi

### Relasi
- `submissions` → `students` (student_nim)
- `submissions` → `exam_types` (exam_type_id)
- `submission_documents` → `submissions` (submission_id)
- `submission_documents` → `exam_requirements` (requirement_id)
- `lecturers` → `study_programs` (study_program_id)

## Fitur yang Sudah Tersedia

### 1. **Sistem Admin**
- Dashboard dengan statistik
- Manajemen mahasiswa (tambah, edit, hapus, verifikasi)
- Manajemen dosen
- Manajemen program studi
- Verifikasi pengajuan ujian
- Preview dan download dokumen

### 2. **Sistem Mahasiswa**
- Dashboard mahasiswa
- Pilih jenis ujian (5 jenis)
- Upload dokumen sesuai requirements
- Lihat status pengajuan
- Download formulir pendaftaran

### 3. **Sistem Dosen**
- Dashboard dosen
- Verifikasi pengajuan
- Preview dan download dokumen

## Catatan Penting

1. **Password Database:** Gunakan password yang sesuai dengan konfigurasi MySQL Anda
2. **File Upload:** Pastikan folder `storage/app/private` memiliki permission yang benar
3. **Environment:** Sesuaikan konfigurasi di file `.env` dengan environment Anda
4. **Backup:** Selalu backup database sebelum melakukan import

## Troubleshooting

### Error "Access denied"
```bash
# Cek user dan password MySQL
mysql -u root -p -e "SHOW DATABASES;"
```

### Error "Database doesn't exist"
```bash
# Buat database terlebih dahulu
mysql -u root -p -e "CREATE DATABASE simantap_dynamic;"
```

### Error "Table doesn't exist"
```bash
# Jalankan migrasi Laravel
php artisan migrate
```

## Support

Jika ada masalah dengan export database, periksa:
1. Konfigurasi MySQL
2. Permission file dan folder
3. Konfigurasi Laravel di `.env`
4. Log error di `storage/logs/laravel.log`