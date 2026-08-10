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
  const priceLabel = p.purpose === 'rent' ? '/mo' : '';
  const isFav = window.isFavorite(p.id) ? 'active' : '';

  // Set Title
  document.title = `${p.title} | HYVE Real Estate`;

  // Render Gallery Images
  const mainImage = document.getElementById('main-gallery-image');
  mainImage.src = p.images[0];
  
  const thumbnailContainer = document.getElementById('gallery-thumbnails');
  thumbnailContainer.innerHTML = p.images.map((img, index) => `
    <div class="thumb ${index === 0 ? 'active' : ''}" data-index="${index}">
      <img src="${img}" alt="Thumbnail ${index + 1}">
    </div>
  `).join('');

  // Render Details
  document.getElementById('pd-title').textContent = p.title;
  document.getElementById('pd-location').innerHTML = `
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
    ${p.location}
  `;
  document.getElementById('pd-price').textContent = formatPrice(p.price) + priceLabel;
  document.getElementById('pd-type').textContent = p.type;
  
  const favBtn = document.getElementById('pd-fav-btn');
  if (isFav) favBtn.classList.add('active');
  favBtn.onclick = (e) => toggleFavorite(p.id, favBtn);

  // Key stats
  document.getElementById('pd-beds').textContent = p.bedrooms;
  document.getElementById('pd-baths').textContent = p.bathrooms;
  document.getElementById('pd-area').textContent = p.area;
  document.getElementById('pd-year').textContent = p.yearBuilt;

  // Description & Features
  document.getElementById('pd-description').textContent = p.description;
  document.getElementById('pd-features').innerHTML = p.features.map(f => `
    <li style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
      ${f}
    </li>
  `).join('');

  // Agent Info
  document.getElementById('agent-image').src = p.agent.image;
  document.getElementById('agent-name').textContent = p.agent.name;
  document.getElementById('agent-phone').textContent = p.agent.phone;
}

function initGallery() {
  const mainImage = document.getElementById('main-gallery-image');
  const thumbnails = document.querySelectorAll('.thumb');
  const prevBtn = document.getElementById('gallery-prev');
  const nextBtn = document.getElementById('gallery-next');
  const lightboxBtn = document.getElementById('gallery-expand');
  
  let currentIndex = 0;

  const updateGallery = (index) => {
    thumbnails.forEach(t => t.classList.remove('active'));
    thumbnails[index].classList.add('active');
    mainImage.src = thumbnails[index].querySelector('img').src;
    currentIndex = index;
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
