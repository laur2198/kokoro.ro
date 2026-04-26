<?php
/**
 * Template Name: Înscriere
 * Formular înscriere — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

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

    <?php
      // Trage disciplinele din CPT pentru select
      $disc_choices = get_posts([
          'post_type'      => 'disciplina',
          'posts_per_page' => -1,
          'post_status'    => 'publish',
          'orderby'        => 'menu_order title',
          'order'          => 'ASC',
      ]);

      kokoro_form_status_banner();
    ?>

    <form class="contact-form reveal" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
      <input type="hidden" name="action"     value="kokoro_form_submit">
      <input type="hidden" name="form_type"  value="inscriere">
      <input type="hidden" name="form_time"  value="<?php echo esc_attr(time()); ?>">
      <?php wp_nonce_field('kokoro_form_submit', 'kokoro_form_nonce'); ?>

      <!-- Honeypot -->
      <div style="position: absolute; left: -9999px;" aria-hidden="true">
        <label>Website</label>
        <input type="text" name="website" tabindex="-1" autocomplete="off">
      </div>

      <!-- Datele sportivului -->
      <h3 class="heading-4" style="margin-bottom: var(--space-xl);">DATELE <em>SPORTIVULUI</em></h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
        <div class="form-group">
          <label class="form-label" for="first-name">Prenume *</label>
          <input type="text" id="first-name" name="first_name" class="form-input" placeholder="Prenumele" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="last-name">Nume *</label>
          <input type="text" id="last-name" name="last_name" class="form-input" placeholder="Numele de familie" required>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
        <div class="form-group">
          <label class="form-label" for="birth-date">Data nașterii *</label>
          <input type="date" id="birth-date" name="birth_date" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="group">Grupa dorită *</label>
          <select id="group" name="group" class="form-select" required>
            <option value="">Alege grupa...</option>
            <option value="Copii (4-7 ani)">Copii (4-7 ani)</option>
            <option value="Copii (8-12 ani)">Copii (8-12 ani)</option>
            <option value="Juniori (13-17 ani)">Juniori (13-17 ani)</option>
            <option value="Adulți (18+ ani)">Adulți (18+ ani)</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="discipline">Disciplina *</label>
        <select id="discipline" name="discipline" class="form-select" required>
          <option value="">Alege disciplina...</option>
          <?php if (!empty($disc_choices)) : ?>
            <?php foreach ($disc_choices as $d) : ?>
              <option value="<?php echo esc_attr(get_the_title($d->ID)); ?>"><?php echo esc_html(get_the_title($d->ID)); ?></option>
            <?php endforeach; ?>
          <?php else : ?>
            <option value="Ju-Jitsu Competițional">Ju-Jitsu Competițional</option>
            <option value="Ju-Jitsu Autoapărare">Ju-Jitsu Autoapărare</option>
            <option value="TRX Suspension Training">TRX Suspension Training</option>
            <option value="Personal Training">Personal Training</option>
          <?php endif; ?>
        </select>
      </div>

      <!-- Torii Separator -->
      <div class="torii-separator" style="margin: var(--space-2xl) 0;">
        <div class="torii-separator__icon">
          <?php echo kokoro_svg('torii-gate'); ?>
        </div>
      </div>

      <!-- Date contact -->
      <h3 class="heading-4" style="margin-bottom: var(--space-xl);">DATE DE <em>CONTACT</em></h3>
      <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: var(--space-xl);">
        Pentru minori, completați datele părintelui/tutorelui legal.
      </p>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
        <div class="form-group">
          <label class="form-label" for="parent-name">Nume părinte/tutore</label>
          <input type="text" id="parent-name" name="parent_name" class="form-input" placeholder="Nume complet">
        </div>
        <div class="form-group">
          <label class="form-label" for="phone">Telefon *</label>
          <input type="tel" id="phone" name="phone" class="form-input" placeholder="+40 7XX XXX XXX" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="email">Email *</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="email@exemplu.ro" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="message">Mesaj suplimentar</label>
        <textarea id="message" name="message" class="form-textarea" placeholder="Experiență anterioară, întrebări, sau alte informații relevante..." rows="4"></textarea>
      </div>

      <!-- Submit -->
      <div style="margin-top: var(--space-xl);">
        <button type="submit" class="btn btn--primary btn--large btn--block">
          Trimite Înscrierea
        </button>
        <p style="color: var(--color-gray); font-size: 0.8125rem; text-align: center; margin-top: var(--space-md);">
          Te vom contacta în maxim 24 de ore pentru a confirma înscrierea și a stabili prima lecție gratuită.
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
