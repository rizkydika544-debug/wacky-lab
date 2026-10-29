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
                                    <!-- Scene 03: Dunia (Horizon Senja, Siluet Musafir Melangkah, Lentera Bergoyang & Nafas Kehidupan) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <radialGradient id="sunGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#fffbeb" stop-opacity="1"/>
                                                <stop offset="35%" stop-color="#fef08a" stop-opacity="0.9"/>
                                                <stop offset="70%" stop-color="#f97316" stop-opacity="0.5"/>
                                                <stop offset="100%" stop-color="#c2410c" stop-opacity="0"/>
                                            </radialGradient>
                                            <radialGradient id="beaconGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#ff7849" stop-opacity="0.9"/>
                                                <stop offset="60%" stop-color="#ea580c" stop-opacity="0.4"/>
                                                <stop offset="100%" stop-color="#ea580c" stop-opacity="0"/>
                                            </radialGradient>
                                            <linearGradient id="duneGrad1" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#311b5e"/>
                                                <stop offset="100%" stop-color="#180b2b"/>
                                            </linearGradient>
                                            <linearGradient id="duneGrad2" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#1f113a"/>
                                                <stop offset="100%" stop-color="#090514"/>
                                            </linearGradient>
                                        </defs>

                                        <!-- Pulsing Corona of the Setting Sun -->
                                        <circle cx="250" cy="135" r="75" fill="url(#sunGlow)">
                                            <animate attributeName="r" values="70;82;70" dur="4s" repeatCount="indefinite" />
                                            <animate attributeName="opacity" values="0.75;1;0.75" dur="4s" repeatCount="indefinite" />
                                        </circle>
                                        <circle cx="250" cy="135" r="32" fill="#fffbeb" filter="drop-shadow(0 0 25px #fb923c)">
                                            <animate attributeName="r" values="30;34;30" dur="3s" repeatCount="indefinite" />
                                        </circle>

                                        <!-- Sun rays rotating slowly -->
                                        <g opacity="0.35">
                                            <animateTransform attributeName="transform" type="rotate" from="0 250 135" to="360 250 135" dur="45s" repeatCount="indefinite" />
                                            <line x1="250" y1="50" x2="250" y2="70" stroke="#fef08a" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="250" y1="200" x2="250" y2="220" stroke="#fef08a" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="165" y1="135" x2="185" y2="135" stroke="#fef08a" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="315" y1="135" x2="335" y2="135" stroke="#fef08a" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="190" y1="75" x2="205" y2="90" stroke="#fef08a" stroke-width="1.5" stroke-linecap="round"/>
                                            <line x1="295" y1="180" x2="310" y2="195" stroke="#fef08a" stroke-width="1.5" stroke-linecap="round"/>
                                            <line x1="190" y1="195" x2="205" y2="180" stroke="#fef08a" stroke-width="1.5" stroke-linecap="round"/>
                                            <line x1="295" y1="90" x2="310" y2="75" stroke="#fef08a" stroke-width="1.5" stroke-linecap="round"/>
                                        </g>

                                        <!-- Drifting Dust & Wind Particles of Dunya -->
                                        <circle cx="80" cy="120" r="1.5" fill="#fef08a" opacity="0.7">
                                            <animate attributeName="cx" values="20;480;20" dur="18s" repeatCount="indefinite"/>
                                            <animate attributeName="cy" values="140;110;140" dur="6s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="160" cy="95" r="2" fill="#ffd89a" opacity="0.6">
                                            <animate attributeName="cx" values="100;500;100" dur="14s" repeatCount="indefinite"/>
                                            <animate attributeName="cy" values="110;85;110" dur="7s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="340" cy="150" r="1.8" fill="#fef08a" opacity="0.8">
                                            <animate attributeName="cx" values="500;40;500" dur="20s" repeatCount="indefinite"/>
                                            <animate attributeName="cy" values="160;140;160" dur="5s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- Layer 1: Background Desert Dunes -->
                                        <path d="M 0 165 Q 130 140 250 155 T 500 148 L 500 240 L 0 240 Z" fill="url(#duneGrad1)" opacity="0.85"/>

                                        <!-- Layer 2: Foreground Desert Dunes -->
                                        <path d="M 0 178 Q 170 162 310 176 T 500 168 L 500 240 L 0 240 Z" fill="url(#duneGrad2)"/>
                                        <path d="M 0 178 Q 170 162 310 176 T 500 168" stroke="#f97316" stroke-width="1.5" opacity="0.65"/>

                                        <!-- Swaying Desert Date Palm Silhouettes -->
                                        <!-- Left Palm -->
                                        <g transform="translate(60, 125)">
                                            <path d="M 12 55 Q 16 30 10 0" stroke="#0f071f" stroke-width="4.5" stroke-linecap="round"/>
                                            <g>
                                                <animateTransform attributeName="transform" type="rotate" values="-3 10 0; 3 10 0; -3 10 0" dur="5s" repeatCount="indefinite"/>
                                                <path d="M 10 0 Q -10 -8 -22 6 M 10 0 Q 3 -16 6 -26 M 10 0 Q 25 -14 36 -4 M 10 0 Q 28 8 38 20 M 10 0 Q -8 10 -18 22" stroke="#0f071f" stroke-width="2.2" stroke-linecap="round"/>
                                            </g>
                                        </g>
                                        <!-- Right Distant Palm -->
                                        <g transform="translate(425, 138) scale(0.65)">
                                            <path d="M 12 55 Q 8 30 10 0" stroke="#0f071f" stroke-width="4.5" stroke-linecap="round"/>
                                            <g>
                                                <animateTransform attributeName="transform" type="rotate" values="2 10 0; -3 10 0; 2 10 0" dur="6s" repeatCount="indefinite"/>
                                                <path d="M 10 0 Q -10 -8 -22 6 M 10 0 Q 3 -16 6 -26 M 10 0 Q 25 -14 36 -4 M 10 0 Q 28 8 38 20" stroke="#0f071f" stroke-width="2.2" stroke-linecap="round"/>
                                            </g>
                                        </g>

                                        <!-- Ground Marker: Rippling Presence Beacon (Only on Dunya) -->
                                        <g transform="translate(250, 185)">
                                            <ellipse cx="0" cy="0" rx="35" ry="9" fill="url(#beaconGlow)">
                                                <animate attributeName="rx" values="25;45;25" dur="2.4s" repeatCount="indefinite"/>
                                                <animate attributeName="opacity" values="0.9;0.3;0.9" dur="2.4s" repeatCount="indefinite"/>
                                            </ellipse>
                                            <ellipse cx="0" cy="0" rx="50" ry="12" fill="none" stroke="#ea580c" stroke-width="1.5" stroke-dasharray="4 4">
                                                <animate attributeName="rx" values="30;65;30" dur="2.4s" repeatCount="indefinite"/>
                                                <animate attributeName="opacity" values="0.8;0;0.8" dur="2.4s" repeatCount="indefinite"/>
                                            </ellipse>
                                        </g>

                                        <!-- The Walking Human Musafir (Animated Breathing & Striding in Dunya) -->
                                        <g id="humanMusafir">
                                            <!-- Bobbing gait / walking movement -->
                                            <animateTransform attributeName="transform" type="translate" values="0 0; 0 -3.5; 0 0" dur="1.2s" repeatCount="indefinite"/>

                                            <!-- Upward floating deeds / prayer sparks from the human -->
                                            <circle cx="250" cy="115" r="2" fill="#fef08a" opacity="0.9">
                                                <animate attributeName="cy" values="120;30;20" dur="2.8s" repeatCount="indefinite"/>
                                                <animate attributeName="opacity" values="0.9;0.6;0" dur="2.8s" repeatCount="indefinite"/>
                                                <animate attributeName="cx" values="250;242;255" dur="2.8s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="253" cy="130" r="1.5" fill="#67e8f9" opacity="0.8">
                                                <animate attributeName="cy" values="135;45;35" dur="3.2s" repeatCount="indefinite"/>
                                                <animate attributeName="opacity" values="0.8;0.4;0" dur="3.2s" repeatCount="indefinite"/>
                                                <animate attributeName="cx" values="253;260;248" dur="3.2s" repeatCount="indefinite"/>
                                            </circle>

                                            <!-- Head with holy soul halo -->
                                            <circle cx="250" cy="112" r="8" fill="#ffffff" filter="drop-shadow(0 0 10px #ffffff)"/>
                                            <circle cx="250" cy="112" r="13" stroke="#fef08a" stroke-width="1.2" stroke-dasharray="2 3" opacity="0.75"/>

                                            <!-- Cloak / Torso (Walking posture) -->
                                            <path d="M 245 120 C 242 135 240 152 238 165 C 248 168 256 168 262 165 C 258 150 256 135 255 120 Z" fill="#ffffff" filter="drop-shadow(0 0 6px rgba(255,255,255,0.4))"/>

                                            <!-- Left Leg (Striding Forward) -->
                                            <path d="M 244 164 L 237 185" stroke="#ffffff" stroke-width="3" stroke-linecap="round">
                                                <animate attributeName="d" values="M 244 164 L 237 185; M 244 164 L 246 185; M 244 164 L 237 185" dur="1.2s" repeatCount="indefinite"/>
                                            </path>

                                            <!-- Right Leg (Trailing / Walking Push) -->
                                            <path d="M 256 164 L 261 185" stroke="#ffffff" stroke-width="3" stroke-linecap="round">
                                                <animate attributeName="d" values="M 256 164 L 261 185; M 256 164 L 253 185; M 256 164 L 261 185" dur="1.2s" repeatCount="indefinite"/>
                                            </path>

                                            <!-- Walking Staff Planted by Traveler -->
                                            <line x1="266" y1="102" x2="266" y2="186" stroke="#fef08a" stroke-width="2.2" stroke-linecap="round"/>

                                            <!-- Hanging Lantern on Staff with Pendulum Swing -->
                                            <g transform="translate(266, 120)">
                                                <g>
                                                    <animateTransform attributeName="transform" type="rotate" values="-18 0 0; 18 0 0; -18 0 0" dur="2s" repeatCount="indefinite"/>
                                                    <!-- Lantern cord -->
                                                    <line x1="0" y1="0" x2="0" y2="14" stroke="#fef08a" stroke-width="1.5"/>
                                                    <!-- Lantern body -->
                                                    <path d="M -4 14 L 4 14 L 5 22 L -5 22 Z" fill="#ea580c" stroke="#fef08a" stroke-width="1"/>
                                                    <!-- Glowing Lantern Flame -->
                                                    <circle cx="0" cy="18" r="4.5" fill="#fef08a" filter="drop-shadow(0 0 14px #f59e0b)"/>
                                                    <!-- Lantern Light Corona Pulsing -->
                                                    <circle cx="0" cy="18" r="18" fill="none" stroke="#fef08a" stroke-width="0.8" opacity="0.5">
                                                        <animate attributeName="r" values="14;22;14" dur="1.5s" repeatCount="indefinite"/>
                                                        <animate attributeName="opacity" values="0.7;0.2;0.7" dur="1.5s" repeatCount="indefinite"/>
                                                    </circle>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                @elseif ($stage['id'] === 4)
                                    <!-- Scene 04: Barzakh (Dinding Pembatas & 3 Aliran Cahaya Menjulang) -->
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
                                        <circle cx="250" cy="155" r="8" fill="#e8b57a" filter="drop-shadow(0 0 12px #e8b57a)">
                                            <animate attributeName="r" values="7;9;7" dur="2s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- 3 Continuous Radiant Light Streams Ascending to Heaven -->
                                        <!-- Stream 1: Sedekah Jariyah -->
                                        <path d="M 225 125 Q 160 50 140 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)">
                                            <animate attributeName="stroke-dashoffset" values="0;-32" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <circle cx="140" cy="25" r="4" fill="#fef08a" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="130" y="18" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Sedekah Jariyah</text>

                                        <!-- Stream 2: Ilmu Bermanfaat -->
                                        <path d="M 250 125 Q 250 50 250 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)">
                                            <animate attributeName="stroke-dashoffset" values="0;-32" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <circle cx="250" cy="25" r="4" fill="#fef08a" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="250" y="14" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Ilmu Bermanfaat</text>

                                        <!-- Stream 3: Doa Anak Saleh -->
                                        <path d="M 275 125 Q 340 50 360 25" stroke="#f59e0b" stroke-width="2.5" stroke-dasharray="4 4" fill="none" filter="drop-shadow(0 0 8px #f59e0b)">
                                            <animate attributeName="stroke-dashoffset" values="0;-32" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <circle cx="360" cy="25" r="4" fill="#fef08a" filter="drop-shadow(0 0 8px #f59e0b)"/>
                                        <text x="370" y="18" fill="#fef08a" font-size="9" font-weight="bold" text-anchor="middle">Doa Anak Saleh</text>
                                    </svg>
                                @elseif ($stage['id'] === 5)
                                    <!-- Scene 05: Sangkakala (Gelombang Suara Riak Kiamat) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Cosmic Shockwave Acoustic Rings -->
                                        <circle cx="250" cy="120" r="16" fill="#fef08a" filter="drop-shadow(0 0 25px #f59e0b)">
                                            <animate attributeName="r" values="14;18;14" dur="1.5s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="250" cy="120" r="35" stroke="#ffe9b0" stroke-width="2" opacity="0.9">
                                            <animate attributeName="r" values="20;160" dur="2.4s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.9;0" dur="2.4s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="250" cy="120" r="75" stroke="#ffe9b0" stroke-width="1.8" opacity="0.65">
                                            <animate attributeName="r" values="50;190" dur="2.4s" begin="0.8s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.7;0" dur="2.4s" begin="0.8s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="250" cy="120" r="115" stroke="#ffe9b0" stroke-width="1.2" opacity="0.4" stroke-dasharray="5 5">
                                            <animate attributeName="r" values="80;220" dur="2.4s" begin="1.6s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.5;0" dur="2.4s" begin="1.6s" repeatCount="indefinite"/>
                                        </circle>
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
                                        <circle cx="250" cy="60" r="55" fill="#fff0c8" opacity="0.95" filter="drop-shadow(0 0 40px #ea580c)">
                                            <animate attributeName="r" values="52;62;52" dur="2.5s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="250" cy="60" r="75" stroke="#f97316" stroke-width="1.5" opacity="0.4" stroke-dasharray="4 4">
                                            <animateTransform attributeName="transform" type="rotate" from="0 250 60" to="360 250 60" dur="25s" repeatCount="indefinite"/>
                                        </circle>
                                        <!-- Vast Plain of Mahsyar -->
                                        <ellipse cx="250" cy="190" rx="230" ry="35" fill="rgba(224,136,58,0.25)"/>
                                        <line x1="20" y1="190" x2="480" y2="190" stroke="#ea580c" stroke-width="2.5"/>
                                        <!-- Infinite crowd of light souls with shimmer -->
                                        @for ($i = 0; $i < 24; $i++)
                                            <circle cx="{{ 50 + $i * 18 }}" cy="{{ 180 + (($i * 7) % 15) }}" r="2.5" fill="#ffffff" opacity="{{ 0.5 + (($i % 5) * 0.1) }}">
                                                <animate attributeName="opacity" values="0.4;1;0.4" dur="{{ 1.5 + (($i % 3) * 0.5) }}s" repeatCount="indefinite"/>
                                            </circle>
                                        @endfor
                                    </svg>
                                @elseif ($stage['id'] === 7)
                                    <!-- Scene 07: Syafaat (Bentuk Cahaya Suci Para Nabi & Pilar Cahaya Agung Syafaat Kubra) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <!-- Divine Golden Syafaat Beam -->
                                            <linearGradient id="syafaatBeam" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                                                <stop offset="25%" stop-color="#fef08a" stop-opacity="0.9"/>
                                                <stop offset="60%" stop-color="#f59e0b" stop-opacity="0.6"/>
                                                <stop offset="100%" stop-color="#d97706" stop-opacity="0"/>
                                            </linearGradient>
                                            <radialGradient id="prophetAura" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                                                <stop offset="40%" stop-color="#fde047" stop-opacity="0.8"/>
                                                <stop offset="80%" stop-color="#f59e0b" stop-opacity="0.3"/>
                                                <stop offset="100%" stop-color="#f59e0b" stop-opacity="0"/>
                                            </radialGradient>
                                            <radialGradient id="holyOrbGrad" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#ffffff" stop-opacity="1"/>
                                                <stop offset="50%" stop-color="#ffd89a" stop-opacity="0.75"/>
                                                <stop offset="100%" stop-color="#eab308" stop-opacity="0"/>
                                            </radialGradient>
                                        </defs>

                                        <!-- Celestial Arcs of Syafaat Request Chain (From Nabi to Nabi) -->
                                        <path d="M 70 175 C 95 145 125 145 145 155" stroke="#fde047" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6">
                                            <animate attributeName="stroke-dashoffset" values="0;24" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <path d="M 145 155 C 170 125 190 125 205 135" stroke="#fde047" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6">
                                            <animate attributeName="stroke-dashoffset" values="0;24" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <path d="M 205 135 C 220 100 235 70 250 50" stroke="#fde047" stroke-width="2" stroke-dasharray="4 4" opacity="0.8">
                                            <animate attributeName="stroke-dashoffset" values="0;24" dur="1.5s" repeatCount="indefinite"/>
                                        </path>
                                        <path d="M 430 175 C 405 145 375 145 355 155" stroke="#fde047" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6">
                                            <animate attributeName="stroke-dashoffset" values="0;-24" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <path d="M 355 155 C 330 125 310 125 295 135" stroke="#fde047" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.6">
                                            <animate attributeName="stroke-dashoffset" values="0;-24" dur="2s" repeatCount="indefinite"/>
                                        </path>
                                        <path d="M 295 135 C 280 100 265 70 250 50" stroke="#fde047" stroke-width="2" stroke-dasharray="4 4" opacity="0.8">
                                            <animate attributeName="stroke-dashoffset" values="0;-24" dur="1.5s" repeatCount="indefinite"/>
                                        </path>

                                        <!-- Central Grand Pillar of Light: Maqam Mahmud / Syafaat Kubra -->
                                        <polygon points="190,240 238,30 262,30 310,240" fill="url(#syafaatBeam)" opacity="0.85">
                                            <animate attributeName="opacity" values="0.7;0.95;0.7" dur="3s" repeatCount="indefinite"/>
                                        </polygon>

                                        <!-- Expanding Radiance Rings of Mercy from Syafaat Nabi Muhammad ﷺ -->
                                        <circle cx="250" cy="45" r="25" fill="none" stroke="#fde047" stroke-width="2" opacity="0.8">
                                            <animate attributeName="r" values="20;75;20" dur="3.5s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.9;0;0.9" dur="3.5s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="250" cy="45" r="45" fill="none" stroke="#ffffff" stroke-width="1.5" stroke-dasharray="4 6" opacity="0.6">
                                            <animate attributeName="r" values="35;105;35" dur="3.5s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.7;0;0.7" dur="3.5s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- Central Syafaat Apex Light (Nabi Muhammad ﷺ - Nuur / Sacred Light) -->
                                        <g transform="translate(250, 45)">
                                            <!-- Rotating Starburst Light -->
                                            <g opacity="0.9">
                                                <animateTransform attributeName="transform" type="rotate" from="0 0 0" to="360 0 0" dur="25s" repeatCount="indefinite"/>
                                                <path d="M 0 -35 L 5 -10 L 35 0 L 5 10 L 0 35 L -5 10 L -35 0 L -5 -10 Z" fill="#ffffff" filter="drop-shadow(0 0 15px #fde047)"/>
                                                <path d="M -22 -22 L -7 -5 L 0 -22 L 7 -5 L 22 -22 L 5 -7 L 22 0 L 5 7 L 22 22 L 7 5 L 0 22 L -7 5 L -22 22 L -5 7 L -22 0 L -5 -7 Z" fill="#fde047" opacity="0.7"/>
                                            </g>
                                            <circle cx="0" cy="0" r="30" fill="url(#prophetAura)"/>
                                            <circle cx="0" cy="0" r="14" fill="#ffffff" filter="drop-shadow(0 0 25px #ffffff)">
                                                <animate attributeName="r" values="12;16;12" dur="2s" repeatCount="indefinite"/>
                                            </circle>
                                        </g>

                                        <!-- Floating Upward Shalawat / Mercy Light Orbs -->
                                        <circle cx="235" cy="180" r="3" fill="#ffffff" filter="drop-shadow(0 0 8px #fde047)">
                                            <animate attributeName="cy" values="220;60;220" dur="4s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;1;0" dur="4s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="265" cy="150" r="2.5" fill="#fef08a" filter="drop-shadow(0 0 8px #f59e0b)">
                                            <animate attributeName="cy" values="210;50;210" dur="3.2s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;1;0" dur="3.2s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="248" cy="120" r="2" fill="#ffffff">
                                            <animate attributeName="cy" values="200;40;200" dur="2.8s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;1;0" dur="2.8s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- Stations of Prophetic Light Orbs (Adam, Nuh, Ibrahim, Musa, Isa) -->
                                        <!-- 1. Cahaya Nabi Adam ('Alaihissalam) -->
                                        <g transform="translate(70, 175)">
                                            <circle cx="0" cy="0" r="18" fill="url(#holyOrbGrad)"/>
                                            <circle cx="0" cy="0" r="7" fill="#ffffff" filter="drop-shadow(0 0 12px #fde047)">
                                                <animate attributeName="r" values="6;8;6" dur="2.2s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="0" cy="0" r="12" stroke="#fde047" stroke-width="1" stroke-dasharray="2 3" opacity="0.7">
                                                <animateTransform attributeName="transform" type="rotate" from="0 0 0" to="360 0 0" dur="12s" repeatCount="indefinite"/>
                                            </circle>
                                            <text x="0" y="24" fill="#fef08a" font-size="9" font-weight="900" text-anchor="middle" filter="drop-shadow(0 0 4px rgba(0,0,0,0.8))">Nabi Adam (ع)</text>
                                        </g>

                                        <!-- 2. Cahaya Nabi Nuh ('Alaihissalam) -->
                                        <g transform="translate(145, 155)">
                                            <circle cx="0" cy="0" r="18" fill="url(#holyOrbGrad)"/>
                                            <circle cx="0" cy="0" r="7" fill="#ffffff" filter="drop-shadow(0 0 12px #fde047)">
                                                <animate attributeName="r" values="6;8;6" dur="2.5s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="0" cy="0" r="12" stroke="#fde047" stroke-width="1" stroke-dasharray="2 3" opacity="0.7">
                                                <animateTransform attributeName="transform" type="rotate" from="360 0 0" to="0 0 0" dur="14s" repeatCount="indefinite"/>
                                            </circle>
                                            <text x="0" y="24" fill="#fef08a" font-size="9" font-weight="900" text-anchor="middle" filter="drop-shadow(0 0 4px rgba(0,0,0,0.8))">Nabi Nuh (ع)</text>
                                        </g>

                                        <!-- 3. Cahaya Nabi Ibrahim ('Alaihissalam) -->
                                        <g transform="translate(205, 135)">
                                            <circle cx="0" cy="0" r="20" fill="url(#holyOrbGrad)"/>
                                            <circle cx="0" cy="0" r="8" fill="#ffffff" filter="drop-shadow(0 0 14px #fde047)">
                                                <animate attributeName="r" values="7;9;7" dur="2s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="0" cy="0" r="14" stroke="#fde047" stroke-width="1.2" stroke-dasharray="3 3" opacity="0.8">
                                                <animateTransform attributeName="transform" type="rotate" from="0 0 0" to="360 0 0" dur="10s" repeatCount="indefinite"/>
                                            </circle>
                                            <text x="0" y="25" fill="#fef08a" font-size="9" font-weight="900" text-anchor="middle" filter="drop-shadow(0 0 4px rgba(0,0,0,0.8))">Nabi Ibrahim (ع)</text>
                                        </g>

                                        <!-- 4. Cahaya Nabi Musa ('Alaihissalam) -->
                                        <g transform="translate(295, 135)">
                                            <circle cx="0" cy="0" r="20" fill="url(#holyOrbGrad)"/>
                                            <circle cx="0" cy="0" r="8" fill="#ffffff" filter="drop-shadow(0 0 14px #fde047)">
                                                <animate attributeName="r" values="7;9;7" dur="2.1s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="0" cy="0" r="14" stroke="#fde047" stroke-width="1.2" stroke-dasharray="3 3" opacity="0.8">
                                                <animateTransform attributeName="transform" type="rotate" from="360 0 0" to="0 0 0" dur="10s" repeatCount="indefinite"/>
                                            </circle>
                                            <text x="0" y="25" fill="#fef08a" font-size="9" font-weight="900" text-anchor="middle" filter="drop-shadow(0 0 4px rgba(0,0,0,0.8))">Nabi Musa (ع)</text>
                                        </g>

                                        <!-- 5. Cahaya Nabi Isa ('Alaihissalam) -->
                                        <g transform="translate(355, 155)">
                                            <circle cx="0" cy="0" r="18" fill="url(#holyOrbGrad)"/>
                                            <circle cx="0" cy="0" r="7" fill="#ffffff" filter="drop-shadow(0 0 12px #fde047)">
                                                <animate attributeName="r" values="6;8;6" dur="2.3s" repeatCount="indefinite"/>
                                            </circle>
                                            <circle cx="0" cy="0" r="12" stroke="#fde047" stroke-width="1" stroke-dasharray="2 3" opacity="0.7">
                                                <animateTransform attributeName="transform" type="rotate" from="0 0 0" to="360 0 0" dur="13s" repeatCount="indefinite"/>
                                            </circle>
                                            <text x="0" y="24" fill="#fef08a" font-size="9" font-weight="900" text-anchor="middle" filter="drop-shadow(0 0 4px rgba(0,0,0,0.8))">Nabi Isa (ع)</text>
                                        </g>

                                        <!-- Center Label: Maqam Mahmud Syafaat Kubra Nabi Muhammad ﷺ -->
                                        <g transform="translate(250, 92)">
                                            <rect x="-105" y="-12" width="210" height="22" rx="11" fill="rgba(15,23,42,0.85)" stroke="#f59e0b" stroke-width="1.2" filter="drop-shadow(0 0 12px rgba(245,158,11,0.5))"/>
                                            <text x="0" y="3" fill="#fef08a" font-size="9.5" font-weight="900" letter-spacing="1" text-anchor="middle">
                                                ✦ SYAFAAT RASULULLAH ﷺ ✦
                                            </text>
                                        </g>
                                    </svg>
                                @elseif ($stage['id'] === 8)
                                    <!-- Scene 08: Timbangan Al-Mizan (Keadilan Hakiki, Palang Neraca Bergoyang Dinamis & Bobot Amal) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <defs>
                                            <!-- Good Deeds Glow (Emerald & Gold) -->
                                            <radialGradient id="goodDeedsGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#86efac" stop-opacity="1"/>
                                                <stop offset="50%" stop-color="#22c55e" stop-opacity="0.8"/>
                                                <stop offset="100%" stop-color="#15803d" stop-opacity="0"/>
                                            </radialGradient>
                                            <!-- Bad Deeds Glow (Dim Crimson & Smoke) -->
                                            <radialGradient id="badDeedsGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#f87171" stop-opacity="0.9"/>
                                                <stop offset="50%" stop-color="#dc2626" stop-opacity="0.6"/>
                                                <stop offset="100%" stop-color="#7f1d1d" stop-opacity="0"/>
                                            </radialGradient>
                                            <radialGradient id="apexGlow" cx="50%" cy="50%" r="50%">
                                                <stop offset="0%" stop-color="#fffbeb" stop-opacity="1"/>
                                                <stop offset="50%" stop-color="#f59e0b" stop-opacity="0.7"/>
                                                <stop offset="100%" stop-color="#b45309" stop-opacity="0"/>
                                            </radialGradient>
                                        </defs>

                                        <!-- Celestial Apex Dome & Crown of Al-Mizan -->
                                        <path d="M 235 38 Q 250 14 265 38 Z" fill="#fde047" stroke="#f59e0b" stroke-width="1.5"/>
                                        <circle cx="250" cy="18" r="6" fill="#ffffff" filter="drop-shadow(0 0 12px #fde047)">
                                            <animate attributeName="r" values="5;7;5" dur="2s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- Main Solid Pillar of Truth (Al-Haqq) -->
                                        <line x1="250" y1="36" x2="250" y2="205" stroke="#ffe0a0" stroke-width="4.5" stroke-linecap="round"/>
                                        <line x1="250" y1="36" x2="250" y2="205" stroke="#ffffff" stroke-width="1" opacity="0.8"/>
                                        <!-- Base Pedestal -->
                                        <path d="M 220 215 L 280 215 L 290 225 L 210 225 Z" fill="#ffe0a0" stroke="#f59e0b" stroke-width="1.5"/>
                                        <circle cx="250" cy="220" r="3" fill="#ffffff"/>

                                        <!-- Central Fulcrum Pivot Ring -->
                                        <circle cx="250" cy="65" r="14" fill="url(#apexGlow)"/>
                                        <circle cx="250" cy="65" r="9" fill="#f59e0b" stroke="#ffffff" stroke-width="1.8"/>
                                        <circle cx="250" cy="65" r="3" fill="#ffffff"/>

                                        <!-- Central Fulcrum Needle (Lisanul Mizan) - tilts to show justice -->
                                        <polygon points="248,65 252,65 250,42" fill="#ffffff" filter="drop-shadow(0 0 6px #ffffff)"/>

                                        <!-- Falling Deed Atoms (Mitsqala Dzarrah - Biji Sawi Amal Jatuh ke Timbangan) -->
                                        <!-- Falling Good Deed Particles (Golden White) -->
                                        <circle cx="130" cy="40" r="3.5" fill="#fef08a" filter="drop-shadow(0 0 8px #86efac)">
                                            <animate attributeName="cy" values="25;145;145" dur="2.4s" repeatCount="indefinite"/>
                                            <animate attributeName="cx" values="125;130;130" dur="2.4s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;1;0" dur="2.4s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="145" cy="50" r="2.5" fill="#86efac" filter="drop-shadow(0 0 6px #22c55e)">
                                            <animate attributeName="cy" values="35;150;150" dur="3s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;1;0" dur="3s" repeatCount="indefinite"/>
                                        </circle>
                                        <!-- Falling Bad Deed Particles (Dark Crimson) -->
                                        <circle cx="365" cy="45" r="2.5" fill="#f87171" opacity="0.8">
                                            <animate attributeName="cy" values="25;105;105" dur="3.5s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0;0.9;0" dur="3.5s" repeatCount="indefinite"/>
                                        </circle>

                                        <!-- DYNAMIC SWAYING BALANCE ASSEMBLY -->
                                        <!-- The whole beam swings with continuous gentle oscillation, with Left Pan (Good Deeds) heavier and lowered -->
                                        <g id="mizanAssembly">
                                            <animateTransform attributeName="transform" type="rotate" values="-8 250 65; -5 250 65; -11 250 65; -8 250 65" dur="4.5s" repeatCount="indefinite" additive="sum"/>

                                            <!-- The Ornate Horizontal Crossbeam -->
                                            <path d="M 125 65 Q 185 61 250 65 Q 315 69 375 65" stroke="#ffe0a0" stroke-width="4.5" stroke-linecap="round"/>
                                            <path d="M 125 65 Q 185 61 250 65 Q 315 69 375 65" stroke="#ffffff" stroke-width="1.2" opacity="0.8"/>
                                            <!-- Crossbeam Decorative End Knobs -->
                                            <circle cx="125" cy="65" r="5" fill="#f59e0b" stroke="#ffffff" stroke-width="1"/>
                                            <circle cx="375" cy="65" r="5" fill="#f59e0b" stroke="#ffffff" stroke-width="1"/>

                                            <!-- LEFT SIDE: AMAL KEBAIKAN (HEAVIER, WEIGHTED DOWN) -->
                                            <!-- Suspension Chains for Left Pan -->
                                            <line x1="125" y1="65" x2="105" y2="148" stroke="#ffe0a0" stroke-width="1.5" stroke-dasharray="3 3"/>
                                            <line x1="125" y1="65" x2="145" y2="148" stroke="#ffe0a0" stroke-width="1.5" stroke-dasharray="3 3"/>
                                            <line x1="125" y1="65" x2="125" y2="148" stroke="#ffe0a0" stroke-width="1.2" stroke-dasharray="2 3"/>

                                            <!-- Left Pan (Deep, Golden & Glowing with Heavy Hasanat) -->
                                            <g transform="translate(0, 0)">
                                                <ellipse cx="125" cy="148" rx="36" ry="11" fill="rgba(34,197,94,0.3)" stroke="#ffe0a0" stroke-width="2.5" filter="drop-shadow(0 0 16px rgba(34,197,94,0.7))"/>
                                                <path d="M 89 148 Q 125 178 161 148 Z" fill="rgba(245,158,11,0.4)" stroke="#ffe0a0" stroke-width="2.5"/>

                                                <!-- Piled Radiant Gems / Crystals of Good Deeds -->
                                                <circle cx="125" cy="142" r="22" fill="url(#goodDeedsGlow)"/>
                                                <circle cx="115" cy="144" r="5" fill="#ffffff" filter="drop-shadow(0 0 8px #86efac)">
                                                    <animate attributeName="r" values="4;6;4" dur="2s" repeatCount="indefinite"/>
                                                </circle>
                                                <circle cx="128" cy="140" r="6" fill="#fef08a" filter="drop-shadow(0 0 10px #f59e0b)">
                                                    <animate attributeName="r" values="5;7;5" dur="2.4s" repeatCount="indefinite"/>
                                                </circle>
                                                <circle cx="138" cy="145" r="4.5" fill="#86efac" filter="drop-shadow(0 0 6px #22c55e)">
                                                    <animate attributeName="r" values="3.5;5.5;3.5" dur="1.8s" repeatCount="indefinite"/>
                                                </circle>
                                                <circle cx="125" cy="132" r="4" fill="#ffffff"/>
                                            </g>

                                            <!-- RIGHT SIDE: AMAL KEBURUKAN (LIGHTER, ELEVATED UP) -->
                                            <!-- Suspension Chains for Right Pan -->
                                            <line x1="375" y1="65" x2="355" y2="118" stroke="#ffe0a0" stroke-width="1.5" stroke-dasharray="3 3"/>
                                            <line x1="375" y1="65" x2="395" y2="118" stroke="#ffe0a0" stroke-width="1.5" stroke-dasharray="3 3"/>
                                            <line x1="375" y1="65" x2="375" y2="118" stroke="#ffe0a0" stroke-width="1.2" stroke-dasharray="2 3"/>

                                            <!-- Right Pan (Shallow, Dim & Elevated with Light Sayyiat) -->
                                            <g transform="translate(0, 0)">
                                                <ellipse cx="375" cy="118" rx="34" ry="10" fill="rgba(220,38,38,0.2)" stroke="#a16207" stroke-width="2" filter="drop-shadow(0 0 10px rgba(220,38,38,0.4))"/>
                                                <path d="M 341 118 Q 375 142 409 118 Z" fill="rgba(127,29,29,0.3)" stroke="#a16207" stroke-width="2"/>

                                                <!-- Sparse Dim Embers of Bad Deeds -->
                                                <circle cx="375" cy="115" r="16" fill="url(#badDeedsGlow)"/>
                                                <circle cx="368" cy="116" r="3.5" fill="#f87171" opacity="0.8">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2s" repeatCount="indefinite"/>
                                                </circle>
                                                <circle cx="382" cy="117" r="3" fill="#ea580c" opacity="0.7"/>
                                                <circle cx="374" cy="112" r="2.5" fill="#fca5a5" opacity="0.6"/>
                                            </g>
                                        </g>

                                        <!-- Clear Visual Weight Labels Beneath the Pans -->
                                        <!-- Left Pan Label: AMAL KEBAIKAN (BERAT / MENANG) -->
                                        <g transform="translate(125, 204)">
                                            <rect x="-65" y="-10" width="130" height="20" rx="10" fill="rgba(20,83,45,0.7)" stroke="#22c55e" stroke-width="1.2" filter="drop-shadow(0 0 8px rgba(34,197,94,0.5))"/>
                                            <text x="0" y="3.5" fill="#bbf7d0" font-size="9" font-weight="900" letter-spacing="0.5" text-anchor="middle">
                                                ⚖️ AMAL KEBAIKAN (BERAT)
                                            </text>
                                        </g>

                                        <!-- Right Pan Label: AMAL KEBURUKAN (RINGAN) -->
                                        <g transform="translate(375, 172)">
                                            <rect x="-62" y="-10" width="124" height="20" rx="10" fill="rgba(69,10,10,0.6)" stroke="#ef4444" stroke-width="1.2"/>
                                            <text x="0" y="3.5" fill="#fca5a5" font-size="9" font-weight="900" letter-spacing="0.5" text-anchor="middle">
                                                AMAL KEBURUKAN
                                            </text>
                                        </g>
                                    </svg>
                                @elseif ($stage['id'] === 9)
                                    <!-- Scene 09: Telaga Al-Hawdh (Kesejukan Putih Susu) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- The Pristine Heavenly Oasis -->
                                        <ellipse cx="250" cy="140" rx="190" ry="70" fill="rgba(207,225,245,0.35)" stroke="#ffffff" stroke-width="2.5" filter="drop-shadow(0 0 35px rgba(255,255,255,0.8))"/>
                                        <ellipse cx="250" cy="140" rx="140" ry="48" fill="none" stroke="#ffffff" stroke-width="1.2" opacity="0.6">
                                            <animate attributeName="rx" values="130;160;130" dur="4s" repeatCount="indefinite"/>
                                        </ellipse>
                                        <ellipse cx="250" cy="140" rx="130" ry="45" fill="rgba(255,255,255,0.7)"/>
                                        <ellipse cx="250" cy="140" rx="70" ry="25" fill="#ffffff" filter="drop-shadow(0 0 15px #ffffff)">
                                            <animate attributeName="rx" values="65;75;65" dur="3s" repeatCount="indefinite"/>
                                        </ellipse>
                                        <!-- Celestial Dew Goblets -->
                                        <circle cx="160" cy="135" r="4" fill="#ffffff">
                                            <animate attributeName="cy" values="133;137;133" dur="2s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="340" cy="145" r="4" fill="#ffffff">
                                            <animate attributeName="cy" values="143;147;143" dur="2.2s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="210" cy="155" r="3" fill="#cfe1f5"/>
                                        <circle cx="290" cy="125" r="3" fill="#cfe1f5"/>
                                    </svg>
                                @elseif ($stage['id'] === 10)
                                    <!-- Scene 10: Pemisahan (Tamyiz Dua Jalan) -->
                                    <svg class="scene-svg" viewBox="0 0 500 240" fill="none" aria-hidden="true">
                                        <!-- Divine Dividing Line -->
                                        <line x1="250" y1="20" x2="250" y2="220" stroke="#c8d4ff" stroke-width="2.5" stroke-dasharray="6 6" filter="drop-shadow(0 0 12px #c8d4ff)">
                                            <animate attributeName="stroke-dashoffset" values="0;24" dur="2s" repeatCount="indefinite"/>
                                        </line>
                                        <!-- Left Ascending Path of Faith -->
                                        <path d="M 230 130 Q 150 110 80 120" stroke="#60a5fa" stroke-width="3" opacity="0.9" filter="drop-shadow(0 0 10px #60a5fa)"/>
                                        <circle cx="80" cy="120" r="6" fill="#ffffff" filter="drop-shadow(0 0 10px #60a5fa)">
                                            <animate attributeName="r" values="5;7;5" dur="1.8s" repeatCount="indefinite"/>
                                        </circle>
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
                                        <!-- Speeding lightning soul crossing across -->
                                        <circle cx="220" cy="110" r="6" fill="#ffffff" filter="drop-shadow(0 0 14px #ffffff)">
                                            <animate attributeName="cx" values="30;470" dur="1.8s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="340" cy="110" r="4.5" fill="#fef08a" filter="drop-shadow(0 0 10px #f59e0b)"/>
                                        <!-- Stray embers in abyss rising -->
                                        <circle cx="150" cy="190" r="2.5" fill="#ef4444" opacity="0.6">
                                            <animate attributeName="cy" values="210;165" dur="2s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.8;0" dur="2s" repeatCount="indefinite"/>
                                        </circle>
                                        <circle cx="380" cy="180" r="2" fill="#f97316" opacity="0.6">
                                            <animate attributeName="cy" values="200;165" dur="2.5s" repeatCount="indefinite"/>
                                            <animate attributeName="opacity" values="0.8;0" dur="2.5s" repeatCount="indefinite"/>
                                        </circle>
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
                                        <circle cx="250" cy="80" r="90" fill="url(#heavenBurst)">
                                            <animate attributeName="r" values="85;105;85" dur="3s" repeatCount="indefinite"/>
                                        </circle>
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
