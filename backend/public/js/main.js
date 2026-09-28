// =========================================
// MAIN JAVASCRIPT LOGIC
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  initIntroAnimation();
  initCurrencySelector();
  initNavbar();
  initMobileMenu();
  initBackToTop();
  updateFooterYear();
  initHeroSlideshow();
  initStaySlider();
  initPremiumTestimonials();
  initListPropertyModal();
  initServicesAccordion();
  initServicesEstimator();
  initHeroSearch();
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
  const listBtns = document.querySelectorAll('.nav-list-property, .open-list-modal');

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
      // Simulated API call for GitHub Pages static hosting
      await new Promise(resolve => setTimeout(resolve, 800));

      showToast('Property details submitted successfully!');
      form.reset();
      modal.style.display = 'none';
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

// =========================================
// MULTI-CURRENCY ENGINE
// Currencies: LKR (First / Default), USD, YEN, AUD, CAD, EUROS
// =========================================
window.HYVE_CURRENCIES = {
  LKR: { code: 'LKR', label: 'LKR', symbol: 'Rs. ', flag: '🇱🇰', icon: 'https://hatscripts.github.io/circle-flags/flags/lk.svg', rate: 308.0, locale: 'en-LK', name: 'Sri Lankan Rupee' },
  USD: { code: 'USD', label: 'USD', symbol: '$', flag: '🇺🇸', icon: 'https://hatscripts.github.io/circle-flags/flags/us.svg', rate: 1.0, locale: 'en-US', name: 'US Dollar' },
  YEN: { code: 'JPY', label: 'YEN', symbol: '¥', flag: '🇯🇵', icon: 'https://hatscripts.github.io/circle-flags/flags/jp.svg', rate: 155.0, locale: 'ja-JP', name: 'Japanese Yen' },
  AUD: { code: 'AUD', label: 'AUD', symbol: 'A$', flag: '🇦🇺', icon: 'https://hatscripts.github.io/circle-flags/flags/au.svg', rate: 1.55, locale: 'en-AU', name: 'Australian Dollar' },
  CAD: { code: 'CAD', label: 'CAD', symbol: 'C$', flag: '🇨🇦', icon: 'https://hatscripts.github.io/circle-flags/flags/ca.svg', rate: 1.39, locale: 'en-CA', name: 'Canadian Dollar' },
  EUR: { code: 'EUR', label: 'EUROS', symbol: '€', flag: '🇪🇺', icon: 'https://hatscripts.github.io/circle-flags/flags/eu.svg', rate: 0.92, locale: 'de-DE', name: 'Euro' }
};

window.getCurrentCurrency = function() {
  const saved = localStorage.getItem('hyve_currency');
  if (saved && window.HYVE_CURRENCIES[saved]) {
    return saved;
  }
  return 'LKR'; // Default LKR first
};

window.convertPrice = function(usdAmount, targetCurrency) {
  if (usdAmount === undefined || usdAmount === null || isNaN(usdAmount)) return 0;
  const curr = targetCurrency || window.getCurrentCurrency();
  const cfg = window.HYVE_CURRENCIES[curr] || window.HYVE_CURRENCIES['LKR'];
  return Math.round(Number(usdAmount) * cfg.rate);
};

window.formatPrice = function(usdPrice, targetCurrency) {
  if (usdPrice === undefined || usdPrice === null || isNaN(usdPrice)) return '0';
  const curr = targetCurrency || window.getCurrentCurrency();
  const cfg = window.HYVE_CURRENCIES[curr] || window.HYVE_CURRENCIES['LKR'];
  const converted = Math.round(Number(usdPrice) * cfg.rate);

  if (cfg.code === 'LKR') {
    return 'Rs. ' + converted.toLocaleString('en-US');
  } else if (cfg.code === 'USD') {
    return '$' + converted.toLocaleString('en-US');
  } else if (cfg.code === 'JPY') {
    return '¥' + converted.toLocaleString('ja-JP');
  } else if (cfg.code === 'AUD') {
    return 'A$' + converted.toLocaleString('en-AU');
  } else if (cfg.code === 'CAD') {
    return 'C$' + converted.toLocaleString('en-CA');
  } else if (cfg.code === 'EUR') {
    return '€' + converted.toLocaleString('de-DE');
  }
  return (cfg.symbol || '') + converted.toLocaleString('en-US');
};

