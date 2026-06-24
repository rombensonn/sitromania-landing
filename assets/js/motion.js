import { animate, inView } from './framer-motion.esm.js';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!reduceMotion) {
  animate(
    '.site-header',
    { opacity: [0, 1], y: [-18, 0], filter: ['blur(8px)', 'blur(0px)'] },
    { duration: 0.65, ease: [0.16, 1, 0.3, 1] }
  );

  animate(
    '.hero__content > *',
    { opacity: [0, 1], y: [28, 0] },
    { duration: 0.8, delay: (index) => index * 0.08, ease: [0.16, 1, 0.3, 1] }
  );

  animate(
    '.hero__photo-card',
    { opacity: [0, 1], y: [60, 0], scale: [0.96, 1] },
    { duration: 0.9, delay: (index) => 0.2 + index * 0.12, ease: [0.16, 1, 0.3, 1] }
  );

  inView(
    '.section, .service-card, .advantage-card, .review-card, .brand-badge, .process-list li, .photo-grid figure, .contacts-card, .lead-form',
    (element) => {
      animate(
        element,
        { opacity: [0, 1], y: [48, 0], scale: [0.985, 1] },
        { duration: 0.72, ease: [0.16, 1, 0.3, 1] }
      );
    },
    { margin: '0px 0px -12% 0px', amount: 0.18 }
  );

  document.querySelectorAll('.btn, .service-card, .advantage-card, .review-card, .brand-badge, .photo-grid figure').forEach((element) => {
    element.addEventListener('pointerenter', () => {
      animate(element, { y: -6, scale: 1.012 }, { duration: 0.22, ease: 'easeOut' });
    });
    element.addEventListener('pointerleave', () => {
      animate(element, { y: 0, scale: 1 }, { duration: 0.28, ease: 'easeOut' });
    });
  });
}
