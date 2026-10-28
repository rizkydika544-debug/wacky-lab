import { beep } from './audio.js';
import { showToast } from './kinetic.js';

export function initTheme() {
  const themeToggleBtn = document.getElementById('theme-toggle-btn');
  const root = document.documentElement;

  // Read saved theme or fallback to system preference
  const savedTheme = localStorage.getItem('wacky-theme');
  if (savedTheme) {
    root.setAttribute('data-theme', savedTheme);
  } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    root.setAttribute('data-theme', 'dark');
  } else {
    root.setAttribute('data-theme', 'light');
  }

  const updateButtonText = () => {
    if (!themeToggleBtn) return;
    const currentTheme = root.getAttribute('data-theme');
    themeToggleBtn.innerHTML = currentTheme === 'dark' ? '☀️ Mode Terang' : '🌙 Mode Gelap';
  };
  updateButtonText();

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
      const current = root.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', next);
      localStorage.setItem('wacky-theme', next);
      updateButtonText();
      beep(680, 0.08);
      showToast(next === 'dark' ? '🌙 Tema gelap aktif!' : '☀️ Tema terang aktif!');
    });
  }
}

