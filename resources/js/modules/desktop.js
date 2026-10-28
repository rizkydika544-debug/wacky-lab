import { beep, toggleWinampMusic } from './audio.js';

let topZIndex = 20;

export function makeDraggable(el, handle, bringToFront = true) {
  let offsetX = 0;
  let offsetY = 0;
  let isDragging = false;

  handle.addEventListener('pointerdown', (e) => {
    isDragging = true;
    handle.setPointerCapture(e.pointerId);
    offsetX = e.clientX - el.offsetLeft;
    offsetY = e.clientY - el.offsetTop;

    if (bringToFront) {
      el.style.zIndex = ++topZIndex;
    }
    e.preventDefault();
    e.stopPropagation();
  });

  handle.addEventListener('pointermove', (e) => {
    if (!isDragging) return;
    const parent = el.parentElement;
    const maxX = parent.clientWidth - el.offsetWidth;
    const maxY = parent.clientHeight - el.offsetHeight;
    el.style.left = `${Math.max(0, Math.min(maxX, e.clientX - offsetX))}px`;
    el.style.top = `${Math.max(0, Math.min(maxY, e.clientY - offsetY))}px`;
  });

  const stopDrag = () => { isDragging = false; };
  handle.addEventListener('pointerup', stopDrag);
  handle.addEventListener('pointercancel', stopDrag);
}

export function initDesktop() {
  const desk = document.getElementById('desk');
  if (!desk) return;

  // Make windows draggable and closable
  const windows = desk.querySelectorAll('.win');
  windows.forEach(win => {
    const titleBar = win.querySelector('.tb');
    if (titleBar) {
      makeDraggable(win, titleBar, true);
    }
    const closeBtn = win.querySelector('.tb b');
    if (closeBtn) {
      closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        win.style.display = 'none';
        beep(250, 0.08);
      });
    }
    win.addEventListener('pointerdown', () => {
      win.style.zIndex = ++topZIndex;
    });
  });

  // Start button & Start Menu
  const startBtn = document.getElementById('start');
  const startMenu = document.getElementById('start-menu');
  if (startBtn) {
    startBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (startMenu) {
        const isShown = startMenu.style.display === 'block';
        startMenu.style.display = isShown ? 'none' : 'block';
      }
      windows.forEach(w => { w.style.display = 'block'; });
      beep(500, 0.09);
    });
  }

  // Click outside to close start menu
  document.addEventListener('click', (e) => {
    if (startMenu && !startMenu.contains(e.target) && e.target !== startBtn) {
      startMenu.style.display = 'none';
    }
  });

  // Desktop shortcut icons
  const iconTentang = document.getElementById('icon-tentang');
  const iconWinamp = document.getElementById('icon-winamp');
  const iconTerminal = document.getElementById('icon-terminal');

  if (iconTentang) {
    iconTentang.addEventListener('click', () => {
      const w = document.getElementById('w1');
      if (w) { w.style.display = 'block'; w.style.zIndex = ++topZIndex; }
      beep(600, 0.06);
    });
  }
  if (iconWinamp) {
    iconWinamp.addEventListener('click', () => {
      const w = document.getElementById('w2');
      if (w) { w.style.display = 'block'; w.style.zIndex = ++topZIndex; }
      beep(600, 0.06);
    });
  }
  if (iconTerminal) {
    iconTerminal.addEventListener('click', () => {
      const w = document.getElementById('w3');
      if (w) { w.style.display = 'block'; w.style.zIndex = ++topZIndex; }
      beep(600, 0.06);
    });
  }

  // Winamp Equalizer bars
  const eq = document.querySelector('.eq');
  if (eq) {
    eq.innerHTML = '<i></i>'.repeat(16);
    eq.querySelectorAll('i').forEach((bar, idx) => {
      bar.style.animationDelay = `${-(idx * 0.35 % 0.5)}s`;
      bar.style.animationDuration = `${0.3 + (idx * 0.12 % 0.45)}s`;
    });
  }

  // Winamp Play/Stop
  const playBtn = document.getElementById('play');
  if (playBtn) {
    playBtn.addEventListener('click', () => {
      toggleWinampMusic(playBtn, eq);
    });
  }

  // Live Taskbar Clock
  const clockEl = document.getElementById('clk');
  function updateClock() {
    if (clockEl) {
      const now = new Date();
      clockEl.textContent = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
    }
  }
  updateClock();
  setInterval(updateClock, 1000);
}

