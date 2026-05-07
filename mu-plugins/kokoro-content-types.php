<?php
/**
 * Plugin Name: Kokoro — Content Types
 * Description: Înregistrează CPT-urile Kokoro Brașov Academy (campion, disciplina, antrenor) la nivel de must-use plugin, ca să supraviețuiască schimbării temei. Decuplează conținutul de prezentare.
 * Version: 1.0.0
 * Author: Kokoro Brașov
 * License: GPL-2.0-or-later
 *
 * IMPORTANT: Acest fișier merge în wp-content/mu-plugins/ (NU în /plugins/).
 * Mu-plugins se încarcă automat și nu pot fi dezactivate din admin.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Campion — sportiv al academiei cu palmares.
 */
function kokoro_register_campion_cpt() {
    if (post_type_exists('campion')) {
        return;
    }

    $labels = [
        'name'               => __('Campioni', 'kokoro'),
        'singular_name'      => __('Campion', 'kokoro'),
        'menu_name'          => __('Campioni', 'kokoro'),
        'name_admin_bar'     => __('Campion', 'kokoro'),
        'add_new'            => __('Adaugă Campion', 'kokoro'),
        'add_new_item'       => __('Adaugă Campion Nou', 'kokoro'),
        'new_item'           => __('Campion Nou', 'kokoro'),
        'edit_item'          => __('Editează Campion', 'kokoro'),
        'view_item'          => __('Vezi Campion', 'kokoro'),
        'all_items'          => __('Toți Campionii', 'kokoro'),
        'search_items'       => __('Caută Campion', 'kokoro'),
        'not_found'          => __('Niciun campion găsit.', 'kokoro'),
        'featured_image'     => __('Foto Campion', 'kokoro'),
        'set_featured_image' => __('Setează foto', 'kokoro'),
    ];

    register_post_type('campion', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-awards',
        'menu_position'      => 20,
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'campion'],
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
    ]);
}
add_action('init', 'kokoro_register_campion_cpt', 5); // before CPTUI default 10

/**
 * Disciplină — sport/activitate predată la academie (Ju-Jitsu, TRX, etc.)
 */
function kokoro_register_disciplina_cpt() {
    if (post_type_exists('disciplina')) {
        return;
    }

    $labels = [
        'name'               => __('Discipline', 'kokoro'),
        'singular_name'      => __('Disciplină', 'kokoro'),
        'menu_name'          => __('Discipline', 'kokoro'),
        'add_new'            => __('Adaugă Disciplină', 'kokoro'),
        'add_new_item'       => __('Adaugă Disciplină Nouă', 'kokoro'),
        'new_item'           => __('Disciplină Nouă', 'kokoro'),
        'edit_item'          => __('Editează Disciplina', 'kokoro'),
        'view_item'          => __('Vezi Disciplina', 'kokoro'),
        'all_items'          => __('Toate Disciplinele', 'kokoro'),
        'search_items'       => __('Caută Disciplină', 'kokoro'),
        'not_found'          => __('Nicio disciplină găsită.', 'kokoro'),
    ];

    register_post_type('disciplina', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-editor-expand',
        'menu_position'      => 21,
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'disciplina'],
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
    ]);
}
add_action('init', 'kokoro_register_disciplina_cpt', 5);

/**
 * Antrenor — membru al echipei tehnice (sensei, antrenor, preparator).
 */
function kokoro_register_antrenor_cpt() {
    if (post_type_exists('antrenor')) {
        return;
    }

    $labels = [
        'name'               => __('Antrenori', 'kokoro'),
        'singular_name'      => __('Antrenor', 'kokoro'),
        'menu_name'          => __('Antrenori', 'kokoro'),
        'add_new'            => __('Adaugă Antrenor', 'kokoro'),
        'add_new_item'       => __('Adaugă Antrenor Nou', 'kokoro'),
        'new_item'           => __('Antrenor Nou', 'kokoro'),
        'edit_item'          => __('Editează Antrenor', 'kokoro'),
        'view_item'          => __('Vezi Antrenor', 'kokoro'),
        'all_items'          => __('Toți Antrenorii', 'kokoro'),
        'search_items'       => __('Caută Antrenor', 'kokoro'),
        'not_found'          => __('Niciun antrenor găsit.', 'kokoro'),
    ];

    register_post_type('antrenor', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-businessperson',
        'menu_position'      => 22,
        'has_archive'        => false,
        'rewrite'            => ['slug' => 'antrenor'],
        'supports'           => ['title', 'editor', 'thumbnail', 'page-attributes'],
    ]);
}
add_action('init', 'kokoro_register_antrenor_cpt', 5);

/**
 * La activare/deploy inițial: face flush la rewrite rules ca slug-urile noi
 * (/campion/, /disciplina/, /antrenor/) să fie recunoscute fără vizita
 * manuală la Settings → Permalinks.
 *
 * Rulează o singură dată — folosim un option flag.
 */
function kokoro_mu_flush_rewrites() {
    if (get_option('kokoro_mu_flushed') === '1') {
        return;
    }
    flush_rewrite_rules(false);
    update_option('kokoro_mu_flushed', '1');
}
add_action('init', 'kokoro_mu_flush_rewrites', 99);
