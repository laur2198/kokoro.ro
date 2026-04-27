<?php
/**
 * SEO Meta tags + JSON-LD generator — Kokoro Brașov Academy
 *
 * Generează automat <title>, meta description, OG, Twitter Card, canonical,
 * hreflang, geo tags și schema markup (Organization/SportsActivityLocation,
 * BreadcrumbList) pe fiecare pagină.
 *
 * Per-page overrides via ACF câmpuri kokoro_seo_*.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Helper: citește un câmp ACF de pe post-ul curent (sau post specific).
 */
function kokoro_seo_field($name, $post_id = null) {
    if (!function_exists('get_field')) return '';
    $val = get_field($name, $post_id);
    return is_string($val) ? $val : '';
}

/**
 * Întoarce datele SEO calculate pentru pagina curentă.
 *
 * @return array
 */
function kokoro_seo_data() {
    $separator     = kokoro_setting('seo_separator', ' | ');
    $site_name     = get_bloginfo('name');
    $site_desc     = get_bloginfo('description');
    $home_title    = kokoro_setting('seo_titlu_home', $site_name);
    $home_desc     = kokoro_setting('seo_desc_home', kokoro_setting('meta_descriere', $site_desc));
    $default_kw    = kokoro_setting('seo_keywords_default', '');
    $og_default    = kokoro_setting('seo_og_default', '');
    $twitter       = kokoro_setting('seo_twitter', '');

    $url_current   = (is_ssl() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '/');
    $canonical     = home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? '/'));

    $title = '';
    $description = '';
    $keywords = $default_kw;
    $og_image = $og_default;
    $og_type = 'website';
    $noindex = false;

    if (is_front_page()) {
        $title       = $home_title;
        $description = $home_desc;
        $canonical   = home_url('/');
    } elseif (is_singular()) {
        $pid = get_queried_object_id();

        $override_title = kokoro_seo_field('kokoro_seo_titlu', $pid);
        $override_desc  = kokoro_seo_field('kokoro_seo_desc', $pid);
        $override_kw    = kokoro_seo_field('kokoro_seo_keywords', $pid);
        $override_og    = function_exists('get_field') ? (string) get_field('kokoro_seo_og_image', $pid) : '';
        $noindex        = function_exists('get_field') ? (bool) get_field('kokoro_seo_noindex', $pid) : false;

        $title       = $override_title !== '' ? $override_title : get_the_title($pid) . $separator . $site_name;
        $description = $override_desc  !== '' ? $override_desc  : wp_trim_words(wp_strip_all_tags(get_the_excerpt() ?: get_post_field('post_content', $pid)), 28, '…');
        if ($description === '' || $description === '…') {
            $description = $home_desc;
        }
        if ($override_kw !== '') $keywords = $override_kw;
        if ($override_og !== '') {
            $og_image = $override_og;
        } elseif (has_post_thumbnail($pid)) {
            $og_image = get_the_post_thumbnail_url($pid, 'large') ?: $og_default;
        }
        $canonical = get_permalink($pid);
        if (get_post_type($pid) === 'post') {
            $og_type = 'article';
        }
    } elseif (is_search()) {
        $title       = sprintf('Căutare pentru „%s"%s%s', get_search_query(), $separator, $site_name);
        $description = sprintf('Rezultate căutare „%s" pe site-ul Kokoro Brașov Academy.', get_search_query());
        $noindex     = true;
    } elseif (is_404()) {
        $title       = 'Pagina nu există' . $separator . $site_name;
        $description = 'Pagina căutată nu există. Întoarce-te la pagina principală sau caută altceva.';
        $noindex     = true;
    } elseif (is_archive()) {
        $title       = wp_get_document_title();
        $description = $home_desc;
    } else {
        $title       = wp_get_document_title();
        $description = $home_desc;
    }

    return [
        'title'       => $title,
        'description' => $description,
        'keywords'    => $keywords,
        'og_image'    => $og_image,
        'og_type'     => $og_type,
        'canonical'   => $canonical,
        'noindex'     => $noindex,
        'twitter'     => $twitter,
    ];
}