window.setCurrency = function(currencyKey) {
  if (!window.HYVE_CURRENCIES[currencyKey]) return;
  localStorage.setItem('hyve_currency', currencyKey);

  updateCurrencyButtonUI(currencyKey);
  updateCurrencyLabels(currencyKey);

  window.dispatchEvent(new CustomEvent('currencyChanged', {
    detail: {
      currency: currencyKey,
      config: window.HYVE_CURRENCIES[currencyKey]
    }
  }));
};

function updateCurrencyButtonUI(currencyKey) {
  const cfg = window.HYVE_CURRENCIES[currencyKey] || window.HYVE_CURRENCIES['LKR'];

  // Navbar button elements
  const flagEl = document.getElementById('current-currency-flag');
  const codeEl = document.getElementById('current-currency-code');
  const symbolEl = document.getElementById('current-currency-symbol');
  if (flagEl) flagEl.textContent = cfg.flag;
  if (codeEl) codeEl.textContent = cfg.label;
  if (symbolEl) symbolEl.textContent = cfg.symbol.trim();

  // Navbar pill button elements
  const ncFlag = document.getElementById('nc-current-flag');
  const ncCode = document.getElementById('nc-current-code');
  const ncBtn = document.getElementById('navbar-currency-btn');
  if (ncFlag) ncFlag.innerHTML = `<img src="${cfg.icon}" alt="${cfg.code}" class="currency-flag-icon">`;
  if (ncCode) ncCode.textContent = cfg.label;
  if (ncBtn) ncBtn.setAttribute('title', `Currency: ${cfg.label} (${cfg.symbol.trim()}) - Click to change`);

  document.querySelectorAll('.currency-option, .curr-opt-item').forEach(opt => {
    if (opt.getAttribute('data-currency') === currencyKey) {
      opt.classList.add('active');
    } else {
      opt.classList.remove('active');
    }
  });
}

function updateCurrencyLabels(currencyKey) {
  const cfg = window.HYVE_CURRENCIES[currencyKey] || window.HYVE_CURRENCIES['LKR'];
  document.querySelectorAll('.curr-symbol-label').forEach(el => {
    el.textContent = cfg.symbol.trim() || cfg.label;
  });
  document.querySelectorAll('.curr-code-label').forEach(el => {
    el.textContent = cfg.label;
  });
}

function fetchLiveRates() {
  fetch('https://open.er-api.com/v6/latest/USD')
    .then(res => res.json())
    .then(data => {
      if (data && data.rates) {
        if (data.rates.LKR) window.HYVE_CURRENCIES.LKR.rate = data.rates.LKR;
        if (data.rates.JPY) window.HYVE_CURRENCIES.YEN.rate = data.rates.JPY;
        if (data.rates.AUD) window.HYVE_CURRENCIES.AUD.rate = data.rates.AUD;
        if (data.rates.CAD) window.HYVE_CURRENCIES.CAD.rate = data.rates.CAD;
        if (data.rates.EUR) window.HYVE_CURRENCIES.EUR.rate = data.rates.EUR;

        const current = window.getCurrentCurrency();
        window.dispatchEvent(new CustomEvent('currencyChanged', {
          detail: { currency: current, config: window.HYVE_CURRENCIES[current] }
        }));
      }
    })
    .catch(() => { /* Fallback to default rates */ });
}

function initCurrencySelector() {
  const current = window.getCurrentCurrency();

  updateCurrencyButtonUI(current);
  updateCurrencyLabels(current);

  fetchLiveRates();
  initFloatingCurrencyChanger();
}

