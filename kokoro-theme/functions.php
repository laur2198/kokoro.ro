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
require_once KOKORO_DIR . '/inc/acf-fields.php';
require_once KOKORO_DIR . '/inc/forms.php';
require_once KOKORO_DIR . '/inc/seo-meta.php';

/* ==========================================================================
   1. Theme Setup
   ========================================================================== */

function kokoro_setup() {
    // Title tag — gestionat manual de inc/seo-meta.php (kokoro_render_seo_meta).
    // NU adăugăm 'title-tag' ca să evităm dublarea în <head>.

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

    // Main script
    wp_enqueue_script(
        'kokoro-main',
        KOKORO_URI . '/assets/js/main.js',
        [],
        KOKORO_VERSION,
        true
    );

    // Pass data to JS
    wp_localize_script('kokoro-main', 'kokoroData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'siteUrl' => home_url('/'),
        'nonce'   => wp_create_nonce('kokoro_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'kokoro_enqueue_assets');

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
   6. Theme Activation — Create Default Pages
   ========================================================================== */

function kokoro_activate() {
    // [slug => [title, template_filename or null]]
    $pages = [
        'despre-noi' => ['Despre Noi',         'page-despre-noi.php'],
        'antrenori'  => ['Antrenori',          'page-antrenori.php'],
        'campioni'   => ['Campioni',           'page-campioni.php'],
        'discipline' => ['Discipline',         'page-discipline.php'],
        'orar'       => ['Orar',               'page-orar.php'],
        'tarife'     => ['Tarife',             'page-tarife.php'],
        'inscriere'  => ['Înscriere',          'page-inscriere.php'],
        'galerie'    => ['Galerie',            'page-galerie.php'],
        'contact'    => ['Contact',            'page-contact.php'],
    ];

    foreach ($pages as $slug => [$title, $template]) {
        if (!get_page_by_path($slug)) {
            $page_id = wp_insert_post([
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);
            if ($page_id && !is_wp_error($page_id) && $template) {
                update_post_meta($page_id, '_wp_page_template', $template);
            }
        }
    }

    // Front page: creează „Acasă" doar dacă nu există deja, apoi setează ca front static.
    $front = get_page_by_path('acasa');
    if (!$front) {
        $front_id = wp_insert_post([
            'post_title'  => 'Acasă',
            'post_name'   => 'acasa',
            'post_status' => 'publish',
            'post_type'   => 'page',
        ]);
    } else {
        $front_id = $front->ID;
    }
    if ($front_id && !is_wp_error($front_id)) {
        update_option('page_on_front', $front_id);
        update_option('show_on_front', 'page');
    }

    // Permalinks rewrite — necesar pentru CPT-urile noi (campion/disciplina/antrenor)
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'kokoro_activate');

/* ==========================================================================
   7. Security & Cleanup
   ========================================================================== */

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
