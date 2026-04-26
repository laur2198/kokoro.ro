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

/**
 * Înregistrează „Setări Kokoro" ca options page (date globale: contact,
 * social, etc.). Necesită ACF 6.2+ (Free) sau ACF Pro pentru
 * acf_add_options_page().
 */
function kokoro_register_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    acf_add_options_page([
        'page_title' => __('Setări Kokoro', 'kokoro'),
        'menu_title' => __('Setări Kokoro', 'kokoro'),
        'menu_slug'  => 'kokoro-settings',
        'icon_url'   => 'dashicons-admin-customizer',
        'position'   => 22,
        'capability' => 'edit_theme_options',
        'redirect'   => false,
    ]);
}
add_action('acf/init', 'kokoro_register_options_page');

function kokoro_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    /* ------------------------------------------------------------------
       -1. SEO override per pagină / per CPT post
           (apar în meta box „SEO" pe orice pagină sau post)
       ------------------------------------------------------------------ */
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

    /* ------------------------------------------------------------------
       0. Setări Globale (options page „Setări Kokoro")
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_settings',
        'title'  => 'Setări Globale Site',
        'fields' => [
            // Contact
            ['key' => 'field_set_tab_contact', 'label' => 'CONTACT',     'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_telefon',     'label' => 'Telefon',     'name' => 'set_telefon',     'type' => 'text',     'default_value' => '0742 037 973', 'instructions' => 'Format internațional cu spații e ok pentru afișare; e folosit și ca link tel:'],
            ['key' => 'field_set_email',       'label' => 'Email',       'name' => 'set_email',       'type' => 'email',    'default_value' => 'contact@kokoro.ro'],
            ['key' => 'field_set_adresa',      'label' => 'Adresă',      'name' => 'set_adresa',      'type' => 'textarea', 'rows' => 2, 'default_value' => 'Str. Carpaților 60<br>500269 Brașov, România', 'new_lines' => 'br'],
            ['key' => 'field_set_oras',        'label' => 'Oraș (label scurt)', 'name' => 'set_oras', 'type' => 'text', 'default_value' => 'Brașov, România'],
            ['key' => 'field_set_strada',      'label' => 'Stradă (numai)',     'name' => 'set_strada','type' => 'text', 'default_value' => 'Str. Carpaților 60', 'instructions' => 'Folosit în Schema.org (PostalAddress.streetAddress).'],
            ['key' => 'field_set_localitate',  'label' => 'Localitate',         'name' => 'set_localitate','type' => 'text', 'default_value' => 'Brașov'],
            ['key' => 'field_set_cod_postal',  'label' => 'Cod poștal',         'name' => 'set_cod_postal','type' => 'text', 'default_value' => '500269'],
            ['key' => 'field_set_regiune',     'label' => 'Regiune',            'name' => 'set_regiune','type' => 'text', 'default_value' => 'Brașov'],
            ['key' => 'field_set_tara',        'label' => 'Țară (cod ISO)',     'name' => 'set_tara',  'type' => 'text', 'default_value' => 'RO'],
            ['key' => 'field_set_lat',         'label' => 'Latitudine GPS',     'name' => 'set_lat',   'type' => 'text', 'default_value' => '45.6427', 'instructions' => 'Verifică pe Google Maps adresa exactă!'],
            ['key' => 'field_set_lng',         'label' => 'Longitudine GPS',    'name' => 'set_lng',   'type' => 'text', 'default_value' => '25.5887'],
            ['key' => 'field_set_maps_url',    'label' => 'Link Google Maps (opțional)', 'name' => 'set_maps_url', 'type' => 'url'],
            ['key' => 'field_set_an_fondare',  'label' => 'An înființare',      'name' => 'set_an_fondare','type' => 'text', 'default_value' => '2008'],
            ['key' => 'field_set_program_lv',  'label' => 'Program L-V',        'name' => 'set_program_lv','type' => 'text', 'default_value' => '16:00 – 21:00'],
            ['key' => 'field_set_program_sa',  'label' => 'Program Sâmbătă',    'name' => 'set_program_sa','type' => 'text', 'default_value' => 'după programare'],

            // Social
            ['key' => 'field_set_tab_social', 'label' => 'SOCIAL', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_facebook',  'label' => 'Facebook URL',  'name' => 'set_facebook',  'type' => 'url', 'default_value' => 'https://www.facebook.com/kokorobrasovacademy'],
            ['key' => 'field_set_instagram', 'label' => 'Instagram URL', 'name' => 'set_instagram', 'type' => 'url', 'default_value' => 'https://www.instagram.com/kokorobrasov'],
            ['key' => 'field_set_youtube',   'label' => 'YouTube URL',   'name' => 'set_youtube',   'type' => 'url', 'instructions' => 'Lasă gol dacă nu folosești.'],
            ['key' => 'field_set_tiktok',    'label' => 'TikTok URL',    'name' => 'set_tiktok',    'type' => 'url', 'instructions' => 'Lasă gol dacă nu folosești.'],
            ['key' => 'field_set_google_url','label' => 'Google Reviews URL', 'name' => 'set_google_url','type' => 'url', 'instructions' => 'Linkul pentru recenzii Google.'],
            ['key' => 'field_set_google_rating', 'label' => 'Rating Google (numeric)', 'name' => 'set_google_rating', 'type' => 'text', 'default_value' => '4.8'],
            ['key' => 'field_set_google_count',  'label' => 'Număr recenzii Google',   'name' => 'set_google_count',  'type' => 'text', 'default_value' => '97'],

            // WhatsApp
            ['key' => 'field_set_tab_whatsapp', 'label' => 'WHATSAPP', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_whatsapp_numar',  'label' => 'Număr WhatsApp', 'name' => 'set_whatsapp_numar',  'type' => 'text', 'default_value' => '40740123456', 'instructions' => 'Doar cifrele cu prefixul țării, fără +. Ex: 40740123456 (pentru +40 740 123 456). Lasă gol pentru a ascunde butonul WhatsApp.'],
            ['key' => 'field_set_whatsapp_arata',  'label' => 'Arată butonul flotant',  'name' => 'set_whatsapp_arata',  'type' => 'true_false', 'ui' => 1, 'ui_on_text' => 'Da', 'ui_off_text' => 'Nu', 'default_value' => 1],

            // Header
            ['key' => 'field_set_tab_header', 'label' => 'HEADER', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_header_cta_text', 'label' => 'Text buton CTA navbar', 'name' => 'set_header_cta_text', 'type' => 'text', 'default_value' => 'Înscrie-te'],
            ['key' => 'field_set_header_cta_url',  'label' => 'URL buton CTA navbar',  'name' => 'set_header_cta_url',  'type' => 'url',  'instructions' => 'Gol → /inscriere/'],
            ['key' => 'field_set_meta_descriere', 'label' => 'Meta descriere site', 'name' => 'set_meta_descriere', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Kokoro Brașov Academy — Ju-Jitsu pentru copii, juniori și adulți din 2008. Campioni mondiali, antrenori dedicați.', 'instructions' => 'Folosit în <meta name="description"> când nu există un SEO plugin.'],

            // Footer
            ['key' => 'field_set_tab_footer', 'label' => 'FOOTER', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_footer_descriere', 'label' => 'Descriere brand (footer coloana 1)', 'name' => 'set_footer_descriere', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'Kokoro Brașov Academy — academie de Ju-Jitsu fondată în 2008. Recunoscută MTS și FRAM. Formăm campioni și caractere puternice prin disciplină, respect și perseverență.'],
            ['key' => 'field_set_footer_kanji', 'label' => 'Kanji decorativ (footer coloana 1)', 'name' => 'set_footer_kanji', 'type' => 'text', 'default_value' => '武道'],
            ['key' => 'field_set_footer_disc_titlu', 'label' => 'Titlu coloana Discipline', 'name' => 'set_footer_disc_titlu', 'type' => 'text', 'default_value' => 'Discipline'],
            ['key' => 'field_set_footer_disc_limit', 'label' => 'Câte discipline în footer', 'name' => 'set_footer_disc_limit', 'type' => 'number', 'default_value' => 4, 'min' => 1, 'max' => 10],
            ['key' => 'field_set_footer_nav_titlu', 'label' => 'Titlu coloana Navigare', 'name' => 'set_footer_nav_titlu', 'type' => 'text', 'default_value' => 'Navigare', 'instructions' => 'Link-urile vin din meniul WP cu locația „Meniu Footer" (Appearance → Menus).'],
            ['key' => 'field_set_footer_contact_titlu', 'label' => 'Titlu coloana Contact', 'name' => 'set_footer_contact_titlu', 'type' => 'text', 'default_value' => 'Contact'],
            ['key' => 'field_set_footer_copyright', 'label' => 'Text copyright', 'name' => 'set_footer_copyright', 'type' => 'text', 'default_value' => 'Kokoro Brașov Academy. Toate drepturile rezervate.', 'instructions' => 'Anul curent + © sunt adăugate automat la început.'],
            ['key' => 'field_set_footer_tagline', 'label' => 'Tagline final', 'name' => 'set_footer_tagline', 'type' => 'text', 'default_value' => 'Kokoro — Inimă, Spirit, Minte', 'instructions' => 'Apare lângă kanji-ul 心 sub copyright.'],

            // SEO Global
            ['key' => 'field_set_tab_seo', 'label' => 'SEO', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_seo_titlu_separator', 'label' => 'Separator titlu',     'name' => 'set_seo_separator', 'type' => 'text', 'default_value' => ' | ', 'instructions' => 'Apare între titlu pagină și nume site. Ex: " | ", " — ", " · "'],
            ['key' => 'field_set_seo_titlu_home',      'label' => 'Titlu Homepage SEO',  'name' => 'set_seo_titlu_home', 'type' => 'text', 'default_value' => 'Kokoro Brașov — Ju-Jitsu și Autoapărare pentru Copii și Adulți', 'instructions' => 'Max 65 caractere. Apare în <title> pentru Acasă.'],
            ['key' => 'field_set_seo_desc_home',       'label' => 'Descriere Homepage',  'name' => 'set_seo_desc_home', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Academie Ju-Jitsu Brașov din 2008. Cursuri pentru copii (4+ ani), adulți, autoapărare și TRX. Antrenor: Adrian Boglut, vicecampion european. Antrenament gratuit de probă.', 'instructions' => '140-160 caractere ideal.'],
            ['key' => 'field_set_seo_og_default',      'label' => 'Imagine OG default',  'name' => 'set_seo_og_default', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => 'Folosită când o pagină nu are imagine proprie. Ideal: 1200×630px, sub 200KB.'],
            ['key' => 'field_set_seo_twitter',         'label' => 'Twitter handle (opțional)', 'name' => 'set_seo_twitter', 'type' => 'text', 'instructions' => 'Cu @ în față, ex: @kokorobrasov.'],
            ['key' => 'field_set_seo_keywords_default','label' => 'Keywords default',    'name' => 'set_seo_keywords_default', 'type' => 'text', 'default_value' => 'ju-jitsu brașov, ju jitsu copii, autoapărare brașov, arte marțiale brașov, kokoro', 'instructions' => 'Comma-separated. Folosit când o pagină nu are keywords proprii.'],
        ],
        'location' => [
            [['param' => 'options_page', 'operator' => '==', 'value' => 'kokoro-settings']],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);


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
       1b. Detalii Disciplină (pe CPT `disciplina`)
       ------------------------------------------------------------------ */
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

    /* ------------------------------------------------------------------
       1c. Detalii Antrenor (pe CPT `antrenor`)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_antrenor',
        'title'  => 'Detalii Antrenor',
        'fields' => [
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

    /* ------------------------------------------------------------------
       2a. Conținut pagina Antrenori (template page-antrenori.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_antrenori',
        'title'  => 'Conținut pagina Antrenori',
        'fields' => [
            [
                'key'           => 'field_antr_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'antr_hero_titlu',
                'type'          => 'text',
                'default_value' => 'ECHIPA|KOKORO',
            ],
            [
                'key'           => 'field_antr_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'antr_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Antrenori cu zeci de ani de experiență, dedicați să formeze caractere puternice și sportivi de top.',
            ],
            [
                'key'           => 'field_antr_jp_kanji',
                'label'         => 'Citat — kanji',
                'name'          => 'antr_jp_kanji',
                'type'          => 'text',
                'default_value' => '「先生」',
            ],
            [
                'key'           => 'field_antr_jp_romaji',
                'label'         => 'Citat — romaji',
                'name'          => 'antr_jp_romaji',
                'type'          => 'text',
                'default_value' => 'Sensei',
            ],
            [
                'key'           => 'field_antr_jp_traducere',
                'label'         => 'Citat — traducere',
                'name'          => 'antr_jp_traducere',
                'type'          => 'text',
                'default_value' => 'Cel care a mers înaintea ta — învățătorul, mentorul.',
            ],
            [
                'key'           => 'field_antr_cta_titlu',
                'label'         => 'Titlu CTA jos',
                'name'          => 'antr_cta_titlu',
                'type'          => 'text',
                'default_value' => 'ANTRENEAZĂ-TE CU|CEI MAI BUNI',
            ],
            [
                'key'           => 'field_antr_cta_text',
                'label'         => 'Text CTA',
                'name'          => 'antr_cta_text',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Vino la o lecție demonstrativă gratuită și cunoaște echipa Kokoro.',
            ],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'page-antrenori.php']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement' => 'top',
        'active'     => true,
    ]);

    /* ------------------------------------------------------------------
       2b. Conținut pagina Despre Noi (template page-despre-noi.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_despre',
        'title'  => 'Conținut pagina Despre Noi',
        'fields' => [
            ['key' => 'field_d_tab_hero', 'label' => 'HERO', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_hero_titlu',    'name' => 'despre_hero_titlu',    'label' => 'Titlu hero',    'type' => 'text',     'default_value' => 'DESPRE|KOKORO'],
            ['key' => 'field_d_hero_subtitlu', 'name' => 'despre_hero_subtitlu', 'label' => 'Subtitlu hero', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'O academie de Ju-Jitsu fondată din pasiune. Fiecare antrenament e un pas spre versiunea ta mai bună.'],
            ['key' => 'field_d_hero_imagine',  'name' => 'despre_hero_imagine',  'label' => 'Imagine hero (opțional)', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'],

            ['key' => 'field_d_tab_poveste', 'label' => 'POVESTEA', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_poveste_titlu',   'name' => 'despre_poveste_titlu',   'label' => 'Titlu',    'type' => 'text', 'default_value' => 'POVESTEA|NOASTRĂ'],
            ['key' => 'field_d_poveste_text',    'name' => 'despre_poveste_text',    'label' => 'Text',     'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'default_value' => 'În 2008, Sensei Lucică a deschis primul dojo Kokoro Brașov cu ambiția de a forma sportivi de elită și caractere puternice. De atunci, sute de copii, juniori și adulți au trecut prin sala noastră, iar zeci au cucerit medalii la competiții naționale și internaționale.'],
            ['key' => 'field_d_poveste_imagine', 'name' => 'despre_poveste_imagine', 'label' => 'Imagine',  'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'],

            ['key' => 'field_d_tab_mv', 'label' => 'MISIUNE & VIZIUNE', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_misiune_titlu', 'name' => 'despre_misiune_titlu', 'label' => 'Titlu Misiune',  'type' => 'text',     'default_value' => 'MISIUNE'],
            ['key' => 'field_d_misiune_text',  'name' => 'despre_misiune_text',  'label' => 'Text Misiune',   'type' => 'textarea', 'rows' => 4, 'default_value' => 'Să formăm sportivi puternici, disciplinați și respectuoși, transmițând tradiția Ju-Jitsu prin antrenamente de calitate.'],
            ['key' => 'field_d_viziune_titlu', 'name' => 'despre_viziune_titlu', 'label' => 'Titlu Viziune',  'type' => 'text',     'default_value' => 'VIZIUNE'],
            ['key' => 'field_d_viziune_text',  'name' => 'despre_viziune_text',  'label' => 'Text Viziune',   'type' => 'textarea', 'rows' => 4, 'default_value' => 'Să devenim cea mai respectată academie de Ju-Jitsu din România, formând următorii campioni mondiali.'],

            ['key' => 'field_d_tab_stats', 'label' => 'STATISTICI', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_stats', 'name' => 'despre_stats', 'label' => 'Statistici (bara galbenă)', 'type' => 'repeater', 'button_label' => 'Adaugă', 'layout' => 'table', 'sub_fields' => [
                ['key' => 'field_d_stat_numar', 'label' => 'Număr',    'name' => 'numar', 'type' => 'number', 'required' => 1],
                ['key' => 'field_d_stat_sufix', 'label' => 'Sufix',    'name' => 'sufix', 'type' => 'text'],
                ['key' => 'field_d_stat_label', 'label' => 'Etichetă', 'name' => 'label', 'type' => 'text', 'required' => 1],
            ]],

            ['key' => 'field_d_tab_valori', 'label' => 'VALORI', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_valori_titlu',    'name' => 'despre_valori_titlu',    'label' => 'Titlu',    'type' => 'text',     'default_value' => 'VALORI|FUNDAMENTALE'],
            ['key' => 'field_d_valori_subtitlu', 'name' => 'despre_valori_subtitlu', 'label' => 'Subtitlu', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Principiile care ne ghidează în fiecare antrenament și competiție.'],
            ['key' => 'field_d_valori', 'name' => 'despre_valori', 'label' => 'Valori', 'type' => 'repeater', 'button_label' => 'Adaugă valoare', 'layout' => 'block', 'sub_fields' => [
                ['key' => 'field_d_val_kanji',     'label' => 'Kanji',     'name' => 'kanji',     'type' => 'text', 'required' => 1],
                ['key' => 'field_d_val_romaji',    'label' => 'Romaji',    'name' => 'romaji',    'type' => 'text', 'required' => 1],
                ['key' => 'field_d_val_nume',     'label' => 'Nume',     'name' => 'nume',     'type' => 'text'],
                ['key' => 'field_d_val_descriere', 'label' => 'Descriere', 'name' => 'descriere', 'type' => 'textarea', 'rows' => 3, 'required' => 1],
            ]],

            ['key' => 'field_d_tab_timeline', 'label' => 'MOMENTE CHEIE', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_timeline_titlu', 'name' => 'despre_timeline_titlu', 'label' => 'Titlu', 'type' => 'text', 'default_value' => 'MOMENTE|CHEIE'],
            ['key' => 'field_d_timeline', 'name' => 'despre_timeline', 'label' => 'Etape', 'type' => 'repeater', 'button_label' => 'Adaugă moment', 'layout' => 'row', 'sub_fields' => [
                ['key' => 'field_d_tl_an',         'label' => 'An',         'name' => 'an',         'type' => 'text', 'required' => 1, 'instructions' => 'Ex: „2008", „2008-2010"'],
                ['key' => 'field_d_tl_eveniment',  'label' => 'Eveniment',  'name' => 'eveniment',  'type' => 'text', 'required' => 1],
                ['key' => 'field_d_tl_descriere',  'label' => 'Descriere',  'name' => 'descriere',  'type' => 'textarea', 'rows' => 2],
            ]],

            ['key' => 'field_d_tab_echipa', 'label' => 'ECHIPA', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_echipa_titlu',  'name' => 'despre_echipa_titlu',  'label' => 'Titlu',  'type' => 'text', 'default_value' => 'ECHIPA|KOKORO'],
            ['key' => 'field_d_echipa_text',   'name' => 'despre_echipa_text',   'label' => 'Text introductiv', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Antrenori dedicați, cu zeci de ani de experiență combinată.'],
            ['key' => 'field_d_echipa_limit',  'name' => 'despre_echipa_limit',  'label' => 'Câți antrenori', 'type' => 'number', 'default_value' => 4, 'min' => 0, 'max' => 12, 'instructions' => '0 = ascunde secțiunea. Antrenorii vin din CPT, sortați după menu_order.'],

            ['key' => 'field_d_tab_cta', 'label' => 'CTA', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_d_cta_titlu', 'name' => 'despre_cta_titlu', 'label' => 'Titlu',         'type' => 'text', 'default_value' => 'ALĂTURĂ-TE|FAMILIEI KOKORO'],
            ['key' => 'field_d_cta_text',  'name' => 'despre_cta_text',  'label' => 'Text',          'type' => 'textarea', 'rows' => 2, 'default_value' => 'Vino la o lecție demonstrativă gratuită și descoperă spiritul Kokoro.'],
            ['key' => 'field_d_cta_buton', 'name' => 'despre_cta_buton', 'label' => 'Text buton',    'type' => 'text', 'default_value' => 'Înscrie-te Acum'],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'page-despre-noi.php']],
        ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'label_placement' => 'top',
        'active'     => true,
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

    /* ------------------------------------------------------------------
       3. Conținut pagina Orar (template page-orar.php)
       ------------------------------------------------------------------ */
    $zile_choices = [
        'Luni'     => 'Luni',
        'Marți'    => 'Marți',
        'Miercuri' => 'Miercuri',
        'Joi'      => 'Joi',
        'Vineri'   => 'Vineri',
        'Sâmbătă'  => 'Sâmbătă',
        'Duminică' => 'Duminică',
    ];
    $grupa_choices = [
        'copii'    => 'Copii (4-12 ani)',
        'juniori'  => 'Juniori (13-17 ani)',
        'adulti'   => 'Adulți (18+ ani)',
    ];

    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_orar',
        'title'  => 'Conținut pagina Orar',
        'fields' => [
            [
                'key'           => 'field_orar_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'orar_hero_titlu',
                'type'          => 'text',
                'default_value' => 'PROGRAMUL|ANTRENAMENTELOR',
                'instructions'  => 'Foloseste pipe "|" pentru a separa pe linii. Linia 2, 4, ... apare cu italic.',
            ],
            [
                'key'           => 'field_orar_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'orar_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Alege grupa și orele care ți se potrivesc. Antrenamentele au loc în sala Kokoro din Brașov.',
            ],
            [
                'key'           => 'field_orar_legenda',
                'label'         => 'Legendă grupe',
                'name'          => 'orar_legenda',
                'type'          => 'repeater',
                'instructions'  => 'Afișată deasupra tabelului. Recomandat 3 grupe.',
                'button_label'  => 'Adaugă grupă',
                'layout'        => 'table',
                'sub_fields'    => [
                    [
                        'key'      => 'field_legenda_slug',
                        'label'    => 'Slug CSS',
                        'name'     => 'slug',
                        'type'     => 'select',
                        'choices'  => $grupa_choices,
                        'required' => 1,
                        'default_value' => 'copii',
                    ],
                    [
                        'key'      => 'field_legenda_nume',
                        'label'    => 'Nume afișat',
                        'name'     => 'nume',
                        'type'     => 'text',
                        'required' => 1,
                    ],
                    [
                        'key'   => 'field_legenda_varsta',
                        'label' => 'Vârstă / descriere',
                        'name'  => 'varsta',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'           => 'field_orar_program',
                'label'         => 'Program săptămânal',
                'name'          => 'orar_program',
                'type'          => 'repeater',
                'instructions'  => 'Un rând = un antrenament. Sistemul grupează automat intrările după zi (indiferent de ordine).',
                'button_label'  => 'Adaugă antrenament',
                'layout'        => 'row',
                'sub_fields'    => [
                    [
                        'key'      => 'field_program_zi',
                        'label'    => 'Zi',
                        'name'     => 'zi',
                        'type'     => 'select',
                        'choices'  => $zile_choices,
                        'required' => 1,
                        'default_value' => 'Luni',
                    ],
                    [
                        'key'      => 'field_program_ora',
                        'label'    => 'Oră',
                        'name'     => 'ora',
                        'type'     => 'text',
                        'required' => 1,
                        'instructions' => 'Ex: "17:00 – 18:00"',
                    ],
                    [
                        'key'      => 'field_program_disciplina',
                        'label'    => 'Disciplină',
                        'name'     => 'disciplina',
                        'type'     => 'text',
                        'required' => 1,
                        'instructions' => 'Ex: "Ju-Jitsu", "TRX Suspension", "Ju-Jitsu Autoapărare"',
                    ],
                    [
                        'key'      => 'field_program_grupa',
                        'label'    => 'Grupă',
                        'name'     => 'grupa',
                        'type'     => 'select',
                        'choices'  => $grupa_choices,
                        'default_value' => 'adulti',
                    ],
                    [
                        'key'   => 'field_program_antrenor',
                        'label' => 'Antrenor',
                        'name'  => 'antrenor',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'           => 'field_orar_nota',
                'label'         => 'Notă sub tabel',
                'name'          => 'orar_nota',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Programul poate suferi modificări în perioada competițiilor sau vacanțelor. Verifică pagina de Facebook sau contactează-ne pentru confirmarea orelor.',
            ],
            [
                'key'           => 'field_orar_cta_titlu',
                'label'         => 'Titlu CTA (jos de tot)',
                'name'          => 'orar_cta_titlu',
                'type'          => 'text',
                'default_value' => 'ALEGE|GRUPA|TA',
                'instructions'  => 'Pipe "|" împarte în segmente; segmentele pare (2, 4, ...) apar italic. "ALEGE|GRUPA|TA" → ALEGE *GRUPA* TA.',
            ],
            [
                'key'           => 'field_orar_cta_text',
                'label'         => 'Text CTA',
                'name'          => 'orar_cta_text',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Prima lecție este gratuită. Vino și descoperă Ju-Jitsu la Kokoro!',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'page-orar.php'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);
    /* ------------------------------------------------------------------
       4. Conținut pagina Tarife (template page-tarife.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_tarife',
        'title'  => 'Conținut pagina Tarife',
        'fields' => [
            [
                'key'           => 'field_tarife_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'tarife_hero_titlu',
                'type'          => 'text',
                'default_value' => 'INVESTIȚIA ÎN|PERFORMANȚĂ',
            ],
            [
                'key'           => 'field_tarife_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'tarife_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Alege pachetul potrivit pentru tine sau copilul tău. Toate abonamentele includ acces la echipament și ghidare personalizată.',
            ],
            [
                'key'           => 'field_tarife_pachete',
                'label'         => 'Pachete',
                'name'          => 'tarife_pachete',
                'type'          => 'repeater',
                'instructions'  => 'Recomandat 3 pachete.',
                'button_label'  => 'Adaugă pachet',
                'layout'        => 'block',
                'sub_fields'    => [
                    [
                        'key'      => 'field_pachet_titlu',
                        'label'    => 'Titlu pachet',
                        'name'     => 'titlu',
                        'type'     => 'text',
                        'required' => 1,
                        'instructions' => 'Ex: „Copii", „Juniori & Adulți", „Personal Training"',
                    ],
                    [
                        'key'      => 'field_pachet_pret',
                        'label'    => 'Preț (doar numărul)',
                        'name'     => 'pret',
                        'type'     => 'number',
                        'required' => 1,
                    ],
                    [
                        'key'           => 'field_pachet_moneda',
                        'label'         => 'Moneda',
                        'name'          => 'moneda',
                        'type'          => 'text',
                        'default_value' => 'lei',
                    ],
                    [
                        'key'           => 'field_pachet_perioada',
                        'label'         => 'Perioadă',
                        'name'          => 'perioada',
                        'type'          => 'text',
                        'default_value' => '/ lună',
                        'instructions'  => 'Ex: „/ lună", „/ ședință", „/ an"',
                    ],
                    [
                        'key'          => 'field_pachet_featured',
                        'label'        => 'Pachet recomandat (evidențiat)',
                        'name'         => 'featured',
                        'type'         => 'true_false',
                        'ui'           => 1,
                        'ui_on_text'   => 'Da',
                        'ui_off_text'  => 'Nu',
                        'instructions' => 'Bifează maxim unul. Va fi evidențiat cu style-ul „featured".',
                    ],
                    [
                        'key'          => 'field_pachet_beneficii',
                        'label'        => 'Beneficii (listă)',
                        'name'         => 'beneficii',
                        'type'         => 'repeater',
                        'button_label' => 'Adaugă beneficiu',
                        'layout'       => 'table',
                        'sub_fields'   => [
                            [
                                'key'      => 'field_beneficiu_text',
                                'label'    => 'Text',
                                'name'     => 'text',
                                'type'     => 'text',
                                'required' => 1,
                            ],
                        ],
                    ],
                    [
                        'key'           => 'field_pachet_buton_text',
                        'label'         => 'Text buton',
                        'name'          => 'buton_text',
                        'type'          => 'text',
                        'default_value' => 'Înscrie-te',
                    ],
                    [
                        'key'           => 'field_pachet_buton_url',
                        'label'         => 'URL buton',
                        'name'          => 'buton_url',
                        'type'          => 'url',
                        'instructions'  => 'Lasă gol pentru a folosi /inscriere/ automat.',
                    ],
                ],
            ],
            [
                'key'           => 'field_tarife_nota',
                'label'         => 'Notă sub pachete',
                'name'          => 'tarife_nota',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Prețurile sunt orientative și pot varia. Pentru tarife actualizate și oferte speciale pentru frați sau grupe, contactează-ne direct.',
            ],
            [
                'key'           => 'field_tarife_cta_titlu',
                'label'         => 'Titlu CTA (jos)',
                'name'          => 'tarife_cta_titlu',
                'type'          => 'text',
                'default_value' => 'PRIMA LECȚIE|E GRATUITĂ',
            ],
            [
                'key'           => 'field_tarife_cta_text',
                'label'         => 'Text CTA',
                'name'          => 'tarife_cta_text',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Vino la o lecție demonstrativă gratuită ca să vezi cum decurge un antrenament Kokoro.',
            ],
            [
                'key'           => 'field_tarife_cta_buton',
                'label'         => 'Text buton CTA',
                'name'          => 'tarife_cta_buton',
                'type'          => 'text',
                'default_value' => 'Programează Lecția Gratuită',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'page-tarife.php'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);

    /* ------------------------------------------------------------------
       4a. Conținut Homepage (pagina setată ca „front page" în Settings → Reading)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_home',
        'title'  => 'Conținut Homepage',
        'fields' => [
            // ---------- Hero ----------
            [
                'key'     => 'field_home_tab_hero',
                'label'   => 'HERO',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_hero_imagine',
                'label'         => 'Imagine fundal hero',
                'name'          => 'home_hero_imagine',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ],
            [
                'key'           => 'field_home_hero_eyebrow',
                'label'         => 'Eyebrow (text mic deasupra titlului)',
                'name'          => 'home_hero_eyebrow',
                'type'          => 'text',
                'default_value' => '01 — Academia',
            ],
            [
                'key'           => 'field_home_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'home_hero_titlu',
                'type'          => 'text',
                'default_value' => 'DEVINO|CAMPION|LA KOKORO',
                'instructions'  => 'Pipe "|" = separator de linie; linia 2, 4... apare italic.',
            ],
            [
                'key'           => 'field_home_hero_subtitlu',
                'label'         => 'Subtitlu',
                'name'          => 'home_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Ju-Jitsu pentru copii, juniori și adulți din 2008. Academie recunoscută MTS și FRAM, cu campioni mondiali în palmares.',
            ],
            [
                'key'           => 'field_home_hero_btn1_text',
                'label'         => 'Buton primar — text',
                'name'          => 'home_hero_btn1_text',
                'type'          => 'text',
                'default_value' => 'Înscrie-te Acum',
            ],
            [
                'key'           => 'field_home_hero_btn1_url',
                'label'         => 'Buton primar — URL',
                'name'          => 'home_hero_btn1_url',
                'type'          => 'url',
                'instructions'  => 'Gol → /inscriere/',
            ],
            [
                'key'           => 'field_home_hero_btn2_text',
                'label'         => 'Buton secundar — text',
                'name'          => 'home_hero_btn2_text',
                'type'          => 'text',
                'default_value' => 'Descoperă Disciplinele',
            ],
            [
                'key'           => 'field_home_hero_btn2_url',
                'label'         => 'Buton secundar — URL',
                'name'          => 'home_hero_btn2_url',
                'type'          => 'url',
                'instructions'  => 'Gol → /discipline/',
            ],
            [
                'key'           => 'field_home_hero_stats',
                'label'         => 'Statistici în bara hero',
                'name'          => 'home_hero_stats',
                'type'          => 'repeater',
                'button_label'  => 'Adaugă statistică',
                'layout'        => 'table',
                'sub_fields'    => [
                    ['key' => 'field_home_stat_numar', 'label' => 'Număr',    'name' => 'numar', 'type' => 'number', 'required' => 1],
                    ['key' => 'field_home_stat_sufix', 'label' => 'Sufix',    'name' => 'sufix', 'type' => 'text'],
                    ['key' => 'field_home_stat_label', 'label' => 'Etichetă', 'name' => 'label', 'type' => 'text',   'required' => 1],
                ],
            ],

            // ---------- Marquee ----------
            [
                'key'     => 'field_home_tab_marquee',
                'label'   => 'MARQUEE (banda derulantă)',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'          => 'field_home_marquee',
                'label'        => 'Elemente marquee',
                'name'         => 'home_marquee',
                'type'         => 'repeater',
                'button_label' => 'Adaugă element',
                'layout'       => 'table',
                'sub_fields'   => [
                    ['key' => 'field_home_marquee_item', 'label' => 'Text', 'name' => 'text', 'type' => 'text', 'required' => 1],
                ],
            ],

            // ---------- Discipline secțiune ----------
            [
                'key'     => 'field_home_tab_discipline',
                'label'   => 'DISCIPLINE',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_disc_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_disc_eyebrow',
                'type'          => 'text',
                'default_value' => '02 — Discipline',
            ],
            [
                'key'           => 'field_home_disc_titlu',
                'label'         => 'Titlu secțiune',
                'name'          => 'home_disc_titlu',
                'type'          => 'text',
                'default_value' => 'CE|ANTRENĂM',
            ],
            [
                'key'           => 'field_home_disc_limit',
                'label'         => 'Câte discipline să afișez',
                'name'          => 'home_disc_limit',
                'type'          => 'number',
                'default_value' => 4,
                'min'           => 1,
                'max'           => 8,
                'instructions'  => 'Cardurile se trag automat din CPT „Discipline" sortate după menu_order.',
            ],

            // ---------- Valori ----------
            [
                'key'     => 'field_home_tab_valori',
                'label'   => 'CALEA KOKORO (valori)',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_valori_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_valori_eyebrow',
                'type'          => 'text',
                'default_value' => '03 — Filozofie',
            ],
            [
                'key'           => 'field_home_valori_titlu',
                'label'         => 'Titlu secțiune',
                'name'          => 'home_valori_titlu',
                'type'          => 'text',
                'default_value' => 'CALEA|KOKORO',
            ],
            [
                'key'           => 'field_home_valori_subtitlu',
                'label'         => 'Text intro',
                'name'          => 'home_valori_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => '„Kokoro" (心) înseamnă Inimă, Spirit, Minte în limba japoneză. Aceste trei principii ne ghidează pe tatami și în viață.',
            ],
            [
                'key'           => 'field_home_valori',
                'label'         => 'Valori',
                'name'          => 'home_valori',
                'type'          => 'repeater',
                'button_label'  => 'Adaugă valoare',
                'layout'        => 'table',
                'sub_fields'    => [
                    ['key' => 'field_valoare_kanji',   'label' => 'Kanji',     'name' => 'kanji',   'type' => 'text', 'required' => 1],
                    ['key' => 'field_valoare_romaji',  'label' => 'Romaji',    'name' => 'romaji',  'type' => 'text', 'required' => 1],
                    ['key' => 'field_valoare_meaning', 'label' => 'Semnificație', 'name' => 'meaning', 'type' => 'textarea', 'rows' => 3, 'required' => 1],
                ],
            ],

            // ---------- Campioni ----------
            [
                'key'     => 'field_home_tab_campioni',
                'label'   => 'CAMPIONI',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_camp_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_camp_eyebrow',
                'type'          => 'text',
                'default_value' => '04 — Campioni',
            ],
            [
                'key'           => 'field_home_camp_titlu',
                'label'         => 'Titlu secțiune',
                'name'          => 'home_camp_titlu',
                'type'          => 'text',
                'default_value' => 'PERFORMANȚĂ|MONDIALĂ',
            ],
            [
                'key'           => 'field_home_camp_subtitlu',
                'label'         => 'Subtitlu lateral',
                'name'          => 'home_camp_subtitlu',
                'type'          => 'text',
                'default_value' => 'REZULTATE DE|EXCEPȚIE',
            ],
            [
                'key'           => 'field_home_camp_text',
                'label'         => 'Text descriere',
                'name'          => 'home_camp_text',
                'type'          => 'textarea',
                'rows'          => 4,
                'default_value' => 'De la înființarea în 2008, sportivii Kokoro au câștigat sute de medalii la competiții naționale și internaționale. Academiei noastre i-au fost recunoscute meritele de către Ministerul Tineretului și Sportului și Federația Română de Arte Marțiale.',
            ],
            [
                'key'           => 'field_home_camp_stats',
                'label'         => 'Statistici campioni',
                'name'          => 'home_camp_stats',
                'type'          => 'repeater',
                'button_label'  => 'Adaugă statistică',
                'layout'        => 'table',
                'sub_fields'    => [
                    ['key' => 'field_home_camp_stat_num',   'label' => 'Număr',    'name' => 'numar', 'type' => 'number', 'required' => 1],
                    ['key' => 'field_home_camp_stat_sufix', 'label' => 'Sufix',    'name' => 'sufix', 'type' => 'text'],
                    ['key' => 'field_home_camp_stat_label', 'label' => 'Etichetă', 'name' => 'label', 'type' => 'text',   'required' => 1],
                ],
            ],
            [
                'key'           => 'field_home_camp_cta',
                'label'         => 'Text buton (spre /campioni)',
                'name'          => 'home_camp_cta',
                'type'          => 'text',
                'default_value' => 'Vezi Toți Campionii',
            ],

            // ---------- Testimoniale ----------
            [
                'key'     => 'field_home_tab_test',
                'label'   => 'TESTIMONIALE',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_test_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_test_eyebrow',
                'type'          => 'text',
                'default_value' => '05 — Recenzii',
            ],
            [
                'key'           => 'field_home_test_titlu',
                'label'         => 'Titlu secțiune',
                'name'          => 'home_test_titlu',
                'type'          => 'text',
                'default_value' => 'CE SPUN|DESPRE NOI',
            ],
            [
                'key'           => 'field_home_test_rating',
                'label'         => 'Rating (număr)',
                'name'          => 'home_test_rating',
                'type'          => 'text',
                'default_value' => '4.8',
            ],
            [
                'key'           => 'field_home_test_rating_label',
                'label'         => 'Text rating',
                'name'          => 'home_test_rating_label',
                'type'          => 'text',
                'default_value' => '96 recenzii Google',
            ],
            [
                'key'           => 'field_home_test',
                'label'         => 'Testimoniale',
                'name'          => 'home_test',
                'type'          => 'repeater',
                'button_label'  => 'Adaugă testimonial',
                'layout'        => 'block',
                'sub_fields'    => [
                    ['key' => 'field_test_text',   'label' => 'Text',    'name' => 'text',   'type' => 'textarea', 'rows' => 4, 'required' => 1],
                    ['key' => 'field_test_autor',  'label' => 'Autor',   'name' => 'autor',  'type' => 'text',     'required' => 1],
                    ['key' => 'field_test_sursa',  'label' => 'Sursă',   'name' => 'sursa',  'type' => 'text',     'default_value' => 'Google Review'],
                ],
            ],

            // ---------- Orar preview ----------
            [
                'key'     => 'field_home_tab_orar',
                'label'   => 'ORAR PREVIEW',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_orar_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_orar_eyebrow',
                'type'          => 'text',
                'default_value' => '06 — Program',
            ],
            [
                'key'           => 'field_home_orar_titlu',
                'label'         => 'Titlu secțiune',
                'name'          => 'home_orar_titlu',
                'type'          => 'text',
                'default_value' => 'ORARUL|ANTRENAMENTELOR',
            ],
            [
                'key'           => 'field_home_orar_limit',
                'label'         => 'Câte rânduri din orar să afișez',
                'name'          => 'home_orar_limit',
                'type'          => 'number',
                'default_value' => 10,
                'min'           => 1,
                'max'           => 50,
                'instructions'  => 'Rândurile sunt trase din pagina Orar (câmpul „Program săptămânal").',
            ],
            [
                'key'           => 'field_home_orar_cta',
                'label'         => 'Text buton (spre /orar)',
                'name'          => 'home_orar_cta',
                'type'          => 'text',
                'default_value' => 'Vezi Orarul Complet',
            ],

            // ---------- CTA înscriere ----------
            [
                'key'     => 'field_home_tab_cta',
                'label'   => 'CTA ÎNSCRIERE',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_cta_eyebrow',
                'label'         => 'Eyebrow',
                'name'          => 'home_cta_eyebrow',
                'type'          => 'text',
                'default_value' => '07 — Început',
            ],
            [
                'key'           => 'field_home_cta_titlu',
                'label'         => 'Titlu',
                'name'          => 'home_cta_titlu',
                'type'          => 'text',
                'default_value' => 'ÎNCEPE|CĂLĂTORIA',
            ],
            [
                'key'           => 'field_home_cta_text',
                'label'         => 'Text',
                'name'          => 'home_cta_text',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Nu contează vârsta, nivelul de experiență sau condiția fizică. Contează să faci primul pas. Înscrierile sunt deschise pentru toate grupele.',
            ],
            [
                'key'           => 'field_home_cta_btn1_text',
                'label'         => 'Buton 1 — text',
                'name'          => 'home_cta_btn1_text',
                'type'          => 'text',
                'default_value' => 'Înscrie-te Acum',
            ],
            [
                'key'           => 'field_home_cta_btn1_url',
                'label'         => 'Buton 1 — URL',
                'name'          => 'home_cta_btn1_url',
                'type'          => 'url',
                'instructions'  => 'Gol → /inscriere/',
            ],
            [
                'key'           => 'field_home_cta_btn2_text',
                'label'         => 'Buton 2 — text',
                'name'          => 'home_cta_btn2_text',
                'type'          => 'text',
                'default_value' => 'Contactează-ne',
            ],
            [
                'key'           => 'field_home_cta_btn2_url',
                'label'         => 'Buton 2 — URL',
                'name'          => 'home_cta_btn2_url',
                'type'          => 'url',
                'instructions'  => 'Gol → /contact/',
            ],

            // ---------- JP Quote ----------
            [
                'key'     => 'field_home_tab_jp',
                'label'   => 'CITAT JAPONEZ (pre-footer)',
                'type'    => 'tab',
                'placement' => 'left',
            ],
            [
                'key'           => 'field_home_jp_kanji',
                'label'         => 'Kanji',
                'name'          => 'home_jp_kanji',
                'type'          => 'text',
                'default_value' => '「継続は力なり」',
            ],
            [
                'key'           => 'field_home_jp_romaji',
                'label'         => 'Romaji',
                'name'          => 'home_jp_romaji',
                'type'          => 'text',
                'default_value' => 'Keizoku wa chikara nari',
            ],
            [
                'key'           => 'field_home_jp_traducere',
                'label'         => 'Traducere',
                'name'          => 'home_jp_traducere',
                'type'          => 'text',
                'default_value' => 'Perseverența este forță',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_type', 'operator' => '==', 'value' => 'front_page'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);

    /* ------------------------------------------------------------------
       4b. Conținut pagina Discipline (template page-discipline.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_discipline',
        'title'  => 'Conținut pagina Discipline',
        'fields' => [
            [
                'key'           => 'field_discipline_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'discipline_hero_titlu',
                'type'          => 'text',
                'default_value' => 'ARTA|LUPTEI|NOBILE',
            ],
            [
                'key'           => 'field_discipline_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'discipline_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'De la Ju-Jitsu competițional la autoapărare și pregătire fizică — descoperă disciplinele Kokoro Brașov Academy.',
            ],
            [
                'key'           => 'field_discipline_jp_kanji',
                'label'         => 'Citat japonez - kanji',
                'name'          => 'discipline_jp_kanji',
                'type'          => 'text',
                'default_value' => '「柔よく剛を制す」',
            ],
            [
                'key'           => 'field_discipline_jp_romaji',
                'label'         => 'Citat japonez - romaji',
                'name'          => 'discipline_jp_romaji',
                'type'          => 'text',
                'default_value' => 'Ju yoku go wo seisu',
            ],
            [
                'key'           => 'field_discipline_jp_traducere',
                'label'         => 'Citat japonez - traducere',
                'name'          => 'discipline_jp_traducere',
                'type'          => 'text',
                'default_value' => 'Blândețea controlează duritatea — filozofia Ju-Jitsu',
            ],
            [
                'key'           => 'field_discipline_arata_centuri',
                'label'         => 'Arată secțiunea Centuri',
                'name'          => 'discipline_arata_centuri',
                'type'          => 'true_false',
                'ui'            => 1,
                'ui_on_text'    => 'Da',
                'ui_off_text'   => 'Nu',
                'default_value' => 1,
            ],
            [
                'key'           => 'field_discipline_cta_titlu',
                'label'         => 'Titlu CTA',
                'name'          => 'discipline_cta_titlu',
                'type'          => 'text',
                'default_value' => 'ALEGE|DISCIPLINA|TA',
            ],
            [
                'key'           => 'field_discipline_cta_text',
                'label'         => 'Text CTA',
                'name'          => 'discipline_cta_text',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Nu știi ce ți se potrivește? Vino la o lecție demonstrativă gratuită și descoperă!',
            ],
            [
                'key'           => 'field_discipline_cta_buton',
                'label'         => 'Text buton CTA',
                'name'          => 'discipline_cta_buton',
                'type'          => 'text',
                'default_value' => 'Programează Lecția Gratuită',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'page-discipline.php'],
            ],
        ],
        'menu_order'      => 0,
        'position'        => 'normal',
        'style'           => 'default',
        'label_placement' => 'top',
        'active'          => true,
    ]);

    /* ------------------------------------------------------------------
       5. Conținut pagina Galerie (template page-galerie.php)
       ------------------------------------------------------------------ */
    acf_add_local_field_group([
        'key'    => 'group_kokoro_pagina_galerie',
        'title'  => 'Conținut pagina Galerie',
        'fields' => [
            [
                'key'           => 'field_galerie_hero_titlu',
                'label'         => 'Titlu hero',
                'name'          => 'galerie_hero_titlu',
                'type'          => 'text',
                'default_value' => 'MOMENTE|KOKORO',
            ],
            [
                'key'           => 'field_galerie_hero_subtitlu',
                'label'         => 'Subtitlu hero',
                'name'          => 'galerie_hero_subtitlu',
                'type'          => 'textarea',
                'rows'          => 3,
                'default_value' => 'Antrenamente, competiții, tabere și momente de bucurie — viața la Kokoro Brașov Academy în imagini.',
            ],
            [
                'key'           => 'field_galerie_imagini',
                'label'         => 'Imagini',
                'name'          => 'galerie_imagini',
                'type'          => 'repeater',
                'instructions'  => 'Adaugă imagini una câte una. Folosește „Add Row" sau trage-le în ordine.',
                'button_label'  => 'Adaugă imagine',
                'layout'        => 'block',
                'sub_fields'    => [
                    [
                        'key'           => 'field_galerie_imagine',
                        'label'         => 'Imagine',
                        'name'          => 'imagine',
                        'type'          => 'image',
                        'return_format' => 'array',
                        'preview_size'  => 'medium',
                        'required'      => 1,
                    ],
                    [
                        'key'   => 'field_galerie_caption',
                        'label' => 'Caption (opțional)',
                        'name'  => 'caption',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'           => 'field_galerie_cta_text',
                'label'         => 'Text sub galerie',
                'name'          => 'galerie_cta_text',
                'type'          => 'textarea',
                'rows'          => 2,
                'default_value' => 'Mai multe fotografii și videoclipuri pe pagina noastră de Facebook.',
            ],
            [
                'key'           => 'field_galerie_cta_buton',
                'label'         => 'Text buton',
                'name'          => 'galerie_cta_buton',
                'type'          => 'text',
                'default_value' => 'Vezi pe Facebook',
            ],
            [
                'key'           => 'field_galerie_cta_url',
                'label'         => 'URL buton',
                'name'          => 'galerie_cta_url',
                'type'          => 'url',
                'default_value' => 'https://www.facebook.com/kokorobrasovacademy',
            ],
        ],
        'location' => [
            [
                ['param' => 'page_template', 'operator' => '==', 'value' => 'page-galerie.php'],
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
 * Helper: întoarce o setare globală din pagina ACF „Setări Kokoro".
 * Fallback la $default dacă ACF nu e activ sau câmpul e gol.
 *
 * @param string $name    Numele câmpului ACF (fără prefixul „set_" — îl adaugă funcția).
 * @param string $default Valoare default.
 * @return string
 */
function kokoro_setting($name, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    $val = get_field('set_' . $name, 'option');
    if ($val === null || $val === false || $val === '' || (is_array($val) && empty($val))) {
        return $default;
    }
    // Defaultul indică tipul așteptat — păstrează tipul când default e string
    return is_string($default) ? (string) $val : $val;
}

/**
 * Helper: întoarce pagina care folosește un template anume.
 *
 * @param string $template Ex: "page-orar.php".
 * @return WP_Post|null
 */
function kokoro_get_page_by_template($template) {
    static $cache = [];
    if (isset($cache[$template])) {
        return $cache[$template];
    }
    $pages = get_posts([
        'post_type'      => 'page',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => $template,
    ]);
    $cache[$template] = $pages[0] ?? null;
    return $cache[$template];
}

/**
 * Helper: randează un titlu de tip "FOO|BAR|BAZ" cu segmentele impare (1, 3, ...)
 * în <em>. Separator între segmente, configurabil.
 *
 * @param string $text      Textul cu | ca separator.
 * @param string $separator Ce inserezi între segmente (ex: "<br>" sau " ").
 * @return string HTML escape-uit.
 */
function kokoro_render_italic_title($text, $separator = '<br>') {
    $parts = explode('|', $text);
    $out   = '';
    foreach ($parts as $i => $part) {
        if ($i > 0) {
            $out .= $separator;
        }
        $escaped = esc_html($part);
        $out   .= ($i % 2 === 1) ? "<em>{$escaped}</em>" : $escaped;
    }
    return $out;
}

/**
 * Helper: ordonează rândurile din program după ziua săptămânii.
 *
 * @param array $program Repeater orar_program.
 * @return array Sortat, preserving ordinea user-ului în cadrul aceleiași zile (stable sort).
 */
function kokoro_sort_program_by_day($program) {
    if (!is_array($program)) {
        return [];
    }
    $day_order = [
        'Luni' => 1, 'Marți' => 2, 'Miercuri' => 3, 'Joi' => 4,
        'Vineri' => 5, 'Sâmbătă' => 6, 'Duminică' => 7,
    ];
    $indexed = [];
    foreach ($program as $i => $row) {
        $indexed[] = [$i, $day_order[$row['zi'] ?? ''] ?? 99, $row];
    }
    usort($indexed, function ($a, $b) {
        return $a[1] <=> $b[1] ?: $a[0] <=> $b[0];
    });
    return array_map(fn($entry) => $entry[2], $indexed);
}

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
