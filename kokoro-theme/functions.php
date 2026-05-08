<?php
/**
 * Kokoro Brașov Academy — Theme Functions
 *
 * @package Kokoro
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

define('KOKORO_VERSION', '1.0.0');
define('KOKORO_DIR', get_template_directory());
define('KOKORO_URI', get_template_directory_uri());

/* ==========================================================================
   0. Includes
   ========================================================================== */

require_once KOKORO_DIR . '/inc/cpt.php';
require_once KOKORO_DIR . '/inc/helpers.php';            // kokoro_setting, kokoro_render_italic_title, kokoro_strip_honorific etc.
require_once KOKORO_DIR . '/inc/acf-fields.php';         // bootstrap: require inc/acf/*.php
require_once KOKORO_DIR . '/inc/forms.php';
require_once KOKORO_DIR . '/inc/seo-meta.php';          // <head> meta tags + title filter
require_once KOKORO_DIR . '/inc/seo-schemas.php';       // JSON-LD schema generators (split din seo-meta)
require_once KOKORO_DIR . '/inc/security-headers.php';
require_once KOKORO_DIR . '/inc/acf-pages-extra.php';
require_once KOKORO_DIR . '/inc/activation.php';        // theme activation: create default pages

/* ==========================================================================
   1. Theme Setup
   ========================================================================== */

