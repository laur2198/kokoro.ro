<?php
/**
 * SEO — JSON-LD schemas (split din inc/seo-meta.php pentru mentenabilitate)
 *
 * Conține toate generatoarele de schema.org JSON-LD:
 * Organization, BreadcrumbList, Person (campion + antrenor), Course (disciplina),
 * FAQPage, Article, Pillar (Course/Service/Article), Service+Offer (tarife),
 * Review. Plus helper render FAQ vizual.
 *
 * Hook unic la wp_footer:100 → kokoro_print_jsonld_schemas() apelează toate.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

function kokoro_render_jsonld_organization() {
    $name        = get_bloginfo('name');
    $url         = home_url('/');
    $logo_id     = (int) get_theme_mod('custom_logo');
    $logo_url    = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $telefon     = kokoro_setting('telefon', '');
    $tel_e164    = kokoro_phone_to_e164($telefon);
    $email       = kokoro_setting('email', '');
    $strada      = kokoro_setting('strada', 'Str. Carpaților 60');
    $localitate  = kokoro_setting('localitate', 'Brașov');
    $cod_postal  = kokoro_setting('cod_postal', '500269');
    $regiune     = kokoro_setting('regiune', 'Brașov');
    $tara        = kokoro_setting('tara', 'RO');
    $lat         = kokoro_setting('lat', '');
    $lng         = kokoro_setting('lng', '');
    $an_fondare  = kokoro_setting('an_fondare', '2008');
    $rating      = kokoro_setting('google_rating', '');
    $rating_n    = kokoro_setting('google_count', '');
    $program_lv  = kokoro_setting('program_lv', '');
    $program_sa  = kokoro_setting('program_sa', '');

    $sames = [];
    foreach (['facebook','instagram','youtube','tiktok','google_url'] as $k) {
        $v = kokoro_setting($k, '');
        if ($v !== '' && filter_var($v, FILTER_VALIDATE_URL)) $sames[] = $v;
    }

    // Dual-type: SportsClub (subtip al SportsActivityLocation) e mai precis pentru
    // o academie sportivă; Organization permite foundingDate/sameAs/aggregateRating
    // să fie semantic corecte (sunt properties de Organization, nu de Place).
    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => ['SportsClub', 'Organization'],
        '@id'         => $url . '#organization',
        'name'        => $name,
        'alternateName' => 'Academia de Ju-Jitsu Kokoro Brașov',
        'description' => kokoro_setting('seo_desc_home', kokoro_setting('meta_descriere', '')),
        'url'         => $url,
        'sport'       => ['Ju-Jitsu', 'Autoapărare', 'TRX'],
        'foundingDate'=> $an_fondare,
        'areaServed'  => ['@type' => 'City', 'name' => $localitate],
    ];
    if ($logo_url) $data['logo'] = $logo_url;
    if ($telefon)  $data['telephone'] = $tel_e164 ?: $telefon;
    if ($email)    $data['email'] = $email;
    if ($strada || $localitate) {
        $data['address'] = [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $strada,
            'addressLocality' => $localitate,
            'postalCode'      => $cod_postal,
            'addressRegion'   => $regiune,
            'addressCountry'  => $tara,
        ];
    }
    if ($lat !== '' && $lng !== '') {
        $data['geo'] = [
            '@type'     => 'GeoCoordinates',
            'latitude'  => (float) $lat,
            'longitude' => (float) $lng,
        ];
    }

    $hours = [];
    if ($program_lv !== '' && preg_match('/(\d{1,2}:\d{2})\s*[–-]\s*(\d{1,2}:\d{2})/u', $program_lv, $m)) {
        $hours[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
            'opens'     => $m[1],
            'closes'    => $m[2],
        ];
    }
    if ($program_sa !== '' && preg_match('/(\d{1,2}:\d{2})\s*[–-]\s*(\d{1,2}:\d{2})/u', $program_sa, $m)) {
        $hours[] = [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => 'Saturday',
            'opens'     => $m[1],
            'closes'    => $m[2],
        ];
    }
    if (!empty($hours)) $data['openingHoursSpecification'] = $hours;

    if ($rating !== '' && is_numeric($rating) && $rating_n !== '' && is_numeric($rating_n)) {
        $data['aggregateRating'] = [
            '@type'       => 'AggregateRating',
            'ratingValue' => (string) $rating,
            'reviewCount' => (string) $rating_n,
            'bestRating'  => '5',
        ];
    }

    if (!empty($sames)) $data['sameAs'] = array_values($sames);

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/**
 * Convertește un număr românesc în format E.164: 0742 037 973 → +40742037973.
 */

