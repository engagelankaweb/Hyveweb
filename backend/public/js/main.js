// =========================================
// MAIN JAVASCRIPT LOGIC
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  initCurrencySelector();
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
  LKR: { code: 'LKR', label: 'LKR', symbol: 'Rs. ', flag: '🇱🇰', rate: 308.0, locale: 'en-LK', name: 'Sri Lankan Rupee' },
  USD: { code: 'USD', label: 'USD', symbol: '$', flag: '🇺🇸', rate: 1.0, locale: 'en-US', name: 'US Dollar' },
  YEN: { code: 'JPY', label: 'YEN', symbol: '¥', flag: '🇯🇵', rate: 155.0, locale: 'ja-JP', name: 'Japanese Yen' },
  AUD: { code: 'AUD', label: 'AUD', symbol: 'A$', flag: '🇦🇺', rate: 1.55, locale: 'en-AU', name: 'Australian Dollar' },
  CAD: { code: 'CAD', label: 'CAD', symbol: 'C$', flag: '🇨🇦', rate: 1.39, locale: 'en-CA', name: 'Canadian Dollar' },
  EUR: { code: 'EUR', label: 'EUROS', symbol: '€', flag: '🇪🇺', rate: 0.92, locale: 'de-DE', name: 'Euro' }
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

  // Floating circular button elements (Properties & Short-Term Rentals)
  const fcFlag = document.getElementById('fc-current-flag');
  const fcCode = document.getElementById('fc-current-code');
  const fcBtn = document.getElementById('floating-currency-btn');
  if (fcFlag) fcFlag.textContent = cfg.flag;
  if (fcCode) fcCode.textContent = cfg.label;
  if (fcBtn) fcBtn.setAttribute('title', `Currency: ${cfg.label} (${cfg.symbol.trim()}) - Click to change`);

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
  const isNoCurrencyPage = document.body.classList.contains('no-currency') || 
                           window.location.pathname.includes('about.html') ||
                           window.location.pathname.endsWith('/about');
  if (isNoCurrencyPage) return;

  const navLinks = document.querySelector('.nav-links');
  if (!navLinks) return;

  const current = window.getCurrentCurrency();
  let dropdown = document.querySelector('.currency-dropdown');
  const isLightMode = document.querySelector('.navbar .nav-link')?.classList.contains('light-mode') || false;

  if (!dropdown) {
    const li = document.createElement('li');
    li.className = 'currency-selector-item';
    li.innerHTML = `
      <div class="currency-dropdown" id="currency-dropdown">
        <button class="currency-btn" type="button" aria-haspopup="true" aria-expanded="false" id="currency-toggle-btn">
          <span class="currency-flag" id="current-currency-flag">🇱🇰</span>
          <span class="currency-code" id="current-currency-code">LKR</span>
          <span class="currency-symbol-tag" id="current-currency-symbol">Rs.</span>
          <svg class="currency-chevron" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </button>
        <div class="currency-menu" id="currency-menu">
          <div class="currency-menu-header">Select Currency</div>
          <button class="currency-option ${current === 'LKR' ? 'active' : ''}" data-currency="LKR">
            <span class="curr-opt-flag">🇱🇰</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">LKR <span class="curr-opt-symbol">Rs.</span></span>
              <span class="curr-opt-name">Sri Lankan Rupee</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
          <button class="currency-option ${current === 'USD' ? 'active' : ''}" data-currency="USD">
            <span class="curr-opt-flag">🇺🇸</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">USD <span class="curr-opt-symbol">$</span></span>
              <span class="curr-opt-name">US Dollar</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
          <button class="currency-option ${current === 'YEN' ? 'active' : ''}" data-currency="YEN">
            <span class="curr-opt-flag">🇯🇵</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">YEN <span class="curr-opt-symbol">¥</span></span>
              <span class="curr-opt-name">Japanese Yen (JPY)</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
          <button class="currency-option ${current === 'AUD' ? 'active' : ''}" data-currency="AUD">
            <span class="curr-opt-flag">🇦🇺</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">AUD <span class="curr-opt-symbol">A$</span></span>
              <span class="curr-opt-name">Australian Dollar</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
          <button class="currency-option ${current === 'CAD' ? 'active' : ''}" data-currency="CAD">
            <span class="curr-opt-flag">🇨🇦</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">CAD <span class="curr-opt-symbol">C$</span></span>
              <span class="curr-opt-name">Canadian Dollar</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
          <button class="currency-option ${current === 'EUR' ? 'active' : ''}" data-currency="EUR">
            <span class="curr-opt-flag">🇪🇺</span>
            <span class="curr-opt-details">
              <span class="curr-opt-top">EUROS <span class="curr-opt-symbol">€</span></span>
              <span class="curr-opt-name">Euro</span>
            </span>
            <span class="curr-opt-check">✓</span>
          </button>
        </div>
      </div>
    `;

    const listBtnLi = navLinks.querySelector('.nav-list-property')?.closest('li');
    if (listBtnLi) {
      navLinks.insertBefore(li, listBtnLi);
    } else {
      navLinks.appendChild(li);
    }
    dropdown = li.querySelector('.currency-dropdown');
  }

  updateCurrencyButtonUI(current);
  updateCurrencyLabels(current);

  const toggleBtn = dropdown.querySelector('#currency-toggle-btn');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      dropdown.classList.toggle('open');
      toggleBtn.setAttribute('aria-expanded', dropdown.classList.contains('open'));
    });
  }

  dropdown.querySelectorAll('.currency-option').forEach(opt => {
    opt.addEventListener('click', (e) => {
      e.stopPropagation();
      const code = opt.getAttribute('data-currency');
      window.setCurrency(code);
      dropdown.classList.remove('open');
      if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    });
  });

  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target)) {
      dropdown.classList.remove('open');
      if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && dropdown.classList.contains('open')) {
      dropdown.classList.remove('open');
      if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
    }
  });

  fetchLiveRates();
  initFloatingCurrencyChanger();
}

