import { makeDraggable } from './desktop.js';
import { beep } from './audio.js';
import { burst } from './kinetic.js';

const stickerPool = ['🔥', '💀', '🐸', '⭐', '🍜', '🎮', '🚀', '👾', '🍕', '🐱', '🌈', '🍦', '💎', '🎸'];

export function initStickers() {
  const board = document.getElementById('bo');
  if (!board) return;

  const existingStickers = board.querySelectorAll('.stk');
  existingStickers.forEach(sticker => {
    makeDraggable(sticker, sticker, true);
    sticker.addEventListener('pointerdown', () => beep(550, 0.05));
  });

  const addStickerBtn = document.getElementById('add-sticker');
  const clearStickersBtn = document.getElementById('clear-stickers');

  if (addStickerBtn) {
    addStickerBtn.addEventListener('click', () => {
      const char = stickerPool[Math.floor(Math.random() * stickerPool.length)];
      const span = document.createElement('span');
      span.className = 'stk';
      span.textContent = char;

      const randomLeft = Math.floor(Math.random() * (board.clientWidth - 60));
      const randomTop = Math.floor(Math.random() * (board.clientHeight - 60));
      span.style.left = `${Math.max(10, randomLeft)}px`;
      span.style.top = `${Math.max(10, randomTop)}px`;

      board.appendChild(span);
      makeDraggable(span, span, true);

      span.addEventListener('pointerdown', () => beep(580, 0.05));

      const rect = span.getBoundingClientRect();
      burst(rect.left + 20, rect.top + 20, 15, ['✨', '⭐']);
      beep(720, 0.08);
    });
  }

  if (clearStickersBtn) {
    clearStickersBtn.addEventListener('click', () => {
      board.innerHTML = '';
      beep(300, 0.1);
    });
  }
}

