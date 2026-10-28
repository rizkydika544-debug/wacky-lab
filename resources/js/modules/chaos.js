import { beep } from './audio.js';
import { burst, showToast } from './kinetic.js';

let isCursorTrailActive = false;
let lastTrailTime = 0;
let mouseX = 0, mouseY = 0;

export function initChaos() {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Toggle helper
  const setupToggle = (selector, callback) => {
    const btn = document.querySelector(selector);
    if (!btn) return;
    btn.addEventListener('click', (e) => {
      const currentlyPressed = btn.getAttribute('aria-pressed') === 'true';
      const nextState = !currentlyPressed;
      btn.setAttribute('aria-pressed', nextState ? 'true' : 'false');
      callback(nextState);
      beep(nextState ? 720 : 420, 0.08);
    });
  };

  // 1. Sparkle cursor trail
  setupToggle('#t-trail', (enabled) => {
    isCursorTrailActive = enabled;
    showToast(enabled ? '✨ Jejak kursor aktif!' : '✨ Jejak kursor mati');
  });

  // 2. Wobble screen
  setupToggle('#t-wob', (enabled) => {
    document.body.classList.toggle('wob', enabled);
    showToast(enabled ? '🥴 Mode goyang aktif!' : '🥴 Mode goyang mati');
  });

  // 3. Rainbow hue-rotate
  setupToggle('#t-rb', (enabled) => {
    document.documentElement.classList.toggle('rb', enabled);
    showToast(enabled ? '🌈 Mode pelangi aktif!' : '🌈 Mode pelangi mati');
  });

  // 4. Earthquake / Gempa button
  const quakeBtn = document.getElementById('quake');
  if (quakeBtn) {
    quakeBtn.addEventListener('click', () => {
      const mainContainer = document.getElementById('m');
      if (mainContainer) {
        mainContainer.classList.remove('shake');
        void mainContainer.offsetWidth; // Trigger reflow
        mainContainer.classList.add('shake');
      }
      beep(130, 0.35, true);
      showToast('🌋 GEMPA BUMI! Wuuusshhh!');
    });
  }

  // Cursor trail emitter
  window.addEventListener('pointermove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    const now = performance.now();

    if (isCursorTrailActive && !prefersReducedMotion && (now - lastTrailTime > 40)) {
      lastTrailTime = now;
      const star = document.createElement('span');
      const icons = ['✨', '⭐', '💫', '🌸', '⚡'];
      star.textContent = icons[Math.floor(now / 50) % icons.length];
      star.style.cssText = `position:fixed;left:${mouseX}px;top:${mouseY}px;pointer-events:none;z-index:90;font-size:16px;`;
      document.body.appendChild(star);

      star.animate([
        { opacity: 1, transform: 'translate(0, 0) scale(1)' },
        { opacity: 0, transform: 'translate(0, 26px) scale(0.4)' }
      ], {
        duration: 550,
        easing: 'ease-out'
      }).onfinish = () => star.remove();
    }
  }, { passive: true });

  // Spacebar confetti & Konami code
  const konamiSeq = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
  let konamiIndex = 0;

  window.addEventListener('keydown', (e) => {
    // Spacebar confetti
    if (e.code === 'Space' && (e.target === document.body || e.target === document.documentElement)) {
      e.preventDefault();
      burst(window.innerWidth / 2, window.innerHeight / 2, 60, ['🎉', '⭐', '🔥', '👾', '🌈', '🍕']);
      beep(700, 0.08);
      showToast('🚀 SPASI DITEKAN! BOOM!');
    }

    // Konami sequence tracking
    const currentExpectedKey = konamiSeq[konamiIndex].toLowerCase();
    const pressedKey = e.key.toLowerCase();

    if (pressedKey === currentExpectedKey) {
      konamiIndex++;
    } else {
      konamiIndex = (pressedKey === konamiSeq[0].toLowerCase()) ? 1 : 0;
    }

    if (konamiIndex === konamiSeq.length) {
      konamiIndex = 0;
      const isArcade = document.documentElement.classList.toggle('arc');
      showToast(isArcade ? '🕹️ ARCADE MODE: ON!' : '🕹️ ARCADE MODE: OFF!', 2500);
      burst(window.innerWidth / 2, window.innerHeight / 2, 70, ['👾', '🕹️', '⭐', '⚡', '🏆']);
      beep(880, 0.25, true);
    }
  });

  // Anywhere click confetti burst (excluding buttons & interactive elements)
  window.addEventListener('click', (e) => {
    if (!e.target.closest('button, .win, .stk, canvas, #food, a, input, select')) {
      burst(e.clientX, e.clientY, 10, ['✨', '⭐', '💥']);
      beep(900, 0.03);
    }
  });

  // Scroll Progress and Parallax Floating Emojis
  const floatingEmojis = document.querySelectorAll('.fl');
  const progressBar = document.getElementById('bar');

  function handleScroll() {
    const docEl = document.documentElement;
    const maxScroll = Math.max(1, docEl.scrollHeight - window.innerHeight);
    const scrollPercent = (docEl.scrollTop / maxScroll) * 100;

    if (progressBar) {
      progressBar.style.width = `${Math.min(100, Math.max(0, scrollPercent))}%`;
    }

    floatingEmojis.forEach(item => {
      const speed = parseFloat(item.dataset.s || '0.2');
      const translateY = -docEl.scrollTop * speed;
      const rotate = (docEl.scrollTop * 0.12) % 360;
      item.style.transform = `translateY(${translateY}px) rotate(${rotate}deg)`;
    });
  }

  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();
}

