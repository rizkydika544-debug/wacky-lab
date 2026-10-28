import { burst } from './kinetic.js';
import { beep, playFanfare } from './audio.js';

let canvas = null;
let ctx = null;
let isPointerDown = false;
let moveCount = 0;
let isCleared = false;

const secretMessages = [
  'Kode rahasia:\n↑ ↑ ↓ ↓ ← → ← → B A',
  '🎉 Selamat! Kamu dapat Kupon Kopi Gratis ☕',
  '⭐ Easter Egg: Coba Tekan [SPASI] di keyboard!',
  '👾 Cheat Code: Ketik Konami Code di mana saja!'
];
let currentMessageIdx = 0;

export function coverCard() {
  if (!canvas || !ctx) return;
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
  canvas.style.opacity = '1';
  canvas.style.pointerEvents = 'auto';
  isCleared = false;

  const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
  gradient.addColorStop(0, '#9a96ad');
  gradient.addColorStop(0.5, '#b8b4c7');
  gradient.addColorStop(1, '#c9c6d6');

  ctx.globalCompositeOperation = 'source-over';
  ctx.fillStyle = gradient;
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // Scratch guide label
  ctx.fillStyle = '#494266';
  ctx.font = 'bold 18px system-ui, sans-serif';
  ctx.textAlign = 'center';
  ctx.textBaseline = 'middle';
  ctx.fillText('🪙 Gosok kupon di sini!', canvas.width / 2, canvas.height / 2);
}

function scratchAt(e) {
  if (!isPointerDown || isCleared) return;
  const rect = canvas.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;

  ctx.globalCompositeOperation = 'destination-out';
  ctx.beginPath();
  ctx.arc(x, y, 22, 0, Math.PI * 2);
  ctx.fill();

  if (++moveCount % 10 === 0) {
    checkClearedPercentage(rect);
  }
}

function checkClearedPercentage(rect) {
  const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
  let transparentPixels = 0;
  const totalSamples = imageData.length / 64;

  for (let i = 3; i < imageData.length; i += 64) {
    if (imageData[i] === 0) {
      transparentPixels++;
    }
  }

  if (transparentPixels / totalSamples > 0.45) {
    isCleared = true;
    canvas.style.opacity = '0';
    canvas.style.pointerEvents = 'none';
    burst(rect.left + rect.width / 2, rect.top + rect.height / 2, 40, ['🪙', '✨', '🎉', '⭐', '🎊']);
    playFanfare();
  }
}

export function initScratch() {
  canvas = document.getElementById('sc');
  if (!canvas) return;
  ctx = canvas.getContext('2d');

  coverCard();

  canvas.addEventListener('pointerdown', (e) => {
    isPointerDown = true;
    canvas.setPointerCapture(e.pointerId);
    scratchAt(e);
    beep(700, 0.04);
    e.stopPropagation();
  });

  canvas.addEventListener('pointermove', scratchAt);

  const stopScratch = () => { isPointerDown = false; };
  canvas.addEventListener('pointerup', stopScratch);
  canvas.addEventListener('pointercancel', stopScratch);

  const refillBtn = document.getElementById('refill');
  const cardText = document.getElementById('card-secret-text');

  if (refillBtn) {
    refillBtn.addEventListener('click', () => {
      currentMessageIdx = (currentMessageIdx + 1) % secretMessages.length;
      if (cardText) {
        cardText.innerHTML = secretMessages[currentMessageIdx].replace(/\n/g, '<br>');
      }
      coverCard();
      beep(650, 0.08);
    });
  }

  window.addEventListener('resize', () => {
    if (!isCleared && canvas.style.opacity !== '0') {
      coverCard();
    }
  });
}