/**
 * Print <title>, meta tags, OG, Twitter, canonical, hreflang, geo.
 * Apelat din header.php (în <head>).
 */
function kokoro_render_seo_meta() {
    $d = kokoro_seo_data();
    $lat = kokoro_setting('lat', '');
    $lng = kokoro_setting('lng', '');
    $regiune_iso = 'RO-BV'; // Brașov

    $robots = $d['noindex']
        ? 'noindex, nofollow'
        : 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';

    $og_image_w = 1200;
    $og_image_h = 630;
    ?>
<title><?php echo esc_html($d['title']); ?></title>
<meta name="description" content="<?php echo esc_attr($d['description']); ?>">
<?php if (!empty($d['keywords'])) : ?>
<meta name="keywords" content="<?php echo esc_attr($d['keywords']); ?>">
<?php endif; ?>
<meta name="author" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
<meta name="robots" content="<?php echo esc_attr($robots); ?>">
<meta name="theme-color" content="#0D2137">

<meta name="geo.region" content="<?php echo esc_attr($regiune_iso); ?>">
<meta name="geo.placename" content="<?php echo esc_attr(kokoro_setting('localitate', 'Brașov')); ?>">
<?php if ($lat !== '' && $lng !== '') : ?>
<meta name="geo.position" content="<?php echo esc_attr($lat . ';' . $lng); ?>">
<meta name="ICBM" content="<?php echo esc_attr($lat . ', ' . $lng); ?>">
<?php endif; ?>

<link rel="canonical" href="<?php echo esc_url($d['canonical']); ?>">
<link rel="alternate" hreflang="ro" href="<?php echo esc_url($d['canonical']); ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo esc_url($d['canonical']); ?>">

<!-- Open Graph -->
<meta property="og:type" content="<?php echo esc_attr($d['og_type']); ?>">
<meta property="og:locale" content="ro_RO">
<meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
<meta property="og:title" content="<?php echo esc_attr($d['title']); ?>">
<meta property="og:description" content="<?php echo esc_attr($d['description']); ?>">
<meta property="og:url" content="<?php echo esc_url($d['canonical']); ?>">
<?php if (!empty($d['og_image'])) : ?>
<meta property="og:image" content="<?php echo esc_url($d['og_image']); ?>">
<meta property="og:image:width" content="<?php echo (int) $og_image_w; ?>">
<meta property="og:image:height" content="<?php echo (int) $og_image_h; ?>">
<meta property="og:image:alt" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo esc_attr($d['title']); ?>">
<meta name="twitter:description" content="<?php echo esc_attr($d['description']); ?>">
<?php if (!empty($d['og_image'])) : ?>
<meta name="twitter:image" content="<?php echo esc_url($d['og_image']); ?>">
<?php endif; ?>
<?php if (!empty($d['twitter'])) : ?>
<meta name="twitter:site" content="<?php echo esc_attr($d['twitter']); ?>">
<?php endif; ?>
    <?php
}

/**
 * Hook in <head> ca alternativă la apelul direct din header.php.
 * Preferăm apel direct, dar în caz de fallback, încarcă acest hook.
 */

/**
 * Ascunde titlul implicit WordPress dacă tema îl gestionează.
 * (Tema noastră generează propriul <title> via kokoro_render_seo_meta().)
 *
 * Notă: tema deja are add_theme_support('title-tag'), care permite WP
 * să genereze titlul. Folosim wp_get_document_title() în fallback-uri.
 */

/* ==========================================================================
   JSON-LD: Organization / SportsActivityLocation (universal, în footer)
   ========================================================================== */

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

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'SportsActivityLocation',
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
function kokoro_phone_to_e164($phone) {
    if (!$phone) return '';
    $digits = preg_replace('/\D/', '', $phone);
    if ($digits === '') return '';
    if (strpos($digits, '40') === 0 && strlen($digits) >= 11) {
        return '+' . $digits;
    }
    if (strpos($digits, '0') === 0) {
        return '+40' . substr($digits, 1);
    }
    return '+' . $digits;
}