function kokoro_render_jsonld_breadcrumb() {
    if (is_front_page() || is_404()) return;

    $items = [
        ['name' => 'Acasă', 'url' => home_url('/')],
    ];

    if (is_singular('campion')) {
        $items[] = ['name' => 'Campioni',  'url' => home_url('/campioni/')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('disciplina')) {
        $items[] = ['name' => 'Discipline', 'url' => home_url('/discipline/')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('antrenor')) {
        $items[] = ['name' => 'Antrenori',  'url' => home_url('/antrenori/')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_page()) {
        $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
        foreach ($ancestors as $aid) {
            $items[] = ['name' => get_the_title($aid), 'url' => get_permalink($aid)];
        }
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('post')) {
        $items[] = ['name' => 'Articole', 'url' => home_url('/blog/')];
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } else {
        return;
    }

    $list = [];
    foreach ($items as $i => $it) {
        $list[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $it['name'],
            'item'     => $it['url'],
        ];
    }

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $list,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Person (Campion / Antrenor — context-dependent)
   ========================================================================== */

function kokoro_render_jsonld_person_campion() {
    if (!is_singular('campion')) return;
    $cid = get_queried_object_id();
    if (!$cid) return;

    $bio        = function_exists('get_field') ? (string) get_field('campion_bio_scurt', $cid)   : '';
    $rezultate  = function_exists('get_field') ? get_field('campion_rezultate', $cid)            : [];
    $centura    = function_exists('get_field') ? (string) get_field('campion_centura', $cid)     : '';
    $thumb      = has_post_thumbnail($cid) ? get_the_post_thumbnail_url($cid, 'kokoro-square') : '';

    $awards = [];
    if (is_array($rezultate)) {
        foreach ($rezultate as $r) {
            $an   = $r['an']         ?? '';
            $comp = $r['competitie'] ?? '';
            $med  = $r['medalie']    ?? '';
            if ($comp) {
                $awards[] = trim(($an ? "$an: " : '') . $comp . ($med ? ' (' . kokoro_medalie_label($med) . ')' : ''));
            }
        }
    }

    // Cross-reference la entitatea canonică antrenor — dacă acest campion e și antrenor
    // (ex. Adi), Knowledge Graph consolidează prin sameAs.
    $canonical_id = function_exists('get_field') ? (string) get_field('antrenor_persoana_id_canonical', $cid) : '';

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink($cid) . '#person',
        'name'        => get_the_title($cid),
        'url'         => get_permalink($cid),
        'jobTitle'    => 'Sportiv Kokoro Brașov',
        'affiliation' => [
            '@type' => 'SportsOrganization',
            '@id'   => home_url('/') . '#organization',
            'name'  => get_bloginfo('name'),
        ],
        'worksFor'    => [
            '@type' => 'Organization',
            '@id'   => home_url('/') . '#organization',
            'name'  => get_bloginfo('name'),
        ],
        'knowsAbout'  => ['Ju-Jitsu', 'Arte marțiale'],
    ];
    if ($thumb)   $data['image']       = $thumb;
    if ($bio)     $data['description'] = wp_strip_all_tags($bio);
    if (!empty($awards)) $data['award'] = $awards;
    if ($canonical_id !== '' && filter_var($canonical_id, FILTER_VALIDATE_URL)) {
        $data['sameAs'] = [$canonical_id];
    }

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

function kokoro_render_jsonld_person_antrenor() {
    if (!is_singular('antrenor')) return;
    $aid = get_queried_object_id();
    if (!$aid) return;

    $rol          = function_exists('get_field') ? (string) get_field('antrenor_rol', $aid)          : '';
    $given        = function_exists('get_field') ? trim((string) get_field('antrenor_given_name', $aid))        : '';
    $family       = function_exists('get_field') ? trim((string) get_field('antrenor_family_name', $aid))       : '';
    $honorific    = function_exists('get_field') ? trim((string) get_field('antrenor_honorific_prefix', $aid))  : '';
    $bio          = function_exists('get_field') ? (string) get_field('antrenor_bio_scurt', $aid)    : '';
    $specializare = function_exists('get_field') ? (string) get_field('antrenor_specializare', $aid) : '';
    $skills       = function_exists('get_field') ? (string) get_field('antrenor_skills', $aid)       : '';
    $ani_exp      = function_exists('get_field') ? (int)    get_field('antrenor_ani_experienta', $aid) : 0;
    $email_a      = function_exists('get_field') ? (string) get_field('antrenor_email', $aid)        : '';
    $tel_a        = function_exists('get_field') ? (string) get_field('antrenor_telefon', $aid)      : '';
    $facebook_a   = function_exists('get_field') ? (string) get_field('antrenor_facebook', $aid)     : '';
    $instagram_a  = function_exists('get_field') ? (string) get_field('antrenor_instagram', $aid)    : '';
    $thumb        = has_post_thumbnail($aid) ? get_the_post_thumbnail_url($aid, 'kokoro-square') : '';

    $jobTitle = $rol !== '' ? $rol : 'Antrenor';

    // Personal name canonic — ACF given+family au prioritate; fallback la
    // post_title strip-uit de honorific. Nu emitem schema cu name gol.
    $name_acf = trim($given . ' ' . $family);
    $name = $name_acf !== '' ? $name_acf : kokoro_strip_honorific(get_the_title($aid));

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink($aid) . '#person',
        'name'        => $name,
        'url'         => get_permalink($aid),
        'jobTitle'    => $jobTitle,
        'worksFor'    => [
            '@type' => 'Organization',
            '@id'   => home_url('/') . '#organization',
            'name'  => get_bloginfo('name'),
        ],
    ];
    // Componente granulare — emise doar dacă ACF e populat (Knowledge Graph
    // consolidează prin given+family matching cu Person campion pentru același individ).
    if ($given !== '')     $data['givenName']       = $given;
    if ($family !== '')    $data['familyName']      = $family;
    if ($honorific !== '') $data['honorificPrefix'] = $honorific;

    if ($specializare !== '') $data['knowsAbout'] = array_map('trim', explode(',', $specializare));
    if ($bio)     $data['description'] = wp_strip_all_tags($bio);
    if ($thumb)   $data['image']       = $thumb;
    if ($email_a) $data['email']       = $email_a;
    if ($tel_a)   $data['telephone']   = kokoro_phone_to_e164($tel_a) ?: $tel_a;

    // hasOccupation — emis DOAR dacă avem ani de experiență din ACF (gate strict).
    // Fără ani > 0, semantica e incompletă (Occupation fără experienceRequirements
    // e o etichetă goală), așa că skip-uim întreg block-ul în loc să emitem zero.
    // monthsOfExperience derivat: intval($ani) * 12. Niciodată hardcodat.
    if ($ani_exp > 0) {
        $occupation = [
            '@type'              => 'Occupation',
            'name'               => $jobTitle,
            'occupationLocation' => [
                '@type' => 'City',
                'name'  => kokoro_setting('localitate', 'Brașov'),
            ],
            'experienceRequirements' => [
                '@type'              => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => $ani_exp * 12,
            ],
        ];
        if ($skills !== '') {
            $occupation['skills'] = $skills;
        }
        $data['hasOccupation'] = $occupation;
    }

    $sames = array_filter([$facebook_a, $instagram_a]);
    if (!empty($sames)) $data['sameAs'] = array_values($sames);

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Course (pe single-disciplina + paginile pilon)
   ========================================================================== */

function kokoro_render_jsonld_course_disciplina() {
    if (!is_singular('disciplina')) return;
    $did = get_queried_object_id();
    if (!$did) return;

    $desc       = function_exists('get_field') ? (string) get_field('disciplina_descriere_scurta', $did) : '';
    $thumb      = has_post_thumbnail($did) ? get_the_post_thumbnail_url($did, 'kokoro-hero') : '';
    $localitate = kokoro_setting('localitate', 'Brașov');
    $strada     = kokoro_setting('strada', '');
    $tara       = kokoro_setting('tara', 'RO');

    $data = [
        '@context'         => 'https://schema.org',
        '@type'            => 'Course',
        'name'             => get_the_title($did),
        'description'      => $desc !== '' ? wp_strip_all_tags($desc) : wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $did)), 30, '…'),
        'provider'         => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
            '@id'   => home_url('/') . '#organization',
            'url'   => home_url('/'),
        ],
        'inLanguage'       => 'ro',
        'courseMode'       => 'in-person',
        'educationalLevel' => 'Beginner to Advanced',
        'hasCourseInstance'=> [
            '@type'     => 'CourseInstance',
            'courseMode'=> 'in-person',
            'location'  => [
                '@type'   => 'Place',
                'name'    => get_bloginfo('name'),
                'address' => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => $strada,
                    'addressLocality' => $localitate,
                    'addressCountry'  => $tara,
                ],
            ],
        ],
    ];
    if ($thumb) $data['image'] = $thumb;
    $url = get_permalink($did);
    if ($url) $data['url'] = $url;

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: FAQPage — apare când pagina/postul are ACF câmp kokoro_faq populat
   ========================================================================== */

