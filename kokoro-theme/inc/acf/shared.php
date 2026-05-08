<?php
/**
 * ACF: FAQ shared (apare pe pagini + CPTs)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_shared() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_faq',
        'title'  => 'Întrebări frecvente (FAQ)',
        'fields' => [
            [
                'key'           => 'field_kokoro_faq',
                'label'         => 'FAQ — întrebări și răspunsuri',
                'name'          => 'kokoro_faq',
                'type'          => 'repeater',
                'instructions'  => 'Adaugă întrebări frecvente pentru această pagină. Apar și în Schema FAQPage (Google rich results) — boost SEO important pentru AI search (Perplexity, Google AI Overview).',
                'button_label'  => 'Adaugă întrebare',
                'layout'        => 'block',
                'sub_fields' => [
                    ['key' => 'field_faq_q', 'label' => 'Întrebare', 'name' => 'intrebare', 'type' => 'text',     'required' => 1],
                    ['key' => 'field_faq_a', 'label' => 'Răspuns',   'name' => 'raspuns',   'type' => 'textarea', 'rows' => 3, 'required' => 1, 'instructions' => 'Răspuns simplu, fără HTML. 1-3 fraze ideal.'],
                ],
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'page']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'disciplina']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'antrenor']],
            [['param' => 'post_type', 'operator' => '==', 'value' => 'campion']],
        ],
        'menu_order'      => 50,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_shared');
