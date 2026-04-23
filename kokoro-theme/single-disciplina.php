<?php
/**
 * Single Disciplina — pagină dedicată unei discipline individuale
 *
 * @package Kokoro
 */

get_header();

if (!have_posts()) {
    get_footer();
    return;
}
the_post();

$did         = get_the_ID();
$descriere   = function_exists('get_field') ? (string) get_field('disciplina_descriere_scurta') : '';
$cta_label   = function_exists('get_field') ? (string) get_field('disciplina_cta_label')        : '';
if ($cta_label === '') $cta_label = 'Înscrie-te';

// Trage rândurile din Orar care au această disciplină în nume
$orar_page = kokoro_get_page_by_template('page-orar.php');
$rows_pentru_disciplina = [];
if ($orar_page && function_exists('get_field')) {
    $program = get_field('orar_program', $orar_page->ID);
    if (is_array($program)) {
        $titlu_lower = mb_strtolower(get_the_title($did), 'UTF-8');
        foreach ($program as $row) {
            $disc_lower = mb_strtolower($row['disciplina'] ?? '', 'UTF-8');
            // Match dacă numele disciplinei apare în câmpul disciplina al rândului (sau invers)
            if ($disc_lower !== '' && (mb_strpos($disc_lower, $titlu_lower) !== false || mb_strpos($titlu_lower, $disc_lower) !== false)) {
                $rows_pentru_disciplina[] = $row;
            }
        }
        $rows_pentru_disciplina = kokoro_sort_program_by_day($rows_pentru_disciplina);
    }
}
?>

<section class="page-header">
  <div class="container">
    <a href="<?php echo esc_url(home_url('/discipline/')); ?>" class="section-number" style="text-decoration: none;">← Toate Disciplinele</a>
    <h1 style="margin-top: var(--space-md);"><?php the_title(); ?></h1>
    <?php if ($descriere !== '') : ?>
      <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 700px; line-height: 1.7;">
        <?php echo nl2br(esc_html($descriere)); ?>
      </p>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">柔</div>
</section>

<!-- Hero image (dacă există featured image) -->
<?php if (has_post_thumbnail()) : ?>
<section style="padding: 0;">
  <div class="container" style="margin-top: calc(-1 * var(--space-2xl));">
    <?php the_post_thumbnail('kokoro-hero', [
        'style' => 'width: 100%; height: auto; max-height: 500px; object-fit: cover; display: block;',
    ]); ?>
  </div>
</section>
<?php endif; ?>

<!-- Conținut detaliat din editor -->
<?php if (get_the_content()) : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <article class="page-content" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
      <?php the_content(); ?>
    </article>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($rows_pentru_disciplina)) : ?>
<!-- Orar pentru această disciplină -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Program</div>
      <h2>ANTRENAMENTE<br><em>DISPONIBILE</em></h2>
      <p style="color: var(--color-gray); margin-top: var(--space-md);">
        Următoarele antrenamente includ <strong style="color: var(--color-accent);"><?php the_title(); ?></strong>.
      </p>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Zi</th>
            <th>Oră</th>
            <th>Grupă</th>
            <th>Antrenor</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows_pentru_disciplina as $row) :
              $grupa_slug   = $row['grupa'] ?? '';
              $grupa_labels = ['copii' => 'Copii', 'juniori' => 'Juniori', 'adulti' => 'Adulți'];
              $grupa_label  = $grupa_labels[$grupa_slug] ?? ucfirst((string) $grupa_slug);
          ?>
            <tr>
              <td style="font-weight: 700; color: var(--color-white);"><?php echo esc_html(mb_strtoupper($row['zi'] ?? '', 'UTF-8')); ?></td>
              <td><?php echo esc_html($row['ora'] ?? ''); ?></td>
              <td>
                <?php if ($grupa_slug !== '') : ?>
                  <span class="schedule__group schedule__group--<?php echo esc_attr($grupa_slug); ?>">
                    <?php echo esc_html($grupa_label); ?>
                  </span>
                <?php endif; ?>
              </td>
              <td style="color: var(--color-white);"><?php echo esc_html($row['antrenor'] ?? '—'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div style="text-align: center; margin-top: var(--space-2xl);" class="reveal">
      <a href="<?php echo esc_url(home_url('/orar/')); ?>" class="btn btn--outline-accent">
        Vezi Orarul Complet
      </a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Navigare disciplina anterioară/următoare -->
<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if ($prev_post || $next_post) :
?>
<section class="section section--dark" style="padding: var(--space-3xl) 0;">
  <div class="container">
    <div style="display: flex; justify-content: space-between; gap: var(--space-lg); flex-wrap: wrap;">
      <div style="flex: 1; min-width: 200px;">
        <?php if ($prev_post) : ?>
          <span class="section-label">← Disciplina anterioară</span>
          <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="link" style="display: block; margin-top: var(--space-xs); color: var(--color-white); font-weight: 700;">
            <?php echo esc_html($prev_post->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
      <div style="flex: 1; min-width: 200px; text-align: right;">
        <?php if ($next_post) : ?>
          <span class="section-label">Disciplina următoare →</span>
          <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="link" style="display: block; margin-top: var(--space-xs); color: var(--color-white); font-weight: 700;">
            <?php echo esc_html($next_post->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">VINO LA O LECȚIE<br><em>DEMONSTRATIVĂ</em></h2>
      <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        Prima lecție este gratuită. Descoperă singur cum decurge un antrenament <strong><?php the_title(); ?></strong> la Kokoro.
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        <?php echo esc_html($cta_label); ?>
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
