<?php
/**
 * Template Name: Regulament Intern
 * Pagina regulament de ordine interioară — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();

$acf = function_exists('get_field');

$hero_eyebrow  = $acf ? (string) get_field('regulament_hero_eyebrow')  : '';
$hero_titlu    = $acf ? (string) get_field('regulament_hero_titlu')    : '';
$hero_subtitlu = $acf ? (string) get_field('regulament_hero_subtitlu') : '';
$intro         = $acf ? (string) get_field('regulament_intro')         : '';
$articole      = $acf ? get_field('regulament_articole')               : [];
$nota          = $acf ? (string) get_field('regulament_nota')          : '';
$semnatar      = $acf ? (string) get_field('regulament_semnatar')      : '';
$cta_titlu     = $acf ? (string) get_field('regulament_cta_titlu')     : '';
$cta_text      = $acf ? (string) get_field('regulament_cta_text')      : '';

if ($hero_eyebrow === '')  $hero_eyebrow  = 'Regulament';
if ($hero_titlu === '')    $hero_titlu    = 'REGULAMENT DE|ORDINE INTERIOARĂ';
if ($hero_subtitlu === '') $hero_subtitlu = 'Regulile clubului C.S. Kokoro Brașov — disciplină, înscriere, examene de grad și principii fundamentale.';
if ($intro === '')         $intro         = '<p>În cadrul clubului nostru se practică artele marțiale — Ju-Jitsu. Membrii clubului se adresează antrenorului cu <strong>„Sensei"</strong>. Toți sportivii sunt tratați egal, indiferent de vârstă, sex, religie sau poziție socială.</p><p>Antrenamentul nu poate avea loc decât în prezența Sensei-ului sau a unui instructor desemnat de acesta. În dojo nu se lucrează alte tehnici decât cele cerute de Sensei.</p>';
if ($nota === '')          $nota          = 'Acest Regulament de Ordine Interioară a fost aprobat și semnat în ședința consiliului director din data de 15.08.2013, actualizat ulterior cu numele și taxele curente.';
if ($semnatar === '')      $semnatar      = 'Președinte Academie — Lucian Bogluț';
if ($cta_titlu === '')     $cta_titlu     = 'AI ÎNTREBĂRI|DESPRE REGULAMENT?';
if ($cta_text === '')      $cta_text      = 'Suntem aici să te ajutăm să înțelegi cum funcționează academia. Contactează-ne pentru orice clarificare.';

if (!is_array($articole) || empty($articole)) {
    $articole = []; // gol → afișează mesaj
}
?>

<section class="page-header">
  <div class="container">
    <div class="section-number"><?php echo esc_html($hero_eyebrow); ?></div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="margin-top: var(--space-lg); max-width: 700px;"><?php echo esc_html($hero_subtitlu); ?></p>
  </div>
  <div class="page-header__number" aria-hidden="true">道</div>
</section>

<?php if ($intro !== '') : ?>
<section class="section section--alt">
  <div class="container" style="max-width: 800px;">
    <div class="reveal" style="background: var(--color-bg-card); border-left: 4px solid var(--color-accent); padding: var(--space-xl) var(--space-2xl); border-radius: var(--radius-md); color: var(--color-text); line-height: 1.9;">
      <?php echo wp_kses_post($intro); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($articole)) : ?>
<section class="section section--blue">
  <div class="container" style="max-width: 900px;">
    <?php foreach ($articole as $art) : ?>
      <article class="reveal" style="margin-bottom: var(--space-3xl);">
        <h2 style="color: var(--color-accent); margin-bottom: var(--space-lg);"><?php echo esc_html($art['titlu'] ?? ''); ?></h2>
        <?php if (!empty($art['continut'])) : ?>
          <div style="line-height: 2;"><?php echo wp_kses_post($art['continut']); ?></div>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>

    <?php if ($nota !== '') : ?>
      <div class="reveal" style="margin-top: var(--space-3xl); padding: var(--space-xl); background: rgba(0,0,0,0.2); border-left: 4px solid var(--color-accent); border-radius: var(--radius-md);">
        <p style="line-height: 1.9;"><strong style="color: var(--color-accent);">NOTĂ:</strong> <?php echo esc_html($nota); ?></p>
        <?php if ($semnatar !== '') : ?>
          <p style="margin-top: var(--space-sm); font-size: 0.9375rem; opacity: 0.85;"><?php echo esc_html($semnatar); ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php else : ?>
<section class="section section--blue">
  <div class="container" style="text-align: center;">
    <p>Conținutul regulamentului nu a fost încă publicat. Editează pagina <strong>Regulament</strong> din admin → câmpul <strong>Articole</strong>.</p>
  </div>
</section>
<?php endif; ?>

<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);"><?php echo kokoro_render_italic_title($cta_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <p style="color: var(--color-primary-dark); margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;"><?php echo esc_html($cta_text); ?></p>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">Contactează-ne</a>
        <a href="<?php echo esc_url(home_url('/formulare/')); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">Vezi Formularele</a>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
