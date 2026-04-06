<?php
/**
 * Kokoro ACF Field Definitions
 * Definește câmpurile editabile din WordPress Admin
 *
 * Necesită: Advanced Custom Fields (gratuit) sau ACF PRO
 * Install: Plugins → Add New → "Advanced Custom Fields" → Install → Activate
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Check if ACF is active
 */
function kokoro_acf_active() {
    return function_exists('acf_add_local_field_group');
}

/**
 * Register ACF Options Page (global settings)
 */
function kokoro_acf_options_page() {
    if (!kokoro_acf_active()) return;
    if (!function_exists('acf_add_options_page')) return;

    acf_add_options_page([
        'page_title' => 'Setări Kokoro',
        'menu_title' => 'Kokoro Settings',
        'menu_slug'  => 'kokoro-settings',
        'capability' => 'edit_posts',
        'icon_url'   => 'dashicons-heart',
        'position'   => 2,
    ]);
}
add_action('acf/init', 'kokoro_acf_options_page');

/**
 * Register all ACF Field Groups
 */
function kokoro_acf_register_fields() {
    if (!kokoro_acf_active()) return;

    /* ==========================================================================
       1. GLOBAL SETTINGS (Options Page)
       ========================================================================== */

    acf_add_local_field_group([
        'key'    => 'group_kokoro_global',
        'title'  => 'Setări Globale Kokoro',
        'fields' => [
            // Contact
            [
                'key'   => 'field_kokoro_phone',
                'label' => 'Telefon',
                'name'  => 'kokoro_phone',
                'type'  => 'text',
                'default_value' => '+40 740 123 456',
                'instructions'  => 'Numărul de telefon afișat pe site',
            ],
            [
                'key'   => 'field_kokoro_email',
                'label' => 'Email',
                'name'  => 'kokoro_email',
                'type'  => 'email',
                'default_value' => 'contact@kokoro.ro',
            ],
            [
                'key'   => 'field_kokoro_address',
                'label' => 'Adresă',
                'name'  => 'kokoro_address',
                'type'  => 'textarea',
                'rows'  => 2,
                'default_value' => 'Brașov, România',
            ],
            [
                'key'   => 'field_kokoro_whatsapp',
                'label' => 'WhatsApp Link',
                'name'  => 'kokoro_whatsapp',
                'type'  => 'url',
                'default_value' => 'https://wa.me/40740123456',
            ],
            // Social Media
            [
                'key'   => 'field_kokoro_facebook',
                'label' => 'Facebook URL',
                'name'  => 'kokoro_facebook',
                'type'  => 'url',
                'default_value' => 'https://www.facebook.com/kokorobrasovacademy',
            ],
            [
                'key'   => 'field_kokoro_instagram',
                'label' => 'Instagram URL',
                'name'  => 'kokoro_instagram',
                'type'  => 'url',
                'default_value' => 'https://www.instagram.com/kokorobrasov',
            ],
            [
                'key'   => 'field_kokoro_youtube',
                'label' => 'YouTube URL',
                'name'  => 'kokoro_youtube',
                'type'  => 'url',
                'default_value' => 'https://www.youtube.com/@kokorobrasov',
            ],
            [
                'key'   => 'field_kokoro_tiktok',
                'label' => 'TikTok URL',
                'name'  => 'kokoro_tiktok',
                'type'  => 'url',
                'default_value' => 'https://www.tiktok.com/@kokorobrasov',
            ],
            // Program
            [
                'key'   => 'field_kokoro_program',
                'label' => 'Program',
                'name'  => 'kokoro_program',
                'type'  => 'textarea',
                'rows'  => 4,
                'default_value' => "Luni, Miercuri: 16:00 – 22:00\nMarți, Joi: 16:00 – 21:00\nVineri: 16:00 – 20:00\nSâmbătă – Duminică: Închis",
                'instructions' => 'Programul afișat pe pagina de contact și footer',
            ],
        ],
        'location' => [
            [[ 'param' => 'options_page', 'operator' => '==', 'value' => 'kokoro-settings' ]],
        ],
    ]);

    /* ==========================================================================
       2. HOMEPAGE FIELDS
       ========================================================================== */

    acf_add_local_field_group([
        'key'    => 'group_kokoro_homepage',
        'title'  => 'Homepage — Secțiuni Editabile',
        'fields' => [
            // Hero
            [
                'key'   => 'field_hero_title',
                'label' => 'Hero — Titlu',
                'name'  => 'hero_title',
                'type'  => 'text',
                'default_value' => 'DEVINO CAMPION LA KOKORO',
                'instructions'  => 'Titlul mare din hero. Cuvântul între *asteriscuri* va fi galben italic.',
            ],
            [
                'key'   => 'field_hero_subtitle',
                'label' => 'Hero — Subtitlu',
                'name'  => 'hero_subtitle',
                'type'  => 'textarea',
                'rows'  => 3,
                'default_value' => 'Ju-Jitsu pentru copii, juniori și adulți din 2008. Academie recunoscută MTS și FRAM, cu campioni mondiali în palmares.',
            ],
            [
                'key'   => 'field_hero_image',
                'label' => 'Hero — Imagine Fundal',
                'name'  => 'hero_image',
                'type'  => 'image',
                'return_format' => 'url',
                'instructions'  => 'Imagine de fundal hero (1920x1080 recomandat)',
            ],
            [
                'key'   => 'field_hero_video',
                'label' => 'Hero — Video URL (YouTube)',
                'name'  => 'hero_video',
                'type'  => 'url',
                'instructions'  => 'Link YouTube pentru secțiunea video',
            ],
            // Stats
            [
                'key'   => 'field_stat_years',
                'label' => 'Statistici — Ani activitate',
                'name'  => 'stat_years',
                'type'  => 'number',
                'default_value' => 17,
            ],
            [
                'key'   => 'field_stat_medals',
                'label' => 'Statistici — Medalii',
                'name'  => 'stat_medals',
                'type'  => 'number',
                'default_value' => 200,
            ],
            [
                'key'   => 'field_stat_champions',
                'label' => 'Statistici — Campioni mondiali',
                'name'  => 'stat_champions',
                'type'  => 'number',
                'default_value' => 3,
            ],
            [
                'key'   => 'field_stat_athletes',
                'label' => 'Statistici — Sportivi formați',
                'name'  => 'stat_athletes',
                'type'  => 'number',
                'default_value' => 500,
            ],
            // Testimoniale
            [
                'key'   => 'field_testimonials',
                'label' => 'Testimoniale',
                'name'  => 'testimonials',
                'type'  => 'repeater',
                'min'   => 1,
                'max'   => 12,
                'layout' => 'block',
                'button_label' => 'Adaugă Testimonial',
                'sub_fields' => [
                    [
                        'key'   => 'field_testimonial_text',
                        'label' => 'Text',
                        'name'  => 'text',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'key'   => 'field_testimonial_author',
                        'label' => 'Autor',
                        'name'  => 'author',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_testimonial_source',
                        'label' => 'Sursă (Google / Facebook)',
                        'name'  => 'source',
                        'type'  => 'text',
                        'default_value' => 'Google Review',
                    ],
                ],
            ],
        ],
        'location' => [
            [[ 'param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php' ]],
            [[ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ]],
        ],
    ]);

    /* ==========================================================================
       3. TARIFE FIELDS
       ========================================================================== */

    acf_add_local_field_group([
        'key'    => 'group_kokoro_tarife',
        'title'  => 'Tarife — Pachete Prețuri',
        'fields' => [
            [
                'key'   => 'field_tarife_packages',
                'label' => 'Pachete',
                'name'  => 'tarife_packages',
                'type'  => 'repeater',
                'min'   => 1,
                'max'   => 6,
                'layout' => 'block',
                'button_label' => 'Adaugă Pachet',
                'sub_fields' => [
                    [
                        'key'   => 'field_package_name',
                        'label' => 'Nume Pachet',
                        'name'  => 'name',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_package_price',
                        'label' => 'Preț',
                        'name'  => 'price',
                        'type'  => 'text',
                        'instructions' => 'Ex: 300',
                    ],
                    [
                        'key'   => 'field_package_period',
                        'label' => 'Perioadă',
                        'name'  => 'period',
                        'type'  => 'text',
                        'default_value' => '/ lună',
                    ],
                    [
                        'key'   => 'field_package_featured',
                        'label' => 'Pachet recomandat?',
                        'name'  => 'featured',
                        'type'  => 'true_false',
                        'ui'    => 1,
                    ],
                    [
                        'key'   => 'field_package_features',
                        'label' => 'Beneficii (unul pe linie)',
                        'name'  => 'features',
                        'type'  => 'textarea',
                        'rows'  => 6,
                        'instructions' => 'Scrie fiecare beneficiu pe o linie nouă',
                    ],
                ],
            ],
        ],
        'location' => [
            [[ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-tarife.php' ]],
        ],
    ]);

    /* ==========================================================================
       4. ORAR FIELDS
       ========================================================================== */

    acf_add_local_field_group([
        'key'    => 'group_kokoro_orar',
        'title'  => 'Orar — Program Antrenamente',
        'fields' => [
            [
                'key'   => 'field_orar_entries',
                'label' => 'Orarul Săptămânal',
                'name'  => 'orar_entries',
                'type'  => 'repeater',
                'min'   => 1,
                'max'   => 30,
                'layout' => 'table',
                'button_label' => 'Adaugă Oră',
                'sub_fields' => [
                    [
                        'key'   => 'field_orar_day',
                        'label' => 'Zi',
                        'name'  => 'day',
                        'type'  => 'select',
                        'choices' => [
                            'LUNI' => 'Luni', 'MARȚI' => 'Marți', 'MIERCURI' => 'Miercuri',
                            'JOI' => 'Joi', 'VINERI' => 'Vineri', 'SÂMBĂTĂ' => 'Sâmbătă',
                        ],
                    ],
                    [
                        'key'   => 'field_orar_time',
                        'label' => 'Oră',
                        'name'  => 'time',
                        'type'  => 'text',
                        'instructions' => 'Ex: 16:00 – 17:00',
                    ],
                    [
                        'key'   => 'field_orar_discipline',
                        'label' => 'Disciplină',
                        'name'  => 'discipline',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_orar_group',
                        'label' => 'Grupă',
                        'name'  => 'group',
                        'type'  => 'select',
                        'choices' => [
                            'copii' => 'Copii', 'juniori' => 'Juniori', 'adulti' => 'Adulți',
                        ],
                    ],
                    [
                        'key'   => 'field_orar_trainer',
                        'label' => 'Antrenor',
                        'name'  => 'trainer',
                        'type'  => 'text',
                        'default_value' => 'Sensei Lucian Bogluț',
                    ],
                ],
            ],
        ],
        'location' => [
            [[ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-orar.php' ]],
        ],
    ]);

    /* ==========================================================================
       5. CAMPIONI FIELDS
       ========================================================================== */

    acf_add_local_field_group([
        'key'    => 'group_kokoro_campioni',
        'title'  => 'Campioni — Palmares',
        'fields' => [
            [
                'key'   => 'field_champion_name',
                'label' => 'Campion Principal — Nume',
                'name'  => 'champion_name',
                'type'  => 'text',
                'default_value' => 'Adrian Bogluț',
            ],
            [
                'key'   => 'field_champion_photo',
                'label' => 'Campion Principal — Foto',
                'name'  => 'champion_photo',
                'type'  => 'image',
                'return_format' => 'url',
            ],
            [
                'key'   => 'field_champion_description',
                'label' => 'Campion Principal — Descriere',
                'name'  => 'champion_description',
                'type'  => 'textarea',
                'rows'  => 4,
                'default_value' => 'Adrian Bogluț a scris istorie pentru sportul românesc — primul român medaliat la proba de Ju-Jitsu Contact într-un Campionat Mondial (Thailanda, 2025, bronz la -62 kg).',
            ],
            [
                'key'   => 'field_palmares',
                'label' => 'Palmares (Rezultate)',
                'name'  => 'palmares',
                'type'  => 'repeater',
                'min'   => 1,
                'max'   => 30,
                'layout' => 'table',
                'button_label' => 'Adaugă Rezultat',
                'sub_fields' => [
                    [
                        'key'   => 'field_result_year',
                        'label' => 'An',
                        'name'  => 'year',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_result_competition',
                        'label' => 'Competiție',
                        'name'  => 'competition',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_result_medal',
                        'label' => 'Rezultat',
                        'name'  => 'medal',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_result_athlete',
                        'label' => 'Sportiv',
                        'name'  => 'athlete',
                        'type'  => 'text',
                    ],
                ],
            ],
        ],
        'location' => [
            [[ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-campioni.php' ]],
        ],
    ]);
}
add_action('acf/init', 'kokoro_acf_register_fields');

/* ==========================================================================
   Helper Functions — Get ACF values with fallbacks
   ========================================================================== */

/**
 * Get global option with fallback
 */
function kokoro_option($field, $fallback = '') {
    if (!kokoro_acf_active()) return $fallback;
    $value = get_field($field, 'option');
    return $value ? $value : $fallback;
}

/**
 * Get page field with fallback
 */
function kokoro_field($field, $fallback = '') {
    if (!kokoro_acf_active()) return $fallback;
    $value = get_field($field);
    return $value ? $value : $fallback;
}
