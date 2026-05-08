<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Security HTTP headers
 *
 * Adaugă headers de securitate pentru frontend.
 * Nu se aplică în WP admin (poate sparge plugin-uri).
 */
function kokoro_send_security_headers() {
    if (is_admin()) return;

    // Prevent clickjacking — disallow embedding in iframes from other origins
    header('X-Frame-Options: SAMEORIGIN');

    // Prevent MIME-type sniffing
    header('X-Content-Type-Options: nosniff');

    // Restrict referrer leakage to other origins
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Disable potentially dangerous browser features
    header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()');

    // HSTS — force HTTPS for 1 year (only on HTTPS)
    if (is_ssl()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    /**
     * Content-Security-Policy în mod Report-Only.
     *
     * Browser-ele NU blochează încălcările — doar le raportează în console.
     * După 1-2 zile de monitorizare în production (verifică dev tools console
     * pentru CSP violations pe paginile-cheie: front-page, page-pillar, contact,
     * inscriere), promovează la enforce schimbând header-ul în
     * `Content-Security-Policy:` (fără sufixul -Report-Only).
     *
     * 'unsafe-inline' pe style-src e necesar pentru inline `style="..."` din
     * șabloanele pillar; pe script-src pentru main.js inline data attributes.
     * Pentru enforce strict, aceste se pot înlocui cu nonces sau hash-uri.
     */
    $csp = implode('; ', [
        "default-src 'self'",
        "script-src 'self' 'unsafe-inline' https://www.youtube.com https://s.ytimg.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com data:",
        "img-src 'self' data: https:",
        "media-src 'self' https:",
        "connect-src 'self'",
        "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com https://maps.google.com https://www.google.com",
        "object-src 'none'",
        "base-uri 'self'",
        "form-action 'self'",
        "frame-ancestors 'self'",
        "upgrade-insecure-requests",
    ]);
    header('Content-Security-Policy-Report-Only: ' . $csp);
}
add_action('send_headers', 'kokoro_send_security_headers');
