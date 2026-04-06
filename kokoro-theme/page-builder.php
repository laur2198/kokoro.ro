<?php
/**
 * Template Name: Page Builder
 * Permite clientului să construiască pagini din blocuri pre-definite
 *
 * @package Kokoro
 */

get_header();
?>

<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1><?php the_title(); ?></h1>
  </div>
</section>

<?php if (have_rows('page_sections')) : ?>
  <?php while (have_rows('page_sections')) : the_row(); ?>

    <?php
      // Determine background class
      $bg = get_sub_field('background') ?: 'dark';
      $bg_class = 'section--' . $bg;
      $is_light = in_array($bg, ['dark', 'alt']);
    ?>

    <?php /* ===== HERO SECTION ===== */ ?>
    <?php if (get_row_layout() === 'hero_section') : ?>
      <section class="hero section--blue">
        <?php if (get_sub_field('image')) : ?>
          <div class="hero__bg" style="background-image: url('<?php echo esc_url(get_sub_field('image')); ?>');"></div>
        <?php endif; ?>
        <div class="hero__content">
          <h1 class="hero__headline reveal"><?php echo esc_html(get_sub_field('title')); ?></h1>
          <p class="hero__subtitle reveal"><?php echo esc_html(get_sub_field('subtitle')); ?></p>
          <?php if (get_sub_field('btn_text')) : ?>
            <div class="hero__cta reveal">
              <a href="<?php echo esc_url(get_sub_field('btn_link')); ?>" class="btn btn--secondary btn--large"><?php echo esc_html(get_sub_field('btn_text')); ?></a>
            </div>
          <?php endif; ?>
        </div>
      </section>

    <?php /* ===== TEXT + IMAGE ===== */ ?>
    <?php elseif (get_row_layout() === 'text_image') : ?>
      <section class="section <?php echo esc_attr($bg_class); ?>">
        <div class="container">
          <div class="grid-2-col <?php echo get_sub_field('reverse') ? 'grid-2-col--reverse' : ''; ?>">
            <?php if (get_sub_field('reverse')) : ?>
              <!-- Image first -->
              <div class="reveal reveal--left">
                <?php if (get_sub_field('image')) : ?>
                  <img src="<?php echo esc_url(get_sub_field('image')); ?>" alt="" style="width: 100%; height: auto; border-radius: var(--radius-md);">
                <?php endif; ?>
              </div>
              <div class="reveal reveal--right">
                <?php if (get_sub_field('label')) : ?>
                  <div class="section-number"><?php echo esc_html(get_sub_field('label')); ?></div>
                <?php endif; ?>
                <h2 style="margin-top: var(--space-md);"><?php echo wp_kses_post(get_sub_field('title')); ?></h2>
                <div style="margin-top: var(--space-xl); line-height: 1.8; color: var(--color-gray);">
                  <?php echo wp_kses_post(get_sub_field('text')); ?>
                </div>
              </div>
            <?php else : ?>
              <!-- Text first -->
              <div class="reveal reveal--left">
                <?php if (get_sub_field('label')) : ?>
                  <div class="section-number"><?php echo esc_html(get_sub_field('label')); ?></div>
                <?php endif; ?>
                <h2 style="margin-top: var(--space-md);"><?php echo wp_kses_post(get_sub_field('title')); ?></h2>
                <div style="margin-top: var(--space-xl); line-height: 1.8; color: var(--color-gray);">
                  <?php echo wp_kses_post(get_sub_field('text')); ?>
                </div>
              </div>
              <div class="reveal reveal--right">
                <?php if (get_sub_field('image')) : ?>
                  <img src="<?php echo esc_url(get_sub_field('image')); ?>" alt="" style="width: 100%; height: auto; border-radius: var(--radius-md);">
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

    <?php /* ===== CARDS GRID ===== */ ?>
    <?php elseif (get_row_layout() === 'cards_grid') : ?>
      <section class="section <?php echo esc_attr($bg_class); ?>">
        <div class="container">
          <?php if (get_sub_field('title')) : ?>
            <div class="section__header reveal" style="text-align: center;">
              <?php if (get_sub_field('label')) : ?>
                <div class="section-number"><?php echo esc_html(get_sub_field('label')); ?></div>
              <?php endif; ?>
              <h2><?php echo wp_kses_post(get_sub_field('title')); ?></h2>
            </div>
          <?php endif; ?>

          <?php if (have_rows('cards')) : ?>
            <div class="discipline-grid" style="gap: var(--space-lg);">
              <?php $i = 1; while (have_rows('cards')) : the_row(); ?>
                <div class="card card-tilt reveal reveal-delay-<?php echo $i; ?>">
                  <div class="card__number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
                  <?php if (get_sub_field('image')) : ?>
                    <img src="<?php echo esc_url(get_sub_field('image')); ?>" alt="" class="card__image">
                  <?php endif; ?>
                  <h4 class="card__title"><?php echo esc_html(get_sub_field('title')); ?></h4>
                  <p class="card__text"><?php echo esc_html(get_sub_field('text')); ?></p>
                </div>
              <?php $i++; endwhile; ?>
            </div>
          <?php endif; ?>
        </div>
      </section>

    <?php /* ===== CTA ===== */ ?>
    <?php elseif (get_row_layout() === 'cta_section') : ?>
      <section class="section <?php echo esc_attr($bg_class); ?>">
        <div class="container" style="text-align: center;">
          <div class="reveal">
            <h2><?php echo wp_kses_post(get_sub_field('title')); ?></h2>
            <?php if (get_sub_field('text')) : ?>
              <p style="max-width: 500px; margin: var(--space-lg) auto var(--space-2xl); <?php echo $bg === 'blue' ? 'color: rgba(255,255,255,0.95);' : ''; ?>">
                <?php echo esc_html(get_sub_field('text')); ?>
              </p>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_sub_field('btn_link')); ?>" class="btn <?php echo $bg === 'blue' ? 'btn--secondary' : 'btn--primary'; ?> btn--large">
              <?php echo esc_html(get_sub_field('btn_text')); ?>
            </a>
          </div>
        </div>
      </section>

    <?php /* ===== TEXT SIMPLU ===== */ ?>
    <?php elseif (get_row_layout() === 'text_section') : ?>
      <section class="section <?php echo esc_attr($bg_class); ?>">
        <div class="container container--narrow">
          <div class="page-content reveal" style="color: var(--color-gray); line-height: 1.8; font-size: 1.0625rem;">
            <?php echo wp_kses_post(get_sub_field('content')); ?>
          </div>
        </div>
      </section>

    <?php /* ===== CITAT JAPONEZ ===== */ ?>
    <?php elseif (get_row_layout() === 'jp_quote') : ?>
      <section class="section section--blue">
        <div class="container">
          <div class="jp-quote reveal">
            <div class="jp-quote__kanji"><?php echo esc_html(get_sub_field('kanji')); ?></div>
            <div class="jp-quote__romaji"><?php echo esc_html(get_sub_field('romaji')); ?></div>
            <div class="jp-quote__translation"><?php echo esc_html(get_sub_field('translation')); ?></div>
          </div>
        </div>
      </section>

    <?php /* ===== GALERIE ===== */ ?>
    <?php elseif (get_row_layout() === 'gallery_section') : ?>
      <section class="section section--alt">
        <div class="container">
          <?php $images = get_sub_field('images'); if ($images) : ?>
            <div class="gallery-grid reveal">
              <?php foreach ($images as $img_url) : ?>
                <div class="gallery-item">
                  <img src="<?php echo esc_url($img_url); ?>" alt="">
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </section>

    <?php endif; ?>
  <?php endwhile; ?>
<?php else : ?>
  <!-- Fallback: WordPress editor content -->
  <section class="section section--dark">
    <div class="container container--narrow">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="page-content" style="color: var(--color-gray); line-height: 1.8;">
          <?php the_content(); ?>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </section>
<?php endif; ?>

<?php get_footer(); ?>
