import Matter from 'matter-js';
import { beep } from './audio.js';
import { showToast } from './kinetic.js';

let engine = null;
let physicsList = [];
let animFrameId = 0;

function buildPhysicsWorld() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
  document.body.style.overflow = 'hidden';
  physicsList = [];

  const W = window.innerWidth;
  const H = window.innerHeight;

  engine = Matter.Engine.create();

  // Find all elements marked with class 'phys'
  const elements = document.querySelectorAll('.phys');
  elements.forEach(el => {
    el.style.transform = '';
    const rect = el.getBoundingClientRect();
    if (rect.width < 4 || rect.top > H || rect.left > W) return;

    const cx = rect.left + rect.width / 2;
    const cy = rect.top + rect.height / 2;

    const body = Matter.Bodies.rectangle(cx, cy, rect.width, rect.height, {
      restitution: 0.65,
      frictionAir: 0.015,
      density: 0.002
    });

    physicsList.push({
      el,
      cx,
      cy,
      body
    });
  });

  // World boundary walls
  const wall = (x, y, w, h) => Matter.Bodies.rectangle(x, y, w, h, { isStatic: true });
  Matter.Composite.add(engine.world, [
    ...physicsList.map(item => item.body),
    wall(W / 2, H + 120, W * 3, 240),
    wall(W / 2, -120, W * 3, 240),
    wall(-120, H / 2, 240, H * 3),
    wall(W + 120, H / 2, 240, H * 3)
  ]);

  // Mouse interaction constraint
  const mouse = Matter.Mouse.create(document.body);
  const mouseConstraint = Matter.MouseConstraint.create(engine, {
    mouse,
    constraint: {
      stiffness: 0.25,
      render: { visible: false }
    }
  });
  Matter.Composite.add(engine.world, mouseConstraint);

  // Simulation tick loop
  function tick() {
    Matter.Engine.update(engine, 1000 / 60);
    physicsList.forEach(item => {
      const deltaX = item.body.position.x - item.cx;
      const deltaY = item.body.position.y - item.cy;
      item.el.style.transform = `translate(${deltaX}px, ${deltaY}px) rotate(${item.body.angle}rad)`;
    });
    animFrameId = requestAnimationFrame(tick);
  }
  tick();
}

export function resetPhysics() {
  if (!engine) return;
  cancelAnimationFrame(animFrameId);
  Matter.World.clear(engine.world, false);
  Matter.Engine.clear(engine);
  engine = null;

  physicsList.forEach(item => {
    item.el.style.transform = '';
  });
  physicsList = [];
  document.body.style.overflow = '';
  beep(400, 0.08);
  showToast('↺ Posisi elemen di-reset!');
}

export function initPhysics() {
  const zeroBtn = document.getElementById('zero');
  const dropBtn = document.getElementById('drop');
  const resetBtn = document.getElementById('reset');

  if (zeroBtn) {
    zeroBtn.addEventListener('click', () => {
      if (!engine) buildPhysicsWorld();
      engine.gravity.y = 0;
      physicsList.forEach(item => {
        Matter.Body.set(item.body, { restitution: 0.95, frictionAir: 0.001 });
        Matter.Body.setVelocity(item.body, {
          x: (Math.random() - 0.5) * 10,
          y: (Math.random() - 0.5) * 10
        });
      });
      beep(320, 0.12);
      showToast('🪐 Zero-G Aktif! Elemen melayang bebas.');
    });
  }

  if (dropBtn) {
    dropBtn.addEventListener('click', () => {
      if (!engine) buildPhysicsWorld();
      engine.gravity.y = 1.2;
      physicsList.forEach(item => {
        Matter.Body.set(item.body, { restitution: 0.6, frictionAir: 0.015 });
        Matter.Body.applyForce(item.body, item.body.position, {
          x: (Math.random() - 0.5) * 0.05,
          y: Math.random() * 0.05
        });
      });
      beep(220, 0.15);
      showToast('💥 Chaos Drop! Gravitasi diaktifkan.');
    });
  }

  if (resetBtn) {
    resetBtn.addEventListener('click', resetPhysics);
  }
}