function initFloatingCurrencyChanger() {
  const isTargetPage = document.body.classList.contains('has-floating-currency') ||
                       window.location.pathname.includes('properties') || 
                       window.location.pathname.includes('short-term-rentals') ||
                       document.getElementById('properties-grid') !== null;
  if (!isTargetPage) return;

  document.body.classList.add('has-floating-currency');

  let wrapper = document.getElementById('floating-currency-wrapper');
  const current = window.getCurrentCurrency();
  const cfg = window.HYVE_CURRENCIES[current] || window.HYVE_CURRENCIES['LKR'];

  if (!wrapper) {
    wrapper = document.createElement('div');
    wrapper.className = 'floating-currency-wrapper';
    wrapper.id = 'floating-currency-wrapper';
    wrapper.innerHTML = `
      <button class="floating-currency-btn" id="floating-currency-btn" type="button" aria-label="Change Currency" title="Currency: ${cfg.label} (${cfg.symbol.trim()}) - Click to change">
        <span class="fc-flag" id="fc-current-flag">${cfg.flag}</span>
        <span class="fc-code" id="fc-current-code">${cfg.label}</span>
      </button>
      <div class="floating-currency-menu" id="floating-currency-menu">
        <div class="menu-heading">
          <span>Select Currency</span>
          <span style="color: var(--color-accent, #D4AF37); font-weight: 700;">HYVE</span>
        </div>
        <button class="curr-opt-item ${current === 'LKR' ? 'active' : ''}" data-currency="LKR">
          <span class="curr-opt-flag">🇱🇰</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">LKR <span class="curr-opt-symbol">Rs.</span></span>
            <span class="curr-opt-name">Sri Lankan Rupee</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'USD' ? 'active' : ''}" data-currency="USD">
          <span class="curr-opt-flag">🇺🇸</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">USD <span class="curr-opt-symbol">$</span></span>
            <span class="curr-opt-name">US Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'YEN' ? 'active' : ''}" data-currency="YEN">
          <span class="curr-opt-flag">🇯🇵</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">YEN <span class="curr-opt-symbol">¥</span></span>
            <span class="curr-opt-name">Japanese Yen (JPY)</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'AUD' ? 'active' : ''}" data-currency="AUD">
          <span class="curr-opt-flag">🇦🇺</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">AUD <span class="curr-opt-symbol">A$</span></span>
            <span class="curr-opt-name">Australian Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'CAD' ? 'active' : ''}" data-currency="CAD">
          <span class="curr-opt-flag">🇨🇦</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">CAD <span class="curr-opt-symbol">C$</span></span>
            <span class="curr-opt-name">Canadian Dollar</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
        <button class="curr-opt-item ${current === 'EUR' ? 'active' : ''}" data-currency="EUR">
          <span class="curr-opt-flag">🇪🇺</span>
          <span class="curr-opt-details">
            <span class="curr-opt-top">EUROS <span class="curr-opt-symbol">€</span></span>
            <span class="curr-opt-name">Euro</span>
          </span>
          <span class="curr-opt-check">✓</span>
        </button>
      </div>
    `;
    document.body.appendChild(wrapper);
  }

  const fcBtn = wrapper.querySelector('#floating-currency-btn');
  if (fcBtn) {
    fcBtn.addEventListener('click', (e) => {
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
          <h3 class="stay-title" style="font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.5rem; margin-bottom: 12px; color: #000;">${property.title}</h3>
          <div style="color: #666; font-size: 0.8rem; display: flex; align-items: center; gap: 6px; font-weight: 500; text-transform: uppercase; margin-bottom: 16px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            ${property.location}
          </div>
          <p style="color: #666; font-size: 0.95rem; line-height: 1.5; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
            ${property.description || ''}
          </p>

          <a href="property-details.html?id=${property.id}" class="btn-text" style="font-weight: 600; font-size: 0.9rem; color: #234551; margin-top: auto; align-self: center; text-decoration: none;">View More</a>
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
