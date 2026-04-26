<?php
/**
 * Template Name: Orar
 * Pagina orar — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu    = function_exists('get_field') ? (string) get_field('orar_hero_titlu')    : '';
$hero_subtitlu = function_exists('get_field') ? (string) get_field('orar_hero_subtitlu') : '';
$legenda       = function_exists('get_field') ? get_field('orar_legenda')                : [];
$program       = function_exists('get_field') ? get_field('orar_program')                : [];
$nota          = function_exists('get_field') ? (string) get_field('orar_nota')          : '';
$cta_titlu     = function_exists('get_field') ? (string) get_field('orar_cta_titlu')     : '';
$cta_text      = function_exists('get_field') ? (string) get_field('orar_cta_text')      : '';

if ($hero_titlu === '')    { $hero_titlu    = 'PROGRAMUL|ANTRENAMENTELOR'; }
if ($hero_subtitlu === '') { $hero_subtitlu = 'Alege grupa și orele care ți se potrivesc. Antrenamentele au loc în sala Kokoro din Brașov.'; }
if ($cta_titlu === '')     { $cta_titlu     = 'ALEGE|GRUPA|TA'; }
if ($cta_text === '')      { $cta_text      = 'Prima lecție este gratuită. Vino și descoperă Ju-Jitsu la Kokoro!'; }

$program_sorted = kokoro_sort_program_by_day($program);

// Count rows per day for rowspan
$day_counts = [];
foreach ($program_sorted as $row) {
    $zi = $row['zi'] ?? '';
    if ($zi === '') continue;
    $day_counts[$zi] = ($day_counts[$zi] ?? 0) + 1;
}
$day_rendered = [];
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Orar</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">修行</div>
</section>

<?php if (!empty($legenda) && is_array($legenda)) : ?>
<!-- Legend -->
<section class="section section--alt" style="padding: var(--space-xl) 0;">
  <div class="container">
    <div style="display: flex; gap: var(--space-xl); justify-content: center; flex-wrap: wrap;">
      <?php foreach ($legenda as $item) : ?>
        <div style="display: flex; align-items: center; gap: var(--space-sm);">
          <span class="schedule__group schedule__group--<?php echo esc_attr($item['slug'] ?? 'adulti'); ?>">
            <?php echo esc_html($item['nume'] ?? ''); ?>
          </span>
          <?php if (!empty($item['varsta'])) : ?>
            <span class="text-sm text-gray"><?php echo esc_html($item['varsta']); ?></span>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($program_sorted)) : ?>
<!-- Schedule Table -->
<section class="section section--dark">
  <div class="container">
    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Zi</th>
            <th>Oră</th>
            <th>Disciplină</th>
            <th>Grupă</th>
            <th>Antrenor</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($program_sorted as $row) :
              $zi         = $row['zi'] ?? '';
              $ora        = $row['ora'] ?? '';
              $disciplina = $row['disciplina'] ?? '';
              $grupa_slug = $row['grupa'] ?? '';
              $antrenor   = $row['antrenor'] ?? '';

              $grupa_labels = [
                  'copii'   => 'Copii',
                  'juniori' => 'Juniori',
                  'adulti'  => 'Adulți',
              ];
              $grupa_label = $grupa_labels[$grupa_slug] ?? ucfirst($grupa_slug);

              $is_first_row_for_day = !isset($day_rendered[$zi]);
              $day_rendered[$zi] = true;
          ?>
            <tr>
              <?php if ($is_first_row_for_day) : ?>
                <td<?php if (($day_counts[$zi] ?? 1) > 1) : ?> rowspan="<?php echo (int) $day_counts[$zi]; ?>"<?php endif; ?>
                    style="font-weight: 700; color: var(--color-white); vertical-align: middle;">
                  <?php echo esc_html(mb_strtoupper($zi, 'UTF-8')); ?>
                </td>
              <?php endif; ?>
              <td><?php echo esc_html($ora); ?></td>
              <td><?php echo esc_html($disciplina); ?></td>
              <td>
                <?php if ($grupa_slug !== '') : ?>
                  <span class="schedule__group schedule__group--<?php echo esc_attr($grupa_slug); ?>">
                    <?php echo esc_html($grupa_label); ?>
                  </span>
                <?php endif; ?>
              </td>
              <td style="color: var(--color-white);">
                <?php echo $antrenor !== '' ? esc_html($antrenor) : '—'; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($nota !== '') : ?>
      <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-bg-card); border: 1px solid var(--color-gray-dark);">
        <p style="color: var(--color-gray); font-size: 0.9375rem;">
          <strong style="color: var(--color-accent);">Notă:</strong> <?php echo esc_html($nota); ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php else : ?>
<!-- Empty state -->
<section class="section section--dark">
  <div class="container" style="text-align: center;">
    <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
      Încă nu ai adăugat antrenamente. Editează pagina <strong>Orar</strong> din admin și completează câmpul <strong>Program săptămânal</strong>.
    </p>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">
        <?php echo kokoro_render_italic_title($cta_titlu, ' '); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </h2>
      <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        <?php echo esc_html($cta_text); ?>
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
