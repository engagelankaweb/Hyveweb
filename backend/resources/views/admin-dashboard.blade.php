<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HYVE Portal | Management Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <style>
    :root {
      --sidebar-width: 270px;
      --color-primary-dark: #0f111a;
      --color-sidebar-bg: #161824;
      --color-sidebar-active: rgba(212, 175, 55, 0.12);
      --color-accent: #D4AF37;
      --color-accent-hover: #E5C158;
      --color-accent-glow: rgba(212, 175, 55, 0.2);
      --color-danger: #EF4444;
      --color-danger-hover: #DC2626;
      --color-success: #10B981;
      --color-warning: #F59E0B;
      --color-info: #3B82F6;
      --color-bg-main: #f8fafc;
      --color-card-bg: #ffffff;
      --color-border-light: #e2e8f0;
      --shadow-premium: 0 10px 30px rgba(0, 0, 0, 0.04);
      --shadow-dropdown: 0 15px 35px rgba(0, 0, 0, 0.12);
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      background-color: var(--color-bg-main);
      color: #1e293b;
      min-height: 100vh;
      display: flex;
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Mobile toggle */
    .mobile-nav-toggle {
      display: none;
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      background: var(--color-accent);
      color: #121212;
      border: none;
      border-radius: 50%;
      width: 52px;
      height: 52px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      cursor: pointer;
      align-items: center;
      justify-content: center;
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
      box-shadow: 4px 0 24px rgba(0,0,0,0.06);
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .sidebar-brand {
      padding: 26px 24px;
      font-family: 'Playfair Display', serif;
      font-size: 1.75rem;
      font-weight: 700;
      color: #ffffff;
      border-bottom: 1px solid rgba(255,255,255,0.06);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .sidebar-brand span {
      color: var(--color-accent);
    }

    .sidebar-role-badge {
      font-family: 'Inter', sans-serif;
      font-size: 0.72rem;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .badge-role-main_admin {
      background: rgba(212, 175, 55, 0.2);
      color: var(--color-accent);
      border: 1px solid rgba(212, 175, 55, 0.4);
    }

    .badge-role-staff {
      background: rgba(59, 130, 246, 0.15);
      color: #60A5FA;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .badge-role-agent {
      background: rgba(16, 185, 129, 0.15);
      color: #34D399;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .sidebar-menu {
      padding: 20px 14px;
      display: flex;
      flex-direction: column;
      gap: 6px;
      flex: 1;
      overflow-y: auto;
    }

    .menu-section-heading {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #64748b;
      padding: 12px 14px 6px;
      font-weight: 700;
    }

    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: var(--radius-sm);
      color: #94a3b8;
      font-weight: 500;
      font-size: 0.92rem;
      cursor: pointer;
      transition: all 0.25s ease;
      background: transparent;
      border: none;
      width: 100%;
      text-align: left;
    }

    .menu-item svg {
      width: 20px;
      height: 20px;
      stroke-width: 2;
      transition: transform 0.25s ease;
      flex-shrink: 0;
    }

    .menu-item:hover {
      color: #ffffff;
      background-color: rgba(255, 255, 255, 0.05);
    }

    .menu-item.active {
      color: var(--color-accent);
      background-color: var(--color-sidebar-active);
      font-weight: 600;
      border-left: 3px solid var(--color-accent);
    }

    .menu-item.active svg {
      color: var(--color-accent);
    }

    .menu-item:hover svg {
      transform: translateX(2px);
    }

    .sidebar-footer {
      padding: 18px 20px;
      border-top: 1px solid rgba(255,255,255,0.06);
      background: rgba(0, 0, 0, 0.15);
    }

    .sidebar-user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 14px;
    }

    .user-avatar-sm {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--color-accent);
      color: #121212;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 0.95rem;
      flex-shrink: 0;
    }

    .user-text-info {
      overflow: hidden;
    }

    .user-name-text {
      color: #ffffff;
      font-size: 0.88rem;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .user-role-text {
      color: #64748b;
      font-size: 0.75rem;
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
      padding: 9px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      font-weight: 600;
      font-size: 0.85rem;
      transition: all 0.25s ease;
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
      padding: 2rem 2.5rem;
      transition: all 0.3s ease;
      background: #f8fafc;
    }

    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.open {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
        padding: 1.5rem;
      }
      .mobile-nav-toggle {
        display: flex;
      }
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
      font-size: 1.75rem;
      font-weight: 700;
      margin: 0 0 4px 0;
      color: #0f172a;
      font-family: 'Playfair Display', serif;
    }

    .header-title p {
      font-size: 0.9rem;
      color: #64748b;
      margin: 0;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-header-profile {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f8fafc;
      padding: 8px 16px;
      border-radius: 40px;
      border: 1px solid #e2e8f0;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-header-profile:hover {
      background: #f1f5f9;
      border-color: #cbd5e1;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
      margin-bottom: 2rem;
    }

    @media (max-width: 1200px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 640px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
      .dashboard-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
        padding: 1rem;
      }
      .header-search {
        margin: 0;
      }
      .header-search input {
        width: 100%;
      }
      .header-actions {
        justify-content: flex-end;
      }
      .page-title {
        font-size: 1.5rem;
      }
    }

    .stat-card {
      background: var(--color-card-bg);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-premium);
      border: 1px solid var(--color-border-light);
      padding: 1.4rem;
      display: flex;
      align-items: center;
      gap: 1.1rem;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.06);
      border-color: rgba(212, 175, 55, 0.35);
    }

    .stat-icon {
      width: 48px;
      height: 48px;
      border-radius: var(--radius-sm);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .icon-gold { background: rgba(212,175,55,0.12); color: #B89010; }
    .icon-green { background: rgba(16,185,129,0.12); color: var(--color-success); }
    .icon-blue { background: rgba(59,130,246,0.12); color: #2563EB; }
    .icon-purple { background: rgba(139,92,246,0.12); color: #7C3AED; }
    .icon-orange { background: rgba(245,158,11,0.12); color: #D97706; }

    .stat-value {
      font-size: 1.7rem;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.1;
      margin-bottom: 2px;
    }

    .stat-label {
      font-size: 0.82rem;
      color: #64748b;
      font-weight: 500;
    }

    /* Views Panels */
    .view-panel {
      display: none;
      animation: viewFadeIn 0.4s ease forwards;
    }

    .view-panel.active-view {
      display: block;
    }

    @keyframes viewFadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Dashboard Panels */
    .dashboard-panel-card {
      background: var(--color-card-bg);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-premium);
      border: 1px solid var(--color-border-light);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .panel-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #f1f5f9;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .panel-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.45rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
    }

    /* Table Filter Bar */
    .table-filter-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 0.85rem;
      margin-bottom: 1.5rem;
      background: #f8fafc;
      padding: 1rem;
      border-radius: var(--radius-sm);
      border: 1px solid #e2e8f0;
      align-items: center;
    }

    .search-wrapper {
      flex: 1;
      min-width: 220px;
      position: relative;
    }

    .search-input {
      width: 100%;
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 10px 12px 10px 38px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      background: #ffffff;
    }

    .search-input:focus {
      outline: none;
      border-color: var(--color-accent);
      box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .search-icon {
      position: absolute;
      left: 12px;
      top: 11px;
      color: #94a3b8;
    }

    .filter-select {
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 10px 14px;
      font-size: 0.88rem;
      background: #ffffff;
      min-width: 140px;
      cursor: pointer;
    }

    .filter-select:focus {
      outline: none;
      border-color: var(--color-accent);
    }

    .btn-add-action {
      background: var(--color-accent);
      color: #121212;
      padding: 10px 18px;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.88rem;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.25s ease;
      text-decoration: none;
    }

    .btn-add-action:hover {
      background: var(--color-accent-hover);
      box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
    }

    /* Table Styling */
    .data-table {
      width: 100%;
      border-collapse: collapse;
    }

    .data-table th {
      background: #f8fafc;
      color: #475569;
      font-weight: 600;
      font-size: 0.82rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 14px 18px;
      border-bottom: 2px solid #edf2f7;
      text-align: left;
    }

    .data-table td {
      padding: 16px 18px;
      border-bottom: 1px solid #edf2f7;
      vertical-align: middle;
      font-size: 0.9rem;
    }

    .data-table tr:hover {
      background-color: #fafbfd;
    }

    .prop-info-cell {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .prop-thumbnail {
      width: 75px;
      height: 55px;
      border-radius: var(--radius-sm);
      object-fit: cover;
      border: 1px solid #e2e8f0;
      background: #edf2f7;
      flex-shrink: 0;
    }

    .prop-name {
      font-weight: 600;
      color: #0f172a;
      font-size: 0.95rem;
      margin-bottom: 3px;
    }

    .prop-address {
      font-size: 0.8rem;
      color: #64748b;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .badge {
      font-size: 0.72rem;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 4px;
      display: inline-block;
      letter-spacing: 0.2px;
    }

    .badge-published {
      background: rgba(16, 185, 129, 0.12);
      color: #059669;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .badge-draft {
      background: rgba(148, 163, 184, 0.15);
      color: #475569;
      border: 1px solid rgba(148, 163, 184, 0.3);
    }

    .badge-active {
      background: rgba(16, 185, 129, 0.12);
      color: #059669;
    }

    .badge-inactive {
      background: rgba(239, 68, 68, 0.12);
      color: #DC2626;
    }

    .badge-category {
      background: #f1f5f9;
      color: #334155;
    }

    .badge-buy { background: #e0f2fe; color: #0369a1; }
    .badge-rent { background: #fef3c7; color: #b45309; }
    .badge-short_term { background: #fae8ff; color: #86198f; }

    .badge-featured {
      background: linear-gradient(135deg, var(--color-accent) 0%, #B89010 100%);
      color: #121212;
      font-weight: 700;
    }

    /* Action Buttons in Table */
    .table-actions {
      display: flex;
      align-items: center;
      gap: 6px;
      justify-content: flex-end;
    }

    .btn-action-sm {
      padding: 6px 10px;
      border-radius: var(--radius-sm);
      font-size: 0.8rem;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: all 0.2s ease;
      border: 1px solid transparent;
      background: #f1f5f9;
      color: #334155;
      text-decoration: none;
    }

    .btn-action-sm:hover {
      background: #e2e8f0;
      color: #0f172a;
    }

    .btn-action-edit {
      background: rgba(59, 130, 246, 0.08);
      color: #2563EB;
      border-color: rgba(59, 130, 246, 0.2);
    }

    .btn-action-edit:hover {
      background: #2563EB;
      color: #ffffff;
    }

    .btn-action-delete {
      background: rgba(239, 68, 68, 0.08);
      color: var(--color-danger);
      border-color: rgba(239, 68, 68, 0.2);
    }

    .btn-action-delete:hover {
      background: var(--color-danger);
      color: #ffffff;
    }

    /* Live Toggle Switch */
    .switch-toggle {
      position: relative;
      display: inline-block;
      width: 38px;
      height: 20px;
    }

    .switch-toggle input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #cbd5e1;
      transition: .3s cubic-bezier(0.16, 1, 0.3, 1);
      border-radius: 20px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 14px;
      width: 14px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .3s cubic-bezier(0.16, 1, 0.3, 1);
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .switch-toggle input:checked + .slider {
      background-color: var(--color-success);
    }

    .switch-toggle input:checked + .slider:before {
      transform: translateX(18px);
    }

    /* Form Layouts & Inputs */
    .form-tabs {
      display: flex;
      gap: 8px;
      margin-bottom: 1.8rem;
      border-bottom: 1px solid #e2e8f0;
      padding-bottom: 8px;
    }

    .form-tab-btn {
      background: transparent;
      border: none;
      padding: 10px 18px;
      font-size: 0.9rem;
      font-weight: 600;
      color: #64748b;
      cursor: pointer;
      border-radius: var(--radius-sm);
      transition: all 0.2s ease;
    }

    .form-tab-btn.active {
      color: #121212;
      background: rgba(212, 175, 55, 0.15);
    }

    .form-tab-content {
      display: none;
    }

    .form-tab-content.active {
      display: block;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.25rem;
    }

    .form-grid-3 {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.25rem;
    }

    @media (max-width: 768px) {
      .form-grid-2, .form-grid-3 {
        grid-template-columns: 1fr;
      }
    }

    .form-group-custom {
      margin-bottom: 1.25rem;
      display: flex;
      flex-direction: column;
    }

    .form-group-custom.full-span {
      grid-column: 1 / -1;
    }

    .label-custom {
      font-size: 0.85rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 5px;
    }

    .input-custom, .select-custom, .textarea-custom {
      border: 1px solid #cbd5e1;
      border-radius: var(--radius-sm);
      padding: 11px 14px;
      font-family: 'Inter', sans-serif;
      font-size: 0.92rem;
      background: #FFFFFF;
      transition: all 0.25s ease;
      color: #1e293b;
      box-sizing: border-box;
      width: 100%;
    }

    .input-custom:focus, .select-custom:focus, .textarea-custom:focus {
      outline: none;
      border-color: var(--color-accent);
      box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .textarea-custom {
      min-height: 110px;
      resize: vertical;
    }

    .upload-drag-zone {
      border: 2px dashed #cbd5e1;
      border-radius: var(--radius-md);
      padding: 2.2rem;
      text-align: center;
      background: #f8fafc;
      cursor: pointer;
      transition: all 0.25s ease;
      margin-top: 6px;
    }

    .upload-drag-zone:hover, .upload-drag-zone.dragover {
      border-color: var(--color-accent);
      background: rgba(212, 175, 55, 0.03);
    }

    .upload-drag-zone svg {
      color: var(--color-accent);
      margin-bottom: 8px;
    }

    .preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 1rem;
    }

    .preview-thumb-box {
      position: relative;
      width: 90px;
      height: 70px;
      border-radius: var(--radius-sm);
      overflow: hidden;
      border: 1px solid #e2e8f0;
      background: #edf2f7;
    }

    .preview-thumb-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .preview-remove-btn {
      position: absolute;
      top: 3px;
      right: 3px;
      background: rgba(239, 68, 68, 0.9);
      color: #ffffff;
      border: none;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .btn-form-action-group {
      display: flex;
      justify-content: space-between;
      margin-top: 1.8rem;
      border-top: 1px solid #e2e8f0;
      padding-top: 1.4rem;
    }

    .btn-secondary-custom {
      background: #f1f5f9;
      color: #475569;
      border: 1px solid #e2e8f0;
      border-radius: var(--radius-sm);
      padding: 10px 20px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-secondary-custom:hover {
      background: #e2e8f0;
    }

    /* Modal dialogs */
    .modal-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(4px);
      z-index: 1050;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      animation: modalFade 0.25s ease;
    }

    .modal-overlay.open {
      display: flex;
    }

    @keyframes modalFade {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .modal-dialog {
      background: #ffffff;
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-dropdown);
      width: 95%;
      max-width: 850px;
      max-height: 90vh;
      margin: 20px auto;
      display: flex;
      flex-direction: column;
      animation: modalSlide 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      overflow-y: auto;
    }

    .modal-dialog.sm {
      max-width: 480px;
    }

    @keyframes modalSlide {
      from { transform: translateY(20px) scale(0.98); }
      to { transform: translateY(0) scale(1); }
    }

    .modal-header {
      padding: 1.4rem 1.8rem;
      border-bottom: 1px solid #f1f5f9;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.35rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
    }

    .modal-close-btn {
      background: transparent;
      border: none;
      font-size: 1.5rem;
      color: #94a3b8;
      cursor: pointer;
      line-height: 1;
      padding: 4px;
    }

    .modal-close-btn:hover {
      color: #0f172a;
    }

    .modal-body {
      padding: 1.8rem;
      overflow-y: auto;
      flex: 1;
    }

    .modal-footer {
      padding: 1.2rem 1.8rem;
      border-top: 1px solid #f1f5f9;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      background: #fafbfd;
      border-bottom-left-radius: var(--radius-md);
      border-bottom-right-radius: var(--radius-md);
    }

    /* Toast Notification */
    .toast-container {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .toast-msg {
      background: #0f172a;
      color: #ffffff;
      padding: 12px 20px;
      border-radius: var(--radius-sm);
      font-size: 0.9rem;
      font-weight: 500;
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
      display: flex;
      align-items: center;
      gap: 10px;
      border-left: 4px solid var(--color-accent);
      animation: toastIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes toastIn {
      from { transform: translateX(50px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }

    .spinner-sm {
      width: 16px;
      height: 16px;
      border: 2px solid rgba(18, 18, 18, 0.2);
      border-top-color: #121212;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }
  </style>
</head>
<body>

  <!-- Mobile Navigation Toggle Button -->
  <button class="mobile-nav-toggle" onclick="toggleSidebar()">
    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>

  <!-- Sidebar Navigation -->
  <aside class="sidebar" id="main-sidebar">
    <div class="sidebar-brand">
      <div>HYVE<span>.</span> Admin</div>
      <span class="sidebar-role-badge badge-role-{{ $currentUser->role }}">
        {{ $currentUser->role === 'main_admin' ? 'Main Admin' : ($currentUser->role === 'staff' ? 'Staff' : 'Agent') }}
      </span>
    </div>
    
    <nav class="sidebar-menu">
      <div class="menu-section-heading">Catalog & Listings</div>
      
      <button class="menu-item active" id="menu-btn-overview" onclick="switchView('overview')">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Overview Dashboard
      </button>

      @if($currentUser->isMainAdmin())
        <button class="menu-item" id="menu-btn-properties" onclick="switchView('properties')">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          Property Management
        </button>

        <button class="menu-item" id="menu-btn-rentals" onclick="switchView('rentals')">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Short Term Rentals
        </button>

        <button class="menu-item" id="menu-btn-add-property" onclick="switchView('add-property')">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
          Add New Property
        </button>

        <div class="menu-section-heading">Administration</div>
        
        <button class="menu-item" id="menu-btn-users" onclick="switchView('users')">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          User Management
        </button>
      @endif

      <div class="menu-section-heading">Settings</div>
      
      <button class="menu-item" id="menu-btn-profile" onclick="openProfileModal()">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        My Profile & Security
      </button>

      <a href="{{ url('/') }}" target="_blank" class="menu-item" style="color: #64748b;">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        View Public Site
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user-info">
        <div class="user-avatar-sm">{{ strtoupper(substr($currentUser->name, 0, 1)) }}</div>
        <div class="user-text-info">
          <div class="user-name-text">{{ $currentUser->name }}</div>
          <div class="user-role-text">{{ $currentUser->email }}</div>
        </div>
      </div>
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      <button class="btn-sidebar-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1"/></svg>
        Log Out
      </button>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <main class="main-content">
    
    <!-- Top Header -->
    <header class="dashboard-header">
      <div class="header-title">
        <h1 id="page-title-text">Management Overview</h1>
        <p id="page-subtitle-text">Monitor portfolio metrics, listings status, and administrator controls</p>
      </div>
      <div class="header-actions">
        <button class="btn-header-profile" onclick="openProfileModal()">
          <div class="user-avatar-sm" style="width: 28px; height: 28px; font-size: 0.8rem;">{{ strtoupper(substr($currentUser->name, 0, 1)) }}</div>
          <span style="font-weight: 600; font-size: 0.88rem; color: #1e293b;">{{ $currentUser->name }}</span>
        </button>
        @if($currentUser->isMainAdmin())
        <button class="btn-add-action" onclick="switchView('add-property')">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          New Listing
        </button>
        @endif
      </div>
    </header>

    <!-- Metrics Stats Row -->
    <section class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon icon-gold">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-total">{{ $stats['total'] }}</div>
          <div class="stat-label">Total Listings</div>
        </div>
      </div>
      
      <div class="stat-card">
        <div class="stat-icon icon-green">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-published">{{ $stats['published'] }}</div>
          <div class="stat-label">Live & Published</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-purple">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-rentals">{{ $stats['short_term'] }}</div>
          <div class="stat-label">Short Term Rentals</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon icon-blue">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
          <div class="stat-value" id="stats-users">{{ $stats['users_count'] }}</div>
          <div class="stat-label">Admin & Staff Users</div>
        </div>
      </div>
    </section>

    <!-- ============================================== -->
    <!-- VIEW 1: OVERVIEW DASHBOARD -->
    <!-- ============================================== -->
    <section class="view-panel active-view" id="view-panel-overview">
      <div class="dashboard-panel-card">
        <div class="panel-header">
          <h2 class="panel-title">Recent Real Estate Listings</h2>
          @if($currentUser->isMainAdmin())
          <button class="btn-secondary-custom" onclick="switchView('properties')">View Full Catalog →</button>
          @endif
        </div>

        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Property</th>
                <th>Type & Purpose</th>
                <th>Price / Rates</th>
                @if($currentUser->isMainAdmin())
                <th>Publish Status</th>
                <th>Featured</th>
                <th style="text-align: right;">Quick Actions</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @forelse($properties->take(6) as $prop)
                <tr id="overview-prop-row-{{ $prop->id }}">
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
                          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                          {{ $prop->location }}, {{ $prop->city }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-category">{{ $prop->type }}</span>
                    <span class="badge badge-{{ $prop->purpose }}">{{ $prop->purpose === 'buy' ? 'For Sale' : ($prop->rental_type === 'short_term' ? 'Short Stay' : 'Long Rent') }}</span>
                  </td>
                  <td style="font-weight: 700; color: #0f172a;">
                    ${{ number_format($prop->price) }}{{ $prop->purpose === 'rent' ? ($prop->rental_type === 'short_term' ? '/night' : '/mo') : '' }}
                  </td>
                  @if($currentUser->isMainAdmin())
                  <td>
                    <label class="switch-toggle" title="Toggle Publish Status">
                      <input type="checkbox" {{ $prop->is_published ? 'checked' : '' }} onchange="togglePublish({{ $prop->id }}, this)">
                      <span class="slider"></span>
                    </label>
                  </td>
                  <td>
                    <button class="btn-action-sm {{ $prop->featured ? 'badge-featured' : '' }}" onclick="toggleFeatured({{ $prop->id }}, this)" title="Toggle Featured on Homepage">
                      {{ $prop->featured ? '★ Featured' : '☆ Standard' }}
                    </button>
                  </td>
                  <td>
                    <div class="table-actions">
                      <button class="btn-action-sm btn-action-edit" onclick="openEditModal({{ $prop->id }})">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                      </button>
                      <button class="btn-action-sm btn-action-delete" onclick="deleteProperty({{ $prop->id }})">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Delete
                      </button>
                    </div>
                  </td>
                  @endif
                </tr>
              @empty
                <tr>
                  <td colspan="{{ $currentUser->isMainAdmin() ? 6 : 3 }}" style="text-align: center; color: #64748b; padding: 3rem;">No property listings available.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </section>

    @if($currentUser->isMainAdmin())
    <!-- ============================================== -->
    <!-- VIEW 2: PROPERTY MANAGEMENT DASHBOARD -->
    <!-- ============================================== -->
    <section class="view-panel" id="view-panel-properties">
      <div class="dashboard-panel-card">
        <div class="panel-header">
          <div>
            <h2 class="panel-title">Property Catalog Management</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">Add, edit, unpublish, or delete real estate listings</p>
          </div>
          <button class="btn-add-action" onclick="switchView('add-property')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Property
          </button>
        </div>

        <!-- Filter Controls -->
        <div class="table-filter-bar">
          <div class="search-wrapper">
            <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="prop-search" class="search-input" oninput="filterPropertiesTable()">
          </div>
          
          <select id="prop-filter-city" class="filter-select" onchange="filterPropertiesTable()">
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

          <select id="prop-filter-type" class="filter-select" onchange="filterPropertiesTable()">
            <option value="">All Categories</option>
            <option value="Villa">Villa</option>
            <option value="House">House</option>
            <option value="Apartment">Apartment</option>
            <option value="Condo">Condo</option>
            <option value="Commercial">Commercial</option>
          </select>

          <select id="prop-filter-purpose" class="filter-select" onchange="filterPropertiesTable()">
            <option value="">All Purposes</option>
            <option value="buy">For Sale</option>
            <option value="rent">For Rent</option>
          </select>

          <select id="prop-filter-status" class="filter-select" onchange="filterPropertiesTable()">
            <option value="">All Statuses</option>
            <option value="published">Published Only</option>
            <option value="draft">Draft / Unpublished</option>
          </select>
        </div>

        <!-- Table Listing -->
        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Property Listing</th>
                <th>Category</th>
                <th>Price</th>
                <th>Specifications</th>
                <th>Status</th>
                <th>External Link</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody id="properties-table-body">
              @foreach($properties as $prop)
                <tr id="prop-row-{{ $prop->id }}" data-city="{{ $prop->city }}" data-type="{{ $prop->type }}" data-purpose="{{ $prop->purpose }}" data-status="{{ $prop->is_published ? 'published' : 'draft' }}">
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
                          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                          {{ $prop->location }}, {{ $prop->city }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-category">{{ $prop->type }}</span>
                    <span class="badge badge-{{ $prop->purpose }}">{{ $prop->purpose === 'buy' ? 'For Sale' : 'Rent' }}</span>
                  </td>
                  <td style="font-weight: 700; color: #0f172a;">
                    ${{ number_format($prop->price) }}{{ $prop->purpose === 'rent' ? '/mo' : '' }}
                  </td>
                  <td style="color: #64748b; font-size: 0.85rem;">
                    <strong>{{ $prop->bedrooms }}</strong> bd &bull; 
                    <strong>{{ $prop->bathrooms }}</strong> ba &bull; 
                    <strong>{{ $prop->area }}</strong> sqft
                  </td>
                  <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                      <label class="switch-toggle" title="Live Publish / Draft Switch">
                        <input type="checkbox" {{ $prop->is_published ? 'checked' : '' }} onchange="togglePublish({{ $prop->id }}, this)">
                        <span class="slider"></span>
                      </label>
                      <span class="badge badge-{{ $prop->is_published ? 'published' : 'draft' }}" id="prop-badge-status-{{ $prop->id }}">
                        {{ $prop->is_published ? 'Published' : 'Draft' }}
                      </span>
                    </div>
                  </td>
                  <td>
                    @if($prop->external_url)
                      <a href="{{ $prop->external_url }}" target="_blank" class="btn-action-sm" style="color: #2563eb; border-color: #bfdbfe;">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Virtual Tour
                      </a>
                    @else
                      <span style="color: #94a3b8; font-size: 0.8rem;">None</span>
                    @endif
                  </td>
                  <td>
                    <div class="table-actions">
                      <button class="btn-action-sm btn-action-edit" onclick="openEditModal({{ $prop->id }})">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                      </button>
                      <button class="btn-action-sm btn-action-delete" onclick="deleteProperty({{ $prop->id }})">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Remove
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ============================================== -->
    <!-- VIEW 3: SHORT TERM RENTALS DASHBOARD -->
    <!-- ============================================== -->
    <section class="view-panel" id="view-panel-rentals">
      <div class="dashboard-panel-card">
        <div class="panel-header">
          <div>
            <h2 class="panel-title">Short Term Rentals & Vacation Stays</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">Manage nightly rates, guest capacities, min stays, and booking URLs</p>
          </div>
          <button class="btn-add-action" onclick="openAddShortRentalModal()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Short-Term Rental
          </button>
        </div>

        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Stay Property</th>
                <th>Nightly Rate</th>
                <th>Capacity</th>
                <th>Min Stay</th>
                <th>Check-in / Out</th>
                <th>Booking Partner URL</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($shortTermRentals as $rental)
                <tr id="rental-row-{{ $rental->id }}">
                  <td>
                    <div class="prop-info-cell">
                      @if(is_array($rental->images) && count($rental->images) > 0)
                        <img class="prop-thumbnail" src="{{ asset($rental->images[0]) }}" alt="{{ $rental->title }}">
                      @else
                        <div class="prop-thumbnail"></div>
                      @endif
                      <div>
                        <div class="prop-name">{{ $rental->title }}</div>
                        <div class="prop-address">{{ $rental->location }}, {{ $rental->city }}</div>
                      </div>
                    </div>
                  </td>
                  <td style="font-weight: 700; color: #0f172a;">
                    ${{ number_format($rental->nightly_rate ?: $rental->price) }}<span style="font-size: 0.8rem; font-weight: 500; color: #64748b;">/night</span>
                  </td>
                  <td>
                    <span style="font-weight: 600;">{{ $rental->max_guests ?: ($rental->bedrooms * 2) }}</span> Guests
                  </td>
                  <td>
                    {{ $rental->min_stay ?: 1 }} nights min
                  </td>
                  <td style="font-size: 0.82rem; color: #64748b;">
                    {{ $rental->check_in_time ?: '3:00 PM' }} / {{ $rental->check_out_time ?: '11:00 AM' }}
                  </td>
                  <td>
                    @if($rental->external_booking_url)
                      <a href="{{ $rental->external_booking_url }}" target="_blank" class="btn-action-sm" style="color: #9333ea; border-color: #f3e8ff;">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Airbnb / Booking
                      </a>
                    @else
                      <span style="color: #94a3b8; font-size: 0.8rem;">Direct Book</span>
                    @endif
                  </td>
                  <td>
                    <label class="switch-toggle">
                      <input type="checkbox" {{ $rental->is_published ? 'checked' : '' }} onchange="togglePublish({{ $rental->id }}, this)">
                      <span class="slider"></span>
                    </label>
                  </td>
                  <td>
                    <div class="table-actions">
                      <button class="btn-action-sm btn-action-edit" onclick="openEditModal({{ $rental->id }})">Edit</button>
                      <button class="btn-action-sm btn-action-delete" onclick="deleteProperty({{ $rental->id }})">Remove</button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" style="text-align: center; color: #64748b; padding: 3rem;">
                    No short-term rentals configured yet. Click "Add Short-Term Rental" to create vacation listings.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ============================================== -->
    <!-- VIEW 4: ADD PROPERTY VIEW -->
    <!-- ============================================== -->
    <section class="view-panel" id="view-panel-add-property">
      <div class="dashboard-panel-card" style="max-width: 900px; margin: 0 auto 2rem;">
        <div class="panel-header">
          <div>
            <h2 class="panel-title">Create New Listing</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">Publish a luxury property, long-term rental, or vacation stay</p>
          </div>
          <button class="btn-secondary-custom" onclick="switchView('properties')">Cancel & Return</button>
        </div>

        <form id="add-property-form" enctype="multipart/form-data">
          <!-- Step Tabs -->
          <div class="form-tabs">
            <button type="button" class="form-tab-btn active" id="tab-add-btn-1" onclick="switchAddTab(1)">1. Basic Information</button>
            <button type="button" class="form-tab-btn" id="tab-add-btn-2" onclick="switchAddTab(2)">2. Specs & Rates</button>
            <button type="button" class="form-tab-btn" id="tab-add-btn-3" onclick="switchAddTab(3)">3. Media & External Link</button>
          </div>

          <!-- Tab 1: Basic Info -->
          <div class="form-tab-content active" id="tab-add-content-1">
            <div class="form-group-custom">
              <label class="label-custom" for="add_title">Listing Title *</label>
              <input type="text" id="add_title" name="title" class="input-custom" required>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="add_type">Property Category *</label>
                <select id="add_type" name="type" class="select-custom" required>
                  <option value="Villa">Villa</option>
                  <option value="House">House</option>
                  <option value="Apartment">Apartment</option>
                  <option value="Condo">Condo</option>
                  <option value="Commercial">Commercial</option>
                </select>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="add_purpose">Listing Purpose *</label>
                <select id="add_purpose" name="purpose" class="select-custom" required>
                  <option value="buy">For Sale (Buy)</option>
                  <option value="rent">For Rent (Long-Term)</option>
                </select>
              </div>
            </div>

            <!-- Hidden long_term for properties -->
            <input type="hidden" id="add_rental_type" name="rental_type" value="long_term">

            <div class="form-group-custom">
              <label class="label-custom" for="add_price">Price ($ USD) *</label>
              <input type="number" id="add_price" name="price" class="input-custom" min="0" required>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="add_description">Listing Narrative & Description *</label>
              <textarea id="add_description" name="description" class="textarea-custom" required></textarea>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom">Featured on Homepage</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" name="featured" value="1">
                  <span class="slider"></span>
                </label>
              </div>

              <div class="form-group-custom">
                <label class="label-custom">Publish Immediately</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" name="is_published" value="1" checked>
                  <span class="slider"></span>
                </label>
              </div>
            </div>

            <div class="btn-form-action-group">
              <div></div>
              <button type="button" class="btn-add-action" onclick="switchAddTab(2)">Continue to Specs →</button>
            </div>
          </div>

          <!-- Tab 2: Specs & Rates -->
          <div class="form-tab-content" id="tab-add-content-2">
            <div class="form-grid-3">
              <div class="form-group-custom">
                <label class="label-custom" for="add_bedrooms">Bedrooms *</label>
                <input type="number" id="add_bedrooms" name="bedrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="add_bathrooms">Bathrooms *</label>
                <input type="number" step="0.5" id="add_bathrooms" name="bathrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="add_area">Area (sqft) *</label>
                <input type="number" id="add_area" name="area" class="input-custom" min="0" required>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="add_yearBuilt">Year Built *</label>
                <input type="number" id="add_yearBuilt" name="yearBuilt" class="input-custom" min="1800" max="2035" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="add_city">City *</label>
                <input type="text" id="add_city" name="city" class="input-custom" required>
              </div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="add_location">Street Address *</label>
              <input type="text" id="add_location" name="location" class="input-custom" required>
            </div>


            <div class="form-group-custom">
              <label class="label-custom" for="add_features">Key Features (comma-separated)</label>
              <input type="text" id="add_features" name="features" class="input-custom">
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchAddTab(1)">← Back to Basic</button>
              <button type="button" class="btn-add-action" onclick="switchAddTab(3)">Continue to Media →</button>
            </div>
          </div>

          <!-- Tab 3: Media & External Links -->
          <div class="form-tab-content" id="tab-add-content-3">
            <div class="form-group-custom">
              <label class="label-custom">Upload Property Media Photos</label>
              <div class="upload-drag-zone" onclick="document.getElementById('add_images').click()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" style="margin: 0 auto 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <div style="font-weight: 600; font-size: 0.92rem; color: #1e293b;">Click to browse photos or drag and drop files here</div>
                <span style="font-size: 0.8rem; color: #94a3b8;">Supports JPEG, PNG, WEBP (Max 5MB each)</span>
              </div>
              <input type="file" id="add_images" name="images[]" multiple accept="image/*" style="display: none;" onchange="renderAddImagePreviews(this.files)">
              <div class="preview-container" id="add_images_preview"></div>
            </div>


            <div class="form-group-custom" style="border-top: 1px solid #f1f5f9; padding-top: 1.25rem; margin-top: 1.25rem;">
              <label class="label-custom" for="add_agent_selection">Assign Listing Agent *</label>
              <select id="add_agent_selection" name="agent_selection" class="select-custom" required onchange="handleAddAgentChange(this.value)">
                <option value="sarah" selected>Sarah Jenkins (Senior Partner)</option>
                <option value="michael">Michael Chen (Urban Specialist)</option>
                <option value="emma">Emma Davis (Family Estates)</option>
                <option value="custom">-- Custom Listing Agent --</option>
              </select>
            </div>

            <div id="add-custom-agent-box" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; padding: 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1rem;">
              <div class="form-grid-2">
                <div class="form-group-custom">
                  <label class="label-custom" for="add_agent_name">Agent Full Name</label>
                  <input type="text" id="add_agent_name" name="agent_name" class="input-custom">
                </div>
                <div class="form-group-custom">
                  <label class="label-custom" for="add_agent_phone">Contact Phone</label>
                  <input type="text" id="add_agent_phone" name="agent_phone" class="input-custom">
                </div>
              </div>
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchAddTab(2)">← Back to Specs</button>
              <button type="submit" class="btn-add-action" id="btn-add-submit" style="padding: 12px 32px;">
                <span class="spinner-sm" id="spinner-add-submit"></span>
                <span>Publish Real Estate Listing</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </section>

    <!-- ============================================== -->
    <!-- VIEW X: ADD SHORT TERM RENTAL VIEW -->
    <!-- ============================================== -->
    <section class="view-panel" id="view-panel-add-short-rental">
      <div class="dashboard-panel-card" style="max-width: 900px; margin: 0 auto 2rem;">
        <div class="panel-header">
          <div>
            <h2 class="panel-title">Create New Short-Term Rental</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">Publish a vacation stay with nightly rates</p>
          </div>
          <button class="btn-secondary-custom" onclick="switchView('rentals')">Cancel & Return</button>
        </div>

        <form id="add-short-rental-form" enctype="multipart/form-data">
          <!-- Hidden fields for rentals -->
          <input type="hidden" name="purpose" value="rent">
          <input type="hidden" name="rental_type" value="short_term">

          <!-- Step Tabs -->
          <div class="form-tabs">
            <button type="button" class="form-tab-btn active" id="tab-rental-btn-1" onclick="switchRentalTab(1)">1. Basic Information</button>
            <button type="button" class="form-tab-btn" id="tab-rental-btn-2" onclick="switchRentalTab(2)">2. Specs & Rates</button>
            <button type="button" class="form-tab-btn" id="tab-rental-btn-3" onclick="switchRentalTab(3)">3. Media & Links</button>
          </div>

          <!-- Tab 1: Basic Info -->
          <div class="form-tab-content active" id="tab-rental-content-1">
            <div class="form-group-custom">
              <label class="label-custom" for="rental_title">Listing Title *</label>
              <input type="text" id="rental_title" name="title" class="input-custom" required>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="rental_type_select">Property Category *</label>
                <select id="rental_type_select" name="type" class="select-custom" required>
                  <option value="Villa">Villa</option>
                  <option value="House">House</option>
                  <option value="Apartment">Apartment</option>
                  <option value="Condo">Condo</option>
                  <option value="Cabin">Cabin</option>
                </select>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_nightly_rate">Nightly Rate ($ USD) *</label>
                <input type="number" id="rental_nightly_rate" name="nightly_rate" class="input-custom" min="0" required oninput="document.getElementById('rental_price').value = this.value">
              </div>
            </div>

            <div class="form-group-custom" style="display: none;">
              <input type="number" id="rental_price" name="price" value="0">
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="rental_description">Listing Narrative & Description *</label>
              <textarea id="rental_description" name="description" class="textarea-custom" required></textarea>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom">Featured on Homepage</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" name="featured" value="1">
                  <span class="slider"></span>
                </label>
              </div>

              <div class="form-group-custom">
                <label class="label-custom">Publish Immediately</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" name="is_published" value="1" checked>
                  <span class="slider"></span>
                </label>
              </div>
            </div>

            <div class="btn-form-action-group">
              <div></div>
              <button type="button" class="btn-add-action" onclick="switchRentalTab(2)">Continue to Specs →</button>
            </div>
          </div>

          <!-- Tab 2: Specs & Rates -->
          <div class="form-tab-content" id="tab-rental-content-2">
            <div class="form-grid-3">
              <div class="form-group-custom">
                <label class="label-custom" for="rental_bedrooms">Bedrooms *</label>
                <input type="number" id="rental_bedrooms" name="bedrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_bathrooms">Bathrooms *</label>
                <input type="number" step="0.5" id="rental_bathrooms" name="bathrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_area">Area (sqft) *</label>
                <input type="number" id="rental_area" name="area" class="input-custom" min="0" required>
              </div>
            </div>

            <div class="form-grid-3">
              <div class="form-group-custom">
                <label class="label-custom" for="rental_max_guests">Max Guests</label>
                <input type="number" id="rental_max_guests" name="max_guests" class="input-custom" min="1">
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_min_stay">Min Stay (Nights)</label>
                <input type="number" id="rental_min_stay" name="min_stay" class="input-custom" min="1">
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_yearBuilt">Year Built *</label>
                <input type="number" id="rental_yearBuilt" name="yearBuilt" class="input-custom" min="1800" max="2035" required>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="rental_check_in_time">Check-in Time</label>
                <input type="text" id="rental_check_in_time" name="check_in_time" placeholder="e.g. 3:00 PM" class="input-custom">
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_check_out_time">Check-out Time</label>
                <input type="text" id="rental_check_out_time" name="check_out_time" placeholder="e.g. 11:00 AM" class="input-custom">
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="rental_city">City *</label>
                <input type="text" id="rental_city" name="city" class="input-custom" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="rental_location">Street Address *</label>
                <input type="text" id="rental_location" name="location" class="input-custom" required>
              </div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="rental_features">Key Features (comma-separated)</label>
              <input type="text" id="rental_features" name="features" class="input-custom">
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchRentalTab(1)">← Back to Basic</button>
              <button type="button" class="btn-add-action" onclick="switchRentalTab(3)">Continue to Media →</button>
            </div>
          </div>

          <!-- Tab 3: Media & Links -->
          <div class="form-tab-content" id="tab-rental-content-3">
            <div class="form-group-custom">
              <label class="label-custom">Upload Property Media Photos</label>
              <div class="upload-drag-zone" onclick="document.getElementById('rental_images').click()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="36" height="36" style="margin: 0 auto 6px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                <div style="font-weight: 600; font-size: 0.92rem; color: #1e293b;">Click to browse photos or drag and drop files here</div>
                <span style="font-size: 0.8rem; color: #94a3b8;">Supports JPEG, PNG, WEBP (Max 5MB each)</span>
              </div>
              <input type="file" id="rental_images" name="images[]" multiple accept="image/*" style="display: none;" onchange="renderRentalImagePreviews(this.files)">
              <div class="preview-container" id="rental_images_preview"></div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="rental_external_booking_url">Booking Partner URL (e.g. Airbnb, Booking.com)</label>
              <input type="url" id="rental_external_booking_url" name="external_booking_url" class="input-custom" placeholder="https://">
            </div>

            <div class="form-group-custom" style="border-top: 1px solid #f1f5f9; padding-top: 1.25rem; margin-top: 1.25rem;">
              <label class="label-custom" for="rental_agent_selection">Assign Listing Agent *</label>
              <select id="rental_agent_selection" name="agent_selection" class="select-custom" required onchange="handleRentalAgentChange(this.value)">
                <option value="sarah" selected>Sarah Jenkins (Senior Partner)</option>
                <option value="michael">Michael Chen (Urban Specialist)</option>
                <option value="emma">Emma Davis (Family Estates)</option>
                <option value="custom">-- Custom Listing Agent --</option>
              </select>
            </div>

            <div id="rental-custom-agent-box" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; padding: 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1rem;">
              <div class="form-grid-2">
                <div class="form-group-custom">
                  <label class="label-custom" for="rental_agent_name">Agent Full Name</label>
                  <input type="text" id="rental_agent_name" name="agent_name" class="input-custom">
                </div>
                <div class="form-group-custom">
                  <label class="label-custom" for="rental_agent_phone">Contact Phone</label>
                  <input type="text" id="rental_agent_phone" name="agent_phone" class="input-custom">
                </div>
              </div>
            </div>

            <div class="btn-form-action-group">
              <button type="button" class="btn-secondary-custom" onclick="switchRentalTab(2)">← Back to Specs</button>
              <button type="submit" class="btn-add-action" id="btn-rental-submit" style="padding: 12px 32px;">
                <span class="spinner-sm" id="spinner-rental-submit"></span>
                <span>Publish Vacation Stay</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </section>
    @endif

    <!-- ============================================== -->
    <!-- VIEW 5: USER MANAGEMENT (MAIN ADMIN ONLY) -->
    <!-- ============================================== -->
    @if($currentUser->isMainAdmin())
    <section class="view-panel" id="view-panel-users">
      <div class="dashboard-panel-card">
        <div class="panel-header">
          <div>
            <h2 class="panel-title">Administrator & Staff User Roster</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">Manage administrator accounts, roles, access levels, and active statuses</p>
          </div>
          <button class="btn-add-action" onclick="openAddUserModal()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Add New User
          </button>
        </div>

        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>User Account</th>
                <th>Role & Access</th>
                <th>Phone</th>
                <th>Account Status</th>
                <th>Created Date</th>
                <th style="text-align: right;">Actions</th>
              </tr>
            </thead>
            <tbody id="users-table-body">
              @foreach($users as $u)
                <tr id="user-row-{{ $u->id }}">
                  <td>
                    <div style="display: flex; align-items: center; gap: 12px;">
                      <div class="user-avatar-sm">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                      <div>
                        <div style="font-weight: 600; color: #0f172a;">{{ $u->name }}</div>
                        <div style="font-size: 0.82rem; color: #64748b;">{{ $u->email }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="sidebar-role-badge badge-role-{{ $u->role }}">
                      {{ $u->role === 'main_admin' ? 'Main Admin' : ($u->role === 'staff' ? 'Staff / Manager' : 'Listing Agent') }}
                    </span>
                  </td>
                  <td style="color: #64748b;">{{ $u->phone ?: '—' }}</td>
                  <td>
                    <button class="btn-action-sm {{ $u->status === 'active' ? 'badge-active' : 'badge-inactive' }}" onclick="toggleUserStatus({{ $u->id }})" title="Click to toggle Active/Inactive">
                      {{ ucfirst($u->status) }}
                    </button>
                  </td>
                  <td style="color: #64748b; font-size: 0.85rem;">{{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}</td>
                  <td>
                    <div class="table-actions">
                      <button class="btn-action-sm btn-action-edit" onclick="openEditUserModal({{ $u->id }})">
                        Edit
                      </button>
                      @if($u->id !== $currentUser->id)
                        <button class="btn-action-sm btn-action-delete" onclick="deleteUser({{ $u->id }})">
                          Delete
                        </button>
                      @endif
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
    @endif

  </main>

  <!-- ============================================== -->
  <!-- MODAL: EDIT PROPERTY LISTING -->
  <!-- ============================================== -->
  <div class="modal-overlay" id="edit-property-modal">
    <div class="modal-dialog">
      <div class="modal-header">
        <h3 class="modal-title">Edit Property Listing</h3>
        <button class="modal-close-btn" onclick="closeEditModal()">&times;</button>
      </div>
      <form id="edit-property-form" enctype="multipart/form-data">
        <input type="hidden" id="edit_prop_id" name="id">
        
        <div class="modal-body">
          <!-- Step Tabs -->
          <div class="form-tabs">
            <button type="button" class="form-tab-btn active" id="tab-edit-btn-1" onclick="switchEditTab(1)">1. General</button>
            <button type="button" class="form-tab-btn" id="tab-edit-btn-2" onclick="switchEditTab(2)">2. Specs & Rates</button>
            <button type="button" class="form-tab-btn" id="tab-edit-btn-3" onclick="switchEditTab(3)">3. Photos & Links</button>
          </div>

          <!-- Edit Tab 1 -->
          <div class="form-tab-content active" id="tab-edit-content-1">
            <div class="form-group-custom">
              <label class="label-custom" for="edit_title">Listing Title *</label>
              <input type="text" id="edit_title" name="title" class="input-custom" required>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="edit_type">Property Category *</label>
                <select id="edit_type" name="type" class="select-custom" required>
                  <option value="Villa">Villa</option>
                  <option value="House">House</option>
                  <option value="Apartment">Apartment</option>
                  <option value="Condo">Condo</option>
                  <option value="Commercial">Commercial</option>
                </select>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="edit_purpose">Purpose *</label>
                <select id="edit_purpose" name="purpose" class="select-custom" required onchange="handleEditPurposeChange(this.value)">
                  <option value="buy">For Sale (Buy)</option>
                  <option value="rent">For Rent</option>
                </select>
              </div>
            </div>

            <div class="form-group-custom" id="edit-rental-type-container" style="display: none;">
              <label class="label-custom" for="edit_rental_type">Rental Format</label>
              <select id="edit_rental_type" name="rental_type" class="select-custom" onchange="handleEditRentalTypeChange(this.value)">
                <option value="long_term">Long-Term Residential Rental</option>
                <option value="short_term">Short-Term Vacation / Nightly Stay</option>
              </select>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="edit_price">Price ($ USD) *</label>
                <input type="number" id="edit_price" name="price" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom" id="edit-nightly-rate-box" style="display: none;">
                <label class="label-custom" for="edit_nightly_rate">Nightly Rate ($ USD)</label>
                <input type="number" id="edit_nightly_rate" name="nightly_rate" class="input-custom" min="0">
              </div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="edit_description">Description *</label>
              <textarea id="edit_description" name="description" class="textarea-custom" required></textarea>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom">Featured on Homepage</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" id="edit_featured" name="featured" value="1">
                  <span class="slider"></span>
                </label>
              </div>

              <div class="form-group-custom">
                <label class="label-custom">Published Status</label>
                <label class="switch-toggle" style="margin-top: 6px;">
                  <input type="checkbox" id="edit_is_published" name="is_published" value="1">
                  <span class="slider"></span>
                </label>
              </div>
            </div>
          </div>

          <!-- Edit Tab 2 -->
          <div class="form-tab-content" id="tab-edit-content-2">
            <div class="form-grid-3">
              <div class="form-group-custom">
                <label class="label-custom" for="edit_bedrooms">Bedrooms *</label>
                <input type="number" id="edit_bedrooms" name="bedrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="edit_bathrooms">Bathrooms *</label>
                <input type="number" step="0.5" id="edit_bathrooms" name="bathrooms" class="input-custom" min="0" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="edit_area">Area (sqft) *</label>
                <input type="number" id="edit_area" name="area" class="input-custom" min="0" required>
              </div>
            </div>

            <div class="form-grid-2">
              <div class="form-group-custom">
                <label class="label-custom" for="edit_yearBuilt">Year Built *</label>
                <input type="number" id="edit_yearBuilt" name="yearBuilt" class="input-custom" min="1800" max="2035" required>
              </div>

              <div class="form-group-custom">
                <label class="label-custom" for="edit_city">City *</label>
                <input type="text" id="edit_city" name="city" class="input-custom" required>
              </div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom" for="edit_location">Street Address *</label>
              <input type="text" id="edit_location" name="location" class="input-custom" required>
            </div>


            <div class="form-group-custom">
              <label class="label-custom" for="edit_features">Key Features (comma-separated)</label>
              <input type="text" id="edit_features" name="features" class="input-custom">
            </div>
          </div>

          <!-- Edit Tab 3 -->
          <div class="form-tab-content" id="tab-edit-content-3">
            <div class="form-group-custom">
              <label class="label-custom">Current Photo Gallery</label>
              <div class="preview-container" id="edit_existing_images_preview"></div>
            </div>

            <div class="form-group-custom">
              <label class="label-custom">Upload Additional Photos</label>
              <input type="file" id="edit_images" name="images[]" multiple accept="image/*" class="input-custom">
            </div>


            <div class="form-group-custom">
              <label class="label-custom" for="edit_agent_selection">Assigned Agent</label>
              <select id="edit_agent_selection" name="agent_selection" class="select-custom">
                <option value="keep" selected>-- Keep Current Agent --</option>
                <option value="sarah">Sarah Jenkins</option>
                <option value="michael">Michael Chen</option>
                <option value="emma">Emma Davis</option>
                <option value="custom">Custom Agent</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-secondary-custom" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="btn-add-action" id="btn-edit-submit">
            <span class="spinner-sm" id="spinner-edit-submit"></span>
            <span>Save Listing Changes</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ============================================== -->
  <!-- MODAL: ADD / EDIT USER (MAIN ADMIN) -->
  <!-- ============================================== -->
  @if($currentUser->isMainAdmin())
  <div class="modal-overlay" id="user-modal">
    <div class="modal-dialog sm">
      <div class="modal-header">
        <h3 class="modal-title" id="user-modal-title">Add Administrator User</h3>
        <button class="modal-close-btn" onclick="closeUserModal()">&times;</button>
      </div>
      <form id="user-form">
        <input type="hidden" id="user_form_id" name="id">
        <div class="modal-body">
          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_name">Full Name *</label>
            <input type="text" id="modal_user_name" name="name" class="input-custom" required>
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_email">Email Address *</label>
            <input type="email" id="modal_user_email" name="email" class="input-custom" required>
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_role">Portal Role *</label>
            <select id="modal_user_role" name="role" class="select-custom" required>
              <option value="staff">Staff / Operations Manager</option>
              <option value="agent">Listing Agent</option>
              <option value="main_admin">Main Administrator</option>
            </select>
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_phone">Phone Number</label>
            <input type="text" id="modal_user_phone" name="phone" class="input-custom">
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_status">Account Status</label>
            <select id="modal_user_status" name="status" class="select-custom">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="modal_user_password" id="modal_user_password_label">Password *</label>
            <input type="password" id="modal_user_password" name="password" class="input-custom">
            <span id="modal_user_password_hint" style="font-size: 0.75rem; color: #64748b; margin-top: 4px; display: none;">Leave blank to keep existing password.</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-secondary-custom" onclick="closeUserModal()">Cancel</button>
          <button type="submit" class="btn-add-action" id="btn-user-submit">
            <span class="spinner-sm" id="spinner-user-submit"></span>
            <span>Save User Account</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  @endif

  <!-- ============================================== -->
  <!-- MODAL: CURRENT USER PROFILE & PASSWORD -->
  <!-- ============================================== -->
  <div class="modal-overlay" id="profile-modal">
    <div class="modal-dialog sm">
      <div class="modal-header">
        <h3 class="modal-title">My Profile & Security</h3>
        <button class="modal-close-btn" onclick="closeProfileModal()">&times;</button>
      </div>
      <form id="profile-form">
        <div class="modal-body">
          <div class="form-group-custom">
            <label class="label-custom" for="profile_name">Full Name *</label>
            <input type="text" id="profile_name" name="name" class="input-custom" value="{{ $currentUser->name }}" required>
          </div>

          <div class="form-group-custom">
            <label class="label-custom">Email Address (Read-only)</label>
            <input type="email" class="input-custom" value="{{ $currentUser->email }}" disabled style="background: #f1f5f9;">
          </div>

          <div class="form-group-custom">
            <label class="label-custom" for="profile_phone">Contact Phone</label>
            <input type="text" id="profile_phone" name="phone" class="input-custom" value="{{ $currentUser->phone }}">
          </div>

          <div style="border-top: 1px solid #f1f5f9; margin-top: 1.2rem; padding-top: 1rem;">
            <div style="font-weight: 700; font-size: 0.9rem; color: #0f172a; margin-bottom: 0.8rem;">Change Password</div>
            <div class="form-group-custom">
              <label class="label-custom" for="profile_current_password">Current Password</label>
              <input type="password" id="profile_current_password" name="current_password" class="input-custom">
            </div>
            <div class="form-group-custom">
              <label class="label-custom" for="profile_new_password">New Password</label>
              <input type="password" id="profile_new_password" name="new_password" class="input-custom">
            </div>
            <div class="form-group-custom">
              <label class="label-custom" for="profile_new_password_confirmation">Confirm New Password</label>
              <input type="password" id="profile_new_password_confirmation" name="new_password_confirmation" class="input-custom">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-secondary-custom" onclick="closeProfileModal()">Cancel</button>
          <button type="submit" class="btn-add-action" id="btn-profile-submit">Save Profile</button>
        </div>
      </form>
    </div>
  </div>

  <div id="toast-container" class="toast-container"></div>

  <script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toast feedback helper
    function showToast(message) {
      const container = document.getElementById('toast-container');
      const toast = document.createElement('div');
      toast.className = 'toast-msg';
      toast.innerHTML = `
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>${message}</span>
      `;
      container.appendChild(toast);
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
      }, 3500);
    }

    // Sidebar Mobile Toggle
    function toggleSidebar() {
      document.getElementById('main-sidebar').classList.toggle('open');
    }

    // View Navigation Switcher
    function switchView(viewName) {
      document.querySelectorAll('.menu-item').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('.view-panel').forEach(panel => panel.classList.remove('active-view'));

      const titleEl = document.getElementById('page-title-text');
      const subtitleEl = document.getElementById('page-subtitle-text');

      if (viewName === 'overview') {
        const btn = document.getElementById('menu-btn-overview');
        if (btn) btn.classList.add('active');
        document.getElementById('view-panel-overview').classList.add('active-view');
        titleEl.textContent = 'Management Overview';
        subtitleEl.textContent = 'Monitor portfolio metrics, listings status, and administrator controls';
      } else if (viewName === 'properties') {
        const btn = document.getElementById('menu-btn-properties');
        if (btn) btn.classList.add('active');
        document.getElementById('view-panel-properties').classList.add('active-view');
        titleEl.textContent = 'Property Management';
        subtitleEl.textContent = 'Add, edit, unpublish, or delete real estate listings';
      } else if (viewName === 'rentals') {
        const btn = document.getElementById('menu-btn-rentals');
        if (btn) btn.classList.add('active');
        document.getElementById('view-panel-rentals').classList.add('active-view');
        titleEl.textContent = 'Short Term Rentals';
        subtitleEl.textContent = 'Manage vacation stays, nightly rates, capacity, and booking links';
      } else if (viewName === 'add-property') {
        const btn = document.getElementById('menu-btn-add-property');
        if (btn) btn.classList.add('active');
        document.getElementById('view-panel-add-property').classList.add('active-view');
        titleEl.textContent = 'Add Property Listing';
        subtitleEl.textContent = 'Create a premium database real estate listing';
        switchAddTab(1);
      } else if (viewName === 'add-short-rental') {
        document.getElementById('view-panel-add-short-rental').classList.add('active-view');
        titleEl.textContent = 'Create New Short-Term Rental';
        subtitleEl.textContent = 'Publish a vacation stay with nightly rates';
        switchRentalTab(1);
      } else if (viewName === 'users') {
        const btn = document.getElementById('menu-btn-users');
        if (btn) btn.classList.add('active');
        const panel = document.getElementById('view-panel-users');
        if (panel) {
          panel.classList.add('active-view');
          titleEl.textContent = 'User & Role Management';
          subtitleEl.textContent = 'Configure administrator access, staff roles, and status';
        }
      }

      // Close mobile sidebar if open
      document.getElementById('main-sidebar').classList.remove('open');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Tab switcher in Add Property Form
    function switchAddTab(step) {
      if (step === 2) {
        if (!document.getElementById('add_title').reportValidity()) return;
        if (!document.getElementById('add_price').reportValidity()) return;
      } else if (step === 3) {
        if (!document.getElementById('add_bedrooms').reportValidity()) return;
        if (!document.getElementById('add_bathrooms').reportValidity()) return;
        if (!document.getElementById('add_area').reportValidity()) return;
        if (!document.getElementById('add_yearBuilt').reportValidity()) return;
        if (!document.getElementById('add_city').reportValidity()) return;
        if (!document.getElementById('add_location').reportValidity()) return;
      }

      document.querySelectorAll('#view-panel-add-property .form-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('#view-panel-add-property .form-tab-content').forEach(c => c.classList.remove('active'));

      document.getElementById(`tab-add-btn-${step}`).classList.add('active');
      document.getElementById(`tab-add-content-${step}`).classList.add('active');
    }

    // Removed handleAddPurposeChange and handleAddRentalTypeChange

    function handleAddAgentChange(val) {
      const box = document.getElementById('add-custom-agent-box');
      box.style.display = (val === 'custom') ? 'block' : 'none';
    }

    // Previews for new property image upload
    let addFilesList = [];
    function renderAddImagePreviews(files) {
      addFilesList = Array.from(files);
      const container = document.getElementById('add_images_preview');
      container.innerHTML = '';

      addFilesList.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
          const div = document.createElement('div');
          div.className = 'preview-thumb-box';
          div.innerHTML = `
            <img src="${e.target.result}" alt="Preview">
            <button type="button" class="preview-remove-btn" onclick="removeAddFile(${index})">&times;</button>
          `;
          container.appendChild(div);
        };
        reader.readAsDataURL(file);
      });
    }

    function removeAddFile(idx) {
      addFilesList.splice(idx, 1);
      const dt = new DataTransfer();
      addFilesList.forEach(file => dt.items.add(file));
      document.getElementById('add_images').files = dt.files;
      renderAddImagePreviews(dt.files);
    }

    // Submit Add Property Form
    document.getElementById('add-property-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = document.getElementById('btn-add-submit');
      const spinner = document.getElementById('spinner-add-submit');
      btn.disabled = true;
      spinner.style.display = 'inline-block';

      const formData = new FormData(document.getElementById('add-property-form'));

      try {
        const res = await fetch('{{ url("/admin/properties") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message || 'Property added successfully!');
          setTimeout(() => window.location.reload(), 800);
        } else {
          showToast(data.message || 'Validation failed. Check your input values.');
          btn.disabled = false;
          spinner.style.display = 'none';
        }
      } catch (err) {
        console.error(err);
        showToast('Error connecting to server.');
        btn.disabled = false;
        spinner.style.display = 'none';
      }
    });

    // Filter properties table
    function filterPropertiesTable() {
      const q = document.getElementById('prop-search').value.toLowerCase();
      const city = document.getElementById('prop-filter-city').value;
      const type = document.getElementById('prop-filter-type').value;
      const purpose = document.getElementById('prop-filter-purpose').value;
      const status = document.getElementById('prop-filter-status').value;

      document.querySelectorAll('#properties-table-body tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        const rCity = row.getAttribute('data-city');
        const rType = row.getAttribute('data-type');
        const rPurpose = row.getAttribute('data-purpose');
        const rStatus = row.getAttribute('data-status');

        const matchQ = !q || text.includes(q);
        const matchCity = !city || rCity === city;
        const matchType = !type || rType === type;
        const matchPurpose = !purpose || rPurpose === purpose;
        const matchStatus = !status || rStatus === status;

        row.style.display = (matchQ && matchCity && matchType && matchPurpose && matchStatus) ? '' : 'none';
      });
    }

    // Toggle publish status via live switch
    async function togglePublish(id, chk) {
      try {
        const res = await fetch(`{{ url('/admin/properties') }}/${id}/toggle-publish`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          const badge = document.getElementById(`prop-badge-status-${id}`);
          if (badge) {
            badge.className = `badge badge-${data.is_published ? 'published' : 'draft'}`;
            badge.textContent = data.is_published ? 'Published' : 'Draft';
          }
          const row = document.getElementById(`prop-row-${id}`);
          if (row) {
            row.setAttribute('data-status', data.is_published ? 'published' : 'draft');
          }
        } else {
          showToast('Failed to update publish status.');
          chk.checked = !chk.checked;
        }
      } catch (err) {
        showToast('Error updating status.');
        chk.checked = !chk.checked;
      }
    }

    // Toggle featured status
    async function toggleFeatured(id, btn) {
      try {
        const res = await fetch(`{{ url('/admin/properties') }}/${id}/toggle-featured`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          if (data.featured) {
            btn.classList.add('badge-featured');
            btn.textContent = '★ Featured';
          } else {
            btn.classList.remove('badge-featured');
            btn.textContent = '☆ Standard';
          }
        }
      } catch (err) {
        showToast('Error updating featured status.');
      }
    }

    // Delete property
    async function deleteProperty(id) {
      if (!confirm('Are you sure you want to delete this property listing? This action cannot be undone.')) return;

      try {
        const res = await fetch(`{{ url('/admin/properties') }}/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          const r1 = document.getElementById(`prop-row-${id}`);
          const r2 = document.getElementById(`overview-prop-row-${id}`);
          const r3 = document.getElementById(`rental-row-${id}`);
          if (r1) r1.remove();
          if (r2) r2.remove();
          if (r3) r3.remove();
        } else {
          showToast(data.message || 'Failed to delete listing.');
        }
      } catch (err) {
        showToast('Error deleting listing.');
      }
    }

    // Edit Property Modal & Form Handlers
    let currentEditProperty = null;
    let retainedExistingImages = [];

    function switchEditTab(step) {
      document.querySelectorAll('#edit-property-modal .form-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('#edit-property-modal .form-tab-content').forEach(c => c.classList.remove('active'));
      document.getElementById(`tab-edit-btn-${step}`).classList.add('active');
      document.getElementById(`tab-edit-content-${step}`).classList.add('active');
    }

    function handleEditPurposeChange(val) {
      const container = document.getElementById('edit-rental-type-container');
      if (val === 'rent') {
        container.style.display = 'flex';
      } else {
        container.style.display = 'none';
        document.getElementById('edit_rental_type').value = 'long_term';
        handleEditRentalTypeChange('long_term');
      }
    }

    function handleEditRentalTypeChange(val) {
      const nightlyBox = document.getElementById('edit-nightly-rate-box');
      if (val === 'short_term') {
        nightlyBox.style.display = 'flex';
      } else {
        nightlyBox.style.display = 'none';
      }
    }

    async function openEditModal(id) {
      try {
        const res = await fetch(`{{ url('/admin/properties') }}/${id}`);
        const data = await res.json();
        if (!res.ok || !data.success) {
          showToast('Failed to load property details.');
          return;
        }

        const prop = data.property;
        currentEditProperty = prop;
        retainedExistingImages = Array.isArray(prop.images) ? [...prop.images] : [];

        // Pre-fill form fields
        document.getElementById('edit_prop_id').value = prop.id;
        document.getElementById('edit_title').value = prop.title || '';
        document.getElementById('edit_type').value = prop.type || 'Villa';
        document.getElementById('edit_purpose').value = prop.purpose || 'buy';
        document.getElementById('edit_price').value = prop.price || '';
        document.getElementById('edit_nightly_rate').value = prop.nightly_rate || '';
        document.getElementById('edit_description').value = prop.description || '';
        document.getElementById('edit_bedrooms').value = prop.bedrooms || 0;
        document.getElementById('edit_bathrooms').value = prop.bathrooms || 0;
        document.getElementById('edit_area').value = prop.area || 0;
        document.getElementById('edit_yearBuilt').value = prop.yearBuilt || 2022;
        document.getElementById('edit_city').value = prop.city || '';
        document.getElementById('edit_location').value = prop.location || '';
        document.getElementById('edit_features').value = Array.isArray(prop.features) ? prop.features.join(', ') : '';
        document.getElementById('edit_featured').checked = !!prop.featured;
        document.getElementById('edit_is_published').checked = !!prop.is_published;

        handleEditPurposeChange(prop.purpose);
        if (prop.purpose === 'rent') {
          document.getElementById('edit_rental_type').value = prop.rental_type || 'long_term';
          handleEditRentalTypeChange(prop.rental_type || 'long_term');
        }

        renderEditExistingImages();
        switchEditTab(1);
        document.getElementById('edit-property-modal').classList.add('open');
      } catch (err) {
        showToast('Error opening edit modal.');
      }
    }

    function renderEditExistingImages() {
      const container = document.getElementById('edit_existing_images_preview');
      container.innerHTML = '';
      retainedExistingImages.forEach((path, idx) => {
        const div = document.createElement('div');
        div.className = 'preview-thumb-box';
        div.innerHTML = `
          <img src="{{ asset('') }}${path}" alt="Photo">
          <button type="button" class="preview-remove-btn" onclick="removeExistingImage(${idx})">&times;</button>
        `;
        container.appendChild(div);
      });
    }

    function removeExistingImage(idx) {
      retainedExistingImages.splice(idx, 1);
      renderEditExistingImages();
    }

    function closeEditModal() {
      document.getElementById('edit-property-modal').classList.remove('open');
    }

    // Submit Edit Property Form
    document.getElementById('edit-property-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('edit_prop_id').value;
      const btn = document.getElementById('btn-edit-submit');
      const spinner = document.getElementById('spinner-edit-submit');

      btn.disabled = true;
      spinner.style.display = 'inline-block';

      const formData = new FormData(document.getElementById('edit-property-form'));
      // Append retained existing images
      retainedExistingImages.forEach(img => formData.append('existing_images[]', img));

      try {
        const res = await fetch(`{{ url('/admin/properties') }}/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message || 'Listing updated successfully!');
          closeEditModal();
          setTimeout(() => window.location.reload(), 700);
        } else {
          showToast(data.message || 'Update failed. Check your inputs.');
          btn.disabled = false;
          spinner.style.display = 'none';
        }
      } catch (err) {
        showToast('Error saving changes.');
        btn.disabled = false;
        spinner.style.display = 'none';
      }
    });

    // Tab switcher in Add Short Rental Form
    function switchRentalTab(step) {
      if (step === 2) {
        if (!document.getElementById('rental_title').reportValidity()) return;
        if (!document.getElementById('rental_nightly_rate').reportValidity()) return;
      } else if (step === 3) {
        if (!document.getElementById('rental_bedrooms').reportValidity()) return;
        if (!document.getElementById('rental_bathrooms').reportValidity()) return;
        if (!document.getElementById('rental_area').reportValidity()) return;
        if (!document.getElementById('rental_yearBuilt').reportValidity()) return;
        if (!document.getElementById('rental_city').reportValidity()) return;
        if (!document.getElementById('rental_location').reportValidity()) return;
      }

      document.querySelectorAll('#view-panel-add-short-rental .form-tab-btn').forEach(btn => btn.classList.remove('active'));
      document.querySelectorAll('#view-panel-add-short-rental .form-tab-content').forEach(c => c.classList.remove('active'));

      document.getElementById(`tab-rental-btn-${step}`).classList.add('active');
      document.getElementById(`tab-rental-content-${step}`).classList.add('active');
    }

    function handleRentalAgentChange(val) {
      const box = document.getElementById('rental-custom-agent-box');
      box.style.display = (val === 'custom') ? 'block' : 'none';
    }

    let rentalFilesList = [];
    function renderRentalImagePreviews(files) {
      rentalFilesList = Array.from(files);
      const container = document.getElementById('rental_images_preview');
      container.innerHTML = '';

      rentalFilesList.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
          const div = document.createElement('div');
          div.className = 'preview-thumb-box';
          div.innerHTML = `
            <img src="${e.target.result}" alt="Preview">
            <button type="button" class="preview-remove-btn" onclick="removeRentalFile(${index})">&times;</button>
          `;
          container.appendChild(div);
        };
        reader.readAsDataURL(file);
      });
    }

    function removeRentalFile(idx) {
      rentalFilesList.splice(idx, 1);
      const dt = new DataTransfer();
      rentalFilesList.forEach(file => dt.items.add(file));
      document.getElementById('rental_images').files = dt.files;
      renderRentalImagePreviews(dt.files);
    }

    // Submit Add Short Rental Form
    document.getElementById('add-short-rental-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = document.getElementById('btn-rental-submit');
      const spinner = document.getElementById('spinner-rental-submit');
      btn.disabled = true;
      spinner.style.display = 'inline-block';

      const formData = new FormData(document.getElementById('add-short-rental-form'));

      try {
        const res = await fetch('{{ url("/admin/properties") }}', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message || 'Short term rental added successfully!');
          setTimeout(() => window.location.reload(), 800);
        } else {
          showToast(data.message || 'Validation failed. Check your input values.');
          btn.disabled = false;
          spinner.style.display = 'none';
        }
      } catch (err) {
        console.error(err);
        showToast('Error connecting to server.');
        btn.disabled = false;
        spinner.style.display = 'none';
      }
    });

    // Shortcut to Add Short Rental
    function openAddShortRentalModal() {
      switchView('add-short-rental');
    }

    // ==========================================
    // USER MANAGEMENT JS (MAIN ADMIN ONLY)
    // ==========================================
    @if($currentUser->isMainAdmin())
    function openAddUserModal() {
      document.getElementById('user-form').reset();
      document.getElementById('user_form_id').value = '';
      document.getElementById('user-modal-title').textContent = 'Add New Administrator / Staff';
      document.getElementById('modal_user_password').required = true;
      document.getElementById('modal_user_password_hint').style.display = 'none';
      document.getElementById('user-modal').classList.add('open');
    }

    async function openEditUserModal(id) {
      try {
        const res = await fetch(`{{ url('/admin/users') }}/${id}`);
        const data = await res.json();
        if (!res.ok || !data.success) {
          showToast('Failed to load user details.');
          return;
        }

        const u = data.user;
        document.getElementById('user_form_id').value = u.id;
        document.getElementById('modal_user_name').value = u.name;
        document.getElementById('modal_user_email').value = u.email;
        document.getElementById('modal_user_role').value = u.role;
        document.getElementById('modal_user_phone').value = u.phone || '';
        document.getElementById('modal_user_status').value = u.status;
        document.getElementById('modal_user_password').value = '';
        document.getElementById('modal_user_password').required = false;
        document.getElementById('modal_user_password_hint').style.display = 'block';

        document.getElementById('user-modal-title').textContent = `Edit User: ${u.name}`;
        document.getElementById('user-modal').classList.add('open');
      } catch (err) {
        showToast('Error loading user.');
      }
    }

    function closeUserModal() {
      document.getElementById('user-modal').classList.remove('open');
    }

    document.getElementById('user-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('user_form_id').value;
      const btn = document.getElementById('btn-user-submit');
      const spinner = document.getElementById('spinner-user-submit');

      btn.disabled = true;
      spinner.style.display = 'inline-block';

      const formData = new FormData(document.getElementById('user-form'));
      const url = id ? `{{ url('/admin/users') }}/${id}` : `{{ url('/admin/users') }}`;

      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          closeUserModal();
          setTimeout(() => window.location.reload(), 700);
        } else {
          showToast(data.message || 'Error processing user request.');
          btn.disabled = false;
          spinner.style.display = 'none';
        }
      } catch (err) {
        showToast('Server error on user form submit.');
        btn.disabled = false;
        spinner.style.display = 'none';
      }
    });

    async function toggleUserStatus(id) {
      try {
        const res = await fetch(`{{ url('/admin/users') }}/${id}/toggle-status`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          setTimeout(() => window.location.reload(), 600);
        } else {
          showToast(data.message || 'Failed to toggle status.');
        }
      } catch (err) {
        showToast('Error changing user status.');
      }
    }

    async function deleteUser(id) {
      if (!confirm('Are you sure you want to permanently delete this user account?')) return;

      try {
        const res = await fetch(`{{ url('/admin/users') }}/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          }
        });
        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          const row = document.getElementById(`user-row-${id}`);
          if (row) row.remove();
        } else {
          showToast(data.message || 'Failed to delete user.');
        }
      } catch (err) {
        showToast('Error deleting user.');
      }
    }
    @endif

    // Profile Modal
    function openProfileModal() {
      document.getElementById('profile-modal').classList.add('open');
    }
    function closeProfileModal() {
      document.getElementById('profile-modal').classList.remove('open');
    }

    document.getElementById('profile-form').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(document.getElementById('profile-form'));

      try {
        const res = await fetch(`{{ route('admin.profile.update') }}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
          },
          body: formData
        });

        const data = await res.json();
        if (res.ok && data.success) {
          showToast(data.message);
          closeProfileModal();
          setTimeout(() => window.location.reload(), 800);
        } else {
          showToast(data.message || 'Failed to update profile.');
        }
      } catch (err) {
        showToast('Error updating profile.');
      }
    });
  </script>
</body>
</html>
