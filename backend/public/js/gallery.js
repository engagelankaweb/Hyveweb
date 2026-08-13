// =========================================
// PROPERTY DETAILS & GALLERY LOGIC
// =========================================

document.addEventListener('DOMContentLoaded', () => {
  const detailsContainer = document.getElementById('property-details-container');
  if (detailsContainer) {
    loadPropertyDetails();
  }
});

function loadPropertyDetails() {
  const urlParams = new URLSearchParams(window.location.search);
  const id = parseInt(urlParams.get('id'));
  
  if (!id) {
    window.location.href = 'properties.html';
    return;
  }

  if (typeof propertiesData === 'undefined') {
    console.error('propertiesData is not loaded.');
    return;
  }

  const property = propertiesData.find(p => p.id === id);
  if (!property) {
    document.getElementById('property-details-container').innerHTML = `
      <div class="container text-center section">
        <h2>Property Not Found</h2>
        <a href="properties.html" class="btn btn-primary" style="margin-top: 1rem;">Back to Properties</a>
      </div>
    `;
    return;
  }

  renderProperty(property);
  initGallery();
}

function renderProperty(p) {
  const isShortTerm = p.rental_type === 'short_term';
  let priceLabel = '';
  let displayPrice = p.price;

  if (isShortTerm) {
    priceLabel = ' / night';
    displayPrice = p.nightly_rate || p.price;
  } else if (p.purpose === 'rent') {
    priceLabel = ' / mo';
  }

  const isFav = window.isFavorite ? (window.isFavorite(p.id) ? 'active' : '') : '';

  // Set Page Title
  document.title = `${p.title} | HYVE Real Estate`;

  // Render Gallery Images
  const mainImage = document.getElementById('main-gallery-image');
  const images = (p.images && p.images.length > 0) ? p.images : ['assets/images/luxury_villa_1786339560928.png'];
  if (mainImage) mainImage.src = images[0];
  
  const thumbnailContainer = document.getElementById('gallery-thumbnails');
  if (thumbnailContainer) {
    thumbnailContainer.innerHTML = images.map((img, index) => `
      <div class="thumb ${index === 0 ? 'active' : ''}" data-index="${index}">
        <img src="${img}" alt="Thumbnail ${index + 1}">
      </div>
    `).join('');
  }

  // Render Details
  const titleEl = document.getElementById('pd-title');
  if (titleEl) titleEl.textContent = p.title;

  const locEl = document.getElementById('pd-location');
  if (locEl) {
    locEl.innerHTML = `
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
      ${p.location}
    `;
  }

  const priceEl = document.getElementById('pd-price');
  if (priceEl) priceEl.textContent = formatPrice(displayPrice) + priceLabel;

  const typeEl = document.getElementById('pd-type');
  if (typeEl) typeEl.textContent = p.type;

  const statusBadge = document.getElementById('pd-status');
  if (statusBadge) {
    if (isShortTerm) {
      statusBadge.textContent = 'Vacation Stay';
      statusBadge.style.borderColor = '#86198f';
      statusBadge.style.color = '#86198f';
    } else {
      statusBadge.textContent = p.purpose === 'buy' ? 'For Sale' : 'For Rent';
    }
  }
  
  const favBtn = document.getElementById('pd-fav-btn');
  if (favBtn) {
    if (isFav) favBtn.classList.add('active');
    favBtn.onclick = (e) => toggleFavorite(p.id, favBtn);
  }

  // Key stats
  const bedsEl = document.getElementById('pd-beds');
  if (bedsEl) bedsEl.textContent = p.bedrooms;
  const bathsEl = document.getElementById('pd-baths');
  if (bathsEl) bathsEl.textContent = p.bathrooms;
  const areaEl = document.getElementById('pd-area');
  if (areaEl) areaEl.textContent = (isShortTerm && p.max_guests) ? `${p.max_guests} Guests` : p.area;
  const yearEl = document.getElementById('pd-year');
  if (yearEl) yearEl.textContent = p.yearBuilt;

  // Description & Features
  const descEl = document.getElementById('pd-description');
  if (descEl) descEl.textContent = p.description;

  const featuresList = p.features && Array.isArray(p.features) ? [...p.features] : [];
  if (isShortTerm) {
    if (p.min_stay) featuresList.push(`Min Stay: ${p.min_stay} nights`);
    if (p.check_in_time) featuresList.push(`Check-In: ${p.check_in_time}`);
    if (p.check_out_time) featuresList.push(`Check-Out: ${p.check_out_time}`);
  }

  const featEl = document.getElementById('pd-features');
  if (featEl) {
    featEl.innerHTML = featuresList.map(f => `
      <li style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
        ${f}
      </li>
    `).join('');
  }

  // External Links section
  let externalLinksHtml = '';
  if (p.external_url) {
    externalLinksHtml += `
      <a href="${p.external_url}" target="_blank" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px; margin-right: 8px;">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
        Experience 3D Virtual Tour
      </a>
    `;
  }
  if (p.external_booking_url) {
    externalLinksHtml += `
      <a href="${p.external_booking_url}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 12px;">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Book on Airbnb / Partner
      </a>
    `;
  }

  if (externalLinksHtml && descEl) {
    const linkBox = document.createElement('div');
    linkBox.style.marginTop = '16px';
    linkBox.innerHTML = externalLinksHtml;
    descEl.parentNode.insertBefore(linkBox, descEl.nextSibling);
  }

  // Agent Info
  if (p.agent) {
    const agentImg = document.getElementById('agent-image');
    if (agentImg) agentImg.src = p.agent.image || 'assets/images/agent_office_1786339595128.png';
    const agentName = document.getElementById('agent-name');
    if (agentName) agentName.textContent = p.agent.name || 'HYVE Real Estate';
    const agentPhone = document.getElementById('agent-phone');
    if (agentPhone) agentPhone.textContent = p.agent.phone || '+1 (555) 019-2831';
  }
}

function initGallery() {
  const mainImage = document.getElementById('main-gallery-image');
  const thumbnails = document.querySelectorAll('.thumb');
  const prevBtn = document.getElementById('gallery-prev');
  const nextBtn = document.getElementById('gallery-next');
  
  if (!mainImage || thumbnails.length === 0) return;

  let currentIndex = 0;

  const updateGallery = (index) => {
    thumbnails.forEach(t => t.classList.remove('active'));
    if (thumbnails[index]) {
      thumbnails[index].classList.add('active');
      mainImage.src = thumbnails[index].querySelector('img').src;
      currentIndex = index;
    }
  };

  thumbnails.forEach((thumb, index) => {
    thumb.addEventListener('click', () => updateGallery(index));
  });

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      let newIndex = currentIndex - 1;
      if (newIndex < 0) newIndex = thumbnails.length - 1;
      updateGallery(newIndex);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      let newIndex = currentIndex + 1;
      if (newIndex >= thumbnails.length) newIndex = 0;
      updateGallery(newIndex);
    });
  }
}
