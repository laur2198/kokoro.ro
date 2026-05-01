<?php
/**
 * Kokoro Brașov — Database Seed Script
 *
 * Populates all CPT entries (antrenori, campioni, discipline) and ACF data
 * (tarife, orar) with the canonical content from the preview HTML.
 *
 * USAGE (wp-cli):
 *   wp eval-file wp-content/themes/kokoro-theme/bin/seed.php
 *
 * USAGE (browser, one-time, admin only):
 *   1. Place this file at: kokoro-theme/bin/seed.php
 *   2. Visit: https://kokoro.ro/wp-content/themes/kokoro-theme/bin/seed.php?run=1&token=YOUR_NONCE
 *   3. The script will refuse to run unless you're logged in as admin.
 *   4. After successful run, delete this file from production.
 *
 * SAFE TO RE-RUN: uses upsert by post_title; existing entries are updated, not duplicated.
 */

// Boot WordPress if running outside wp-cli
if (!defined('ABSPATH')) {
    $candidates = [
        __DIR__ . '/../../../../wp-load.php',
        __DIR__ . '/../../../wp-load.php',
        __DIR__ . '/../../wp-load.php',
    ];
    foreach ($candidates as $wp_load) {
        if (file_exists($wp_load)) { require_once $wp_load; break; }
    }
    if (!defined('ABSPATH')) { die('Cannot locate wp-load.php'); }
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        die('Acces interzis. Trebuie să fii logat ca admin.');
    }
}

if (!function_exists('update_field')) { die('ACF nu e activ. Activează ACF înainte de seed.'); }

// =============================================================================
// HELPERS
// =============================================================================

function k_seed_log($msg) {
    if (defined('WP_CLI') && class_exists('WP_CLI')) { WP_CLI::log($msg); }
    else { echo esc_html($msg) . "<br>\n"; }
}

function k_upsert_post($post_type, $title, $content = '', $meta = []) {
    $existing = get_posts(['post_type' => $post_type, 'title' => $title, 'posts_per_page' => 1, 'post_status' => 'any']);
    if ($existing) {
        $post_id = $existing[0]->ID;
        wp_update_post(['ID' => $post_id, 'post_status' => 'publish', 'post_content' => $content]);
    } else {
        $post_id = wp_insert_post([
            'post_type'    => $post_type,
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
        ]);
    }
    foreach ($meta as $key => $value) {
        update_field($key, $value, $post_id);
    }
    return $post_id;
}

function k_attach_image($post_id, $relative_path) {
    $theme_dir = get_stylesheet_directory();
    $abs_path = $theme_dir . '/' . ltrim($relative_path, '/');
    if (!file_exists($abs_path)) { return false; }

    // Check if already attached
    $existing = get_posts([
        'post_type'      => 'attachment',
        'meta_key'       => '_k_seed_source',
        'meta_value'     => $relative_path,
        'posts_per_page' => 1,
    ]);
    if ($existing) {
        $att_id = $existing[0]->ID;
    } else {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $upload_dir = wp_upload_dir();
        $filename = basename($abs_path);
        $new_path = $upload_dir['path'] . '/' . $filename;
        if (!file_exists($new_path)) { copy($abs_path, $new_path); }
        $filetype = wp_check_filetype($filename);
        $att_id = wp_insert_attachment([
            'post_mime_type' => $filetype['type'],
            'post_title'     => sanitize_file_name($filename),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ], $new_path, $post_id);
        $metadata = wp_generate_attachment_metadata($att_id, $new_path);
        wp_update_attachment_metadata($att_id, $metadata);
        update_post_meta($att_id, '_k_seed_source', $relative_path);
    }
    set_post_thumbnail($post_id, $att_id);
    return $att_id;
}

// =============================================================================
// 1. ANTRENORI (4 entries)
// =============================================================================

