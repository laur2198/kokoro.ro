<?php
/**
 * ACF: Detalii Campion (CPT)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_cpt_campion() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_campion',
        'title'  => 'Detalii Campion',
        'fields' => [
            [
                'key'           => 'field_campion_bio_scurt',
                'label'         => 'Bio scurt (1-2 fraze)',
                'name'          => 'campion_bio_scurt',
                'type'          => 'textarea',
                'instructions'  => 'Afișat sub nume pe pagina principală. Maxim 2 fraze.',
                'rows'          => 3,
                'new_lines'     => 'br',
            ],
            [
                'key'          => 'field_campion_centura',
                'label'        => 'Centură',
                'name'         => 'campion_centura',
                'type'         => 'select',
                'choices'      => [
                    'alba'       => 'Albă',
                    'galbena'    => 'Galbenă',
                    'portocalie' => 'Portocalie',
                    'verde'      => 'Verde',
                    'albastra'   => 'Albastră',
                    'maro'       => 'Maro',
                    'neagra'     => 'Neagră',
                ],
                'default_value' => 'neagra',
                'return_format' => 'value',
            ],
            [
                'key'           => 'field_campion_is_featured',
                'label'         => 'Campion featured (apare mare, sus)',
                'name'          => 'campion_is_featured',
                'type'          => 'true_false',
                'instructions'  => 'Doar un singur campion ar trebui bifat. Apare mare, cu poză, pe pagina /campioni.',
                'ui'            => 1,
                'ui_on_text'    => 'Da',
                'ui_off_text'   => 'Nu',
            ],
            [
                'key'           => 'field_campion_rezultate',
                'label'         => 'Palmares',
                'name'          => 'campion_rezultate',
                'type'          => 'repeater',
                'instructions'  => 'Adaugă un rând pentru fiecare medalie / rezultat notabil.',
                'button_label'  => 'Adaugă rezultat',
                'layout'        => 'table',
                'sub_fields'    => [
                    [
                        'key'   => 'field_rezultat_an',
                        'label' => 'An',
                        'name'  => 'an',
                        'type'  => 'number',
                        'min'   => 1990,
                        'max'   => 2100,
                        'required' => 1,
                    ],
                    [
                        'key'   => 'field_rezultat_competitie',
                        'label' => 'Competiție',
                        'name'  => 'competitie',
                        'type'  => 'text',
                        'required' => 1,
                    ],
                    [
                        'key'     => 'field_rezultat_medalie',
                        'label'   => 'Medalie',
                        'name'    => 'medalie',
                        'type'    => 'select',
                        'choices' => [
                            'aur'          => 'Aur',
                            'argint'       => 'Argint',
                            'bronz'        => 'Bronz',
                            'multiple'     => 'Multiple medalii',
                            'participare'  => 'Participare',
                        ],
                        'default_value' => 'aur',
                    ],
                    [
                        'key'          => 'field_rezultat_disciplina',
                        'label'        => 'Disciplină',
                        'name'         => 'disciplina',
                        'type'         => 'text',
                        'instructions' => 'Ex: Ju-Jitsu Fighting, BJJ, No-Gi. Opțional.',
                    ],
                ],
            ],
            [
                'key'          => 'field_campion_persoana_id_canonical',
                'label'        => 'Identitate canonică (URL antrenor #person)',
                'name'         => 'antrenor_persoana_id_canonical',
                'type'         => 'url',
                'instructions' => 'Dacă acest campion e și antrenor (cazul Adi), pune URL-ul canonic al CPT-ului antrenor + #person (ex. https://kokoro.ro/antrenor/sempai-adrian/#person). Schema Person.sameAs va trimite Google către o singură entitate consolidată în Knowledge Graph.',
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'campion'],
            ],
        ],
        'menu_order'     => 0,
        'position'       => 'normal',
        'style'          => 'default',
        'label_placement' => 'top',
        'active'         => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_cpt_campion');
