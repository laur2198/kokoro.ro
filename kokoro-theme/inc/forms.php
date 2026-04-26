<?php
/**
 * Native form handler — Kokoro Brașov Academy
 *
 * - Trimite emailuri prin wp_mail() la adresa configurată în „Setări Kokoro"
 * - Salvează fiecare submisie ca post CPT `kokoro_msg` (vizibil doar în admin)
 * - Honeypot anti-spam + nonce + timestamp check
 * - Redirect PRG (Post-Redirect-Get) cu ?sent=1 sau ?err=... ca să nu se
 *   re-trimită la refresh
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

/**
 * 1. Înregistrează CPT-ul `kokoro_msg` — pentru istoricul mesajelor.
 *    Public=false, vizibil doar în admin.
 */
function kokoro_register_msg_cpt() {
    register_post_type('kokoro_msg', [
        'labels' => [
            'name'          => __('Mesaje', 'kokoro'),
            'singular_name' => __('Mesaj', 'kokoro'),
            'menu_name'     => __('Mesaje primite', 'kokoro'),
            'all_items'     => __('Toate mesajele', 'kokoro'),
            'view_item'     => __('Vezi mesajul', 'kokoro'),
            'edit_item'     => __('Vezi detalii', 'kokoro'),
            'search_items'  => __('Caută mesaj', 'kokoro'),
            'not_found'     => __('Niciun mesaj.', 'kokoro'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'menu_icon'           => 'dashicons-email-alt',
        'menu_position'       => 25,
        'capability_type'     => 'post',
        'capabilities'        => [
            'create_posts' => 'do_not_allow', // doar handler-ul poate crea
        ],
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'rewrite'             => false,
        'supports'            => ['title', 'editor', 'custom-fields'],
        'exclude_from_search' => true,
    ]);
}
add_action('init', 'kokoro_register_msg_cpt');

/**
 * 2. Adaugă coloane utile în lista de Mesaje (admin).
 */
add_filter('manage_kokoro_msg_posts_columns', function ($cols) {
    $new = [
        'cb'        => $cols['cb'] ?? '',
        'title'     => __('Titlu', 'kokoro'),
        'msg_type'  => __('Tip', 'kokoro'),
        'msg_email' => __('Email', 'kokoro'),
        'msg_phone' => __('Telefon', 'kokoro'),
        'date'      => __('Primit la', 'kokoro'),
    ];
    return $new;
});
add_action('manage_kokoro_msg_posts_custom_column', function ($col, $post_id) {
    if ($col === 'msg_type') {
        $type = get_post_meta($post_id, '_kokoro_form_type', true);
        echo esc_html($type ?: '—');
    }
    if ($col === 'msg_email') {
        $e = get_post_meta($post_id, '_kokoro_email', true);
        if ($e) echo '<a href="mailto:' . esc_attr(antispambot($e)) . '">' . esc_html($e) . '</a>';
        else echo '—';
    }
    if ($col === 'msg_phone') {
        echo esc_html(get_post_meta($post_id, '_kokoro_phone', true) ?: '—');
    }
}, 10, 2);

/**
 * 3. Handler pentru submisii de formular (acționat prin admin-post.php).
 *    Folosit de ambele formulare (contact + înscriere) cu un câmp form_type.
 */
function kokoro_handle_form_submit() {
    // Verify nonce
    if (!isset($_POST['kokoro_form_nonce']) || !wp_verify_nonce($_POST['kokoro_form_nonce'], 'kokoro_form_submit')) {
        kokoro_form_redirect_back('nonce');
    }

    // Honeypot — câmpul „website" trebuie să fie gol
    if (!empty($_POST['website'])) {
        kokoro_form_redirect_back('spam');
    }

    // Timestamp check — formularele trimise în < 2 secunde sunt bot-uri
    $form_time = isset($_POST['form_time']) ? (int) $_POST['form_time'] : 0;
    if ($form_time > 0 && (time() - $form_time) < 2) {
        kokoro_form_redirect_back('spam');
    }

    // Whitelist form_type — orice altă valoare cade pe „contact"
    $allowed_types = ['contact', 'inscriere'];
    $form_type     = in_array($_POST['form_type'] ?? '', $allowed_types, true)
        ? sanitize_key($_POST['form_type'])
        : 'contact';
    $referer       = wp_get_referer() ?: home_url('/');

    if ($form_type === 'inscriere') {
        $data = [
            'first_name'  => sanitize_text_field($_POST['first_name']  ?? ''),
            'last_name'   => sanitize_text_field($_POST['last_name']   ?? ''),
            'birth_date'  => sanitize_text_field($_POST['birth_date']  ?? ''),
            'group'       => sanitize_text_field($_POST['group']       ?? ''),
            'discipline'  => sanitize_text_field($_POST['discipline']  ?? ''),
            'parent_name' => sanitize_text_field($_POST['parent_name'] ?? ''),
            'phone'       => sanitize_text_field($_POST['phone']       ?? ''),
            'email'       => sanitize_email($_POST['email']            ?? ''),
            'message'     => sanitize_textarea_field($_POST['message'] ?? ''),
        ];

        // Validări minime
        if ($data['first_name'] === '' || $data['last_name'] === '' || $data['phone'] === '' || !is_email($data['email'])) {
            kokoro_form_redirect_back('invalid', $referer);
        }

        $title = sprintf('[Înscriere] %s %s', $data['first_name'], $data['last_name']);
        $body_lines = [
            'Sportiv: '          . $data['first_name'] . ' ' . $data['last_name'],
            'Data nașterii: '    . $data['birth_date'],
            'Grupă dorită: '     . $data['group'],
            'Disciplină: '       . $data['discipline'],
            'Părinte/tutore: '   . ($data['parent_name'] ?: '—'),
            'Telefon: '          . $data['phone'],
            'Email: '            . $data['email'],
            '',
            'Mesaj suplimentar:',
            $data['message'] ?: '(niciun mesaj)',
        ];
    } else {
        // Contact (default)
        $data = [
            'name'    => sanitize_text_field($_POST['name']    ?? ''),
            'email'   => sanitize_email($_POST['email']        ?? ''),
            'phone'   => sanitize_text_field($_POST['phone']   ?? ''),
            'subject' => sanitize_text_field($_POST['subject'] ?? ''),
            'message' => sanitize_textarea_field($_POST['message'] ?? ''),
        ];

        if ($data['name'] === '' || !is_email($data['email']) || $data['message'] === '') {
            kokoro_form_redirect_back('invalid', $referer);
        }

        $title = sprintf('[Contact] %s', $data['name']);
        if (!empty($data['subject'])) {
            $title .= ' — ' . $data['subject'];
        }
        $body_lines = [
            'De la: '    . $data['name'],
            'Email: '    . $data['email'],
            'Telefon: '  . ($data['phone'] ?: '—'),
            'Subiect: '  . ($data['subject'] ?: '—'),
            '',
            'Mesaj:',
            $data['message'],
        ];
    }

    $body = implode("\n", $body_lines);

    // Salvează ca post CPT
    $post_id = wp_insert_post([
        'post_type'    => 'kokoro_msg',
        'post_status'  => 'private',
        'post_title'   => $title,
        'post_content' => $body,
    ], true);

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, '_kokoro_form_type', $form_type === 'inscriere' ? 'Înscriere' : 'Contact');
        update_post_meta($post_id, '_kokoro_email', $data['email']);
        update_post_meta($post_id, '_kokoro_phone', $data['phone'] ?? '');
        // Salvează toate câmpurile raw ca meta (pentru detalii)
        foreach ($data as $k => $v) {
            update_post_meta($post_id, '_kokoro_' . $k, $v);
        }
    }

    // Trimite email
    $recipient = function_exists('kokoro_setting') ? kokoro_setting('email', get_option('admin_email')) : get_option('admin_email');
    if (!is_email($recipient)) {
        $recipient = get_option('admin_email');
    }

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $data['email'],
    ];

    $sent = wp_mail($recipient, $title, $body, $headers);

    kokoro_form_redirect_back($sent ? 'ok' : 'mail_fail', $referer);
}
add_action('admin_post_nopriv_kokoro_form_submit', 'kokoro_handle_form_submit');
add_action('admin_post_kokoro_form_submit',        'kokoro_handle_form_submit');