k_seed_log('=== Seed antrenori ===');
$antrenori = [
    [
        'title'  => 'Sensei Lucian Bogluț',
        'image'  => 'assets/images/antrenori/sensei-lucian.png',
        'meta'   => [
            'antrenor_rol'           => 'Sensei · Președinte Academie',
            'antrenor_bio_scurt'     => 'Fondatorul și antrenorul coordonator al Academiei de Ju-Jitsu Kokoro Brașov din 2008. A construit academia într-o instituție recunoscută de ANS și FRAM, formând generații de sportivi cu palmares național și internațional.',
            'antrenor_specializare'  => 'Inițiere Ju-Jitsu Fighting, Piticii Kokoro, coordonare antrenamente competiționale și examene de grad',
            'antrenor_centura'       => 'Centură Neagră',
            'antrenor_ani_experienta'=> 17,
        ],
    ],
    [
        'title'  => 'Sempai Adrian',
        'image'  => 'assets/images/antrenori/sempai-adrian.png',
        'meta'   => [
            'antrenor_rol'          => 'Sempai · Personal Trainer',
            'antrenor_bio_scurt'    => 'Antrenorul de Personal Training și Ju-Jitsu Contact. Alături de Sempai Petru conduce și antrenamentele de Ju-Jitsu Fighting.',
            'antrenor_specializare' => 'Personal Training, Ju-Jitsu Fighting, Ju-Jitsu Contact',
        ],
    ],
    [
        'title'  => 'Sempai Dan',
        'image'  => 'assets/images/antrenori/sempai-dan.png',
        'meta'   => [
            'antrenor_rol'          => 'Sempai · Jiu-Jitsu Gi',
            'antrenor_bio_scurt'    => 'Specialist în Jiu-Jitsu Gi și grupa Avansați Kokoro. Aduce experiență tehnică și didactică în sesiunile de luptă la sol cu kimono.',
            'antrenor_specializare' => 'Avansați Kokoro, Jiu-Jitsu Gi',
        ],
    ],
    [
        'title'  => 'Sempai Petru',
        'image'  => 'assets/images/antrenori/sempai-petru.png',
        'meta'   => [
            'antrenor_rol'          => 'Sempai · Ju-Jitsu Fighting',
            'antrenor_bio_scurt'    => 'Co-antrenor pentru Ju-Jitsu Fighting alături de Sempai Adrian. Pregătire competițională pentru juniori și adulți.',
            'antrenor_specializare' => 'Ju-Jitsu Fighting',
        ],
    ],
];
foreach ($antrenori as $a) {
    $id = k_upsert_post('antrenor', $a['title'], '', $a['meta']);
    if (!empty($a['image'])) { k_attach_image($id, $a['image']); }
    k_seed_log("  ✓ {$a['title']} (ID $id)");
}

// =============================================================================
// 2. DISCIPLINE (4 entries)
// =============================================================================

k_seed_log('=== Seed discipline ===');
$discipline = [
    [
        'title' => 'Ju-Jitsu Competițional',
        'meta'  => [
            'disciplina_teaser_home'        => 'Ju-Jitsu Fighting, Jiu-Jitsu Gi, Ground Fight, Ju-Jitsu Contact',
            'disciplina_descriere_scurta'   => 'Disciplina noastră de bază — pregătire pentru competiții naționale și internaționale. Grupe: copii, juniori, adulți.',
        ],
    ],
    [
        'title' => 'Ju-Jitsu Autoapărare',
        'meta'  => [
            'disciplina_teaser_home'      => 'Tehnici practice de self-defense',
            'disciplina_descriere_scurta' => 'Tehnici practice de self-defense pentru situații reale. Potrivit pentru femei, oameni de afaceri, și oricine vrea să se simtă în siguranță.',
        ],
    ],
    [
        'title' => 'Personal Training',
        'meta'  => [
            'disciplina_teaser_home'      => 'Preparare fizică individualizată',
            'disciplina_descriere_scurta' => 'Pregătire fizică individualizată — program personalizat pentru obiectivele tale, de la slăbit la performanță sportivă.',
        ],
    ],
    [
        'title' => 'Preparator Fizic',
        'meta'  => [
            'disciplina_teaser_home'      => 'Pentru oameni care doresc să antreneze în privat',
            'disciplina_descriere_scurta' => 'Coaching individual cu program adaptat nivelului și obiectivelor personale.',
        ],
    ],
];
foreach ($discipline as $d) {
    $id = k_upsert_post('disciplina', $d['title'], '', $d['meta']);
    k_seed_log("  ✓ {$d['title']} (ID $id)");
}

// =============================================================================
// 3. CAMPIONI (23 entries)
// =============================================================================

