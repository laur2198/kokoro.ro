<?php
/**
 * Template Name: Tarife
 * Pagina de tarife — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

$hero_titlu    = function_exists('get_field') ? (string) get_field('tarife_hero_titlu')    : '';
$hero_subtitlu = function_exists('get_field') ? (string) get_field('tarife_hero_subtitlu') : '';
$pachete       = function_exists('get_field') ? get_field('tarife_pachete')                : [];
$nota          = function_exists('get_field') ? (string) get_field('tarife_nota')          : '';
$cta_titlu     = function_exists('get_field') ? (string) get_field('tarife_cta_titlu')     : '';
$cta_text      = function_exists('get_field') ? (string) get_field('tarife_cta_text')      : '';
$cta_buton     = function_exists('get_field') ? (string) get_field('tarife_cta_buton')     : '';

if ($hero_titlu === '')    { $hero_titlu    = 'INVESTIȚIA ÎN|PERFORMANȚĂ'; }
if ($hero_subtitlu === '') { $hero_subtitlu = 'Alege pachetul potrivit pentru tine sau copilul tău.'; }
if ($cta_titlu === '')     { $cta_titlu     = 'PRIMA LECȚIE|E GRATUITĂ'; }
if ($cta_buton === '')     { $cta_buton     = 'Programează Lecția Gratuită'; }

$inscriere_url = home_url('/inscriere/');
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Tarife</div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">料金</div>
</section>

<section class="section section--dark">
  <div class="container">

    <?php if (!empty($pachete) && is_array($pachete)) : ?>
      <div class="pricing-grid reveal">
        <?php foreach ($pachete as $p) :
            $titlu       = $p['titlu']      ?? '';
            $pret        = $p['pret']       ?? '';
            $moneda      = $p['moneda']     ?? 'lei';
            $perioada    = $p['perioada']   ?? '';
            $featured    = !empty($p['featured']);
            $beneficii   = $p['beneficii']  ?? [];
            $buton_text  = $p['buton_text'] ?? 'Înscrie-te';
            $buton_url   = $p['buton_url']  ?? '';
            if ($buton_url === '') $buton_url = $inscriere_url;

            $card_class  = 'pricing-card' . ($featured ? ' pricing-card--featured' : '');
            $btn_class   = $featured ? 'btn btn--primary btn--block' : 'btn btn--outline-accent btn--block';
        ?>
          <div class="<?php echo esc_attr($card_class); ?>">
            <div class="pricing-card__title"><?php echo esc_html($titlu); ?></div>
            <div class="pricing-card__price">
              <?php echo esc_html((string) $pret); ?><span style="font-size: 1.5rem;"> <?php echo esc_html($moneda); ?></span>
            </div>
            <?php if ($perioada !== '') : ?>
              <div class="pricing-card__period"><?php echo esc_html($perioada); ?></div>
            <?php endif; ?>

            <?php if (!empty($beneficii) && is_array($beneficii)) : ?>
              <div class="pricing-card__features">
                <?php foreach ($beneficii as $b) : ?>
                  <div class="pricing-card__feature"><?php echo esc_html($b['text'] ?? ''); ?></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <a href="<?php echo esc_url($buton_url); ?>" class="<?php echo esc_attr($btn_class); ?>">
              <?php echo esc_html($buton_text); ?>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="reveal" style="text-align: center; padding: var(--space-3xl) 0;">
        <p style="color: var(--color-gray); max-width: 600px; margin: 0 auto;">
          Încă nu ai adăugat pachete. Editează pagina <strong>Tarife</strong> din admin și completează câmpul <strong>Pachete</strong>.
        </p>
      </div>
    <?php endif; ?>

    <?php if ($nota !== '') : ?>
      <div class="reveal" style="text-align: center; margin-top: var(--space-3xl); padding: var(--space-2xl); background: var(--color-bg-card); border: 1px solid var(--color-gray-dark);">
        <p style="color: var(--color-gray); font-size: 0.9375rem;">
          <strong style="color: var(--color-white);">Notă:</strong> <?php echo esc_html($nota); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline btn--small" style="margin-top: var(--space-lg);">
          Solicită Ofertă
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- CTA Section -->
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
      <a href="<?php echo esc_url($inscriere_url); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        <?php echo esc_html($cta_buton); ?>
      </a>
    </div>
  </div>
</section>

<?php kokoro_render_faq_section(); ?>

<?php get_footer(); ?>
