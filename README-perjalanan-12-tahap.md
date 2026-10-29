# 🌌 Perjalanan 12 Tahap — Halaman Edukasi Interaktif

> Sebuah halaman web **sinematik dan edukatif** yang membawa pengunjung menyusuri 12 tahap perjalanan manusia menurut Al-Qur'an dan hadis: dari **sebelum lahir** sampai **masuk surga**. Setiap tahap punya animasi transisi, teks Arab, terjemah, dalil, penjelasan, dan pelajaran praktis.
>
> Halaman ini **disisipkan ke website yang sudah ada** sebagai halaman baru yang diakses lewat **tombol di navbar**, dan sekaligus menjadi **karya portofolio** (UI/UX, animasi web, content engineering, aksesibilitas).

---

## 0. BACA DULU — Instruksi untuk Antigravity

Dokumen ini adalah brief lengkap. Kerjakan berurutan dan patuhi aturan berikut.

1. **Periksa proyek yang sudah ada terlebih dahulu.** Baca struktur folder, framework, sistem routing, komponen navbar, gaya CSS, font, dan token warna. **Ikuti stack dan konvensi yang sudah dipakai.** Jangan mengganti framework, jangan menimpa file yang sudah ada, dan jangan merusak halaman lain.
2. **Halaman ini ditambahkan, bukan menggantikan.** Buat satu halaman/route baru (disarankan `/perjalanan-12-tahap`) dan **tambahkan satu tombol di navbar** yang menuju ke sana (lihat Bagian 5).
3. Kalau website induk berupa portofolio interaktif dengan beberapa modul atau halaman, daftarkan halaman ini sebagai **modul/halaman tambahan** dengan cara yang sama seperti yang lain.
4. Halaman ini punya **tema gelap imersif sendiri** (lihat Bagian 7), tetapi navbar harus tetap terasa satu keluarga dengan website induk.
5. **Jangan membuat/mengarang teks Arab, ayat, atau nomor hadis sendiri.** Gunakan data pada Bagian 9 sebagai acuan, lalu **verifikasi atau ambil dari sumber resmi** (lihat Bagian 14). Teks Arab di dokumen ini ditulis sebagai referensi awal dan **wajib dicek ulang** sebelum dipublikasikan.
6. Semua animasi wajib punya **fallback `prefers-reduced-motion`** dan performa harus aman di HP kelas menengah.
7. Setelah selesai, jalankan **checklist penerimaan** di Bagian 16 dan laporkan apa yang sudah dan belum selesai.

### Ringkasan satu paragraf (boleh dipakai sebagai prompt awal)

> Buatkan halaman baru "Perjalanan 12 Tahap" di website ini. Halaman berisi 12 tahap perjalanan manusia (sebelum lahir → rahim → dunia → kubur/barzakh → sangkakala → padang mahsyar → syafaat → catatan & timbangan → telaga → pemisahan → shirath → qantharah/surga). Setiap tahap punya ilustrasi animasi minimalis bergaya langit malam/senja, bar progres 12 titik, penanda "KAMU DI SINI", teks Arab + terjemah + dalil + penjelasan panjang + pelajaran praktis, dan animasi transisi sinematik antar tahap. Tambahkan tombol di navbar untuk membuka halaman ini. Ikuti stack dan desain website yang sudah ada. Data konten ada di README ini.

---

## 1. Latar Belakang & Inspirasi

Konsep ini terinspirasi dari sebuah video TikTok berformat *infografis animasi* di akun **@pendar.quran**. Videonya menyajikan perjalanan manusia dalam 12 tahap dengan metafora **peta perjalanan**: ada penanda "KAMU DI SINI", bar 12 titik yang maju tiap tahap, ilustrasi minimalis, dan kutipan dalil di tiap tahap. Pesan penutupnya: dari seluruh tahap itu, **hanya fase dunia yang masih bisa diubah manusia**.

### ⚠️ Orisinalitas & atribusi (penting untuk portofolio)

- Proyek ini adalah **karya sendiri yang terinspirasi dari konsep umum** "peta perjalanan 12 tahap". Jangan menyalin teks narasi, ilustrasi, atau animasi persis dari video aslinya.
- **Tulis ulang semua narasi dengan gaya bahasa sendiri.** Dalil Al-Qur'an dan hadis boleh dikutip karena sumbernya publik, tetapi kalimat penjelasannya harus asli.
- **Buat ilustrasi dan animasi sendiri** (SVG, Canvas, CSS). Tampilkan atribusi kecil di footer: *"Terinspirasi dari konsep peta perjalanan 12 tahap oleh @pendar.quran"*.
- Struktur 12 tahap adalah **kerangka penyajian**, bukan klasifikasi baku dari dalil (lihat Bagian 14).

---

## 2. Tujuan Proyek

### 2.1 Tujuan produk

| # | Tujuan | Ukuran keberhasilan |
|---|--------|--------------------|
| 1 | Mengedukasi pengunjung tentang urutan peristiwa perjalanan manusia menurut dalil | Pengunjung bisa menyebut ulang 12 tahap setelah selesai |
| 2 | Menyajikan konten keagamaan dengan **akurat, bersumber, dan beradab** | Setiap klaim punya dalil/rujukan, dan perbedaan pendapat ulama ditandai |
| 3 | Pengalaman visual yang **tenang, sinematik, dan reflektif** | Transisi halus, tidak berisik, tidak menakut-nakuti berlebihan |
| 4 | Jadi karya portofolio yang kuat | Ada case study (Bagian 18), kode bersih, performa dan aksesibilitas baik |

### 2.2 Target pengguna

- Pelajar dan mahasiswa yang suka konten Islami berformat singkat.
- Pengunjung portofolio (rekruter, guru pembimbing, calon mitra PKL) yang menilai kemampuan UI/animasi.
- Siapa pun yang ingin memahami gambaran besar perjalanan akhirat secara runtut.

### 2.3 Nilai portofolio

Halaman ini memamerkan: scroll/step-driven storytelling, animasi SVG/Canvas, desain tipografi bilingual (Arab–Latin), RTL handling, content modeling (data terpisah dari tampilan), aksesibilitas, dan optimasi performa.

---

## 3. Konsep Utama: "Peta Perjalanan"

Pengunjung diposisikan sebagai **seorang musafir** yang bergerak melewati 12 tahap.

- **Penanda posisi:** pin oranye bertuliskan **KAMU DI SINI** muncul di tahap yang relevan, terutama tahap Dunia dan Kubur.
- **Bar progres 12 titik** di bagian atas: titik yang sudah dilewati menyala keemasan, titik sekarang paling terang, sisanya redup. Ada penghitung `03 / 12`.
- **Setiap tahap = satu "alam" dengan suasana warna dan gerak sendiri.** Perpindahan antar alam harus terasa seperti berpindah dimensi.
- **Satu tahap, satu ide.** Teks utama singkat dan kuat. Penjelasan panjang tersedia di panel "Pelajari lebih dalam".
- **Arah cerita:** gelap & sunyi (awal) → ujian di dunia → kegelapan alam kubur → guncangan hari kiamat → pengadilan → keselamatan → cahaya surga.
- **Klimaks emosional:** layar penutup mengajak pengunjung kembali ke tahap Dunia dan bertanya, *"Apa yang bisa aku lakukan hari ini?"*

---

## 4. Alur Pengalaman Pengguna (UX Flow)

```
Navbar → klik "Perjalanan 12 Tahap"
   ↓
[Intro]  "Perjalananmu ada 12 tahap. Satu tahap masih bisa kamu ubah." → tombol "Mulai Perjalanan"
   ↓
[Tahap 01 … 12]  (navigasi: scroll / swipe / tombol Lanjut ‣ Kembali / tombol panah keyboard)
   ↓
[Layar Penutup]  Ringkasan 12 tahap + ajakan beramal + tombol "Ulangi", "Kuis", "Bagikan", "Kembali ke Beranda"
```

### 4.1 Mode navigasi (sediakan keduanya)

1. **Mode Sinematik (default):** tiap tahap memenuhi satu layar penuh (100dvh). Pindah tahap lewat scroll bertahap (scroll-snap), swipe vertikal di HP, tombol panah ↑ ↓ / ← →, atau tombol Lanjut/Kembali di layar.
2. **Mode Baca:** semua tahap ditampilkan sebagai satu halaman panjang dengan animasi minimal. Cocok untuk membaca teks panjang, untuk pengguna reduced motion, dan untuk SEO. Sediakan tombol toggle "Mode Sinematik ⇄ Mode Baca".

