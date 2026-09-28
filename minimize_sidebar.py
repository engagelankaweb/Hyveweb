import re

file_path = r"c:\xampp\htdocs\Hyveweb\backend\resources\views\admin-dashboard.blade.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Inject CSS before </style>
css_to_add = """
    /* Sidebar Minimized Styles */
    .sidebar.minimized {
      width: 80px;
    }
    .sidebar.minimized .sidebar-brand {
      font-size: 0;
      justify-content: center;
      padding: 26px 0;
    }
    .sidebar.minimized .sidebar-brand .sidebar-role-badge {
      display: none;
    }
    .sidebar.minimized .menu-section-heading {
      display: none;
    }
    .sidebar.minimized .menu-item {
      font-size: 0;
      justify-content: center;
      padding: 12px 0;
    }
    .sidebar.minimized .menu-item svg {
      margin: 0;
    }
    .sidebar.minimized .sidebar-footer {
      padding: 18px 0;
      text-align: center;
    }
    .sidebar.minimized .sidebar-user-info {
      justify-content: center;
    }
    .sidebar.minimized .user-text-info {
      display: none;
    }
    .sidebar.minimized .btn-sidebar-logout {
      font-size: 0;
      padding: 9px 0;
    }
    .main-content.minimized {
      margin-left: 80px;
    }
    .sidebar-toggle-btn {
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px;
      border-radius: 50%;
      margin-right: 15px;
      transition: background 0.2s, color 0.2s;
    }
    .sidebar-toggle-btn:hover {
      background: rgba(0,0,0,0.05);
      color: #1e293b;
    }
"""
content = content.replace("  </style>", css_to_add + "\n  </style>")

# 2. Inject Toggle Button in Header
header_search = """    <header class="dashboard-header">
      <div class="header-title">"""

header_replace = """    <header class="dashboard-header">
      <div style="display: flex; align-items: center;">
        <button id="sidebar-toggle" class="sidebar-toggle-btn" title="Toggle Sidebar">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
        <div class="header-title">"""

content = content.replace(header_search, header_replace)
content = content.replace("      </div>\n      <div class=\"header-actions\">", "        </div>\n      </div>\n      <div class=\"header-actions\">")

# 3. Inject JS to handle the toggle
js_to_add = """
    // Sidebar Minimize Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if(sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('minimized');
        mainContent.classList.toggle('minimized');
        
        // Save state to localStorage
        if(sidebar.classList.contains('minimized')) {
          localStorage.setItem('sidebarMinimized', 'true');
        } else {
          localStorage.setItem('sidebarMinimized', 'false');
        }
      });
      
      // Load saved state
      if(localStorage.getItem('sidebarMinimized') === 'true') {
        sidebar.classList.add('minimized');
        mainContent.classList.add('minimized');
      }
    }
"""
content = content.replace("  </script>\n</body>", js_to_add + "\n  </script>\n</body>")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Modifications done.")
