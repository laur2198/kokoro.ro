<?php
/**
 * ACF: Conținut Pagină Pilon (page-pillar.php)
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_acf_register_pillars() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'    => 'group_kokoro_pillar',
        'title'  => 'Conținut Pagină Pilon (SEO)',
        'fields' => [
            // ============ SCHEMA ============
            ['key' => 'field_pl_tab_schema', 'label' => 'SCHEMA', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_schema_type', 'name' => 'pl_schema_type', 'label' => 'Tip schema JSON-LD', 'type' => 'select', 'choices' => ['course' => 'Course (curs sportiv — Ju-Jitsu, autoapărare)', 'service' => 'Service (serviciu — personal training, consultanță)', 'article' => 'Article (ghid editorial — comparativ arte marțiale, blog SEO)'], 'default_value' => 'course', 'instructions' => 'Determină schema Schema.org randată automat în footer. Course = recomandat default. Service = pentru pagini gen personal-trainer. Article = pentru ghiduri editoriale lungi.'],

            // ============ HERO ============
            ['key' => 'field_pl_tab_hero', 'label' => 'HERO', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_hero_eyebrow',   'name' => 'pl_hero_eyebrow',   'label' => 'Eyebrow (categorie)', 'type' => 'text', 'instructions' => 'Ex: „Pentru copii (4-15 ani)" — apare deasupra titlului.'],
            ['key' => 'field_pl_hero_titlu',     'name' => 'pl_hero_titlu',     'label' => 'Titlu (H1)',          'type' => 'text', 'instructions' => 'Pipe „|" pentru break-line. Ex: „Ju-Jitsu pentru Copii|Brașov".'],
            ['key' => 'field_pl_hero_subtitlu',  'name' => 'pl_hero_subtitlu',  'label' => 'Subtitlu',            'type' => 'textarea', 'rows' => 3, 'instructions' => '1-2 fraze. 150-200 caractere ideal pentru SEO.'],
            ['key' => 'field_pl_hero_imagine',   'name' => 'pl_hero_imagine',   'label' => 'Imagine fundal',      'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => 'Opțional. Recomandat 1920×1080.'],
            ['key' => 'field_pl_hero_btn1_text', 'name' => 'pl_hero_btn1_text', 'label' => 'Buton primar — text', 'type' => 'text', 'default_value' => 'Antrenament Gratuit de Probă'],
            ['key' => 'field_pl_hero_btn1_url',  'name' => 'pl_hero_btn1_url',  'label' => 'Buton primar — URL',  'type' => 'url', 'instructions' => 'Gol → /inscriere/'],
            ['key' => 'field_pl_hero_btn2_text', 'name' => 'pl_hero_btn2_text', 'label' => 'Buton secundar — text','type' => 'text', 'default_value' => 'Sună acum'],
            ['key' => 'field_pl_hero_btn2_url',  'name' => 'pl_hero_btn2_url',  'label' => 'Buton secundar — URL', 'type' => 'text', 'instructions' => 'Lasă „tel:" pentru telefon, gol → telefon din Setări Kokoro.'],

            // ============ INTRO ============
            ['key' => 'field_pl_tab_intro', 'label' => 'INTRO', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_intro_titlu', 'name' => 'pl_intro_titlu', 'label' => 'Titlu secțiune intro', 'type' => 'text', 'instructions' => 'Lasă gol pentru a sări secțiunea.'],
            ['key' => 'field_pl_intro_text',  'name' => 'pl_intro_text',  'label' => 'Text intro (150-200 cuv)', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'instructions' => 'Conține keyword-ul principal în primele 100 cuvinte. Important pentru SEO.'],

            // ============ BENEFICII ============
            ['key' => 'field_pl_tab_benef', 'label' => 'BENEFICII', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_benef_titlu', 'name' => 'pl_benef_titlu', 'label' => 'Titlu secțiune', 'type' => 'text', 'instructions' => 'Lasă gol pentru a sări.'],
            ['key' => 'field_pl_benef',       'name' => 'pl_benef',       'label' => 'Beneficii (5-7 recomandate)', 'type' => 'repeater', 'button_label' => 'Adaugă beneficiu', 'layout' => 'row', 'sub_fields' => [
                ['key' => 'field_pl_benef_icon',  'label' => 'Iconiță / emoji', 'name' => 'icon',     'type' => 'text', 'instructions' => 'Ex: 🥋 sau kanji 武 sau lasă gol.'],
                ['key' => 'field_pl_benef_titlu', 'label' => 'Titlu',           'name' => 'titlu',    'type' => 'text', 'required' => 1],
                ['key' => 'field_pl_benef_descr', 'label' => 'Descriere',       'name' => 'descriere','type' => 'textarea', 'rows' => 3],
            ]],

            // ============ CE ÎNVAȚĂ ============
            ['key' => 'field_pl_tab_inv', 'label' => 'CE ÎNVAȚĂ', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_inv_titlu', 'name' => 'pl_inv_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_inv_intro', 'name' => 'pl_inv_intro', 'label' => 'Text scurt deasupra listei', 'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_pl_inv',       'name' => 'pl_inv',       'label' => 'Lucruri pe care le învață', 'type' => 'repeater', 'button_label' => 'Adaugă punct', 'layout' => 'table', 'sub_fields' => [
                ['key' => 'field_pl_inv_text', 'label' => 'Punct', 'name' => 'text', 'type' => 'text', 'required' => 1],
            ]],

            // ============ PROGRAM PE GRUPE ============
            ['key' => 'field_pl_tab_grupe', 'label' => 'GRUPE DE VÂRSTĂ', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_grupe_titlu', 'name' => 'pl_grupe_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_grupe',       'name' => 'pl_grupe',       'label' => 'Grupe', 'type' => 'repeater', 'button_label' => 'Adaugă grupă', 'layout' => 'block', 'sub_fields' => [
                ['key' => 'field_pl_grupa_nume',  'label' => 'Nume grupă',    'name' => 'nume',     'type' => 'text', 'required' => 1, 'instructions' => 'Ex: „Copii 4-7 ani"'],
                ['key' => 'field_pl_grupa_descr', 'label' => 'Descriere',     'name' => 'descriere','type' => 'textarea', 'rows' => 3],
                ['key' => 'field_pl_grupa_freq',  'label' => 'Frecvență',     'name' => 'frecventa','type' => 'text', 'instructions' => 'Ex: „2 antrenamente/săpt × 60 min"'],
            ]],

            // ============ DESFĂȘURARE ============
            ['key' => 'field_pl_tab_desf', 'label' => 'CUM SE DESFĂȘOARĂ', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_desf_titlu',   'name' => 'pl_desf_titlu',   'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_desf_text',    'name' => 'pl_desf_text',    'label' => 'Descriere narativă (200 cuv)', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0],
            ['key' => 'field_pl_desf_imagine', 'name' => 'pl_desf_imagine', 'label' => 'Imagine antrenament', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'],

            // ============ ECHIPAMENT ============
            ['key' => 'field_pl_tab_echip', 'label' => 'ECHIPAMENT', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_echip_titlu', 'name' => 'pl_echip_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_echip',       'name' => 'pl_echip',       'label' => 'Listă echipament necesar', 'type' => 'repeater', 'button_label' => 'Adaugă item', 'layout' => 'table', 'sub_fields' => [
                ['key' => 'field_pl_echip_item', 'label' => 'Item', 'name' => 'text', 'type' => 'text', 'required' => 1],
            ]],

            // ============ PREȚURI ============
            ['key' => 'field_pl_tab_pret', 'label' => 'PREȚURI', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_pret_titlu', 'name' => 'pl_pret_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_pret_text',  'name' => 'pl_pret_text',  'label' => 'Text preț', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'instructions' => 'Poți insera preț + linkul către pagina /tarife/.'],

            // ============ DIFERENȚIATOR ============
            ['key' => 'field_pl_tab_dif', 'label' => 'CE NE DIFERENȚIAZĂ', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_dif_titlu', 'name' => 'pl_dif_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_dif',       'name' => 'pl_dif',       'label' => 'Puncte diferențiator', 'type' => 'repeater', 'button_label' => 'Adaugă punct', 'layout' => 'row', 'sub_fields' => [
                ['key' => 'field_pl_dif_titlu', 'label' => 'Titlu',      'name' => 'titlu',     'type' => 'text', 'required' => 1],
                ['key' => 'field_pl_dif_descr', 'label' => 'Descriere',  'name' => 'descriere', 'type' => 'textarea', 'rows' => 3],
            ]],

            // ============ TESTIMONIALE ============
            ['key' => 'field_pl_tab_test', 'label' => 'TESTIMONIALE', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_test_titlu', 'name' => 'pl_test_titlu', 'label' => 'Titlu secțiune', 'type' => 'text'],
            ['key' => 'field_pl_test',       'name' => 'pl_test',       'label' => 'Testimoniale (3-5 recomandate)', 'type' => 'repeater', 'button_label' => 'Adaugă testimonial', 'layout' => 'block', 'sub_fields' => [
                ['key' => 'field_pl_test_text',  'label' => 'Text',                'name' => 'text',  'type' => 'textarea', 'rows' => 4, 'required' => 1],
                ['key' => 'field_pl_test_autor', 'label' => 'Autor',               'name' => 'autor', 'type' => 'text', 'required' => 1],
                ['key' => 'field_pl_test_meta',  'label' => 'Meta (vârstă copil)', 'name' => 'meta',  'type' => 'text', 'instructions' => 'Ex: „mama lui Andrei, 8 ani". Apare sub nume.'],
                [
                    'key'           => 'field_pl_test_consimtamant',
                    'label'         => 'Consimțământ publicare schema',
                    'name'          => 'consimtamant_publicare',
                    'type'          => 'true_false',
                    'ui'            => 1,
                    'ui_on_text'    => 'Da',
                    'ui_off_text'   => 'Nu',
                    'default_value' => 0,
                    'instructions'  => 'Bifează DOAR dacă ai consimțământ scris al autorului. Doar testimonialele bifate intră în schema.org Review.',
                ],
            ]],

            // ============ INSTRUCTORI ============
            ['key' => 'field_pl_tab_instr', 'label' => 'INSTRUCTORI', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_instr_titlu', 'name' => 'pl_instr_titlu', 'label' => 'Titlu secțiune', 'type' => 'text', 'instructions' => 'Lasă gol pentru a ascunde secțiunea.'],
            ['key' => 'field_pl_instr_limit', 'name' => 'pl_instr_limit', 'label' => 'Câți antrenori să afișez', 'type' => 'number', 'default_value' => 0, 'min' => 0, 'max' => 12, 'instructions' => '0 = ascunde. Antrenorii vin din CPT, sortați după menu_order.'],

            // ============ LOCAȚIE ============
            ['key' => 'field_pl_tab_loc', 'label' => 'LOCAȚIE', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_loc_titlu', 'name' => 'pl_loc_titlu', 'label' => 'Titlu secțiune', 'type' => 'text', 'instructions' => 'Lasă gol pentru a ascunde.'],
            ['key' => 'field_pl_loc_text',  'name' => 'pl_loc_text',  'label' => 'Text adresă (opțional)', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Lasă gol → folosește adresa din Setări Kokoro.'],

            // ============ CTA FINAL ============
            ['key' => 'field_pl_tab_cta', 'label' => 'CTA FINAL', 'type' => 'tab', 'placement' => 'left'],
            ['key' => 'field_pl_cta_titlu', 'name' => 'pl_cta_titlu', 'label' => 'Titlu',         'type' => 'text', 'default_value' => 'GATA SĂ ÎNCEPI?'],
            ['key' => 'field_pl_cta_text',  'name' => 'pl_cta_text',  'label' => 'Text',          'type' => 'textarea', 'rows' => 2, 'default_value' => 'Programează antrenamentul gratuit de probă. Te contactăm în 24h.'],
            ['key' => 'field_pl_cta_btn',   'name' => 'pl_cta_btn',   'label' => 'Text buton',    'type' => 'text', 'default_value' => 'Înscrie-te Acum'],
        ],
        'location' => [
            [['param' => 'page_template', 'operator' => '==', 'value' => 'page-pillar.php']],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
    ]);
}
add_action('acf/init', 'kokoro_acf_register_pillars');