### 4.2 Kontrol di layar

- **Kiri-atas / navbar:** tombol kembali ke beranda dan indikator "Perjalanan 12 Tahap".
- **Atas:** bar 12 titik + penghitung. Titik bisa diklik untuk melompat ke tahap tersebut.
- **Bawah:** tombol `‹ Mundur` dan `Lanjut ›`, plus tombol "Pelajari lebih dalam ⌄".
- **Kanan-atas:** toggle suara (default **mati**), toggle Mode Baca, toggle ukuran teks Arab.
- Simpan progres terakhir di `localStorage` (bungkus try/catch) agar pengunjung bisa "Lanjutkan dari tahap 07".

---

## 5. Integrasi ke Website yang Sudah Ada (Navbar)

### 5.1 Permintaan utama

> **Tambahkan satu tombol di navbar** yang membuka halaman Perjalanan 12 Tahap. Klik tombol = berpindah halaman (route baru), bukan sekadar scroll.

### 5.2 Spesifikasi navbar

| Item | Spesifikasi |
|------|-------------|
| Label | **"Perjalanan 12 Tahap"** (versi pendek untuk mobile: **"12 Tahap"**) |
| Ikon | Pin peta 📍 atau bulan sabit/bintang. Gunakan ikon dari library yang sudah dipakai proyek. |
| Posisi | Sejajar dengan item navbar lain; bila proyek punya dropdown "Proyek"/"Lab", boleh ditaruh di sana, tapi tetap mudah ditemukan |
| Route | `/perjalanan-12-tahap` (atau konvensi routing proyek, misal hash `#/perjalanan-12-tahap`) |
| State aktif | Item navbar diberi gaya aktif saat berada di halaman ini |
| Mobile | Masuk ke menu hamburger dengan label dan ikon yang sama, area sentuh minimal 44×44 px |
| Aksesibilitas | `aria-current="page"` saat aktif, fokus keyboard terlihat jelas |
| Kembali | Dari halaman ini harus mudah kembali ke beranda (logo/nav item "Beranda") |

### 5.3 Perilaku saat berpindah halaman

- Gunakan **transisi halaman** yang halus, misalnya layar gelap memudar (fade-to-night) selama ±600 ms sebelum konten halaman baru muncul. Pakai mekanisme transisi yang sudah ada di proyek bila ada.
- **Lazy-load**: kode dan aset halaman ini (animasi, font Arab) hanya dimuat saat halaman dibuka, jangan memberatkan halaman lain.
- Saat halaman dibuka dari navbar, mulai dari **Intro**, kecuali ada progres tersimpan, maka tampilkan opsi "Lanjutkan".
- Navbar di halaman ini boleh dibuat **transparan dan menyatu dengan tema gelap**, lalu kembali ke gaya normal di halaman lain.
- Jika proyek memakai SPA, pastikan tombol **Back browser** berfungsi: tahap bisa direpresentasikan dengan hash `#tahap-04`. Hindari state tersembunyi yang membuat tombol Back membingungkan.

### 5.4 Struktur file yang disarankan (sesuaikan dengan stack proyek)

```
<root-proyek>/
└── (folder halaman/komponen sesuai konvensi proyek)/
    └── perjalanan-12-tahap/
        ├── index                      ← halaman utama (route)
        ├── data/
        │   ├── stages.json            ← 12 tahap (lihat Bagian 9)
        │   ├── glossary.json          ← kamus istilah
        │   └── quiz.json              ← bank soal kuis
        ├── components/
        │   ├── JourneyShell           ← kerangka: progress bar, kontrol, mode
        │   ├── StageScene             ← satu tahap (visual + teks)
        │   ├── ProgressTrail          ← bar 12 titik + pin "KAMU DI SINI"
        │   ├── ArabicBlock            ← teks Arab RTL + terjemah + sumber
        │   ├── DeepDivePanel          ← "Pelajari lebih dalam"
        │   ├── TransitionLayer        ← animasi antar alam
        │   ├── Glossary / Quiz / EndScreen
        │   └── scenes/                ← 12 komponen animasi (Scene01 … Scene12)
        ├── styles/                    ← token warna, tipografi, utilitas RTL
        └── assets/                    ← SVG, font Arab (self-host jika memungkinkan)
```

---

## 6. Struktur Layar Tiap Tahap

Setiap tahap memakai satu template yang sama agar konsisten.

```
┌───────────────────────────────────────┐
│  ● ● ● ○ ○ ○ ○ ○ ○ ○ ○ ○    03 / 12   │  ← ProgressTrail
│                                       │
│            📍 KAMU DI SINI            │  ← hanya di tahap tertentu
│                                       │
│          [ ILUSTRASI ANIMASI ]        │  ← scene khas tiap alam
│                                       │
│   03 / 12 · DUNIA                     │  ← label tahap (kapital, letter-spacing lebar)
│      لِيَبْلُوَكُمْ أَيُّكُمْ أَحْسَنُ عَمَلًا   │  ← ArabicBlock (RTL, font Naskh/Amiri)
│   Mati dan hidup diciptakan untuk     │  ← kalimat inti (Indonesia, besar & tebal)
│   menguji: siapa yang paling baik     │
│   amalnya.                            │
│   QS. Al-Mulk 67:2 · Terjemah Kemenag │  ← sumber (kecil, redup)
│                                       │
│     ‹ Mundur     Lanjut ›             │
│        ⌄ Pelajari lebih dalam         │  ← membuka DeepDivePanel
└───────────────────────────────────────┘
```

### Panel "Pelajari lebih dalam" (DeepDivePanel)

Bottom-sheet (mobile) atau panel samping (desktop) berisi:

1. **Penjelasan** (2–4 paragraf).
2. **Kosakata Arab** (istilah, tulisan Arab, transliterasi, arti).
3. **Dalil lengkap**: teks Arab lengkap, terjemah, sumber, tautan rujukan.
4. **Catatan ulama** (jika ada perbedaan pendapat).
5. **Pelajaran praktis**: apa yang bisa dilakukan sekarang.
6. **Bacaan lanjutan**: dalil tambahan.

---

## 7. Desain Visual

### 7.1 Karakter visual

- **Gaya:** minimalis, siluet dan garis tipis bercahaya (line-art glow), partikel cahaya, langit gradien. Suasana tenang, bukan horor.
- **Pantangan visual (adab):**
  - **Jangan menggambarkan wajah atau rupa Nabi dan para malaikat.** Untuk Nabi cukup teks atau cahaya. Manusia boleh berupa **siluet polos tanpa wajah**.
  - **Jangan menampilkan gambar menakutkan, gore, atau sadis** untuk neraka dan azab. Cukup suasana: warna merah gelap, garis jembatan, kilatan redup.
  - Hindari hal yang mengesankan mempermainkan topik suci (meme, efek lucu).
  - Jangan memakai musik bernada hiburan yang tidak pantas. Default tanpa suara.

### 7.2 Token warna per alam

Tentukan sebagai CSS variables agar mudah diubah. Tiap tahap punya palet gradien langit (`--sky-top`, `--sky-bottom`), warna cahaya (`--glow`), dan warna aksen.

| # | Alam | Suasana | `--sky-top` | `--sky-bottom` | `--glow` |
|---|------|---------|-------------|----------------|----------|
| 01 | Sebelum lahir | Ruang bintang biru tua | `#070b24` | `#101a4a` | `#cfe0ff` |
| 02 | Rahim | Marun gelap, hangat, berdenyut | `#1a0710` | `#3a0f1c` | `#ffb4a0` |
| 03 | Dunia | Senja jingga ke biru malam | `#2a1f4a` | `#f2a05a` | `#ffd89a` |
| 04 | Kubur / Barzakh | Ungu gelap, sunyi, dingin | `#0b0818` | `#2b1530` | `#e8b57a` |
| 05 | Sangkakala | Hitam pekat bertabur titik | `#05050b` | `#0d0a1a` | `#ffe9b0` |
| 06 | Padang Mahsyar | Jingga terik, matahari dekat | `#3b1a0c` | `#e0883a` | `#fff0c8` |
| 07 | Syafaat | Gelap keemasan, cahaya lembut | `#150f1f` | `#3a2a2a` | `#ffd36b` |
| 08 | Catatan & Timbangan | Emas hangat, timbangan | `#241410` | `#8a5a3a` | `#ffe0a0` |
| 09 | Telaga | Biru pucat, putih seperti susu | `#0a1230` | `#cfe1f5` | `#ffffff` |
| 10 | Pemisahan | Biru dongker, dua arah | `#070b1a` | `#101830` | `#c8d4ff` |
| 11 | Shirath | Merah-hitam, garis tipis menyala | `#12050a` | `#4a1010` | `#ff9a6a` |
| 12 | Qantharah → Surga | Fajar emas hangat | `#1a1230` | `#ffcf8a` | `#fff3d0` |

