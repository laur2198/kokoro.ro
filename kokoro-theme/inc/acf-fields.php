<?php
/**
 * ACF Field Groups — Kokoro Brașov Academy
 *
 * Bootstrap. Conținutul propriu al grupurilor a fost split-uit în inc/acf/
 * pe topic, pentru mentenabilitate (was 1904 LoC monolithic).
 *
 * Ordinea require-urilor stabilește ordinea de înregistrare la `acf/init` —
 * fiecare fișier înregistrează propriul callback `kokoro_acf_register_*`.
 *
 * Helpers (kokoro_setting, kokoro_render_italic_title, etc.) au fost mutate
 * în inc/helpers.php.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Înregistrează „Setări Kokoro" ca options page (date globale: contact,
 * social, etc.). Necesită SCF (Free, by WP Engine) sau ACF 6.2+ pentru
 * acf_add_options_page().
 */
function kokoro_register_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    acf_add_options_page([
        'page_title' => __('Setări Kokoro', 'kokoro'),
        'menu_title' => __('Setări Kokoro', 'kokoro'),
        'menu_slug'  => 'kokoro-settings',
        'icon_url'   => 'dashicons-admin-customizer',
        'position'   => 22,
        'capability' => 'edit_theme_options',
        'redirect'   => false,
    ]);
}
add_action('acf/init', 'kokoro_register_options_page');

/* ==========================================================================
   Field group registrations — split per topic în inc/acf/
   ========================================================================== */

require_once __DIR__ . '/acf/shared.php';          // FAQ shared
require_once __DIR__ . '/acf/seo.php';             // SEO override per page/post
require_once __DIR__ . '/acf/settings.php';        // Setări Globale (options)
require_once __DIR__ . '/acf/cpt-campion.php';     // CPT campion
require_once __DIR__ . '/acf/cpt-disciplina.php';  // CPT disciplina
require_once __DIR__ . '/acf/cpt-antrenor.php';    // CPT antrenor
require_once __DIR__ . '/acf/pillars.php';         // page-pillar.php template
require_once __DIR__ . '/acf/page-homepage.php';   // front-page.php (homepage)
require_once __DIR__ . '/acf/page-templates.php';  // celelalte page templates