function initFloatingCurrencyChanger() {
  let wrapper = document.getElementById('navbar-currency-wrapper');
  const current = window.getCurrentCurrency();
  const cfg = window.HYVE_CURRENCIES[current] || window.HYVE_CURRENCIES['LKR'];

  if (!wrapper) {
    wrapper = document.createElement('li');
    const isLightMode = !!document.querySelector('.navbar .light-mode');
    wrapper.className = isLightMode ? 'navbar-currency-wrapper light-mode' : 'navbar-currency-wrapper';
    wrapper.id = 'navbar-currency-wrapper';
    wrapper.innerHTML = `
      <button class="navbar-currency-btn" id="navbar-currency-btn" type="button" aria-label="Change Currency" title="Currency: ${cfg.label} (${cfg.symbol.trim()}) - Click to change">
        <span class="nc-flag" id="nc-current-flag"><img src="${cfg.icon}" alt="${cfg.code}" class="currency-flag-icon"></span>
        <span class="nc-code" id="nc-current-code">${cfg.label}</span>
      </button>
      <div class="floating-currency-menu" id="floating-currency-menu">
        <div class="menu-heading">
          <span>Select Currency</span>
          <span style="color: var(--color-accent, #14335C); font-weight: 700;">HYVE</span>
        </div>
        <button class="curr-opt-item ${current === 'LKR' ? 'active' : ''}" data-currency="LKR">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/lk.svg" alt="LKR" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">LKR <span class="curr-opt-symbol">Rs.</span></span>
            <span class="curr-opt-name">Sri Lankan Rupee</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'USD' ? 'active' : ''}" data-currency="USD">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/us.svg" alt="USD" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">USD <span class="curr-opt-symbol">$</span></span>
            <span class="curr-opt-name">US Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'YEN' ? 'active' : ''}" data-currency="YEN">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/jp.svg" alt="JPY" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">YEN <span class="curr-opt-symbol">¥</span></span>
            <span class="curr-opt-name">Japanese Yen (JPY)</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'AUD' ? 'active' : ''}" data-currency="AUD">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/au.svg" alt="AUD" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">AUD <span class="curr-opt-symbol">A$</span></span>
            <span class="curr-opt-name">Australian Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'CAD' ? 'active' : ''}" data-currency="CAD">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/ca.svg" alt="CAD" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">CAD <span class="curr-opt-symbol">C$</span></span>
            <span class="curr-opt-name">Canadian Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'EUR' ? 'active' : ''}" data-currency="EUR">
          <span class="curr-opt-flag"><img src="https://hatscripts.github.io/circle-flags/flags/eu.svg" alt="EUR" class="currency-flag-icon"></span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">EUROS <span class="curr-opt-symbol">€</span></span>
            <span class="curr-opt-name">Euro</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
      </div>
    `;
    
    const navLinks = document.querySelector('.nav-links');
    if (navLinks) {
      navLinks.appendChild(wrapper);
    } else {
      document.body.appendChild(wrapper);
    }
  }

  const ncBtn = wrapper.querySelector('#navbar-currency-btn');
  if (ncBtn) {
    ncBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      wrapper.classList.toggle('open');
    });
  }

  wrapper.querySelectorAll('.curr-opt-item').forEach(opt => {
    opt.addEventListener('click', (e) => {
      e.stopPropagation();
      const code = opt.getAttribute('data-currency');
      window.setCurrency(code);
      wrapper.classList.remove('open');
    });
  });

  document.addEventListener('click', (e) => {
    if (!wrapper.contains(e.target)) {
      wrapper.classList.remove('open');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && wrapper.classList.contains('open')) {
      wrapper.classList.remove('open');
    }
  });
}

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