function kokoro_setup() {
    // Translations — kokoro.pot/.mo în /languages
    load_theme_textdomain('kokoro', KOKORO_DIR . '/languages');

    // Title tag — emis de WP. Conținutul real e setat de filtrul
    // kokoro_filter_document_title (inc/seo-meta.php) la prioritate 1,
    // ca plugin-urile SEO (SiteSEO etc.) să poată suprascrie la prioritate 10.
    add_theme_support('title-tag');

    // Auto RSS feed links
    add_theme_support('automatic-feed-links');

    // Post thumbnails
    add_theme_support('post-thumbnails');
    add_image_size('kokoro-hero', 1920, 1080, true);
    add_image_size('kokoro-card', 600, 400, true);
    add_image_size('kokoro-square', 600, 600, true);

    // HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Custom logo
    add_theme_support('custom-logo', [
        'height'      => 120,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // Block editor (Gutenberg)
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('core-block-patterns');

    // Navigation menus
    register_nav_menus([
        'primary'  => __('Meniu Principal', 'kokoro'),
        'footer'   => __('Meniu Footer', 'kokoro'),
        'social'   => __('Social Media', 'kokoro'),
    ]);

    // Editor styles
    add_editor_style('assets/css/main.css');
}
add_action('after_setup_theme', 'kokoro_setup');

/* ==========================================================================
   2. Enqueue Styles & Scripts
   ========================================================================== */

function kokoro_enqueue_assets() {
    // Google Fonts — Barlow Condensed + Barlow + Noto Serif JP (kanji)
    wp_enqueue_style(
        'kokoro-google-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700;1,800;1,900&family=Barlow:wght@400;500;600;700&family=Noto+Serif+JP:wght@700;900&display=swap',
        [],
        null
    );

    // Theme stylesheet (style.css — CSS variables)
    wp_enqueue_style(
        'kokoro-variables',
        get_stylesheet_uri(),
        [],
        KOKORO_VERSION
    );

    // CSS Modules (loaded individually for performance)
    $css_modules = ['reset', 'typography', 'components', 'japanese', 'responsive'];
    foreach ($css_modules as $module) {
        wp_enqueue_style(
            'kokoro-' . $module,
            KOKORO_URI . '/assets/css/' . $module . '.css',
            ['kokoro-variables', 'kokoro-google-fonts'],
            KOKORO_VERSION
        );
    }

    // Main script — in_footer + defer (parsing parallelism, WP 6.3+ strategy API)
    wp_enqueue_script(
        'kokoro-main',
        KOKORO_URI . '/assets/js/main.js',
        [],
        KOKORO_VERSION,
        ['strategy' => 'defer', 'in_footer' => true]
    );

    // Pass data to JS
    wp_localize_script('kokoro-main', 'kokoroData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'siteUrl' => home_url('/'),
        'nonce'   => wp_create_nonce('kokoro_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'kokoro_enqueue_assets');

/**
 * Preconnect la Google Fonts — TTFB -200-300ms pe conexiuni reci.
 * Browser-ul deschide TCP+TLS la fonts.gstatic.com în paralel cu parsing-ul HTML,
 * deci WOFF2 fetch-ul nu așteaptă întoarcerea CSS-ului.
 */
function kokoro_resource_hints($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = ['href' => 'https://fonts.googleapis.com'];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous'];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'kokoro_resource_hints', 10, 2);

/* ==========================================================================
   3. Custom Nav Walker
   ========================================================================== */

class Kokoro_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<ul class=\"kokoro-submenu\">\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'kokoro-menu__item';

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'kokoro-menu__item--active';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'kokoro-menu__item--has-children';
        }

        $class_names = implode(' ', array_filter($classes));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts = [];
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'kokoro-menu__link';

        if ($item->current) {
            $atts['aria-current'] = 'page';
        }

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);

        $item_output  = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . $title . ($args->link_after ?? '');
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Walker simplu pentru meniul din footer: emite doar <a class="footer__link">,
 * fără <li>/<ul>. Folosit în footer.php cu items_wrap = '%3$s'.
 */
class Kokoro_Footer_Link_Walker extends Walker_Nav_Menu {

    public function start_lvl(&$output, $depth = 0, $args = null) { /* no submenu */ }
    public function end_lvl(&$output, $depth = 0, $args = null)   { /* no submenu */ }
    public function end_el(&$output, $item, $depth = 0, $args = null) { /* no </li> */ }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $url   = !empty($item->url) ? $item->url : '';
        $title = apply_filters('the_title', $item->title, $item->ID);
        $output .= sprintf(
            '<a href="%s" class="footer__link">%s</a>',
            esc_url($url),
            esc_html($title)
        );
    }
}

/* ==========================================================================
   4. Widget Areas
   ========================================================================== */

function kokoro_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Col 1', 'kokoro'),
        'id'            => 'footer-1',
        'before_widget' => '<div class="kokoro-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="kokoro-widget__title">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Col 2', 'kokoro'),
        'id'            => 'footer-2',
        'before_widget' => '<div class="kokoro-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="kokoro-widget__title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'kokoro_widgets_init');

/* ==========================================================================
   5. Helper Functions
   ========================================================================== */

/**
 * Get footer disciplines (cached 1h). Invalidat automat la save_post_disciplina
 * via version bump în option `kokoro_disc_ver` — fără DB scan pe transient_*.
 *
 * Rulează pe FIECARE pagină (footer e global), deci cache-ul e critic pentru
 * a evita 5+ queries per request uncached.
 *
 * @param int $limit
 * @return WP_Post[]
 */
function kokoro_get_footer_disciplines($limit) {
    $limit  = max(1, (int) $limit);
    $ver    = (int) get_option('kokoro_disc_ver', 1);
    $key    = 'kokoro_footer_disc_v' . $ver . '_l' . $limit;
    $cached = get_transient($key);
    if (is_array($cached)) {
        return $cached;
    }
    $posts = get_posts([
        'post_type'              => 'disciplina',
        'posts_per_page'         => $limit,
        'post_status'            => 'publish',
        'orderby'                => 'menu_order title',
        'order'                  => 'ASC',
        'no_found_rows'          => true,
        'update_post_term_cache' => false,
    ]);
    set_transient($key, $posts, HOUR_IN_SECONDS);
    return $posts;
}

/**
 * Bump version → invalidates all footer-disc caches instantly (no DB scan).
 */
function kokoro_bump_disc_cache() {
    update_option('kokoro_disc_ver', (int) get_option('kokoro_disc_ver', 1) + 1, false);
}
add_action('save_post_disciplina', 'kokoro_bump_disc_cache');
add_action('deleted_post',         'kokoro_bump_disc_cache'); // covers any post deletion incl. disciplina

/* ==========================================================================
   Sticky CTA bar (mobile-only) pe paginile-cheie de conversie
   ========================================================================== */

/**
 * Pagini unde apare sticky CTA bar (telefon + WhatsApp).
 *
 * @return string[] Listă de slug-uri.
 */
function kokoro_sticky_cta_slugs() {
    $slugs = [
        'inscriere',
        'tarife',
        'contact',
        'ju-jitsu-copii-brasov',
        'arte-martiale-copii-brasov',
        'autoaparare-copii-brasov',
    ];
    /**
     * Filter the slugs where the sticky mobile CTA bar appears.
     *
     * @param string[] $slugs Lista de slug-uri (post_name) unde bara apare.
     */
    return apply_filters('kokoro_sticky_cta_slugs', $slugs);
}

function kokoro_is_sticky_cta_page() {
    if (!is_page()) return false;
    return in_array(get_post_field('post_name'), kokoro_sticky_cta_slugs(), true);
}

/**
 * Adaugă body class când pagina merită sticky CTA — CSS-ul folosește clasa
 * pentru a adăuga padding-bottom la body (anti-overlap).
 */
function kokoro_body_class_sticky_cta($classes) {
    if (kokoro_is_sticky_cta_page()) {
        $classes[] = 'kokoro-has-sticky-cta';
    }
    return $classes;
}
add_filter('body_class', 'kokoro_body_class_sticky_cta');

/**
 * Render sticky CTA bar — vizibil doar pe mobile (≤768px) via CSS.
 * Conține 2 butoane CTA: phone + WhatsApp. Respectă safe-area-inset-bottom.
 */
function kokoro_render_sticky_cta() {
    if (!kokoro_is_sticky_cta_page()) return;

    $tel  = kokoro_setting('telefon', '+40 742 037 973');
    $tel_e164 = function_exists('kokoro_phone_to_e164')
        ? kokoro_phone_to_e164($tel)
        : '+' . preg_replace('/\D/', '', $tel);

    $wa = preg_replace('/\D/', '', kokoro_setting('whatsapp_numar', '40742037973'));
    if ($wa === '') $wa = '40742037973';
    ?>
    <div class="kokoro-sticky-cta" role="region" aria-label="<?php esc_attr_e('Contact rapid', 'kokoro'); ?>">
        <a href="tel:<?php echo esc_attr($tel_e164); ?>" class="kokoro-sticky-cta__btn kokoro-sticky-cta__btn--phone">
            <span class="kokoro-sticky-cta__icon" aria-hidden="true">📞</span>
            <span><?php esc_html_e('Sună acum', 'kokoro'); ?></span>
        </a>
        <a href="https://wa.me/<?php echo esc_attr($wa); ?>" target="_blank" rel="noopener" class="kokoro-sticky-cta__btn kokoro-sticky-cta__btn--wa">
            <span class="kokoro-sticky-cta__icon" aria-hidden="true">💬</span>
            <span><?php esc_html_e('WhatsApp', 'kokoro'); ?></span>
        </a>
    </div>
    <?php
}
add_action('wp_footer', 'kokoro_render_sticky_cta', 50);

/**
 * URL canonic pentru un antrenor — folosit ca @id în schema.org Person/Course.instructor.
 *
 * Strategy: ANTRENORII sunt entități canonice. Campionii care sunt și antrenori
 * (cazul Adi) referențiază prin sameAs. Pillar inline schemas folosesc @id ref,
 * nu Person inline cu nume duplicat.
 *
 * @param string $slug Slug-ul postului antrenor (ex. „sensei-lucian-boglut", „sempai-adrian", „sempai-dan").
 * @return string URL absolut cu fragment #person.
 */
function kokoro_antrenor_canonical_id($slug) {
    return home_url('/antrenor/' . sanitize_title($slug) . '/') . '#person';
}

/**
 * Get SVG icon from assets/images folder
 */
function kokoro_svg($name) {
    $path = KOKORO_DIR . '/assets/images/' . $name . '.svg';
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return '';
}

/**
 * Custom excerpt length
 */
function kokoro_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'kokoro_excerpt_length');

function kokoro_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'kokoro_excerpt_more');

