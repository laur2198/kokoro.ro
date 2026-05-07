<?php
/**
 * Comments template — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area" style="margin-top: var(--space-3xl); padding-top: var(--space-2xl); border-top: 1px solid var(--color-gray-dark);">

    <?php if (have_comments()) : ?>

        <h2 class="comments-title" style="font-family: var(--font-heading); font-weight: 800; margin-bottom: var(--space-xl);">
            <?php
            $count = get_comments_number();
            printf(
                esc_html(_n('%s comentariu', '%s comentarii', $count, 'kokoro')),
                '<strong style="color: var(--color-accent);">' . esc_html(number_format_i18n($count)) . '</strong>'
            );
            ?>
        </h2>

        <ol class="comment-list" style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: var(--space-xl);">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 48,
            ]);
            ?>
        </ol>

        <?php
        the_comments_navigation([
            'prev_text' => esc_html__('← Comentarii anterioare', 'kokoro'),
            'next_text' => esc_html__('Comentarii următoare →', 'kokoro'),
        ]);
        ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments" style="color: var(--color-gray); margin-top: var(--space-lg);">
                <?php esc_html_e('Comentariile sunt închise pentru acest articol.', 'kokoro'); ?>
            </p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form([
        'title_reply'        => esc_html__('Lasă un comentariu', 'kokoro'),
        'title_reply_to'     => esc_html__('Răspunde lui %s', 'kokoro'),
        'cancel_reply_link'  => esc_html__('Anulează răspunsul', 'kokoro'),
        'label_submit'       => esc_html__('Trimite comentariul', 'kokoro'),
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
        'class_submit'       => 'btn btn--primary',
    ]);
    ?>

</section>
