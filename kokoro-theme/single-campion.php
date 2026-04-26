<?php
/**
 * Single Campion — pagină dedicată unui campion individual
 *
 * @package Kokoro
 */

get_header();

if (!have_posts()) {
    get_footer();
    return;
}
the_post();

$cid       = get_the_ID();
$bio_scurt = function_exists('get_field') ? (string) get_field('campion_bio_scurt') : '';
$centura   = function_exists('get_field') ? (string) get_field('campion_centura')   : '';
$rezultate = function_exists('get_field') ? get_field('campion_rezultate')          : [];

$centura_label_map = [
    'alba' => 'Albă', 'galbena' => 'Galbenă', 'portocalie' => 'Portocalie',
    'verde' => 'Verde', 'albastra' => 'Albastră', 'maro' => 'Maro', 'neagra' => 'Neagră',
];
$centura_belt_map = [
    'alba' => 'white', 'galbena' => 'yellow', 'portocalie' => 'orange',
    'verde' => 'green', 'albastra' => 'blue', 'maro' => 'brown', 'neagra' => 'black',
];
$centura_label = $centura_label_map[$centura] ?? '';
$belt_class    = $centura_belt_map[$centura]  ?? '';

// Sortează rezultate după an descrescător
if (is_array($rezultate)) {
    usort($rezultate, fn($a, $b) => (int) ($b['an'] ?? 0) <=> (int) ($a['an'] ?? 0));
} else {
    $rezultate = [];
}

// Numără medalii pe tipuri pentru rezumat
$count_medalii = ['aur' => 0, 'argint' => 0, 'bronz' => 0, 'multiple' => 0, 'participare' => 0];
foreach ($rezultate as $r) {
    $m = $r['medalie'] ?? '';
    if (isset($count_medalii[$m])) $count_medalii[$m]++;
}
?>

<section class="page-header">
  <div class="container">
    <a href="<?php echo esc_url(home_url('/campioni/')); ?>" class="section-number" style="text-decoration: none;">← Toți Campionii</a>
    <h1 style="margin-top: var(--space-md);"><?php the_title(); ?></h1>
    <?php if ($centura_label !== '') : ?>
      <p style="color: var(--color-gray); margin-top: var(--space-sm);">
        Centură <strong style="color: var(--color-accent);"><?php echo esc_html($centura_label); ?></strong>
      </p>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">勝</div>
</section>

<!-- Hero: poză + bio -->
<section class="section section--dark">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl); align-items: start;" class="reveal">

      <div>
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('kokoro-hero', [
              'style' => 'width: 100%; height: auto; max-height: 600px; object-fit: cover; display: block;',
          ]); ?>
        <?php else : ?>
          <div style="width: 100%; height: 500px; background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); display: flex; align-items: center; justify-content: center;">
            <span style="color: var(--color-gray);">Foto <?php the_title(); ?></span>
          </div>
        <?php endif; ?>

        <?php if ($belt_class !== '') : ?>
          <div class="belt-progression" style="margin-top: var(--space-lg); display: flex; align-items: center; gap: var(--space-md);">
            <div class="belt belt--<?php echo esc_attr($belt_class); ?>" style="width: 120px; height: 10px;"></div>
            <span class="text-sm" style="color: var(--color-white);">Centură <?php echo esc_html($centura_label); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <div>
        <?php if ($bio_scurt !== '') : ?>
          <h2 class="heading-3" style="margin-bottom: var(--space-lg);"><?php echo wp_kses_post($bio_scurt); ?></h2>
        <?php endif; ?>

        <?php if (get_the_content()) : ?>
          <div style="color: var(--color-gray); line-height: 1.8;">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

        <?php
          // Rezumat medalii (dacă există)
          $total_medalii = array_sum($count_medalii);
          if ($total_medalii > 0) :
        ?>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: var(--space-md); margin-top: var(--space-2xl);">
            <?php if ($count_medalii['aur'] > 0) : ?>
              <div class="stat">
                <div class="stat__number" style="color: var(--color-accent);"><?php echo (int) $count_medalii['aur']; ?></div>
                <div class="stat__label">Medalii Aur</div>
              </div>
            <?php endif; ?>
            <?php if ($count_medalii['argint'] > 0) : ?>
              <div class="stat">
                <div class="stat__number"><?php echo (int) $count_medalii['argint']; ?></div>
                <div class="stat__label">Medalii Argint</div>
              </div>
            <?php endif; ?>
            <?php if ($count_medalii['bronz'] > 0) : ?>
              <div class="stat">
                <div class="stat__number"><?php echo (int) $count_medalii['bronz']; ?></div>
                <div class="stat__label">Medalii Bronz</div>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php if (!empty($rezultate)) : ?>
<!-- Palmares personal -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Palmares</div>
      <h2>REZULTATE<br><em>NOTABILE</em></h2>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>An</th>
            <th>Competiție</th>
            <th>Medalie</th>
            <th>Disciplină</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rezultate as $r) : ?>
            <tr>
              <td style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html($r['an'] ?? ''); ?></td>
              <td><?php echo esc_html($r['competitie'] ?? ''); ?></td>
              <td><span class="card__tag" style="margin: 0;"><?php echo esc_html(kokoro_medalie_label($r['medalie'] ?? '')); ?></span></td>
              <td style="color: var(--color-gray);"><?php echo esc_html($r['disciplina'] ?? '—'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Navigare campion anterior/următor -->
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
          <span class="section-label">← Campion anterior</span>
          <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="link" style="display: block; margin-top: var(--space-xs); color: var(--color-white); font-weight: 700;">
            <?php echo esc_html($prev_post->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
      <div style="flex: 1; min-width: 200px; text-align: right;">
        <?php if ($next_post) : ?>
          <span class="section-label">Campion următor →</span>
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
      <h2 style="color: var(--color-bg);">DEVINO URMĂTORUL<br><em>CAMPION KOKORO</em></h2>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg); margin-top: var(--space-xl);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
