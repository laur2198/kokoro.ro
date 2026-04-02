<?php
/**
 * Template Name: Galerie
 * Galerie foto/video — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Galerie</div>
    <h1>MOMENTE<br><em>KOKORO</em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      Antrenamente, competiții, tabere și momente de bucurie — viața la Kokoro Brașov Academy în imagini.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">写真</div>
</section>

<section class="section section--dark">
  <div class="container">

    <?php
    // If the page has content (WordPress gallery blocks), display it
    if (have_posts()) :
      while (have_posts()) : the_post();
        if (get_the_content()) :
          ?>
          <div class="page-content reveal">
            <?php the_content(); ?>
          </div>
        <?php
        endif;
      endwhile;
    endif;
    ?>

    <!-- Placeholder Gallery Grid (until real photos are uploaded) -->
    <div class="gallery-grid reveal">
      <?php for ($i = 1; $i <= 12; $i++) : ?>
        <div class="gallery-item">
          <div style="width: 100%; height: 100%; background: var(--color-bg-card); display: flex; align-items: center; justify-content: center; flex-direction: column; gap: var(--space-sm);">
            <span style="color: var(--color-gray); font-size: 2rem;">🥋</span>
            <span style="color: var(--color-gray); font-size: 0.75rem;">Foto <?php echo $i; ?></span>
          </div>
        </div>
      <?php endfor; ?>
    </div>

    <div class="reveal" style="text-align: center; margin-top: var(--space-3xl);">
      <p style="color: var(--color-gray); margin-bottom: var(--space-lg);">
        Mai multe fotografii și videoclipuri pe pagina noastră de Facebook.
      </p>
      <a href="https://www.facebook.com/kokorobrasovacademy" class="btn btn--outline-accent" target="_blank" rel="noopener">
        Vezi pe Facebook
      </a>
    </div>

  </div>
</section>

<!-- CTA -->
<section class="section section--blue">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2>VREI SĂ FACI<br><em>PARTE DIN ECHIPĂ?</em></h2>
      <p style="color: rgba(255,255,255,0.95); max-width: 500px; margin: var(--space-lg) auto var(--space-2xl);">
        Înscrie-te la Kokoro Brașov Academy și trăiește experiența Ju-Jitsu!
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--secondary btn--large">Înscrie-te Acum</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