// =========================================
// LUXURY INTRO ANIMATION OVERLAY
// =========================================
function initIntroAnimation() {
  const overlay = document.getElementById('intro-overlay');
  if (!overlay) return;

  // Reduced motion preference
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    overlay.remove();
    return;
  }

  let isCompleted = false;

  function completeIntro() {
    if (isCompleted) return;
    isCompleted = true;
    overlay.classList.add('fade-out');
    setTimeout(() => {
      overlay.remove();
    }, 600);
    window.removeEventListener('keydown', onKey);
    window.removeEventListener('click', onClickSkip);
    window.removeEventListener('touchstart', onClickSkip);
    window.removeEventListener('wheel', onClickSkip);
  }

  function onClickSkip() {
    completeIntro();
  }

  function onKey(e) {
    if (e.key === 'Escape' || e.key === ' ' || e.key === 'Enter') {
      completeIntro();
    }
  }

  window.addEventListener('click', onClickSkip, { once: true });
  window.addEventListener('touchstart', onClickSkip, { once: true, passive: true });
  window.addEventListener('wheel', onClickSkip, { once: true, passive: true });
  window.addEventListener('keydown', onKey);

  // Step 1: 350ms - Circle image emerges smoothly behind/around the central logo
  setTimeout(() => {
    if (isCompleted) return;
    overlay.classList.add('intro-step-circle');
  }, 350);

  // Step 2: 950ms - Circle expands organically outward to fill viewport, logo fades
  setTimeout(() => {
    if (isCompleted) return;
    overlay.classList.add('intro-step-expand');
  }, 950);

  // Step 3: 2200ms - Smoothly fade out overlay to seamlessly reveal the homepage hero
  setTimeout(() => {
    completeIntro();
  }, 2200);
}

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
  const dotsContainer = document.getElementById('stay-slider-dots');
  const staySection = document.querySelector('.stay-section');
  
  if (!track || !staySection) return;

  let stayProperties = [];
  if (typeof propertiesData !== 'undefined') {
    stayProperties = propertiesData.filter(p => p.rental_type === 'short_term').slice(0, 6);
  }

  if (stayProperties.length === 0) {
    staySection.style.display = 'none';
    return;
  }

  // Generate cards
  let cardsHtml = '';
  // Duplicate properties to ensure continuous sliding if there are few
  const displayProperties = stayProperties.length < 4 ? [...stayProperties, ...stayProperties] : stayProperties;
  
  displayProperties.forEach(property => {
    const imgSrc = (property.images && property.images.length > 0) ? property.images[0] : 'assets/images/luxury_villa_1786339560928.png';
    cardsHtml += `
      <div class="stay-card">
        <div class="stay-image">
          <img src="${imgSrc}" alt="${property.title}">
        </div>
        <div class="stay-info">
          <span class="stay-location text-xs uppercase" style="color: #e67e22; font-weight: 500; letter-spacing: 0.5px; font-size: 0.85rem; margin-bottom: 8px; display: block;">${property.city || property.location || 'LOCATION'}</span>
          <h3 class="stay-title" style="font-family: var(--font-secondary); font-weight: 500; font-size: 1.5rem; margin-bottom: 12px; color: #000;">${property.title}</h3>
          <div style="color: #666; font-size: 0.8rem; display: flex; align-items: center; gap: 6px; font-weight: 500; text-transform: uppercase; margin-bottom: 16px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            ${property.location}
          </div>
          <p style="color: var(--color-text-main); font-size: 0.95rem; line-height: 1.5; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
            ${property.description || ''}
          </p>

          <a href="property-details.html?id=${property.id}" class="btn-text" style="font-weight: 600; font-size: 0.9rem; color: var(--color-accent); margin-top: auto; align-self: center; text-decoration: none;">View More</a>
        </div>
      </div>
    `;
  });
  
  track.innerHTML = cardsHtml;

  // Generate dots
  if (dotsContainer) {
    let dotsHtml = '';
    stayProperties.forEach((_, index) => {
      dotsHtml += `<div class="stay-dot ${index === 0 ? 'active' : ''}"></div>`;
    });
    dotsContainer.innerHTML = dotsHtml;
  }

  const prevBtn = document.querySelector('.stay-nav-prev');
  const nextBtn = document.querySelector('.stay-nav-next');
  const dots = document.querySelectorAll('.stay-dot');
  
  if (!prevBtn || !nextBtn) return;

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
    const gap = parseInt(window.getComputedStyle(track).gap) || 20;
    const cardWidth = card.offsetWidth + gap; // card width + gap
    
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
    const gap = parseInt(window.getComputedStyle(track).gap) || 20;
    const cardWidth = card.offsetWidth + gap; // card width + gap
    
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

  // Touch Swipe Logic
  let startX = 0;
  let currentX = 0;

  track.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    currentX = startX;
  }, {passive: true});

  track.addEventListener('touchmove', (e) => {
    currentX = e.touches[0].clientX;
  }, {passive: true});

  track.addEventListener('touchend', () => {
    if (startX - currentX > 50) {
      nextBtn.click();
    } else if (currentX - startX > 50) {
      prevBtn.click();
    }
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

// =========================================
// SERVICES PAGE: ACCORDION & ESTIMATOR
// =========================================

function initServicesAccordion() {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    if (!question) return;

    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');
      
      // Close other open accordions
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('active');
        }
      });

      // Toggle current item
      if (isActive) {
        item.classList.remove('active');
      } else {
        item.classList.add('active');
      }
    });
  });
}

