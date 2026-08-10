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
  const isFav = window.isFavorite(property.id) ? 'active' : '';
  const priceLabel = property.purpose === 'rent' ? '/mo' : '';
  
  return `
    <div class="property-card reveal-hidden" data-animation="reveal-slide-up">
      <div class="property-image-wrapper">
        ${property.featured ? '<span class="property-badge">Featured</span>' : ''}
        <span class="property-type">${property.type}</span>
        <button class="fav-btn ${isFav}" onclick="event.preventDefault(); toggleFavorite(${property.id}, this)">
          <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        </button>
        <a href="property-details.html?id=${property.id}">
          <img src="${property.images[0]}" alt="${property.title}" loading="lazy">
        </a>
      </div>
      <div class="property-content">
        <div class="property-price">${formatPrice(property.price)}${priceLabel}</div>
        <h3 class="property-title"><a href="property-details.html?id=${property.id}">${property.title}</a></h3>
        <div class="property-location">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          ${property.location}
        </div>
        <div class="property-features">
          <div class="feature">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            ${property.bedrooms} Beds
          </div>
          <div class="feature">
            <svg viewBox="0 0 24 24"><path d="M2 12h20M12 2v20"></path></svg> <!-- Placeholder icon -->
            ${property.bathrooms} Baths
          </div>
          <div class="feature">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>
            ${property.area} sqft
          </div>
        </div>
        <div class="property-footer">
          <a href="property-details.html?id=${property.id}" class="btn btn-outline" style="width: 100%; text-align: center;">View Property</a>
        </div>
      </div>
    </div>
  `;
}

// Render Featured Properties on Homepage
function renderFeaturedProperties(container) {
  const featured = propertiesData.filter(p => p.featured).slice(0, 6);
  container.innerHTML = featured.map(createPropertyCard).join('');
  // Re-init scroll reveals for new elements
  if (window.initScrollReveals) initScrollReveals();
}

// Filter Logic for Properties Page
function initFilters(container) {
  const form = document.getElementById('filter-form');
  const countEl = document.getElementById('results-count');
  const sortSelect = document.getElementById('sort-select');
  const resetBtn = document.getElementById('reset-filters');
  
  if (!form || !container) return;

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
      if (purpose && p.purpose !== purpose) match = false;
      if (type && p.type !== type) match = false;
      if (p.price < minPrice || p.price > maxPrice) match = false;
      if (beds) {
        if (beds === '4+' && p.bedrooms < 4) match = false;
        else if (beds !== '4+' && p.bedrooms != beds) match = false;
      }
      return match;
    });

    applySort(); // Sort after filtering
  };

  const applySort = () => {
    const sortVal = sortSelect.value;
    
    if (sortVal === 'price-low') {
      currentData.sort((a, b) => a.price - b.price);
    } else if (sortVal === 'price-high') {
      currentData.sort((a, b) => b.price - a.price);
    } else if (sortVal === 'newest') {
      currentData.sort((a, b) => b.yearBuilt - a.yearBuilt);
    } // default is basically original order (no sort needed)

    render();
  };

  // Event Listeners
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    applyFilters();
  });
  
  form.addEventListener('change', applyFilters);
  sortSelect.addEventListener('change', applySort);
  
  resetBtn.addEventListener('click', (e) => {
    e.preventDefault();
    form.reset();
    currentData = [...propertiesData];
    sortSelect.value = 'default';
    render();
  });

  // Check URL params for initial search (from homepage)
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
    // Initial render
    render();
  }
}
