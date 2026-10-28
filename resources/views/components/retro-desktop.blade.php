<section id="os">
    <h2><span>💻</span> Komputer jadul (Windows 98)</h2>
    <p class="sub">
        Geser jendelanya, tumpuk, dengarkan nada 8-bit Winamp, atau buka kembali aplikasi lewat tombol Start.
    </p>

    <div class="desk" id="desk">
        <!-- Desktop shortcut icons -->
        <div class="desk-bg-icons">
            <div class="desk-icon" id="icon-tentang">
                <span class="text-3xl">📝</span>
                <span>Tentang.txt</span>
            </div>
            <div class="desk-icon" id="icon-winamp">
                <span class="text-3xl">📻</span>
                <span>Winamp.exe</span>
            </div>
            <div class="desk-icon" id="icon-terminal">
                <span class="text-3xl">📟</span>
                <span>Lab.exe</span>
            </div>
        </div>

        <!-- Window 1: Tentang.txt -->
        <div class="win" id="w1" style="left: 100px; top: 20px;">
            <div class="tb">
                <span>📝 Tentang.txt</span>
                <b>x</b>
            </div>
            <div class="wb">
                <p class="m-0 leading-relaxed font-sans text-xs">
                    Halo, gue <strong>Rizky Dika</strong>! Siswa RPL yang antusias membangun aplikasi Android (Kotlin, Jetpack Compose) dan bereksperimen dengan web interaktif serta Blender 3D.
                </p>
                <div class="mt-3 pt-2 border-t border-[#808080] text-[11px] text-[#404040]">
                    Tip: Coba seret pizza ke arah kucing di pojok kanan bawah! 🍕🐱
                </div>
            </div>
        </div>

        <!-- Window 2: Winamp-ish player -->
        <div class="win" id="w2" style="left: 40px; top: 190px;">
            <div class="tb">
                <span>📻 Winamp-ish Chiptune</span>
                <b>x</b>
            </div>
            <div class="wb">
                <div class="text-[11px] font-mono text-center font-bold mb-1 text-[#000080]">
                    Track: 8-Bit Retro Bounce.mid
                </div>
                <div class="eq"></div>
                <div class="flex items-center justify-between gap-2 mt-2">
                    <button class="btn text-xs py-1 px-3" id="play" style="box-shadow: none;">
                        ▶ Putar
                    </button>
                    <span class="text-[11px] font-mono text-[#404040]">Web Audio API</span>
                </div>
            </div>
        </div>

        <!-- Window 3: Terminal.exe -->
        <div class="win" id="w3" style="left: 140px; top: 140px; display: none;">
            <div class="tb">
                <span>📟 WackyLab Command Prompt</span>
                <b>x</b>
            </div>
            <div class="wb bg-black text-[#00ff66] font-mono text-xs p-3">
                <p class="m-0">C:\WACKY-LAB> sysinfo</p>
                <p class="m-0 text-[#a0ffa0]">OS: WackyOS 98 Special Edition</p>
                <p class="m-0 text-[#a0ffa0]">Memory: 64 MB EDO RAM</p>
                <p class="m-0 text-[#a0ffa0]">Physics Engine: Matter.js 2D</p>
                <p class="mt-2 m-0 text-white">Hint: Tekan spasi untuk ledakan konfeti!</p>
            </div>
        </div>

        <!-- Start menu popup -->
        <div id="start-menu" style="display: none; position: absolute; left: 2px; bottom: 40px; width: 190px; background: #c0c0c0; border: 2px solid; border-color: #fff #404040 #404040 #fff; box-shadow: 3px 3px 6px rgba(0,0,0,0.4); z-index: 50; font-family: system-ui;">
            <div style="background: linear-gradient(180deg, #000080, #1084d0); color: #fff; padding: 6px; font-weight: 900; font-size: 13px;">
                WackyLab 98
            </div>
            <div style="padding: 4px; display: flex; flex-direction: column; gap: 2px; font-size: 12px; color: #000;">
                <button class="text-left px-2 py-1 hover:bg-[#000080] hover:text-white flex items-center gap-2 border-0 bg-transparent cursor-pointer" onclick="document.querySelectorAll('.win').forEach(w => w.style.display='block');">
                    <span>🪟</span> Buka Semua Jendela
                </button>
                <button class="text-left px-2 py-1 hover:bg-[#000080] hover:text-white flex items-center gap-2 border-0 bg-transparent cursor-pointer" onclick="document.getElementById('w1').style.display='block';">
                    <span>📝</span> Tentang.txt
                </button>
                <button class="text-left px-2 py-1 hover:bg-[#000080] hover:text-white flex items-center gap-2 border-0 bg-transparent cursor-pointer" onclick="document.getElementById('w2').style.display='block';">
                    <span>📻</span> Winamp Player
                </button>
                <button class="text-left px-2 py-1 hover:bg-[#000080] hover:text-white flex items-center gap-2 border-0 bg-transparent cursor-pointer" onclick="document.getElementById('w3').style.display='block';">
                    <span>📟</span> Terminal Prompt
                </button>
            </div>
        </div>

        <!-- Taskbar -->
        <div class="tk">
            <button id="start">
                <span class="text-sm">🪟</span> Start
            </button>
            <div class="flex items-center gap-2">
                <span class="text-xs font-normal hidden sm:inline text-[#333]">WackyOS 98</span>
                <div class="tk-tray">
                    <span id="clk">12:00:00</span>
                </div>
            </div>
        </div>
    </div>
</section>

