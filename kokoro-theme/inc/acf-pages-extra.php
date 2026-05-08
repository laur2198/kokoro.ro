<?php
/**
 * ACF Field Groups for additional pages
 * - Formulare
 * - Regulament Intern
 * - Calendar Competițional
 * - Contact (overrides)
 * - FAQ (categories + items repeater)
 *
 * @package Kokoro
 */

if (!defined('ABSPATH')) { exit; }

/**
 * Helper pentru pagini pillar: returnează valoarea ACF override
 * sau fallback-ul (textul hardcoded).
 */
if (!function_exists('kokoro_pillar_ovr')) {
    function kokoro_pillar_ovr($field_name, $default = '') {
        if (!function_exists('get_field')) return $default;
        $val = get_field($field_name);
        if (is_string($val) && trim($val) !== '') return $val;
        return $default;
    }
}

function kokoro_acf_register_pages_extra() {
    if (!function_exists('acf_add_local_field_group')) return;

    // =========================================================================
    // FORMULARE
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_formulare',
        'title'    => 'Conținut pagina Formulare',
        'fields'   => [
            ['key' => 'field_formulare_hero_eyebrow',  'label' => 'Eyebrow',  'name' => 'formulare_hero_eyebrow',  'type' => 'text', 'default_value' => 'Formulare'],
            ['key' => 'field_formulare_hero_titlu',    'label' => 'Titlu',    'name' => 'formulare_hero_titlu',    'type' => 'text', 'default_value' => 'FORMULARE|ÎNSCRIERE', 'instructions' => 'Pipe "|" = separator linie. Linia 2 apare italic.'],
            ['key' => 'field_formulare_hero_subtitlu', 'label' => 'Subtitlu', 'name' => 'formulare_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Descarcă, completează și semnează formularele necesare pentru înscriere în Academia Kokoro Brașov.'],
            [
                'key' => 'field_formulare_lista', 'label' => 'Formulare descărcabile', 'name' => 'formulare_lista',
                'type' => 'repeater', 'button_label' => 'Adaugă formular', 'layout' => 'block',
                'sub_fields' => [
                    ['key' => 'field_form_icon',       'label' => 'Icon (emoji)',  'name' => 'icon',       'type' => 'text', 'default_value' => '📄'],
                    ['key' => 'field_form_titlu',      'label' => 'Titlu',         'name' => 'titlu',      'type' => 'text', 'required' => 1],
                    ['key' => 'field_form_descriere',  'label' => 'Descriere',     'name' => 'descriere',  'type' => 'textarea', 'rows' => 3],
                    ['key' => 'field_form_fisier',    'label' => 'URL fișier',    'name' => 'fisier_url',  'type' => 'url', 'instructions' => 'Link direct sau pagina de descărcare'],
                    ['key' => 'field_form_buton',     'label' => 'Text buton',     'name' => 'buton_text',  'type' => 'text', 'default_value' => 'Descarcă'],
                ],
            ],
            [
                'key' => 'field_formulare_instructiuni', 'label' => 'Pași de procedură', 'name' => 'formulare_instructiuni',
                'type' => 'repeater', 'button_label' => 'Adaugă pas', 'layout' => 'table',
                'sub_fields' => [
                    ['key' => 'field_instr_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2, 'required' => 1, 'instructions' => 'HTML basic permis (strong, em, a)'],
                ],
            ],
            [
                'key' => 'field_formulare_dosar', 'label' => 'Dosar complet (listă)', 'name' => 'formulare_dosar',
                'type' => 'repeater', 'button_label' => 'Adaugă element', 'layout' => 'table',
                'sub_fields' => [
                    ['key' => 'field_dosar_text', 'label' => 'Element', 'name' => 'text', 'type' => 'text', 'required' => 1],
                ],
            ],
            ['key' => 'field_formulare_cta_titlu', 'label' => 'CTA titlu', 'name' => 'formulare_cta_titlu', 'type' => 'text', 'default_value' => 'AI NEVOIE DE|AJUTOR?'],
            ['key' => 'field_formulare_cta_text',  'label' => 'CTA text',  'name' => 'formulare_cta_text',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'Te ajutăm să completezi corect dosarul. Sună-ne sau scrie-ne pe WhatsApp.'],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-formulare.php']]],
    ]);

    // =========================================================================
    // REGULAMENT INTERN
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_regulament',
        'title'    => 'Conținut pagina Regulament',
        'fields'   => [
            ['key' => 'field_regulament_hero_eyebrow',  'label' => 'Eyebrow',  'name' => 'regulament_hero_eyebrow',  'type' => 'text', 'default_value' => 'Regulament'],
            ['key' => 'field_regulament_hero_titlu',    'label' => 'Titlu',    'name' => 'regulament_hero_titlu',    'type' => 'text', 'default_value' => 'REGULAMENT DE|ORDINE INTERIOARĂ'],
            ['key' => 'field_regulament_hero_subtitlu', 'label' => 'Subtitlu', 'name' => 'regulament_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Regulile clubului C.S. Kokoro Brașov — disciplină, înscriere, examene de grad și principii fundamentale.'],
            ['key' => 'field_regulament_intro',         'label' => 'Intro (introducere)', 'name' => 'regulament_intro', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0],
            [
                'key' => 'field_regulament_articole', 'label' => 'Articole regulament', 'name' => 'regulament_articole',
                'type' => 'repeater', 'button_label' => 'Adaugă articol', 'layout' => 'block',
                'sub_fields' => [
                    ['key' => 'field_art_titlu',   'label' => 'Titlu articol',   'name' => 'titlu',   'type' => 'text', 'required' => 1, 'instructions' => 'Ex: „Art. 1 — Înscrierea"'],
                    ['key' => 'field_art_continut','label' => 'Conținut',        'name' => 'continut','type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'required' => 1],
                ],
            ],
            ['key' => 'field_regulament_nota',     'label' => 'Notă jos',  'name' => 'regulament_nota',     'type' => 'textarea', 'rows' => 3, 'default_value' => 'Acest Regulament de Ordine Interioară a fost aprobat și semnat în ședința consiliului director din data de 15.08.2013.'],
            ['key' => 'field_regulament_semnatar', 'label' => 'Semnatar',  'name' => 'regulament_semnatar', 'type' => 'text',     'default_value' => 'Președinte Academie — Lucian Bogluț'],
            ['key' => 'field_regulament_cta_titlu','label' => 'CTA titlu', 'name' => 'regulament_cta_titlu','type' => 'text',     'default_value' => 'AI ÎNTREBĂRI|DESPRE REGULAMENT?'],
            ['key' => 'field_regulament_cta_text', 'label' => 'CTA text',  'name' => 'regulament_cta_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Suntem aici să te ajutăm să înțelegi cum funcționează academia. Contactează-ne pentru orice clarificare.'],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-regulament.php']]],
    ]);

    // =========================================================================
    // CALENDAR COMPETIȚIONAL
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_calendar',
        'title'    => 'Conținut pagina Calendar Competițional',
        'fields'   => [
            ['key' => 'field_calendar_hero_eyebrow',  'label' => 'Eyebrow',  'name' => 'calendar_hero_eyebrow',  'type' => 'text', 'default_value' => 'Calendar'],
            ['key' => 'field_calendar_hero_titlu',    'label' => 'Titlu',    'name' => 'calendar_hero_titlu',    'type' => 'text', 'default_value' => 'CALENDAR|COMPETIȚIONAL'],
            ['key' => 'field_calendar_hero_subtitlu', 'label' => 'Subtitlu', 'name' => 'calendar_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Competițiile la care participă Academia Kokoro Brașov în acest an.'],
            [
                'key' => 'field_calendar_competitii', 'label' => 'Competiții', 'name' => 'calendar_competitii',
                'type' => 'repeater', 'button_label' => 'Adaugă competiție', 'layout' => 'block',
                'sub_fields' => [
                    ['key' => 'field_comp_titlu',     'label' => 'Titlu competiție',  'name' => 'titlu',     'type' => 'text', 'required' => 1],
                    ['key' => 'field_comp_data',      'label' => 'Data',              'name' => 'data',      'type' => 'text', 'instructions' => 'Ex: „15-17 Mai 2026"'],
                    ['key' => 'field_comp_locatie',   'label' => 'Locație',           'name' => 'locatie',   'type' => 'text', 'instructions' => 'Ex: „Brașov, România"'],
                    ['key' => 'field_comp_tip',       'label' => 'Tip',               'name' => 'tip',       'type' => 'select', 'choices' => ['national' => 'Național', 'balcanic' => 'Balcanic', 'european' => 'European', 'mondial' => 'Mondial'], 'default_value' => 'national'],
                    ['key' => 'field_comp_descriere', 'label' => 'Descriere',         'name' => 'descriere', 'type' => 'textarea', 'rows' => 2],
                    ['key' => 'field_comp_link',      'label' => 'Link detalii',      'name' => 'link',      'type' => 'url'],
                ],
            ],
            ['key' => 'field_calendar_nota',      'label' => 'Notă jos',  'name' => 'calendar_nota',      'type' => 'textarea', 'rows' => 2, 'default_value' => 'Programul poate suferi modificări. Pentru ultimele actualizări, contactează-ne.'],
            ['key' => 'field_calendar_cta_titlu', 'label' => 'CTA titlu', 'name' => 'calendar_cta_titlu', 'type' => 'text',     'default_value' => 'VREI SĂ|CONCUREZI?'],
            ['key' => 'field_calendar_cta_text',  'label' => 'CTA text',  'name' => 'calendar_cta_text',  'type' => 'textarea', 'rows' => 2, 'default_value' => 'Pregătirea pentru competiție începe în sala Kokoro. Înscrie-te la grupa de performanță și vino să ne cunoști.'],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-calendar-competitional.php']]],
    ]);

    // =========================================================================
    // CONTACT — overrides
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_contact',
        'title'    => 'Conținut pagina Contact',
        'fields'   => [
            ['key' => 'field_contact_hero_titlu', 'label' => 'Titlu hero',     'name' => 'contact_hero_titlu', 'type' => 'text',     'default_value' => 'IA|LEGĂTURA|CU NOI', 'instructions' => 'Pipe "|" = separator linie. Linia 2 apare italic.'],
            ['key' => 'field_contact_landmark',   'label' => 'Landmark adresă','name' => 'contact_landmark',   'type' => 'textarea', 'rows' => 2, 'default_value' => 'Parcul Industrial METROM — deasupra service-ului auto, lângă Pensiunea „Floarea Soarelui"'],
            ['key' => 'field_contact_drum',       'label' => 'Cum ajungi',     'name' => 'contact_drum',       'type' => 'textarea', 'rows' => 3, 'default_value' => 'Intrarea se face pe poarta principală a uzinei METROM. După poartă, mergeți drept înainte 50 m, apoi la indicatorul rutier STOP, faceți dreapta 100 m.'],
            ['key' => 'field_contact_program',    'label' => 'Program (HTML)', 'name' => 'contact_program',    'type' => 'textarea', 'rows' => 3, 'new_lines' => 'br', 'default_value' => 'Luni – Vineri: 16:00 – 21:00<br>Sâmbătă: după programare'],
            ['key' => 'field_contact_form_titlu', 'label' => 'Titlu formular', 'name' => 'contact_form_titlu', 'type' => 'text',     'default_value' => 'TRIMITE-NE|UN MESAJ'],
            [
                'key' => 'field_contact_form_subiecte', 'label' => 'Subiecte formular contact', 'name' => 'contact_form_subiecte',
                'type' => 'repeater', 'button_label' => 'Adaugă subiect', 'layout' => 'table',
                'sub_fields' => [
                    ['key' => 'field_subiect_value', 'label' => 'Value (slug)', 'name' => 'value', 'type' => 'text', 'required' => 1, 'instructions' => 'Ex: „inscriere", „informatii"'],
                    ['key' => 'field_subiect_label', 'label' => 'Label afișat', 'name' => 'label', 'type' => 'text', 'required' => 1],
                ],
            ],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php']]],
    ]);

    // =========================================================================
    // FAQ
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_faq',
        'title'    => 'Conținut pagina FAQ',
        'fields'   => [
            ['key' => 'field_faq_hero_eyebrow',  'label' => 'Eyebrow',         'name' => 'faq_hero_eyebrow',  'type' => 'text', 'default_value' => 'FAQ · Întrebări Frecvente'],
            ['key' => 'field_faq_hero_titlu',    'label' => 'Titlu',           'name' => 'faq_hero_titlu',    'type' => 'text', 'default_value' => 'ÎNTREBĂRI|FRECVENTE'],
            ['key' => 'field_faq_hero_subtitlu', 'label' => 'Subtitlu (HTML)', 'name' => 'faq_hero_subtitlu', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'Răspunsuri scurte și directe la întrebările pe care le-am primit cel mai des.'],
            ['key' => 'field_faq_intro',         'label' => 'Intro paragrafe', 'name' => 'faq_intro',         'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0],
            [
                'key' => 'field_faq_categorii', 'label' => 'Categorii și Întrebări', 'name' => 'faq_categorii',
                'type' => 'repeater', 'button_label' => 'Adaugă categorie', 'layout' => 'block',
                'sub_fields' => [
                    ['key' => 'field_faq_cat_slug',    'label' => 'Slug (id ancoră)', 'name' => 'slug',    'type' => 'text', 'required' => 1, 'instructions' => 'Ex: „cat-generale"'],
                    ['key' => 'field_faq_cat_eyebrow', 'label' => 'Eyebrow',          'name' => 'eyebrow', 'type' => 'text'],
                    ['key' => 'field_faq_cat_titlu',   'label' => 'Titlu categorie',  'name' => 'titlu',   'type' => 'text', 'required' => 1],
                    [
                        'key' => 'field_faq_cat_intrebari', 'label' => 'Întrebări', 'name' => 'intrebari',
                        'type' => 'repeater', 'button_label' => 'Adaugă întrebare', 'layout' => 'row',
                        'sub_fields' => [
                            ['key' => 'field_faq_q', 'label' => 'Întrebare', 'name' => 'q', 'type' => 'text',     'required' => 1],
                            ['key' => 'field_faq_a', 'label' => 'Răspuns',   'name' => 'a', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'required' => 1],
                        ],
                    ],
                ],
            ],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php']]],
    ]);

    // =========================================================================
    // PILLAR — override pentru paginile pillar hardcoded
    // (hero, intro, CTA editabile; restul SEO-deep rămâne hardcoded)
    // =========================================================================
    $pillar_templates = [
        'page-arte-martiale-copii-brasov.php',
        'page-autoaparare-copii-brasov.php',
        'page-autoaparare-femei-brasov.php',
        'page-ju-jitsu-copii-brasov.php',
        'page-personal-trainer-brasov.php',
    ];
    $location_rules = [];
    foreach ($pillar_templates as $tpl) {
        $location_rules[] = [['param' => 'page_template', 'operator' => '==', 'value' => $tpl]];
    }
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pillar_overrides',
        'title'    => 'Override conținut pillar (opțional)',
        'fields'   => [
            ['key' => 'field_pillar_ovr_msg', 'label' => '⚠ Recomandare', 'name' => 'pillar_ovr_msg', 'type' => 'message', 'message' => '<strong>Pentru control complet</strong> al unei pagini pilon, schimbă <em>Page Attributes → Template</em> în <strong>"Pagină Pilon (SEO)"</strong> (page-pillar.php). Astfel poți edita TOATE secțiunile via ACF (Hero, Intro, Beneficii, Ce învață, Grupe, Cum se desfășoară, Echipament, Preț, Diferențiator, Testimoniale, Instructori, Locație, FAQ, CTA).<br><br>Câmpurile de mai jos sunt doar override-uri rapide pentru paginile cu template hardcoded.'],
            ['key' => 'field_pillar_ovr_hero_titlu',    'label' => 'Override titlu hero',    'name' => 'pillar_ovr_hero_titlu',    'type' => 'text',     'instructions' => 'Lasă gol pentru a păstra titlul din template.'],
            ['key' => 'field_pillar_ovr_hero_subtitlu', 'label' => 'Override subtitlu hero', 'name' => 'pillar_ovr_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Lasă gol pentru valoarea hardcoded.'],
            ['key' => 'field_pillar_ovr_intro_titlu',   'label' => 'Override titlu intro',   'name' => 'pillar_ovr_intro_titlu',   'type' => 'text'],
            ['key' => 'field_pillar_ovr_intro',         'label' => 'Override intro text',    'name' => 'pillar_ovr_intro',         'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0],
            ['key' => 'field_pillar_ovr_cta_titlu',     'label' => 'Override CTA titlu',     'name' => 'pillar_ovr_cta_titlu',     'type' => 'text'],
            ['key' => 'field_pillar_ovr_cta_text',      'label' => 'Override CTA text',      'name' => 'pillar_ovr_cta_text',      'type' => 'textarea', 'rows' => 2],
            ['key' => 'field_pillar_ovr_cta_btn_text',  'label' => 'Override CTA buton text','name' => 'pillar_ovr_cta_btn_text',  'type' => 'text'],
            ['key' => 'field_pillar_ovr_cta_btn_url',   'label' => 'Override CTA buton URL', 'name' => 'pillar_ovr_cta_btn_url',   'type' => 'url'],
        ],
        'location' => $location_rules,
    ]);

    // =========================================================================
    // INSCRIERE — overrides
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_inscriere',
        'title'    => 'Conținut pagina Înscriere',
        'fields'   => [
            ['key' => 'field_inscriere_hero_titlu',    'label' => 'Titlu hero',     'name' => 'inscriere_hero_titlu',    'type' => 'text',     'default_value' => 'ÎNSCRIE-TE LA|KOKORO'],
            ['key' => 'field_inscriere_hero_subtitlu', 'label' => 'Subtitlu hero',  'name' => 'inscriere_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Prima lecție este gratuită. Completează formularul și te contactăm în maxim 24h pentru a stabili o ședință de probă.'],
            ['key' => 'field_inscriere_form_titlu',    'label' => 'Titlu formular', 'name' => 'inscriere_form_titlu',    'type' => 'text',     'default_value' => 'COMPLETEAZĂ|FORMULARUL'],
            [
                'key' => 'field_inscriere_grupe', 'label' => 'Opțiuni grupă (formular)', 'name' => 'inscriere_grupe',
                'type' => 'repeater', 'button_label' => 'Adaugă grupă', 'layout' => 'table',
                'sub_fields' => [
                    ['key' => 'field_grupa_value', 'label' => 'Value (slug)', 'name' => 'value', 'type' => 'text', 'required' => 1],
                    ['key' => 'field_grupa_label', 'label' => 'Label afișat', 'name' => 'label', 'type' => 'text', 'required' => 1],
                ],
            ],
            ['key' => 'field_inscriere_info_titlu',   'label' => 'Titlu sectiune info',   'name' => 'inscriere_info_titlu',   'type' => 'text', 'default_value' => 'CE URMEAZĂ|DUPĂ FORMULAR?'],
            [
                'key' => 'field_inscriere_pasi', 'label' => 'Pași după înscriere', 'name' => 'inscriere_pasi',
                'type' => 'repeater', 'button_label' => 'Adaugă pas', 'layout' => 'block',
                'sub_fields' => [
                    ['key' => 'field_pas_numar',     'label' => 'Număr pas',     'name' => 'numar',     'type' => 'text', 'default_value' => '01'],
                    ['key' => 'field_pas_titlu',     'label' => 'Titlu pas',     'name' => 'titlu',     'type' => 'text', 'required' => 1],
                    ['key' => 'field_pas_descriere', 'label' => 'Descriere pas', 'name' => 'descriere', 'type' => 'textarea', 'rows' => 3, 'required' => 1],
                ],
            ],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-inscriere.php']]],
    ]);

    // =========================================================================
    // GALERIE — content overrides
    // =========================================================================
    acf_add_local_field_group([
        'key'      => 'group_kokoro_pagina_galerie',
        'title'    => 'Conținut pagina Galerie (text)',
        'fields'   => [
            ['key' => 'field_galerie_hero_titlu',    'label' => 'Titlu hero',     'name' => 'galerie_hero_titlu',    'type' => 'text', 'default_value' => 'GALERIA|KOKORO'],
            ['key' => 'field_galerie_hero_subtitlu', 'label' => 'Subtitlu hero',  'name' => 'galerie_hero_subtitlu', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Momente din antrenamente, competiții și evenimente — istoria noastră în imagini.'],
            ['key' => 'field_galerie_intro',         'label' => 'Intro (opțional)', 'name' => 'galerie_intro',       'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0],
        ],
        'location' => [[['param' => 'page_template', 'operator' => '==', 'value' => 'page-galerie.php']]],
        'instructions' => 'Pozele din galerie se gestionează separat (CPT galerie sau alt mecanism existent).',
    ]);
}
add_action('acf/init', 'kokoro_acf_register_pages_extra');