k_seed_log('=== Seed campioni ===');
$campioni = [
    ['nume' => 'Adrian Bogluț',           'img' => 'assets/images/campioni/8.png',  'palmares' => "Bronz Mondial 2025 — primul român medaliat la Ju-Jitsu Contact\nAur Balcanic 2025\nArgint Balcanic 2024\nBronz Balcanic 2023\nVicecampion Mondial 2022\nVicecampion European 2022\nCampion Balcanic 2022", 'titlu' => 'Vicecampion Mondial', 'ordine' => 1],
    ['nume' => 'Florin Dima',              'img' => 'assets/images/campioni/5.png',  'palmares' => "Vicecampion Mondial 2025\nCampion European 2025\nCampion Balcanic 2025\nMultiplu Campion Național", 'titlu' => 'Campion European', 'ordine' => 2],
    ['nume' => 'Sofia Scârneciu',          'img' => 'assets/images/campioni/7.png',  'palmares' => "Campioană Mondială 2025\nCampioană Europeană 2025\nVicecampioană Balcanică 2025\nCampioană Națională", 'titlu' => 'Campioană Mondială', 'ordine' => 3],
    ['nume' => 'Karina Moldoveanu',        'img' => 'assets/images/campioni/4.png',  'palmares' => "Campioană Mondială — Creta 2024\nVicecampioană Europeană — Cipru 2025\nMultipla Campioană Națională", 'titlu' => 'Campioană Mondială', 'ordine' => 4],
    ['nume' => 'Emma Mazilu',              'img' => 'assets/images/campioni/3.png',  'palmares' => "Campioană Europeană — Creta 2026\nVicecampioană Europeană — Cipru 2025\nMultipla Campioană Națională", 'titlu' => 'Campioană Europeană', 'ordine' => 5],
    ['nume' => 'Eduard-Nicolas Cojocaru',  'img' => 'assets/images/campioni/12.png', 'palmares' => "Vicecampion European 2026 — Creta\nBronz Balcanic 2025 — Atena\nVicecampion Balcanic 2024 — Pitești\nBronz Balcanic 2023 — Muntenegru\nMultiplu Campion Național", 'titlu' => 'Vicecampion European', 'ordine' => 6],
    ['nume' => 'Rareș Stoica',             'img' => 'assets/images/campioni/23.png', 'palmares' => "Bronz Campionatul European 2026\nCampion Balcanic 2023\nMultiplu Vicecampion Național\nMultiplu Medaliat Bronz Balcanic", 'titlu' => 'Medaliat European', 'ordine' => 7],
    ['nume' => 'Teo Monescu',              'img' => 'assets/images/campioni/1.png',  'palmares' => "Bronz European — Cipru 2025\nBronz Balcanic 2025\nBronz Cupa Europeană — Belgia 2025\nMultiplu Campion Național", 'titlu' => 'Medaliat European', 'ordine' => 8],
    ['nume' => 'Tudor Mazilu',             'img' => 'assets/images/campioni/2.png',  'palmares' => "Bronz European — Cipru 2024\nMultiplu Campion Național", 'titlu' => 'Medaliat European', 'ordine' => 9],
    ['nume' => 'David Totoiu',             'img' => 'assets/images/campioni/6.png',  'palmares' => "Bronz Balcanic 2025\nCampion Național", 'titlu' => 'Campion Național', 'ordine' => 10],
    ['nume' => 'Adam Gligorasi',           'img' => 'assets/images/campioni/9.png',  'palmares' => "Vicecampion Balcanic 2023 — Muntenegru\nBronz Balcanic 2024 — Pitești\nCampion Național 2024 — Pitești\nCampion Național 2025 — Tg. Mureș", 'titlu' => 'Campion Național', 'ordine' => 11],
    ['nume' => 'Matei Darabant',           'img' => 'assets/images/campioni/10.png', 'palmares' => "Vicecampion Național 2024 și 2025", 'titlu' => 'Vicecampion Național', 'ordine' => 12],
    ['nume' => 'Matei Coltea',             'img' => 'assets/images/campioni/11.png', 'palmares' => "Vicecampion Național 2024", 'titlu' => 'Vicecampion Național', 'ordine' => 13],
    ['nume' => 'Ștefania Moldovanu',       'img' => 'assets/images/campioni/13.png', 'palmares' => "Campioană Națională 2025", 'titlu' => 'Campioană Națională', 'ordine' => 14],
    ['nume' => 'Erick Porumboiu',          'img' => 'assets/images/campioni/14.png', 'palmares' => "Locul III — Campionatul Balcanic 2024\nLocul III — Campionatul Național 2024", 'titlu' => 'Medaliat Balcanic', 'ordine' => 15],
    ['nume' => 'Eric Gherman',             'img' => 'assets/images/campioni/15.png', 'palmares' => "Bronz Campionatul Național 2025\nMultiplu Medaliat Cupe Naționale", 'titlu' => 'Medaliat Național', 'ordine' => 16],
    ['nume' => 'Petru Monescu',            'img' => 'assets/images/campioni/16.png', 'palmares' => "Campion Național 2024", 'titlu' => 'Campion Național', 'ordine' => 17],
    ['nume' => 'Cezar Climescu',           'img' => 'assets/images/campioni/17.png', 'palmares' => "Vicecampion Național 2025", 'titlu' => 'Vicecampion Național', 'ordine' => 18],
    ['nume' => 'Alexandru Stan',           'img' => 'assets/images/campioni/18.png', 'palmares' => "Campion Național 2024\nDublu Vicecampion Național 2023, 2024", 'titlu' => 'Campion Național', 'ordine' => 19],
    ['nume' => 'Darius Aboni',             'img' => 'assets/images/campioni/19.png', 'palmares' => "Multiplu Medaliat Cupe Naționale", 'titlu' => 'Medaliat Național', 'ordine' => 20],
    ['nume' => 'Sara Stoica',              'img' => 'assets/images/campioni/20.png', 'palmares' => "Multipla Medaliată Cupe Naționale", 'titlu' => 'Medaliată Națională', 'ordine' => 21],
    ['nume' => 'Emma Porumboiu',           'img' => 'assets/images/campioni/21.png', 'palmares' => "Multipla Campioană la concursurile de nivel Național", 'titlu' => 'Campioană Națională', 'ordine' => 22],
    ['nume' => 'Toma Stoianovici',         'img' => 'assets/images/campioni/22.png', 'palmares' => "Bronz Balcanic 2024", 'titlu' => 'Medaliat Balcanic', 'ordine' => 23],
];
foreach ($campioni as $c) {
    $meta = [
        'campion_bio_scurt'   => $c['titlu'] . ' — ' . str_replace("\n", '. ', $c['palmares']),
        'campion_centura'     => 'neagra',
        'campion_is_featured' => ($c['ordine'] === 1),
    ];
    $id = k_upsert_post('campion', $c['nume'], '', $meta);
    // Set menu_order to control display order
    wp_update_post(['ID' => $id, 'menu_order' => $c['ordine']]);
    if (!empty($c['img'])) { k_attach_image($id, $c['img']); }
    k_seed_log("  ✓ {$c['nume']} (ID $id)");
}

