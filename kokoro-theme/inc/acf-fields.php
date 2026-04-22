<?php
/**
 * ACF Field Groups — Kokoro Brașov Academy
 *
 * Definesc câmpurile prin cod, ca să nu trebuiască utilizatorul să le
 * configureze manual în ACF → Field Groups. Funcțiile ACF sunt gate-uite
 * în funcția_exists() ca tema să nu crape dacă ACF e dezactivat.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    /* ------------------------------------------------------------------
       1. Detalii Campion (pe CPT `campion`)
       ------------------------------------------------------------------ */
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

    /* ------------------------------------------------------------------
       2. Conținut pagina Campioni (template page-campioni.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_campioni',
        'title'  => 'Conținut pagina Campioni',
        'fields' => [
            [
                'key'           => 'field_campioni_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'campioni_hero_titlu',
                'type'          => 'text',
                'default_value' => 'PERFORMANȚĂ MONDIALĂ',
                'instructions'  => 'Separă cuvântul din italic prin pipe. Ex: "PERFORMANȚĂ|MONDIALĂ" → "PERFORMANȚĂ" normal, "MONDIALĂ" italic.',
            ],
            [
                'key'           => 'field_campioni_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'campioni_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'De la înființare, sportivii Kokoro Brașov au cucerit sute de medalii la competiții naționale și internaționale.',
            ],
            [
                'key'           => 'field_campioni_stats',
                'label'         => 'Statistici (bara galbenă)',
                'name'          => 'campioni_stats',
                'type'          => 'repeater',
                'instructions'  => 'Recomandat 4 statistici.',
                'button_label'  => 'Adaugă statistică',
                'layout'        => 'table',
                'min'           => 0,
                'max'           => 6,
                'sub_fields'    => [
                    [
                        'key'      => 'field_stat_numar',
                        'label'    => 'Număr',
                        'name'     => 'numar',
                        'type'     => 'number',
                        'required' => 1,
                    ],
                    [
                        'key'          => 'field_stat_sufix',
                        'label'        => 'Sufix',
                        'name'         => 'sufix',
                        'type'         => 'text',
                        'instructions' => 'Ex: "+", "K+". Opțional.',
                    ],
                    [
                        'key'      => 'field_stat_label',
                        'label'    => 'Etichetă',
                        'name'     => 'label',
                        'type'     => 'text',
                        'required' => 1,
                    ],
                ],
            ],
            [
                'key'           => 'field_campioni_palmares_note',
                'label'         => 'Notă sub tabelul de palmares',
                'name'          => 'campioni_palmares_note',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Tabelul include doar o selecție a rezultatelor. Palmaresul complet este disponibil la cerere.',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'page-campioni.php'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
}
add_action('acf/init', 'kokoro_register_acf_field_groups');

/**
 * Helper: întoarce toate rezultatele (an, competiție, medalie, sportiv)
 * din toți campionii publicați, sortate după an descrescător.
 *
 * @return array
 */
function kokoro_get_palmares_rows() {
    $rows = [];

    $campioni = get_posts([
        'post_type'      => 'campion',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ]);

    foreach ($campioni as $c) {
        $rezultate = function_exists('get_field') ? get_field('campion_rezultate', $c->ID) : [];
        if (!is_array($rezultate)) {
            continue;
        }
        foreach ($rezultate as $r) {
            $rows[] = [
                'an'          => $r['an'] ?? '',
                'competitie'  => $r['competitie'] ?? '',
                'medalie'     => $r['medalie'] ?? '',
                'disciplina'  => $r['disciplina'] ?? '',
                'sportiv'     => get_the_title($c->ID),
                'sportiv_id'  => $c->ID,
            ];
        }
    }

    // Sort by year desc, then alphabetical by competition
    usort($rows, function ($a, $b) {
        $cmp = (int) $b['an'] <=> (int) $a['an'];
        return $cmp !== 0 ? $cmp : strcmp($a['competitie'], $b['competitie']);
    });

    return $rows;
}

/**
 * Helper: eticheta umană pentru valoarea medalie.
 */
function kokoro_medalie_label($key) {
    $map = [
        'aur'          => 'Aur',
        'argint'       => 'Argint',
        'bronz'        => 'Bronz',
        'multiple'     => 'Multiple medalii',
        'participare'  => 'Participare',
    ];
    return $map[$key] ?? ucfirst((string) $key);
}
