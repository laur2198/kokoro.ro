<?php
/**
 * Single Antrenor — pagină dedicată unui antrenor
 *
 * @package Kokoro
 */

get_header();

if (!have_posts()) {
    get_footer();
    return;
}
the_post();

$aid          = get_the_ID();
$rol          = function_exists('get_field') ? (string) get_field('antrenor_rol')          : '';
$bio          = function_exists('get_field') ? (string) get_field('antrenor_bio_scurt')    : '';
$specializare = function_exists('get_field') ? (string) get_field('antrenor_specializare') : '';
$centura      = function_exists('get_field') ? (string) get_field('antrenor_centura')      : '';
$ani          = function_exists('get_field') ? (int)    get_field('antrenor_ani_experienta'): 0;
$email_a      = function_exists('get_field') ? (string) get_field('antrenor_email')        : '';
$telefon_a    = function_exists('get_field') ? (string) get_field('antrenor_telefon')      : '';
$facebook_a   = function_exists('get_field') ? (string) get_field('antrenor_facebook')     : '';
$instagram_a  = function_exists('get_field') ? (string) get_field('antrenor_instagram')    : '';

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

// Antrenamentele coordonate de el (din Orar — match după nume în coloana Antrenor)
$orar_page = kokoro_get_page_by_template('page-orar.php');
$rows_antrenor = [];
if ($orar_page && function_exists('get_field')) {
    $program = get_field('orar_program', $orar_page->ID);
    if (is_array($program)) {
        $name_lower = mb_strtolower(get_the_title($aid), 'UTF-8');
        $first_name = mb_strtolower(strtok(get_the_title($aid), ' '), 'UTF-8'); // primul cuvânt din nume
        foreach ($program as $row) {
            $antr_lower = mb_strtolower($row['antrenor'] ?? '', 'UTF-8');
            if ($antr_lower !== '' && (mb_strpos($antr_lower, $name_lower) !== false || mb_strpos($antr_lower, $first_name) !== false)) {
                $rows_antrenor[] = $row;
            }
        }
        $rows_antrenor = kokoro_sort_program_by_day($rows_antrenor);
    }
}
?>

<section class="page-header">
  <div class="container">
    <a href="<?php echo esc_url(home_url('/antrenori/')); ?>" class="section-number" style="text-decoration: none;">← Toți Antrenorii</a>
    <h1 style="margin-top: var(--space-md);"><?php the_title(); ?></h1>
    <?php if ($rol !== '') : ?>
      <p style="color: var(--color-accent); font-weight: 700; margin-top: var(--space-sm); text-transform: uppercase; letter-spacing: 0.05em;">
        <?php echo esc_html($rol); ?>
      </p>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">先</div>
</section>

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
            <span style="color: var(--color-gray);">Foto antrenor</span>
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
        <?php if ($specializare !== '') : ?>
          <div class="card__tag" style="margin-bottom: var(--space-md);"><?php echo esc_html($specializare); ?></div>
        <?php endif; ?>

        <?php if ($bio !== '') : ?>
          <h2 class="heading-3" style="margin-bottom: var(--space-lg);"><?php echo wp_kses($bio, ['br' => []]); ?></h2>
        <?php endif; ?>

        <?php if (get_the_content()) : ?>
          <div style="color: var(--color-gray); line-height: 1.8;">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

        <!-- Stats / contact -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: var(--space-md); margin-top: var(--space-2xl);">
          <?php if ($ani > 0) : ?>
            <div class="stat">
              <div class="stat__number" style="color: var(--color-accent);"><?php echo (int) $ani; ?>+</div>
              <div class="stat__label">Ani experiență</div>
            </div>
          <?php endif; ?>
          <?php if ($centura_label !== '') : ?>
            <div class="stat">
              <div class="stat__number" style="color: var(--color-white); font-size: 1.5rem;"><?php echo esc_html($centura_label); ?></div>
              <div class="stat__label">Centură</div>
            </div>
          <?php endif; ?>
        </div>

        <!-- Social/contact -->
        <?php if ($email_a || $telefon_a || $facebook_a || $instagram_a) : ?>
          <div style="margin-top: var(--space-2xl); padding-top: var(--space-xl); border-top: 1px solid var(--color-gray-dark);">
            <p style="color: var(--color-gray); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: var(--space-md);">Contact direct</p>
            <div style="display: flex; gap: var(--space-md); flex-wrap: wrap; align-items: center;">
              <?php if ($email_a) : ?>
                <a href="mailto:<?php echo esc_attr(antispambot($email_a)); ?>" class="link"><?php echo esc_html(antispambot($email_a)); ?></a>
              <?php endif; ?>
              <?php if ($telefon_a) : ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $telefon_a)); ?>" class="link"><?php echo esc_html($telefon_a); ?></a>
              <?php endif; ?>
              <?php if ($facebook_a) : ?>
                <a href="<?php echo esc_url($facebook_a); ?>" target="_blank" rel="noopener" class="footer__social-link" aria-label="Facebook">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
              <?php endif; ?>
              <?php if ($instagram_a) : ?>
                <a href="<?php echo esc_url($instagram_a); ?>" target="_blank" rel="noopener" class="footer__social-link" aria-label="Instagram">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php if (!empty($rows_antrenor)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Program</div>
      <h2>ANTRENAMENTELE<br><em>SALE</em></h2>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Zi</th>
            <th>Oră</th>
            <th>Disciplină</th>
            <th>Grupă</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows_antrenor as $row) :
              $grupa_slug   = $row['grupa'] ?? '';
              $grupa_labels = ['copii' => 'Copii', 'juniori' => 'Juniori', 'adulti' => 'Adulți'];
              $grupa_label  = $grupa_labels[$grupa_slug] ?? ucfirst((string) $grupa_slug);
          ?>
            <tr>
              <td style="font-weight: 700; color: var(--color-white);"><?php echo esc_html(mb_strtoupper($row['zi'] ?? '', 'UTF-8')); ?></td>
              <td><?php echo esc_html($row['ora'] ?? ''); ?></td>
              <td><?php echo esc_html($row['disciplina'] ?? ''); ?></td>
              <td>
                <?php if ($grupa_slug !== '') : ?>
                  <span class="schedule__group schedule__group--<?php echo esc_attr($grupa_slug); ?>"><?php echo esc_html($grupa_label); ?></span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php endif; ?>

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
          <span class="section-label">← Antrenor anterior</span>
          <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="link" style="display: block; margin-top: var(--space-xs); color: var(--color-white); font-weight: 700;">
            <?php echo esc_html($prev_post->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
      <div style="flex: 1; min-width: 200px; text-align: right;">
        <?php if ($next_post) : ?>
          <span class="section-label">Antrenor următor →</span>
          <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="link" style="display: block; margin-top: var(--space-xs); color: var(--color-white); font-weight: 700;">
            <?php echo esc_html($next_post->post_title); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">VINO LA O LECȚIE<br><em>DEMONSTRATIVĂ</em></h2>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg); margin-top: var(--space-xl);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
