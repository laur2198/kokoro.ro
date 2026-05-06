<?php
/**
 * Template Name: Calendar Competițional
 * Pagina cu calendarul competițiilor — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();

$acf = function_exists('get_field');

$hero_eyebrow  = $acf ? (string) get_field('calendar_hero_eyebrow')  : '';
$hero_titlu    = $acf ? (string) get_field('calendar_hero_titlu')    : '';
$hero_subtitlu = $acf ? (string) get_field('calendar_hero_subtitlu') : '';
$competitii    = $acf ? get_field('calendar_competitii')             : [];
$nota          = $acf ? (string) get_field('calendar_nota')          : '';
$cta_titlu     = $acf ? (string) get_field('calendar_cta_titlu')     : '';
$cta_text      = $acf ? (string) get_field('calendar_cta_text')      : '';

if ($hero_eyebrow === '')  $hero_eyebrow  = 'Calendar';
if ($hero_titlu === '')    $hero_titlu    = 'CALENDAR|COMPETIȚIONAL';
if ($hero_subtitlu === '') $hero_subtitlu = 'Competițiile la care participă Academia Kokoro Brașov în acest an — naționale, balcanice, europene și mondiale.';
if ($nota === '')          $nota          = 'Programul poate suferi modificări. Pentru ultimele actualizări, contactează-ne sau consultă pagina noastră de Facebook.';
if ($cta_titlu === '')     $cta_titlu     = 'VREI SĂ|CONCUREZI?';
if ($cta_text === '')      $cta_text      = 'Pregătirea pentru competiție începe în sala Kokoro. Înscrie-te la grupa de performanță și vino să ne cunoști.';
?>

<section class="page-header">
  <div class="container">
    <div class="section-number"><?php echo esc_html($hero_eyebrow); ?></div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="margin-top: var(--space-lg); max-width: 700px;"><?php echo esc_html($hero_subtitlu); ?></p>
  </div>
  <div class="page-header__number" aria-hidden="true">競</div>
</section>

<?php if (!empty($competitii) && is_array($competitii)) : ?>
<section class="section section--dark">
  <div class="container" style="max-width: 900px;">
    <div class="reveal" style="display: grid; grid-template-columns: 1fr; gap: var(--space-lg);">
      <?php foreach ($competitii as $comp) :
        $titlu     = $comp['titlu']     ?? '';
        $data      = $comp['data']      ?? '';
        $locatie   = $comp['locatie']   ?? '';
        $tip       = $comp['tip']       ?? '';
        $descriere = $comp['descriere'] ?? '';
        $link      = $comp['link']      ?? '';
        $tip_color = ['national' => 'var(--color-primary)', 'balcanic' => '#9C27B0', 'european' => '#00BCD4', 'mondial' => 'var(--color-accent)'];
        $tip_label = ['national' => 'Național', 'balcanic' => 'Balcanic', 'european' => 'European', 'mondial' => 'Mondial'];
      ?>
        <article style="background: var(--color-bg-card); padding: var(--space-2xl); border-radius: var(--radius-md); border-left: 4px solid <?php echo esc_attr($tip_color[$tip] ?? 'var(--color-accent)'); ?>;">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: var(--space-md); flex-wrap: wrap; margin-bottom: var(--space-md);">
            <div>
              <h3 style="color: var(--color-text); margin-bottom: var(--space-xs);"><?php echo esc_html($titlu); ?></h3>
              <?php if ($locatie !== '') : ?>
                <p style="color: var(--color-gray); font-size: 0.9375rem;">📍 <?php echo esc_html($locatie); ?></p>
              <?php endif; ?>
            </div>
            <div style="text-align: right;">
              <?php if ($tip !== '' && isset($tip_label[$tip])) : ?>
                <span style="display: inline-block; padding: 0.25rem 0.75rem; background: <?php echo esc_attr($tip_color[$tip]); ?>; color: var(--color-white); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; border-radius: var(--radius-sm); font-weight: 700;"><?php echo esc_html($tip_label[$tip]); ?></span>
              <?php endif; ?>
              <?php if ($data !== '') : ?>
                <p style="color: var(--color-accent); font-weight: 700; margin-top: var(--space-xs);"><?php echo esc_html($data); ?></p>
              <?php endif; ?>
            </div>
          </div>
          <?php if ($descriere !== '') : ?>
            <p style="color: var(--color-gray); line-height: 1.7;"><?php echo esc_html($descriere); ?></p>
          <?php endif; ?>
          <?php if ($link !== '') : ?>
            <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener" class="btn btn--outline btn--small" style="margin-top: var(--space-md);">Detalii concurs →</a>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($nota !== '') : ?>
      <div class="reveal" style="margin-top: var(--space-3xl); padding: var(--space-xl); background: rgba(0,0,0,0.2); border-left: 4px solid var(--color-accent); border-radius: var(--radius-md);">
        <p style="line-height: 1.9;"><strong style="color: var(--color-accent);">Notă:</strong> <?php echo esc_html($nota); ?></p>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php else : ?>
<section class="section section--dark">
  <div class="container" style="text-align: center;">
    <p style="max-width: 600px; margin: 0 auto;">Nu sunt competiții programate momentan. Editează pagina <strong>Calendar Competițional</strong> din admin → câmpul <strong>Competiții</strong>.</p>
  </div>
</section>
<?php endif; ?>

<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);"><?php echo kokoro_render_italic_title($cta_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <p style="color: #0D47A1; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;"><?php echo esc_html($cta_text); ?></p>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">Înscrie-te la Performanță</a>
        <a href="<?php echo esc_url(home_url('/campioni/')); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">Vezi Campionii</a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
