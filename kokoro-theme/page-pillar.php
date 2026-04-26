<?php
/**
 * Template Name: Pagină Pilon (SEO)
 *
 * Template generic pentru paginile-pilon SEO (Ju-Jitsu copii, Autoapărare,
 * TRX, Personal Trainer, etc.). Toate secțiunile sunt opționale — apar doar
 * dacă câmpul lor `_titlu` (sau repeater-ul) e completat din admin.
 *
 * Structura urmează ghidul SEO/AI-search master plan: Hero → Intro →
 * Beneficii → Ce învață → Grupe → Cum se desfășoară → Echipament → Preț →
 * Diferențiator → Testimoniale → Instructori → Locație → FAQ → CTA.
 *
 * @package Kokoro
 */

get_header();

if (!have_posts()) { get_footer(); return; }
the_post();

$acf = function_exists('get_field');
$f   = function ($name) use ($acf) { return $acf ? get_field($name) : null; };

// Read all sections
$hero_eyebrow   = (string) $f('pl_hero_eyebrow');
$hero_titlu     = (string) $f('pl_hero_titlu');
$hero_subtitlu  = (string) $f('pl_hero_subtitlu');
$hero_imagine   = (string) $f('pl_hero_imagine');
$hero_btn1_text = (string) $f('pl_hero_btn1_text');
$hero_btn1_url  = (string) $f('pl_hero_btn1_url');
$hero_btn2_text = (string) $f('pl_hero_btn2_text');
$hero_btn2_url  = (string) $f('pl_hero_btn2_url');

$intro_titlu = (string) $f('pl_intro_titlu');
$intro_text  = (string) $f('pl_intro_text');

$benef_titlu = (string) $f('pl_benef_titlu');
$benef       = $f('pl_benef');

$inv_titlu = (string) $f('pl_inv_titlu');
$inv_intro = (string) $f('pl_inv_intro');
$inv       = $f('pl_inv');

$grupe_titlu = (string) $f('pl_grupe_titlu');
$grupe       = $f('pl_grupe');

$desf_titlu   = (string) $f('pl_desf_titlu');
$desf_text    = (string) $f('pl_desf_text');
$desf_imagine = (string) $f('pl_desf_imagine');

$echip_titlu = (string) $f('pl_echip_titlu');
$echip       = $f('pl_echip');

$pret_titlu = (string) $f('pl_pret_titlu');
$pret_text  = (string) $f('pl_pret_text');

$dif_titlu = (string) $f('pl_dif_titlu');
$dif       = $f('pl_dif');

$test_titlu = (string) $f('pl_test_titlu');
$test       = $f('pl_test');

$instr_titlu = (string) $f('pl_instr_titlu');
$instr_limit = (int)    $f('pl_instr_limit');

$loc_titlu = (string) $f('pl_loc_titlu');
$loc_text  = (string) $f('pl_loc_text');

$cta_titlu = (string) $f('pl_cta_titlu');
$cta_text  = (string) $f('pl_cta_text');
$cta_btn   = (string) $f('pl_cta_btn');

// Defaults & fallbacks
if ($hero_btn1_url === '') $hero_btn1_url = home_url('/inscriere/');
if ($hero_btn2_url === '') $hero_btn2_url = 'tel:' . preg_replace('/\s+/', '', kokoro_setting('telefon', ''));
if ($cta_titlu === '')     $cta_titlu     = 'GATA SĂ ÎNCEPI?';
if ($cta_btn === '')       $cta_btn       = 'Înscrie-te Acum';

$page_title    = get_the_title();
$telefon       = kokoro_setting('telefon', '');
$telefon_e164  = $telefon ? preg_replace('/\s+/', '', $telefon) : '';

// Antrenori pentru secțiunea Instructori (dacă activă)
$antrenori = ($instr_limit > 0 && $instr_titlu !== '') ? get_posts([
    'post_type'      => 'antrenor',
    'posts_per_page' => $instr_limit,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]) : [];

// Locație fallback
$loc_text_final = $loc_text !== '' ? $loc_text : kokoro_setting('adresa', '');
$maps_url       = kokoro_setting('maps_url', '');
?>

