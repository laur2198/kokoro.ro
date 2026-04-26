<?php
/**
 * Template Name: Antrenori
 * Pagina antrenori — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu    = function_exists('get_field') ? (string) get_field('antr_hero_titlu')    : '';
$hero_subtitlu = function_exists('get_field') ? (string) get_field('antr_hero_subtitlu') : '';
$jp_kanji      = function_exists('get_field') ? (string) get_field('antr_jp_kanji')      : '';
$jp_romaji     = function_exists('get_field') ? (string) get_field('antr_jp_romaji')     : '';
$jp_traducere  = function_exists('get_field') ? (string) get_field('antr_jp_traducere')  : '';
$cta_titlu     = function_exists('get_field') ? (string) get_field('antr_cta_titlu')     : '';
$cta_text      = function_exists('get_field') ? (string) get_field('antr_cta_text')      : '';

if ($hero_titlu === '')    $hero_titlu    = 'ECHIPA|KOKORO';
if ($hero_subtitlu === '') $hero_subtitlu = 'Antrenori cu zeci de ani de experiență, dedicați să formeze caractere puternice și sportivi de top.';
if ($cta_titlu === '')     $cta_titlu     = 'ANTRENEAZĂ-TE CU|CEI MAI BUNI';

$antrenori = get_posts([
    'post_type'      => 'antrenor',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Echipa</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">先生</div>
</section>

<?php if ($jp_kanji !== '' || $jp_romaji !== '' || $jp_traducere !== '') : ?>
<section class="section section--alt" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="jp-quote">
      <?php if ($jp_kanji !== '')     : ?><div class="jp-quote__kanji"><?php       echo esc_html($jp_kanji);     ?></div><?php endif; ?>
      <?php if ($jp_romaji !== '')    : ?><div class="jp-quote__romaji"><?php      echo esc_html($jp_romaji);    ?></div><?php endif; ?>
      <?php if ($jp_traducere !== '') : ?><div class="jp-quote__translation"><?php echo esc_html($jp_traducere); ?></div><?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($antrenori)) : ?>
<section class="section section--dark">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($antrenori as $i => $a) :
          $aid          = $a->ID;
          $rol          = function_exists('get_field') ? (string) get_field('antrenor_rol', $aid)          : '';
          $bio          = function_exists('get_field') ? (string) get_field('antrenor_bio_scurt', $aid)    : '';
          $specializare = function_exists('get_field') ? (string) get_field('antrenor_specializare', $aid) : '';
          $ani          = function_exists('get_field') ? (int)    get_field('antrenor_ani_experienta', $aid): 0;
          $delay        = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <a href="<?php echo esc_url(get_permalink($aid)); ?>" class="card reveal <?php echo esc_attr($delay); ?>" style="text-decoration: none; display: block; transition: transform var(--transition-base);">
          <?php if (has_post_thumbnail($aid)) : ?>
            <?php echo get_the_post_thumbnail($aid, 'kokoro-square', [
                'style' => 'width: 100%; height: 350px; object-fit: cover; display: block; margin-bottom: var(--space-lg);',
            ]); ?>
          <?php else : ?>
            <div style="width: 100%; height: 350px; background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-lg);">
              <span style="color: var(--color-gray);">Foto antrenor</span>
            </div>
          <?php endif; ?>

          <?php if ($rol !== '') : ?>
            <div class="card__tag"><?php echo esc_html($rol); ?></div>
          <?php endif; ?>
          <h3 class="card__title" style="margin-top: var(--space-sm);"><?php echo esc_html(get_the_title($aid)); ?></h3>

          <?php if ($specializare !== '') : ?>
            <p style="color: var(--color-accent); font-size: 0.875rem; font-weight: 600; margin-top: var(--space-xs);">
              <?php echo esc_html($specializare); ?>
            </p>
          <?php endif; ?>

          <?php if ($bio !== '') : ?>
            <p class="card__text" style="margin-top: var(--space-md);"><?php echo wp_kses($bio, ['br' => []]); ?></p>
          <?php endif; ?>

          <?php if ($ani > 0) : ?>
            <p style="color: var(--color-gray); font-size: 0.875rem; margin-top: var(--space-md);">
              <strong style="color: var(--color-white);"><?php echo (int) $ani; ?>+</strong> ani de experiență
            </p>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php else : ?>
<section class="section section--dark">
  <div class="container" style="text-align: center;">
    <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
      Încă nu ai adăugat antrenori. Mergi în <strong>Antrenori → Adaugă Antrenor Nou</strong> din meniul WP Admin.
    </p>
  </div>
</section>
<?php endif; ?>

<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">
        <?php echo kokoro_render_italic_title($cta_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </h2>
      <?php if ($cta_text !== '') : ?>
        <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
          <?php echo esc_html($cta_text); ?>
        </p>
      <?php endif; ?>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
