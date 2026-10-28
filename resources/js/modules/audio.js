/**
 * Web Audio API Retro 8-bit Sound Synthesizer
 */
let audioCtx = null;
let isSoundEnabled = false;
let currentMusicTimer = null;

const tracks = [
  // Track 0: Winamp Classic chiptune arpeggio
  [262, 330, 392, 523, 392, 330, 294, 392],
  // Track 1: Upbeat retro arcade riff
  [330, 392, 494, 587, 494, 392, 440, 523],
  // Track 2: Quirky bass bounce
  [196, 220, 246, 262, 294, 262, 220, 196]
];
let currentTrackIdx = 0;

export function initAudio() {
  const toggleBtn = document.getElementById('t-snd');
  const globalAudioBtn = document.getElementById('audio-toggle-btn');

  const updateSoundState = (enabled) => {
    isSoundEnabled = enabled;
    if (toggleBtn) {
      toggleBtn.setAttribute('aria-pressed', enabled ? 'true' : 'false');
    }
    if (globalAudioBtn) {
      globalAudioBtn.innerHTML = enabled ? '🔊 Suara: ON' : '🔈 Suara: OFF';
      globalAudioBtn.setAttribute('aria-pressed', enabled ? 'true' : 'false');
    }
    if (enabled) {
      beep(800, 0.1, true);
    }
  };

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      const nextState = toggleBtn.getAttribute('aria-pressed') !== 'true';
      updateSoundState(nextState);
    });
  }

  if (globalAudioBtn) {
    globalAudioBtn.addEventListener('click', () => {
      updateSoundState(!isSoundEnabled);
    });
  }
}

export function getAudioContext() {
  if (!audioCtx) {
    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
    if (AudioContextClass) {
      audioCtx = new AudioContextClass();
    }
  }
  if (audioCtx && audioCtx.state === 'suspended') {
    audioCtx.resume();
  }
  return audioCtx;
}

export function isAudioOn() {
  return isSoundEnabled;
}

export function setAudioOn(state) {
  isSoundEnabled = !!state;
}

export function beep(freq = 660, duration = 0.08, force = false, waveType = 'square') {
  if (!isSoundEnabled && !force) return;
  const ctx = getAudioContext();
  if (!ctx) return;

  try {
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = waveType;
    osc.frequency.setValueAtTime(freq, ctx.currentTime);
    gain.gain.setValueAtTime(0.06, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);

    osc.connect(gain);
    gain.connect(ctx.destination);

    osc.start();
    osc.stop(ctx.currentTime + duration);
  } catch (e) {
    console.debug('Audio error:', e);
  }
}

export function playEatSound() {
  beep(440, 0.1, true, 'triangle');
  setTimeout(() => beep(660, 0.15, true, 'square'), 80);
}

export function playFanfare() {
  const notes = [523.25, 659.25, 783.99, 1046.5];
  notes.forEach((freq, idx) => {
    setTimeout(() => beep(freq, 0.12, true, 'triangle'), idx * 110);
  });
}

export function toggleWinampMusic(playButton, equalizerEl) {
  const ctx = getAudioContext();
  const winampWindow = document.getElementById('w2');

  if (currentMusicTimer) {
    clearInterval(currentMusicTimer);
    currentMusicTimer = null;
    if (winampWindow) winampWindow.classList.remove('pl');
    if (playButton) playButton.textContent = '▶ Putar';
  } else {
    if (winampWindow) winampWindow.classList.add('pl');
    if (playButton) playButton.textContent = '■ Berhenti';

    const selectedTrack = tracks[currentTrackIdx % tracks.length];
    currentTrackIdx++;
    let noteIdx = 0;

    currentMusicTimer = setInterval(() => {
      const freq = selectedTrack[noteIdx % selectedTrack.length];
      noteIdx++;
      beep(freq, 0.14, true, 'square');
    }, 220);
  }
}

