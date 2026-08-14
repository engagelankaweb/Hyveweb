// =========================================
// PROPERTY FILTERING & RENDERING
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  // Check if we are on a page that needs property rendering
  const propertiesGrid = document.getElementById('properties-grid');
  const featuredGrid = document.getElementById('featured-grid');
  
  if (featuredGrid) {
    renderFeaturedProperties(featuredGrid);
  }
  
  if (propertiesGrid) {
    initFilters(propertiesGrid);
  }
});

// Render a single property card
function createPropertyCard(property) {
  const isFav = window.isFavorite ? (window.isFavorite(property.id) ? 'active' : '') : '';
  const isShortTerm = property.rental_type === 'short_term';
  let priceLabel = '';
  let displayPrice = property.price;

  if (isShortTerm) {
    priceLabel = '/night';
    displayPrice = property.nightly_rate || property.price;
  } else if (property.purpose === 'rent') {
    priceLabel = '/mo';
  }
  
  const imgSrc = (property.images && property.images.length > 0) ? property.images[0] : 'assets/images/luxury_villa_1786339560928.png';

  return `
    <div class="property-card reveal-hidden" data-animation="reveal-slide-up">
      <div class="property-image-wrapper">
        ${property.featured ? '<span class="property-badge">Featured</span>' : ''}
        ${isShortTerm ? '<span class="property-badge" style="left: auto; right: 12px; background: #86198f;">Vacation Stay</span>' : ''}
        <span class="property-type">${property.type}</span>
        <button class="fav-btn ${isFav}" onclick="event.preventDefault(); toggleFavorite(${property.id}, this)">
          <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        </button>
        <a href="property-details.html?id=${property.id}">
          <img src="${imgSrc}" alt="${property.title}" loading="lazy">
        </a>
      </div>
      <div class="property-content">
        <div class="property-price">${formatPrice(displayPrice)}${priceLabel}</div>
        <h3 class="property-title"><a href="property-details.html?id=${property.id}">${property.title}</a></h3>
        <div class="property-location">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          ${property.location}
        </div>
        <div class="property-description" style="margin-top: 0.5rem; font-size: 0.9rem; color: var(--color-text-light, #666); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
          ${property.description || ''}
        </div>
        <div class="property-features">
          <div class="feature">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            ${property.bedrooms} Beds
          </div>
          <div class="feature">
            <svg viewBox="0 0 24 24"><path d="M2 12h20M12 2v20"></path></svg>
            ${property.bathrooms} Baths
          </div>
          <div class="feature">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>
            ${isShortTerm && property.max_guests ? property.max_guests + ' Guests' : property.area + ' sqft'}
          </div>
        </div>
        <div class="property-footer" style="display: flex; gap: 8px;">
          <a href="property-details.html?id=${property.id}" class="btn btn-outline" style="flex: 1; text-align: center;">View Property</a>
          ${property.external_url ? `
            <a href="${property.external_url}" target="_blank" class="btn btn-secondary" style="padding: 8px 12px;" title="Virtual Tour / External Listing">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
          ` : ''}
        </div>
      </div>
    </div>
  `;
}

// Render Featured Properties on Homepage
function renderFeaturedProperties(container) {
  if (typeof propertiesData === 'undefined') return;
  const featured = propertiesData.filter(p => p.featured).slice(0, 6);
  container.innerHTML = featured.map(createPropertyCard).join('');
  if (window.initScrollReveals) initScrollReveals();
}

// Filter Logic for Properties Page
function initFilters(container) {
  const form = document.getElementById('filter-form');
  const countEl = document.getElementById('results-count');
  const sortSelect = document.getElementById('sort-select');
  const resetBtn = document.getElementById('reset-filters');
  
  if (!form || !container || typeof propertiesData === 'undefined') return;

  let currentData = [...propertiesData];

  const render = () => {
    container.innerHTML = '';
    
    if (currentData.length === 0) {
      container.innerHTML = `
        <div class="no-results" style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem;">
          <h3>No properties found</h3>
          <p>Try adjusting your filters to find what you're looking for.</p>
          <button class="btn btn-primary" onclick="document.getElementById('reset-filters').click()" style="margin-top: 1rem;">Reset Filters</button>
        </div>
      `;
      if (countEl) countEl.textContent = '0';
      return;
    }

    container.innerHTML = currentData.map(createPropertyCard).join('');
    if (countEl) countEl.textContent = currentData.length;
    if (window.initScrollReveals) initScrollReveals();
  };

  const applyFilters = () => {
    const purpose = document.getElementById('filter-purpose').value;
    const type = document.getElementById('filter-type').value;
    const minPrice = parseInt(document.getElementById('filter-min-price').value) || 0;
    const maxPrice = parseInt(document.getElementById('filter-max-price').value) || Infinity;
    const beds = document.getElementById('filter-beds').value;

    currentData = propertiesData.filter(p => {
      let match = true;
      if (purpose) {
        if (purpose === 'short_term') {
          if (p.rental_type !== 'short_term') match = false;
        } else if (p.purpose !== purpose) {
          match = false;
        }
      }
      if (type && p.type !== type) match = false;
      const comparePrice = (p.rental_type === 'short_term' && p.nightly_rate) ? p.nightly_rate : p.price;
      if (comparePrice < minPrice || comparePrice > maxPrice) match = false;
      if (beds) {
        if (beds === '4+' && p.bedrooms < 4) match = false;
        else if (beds !== '4+' && p.bedrooms != beds) match = false;
      }
      return match;
    });

    applySort();
  };

  const applySort = () => {
    const sortVal = sortSelect ? sortSelect.value : 'default';
    
    if (sortVal === 'price-low') {
      currentData.sort((a, b) => a.price - b.price);
    } else if (sortVal === 'price-high') {
      currentData.sort((a, b) => b.price - a.price);
    } else if (sortVal === 'newest') {
      currentData.sort((a, b) => b.yearBuilt - a.yearBuilt);
    }

    render();
  };

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    applyFilters();
  });
  
  form.addEventListener('change', applyFilters);
  if (sortSelect) sortSelect.addEventListener('change', applySort);
  
  if (resetBtn) {
    resetBtn.addEventListener('click', (e) => {
      e.preventDefault();
      form.reset();
      currentData = [...propertiesData];
      if (sortSelect) sortSelect.value = 'default';
      render();
    });
  }

  // Check URL params for initial search
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.toString()) {
    ['purpose', 'location', 'type', 'beds'].forEach(param => {
      const val = urlParams.get(param);
      if (val) {
        const el = document.getElementById(`filter-${param}`);
        if (el) el.value = val;
      }
    });
    applyFilters();
  } else {
    render();
  }
}
