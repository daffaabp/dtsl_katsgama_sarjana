// Import DOMPurify untuk sanitasi
import DOMPurify from 'dompurify';

// Definisikan fungsi sanitasi global
window.sanitizeHTML = (dirty) => {
    return DOMPurify.sanitize(dirty, {
        ALLOWED_TAGS: ['b', 'i', 'em', 'strong', 'a', 'p', 'div', 'span', 'ul', 'li', 'table', 'tr', 'td', 'th', 'thead', 'tbody'],
        ALLOWED_ATTR: ['href', 'target', 'class', 'id', 'style']
    });
};

// Import custom modules
import './custom/security.js';

// Import vendor scripts
import './vendor/alpine.js';
import './vendor/alpine-persist.js';

// Import helper
import { safeDOM } from './custom/dom-handler';

// Inisialisasi global helper
window.safeDOM = safeDOM;

// Event handler yang aman untuk form submit
document.addEventListener('DOMContentLoaded', () => {
    // Form submit handlers
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', safeDOM.createSafeEventHandler(function(e) {
            // Handle form submit
        }));
    });

    // Input change handlers
    document.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', safeDOM.createSafeEventHandler(function(e) {
            // Handle input change
        }));
    });

    // Button click handlers
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', safeDOM.createSafeEventHandler(function(e) {
            // Handle button click
        }));
    });
}); 