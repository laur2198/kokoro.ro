<?php
/**
 * ACF: Detalii Disciplină (CPT)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_cpt_disciplina() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_disciplina',
        'title'  => 'Detalii Disciplină',
        'fields' => [
            [
                'key'           => 'field_disciplina_descriere_scurta',
                'label'         => 'Descriere scurtă (pentru card)',
                'name'          => 'disciplina_descriere_scurta',
                'type'          => 'textarea',
                'rows'          => 4,
                'instructions'  => 'Apare pe pagina /discipline ca subtitlu al card-ului. 2-3 fraze.',
                'new_lines'     => 'br',
            ],
            [
                'key'           => 'field_disciplina_cta_label',
                'label'         => 'Text buton card',
                'name'          => 'disciplina_cta_label',
                'type'          => 'text',
                'default_value' => 'Află Mai Mult',
            ],
            [
                'key'           => 'field_disciplina_link',
                'label'         => 'Link custom (opțional)',
                'name'          => 'disciplina_link',
                'type'          => 'url',
                'instructions'  => 'Dacă e gol, folosește pagina automată generată de WordPress pentru disciplină.',
            ],
            [
                'key'           => 'field_disciplina_titlu_home',
                'label'         => 'Titlu pe Homepage (opțional)',
                'name'          => 'disciplina_titlu_home',
                'type'          => 'text',
                'instructions'  => 'Override doar pentru card-ul din Homepage. Foloseste "|" pentru break-line. Ex: "Ju-Jitsu|Competițional".',
            ],
            [
                'key'           => 'field_disciplina_teaser_home',
                'label'         => 'Teaser Homepage (opțional)',
                'name'          => 'disciplina_teaser_home',
                'type'          => 'text',
                'instructions'  => 'Scurt 1-liner pentru card-ul de pe Homepage (ex: "Fighting, Ne-Waza, Duo System"). Dacă e gol, folosește descrierea scurtă trunchiată.',
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'disciplina'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_cpt_disciplina');
