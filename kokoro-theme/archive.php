<?php
/**
 * Archive — News/stories listing
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Știri Sportive</div>
    <h1>
      <?php if (is_category()) : ?>
        <?php single_cat_title(); ?>
      <?php elseif (is_tag()) : ?>
        <?php single_tag_title(); ?>
      <?php elseif (is_date()) : ?>
        ARHIVĂ
      <?php else : ?>
        NOUTĂȚI <em>KOKORO</em>
      <?php endif; ?>
    </h1>
    <?php if (category_description()) : ?>
      <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
        <?php echo category_description(); ?>
      </p>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">新聞</div>
</section>

<section class="section section--dark">
  <div class="container">
    <?php if (have_posts()) : ?>

      <div class="post-grid">
        <?php while (have_posts()) : the_post(); ?>

          <article class="post-card reveal">
            <?php if (has_post_thumbnail()) : ?>
              <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'kokoro-card')); ?>" alt="<?php the_title_attribute(); ?>" class="post-card__image">
            <?php else : ?>
              <div class="post-card__image" style="background: var(--color-bg-card); display: flex; align-items: center; justify-content: center;">
                <span style="color: var(--color-gray); font-size: 0.875rem;">Kokoro</span>
              </div>
            <?php endif; ?>

            <div class="post-card__body">
              <?php
                $cats = get_the_category();
                if ($cats) :
              ?>
                <div class="post-card__date">
                  <?php echo esc_html($cats[0]->name); ?> — <?php echo get_the_date('d M Y'); ?>
                </div>
              <?php else : ?>
                <div class="post-card__date"><?php echo get_the_date('d M Y'); ?></div>
              <?php endif; ?>

              <h2 class="post-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <p class="post-card__excerpt"><?php echo get_the_excerpt(); ?></p>
            </div>
          </article>

        <?php endwhile; ?>
      </div>

      <div style="text-align: center; margin-top: var(--space-3xl);">
        <?php
          the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&larr; Anterioare',
            'next_text' => 'Următoare &rarr;',
          ]);
        ?>
      </div>

    <?php else : ?>

      <div style="text-align: center; padding: var(--space-4xl) 0;">
        <h2>Niciun articol găsit</h2>
        <p style="color: var(--color-gray);">Nu există articole în această categorie.</p>
      </div>

    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
