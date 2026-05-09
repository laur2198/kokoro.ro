<?php
/**
 * Template Name: Înscriere
 * Formular înscriere — Kokoro Brașov Academy
 *
 * @package Kokoro
 */


if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Înscriere</div>
    <h1>ÎNCEPE<br><em>CĂLĂTORIA</em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      Completează formularul de mai jos pentru a te înscrie la Kokoro Brașov Academy. Prima lecție este gratuită!
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">力</div>
</section>

<section class="section section--dark">
  <div class="container container--narrow">

    <?php kokoro_form_status_banner(); ?>

    <form class="contact-form reveal" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
      <input type="hidden" name="action"     value="kokoro_form_submit">
      <input type="hidden" name="form_type"  value="inscriere">
      <input type="hidden" name="form_time"  value="<?php echo esc_attr(time()); ?>">
      <?php wp_nonce_field('kokoro_form_submit', 'kokoro_form_nonce'); ?>

      <!-- Honeypot — bot-urile completează acest câmp; oamenii nu îl văd. -->
      <div style="position: absolute; left: -9999px;" aria-hidden="true">
        <label for="kokoro-honey-inscriere">Website</label>
        <input type="text" id="kokoro-honey-inscriere" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
      </div>

      <!-- Datele copilului -->
      <h2 class="heading-4" style="margin-bottom: var(--space-xl);">DATELE <em>COPILULUI</em></h2>

      <div class="form-group">
        <label class="form-label" for="child-name">Nume complet copil *</label>
        <input type="text" id="child-name" name="child_name" class="form-input" placeholder="Ex: Andrei Popescu" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="age-group">Vârsta copilului *</label>
        <select id="age-group" name="age_group" class="form-select" required>
          <option value="">Alege grupa...</option>
          <option value="4-7 ani · Piticii">4-7 ani · Piticii</option>
          <option value="8-12 ani · Copii">8-12 ani · Copii</option>
          <option value="13-17 ani · Juniori">13-17 ani · Juniori</option>
          <option value="18+ · Adulți">18+ · Adulți</option>
        </select>
      </div>

      <!-- Torii Separator -->
      <div class="torii-separator" style="margin: var(--space-2xl) 0;">
        <div class="torii-separator__icon">
          <?php echo kokoro_svg('torii-gate'); ?>
        </div>
      </div>

      <!-- Date contact -->
      <h2 class="heading-4" style="margin-bottom: var(--space-xl);">DATE DE <em>CONTACT</em></h2>

      <div class="form-group">
        <label class="form-label" for="phone">Telefon părinte *</label>
        <input type="tel" id="phone" name="phone" class="form-input" placeholder="+40 7XX XXX XXX" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email <span style="color: var(--color-gray); font-weight: 400;">(opțional)</span></label>
        <input type="email" id="email" name="email" class="form-input" placeholder="email@exemplu.ro">
      </div>

      <div class="form-group">
        <label class="form-label" for="message">Mesaj <span style="color: var(--color-gray); font-weight: 400;">(opțional)</span></label>
        <textarea id="message" name="message" class="form-textarea" placeholder="Întrebări, experiență anterioară, alte informații utile..." rows="3"></textarea>
      </div>

      <!-- Submit (B3) + Privacy reassurance (B4) -->
      <div style="margin-top: var(--space-xl);">
        <button type="submit" class="btn btn--primary btn--large btn--block">
          📅 Programează Antrenamentul Gratuit
        </button>
        <p class="form-reassurance">
          🔒 Datele tale sunt în siguranță. Te contactăm doar pentru programarea antrenamentului. Nu trimitem spam.
        </p>
      </div>

    </form>

  </div>
</section>

<!-- Info Section -->
<section class="section section--alt">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-2xl); text-align: center;">

      <div class="reveal reveal-delay-1">
        <div class="value-item__kanji" style="font-size: 2.5rem;">📞</div>
        <h4 class="heading-5" style="margin: var(--space-md) 0;">Te Contactăm</h4>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Primești confirmare și detalii despre prima lecție în maxim 24h.</p>
      </div>

      <div class="reveal reveal-delay-2">
        <div class="value-item__kanji" style="font-size: 2.5rem;">🥋</div>
        <h4 class="heading-5" style="margin: var(--space-md) 0;">Lecție Gratuită</h4>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Vii la prima lecție fără nicio obligație. Echipamentul este asigurat.</p>
      </div>

      <div class="reveal reveal-delay-3">
        <div class="value-item__kanji" style="font-size: 2.5rem;">✅</div>
        <h4 class="heading-5" style="margin: var(--space-md) 0;">Începi Antrenamentul</h4>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Dacă îți place, alegi abonamentul și devii parte din familia Kokoro.</p>
      </div>

    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
