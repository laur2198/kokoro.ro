<?php
/**
 * Template Name: Campioni
 * Pagina campioni — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu    = function_exists('get_field') ? (string) get_field('campioni_hero_titlu')    : '';
$hero_subtitlu = function_exists('get_field') ? (string) get_field('campioni_hero_subtitlu') : '';
$stats         = function_exists('get_field') ? get_field('campioni_stats')                  : [];
$palmares_note = function_exists('get_field') ? (string) get_field('campioni_palmares_note') : '';

if ($hero_titlu === '') {
    $hero_titlu = 'PERFORMANȚĂ|MONDIALĂ';
}
if ($hero_subtitlu === '') {
    $hero_subtitlu = 'De la înființare, sportivii Kokoro Brașov au cucerit sute de medalii la competiții naționale și internaționale.';
}

[$titlu_primar, $titlu_em] = array_pad(explode('|', $hero_titlu, 2), 2, '');

$featured_q = new WP_Query([
    'post_type'      => 'campion',
    'posts_per_page' => 1,
    'meta_query'     => [
        ['key' => 'campion_is_featured', 'value' => '1'],
    ],
    'post_status'    => 'publish',
]);
$featured = $featured_q->have_posts() ? $featured_q->posts[0] : null;
wp_reset_postdata();

$palmares = kokoro_get_palmares_rows();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Campioni</div>
    <h1><?php echo esc_html($titlu_primar); ?><?php if ($titlu_em !== '') : ?><br><em><?php echo esc_html($titlu_em); ?></em><?php endif; ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">勝利</div>
</section>

<?php if (!empty($stats) && is_array($stats)) : ?>
<!-- Stats Section -->
<section class="section section--accent" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="hero__stats-inner" style="padding: 0; justify-content: space-around;">
      <?php foreach ($stats as $stat) : ?>
        <div class="stat">
          <div class="stat__number" style="color: var(--color-bg);"
               data-counter="<?php echo esc_attr($stat['numar']); ?>"
               <?php if (!empty($stat['sufix'])) : ?>data-suffix="<?php echo esc_attr($stat['sufix']); ?>"<?php endif; ?>>0</div>
          <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;"><?php echo esc_html($stat['label']); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ($featured) :
    $featured_id     = $featured->ID;
    $featured_bio    = function_exists('get_field') ? (string) get_field('campion_bio_scurt', $featured_id) : '';
    $featured_full   = apply_filters('the_content', $featured->post_content);
    $featured_centura = function_exists('get_field') ? (string) get_field('campion_centura', $featured_id) : '';
    $centura_labels  = [
        'alba' => 'Albă', 'galbena' => 'Galbenă', 'portocalie' => 'Portocalie',
        'verde' => 'Verde', 'albastra' => 'Albastră', 'maro' => 'Maro', 'neagra' => 'Neagră',
    ];
    $centura_belts = [
        'alba' => 'white', 'galbena' => 'yellow', 'portocalie' => 'orange',
        'verde' => 'green', 'albastra' => 'blue', 'maro' => 'brown', 'neagra' => 'black',
    ];
    $centura_label = $centura_labels[$featured_centura] ?? '';
    $belt_class    = $centura_belts[$featured_centura]  ?? '';
?>
<!-- Featured Champion -->
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">01 — Campion Featured</div>
      <h2><?php echo esc_html(get_the_title($featured_id)); ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl); align-items: center;" class="reveal">
      <div>
        <?php if (has_post_thumbnail($featured_id)) : ?>
          <?php echo get_the_post_thumbnail($featured_id, 'kokoro-hero', [
              'style' => 'width: 100%; height: 450px; object-fit: cover; display: block;',
              'alt'   => esc_attr(get_the_title($featured_id)),
          ]); ?>
        <?php else : ?>
          <div style="width: 100%; height: 450px; background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); display: flex; align-items: center; justify-content: center;">
            <span style="color: var(--color-gray);">Adaugă o poză la campion</span>
          </div>
        <?php endif; ?>
      </div>
      <div>
        <?php if ($centura_label !== '') : ?>
          <div class="card__tag">Centură <?php echo esc_html($centura_label); ?></div>
        <?php endif; ?>
        <?php if ($featured_bio !== '') : ?>
          <h3 class="heading-3" style="margin: var(--space-lg) 0;"><?php echo wp_kses_post($featured_bio); ?></h3>
        <?php endif; ?>
        <?php if ($featured_full !== '') : ?>
          <div style="color: var(--color-gray); line-height: 1.8; margin-bottom: var(--space-xl);">
            <?php echo $featured_full; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- filtered by the_content ?>
          </div>
        <?php endif; ?>
        <?php if ($featured_centura !== '') : ?>
          <div class="belt-progression" style="margin-bottom: var(--space-lg);">
            <div class="belt belt--<?php echo esc_attr($belt_class); ?>" style="width: 80px; height: 8px;"></div>
            <?php if ($centura_label !== '') : ?>
              <span class="text-sm" style="color: var(--color-white);">Centură <?php echo esc_html($centura_label); ?></span>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($palmares)) : ?>
<!-- Palmares / Results -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number"><?php echo $featured ? '02' : '01'; ?> — Palmares</div>
      <h2>REZULTATE<br><em>NOTABILE</em></h2>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>An</th>
            <th>Competiție</th>
            <th>Rezultat</th>
            <th>Sportiv</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($palmares as $row) : ?>
            <tr>
              <td style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html($row['an']); ?></td>
              <td>
                <?php echo esc_html($row['competitie']); ?>
                <?php if (!empty($row['disciplina'])) : ?>
                  <span class="text-sm text-gray" style="margin-left: var(--space-xs);">· <?php echo esc_html($row['disciplina']); ?></span>
                <?php endif; ?>
              </td>
              <td><span class="card__tag" style="margin: 0;"><?php echo esc_html(kokoro_medalie_label($row['medalie'])); ?></span></td>
              <td style="color: var(--color-white);"><?php echo esc_html($row['sportiv']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($palmares_note !== '') : ?>
      <p style="color: var(--color-gray); text-align: center; margin-top: var(--space-xl); font-size: 0.875rem;">
        <?php echo esc_html($palmares_note); ?>
      </p>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if (empty($palmares) && !$featured) : ?>
<!-- Empty state -->
<section class="section section--alt">
  <div class="container" style="text-align: center;">
    <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
      Încă nu ai adăugat campioni. Mergi în <strong>Campioni → Adaugă Campion Nou</strong> din meniul WP Admin.
    </p>
  </div>
</section>
<?php endif; ?>

<!-- CTA -->
<section class="section section--dark">
  <div class="container" style="text-align: center;">
    <div class="jp-quote reveal">
      <div class="jp-quote__kanji">「勝利」</div>
      <div class="jp-quote__romaji">Shōri</div>
      <div class="jp-quote__translation">Victorie</div>
    </div>

    <div class="reveal" style="margin-top: var(--space-2xl);">
      <h3 class="heading-3">DEVINO URMĂTORUL<br><em>CAMPION KOKORO</em></h3>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large" style="margin-top: var(--space-xl);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
