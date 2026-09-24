// =========================================
// ANIMATIONS & SCROLL REVEALS
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  initScrollReveals();
  initCounters();
});

// Intersection Observer for scroll animations
function initScrollReveals() {
  const revealElements = document.querySelectorAll('.reveal-hidden');
  
  if (!revealElements.length || !window.IntersectionObserver) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Get animation class from data attribute or default to fade
        const animClass = entry.target.dataset.animation || 'reveal-fade';
        entry.target.classList.add(animClass);
        // Stop observing once revealed
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.05, // Trigger as soon as entering view
    rootMargin: "0px 0px 50px 0px" // Trigger 50px before it comes into view for smooth UX
  });

  revealElements.forEach(el => observer.observe(el));
}

// Number Counter Animation for About Section
function initCounters() {
  const counters = document.querySelectorAll('.stat-number');
  if (!counters.length || !window.IntersectionObserver) return;

  const animateCounter = (counter) => {
    const target = +counter.getAttribute('data-target');
    const duration = 2000; // ms
    const increment = target / (duration / 16); // 60fps
    let current = 0;

    const updateCounter = () => {
      current += increment;
      if (current < target) {
        counter.innerText = Math.ceil(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.innerText = target;
      }
    };
    updateCounter();
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(counter => observer.observe(counter));
}
