<?php
/**
 * Search results template — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

global $wp_query;
$query   = get_search_query();
$total   = (int) $wp_query->found_posts;
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Căutare</div>
    <h1>REZULTATE PENTRU<br><em><?php echo esc_html($query); ?></em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg);">
      <?php
        printf(
          esc_html(_n('%s rezultat găsit.', '%s rezultate găsite.', $total, 'kokoro')),
          '<strong style="color: var(--color-accent);">' . esc_html($total) . '</strong>'
        );
      ?>
    </p>

    <!-- Search form again -->
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: var(--space-sm); max-width: 500px; margin-top: var(--space-xl);">
      <label for="search-input" class="screen-reader-text" style="position: absolute; left: -9999px;">Caută din nou</label>
      <input id="search-input" type="search" name="s" placeholder="Caută din nou..." class="form-input" style="flex: 1;" value="<?php echo esc_attr($query); ?>">
      <button type="submit" class="btn btn--primary">Caută</button>
    </form>
  </div>
  <div class="page-header__number" aria-hidden="true">検索</div>
</section>

<section class="section section--dark">
  <div class="container container--narrow">

    <?php if (have_posts()) : ?>
      <div style="display: flex; flex-direction: column; gap: var(--space-2xl);">
        <?php while (have_posts()) : the_post();
          $post_type_obj   = get_post_type_object(get_post_type());
          $post_type_label = $post_type_obj ? $post_type_obj->labels->singular_name : 'Pagină';
        ?>
          <article class="reveal" style="padding-bottom: var(--space-2xl); border-bottom: 1px solid var(--color-gray-dark);">
            <div class="section-number" style="margin-bottom: var(--space-sm);">
              <?php echo esc_html($post_type_label); ?>
            </div>
            <h2 style="margin-bottom: var(--space-md);">
              <a href="<?php the_permalink(); ?>" class="link" style="color: var(--color-white);">
                <?php the_title(); ?>
              </a>
            </h2>
            <?php if (has_excerpt() || get_the_content()) : ?>
              <p style="color: var(--color-gray); line-height: 1.8;">
                <?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 30, '…')); ?>
              </p>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>" class="link" style="color: var(--color-accent); font-weight: 700; margin-top: var(--space-md); display: inline-block;">
              Citește mai mult →
            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <!-- Pagination -->
      <?php
        $pagination = paginate_links([
            'prev_text' => '← Anterior',
            'next_text' => 'Următor →',
            'type'      => 'array',
        ]);
        if (!empty($pagination)) :
      ?>
        <nav style="display: flex; gap: var(--space-sm); justify-content: center; margin-top: var(--space-3xl); flex-wrap: wrap;">
          <?php foreach ($pagination as $link) : ?>
            <span><?php echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- WP-built ?></span>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>

    <?php else : ?>
      <div style="text-align: center; padding: var(--space-3xl) 0;">
        <div class="jp-quote" style="margin-bottom: var(--space-2xl);">
          <div class="jp-quote__kanji">「無」</div>
          <div class="jp-quote__romaji">Mu</div>
          <div class="jp-quote__translation">Vid — niciun rezultat</div>
        </div>
        <p style="color: var(--color-gray); max-width: 500px; margin: 0 auto;">
          Nu am găsit nimic pentru <strong style="color: var(--color-accent);">„<?php echo esc_html($query); ?>"</strong>.
          Încearcă alți termeni sau explorează paginile principale.
        </p>
        <div style="margin-top: var(--space-2xl); display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">Acasă</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">Contact</a>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
