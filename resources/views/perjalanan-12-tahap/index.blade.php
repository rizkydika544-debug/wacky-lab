<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="Perjalanan 12 Tahap — Edukasi interaktif dan sinematik menyusuri 12 tahap perjalanan manusia dari sebelum lahir hingga surga menurut Al-Qur'an dan hadis.">
    <meta name="theme-color" content="#070b24">

    <title>Perjalanan 12 Tahap — Edukasi Perjalanan Manusia Menurut Al-Qur'an & Hadis</title>

    <!-- Google Fonts: Amiri (Arabic) & Plus Jakarta Sans (Latin) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/journey.css', 'resources/js/journey.js'])

    <script>
        window.JOURNEY_STAGES = @json($stages);
        window.JOURNEY_GLOSSARY = @json($glossary);
        window.JOURNEY_QUIZ = @json($quiz);
    </script>
</head>

<body class="journey-body select-none">
    <!-- Dynamic Atmospheric Background & Star Canvas -->
    <div class="journey-bg"></div>
    <canvas id="journey-canvas"></canvas>

    <!-- Main App Container -->
    <div id="journey-container" class="relative z-10 flex flex-col min-h-dvh">

        <!-- Top Navigation Header -->
        <header class="sticky top-0 z-40 bg-slate-950/70 backdrop-blur-md border-b border-white/10 px-4 py-3">
            <div class="max-w-6xl mx-auto flex items-center justify-between gap-3">
                <!-- Left: Back to Home & Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="text-xs font-bold text-slate-300 hover:text-white flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 transition-colors no-underline">
                        <span>‹</span>
                        <span class="hidden sm:inline">Beranda Wacky Lab</span>
                        <span class="sm:hidden">Beranda</span>
                    </a>
                    <div class="hidden md:flex items-center gap-2 text-xs font-extrabold tracking-wider text-amber-400">
                        <span>🌌</span>
                        <span>PERJALANAN 12 TAHAP</span>
                    </div>
                </div>

                <!-- Center: 12-dot Progress Trail + Counter (Cinematic Mode) -->
                <div class="flex items-center gap-3">
                    <div class="progress-trail" title="Lompat ke tahap tertentu">
                        @foreach ($stages as $index => $s)
                            <button class="trail-dot {{ $index === 0 ? 'active' : '' }}" data-stage="{{ $index }}" aria-label="Tahap {{ $s['id'] }}: {{ $s['labelId'] }}"></button>
                        @endforeach
                    </div>
                    <span id="stage-counter" class="text-xs font-mono font-bold text-slate-300 min-w-[50px] text-center">
                        01 / 12
                    </span>
                </div>

                <!-- Right: Action Controls -->
                <div class="flex items-center gap-1.5">
                    <button id="toggle-sound-btn" class="p-2 sm:px-3 sm:py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-xs font-bold text-slate-200 transition-colors" title="Nyalakan suara hening" aria-pressed="false">
                        <span class="hidden sm:inline">🔇 Suara: OFF</span>
                        <span class="sm:hidden">🔇</span>
                    </button>
                    <button id="toggle-arabic-size" class="p-2 sm:px-2.5 sm:py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-xs font-bold text-slate-200 transition-colors" title="Ubah ukuran teks Arab">
                        Aa
                    </button>
                    <button id="open-glossary-btn" class="p-2 sm:px-2.5 sm:py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-xs font-bold text-slate-200 transition-colors" title="Buka Glosarium Istilah">
                        📖
                    </button>
                    <button id="open-quiz-btn" class="p-2 sm:px-2.5 sm:py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 text-xs font-bold text-amber-300 transition-colors" title="Uji Pemahaman (Kuis 12 Soal)">
                        ✍️
                    </button>
                    <button id="toggle-mode-btn" class="px-3 py-1.5 rounded-xl border border-amber-500/40 bg-amber-500/10 hover:bg-amber-500/20 text-amber-300 text-xs font-extrabold transition-colors">
                        📖 Mode Baca
                    </button>
                </div>
            </div>
        </header>

        <!-- 1. INTRO SCREEN -->
        <section id="journey-intro" class="flex-1 flex flex-col items-center justify-center text-center px-4 py-12 max-w-2xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full border border-amber-400/30 bg-amber-400/10 text-amber-300 text-xs font-bold tracking-widest uppercase mb-6 animate-pulse">
                <span>🌙</span> Peta Perjalanan Jiwa Manusia
            </div>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Perjalananmu ada 12 tahap.
            </h1>

            <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8 max-w-xl">
                Dari sebelum lahir hingga menuju keabadian. Dari seluruh dua belas tahap itu, <strong>hanya satu tahap yang masih bisa kamu ubah</strong>. Yuk, lihat di mana posisimu sekarang.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <button id="start-journey-btn" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 font-black text-sm tracking-wide shadow-lg shadow-orange-500/25 hover:scale-105 active:scale-95 transition-all">
                    Mulai Perjalanan ›
                </button>
                <button id="resume-journey-btn" class="hidden w-full sm:w-auto px-6 py-3.5 rounded-2xl border border-white/20 bg-white/5 hover:bg-white/10 text-white font-bold text-sm transition-colors">
                    Lanjutkan Progres
                </button>
            </div>

            <div class="mt-12 flex flex-wrap justify-center items-center gap-4 text-xs text-slate-400">
                <span class="flex items-center gap-1.5"><span>📜</span> Bersumber Al-Qur'an & Hadis</span>
                <span class="flex items-center gap-1.5"><span>⚖️</span> Catatan Perbedaan Ulama</span>
                <span class="flex items-center gap-1.5"><span>✨</span> Animasi Reflektif</span>
            </div>
        </section>

        <!-- 2. CINEMATIC MODE (100dvh Per Stage) -->
        <section id="journey-cinematic" class="flex-1 flex flex-col justify-between hidden">
            <div class="relative flex-1 w-full max-w-3xl mx-auto flex flex-col justify-between">
                @foreach ($stages as $idx => $stage)
                    <div class="cinematic-stage {{ $idx === 0 ? 'stage-active' : 'stage-hidden' }}" data-index="{{ $idx }}" data-slug="{{ $stage['slug'] }}">

                        <!-- Top: Pin Position & Stage Title -->
                        <div class="text-center pt-2">
                            @if ($stage['showYouAreHere'])
                                <div class="mb-2">
                                    <span class="you-are-here-pin">📍 KAMU DI SINI</span>
                                </div>
                            @endif

                            <div class="text-xs font-mono font-extrabold tracking-widest text-slate-400">
                                {{ sprintf('%02d', $stage['id']) }} / 12 &middot; {{ $stage['labelId'] }}
                            </div>
                        </div>

                        <!-- Center: Scene Visual Illustration (Minimal Line-Art Glow) -->
                        <div class="scene-visual-wrapper my-auto">
                            @if ($stage['id'] === 1)
                                <!-- Scene 01: Ruang Ruh & Perjanjian Mitsaq -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <ellipse cx="200" cy="100" rx="140" ry="70" stroke="rgba(207,224,255,0.25)" stroke-width="1.5" stroke-dasharray="4 6"/>
                                    <circle cx="200" cy="100" r="14" fill="#cfe0ff" opacity="0.85" filter="drop-shadow(0 0 16px #cfe0ff)"/>
                                    <circle cx="140" cy="70" r="3" fill="#ffffff" opacity="0.6"/>
                                    <circle cx="260" cy="130" r="3.5" fill="#ffffff" opacity="0.7"/>
                                    <circle cx="110" cy="120" r="2.5" fill="#ffffff" opacity="0.5"/>
                                    <circle cx="290" cy="80" r="2.5" fill="#ffffff" opacity="0.5"/>
                                    <path d="M 200 115 Q 200 160 200 200" stroke="#cfe0ff" stroke-width="2" stroke-dasharray="3 3" opacity="0.6"/>
                                </svg>
                            @elseif ($stage['id'] === 2)
                                <!-- Scene 02: Rahim Hangat -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <ellipse cx="200" cy="100" rx="90" ry="70" stroke="#ffb4a0" stroke-width="2" opacity="0.3"/>
                                    <ellipse cx="200" cy="100" rx="60" ry="46" stroke="#ffb4a0" stroke-width="2.5" opacity="0.6"/>
                                    <circle cx="200" cy="100" r="18" fill="#ffb4a0" opacity="0.9" filter="drop-shadow(0 0 20px #ffb4a0)">
                                        <animate attributeName="r" values="16;19;16" dur="1.2s" repeatCount="indefinite" />
                                    </circle>
                                </svg>
                            @elseif ($stage['id'] === 3)
                                <!-- Scene 03: Dunia (Horizon Senja & Siluet) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <!-- Sun at horizon -->
                                    <circle cx="200" cy="140" r="45" fill="#ffd89a" opacity="0.5" filter="drop-shadow(0 0 30px #f2a05a)"/>
                                    <!-- Horizon line -->
                                    <line x1="20" y1="150" x2="380" y2="150" stroke="#ffd89a" stroke-width="2" opacity="0.7"/>
                                    <!-- Person Silhouette standing -->
                                    <circle cx="200" cy="115" r="7" fill="#ffffff"/>
                                    <path d="M 200 122 L 200 148 M 194 132 L 206 132 M 200 148 L 194 165 M 200 148 L 206 165" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
                                </svg>
                            @elseif ($stage['id'] === 4)
                                <!-- Scene 04: Barzakh (Horizon Sekat & 3 Berkas Cahaya) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <line x1="20" y1="90" x2="380" y2="90" stroke="#e8b57a" stroke-width="2" opacity="0.5"/>
                                    <text x="200" y="82" fill="#e8b57a" font-size="10" font-weight="bold" letter-spacing="3" text-anchor="middle" opacity="0.8">B A R Z A K H</text>
                                    <!-- Grave capsule below -->
                                    <rect x="160" y="110" width="80" height="50" rx="25" stroke="#e8b57a" stroke-width="1.5" fill="rgba(11,8,24,0.6)"/>
                                    <circle cx="200" cy="135" r="6" fill="#e8b57a" filter="drop-shadow(0 0 8px #e8b57a)"/>
                                    <!-- 3 Arcs rising: Sedekah, Ilmu, Doa Anak -->
                                    <path d="M 185 110 Q 150 40 130 30" stroke="#ffd89a" stroke-width="2" stroke-dasharray="4 4" fill="none" opacity="0.8"/>
                                    <path d="M 200 110 Q 200 40 200 25" stroke="#ffd89a" stroke-width="2" stroke-dasharray="4 4" fill="none" opacity="0.8"/>
                                    <path d="M 215 110 Q 250 40 270 30" stroke="#ffd89a" stroke-width="2" stroke-dasharray="4 4" fill="none" opacity="0.8"/>
                                </svg>
                            @elseif ($stage['id'] === 5)
                                <!-- Scene 05: Sangkakala (Gelombang Suara Riak) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <circle cx="200" cy="100" r="10" fill="#ffe9b0"/>
                                    <circle cx="200" cy="100" r="30" stroke="#ffe9b0" stroke-width="1.5" opacity="0.8"/>
                                    <circle cx="200" cy="100" r="55" stroke="#ffe9b0" stroke-width="1.2" opacity="0.5"/>
                                    <circle cx="200" cy="100" r="85" stroke="#ffe9b0" stroke-width="1" opacity="0.3"/>
                                    <circle cx="200" cy="100" r="120" stroke="#ffe9b0" stroke-width="0.8" stroke-dasharray="5 5" opacity="0.2"/>
                                </svg>
                            @elseif ($stage['id'] === 6)
                                <!-- Scene 06: Padang Mahsyar (Matahari Turun & Hamparan Debu) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <circle cx="200" cy="50" r="40" fill="#fff0c8" opacity="0.9" filter="drop-shadow(0 0 35px #e0883a)"/>
                                    <ellipse cx="200" cy="165" rx="180" ry="30" fill="rgba(224,136,58,0.2)"/>
                                    <line x1="20" y1="165" x2="380" y2="165" stroke="#e0883a" stroke-width="2"/>
                                    <!-- Scattered light points -->
                                    <circle cx="100" cy="155" r="2" fill="#fff"/>
                                    <circle cx="150" cy="160" r="2.5" fill="#fff"/>
                                    <circle cx="200" cy="158" r="2" fill="#fff"/>
                                    <circle cx="250" cy="162" r="2.5" fill="#fff"/>
                                    <circle cx="300" cy="157" r="2" fill="#fff"/>
                                </svg>
                            @elseif ($stage['id'] === 7)
                                <!-- Scene 07: Syafaat (Pilar Cahaya Emas Lembut) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <ellipse cx="200" cy="170" rx="160" ry="25" fill="rgba(255,211,107,0.15)"/>
                                    <path d="M 170 170 L 195 20 L 205 20 L 230 170 Z" fill="url(#syafaatGlow)" opacity="0.8"/>
                                    <defs>
                                        <linearGradient id="syafaatGlow" x1="0" y1="1" x2="0" y2="0">
                                            <stop offset="0%" stop-color="#ffd36b" stop-opacity="0.2"/>
                                            <stop offset="100%" stop-color="#fff" stop-opacity="0.9"/>
                                        </linearGradient>
                                    </defs>
                                    <circle cx="200" cy="20" r="12" fill="#ffffff" filter="drop-shadow(0 0 25px #ffd36b)"/>
                                </svg>
                            @elseif ($stage['id'] === 8)
                                <!-- Scene 08: Timbangan Al-Mizan -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <!-- Central Pillar -->
                                    <line x1="200" y1="40" x2="200" y2="160" stroke="#ffe0a0" stroke-width="3"/>
                                    <!-- Crossbar -->
                                    <line x1="120" y1="60" x2="280" y2="60" stroke="#ffe0a0" stroke-width="2.5"/>
                                    <!-- Left Pan -->
                                    <line x1="120" y1="60" x2="105" y2="110" stroke="#ffe0a0" stroke-width="1.5"/>
                                    <line x1="120" y1="60" x2="135" y2="110" stroke="#ffe0a0" stroke-width="1.5"/>
                                    <path d="M 100 110 Q 120 125 140 110 Z" fill="rgba(255,224,160,0.3)" stroke="#ffe0a0" stroke-width="2"/>
                                    <!-- Right Pan -->
                                    <line x1="280" y1="60" x2="265" y2="110" stroke="#ffe0a0" stroke-width="1.5"/>
                                    <line x1="280" y1="60" x2="295" y2="110" stroke="#ffe0a0" stroke-width="1.5"/>
                                    <path d="M 260 110 Q 280 125 300 110 Z" fill="rgba(255,224,160,0.3)" stroke="#ffe0a0" stroke-width="2"/>
                                </svg>
                            @elseif ($stage['id'] === 9)
                                <!-- Scene 09: Telaga Al-Hawdh -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <ellipse cx="200" cy="120" rx="150" ry="55" fill="rgba(207,225,245,0.4)" stroke="#ffffff" stroke-width="2" filter="drop-shadow(0 0 25px rgba(255,255,255,0.7))"/>
                                    <ellipse cx="200" cy="120" rx="100" ry="35" fill="rgba(255,255,255,0.6)"/>
                                    <circle cx="170" cy="115" r="3" fill="#ffffff"/>
                                    <circle cx="230" cy="125" r="3" fill="#ffffff"/>
                                </svg>
                            @elseif ($stage['id'] === 10)
                                <!-- Scene 10: Pemisahan (Tamyiz 2 Arah) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <line x1="200" y1="30" x2="200" y2="170" stroke="#c8d4ff" stroke-width="2" stroke-dasharray="6 6" opacity="0.6"/>
                                    <!-- Left stream moving smoothly -->
                                    <path d="M 180 100 Q 130 90 80 100" stroke="#c8d4ff" stroke-width="2" opacity="0.8"/>
                                    <circle cx="80" cy="100" r="4" fill="#c8d4ff"/>
                                    <!-- Right stream fading -->
                                    <path d="M 220 100 Q 270 110 320 100" stroke="rgba(200,212,255,0.2)" stroke-width="2"/>
                                    <circle cx="320" cy="100" r="3" fill="rgba(200,212,255,0.3)"/>
                                </svg>
                            @elseif ($stage['id'] === 11)
                                <!-- Scene 11: Shirath (Titian Garis Tipis di Jurang) -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <!-- Abyss beneath -->
                                    <path d="M 0 140 Q 200 180 400 140 L 400 200 L 0 200 Z" fill="rgba(74,16,16,0.6)"/>
                                    <!-- Glowing razor bridge line -->
                                    <line x1="20" y1="95" x2="380" y2="95" stroke="#ff9a6a" stroke-width="2" filter="drop-shadow(0 0 10px #ff9a6a)"/>
                                    <!-- Moving light particle on bridge -->
                                    <circle cx="180" cy="95" r="4" fill="#ffffff" filter="drop-shadow(0 0 8px #ffffff)"/>
                                    <!-- Falling particle -->
                                    <circle cx="260" cy="130" r="2" fill="#ff7849" opacity="0.6"/>
                                </svg>
                            @elseif ($stage['id'] === 12)
                                <!-- Scene 12: Qantharah & Gerbang Surga -->
                                <svg class="scene-svg" viewBox="0 0 400 200" fill="none" aria-hidden="true">
                                    <!-- Golden Arch Gate -->
                                    <path d="M 130 180 Q 130 40 200 40 Q 270 40 270 180" stroke="#fff3d0" stroke-width="3.5" fill="rgba(255,207,138,0.2)" filter="drop-shadow(0 0 25px rgba(255,243,208,0.8))"/>
                                    <!-- Rising Dawn Rays -->
                                    <line x1="200" y1="40" x2="200" y2="10" stroke="#fff3d0" stroke-width="2" opacity="0.8"/>
                                    <line x1="200" y1="40" x2="160" y2="15" stroke="#fff3d0" stroke-width="2" opacity="0.6"/>
                                    <line x1="200" y1="40" x2="240" y2="15" stroke="#fff3d0" stroke-width="2" opacity="0.6"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Bottom: Arabic Text, Headline & Source -->
                        <div class="arabic-block text-center mt-auto pb-4">
                            <div class="arabic-text mb-3 px-2" dir="rtl" lang="ar">
                                {{ $stage['arabic'] }}
                            </div>

                            <p class="translation-text text-base sm:text-xl font-extrabold text-white leading-snug max-w-xl mx-auto mb-2">
                                "{{ $stage['headline'] }}"
                            </p>

                            <div class="flex items-center justify-center gap-2 text-xs text-slate-400 font-semibold mb-3">
                                <span class="source-text">
                                    {{ $stage['sources'][0]['ref'] }} &middot; {{ $stage['sources'][0]['translationBy'] ?? 'Resmi' }}
                                </span>
                                <button class="copy-ayat-btn p-1 rounded hover:bg-white/10 text-slate-400 hover:text-white" title="Salin teks Arab & dalil">
                                    📋
                                </button>
                            </div>

                            @if (!empty($stage['scholarNotes']))
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-[11px] text-amber-300 font-medium">
                                    <span>⚖️</span> Ulama berbeda pendapat
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Bottom Floating Action Bar -->
            <div class="sticky bottom-0 z-30 p-4 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent">
                <div class="max-w-xl mx-auto flex items-center justify-between gap-3">
                    <button id="prev-stage-btn" class="px-5 py-2.5 rounded-xl border border-white/20 bg-white/5 hover:bg-white/15 text-white font-extrabold text-xs transition-colors flex items-center gap-1.5">
                        <span>‹</span> Mundur
                    </button>

                    <button id="trigger-deep-dive" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/25 text-white font-bold text-xs transition-colors flex items-center gap-1">
                        <span>Pelajari lebih dalam</span>
                        <span>⌄</span>
                    </button>

                    <button id="next-stage-btn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-slate-950 font-black text-xs hover:scale-105 active:scale-95 transition-all flex items-center gap-1.5">
                        Lanjut <span>›</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- 3. READ MODE (All 12 Stages Vertical Long Read) -->
        <section id="journey-read" class="flex-1 max-w-3xl mx-auto px-4 py-8 hidden">
            <div class="mb-10 text-center">
                <h2 class="text-2xl sm:text-3xl font-black text-white mb-2">12 Tahap Perjalanan Manusia</h2>
                <p class="text-sm text-slate-400">Mode baca runtut dan mendalam menurut Al-Qur'an dan Sunnah.</p>
            </div>

            <div class="space-y-12">
                @foreach ($stages as $s)
                    <article class="p-6 sm:p-8 rounded-3xl bg-slate-900/80 border border-white/10 shadow-xl relative overflow-hidden" id="tahap-read-{{ $s['id'] }}">
                        <div class="flex items-center justify-between mb-4 border-b border-white/10 pb-3">
                            <span class="text-xs font-mono font-bold text-amber-400">TAHAP {{ sprintf('%02d', $s['id']) }} / 12</span>
                            <span class="text-lg font-serif text-slate-400" dir="rtl">{{ $s['labelAr'] }}</span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-black text-white mb-4">
                            {{ $s['labelId'] }}
                            @if ($s['showYouAreHere'])
                                <span class="you-are-here-pin ml-2 text-[10px]">📍 KAMU DI SINI</span>
                            @endif
                        </h3>

                        <!-- Arabic Ayat -->
                        <div class="p-4 rounded-2xl bg-black/40 border border-white/10 mb-5 text-center">
                            <div class="arabic-text text-xl sm:text-2xl mb-2" dir="rtl" lang="ar">{{ $s['arabic'] }}</div>
                            <p class="text-xs sm:text-sm italic text-slate-300 leading-relaxed mb-2">"{{ $s['translation'] }}"</p>
                            <span class="text-[11px] font-semibold text-amber-400/90">{{ $s['sources'][0]['ref'] }}</span>
                        </div>

                        <!-- Explanations -->
                        <div class="space-y-3 mb-5 text-sm text-slate-300 leading-relaxed">
                            @foreach ($s['explanation'] as $p)
                                <p>{{ $p }}</p>
                            @endforeach
                        </div>

                        <!-- Vocabulary -->
                        @if (!empty($s['vocabulary']))
                            <div class="mb-4 p-3 rounded-xl bg-slate-800/50 border border-white/5">
                                <div class="text-[11px] font-extrabold uppercase text-amber-400 mb-2">Kosakata Arab:</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($s['vocabulary'] as $v)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-black/50 text-xs text-slate-300 border border-white/10">
                                            <span class="font-serif text-amber-300" dir="rtl">{{ $v['ar'] }}</span>
                                            <span>({{ $v['latin'] }}): {{ $v['meaning'] }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Scholar Notes -->
                        @if (!empty($s['scholarNotes']))
                            <div class="mb-4 p-3 rounded-xl bg-amber-950/20 border border-amber-600/30 text-xs text-amber-200/90">
                                <div class="scholar-badge mb-1.5">⚖️ Catatan Ulama</div>
                                <p class="m-0">{{ $s['scholarNotes'][0] }}</p>
                            </div>
                        @endif

                        <!-- Practical Takeaway -->
                        @if (!empty($s['practicalLessons']))
                            <div class="p-3 rounded-xl bg-emerald-950/20 border border-emerald-600/30 text-xs text-emerald-200/90">
                                <div class="font-bold text-emerald-400 mb-1">🌱 Pelajaran Praktis:</div>
                                <p class="m-0">{{ $s['practicalLessons'][0] }}</p>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>

        <!-- 4. END SCREEN (Layar Penutup & Ajakan Beramal) -->
        <section id="journey-end" class="flex-1 max-w-2xl mx-auto px-4 py-12 flex flex-col justify-center text-center hidden">
            <div class="mb-4">
                <span class="you-are-here-pin">📍 KAMU DI SINI</span>
            </div>

            <h2 class="text-3xl sm:text-4xl font-black text-white leading-tight mb-3">
                Kamu masih di tahap 3.
            </h2>

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed mb-8 max-w-xl mx-auto">
                Dari dua belas tahap perjalanan jiwa, hanya satu yang masih terbuka untuk kamu perbaiki dan tambahkan bekalnya. Semua tahap berikutnya sudah ada ketetapannya.
            </p>

            <!-- 12-Stage Mini Map -->
            <div class="p-4 rounded-2xl bg-slate-900/70 border border-white/10 mb-8">
                <div class="text-xs font-mono font-bold text-amber-400 mb-3 uppercase tracking-wider">Ringkasan Peta Perjalanan</div>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 text-[11px] font-bold">
                    @foreach ($stages as $s)
                        <div class="p-2 rounded-lg bg-slate-800/60 border {{ $s['id'] === 3 ? 'border-amber-400 text-amber-300' : 'border-slate-700/60 text-slate-300' }}">
                            {{ sprintf('%02d', $s['id']) }}. {{ $s['labelId'] }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Interactive Checklist "Bekal dari Tahap 3" -->
            <div class="p-5 rounded-2xl bg-emerald-950/30 border border-emerald-500/40 text-left mb-8">
                <h4 class="text-xs font-mono uppercase tracking-wider font-extrabold text-emerald-400 mb-3">
                    Bekal dari Tahap 3 — Amal Hari Ini:
                </h4>
                <div class="space-y-3 text-xs text-slate-200">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" class="bekal-checkbox mt-0.5 rounded text-emerald-500 focus:ring-0">
                        <span>Satu amal kecil yang tulus hari ini (sedekah tersembunyi, shalat awal waktu, membantu orang lain).</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" class="bekal-checkbox mt-0.5 rounded text-emerald-500 focus:ring-0">
                        <span>Satu ilmu yang dibagikan atau dipelajari untuk bekal pahala mengalir.</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" class="bekal-checkbox mt-0.5 rounded text-emerald-500 focus:ring-0">
                        <span>Satu hak sesama yang diselesaikan (minta maaf, lunasi utang, sambung silaturahmi).</span>
                    </label>
                </div>
            </div>

            <!-- End Action Buttons -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button id="restart-journey-btn" class="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition-colors">
                    🔄 Ulangi Perjalanan
                </button>
                <button id="end-quiz-btn" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs transition-colors">
                    ✍️ Uji Pemahaman (Kuis)
                </button>
                <button id="share-journey-btn" class="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition-colors">
                    📤 Bagikan
                </button>
                <a href="{{ url('/') }}" class="px-5 py-3 rounded-xl border border-white/20 text-slate-300 hover:text-white font-bold text-xs transition-colors no-underline">
                    🏠 Kembali ke Beranda
                </a>
            </div>
        </section>

        <!-- Footer: Adab, Disclaimer & Atribusi -->
        <footer class="mt-auto border-t border-white/10 px-4 py-8 text-center text-xs text-slate-500">
            <div class="max-w-2xl mx-auto space-y-3">
                <p class="leading-relaxed">
                    <strong>Disclaimer:</strong> Halaman ini adalah media edukasi ringkas dan bukan pengganti belajar langsung kepada guru/ustaz yang berilmu. Urutan 12 tahap adalah kerangka penyajian untuk memudahkan tadabbur dan pemahaman.
                </p>
                <p class="leading-relaxed text-[11px] text-slate-400">
                    Terinspirasi dari konsep peta perjalanan 12 tahap oleh <strong>@pendar.quran</strong> &middot; Dibuat dengan penuh adab dan ketelitian oleh <strong>Rizky Dika</strong> &middot; Wacky Lab &copy; {{ date('Y') }}
                </p>
            </div>
        </footer>

    </div>

    <!-- 5. DEEP DIVE SLIDE PANEL (Bottom-sheet on mobile / Slide-over on desktop) -->
    <div id="deep-dive-overlay" class="modal-overlay"></div>
    <aside id="deep-dive-panel" class="deep-dive-panel" aria-label="Pelajari lebih dalam">
        <div class="flex items-center justify-between mb-4 border-b border-slate-800 pb-3">
            <span class="text-xs font-mono font-bold text-amber-400 tracking-wider">DETAIL TAFSIR & AMAL</span>
            <button id="close-deep-dive" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs" title="Tutup panel (Esc)">
                ✕ Tutup
            </button>
        </div>
        <div id="deep-dive-content">
            <!-- Dynamic populated via journey.js -->
        </div>
    </aside>

    <!-- 6. GLOSSARY MODAL -->
    <div id="glossary-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md hidden">
        <div class="w-full max-w-xl max-h-[85dvh] bg-slate-900 border border-slate-700 rounded-3xl p-6 shadow-2xl flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📖</span>
                    <h3 class="text-lg font-black text-white m-0">Kamus Istilah (Glosarium)</h3>
                </div>
                <button id="close-glossary-modal" class="text-slate-400 hover:text-white p-1 font-bold text-sm">✕</button>
            </div>

            <div class="mb-4">
                <input type="text" id="glossary-search-input" placeholder="Cari istilah (contoh: barzakh, mitsaq)..." class="w-full p-2.5 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400">
            </div>

            <div id="glossary-items-list" class="flex-1 overflow-y-auto space-y-3 pr-1">
                <!-- Dynamically rendered -->
            </div>
        </div>
    </div>

    <!-- 7. QUIZ MODAL -->
    <div id="quiz-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md hidden">
        <div class="w-full max-w-2xl max-h-[88dvh] bg-slate-900 border border-slate-700 rounded-3xl p-6 shadow-2xl flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✍️</span>
                    <h3 class="text-lg font-black text-white m-0">Kuis Pemahaman 12 Tahap</h3>
                </div>
                <button id="close-quiz-modal" class="text-slate-400 hover:text-white p-1 font-bold text-sm">✕</button>
            </div>

            <div id="quiz-result-banner" class="hidden mb-4"></div>

            <div id="quiz-questions-list" class="flex-1 overflow-y-auto pr-2">
                <!-- Dynamically rendered -->
            </div>
        </div>
    </div>

    <!-- Global Toast Notification -->
    <div id="journey-toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-2.5 rounded-full bg-slate-900/95 border border-amber-500/40 text-amber-200 text-xs font-bold shadow-2xl z-50 transition-all duration-300 opacity-0 pointer-events-none translate-y-4">
    </div>

</body>
</html>