/**
 * Redirect helper: trimite înapoi la pagina de unde vine, cu un parametru status.
 */
function kokoro_form_redirect_back($status, $referer = null) {
    if ($referer === null) {
        $referer = wp_get_referer() ?: home_url('/');
    }
    $url = add_query_arg('kokoro_form', $status, remove_query_arg('kokoro_form', $referer));
    wp_safe_redirect($url . '#kokoro-form');
    exit;
}

/**
 * Helper: afișează banner de succes/eroare deasupra formularului
 * (folosit în page-contact.php și page-inscriere.php).
 */
function kokoro_form_status_banner() {
    $status = isset($_GET['kokoro_form']) ? sanitize_key($_GET['kokoro_form']) : '';
    if ($status === '') return;

    $messages = [
        'ok'        => ['Mesajul a fost trimis cu succes! Te contactăm în cel mai scurt timp.', 'success'],
        'mail_fail' => ['Mesajul a fost salvat, dar nu am putut trimite emailul. Te vom contacta noi.', 'warning'],
        'invalid'   => ['Te rog completează corect câmpurile obligatorii (marcate cu *).', 'error'],
        'nonce'     => ['Sesiunea a expirat. Reîncarcă pagina și încearcă din nou.', 'error'],
        'spam'      => ['Mesajul nu a putut fi trimis. Dacă nu ești bot, contactează-ne direct.', 'error'],
    ];

    if (!isset($messages[$status])) return;
    [$msg, $type] = $messages[$status];

    $colors = [
        'success' => ['bg' => '#0F5132', 'color' => '#D1E7DD'],
        'warning' => ['bg' => '#664D03', 'color' => '#FFF3CD'],
        'error'   => ['bg' => '#842029', 'color' => '#F8D7DA'],
    ];
    $c = $colors[$type] ?? $colors['error'];

    printf(
        '<div id="kokoro-form" class="kokoro-form-banner" style="padding: var(--space-md) var(--space-lg); background: %s; color: %s; margin-bottom: var(--space-xl); border-radius: 4px; font-weight: 600;">%s</div>',
        esc_attr($c['bg']),
        esc_attr($c['color']),
        esc_html($msg)
    );
}
