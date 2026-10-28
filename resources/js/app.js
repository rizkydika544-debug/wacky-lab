import { initAudio } from './modules/audio.js';
import { initKinetic } from './modules/kinetic.js';
import { initPhysics } from './modules/physics.js';
import { initMascot } from './modules/mascot.js';
import { initDesktop } from './modules/desktop.js';
import { initScratch } from './modules/scratch.js';
import { initStickers } from './modules/stickers.js';
import { initChaos } from './modules/chaos.js';
import { initBadge } from './modules/badge.js';
import { initTheme } from './modules/theme.js';

document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initAudio();
  initKinetic();
  initPhysics();
  initMascot();
  initDesktop();
  initScratch();
  initStickers();
  initChaos();
  initBadge();

  console.log(
    '%c🌀 WACKY LAB 🌀\n%cSelamat datang di laboratorium eksperimen interaktif Rizky!\nCoba ketik Konami Code: ↑ ↑ ↓ ↓ ← → ← → B A',
    'font-size: 20px; font-weight: bold; color: #ff3d81;',
    'font-size: 13px; color: #3d5afe;'
  );
});
