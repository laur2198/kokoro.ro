<?php
/**
 * Kokoro Brașov — Performance Snapshot Tap
 *
 * Colectează: query count, timing per hook major (parse_request → wp_footer),
 * număr de get_field loads ACF, inventar <img> emise (lazy/srcset/dimensiuni/bytes),
 * dimensiune HTML, asset-uri enqueued. Salvează JSON în uploads sau printează
 * un panel în footer pentru admins.
 *
 * ============================================================================
 * INSTALARE (mu-plugin mode — recomandat):
 *   1. Adaugă în wp-config.php deasupra liniei „That's all, stop editing":
 *        define('SAVEQUERIES', true);
 *      (fără asta, nu se contorizează query-urile)
 *   2. Copiază acest fișier în wp-content/mu-plugins/perf-snapshot.php
 *      (creează folderul dacă nu există)
 *   3. Loghează ca admin → vizitează orice pagină front-end →
 *      panelul perf apare fixat în colțul dreapta-jos
 *   4. Pentru a salva JSON: vizitează ?kokoro_perf_dump=1
 *      (rezultatul e în wp-content/uploads/kokoro-perf/)
 *   5. După colectare, șterge fișierul din mu-plugins/
 *
 * INSTALARE (CLI test):
 *   wp eval-file wp-content/themes/kokoro-theme/bin/perf-snapshot.php
 *   → printează doar instrucțiuni; nu rulează tap-ul
 *
 * SECURITATE:
 *   - Nu produce output decât pentru utilizatori cu manage_options
 *   - bin/.htaccess blochează accesul HTTP direct la acest fișier când e
 *     păstrat în bin/. În mu-plugins/ se bazează pe verificarea de capabilitate.
 *   - Nu modifică DB. Read-only — citește $wpdb->queries (dacă SAVEQUERIES
 *     e activ), output buffer și hooks ACF.
 *
 * @package Kokoro
 */

// =====================================================================
// Mod 1: Bootstrap standalone (CLI sau acces direct prin HTTP)
// =====================================================================
if (!defined('ABSPATH')) {
    $boot_paths = [
        __DIR__ . '/../../../../wp-load.php', // bin/ în temă
        __DIR__ . '/../../../wp-load.php',    // mu-plugins (file mutat)
        __DIR__ . '/../../wp-load.php',
    ];
    foreach ($boot_paths as $p) {
        if (file_exists($p)) { require_once $p; break; }
    }
    if (!defined('ABSPATH')) {
        echo "Cannot locate wp-load.php\n";
        exit(1);
    }
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        die("Acces interzis. Trebuie să fii logat ca admin.\n");
    }

    $msg  = "Kokoro Perf Snapshot — instrucțiuni:\n\n";
    $msg .= "Acest fișier e proiectat să ruleze ca mu-plugin, nu standalone.\n\n";
    $msg .= "Pași:\n";
    $msg .= "  1. Asigură-te că ai în wp-config.php:\n";
    $msg .= "     define('SAVEQUERIES', true);\n\n";
    $msg .= "  2. Copiază bin/perf-snapshot.php în wp-content/mu-plugins/perf-snapshot.php\n\n";
    $msg .= "  3. Loghează ca admin și vizitează paginile cheie\n";
    $msg .= "     (homepage, /noutati/, /contact/, /tarife/, /inscriere/).\n\n";
    $msg .= "  4. Pentru fiecare pagină, adaugă ?kokoro_perf_dump=1 ca să\n";
    $msg .= "     salvezi JSON în uploads/kokoro-perf/.\n\n";
    $msg .= "  5. Trimite back JSON-urile ca să recomand fix-uri targeted.\n\n";
    $msg .= "SAVEQUERIES enabled: " . (defined('SAVEQUERIES') && SAVEQUERIES ? 'YES' : 'NO — adaugă în wp-config.php') . "\n";
    if (defined('WP_CLI') && class_exists('WP_CLI')) {
        WP_CLI::log($msg);
    } else {
        echo nl2br(esc_html($msg));
    }
    exit;
}

// =====================================================================
// Mod 2: Auto-load ca mu-plugin
// =====================================================================
if (class_exists('Kokoro_Perf_Snapshot', false)) {
    return;
}

final class Kokoro_Perf_Snapshot {

    /** @var float */
    private static $start = 0.0;

    /** @var array<string, float> Hook → relative seconds since $start */
    private static $hook_times = [];

    /** @var int Counts unique field+post lookups via acf/load_value */
    private static $acf_loads = 0;

    /** @var bool */
    private static $started = false;

