<p align="center">
  <h1 align="center">🌀 WACKY LAB</h1>
  <p align="center">
    <strong>Laboratorium Web Interaktif, Eksperimental, dan Menyenangkan</strong><br>
    <em>Dibuat oleh Rizky Dika — Siswa RPL, Pengembang Android & Full-stack Web Enthusiast.</em>
  </p>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS v4" />
  <img src="https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
  <img src="https://img.shields.io/badge/Matter.js-2D_Physics-4B5563?style=for-the-badge" alt="Matter.js" />
  <img src="https://img.shields.io/badge/Web_Audio-8--Bit_Synth-F59E0B?style=for-the-badge" alt="Web Audio API" />
</p>

---

## 📖 Tentang Proyek

**Wacky Lab** adalah portofolio sekaligus tempat bermain web (*interactive playground*) bergaya *Neo-Brutalist Retro* yang memadukan animasi kinetik, simulasi fisika 2D di browser, desktop retro Windows 98, synthesizer suara 8-bit tanpa audio file eksternal, kartu 3D holografik, maskot interaktif, dan berbagai *easter egg* seru.

Proyek ini telah direfaktor dan di-modularisasi sepenuhnya ke dalam arsitektur **Laravel Blade Components** dan **Vite ES Modules**, sehingga rapi, mudah dikembangkan, berkinerja tinggi, dan siap dipamerkan di GitHub.

---

## ✨ Fitur-Fitur Interaktif

### 1. 🔤 Tipografi Kinetik & Fisika 2D (Matter.js)
- **Huruf Karet (*Squash & Stretch*)**: Huruf judul membal elastis mengikuti kedekatan kursor mouse.
- **Tombol Magnetik**: Tombol-tombol utama tertarik lembut ke arah kursor.
- **Simulasi Gravitasi Dinamis**:
  - `🪐 Zero-G`: Menghilangkan gravitasi dan melayangkan elemen-elemen di layar ke segala arah.
  - `💥 Chaos Drop`: Menjatuhkan elemen ke bawah dengan gravitasi penuh dan pantulan realistis.
  - `↺ Reset`: Mengembalikan semua elemen ke posisi grid awal.

### 2. 🪪 Kartu Nama 3D Holografik
- Efek kemilau holografik (*hologram sheen*) yang dinamis.
- Kemiringan 3D (*perspective tilt*) mengikuti posisi mouse di PC dan orientasi giroskop (*gyroscope sensor*) di perangkat seluler / HP.
- Tombol **Kustomisasi Kartu ID** untuk mengganti nama dan peran secara langsung.

### 3. 💻 Komputer Jadul (Windows 98 OS)
- **Jendela Interaktif**: Jendela *draggable* yang dapat digeser, ditumpuk (*layering z-index* otomatis), dan ditutup.
- **Winamp-ish 8-bit Synthesizer**: Pemutar musik chiptune retro menggunakan **Web Audio API** asli (tanpa file mp3) lengkap dengan animasi equalizer dinamis.
- **Desktop Shortcut Icons & Start Menu**: Buka kembali aplikasi yang telah ditutup lewat menu Start atau ikon desktop.
- **Jam Digital Live**: Jam taskbar berjalan *real-time* dengan format waktu lokal.

### 4. ⚡ Panel Kekacauan (Chaos Controls)
- **✨ Jejak Kursor**: Menghamburkan bintang berkelip di jejak pergerakan kursor.
- **🥴 Mode Goyang**: Menggoyangkan seluruh elemen halaman web.
- **🌈 Mode Pelangi**: Siklus warna `hue-rotate` 360 derajat tiada henti.
- **🔊 Suara Klik Retro**: Sintesis suara bip 8-bit saat menekan tombol dan berinteraksi.
- **🌋 Mode Gempa**: Guncangan layar dramatis ala gempa bumi.

### 5. 🎨 Papan Stiker Bebas
- Papan gabus interaktif untuk menempel, menyeret, dan menata emoji stiker.
- Tombol **Tambah Stiker Acak** dan **Bersihkan Papan**.

### 6. 🪙 Kupon Gosok Berhadiah
- Kartu gosok berbasis HTML5 `<canvas>` dengan penghapusan transparan (*destination-out*).
- Menghitung persentase gosok secara otomatis: jika >45% terbuka, efek ledakan konfeti dan *fanfare fanfare sound* akan berbunyi!
- Tombol **Isi Ulang Kupon** yang merotasi pesan rahasia / kutipan baru.

### 7. 🐱 Maskot Kucing Interaktif & Makanan
- Maskot SVG dengan pelacak retina mata (*pupil tracking*) yang selalu memandang kursor.
- **Mode Tidur Otomatis**: Jika pengguna diam selama >10 detik, mata kucing akan terpejam dan muncul efek mendengkur `zZ`.
- **Reaksi Kaget**: Kucing akan meloncat kaget (*"hah?!"*) jika kursor digerakkan dengan sangat cepat di dekatnya.
- **Beri Makan Kucing**: Seret makanan pizza (🍕) ke mulut kucing untuk memicu animasi makan (*"nyam!"*) dan suara mengunyah.

