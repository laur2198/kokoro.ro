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

/**
 * Hook footer: outputează schema-urile.
 */
function kokoro_print_jsonld_schemas() {
    kokoro_render_jsonld_organization();
    kokoro_render_jsonld_breadcrumb();
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