### 7.3 Tipografi

| Kebutuhan | Rekomendasi | Catatan |
|-----------|-------------|---------|
| Teks Arab (ayat/hadis) | **Amiri**, **Scheherazade New**, atau **Noto Naskh Arabic** | Self-host bila bisa. Ukuran min. `1.6rem` di mobile, `line-height: 2.1–2.4` agar harakat tidak terpotong |
| Teks Latin | Font sans modern (mis. *Plus Jakarta Sans* atau *Inter*), atau ikuti font proyek | Bobot tebal untuk kalimat inti |
| Label tahap | Kapital, `letter-spacing: 0.2em`, ukuran kecil | Contoh: `03 / 12 · DUNIA` |

- Teks Arab: `dir="rtl"`, `lang="ar"`, `text-align: center`.
- Gunakan `font-feature-settings` default; jangan memaksa ligature yang merusak harakat.
- Jangan pernah menaruh teks Arab sebagai **gambar**. Harus teks asli agar bisa disalin dan dibaca screen reader.

### 7.4 Komponen visual berulang (motif)

- **Siluet manusia** (garis luar bercahaya): muncul di tahap 3–4 dan 11. Kecil, di tengah.
- **Pin lokasi oranye** "KAMU DI SINI".
- **Titik cahaya (partikel)**: melambangkan ruh/manusia di berbagai tahap. Jumlah dan perilakunya berbeda tiap tahap.
- **Garis horizon**: pemisah langit–bumi di banyak tahap.

---

## 8. Animasi

### 8.1 Prinsip

1. **Halus dan bermakna.** Setiap gerakan harus menjelaskan sesuatu, bukan sekadar hiasan.
2. **Satu gerakan utama per tahap**, sisanya mikro (kerlip bintang, napas cahaya).
3. **Durasi transisi antar alam: 1.2–2.0 detik** dengan easing lembut (`easeInOut`/`power2.inOut`). Teks muncul setelah visual stabil.
4. **Performa dulu:** gunakan `transform` dan `opacity`, hindari animasi `width/height/top/left`.
5. **Reduced motion:** jika `prefers-reduced-motion: reduce`, ganti semua animasi besar dengan **crossfade 300 ms**, matikan partikel bergerak, dan tampilkan gambar statis.

### 8.2 Pilihan teknologi (pilih yang paling cocok dengan stack proyek)

| Kebutuhan | Opsi |
|-----------|------|
| Orkestrasi timeline & transisi | **GSAP** (+ ScrollTrigger) atau **Framer Motion** bila proyek memakai React |
| Ilustrasi | **SVG inline** (garis, siluet, timbangan, jembatan) |
| Partikel/bintang | **Canvas 2D** (ringan). Hindari Three.js kecuali proyek sudah memakainya |
| Efek sederhana | CSS animation/keyframes |

### 8.3 Spesifikasi transisi antar alam (TransitionLayer)

Transisi dibuat di lapisan terpisah di atas semua scene. Tiap transisi menyambung scene sebelum dan sesudahnya.

| Dari → Ke | Efek transisi | Makna |
|-----------|---------------|-------|
| Intro → 01 | Layar menggelap, bintang bermunculan satu per satu | Memasuki alam sebelum waktu |
| 01 → 02 | Bintang-bintang **mengerucut** ke satu titik cahaya, lalu titik itu **membesar menjadi lingkaran hangat** bernapas (rahim) | Ruh → kehidupan di dalam rahim |
| 02 → 03 | Lingkaran **pecah melebar**, fajar naik dari horizon, siluet manusia **muncul perlahan** dari bawah | Kelahiran |
| 03 → 04 | Siluet berjalan menuju horizon, langit **senja memudar jadi gelap**, garis **BARZAKH** menyala di bawah kaki dan kapsul gelap (kubur) muncul | Kematian → alam barzakh |
| 04 → 05 | Titik-titik di kubur meredup, **cincin gelombang suara** (terompet) menyebar dari tengah, semua titik padam, hening 0.6 detik | Tiupan sangkakala |
| 05 → 06 | Ratusan titik cahaya **bangkit dari bawah** dan menyebar di tanah lapang, matahari **turun mendekat** pelan-pelan | Kebangkitan dan padang mahsyar |
| 06 → 07 | Titik-titik **bergerombol dan merapat**, lalu nama para nabi muncul bergantian: `ADAM · NUH · IBRAHIM · MUSA · ISA`, dan terakhir cahaya emas lembut di pusat (tanpa gambar) | Mencari syafaat |
| 07 → 08 | Cahaya emas memanjang jadi tiang, **timbangan** tumbuh dari tiang itu, kedua pinggannya bergoyang lalu stabil | Penimbangan amal |
| 08 → 09 | Timbangan memudar, **hamparan putih susu** (telaga) menyapu dari bawah, partikel berkilau | Telaga yang menyegarkan |
| 09 → 10 | Partikel **terbelah dua arah** (kiri dan kanan), warna langit mendingin | Pemisahan menurut apa yang dulu disembah |
| 10 → 11 | Dari tengah, **satu garis tipis bercahaya** memanjang membentuk jembatan di atas dasar merah gelap, titik-titik kecil berjalan di atasnya (ada yang cepat, ada yang jatuh) | Melintasi shirath |
| 11 → 12 | Jembatan **melengkung naik** menjadi lengkung gerbang (qantharah), warna berubah dari merah ke emas hangat | Selamat dari neraka |
| 12 → Penutup | Lengkung terbuka, **cahaya fajar membanjiri layar** (flash lembut, bukan menyilaukan), lalu layar menurun ke garis horizon dan siluet manusia di tahap Dunia, dengan pin **KAMU DI SINI** kembali muncul | Pesan: perubahan masih mungkin di dunia |

### 8.4 Animasi mikro

- Teks: muncul per baris (stagger 80–120 ms) naik 12 px sambil fade-in.
- Teks Arab: fade-in lebih lambat (600 ms) agar terasa khidmat.
- Bar progres: titik berikutnya "menyala" dengan efek glow 400 ms.
- Pin "KAMU DI SINI": bobbing lembut naik-turun 6 px, loop 2 detik.
- Hover/focus tombol: glow tipis, tanpa skala besar.

### 8.5 Aturan performa

- Batas partikel: **≤ 250 di desktop, ≤ 120 di mobile**.
- Cap `devicePixelRatio` canvas maksimum 2.
- Hentikan loop animasi saat tab tidak aktif (`document.hidden`) dan saat scene di luar layar.
- Satu `requestAnimationFrame` bersama untuk semua partikel.
- Preload hanya **scene berikutnya**, bukan semua 12 sekaligus.
- Target: 60 fps di perangkat menengah, **LCP < 2.5 s**, **CLS < 0.1**.

---

## 9. Data Konten: 12 Tahap (Sumber Kebenaran)

> **Aturan:** semua konten di bawah disimpan di `data/stages.json`, terpisah dari tampilan. Komponen hanya membaca data.
>
> ⚠️ **Teks Arab dan nomor hadis di bagian ini adalah referensi awal.** Sebelum publish, **verifikasi tiap ayat dan hadis** lewat sumber di Bagian 14, atau ambil teks Arab langsung dari sumber resmi saat build. Tandai tiap entri dengan `verified: false` sampai sudah dicek manusia.

### 9.1 Skema data (JSON)

```json
{
  "id": 3,
  "slug": "dunia",
  "labelId": "DUNIA",
  "labelAr": "الدُّنْيَا",
  "transliteration": "ad-dunyā",
  "mood": "senja",
  "headline": "Mati dan hidup diciptakan untuk menguji: siapa yang paling baik amalnya.",
  "showYouAreHere": true,
  "arabic": "لِيَبْلُوَكُمْ أَيُّكُمْ أَحْسَنُ عَمَلًا",
  "translation": "…",
  "sources": [
    { "type": "quran", "ref": "QS. Al-Mulk 67:2", "translationBy": "Kemenag", "verified": false }
  ],
  "explanation": ["paragraf 1", "paragraf 2"],
  "vocabulary": [
    { "ar": "الْبَرْزَخ", "latin": "al-barzakh", "meaning": "sekat/pemisah antara dua hal" }
  ],
  "scholarNotes": ["Ulama berbeda pendapat tentang …"],
  "practicalLessons": ["…"],
  "furtherReading": [
    { "type": "quran", "ref": "QS. Al-Qiyamah 75:36", "arabic": "…", "verified": false }
  ],
  "scene": "Scene03",
  "transitionIn": "birth-dawn",
  "transitionOut": "walk-to-horizon"
}
```

