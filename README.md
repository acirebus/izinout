# Nugas 5 : IzinOut

Aplikasi IzinOut adalah sistem digital untuk pengajuan, verifikasi, dan dokumentasi izin keluar siswa di lingkungan sekolah. Dibangun menggunakan Laravel, aplikasi ini memudahkan proses perizinan, meningkatkan transparansi, dan mengurangi risiko kehilangan dokumen fisik.


### Masalah yang Diselesaikan
- Surat izin kertas mudah hilang dan sulit ditelusuri.
- Proses manual memakan waktu (datang ke guru BK/wali kelas, tanda tangan).
- Validasi izin kurang ketat, rawan pemalsuan.
- Sekolah kesulitan memantau izin secara real-time dan historis.

### Tujuan
- Membuat sistem izin digital yang transparan, cepat, dan aman.
- Memudahkan siswa mengajukan izin online.
- Memudahkan guru/admin memverifikasi izin.
- Penjaga sekolah dapat memvalidasi izin dengan QR Code.
- Data izin terdokumentasi untuk evaluasi sekolah.

## Fitur Utama

- **Registrasi & Login**: Siswa, Guru BK/Admin, dan Guru Mapel dapat login dengan akun masing-masing.
- **Pengajuan Izin Siswa**: Siswa mengisi alasan, waktu mulai/akhir, dan mengunggah bukti pendukung.
- **Verifikasi Izin**: Guru BK/Admin dan Guru Mapel meninjau, menyetujui, atau menolak permohonan izin.
- **QR Code Otomatis**: Izin yang disetujui menghasilkan QR Code unik sesuai durasi izin.
- **Validasi QR oleh Penjaga**: Penjaga sekolah memindai QR untuk cek validitas izin secara real-time.
- **Notifikasi Real-time**: Siswa dan guru menerima notifikasi status izin.
- **Riwayat Izin**: Semua pengguna dapat melihat riwayat izin secara lengkap.
- **Statistik & Laporan**: Admin dapat melihat statistik izin dan melakukan ekspor data.

## Cara Kerja Singkat

1. Siswa login dan mengajukan izin melalui form digital.
2. Guru/Admin menerima notifikasi dan memverifikasi permohonan.
3. Jika disetujui, QR Code dibuat dan dapat dipindai oleh penjaga.
4. Semua proses tercatat dan dapat diakses pada riwayat masing-masing pengguna.

## Cara Instalasi & Menjalankan (Lokal)

1. Aktifkan Apache dan MySQL (Laragon).
2. Import database `izin` dan jalankan semua query.
3. Buka folder project, install dependency Laravel:
	```powershell
	composer install
	```
4. Edit file `.env` sesuai konfigurasi database.
5. Generate key aplikasi:
	```powershell
	php artisan key:generate
	```
6. Migrasi dan seeding database:
	```powershell
	php artisan migrate --seed
	```
7. Jalankan server lokal:
	```powershell
	php artisan serve
	```
8. Akses aplikasi di browser, contoh: `http://localhost:8000`

## Contoh Konfigurasi .env

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY= // App key otomatis //
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=izin
DB_USERNAME=root
DB_PASSWORD=
```

## Akun Demo

Login dengan email berikut (password: `password`):
- admin@smkn13 (admin)
- guru@smkn13 (guru)
- udin@smkn13 (siswa)
- asep@smkn13 (siswa)
- agus@smkn13 (siswa)
- tessiswa@smkn13 (siswa)

## Struktur Utama

- `app/Http/Controllers/` : Logika backend (pengajuan, verifikasi, notifikasi, QR, dsb)
- `resources/views/` : Tampilan frontend (form, dashboard, riwayat, dll)
- `routes/web.php` : Rute aplikasi
- `app/Models/` : Model data (Siswa, Izin, QR, Notifikasi, dsb)
- `database/migrations/` : Struktur tabel database
