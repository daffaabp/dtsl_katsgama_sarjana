document.addEventListener('DOMContentLoaded', loadDoc, false);

/**
 * Safely create and append style element
 * @param {string} cssText
 * @param {HTMLElement} target
 */
function createSafeStyle(cssText, target) {
    const style = document.createElement('style');
    style.textContent = cssText;
    target.appendChild(style);
}

/**
 * Safely create and append script element
 * @param {string} jsText
 * @param {HTMLElement} target
 */
function createSafeScript(jsText, target) {
    const script = document.createElement('script');
    script.textContent = jsText;
    target.appendChild(script);
}

/**
 * Create DOM elements safely
 * @param {string} html
 * @returns {DocumentFragment}
 */
function createSafeElements(html) {
    // Sanitize HTML by removing script tags and dangerous attributes
    const sanitizedHtml = sanitizeHtml(html);
    
    // Use DOMParser for safer HTML parsing
    const parser = new DOMParser();
    const doc = parser.parseFromString(sanitizedHtml, 'text/html');
    
    // Create fragment and move body children to it
    const fragment = document.createDocumentFragment();
    while (doc.body.firstChild) {
        fragment.appendChild(doc.body.firstChild);
    }
    
    return fragment;
}

/**
 * Basic HTML sanitization to prevent XSS
 * @param {string} html
 * @returns {string}
 */
function sanitizeHtml(html) {
    // Remove script tags and their content
    html = html.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '');
    // Remove dangerous event handlers
    html = html.replace(/\s*on\w+\s*=\s*["'][^"']*["']/gi, '');
    // Remove javascript: protocol
    html = html.replace(/javascript:/gi, '');
    return html;
}

/**
 * Validate if script content is safe debugbar script
 * @param {string} scriptContent
 * @returns {boolean}
 */
function isDebugbarScript(scriptContent) {
    // Check for known debugbar patterns and whitelist safe operations
    const safePatterns = [
        /ciDebugBar/,
        /debugbar/i,
        /toolbar/i,
        /console\.log/,
        /addEventListener/,
        /querySelector/
    ];
    
    // Reject dangerous patterns
    const dangerousPatterns = [
        /eval\s*\(/,
        /Function\s*\(/,
        /document\.write/,
        /innerHTML\s*=/,
        /location\s*=/,
        /window\.open/,
        /<script/i,
        /javascript:/i
    ];
    
    // Check for dangerous patterns first
    for (const pattern of dangerousPatterns) {
        if (pattern.test(scriptContent)) {
            return false;
        }
    }
    
    // Check for at least one safe pattern
    for (const pattern of safePatterns) {
        if (pattern.test(scriptContent)) {
            return true;
        }
    }
    
    // Default to safe for empty or very simple scripts
    return scriptContent.trim().length === 0 || scriptContent.trim().length < 50;
}

/**
 * Update history button safely
 * @param {string} debugbarTime
 */
function updateHistoryButton(debugbarTime) {
    const h2 = document.querySelector('#ci-history > h2');
    if (!h2) return;

    // Clear existing content
    h2.textContent = '';
    
    // Create text node
    h2.appendChild(document.createTextNode('History '));
    
    // Create small element
    const small = document.createElement('small');
    small.textContent = 'You have new debug data.';
    h2.appendChild(small);
    
    // Add space
    h2.appendChild(document.createTextNode(' '));
    
    // Create button
    const button = document.createElement('button');
    button.textContent = 'Update';
    button.addEventListener('click', () => loadDoc(debugbarTime));
    h2.appendChild(button);
    
    // Update badge
    const badge = document.querySelector('a[data-tab="ci-history"] > span > .badge');
    if (badge) {
        badge.className += ' active';
    }
}

function loadDoc(time) {
    if (isNaN(time)) {
        time = document.getElementById("debugbar_loader").getAttribute("data-time");
        localStorage.setItem('debugbar-time', time);
    }

    localStorage.setItem('debugbar-time-new', time);

    let url = '{url}';
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            let toolbar = document.getElementById("toolbarContainer");

            if (! toolbar) {
                toolbar = document.createElement('div');
                toolbar.setAttribute('id', 'toolbarContainer');
                document.body.appendChild(toolbar);
            }

            let responseText = this.responseText;
            let dynamicStyle = document.getElementById('debugbar_dynamic_style');
            let dynamicScript = document.getElementById('debugbar_dynamic_script');

            // Extract and apply styles safely
            let start = responseText.indexOf('>', responseText.indexOf('<style')) + 1;
            let end = responseText.indexOf('</style>', start);
            createSafeStyle(responseText.substr(start, end - start), dynamicStyle);
            responseText = responseText.substr(end + 8);

            // Extract and apply script safely with validation using regex
            const scriptTagPattern = /<script[^>]*>([\s\S]*?)<\/script>/i;
            const scriptMatch = responseText.match(scriptTagPattern);
            if (scriptMatch) {
                const fullMatch = scriptMatch[0];
                const scriptContent = scriptMatch[1];
                
                // Only allow known safe script content from debugbar
                if (isDebugbarScript(scriptContent)) {
                    createSafeScript(scriptContent, dynamicScript);
                }
                
                // Remove the processed script block from responseText
                responseText = responseText.replace(fullMatch, '');
            }

            // Handle last style block
            start = responseText.indexOf('>', responseText.indexOf('<style')) + 1;
            end = responseText.indexOf('</style>', start);
            createSafeStyle(responseText.substr(start, end - start), dynamicStyle);
            responseText = responseText.substr(0, start - 8);

            // Apply main content safely
            toolbar.textContent = ''; // Clear existing content
            toolbar.appendChild(createSafeElements(responseText));

            if (typeof ciDebugBar === 'object') {
                ciDebugBar.init();
            }
        } else if (this.readyState === 4 && this.status === 404) {
            console.log('CodeIgniter DebugBar: File "WRITEPATH/debugbar/debugbar_' + time + '" not found.');
        }
    };

    xhttp.open("GET", url + "?debugbar_time=" + time, true);
    xhttp.send();
}

window.oldXHR = window.ActiveXObject
    ? new ActiveXObject('Microsoft.XMLHTTP')
    : window.XMLHttpRequest;

function newXHR() {
    const realXHR = new window.oldXHR();

    realXHR.addEventListener("readystatechange", function() {
        // Only success responses and URLs that do not contains "debugbar_time" are tracked
        if (realXHR.readyState === 4 && realXHR.status.toString()[0] === '2' && realXHR.responseURL.indexOf('debugbar_time') === -1) {
            if (realXHR.getAllResponseHeaders().indexOf("Debugbar-Time") >= 0) {
                let debugbarTime = realXHR.getResponseHeader('Debugbar-Time');

                if (debugbarTime) {
                    updateHistoryButton(debugbarTime);
                }
            }
        }
    }, false);
    return realXHR;
}

window.XMLHttpRequest = newXHR;