/**
 * BreadcrumbList — generat dinamic pe pagini interioare.
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

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink($cid) . '#person',
        'name'        => get_the_title($cid),
        'url'         => get_permalink($cid),
        'jobTitle'    => 'Sportiv Kokoro Brașov',
        'affiliation' => [
            '@type' => 'SportsOrganization',
            'name'  => get_bloginfo('name'),
            'url'   => home_url('/'),
        ],
        'worksFor'    => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
            '@id'   => home_url('/') . '#organization',
        ],
        'knowsAbout'  => ['Ju-Jitsu', 'Arte marțiale'],
    ];
    if ($thumb)   $data['image']       = $thumb;
    if ($bio)     $data['description'] = wp_strip_all_tags($bio);
    if (!empty($awards)) $data['award'] = $awards;

    echo "\n<script type=\"application/ld+json\">\n";
    echo wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}

function kokoro_render_jsonld_person_antrenor() {
    if (!is_singular('antrenor')) return;
    $aid = get_queried_object_id();
    if (!$aid) return;

    $rol          = function_exists('get_field') ? (string) get_field('antrenor_rol', $aid)          : '';
    $bio          = function_exists('get_field') ? (string) get_field('antrenor_bio_scurt', $aid)    : '';
    $specializare = function_exists('get_field') ? (string) get_field('antrenor_specializare', $aid) : '';
    $email_a      = function_exists('get_field') ? (string) get_field('antrenor_email', $aid)        : '';
    $tel_a        = function_exists('get_field') ? (string) get_field('antrenor_telefon', $aid)      : '';
    $facebook_a   = function_exists('get_field') ? (string) get_field('antrenor_facebook', $aid)     : '';
    $instagram_a  = function_exists('get_field') ? (string) get_field('antrenor_instagram', $aid)    : '';
    $thumb        = has_post_thumbnail($aid) ? get_the_post_thumbnail_url($aid, 'kokoro-square') : '';

    $data = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Person',
        '@id'         => get_permalink($aid) . '#person',
        'name'        => get_the_title($aid),
        'url'         => get_permalink($aid),
        'jobTitle'    => $rol !== '' ? $rol : 'Antrenor',
        'worksFor'    => [
            '@type' => 'Organization',
            'name'  => get_bloginfo('name'),
            '@id'   => home_url('/') . '#organization',
        ],
    ];
    if ($specializare !== '') $data['knowsAbout'] = array_map('trim', explode(',', $specializare));
    if ($bio)     $data['description'] = wp_strip_all_tags($bio);
    if ($thumb)   $data['image']       = $thumb;
    if ($email_a) $data['email']       = $email_a;
    if ($tel_a)   $data['telephone']   = kokoro_phone_to_e164($tel_a) ?: $tel_a;
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
    kokoro_render_jsonld_organization();
    kokoro_render_jsonld_breadcrumb();
    kokoro_render_jsonld_person_campion();
    kokoro_render_jsonld_person_antrenor();
    kokoro_render_jsonld_course_disciplina();
    kokoro_render_jsonld_pillar();
    kokoro_render_jsonld_faqpage();
    kokoro_render_jsonld_article();
}
add_action('wp_footer', 'kokoro_print_jsonld_schemas', 100);

/* ==========================================================================
   robots.txt — completare automată cu sitemap
   ========================================================================== */

add_filter('robots_txt', function ($output, $public) {
    if (!$public) return $output;
    $sitemap = home_url('/wp-sitemap.xml');
    if (strpos($output, 'Sitemap:') === false) {
        $output .= "\nSitemap: {$sitemap}\n";
    }
    return $output;
}, 10, 2);

/* ==========================================================================
   Sitemap WP — include CPT-urile noastre și exclude kokoro_msg
   ========================================================================== */

add_filter('wp_sitemaps_post_types', function ($post_types) {
    // Asigură-te că CPT-urile sunt incluse (sunt deja public=true)
    unset($post_types['kokoro_msg']); // never expose private messages
    return $post_types;
});