<!-- ============ HERO ============ -->
<section class="page-header" <?php if ($hero_imagine !== '') : ?>style="background-image: linear-gradient(rgba(13, 33, 55, 0.85), rgba(13, 33, 55, 0.95)), url('<?php echo esc_url($hero_imagine); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
  <div class="container">
    <?php if ($hero_eyebrow !== '') : ?>
      <div class="section-number"><?php echo esc_html($hero_eyebrow); ?></div>
    <?php endif; ?>

    <h1 style="margin-top: var(--space-md);">
      <?php echo $hero_titlu !== ''
          ? kokoro_render_italic_title($hero_titlu, '<br>')
          : esc_html($page_title); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </h1>

    <?php if ($hero_subtitlu !== '') : ?>
      <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 700px; line-height: 1.7; font-size: 1.0625rem;">
        <?php echo esc_html($hero_subtitlu); ?>
      </p>
    <?php endif; ?>

    <div style="display: flex; gap: var(--space-md); flex-wrap: wrap; margin-top: var(--space-2xl); align-items: center;">
      <?php if ($hero_btn1_text !== '') : ?>
        <a href="<?php echo esc_url($hero_btn1_url); ?>" class="btn btn--primary btn--large">
          <?php echo esc_html($hero_btn1_text); ?>
        </a>
      <?php endif; ?>
      <?php if ($hero_btn2_text !== '') : ?>
        <a href="<?php echo esc_url($hero_btn2_url); ?>" class="btn btn--outline btn--large">
          <?php echo esc_html($hero_btn2_text); ?>
        </a>
      <?php endif; ?>
      <?php if ($telefon !== '') : ?>
        <a href="tel:<?php echo esc_attr($telefon_e164); ?>" style="color: var(--color-accent); font-weight: 700; font-size: 1.125rem; margin-left: var(--space-md); white-space: nowrap;">
          📞 <?php echo esc_html($telefon); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ INTRO ============ -->
