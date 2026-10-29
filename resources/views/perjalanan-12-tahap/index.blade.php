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

    <!-- Islamic Geometric Mandala Vector (Subtle Rotating Celestial Background) -->
    <svg class="islamic-mandala-bg" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <circle cx="250" cy="250" r="230" stroke="currentColor" stroke-width="1.5" stroke-dasharray="6 6" class="text-amber-300"/>
        <circle cx="250" cy="250" r="180" stroke="currentColor" stroke-width="1.2" class="text-amber-300"/>
        <circle cx="250" cy="250" r="120" stroke="currentColor" stroke-width="1" class="text-amber-300"/>
        <!-- 8-Pointed Star (Rub el Hizb Geometry) -->
        <polygon points="250,50 391,109 450,250 391,391 250,450 109,391 50,250 109,109" stroke="currentColor" stroke-width="1.5" class="text-amber-300"/>
        <polygon points="250,50 450,250 250,450 50,250" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 4" class="text-amber-300"/>
        <polygon points="391,109 391,391 109,391 109,109" stroke="currentColor" stroke-width="1.5" stroke-dasharray="4 4" class="text-amber-300"/>
    </svg>

    <canvas id="journey-canvas"></canvas>

    <!-- Main App Container -->
    <div id="journey-container" class="relative z-10 flex flex-col min-h-dvh">

        <!-- Top Navigation Header -->
        <header class="sticky top-0 z-40 bg-slate-950/80 backdrop-blur-md border-b border-white/10 px-4 py-2.5">
            <div class="max-w-6xl mx-auto flex items-center justify-between gap-3">
                <!-- Left: Back to Home & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="text-xs font-bold text-slate-300 hover:text-white flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-white/15 bg-white/5 hover:bg-white/10 transition-colors no-underline">
                        <span>‹</span>
                        <span class="hidden sm:inline">Beranda Wacky Lab</span>
                        <span class="sm:hidden">Beranda</span>
                    </a>
                    <div class="hidden lg:flex items-center gap-2 text-xs font-extrabold tracking-wider text-amber-400">
                        <span>۞</span>
                        <span>PERJALANAN 12 TAHAP</span>
                        <span>۞</span>
                    </div>
                </div>

                <!-- Center: 12-dot Progress Trail + Counter (Cinematic Mode) -->
                <div class="flex items-center gap-2.5">
                    <div class="progress-trail" title="Lompat ke tahap tertentu">
                        @foreach ($stages as $index => $s)
                            <button class="trail-dot {{ $index === 0 ? 'active' : '' }}" data-stage="{{ $index }}" aria-label="Tahap {{ $s['id'] }}: {{ $s['labelId'] }}"></button>
                        @endforeach
                    </div>
                    <span id="stage-counter" class="text-xs font-mono font-black text-amber-300 min-w-[55px] text-center px-2 py-0.5 rounded-md bg-amber-500/10 border border-amber-500/20">
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

            <!-- Stage Scrubber Bar (Horizontal Timeline Pills) -->
            <div class="max-w-6xl mx-auto mt-2 pt-1 border-t border-white/5">
                <div class="stage-scrubber">
                    @foreach ($stages as $pIdx => $stg)
                        <button class="scrubber-pill {{ $pIdx === 0 ? 'active' : '' }}" data-stage="{{ $pIdx }}">
                            {{ sprintf('%02d', $stg['id']) }}. {{ $stg['labelId'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </header>

        <!-- 1. INTRO SCREEN -->
        <section id="journey-intro" class="flex-1 flex flex-col items-center justify-center text-center px-4 py-12 max-w-2xl mx-auto my-auto">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-amber-400/30 bg-amber-400/10 text-amber-300 text-xs font-bold tracking-widest uppercase mb-6 animate-pulse">
                <span>۞</span> Peta Perjalanan Jiwa Manusia <span>۞</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Perjalananmu ada 12 tahap.
            </h1>

            <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8 max-w-xl">
                Dari sebelum ditiupkan ruh hingga menuju kampung keabadian. Dari seluruh dua belas tahap itu, <strong class="text-amber-300 underline decoration-amber-500/50">hanya satu tahap yang masih bisa kamu ubah</strong>. Mari telusuri di mana posisimu saat ini.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-3.5 w-full sm:w-auto">
                <button id="start-journey-btn" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 text-slate-950 font-black text-sm tracking-wide shadow-xl shadow-orange-500/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span>Mulai Perjalanan</span>
                    <span>›</span>
                </button>
                <button id="resume-journey-btn" class="hidden w-full sm:w-auto px-6 py-3.5 rounded-2xl border border-white/20 bg-white/5 hover:bg-white/10 text-white font-bold text-sm transition-colors">
                    Lanjutkan Progres
                </button>
            </div>

            <div class="mt-12 flex flex-wrap justify-center items-center gap-5 text-xs text-slate-400">
                <span class="flex items-center gap-1.5"><span class="text-amber-400">📜</span> Al-Qur'an & Hadis Sahih</span>
                <span class="flex items-center gap-1.5"><span class="text-amber-400">⚖️</span> Catatan Ikhtilaf Ulama</span>
                <span class="flex items-center gap-1.5"><span class="text-amber-400">🌌</span> Visual Sinematik & Tadabbur</span>
            </div>
        </section>

        <!-- 2. CINEMATIC MODE (Card per Stage) -->
        <section id="journey-cinematic" class="flex-1 flex flex-col justify-center hidden">
            <div class="relative w-full max-w-3xl mx-auto my-auto px-3 sm:px-4">
                @foreach ($stages as $idx => $stage)
                    <div class="cinematic-stage {{ $idx === 0 ? 'stage-active' : 'stage-hidden' }}" data-index="{{ $idx }}" data-slug="{{ $stage['slug'] }}">

                        <!-- Celestial Holy Card Container -->
                        <div class="celestial-card">
                            <!-- Corner Ornaments -->
                            <div class="corner-ornament corner-top-left"></div>
                            <div class="corner-ornament corner-top-right"></div>
                            <div class="corner-ornament corner-bottom-left"></div>
                            <div class="corner-ornament corner-bottom-right"></div>

                            <!-- Stage Top Badge & Breadcrumb -->
                            <div class="text-center mb-2">
                                @if ($stage['showYouAreHere'])
                                    <div class="mb-3">
                                        <span class="you-are-here-pin">📍 KAMU DI SINI</span>
                                    </div>
                                @endif

                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/80 border border-amber-500/20 text-xs font-mono font-extrabold tracking-widest text-amber-300">
                                    <span>۞</span>
                                    <span>TAHAP {{ sprintf('%02d', $stage['id']) }} / 12 &middot; {{ $stage['labelId'] }}</span>
                                    <span>۞</span>
                                </div>
                            </div>

                            <!-- Scene Visual Illustration (Atmospheric Rich Line-Art Glow) -->
                            <div class="scene-visual-wrapper celestial-float">
                                @if ($stage['id'] === 1)
                                    <!-- Scene 01: Ruang Ruh & Perjanjian Mitsaq -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <radialGradient id="ruhGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#cfe0ff" stop-opacity="1"/>
                                                <stop offset="40%" stop-color="#93c5fd" stop-opacity="0.6"/>
                                                <stop offset="100%" stop-color="#3b82f6" stop-opacity="0"/>
                                            </radialGradient>
                                            <linearGradient id="rayGrad" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#cfe0ff" stop-opacity="0.8"/>
                                                <stop offset="100%" stop-color="#1e3a8a" stop-opacity="0"/>
                                            </linearGradient>
                                        </defs>
                                        <!-- Orbital celestial constellation rings -->
                                        <ellipse cx="250" cy="120" rx="190" ry="75" stroke="#93c5fd" stroke-width="1.5" stroke-dasharray="4 8" opacity="0.4"/>
                                        <ellipse cx="250" cy="120" rx="140" ry="50" stroke="#bfdbfe" stroke-width="1" stroke-dasharray="2 6" opacity="0.6"/>
                                        <ellipse cx="250" cy="120" rx="80" ry="30" stroke="#cfe0ff" stroke-width="1.5" opacity="0.7"/>
                                        <!-- Central Spirit Nucleus -->
                                        <circle cx="250" cy="120" r="45" fill="url(#ruhGlow)"/>
                                        <circle cx="250" cy="120" r="16" fill="#ffffff" filter="drop-shadow(0 0 16px #ffffff)"/>
                                        <!-- Floating Soul Sparks with connection lines -->
                                        <line x1="160" y1="80" x2="250" y2="120" stroke="#93c5fd" stroke-width="0.8" stroke-dasharray="2 3" opacity="0.5"/>
                                        <line x1="340" y1="90" x2="250" y2="120" stroke="#93c5fd" stroke-width="0.8" stroke-dasharray="2 3" opacity="0.5"/>
                                        <circle cx="160" cy="80" r="4" fill="#ffffff" filter="drop-shadow(0 0 6px #bfdbfe)"/>
                                        <circle cx="340" cy="90" r="4" fill="#ffffff" filter="drop-shadow(0 0 6px #bfdbfe)"/>
                                        <circle cx="110" cy="140" r="3" fill="#cfe0ff" opacity="0.8"/>
                                        <circle cx="380" cy="140" r="3" fill="#cfe0ff" opacity="0.8"/>
                                        <circle cx="210" cy="45" r="2.5" fill="#ffffff"/>
                                        <circle cx="290" cy="195" r="2.5" fill="#ffffff"/>
                                        <!-- Path descending toward creation -->
                                        <path d="M 250 140 Q 250 190 250 240" stroke="url(#rayGrad)" stroke-width="2.5" stroke-dasharray="4 4"/>
                                    </svg>
                                @elseif ($stage['id'] === 2)
                                    <!-- Scene 02: Rahim Hangat & Detak Janin -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <radialGradient id="wombGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#ffb4a0" stop-opacity="1"/>
                                                <stop offset="60%" stop-color="#f43f5e" stop-opacity="0.3"/>
                                                <stop offset="100%" stop-color="#881337" stop-opacity="0"/>
                                            </radialGradient>
                                        </defs>
                                        <!-- 3 Darknesses (Layered Sanctuary Rings) -->
                                        <ellipse cx="250" cy="120" rx="170" ry="100" stroke="#fb7185" stroke-width="2" opacity="0.25" stroke-dasharray="6 6"/>
                                        <ellipse cx="250" cy="120" rx="125" ry="75" stroke="#ffb4a0" stroke-width="2" opacity="0.45"/>
                                        <ellipse cx="250" cy="120" rx="80" ry="50" stroke="#f43f5e" stroke-width="2.5" opacity="0.75"/>
                                        <!-- Warm Embryonic Center with pulsing life -->
                                        <circle cx="250" cy="120" r="50" fill="url(#wombGlow)"/>
                                        <circle cx="250" cy="120" r="18" fill="#ffb4a0" filter="drop-shadow(0 0 20px #ffedd5)">
                                            <animate attributeName="r" values="16;20;16" dur="1.2s" repeatCount="indefinite" />
                                        </circle>
                                        <!-- Organic warmth capillaries -->
                                        <path d="M 210 120 C 180 100 150 130 120 110" stroke="#f43f5e" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6"/>
                                        <path d="M 290 120 C 320 140 350 110 380 130" stroke="#f43f5e" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6"/>
                                    </svg>
                                @elseif ($stage['id'] === 3)
                                    <!-- Scene 03: Dunia (Horizon Senja & Siluet Musafir) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <radialGradient id="sunGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#fef08a" stop-opacity="1"/>
                                                <stop offset="50%" stop-color="#f97316" stop-opacity="0.6"/>
                                                <stop offset="100%" stop-color="#ea580c" stop-opacity="0"/>
                                            </radialGradient>
                                        </defs>
                                        <!-- Glorious Setting Sun -->
                                        <circle cx="250" cy="140" r="60" fill="url(#sunGlow)"/>
                                        <circle cx="250" cy="140" r="30" fill="#fef08a" filter="drop-shadow(0 0 25px #fb923c)"/>
                                        <!-- Layered Mountain / Desert Dunes -->
                                        <path d="M 0 175 Q 120 150 250 165 T 500 155 L 500 240 L 0 240 Z" fill="rgba(30,27,75,0.7)"/>
                                        <path d="M 0 185 Q 180 170 330 185 T 500 175 L 500 240 L 0 240 Z" fill="rgba(15,23,42,0.95)"/>
                                        <line x1="20" y1="185" x2="480" y2="185" stroke="#f97316" stroke-width="2" opacity="0.6"/>
                                        <!-- Traveler Silhouette with Staff -->
                                        <circle cx="250" cy="120" r="7" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)"/>
                                        <path d="M 250 128 L 250 162 M 242 140 L 258 140 M 250 162 L 243 185 M 250 162 L 257 185" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round"/>
                                        <!-- Staff with lantern glow -->
                                        <line x1="262" y1="115" x2="262" y2="185" stroke="#fef08a" stroke-width="1.8"/>
                                        <circle cx="262" cy="125" r="3.5" fill="#f59e0b" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                    </svg>
                                @elseif ($stage['id'] === 4)
                                    <!-- Scene 04: Barzakh (Dinding Pembatas & 3 Cahaya Menjulang) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <linearGradient id="barzakhWall" x1="0" y1="0" x2="1" y2="0">
                                                <stop offset="0%" stop-color="#9333ea" stop-opacity="0"/>
                                                <stop offset="50%" stop-color="#e8b57a" stop-opacity="1"/>
                                                <stop offset="100%" stop-color="#9333ea" stop-opacity="0"/>
                                            </linearGradient>
                                        </defs>
                                        <!-- Horizon Divider Wall -->
                                        <line x1="30" y1="100" x2="470" y2="100" stroke="url(#barzakhWall)" stroke-width="2.5"/>
                                        <text x="250" y="90" fill="#e8b57a" font-size="11" font-weight="900" letter-spacing="6" text-anchor="middle" filter="drop-shadow(0 0 8px #e8b57a)">B A R Z A K H</text>
                                        <!-- Grave Resting Capsule -->
                                        <rect x="200" y="125" width="100" height="60" rx="30" stroke="#e8b57a" stroke-width="2" fill="rgba(11,8,24,0.85)"/>
                                        <circle cx="250" cy="155" r="8" fill="#e8b57a" filter="drop-shadow(0 0 12px #e8b57a)"/>
                                        <!-- 3 Radiant Light Streams Ascending -->
                                        <!-- Stream 1: Sedekah Jariyah -->
                                        <path d="M 225 125 Q 160 50 140 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="130" y="20" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Sedekah Jariyah</text>
                                        <!-- Stream 2: Ilmu Bermanfaat -->
                                        <path d="M 250 125 Q 250 50 250 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="250" y="16" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Ilmu Bermanfaat</text>
                                        <!-- Stream 3: Doa Anak Saleh -->
                                        <path d="M 275 125 Q 340 50 360 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="370" y="20" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Doa Anak Saleh</text>
                                    </svg>
                                @elseif ($stage['id'] === 5)
                                    <!-- Scene 05: Sangkakala (Gelombang Suara Riak Kiamat) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Cosmic Shockwave Acoustic Rings -->
                                        <circle cx="250" cy="120" r="15" fill="#fef08a" filter="drop-shadow(0 0 20px #f59e0b)"/>
                                        <circle cx="250" cy="120" r="40" stroke="#ffe9b0" stroke-width="2" opacity="0.9"/>
                                        <circle cx="250" cy="120" r="75" stroke="#ffe9b0" stroke-width="1.8" opacity="0.65"/>
                                        <circle cx="250" cy="120" r="115" stroke="#ffe9b0" stroke-width="1.2" opacity="0.4" stroke-dasharray="5 5"/>
                                        <circle cx="250" cy="120" r="160" stroke="#ffe9b0" stroke-width="0.8" opacity="0.25"/>
                                        <!-- Vibrating Cosmic Dust -->
                                        <circle cx="150" cy="80" r="3" fill="#ffffff"/>
                                        <circle cx="350" cy="160" r="3" fill="#ffffff"/>
                                        <circle cx="180" cy="180" r="2.5" fill="#ffe9b0"/>
                                        <circle cx="320" cy="60" r="2.5" fill="#ffe9b0"/>
                                    </svg>
                                @elseif ($stage['id'] === 6)
                                    <!-- Scene 06: Padang Mahsyar (Matahari Terik & Hamparan Jiwa) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Blazing Scorching Sun -->
                                        <circle cx="250" cy="60" r="55" fill="#fff0c8" opacity="0.95" filter="drop-shadow(0 0 40px #ea580c)"/>
                                        <circle cx="250" cy="60" r="75" stroke="#f97316" stroke-width="1.5" opacity="0.4" stroke-dasharray="4 4"/>
                                        <!-- Vast Plain of Mahsyar -->
                                        <ellipse cx="250" cy="190" rx="230" ry="35" fill="rgba(224,136,58,0.25)"/>
                                        <line x1="20" y1="190" x2="480" y2="190" stroke="#ea580c" stroke-width="2.5"/>
                                        <!-- Infinite crowd of light souls -->
                                        @for ($i = 0; $i < 24; $i++)
                                            <circle cx="{{ 50 + $i * 18 }}" cy="{{ 180 + (($i * 7) % 15) }}" r="2.5" fill="#ffffff" opacity="{{ 0.5 + (($i % 5) * 0.1) }}"/>
                                        @endfor
                                    </svg>
                                @elseif ($stage['id'] === 7)
                                    <!-- Scene 07: Syafaat (Pilar Cahaya Emas & Nama Para Rasul) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <linearGradient id="divineBeam" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                                                <stop offset="40%" stop-color="#f59e0b" stop-opacity="0.8"/>
                                                <stop offset="100%" stop-color="#ffd36b" stop-opacity="0.1"/>
                                            </linearGradient>
                                        </defs>
                                        <!-- Central Pillar of Light -->
                                        <polygon points="210,240 240,20 260,20 290,240" fill="url(#divineBeam)"/>
                                        <circle cx="250" cy="25" r="16" fill="#ffffff" filter="drop-shadow(0 0 30px #f59e0b)"/>
                                        <!-- Stepped Name Tablets of the Prophets -->
                                        <g font-size="9" font-weight="900" fill="#fef08a" opacity="0.85" text-anchor="middle">
                                            <text x="90" y="195">ADAM</text>
                                            <text x="160" y="165">NUH</text>
                                            <text x="210" y="135">IBRAHIM</text>
                                            <text x="290" y="135">MUSA</text>
                                            <text x="340" y="165">ISA</text>
                                            <text x="410" y="195">MUHAMMAD ﷺ</text>
                                        </g>
                                    </svg>
                                @elseif ($stage['id'] === 8)
                                    <!-- Scene 08: Timbangan Al-Mizan (Keadilan Hakiki) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Moorish Celestial Apex -->
                                        <path d="M 230 40 Q 250 15 270 40 Z" fill="#fef08a"/>
                                        <circle cx="250" cy="20" r="4" fill="#ffffff"/>
                                        <!-- Main Balance Pillar -->
                                        <line x1="250" y1="40" x2="250" y2="200" stroke="#ffe0a0" stroke-width="4"/>
                                        <circle cx="250" cy="65" r="8" fill="#f59e0b" filter="drop-shadow(0 0 10px #f59e0b)"/>
                                        <!-- Ornate Crossbar -->
                                        <line x1="140" y1="65" x2="360" y2="65" stroke="#ffe0a0" stroke-width="3.5"/>
                                        <!-- Left Balance Pan (Kebaikan) -->
                                        <line x1="140" y1="65" x2="120" y2="135" stroke="#ffe0a0" stroke-width="1.8"/>
                                        <line x1="140" y1="65" x2="160" y2="135" stroke="#ffe0a0" stroke-width="1.8"/>
                                        <path d="M 110 135 Q 140 160 170 135 Z" fill="rgba(245,158,11,0.3)" stroke="#ffe0a0" stroke-width="2.5" filter="drop-shadow(0 0 10px rgba(245,158,11,0.5))"/>
                                        <!-- Right Balance Pan -->
                                        <line x1="360" y1="65" x2="340" y2="135" stroke="#ffe0a0" stroke-width="1.8"/>
                                        <line x1="360" y1="65" x2="380" y2="135" stroke="#ffe0a0" stroke-width="1.8"/>
                                        <path d="M 330 135 Q 360 160 390 135 Z" fill="rgba(245,158,11,0.3)" stroke="#ffe0a0" stroke-width="2.5" filter="drop-shadow(0 0 10px rgba(245,158,11,0.5))"/>
                                        <!-- Deeds particles falling -->
                                        <circle cx="140" cy="115" r="3" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)"/>
                                        <circle cx="145" cy="125" r="2.5" fill="#fef08a"/>
                                    </svg>
                                @elseif ($stage['id'] === 9)
                                    <!-- Scene 09: Telaga Al-Hawdh (Kesejukan Putih Susu) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- The Pristine Heavenly Oasis -->
                                        <ellipse cx="250" cy="140" rx="190" ry="70" fill="rgba(207,225,245,0.35)" stroke="#ffffff" stroke-width="2.5" filter="drop-shadow(0 0 35px rgba(255,255,255,0.8))"/>
                                        <ellipse cx="250" cy="140" rx="130" ry="45" fill="rgba(255,255,255,0.7)"/>
                                        <ellipse cx="250" cy="140" rx="70" ry="25" fill="#ffffff" filter="drop-shadow(0 0 15px #ffffff)"/>
                                        <!-- Celestial Dew Goblets -->
                                        <circle cx="160" cy="135" r="4" fill="#ffffff"/>
                                        <circle cx="340" cy="145" r="4" fill="#ffffff"/>
                                        <circle cx="210" cy="155" r="3" fill="#cfe1f5"/>
                                        <circle cx="290" cy="125" r="3" fill="#cfe1f5"/>
                                    </svg>
                                @elseif ($stage['id'] === 10)
                                    <!-- Scene 10: Pemisahan (Tamyiz Dua Jalan) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Divine Dividing Line -->
                                        <line x1="250" y1="20" x2="250" y2="220" stroke="#c8d4ff" stroke-width="2.5" stroke-dasharray="6 6" filter="drop-shadow(0 0 12px #c8d4ff)"/>
                                        <!-- Left Ascending Path of Faith -->
                                        <path d="M 230 130 Q 150 110 80 120" stroke="#60a5fa" stroke-width="3" opacity="0.9" filter="drop-shadow(0 0 10px #60a5fa)"/>
                                        <circle cx="80" cy="120" r="6" fill="#ffffff" filter="drop-shadow(0 0 10px #60a5fa)"/>
                                        <text x="80" y="95" fill="#93c5fd" font-size="10" font-weight="bold" text-anchor="middle">AHLU TAWFIQ</text>
                                        <!-- Right Path of Stiff Hypocrisy -->
                                        <path d="M 270 130 Q 350 150 420 160" stroke="rgba(200,212,255,0.25)" stroke-width="2.5"/>
                                        <circle cx="420" cy="160" r="4" fill="rgba(200,212,255,0.3)"/>
                                        <text x="420" y="190" fill="#64748b" font-size="10" font-weight="bold" text-anchor="middle">AHLU RIYA'</text>
                                    </svg>
                                @elseif ($stage['id'] === 11)
                                    <!-- Scene 11: Shirath (Titian Tajam di Atas Jurang) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Deep Abyss of Jahannam -->
                                        <path d="M 0 160 Q 250 210 500 160 L 500 240 L 0 240 Z" fill="rgba(74,16,16,0.8)"/>
                                        <line x1="0" y1="160" x2="500" y2="160" stroke="#dc2626" stroke-width="1.5" opacity="0.6"/>
                                        <!-- The Razor Thin Bridge of Shirath -->
                                        <line x1="20" y1="110" x2="480" y2="110" stroke="#ffedd5" stroke-width="2.5" filter="drop-shadow(0 0 15px #f97316)"/>
                                        <!-- Light halo surrounding moving souls -->
                                        <circle cx="220" cy="110" r="6" fill="#ffffff" filter="drop-shadow(0 0 14px #ffffff)"/>
                                        <circle cx="340" cy="110" r="4.5" fill="#fef08a" filter="drop-shadow(0 0 10px #f59e0b)"/>
                                        <!-- Stray embers in abyss -->
                                        <circle cx="150" cy="190" r="2.5" fill="#ef4444" opacity="0.6"/>
                                        <circle cx="380" cy="180" r="2" fill="#f97316" opacity="0.6"/>
                                    </svg>
                                @elseif ($stage['id'] === 12)
                                    <!-- Scene 12: Qantharah & Gerbang Surga Abadi -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Radiant Heavenly Dawn Burst -->
                                        <defs>
                                            <radialGradient id="heavenBurst" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#fffbeb" stop-opacity="1"/>
                                                <stop offset="60%" stop-color="#fde68a" stop-opacity="0.6"/>
                                                <stop offset="100%" stop-color="#f59e0b" stop-opacity="0"/>
                                            </radialGradient>
                                        </defs>
                                        <circle cx="250" cy="80" r="90" fill="url(#heavenBurst)"/>
                                        <!-- Grand Moorish Arch of Paradise (Babul Jannah) -->
                                        <path d="M 160 220 L 160 110 Q 160 30 250 30 Q 340 30 340 110 L 340 220" stroke="#fef3c7" stroke-width="4.5" fill="rgba(254,243,199,0.25)" filter="drop-shadow(0 0 35px rgba(254,243,199,0.9))"/>
                                        <!-- Inner Arch Contour -->
                                        <path d="M 185 220 L 185 115 Q 185 55 250 55 Q 315 55 315 115 L 315 220" stroke="#fde68a" stroke-width="2" fill="none"/>
                                        <!-- Rays of Eternal Dawn -->
                                        <line x1="250" y1="30" x2="250" y2="0" stroke="#ffffff" stroke-width="3" filter="drop-shadow(0 0 8px #ffffff)"/>
                                        <line x1="250" y1="30" x2="200" y2="5" stroke="#fef08a" stroke-width="2.5"/>
                                        <line x1="250" y1="30" x2="300" y2="5" stroke="#fef08a" stroke-width="2.5"/>
                                        <line x1="250" y1="30" x2="150" y2="15" stroke="#fef08a" stroke-width="2"/>
                                        <line x1="250" y1="30" x2="350" y2="15" stroke="#fef08a" stroke-width="2"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Bottom: Arabic Block & Message -->
                            <div class="arabic-block text-center mt-3">
                                <div class="arabic-text mb-3 px-2 font-serif" dir="rtl" lang="ar">
                                    {{ $stage['arabic'] }}
                                </div>

                                <p class="translation-text text-base sm:text-xl font-black text-white leading-snug max-w-xl mx-auto mb-2.5">
                                    "{{ $stage['headline'] }}"
                                </p>

                                <div class="flex items-center justify-center gap-3 text-xs text-slate-300 font-semibold mb-3">
                                    <span class="source-text px-3 py-1 rounded-full bg-slate-900/80 border border-white/10 text-amber-300 font-bold">
                                        {{ $stage['sources'][0]['ref'] }} &middot; {{ $stage['sources'][0]['translationBy'] ?? 'Resmi' }}
                                    </span>
                                    <button class="copy-ayat-btn p-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-white/10 transition-colors" title="Salin teks Arab & dalil">
                                        📋 Salin
                                    </button>
                                </div>

                                @if (!empty($stage['scholarNotes']))
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/15 border border-amber-500/40 text-[11px] text-amber-300 font-bold">
                                        <span>⚖️</span> Catatan: Ulama berbeda pendapat
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Bottom Floating Action Bar -->
            <div class="sticky bottom-0 z-30 p-3.5 bg-gradient-to-t from-slate-950 via-slate-950/90 to-transparent">
                <div class="max-w-xl mx-auto flex items-center justify-between gap-3">
                    <button id="prev-stage-btn" class="px-5 py-2.5 rounded-xl border border-white/20 bg-slate-900/80 hover:bg-white/15 text-white font-black text-xs transition-colors flex items-center gap-1.5 shadow-md">
                        <span>‹</span> Mundur
                    </button>

                    <button id="trigger-deep-dive" class="px-5 py-2.5 rounded-xl bg-amber-500/15 hover:bg-amber-500/25 border-1.5 border-amber-500/40 text-amber-300 font-extrabold text-xs transition-colors flex items-center gap-1.5 shadow-lg shadow-amber-500/10">
                        <span>📖 Pelajari lebih dalam</span>
                        <span>⌄</span>
                    </button>

                    <button id="next-stage-btn" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 text-slate-950 font-black text-xs hover:scale-105 active:scale-95 transition-all flex items-center gap-1.5 shadow-lg shadow-orange-500/25">
                        Lanjut <span>›</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- 3. READ MODE (Vertical Long Read) -->
        <section id="journey-read" class="flex-1 max-w-3xl mx-auto px-4 py-8 hidden">
            <div class="mb-10 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-bold mb-3">
                    <span>📖</span> Tadabbur 12 Alam
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-white mb-2">12 Tahap Perjalanan Manusia</h2>
                <p class="text-xs sm:text-sm text-slate-400">Mode baca runtut dan mendalam berdasarkan Al-Qur'an dan As-Sunnah.</p>
            </div>

            <div class="space-y-10">
                @foreach ($stages as $s)
                    <article class="p-6 sm:p-8 rounded-3xl bg-slate-900/85 border border-amber-500/20 shadow-2xl relative overflow-hidden" id="tahap-read-{{ $s['id'] }}">
                        <div class="flex items-center justify-between mb-4 border-b border-white/10 pb-3">
                            <span class="text-xs font-mono font-black text-amber-400">TAHAP {{ sprintf('%02d', $s['id']) }} / 12</span>
                            <span class="text-2xl font-serif text-amber-300/80" dir="rtl">{{ $s['labelAr'] }}</span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-black text-white mb-4 flex items-center gap-3">
                            <span>{{ $s['labelId'] }}</span>
                            @if ($s['showYouAreHere'])
                                <span class="you-are-here-pin text-[10px]">📍 KAMU DI SINI</span>
                            @endif
                        </h3>

                        <!-- Arabic Ayat -->
                        <div class="p-5 rounded-2xl bg-black/50 border border-amber-500/20 mb-5 text-center">
                            <div class="arabic-text text-2xl mb-2" dir="rtl" lang="ar">{{ $s['arabic'] }}</div>
                            <p class="text-xs sm:text-sm italic text-slate-300 leading-relaxed mb-2 font-medium">"{{ $s['translation'] }}"</p>
                            <span class="text-[11px] font-bold text-amber-400">{{ $s['sources'][0]['ref'] }}</span>
                        </div>

                        <!-- Explanations -->
                        <div class="space-y-3 mb-5 text-xs sm:text-sm text-slate-300 leading-relaxed">
                            @foreach ($s['explanation'] as $p)
                                <p>{{ $p }}</p>
                            @endforeach
                        </div>

                        <!-- Vocabulary -->
                        @if (!empty($s['vocabulary']))
                            <div class="mb-4 p-4 rounded-2xl bg-slate-800/60 border border-white/5">
                                <div class="text-[11px] font-black uppercase tracking-wider text-amber-400 mb-2">Kosakata Arab:</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($s['vocabulary'] as $v)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-black/60 text-xs text-slate-200 border border-white/10">
                                            <span class="font-serif text-amber-300 font-bold" dir="rtl">{{ $v['ar'] }}</span>
                                            <span class="font-bold text-slate-300">({{ $v['latin'] }}):</span>
                                            <span class="text-slate-400">{{ $v['meaning'] }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Scholar Notes -->
                        @if (!empty($s['scholarNotes']))
                            <div class="mb-4 p-4 rounded-2xl bg-amber-950/30 border border-amber-600/40 text-xs text-amber-200/95">
                                <div class="scholar-badge mb-2">⚖️ Catatan Ulama</div>
                                <p class="m-0 leading-relaxed">{{ $s['scholarNotes'][0] }}</p>
                            </div>
                        @endif

                        <!-- Practical Takeaway -->
                        @if (!empty($s['practicalLessons']))
                            <div class="p-4 rounded-2xl bg-emerald-950/30 border border-emerald-600/40 text-xs text-emerald-200/95">
                                <div class="font-black text-emerald-400 mb-1 flex items-center gap-1.5">
                                    <span>🌱</span> Pelajaran Praktis:
                                </div>
                                <p class="m-0 leading-relaxed">{{ $s['practicalLessons'][0] }}</p>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>

        <!-- 4. END SCREEN (Layar Penutup & Ajakan Beramal) -->
        <section id="journey-end" class="flex-1 max-w-2xl mx-auto px-4 py-12 flex flex-col justify-center text-center my-auto hidden">
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
            <div class="p-5 rounded-3xl bg-slate-900/80 border border-amber-500/25 mb-8 shadow-xl">
                <div class="text-xs font-mono font-bold text-amber-400 mb-3 uppercase tracking-wider">Ringkasan Peta Perjalanan</div>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5 text-[11px] font-bold">
                    @foreach ($stages as $s)
                        <div class="p-2.5 rounded-xl bg-slate-800/70 border {{ $s['id'] === 3 ? 'border-amber-400 text-amber-300 bg-amber-500/10' : 'border-slate-700/60 text-slate-300' }}">
                            {{ sprintf('%02d', $s['id']) }}. {{ $s['labelId'] }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Interactive Checklist "Bekal dari Tahap 3" -->
            <div class="p-6 rounded-3xl bg-emerald-950/40 border border-emerald-500/50 text-left mb-8 shadow-xl">
                <h4 class="text-xs font-mono uppercase tracking-wider font-black text-emerald-400 mb-3 flex items-center gap-2">
                    <span>🌱</span> Bekal dari Tahap 3 — Amal Hari Ini:
                </h4>
                <div class="space-y-3.5 text-xs text-slate-200">
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
                <button id="restart-journey-btn" class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-black text-xs transition-colors">
                    🔄 Ulangi Perjalanan
                </button>
                <button id="end-quiz-btn" class="px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-slate-950 font-black text-xs transition-colors shadow-lg shadow-orange-500/20">
                    ✍️ Uji Pemahaman (Kuis)
                </button>
                <button id="share-journey-btn" class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs transition-colors">
                    📤 Bagikan
                </button>
                <a href="{{ url('/') }}" class="px-5 py-3 rounded-2xl border border-white/20 text-slate-300 hover:text-white font-bold text-xs transition-colors no-underline">
                    🏠 Kembali ke Beranda
                </a>
            </div>
        </section>

        <!-- Footer: Adab, Disclaimer & Atribusi -->
        <footer class="mt-auto border-t border-white/10 px-4 py-8 text-center text-xs text-slate-400 bg-slate-950/60">
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
    <div id="glossary-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md hidden">
        <div class="w-full max-w-xl max-h-[85dvh] bg-slate-900 border border-amber-500/30 rounded-3xl p-6 shadow-2xl flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📖</span>
                    <h3 class="text-lg font-black text-white m-0">Kamus Istilah (Glosarium)</h3>
                </div>
                <button id="close-glossary-modal" class="text-slate-400 hover:text-white p-1 font-bold text-sm">✕</button>
            </div>

            <div class="mb-4">
                <input type="text" id="glossary-search-input" placeholder="Cari istilah (contoh: barzakh, mitsaq)..." class="w-full p-3 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-amber-400">
            </div>

            <div id="glossary-items-list" class="flex-1 overflow-y-auto space-y-3 pr-1">
                <!-- Dynamically rendered -->
            </div>
        </div>
    </div>

    <!-- 7. QUIZ MODAL -->
    <div id="quiz-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md hidden">
        <div class="w-full max-w-2xl max-h-[88dvh] bg-slate-900 border border-amber-500/30 rounded-3xl p-6 shadow-2xl flex flex-col">
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
    <div id="journey-toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 px-5 py-2.5 rounded-full bg-slate-900/95 border border-amber-500/50 text-amber-200 text-xs font-bold shadow-2xl z-50 transition-all duration-300 opacity-0 pointer-events-none translate-y-4">
    </div>

</body>
</html>
