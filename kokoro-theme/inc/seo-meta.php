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

        // B5 (Faza 8): paginile de „mulțumire" sunt thank-you pages — never index.
        // Slug-ul/template-ul e detectat aici ca safety net peste flag-ul ACF.
        $tpl_slug = (string) get_post_meta($pid, '_wp_page_template', true);
        if ($tpl_slug === 'page-multumesc-inscriere.php' || strpos((string) get_post_field('post_name', $pid), 'multumesc') === 0) {
            $noindex = true;
        }

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

    $data = [
        'title'       => $title,
        'description' => $description,
        'keywords'    => $keywords,
        'og_image'    => $og_image,
        'og_type'     => $og_type,
        'canonical'   => $canonical,
        'noindex'     => $noindex,
        'twitter'     => $twitter,
    ];

    /**
     * Filter the SEO data computed for the current request.
     *
     * Permite plugin-uri / mu-plugins / temă-copil să suprascrie valori
     * fără să modifice template-ul. Util pentru landing-pages cu titlu
     * dinamic, A/B testing pe meta description, etc.
     *
     * @param array $data SEO data (title, description, keywords, og_image, og_type, canonical, noindex, twitter).
     */
    return apply_filters('kokoro_seo_data', $data);
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

    // <title> e emis de WP via add_theme_support('title-tag') + filtrul
    // kokoro_filter_document_title (vezi mai jos). Plugin-urile SEO (ex. SiteSEO)
    // pot suprascrie cu prioritate >1.
    ?>
<meta name="description" content="<?php echo esc_attr($d['description']); ?>">
<?php if (!empty($d['keywords'])) : ?>
<meta name="keywords" content="<?php echo esc_attr($d['keywords']); ?>">
<?php endif; ?>
<meta name="author" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
<meta name="robots" content="<?php echo esc_attr($robots); ?>">
<meta name="theme-color" content="var(--color-dark)">

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
 * Filtru pentru <title>. Rulează la prioritate 1 (înainte de plugin-uri SEO),
 * deci dacă SiteSEO/Yoast/RankMath sunt active la prioritate 10, ele vor
 * suprascrie valoarea returnată aici. Dacă niciun plugin SEO nu intervine,
 * formatul nostru e folosit.
 *
 * Nu apelăm wp_get_document_title() ca să evităm recursivitatea prin
 * kokoro_seo_data().
 */
function kokoro_filter_document_title($title) {
    $separator = kokoro_setting('seo_separator', ' | ');
    $site_name = get_bloginfo('name');

    if (is_front_page()) {
        return kokoro_setting('seo_titlu_home', $site_name);
    }
    if (is_singular()) {
        $pid      = get_queried_object_id();
        $override = kokoro_seo_field('kokoro_seo_titlu', $pid);
        if ($override !== '') return $override;
        return get_the_title($pid) . $separator . $site_name;
    }
    if (is_search()) {
        return sprintf('Căutare pentru „%s"%s%s', get_search_query(), $separator, $site_name);
    }
    if (is_404()) {
        return 'Pagina nu există' . $separator . $site_name;
    }
    return $title; // arhive, taxonomy etc. → titlul implicit WP
}
add_filter('pre_get_document_title', 'kokoro_filter_document_title', 1);

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


/* JSON-LD schema generators au fost mutate în inc/seo-schemas.php
   (Organization, Person, Course, Article, FAQPage, Pillar, Tarife, Reviews) */


/* ==========================================================================
   robots.txt — completare automată cu sitemap
   ========================================================================== */

function kokoro_robots_txt_sitemap($output, $public) {
    if (!$public) return $output;
    $sitemap = home_url('/wp-sitemap.xml');
    if (strpos($output, 'Sitemap:') === false) {
        $output .= "\nSitemap: {$sitemap}\n";
    }
    return $output;
}
add_filter('robots_txt', 'kokoro_robots_txt_sitemap', 10, 2);

/* ==========================================================================
   Sitemap WP — exclude kokoro_msg (mesaje formular private)
   ========================================================================== */

function kokoro_sitemaps_exclude_msg($post_types) {
    unset($post_types['kokoro_msg']); // never expose private messages
    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'kokoro_sitemaps_exclude_msg');
