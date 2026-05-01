<?php
if (!defined('ABSPATH')) { exit; }

/**
 * Security HTTP headers
 *
 * Adaugă headers de securitate pentru frontend.
 * Nu se aplică în WP admin (poate sparge plugin-uri).
 */
add_action('send_headers', function () {
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
});
