// =========================================
// PROPERTY DATA LOADER
// =========================================
// This script dynamically selects the source of property data depending on where the site is hosted.
// - On GitHub Pages (or static hosts), it loads the static mock data.
// - On Laravel backend (port 8000 or production), it fetches the dynamic data from the database.

(function() {
    let scriptUrl = 'js/properties.mock.js';
    
    // Detect if we are running on the Laravel backend (local dev server on 8000 or a production backend)
    const hostname = window.location.hostname;
    const port = window.location.port;
    
    // If it's localhost:8000 or 127.0.0.1:8000 (Laravel dev server)
    if (port === '8000' || (hostname === '127.0.0.1' && port !== '80')) {
        scriptUrl = '/api/properties-data.js';
    } 
    // Otherwise, if it's NOT github pages and NOT xampp (localhost without port 8000), assume production Laravel
    else if (!hostname.includes('github.io') && hostname !== 'localhost' && hostname !== '127.0.0.1') {
        scriptUrl = '/api/properties-data.js';
    }

    // Synchronously write the script tag so propertiesData is available immediately for filters.js
    document.write('<script src="' + scriptUrl + '"></script>');
})();
