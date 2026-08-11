// =========================================
// MAIN JAVASCRIPT LOGIC
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initBackToTop();
  updateFooterYear();
  initHeroSlideshow();
  initStaySlider();
});

// Sticky Navbar
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
}

// Mobile Menu
function initMobileMenu() {
  const mobileBtn = document.querySelector('.mobile-menu-btn');
  const navLinks = document.querySelector('.nav-links');
  
  if (!mobileBtn || !navLinks) return;

  mobileBtn.addEventListener('click', () => {
    mobileBtn.classList.toggle('active');
    navLinks.classList.toggle('active');
  });

  // Close menu when clicking a link
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      mobileBtn.classList.remove('active');
      navLinks.classList.remove('active');
    });
  });
}

// Back to Top Button
function initBackToTop() {
  const btn = document.getElementById('back-to-top');
  if (!btn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      btn.classList.add('visible');
    } else {
      btn.classList.remove('visible');
    }
  });

  btn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

// Footer Year
function updateFooterYear() {
  const yearEl = document.getElementById('current-year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
}

// Toast Notifications
window.showToast = function(message) {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.textContent = message;

  container.appendChild(toast);

  // Trigger animation
  setTimeout(() => {
    toast.classList.add('show');
  }, 10);

  // Remove after 3 seconds
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 3000);
};

// Utilities for formatting
window.formatPrice = function(price) {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    maximumFractionDigits: 0
  }).format(price);
};

// LocalStorage for Favorites
window.toggleFavorite = function(id, btnElement) {
  let favorites = JSON.parse(localStorage.getItem('hyve_favorites') || '[]');
  
  if (favorites.includes(id)) {
    favorites = favorites.filter(favId => favId !== id);
    btnElement.classList.remove('active');
    showToast('Removed from favorites');
  } else {
    favorites.push(id);
    btnElement.classList.add('active');
    showToast('Added to favorites');
  }
  
  localStorage.setItem('hyve_favorites', JSON.stringify(favorites));
};

window.isFavorite = function(id) {
  const favorites = JSON.parse(localStorage.getItem('hyve_favorites') || '[]');
  return favorites.includes(id);
};

// Hero Slideshow
function initHeroSlideshow() {
  const slides = document.querySelectorAll('.hero-slide');
  if (slides.length === 0) return;
  
  let currentSlide = 0;
  
  setInterval(() => {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
  }, 5000);
}

// Stay Slider
function initStaySlider() {
  const track = document.querySelector('.stay-slider-track');
  const prevBtn = document.querySelector('.stay-nav-prev');
  const nextBtn = document.querySelector('.stay-nav-next');
  if (!track || !prevBtn || !nextBtn) return;

  let isAnimating = false;
  
  prevBtn.addEventListener('click', () => {
    if (isAnimating) return;
    isAnimating = true;
    
    const card = track.querySelector('.stay-card');
    if (!card) return;
    const cardWidth = card.offsetWidth + 20; // card width + gap
    
    // Instantly move last element to front and offset track
    track.style.transition = 'none';
    track.prepend(track.lastElementChild);
    track.style.transform = `translateX(-${cardWidth}px)`;
    
    // Force reflow
    void track.offsetWidth;
    
    // Animate to 0
    track.style.transition = 'transform 0.4s ease-in-out';
    track.style.transform = 'translateX(0)';
    
    setTimeout(() => {
      isAnimating = false;
    }, 400);
  });

  nextBtn.addEventListener('click', () => {
    if (isAnimating) return;
    isAnimating = true;
    
    const card = track.querySelector('.stay-card');
    if (!card) return;
    const cardWidth = card.offsetWidth + 20; // card width + gap
    
    // Animate to left
    track.style.transition = 'transform 0.4s ease-in-out';
    track.style.transform = `translateX(-${cardWidth}px)`;
    
    setTimeout(() => {
      // Instantly move first element to back and reset offset
      track.style.transition = 'none';
      track.appendChild(track.firstElementChild);
      track.style.transform = 'translateX(0)';
      
      // Force reflow
      void track.offsetWidth;
      isAnimating = false;
    }, 400);
  });
}
