<?php
/**
 * ACF: Setări Globale Site (options page)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_settings() {
    if (!function_exists('acf_add_local_field_group')) return;

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
            ['key' => 'field_set_whatsapp_numar',  'label' => 'Număr WhatsApp', 'name' => 'set_whatsapp_numar',  'type' => 'text', 'default_value' => '40742037973', 'instructions' => 'Doar cifrele cu prefixul țării, fără +. Ex: 40742037973 (pentru +40 742 037 973). Lasă gol pentru a ascunde butonul WhatsApp.'],
            ['key' => 'field_set_whatsapp_arata',  'label' => 'Arată butonul flotant',  'name' => 'set_whatsapp_arata',  'type' => 'true_false', 'ui' => 1, 'ui_on_text' => 'Da', 'ui_off_text' => 'Nu', 'default_value' => 1],

            // Header
            ['key' => 'field_set_tab_header', 'label' => 'HEADER', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_header_cta_text', 'label' => 'Text buton CTA navbar', 'name' => 'set_header_cta_text', 'type' => 'text', 'default_value' => 'Înscrie-te'],
            ['key' => 'field_set_header_cta_url',  'label' => 'URL buton CTA navbar',  'name' => 'set_header_cta_url',  'type' => 'url',  'instructions' => 'Gol → /inscriere/'],
            ['key' => 'field_set_meta_descriere', 'label' => 'Meta descriere site', 'name' => 'set_meta_descriere', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Kokoro Brașov Academy — Ju-Jitsu pentru copii, juniori și adulți din 2008. Campioni mondiali, antrenori dedicați.', 'instructions' => 'Folosit în <meta name="description"> când nu există un SEO plugin.'],

            // Footer
            ['key' => 'field_set_tab_footer', 'label' => 'FOOTER', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_set_footer_descriere', 'label' => 'Descriere brand (footer coloana 1)', 'name' => 'set_footer_descriere', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'Kokoro Brașov Academy — academie de Ju-Jitsu fondată în 2008. Recunoscută de Agenția Națională pentru Sport și Federația Română de Arte Marțiale. Formăm campioni și caractere puternice prin disciplină, respect și perseverență.'],
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
}
add_action('acf/init', 'kokoro_acf_register_settings');
