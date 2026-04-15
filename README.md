# Karcisin API 🎟️

Karcisin adalah sistem manajemen tiket event berbasis web dan mobile yang dibangun menggunakan framework **Laravel 13**. Proyek ini berfungsi sebagai backend API untuk aplikasi pemesanan tiket, mencakup pengelolaan event, kategori, serta sistem booking.

## 🚀 Fitur Utama

* **Autentikasi**: Sistem Login dan Register menggunakan Laravel Sanctum.
* **Manajemen Event**: CRUD data event lengkap dengan informasi lokasi (latitude/longitude), kuota, dan status.
* **Kategori Event**: Pengelompokan event berdasarkan kategori tertentu.
* **Sistem Booking**: Proses pemesanan tiket dengan kode unik dan unggah bukti pembayaran.
* **RESTful API**: Endpoint yang terstruktur untuk integrasi dengan aplikasi mobile (Flutter).

## 🛠️ Teknologi yang Digunakan

* **Backend**: [Laravel 13](https://laravel.com)
* **Database**: MariaDB/MySQL (melalui migrasi Laravel)
* **Auth**: Laravel Sanctum
* **Package Dev**: Laravel Sail, Pint, & Pail

## 📋 Struktur Database (Migrations)

Proyek ini memiliki beberapa tabel utama:
- `users`: Data pengguna dan penyelenggara.
- `categories`: Kategori event (e.g., Konser, Workshop).
- `events`: Detail acara, lokasi, harga, dan relasi ke kategori/user.
- `bookings`: Transaksi tiket, status pembayaran, dan riwayat check-in.

## 🚦 Endpoint API (v1)

Berikut adalah beberapa endpoint yang tersedia:

| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| POST | `/api/v1/login` | Autentikasi pengguna |
| POST | `/api/v1/register` | Pendaftaran pengguna baru |
| GET | `/api/v1/events` | Mengambil daftar semua event |
| GET | `/api/v1/users` | Daftar pengguna (Admin/Internal) |
| GET | `/api/v1/users/{id}` | Detail profil pengguna |

## 💻 Cara Instalasi

1. **Clone repositori**:
   ```bash
   git clone [https://github.com/rian18-ari/db-karcisin.git](https://github.com/rian18-ari/db-karcisin.git)
   cd db-karcisin
2. **Install dependencies**:
   ```bash
   composer install
   ```
3. **Konfigurasi environment**:
   Salin file `.env.example` menjadi `.env` dan sesuaikan kredensial database:
   ```bash
   cp .env.example .env
   ```
4. **Generate key**:
   ```bash
   php artisan key:generate
   ```
5. **Jalankan migrasi database**:
   ```bash
   php artisan migrate
   ```
6. **Jalankan server development**:
   ```bash
   php artisan serve
   ```
   Server akan berjalan pada `http://localhost:8000`.

## 🧪 Pengujian API

Anda dapat menggunakan alat seperti [Postman](https://www.postman.com/) atau [Insomnia](https://insomnia.rest/) untuk menguji endpoint API.

### Contoh Request Login

**URL**: `http://localhost:8000/api/v1/login`
**Method**: `POST`
**Body** (JSON):
```json
{
    "email": "[EMAIL_ADDRESS]",
    "password": "password123"
}
```

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repositori, buat branch fitur (`git checkout -b feature/AmazingFeature`), commit perubahan (`git commit -m 'Add some AmazingFeature'`), dan push ke branch (`git push origin feature/AmazingFeature`).

## 📄 Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT.