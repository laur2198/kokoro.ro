<?php
/**
 * Custom Post Types — admin notices
 *
 * Înregistrarea CPT-urilor (campion, disciplina, antrenor) a fost mutată într-un
 * mu-plugin (wp-content/mu-plugins/kokoro-content-types.php) ca să decupleze
 * conținutul de temă și să supraviețuiască schimbării temei.
 *
 * Aici păstrăm doar două notice-uri admin:
 *   - missing: mu-plugin-ul nu e instalat → CPT-uri inexistente, șabloanele nu vor răspunde
 *   - conflict: alte plugin-uri (CPTUI etc.) definesc CPT-uri cu rol duplicat
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * Notice: mu-plugin-ul de content types nu e instalat.
 * Fără el, CPT-urile așteptate de șabloane nu există → templates ca
 * single-antrenor.php nu se vor declanșa.
 */
function kokoro_cpt_missing_notice() {
    if (!current_user_can('manage_options')) return;

    $expected = ['campion', 'disciplina', 'antrenor'];
    $missing  = array_filter($expected, fn($pt) => !post_type_exists($pt));

    if (empty($missing)) return;
    ?>
    <div class="notice notice-error">
        <p>
            <strong><?php esc_html_e('Kokoro — mu-plugin lipsă', 'kokoro'); ?>:</strong>
            <?php esc_html_e('Tipurile de conținut Kokoro nu sunt înregistrate. Șabloanele single-antrenor / single-disciplina / single-campion nu vor funcționa.', 'kokoro'); ?>
        </p>
        <p>
            <?php
            printf(
                esc_html__('Lipsesc: %s.', 'kokoro'),
                '<code>' . esc_html(implode('</code>, <code>', $missing)) . '</code>'
            );
            ?>
        </p>
        <p>
            <?php esc_html_e('Soluție: copiază fișierul kokoro-content-types.php din folderul mu-plugins/ al repo-ului în wp-content/mu-plugins/ pe server.', 'kokoro'); ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'kokoro_cpt_missing_notice');

/**
 * Notice: alte plugin-uri (în special CPTUI) au definit CPT-uri cu rol duplicat.
 * Templatele temei folosesc slug-urile românești (antrenor/disciplina/campion).
 * Dacă există paralel slug-uri ca trainers/discipline/champions, conținutul se
 * fragmentează în două locuri.
 */
function kokoro_cpt_conflict_notice() {
    if (!current_user_can('manage_options')) return;

    $aliases = [
        'antrenor'   => ['trainers', 'trainer', 'antrenori'],
        'disciplina' => ['discipline', 'sports'],
        'campion'    => ['champions', 'campioni'],
    ];

    $conflicts = [];
    foreach ($aliases as $ours => $alts) {
        foreach ($alts as $alt) {
            if (post_type_exists($alt)) {
                $conflicts[] = sprintf('„%s" (probabil duplicat al „%s")', $alt, $ours);
            }
        }
    }

    if (empty($conflicts)) return;
    ?>
    <div class="notice notice-warning is-dismissible">
        <p>
            <strong><?php esc_html_e('Kokoro — conflict CPT detectat', 'kokoro'); ?>:</strong>
            <?php esc_html_e('Există tipuri de post cu rol duplicat care fragmentează conținutul:', 'kokoro'); ?>
        </p>
        <ul style="list-style: disc; margin-left: 20px;">
            <?php foreach ($conflicts as $c) : ?>
                <li><?php echo esc_html($c); ?></li>
            <?php endforeach; ?>
        </ul>
        <p>
            <?php esc_html_e('Recomandare: dezactivează aceste tipuri din Custom Post Type UI și migrează conținutul în CPT-urile native (campion, disciplina, antrenor).', 'kokoro'); ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'kokoro_cpt_conflict_notice');
