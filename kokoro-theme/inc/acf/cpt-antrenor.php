<?php
/**
 * ACF: Detalii Antrenor (CPT)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_cpt_antrenor() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_antrenor',
        'title'  => 'Detalii Antrenor',
        'fields' => [
            // ----- Identitate canonică (folosită de schema.org Person) -----
            [
                'key'   => 'field_antrenor_given_name',
                'label' => 'Prenume (given name)',
                'name'  => 'antrenor_given_name',
                'type'  => 'text',
                'instructions' => 'Ex: „Lucian", „Adrian", „Dan". Folosit în schema.org Person.givenName + Person.name. Dacă lipsește, schema deduce numele din post_title fără prefix-uri honorifice.',
            ],
            [
                'key'   => 'field_antrenor_family_name',
                'label' => 'Nume de familie',
                'name'  => 'antrenor_family_name',
                'type'  => 'text',
                'instructions' => 'Ex: „Bogluț". Folosit în schema.org Person.familyName + Person.name. CRUCIAL pentru consolidarea identității în Knowledge Graph: dacă Adi e și antrenor și campion, ambele schemas trebuie să aibă același given+family.',
            ],
            [
                'key'   => 'field_antrenor_honorific_prefix',
                'label' => 'Honorific (prefix titlu)',
                'name'  => 'antrenor_honorific_prefix',
                'type'  => 'text',
                'maxlength' => 15,
                'instructions' => 'Ex: „Sensei", „Sempai", „Sifu", „Master". Apare în schema.org Person.honorificPrefix — separat de personal name.',
            ],
            [
                'key'           => 'field_antrenor_rol',
                'label'         => 'Rol / Funcție',
                'name'          => 'antrenor_rol',
                'type'          => 'text',
                'default_value' => 'Antrenor',
                'instructions'  => 'Ex: „Sensei principal", „Antrenor copii", „Preparator fizic". Apare ca tag pe card.',
            ],
            [
                'key'   => 'field_antrenor_specializare',
                'label' => 'Specializare',
                'name'  => 'antrenor_specializare',
                'type'  => 'text',
                'instructions' => 'Ex: „Ju-Jitsu Competițional, Autoapărare". Lasă gol dacă nu vrei.',
            ],
            [
                'key'   => 'field_antrenor_bio_scurt',
                'label' => 'Bio scurt (pentru card)',
                'name'  => 'antrenor_bio_scurt',
                'type'  => 'textarea',
                'rows'  => 3,
                'instructions' => '1-2 fraze afișate sub nume pe card. Bio-ul lung îl pui în editorul principal.',
                'new_lines'    => 'br',
            ],
            [
                'key'     => 'field_antrenor_centura',
                'label'   => 'Centură',
                'name'    => 'antrenor_centura',
                'type'    => 'select',
                'choices' => [
                    'alba'       => 'Albă',
                    'galbena'    => 'Galbenă',
                    'portocalie' => 'Portocalie',
                    'verde'      => 'Verde',
                    'albastra'   => 'Albastră',
                    'maro'       => 'Maro',
                    'neagra'     => 'Neagră',
                ],
                'default_value' => 'neagra',
            ],
            [
                'key'   => 'field_antrenor_ani_experienta',
                'label' => 'Ani de experiență',
                'name'  => 'antrenor_ani_experienta',
                'type'  => 'number',
                'min'   => 0,
                'max'   => 80,
            ],
            [
                'key'   => 'field_antrenor_skills',
                'label' => 'Skills (comma-separated)',
                'name'  => 'antrenor_skills',
                'type'  => 'text',
                'instructions' => 'Folosit în schema.org Person.hasOccupation.skills. Ex: „Ju-Jitsu Fighting, Autoapărare, Personal Training, Coaching copii".',
            ],
            [
                'key'   => 'field_antrenor_email',
                'label' => 'Email (opțional)',
                'name'  => 'antrenor_email',
                'type'  => 'email',
            ],
            [
                'key'   => 'field_antrenor_telefon',
                'label' => 'Telefon (opțional)',
                'name'  => 'antrenor_telefon',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_antrenor_facebook',
                'label' => 'Facebook URL (opțional)',
                'name'  => 'antrenor_facebook',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_antrenor_instagram',
                'label' => 'Instagram URL (opțional)',
                'name'  => 'antrenor_instagram',
                'type'  => 'url',
            ],
        ],
        'location' => [
            [['param' => 'post_type', 'operator' => '==', 'value' => 'antrenor']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement' => 'top',
        'active'     => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_cpt_antrenor');