function kokoro_render_jsonld_faqpage() {
    if (!is_singular()) return;
    if (!function_exists('get_field')) return;
    $faq = get_field('kokoro_faq');
    if (!is_array($faq) || empty($faq)) return;

    $entities = [];
    foreach ($faq as $row) {
        $q = $row['intrebare'] ?? '';
        $a = $row['raspuns']   ?? '';
        if ($q === '' || $a === '') continue;
        $entities[] = [
            '@type'          => 'Question',
            'name'           => wp_strip_all_tags($q),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => wp_strip_all_tags($a),
            ],
        ];
    }
    if (empty($entities)) return;

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode([
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Article (pe post-uri normale)
   ========================================================================== */

function kokoro_render_jsonld_article() {
    if (!is_singular('post')) return;
    $pid = get_queried_object_id();
    if (!$pid) return;

    $author_id   = (int) get_post_field('post_author', $pid);
    $author_name = get_the_author_meta('display_name', $author_id) ?: get_bloginfo('name');
    $thumb       = has_post_thumbnail($pid) ? get_the_post_thumbnail_url($pid, 'kokoro-hero') : '';
    $logo_id     = (int) get_theme_mod('custom_logo');
    $logo_url    = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $excerpt     = wp_strip_all_tags(get_the_excerpt($pid)) ?: wp_trim_words(wp_strip_all_tags(get_post_field('post_content', $pid)), 30, '…');

    $data = [
        '@context'         => 'https://schema.org',
        '@type'            => 'Article',
        'headline'         => get_the_title($pid),
        'description'      => $excerpt,
        'datePublished'    => get_post_time('c', true, $pid),
        'dateModified'     => get_post_modified_time('c', true, $pid),
        'inLanguage'       => 'ro',
        'mainEntityOfPage' => get_permalink($pid),
        'author'           => [
            '@type' => 'Person',
            'name'  => $author_name,
        ],
        'publisher'        => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
            '@id'   => home_url('/') . '#organization',
            'url'   => home_url('/'),
        ],
    ];
    if ($logo_url) {
        $data['publisher']['logo'] = [
            '@type' => 'ImageObject',
            'url'   => $logo_url,
        ];
    }
    if ($thumb) $data['image'] = $thumb;

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Course/Service/Article — paginile pilon (page-pillar.php)
   Tipul schemei se alege din ACF câmp `pl_schema_type`:
     - course   → Course schema (default; pentru ju-jitsu-copii, autoaparare-*)
     - service  → Service schema (pentru personal-trainer)
     - article  → Article schema (pentru ghiduri editoriale ex. arte-martiale)
   ========================================================================== */

function kokoro_render_jsonld_pillar() {
    if (!is_page()) return;
    if (!is_page_template('page-pillar.php')) return;
    if (!function_exists('get_field')) return;

    $pid  = get_queried_object_id();
    if (!$pid) return;

    $type = (string) get_field('pl_schema_type', $pid);
    if ($type === '') $type = 'course';

    $title = get_the_title($pid);
    $url   = get_permalink($pid);
    $desc  = (string) get_field('pl_intro_text', $pid);
    $desc  = $desc !== '' ? wp_trim_words(wp_strip_all_tags($desc), 50, '…') : '';
    $thumb = has_post_thumbnail($pid) ? get_the_post_thumbnail_url($pid, 'kokoro-hero') : '';

    $org = [
        '@type' => 'Organization',
        'name'  => get_bloginfo('name'),
        '@id'   => home_url('/') . '#organization',
        'url'   => home_url('/'),
    ];
    $place_address = [
        '@type'           => 'PostalAddress',
        'streetAddress'   => kokoro_setting('strada', ''),
        'addressLocality' => kokoro_setting('localitate', 'Brașov'),
        'addressCountry'  => kokoro_setting('tara', 'RO'),
    ];

    $data = ['@context' => 'https://schema.org'];

    switch ($type) {
        case 'service':
            $data += [
                '@type'       => 'Service',
                'name'        => $title,
                'description' => $desc,
                'url'         => $url,
                'provider'    => $org,
                'areaServed'  => ['@type' => 'City', 'name' => kokoro_setting('localitate', 'Brașov')],
            ];
            break;
        case 'article':
            $data += [
                '@type'         => 'Article',
                'headline'      => $title,
                'description'   => $desc,
                'url'           => $url,
                'datePublished' => get_the_date('c', $pid),
                'dateModified'  => get_the_modified_date('c', $pid),
                'author'        => $org,
                'publisher'     => $org,
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $url],
            ];
            if ($thumb) $data['image'] = $thumb;
            break;
        case 'course':
        default:
            $data += [
                '@type'            => 'Course',
                'name'             => $title,
                'description'      => $desc,
                'url'              => $url,
                'provider'         => $org,
                'inLanguage'       => 'ro',
                'courseMode'       => 'in-person',
                'educationalLevel' => 'Beginner to Advanced',
                'hasCourseInstance'=> [
                    '@type'      => 'CourseInstance',
                    'courseMode' => 'in-person',
                    'location'   => [
                        '@type'   => 'Place',
                        'name'    => get_bloginfo('name'),
                        'address' => $place_address,
                    ],
                ],
            ];
            if ($thumb) $data['image'] = $thumb;
            break;
    }

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Service + Offers pe page-tarife.php
   ========================================================================== */

function kokoro_render_jsonld_tarife() {
    if (!is_page_template('page-tarife.php')) return;
    if (!function_exists('get_field')) return;

    $pachete = get_field('tarife_pachete');
    if (!is_array($pachete) || empty($pachete)) return;

    $offers = [];
    $prices = [];
    $url    = get_permalink();

    foreach ($pachete as $p) {
        $titlu = trim((string) ($p['titlu'] ?? ''));
        $pret  = (int) ($p['pret'] ?? 0);
        if ($titlu === '' || $pret <= 0) continue;

        $moneda_raw = strtoupper(trim((string) ($p['moneda'] ?? 'RON')));
        $moneda = ($moneda_raw === 'LEI' || $moneda_raw === '') ? 'RON' : $moneda_raw;
        $perioada = (string) ($p['perioada'] ?? '/ lună');

        // Mapează „/ lună" → MONTH (ISO 8601 unitText pe Schema.org)
        $unit = 'MONTH';
        if (stripos($perioada, 'ședință') !== false || stripos($perioada, 'sedinta') !== false) $unit = 'EA'; // each
        elseif (stripos($perioada, 'an') !== false && stripos($perioada, 'lună') === false)    $unit = 'ANN';
        elseif (stripos($perioada, 'săpt') !== false || stripos($perioada, 'sapt') !== false)  $unit = 'WEE';

        // Beneficii → string concatenat (Offer.description)
        $beneficii = [];
        if (!empty($p['beneficii']) && is_array($p['beneficii'])) {
            foreach ($p['beneficii'] as $b) {
                $t = trim((string) ($b['text'] ?? ''));
                if ($t !== '') $beneficii[] = $t;
            }
        }

        $offer = [
            '@type'         => 'Offer',
            'name'          => $titlu,
            'price'         => (string) $pret,
            'priceCurrency' => $moneda,
            'priceSpecification' => [
                '@type'         => 'UnitPriceSpecification',
                'price'         => (string) $pret,
                'priceCurrency' => $moneda,
                'unitCode'      => $unit,
                'referenceQuantity' => [
                    '@type'    => 'QuantitativeValue',
                    'value'    => 1,
                    'unitCode' => $unit,
                ],
            ],
            'availability' => 'https://schema.org/InStock',
            'url'          => $url,
        ];
        if (!empty($beneficii)) {
            $offer['description'] = implode('; ', $beneficii);
        }
        $offers[] = $offer;
        $prices[] = $pret;
    }

    if (empty($offers)) return;

    $service = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $url . '#service-tarife',
        'name'        => 'Cursuri Ju-Jitsu și Autoapărare — Kokoro Brașov',
        'serviceType' => 'Antrenament Ju-Jitsu',
        'description' => 'Pachete de antrenament pentru copii, juniori, adulți și personal training la Academia Kokoro din Brașov.',
        'provider'    => ['@id' => home_url('/') . '#organization'],
        'areaServed'  => ['@type' => 'City', 'name' => kokoro_setting('localitate', 'Brașov')],
        'url'         => $url,
    ];

    if (count($offers) > 1) {
        $service['offers'] = [
            '@type'         => 'AggregateOffer',
            'priceCurrency' => 'RON',
            'lowPrice'      => (string) min($prices),
            'highPrice'     => (string) max($prices),
            'offerCount'    => count($offers),
            'offers'        => $offers,
        ];
    } else {
        $service['offers'] = $offers[0];
    }

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($service, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

/* ==========================================================================
   JSON-LD: Reviews pe homepage + page-pillar.php (gated by consent)
   ========================================================================== */

/**
 * Construiește un Review schema pentru un testimonial.
 *
 * @param string $text     Textul testimonialului.
 * @param string $autor    Numele autorului (deja anonimizat în ACF, ex. „Maria P." sau „mama lui Andrei").
 * @param string $sursa    Sursa (ex. „Google Review"). Opțional.
 * @return array|null
 */
function kokoro_build_review($text, $autor, $sursa = '') {
    $text  = trim(wp_strip_all_tags((string) $text));
    $autor = trim((string) $autor);
    if ($text === '' || $autor === '') return null;

    $review = [
        '@type'        => 'Review',
        'itemReviewed' => ['@id' => home_url('/') . '#organization'],
        'reviewRating' => [
            '@type'       => 'Rating',
            'ratingValue' => '5',
            'bestRating'  => '5',
        ],
        'author'       => ['@type' => 'Person', 'name' => $autor],
        'reviewBody'   => $text,
    ];
    if ($sursa !== '') {
        $review['publisher'] = ['@type' => 'Organization', 'name' => $sursa];
    }
    return $review;
}

function kokoro_render_jsonld_reviews() {
    if (!function_exists('get_field')) return;

    $reviews = [];

    if (is_front_page()) {
        $items = get_field('home_test', get_queried_object_id());
        if (is_array($items)) {
            foreach ($items as $r) {
                if (empty($r['consimtamant_publicare'])) continue; // GDPR gate
                $review = kokoro_build_review(
                    $r['text']  ?? '',
                    $r['autor'] ?? '',
                    $r['sursa'] ?? ''
                );
                if ($review) $reviews[] = $review;
            }
        }
    } elseif (is_page_template('page-pillar.php')) {
        $items = get_field('pl_test');
        if (is_array($items)) {
            foreach ($items as $r) {
                if (empty($r['consimtamant_publicare'])) continue;
                $name = trim((string) ($r['autor'] ?? ''));
                $meta = trim((string) ($r['meta'] ?? ''));
                if ($meta !== '') $name .= ' (' . $meta . ')';
                $review = kokoro_build_review($r['text'] ?? '', $name, '');
                if ($review) $reviews[] = $review;
            }
        }
    }

    if (empty($reviews)) return;

    foreach ($reviews as $r) {
        echo "\n<script type=\"application/ld+json\">\n";
        echo wp_json_encode($r, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n</script>\n";
    }
}

/**
 * Helper: randează vizual FAQ-ul (același conținut care intră în FAQPage schema).
 * Folosit în template-uri: dacă pagina/postul curent are kokoro_faq populat,
 * apare ca secțiune pe ecran. Apel: <?php kokoro_render_faq_section(); ?>
 *
 * @param int|null $post_id Post-ul curent dacă e null.
 * @return void
 */
function kokoro_render_faq_section($post_id = null) {
    if (!function_exists('get_field')) return;
    $faq = get_field('kokoro_faq', $post_id);
    if (!is_array($faq) || empty($faq)) return;
    ?>
    <section class="section section--alt" id="faq">
      <div class="container container--narrow">
        <div class="section__header reveal">
          <div class="section-number">FAQ</div>
          <h2>ÎNTREBĂRI<br><em>FRECVENTE</em></h2>
        </div>

        <div class="kokoro-faq" style="display: flex; flex-direction: column; gap: var(--space-md);">
          <?php foreach ($faq as $i => $row) :
              $q = $row['intrebare'] ?? '';
              $a = $row['raspuns']   ?? '';
              if ($q === '' || $a === '') continue;
              $delay = 'reveal-delay-' . min($i + 1, 4);
          ?>
            <details class="reveal <?php echo esc_attr($delay); ?>" style="background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); border-radius: 4px; padding: var(--space-md) var(--space-lg);">
              <summary style="cursor: pointer; font-weight: 700; color: var(--color-white); font-size: 1.0625rem; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: var(--space-md);">
                <span><?php echo esc_html($q); ?></span>
                <span aria-hidden="true" style="color: var(--color-accent); font-family: var(--font-heading); font-size: 1.5rem;">+</span>
              </summary>
              <div style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-md); padding-top: var(--space-md); border-top: 1px solid var(--color-gray-dark);">
                <?php echo wp_kses_post(wpautop($a)); ?>
              </div>
            </details>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php
}

/**
 * Hook footer: outputează schema-urile.
 */
function kokoro_print_jsonld_schemas() {
    $renderers = [
        'organization'      => 'kokoro_render_jsonld_organization',
        'breadcrumb'        => 'kokoro_render_jsonld_breadcrumb',
        'person_campion'    => 'kokoro_render_jsonld_person_campion',
        'person_antrenor'   => 'kokoro_render_jsonld_person_antrenor',
        'course_disciplina' => 'kokoro_render_jsonld_course_disciplina',
        'pillar'            => 'kokoro_render_jsonld_pillar',
        'faqpage'           => 'kokoro_render_jsonld_faqpage',
        'article'           => 'kokoro_render_jsonld_article',
        'tarife'            => 'kokoro_render_jsonld_tarife',
        'reviews'           => 'kokoro_render_jsonld_reviews',
    ];
    /**
     * Filter the list of JSON-LD schema renderers emitted at wp_footer.
     *
     * Util pentru a dezactiva o schemă specifică: e.g.
     *   add_filter('kokoro_jsonld_renderers', fn($r) => array_diff_key($r, ['reviews' => 1]));
     *
     * @param array<string,callable> $renderers slug → callable map.
     */
    $renderers = apply_filters('kokoro_jsonld_renderers', $renderers);
    foreach ($renderers as $fn) {
        if (is_callable($fn)) $fn();
    }
}
add_action('wp_footer', 'kokoro_print_jsonld_schemas', 100);
