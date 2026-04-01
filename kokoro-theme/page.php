<?php
/**
 * Page — Generic page template
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <h1><?php the_title(); ?></h1>
  </div>
</section>

<section class="section section--dark">
  <div class="container container--narrow">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <div class="page-content" style="color: var(--color-gray); line-height: 1.8; font-size: 1.0625rem;">
        <?php the_content(); ?>
      </div>

    <?php endwhile; endif; ?>
  </div>
</section>

<?php get_footer(); ?>
