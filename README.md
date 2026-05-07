# Karcis.in 🎟️

**Karcis.in** adalah platform manajemen tiket event modern yang menyatukan kemudahan integrasi API untuk aplikasi mobile (Flutter) dengan dashboard web yang elegan bagi penyelenggara acara (Owner). Platform ini dibangun untuk memberikan pengalaman UX terbaik mulai dari pembuatan event hingga validasi peserta di lokasi.

---

## 🌟 Fitur Unggulan

### 1. **Owner Dashboard Premium**
Dashboard khusus penyelenggara dengan visualisasi data yang bersih dan modern menggunakan **Tailwind CSS**. 
- Ringkasan statistik (Total Event, Peserta, Revenue).
- Manajemen peserta real-time.

### 2. **Interactive Map Tagging**
Integrasi **Leaflet.js** dan **OpenStreetMap** pada halaman pembuatan event.
- Klik pada peta untuk mengambil koordinat Latitude dan Longitude secara otomatis.
- Mempermudah peserta menemukan lokasi acara dengan presisi tinggi.

### 3. **Smart Authentication System**
Implementasi sistem keamanan berlapis:
- **Web Auth**: Menggunakan Laravel Session untuk manajemen akses Dashboard.
- **API Auth**: Menggunakan **Laravel Sanctum** untuk komunikasi aman dengan aplikasi mobile.
- Role-based Access Control (Owner & User).

### 4. **Payment Gateway Integration (Midtrans)**
Terintegrasi secara penuh dengan **Midtrans** untuk pembayaran tiket otomatis.
- Generate Snap Token langsung saat booking tiket.
- Webhook otomatis untuk verifikasi status pembayaran (success, cancel, expire) ke tabel database tanpa intervensi manual.

### 4. **Fitur Validasi (Check-in)**
Sistem check-in yang efisien untuk mempercepat antrean di lokasi acara.
- Update status tiket menjadi `used`.
- Pencatatan otomatis waktu kedatangan (`check_in_at`).

### 5. **Premium UI/UX Design**
- **Aesthetics**: Menggunakan font **Plus Jakarta Sans**, efek *glassmorphism*, dan transisi halus.
- **Responsive**: Optimal diakses dari perangkat mobile maupun desktop.

---

## 🛠️ Teknologi & Tools

| Komponen | Teknologi |
| :--- | :--- |
| **Framework Utama** | [Laravel 13](https://laravel.com) |
| **Styling** | [Tailwind CSS](https://tailwindcss.com) |
| **Maps & Geolocation** | [Leaflet.js](https://leafletjs.com) & OpenStreetMap |
| **Autentikasi** | Laravel Sanctum & Web Guard |
| **Frontend Logic** | Blade Templates & [Alpine.js](https://alpinejs.dev) |
| **Icons & Fonts** | HeroIcons & Google Fonts (Plus Jakarta Sans) |
| **Image Processing** | Local Storage / Public Uploads |

---

## 📋 Prasyarat Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM (untuk aset frontend)
- MySQL / MariaDB

---

## 💻 Cara Instalasi

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/rian18-ari/db-karcisin.git
   cd db-karcisin
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   **Tambahkan Kredensial Midtrans di `.env`:**
   ```env
   MIDTRANS_SERVER_KEY="SB-Mid-server-xxxx"
   MIDTRANS_CLIENT_KEY="SB-Mid-client-xxxx"
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_IS_SANITIZED=true
   MIDTRANS_IS_3DS=true
   ```

4. **Database & Storage**:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   mkdir -p public/events # Pastikan folder upload tersedia
   ```

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```

---

## 🚦 Akses Aplikasi

### Web Dashboard
- **Landing Page**: `/`
- **Login Penyelenggara**: `/login`
- **Owner Dashboard**: `/owner/dashboard`
- **Create Event**: `/owner/events/create`
- **List Peserta**: `/owner/participants`

### API Endpoint (v1)
- `POST /api/v1/login` - Autentikasi User
- `GET /api/v1/events` - Daftar Event
- `POST /api/v1/bookings` - Pemesanan Tiket (Return `snap_token`)
- `POST /api/v1/bookings/webhook` - Webhook Midtrans untuk update status pembayaran
- `GET/POST /api/v1/charge` - Dummy endpoint untuk inisialisasi SDK Midtrans

---

## 💳 Cara Penggunaan Payment Gateway (Midtrans) *(payment flow)*

1.  **Inisialisasi SDK (Mobile)**: 
    *   Midtrans SDK diinisialisasi di `main.dart` menggunakan `MidtransSDK.init` tanpa `await` agar tidak menghambat *splash screen*.
    *   `merchantBaseUrl` diarahkan ke `Config.baseUrl` (`/api/v1`) untuk memicu *dummy check* ke `/api/v1/charge` [File: `lib/main.dart`].
2.  **Membuat Booking (Mobile -> Laravel)**:
    *   `BookingBloc` mengirim event `CreateBooking` yang memicu request ke `POST /api/v1/bookings` [File: `lib/bloc/booking/booking_bloc.dart`].
    *   `BookingController@store` di Laravel melakukan:
        *   Validasi paket & kuota.
        *   Simpan booking ke database dengan status `pending` [File: `app/Http/Controllers/api/BookingController.php`].
        *   Generate `snap_token` menggunakan library `midtrans/midtrans-php`.
        *   Mengembalikan JSON: `{ "status": "success", "snap_token": "...", "data": { ... } }`.
3.  **Memunculkan UI Pembayaran (Mobile)**:
    *   Setelah menerima `snap_token`, `BookingBloc` memanggil `midtransGlobal!.startPaymentUiFlow(token: snapToken)`.
    *   Pengecekan `midtransGlobal == null` dilakukan untuk mencegah `LateInitializationError` [File: `lib/bloc/booking/booking_bloc.dart`].
4.  **Callback & Webhook**:
    *   **Client Side**: SDK memicu `setTransactionFinishedCallback` saat pembayaran selesai di HP user untuk navigasi UI.
    *   **Server Side**: Midtrans mengirimkan notifikasi ke `POST /api/v1/bookings/webhook`.
    *   Laravel memverifikasi `signature_key`, lalu mengupdate status booking menjadi `paid` dan mengurangi kuota tiket secara permanen [File: `app/Http/Controllers/api/BookingController.php`].

---

## 🤝 Kontribusi

Kami sangat terbuka untuk kontribusi! Silakan buka *issue* atau kirimkan *pull request* untuk perbaikan dan fitur baru.

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah **Lisensi MIT**. 

---
*Dibuat dengan ❤️ oleh tim Karcis.in - 2026*