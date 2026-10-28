import { beep } from './audio.js';

let mouseX = -999;
let mouseY = -999;
const letters = [];
const magneticButtons = [];
let prefersReducedMotion = false;

export function showToast(text, duration = 1800) {
  const toast = document.getElementById('msg');
  if (!toast) return;
  toast.textContent = text;
  toast.classList.add('on');
  clearTimeout(showToast.timer);
  showToast.timer = setTimeout(() => {
    toast.classList.remove('on');
  }, duration);
}

export function burst(x, y, count = 24, set = ['🎉', '✨', '⭐', '🔥', '💥', '🍕']) {
  if (prefersReducedMotion) return;
  for (let i = 0; i < count; i++) {
    const span = document.createElement('span');
    span.textContent = set[i % set.length];
    span.style.cssText = `position:fixed;left:${x}px;top:${y}px;font-size:${14 + Math.random() * 20}px;pointer-events:none;z-index:95;`;
    document.body.appendChild(span);

    const angle = Math.random() * Math.PI * 2;
    const distance = 60 + Math.random() * 180;
    const destX = Math.cos(angle) * distance;
    const destY = Math.sin(angle) * distance + 80;

    span.animate([
      { transform: 'translate(0, 0) scale(1) rotate(0deg)', opacity: 1 },
      { transform: `translate(${destX}px, ${destY}px) scale(0.6) rotate(${Math.random() * 720 - 360}deg)`, opacity: 0 }
    ], {
      duration: 800 + Math.random() * 600,
      easing: 'cubic-bezier(0.2, 0.8, 0.4, 1)'
    }).onfinish = () => span.remove();
  }
}

export function initKinetic() {
  prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Split lines into bouncy elastic letters
  const lines = document.querySelectorAll('.line');
  lines.forEach(line => {
    const text = line.dataset.t || line.textContent.trim();
    line.innerHTML = '';
    [...text].forEach(char => {
      const span = document.createElement('span');
      span.className = 'l';
      span.textContent = char;
      line.appendChild(span);
      letters.push({
        el: span,
        scale: 1,
        velocity: 0
      });
    });
  });

  // Track magnetic buttons
  const mags = document.querySelectorAll('.mag');
  mags.forEach(el => {
    magneticButtons.push({
      el,
      x: 0,
      y: 0
    });
  });

  // Mouse move tracking for rubber & magnetic effects
  window.addEventListener('pointermove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  }, { passive: true });

  // Color randomize button
  const colorBtn = document.getElementById('color');
  if (colorBtn) {
    colorBtn.addEventListener('click', () => {
      const randomHue = () => Math.floor(Math.random() * 360);
      const rootStyle = document.documentElement.style;
      const h1 = randomHue();
      const h2 = (h1 + 120 + Math.floor(Math.random() * 120)) % 360;
      rootStyle.setProperty('--pk', `hsl(${h1}, 95%, 60%)`);
      rootStyle.setProperty('--bl', `hsl(${h2}, 90%, 58%)`);
      rootStyle.setProperty('--gr', `hsl(${(h1 + 60) % 360}, 90%, 55%)`);
      beep(520, 0.08);
      showToast('🎨 Warna tema diacak!');
    });
  }

  // Cat caller
  const callBtn = document.getElementById('call');
  if (callBtn) {
    callBtn.addEventListener('click', () => {
      const sayBox = document.getElementById('say');
      const mascot = document.getElementById('mascot');
      if (sayBox && mascot) {
        sayBox.textContent = 'meow! 🐾';
        mascot.classList.add('talk');
        setTimeout(() => mascot.classList.remove('talk'), 1200);
      }
      beep(880, 0.12);
      showToast('🐱 Kucing menengok!');
    });
  }

  // Confetti burst
  const confBtn = document.getElementById('conf');
  if (confBtn) {
    confBtn.addEventListener('click', (e) => {
      const rect = confBtn.getBoundingClientRect();
      const cx = e.clientX || (rect.left + rect.width / 2);
      const cy = e.clientY || (rect.top + rect.height / 2);
      burst(cx, cy, 45, ['🎉', '✨', '⭐', '🎊', '💫', '💖']);
      beep(990, 0.09);
      showToast('🎉 Duar! Konfeti melayang!');
    });
  }

  // Animation loop
  function loop() {
    letters.forEach(item => {
      let targetScale = 1;
      if (!prefersReducedMotion && mouseX > -100) {
        const rect = item.el.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const dist = Math.hypot(mouseX - centerX, mouseY - centerY);
        targetScale = 1 + Math.max(0, 1 - dist / 180) * 0.9;
      }
      item.velocity = (item.velocity + (targetScale - item.scale) * 0.2) * 0.78;
      item.scale += item.velocity;
      item.el.style.transform = `scale(${1 - (item.scale - 1) * 0.3}, ${item.scale})`;
    });

    magneticButtons.forEach(m => {
      const rect = m.el.getBoundingClientRect();
      const centerX = rect.left + rect.width / 2 - m.x;
      const centerY = rect.top + rect.height / 2 - m.y;
      const dist = Math.hypot(mouseX - centerX, mouseY - centerY);

      const isHoverNear = !prefersReducedMotion && dist < 130 && mouseX > -100;
      const targetX = isHoverNear ? (mouseX - centerX) * 0.35 : 0;
      const targetY = isHoverNear ? (mouseY - centerY) * 0.35 : 0;

      m.x += (targetX - m.x) * 0.2;
      m.y += (targetY - m.y) * 0.2;
      m.el.style.transform = `translate(${m.x}px, ${m.y}px)`;
    });

    requestAnimationFrame(loop);
  }

  requestAnimationFrame(loop);
}