// =============================================================================
// 4. TARIFE PACHETE (page-tarife.php ACF)
// =============================================================================

k_seed_log('=== Seed tarife pachete ===');
$tarife_page = get_page_by_path('tarife');
if ($tarife_page) {
    update_field('tarife_pachete', [
        [
            'titlu'     => 'Ju-Jitsu Copii',
            'pret'      => 300,
            'moneda'    => 'lei',
            'perioada'  => '/ lună',
            'featured'  => false,
            'beneficii' => [
                ['text' => '2 antrenamente / săptămână'],
                ['text' => 'Autoapărare pentru copii'],
                ['text' => 'Ju-Jitsu adaptat vârstei'],
                ['text' => 'Disciplină și respect'],
                ['text' => 'Reduceri pentru frați și surori'],
            ],
            'buton_text' => 'Înscrie-te',
            'buton_url'  => '',
        ],
        [
            'titlu'     => 'Ju-Jitsu Copii Plus',
            'pret'      => 350,
            'moneda'    => 'lei',
            'perioada'  => '/ lună',
            'featured'  => true,
            'beneficii' => [
                ['text' => '3 antrenamente / săptămână'],
                ['text' => 'Autoapărare pentru copii'],
                ['text' => 'Pregătire pentru competiții'],
                ['text' => 'Acces extins la sală'],
                ['text' => 'Reduceri pentru frați și surori'],
            ],
            'buton_text' => 'Înscrie-te Acum',
            'buton_url'  => '',
        ],
        [
            'titlu'     => 'Antrenor Personal',
            'pret'      => 100,
            'moneda'    => 'lei',
            'perioada'  => '/ oră / zi',
            'featured'  => false,
            'beneficii' => [
                ['text' => 'Antrenament 1-on-1'],
                ['text' => 'Ju-Jitsu, tonifiere musculară, cardio, TRX'],
                ['text' => 'Program adaptat cerinței'],
                ['text' => 'Orar flexibil — la cerere'],
                ['text' => 'Evaluare fizică inițială'],
            ],
            'buton_text' => 'Înscrie-te',
            'buton_url'  => '',
        ],
    ], $tarife_page->ID);
    update_field('tarife_nota', 'Cotizația se plătește lunar între 1 și 10 ale lunii. Plata se poate face în numerar la sală sau în contul IBAN al clubului. Reduceri pentru frați, surori și relația părinte-copil. Taxă înscriere: 150 lei (o singură dată).', $tarife_page->ID);
    k_seed_log('  ✓ Tarife pachete (3 pachete) salvate');
} else {
    k_seed_log('  ⚠ Pagina /tarife/ nu există — creează-o întâi din WP admin');
}

// =============================================================================
// 5. ORAR PROGRAM (page-orar.php ACF)
// =============================================================================

k_seed_log('=== Seed orar program ===');
$orar_page = get_page_by_path('orar');
if ($orar_page) {
    update_field('orar_legenda', [
        ['slug' => 'piticii',  'nume' => 'Piticii Kokoro',           'varsta' => ''],
        ['slug' => 'avansati', 'nume' => 'Avansați Kokoro',          'varsta' => ''],
        ['slug' => 'initiere', 'nume' => 'Inițiere Ju-Jitsu Fighting','varsta' => ''],
        ['slug' => 'fighting', 'nume' => 'Ju-Jitsu Fighting',        'varsta' => ''],
        ['slug' => 'gi',       'nume' => 'Jiu-Jitsu Gi',             'varsta' => ''],
        ['slug' => 'contact',  'nume' => 'Ju-Jitsu Contact',         'varsta' => ''],
        ['slug' => 'pt',       'nume' => 'PT',                        'varsta' => 'Antrenamente personalizate la cerere'],
    ], $orar_page->ID);

    $rows = [];
    $week = ['Luni','Marți','Miercuri','Joi','Vineri','Sâmbătă'];
    $template = [
        'Luni'    => [['09:00 – 15:00','Personal Training','pt','Sempai Adrian'],['17:00 – 18:00','Inițiere Ju-Jitsu Fighting','initiere','Sensei Lucian'],['18:00 – 19:30','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru'],['19:30 – 21:00','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru']],
        'Marți'   => [['09:00 – 15:00','Personal Training','pt','Sempai Adrian'],['17:00 – 18:00','Inițiere Ju-Jitsu Fighting','initiere','Sensei Lucian'],['18:00 – 19:30','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru'],['19:30 – 21:00','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru']],
        'Miercuri'=> [['09:00 – 15:00','Personal Training','pt','Sempai Adrian'],['16:30 – 17:30','Piticii Kokoro','piticii','Sensei Lucian'],['17:00 – 18:00','Avansați Kokoro','avansati','Sempai Dan'],['18:00 – 19:30','Jiu-Jitsu Gi','gi','Sempai Dan'],['19:30 – 21:00','Ju-Jitsu Contact','contact','Sempai Adrian']],
        'Joi'     => [['09:00 – 15:00','Personal Training','pt','Sempai Adrian'],['17:00 – 18:00','Inițiere Ju-Jitsu Fighting','initiere','Sensei Lucian'],['18:00 – 19:30','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru'],['19:30 – 21:00','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru']],
        'Vineri'  => [['09:00 – 15:00','Personal Training','pt','Sempai Adrian'],['16:30 – 17:30','Piticii Kokoro','piticii','Sensei Lucian'],['17:00 – 18:00','Avansați Kokoro','avansati','Sempai Dan'],['18:00 – 19:30','Jiu-Jitsu Gi','gi','Sempai Dan'],['19:30 – 21:00','Ju-Jitsu Contact','contact','Sempai Adrian']],
        'Sâmbătă' => [['09:00 – 11:30','Ju-Jitsu Fighting','fighting','Sempai Adrian / Sempai Petru']],
    ];
    foreach ($template as $zi => $sesiuni) {
        foreach ($sesiuni as $s) {
            $rows[] = ['zi' => $zi, 'ora' => $s[0], 'disciplina' => $s[1], 'grupa' => $s[2], 'antrenor' => $s[3]];
        }
    }
    update_field('orar_program', $rows, $orar_page->ID);
    k_seed_log('  ✓ Orar program (' . count($rows) . ' sesiuni)');
} else {
    k_seed_log('  ⚠ Pagina /orar/ nu există — creează-o întâi din WP admin');
}

