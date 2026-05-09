<?php
/**
 * Kokoro — Helper functions
 *
 * Functions used across templates (settings access, SVG inline, title parsing,
 * data sorting, palmares, medalie labels, honorific stripping).
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

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
 * Anii de experiență ai academiei (dinamic, calculat din anul fondării).
 *
 * Citește ACF `set_an_fondare` (default 2008). Folosit în pillar pages,
 * JSON-LD schema, FAQ — orice loc unde apare „N ani de experiență".
 *
 * @return int Numărul de ani; 0 fallback dacă an_fondare invalid.
 */
function kokoro_ani_experienta() {
    $an_fondare = (int) kokoro_setting('an_fondare', 2008);
    $current    = (int) date('Y');
    return max(0, $current - $an_fondare);
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

/**
 * Înlătură prefix-urile honorifice cunoscute din începutul unui nume.
 *
 * Folosit DOAR ca fallback în schema.org Person.name când ACF given_name +
 * family_name nu sunt populate. Pentru un comportament determinist și granular,
 * preferă întotdeauna câmpurile ACF dedicate.
 *
 * Match case-insensitive doar la START. „Petru Sensei" rămâne neatins.
 *
 * @param string $name Nume cu sau fără prefix.
 * @return string Numele fără prefix + trim.
 */
function kokoro_strip_honorific($name) {
    $name = (string) $name;
    if ($name === '') return '';
    $prefixes = ['Sensei', 'Sempai', 'Sifu', 'Master'];
    foreach ($prefixes as $prefix) {
        if (stripos($name, $prefix . ' ') === 0) {
            $name = substr($name, strlen($prefix) + 1);
            break;
        }
    }
    return trim($name);
}

/* ==========================================================================
   Phone helpers (mutat din inc/seo-meta.php pentru disponibilitate globală)
   ========================================================================== */

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
