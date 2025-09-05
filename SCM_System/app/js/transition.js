// transitions.js
// Matches the CSS duration (500ms). Keep in sync.
const TRANSITION_MS = 500;

(function () {
  // Fade in when DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    // allow a tick so CSS initial state applies
    requestAnimationFrame(() => requestAnimationFrame(() => {
      document.body.classList.add('fade-in');
    }));
  });

  // Intercept internal link clicks to play fade-out then navigate.
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a');
    if (!a) return;

    // Allow links that explicitly open new tabs, anchors, mailto, tel, or external hosts
    const href = a.getAttribute('href') || '';
    if (a.target === '_blank' || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    if (/^https?:\/\//i.test(href) && !href.includes(location.hostname)) return;

    // Avoid intercepting empty or javascript: links
    if (!href || href.startsWith('javascript:')) return;

    // Prevent default and animate out
    e.preventDefault();
    document.body.classList.remove('fade-in');
    document.body.classList.add('fade-out');

    // After transition, navigate
    setTimeout(() => {
      // If link is relative, let the browser resolve it
      location.href = href;
    }, TRANSITION_MS);
  });

  // When page is restored from bfcache (back/forward), ensure fade-in is present
  window.addEventListener('pageshow', (evt) => {
    if (evt.persisted) {
      document.body.classList.add('fade-in');
    }
  });
})();