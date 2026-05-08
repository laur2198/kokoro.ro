<?php
/**
 * ACF: SEO override per pagină / per post
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_seo() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_seo_per_post',
        'title'  => 'SEO',
        'fields' => [
            ['key' => 'field_seo_titlu', 'label' => 'Titlu SEO (override)', 'name' => 'kokoro_seo_titlu', 'type' => 'text',
                'instructions' => 'Override pentru <title>. Lasă gol → folosește titlul paginii. Max 65 caractere recomandat.'],
            ['key' => 'field_seo_desc', 'label' => 'Meta descriere', 'name' => 'kokoro_seo_desc', 'type' => 'textarea', 'rows' => 3,
                'instructions' => 'Override pentru <meta description>. Lasă gol → folosește excerpt-ul. Ideal 140-160 caractere.'],
            ['key' => 'field_seo_keywords', 'label' => 'Keywords', 'name' => 'kokoro_seo_keywords', 'type' => 'text',
                'instructions' => 'Comma-separated. Lasă gol → folosește keywords default din Setări Kokoro.'],
            ['key' => 'field_seo_og_image', 'label' => 'Imagine OG/social (override)', 'name' => 'kokoro_seo_og_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium',
                'instructions' => 'Override pentru imaginea de la share pe social. Lasă gol → featured image → imagine default.'],
            ['key' => 'field_seo_noindex', 'label' => 'Ascunde de motoare de căutare', 'name' => 'kokoro_seo_noindex', 'type' => 'true_false', 'ui' => 1, 'ui_on_text' => 'Da (noindex)', 'ui_off_text' => 'Nu (index)', 'default_value' => 0,
                'instructions' => 'Bifează pentru a marca pagina ca noindex (nu apare în Google).'],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'post']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'campion']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'disciplina']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'antrenor']],
        ],
        'menu_order'      => 100,
        'position'        => 'side',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_seo');
