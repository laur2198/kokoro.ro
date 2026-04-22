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