// =============================================================================
// 6. SETĂRI GLOBAL OPTIONS (telefon, WhatsApp, footer text)
// =============================================================================

k_seed_log('=== Seed setări globale ===');
update_field('set_telefon', '0742 037 973', 'option');
update_field('set_whatsapp_numar', '40742037973', 'option');
update_field('set_email', 'contact@kokoro.ro', 'option');
update_field('set_adresa', 'Str. Carpaților 60<br>500269 Brașov, România', 'option');
update_field('set_footer_descriere', 'Kokoro Brașov Academy — academie de Ju-Jitsu fondată în 2008. Recunoscută de Agenția Națională pentru Sport și Federația Română de Arte Marțiale. Formăm campioni și caractere puternice prin disciplină, respect și perseverență.', 'option');
k_seed_log('  ✓ Setări globale actualizate');

// =============================================================================
// 7. PAGINI NOI (Formulare, Regulament, Calendar Competițional, Contact, FAQ)
// =============================================================================

k_seed_log('=== Seed pagini noi ===');

// FORMULARE
$page = get_page_by_path('formulare');
if ($page) {
    update_field('formulare_lista', [
        ['icon' => '📄', 'titlu' => 'Cerere Înscriere Club Kokoro',  'descriere' => 'Formularul principal de înscriere în club, necesar pentru toți cursanții noi.', 'fisier_url' => 'https://kokoro.ro/Fisa_Inscriere_Kokoro_2018.docx', 'buton_text' => 'Descarcă (.docx)'],
        ['icon' => '🥋', 'titlu' => 'Cerere Legitimare FRAM',        'descriere' => 'Cerere de legitimare ca sportiv la Federația Română de Arte Marțiale.',           'fisier_url' => 'https://kokoro.ro/wp-content/uploads/2013/06/CERERE_INSCRIERE.CLUB_.doc', 'buton_text' => 'Descarcă (.doc)'],
        ['icon' => '🔒', 'titlu' => 'Fișă DGPR (GDPR)',              'descriere' => 'Acordul privind prelucrarea datelor cu caracter personal — obligatoriu la înscriere.', 'fisier_url' => 'https://kokoro.ro/wp-content/uploads/2021/02/fisa-DGPR-KOKORO.docx', 'buton_text' => 'Descarcă (.docx)'],
        ['icon' => '💛', 'titlu' => 'Formular 230 — 3,5% impozit',   'descriere' => 'Direcționează 3,5% din impozitul pe venit către Clubul Sportiv Kokoro Brașov.',  'fisier_url' => 'https://kokoro.ro/formulare/formular_230-kokoro-1/', 'buton_text' => 'Vezi Formularul'],
    ], $page->ID);
    update_field('formulare_dosar', [
        ['text' => 'Cerere tipizată club'],
        ['text' => 'Formular DGPR'],
        ['text' => 'Adeverință medic familie — clinic sănătos'],
        ['text' => 'Copie xerox certificat de naștere / C.I.'],
        ['text' => '2 poze tip buletin 3/4 (CI / pașaport / carnet de elev)'],
        ['text' => '150 lei taxă înscriere (o singură dată)'],
    ], $page->ID);
    k_seed_log('  ✓ Formulare populat');
} else {
    k_seed_log('  ⚠ /formulare/ nu există — creează pagina cu template Formulare');
}

