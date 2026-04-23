<?php
/**
 * Template Name: Despre Noi
 * Pagina Despre Noi — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$acf = function_exists('get_field');

$hero_titlu      = $acf ? (string) get_field('despre_hero_titlu')    : '';
$hero_subtitlu   = $acf ? (string) get_field('despre_hero_subtitlu') : '';
$hero_imagine    = $acf ? (string) get_field('despre_hero_imagine')  : '';

$poveste_titlu   = $acf ? (string) get_field('despre_poveste_titlu')   : '';
$poveste_text    = $acf ? (string) get_field('despre_poveste_text')    : '';
$poveste_imagine = $acf ? (string) get_field('despre_poveste_imagine') : '';

$misiune_titlu = $acf ? (string) get_field('despre_misiune_titlu') : '';
$misiune_text  = $acf ? (string) get_field('despre_misiune_text')  : '';
$viziune_titlu = $acf ? (string) get_field('despre_viziune_titlu') : '';
$viziune_text  = $acf ? (string) get_field('despre_viziune_text')  : '';

$stats         = $acf ? get_field('despre_stats') : [];

$valori_titlu    = $acf ? (string) get_field('despre_valori_titlu')    : '';
$valori_subtitlu = $acf ? (string) get_field('despre_valori_subtitlu') : '';
$valori          = $acf ? get_field('despre_valori')                   : [];

$timeline_titlu  = $acf ? (string) get_field('despre_timeline_titlu')  : '';
$timeline        = $acf ? get_field('despre_timeline')                 : [];

$echipa_titlu = $acf ? (string) get_field('despre_echipa_titlu') : '';
$echipa_text  = $acf ? (string) get_field('despre_echipa_text')  : '';
$echipa_limit = $acf ? (int)    get_field('despre_echipa_limit') : 4;

$cta_titlu = $acf ? (string) get_field('despre_cta_titlu') : '';
$cta_text  = $acf ? (string) get_field('despre_cta_text')  : '';
$cta_buton = $acf ? (string) get_field('despre_cta_buton') : '';

if ($hero_titlu === '')      $hero_titlu      = 'DESPRE|KOKORO';
if ($hero_subtitlu === '')   $hero_subtitlu   = 'O academie de Ju-Jitsu fondată din pasiune. Fiecare antrenament e un pas spre versiunea ta mai bună.';
if ($poveste_titlu === '')   $poveste_titlu   = 'POVESTEA|NOASTRĂ';
if ($poveste_text === '')    $poveste_text    = 'În 2008, Sensei Lucică a deschis primul dojo Kokoro Brașov cu ambiția de a forma sportivi de elită și caractere puternice.';
if ($misiune_titlu === '')   $misiune_titlu   = 'MISIUNE';
if ($viziune_titlu === '')   $viziune_titlu   = 'VIZIUNE';
if ($valori_titlu === '')    $valori_titlu    = 'VALORI|FUNDAMENTALE';
if ($timeline_titlu === '')  $timeline_titlu  = 'MOMENTE|CHEIE';
if ($echipa_titlu === '')    $echipa_titlu    = 'ECHIPA|KOKORO';
if ($cta_titlu === '')       $cta_titlu       = 'ALĂTURĂ-TE|FAMILIEI KOKORO';
if ($cta_buton === '')       $cta_buton       = 'Înscrie-te Acum';

$antrenori = ($echipa_limit > 0) ? get_posts([
    'post_type'      => 'antrenor',
    'posts_per_page' => $echipa_limit,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]) : [];
?>

<section class="page-header" <?php if ($hero_imagine !== '') : ?>style="background-image: linear-gradient(rgba(13, 33, 55, 0.8), rgba(13, 33, 55, 0.95)), url('<?php echo esc_url($hero_imagine); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
  <div class="container">
    <div class="section-number">Despre Noi</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">道場</div>
</section>

<!-- Povestea -->
<?php if ($poveste_text !== '') : ?>
<section class="section section--dark">
  <div class="container">
    <div style="display: grid; grid-template-columns: <?php echo $poveste_imagine ? '1fr 1fr' : '1fr'; ?>; gap: var(--space-3xl); align-items: center;" class="reveal">
      <div>
        <div class="section-number">01 — Despre noi</div>
        <h2 style="margin: var(--space-md) 0 var(--space-xl);">
          <?php echo kokoro_render_italic_title($poveste_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </h2>
        <div style="color: var(--color-gray); line-height: 1.8;">
          <?php echo wp_kses_post($poveste_text); ?>
        </div>
      </div>
      <?php if ($poveste_imagine !== '') : ?>
        <div>
          <img src="<?php echo esc_url($poveste_imagine); ?>" alt="<?php echo esc_attr($poveste_titlu); ?>" style="width: 100%; height: auto; display: block;">
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Statistici -->
<?php if (!empty($stats)) : ?>
<section class="section section--accent" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="hero__stats-inner" style="padding: 0; justify-content: space-around;">
      <?php foreach ($stats as $stat) : ?>
        <div class="stat">
          <div class="stat__number" style="color: var(--color-bg);"
               data-counter="<?php echo esc_attr($stat['numar'] ?? 0); ?>"
               <?php if (!empty($stat['sufix'])) : ?>data-suffix="<?php echo esc_attr($stat['sufix']); ?>"<?php endif; ?>>0</div>
          <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;"><?php echo esc_html($stat['label'] ?? ''); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Misiune & Viziune -->
<?php if ($misiune_text !== '' || $viziune_text !== '') : ?>
<section class="section section--alt">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-2xl);" class="reveal">
      <?php if ($misiune_text !== '') : ?>
        <div class="card" style="padding: var(--space-2xl);">
          <div class="card__tag"><?php echo esc_html($misiune_titlu); ?></div>
          <h3 class="heading-3" style="margin-top: var(--space-md);">CE FACEM</h3>
          <p style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-lg);">
            <?php echo esc_html($misiune_text); ?>
          </p>
        </div>
      <?php endif; ?>
      <?php if ($viziune_text !== '') : ?>
        <div class="card" style="padding: var(--space-2xl); border-color: var(--color-accent);">
          <div class="card__tag"><?php echo esc_html($viziune_titlu); ?></div>
          <h3 class="heading-3" style="margin-top: var(--space-md);">UNDE MERGEM</h3>
          <p style="color: var(--color-gray); line-height: 1.8; margin-top: var(--space-lg);">
            <?php echo esc_html($viziune_text); ?>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Valori -->
<?php if (!empty($valori) && is_array($valori)) : ?>
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Valori</div>
      <h2><?php echo kokoro_render_italic_title($valori_titlu, ' '); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <?php if ($valori_subtitlu !== '') : ?>
        <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 600px;">
          <?php echo esc_html($valori_subtitlu); ?>
        </p>
      <?php endif; ?>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($valori as $i => $v) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="value-item reveal <?php echo esc_attr($delay); ?>" style="text-align: center; padding: var(--space-xl);">
          <div class="value-item__kanji"><?php echo esc_html($v['kanji'] ?? ''); ?></div>
          <div class="value-item__romaji"><?php echo esc_html($v['romaji'] ?? ''); ?></div>
          <?php if (!empty($v['nume'])) : ?>
            <h4 class="heading-5" style="margin: var(--space-md) 0 var(--space-sm);"><?php echo esc_html($v['nume']); ?></h4>
          <?php endif; ?>
          <?php if (!empty($v['descriere'])) : ?>
            <p class="value-item__meaning"><?php echo esc_html($v['descriere']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Timeline -->
<?php if (!empty($timeline) && is_array($timeline)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Istorie</div>
      <h2><?php echo kokoro_render_italic_title($timeline_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div style="max-width: 800px; margin: 0 auto;">
      <?php foreach ($timeline as $i => $tl) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="reveal <?php echo esc_attr($delay); ?>" style="display: grid; grid-template-columns: 120px 1fr; gap: var(--space-xl); padding: var(--space-xl) 0; border-bottom: 1px solid var(--color-gray-dark);">
          <div style="text-align: right; padding-right: var(--space-lg); border-right: 3px solid var(--color-accent);">
            <div style="color: var(--color-accent); font-family: var(--font-heading); font-weight: 800; font-size: 1.5rem;">
              <?php echo esc_html($tl['an'] ?? ''); ?>
            </div>
          </div>
          <div>
            <h4 class="heading-5" style="margin-bottom: var(--space-sm);"><?php echo esc_html($tl['eveniment'] ?? ''); ?></h4>
            <?php if (!empty($tl['descriere'])) : ?>
              <p style="color: var(--color-gray); line-height: 1.7;"><?php echo esc_html($tl['descriere']); ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Echipa preview -->
<?php if (!empty($antrenori)) : ?>
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Echipa</div>
      <h2><?php echo kokoro_render_italic_title($echipa_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <?php if ($echipa_text !== '') : ?>
        <p style="color: var(--color-gray); margin-top: var(--space-md); max-width: 600px;">
          <?php echo esc_html($echipa_text); ?>
        </p>
      <?php endif; ?>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-lg);">
      <?php foreach ($antrenori as $i => $a) :
          $aid   = $a->ID;
          $rol   = $acf ? (string) get_field('antrenor_rol', $aid) : '';
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <a href="<?php echo esc_url(get_permalink($aid)); ?>" class="reveal <?php echo esc_attr($delay); ?>" style="text-decoration: none; display: block;">
          <?php if (has_post_thumbnail($aid)) : ?>
            <?php echo get_the_post_thumbnail($aid, 'kokoro-square', [
                'style' => 'width: 100%; height: 280px; object-fit: cover; display: block; margin-bottom: var(--space-md);',
            ]); ?>
          <?php else : ?>
            <div style="width: 100%; height: 280px; background: var(--color-bg-card); margin-bottom: var(--space-md);"></div>
          <?php endif; ?>
          <h4 class="heading-5" style="color: var(--color-white);"><?php echo esc_html(get_the_title($aid)); ?></h4>
          <?php if ($rol !== '') : ?>
            <p style="color: var(--color-accent); font-size: 0.875rem; font-weight: 600; margin-top: var(--space-xs);">
              <?php echo esc_html($rol); ?>
            </p>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: var(--space-3xl);" class="reveal">
      <a href="<?php echo esc_url(home_url('/antrenori/')); ?>" class="btn btn--outline-accent">
        Vezi Toți Antrenorii
      </a>
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

<?php get_footer(); ?>
