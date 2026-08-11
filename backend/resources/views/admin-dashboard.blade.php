<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | HYVE Real Estate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --color-danger: #e63946;
      --color-danger-hover: #c81d25;
      --color-success: #2a9d8f;
    }

    body {
      background-color: #f5f6f8;
      color: var(--color-text-main);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Navbar styling for Admin */
    .admin-navbar {
      height: 70px;
      background: #FFFFFF;
      box-shadow: var(--shadow-sm);
      display: flex;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
      border-bottom: 1px solid var(--color-border);
    }

    .admin-navbar .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      max-width: 1400px;
    }

    .admin-logo {
      font-family: var(--font-secondary);
      font-size: 1.8rem;
      font-weight: 700;
    }

    .admin-logo span {
      color: var(--color-accent);
    }

    .admin-nav-right {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    .admin-user {
      font-size: 0.9rem;
      color: var(--color-text-muted);
      font-weight: 500;
    }

    .btn-logout {
      background: transparent;
      border: 1px solid var(--color-border-dark);
      color: var(--color-text-main);
      padding: 8px 16px;
      font-family: var(--font-primary);
      font-size: 0.85rem;
      font-weight: 500;
      border-radius: var(--radius-sm);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background: var(--color-text-main);
      color: #FFFFFF;
      border-color: var(--color-text-main);
    }

    /* Main Dashboard Layout */
    .dashboard-container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 0 var(--spacing-md);
      flex: 1;
      width: 100%;
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 2rem;
    }

    @media (max-width: 1024px) {
      .dashboard-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Card Panels */
    .dashboard-card {
      background: #FFFFFF;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--color-border);
      padding: 2rem;
      display: flex;
      flex-direction: column;
    }

    .card-title {
      font-family: var(--font-secondary);
      font-size: 1.5rem;
      margin-bottom: 1.5rem;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid var(--color-accent);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .badge-count {
      background: var(--color-accent);
      color: #121212;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 2px 8px;
      border-radius: 20px;
      font-family: var(--font-primary);
    }

    /* Properties Table Listing */
    .table-responsive {
      overflow-x: auto;
    }

    .properties-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    .properties-table th, .properties-table td {
      padding: 12px 16px;
      border-bottom: 1px solid var(--color-border);
      font-size: 0.9rem;
    }

    .properties-table th {
      background-color: #fafbfc;
      font-weight: 600;
      color: var(--color-text-main);
    }

    .properties-table tr:hover {
      background-color: #fcfdfe;
    }

    .prop-row-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .prop-thumb {
      width: 60px;
      height: 45px;
      border-radius: var(--radius-sm);
      object-fit: cover;
      background: #eee;
    }

    .prop-title {
      font-weight: 600;
      color: var(--color-text-main);
    }

    .prop-loc {
      font-size: 0.75rem;
      color: var(--color-text-muted);
    }

    .badge-tag {
      font-size: 0.75rem;
      padding: 2px 6px;
      border-radius: var(--radius-sm);
      font-weight: 500;
    }

    .badge-type {
      background-color: rgba(212, 175, 55, 0.1);
      color: var(--color-accent-hover);
      border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .badge-purpose {
      background-color: #e8f5e9;
      color: #2e7d32;
    }

    .badge-purpose.rent {
      background-color: #e3f2fd;
      color: #1565c0;
    }

    .badge-featured {
      background-color: rgba(212, 175, 55, 0.2);
      color: var(--color-text-main);
      border: 1px solid var(--color-accent);
      font-weight: 600;
    }

    .btn-delete {
      background: transparent;
      border: 1px solid var(--color-danger);
      color: var(--color-danger);
      padding: 6px 12px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-size: 0.8rem;
      font-weight: 500;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .btn-delete:hover {
      background: var(--color-danger);
      color: #FFFFFF;
    }

    /* Form Fields Styling */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    @media (max-width: 480px) {
      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }
    }

    .form-group-admin {
      margin-bottom: 1.2rem;
      display: flex;
      flex-direction: column;
    }

    .form-group-admin.full-width {
      grid-column: 1 / -1;
    }

    .label-admin {
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 0.4rem;
      color: var(--color-text-main);
    }

    .input-admin, .select-admin, .textarea-admin {
      border: 1px solid var(--color-border-dark);
      border-radius: var(--radius-sm);
      padding: 10px 12px;
      font-family: var(--font-primary);
      font-size: 0.9rem;
      background-color: #FFFFFF;
      transition: all 0.3s ease;
      width: 100%;
    }

    .input-admin:focus, .select-admin:focus, .textarea-admin:focus {
      outline: none;
      border-color: var(--color-accent);
      box-shadow: 0 0 8px rgba(212, 175, 55, 0.15);
    }

    .textarea-admin {
      resize: vertical;
      min-height: 100px;
    }

    /* Image Preview Container */
    .preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .preview-thumb-wrapper {
      position: relative;
      width: 70px;
      height: 55px;
      border-radius: var(--radius-sm);
      overflow: hidden;
      border: 1px solid var(--color-border);
    }

    .preview-thumb {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Agent Custom Fields Section */
    .agent-custom-fields {
      display: none;
      background: #fafafa;
      padding: 1rem;
      border-radius: var(--radius-sm);
      border: 1px dashed var(--color-border-dark);
      margin-top: 10px;
      animation: fadeIn 0.4s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
      cursor: pointer;
      user-select: none;
    }

    .checkbox-container input {
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    .btn-submit-prop {
      background: var(--color-accent);
      color: #121212;
      border: none;
      border-radius: var(--radius-sm);
      padding: 12px;
      font-family: var(--font-primary);
      font-weight: 600;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 1.5rem;
    }

    .btn-submit-prop:hover {
      background: var(--color-accent-hover);
      box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }

    .btn-submit-prop:disabled {
      background: #cccccc;
      color: #888888;
      cursor: not-allowed;
    }

    .btn-submit-prop .spinner {
      width: 16px;
      height: 16px;
      border: 2px solid rgba(18, 18, 18, 0.1);
      border-top-color: #121212;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }

    /* Helper styling */
    .form-desc {
      font-size: 0.75rem;
      color: var(--color-text-muted);
      margin-top: 0.25rem;
    }

    .no-props-text {
      text-align: center;
      color: var(--color-text-muted);
      padding: 3rem 1rem;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>

  <!-- Admin Navbar -->
  <header class="admin-navbar">
    <div class="container">
      <a href="{{ url('/') }}" class="admin-logo">HYVE<span>.</span> Admin</a>
      
      <div class="admin-nav-right">
        <span class="admin-user">Welcome, Admin</span>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <button class="btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </button>
      </div>
    </div>
  </header>

  <!-- Dashboard Main Container -->
  <main class="dashboard-container">
    <div class="dashboard-grid">
      
      <!-- Left Column: Properties List -->
      <section class="dashboard-card">
        <div class="card-title">
          Properties List
          <span class="badge-count" id="properties-count">{{ count($properties) }} total</span>
        </div>

        <div class="table-responsive">
          @if(count($properties) > 0)
            <table class="properties-table">
              <thead>
                <tr>
                  <th>Property</th>
                  <th>Type / Purpose</th>
                  <th>Price</th>
                  <th>Specs</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="properties-table-body">
                @foreach($properties as $prop)
                  <tr id="prop-row-{{ $prop->id }}">
                    <td>
                      <div class="prop-row-info">
                        @if(is_array($prop->images) && count($prop->images) > 0)
                          <img class="prop-thumb" src="{{ asset($prop->images[0]) }}" alt="{{ $prop->title }}">
                        @else
                          <div class="prop-thumb" style="background:#eee;"></div>
                        @endif
                        <div>
                          <div class="prop-title">{{ $prop->title }}</div>
                          <div class="prop-loc">{{ $prop->location }}, {{ $prop->city }}</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge-tag badge-type">{{ $prop->type }}</span>
                      <span class="badge-tag badge-purpose {{ $prop->purpose }}">{{ ucfirst($prop->purpose) }}</span>
                      @if($prop->featured)
                        <span class="badge-tag badge-featured">Featured</span>
                      @endif
                    </td>
                    <td style="font-weight: 600;">
                      ${{ number_format($prop->price) }}
                    </td>
                    <td style="color: var(--color-text-muted); font-size: 0.85rem;">
                      {{ $prop->bedrooms }}b / {{ $prop->bathrooms }}b / {{ $prop->area }}sqft
                    </td>
                    <td>
                      <button class="btn-delete" onclick="deleteProperty({{ $prop->id }})">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Delete
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="no-props-text" id="no-props-placeholder">
              No properties in the database. Use the form to add one.
            </div>
          @endif
        </div>
      </section>

      <!-- Right Column: Add Property Form -->
      <section class="dashboard-card">
        <div class="card-title">Add Real Estate Property</div>
        
        <form id="add-property-form" enctype="multipart/form-data">
          
          <div class="form-group-admin">
            <label class="label-admin" for="title">Property Title *</label>
            <input class="input-admin" type="text" id="title" name="title" placeholder="e.g. Modern Luxury Villa" required>
          </div>

          <div class="form-row">
            <div class="form-group-admin">
              <label class="label-admin" for="location">Location Address *</label>
              <input class="input-admin" type="text" id="location" name="location" placeholder="e.g. 102 Ocean Drive" required>
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="city">City *</label>
              <select class="select-admin" id="city" name="city" required>
                <option value="" disabled selected>Select City</option>
                <option value="Los Angeles">Los Angeles</option>
                <option value="New York">New York</option>
                <option value="Miami">Miami</option>
                <option value="Austin">Austin</option>
                <option value="Chicago">Chicago</option>
                <option value="San Francisco">San Francisco</option>
                <option value="Seattle">Seattle</option>
                <option value="Boston">Boston</option>
                <option value="Phoenix">Phoenix</option>
                <option value="Aspen">Aspen</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group-admin">
              <label class="label-admin" for="type">Property Type *</label>
              <select class="select-admin" id="type" name="type" required>
                <option value="Villa">Villa</option>
                <option value="House">House</option>
                <option value="Apartment">Apartment</option>
                <option value="Condo">Condo</option>
                <option value="Commercial">Commercial</option>
              </select>
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="purpose">Purpose *</label>
              <select class="select-admin" id="purpose" name="purpose" required>
                <option value="buy">For Buy</option>
                <option value="rent">For Rent</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group-admin">
              <label class="label-admin" for="price">Price ($) *</label>
              <input class="input-admin" type="number" id="price" name="price" min="0" placeholder="e.g. 250000" required>
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="area">Area (sqft) *</label>
              <input class="input-admin" type="number" id="area" name="area" min="0" placeholder="e.g. 1500" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group-admin">
              <label class="label-admin" for="bedrooms">Bedrooms *</label>
              <input class="input-admin" type="number" id="bedrooms" name="bedrooms" min="0" placeholder="e.g. 3" required>
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="bathrooms">Bathrooms *</label>
              <input class="input-admin" type="number" step="0.5" id="bathrooms" name="bathrooms" min="0" placeholder="e.g. 2.5" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group-admin">
              <label class="label-admin" for="yearBuilt">Year Built *</label>
              <input class="input-admin" type="number" id="yearBuilt" name="yearBuilt" min="1800" max="2035" placeholder="e.g. 2021" required>
            </div>
            <div class="form-group-admin" style="justify-content: center;">
              <label class="checkbox-container">
                <input type="checkbox" id="featured" name="featured">
                <span style="font-size: 0.9rem; font-weight: 500;">Featured Property</span>
              </label>
            </div>
          </div>

          <div class="form-group-admin">
            <label class="label-admin" for="description">Description *</label>
            <textarea class="textarea-admin" id="description" name="description" placeholder="Provide full details of the property..." required></textarea>
          </div>

          <div class="form-group-admin">
            <label class="label-admin" for="features">Key Features (comma-separated)</label>
            <input class="input-admin" type="text" id="features" name="features" placeholder="Pool, Smart Home, Wine Cellar, Wine Room">
            <div class="form-desc">Separate items with commas. Empty values will be filtered out.</div>
          </div>

          <div class="form-group-admin">
            <label class="label-admin" for="images">Upload Images (select multiple)</label>
            <input class="input-admin" type="file" id="images" name="images[]" multiple accept="image/*">
            <div class="form-desc">First image will be used as the main display image. Defaults to placeholder if empty.</div>
            <div class="preview-container" id="images-preview"></div>
          </div>

          <!-- Agent Section -->
          <div class="form-group-admin" style="border-top: 1px solid var(--color-border); padding-top: 1.2rem; margin-top: 1rem;">
            <label class="label-admin" for="agent_selection">Assign Agent *</label>
            <select class="select-admin" id="agent_selection" name="agent_selection" required>
              <option value="sarah" selected>Sarah Jenkins (Senior Partner)</option>
              <option value="michael">Michael Chen (Urban Specialist)</option>
              <option value="emma">Emma Davis (Family Homes)</option>
              <option value="custom">-- Custom Agent --</option>
            </select>
          </div>

          <!-- Custom Agent Details (hidden by default) -->
          <div class="agent-custom-fields" id="agent-custom-section">
            <div class="form-group-admin">
              <label class="label-admin" for="agent_name">Agent Name *</label>
              <input class="input-admin" type="text" id="agent_name" name="agent_name" placeholder="e.g. John Doe">
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="agent_phone">Agent Phone Number *</label>
              <input class="input-admin" type="text" id="agent_phone" name="agent_phone" placeholder="e.g. +1 (555) 000-1111">
            </div>
            <div class="form-group-admin">
              <label class="label-admin" for="agent_image">Agent Photo</label>
              <input class="input-admin" type="file" id="agent_image" name="agent_image" accept="image/*">
              <div class="form-desc">Defaults to placeholder if empty.</div>
            </div>
          </div>

          <button type="submit" class="btn-submit-prop" id="btn-submit">
            <span class="spinner" id="btn-spinner"></span>
            <span id="btn-text">Add Property</span>
          </button>

        </form>
      </section>

    </div>
  </main>

  <div id="toast-container" class="toast-container"></div>

  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    // Handle conditional fields for Agent Selection
    const agentSelection = document.getElementById('agent_selection');
    const customAgentSection = document.getElementById('agent-custom-section');
    const customAgentName = document.getElementById('agent_name');
    const customAgentPhone = document.getElementById('agent_phone');

    agentSelection.addEventListener('change', (e) => {
      if (e.target.value === 'custom') {
        customAgentSection.style.display = 'block';
        customAgentName.required = true;
        customAgentPhone.required = true;
      } else {
        customAgentSection.style.display = 'none';
        customAgentName.required = false;
        customAgentPhone.required = false;
      }
    });

    // Image previews
    const imagesInput = document.getElementById('images');
    const previewContainer = document.getElementById('images-preview');

    imagesInput.addEventListener('change', () => {
      previewContainer.innerHTML = '';
      const files = imagesInput.files;
      if (files.length > 0) {
        Array.from(files).forEach(file => {
          if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
              const wrapper = document.createElement('div');
              wrapper.className = 'preview-thumb-wrapper';
              wrapper.innerHTML = `<img class="preview-thumb" src="${e.target.result}" alt="Preview">`;
              previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
          }
        });
      }
    });

    // Handle AJAX Form Submit for Adding Property
    const form = document.getElementById('add-property-form');
    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      btnSubmit.disabled = true;
      btnText.textContent = 'Saving Property...';
      btnSpinner.style.display = 'block';

      const formData = new FormData(form);
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const response = await fetch('{{ url("/admin/properties") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
          window.showToast(data.message || 'Property added successfully!');
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          window.showToast(data.message || 'Validation failed. Please check inputs.');
          btnSubmit.disabled = false;
          btnText.textContent = 'Add Property';
          btnSpinner.style.display = 'none';
        }
      } catch (error) {
        console.error('Error adding property:', error);
        window.showToast('An error occurred while saving.');
        btnSubmit.disabled = false;
        btnText.textContent = 'Add Property';
        btnSpinner.style.display = 'none';
      }
    });

    // Delete Property AJAX
    async function deleteProperty(id) {
      if (!confirm('Are you sure you want to delete this property? This action cannot be undone.')) {
        return;
      }

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const response = await fetch('{{ url("/admin/properties") }}/' + id, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });

        const data = await response.json();

        if (response.ok && data.success) {
          window.showToast(data.message || 'Property deleted successfully!');
          // Remove row from table
          const row = document.getElementById(`prop-row-${id}`);
          if (row) {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => {
              row.remove();
              
              // Update count
              const countEl = document.getElementById('properties-count');
              if (countEl) {
                const rows = document.querySelectorAll('#properties-table-body tr');
                countEl.textContent = `${rows.length} total`;
                
                if (rows.length === 0) {
                  window.location.reload(); // show empty state placeholder
                }
              }
            }, 500);
          }
        } else {
          window.showToast(data.message || 'Could not delete property.');
        }
      } catch (error) {
        console.error('Error deleting property:', error);
        window.showToast('An error occurred during deletion.');
      }
    }
  </script>
</body>
</html>
