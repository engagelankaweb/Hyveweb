// =========================================
// PROPERTY DATA LOADER
// =========================================
// Dynamically loads live properties from the Laravel database backend.
// Falls back to static mock data if running offline / file:// protocol or on static hosts.

(function() {
    let scriptUrl = 'js/properties.mock.js';

    // Check if we are running over HTTP/HTTPS (not file:// and not github.io)
    const isHttp = window.location.protocol === 'http:' || window.location.protocol === 'https:';
    const isGitHub = window.location.hostname.includes('github.io');

    if (isHttp && !isGitHub) {
        // Resolve the base path of the current site (handles root domain, /Hyveweb/, /newdesign/, etc.)
        let pathname = window.location.pathname;
        let baseDir = '';

        if (pathname.includes('/backend/public/')) {
            baseDir = pathname.substring(0, pathname.indexOf('/backend/public/') + '/backend/public/'.length);
        } else if (pathname.includes('/newdesign/')) {
            baseDir = pathname.substring(0, pathname.indexOf('/newdesign/') + '/newdesign/'.length);
        } else if (pathname.includes('/Hyveweb/')) {
            baseDir = pathname.substring(0, pathname.indexOf('/Hyveweb/') + '/Hyveweb/'.length);
        } else if (pathname === '/Hyveweb') {
            baseDir = '/Hyveweb/';
        } else {
            baseDir = pathname.substring(0, pathname.lastIndexOf('/') + 1);
            if (!baseDir.endsWith('/')) {
                baseDir += '/';
            }
        }

        // Cache-buster timestamp ensures newly added/updated properties from the admin panel show instantly
        scriptUrl = baseDir + 'api/properties-data.js?t=' + Date.now();
    }

    // Synchronously write the script tag so propertiesData is immediately available for filters.js
    // Also include a fallback error handler in case network or backend fails
    document.write(
        '<script src="' + scriptUrl + '" onerror="if(typeof propertiesData===\'undefined\'){console.warn(\'Failed to load live properties from API, loading mock data fallback.\');var s=document.createElement(\'script\');s.src=\'js/properties.mock.js\';document.head.appendChild(s);}"><\/script>'
    );
})();
