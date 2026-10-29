/**
 * Perjalanan 12 Tahap — Interactive Engine
 */

document.addEventListener('DOMContentLoaded', () => {
  const stagesData = window.JOURNEY_STAGES || [];
  const glossaryData = window.JOURNEY_GLOSSARY || [];
  const quizData = window.JOURNEY_QUIZ || [];

  let currentStageIndex = 0; // 0 to 11
  let currentView = 'cinematic'; // 'intro' | 'cinematic' | 'read' | 'end'
  let isSoundOn = false;
  let audioContext = null;
  let ambientOsc = null;
  let ambientGain = null;
  let arabicSizes = ['1.7rem', '2.2rem', '2.7rem'];
  let currentArabicSizeIdx = 1;

  // DOM Elements
  const container = document.getElementById('journey-container');
  const canvas = document.getElementById('journey-canvas');
  const introSection = document.getElementById('journey-intro');
  const cinematicSection = document.getElementById('journey-cinematic');
  const readSection = document.getElementById('journey-read');
  const endSection = document.getElementById('journey-end');
  const stageCounter = document.getElementById('stage-counter');
  const progressDots = document.querySelectorAll('.trail-dot');
  const prevBtn = document.getElementById('prev-stage-btn');
  const nextBtn = document.getElementById('next-stage-btn');
  const deepDivePanel = document.getElementById('deep-dive-panel');
  const deepDiveOverlay = document.getElementById('deep-dive-overlay');
  const deepDiveContent = document.getElementById('deep-dive-content');
  const deepDiveTrigger = document.getElementById('trigger-deep-dive');
  const closeDeepDiveBtn = document.getElementById('close-deep-dive');

  // Mode buttons
  const modeToggleBtn = document.getElementById('toggle-mode-btn');
  const soundToggleBtn = document.getElementById('toggle-sound-btn');
  const arabicSizeBtn = document.getElementById('toggle-arabic-size');
  const openGlossaryBtn = document.getElementById('open-glossary-btn');
  const openQuizBtn = document.getElementById('open-quiz-btn');

  // Modals
  const glossaryModal = document.getElementById('glossary-modal');
  const quizModal = document.getElementById('quiz-modal');
  const closeGlossaryBtn = document.getElementById('close-glossary-modal');
  const closeQuizBtn = document.getElementById('close-quiz-modal');

  // Toast
  const toast = document.getElementById('journey-toast');
  function showToast(text, duration = 2000) {
    if (!toast) return;
    toast.textContent = text;
    toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');
    clearTimeout(showToast.timer);
    showToast.timer = setTimeout(() => {
      toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
      toast.classList.remove('opacity-100', 'translate-y-0');
    }, duration);
  }

  // 1. Ambient Background Particle Canvas
  let ctx = null;
  let particles = [];
  let animFrameId = 0;
  const isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const particleCount = window.innerWidth < 768 ? 60 : 120;

  function initCanvas() {
    if (!canvas || isReducedMotion) return;
    ctx = canvas.getContext('2d');
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas, { passive: true });

    particles = [];
    for (let i = 0; i < particleCount; i++) {
      particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 2 + 0.5,
        alpha: Math.random() * 0.8 + 0.2,
        vx: (Math.random() - 0.5) * 0.3,
        vy: (Math.random() - 0.5) * 0.3
      });
    }

    renderParticles();
  }

  function resizeCanvas() {
    if (!canvas) return;
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  function renderParticles() {
    if (!ctx || document.hidden || isReducedMotion) return;
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const stage = stagesData[currentStageIndex] || stagesData[0];
    const glowColor = stage.glow || '#cfe0ff';

    ctx.fillStyle = glowColor;
    particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;

      if (p.x < 0) p.x = canvas.width;
      if (p.x > canvas.width) p.x = 0;
      if (p.y < 0) p.y = canvas.height;
      if (p.y > canvas.height) p.y = 0;

      ctx.globalAlpha = p.alpha;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
    });

    animFrameId = requestAnimationFrame(renderParticles);
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      cancelAnimationFrame(animFrameId);
    } else if (!isReducedMotion) {
      renderParticles();
    }
  });

  // 2. Audio Atmosphere Synthesis (Native Web Audio API)
  function toggleAmbientSound() {
    if (!audioContext) {
      const AudioCtx = window.AudioContext || window.webkitAudioContext;
      audioContext = new AudioCtx();
    }
    if (audioContext.state === 'suspended') {
      audioContext.resume();
    }

    isSoundOn = !isSoundOn;
    if (soundToggleBtn) {
      soundToggleBtn.innerHTML = isSoundOn ? '🔊 Suara: ON' : '🔇 Suara: OFF';
      soundToggleBtn.setAttribute('aria-pressed', isSoundOn ? 'true' : 'false');
    }

    if (isSoundOn) {
      try {
        ambientOsc = audioContext.createOscillator();
        ambientGain = audioContext.createGain();
        ambientOsc.type = 'sine';
        ambientOsc.frequency.setValueAtTime(110, audioContext.currentTime); // Gentle A2 drone
        ambientGain.gain.setValueAtTime(0.001, audioContext.currentTime);
        ambientGain.gain.exponentialRampToValueAtTime(0.04, audioContext.currentTime + 3);

        ambientOsc.connect(ambientGain);
        ambientGain.connect(audioContext.destination);
        ambientOsc.start();
        showToast('Suara tenang diaktifkan');
      } catch (e) {
        console.debug('Audio error', e);
      }
    } else {
      if (ambientGain) {
        ambientGain.gain.exponentialRampToValueAtTime(0.001, audioContext.currentTime + 1);
        setTimeout(() => {
          if (ambientOsc) ambientOsc.stop();
        }, 1000);
      }
      showToast('Suara dinonaktifkan');
    }
  }

  // 3. Stage & View Presentation
  function setStage(index, updateHistory = true) {
    if (index < 0 || index >= stagesData.length) return;
    currentStageIndex = index;
    const stage = stagesData[index];

    // Save progress
    try {
      localStorage.setItem('journey-progress-stage', index + 1);
    } catch (e) {}

    // Update body theme tokens
    document.documentElement.style.setProperty('--sky-top', stage.skyTop);
    document.documentElement.style.setProperty('--sky-bottom', stage.skyBottom);
    document.documentElement.style.setProperty('--glow', stage.glow);

    // Update Counter
    const numPadded = String(index + 1).padStart(2, '0');
    if (stageCounter) {
      stageCounter.textContent = `${numPadded} / 12`;
    }

    // Update Progress Dots
    progressDots.forEach((dot, dotIdx) => {
      dot.classList.remove('passed', 'active');
      if (dotIdx < index) {
        dot.classList.add('passed');
      } else if (dotIdx === index) {
        dot.classList.add('active');
      }
    });

    // Update Cinematic Cards
    const cards = document.querySelectorAll('.cinematic-stage');
    cards.forEach((card, cIdx) => {
      if (cIdx === index) {
        card.classList.remove('stage-hidden');
        card.classList.add('stage-active');
      } else {
        card.classList.add('stage-hidden');
        card.classList.remove('stage-active');
      }
    });

    // Hash sync
    if (updateHistory && currentView === 'cinematic') {
      window.location.hash = `#tahap-${numPadded}`;
    }

    // Scroll to top in cinematic
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function showView(view) {
    currentView = view;
    if (introSection) introSection.classList.toggle('hidden', view !== 'intro');
    if (cinematicSection) cinematicSection.classList.toggle('hidden', view !== 'cinematic');
    if (readSection) readSection.classList.toggle('hidden', view !== 'read');
    if (endSection) endSection.classList.toggle('hidden', view !== 'end');

    if (modeToggleBtn) {
      modeToggleBtn.innerHTML = view === 'read' ? '🎬 Mode Sinematik' : '📖 Mode Baca';
    }

    if (view === 'cinematic') {
      setStage(currentStageIndex);
    } else if (view === 'end') {
      window.location.hash = '#penutup';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  }

  // Next / Prev stage navigation
  function nextStage() {
    if (currentStageIndex < stagesData.length - 1) {
      setStage(currentStageIndex + 1);
    } else {
      showView('end');
    }
  }

  function prevStage() {
    if (currentStageIndex > 0) {
      setStage(currentStageIndex - 1);
    } else {
      showView('intro');
    }
  }

  // 4. Deep Dive Panel Content
  function openDeepDive() {
    const stage = stagesData[currentStageIndex];
    if (!stage || !deepDiveContent) return;

    let vocabHtml = '';
    if (stage.vocabulary && stage.vocabulary.length > 0) {
      vocabHtml = `
        <div class="mb-6 p-4 rounded-xl bg-slate-800/60 border border-slate-700">
          <h4 class="text-xs uppercase tracking-wider font-extrabold text-amber-400 mb-3">📖 Kosakata & Istilah Arab</h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            ${stage.vocabulary.map(v => `
              <div class="p-2.5 rounded-lg bg-slate-900/50 border border-slate-700/60">
                <div class="text-base font-bold text-amber-300 font-serif" dir="rtl">${v.ar}</div>
                <div class="text-xs font-semibold text-slate-300">${v.latin}</div>
                <div class="text-xs text-slate-400 mt-0.5">${v.meaning}</div>
              </div>
            `).join('')}
          </div>
        </div>
      `;
    }

    let notesHtml = '';
    if (stage.scholarNotes && stage.scholarNotes.length > 0) {
      notesHtml = `
        <div class="mb-6 p-4 rounded-xl bg-amber-950/30 border border-amber-600/40">
          <div class="scholar-badge mb-2">⚖️ Catatan Ulama · Perbedaan Pendapat</div>
          <p class="text-xs leading-relaxed text-amber-200/90 m-0">${stage.scholarNotes.join(' ')}</p>
        </div>
      `;
    }

    let lessonsHtml = '';
    if (stage.practicalLessons && stage.practicalLessons.length > 0) {
      lessonsHtml = `
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/30 border border-emerald-600/40">
          <h4 class="text-xs uppercase tracking-wider font-extrabold text-emerald-400 mb-2">🌱 Pelajaran Praktis & Amal</h4>
          <p class="text-xs leading-relaxed text-emerald-200/90 m-0">${stage.practicalLessons.join(' ')}</p>
        </div>
      `;
    }

    deepDiveContent.innerHTML = `
      <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
        <div>
          <span class="text-xs font-mono font-bold tracking-widest text-amber-400">TAHAP ${String(stage.id).padStart(2, '0')} / 12</span>
          <h3 class="text-xl font-black text-white mt-1">${stage.labelId}</h3>
        </div>
        <span class="text-xl font-bold font-serif text-slate-400" dir="rtl">${stage.labelAr}</span>
      </div>

      <!-- Ayat & Terjemah Lengkap -->
      <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-700/80 mb-6 text-center">
        <div class="arabic-text text-2xl text-amber-100 mb-3" dir="rtl">${stage.arabic}</div>
        <p class="text-sm italic text-slate-300 leading-relaxed m-0 mb-3">"${stage.translation}"</p>
        <div class="text-xs font-semibold text-amber-400/90">
          ${stage.sources.map(s => `${s.ref} (${s.translationBy || 'Sahih'})`).join(' · ')}
        </div>
      </div>

      <!-- Penjelasan Mendalam -->
      <div class="mb-6">
        <h4 class="text-xs uppercase tracking-wider font-extrabold text-slate-400 mb-3">Tafsir & Penjelasan</h4>
        ${stage.explanation.map(p => `<p class="text-sm text-slate-300 leading-relaxed mb-3">${p}</p>`).join('')}
      </div>

      ${vocabHtml}
      ${notesHtml}
      ${lessonsHtml}

      <!-- Bacaan Lanjutan -->
      ${stage.furtherReading && stage.furtherReading.length > 0 ? `
        <div class="pt-4 border-t border-slate-800 text-xs text-slate-400">
          <strong>Rujukan Lanjutan:</strong> ${stage.furtherReading.map(r => r.ref).join(', ')}
        </div>
      ` : ''}
    `;

    if (deepDivePanel) deepDivePanel.classList.add('open');
    if (deepDiveOverlay) deepDiveOverlay.classList.add('open');
  }

  function closeDeepDive() {
    if (deepDivePanel) deepDivePanel.classList.remove('open');
    if (deepDiveOverlay) deepDiveOverlay.classList.remove('open');
  }

  // 5. Quiz Logic
  let userQuizScore = 0;
  let quizAnsweredCount = 0;

  function renderQuiz() {
    const quizListContainer = document.getElementById('quiz-questions-list');
    if (!quizListContainer) return;

    userQuizScore = 0;
    quizAnsweredCount = 0;

    quizListContainer.innerHTML = quizData.map((q, idx) => `
      <div class="p-4 rounded-xl bg-slate-800/50 border border-slate-700 mb-5 quiz-item" data-idx="${idx}">
        <div class="flex items-center gap-2 mb-2">
          <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300">Tahap ${String(q.stage).padStart(2, '0')}</span>
          <span class="text-xs text-slate-400 font-semibold">Soal ${idx + 1} dari 12</span>
        </div>
        <p class="text-sm font-bold text-white mb-3">${q.question}</p>
        <div class="space-y-2">
          ${q.options.map((opt, optIdx) => `
            <button class="w-full text-left p-3 rounded-lg bg-slate-900 border border-slate-700 hover:border-amber-400 text-xs text-slate-200 transition-colors quiz-opt-btn" data-opt="${optIdx}">
              ${String.fromCharCode(65 + optIdx)}. ${opt}
            </button>
          `).join('')}
        </div>
        <div class="quiz-feedback hidden mt-3 p-3 rounded-lg text-xs leading-relaxed"></div>
      </div>
    `).join('');

    // Attach listeners
    quizListContainer.querySelectorAll('.quiz-item').forEach(item => {
      const qIdx = parseInt(item.dataset.idx, 10);
      const q = quizData[qIdx];
      const buttons = item.querySelectorAll('.quiz-opt-btn');
      const feedback = item.querySelector('.quiz-feedback');

      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          const chosen = parseInt(btn.dataset.opt, 10);
          buttons.forEach(b => {
            b.disabled = true;
            b.classList.add('opacity-70', 'cursor-not-allowed');
          });

          feedback.classList.remove('hidden');
          if (chosen === q.answer) {
            btn.classList.remove('bg-slate-900', 'border-slate-700');
            btn.classList.add('bg-emerald-950', 'border-emerald-500', 'text-emerald-200');
            feedback.classList.add('bg-emerald-950/60', 'border', 'border-emerald-500/40', 'text-emerald-300');
            feedback.innerHTML = `<strong>Benar! ✨</strong> ${q.explanation}`;
            userQuizScore++;
          } else {
            btn.classList.remove('bg-slate-900', 'border-slate-700');
            btn.classList.add('bg-rose-950', 'border-rose-500', 'text-rose-200');
            // Highlight correct
            buttons[q.answer].classList.add('border-emerald-500', 'bg-emerald-950/80', 'text-emerald-200');
            feedback.classList.add('bg-rose-950/60', 'border', 'border-rose-500/40', 'text-rose-300');
            feedback.innerHTML = `<strong>Kurang tepat.</strong> ${q.explanation}`;
          }

          quizAnsweredCount++;
          if (quizAnsweredCount === quizData.length) {
            updateQuizResultBanner();
          }
        });
      });
    });
  }

  function updateQuizResultBanner() {
    const banner = document.getElementById('quiz-result-banner');
    if (!banner) return;
    banner.classList.remove('hidden');
    banner.innerHTML = `
      <div class="p-5 rounded-2xl bg-amber-500/20 border-2 border-amber-500/60 text-center">
        <h4 class="text-xl font-black text-amber-300 mb-1">Skor Kamu: ${userQuizScore} / 12</h4>
        <p class="text-xs text-slate-300 mb-3 leading-relaxed">
          ${userQuizScore >= 10 ? 'Masya Allah! Pemahamanmu tentang 12 tahap perjalanan sangat baik.' : 'Alhamdulillah, perjalanan belajar yang bagus! Coba baca kembali tahap-tahap yang belum tepat.'}
        </p>
        <button id="retry-quiz-btn" class="px-4 py-2 bg-amber-500 text-slate-950 font-extrabold text-xs rounded-xl hover:bg-amber-400">
          Ulangi Kuis
        </button>
      </div>
    `;
    document.getElementById('retry-quiz-btn')?.addEventListener('click', renderQuiz);
  }

  // 6. Glossary List
  function renderGlossary(filter = '') {
    const listEl = document.getElementById('glossary-items-list');
    if (!listEl) return;

    const filtered = glossaryData.filter(g =>
      g.term.toLowerCase().includes(filter.toLowerCase()) ||
      g.latin.toLowerCase().includes(filter.toLowerCase()) ||
      g.meaning.toLowerCase().includes(filter.toLowerCase())
    );

    listEl.innerHTML = filtered.map(g => `
      <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700 hover:border-slate-500 transition-colors">
        <div class="flex items-center justify-between mb-1.5">
          <div class="flex items-center gap-2">
            <span class="text-base font-extrabold text-white">${g.term}</span>
            <span class="text-xs text-slate-400">(${g.latin})</span>
          </div>
          <span class="text-xl font-serif text-amber-300" dir="rtl">${g.ar}</span>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed m-0 mb-2">${g.meaning}</p>
        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-slate-700/60 text-slate-400">
          Relevan di Tahap ${String(g.stage).padStart(2, '0')}
        </span>
      </div>
    `).join('');
  }

  // 7. Interactive Checklist "Bekal dari Tahap 3" (LocalStorage)
  function initChecklist() {
    const checklistBoxes = document.querySelectorAll('.bekal-checkbox');
    checklistBoxes.forEach((cb, idx) => {
      const saved = localStorage.getItem(`journey-bekal-${idx}`);
      if (saved === '1') {
        cb.checked = true;
      }
      cb.addEventListener('change', () => {
        localStorage.setItem(`journey-bekal-${idx}`, cb.checked ? '1' : '0');
        showToast(cb.checked ? 'Alhamdulillah, dicentang! ✨' : 'Dihapus dari catatan.');
      });
    });
  }

  // 8. Event Listeners
  // Nav buttons
  if (prevBtn) prevBtn.addEventListener('click', prevStage);
  if (nextBtn) nextBtn.addEventListener('click', nextStage);

  progressDots.forEach(dot => {
    dot.addEventListener('click', () => {
      const idx = parseInt(dot.dataset.stage, 10);
      setStage(idx);
    });
  });

  // Deep dive panel triggers
  if (deepDiveTrigger) deepDiveTrigger.addEventListener('click', openDeepDive);
  if (closeDeepDiveBtn) closeDeepDiveBtn.addEventListener('click', closeDeepDive);
  if (deepDiveOverlay) deepDiveOverlay.addEventListener('click', closeDeepDive);

  // Intro buttons
  document.getElementById('start-journey-btn')?.addEventListener('click', () => {
    showView('cinematic');
    setStage(0);
  });

  const resumeBtn = document.getElementById('resume-journey-btn');
  const savedStage = localStorage.getItem('journey-progress-stage');
  if (resumeBtn && savedStage) {
    resumeBtn.classList.remove('hidden');
    resumeBtn.textContent = `Lanjutkan dari Tahap ${String(savedStage).padStart(2, '0')} ›`;
    resumeBtn.addEventListener('click', () => {
      showView('cinematic');
      setStage(parseInt(savedStage, 10) - 1);
    });
  }

  // End screen buttons
  document.getElementById('restart-journey-btn')?.addEventListener('click', () => {
    showView('cinematic');
    setStage(0);
  });
  document.getElementById('end-quiz-btn')?.addEventListener('click', () => {
    quizModal?.classList.remove('hidden');
    renderQuiz();
  });
  document.getElementById('share-journey-btn')?.addEventListener('click', () => {
    if (navigator.share) {
      navigator.share({
        title: 'Perjalanan 12 Tahap Manusia',
        text: 'Menyusuri 12 tahap perjalanan manusia dari sebelum lahir hingga surga menurut Al-Qur\'an dan hadis.',
        url: window.location.href
      }).catch(() => {});
    } else {
      navigator.clipboard.writeText(window.location.href);
      showToast('Tautan berhasil disalin ke clipboard! 📋');
    }
  });

  // Mode Toggle
  if (modeToggleBtn) {
    modeToggleBtn.addEventListener('click', () => {
      showView(currentView === 'read' ? 'cinematic' : 'read');
    });
  }

  // Sound Toggle
  if (soundToggleBtn) soundToggleBtn.addEventListener('click', toggleAmbientSound);

  // Arabic Size Toggle
  if (arabicSizeBtn) {
    arabicSizeBtn.addEventListener('click', () => {
      currentArabicSizeIdx = (currentArabicSizeIdx + 1) % arabicSizes.length;
      document.documentElement.style.setProperty('--arabic-size', arabicSizes[currentArabicSizeIdx]);
      showToast(`Ukuran teks Arab: ${['Kecil', 'Sedang', 'Besar'][currentArabicSizeIdx]}`);
    });
  }

  // Modals
  if (openGlossaryBtn) {
    openGlossaryBtn.addEventListener('click', () => {
      glossaryModal?.classList.remove('hidden');
      renderGlossary();
    });
  }
  if (closeGlossaryBtn) closeGlossaryBtn.addEventListener('click', () => glossaryModal?.classList.add('hidden'));

  const glossarySearch = document.getElementById('glossary-search-input');
  if (glossarySearch) {
    glossarySearch.addEventListener('input', (e) => renderGlossary(e.target.value));
  }

  if (openQuizBtn) {
    openQuizBtn.addEventListener('click', () => {
      quizModal?.classList.remove('hidden');
      renderQuiz();
    });
  }
  if (closeQuizBtn) closeQuizBtn.addEventListener('click', () => quizModal?.classList.add('hidden'));

  // Copy Ayat buttons
  document.querySelectorAll('.copy-ayat-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const parent = btn.closest('.arabic-block');
      const ar = parent.querySelector('.arabic-text')?.textContent || '';
      const tr = parent.querySelector('.translation-text')?.textContent || '';
      const src = parent.querySelector('.source-text')?.textContent || '';
      const full = `${ar}\n\n"${tr}"\n(${src})`;

      navigator.clipboard.writeText(full).then(() => {
        showToast('Teks Arab & terjemah berhasil disalin! 📋');
      });
    });
  });

  // Keyboard navigation
  window.addEventListener('keydown', (e) => {
    if (deepDivePanel?.classList.contains('open')) {
      if (e.key === 'Escape') closeDeepDive();
      return;
    }
    if (glossaryModal && !glossaryModal.classList.contains('hidden')) {
      if (e.key === 'Escape') glossaryModal.classList.add('hidden');
      return;
    }
    if (quizModal && !quizModal.classList.contains('hidden')) {
      if (e.key === 'Escape') quizModal.classList.add('hidden');
      return;
    }

    if (currentView === 'cinematic') {
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        e.preventDefault();
        nextStage();
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        e.preventDefault();
        prevStage();
      }
    }
  });

  // Touch Swipe
  let touchStartX = 0;
  let touchStartY = 0;
  window.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
  }, { passive: true });

  window.addEventListener('touchend', (e) => {
    if (deepDivePanel?.classList.contains('open') || currentView !== 'cinematic') return;
    const deltaX = e.changedTouches[0].clientX - touchStartX;
    const deltaY = e.changedTouches[0].clientY - touchStartY;

    if (Math.abs(deltaX) > 60 && Math.abs(deltaY) < 50) {
      if (deltaX < 0) nextStage(); // swipe left -> next
      else prevStage(); // swipe right -> prev
    }
  }, { passive: true });

  // 9. Initial Hash Check
  function checkInitialHash() {
    const hash = window.location.hash;
    if (hash.startsWith('#tahap-')) {
      const num = parseInt(hash.replace('#tahap-', ''), 10);
      if (!isNaN(num) && num >= 1 && num <= 12) {
        showView('cinematic');
        setStage(num - 1, false);
        return;
      }
    } else if (hash === '#penutup') {
      showView('end');
      return;
    }
    showView('intro');
  }

  initCanvas();
  initChecklist();
  checkInitialHash();
});
