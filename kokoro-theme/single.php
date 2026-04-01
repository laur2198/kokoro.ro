<?php
/**
 * Single Post — Articol individual
 *
 * @package Kokoro
 */

get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<section class="page-header">
  <div class="container">
    <?php
      $cats = get_the_category();
      if ($cats) :
    ?>
      <div class="section-number"><?php echo esc_html($cats[0]->name); ?></div>
    <?php endif; ?>
    <h1 style="font-size: clamp(2rem, 5vw, 4rem);"><?php the_title(); ?></h1>
    <div style="display: flex; gap: var(--space-lg); margin-top: var(--space-lg); color: var(--color-gray); font-size: 0.875rem;">
      <span><?php echo get_the_date('d MMMM Y'); ?></span>
      <span>•</span>
      <span><?php echo get_the_author(); ?></span>
    </div>
  </div>
</section>

<!-- Featured Image -->
<?php if (has_post_thumbnail()) : ?>
  <section style="padding: 0;">
    <div class="container" style="margin-top: calc(-1 * var(--space-2xl));">
      <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'kokoro-hero')); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: auto; max-height: 500px; object-fit: cover;">
    </div>
  </section>
<?php endif; ?>

<!-- Content -->
<section class="section section--dark">
  <div class="container container--narrow">
    <article class="page-content" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
      <?php the_content(); ?>
    </article>

    <!-- Tags -->
    <?php
      $tags = get_the_tags();
      if ($tags) :
    ?>
      <div style="margin-top: var(--space-2xl); padding-top: var(--space-xl); border-top: 1px solid var(--color-gray-dark);">
        <span class="section-label" style="margin-right: var(--space-md);">Taguri:</span>
        <?php foreach ($tags as $tag) : ?>
          <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="card__tag" style="margin-right: var(--space-xs); margin-bottom: var(--space-xs);">
            <?php echo esc_html($tag->name); ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Navigation -->
    <div style="display: flex; justify-content: space-between; margin-top: var(--space-3xl); padding-top: var(--space-xl); border-top: 1px solid var(--color-gray-dark);">
      <div>
        <?php
          $prev = get_previous_post();
          if ($prev) :
        ?>
          <span class="section-label">Anterior</span>
          <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="link" style="display: block; margin-top: var(--space-xs);">
            <?php echo esc_html($prev->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
      <div style="text-align: right;">
        <?php
          $next = get_next_post();
          if ($next) :
        ?>
          <span class="section-label">Următor</span>
          <a href="<?php echo esc_url(get_permalink($next)); ?>" class="link" style="display: block; margin-top: var(--space-xs);">
            <?php echo esc_html($next->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
