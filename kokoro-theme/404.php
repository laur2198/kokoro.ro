<?php
/**
 * 404 — Page Not Found
 *
 * @package Kokoro
 */

get_header();
?>

<section class="section section--dark" style="min-height: 80vh; display: flex; align-items: center;">
  <!-- Kanji Watermark -->
  <div class="kanji-watermark" style="font-size: clamp(15rem, 40vw, 30rem); left: 50%; top: 50%; transform: translate(-50%, -50%); opacity: 0.03;" aria-hidden="true">迷</div>

  <div class="container" style="text-align: center; position: relative; z-index: 1;">
    <div class="section-number" style="margin-bottom: var(--space-lg);">Eroare 404</div>

    <h1 style="margin-bottom: var(--space-lg);">PAGINA<br><em>NU EXISTĂ</em></h1>

    <div class="jp-quote" style="padding: var(--space-xl) 0;">
      <div class="jp-quote__kanji">「迷」</div>
      <div class="jp-quote__romaji">Mayoi</div>
      <div class="jp-quote__translation">Rătăcire — dar fiecare drum duce undeva</div>
    </div>

    <p style="color: var(--color-gray); max-width: 500px; margin: 0 auto var(--space-2xl);">
      Pagina pe care o cauți nu mai există sau a fost mutată. Întoarce-te pe tatami!
    </p>

    <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
        Acasă
      </a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">
        Contactează-ne
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
