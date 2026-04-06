<?php
/**
 * Kokoro ACF Page Builder
 * Permite clientului să construiască pagini noi din blocuri pre-definite
 *
 * Clientul merge la Pages → Add New → alege blocuri din "Secțiuni Pagină"
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_page_builder() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_page_builder',
        'title'  => 'Secțiuni Pagină — Construiește pagina din blocuri',
        'fields' => [
            [
                'key'   => 'field_page_sections',
                'label' => 'Secțiuni',
                'name'  => 'page_sections',
                'type'  => 'flexible_content',
                'button_label' => 'Adaugă Secțiune',
                'layouts' => [

                    /* ---------- Hero Section ---------- */
                    [
                        'key'   => 'layout_hero',
                        'name'  => 'hero_section',
                        'label' => 'Hero (Banner Mare)',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_hero_title',
                                'label' => 'Titlu',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_hero_subtitle',
                                'label' => 'Subtitlu',
                                'name'  => 'subtitle',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            [
                                'key'   => 'field_pb_hero_image',
                                'label' => 'Imagine Fundal',
                                'name'  => 'image',
                                'type'  => 'image',
                                'return_format' => 'url',
                            ],
                            [
                                'key'   => 'field_pb_hero_btn_text',
                                'label' => 'Text Buton',
                                'name'  => 'btn_text',
                                'type'  => 'text',
                                'default_value' => 'Înscrie-te Acum',
                            ],
                            [
                                'key'   => 'field_pb_hero_btn_link',
                                'label' => 'Link Buton',
                                'name'  => 'btn_link',
                                'type'  => 'url',
                            ],
                        ],
                    ],

                    /* ---------- Text + Image ---------- */
                    [
                        'key'   => 'layout_text_image',
                        'name'  => 'text_image',
                        'label' => 'Text + Imagine (2 coloane)',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_ti_label',
                                'label' => 'Label secțiune (ex: 01 — Despre)',
                                'name'  => 'label',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_ti_title',
                                'label' => 'Titlu',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_ti_text',
                                'label' => 'Text',
                                'name'  => 'text',
                                'type'  => 'wysiwyg',
                                'toolbar' => 'basic',
                            ],
                            [
                                'key'   => 'field_pb_ti_image',
                                'label' => 'Imagine',
                                'name'  => 'image',
                                'type'  => 'image',
                                'return_format' => 'url',
                            ],
                            [
                                'key'   => 'field_pb_ti_reverse',
                                'label' => 'Imagine la stânga?',
                                'name'  => 'reverse',
                                'type'  => 'true_false',
                                'ui'    => 1,
                            ],
                            [
                                'key'   => 'field_pb_ti_bg',
                                'label' => 'Fundal',
                                'name'  => 'background',
                                'type'  => 'select',
                                'choices' => [
                                    'dark'   => 'Alb',
                                    'alt'    => 'Gri deschis',
                                    'blue'   => 'Albastru',
                                    'accent' => 'Galben',
                                ],
                                'default_value' => 'dark',
                            ],
                        ],
                    ],

                    /* ---------- Cards Grid ---------- */
                    [
                        'key'   => 'layout_cards',
                        'name'  => 'cards_grid',
                        'label' => 'Carduri (Grid)',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_cards_label',
                                'label' => 'Label secțiune',
                                'name'  => 'label',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_cards_title',
                                'label' => 'Titlu secțiune',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_cards_items',
                                'label' => 'Carduri',
                                'name'  => 'cards',
                                'type'  => 'repeater',
                                'min'   => 1,
                                'max'   => 8,
                                'layout' => 'block',
                                'button_label' => 'Adaugă Card',
                                'sub_fields' => [
                                    [
                                        'key'   => 'field_pb_card_title',
                                        'label' => 'Titlu',
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_pb_card_text',
                                        'label' => 'Text',
                                        'name'  => 'text',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                    ],
                                    [
                                        'key'   => 'field_pb_card_image',
                                        'label' => 'Imagine',
                                        'name'  => 'image',
                                        'type'  => 'image',
                                        'return_format' => 'url',
                                    ],
                                ],
                            ],
                            [
                                'key'   => 'field_pb_cards_bg',
                                'label' => 'Fundal',
                                'name'  => 'background',
                                'type'  => 'select',
                                'choices' => [
                                    'dark'   => 'Alb',
                                    'alt'    => 'Gri deschis',
                                    'blue'   => 'Albastru',
                                    'accent' => 'Galben',
                                ],
                                'default_value' => 'alt',
                            ],
                        ],
                    ],

                    /* ---------- CTA Section ---------- */
                    [
                        'key'   => 'layout_cta',
                        'name'  => 'cta_section',
                        'label' => 'CTA (Apel la acțiune)',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_cta_title',
                                'label' => 'Titlu',
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_cta_text',
                                'label' => 'Text',
                                'name'  => 'text',
                                'type'  => 'textarea',
                                'rows'  => 3,
                            ],
                            [
                                'key'   => 'field_pb_cta_btn_text',
                                'label' => 'Text Buton',
                                'name'  => 'btn_text',
                                'type'  => 'text',
                                'default_value' => 'Înscrie-te Acum',
                            ],
                            [
                                'key'   => 'field_pb_cta_btn_link',
                                'label' => 'Link Buton',
                                'name'  => 'btn_link',
                                'type'  => 'url',
                            ],
                            [
                                'key'   => 'field_pb_cta_bg',
                                'label' => 'Fundal',
                                'name'  => 'background',
                                'type'  => 'select',
                                'choices' => [
                                    'blue'   => 'Albastru',
                                    'accent' => 'Galben',
                                ],
                                'default_value' => 'blue',
                            ],
                        ],
                    ],

                    /* ---------- Text simplu ---------- */
                    [
                        'key'   => 'layout_text',
                        'name'  => 'text_section',
                        'label' => 'Text Simplu',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_text_content',
                                'label' => 'Conținut',
                                'name'  => 'content',
                                'type'  => 'wysiwyg',
                            ],
                            [
                                'key'   => 'field_pb_text_bg',
                                'label' => 'Fundal',
                                'name'  => 'background',
                                'type'  => 'select',
                                'choices' => [
                                    'dark'   => 'Alb',
                                    'alt'    => 'Gri deschis',
                                ],
                                'default_value' => 'dark',
                            ],
                        ],
                    ],

                    /* ---------- Citat Japonez ---------- */
                    [
                        'key'   => 'layout_jp_quote',
                        'name'  => 'jp_quote',
                        'label' => 'Citat Japonez',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_jp_kanji',
                                'label' => 'Kanji',
                                'name'  => 'kanji',
                                'type'  => 'text',
                                'instructions' => 'Ex: 「継続は力なり」',
                            ],
                            [
                                'key'   => 'field_pb_jp_romaji',
                                'label' => 'Romaji',
                                'name'  => 'romaji',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_pb_jp_translation',
                                'label' => 'Traducere',
                                'name'  => 'translation',
                                'type'  => 'text',
                            ],
                        ],
                    ],

                    /* ---------- Galerie Foto ---------- */
                    [
                        'key'   => 'layout_gallery',
                        'name'  => 'gallery_section',
                        'label' => 'Galerie Foto',
                        'sub_fields' => [
                            [
                                'key'   => 'field_pb_gallery_images',
                                'label' => 'Imagini',
                                'name'  => 'images',
                                'type'  => 'gallery',
                                'return_format' => 'url',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [[ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-builder.php' ]],
        ],
    ]);
}
add_action('acf/init', 'kokoro_acf_page_builder');
