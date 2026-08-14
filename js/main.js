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
  initPremiumTestimonials();
  initListPropertyModal();
});

function initListPropertyModal() {
  const modalHtml = `
    <div id="listPropertyModal" class="modal">
      <div class="modal-content">
        <span class="close-modal" id="closeListPropertyModal">&times;</span>
        <h2 style="margin-bottom: 20px;">List Your Property</h2>
        <form id="listPropertyForm">
          <div class="form-group">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Property Type</label>
            <select name="property_type" class="form-control" required>
              <option value="">Select Type</option>
              <option value="House">House</option>
              <option value="Apartment">Apartment</option>
              <option value="Villa">Villa</option>
              <option value="Condo">Condo</option>
              <option value="Commercial">Commercial</option>
              <option value="Land">Land</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" placeholder="City, Neighborhood" required>
          </div>
          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Additional Notes</label>
            <textarea name="additional_notes" class="form-control" rows="2"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Submit Listing</button>
        </form>
      </div>
    </div>
  `;

  document.body.insertAdjacentHTML('beforeend', modalHtml);

  const modal = document.getElementById('listPropertyModal');
  const closeBtn = document.getElementById('closeListPropertyModal');
  const form = document.getElementById('listPropertyForm');
  const listBtns = document.querySelectorAll('.nav-list-property');

  listBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      modal.style.display = 'flex';
    });
  });

  closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.textContent = 'Submitting...';
    submitBtn.disabled = true;

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    try {
      const response = await fetch('/api/list-property', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(data)
      });

      if (response.ok) {
        showToast('Property details submitted successfully!');
        form.reset();
        modal.style.display = 'none';
      } else {
        const errorData = await response.json();
        showToast(errorData.message || 'Error submitting form. Please try again.');
      }
    } catch (error) {
      showToast('A network error occurred. Please try again.');
    } finally {
      submitBtn.textContent = 'Submit Listing';
      submitBtn.disabled = false;
    }
  });
}

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
  const dots = document.querySelectorAll('.stay-dot');
  if (!track || !prevBtn || !nextBtn) return;

  let isAnimating = false;
  let currentDot = 0;

  function updateDots() {
    if (dots.length === 0) return;
    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[currentDot]) {
      dots[currentDot].classList.add('active');
    }
  }
  
  prevBtn.addEventListener('click', () => {
    if (isAnimating) return;
    isAnimating = true;
    
    if (dots.length > 0) {
      currentDot = (currentDot - 1 + dots.length) % dots.length;
      updateDots();
    }
    
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
    
    if (dots.length > 0) {
      currentDot = (currentDot + 1) % dots.length;
      updateDots();
    }
    
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

// Premium Testimonials Slider
function initPremiumTestimonials() {
  const track = document.getElementById('pt-track');
  const prevBtn = document.getElementById('pt-btn-prev');
  const nextBtn = document.getElementById('pt-btn-next');
  if (!track || !prevBtn || !nextBtn) return;

  let isAnimating = false;
  let autoplayInterval;

  const startAutoplay = () => {
    autoplayInterval = setInterval(() => {
      nextSlide();
    }, 5000); // 5 seconds
  };

  const stopAutoplay = () => {
    clearInterval(autoplayInterval);
  };

  const resetAutoplay = () => {
    stopAutoplay();
    startAutoplay();
  };

  const prevSlide = () => {
    if (isAnimating) return;
    isAnimating = true;
    resetAutoplay();

    // Instantly move last to front
    track.style.transition = 'none';
    track.prepend(track.lastElementChild);
    track.style.transform = 'translateX(-100%)';

    void track.offsetWidth; // Reflow

    // Animate to 0
    track.style.transition = 'transform 0.4s ease-in-out';
    track.style.transform = 'translateX(0)';

    setTimeout(() => { isAnimating = false; }, 400);
  };

  const nextSlide = () => {
    if (isAnimating) return;
    isAnimating = true;
    resetAutoplay();

    track.style.transition = 'transform 0.4s ease-in-out';
    track.style.transform = 'translateX(-100%)';

    setTimeout(() => {
      track.style.transition = 'none';
      track.appendChild(track.firstElementChild);
      track.style.transform = 'translateX(0)';
      void track.offsetWidth;
      isAnimating = false;
    }, 400);
  };

  prevBtn.addEventListener('click', prevSlide);
  nextBtn.addEventListener('click', nextSlide);

  // Pause on hover
  const container = document.querySelector('.premium-testimonial-block');
  if (container) {
    container.addEventListener('mouseenter', stopAutoplay);
    container.addEventListener('mouseleave', startAutoplay);
  }

  // Start initial autoplay
  startAutoplay();
}