// REGULAMENT
$page = get_page_by_path('regulament');
if ($page) {
    $articole = [
        ['titlu' => 'Art. 1 — Înscrierea',                 'continut' => '<ul><li>Toți cursanții (sau părinții cursanților) vor completa și semna, la înscriere, formularul pentru luarea în evidență, vor aduce o poză tip buletin 3/4 și o copie după certificatul de naștere.</li><li>Pentru înscrierea în club, cursantul va avea pe cererea de înscriere parafa medicului de familie.</li><li>Practicantul nu poate face antrenament fără dosarul personal de înscriere complet.</li><li>Înscrierea în club se face o singură dată, taxa fiind <strong>150 lei</strong>.</li></ul>'],
        ['titlu' => 'Art. 2 — Disciplina',                  'continut' => '<ul><li>6 absențe nemotivate pe lună — cursantul este exclus din club.</li><li>Absențele se motivează numai în baza unui telefon de la părinți sau a unui certificat medical.</li><li>Vor fi excluși din club cei care consumă băuturi alcoolice, droguri sau țigări.</li><li>Sportivii trebuie să-și respecte părinții și antrenorii.</li><li>În dojo se lucrează, nu se vorbește.</li><li>În sala de antrenament nu se filmează și nu se fotografiază fără aprobarea Sensei-ului.</li></ul>'],
        ['titlu' => 'Art. 3 — Viza medicală',               'continut' => '<ul><li>Pentru cursanții începători este obligatorie ștampila medicului de familie sau adeverința care atestă că pot efectua efort fizic intens.</li><li>Viza medicală se pune de două ori pe an în carnetul de sportiv.</li></ul>'],
        ['titlu' => 'Art. 4 — Cotizația de cursant',        'continut' => '<ul><li>Cotizația se plătește lunar între 1 și 10 ale lunii.</li><li>Plata în numerar la sală sau în contul IBAN al clubului.</li><li>Reducere pentru frați, surori și relația părinte-copil.</li><li>Banii nu se returnează în cazul nefrecventării antrenamentelor.</li></ul>'],
        ['titlu' => 'Art. 5 — Viza anuală sportiv (FRAM)',  'continut' => '<p>Pentru sportivii legitimați FRAM, viza anuală se plătește până în luna martie a anului în curs.</p>'],
        ['titlu' => 'Art. 6 — Echipamentul',                'continut' => '<ul><li>Pentru primele 3 luni — trening și tricou.</li><li>La primul examen de grad cursantul trebuie să aibă <em>kimono (gi)</em>.</li><li>Echipamentul este individual.</li><li>Niciodată nu mă schimb în dojo, ci în vestiar.</li></ul>'],
        ['titlu' => 'Art. 7 — Cantonamente',                'continut' => '<ul><li>În fiecare an clubul nostru organizează cantonamente la mare sau la munte.</li><li>Taxa pentru cantonament o plătește cursantul.</li></ul>'],
        ['titlu' => 'Art. 8 — Concursuri și competiții',    'continut' => '<ul><li>Participarea se face la recomandarea antrenorilor.</li><li>Costurile (transport, masă) sunt suportate de cursanți.</li><li>Sistemul competițional în Ju-Jitsu este semi-contact.</li><li>Părintele dă acordul în scris și achită taxa de concurs.</li></ul>'],
        ['titlu' => 'Art. 9 — Examenul de grad',            'continut' => '<p>Necesare: acceptul Sensei-ului, prezență minimă 80%, taxe achitate.</p><p>Probele se notează 1-10. Nota minimă 5 pe fiecare probă, media generală minimă 8.</p><p>Cei care nu trec pot da din nou după 3 luni.</p>'],
        ['titlu' => 'Art. 10 — Reguli pentru practicant',   'continut' => '<ul><li>Să respecte cele 10 principii fundamentale.</li><li>Curățenia locurilor utilizate.</li><li>Ținută curată, unghii tăiate scurt.</li><li>Fără cercei, brățări, inele.</li><li>Salut înainte și după antrenament.</li></ul>'],
        ['titlu' => 'Art. 11 — Obiecte de valoare',         'continut' => '<p>Se recomandă ca în cadrul antrenamentelor, practicanții să nu poarte asupra lor obiecte de valoare. Clubul nu își asumă nicio responsabilitate în caz de furt.</p>'],
        ['titlu' => 'Art. 12 — Retragerea din club',        'continut' => '<ul><li>Sportivul se poate retrage în orice moment.</li><li>Pentru sportivii cu BUDOPASS — cerere în 2 exemplare către Consiliul Director.</li><li>Răspuns în 30 zile.</li></ul>'],
        ['titlu' => 'Art. 13 — Pedepse și sancțiuni',       'continut' => '<ul><li>Sportivul este sancționat pentru abateri intenționate cu pedepse începând cu flotări, până la excluderea din club.</li><li>Încălcarea repetată a Art. 2 și 3 duce la eliminarea din club.</li></ul>'],
    ];
    update_field('regulament_articole', $articole, $page->ID);
    k_seed_log('  ✓ Regulament populat (13 articole)');
} else {
    k_seed_log('  ⚠ /regulament/ nu există — creează pagina cu template Regulament');
}