    public static function register() {
        // 'init' priority 0 — early enough to wrap most of the request
        add_action('init', [__CLASS__, 'maybe_start'], 0);
    }

    public static function maybe_start() {
        // Skip admin, AJAX, REST, WP-CLI, cron, feeds
        if (is_admin()) return;
        if (defined('DOING_AJAX') && DOING_AJAX) return;
        if (defined('DOING_CRON') && DOING_CRON) return;
        if (defined('REST_REQUEST') && REST_REQUEST) return;
        if (defined('WP_CLI') && WP_CLI) return;
        if (function_exists('is_feed') && is_feed()) return;

        // Only run for admins
        if (!is_user_logged_in() || !current_user_can('manage_options')) return;

        self::$start   = microtime(true);
        self::$started = true;

        // Capture full output
        ob_start();

        // Mark major hooks
        $hooks = ['parse_request', 'wp', 'template_redirect', 'wp_head', 'wp_footer'];
        foreach ($hooks as $hook) {
            add_action($hook, function () use ($hook) {
                if (!isset(self::$hook_times[$hook])) {
                    self::$hook_times[$hook] = microtime(true) - self::$start;
                }
            }, 0);
        }

        // Count ACF field loads (unique field+post pairs — ACF caches subsequent calls)
        if (function_exists('add_filter')) {
            add_filter('acf/load_value', [__CLASS__, 'count_acf'], 99, 1);
        }

        // Render at wp_footer priority 9999 — last in queue
        add_action('wp_footer', [__CLASS__, 'render'], 9999);
    }

    public static function count_acf($value) {
        self::$acf_loads++;
        return $value;
    }

    public static function render() {
        if (!self::$started) return;
        global $wpdb, $wp_styles, $wp_scripts;

        $end_time = microtime(true);
        $html     = ob_get_contents() ?: '';
        $report   = self::build_report($html, $wpdb, $wp_styles, $wp_scripts, $end_time);

        // Optional: dump JSON to uploads if ?kokoro_perf_dump=1
        if (!empty($_GET['kokoro_perf_dump'])) {
            $saved = self::save_json($report);
            if ($saved) {
                $report['saved_to'] = $saved;
            }
        }

        self::render_panel($report);
    }

    private static function build_report($html, $wpdb, $wp_styles, $wp_scripts, $end_time) {
        $imgs        = self::scan_images($html);
        $with_lazy   = 0;
        $with_srcset = 0;
        $with_dims   = 0;
        $total_bytes = 0;
        foreach ($imgs as $img) {
            if (($img['loading'] ?? '') === 'lazy') $with_lazy++;
            if (!empty($img['srcset']))             $with_srcset++;
            if (!empty($img['width']) && !empty($img['height'])) $with_dims++;
            if (!empty($img['bytes']))              $total_bytes += $img['bytes'];
        }

        $query_count = null;
        $query_ms    = null;
        if (defined('SAVEQUERIES') && SAVEQUERIES && is_array($wpdb->queries)) {
            $query_count = count($wpdb->queries);
            $sum = 0.0;
            foreach ($wpdb->queries as $q) {
                $sum += isset($q[1]) ? (float) $q[1] : 0.0;
            }
            $query_ms = round($sum * 1000, 1);
        }

        $hooks_ms = [];
        foreach (self::$hook_times as $h => $t) {
            $hooks_ms[$h] = round($t * 1000, 1);
        }

        $styles  = is_object($wp_styles)  && !empty($wp_styles->done)  ? array_values($wp_styles->done)  : [];
        $scripts = is_object($wp_scripts) && !empty($wp_scripts->done) ? array_values($wp_scripts->done) : [];

        $req_uri = $_SERVER['REQUEST_URI'] ?? '/';
        $slug    = trim(parse_url($req_uri, PHP_URL_PATH) ?? '/', '/') ?: 'home';

        return [
            'meta' => [
                'url'         => home_url($req_uri),
                'slug'        => $slug,
                'timestamp'   => date('c'),
                'php_version' => PHP_VERSION,
                'wp_version'  => get_bloginfo('version'),
            ],
            'time' => [
                'total_ms'      => round(($end_time - self::$start) * 1000, 1),
                'hooks_ms'      => $hooks_ms,
                'memory_peak_mb'=> round(memory_get_peak_usage(true) / 1048576, 2),
            ],
            'queries' => [
                'savequeries' => defined('SAVEQUERIES') && SAVEQUERIES,
                'count'       => $query_count,
                'time_ms'     => $query_ms,
            ],
            'acf' => [
                'load_value_calls' => self::$acf_loads,
                'note' => 'unique field+post pairs (ACF caches repeats within request)',
            ],
            'output' => [
                'html_kb'      => round(strlen($html) / 1024, 1),
                'images_count' => count($imgs),
                'images_with_lazy'   => $with_lazy,
                'images_with_srcset' => $with_srcset,
                'images_with_dims'   => $with_dims,
                'images_total_kb'    => round($total_bytes / 1024, 1),
            ],
            'assets' => [
                'styles_count'  => count($styles),
                'scripts_count' => count($scripts),
                'styles'        => $styles,
                'scripts'       => $scripts,
            ],
            'images_detail' => array_slice($imgs, 0, 30),
        ];
    }

