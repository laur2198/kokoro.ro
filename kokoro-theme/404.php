<?php
/**
 * 404 — Page Not Found
 *
 * @package Kokoro
 */

get_header();

// Suggested pages — pull paginile importante (filtrate pentru cele care chiar există)
$suggested_slugs = ['orar', 'tarife', 'discipline', 'contact', 'inscriere'];
$suggested_pages = [];
foreach ($suggested_slugs as $slug) {
    $p = get_page_by_path($slug);
    if ($p && $p->post_status === 'publish') {
        $suggested_pages[] = $p;
    }
}
$suggested_pages = array_slice($suggested_pages, 0, 4);
?>

<section class="section section--dark" style="min-height: 80vh; display: flex; align-items: center;">
  <!-- Kanji Watermark -->
  <div class="kanji-watermark" style="font-size: clamp(15rem, 40vw, 30rem); left: 50%; top: 50%; transform: translate(-50%, -50%); opacity: 0.03;" aria-hidden="true">迷</div>

  <div class="container" style="text-align: center; position: relative; z-index: 1; max-width: 700px;">
    <div class="section-number" style="margin-bottom: var(--space-lg);">Eroare 404</div>

    <h1 style="margin-bottom: var(--space-lg);">PAGINA<br><em>NU EXISTĂ</em></h1>

    <div class="jp-quote" style="padding: var(--space-xl) 0;">
      <div class="jp-quote__kanji">「迷」</div>
      <div class="jp-quote__romaji">Mayoi</div>
      <div class="jp-quote__translation">Rătăcire — dar fiecare drum duce undeva</div>
    </div>

    <p style="color: var(--color-gray); margin: 0 auto var(--space-2xl); max-width: 500px;">
      Pagina pe care o cauți nu mai există sau a fost mutată. Întoarce-te pe tatami!
    </p>

    <!-- Search form -->
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: var(--space-sm); max-width: 500px; margin: 0 auto var(--space-2xl);">
      <label for="404-search" class="screen-reader-text" style="position: absolute; left: -9999px;">Caută pe site</label>
      <input
        id="404-search"
        type="search"
        name="s"
        placeholder="Caută pe site..."
        class="form-input"
        style="flex: 1;"
        value="<?php echo esc_attr(get_search_query()); ?>"
      >
      <button type="submit" class="btn btn--primary">Caută</button>
    </form>

    <!-- Suggested pages -->
    <?php if (!empty($suggested_pages)) : ?>
      <div style="margin-bottom: var(--space-2xl);">
        <p style="color: var(--color-gray); font-size: 0.875rem; margin-bottom: var(--space-md); text-transform: uppercase; letter-spacing: 0.1em;">
          Sau explorează:
        </p>
        <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
          <?php foreach ($suggested_pages as $p) : ?>
            <a href="<?php echo esc_url(get_permalink($p)); ?>" class="link" style="color: var(--color-accent); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
              <?php echo esc_html(get_the_title($p)); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
        Înapoi acasă
      </a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">
        Contactează-ne
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
