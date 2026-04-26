<?php
/**
 * Template Name: Discipline
 * Pagina discipline — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu      = function_exists('get_field') ? (string) get_field('discipline_hero_titlu')      : '';
$hero_subtitlu   = function_exists('get_field') ? (string) get_field('discipline_hero_subtitlu')   : '';
$jp_kanji        = function_exists('get_field') ? (string) get_field('discipline_jp_kanji')        : '';
$jp_romaji       = function_exists('get_field') ? (string) get_field('discipline_jp_romaji')       : '';
$jp_traducere    = function_exists('get_field') ? (string) get_field('discipline_jp_traducere')    : '';
$arata_centuri   = function_exists('get_field') ? (bool)   get_field('discipline_arata_centuri')   : true;
$cta_titlu       = function_exists('get_field') ? (string) get_field('discipline_cta_titlu')       : '';
$cta_text        = function_exists('get_field') ? (string) get_field('discipline_cta_text')        : '';
$cta_buton       = function_exists('get_field') ? (string) get_field('discipline_cta_buton')       : '';

if ($hero_titlu === '')    { $hero_titlu    = 'ARTA|LUPTEI|NOBILE'; }
if ($hero_subtitlu === '') { $hero_subtitlu = 'De la Ju-Jitsu competițional la autoapărare și pregătire fizică — descoperă disciplinele Kokoro Brașov Academy.'; }
if ($cta_titlu === '')     { $cta_titlu     = 'ALEGE|DISCIPLINA|TA'; }
if ($cta_buton === '')     { $cta_buton     = 'Programează Lecția Gratuită'; }

$discipline = get_posts([
    'post_type'      => 'disciplina',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);

$centuri = [
    ['slug' => 'white',  'nume' => 'Albă'],
    ['slug' => 'yellow', 'nume' => 'Galbenă'],
    ['slug' => 'orange', 'nume' => 'Portocalie'],
    ['slug' => 'green',  'nume' => 'Verde'],
    ['slug' => 'blue',   'nume' => 'Albastră'],
    ['slug' => 'brown',  'nume' => 'Maro'],
    ['slug' => 'black',  'nume' => 'Neagră'],
];
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Discipline</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">柔術</div>
</section>

<?php if ($jp_kanji !== '' || $jp_romaji !== '' || $jp_traducere !== '') : ?>
<!-- Japanese Quote -->
<section class="section section--alt" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="jp-quote">
      <?php if ($jp_kanji !== '')     : ?><div class="jp-quote__kanji"><?php       echo esc_html($jp_kanji); ?></div>    <?php endif; ?>
      <?php if ($jp_romaji !== '')    : ?><div class="jp-quote__romaji"><?php      echo esc_html($jp_romaji); ?></div>   <?php endif; ?>
      <?php if ($jp_traducere !== '') : ?><div class="jp-quote__translation"><?php echo esc_html($jp_traducere); ?></div><?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($discipline)) : ?>
<!-- Discipline Grid -->
<section class="section section--dark">
  <div class="container">
    <div class="discipline-grid" style="gap: var(--space-lg);">
      <?php foreach ($discipline as $i => $d) :
          $did           = $d->ID;
          $titlu         = get_the_title($did);
          $descriere     = function_exists('get_field') ? (string) get_field('disciplina_descriere_scurta', $did) : '';
          $cta_label_d   = function_exists('get_field') ? (string) get_field('disciplina_cta_label', $did)        : '';
          $link_custom   = function_exists('get_field') ? (string) get_field('disciplina_link', $did)             : '';
          if ($cta_label_d === '') $cta_label_d = 'Află Mai Mult';
          $link          = $link_custom !== '' ? $link_custom : get_permalink($did);
          $numar         = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
          $delay_class   = 'reveal-delay-' . min($i + 1, 4);
          $thumb_url     = get_the_post_thumbnail_url($did, 'kokoro-card');
      ?>
        <a href="<?php echo esc_url($link); ?>" class="discipline-card reveal <?php echo esc_attr($delay_class); ?>" style="min-height: 400px;">
          <div class="discipline-card__bg" style="background-color: var(--color-bg-card);<?php if ($thumb_url) : ?> background-image: url('<?php echo esc_url($thumb_url); ?>'); background-size: cover; background-position: center;<?php endif; ?>"></div>
          <div class="discipline-card__content">
            <div class="discipline-card__number"><?php echo esc_html($numar); ?></div>
            <h3 class="discipline-card__title"><?php echo esc_html($titlu); ?></h3>
            <?php if ($descriere !== '') : ?>
              <p class="discipline-card__subtitle"><?php echo nl2br(esc_html($descriere)); ?></p>
            <?php endif; ?>
            <span class="btn btn--outline-accent btn--small" style="margin-top: var(--space-lg); display: inline-flex;">
              <?php echo esc_html($cta_label_d); ?>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php else : ?>
<!-- Empty state -->
<section class="section section--dark">
  <div class="container" style="text-align: center;">
    <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
      Încă nu ai adăugat discipline. Mergi în <strong>Discipline → Adaugă Disciplină Nouă</strong> din meniul WP Admin.
    </p>
  </div>
</section>
<?php endif; ?>

<?php if ($arata_centuri) : ?>
<!-- Belt Progression -->
<section class="section section--alt">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <div class="section-number">Progresie</div>
      <h2 style="margin-bottom: var(--space-2xl);">SISTEMUL DE <em>CENTURI</em></h2>

      <div class="belt-progression" style="justify-content: center; gap: var(--space-md); flex-wrap: wrap;">
        <?php foreach ($centuri as $c) : ?>
          <div style="text-align: center;">
            <div class="belt belt--<?php echo esc_attr($c['slug']); ?>" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
            <span class="text-xs text-gray"><?php echo esc_html($c['nume']); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
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
        <?php echo esc_html($cta_buton); ?>
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