function initServicesEstimator() {
  const typeSelect = document.getElementById('calc-prop-type');
  const goalSelect = document.getElementById('calc-prop-goal');
  const locSelect = document.getElementById('calc-prop-loc');
  const resultVal = document.getElementById('calc-result-val');
  const resultLabel = document.getElementById('calc-result-label');
  const ctaBtn = document.getElementById('calc-cta-btn');

  if (!typeSelect || !goalSelect || !resultVal) return;

  const updateEstimator = () => {
    const type = typeSelect.value;
    const goal = goalSelect.value;
    const loc = locSelect ? locSelect.value : 'colombo';

    let label = 'Estimated Return';
    let value = 'Rs. 450,000 - 800,000';

    if (goal === 'sell') {
      label = 'Average Liquidity Window';
      value = '35 - 55 Days to Close';
    } else if (goal === 'long_term') {
      label = 'Projected Monthly Rent';
      if (type === 'Apartment') {
        value = loc === 'prime' ? 'Rs. 350,000 - 750,000/mo' : 'Rs. 250,000 - 500,000/mo';
      } else if (type === 'Villa') {
        value = 'Rs. 500,000 - 1,200,000/mo';
      } else if (type === 'Commercial') {
        value = 'Rs. 600,000 - 2,500,000/mo';
      } else {
        value = 'Rs. 300,000 - 650,000/mo';
      }
    } else if (goal === 'airbnb') {
      label = 'Projected Short-Term Net Yield';
      if (type === 'Villa') {
        value = '11.5% - 15.0% Net Annual';
      } else if (type === 'Apartment') {
        value = loc === 'prime' ? '9.0% - 13.5% Net Annual' : '8.0% - 11.0% Net Annual';
      } else {
        value = '8.5% - 12.0% Net Annual';
      }
    } else if (goal === 'manage') {
      label = 'Asset Care Commitment';
      value = '100% Turnkey / 0-Effort';
    }

    if (resultLabel) resultLabel.textContent = label;
    if (resultVal) resultVal.textContent = value;
  };

  typeSelect.addEventListener('change', updateEstimator);
  goalSelect.addEventListener('change', updateEstimator);
  if (locSelect) locSelect.addEventListener('change', updateEstimator);

  // Initial calculation
  updateEstimator();

  if (ctaBtn) {
    ctaBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const modal = document.getElementById('listPropertyModal');
      if (modal) {
        // Pre-fill type in modal if available
        const modalTypeSelect = modal.querySelector('select[name="property_type"]');
        if (modalTypeSelect && typeSelect.value) {
          modalTypeSelect.value = typeSelect.value;
        }
        modal.style.display = 'flex';
      }
    });
  }
}

// =========================================
// LUXURY HERO SEARCH FILTER CONTROLLER
// =========================================
function initHeroSearch() {
  const tabs = document.querySelectorAll('.hero-search-tabs .search-tab');
  const form = document.getElementById('hero-search-form');
  const purposeInput = document.getElementById('h-purpose');
  const btnText = document.getElementById('hero-btn-text');
  const locationInput = document.getElementById('h-location');
  const typeSelect = document.getElementById('h-type');
  const bedsSelect = document.getElementById('h-beds');
  const bedsLabel = document.getElementById('h-beds-label');
  const quickTags = document.querySelectorAll('.quicktag-btn');

  if (!form) return;

  // Handle Tab Switching (Buy / Rent / Stays)
  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      tabs.forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');

      const mode = tab.dataset.mode;
      if (mode === 'stays') {
        form.action = 'short-term-rentals.html';
        if (purposeInput) purposeInput.value = 'short_term';
        if (btnText) btnText.textContent = 'Find Stays';
        if (locationInput) locationInput.placeholder = 'Where do you want to stay?';
        if (bedsLabel) bedsLabel.textContent = 'Guests / Beds';
        if (bedsSelect) {
          bedsSelect.options[0].text = 'Any Guests';
          bedsSelect.options[1].text = '1 Guest / Bed';
          bedsSelect.options[2].text = '2 Guests / Beds';
          bedsSelect.options[3].text = '3 Guests / Beds';
          bedsSelect.options[4].text = '4+ Guests / Beds';
        }
      } else {
        form.action = 'properties.html';
        if (purposeInput) purposeInput.value = mode; // 'buy' or 'rent'
        if (btnText) btnText.textContent = mode === 'rent' ? 'Search Rentals' : 'Search Properties';
        if (locationInput) locationInput.placeholder = 'City or neighborhood...';
        if (bedsLabel) bedsLabel.textContent = 'Bedrooms';
        if (bedsSelect) {
          bedsSelect.options[0].text = 'Any Beds';
          bedsSelect.options[1].text = '1 Bed';
          bedsSelect.options[2].text = '2 Beds';
          bedsSelect.options[3].text = '3 Beds';
          bedsSelect.options[4].text = '4+ Beds';
        }
      }
    });
  });

  // Clicking anywhere on a segment focuses its child input/select
  document.querySelectorAll('.search-field-segment').forEach(segment => {
    segment.addEventListener('click', (e) => {
      if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'SELECT' && e.target.tagName !== 'OPTION') {
        const input = segment.querySelector('input, select');
        if (input) input.focus();
      }
    });
  });

  // Popular Quick Discovery Tags
  quickTags.forEach(tag => {
    tag.addEventListener('click', (e) => {
      e.preventDefault();
      const loc = tag.dataset.searchLocation;
      const type = tag.dataset.searchType;
      if (loc && locationInput) {
        locationInput.value = loc;
        locationInput.focus();
      }
      if (type && typeSelect) {
        typeSelect.value = type;
        typeSelect.focus();
      }
    });
  });
}

