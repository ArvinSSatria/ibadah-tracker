# Ibadah Tracker - Aplikasi Web Pelacak Ibadah Harian

Aplikasi web sederhana namun kuat yang dirancang untuk membantu umat Muslim dalam mencatat, mengelola, dan memantau perkembangan ibadah harian mereka. Proyek ini dibangun dengan tujuan menjadi sahabat digital yang memotivasi pengguna untuk lebih konsisten (istiqomah) dalam beribadah.

## 🕌 Deskripsi Proyek

Ibadah Tracker adalah platform yang ramah pengguna (user-friendly) dan berfokus pada privasi. Pengguna dapat dengan mudah mencatat berbagai macam ibadah harian, mulai dari shalat wajib hingga ibadah sunnah yang dapat mereka personalisasi sendiri. Dengan halaman riwayat yang terstruktur, pengguna dapat melihat kembali progres mereka dari waktu ke waktu, membantu mereka untuk melakukan evaluasi diri dan meningkatkan kualitas ibadah.

## ✨ Fitur Utama

-   **🔐 Autentikasi Pengguna:** Sistem pendaftaran (Sign Up) dan masuk (Login) yang aman.
-   **🌙 Mode Terang & Gelap:** Tampilan yang dapat disesuaikan untuk kenyamanan mata.
-   **📱 Desain Responsif:** Tampilan yang optimal baik di desktop maupun perangkat mobile.
-   **📊 Dasbor Harian:**
    -   Ringkasan progres ibadah hari ini.
    -   Checklist interaktif untuk menandai ibadah yang telah selesai.
-   **📝 Pelacakan Ibadah:**
    -   **Shalat Wajib:** Checklist untuk 5 waktu shalat.
    -   **Tilawah Al-Qur'an:** Input untuk mencatat jumlah halaman yang dibaca setiap hari.
    -   **Ibadah Custom:** Fitur untuk menambah, melacak, dan mengelola ibadah atau kebiasaan baik lainnya sesuai keinginan pengguna (misalnya: Shalat Dhuha, Zikir Pagi, Puasa Senin-Kamis).
-   **📜 Halaman Riwayat & Progres:**
    -   Menampilkan ringkasan data ibadah yang dikelompokkan berdasarkan tanggal.
    -   Memudahkan pengguna untuk melihat konsistensi ibadah dari hari ke hari.

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun dengan TALL Stack modern yang dimodifikasi:

-   **Backend:** [Laravel 10](https://laravel.com/)
-   **Frontend:**
    -   [Tailwind CSS](https://tailwindcss.com/)
    -   [Alpine.js](https://alpinejs.dev/)
    -   [Vite](https://vitejs.dev/)
-   **Database:** [SQLite](https://www.sqlite.org/index.html) (untuk kemudahan portabilitas dan pengembangan lokal)

## 🚀 Panduan Instalasi Lokal

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Prasyarat

Pastikan Anda telah menginstal perangkat lunak berikut di komputer Anda:
-   PHP >= 8.1
-   Composer
-   Node.js & NPM

### Langkah-langkah Instalasi

1.  **Clone repositori ini:**
    ```sh
    git clone https://github.com/username/ibadah-tracker.git
    ```

2.  **Masuk ke direktori proyek:**
    ```sh
    cd ibadah-tracker
    ```

3.  **Instal dependensi PHP:**
    ```sh
    composer install
    ```

4.  **Instal dependensi Node.js:**
    ```sh
    npm install
    ```

5.  **Salin file environment:**
    ```sh
    cp .env.example .env
    ```

6.  **Generate kunci aplikasi Laravel:**
    ```sh
    php artisan key:generate
    ```

7.  **Konfigurasi Database (SQLite):**
    -   Buat sebuah file kosong di dalam direktori `database/` dengan nama `database.sqlite`.
    -   Buka file `.env` dan pastikan konfigurasi database Anda terlihat seperti ini:
      ```env
      DB_CONNECTION=sqlite
      DB_DATABASE=/path/to/your/project/ibadah-tracker/database/database.sqlite
      ```
      _Ganti `/path/to/your/project/` dengan path absolut ke direktori proyek Anda._

8.  **Jalankan migrasi database:**
    Perintah ini akan membuat semua tabel yang dibutuhkan di dalam file `database.sqlite`.
    ```sh
    php artisan migrate
    ```

9.  **Jalankan server pengembangan:**
    -   Di terminal pertama, jalankan server Laravel:
      ```sh
      php artisan serve
      ```
    -   Di terminal kedua, jalankan Vite untuk kompilasi aset frontend:
      ```sh
      npm run dev
      ```

10. **Selesai!** Buka `http://127.0.0.1:8000` di browser Anda.

## 🗺️ Rencana Pengembangan (Roadmap)

Berikut adalah beberapa fitur yang direncanakan untuk pengembangan di masa depan:

-   [ ] **Gamifikasi:** Sistem poin, lencana (badges), dan level untuk meningkatkan motivasi.
-   [ ] **Pelacak Zikir:** Fitur "tasbih digital" untuk menghitung zikir harian.
-   [ ] **Detail Shalat:** Opsi untuk mencatat shalat "Tepat Waktu" dan "Berjamaah".
-   [ ] **Visualisasi Data:** Grafik dan bagan di halaman riwayat untuk melihat tren.
-   [ ] **Tantangan (Challenges):** Membuat tantangan ibadah yang bisa diikuti pengguna.

## 📄 Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE.txt` untuk informasi lebih lanjut.

---