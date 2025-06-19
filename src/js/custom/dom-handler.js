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

    // Create element dengan sanitasi
    createElement(tag, attributes = {}, content = '') {
        const element = document.createElement(tag);
        
        // Sanitasi attributes
        Object.keys(attributes).forEach(key => {
            if (config.ALLOWED_ATTR.includes(key)) {
                element.setAttribute(key, DOMPurify.sanitize(attributes[key], config));
            }
        });

        // Sanitasi content
        if (content) {
            this.setInnerHTML(element, content);
        }

        return element;
    },

    // Event handler yang aman
    createSafeEventHandler(handler) {
        return function(event) {
            // Sanitasi input sebelum diproses
            if (event && event.target && event.target.value) {
                event.target.value = DOMPurify.sanitize(event.target.value, config);
            }
            return handler.call(this, event);
        };
    }
};

// Export untuk global use
window.safeDOM = safeDOM; 