### 9.2 Isi 12 Tahap

Format tiap tahap: **Arab · Terjemah bebas · Sumber · Penjelasan · Catatan ulama · Pelajaran · Visual**. Terjemah dituliskan dengan bahasa bebas dan ringkas; untuk ayat Al-Qur'an gunakan **Terjemah Kemenag** saat tampil.

---

#### 🌠 Tahap 01 — SEBELUM LAHIR · الْمِيثَاق / عَالَمُ الأَرْوَاح

**Arab (QS. Al-A'raf 7:172, potongan):**
أَلَسْتُ بِرَبِّكُمْ ۖ قَالُوا بَلَىٰ ۛ شَهِدْنَا

**Kalimat inti:** *Sebelum lahir, anak cucu Adam ditanya: "Bukankah Aku ini Tuhanmu?" Mereka menjawab: "Betul, kami bersaksi."*

**Sumber:** QS. Al-A'raf 7:172; Tafsir Ibnu Katsir.

**Penjelasan:**
Ayat ini menceritakan peristiwa **al-mitsāq**, yaitu perjanjian dan kesaksian keturunan Adam bahwa Allah adalah Tuhan mereka. Pesannya sangat dalam: pengakuan kepada Tuhan bukan hal yang "baru dipelajari", tetapi sesuatu yang **menyatu dengan fitrah** manusia. Karena itu, di hari kiamat tidak ada yang bisa beralasan, *"Kami lengah, tidak tahu tentang ini."*

**Catatan ulama:**
Ulama berbeda pendapat tentang **bagaimana kejadiannya**. Sebagian memahami ayat ini sebagai peristiwa nyata ketika Allah mengambil kesaksian keturunan Adam. Sebagian lain memahaminya sebagai gambaran **fitrah dan bukti-bukti penciptaan** yang membuat manusia mengakui Tuhannya secara naluriah. Tampilkan catatan ini di layar (seperti pada video inspirasi): *"Bagaimana terjadinya, ulama berbeda pendapat."*

**Pelajaran praktis:** Rasa ingin mencari Tuhan dan makna hidup itu wajar dan alami. Rawat fitrah itu dengan ilmu dan ibadah.

**Visual:** Taburan ±200 titik bintang membentuk gumpalan awan galaksi. Titik berkerlip pelan dan bergerak sangat lambat. Garis tipis meliuk turun di tengah (awal jalur perjalanan).

---

#### 🤍 Tahap 02 — RAHIM · الرَّحِم

**Arab (QS. Az-Zumar 39:6, potongan):**
يَخْلُقُكُمْ فِي بُطُونِ أُمَّهَاتِكُمْ خَلْقًا مِّن بَعْدِ خَلْقٍ فِي ظُلُمَاتٍ ثَلَاثٍ

**Kalimat inti:** *Di perut ibu, kamu dibentuk kejadian demi kejadian, dalam tiga kegelapan.*

**Sumber:** QS. Az-Zumar 39:6. Bacaan lanjutan: QS. Al-Mu'minun 23:12–14.

**Penjelasan:**
Ayat ini menggambarkan penciptaan manusia **bertahap**: "kejadian demi kejadian". Tidak ada satu pun manusia yang memilih bagaimana ia dimulai: tubuhnya, orang tuanya, atau waktu lahirnya. Semua ia terima sebagai pemberian.

**Catatan ulama:** Para mufasir umumnya menafsirkan "tiga kegelapan" sebagai gelapnya **perut, rahim, dan selaput yang menyelubungi janin**. Ada penafsiran lain dengan rincian berbeda, sehingga cukup sebut *"menurut penafsiran yang masyhur"*.

**Pelajaran praktis:** Awal hidup adalah anugerah yang tidak kita bayar. Ini alasan untuk **bersyukur dan rendah hati**, serta berbakti kepada orang tua.

**Visual:** Layar marun gelap. Satu titik cahaya hangat di tengah dikelilingi cincin tipis yang **berdenyut pelan** seperti detak jantung (±1.2 detik per denyut). Titik progres ke-2 menyala.

---

#### 🧭 Tahap 03 — DUNIA · الدُّنْيَا  (📍 KAMU DI SINI)

**Arab (QS. Al-Mulk 67:2, potongan):**
لِيَبْلُوَكُمْ أَيُّكُمْ أَحْسَنُ عَمَلًا

**Kalimat inti:** *Mati dan hidup diciptakan untuk menguji: siapa yang paling baik amalnya.*

**Sumber:** QS. Al-Mulk 67:2.

**Penjelasan:**
Dunia adalah **satu-satunya tahap tempat amal bisa ditambah dan diperbaiki**. Perhatikan kata ayatnya: bukan "paling *banyak* amalnya", tetapi **"paling *baik* amalnya"**. Fudhail bin 'Iyadh, seorang ulama salaf, menjelaskan bahwa amal yang paling baik adalah yang **paling ikhlas** dan **paling benar** (sesuai tuntunan). Dua syarat ini dipakai ulama hingga sekarang sebagai penilai kualitas amal.

**Catatan ulama:** Penjelasan Fudhail bin 'Iyadh tersebut dinukil dalam banyak kitab tafsir. Cantumkan sebagai *"Penjelasan sebagian ulama salaf."*

**Pelajaran praktis:** Tanyakan pada diri sendiri: *Apakah amalku tulus? Apakah caranya benar?* Mulailah dari amal kecil yang konsisten.

**Visual:** Langit senja jingga ke biru malam, matahari rendah di horizon. **Siluet manusia** berdiri di tengah. Pin oranye "KAMU DI SINI" di atas kepala. Ini adalah **tahap yang paling terang dan paling hidup**, sengaja dibuat kontras dengan tahap-tahap lain.

---

#### 🕯️ Tahap 04 — KUBUR / BARZAKH · الْقَبْر / الْبَرْزَخ  (📍 KAMU DI SINI)

**Arab (QS. Al-Mu'minun 23:99–100, potongan):**
وَمِن وَرَائِهِم بَرْزَخٌ إِلَىٰ يَوْمِ يُبْعَثُونَ

**Arab (HR. Muslim 1631, ringkas — wajib verifikasi):**
إِذَا مَاتَ الْإِنْسَانُ انْقَطَعَ عَنْهُ عَمَلُهُ إِلَّا مِنْ ثَلَاثَةٍ: إِلَّا مِنْ صَدَقَةٍ جَارِيَةٍ، أَوْ عِلْمٍ يُنْتَفَعُ بِهِ، أَوْ وَلَدٍ صَالِحٍ يَدْعُو لَهُ

**Kalimat inti (layar 1):** *Alam barzakh, sampai hari dibangkitkan. Di sini kamu ditanya: siapa Tuhanmu, apa agamamu, siapa nabimu.*
**Kalimat inti (layar 2):** *Setelah mati, amal terputus, kecuali tiga: sedekah jariyah, ilmu yang bermanfaat, anak saleh yang mendoakannya.*

**Sumber:** QS. Al-Mu'minun 23:99–100; HR. Abu Dawud 4753 (pertanyaan di kubur; dinilai sahih oleh al-Albani); HR. Muslim 1631.

**Penjelasan:**
**Barzakh** artinya pembatas atau sekat, yaitu alam yang memisahkan kehidupan dunia dan hari kebangkitan. Orang yang sekarat sering digambarkan meminta kesempatan kedua (*"Ya Tuhanku, kembalikan aku"*), tetapi Al-Qur'an menjawab tegas **"Sekali-kali tidak!"**. Pintu amal sudah tertutup.

Ada tiga amal yang pahalanya terus mengalir meski pelakunya sudah wafat: **sedekah jariyah** (manfaatnya terus dipakai orang), **ilmu yang bermanfaat** (diajarkan, ditulis, diwariskan), dan **anak saleh yang mendoakan**.

**Catatan ulama:** Rincian keadaan di alam kubur adalah perkara **gaib** yang hanya diketahui dari dalil. Jangan menambah detail di luar dalil.

**Pelajaran praktis:** Mulai investasi "amal yang mengalir" dari sekarang: wakaf, berbagi ilmu (termasuk lewat karya seperti halaman ini), dan mendidik diri serta keluarga dengan baik.

**Visual:** Langit ungu gelap, siluet berdiri di atas garis horizon bertulis **BARZAKH**. Di bawah garis ada **kapsul gelap** berisi satu titik cahaya (kubur). Saat kalimat "amal terputus kecuali tiga" muncul, **tiga garis cahaya** melengkung naik dari kapsul menuju tiga titik di atas (sedekah, ilmu, doa anak), lalu muncul teks *"Dan tiga-tiganya dimulai di tahap 3"* dengan kata **tahap 3** berwarna oranye. Ini adalah momen kunci pesan halaman.

---

#### 🎺 Tahap 05 — SANGKAKALA · الصُّور

**Arab (QS. Az-Zumar 39:68, potongan):**
وَنُفِخَ فِي الصُّورِ فَصَعِقَ مَن فِي السَّمَاوَاتِ وَمَن فِي الْأَرْضِ إِلَّا مَن شَاءَ اللَّهُ ۖ ثُمَّ نُفِخَ فِيهِ أُخْرَىٰ فَإِذَا هُمْ قِيَامٌ يَنظُرُونَ

**Kalimat inti:** *Ditiup: semua mati, kecuali yang Allah kehendaki. Ditiup lagi: semua bangun.*

**Sumber:** QS. Az-Zumar 39:68.

**Penjelasan:**
**Ash-Shūr** adalah sangkakala yang ditiup oleh malaikat Israfil atas perintah Allah. Ayat ini menyebut **dua tiupan**: tiupan pertama mematikan seluruh makhluk, kecuali yang Allah kehendaki, dan tiupan kedua membangkitkan semuanya serentak.

**Catatan ulama:** Sebagian ulama merinci **tiga tiupan** (kejut, mati, bangkit) berdasarkan hadis-hadis lain, sedangkan sebagian lain memahami **dua tiupan**. Tampilkan perbedaan ini sebagai catatan, jangan memaksakan satu pendapat.

**Pelajaran praktis:** Kiamat datang tiba-tiba. Menunda taubat dan amal berarti mempertaruhkan kesempatan yang tidak pasti.

**Visual:** Layar hampir hitam dengan ±150 titik emas redup tersebar. **Satu cincin gelombang suara** menyebar dari tengah, titik-titik meredup satu per satu lalu hening. Setelah jeda, cincin kedua menyebar dan titik-titik **menyala kembali**.

---

#### ☀️ Tahap 06 — PADANG MAHSYAR · الْمَحْشَر

**Arab (potongan dari hadis):**
فِي صَعِيدٍ وَاحِدٍ

**Kalimat inti:** *Semua manusia, dari yang pertama sampai yang terakhir, di satu tanah lapang. Matahari didekatkan.*

**Sumber:** HR. Bukhari 4712; HR. Muslim 2864.

**Penjelasan:**
Seluruh manusia dikumpulkan di **satu hamparan tanah lapang**. Hadis menyebut matahari didekatkan kepada manusia sehingga mereka bergantung pada amal masing-masing: ada yang tenggelam dalam keringat sesuai amalnya. Gambaran ini menanamkan kesadaran akan **beratnya hari itu** dan bahwa tidak ada yang bisa bersembunyi.

**Catatan ulama:** Detail jarak matahari dan keringat dibahas ulama dalam syarah hadis. Tampilkan hanya yang tertulis dalam hadis.

**Bacaan lanjutan (naungan):** Hadis tentang **tujuh golongan yang dinaungi Allah** pada hari tidak ada naungan selain naungan-Nya (HR. Bukhari 660; HR. Muslim 1031). *Verifikasi nomor sebelum tampil.*

**Pelajaran praktis:** Amal sosial seperti sedekah diam-diam, menjaga lisan, dan keadilan sering menjadi "naungan" di hari itu.

**Visual:** Cakrawala jingga dengan matahari besar. Ratusan titik cahaya menyebar di dataran bawah, bergerak pelan seperti kerumunan. Matahari **turun perlahan** selama animasi. Efek panas (heat shimmer halus) di atas dataran.

---

#### 🤲 Tahap 07 — SYAFAAT · الشَّفَاعَة

**Arab (potongan dari hadis):**
وَاشْفَعْ تُشَفَّعْ

**Arab (QS. Al-Baqarah 2:255, potongan):**
مَن ذَا الَّذِي يَشْفَعُ عِندَهُ إِلَّا بِإِذْنِهِ

**Kalimat inti:** *Nabi demi nabi berkata: "Diriku, diriku." Sampai Nabi Muhammad ﷺ diizinkan memberi syafaat.*

**Sumber:** HR. Bukhari 3340, 4712; QS. Al-Baqarah 2:255.

**Penjelasan:**
Manusia yang kewalahan di mahsyar mendatangi para nabi untuk meminta syafaat (pertolongan agar segera dihisab). Satu per satu: **Adam, Nuh, Ibrahim, Musa, dan Isa** 'alaihimussalam menyatakan sedang sibuk dengan urusan dirinya. Barulah **Nabi Muhammad ﷺ** bersujud kepada Allah dan diizinkan memberi syafaat.

Ayat Kursi menegaskan prinsip pentingnya: **tidak ada yang bisa memberi syafaat kecuali dengan izin Allah**. Syafaat bukan jalan pintas yang membebaskan dari kewajiban beramal, melainkan rahmat Allah bagi siapa yang Dia kehendaki.

**Catatan ulama:** Syafaat memiliki beberapa jenis (syafaat 'uzhma di mahsyar, syafaat bagi penghuni surga, syafaat bagi sebagian ahli tauhid, dan lainnya). Tulis sebagai catatan singkat.

**Pelajaran praktis:** Perbanyak shalawat dan mengikuti sunnahnya sebagai bentuk cinta, tanpa bersandar semata pada syafaat dan meninggalkan amal.

**Visual:** Dataran titik cahaya, di atasnya muncul **teks nama nabi secara berurutan** (ADAM → NUH → IBRAHIM → MUSA → ISA), tiap nama menyala redup lalu padam. Terakhir muncul **cahaya emas lembut** (tanpa wajah, tanpa gambar) disertai teks "NABI MUHAMMAD ﷺ". **Dilarang menggambar rupa para nabi.**

---

#### ⚖️ Tahap 08 — CATATAN & TIMBANGAN · الْكِتَاب وَالْمِيزَان

**Arab (QS. Al-Anbiya' 21:47, potongan):**
وَإِن كَانَ مِثْقَالَ حَبَّةٍ مِّنْ خَرْدَلٍ أَتَيْنَا بِهَا ۗ وَكَفَىٰ بِنَا حَاسِبِينَ

**Arab (QS. Az-Zalzalah 99:7–8):**
فَمَن يَعْمَلْ مِثْقَالَ ذَرَّةٍ خَيْرًا يَرَهُ ۝ وَمَن يَعْمَلْ مِثْقَالَ ذَرَّةٍ شَرًّا يَرَهُ

**Kalimat inti:** *Catatan amal diterima di tangan kanan, atau di tangan kiri. Seberat biji sawi pun ditimbang.*

**Sumber:** QS. Al-Haqqah 69:19, 25; QS. Al-Anbiya' 21:47; bacaan lanjutan QS. Az-Zalzalah 99:7–8.

**Penjelasan:**
Setiap manusia menerima **kitab catatan amalnya**: yang menerima di tangan kanan bergembira dan mengajak orang lain membaca; yang menerima di tangan kiri menyesal. Lalu amal **ditimbang dengan adil** di **al-mīzān**. Al-Qur'an menegaskan bahwa **sekecil biji sawi pun akan didatangkan**, dan cukuplah Allah sebagai Penghisab.

**Catatan ulama:** Ulama berbeda dalam rincian urutan hisab, penimbangan, dan pembagian kitab. Karena itu, penyajian urutan di halaman ini adalah **kerangka umum**.

**Pelajaran praktis:** Tidak ada kebaikan yang terlalu kecil untuk dilakukan, dan tidak ada keburukan yang terlalu kecil untuk dihindari.

**Visual:** Cahaya matahari keemasan. Dari tengah tumbuh **tiang dan timbangan** (garis tipis bercahaya). Dua pinggan menggantung dan **bergoyang lalu stabil** saat teks muncul. Partikel kecil jatuh ke pinggan satu per satu seperti butir-butir amal.

---

#### 💧 Tahap 09 — TELAGA · الْحَوْض

**Arab (potongan hadis; wajib verifikasi):**
مَنْ شَرِبَ مِنْهَا فَلَا يَظْمَأُ أَبَدًا

**Arab (QS. Al-Kautsar 108:1):**
إِنَّا أَعْطَيْنَاكَ الْكَوْثَرَ

**Kalimat inti:** *Airnya lebih putih dari susu. Yang minum, nggak akan haus lagi.*

**Sumber:** HR. Bukhari 6579; rujukan syarah: Fathul Bari 11/466.

**Penjelasan:**
**Al-Hawdh** adalah telaga milik Nabi Muhammad ﷺ yang akan didatangi umatnya. Hadis menggambarkan airnya **lebih putih dari susu**, dan siapa yang minum darinya **tidak akan haus selamanya**. Telaga ini menjadi pelepas dahaga bagi mereka yang kepanasan di mahsyar.

**Catatan ulama:** Para ulama berbeda pendapat apakah telaga berada **sebelum atau sesudah shirath** (lihat pembahasan Ibnu Hajar dalam *Fathul Bari*). Tampilkan catatan ini: *"Sebelum atau sesudah shirath? Ulama berbeda pendapat."*

**Pelajaran praktis:** Mengikuti sunnah dan menjaga persatuan umat adalah bekal agar kelak dapat mendatangi telaga itu, bukan malah terusir darinya.

**Visual:** Dataran biru pucat. Dari bawah **menyapu hamparan putih susu berbentuk elips** (telaga), partikel berkilau seperti butir embun di permukaannya. Suasana paling sejuk dan lega dari semua tahap.

---

#### 🌗 Tahap 10 — PEMISAHAN · التَّمْيِيز

**Arab (potongan hadis; wajib verifikasi):**
مَنْ كَانَ يَعْبُدُ شَيْئًا فَلْيَتَّبِعْهُ

**Arab (QS. Yasin 36:59):**
وَامْتَازُوا الْيَوْمَ أَيُّهَا الْمُجْرِمُونَ

**Kalimat inti:** *Tiap orang mengikuti yang dulu disembahnya. Yang beriman bersujud; yang dulu sujud karena riya, nggak bisa.*

**Sumber:** HR. Bukhari 6573, 4919; bacaan lanjutan QS. Yasin 36:59.

**Penjelasan:**
Pada tahap ini manusia **dipisahkan**: siapa yang menyembah sesuatu akan mengikuti sesembahannya. Hadis juga menggambarkan ujian sujud: orang beriman bisa bersujud kepada Allah, sedangkan orang yang dulu bersujud **karena riya** (ingin dilihat orang) punggungnya **kaku** sehingga tidak bisa sujud. Ini peringatan keras tentang **keikhlasan**.

**Catatan ulama:** Rincian peristiwa (urutan siapa mengikuti apa) ada dalam hadis panjang riwayat Bukhari dan Muslim. Ringkasan di halaman ini hanya intinya.

**Pelajaran praktis:** Periksa niat sebelum dan sesudah beramal. Amal yang tampak besar bisa tak bernilai bila niatnya salah arah.

**Visual:** Langit biru dongker. Titik cahaya yang tadinya bergerombol **terbelah ke dua arah** (kiri dan kanan) dengan jeda hening. Beberapa titik di satu sisi **redup dan kaku** (tidak mengikuti gerak), sementara yang lain bergerak lancar.

---

#### 🌉 Tahap 11 — SHIRATH · الصِّرَاط

**Arab (doa para rasul, HR. Bukhari 6573; wajib verifikasi):**
اللَّهُمَّ سَلِّمْ سَلِّمْ

**Arab (QS. Maryam 19:71, potongan):**
وَإِن مِّنكُمْ إِلَّا وَارِدُهَا ۚ كَانَ عَلَىٰ رَبِّكَ حَتْمًا مَّقْضِيًّا

**Kalimat inti:** *Jembatan di atas neraka. Ada yang selamat, ada yang tersambar. Yang bertauhid, kelak dikeluarkan.* — *Doa para rasul hari itu: "Ya Allah, selamatkan, selamatkan."*

**Sumber:** HR. Bukhari 6573; QS. Maryam 19:71–72.

**Penjelasan:**
**Ash-Shirāth** adalah jembatan yang dibentangkan di atas neraka. Manusia melewatinya sesuai amalnya: ada yang secepat kilat, ada yang berjalan, merangkak, dan ada yang **tersambar dan jatuh**. Pada saat itu para rasul pun berdoa, *"Ya Allah, selamatkan, selamatkan."* Hadis juga menyebut bahwa orang yang di akhir **bertauhid** akhirnya **dikeluarkan** dari neraka dengan izin Allah.

**Catatan ulama:** Penafsiran QS. Maryam 19:71 (*wāriduhā*, "mendatanginya") berbeda: sebagian memahami **melewati shirath**, sebagian memahami cakupan lain. Tulis singkat sebagai catatan.

**Pelajaran praktis:** Perbanyak doa keselamatan, perbanyak amal yang menjadi "cahaya" (lihat QS. Al-Hadid 57:12), dan jangan merasa aman dari azab.

**Visual:** Dasar merah gelap. **Satu garis tipis bercahaya** memanjang di atasnya sebagai jembatan. Titik-titik kecil berjalan di atas jembatan dengan kecepatan berbeda-beda; satu-dua titik jatuh ke bawah dan meredup. **Tanpa gambar api sadis atau sosok yang tersiksa.** Cukup suasana warna dan garis.

---

#### 🌅 Tahap 12 — QANTHARAH & SURGA · الْقَنْطَرَة وَالْجَنَّة

**Arab (QS. Ali 'Imran 3:185, potongan):**
فَمَن زُحْزِحَ عَنِ النَّارِ وَأُدْخِلَ الْجَنَّةَ فَقَدْ فَازَ

**Arab (QS. Al-Hijr 15:47, potongan):**
وَنَزَعْنَا مَا فِي صُدُورِهِم مِّنْ غِلٍّ

**Kalimat inti:** *Orang beriman menuntaskan kezaliman di antara mereka. Setelah bersih, baru masuk surga.* — *"Siapa yang dijauhkan dari neraka dan dimasukkan ke dalam surga, sungguh dia memperoleh kemenangan."*

**Sumber:** HR. Bukhari 6535; QS. Ali 'Imran 3:185; bacaan lanjutan QS. Al-Hijr 15:47.

**Penjelasan:**
Setelah selamat dari shirath, orang-orang beriman **ditahan di sebuah jembatan (qantharah)** antara surga dan neraka. Di sana **hak-hak antar sesama dibereskan**: kezaliman yang pernah terjadi di dunia diselesaikan. Setelah bersih, mereka dipersilakan masuk surga. Al-Qur'an menyebut Allah **mencabut rasa dendam** dari hati mereka.

Ayat 3:185 menutup perjalanan ini dengan pernyataan tentang **kemenangan sejati**: dijauhkan dari neraka dan dimasukkan ke surga.

**Catatan ulama:** Ulama menjelaskan qantharah sebagai salah satu tahapan setelah melewati shirath. Penjelasan detail dapat dilihat dalam *Fathul Bari* (syarah Bukhari 6535).

**Pelajaran praktis:** **Selesaikan hak orang lain sekarang**: minta maaf, lunasi utang, jaga lisan. Lebih mudah beres di dunia daripada di akhirat.

**Visual:** Jembatan dari tahap 11 **melengkung naik menjadi gerbang cahaya**. Warna berubah dari merah gelap ke emas hangat. Di akhir, gerbang terbuka dan **cahaya fajar membanjiri layar** secara lembut, lalu berlanjut ke Layar Penutup.

---

## 10. Layar Penutup (End Screen)

### Tujuan
Mengubah perenungan menjadi **tindakan nyata**. Inilah inti pesan halaman ini: dari 12 tahap, **yang masih bisa kita ubah hanyalah tahap Dunia**.

### Isi

1. **Animasi:** kamera turun dari cahaya surga kembali ke horizon senja dan siluet manusia tahap 3, pin **KAMU DI SINI** muncul lagi.
2. **Kalimat penutup (tulis versi sendiri, jangan menyalin video):** Contoh pilihan,
   - *"Dari dua belas tahap, hanya satu yang masih terbuka untuk kamu perbaiki. Dan kamu sedang berada di sana."*
   - *"Semua tahap berikutnya sudah ada ketetapannya. Hari ini adalah satu-satunya kesempatan menambah bekal."*
3. **Ringkasan 12 tahap** dalam satu baris peta (12 titik + nama singkat), bisa diklik untuk kembali ke tahap tertentu.
4. **Checklist "Bekal dari Tahap 3"**, tiga hal yang bisa dilakukan hari ini (centang interaktif):
   - ☐ Satu amal kecil yang tulus hari ini (sedekah, membantu, shalat tepat waktu).
   - ☐ Satu ilmu yang dibagikan atau dipelajari.
   - ☐ Satu hak orang lain yang diselesaikan (minta maaf, lunasi utang, kembalikan barang).
5. **Tombol aksi:** `Ulangi Perjalanan` · `Uji Pemahaman (Kuis)` · `Bagikan` · `Kembali ke Beranda`.
6. **Doa penutup (opsional):** teks Arab dan terjemah doa yang sudah diverifikasi (mis. doa keselamatan).

---

## 11. Fitur Edukasi Tambahan

### 11.1 Kamus Istilah (Glosarium)
Daftar istilah dengan tulisan Arab, transliterasi, arti, dan tahap terkait. Tampil sebagai tooltip saat istilah disentuh dan sebagai halaman daftar terpisah.

| Istilah | Arab | Arti singkat | Tahap |
|---------|------|--------------|-------|
| Mitsaq | الْمِيثَاق | Perjanjian/kesaksian | 01 |
| Fitrah | الْفِطْرَة | Naluri/kecenderungan asal untuk mengenal Tuhan | 01 |
| Barzakh | الْبَرْزَخ | Sekat antara dunia dan akhirat | 04 |
| Shur | الصُّور | Sangkakala | 05 |
| Mahsyar | الْمَحْشَر | Tempat berkumpulnya manusia | 06 |
| Syafaat | الشَّفَاعَة | Pertolongan/permohonan untuk orang lain | 07 |
| Mizan | الْمِيزَان | Timbangan amal | 08 |
| Hawdh | الْحَوْض | Telaga | 09 |
| Shirath | الصِّرَاط | Jembatan/jalan | 11 |
| Qantharah | الْقَنْطَرَة | Jembatan/lengkungan tempat penyelesaian hak | 12 |

### 11.2 Kuis Pemahaman
12 soal pilihan ganda (1 soal per tahap) di `data/quiz.json`. Setiap soal berisi pertanyaan, 4 pilihan, jawaban benar, **penjelasan singkat**, dan tautan ke tahap terkait. Setelah selesai tampilkan skor dan rekomendasi tahap yang perlu dibaca ulang. Nada: **mendidik, bukan menghakimi.**

### 11.3 Mode Teks Arab
- Toggle **ukuran teks Arab** (S/M/L).
- Toggle **tampilkan/sembunyikan terjemah**.
- Tombol **salin** ayat (menyalin Arab + terjemah + sumber).

### 11.4 Berbagi
Bagikan satu tahap sebagai **kartu gambar** (Arab + kalimat inti + sumber + nama situs). Kartu dirender dari data, bukan tangkapan layar. Sertakan tautan langsung dengan hash `#tahap-04`.

### 11.5 Audio (opsional, default mati)
- Ambient suara lembut (angin/denging halus) dengan toggle.
- **Murottal hanya jika memiliki izin/lisensi** atau memakai rekaman yang jelas boleh dipakai. Jangan memasang audio yang tidak jelas haknya.
- Audio tidak boleh autoplay. Hormati preferensi pengguna dan beri tombol jeda yang jelas.

---

## 12. Aksesibilitas

- Seluruh navigasi bisa dilakukan dengan **keyboard**: `←/→` atau `↑/↓` pindah tahap, `Esc` menutup panel, `Tab` menelusuri kontrol, `Enter/Space` mengaktifkan.
- Tiap tahap diumumkan ke screen reader lewat `aria-live="polite"`: *"Tahap 3 dari 12: Dunia."*
- Kontras teks minimal **WCAG AA** di atas latar gradien (tambahkan overlay gelap tipis di belakang teks bila perlu).
- Teks Arab: `lang="ar"` `dir="rtl"`; terjemah: `lang="id"`.
- Ilustrasi dekoratif diberi `aria-hidden="true"`; ilustrasi bermakna diberi `role="img"` + `aria-label`.
- Semua animasi bisa **dijeda**; hormati `prefers-reduced-motion`.
- Area sentuh minimal 44×44 px.
- Hindari kilatan cepat (maks 3 kali per detik) untuk keamanan penderita fotosensitif. Efek "cahaya surga" harus **pelan**.

---

## 13. Responsif & Perangkat

| Lebar | Perilaku |
|-------|----------|
| ≤ 480 px (HP) | Satu kolom, teks tengah, ilustrasi ±40% tinggi layar, bottom-sheet untuk panel; partikel dikurangi |
| 481–1024 px (tablet) | Satu kolom lebih lebar, panel samping bisa tampil sebagian |
| ≥ 1025 px (desktop) | Layout tengah dengan lebar teks maksimum ±640 px; panel "Pelajari lebih dalam" di samping kanan |

- Gunakan `100dvh` (bukan `100vh`) agar tidak terpotong bar browser di HP.
- Dukungan swipe vertikal di HP; scroll-snap untuk Mode Baca.
- Uji di Chrome, Safari iOS, dan Firefox.

---

## 14. Adab, Akurasi & Sumber (WAJIB DIBACA)

Karena kontennya keagamaan, kualitas dan kehati-hatian lebih penting daripada tampilan.

### 14.1 Aturan konten

1. **Setiap klaim harus punya sumber** (ayat atau hadis lengkap dengan nomor/riwayat).
2. **Bedakan jelas** antara: (a) teks dalil, (b) terjemah, (c) penjelasan/penafsiran. Gunakan gaya visual berbeda.
3. **Tandai perbedaan pendapat ulama** dengan label konsisten (ikon kecil + teks "Ulama berbeda pendapat"), jangan menyembunyikannya.
4. **Jangan menambah detail gaib** yang tidak ada dalilnya. Jika tidak yakin, hapus.
5. **Struktur "12 tahap" adalah kerangka penyajian**, bukan klasifikasi baku. Cantumkan catatan ini di halaman *Tentang* atau footer.
6. **Gunakan penghormatan** yang pantas: ﷺ setelah nama Nabi Muhammad, 'alaihissalam setelah nama nabi lain, dan penyebutan nama Allah dengan adab.
7. Nada narasi: **mengajak dan menenangkan**, bukan menakut-nakuti.
8. Sediakan **disclaimer** (lihat 14.4).

### 14.2 Verifikasi teks Arab & hadis

- **Jangan mengarang atau menghasilkan teks Arab dengan AI tanpa verifikasi.** Salah satu huruf atau harakat bisa mengubah makna.
- Ambil/cek teks Al-Qur'an dari **mushaf digital resmi** (mis. Quran.com, Kemenag, atau Tanzil) dan terjemahnya dari **Terjemah Kemenag**.
- Cek hadis (teks, nomor, derajat) di sumber hadis tepercaya seperti Sunnah.com, aplikasi/portal hadis resmi, atau kitab induk dan syarahnya (*Fathul Bari* untuk Bukhari, *Syarah Shahih Muslim* oleh an-Nawawi).
- Di dokumen ini, **nomor hadis dan potongan Arab hadis diambil sebagai acuan awal** dan harus dicocokkan ulang. Beri `verified: false` di JSON hingga sudah dicek, lalu ubah ke `true` setelah divalidasi manusia.
- Bila memungkinkan, **minta peninjauan** guru agama/ustaz sebelum publikasi dan cantumkan "Telah ditinjau oleh …" bila disetujui.

### 14.3 Rujukan yang disarankan

- Al-Qur'an dan terjemah: Quran.com / Kemenag / Tanzil.
- Hadis: Sunnah.com, kitab Shahih Bukhari, Shahih Muslim, Sunan Abu Dawud.
- Tafsir: Tafsir Ibnu Katsir, Tafsir Kemenag.
- Syarah: *Fathul Bari* (Ibnu Hajar al-'Asqalani) untuk Bukhari.

### 14.4 Teks disclaimer (tampilkan di footer/halaman Tentang)

> Halaman ini adalah media edukasi ringkas dan **bukan pengganti belajar langsung kepada guru/ustaz yang berilmu**. Urutan 12 tahap adalah kerangka penyajian untuk memudahkan pemahaman. Rincian peristiwa akhirat dan perbedaan pendapat ulama dibahas lebih lengkap dalam kitab-kitab rujukan. Jika menemukan kekeliruan, silakan hubungi pembuat halaman ini.

---

## 15. Rencana Pengerjaan (Milestone)

| Fase | Pekerjaan | Hasil |
|------|-----------|-------|
| **0. Audit** | Pelajari proyek yang ada (stack, routing, navbar, gaya) | Catatan integrasi singkat |
| **1. Kerangka** | Route baru, tombol navbar, `JourneyShell`, `ProgressTrail`, data `stages.json` (placeholder) | Halaman bisa dibuka dari navbar dan berpindah antar tahap tanpa animasi |
| **2. Konten** | Isi 12 tahap dari Bagian 9, `ArabicBlock`, `DeepDivePanel`, Mode Baca | Semua teks, Arab, dan sumber tampil benar |
| **3. Visual** | Palet per alam, 12 scene SVG/Canvas statis | Setiap tahap punya suasana visual |
| **4. Animasi** | `TransitionLayer`, 12 transisi (Bagian 8.3), animasi mikro, reduced motion | Perpindahan antar alam sinematik dan halus |
| **5. Edukasi** | Glosarium, kuis, checklist akhir, end screen, kartu berbagi | Pengalaman belajar lengkap |
| **6. Poles** | Aksesibilitas, responsif, performa, QA lintas browser | Lulus checklist Bagian 16 |
| **7. Verifikasi konten** | Cek ulang semua ayat/hadis, ubah `verified: true`, minta tinjauan | Siap publikasi |
| **8. Portofolio** | Tulis case study (Bagian 18), tangkapan layar/GIF | Tampil di portofolio |

---

## 16. Kriteria Penerimaan (Acceptance Checklist)

### Fungsional
- [ ] Tombol **"Perjalanan 12 Tahap"** muncul di navbar (desktop dan mobile) dan membuka halaman baru.
- [ ] Item navbar punya state aktif dan bisa kembali ke beranda.
- [ ] Halaman tidak merusak halaman atau gaya lain pada website induk.
- [ ] 12 tahap tampil lengkap: label, Arab, kalimat inti, sumber, dan panel "Pelajari lebih dalam".
- [ ] Bar progres 12 titik + penghitung `NN / 12` + pin "KAMU DI SINI" berfungsi.
- [ ] Navigasi bekerja lewat scroll, swipe, tombol, dan keyboard.
- [ ] Tombol Back browser berfungsi dan hash `#tahap-NN` bisa dibagikan.
- [ ] Mode Sinematik dan Mode Baca bisa dialihkan.
- [ ] Layar penutup, glosarium, kuis, dan checklist berfungsi.

### Konten
- [ ] Semua ayat/hadis punya sumber, dan semua entri `verified: true` sebelum publikasi.
- [ ] Perbedaan pendapat ulama ditandai di tahap 01, 02, 05, 08, 09, 11 (minimal).
- [ ] Tidak ada gambar rupa Nabi/malaikat, tidak ada gambar sadis.
- [ ] Narasi ditulis ulang dengan bahasa sendiri, atribusi inspirasi tampil di footer.
- [ ] Disclaimer tampil.

### Animasi & performa
- [ ] 12 transisi antar alam berjalan halus (≥ 55 fps di perangkat menengah).
- [ ] `prefers-reduced-motion` menonaktifkan animasi besar dan memakai crossfade.
- [ ] Animasi berhenti saat tab tidak aktif.
- [ ] LCP < 2.5 s, CLS < 0.1; aset halaman ini dimuat lazy.

### Aksesibilitas & responsif
- [ ] Bisa dioperasikan penuh dengan keyboard; fokus terlihat.
- [ ] Kontras teks AA; Arab menggunakan `lang="ar" dir="rtl"`.
- [ ] Tampilan nyaman di 360 px sampai layar desktop lebar.

---

## 17. Daftar Teks UI (Microcopy)

| Elemen | Teks |
|--------|------|
| Tombol navbar | Perjalanan 12 Tahap |
| Judul intro | Perjalananmu ada 12 tahap. |
| Subjudul intro | Satu tahap masih bisa kamu ubah. Yuk, lihat di mana posisimu. |
| Tombol mulai | Mulai Perjalanan |
| Tombol lanjutkan | Lanjutkan dari tahap NN |
| Penanda posisi | KAMU DI SINI |
| Tombol panel | Pelajari lebih dalam |
| Label catatan ulama | Ulama berbeda pendapat |
| Tombol navigasi | ‹ Mundur · Lanjut › |
| Toggle mode | Mode Sinematik ⇄ Mode Baca |
| Layar penutup (judul) | Kamu masih di tahap 3. |
| Tombol akhir | Ulangi · Uji Pemahaman · Bagikan · Kembali ke Beranda |
| Footer atribusi | Terinspirasi dari konsep peta perjalanan 12 tahap oleh @pendar.quran |

---

## 18. Bahan Case Study Portofolio

> Tempel di bagian portofolio, sesuaikan dengan hasil akhir.

**Judul:** Perjalanan 12 Tahap — Edukasi Interaktif Bergaya Sinematik

**Masalah:** Konten keagamaan sering disajikan dalam teks panjang yang sulit diikuti anak muda, atau dalam video pendek yang cepat berlalu dan tidak bisa dijelajahi.

**Solusi:** Halaman web interaktif yang memetakan 12 tahap perjalanan manusia dalam metafora *peta perjalanan*, dengan animasi transisi antar alam, teks Arab bilingual, dalil bersumber, dan penjelasan berlapis (ringkas di layar, mendalam di panel).

**Peran:** Perancangan UX, desain visual, animasi web, penulisan konten bersumber, aksesibilitas.

**Tantangan & keputusan desain:**
- Menjaga **adab dan akurasi**: sistem data dengan penanda `verified`, label perbedaan pendapat, dan larangan visual tertentu.
- Menyajikan **teks Arab RTL** berdampingan dengan Latin tanpa merusak layout atau harakat.
- Membuat animasi **sinematik tetapi ringan** (partikel terbatas, pause saat tab tidak aktif, fallback reduced motion).
- Mengintegrasikan halaman ke situs yang sudah ada lewat **tombol navbar** tanpa mengganggu halaman lain.

**Teknologi:** (isi sesuai stack akhir: mis. framework, GSAP/Framer Motion, SVG, Canvas).

**Hasil:** (isi dengan metrik nyata setelah selesai: skor Lighthouse, jumlah tahap, jumlah soal kuis, dll.)

---

## 19. Prompt Cepat untuk Antigravity (salin-tempel)

**Prompt 1 — Audit & kerangka**
> Baca seluruh proyek ini dan jelaskan stack, sistem routing, dan komponen navbar-nya. Lalu tambahkan route baru `/perjalanan-12-tahap` dan satu tombol "Perjalanan 12 Tahap" di navbar (desktop dan mobile) yang membuka halaman itu. Buat kerangka `JourneyShell` dengan bar progres 12 titik dan navigasi tahap (scroll, tombol, keyboard). Jangan ubah halaman lain. Ikuti README bagian 5, 6, dan 16.

**Prompt 2 — Konten**
> Buat `data/stages.json` berisi 12 tahap sesuai README bagian 9 (skema 9.1). Buat komponen `ArabicBlock` (RTL, font Amiri/Naskh), `DeepDivePanel`, dan Mode Baca. Tampilkan Arab, terjemah, sumber, dan catatan ulama. Jangan mengarang teks Arab: gunakan yang ada di README dan beri `verified: false`.

**Prompt 3 — Visual & animasi**
> Buat 12 scene SVG/Canvas bergaya langit malam/senja minimalis sesuai palet README bagian 7.2 dan visual per tahap di bagian 9. Implementasikan `TransitionLayer` dengan 12 transisi sesuai tabel README 8.3, animasi mikro 8.4, aturan performa 8.5, dan fallback `prefers-reduced-motion`.

**Prompt 4 — Edukasi & poles**
> Tambahkan glosarium, kuis 12 soal, layar penutup dengan checklist "Bekal dari Tahap 3", kartu berbagi, aksesibilitas (README bagian 12), responsif (bagian 13), dan jalankan checklist bagian 16. Laporkan yang belum selesai.

---

## 20. Catatan Akhir

Tujuan halaman ini bukan sekadar tampil keren, tetapi **membantu orang merenung dan beramal**. Jika harus memilih antara animasi yang spektakuler dan konten yang akurat serta beradab, **pilih akurasi dan adab**. Kualitas itulah yang membuat sebuah karya portofolio benar-benar berkesan.

*Semoga bermanfaat.* 🌙