    private static function scan_images($html) {
        if ($html === '') return [];
        if (!preg_match_all('/<img\b[^>]*>/i', $html, $matches)) return [];

        $home = home_url();
        $out  = [];
        foreach ($matches[0] as $tag) {
            $img = ['tag_excerpt' => substr($tag, 0, 180)];
            if (preg_match('/\bsrc=["\']([^"\']+)/', $tag, $m))     $img['src']     = $m[1];
            if (preg_match('/\bsrcset=["\']/i', $tag))               $img['srcset']  = true;
            if (preg_match('/\bsizes=["\']/i', $tag))                $img['sizes']   = true;
            if (preg_match('/\bloading=["\']([^"\']+)/i', $tag, $m)) $img['loading'] = $m[1];
            if (preg_match('/\bwidth=["\'](\d+)/', $tag, $m))        $img['width']   = (int) $m[1];
            if (preg_match('/\bheight=["\'](\d+)/', $tag, $m))       $img['height']  = (int) $m[1];
            if (preg_match('/\balt=["\']([^"\']*)/', $tag, $m))      $img['alt']     = $m[1];

            // File size if local
            if (!empty($img['src']) && strpos($img['src'], $home) === 0) {
                $path  = parse_url($img['src'], PHP_URL_PATH);
                $local = ABSPATH . ltrim((string) $path, '/');
                if (is_string($path) && file_exists($local) && is_file($local)) {
                    $img['bytes'] = filesize($local);
                }
            }
            $out[] = $img;
        }
        return $out;
    }

    private static function save_json($report) {
        $upload = wp_upload_dir();
        if (!empty($upload['error'])) return null;
        $dir = trailingslashit($upload['basedir']) . 'kokoro-perf';
        if (!is_dir($dir) && !wp_mkdir_p($dir)) return null;

        // Prevent directory listing
        $idx = $dir . '/index.html';
        if (!file_exists($idx)) {
            file_put_contents($idx, '');
        }

        $slug = sanitize_file_name($report['meta']['slug'] ?? 'home');
        if ($slug === '') $slug = 'home';

        $file = $dir . '/' . $slug . '-' . date('Ymd-His') . '.json';
        $json = wp_json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) return null;
        return file_put_contents($file, $json) !== false
            ? str_replace(ABSPATH, '/', $file)
            : null;
    }

    private static function render_panel($report) {
        // Slim version for footer panel — full version e în JSON
        $compact = $report;
        unset($compact['images_detail'], $compact['assets']['styles'], $compact['assets']['scripts']);

        $json  = wp_json_encode($compact, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $color = '#0F5132'; // green
        $count = $report['queries']['count'];
        if ($count !== null && $count > 50) $color = '#664D03';   // amber
        if ($count !== null && $count > 100) $color = '#842029';  // red
        ?>
<style id="kokoro-perf-style">
#kokoro-perf-snapshot { position: fixed; bottom: 0; right: 0; max-width: 520px;
  max-height: 70vh; overflow: auto; background: <?php echo esc_attr($color); ?>;
  color: #f1f1f1; font: 11px/1.45 'JetBrains Mono', ui-monospace, monospace;
  padding: 12px 14px; margin: 0; z-index: 999999; border-top-left-radius: 6px;
  box-shadow: -2px -2px 14px rgba(0,0,0,.35); white-space: pre-wrap; }
#kokoro-perf-snapshot h6 { margin: 0 0 8px; font-size: 12px; font-weight: 700;
  letter-spacing: .04em; text-transform: uppercase; }
#kokoro-perf-snapshot a { color: #FFD600; }
</style>
<pre id="kokoro-perf-snapshot"><h6>🔬 Kokoro Perf Snapshot</h6><?php
            echo "Add ?kokoro_perf_dump=1 → JSON în uploads/kokoro-perf/\n";
            if (!empty($report['saved_to'])) {
                echo "Salvat la: " . esc_html($report['saved_to']) . "\n";
            }
            echo "\n" . esc_html((string) $json);
?></pre>
        <?php
    }
}

Kokoro_Perf_Snapshot::register();