<?php if ($intro_titlu !== '' || $intro_text !== '') : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <?php if ($intro_titlu !== '') : ?>
      <div class="section__header reveal">
        <h2><?php echo kokoro_render_italic_title($intro_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      </div>
    <?php endif; ?>
    <?php if ($intro_text !== '') : ?>
      <div class="reveal" style="color: var(--color-gray); line-height: 1.9; font-size: 1.0625rem;">
        <?php echo wp_kses_post($intro_text); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ BENEFICII ============ -->
<?php if ($benef_titlu !== '' && !empty($benef) && is_array($benef)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Beneficii</div>
      <h2><?php echo kokoro_render_italic_title($benef_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($benef as $i => $b) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="reveal <?php echo esc_attr($delay); ?>" style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px;">
          <?php if (!empty($b['icon'])) : ?>
            <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);"><?php echo esc_html($b['icon']); ?></div>
          <?php endif; ?>
          <h3 style="font-family: var(--font-heading); font-weight: 700; font-size: 1.25rem; margin-bottom: var(--space-sm);">
            <?php echo esc_html($b['titlu'] ?? ''); ?>
          </h3>
          <?php if (!empty($b['descriere'])) : ?>
            <p style="color: var(--color-gray); line-height: 1.7;"><?php echo esc_html($b['descriere']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ CE ÎNVAȚĂ ============ -->
<?php if ($inv_titlu !== '' && !empty($inv) && is_array($inv)) : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <h2><?php echo kokoro_render_italic_title($inv_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <?php if ($inv_intro !== '') : ?>
        <p style="color: var(--color-gray); margin-top: var(--space-md); line-height: 1.7;">
          <?php echo esc_html($inv_intro); ?>
        </p>
      <?php endif; ?>
    </div>

    <ul class="reveal" style="list-style: none; padding: 0; margin: 0;">
      <?php foreach ($inv as $point) : ?>
        <li style="padding: var(--space-md) 0; border-bottom: 1px solid var(--color-gray-dark); color: var(--color-white); font-size: 1.0625rem; display: flex; align-items: flex-start; gap: var(--space-md);">
          <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900; font-size: 1.25rem; flex-shrink: 0;">▸</span>
          <span><?php echo esc_html($point['text'] ?? ''); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php endif; ?>

<!-- ============ GRUPE DE VÂRSTĂ ============ -->
<?php if ($grupe_titlu !== '' && !empty($grupe) && is_array($grupe)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Grupe</div>
      <h2><?php echo kokoro_render_italic_title($grupe_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($grupe as $i => $g) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="card reveal <?php echo esc_attr($delay); ?>" style="padding: var(--space-2xl);">
          <div class="card__tag"><?php echo esc_html($g['nume'] ?? ''); ?></div>
          <?php if (!empty($g['frecventa'])) : ?>
            <p style="color: var(--color-accent); font-weight: 700; margin: var(--space-md) 0; font-size: 0.9375rem;">
              <?php echo esc_html($g['frecventa']); ?>
            </p>
          <?php endif; ?>
          <?php if (!empty($g['descriere'])) : ?>
            <p style="color: var(--color-gray); line-height: 1.7;"><?php echo esc_html($g['descriere']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ CUM SE DESFĂȘOARĂ ============ -->
<?php if ($desf_titlu !== '' || $desf_text !== '') : ?>
<section class="section section--dark">
  <div class="container">
    <div style="display: grid; grid-template-columns: <?php echo $desf_imagine ? '1fr 1fr' : '1fr'; ?>; gap: var(--space-3xl); align-items: center;" class="reveal">
      <div>
        <?php if ($desf_titlu !== '') : ?>
          <div class="section-number">Antrenament</div>
          <h2 style="margin: var(--space-md) 0 var(--space-xl);">
            <?php echo kokoro_render_italic_title($desf_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </h2>
        <?php endif; ?>
        <?php if ($desf_text !== '') : ?>
          <div style="color: var(--color-gray); line-height: 1.8;">
            <?php echo wp_kses_post($desf_text); ?>
          </div>
        <?php endif; ?>
      </div>
      <?php if ($desf_imagine !== '') : ?>
        <div>
          <img src="<?php echo esc_url($desf_imagine); ?>" alt="<?php echo esc_attr($desf_titlu ?: $page_title); ?>" loading="lazy" style="width: 100%; height: auto; display: block;">
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ ECHIPAMENT ============ -->
<?php if ($echip_titlu !== '' && !empty($echip) && is_array($echip)) : ?>
<section class="section section--alt">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">Echipament</div>
      <h2><?php echo kokoro_render_italic_title($echip_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div class="reveal" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-md);">
      <?php foreach ($echip as $e) : ?>
        <div style="padding: var(--space-md) var(--space-lg); background: var(--color-white); border-radius: 4px; display: flex; align-items: center; gap: var(--space-md);">
          <span aria-hidden="true" style="color: var(--color-accent); font-weight: 900;">✓</span>
          <span><?php echo esc_html($e['text'] ?? ''); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ PREȚURI ============ -->
<?php if ($pret_titlu !== '' || $pret_text !== '') : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <?php if ($pret_titlu !== '') : ?>
      <div class="section__header reveal">
        <div class="section-number">Investiție</div>
        <h2><?php echo kokoro_render_italic_title($pret_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      </div>
    <?php endif; ?>
    <?php if ($pret_text !== '') : ?>
      <div class="reveal" style="color: var(--color-gray); line-height: 1.8; font-size: 1.0625rem;">
        <?php echo wp_kses_post($pret_text); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ DIFERENȚIATOR ============ -->
<?php if ($dif_titlu !== '' && !empty($dif) && is_array($dif)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">De ce noi</div>
      <h2><?php echo kokoro_render_italic_title($dif_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($dif as $i => $d) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="reveal <?php echo esc_attr($delay); ?>" style="padding: var(--space-xl); border: 2px solid var(--color-accent); border-radius: 4px; background: var(--color-white);">
          <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-sm); color: var(--color-bg);">
            <?php echo esc_html($d['titlu'] ?? ''); ?>
          </h3>
          <?php if (!empty($d['descriere'])) : ?>
            <p style="color: var(--color-gray); line-height: 1.7;"><?php echo esc_html($d['descriere']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ TESTIMONIALE ============ -->
<?php if ($test_titlu !== '' && !empty($test) && is_array($test)) : ?>
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Părerile părinților</div>
      <h2><?php echo kokoro_render_italic_title($test_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($test as $i => $t) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="testimonial reveal <?php echo esc_attr($delay); ?>">
          <div class="testimonial__stars">★★★★★</div>
          <p class="testimonial__text"><?php echo esc_html($t['text'] ?? ''); ?></p>
          <div class="testimonial__author"><?php echo esc_html($t['autor'] ?? ''); ?></div>
          <?php if (!empty($t['meta'])) : ?>
            <div class="testimonial__source"><?php echo esc_html($t['meta']); ?></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ INSTRUCTORI ============ -->
<?php if ($instr_titlu !== '' && !empty($antrenori)) : ?>
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">Echipa</div>
      <h2><?php echo kokoro_render_italic_title($instr_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
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
                'loading' => 'lazy',
            ]); ?>
          <?php else : ?>
            <div style="width: 100%; height: 280px; background: var(--color-bg-card); margin-bottom: var(--space-md);"></div>
          <?php endif; ?>
          <h4 style="font-family: var(--font-heading); font-weight: 700; font-size: 1.125rem;"><?php echo esc_html(get_the_title($aid)); ?></h4>
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

<!-- ============ LOCAȚIE ============ -->
<?php if ($loc_titlu !== '') : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">Locație</div>
      <h2><?php echo kokoro_render_italic_title($loc_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <?php if ($loc_text_final !== '') : ?>
      <p class="reveal" style="color: var(--color-gray); line-height: 1.8; font-size: 1.0625rem;">
        <?php echo wp_kses($loc_text_final, ['br' => []]); ?>
      </p>
    <?php endif; ?>

    <?php if ($maps_url !== '') : ?>
      <div class="reveal" style="margin-top: var(--space-xl);">
        <a href="<?php echo esc_url($maps_url); ?>" target="_blank" rel="noopener" class="btn btn--outline-accent">
          Vezi pe Google Maps →
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ FAQ (din câmpul kokoro_faq) ============ -->
<?php kokoro_render_faq_section(); ?>

<!-- ============ CTA FINAL ============ -->
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
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
          <?php echo esc_html($cta_btn); ?>
        </a>
        <?php if ($telefon !== '') : ?>
          <a href="tel:<?php echo esc_attr($telefon_e164); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">
            📞 <?php echo esc_html($telefon); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
