<?php
/**
 * Template Name: Galerie
 * Galerie foto/video — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu    = function_exists('get_field') ? (string) get_field('galerie_hero_titlu')    : '';
$hero_subtitlu = function_exists('get_field') ? (string) get_field('galerie_hero_subtitlu') : '';
$imagini       = function_exists('get_field') ? get_field('galerie_imagini')                : [];
$cta_text      = function_exists('get_field') ? (string) get_field('galerie_cta_text')      : '';
$cta_buton     = function_exists('get_field') ? (string) get_field('galerie_cta_buton')     : '';
$cta_url       = function_exists('get_field') ? (string) get_field('galerie_cta_url')       : '';

if ($hero_titlu === '')    { $hero_titlu    = 'MOMENTE|KOKORO'; }
if ($hero_subtitlu === '') { $hero_subtitlu = 'Antrenamente, competiții, tabere și momente de bucurie — viața la Kokoro Brașov Academy în imagini.'; }
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Galerie</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">写真</div>
</section>

<section class="section section--dark">
  <div class="container">

    <?php if (!empty($imagini) && is_array($imagini)) : ?>
      <div class="gallery-grid reveal">
        <?php foreach ($imagini as $item) :
            $img     = $item['imagine'] ?? null;
            $caption = $item['caption'] ?? '';
            if (!is_array($img) || empty($img['url'])) continue;
            $alt = $caption !== '' ? $caption : ($img['alt'] ?? '');
        ?>
          <div class="gallery-item">
            <a href="<?php echo esc_url($img['url']); ?>" target="_blank" rel="noopener" style="display: block; width: 100%; height: 100%;">
              <img
                src="<?php echo esc_url($img['sizes']['large'] ?? $img['url']); ?>"
                alt="<?php echo esc_attr($alt); ?>"
                loading="lazy"
                style="width: 100%; height: 100%; object-fit: cover; display: block;"
              >
            </a>
            <?php if ($caption !== '') : ?>
              <div class="gallery-item__caption" style="padding: var(--space-sm); font-size: 0.875rem; color: var(--color-gray);">
                <?php echo esc_html($caption); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="reveal" style="text-align: center; padding: var(--space-3xl) 0;">
        <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
          Încă nu ai adăugat poze. Editează pagina <strong>Galerie</strong> din admin și completează câmpul <strong>Imagini</strong>.
        </p>
      </div>
    <?php endif; ?>

    <?php if ($cta_text !== '' || $cta_url !== '') : ?>
      <div class="reveal" style="text-align: center; margin-top: var(--space-3xl);">
        <?php if ($cta_text !== '') : ?>
          <p style="color: var(--color-gray); margin-bottom: var(--space-lg);">
            <?php echo esc_html($cta_text); ?>
          </p>
        <?php endif; ?>
        <?php if ($cta_url !== '' && $cta_buton !== '') : ?>
          <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--outline-accent" target="_blank" rel="noopener">
            <?php echo esc_html($cta_buton); ?>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
