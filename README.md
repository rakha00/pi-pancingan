# Aplikasi E-Commerce & Layanan Pelanggan Pancingan 🎣

Aplikasi ini adalah platform E-Commerce berbasis **Laravel 12** yang dikhususkan untuk penjualan perlengkapan/alat pancing. Aplikasi ini dirancang tidak hanya untuk mengelola katalog produk dan memproses pesanan, namun juga memiliki keunggulan pada sistem **Live Chat Real-Time** yang intensif antara pelanggan dan admin.

## 🌟 Fitur Utama

### 1. Katalog & Manajemen Produk

- **Kategori Produk**: Pengelolaan kategori alat pancing (misal: joran, kail, umpan, dsb).
- **Manajemen Produk**: Admin dapat menambah, mengubah, dan menghapus produk beserta detail harganya.
- **Tema Terang & Gelap (Dark Mode)**: Mendukung mode gelap (_dark mode_) pada antarmuka admin dan klien untuk kenyamanan visual.

### 2. Transaksi & Pembayaran Terintegrasi

- **Sistem Pesanan (Order)**: Kemampuan sistem menampung dan memantau status pesanan (Pending, Paid, Canceled, dsb).
- **Pembayaran Otomatis**: Layanan integrasi dengan _Payment Gateway_ **Midtrans** (melalui Snap Token) guna mendeteksi pembayaran yang berhasil atau kedaluwarsa secara instan.

### 3. Live Chat & Order Referencing (Real-Time)

- **WebSockets via Laravel Reverb**: Pesan dikirim secara instan (sekedipan mata) antara pelanggan dan operator tanpa perlu me-_refresh_ halaman _(No HTTP Polling)_.
- **Pemisahan Sesi Customer/Admin**: Setiap pelanggan memiliki ruang obrolan (_chat room_) pribadi dengan Admin. Admin menggunakan antarmuka khusus untuk menjawab puluhan pelanggan.
- **Order Linking / Order Attachment**: Pelanggan atau admin dapat **menautkan pesanan** (melampirkan referensi pesanan berupa ID, Status, dan Total Harga) secara langsung ke dalam gelembung obrolan (_bubble chat_). Hal ini sangat mempermudah pelayanan bila terjadi komplain, pelacakan resi, atau pertanyaan garansi.

---

## 💻 Tech Stack

- **Backend**: PHP 8.3 & Laravel 12
- **Frontend**: Tailwind CSS v3, Alpine.js, Blade Templates (Laravel Breeze Backend)
- **Database**: MySQL / SQLite.
- **WebSockets**: Laravel Reverb + Laravel Echo.

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi ini secara lokal di komputer Anda.

### Persyaratan Sistem

- [PHP](https://www.php.net/downloads) (Versi 8.2 atau lebih baru)
- [Composer](https://getcomposer.org/)
- [Node.js / NPM](https://nodejs.org/en/)
- [MySQL](https://www.mysql.com/) atau MariaDB (atau bisa juga menggunakan _driver_ `sqlite`)

### Langkah-langkah Instalasi

1. **Clone Repositori Ini**
   Silakan unduh atau lakukan clone repositori ini ke komputer Anda.

    ```bash
    git clone <url-repositori>
    cd pi-pancingan
    ```

2. **Instalasi Dependensi PHP & JavaScript**

    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Environment (`.env`)**
   Salin berkas konfigurasi bawaan Laravel:

    ```bash
    cp .env.example .env
    ```

    **PENTING:** Buka file `.env` menggunakan _text editor_ dan atur konfigurasi berikut:
    - Generate _Application Key_:
        ```bash
        php artisan key:generate
        ```
    - Atur kredensial **Database** Anda:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=pancingan_db
        DB_USERNAME=root
        DB_PASSWORD=
        ```
    - Atur Driver _Broadcast_ ke **Reverb**:
        ```env
        BROADCAST_CONNECTION=reverb
        CACHE_STORE=database
        QUEUE_CONNECTION=database
        ```
    - Apabila diperlukan, masukkan Kunci API **Midtrans** Anda di _env_ untuk mengaktifkan fungsi transaksi asli.

4. **Jalankan Migrasi Database**
   Buat semua struktur tabel beserta isiannya:

    ```bash
    php artisan migrate
    ```

    _(Opsional)_ Jika repositori ini telah dilengkapi dengan seeder produk/admin, jalankan:
    `php artisan migrate --seed`

5. **Lakukan Build Frontend Assets (Tailwind & Alpine) & Jalankan Server**
   Agar tampilan CSS _(Tailwind Mode)_ dan Javascript dapat di-_compile_:

    ```bash
    npm run build
    # atau untuk mode pengembangan / hot-reload:
    npm run dev
    ```

6. **Menjalankan HTTP Framework & Server WebSocket (Laravel Reverb)**
   Anda perlu membuka **dua terminal** secara terpisah untuk menjalankan aplikasi PHP seutuhnya:
    - **Terminal 1** (Aplikasi HTTP Utama):
        ```bash
        php artisan serve
        ```
    - **Terminal 2** (Real-Time Service - WebSocket):
        ```bash
        php artisan reverb:start
        ```

7. **Aplikasi Siap Digunakan! 🎉**
   Buka _browser_ pilihan Anda dan akses navigasi alamat lokal berikut: `http://127.0.0.1:8000`

---
