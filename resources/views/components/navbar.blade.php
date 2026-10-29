<header class="sticky top-4 z-40 px-4 mb-4">
    <nav class="max-w-4xl mx-auto bg-[var(--card)] border-3 border-[var(--ink)] rounded-2xl px-4 py-3 shadow-[var(--shadow)] flex flex-wrap items-center justify-between gap-3">
        <a href="#hero" class="flex items-center gap-2 font-black text-xl tracking-tight no-underline text-[var(--ink)] hover:scale-105 transition-transform">
            <span class="text-2xl animate-spin" style="animation-duration: 8s;">🌀</span>
            <span>WACKY LAB</span>
        </a>

        <div class="flex items-center flex-wrap gap-2 text-sm font-bold">
            <a href="{{ url('/perjalanan-12-tahap') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--pk)] text-white hover:bg-[var(--yl)] hover:text-[var(--ink)] transition-all no-underline flex items-center gap-1.5 shadow-[2px_2px_0_var(--ink)] font-black" title="Pelajari 12 Tahap Perjalanan Manusia Menurut Dalil">
                <span>🌌</span>
                <span class="hidden sm:inline">Perjalanan 12 Tahap</span>
                <span class="sm:hidden">12 Tahap</span>
            </a>
            <a href="{{ url('/#badge') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--bg)] text-[var(--ink)] hover:bg-[var(--yl)] transition-colors no-underline">
                🪪 ID
            </a>
            <a href="{{ url('/#os') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--bg)] text-[var(--ink)] hover:bg-[var(--gr)] transition-colors no-underline">
                💻 Win98
            </a>
            <a href="{{ url('/#chaos') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--bg)] text-[var(--ink)] hover:bg-[var(--pk)] hover:text-white transition-colors no-underline">
                ⚡ Chaos
            </a>
            <a href="{{ url('/#stk') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--bg)] text-[var(--ink)] hover:bg-[var(--bl)] hover:text-white transition-colors no-underline">
                🎨 Stiker
            </a>
            <a href="{{ url('/#kupon') }}" class="px-3 py-1.5 rounded-xl border-2 border-[var(--ink)] bg-[var(--bg)] text-[var(--ink)] hover:bg-[var(--yl)] transition-colors no-underline">
                🪙 Kupon
            </a>
        </div>

        <div class="flex items-center gap-2">
            <button id="audio-toggle-btn" class="btn text-xs py-1.5 px-3 border-2" aria-pressed="false" title="Nyalakan efek suara 8-bit">
                🔈 Suara: OFF
            </button>
            <button id="theme-toggle-btn" class="btn text-xs py-1.5 px-3 border-2" title="Ganti Mode Terang / Gelap">
                🌙 Mode Gelap
            </button>
        </div>
    </nav>
</header>

