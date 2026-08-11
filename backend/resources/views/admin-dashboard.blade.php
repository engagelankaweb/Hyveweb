<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | HYVE Real Estate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <style>
    :root {
      --sidebar-width: 260px;
      --color-primary-dark: #12121c;
      --color-sidebar-bg: #1e1e2d;
      --color-sidebar-active: rgba(212, 175, 55, 0.15);
      --color-danger: #ef4444;
      --color-danger-hover: #dc2626;
      --color-success: #10b981;
      --color-bg-main: #f8fafc;
      --color-card-bg: #ffffff;
      --color-border-light: #f1f5f9;
      --shadow-premium: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    body {
      background-color: var(--color-bg-main);
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      font-family: 'Inter', sans-serif;
    }

    /* Sidebar Navigation */
    .sidebar {
      width: var(--sidebar-width);
      background-color: var(--color-sidebar-bg);
      color: #94a3b8;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 101;
      display: flex;
      flex-direction: column;
      box-shadow: 4px 0 20px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    .sidebar-brand {
      padding: 24px;
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: #ffffff;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar-brand span {
      color: var(--color-accent);
    }

    .sidebar-menu {
      padding: 24px 16px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      flex: 1;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: var(--radius-sm);
      color: #94a3b8;
      font-weight: 500;
      font-size: 0.95rem;
      cursor: pointer;
      transition: all 0.3s ease;
      background: transparent;
      border: none;
      width: 100%;
      text-align: left;
    }

    .menu-item svg {
      width: 20px;
      height: 20px;
      stroke-width: 2;
      transition: transform 0.3s ease;
    }

    .menu-item:hover, .menu-item.active {
      color: #ffffff;
      background-color: var(--color-sidebar-active);
    }

    .menu-item.active {
      color: var(--color-accent);
      border-left: 3px solid var(--color-accent);
    }

    .menu-item:hover svg {
      transform: translateX(3px);
    }

    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.05);
    }

    .btn-sidebar-logout {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2);
      color: #f87171;
      padding: 10px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.3s ease;
    }

    .btn-sidebar-logout:hover {
      background: var(--color-danger);
      color: #ffffff;
      border-color: var(--color-danger);
    }

    /* Main Content Wrapper */
    .main-content {
      margin-left: var(--sidebar-width);
      flex: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 2rem;
      transition: all 0.3s ease;
    }

    /* Dashboard Header */
    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      background: var(--color-card-bg);
      padding: 1.5rem 2rem;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-premium);
      border: 1px solid var(--color-border-light);
    }

    .header-title h1 {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 4px;
      color: #0f172a;
      font-family: var(--font-secondary);
    }

    .header-title p {
      font-size: 0.9rem;
      color: #64748b;
      margin: 0;
    }

    .header-user-badge {
      display: flex;
      align-items: center;
      gap: 12px;
      background: #f8fafc;
      padding: 8px 16px;
      border-radius: 40px;
      border: 1px solid #e2e8f0;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--color-accent);
      color: #121212;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.9rem;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    @media (max-width: 1024px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 640px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }

    .stat-card {
      background: var(--color-card-bg);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-premium);
      border: 1px solid var(--color-border-light);
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.2rem;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
      border-color: rgba(212, 175, 55, 0.3);
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon-total { background: rgba(212,175,55,0.1); color: var(--color-accent-hover); }
    .icon-sale { background: rgba(16,185,129,0.1); color: var(--color-success); }
    .icon-rent { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .icon-featured { background: rgba(249,115,22,0.1); color: #f97316; }

    .stat-value {
      font-size: 1.8rem;
      font-weight: 700;
      color: #0f172a;
      line-height: 1;
      margin-bottom: 4px;
    }

    .stat-label {
      font-size: 0.85rem;
      color: #64748b;
      font-weight: 500;
    }

    /* Views Panels toggles */
    .view-panel {
      display: none;
      animation: viewFadeIn 0.5s ease forwards;
    }

    .view-panel.active-view {
      display: block;
    }

    @keyframes viewFadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Card Panels */
    .dashboard-panel-card {
      background: var(--color-card-bg);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-premium);
      border: 1px solid var(--color-border-light);
      padding: 2.2rem;
      margin-bottom: 2rem;
    }

    .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #f1f5f9;
    }

    .panel-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
    }

    /* Table Filter Bar controls */
    .table-filter-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1.5rem;
      background: #f8fafc;
      padding: 1rem;
      border-radius: var(--radius-sm);
      border: 1px solid #e2e8f0;
    }

    .search-wrapper {
      flex: 1;
      min-width: 250px;
      position: relative;
    }

    .search-input {
      width: 100%;
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 10px 12px 10px 40px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
    }

    .search-icon {
      position: absolute;
      left: 14px;
      top: 12px;
      color: #94a3b8;
    }

    .filter-select {
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 10px 16px;
      font-size: 0.9rem;
      background: #FFFFFF;
      min-width: 150px;
      cursor: pointer;
    }

    .btn-add-action {
      background: var(--color-accent);
      color: #121212;
      padding: 10px 18px;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.9rem;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.3s ease;
    }

    .btn-add-action:hover {
      background: var(--color-accent-hover);
      box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }

    /* Table Styling */
    .properties-table {
      width: 100%;
      border-collapse: collapse;
    }

    .properties-table th {
      background: #f8fafc;
      color: #475569;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 14px 20px;
      border-bottom: 2px solid #edf2f7;
    }

    .properties-table td {
      padding: 16px 20px;
      border-bottom: 1px solid #edf2f7;
      vertical-align: middle;
      font-size: 0.92rem;
    }

    .properties-table tr:hover {
      background-color: #fcfdfe;
    }

    .prop-info-cell {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .prop-thumbnail {
      width: 80px;
      height: 60px;
      border-radius: var(--radius-sm);
      object-fit: cover;
      border: 1px solid #e2e8f0;
      background: #edf2f7;
    }

    .prop-name {
      font-weight: 600;
      color: #0f172a;
      font-size: 0.98rem;
      margin-bottom: 4px;
    }

    .prop-address {
      font-size: 0.8rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .badge {
      font-size: 0.75rem;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 4px;
      display: inline-block;
    }

    .badge-villa { background: rgba(212, 175, 55, 0.1); color: var(--color-accent-hover); }
    .badge-house { background: rgba(16, 185, 129, 0.1); color: var(--color-success); }
    .badge-apt { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .badge-condo { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .badge-comm { background: rgba(100, 116, 139, 0.1); color: #64748b; }

    .badge-purpose-buy { background: #e0f2fe; color: #0369a1; }
    .badge-purpose-rent { background: #fef3c7; color: #b45309; }
    
    .badge-feat {
      background: linear-gradient(135deg, var(--color-accent) 0%, #b89010 100%);
      color: #121212;
      box-shadow: 0 2px 6px rgba(212,175,55,0.2);
    }

    .btn-table-delete {
      background: rgba(239, 68, 68, 0.08);
      border: 1px solid rgba(239, 68, 68, 0.15);
      color: var(--color-danger);
      padding: 8px 12px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-size: 0.82rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-table-delete:hover {
      background: var(--color-danger);
      color: #ffffff;
    }

    /* Tab Layout for Add Property Form */
    .form-tabs {
      display: flex;
      gap: 8px;
      margin-bottom: 2rem;
      border-bottom: 1px solid #e2e8f0;
      padding-bottom: 8px;
    }

    .form-tab-btn {
      background: transparent;
      border: none;
      padding: 10px 20px;
      font-size: 0.95rem;
      font-weight: 600;
      color: #64748b;
      cursor: pointer;
      border-radius: var(--radius-sm);
      transition: all 0.3s ease;
    }

    .form-tab-btn.active {
      color: var(--color-accent-hover);
      background: rgba(212, 175, 55, 0.08);
    }

    .form-tab-content {
      display: none;
    }

    .form-tab-content.active {
      display: block;
    }

    /* Modern Drag-and-Drop Image Box */
    .upload-drag-zone {
      border: 2px dashed #cbd5e1;
      border-radius: var(--radius-md);
      padding: 2.5rem;
      text-align: center;
      background: #f8fafc;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 8px;
    }

    .upload-drag-zone:hover, .upload-drag-zone.dragover {
      border-color: var(--color-accent);
      background: rgba(212, 175, 55, 0.02);
    }

    .upload-drag-zone svg {
      color: var(--color-accent);
      margin-bottom: 12px;
    }

    .upload-drag-zone p {
      font-size: 0.95rem;
      color: #475569;
      margin-bottom: 4px;
    }

    .upload-drag-zone span {
      color: var(--color-accent-hover);
      font-weight: 600;
      text-decoration: underline;
    }

    /* Custom form groups styling */
    .form-grid-layout {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    @media (max-width: 640px) {
      .form-grid-layout {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
    }

    .form-group-custom {
      margin-bottom: 1.5rem;
      display: flex;
      flex-direction: column;
    }

    .form-group-custom.full-span {
      grid-column: 1 / -1;
    }

    .label-custom {
      font-size: 0.88rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 6px;
    }

    .input-custom, .select-custom, .textarea-custom {
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 12px 14px;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      background: #FFFFFF;
      transition: all 0.3s ease;
      color: #1e293b;
    }

    .input-custom:focus, .select-custom:focus, .textarea-custom:focus {
      outline: none;
      border-color: var(--color-accent);
      box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .textarea-custom {
      min-height: 120px;
      resize: vertical;
    }

    /* Checked status card */
    .toggle-container-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: var(--radius-sm);
      padding: 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
    }

    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 44px;
      height: 24px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #cbd5e1;
      transition: .4s;
      border-radius: 24px;
    }

    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    .toggle-switch input:checked + .toggle-slider {
      background-color: var(--color-accent-hover);
    }

    .toggle-switch input:checked + .toggle-slider:before {
      transform: translateX(20px);
    }

    /* Agent custom section styling */
    .agent-card-selector {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      padding: 1.5rem;
      border-radius: var(--radius-sm);
      margin-top: 1rem;
    }

    .preview-thumb-box {
      position: relative;
      width: 90px;
      height: 70px;
      border-radius: var(--radius-sm);
      overflow: hidden;
      border: 1px solid #e2e8f0;
    }

    .preview-thumb-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .preview-remove-btn {
      position: absolute;
      top: 2px;
      right: 2px;
      background: rgba(239, 68, 68, 0.9);
      color: #ffffff;
      border: none;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-form-action-group {
      display: flex;
      justify-content: space-between;
      margin-top: 2rem;
      border-top: 1px solid #e2e8f0;
      padding-top: 1.5rem;
    }

    .btn-secondary-custom {
      background: #f1f5f9;
      color: #475569;
      border: 1px solid #e2e8f0;
      border-radius: var(--radius-sm);
      padding: 12px 24px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-secondary-custom:hover {
      background: #e2e8f0;
    }
  </style>
</head>
<body>

  <!-- Sidebar Navigation -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      HYVE<span>.</span> Admin
    </div>
    
    <nav class="sidebar-menu">
      <button class="menu-item active" id="menu-btn-list" onclick="switchView('list')">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
        All Properties
      </button>
      <button class="menu-item" id="menu-btn-add" onclick="switchView('add')">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Add Property
      </button>
    </nav>

    <div class="sidebar-footer">
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      <button class="btn-sidebar-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
        Logout
      </button>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <main class="main-content">
    
    <!-- Top Header -->
    <header class="dashboard-header">
      <div class="header-title">
        <h1 id="page-title-text">All Properties</h1>
        <p id="page-subtitle-text">Manage and search your real estate catalog</p>
      </div>
      <div class="header-user-badge">
        <div class="user-avatar">A</div>
        <span style="font-weight: 600; font-size: 0.9rem;">Administrator</span>
      </div>
    </header>

    <!-- Metrics Stats Row -->
    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-total">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-total">{{ count($properties) }}</div>
          <div class="stat-label">Total Listings</div>
        </div>
      </div>
      
      <div class="stat-card">
        <div class="stat-icon icon-sale">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-sale">{{ $properties->where('purpose', 'buy')->count() }}</div>
          <div class="stat-label">For Sale</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-rent">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m-2 4a2 2 0 012 2m-2-6a3 3 0 11-6 0 3 3 0 016 0zm-6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-rent">{{ $properties->where('purpose', 'rent')->count() }}</div>
          <div class="stat-label">Rentals</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-featured">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.961 0 1.36 1.246.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.564-.386-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-featured">{{ $properties->where('featured', true)->count() }}</div>
          <div class="stat-label">Featured</div>
        </div>
      </div>
    </section>

    <!-- PANEL VIEW 1: Properties List View -->
    <section class="view-panel active-view" id="view-panel-list">
      <div class="dashboard-panel-card">
        <div class="panel-header">
          <h2 class="panel-title">Properties Directory</h2>
          <button class="btn-add-action" onclick="switchView('add')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Property
          </button>
        </div>

        <!-- Filter Controls -->
        <div class="table-filter-bar">
          <div class="search-wrapper">
            <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="table-search" class="search-input" placeholder="Search by title, location, city..." oninput="filterTable()">
          </div>
          
          <select id="filter-city-select" class="filter-select" onchange="filterTable()">
            <option value="">All Cities</option>
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

          <select id="filter-type-select" class="filter-select" onchange="filterTable()">
            <option value="">All Types</option>
            <option value="Villa">Villa</option>
            <option value="House">House</option>
            <option value="Apartment">Apartment</option>
            <option value="Condo">Condo</option>
            <option value="Commercial">Commercial</option>
          </select>
        </div>

        <!-- Table Listing -->
        <div style="overflow-x: auto;">
          @if(count($properties) > 0)
            <table class="properties-table">
              <thead>
                <tr>
                  <th>Property Info</th>
                  <th>Type & Purpose</th>
                  <th>Price</th>
                  <th>Specs</th>
                  <th style="text-align: right;">Action</th>
                </tr>
              </thead>
              <tbody id="properties-table-body">
                @foreach($properties as $prop)
                  <tr id="prop-row-{{ $prop->id }}" data-city="{{ $prop->city }}" data-type="{{ $prop->type }}">
                    <td>
                      <div class="prop-info-cell">
                        @if(is_array($prop->images) && count($prop->images) > 0)
                          <img class="prop-thumbnail" src="{{ asset($prop->images[0]) }}" alt="{{ $prop->title }}">
                        @else
                          <div class="prop-thumbnail"></div>
                        @endif
                        <div>
                          <div class="prop-name">{{ $prop->title }}</div>
                          <div class="prop-address">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ $prop->location }}, {{ $prop->city }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-{{ strtolower(substr($prop->type, 0, 5)) }}">{{ $prop->type }}</span>
                      <span class="badge badge-purpose-{{ $prop->purpose }}">{{ $prop->purpose === 'buy' ? 'For Sale' : 'For Rent' }}</span>
                      @if($prop->featured)
                        <span class="badge badge-feat">Featured</span>
                      @endif
                    </td>
                    <td style="font-weight: 700; color: #0f172a;">
                      ${{ number_format($prop->price) }}{{ $prop->purpose === 'rent' ? '/mo' : '' }}
                    </td>
                    <td style="color: #64748b; font-size: 0.85rem; font-weight: 500;">
                      <span style="color:#0f172a; font-weight:600;">{{ $prop->bedrooms }}</span> Bed &nbsp;•&nbsp; 
                      <span style="color:#0f172a; font-weight:600;">{{ $prop->bathrooms }}</span> Bath &nbsp;•&nbsp; 
                      <span style="color:#0f172a; font-weight:600;">{{ $prop->area }}</span> sqft
                    </td>
                    <td style="text-align: right;">
                      <button class="btn-table-delete" onclick="deleteProperty({{ $prop->id }})">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Remove
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div style="text-align: center; color: #64748b; padding: 4rem 1rem;">
              <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="48" height="48" style="margin-bottom: 12px; color: #cbd5e1;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
              <h3>No properties in catalog</h3>
              <p>Add your first real estate listing to display it in the frontend directory.</p>
              <button class="btn-add-action" style="margin: 1.5rem auto 0;" onclick="switchView('add')">Add Property</button>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- PANEL VIEW 2: Add Property View -->
    <section class="view-panel" id="view-panel-add">
      <div class="dashboard-panel-card" style="max-width: 900px; margin: 0 auto 2rem;">
        <div class="panel-header">
          <h2 class="panel-title">Add Property Listing</h2>
          <button class="btn-secondary-custom" style="padding: 6px 12px; font-size: 0.8rem;" onclick="switchView('list')">Back to Directory</button>
        </div>

        <form id="add-property-form" enctype="multipart/form-data">
          
          <!-- Tab Links -->
          <div class="form-tabs">
            <button type="button" class="form-tab-btn active" id="tab-btn-basic" onclick="switchFormTab('basic')">1. Basic Info</button>
            <button type="button" class="form-tab-btn" id="tab-btn-specs" onclick="switchFormTab('specs')">2. Specs & Location</button>
            <button type="button" class="form-tab-btn" id="tab-btn-media" onclick="switchFormTab('media')">3. Media & Agent</button>
          </div>

          <!-- Tab Content 1: Basic Info -->
          <div class="form-tab-content active" id="tab-content-basic">
            <div class="form-group-custom">
              <label class="label-custom" for="title">Listing Title *</label>
              <input type="text" id="title" name="title" class="input-custom" placeholder="e.g. Modern Luxury Beachfront Villa" required>
            </div>

            <div class="form-grid-layout">
              <div class="form-group-custom">
                <label class="label-custom" for="type">Property Category Type *</label>
                <select id="type" name="type" class="select-custom" required>
                  <option value="Villa">Villa</option>
                  <option value="House">House</option>
                  <option value="Apartment">Apartment</option>
                  <option value="Condo">Condo</option>
                  <option value="Commercial">Commercial</option>
                </select>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="purpose">Listing Option *</label>
                <select id="purpose" name="purpose" class="select-custom" required>
                  <option value="buy">For Sale (Buy)</option>
                  <option value="rent">For Rent</option>
                </select>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="price">Price ($ USD) *</label>
                <input type="number" id="price" name="price" class="input-custom" min="0" placeholder="e.g. 1500000" required>
              </div>

              <div class="form-group-custom" style="justify-content: center;">
                <div class="toggle-container-card" onclick="toggleFeaturedCheck()">
                  <div>
                    <div style="font-weight: 600; font-size: 0.9rem; color: #0f172a;">Featured Status</div>
                    <div style="font-size: 0.75rem; color: #64748b;">Highlight on the home page listings</div>
                  </div>
                  <label class="toggle-switch" onclick="event.stopPropagation()">
                    <input type="checkbox" id="featured" name="featured">
                    <span class="toggle-slider"></span>
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="description">Full Description *</label>
              <textarea id="description" name="description" class="textarea-custom" placeholder="Write a detailed, premium narrative of the property features, build details, and layout..." required></textarea>
            </div>

            <div class="btn-form-action-group">
              <div></div>
              <button type="button" class="btn-add-action" onclick="switchFormTab('specs')">Continue to Specs →</button>
            </div>
          </div>

          <!-- Tab Content 2: Specs & Location -->
          <div class="form-tab-content" id="tab-content-specs">
            <div class="form-grid-layout">
              <div class="form-group-custom">
                <label class="label-custom" for="bedrooms">Bedrooms *</label>
                <input type="number" id="bedrooms" name="bedrooms" class="input-custom" min="0" placeholder="e.g. 4" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="bathrooms">Bathrooms *</label>
                <input type="number" step="0.5" id="bathrooms" name="bathrooms" class="input-custom" min="0" placeholder="e.g. 3.5" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="area">Property Size (sqft) *</label>
                <input type="number" id="area" name="area" class="input-custom" min="0" placeholder="e.g. 3600" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="yearBuilt">Year Built *</label>
                <input type="number" id="yearBuilt" name="yearBuilt" class="input-custom" min="1800" max="2035" placeholder="e.g. 2021" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="location">Address Street *</label>
                <input type="text" id="location" name="location" class="input-custom" placeholder="e.g. 102 Beachfront Drive" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="city">Select City *</label>
                <select id="city" name="city" class="select-custom" required>
                  <option value="" disabled selected>Select Location City</option>
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

            <div class="form-group-custom">
              <label class="label-custom" for="features">Key Highlights Features (comma-separated)</label>
              <input type="text" id="features" name="features" class="input-custom" placeholder="e.g. Infinity Pool, Smart Home, Guest House, Wine Cellar">
              <div class="form-desc">Type amenities separated by commas.</div>
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchFormTab('basic')">← Back to Basic</button>
              <button type="button" class="btn-add-action" onclick="switchFormTab('media')">Continue to Media & Agent →</button>
            </div>
          </div>

          <!-- Tab Content 3: Media & Agent -->
          <div class="form-tab-content" id="tab-content-media">
            
            <div class="form-group-custom">
              <label class="label-custom">Upload Property Media</label>
              <!-- Drag zone -->
              <div class="upload-drag-zone" id="drag-drop-zone" onclick="document.getElementById('images').click()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="40" height="40" style="margin: 0 auto 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <p>Drag and drop image files here, or <span>click to browse</span></p>
                <span style="font-size: 0.8rem; color: #94a3b8; text-decoration: none;">Supports JPEG, PNG, WEBP, GIF (Max 5MB per file)</span>
              </div>
              <input type="file" id="images" name="images[]" multiple accept="image/*" style="display: none;">
              
              <!-- Local Previews Grid -->
              <div class="preview-container" id="images-preview" style="margin-top: 1.5rem;"></div>
            </div>

            <!-- Agent selector -->
            <div class="form-group-custom" style="border-top: 1px solid #edf2f7; padding-top: 1.5rem; margin-top: 1.5rem;">
              <label class="label-custom" for="agent_selection">Assign Listing Agent *</label>
              <select id="agent_selection" name="agent_selection" class="select-custom" required>
                <option value="sarah" selected>Sarah Jenkins (Senior Partner)</option>
                <option value="michael">Michael Chen (Urban Specialist)</option>
                <option value="emma">Emma Davis (Family Homes)</option>
                <option value="custom">-- Create Custom Agent --</option>
              </select>
            </div>

            <!-- Custom agent detailed panel -->
            <div class="agent-card-selector" id="agent-custom-section" style="display: none;">
              <div style="font-weight: 700; font-size: 0.95rem; color:#0f172a; margin-bottom: 1rem; border-bottom: 1px dashed #e2e8f0; padding-bottom: 6px;">New Agent Details</div>
              
              <div class="form-grid-layout">
                <div class="form-group-custom">
                  <label class="label-custom" for="agent_name">Agent Name *</label>
                  <input type="text" id="agent_name" name="agent_name" class="input-custom" placeholder="e.g. Jessica Thompson">
                </div>

                <div class="form-group-custom">
                  <label class="label-custom" for="agent_phone">Contact Number *</label>
                  <input type="text" id="agent_phone" name="agent_phone" class="input-custom" placeholder="e.g. +1 (555) 777-8888">
                </div>
              </div>

              <div class="form-group-custom" style="margin-bottom: 0;">
                <label class="label-custom" for="agent_image">Agent Headshot Photo</label>
                <input type="file" id="agent_image" name="agent_image" class="input-custom" accept="image/*">
                <div class="form-desc">Defaults to placeholder office headshot if left blank.</div>
              </div>
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchFormTab('specs')">← Back to Specs</button>
              <button type="submit" class="btn-add-action" id="btn-submit" style="padding: 12px 30px;">
                <span class="spinner" id="btn-spinner"></span>
                <span id="btn-text">Publish Listing</span>
              </button>
            </div>

          </div>

        </form>
      </div>
    </section>

  </main>

  <div id="toast-container" class="toast-container"></div>

  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    // Tab switching in form
    function switchFormTab(tabName) {
      document.querySelectorAll('.form-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.form-tab-content').forEach(content => content.classList.remove('active'));

      if (tabName === 'basic') {
        document.getElementById('tab-btn-basic').classList.add('active');
        document.getElementById('tab-content-basic').classList.add('active');
      } else if (tabName === 'specs') {
        // Validate basic info required inputs first
        if (!document.getElementById('title').reportValidity()) return;
        if (!document.getElementById('price').reportValidity()) return;
        
        document.getElementById('tab-btn-specs').classList.add('active');
        document.getElementById('tab-content-specs').classList.add('active');
      } else if (tabName === 'media') {
        // Validate specs info required inputs first
        if (!document.getElementById('title').reportValidity()) { switchFormTab('basic'); return; }
        if (!document.getElementById('price').reportValidity()) { switchFormTab('basic'); return; }
        if (!document.getElementById('bedrooms').reportValidity()) return;
        if (!document.getElementById('bathrooms').reportValidity()) return;
        if (!document.getElementById('area').reportValidity()) return;
        if (!document.getElementById('yearBuilt').reportValidity()) return;
        if (!document.getElementById('location').reportValidity()) return;
        if (!document.getElementById('city').reportValidity()) return;

        document.getElementById('tab-btn-media').classList.add('active');
        document.getElementById('tab-content-media').classList.add('active');
      }
    }

    // Toggle switch container clicks
    function toggleFeaturedCheck() {
      const chk = document.getElementById('featured');
      chk.checked = !chk.checked;
    }

    // Switch between listing and adding property views
    function switchView(viewName) {
      document.querySelectorAll('.menu-item').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.view-panel').forEach(panel => panel.classList.remove('active-view'));

      const titleEl = document.getElementById('page-title-text');
      const subtitleEl = document.getElementById('page-subtitle-text');

      if (viewName === 'list') {
        document.getElementById('menu-btn-list').classList.add('active');
        document.getElementById('view-panel-list').classList.add('active-view');
        titleEl.textContent = 'All Properties';
        subtitleEl.textContent = 'Manage and search your real estate catalog';
      } else {
        document.getElementById('menu-btn-add').classList.add('active');
        document.getElementById('view-panel-add').classList.add('active-view');
        titleEl.textContent = 'Add Property';
        subtitleEl.textContent = 'Create a premium database real estate listing';
        switchFormTab('basic'); // default to basic info tab
      }
    }

    // Client-side filtering/searching in table
    function filterTable() {
      const query = document.getElementById('table-search').value.toLowerCase();
      const city = document.getElementById('filter-city-select').value;
      const type = document.getElementById('filter-type-select').value;
      let count = 0;

      document.querySelectorAll('#properties-table-body tr').forEach(row => {
        const title = row.querySelector('.prop-name').textContent.toLowerCase();
        const loc = row.querySelector('.prop-address').textContent.toLowerCase();
        const rowCity = row.getAttribute('data-city');
        const rowType = row.getAttribute('data-type');

        const matchesSearch = title.includes(query) || loc.includes(query);
        const matchesCity = !city || rowCity === city;
        const matchesType = !type || rowType === type;

        if (matchesSearch && matchesCity && matchesType) {
          row.style.display = '';
          count++;
        } else {
          row.style.display = 'none';
        }
      });

      // Update count text dynamically
      const countBadge = document.getElementById('properties-count');
      if (countBadge) {
        countBadge.textContent = `${count} showing`;
      }
    }

    // Agent selector display toggle
    const agentSelect = document.getElementById('agent_selection');
    const customSection = document.getElementById('agent-custom-section');
    const custNameInput = document.getElementById('agent_name');
    const custPhoneInput = document.getElementById('agent_phone');

    agentSelect.addEventListener('change', () => {
      if (agentSelect.value === 'custom') {
        customSection.style.display = 'block';
        custNameInput.required = true;
        custPhoneInput.required = true;
      } else {
        customSection.style.display = 'none';
        custNameInput.required = false;
        custPhoneInput.required = false;
      }
    });

    // Drag and Drop Zone triggers
    const dragZone = document.getElementById('drag-drop-zone');
    const fileInput = document.getElementById('images');
    const previews = document.getElementById('images-preview');

    // Drag events
    ['dragenter', 'dragover'].forEach(name => {
      dragZone.addEventListener(name, (e) => {
        e.preventDefault();
        dragZone.classList.add('dragover');
      }, false);
    });

    ['dragleave', 'drop'].forEach(name => {
      dragZone.addEventListener(name, (e) => {
        e.preventDefault();
        dragZone.classList.remove('dragover');
      }, false);
    });

    dragZone.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      const files = dt.files;
      fileInput.files = files; // Assign files to file input
      renderPreviews(files);
    });

    fileInput.addEventListener('change', () => {
      renderPreviews(fileInput.files);
    });

    function renderPreviews(files) {
      previews.innerHTML = '';
      if (files.length > 0) {
        Array.from(files).forEach((file, index) => {
          if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
              const box = document.createElement('div');
              box.className = 'preview-thumb-box';
              box.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="preview-remove-btn" onclick="removeSelectedFile(${index})">×</button>
              `;
              previews.appendChild(box);
            };
            reader.readAsDataURL(file);
          }
        });
      }
    }

    function removeSelectedFile(indexToRemove) {
      const dt = new DataTransfer();
      const { files } = fileInput;
      for (let i = 0; i < files.length; i++) {
        if (i !== indexToRemove) {
          dt.items.add(files[i]);
        }
      }
      fileInput.files = dt.files;
      renderPreviews(fileInput.files);
    }

    // Submit Property Form via AJAX
    const form = document.getElementById('add-property-form');
    const btnSubmit = document.getElementById('btn-submit');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      btnSubmit.disabled = true;
      btnSpinner.style.display = 'block';
      btnText.textContent = 'Publishing Listing...';

      const formData = new FormData(form);
      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const response = await fetch('{{ url("/admin/properties") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrf,
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
          window.showToast(data.message || 'Validation failed. Check your inputs.');
          btnSubmit.disabled = false;
          btnSpinner.style.display = 'none';
          btnText.textContent = 'Publish Listing';
        }
      } catch (err) {
        console.error(err);
        window.showToast('Server error when publishing property.');
        btnSubmit.disabled = false;
        btnSpinner.style.display = 'none';
        btnText.textContent = 'Publish Listing';
      }
    });

    // Delete Property AJAX Call
    async function deleteProperty(id) {
      if (!confirm('Are you sure you want to delete this property? This action is permanent.')) {
        return;
      }

      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      try {
        const response = await fetch('{{ url("/admin/properties") }}/' + id, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });

        const data = await response.json();

        if (response.ok && data.success) {
          window.showToast(data.message || 'Property successfully removed!');
          const row = document.getElementById(`prop-row-${id}`);
          if (row) {
            row.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            setTimeout(() => {
              row.remove();
              // Refresh counts
              const listRows = document.querySelectorAll('#properties-table-body tr');
              
              // Total metrics counts
              const totalVal = document.getElementById('stats-total');
              if (totalVal) {
                totalVal.textContent = listRows.length;
              }
              const countBadge = document.getElementById('properties-count');
              if (countBadge) {
                countBadge.textContent = `${listRows.length} total`;
              }
              
              if (listRows.length === 0) {
                window.location.reload();
              }
            }, 500);
          }
        } else {
          window.showToast(data.message || 'Failed to delete listing.');
        }
      } catch (err) {
        console.error(err);
        window.showToast('An error occurred during list removal.');
      }
    }
  </script>

</body>
</html>
