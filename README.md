<div align="center">
  <h1>⏰ Buddle: Smart Study Timer</h1>
  <p>A smart study timer application with personalized chronotype recommendations based on scientific research.</p>
</div>

---

## 👥 Tim Pengembang (The Team)

| Nama Anggota | Peran / Role |
| :--- | :--- |
| **Rusdiansyah Alief Prasetya** | Full-Stack Developer |
| **Aisha Maryam** | Frontend Developer |
| **Anindhita Faiza** | Data Science Developer |
| **Shafa Rizwana Zarin** | Full-Stack Developer |

## 🚀 Fitur Utama (Features)
Aplikasi ini dirancang dengan sangat detail, mengombinasikan riset data sains dan rekayasa perangkat lunak modern:
- 🧠 **Chronotype Onboarding Quiz**: Kuis cerdas berbasis riset ilmiah untuk mengetahui tipe produktivitas personal pengguna.
- 📊 **Personalized Recommendations**: Memberikan rekomendasi jadwal dan sesi belajar yang paling optimal khusus untuk setiap individu.
- 🎯 **Age-Based Optimization**: Sistem yang mengkalkulasi dan menyesuaikan optimasi berdasarkan usia.
- ⏱️ **Multiple Timer Methods**: Tersedia beragam mode fokus populer (*Pomodoro, 52/17, Flowtime, Animedoro, 2-Min Rule*).
- 🔔 **Smart Background Notifications**: Menggunakan teknologi **Web Worker** dan **PWA Service Worker** agar timer tetap berjalan sangat presisi 100% di latar belakang (kebal *browser throttling*) dan bisa mengirim notifikasi langsung ke layar OS.
- 📱 **Responsive Design**: Antarmuka adaptif yang terlihat cantik di laptop maupun HP.
- 🎨 **Beautiful Animations**: Animasi *smooth* dengan dukungan *Dark/Light mode* yang didesain secara estetik.

## 📂 Struktur Repository (Directory Structure)
Struktur *codebase* disusun dengan rapi menggunakan arsitektur MVC bawaan Laravel:

```text
ProjekTimer/
├── app/                  # Logika backend (Controllers, Models, Middleware)
├── database/             # Skema migrasi database & Seeders (MySQL)
├── public/               # Aset publik statis (File audio, sw.js, manifest.json)
├── resources/            
│   ├── css/              # Konfigurasi framework Tailwind CSS
│   ├── js/               # Konfigurasi bundler Vite & Alpine.js
│   └── views/            # File UI / Blade Templates (dashboard.blade.php)
├── routes/               # Pengaturan routing web (web.php)
├── deploy.sh             # Script shell untuk otomatisasi Deployment
└── Dockerfile            # Konfigurasi blueprint Container untuk Cloud Platform
```

## 🛠️ Tech Stack
Aplikasi ini dikembangkan menggunakan tumpukan teknologi (Tech Stack) modern:
- **Backend:** Laravel 10/11, PHP, MySQL
- **Frontend:** Alpine.js, Tailwind CSS, SweetAlert2
- **Infrastructure:** Docker, Web Audio API, Progressive Web App (PWA)

## ⚙️ Instalasi Lokal (Installation)
Untuk menjalankan aplikasi ini di laptop/komputer lokal:

1. Clone repository:
   ```bash
   git clone https://github.com/RusdiansyahAlief19/smart-study-timer.git
   ```
2. Copy konfigurasi environment:
   ```bash
   cp .env.example .env
   ```
3. Sesuaikan kredensial *database* pada file `.env`.
4. Install *dependencies*:
   ```bash
   composer install
   npm install
   ```
5. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```
6. Build aset *frontend* dan jalankan server lokal:
   ```bash
   npm run build
   php artisan serve
   ```
