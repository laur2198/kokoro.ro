<?php
/**
 * ACF: Conținut Homepage (front-page.php)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_page_homepage() {
    if (!function_exists('acf_add_local_field_group')) return;

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
                'default_value' => 'Ju-Jitsu pentru copii, juniori și adulți din 2008. Academie recunoscută Agenția Națională pentru Sport și Federația Română de Arte Marțiale, cu campioni mondiali și europeni în palmares.',
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
                    [
                        'key'           => 'field_test_consimtamant',
                        'label'         => 'Consimțământ publicare schema',
                        'name'          => 'consimtamant_publicare',
                        'type'          => 'true_false',
                        'ui'            => 1,
                        'ui_on_text'    => 'Da',
                        'ui_off_text'   => 'Nu',
                        'default_value' => 0,
                        'instructions'  => 'Bifează DOAR dacă ai consimțământ scris al autorului. Doar testimonialele bifate intră în schema.org Review (vizibile în Google Knowledge Graph).',
                    ],
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
}
add_action('acf/init', 'kokoro_acf_register_page_homepage');