/* ==========================================================================
   6. Theme Activation — mutat în inc/activation.php
   ========================================================================== */

/* ==========================================================================
   7. ACF Plugin Dependency Notice
   ========================================================================== */

function kokoro_acf_admin_notice() {
    if (function_exists('get_field')) return;
    if (!current_user_can('activate_plugins')) return;

    $install_url = wp_nonce_url(
        self_admin_url('update.php?action=install-plugin&plugin=advanced-custom-fields'),
        'install-plugin_advanced-custom-fields'
    );
    $plugins_url = self_admin_url('plugins.php');
    ?>
    <div class="notice notice-error">
        <p>
            <strong><?php esc_html_e('Kokoro Brașov Academy', 'kokoro'); ?></strong> —
            <?php esc_html_e('tema necesită plugin-ul Advanced Custom Fields (ACF) pentru a funcționa corect. Conținutul paginilor (texte, imagini, setări) nu va putea fi editat fără el.', 'kokoro'); ?>
        </p>
        <p>
            <a href="<?php echo esc_url($install_url); ?>" class="button button-primary"><?php esc_html_e('Instalează ACF', 'kokoro'); ?></a>
            <a href="<?php echo esc_url($plugins_url); ?>" class="button"><?php esc_html_e('Pagina Plugin-uri', 'kokoro'); ?></a>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'kokoro_acf_admin_notice');

/* ==========================================================================
   8. Security & Cleanup
   ========================================================================== */

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
