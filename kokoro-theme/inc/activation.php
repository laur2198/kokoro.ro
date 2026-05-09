<?php
/**
 * Theme activation — creează paginile default cu template-uri assignate.
 *
 * Hook: `after_switch_theme` (rulează o singură dată la activare).
 * Idempotent: paginile existente (după slug) NU sunt suprascrise.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_activate() {
    // [slug => [title, template_filename, noindex_flag (default false)]]
    $pages = [
        'despre-noi'           => ['Despre Noi',         'page-despre-noi.php', false],
        'antrenori'            => ['Antrenori',          'page-antrenori.php',  false],
        'campioni'             => ['Campioni',           'page-campioni.php',   false],
        'discipline'           => ['Discipline',         'page-discipline.php', false],
        'orar'                 => ['Orar',               'page-orar.php',       false],
        'tarife'               => ['Tarife',             'page-tarife.php',     false],
        'inscriere'            => ['Înscriere',          'page-inscriere.php',  false],
        'galerie'              => ['Galerie',            'page-galerie.php',    false],
        'contact'              => ['Contact',            'page-contact.php',    false],
        // Thank-you page — never index (B5 Faza 8)
        'multumesc-inscriere'  => ['Mulțumim — Înscriere', 'page-multumesc-inscriere.php', true],
    ];

    foreach ($pages as $slug => [$title, $template, $noindex]) {
        if (!get_page_by_path($slug)) {
            $page_id = wp_insert_post([
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ]);
            if ($page_id && !is_wp_error($page_id)) {
                if ($template) {
                    update_post_meta($page_id, '_wp_page_template', $template);
                }
                if ($noindex && function_exists('update_field')) {
                    update_field('kokoro_seo_noindex', true, $page_id);
                }
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
