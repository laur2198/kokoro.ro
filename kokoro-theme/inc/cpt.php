<?php
/**
 * Custom Post Types — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Campion — sportiv al academiei cu palmares.
 */
function kokoro_register_campion_cpt() {
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

    $args = [
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
    ];

    register_post_type('campion', $args);
}
add_action('init', 'kokoro_register_campion_cpt');

/**
 * Disciplină — sport/activitate predată la academie (Ju-Jitsu, TRX, etc.)
 */
function kokoro_register_disciplina_cpt() {
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

    $args = [
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
    ];

    register_post_type('disciplina', $args);
}
add_action('init', 'kokoro_register_disciplina_cpt');
