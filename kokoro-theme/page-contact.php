<?php
/**
 * Template Name: Contact
 * Pagina de contact — Kokoro Brașov Academy
 *
 * @package Kokoro
 */


if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();

$adresa   = kokoro_setting('adresa',   'Str. Carpaților 60<br>500269 Brașov, România');
$telefon  = kokoro_setting('telefon',  '+40 742 037 973');
$email    = kokoro_setting('email',    'contact@kokoro.ro');
$facebook = kokoro_setting('facebook', '');
$instagram= kokoro_setting('instagram','');
$maps_url = kokoro_setting('maps_url', '');
$wa_numar = preg_replace('/\D/', '', kokoro_setting('whatsapp_numar', '40742037973'));

// ACF page-specific overrides
$acf = function_exists('get_field');
$contact_titlu      = $acf ? (string) get_field('contact_hero_titlu')   : '';
$landmark           = $acf ? (string) get_field('contact_landmark')     : '';
$drum               = $acf ? (string) get_field('contact_drum')         : '';
$program            = $acf ? (string) get_field('contact_program')      : '';
$form_titlu         = $acf ? (string) get_field('contact_form_titlu')   : '';
$form_subiecte      = $acf ? get_field('contact_form_subiecte')         : [];

if ($contact_titlu === '')   $contact_titlu = 'IA|LEGĂTURA|CU NOI';
if ($landmark === '')        $landmark      = 'Parcul Industrial METROM — deasupra service-ului auto, lângă Pensiunea „Floarea Soarelui"';
if ($drum === '')            $drum          = 'Intrarea se face pe poarta principală a uzinei METROM. După poartă, mergeți drept înainte 50 m, apoi la indicatorul rutier STOP, faceți dreapta 100 m.';
if ($program === '')         $program       = 'Luni – Vineri: 16:00 – 21:00<br>Sâmbătă: după programare';
if ($form_titlu === '')      $form_titlu    = 'TRIMITE-NE|UN MESAJ';
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Contact</div>
    <h1><?php echo kokoro_render_italic_title($contact_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
  </div>
  <div class="page-header__number" aria-hidden="true">連絡</div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="contact-grid">

      <!-- Contact Info -->
      <div class="reveal reveal--left">
        <h2 class="heading-4" style="margin-bottom: var(--space-2xl);">INFORMAȚII<br><em>DE CONTACT</em></h2>

        <?php if ($adresa !== '') : ?>
        <div class="contact-info__item">
          <div class="contact-info__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <div class="contact-info__label">Adresă</div>
            <p class="contact-info__text">
              <?php if ($maps_url !== '') : ?>
                <a href="<?php echo esc_url($maps_url); ?>" target="_blank" rel="noopener" class="link"><?php echo wp_kses($adresa, ['br' => []]); ?></a>
              <?php else : ?>
                <?php echo wp_kses($adresa, ['br' => []]); ?>
              <?php endif; ?>
              <br><span style="color: var(--color-gray); font-size: 0.875rem;"><?php echo esc_html($landmark); ?></span>
            </p>
          </div>
        </div>

        <div class="contact-info__item">
          <div class="contact-info__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
          </div>
          <div>
            <div class="contact-info__label">Cum ajungi</div>
            <p class="contact-info__text"><?php echo esc_html($drum); ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($telefon !== '') : ?>
        <div class="contact-info__item">
          <div class="contact-info__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          </div>
          <div>
            <div class="contact-info__label">Telefon</div>
            <p class="contact-info__text"><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefon)); ?>" class="link"><?php echo esc_html($telefon); ?></a></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($wa_numar !== '') : ?>
        <div class="contact-info__item">
          <div class="contact-info__icon" style="background: rgba(37, 211, 102, 0.15); color: #25D366;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 0 1 8.413 3.488 11.824 11.824 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
          </div>
          <div>
            <div class="contact-info__label">WhatsApp</div>
            <p class="contact-info__text"><a href="https://wa.me/<?php echo esc_attr($wa_numar); ?>" target="_blank" rel="noopener" class="link">Scrie-ne pe WhatsApp</a></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($email !== '') : ?>
        <div class="contact-info__item">
          <div class="contact-info__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div>
            <div class="contact-info__label">Email</div>
            <p class="contact-info__text"><a href="mailto:<?php echo esc_attr(antispambot($email)); ?>" class="link"><?php echo esc_html(antispambot($email)); ?></a></p>
          </div>
        </div>
        <?php endif; ?>

        <div class="contact-info__item">
          <div class="contact-info__icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <div class="contact-info__label">Program</div>
            <p class="contact-info__text"><?php echo wp_kses($program, ['br' => []]); ?></p>
          </div>
        </div>

        <?php if ($facebook !== '' || $instagram !== '') : ?>
        <!-- Social -->
        <div style="margin-top: var(--space-2xl);">
          <div class="contact-info__label" style="margin-bottom: var(--space-md);">Social Media</div>
          <div class="footer__social">
            <?php if ($facebook !== '') : ?>
              <a href="<?php echo esc_url($facebook); ?>" class="footer__social-link" aria-label="Facebook" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
            <?php endif; ?>
            <?php if ($instagram !== '') : ?>
              <a href="<?php echo esc_url($instagram); ?>" class="footer__social-link" aria-label="Instagram" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Contact Form -->
      <div class="reveal reveal--right">
        <h2 class="heading-4" style="margin-bottom: var(--space-2xl);">TRIMITE-NE<br><em>UN MESAJ</em></h2>

        <?php kokoro_form_status_banner(); ?>

        <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
          <input type="hidden" name="action"     value="kokoro_form_submit">
          <input type="hidden" name="form_type"  value="contact">
          <input type="hidden" name="form_time"  value="<?php echo esc_attr(time()); ?>">
          <?php wp_nonce_field('kokoro_form_submit', 'kokoro_form_nonce'); ?>

          <!-- Honeypot — câmp ascuns; bot-urile îl completează -->
          <div style="position: absolute; left: -9999px;" aria-hidden="true">
            <label for="kokoro-honey-contact">Website</label>
            <input type="text" id="kokoro-honey-contact" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
          </div>

          <div class="form-group">
            <label class="form-label" for="name">Nume complet *</label>
            <input type="text" id="name" name="name" class="form-input" placeholder="Numele tău" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="email">Email *</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="email@exemplu.ro" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="phone">Telefon</label>
            <input type="tel" id="phone" name="phone" class="form-input" placeholder="+40 7XX XXX XXX">
          </div>
          <div class="form-group">
            <label class="form-label" for="subject">Subiect</label>
            <select id="subject" name="subject" class="form-select">
              <option value="">Alege subiectul...</option>
              <option value="Înscriere cursuri">Înscriere cursuri</option>
              <option value="Informații generale">Informații generale</option>
              <option value="Tarife și abonamente">Tarife și abonamente</option>
              <option value="Competiții">Competiții</option>
              <option value="Altele">Altele</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="message">Mesaj *</label>
            <textarea id="message" name="message" class="form-textarea" placeholder="Scrie mesajul tău aici..." required></textarea>
          </div>
          <button type="submit" class="btn btn--primary btn--block">Trimite Mesajul</button>
        </form>
      </div>

    </div><!-- /.contact-grid -->
  </div>
</section>

<?php if ($maps_url !== '') : ?>
<!-- Map Section -->
<section class="section section--alt" style="padding: 0;">
  <div style="width: 100%; height: 400px; background: var(--color-bg-card); display: flex; align-items: center; justify-content: center;">
    <a href="<?php echo esc_url($maps_url); ?>" target="_blank" rel="noopener" class="btn btn--outline-accent">
      Deschide pe Google Maps →
    </a>
  </div>
</section>
<?php endif; ?>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
