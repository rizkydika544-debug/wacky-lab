import { beep, playEatSound } from './audio.js';
import { burst } from './kinetic.js';

let lastMoveTime = Date.now();
let lastX = 0, lastY = 0, lastT = 0;
let isDraggingFood = false;

export function say(text, duration = 1200) {
  const sayEl = document.getElementById('say');
  const mascot = document.getElementById('mascot');
  if (!sayEl || !mascot) return;
  sayEl.textContent = text;
  mascot.classList.add('talk');
  clearTimeout(say.timer);
  say.timer = setTimeout(() => {
    mascot.classList.remove('talk');
  }, duration);
}

export function initMascot() {
  const mascot = document.getElementById('mascot');
  const pl = document.getElementById('pl');
  const pr = document.getElementById('pr');
  const lids = document.getElementById('lids');
  const food = document.getElementById('food');
  if (!mascot || !pl || !pr) return;

  function lookAt(targetX, targetY) {
    const rect = mascot.getBoundingClientRect();
    const originX = rect.left + rect.width / 2;
    const originY = rect.top + rect.height * 0.51;
    const angle = Math.atan2(targetY - originY, targetX - originX);
    const radius = targetX < 0 ? 0 : 5.5;

    [
      [pl, 42],
      [pr, 78]
    ].forEach(([pupil, defaultX]) => {
      pupil.setAttribute('cx', defaultX + Math.cos(angle) * radius);
      pupil.setAttribute('cy', 56 + Math.sin(angle) * radius);
    });
  }

  // Pointer tracking for cat reaction and eye movement
  window.addEventListener('pointermove', (e) => {
    const now = performance.now();
    const dt = Math.max(1, now - lastT);
    const speed = Math.hypot(e.clientX - lastX, e.clientY - lastY) / dt;

    lastX = e.clientX;
    lastY = e.clientY;
    lastT = now;
    lastMoveTime = Date.now();

    // Wake up if asleep
    if (mascot.classList.contains('sl')) {
      mascot.classList.remove('sl');
      pl.style.opacity = '1';
      pr.style.opacity = '1';
      if (lids) lids.setAttribute('opacity', '0');
    }

    lookAt(e.clientX, e.clientY);

    // Surprise jump if moving fast nearby
    const rect = mascot.getBoundingClientRect();
    const mascotCenterX = rect.left + rect.width / 2;
    const mascotCenterY = rect.top + rect.height / 2;
    const dist = Math.hypot(e.clientX - mascotCenterX, e.clientY - mascotCenterY);

    if (speed > 2.8 && dist < 180 && !mascot.classList.contains('st')) {
      mascot.classList.add('st');
      say('hah?! 🙀', 800);
      beep(620, 0.08);
      setTimeout(() => mascot.classList.remove('st'), 800);
    }
  }, { passive: true });

  // Sleep check loop (after 10s inactivity)
  setInterval(() => {
    if (Date.now() - lastMoveTime > 10000 && !mascot.classList.contains('sl') && !isDraggingFood) {
      mascot.classList.add('sl');
      pl.style.opacity = '0';
      pr.style.opacity = '0';
      if (lids) lids.setAttribute('opacity', '1');
    }
  }, 600);

  // Click on mascot directly
  mascot.addEventListener('click', () => {
    const quotes = ['meow! 😸', 'purr... 🧶', 'jangan gelitik! 😹', 'lapar nih... 🍕'];
    const chosen = quotes[Math.floor(Math.random() * quotes.length)];
    say(chosen, 1200);
    beep(750, 0.1);
  });

  // Draggable Food
  if (food) {
    food.addEventListener('pointerdown', (e) => {
      isDraggingFood = true;
      food.setPointerCapture(e.pointerId);
      const rect = food.getBoundingClientRect();
      food.style.cssText += `;left:${rect.left}px;top:${rect.top}px;right:auto;bottom:auto;`;
      e.stopPropagation();
      e.preventDefault();
    });

    food.addEventListener('pointermove', (e) => {
      if (isDraggingFood) {
        food.style.left = `${e.clientX - 24}px`;
        food.style.top = `${e.clientY - 24}px`;
      }
    });

    const resetFoodPos = () => {
      if (!isDraggingFood) return;
      isDraggingFood = false;

      const fRect = food.getBoundingClientRect();
      const mRect = mascot.getBoundingClientRect();
      const mouthX = mRect.left + mRect.width / 2;
      const mouthY = mRect.top + mRect.height * 0.72;
      const dist = Math.hypot((fRect.left + fRect.width / 2) - mouthX, (fRect.top + fRect.height / 2) - mouthY);

      if (dist < 85) {
        mascot.classList.add('nom');
        say('nyam! Lezat! 😋', 1400);
        playEatSound();
        burst(mouthX, mouthY, 20, ['✨', '⭐', '💖', '🍕']);
        setTimeout(() => mascot.classList.remove('nom'), 1400);
      }

      food.style.left = '';
      food.style.top = '';
      food.style.right = '';
      food.style.bottom = '';
    };

    food.addEventListener('pointerup', resetFoodPos);
    food.addEventListener('pointercancel', resetFoodPos);
  }

  // Initial look position
  lookAt(window.innerWidth / 2, 300);
}

