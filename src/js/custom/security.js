// Import DOMPurify
import DOMPurify from 'dompurify';

// Konfigurasi DOMPurify
const config = {
    ALLOWED_TAGS: [
        'b', 'i', 'em', 'strong', 'a', 'p', 'div', 'span',
        'ul', 'li', 'table', 'tr', 'td', 'th', 'thead', 'tbody'
    ],
    ALLOWED_ATTR: ['href', 'target', 'class', 'id', 'style']
};

// Helper untuk manipulasi DOM yang aman
export const safeDOM = {
    // Set innerHTML dengan sanitasi
    setInnerHTML(element, content) {
        if (!element) return;
        element.innerHTML = DOMPurify.sanitize(content, config);
    },

    // Set outerHTML dengan sanitasi
    setOuterHTML(element, content) {
        if (!element) return;
        element.outerHTML = DOMPurify.sanitize(content, config);
    },

    // Insert adjacent HTML dengan sanitasi
    insertAdjacentHTML(element, position, content) {
        if (!element) return;
        element.insertAdjacentHTML(position, DOMPurify.sanitize(content, config));
    },

    // Create safe event handler
    createSafeEventHandler(handler) {
        return function(event) {
            // Sanitasi input sebelum diproses
            if (event && event.target && event.target.value) {
                event.target.value = DOMPurify.sanitize(event.target.value, config);
            }
            return handler.call(this, event);
        };
    },

    // Sanitasi URL
    sanitizeURL(url) {
        if (!url) return '';
        // Hanya izinkan protokol http dan https
        if (!/^https?:\/\//i.test(url)) {
            return '';
        }
        return DOMPurify.sanitize(url, {
            ALLOWED_TAGS: [],
            ALLOWED_ATTR: []
        });
    },

    // Sanitasi JSON
    sanitizeJSON(json) {
        try {
            const parsed = typeof json === 'string' ? JSON.parse(json) : json;
            return JSON.stringify(parsed, (key, value) => {
                if (typeof value === 'string') {
                    return DOMPurify.sanitize(value, config);
                }
                return value;
            });
        } catch (e) {
            console.error('Error sanitizing JSON:', e);
            return '{}';
        }
    },

    // Sanitasi form data
    sanitizeFormData(formData) {
        const sanitized = new FormData();
        for (const [key, value] of formData.entries()) {
            if (typeof value === 'string') {
                sanitized.append(key, DOMPurify.sanitize(value, config));
            } else {
                sanitized.append(key, value);
            }
        }
        return sanitized;
    },

    // Sanitasi query string
    sanitizeQueryString(queryString) {
        const params = new URLSearchParams(queryString);
        const sanitized = new URLSearchParams();
        for (const [key, value] of params.entries()) {
            sanitized.append(key, DOMPurify.sanitize(value, config));
        }
        return sanitized.toString();
    },

    // Sanitasi attribute
    sanitizeAttribute(value) {
        return DOMPurify.sanitize(value, {
            ALLOWED_TAGS: [],
            ALLOWED_ATTR: []
        });
    }
};

// Export untuk global use
window.safeDOM = safeDOM; 