### 8. 🕹️ Easter Eggs & Cheat Codes
- **Konami Code**: Ketik urutan tombol keyboard:  
  `↑` `↑` `↓` `↓` `←` `→` `←` `→` `B` `A`  
  untuk mengaktifkan **ARCADE MODE** (tampilan retro invert neon & ledakan partikel).
- **Spasi**: Tekan tombol <kbd>Space</kbd> untuk meluncurkan ledakan konfeti di tengah layar.
- **Klik Sembarang**: Klik di area kosong akan menghasilkan letupan bintang kecil.

---

## 🛠️ Tech Stack

- **Backend Framework**: [Laravel 13](https://laravel.com) (PHP 8.3+)
- **Build Tool**: [Vite 8](https://vitejs.dev) + Laravel Vite Plugin
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com) + Custom Neo-Brutalist Theme
- **Physics Engine**: [Matter.js](https://brm.io/matter-js/)
- **Audio Synthesizer**: Native Web Audio API (Square & Triangle Oscillators)
- **Interactive Canvas**: HTML5 2D Canvas API

---

## 📁 Struktur Proyek

```
wacky-lab/
├── app/
│   └── Providers/
├── resources/
│   ├── css/
│   │   └── app.css                # Style terpusat, variabel CSS, neo-brutalist theme
│   ├── js/
│   │   ├── app.js                 # Entry point inisialisasi aplikasi
│   │   └── modules/
│   │       ├── audio.js           # Web Audio API 8-bit sound generator & Winamp synth
│   │       ├── badge.js           # 3D tilt & hologram logic
│   │       ├── chaos.js           # Panel kekacauan, scroll parallax, Konami code
│   │       ├── desktop.js         # Window manager Windows 98, taskbar, start menu
│   │       ├── kinetic.js         # Huruf karet, tombol magnetik, partikel konfeti
│   │       ├── mascot.js          # Pelacak pupil kucing, mode tidur, interaksi pizza
│   │       ├── physics.js         # Integrasi fisika Matter.js (Zero-G & Chaos Drop)
│   │       ├── scratch.js         # Canvas kartu gosok berhadiah
│   │       ├── stickers.js        # Drag-and-drop papan stiker
│   │       └── theme.js           # Pengatur tema gelap / terang
│   └── views/
│       ├── components/
│       │   ├── layouts/
│       │   │   └── app.blade.php  # Base layout HTML, meta tags, and header/footer
│       │   ├── badge.blade.php    # Komponen kartu 3D
│       │   ├── chaos-panel.blade.php
│       │   ├── footer.blade.php
│       │   ├── hero.blade.php     # Komponen hero & tipografi karet
│       │   ├── marquee.blade.php  # Banner berjalan
│       │   ├── mascot.blade.php   # SVG maskot kucing & treat
│       │   ├── navbar.blade.php   # Navigasi atas, sound switch, dark mode
│       │   ├── retro-desktop.blade.php
│       │   ├── scratch-card.blade.php
│       │   └── sticker-board.blade.php
│       └── home.blade.php         # Halaman utama merakit semua komponen
├── routes/
│   └── web.php
└── vite.config.js
```

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### Prasyarat
- PHP >= 8.3
- Composer
- Node.js >= 20.x & npm

### Langkah-langkah

1. **Clone repositori**:
   ```bash
   git clone https://github.com/rizkydika544-debug/wacky-lab.git
   cd wacky-lab
   ```

2. **Install dependensi PHP**:
   ```bash
   composer install
   ```

3. **Install dependensi Frontend**:
   ```bash
   npm install
   ```

4. **Siapkan berkas environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Build aset frontend**:
   ```bash
   npm run build
   # Atau untuk mode pengembangan real-time:
   # npm run dev
   ```

6. **Jalankan development server**:
   ```bash
   php artisan serve
   ```
   Buka browser di `http://localhost:8000` dan nikmati keseruannya!

---

## 🧪 Menjalankan Pengujian (Tests)

Proyek ini dilengkapi dengan unit & feature tests menggunakan PHPUnit:

```bash
php artisan test
```

---

## 👤 Pengembang

- **Nama**: Rizky Dika
- **Keahlian**: Android Development (Kotlin, Jetpack Compose), Full-stack Web (PHP, Laravel, Tailwind), 3D Modeling (Blender)
- **GitHub**: [@rizkydika544-debug](https://github.com/rizkydika544-debug)

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi [MIT License](LICENSE). Bebas digunakan, dimodifikasi, dan dikembangkan lebih lanjut.
