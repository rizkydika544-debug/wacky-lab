import { beep } from './audio.js';
import { showToast } from './kinetic.js';

export function initBadge() {
  const badge = document.getElementById('bd');
  if (!badge) return;

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  window.addEventListener('pointermove', (e) => {
    if (prefersReducedMotion) return;
    const rect = badge.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;
    const dx = (e.clientX - centerX) / window.innerWidth;
    const dy = (e.clientY - centerY) / window.innerHeight;

    badge.style.transform = `perspective(800px) rotateY(${dx * 36}deg) rotateX(${-dy * 36}deg)`;
    badge.style.backgroundPosition = `${50 + dx * 130}% ${50 + dy * 130}%`;
  }, { passive: true });

  badge.addEventListener('pointerleave', () => {
    badge.style.transform = 'perspective(800px) rotateY(0deg) rotateX(0deg)';
  });

  // Mobile Device Orientation Gyro support
  if (window.DeviceOrientationEvent && !prefersReducedMotion) {
    window.addEventListener('deviceorientation', (e) => {
      if (e.gamma !== null && e.beta !== null) {
        const tiltX = Math.max(-25, Math.min(25, e.gamma));
        const tiltY = Math.max(-25, Math.min(25, e.beta - 45));
        badge.style.transform = `perspective(800px) rotateY(${tiltX}deg) rotateX(${-tiltY}deg)`;
      }
    }, { passive: true });
  }

  // Edit card feature
  const editBadgeBtn = document.getElementById('edit-badge-btn');
  const badgeName = document.getElementById('badge-name');
  const badgeRole = document.getElementById('badge-role');

  if (editBadgeBtn && badgeName && badgeRole) {
    editBadgeBtn.addEventListener('click', () => {
      const newName = prompt('Masukkan nama untuk Kartu ID:', badgeName.textContent.trim());
      if (newName) {
        badgeName.textContent = newName.toUpperCase();
        const newRole = prompt('Masukkan role / keahlian:', badgeRole.textContent.trim());
        if (newRole) {
          badgeRole.textContent = newRole;
        }
        beep(740, 0.1);
        showToast('✨ Kartu ID berhasil diperbarui!');
      }
    });
  }
}