// FAQ — categorii + Q&A
$page = get_page_by_path('faq');
if ($page) {
    update_field('faq_categorii', [
        [
            'slug' => 'cat-generale', 'eyebrow' => '01 — Generale', 'titlu' => 'Despre Kokoro',
            'intrebari' => [
                ['q' => 'Ce este Kokoro Brașov Academy?',           'a' => 'Kokoro Brașov Academy este o academie de Ju-Jitsu și autoapărare fondată în 2008. Oferim programe pentru copii (de la 4 ani), adolescenți, femei (autoapărare) și adulți. Sediul este pe Strada Carpaților 60, Brașov, cu o sală dedicată, vestiare separate și echipament profesional. Avem peste 200 de cursanți activi și am format zeci de campioni naționali și internaționali în 17 ani de activitate.'],
                ['q' => 'Cine sunt antrenorii?',                    'a' => 'Echipa Kokoro este formată din 4 antrenori: <strong>Sensei Lucian Bogluț</strong> (fondator, președinte academie, antrenor coordonator), <strong>Sempai Adrian</strong> (Personal Training, Ju-Jitsu Fighting și Contact), <strong>Sempai Dan</strong> (Avansați Kokoro, Jiu-Jitsu Gi) și <strong>Sempai Petru</strong> (Ju-Jitsu Fighting). Vezi pagina <a href="/antrenori/">Antrenori</a> pentru detalii.'],
                ['q' => 'Ce programe oferiți?',                     'a' => 'Avem 4 discipline principale: <strong>Ju-Jitsu Competițional</strong> (Fighting, Gi, Ground Fight, Contact), <strong>Ju-Jitsu Autoapărare</strong>, <strong>Personal Training</strong> și <strong>Preparator Fizic</strong>. Pentru detalii vezi pagina <a href="/discipline/">Discipline</a>.'],
            ],
        ],
        [
            'slug' => 'cat-inscriere', 'eyebrow' => '02 — Înscriere', 'titlu' => 'Înscriere & Prima Ședință',
            'intrebari' => [
                ['q' => 'Cum mă înscriu la Kokoro?',                'a' => 'Există trei moduri: (1) <strong>Online</strong> — completează formularul de pe pagina <a href="/inscriere/">Înscriere</a>. (2) <strong>Telefon</strong> — sună la 0742 037 973. (3) <strong>WhatsApp</strong> — scrie pe butonul verde din colț. Înscrierea formală (contract + plată) se face după prima ședință de probă gratuită.'],
                ['q' => 'Pot veni la o ședință de probă?',          'a' => 'Da! Prima ședință este <strong>gratuită</strong> pentru toți cursanții noi. Vino cu 15 minute înainte de începerea unui antrenament, în haine sport, și ne cunoaștem. Discutăm despre obiective, vezi cum se desfășoară un antrenament și decizi dacă Kokoro este locul potrivit pentru tine.'],
                ['q' => 'Ce acte îmi trebuie pentru înscriere?',    'a' => 'Dosarul de înscriere conține: cerere tipizată club, formular DGPR, adeverință medic familie (clinic sănătos), copie certificat naștere/CI, 2 poze tip buletin 3/4 și 150 lei taxă înscriere (o singură dată). Toate formularele sunt descărcabile de pe pagina <a href="/formulare/">Formulare</a>.'],
            ],
        ],
        [
            'slug' => 'cat-copii', 'eyebrow' => '03 — Pentru copii', 'titlu' => 'Copii & Adolescenți',
            'intrebari' => [
                ['q' => 'De la ce vârstă pot înscrie copilul?',     'a' => 'De la <strong>4 ani împliniți</strong>, în grupa Mini-Samurai/Piticii Kokoro. La această vârstă antrenamentul este 70% joc structurat, rostogoliri, jocuri de echilibru — tehnica reală vine treptat după 6-7 ani. Grupa 8-12 ani este cea mai populară — copilul are deja coordonarea necesară pentru tehnici complete.'],
                ['q' => 'Câte antrenamente pe săptămână recomandați?', 'a' => 'Pentru copii recomandăm <strong>2 antrenamente/săptămână</strong> ca minim (300 lei/lună). Pentru cei pasionați și care vor să intre în grupa de competiție, <strong>3 antrenamente/săptămână</strong> (350 lei/lună) este pachetul ideal. Frecvența mai mare = progres mai rapid și consolidare mai bună a tehnicilor.'],
                ['q' => 'Ju-Jitsu este periculos pentru copii?',    'a' => 'Nu — Ju-Jitsu pentru copii este un sport extrem de sigur dacă este predat corect. Antrenamentele includ căderi controlate, rostogoliri și tehnici la sol. Sportivii noștri suferă mai puține accidentări decât la fotbal sau handbal școlar. Folosim saltele profesionale și echipament dedicat. La Kokoro, siguranța este prioritate.'],
            ],
        ],
        [
            'slug' => 'cat-femei', 'eyebrow' => '04 — Pentru femei', 'titlu' => 'Autoapărare Femei',
            'intrebari' => [
                ['q' => 'Sunt începătoare — pot face autoapărare?', 'a' => 'Absolut. Programul de Autoapărare Femei e gândit pe 3 niveluri: <strong>începătoare</strong> (fără experiență prealabilă, învățăm tehnicile de bază pas cu pas), <strong>intermediare</strong> (după 6-12 luni), <strong>avansate</strong>. Atmosferă suportivă, fără presiunea unei competiții — accent pe practică, nu pe spectacol.'],
                ['q' => 'Trebuie să fiu în formă?',                  'a' => 'Nu. Pornim de la nivelul tău fizic actual și creștem treptat. Antrenamentele includ încălzire generală, tehnică de autoapărare, și exerciții de tonifiere. Multe cursante vin pentru autoapărare și descoperă că au pierdut și 5-10 kg într-un an, fără să fi avut asta ca scop principal.'],
            ],
        ],
        [
            'slug' => 'cat-adulti', 'eyebrow' => '05 — Pentru adulți', 'titlu' => 'Adulți & Performanță',
            'intrebari' => [
                ['q' => 'Sunt adult, n-am mai făcut sport — pot începe?', 'a' => 'Da. Avem cursanți care au început Ju-Jitsu la 35-45 ani și au ajuns la centura albastră în câțiva ani. Antrenamentele se adaptează nivelului tău. Vino la o probă gratuită și vezi singur.'],
                ['q' => 'Ce e Personal Training și pentru cine?',   'a' => 'Personal Training înseamnă antrenament <strong>1-on-1</strong> cu antrenor (Sempai Adrian) — 100 lei/oră. Program adaptat: slăbire, tonifiere, performanță sportivă, recuperare după accidentare. Disponibil L-V între 09:00-15:00 (la cerere). Ideal pentru cei cu program flexibil sau care vor rezultate rapide.'],
            ],
        ],
        [
            'slug' => 'cat-tarife', 'eyebrow' => '06 — Tarife & Plată', 'titlu' => 'Tarife & Plată',
            'intrebari' => [
                ['q' => 'Care sunt tarifele?',                       'a' => 'Pentru copii: <strong>300 lei/lună</strong> (2 antrenamente/săptămână) sau <strong>350 lei/lună</strong> (3 antrenamente/săptămână). Personal Training: <strong>100 lei/oră</strong>. Taxă înscriere unică: <strong>150 lei</strong>. Vezi detalii pe pagina <a href="/tarife/">Tarife</a>.'],
                ['q' => 'Aveți reduceri?',                           'a' => 'Da: reduceri pentru <strong>frați și surori</strong> înscriși împreună, și pentru relația <strong>părinte-copil</strong> când amândoi se antrenează. Sună-ne pentru detalii — ajustăm în funcție de situație.'],
                ['q' => 'Cum se face plata?',                        'a' => 'Cotizația lunară se plătește între <strong>1 și 10 ale lunii</strong>. Acceptăm: numerar la sală (cu chitanță), transfer bancar (cont IBAN al clubului). Banii nu se returnează în cazul nefrecventării antrenamentelor.'],
            ],
        ],
        [
            'slug' => 'cat-practic', 'eyebrow' => '07 — Practic', 'titlu' => 'Aspecte Practice',
            'intrebari' => [
                ['q' => 'Ce echipament îmi trebuie?',                'a' => 'Pentru prima ședință: haine sport confortabile (legging-uri/pantaloni de trening + tricou cu mâneci scurte), papuci sau șlapi pentru drumul până la tatami (pe tatami se intră desculț), o sticlă de apă și un prosop mic. <strong>Nu aveți nevoie de kimono pentru prima dată</strong> — vi-l procurăm noi după înscriere (180-250 lei).'],
                ['q' => 'Unde sunteți?',                             'a' => 'Strada Carpaților 60, Brașov 500269 — în Parcul Industrial METROM, deasupra service-ului auto, lângă Pensiunea „Floarea Soarelui". Intrarea se face pe poarta principală a uzinei METROM. După poartă, mergeți drept înainte 50m, apoi la indicatorul STOP, dreapta 100m. Vezi <a href="/contact/">Contact</a> pentru hartă și detalii.'],
            ],
        ],
    ], $page->ID);
    k_seed_log('  ✓ FAQ populat (7 categorii, 17 întrebări)');
} else {
    k_seed_log('  ⚠ /faq/ nu există — creează pagina cu template FAQ');
}

// CONTACT — page-specific
$page = get_page_by_path('contact');
if ($page) {
    update_field('contact_form_subiecte', [
        ['value' => 'inscriere',   'label' => 'Înscriere'],
        ['value' => 'informatii',  'label' => 'Informații'],
        ['value' => 'tarife',      'label' => 'Tarife'],
        ['value' => 'competitii',  'label' => 'Competiții'],
        ['value' => 'altele',      'label' => 'Altele'],
    ], $page->ID);
    k_seed_log('  ✓ Contact (subiecte form) populat');
}

k_seed_log('');
k_seed_log('=== SEED COMPLET ===');
k_seed_log('Antrenori: 4 · Discipline: 4 · Campioni: 23');
k_seed_log('Tarife: 3 pachete · Orar: 23 sesiuni');
k_seed_log('Pagini noi: Formulare · Regulament · Calendar · Contact (subiecte)');
k_seed_log('');
k_seed_log('IMPORTANT: dacă rulezi prin browser, șterge bin/seed.php după execuție pentru securitate.');
