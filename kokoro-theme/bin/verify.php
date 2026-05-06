<?php
/**
 * Kokoro — Post-install verification script
 *
 * Verifică automat că toate componentele temei sunt populate corect.
 *
 * USAGE: wp eval-file wp-content/themes/kokoro-theme/bin/verify.php
 */

if (!defined('ABSPATH')) {
    $candidates = [__DIR__ . '/../../../../wp-load.php', __DIR__ . '/../../../wp-load.php'];
    foreach ($candidates as $w) { if (file_exists($w)) { require_once $w; break; } }
    if (!defined('ABSPATH')) die('Cannot locate wp-load.php');
    if (!current_user_can('manage_options')) die('Acces interzis.');
}

function k_check($label, $cond, $detail = '') {
    $icon = $cond ? '✓' : '✗';
    $msg = "  $icon $label" . ($detail ? " ($detail)" : '');
    if (defined('WP_CLI') && class_exists('WP_CLI')) {
        $cond ? WP_CLI::success($label) : WP_CLI::warning($label . ' ' . $detail);
    } else { echo esc_html($msg) . "<br>\n"; }
    return $cond;
}

echo "=== KOKORO INSTALL VERIFICATION ===\n\n";

// 1. ACF active
k_check('ACF plugin activ', function_exists('get_field'));

// 2. Pages exist
$required_pages = [
    'despre-noi', 'antrenori', 'discipline', 'orar', 'tarife',
    'campioni', 'galerie', 'contact', 'inscriere', 'faq',
    'formulare', 'regulament', 'calendar-competitional',
];
foreach ($required_pages as $slug) {
    $p = get_page_by_path($slug);
    k_check("Pagina /$slug/", $p && $p->post_status === 'publish', $p ? "ID $p->ID" : 'lipsește');
}

// 3. CPT entries populated
$cpts = ['antrenor' => 4, 'disciplina' => 4, 'campion' => 23];
foreach ($cpts as $type => $expected) {
    $count = wp_count_posts($type)->publish ?? 0;
    k_check("CPT $type entries: $count (așteptat $expected)", $count >= $expected);
}

// 4. Tarife pachete populated
$tarife_page = get_page_by_path('tarife');
if ($tarife_page) {
    $pachete = get_field('tarife_pachete', $tarife_page->ID);
    k_check('Tarife pachete populate', is_array($pachete) && count($pachete) >= 3, 'count: ' . (is_array($pachete) ? count($pachete) : 0));
}

// 5. Orar program populated
$orar_page = get_page_by_path('orar');
if ($orar_page) {
    $program = get_field('orar_program', $orar_page->ID);
    k_check('Orar program populat', is_array($program) && count($program) >= 20, 'sesiuni: ' . (is_array($program) ? count($program) : 0));
}

// 6. FAQ categorii
$faq_page = get_page_by_path('faq');
if ($faq_page) {
    $cat = get_field('faq_categorii', $faq_page->ID);
    k_check('FAQ categorii populate', is_array($cat) && count($cat) >= 5, 'categorii: ' . (is_array($cat) ? count($cat) : 0));
}

// 7. Settings (options page)
$telefon = get_field('set_telefon', 'option');
k_check('Telefon setat', !empty($telefon), $telefon ?: 'gol');
$wa = get_field('set_whatsapp_numar', 'option');
k_check('WhatsApp setat', !empty($wa), $wa ?: 'gol');

// 8. Image folders
$theme_dir = get_stylesheet_directory();
k_check('Folder antrenori/ există', is_dir($theme_dir . '/assets/images/antrenori'));
k_check('Folder campioni/ există', is_dir($theme_dir . '/assets/images/campioni'));

// 9. seed.php should be deleted (security)
$seed_exists = file_exists($theme_dir . '/bin/seed.php');
k_check('bin/seed.php ȘTERS (securitate)', !$seed_exists, $seed_exists ? '⚠ ÎNCĂ EXISTĂ — șterge-l!' : '');

// 10. SSL
k_check('SSL/HTTPS activ', is_ssl());

echo "\n=== VERIFICATION DONE ===\n";
