<?php
/**
 * Template Name: Tarife
 * Pagina de tarife — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Tarife</div>
    <h1>INVESTIȚIA ÎN<br><em>PERFORMANȚĂ</em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      Alege pachetul potrivit pentru tine sau copilul tău. Toate abonamentele includ acces la echipament și ghidare personalizată.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">料金</div>
</section>

<section class="section section--dark">
  <div class="container">

    <!-- Pricing Grid -->
    <div class="pricing-grid reveal">

      <?php if (have_rows('tarife_packages')) : ?>
        <?php while (have_rows('tarife_packages')) : the_row(); ?>
          <div class="pricing-card <?php echo get_sub_field('featured') ? 'pricing-card--featured' : ''; ?>">
            <div class="pricing-card__title"><?php echo esc_html(get_sub_field('name')); ?></div>
            <div class="pricing-card__price"><?php echo esc_html(get_sub_field('price')); ?><span style="font-size: 1.5rem;"> lei</span></div>
            <div class="pricing-card__period"><?php echo esc_html(get_sub_field('period')); ?></div>
            <div class="pricing-card__features">
              <?php
                $features = explode("\n", get_sub_field('features'));
                foreach ($features as $feature) :
                  $feature = trim($feature);
                  if ($feature) :
              ?>
                <div class="pricing-card__feature"><?php echo esc_html($feature); ?></div>
              <?php endif; endforeach; ?>
            </div>
            <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn <?php echo get_sub_field('featured') ? 'btn--primary' : 'btn--outline-accent'; ?> btn--block">Înscrie-te</a>
          </div>
        <?php endwhile; ?>

      <?php else : ?>
        <!-- Fallback hardcodat dacă ACF nu e activ -->
        <div class="pricing-card">
          <div class="pricing-card__title">Copii — 2x / săpt.</div>
          <div class="pricing-card__price">300<span style="font-size: 1.5rem;"> lei</span></div>
          <div class="pricing-card__period">/ lună</div>
          <div class="pricing-card__features">
            <div class="pricing-card__feature">2 antrenamente / săptămână</div>
            <div class="pricing-card__feature">Grupe pe vârstă (4-7, 8-12 ani)</div>
            <div class="pricing-card__feature">Ju-Jitsu adaptat vârstei</div>
          </div>
          <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--outline-accent btn--block">Înscrie-te</a>
        </div>
        <div class="pricing-card pricing-card--featured">
          <div class="pricing-card__title">Copii — 3x / săpt.</div>
          <div class="pricing-card__price">350<span style="font-size: 1.5rem;"> lei</span></div>
          <div class="pricing-card__period">/ lună</div>
          <div class="pricing-card__features">
            <div class="pricing-card__feature">3 antrenamente / săptămână</div>
            <div class="pricing-card__feature">Ju-Jitsu competițional + autoapărare</div>
            <div class="pricing-card__feature">Pregătire pentru competiții</div>
          </div>
          <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--block">Înscrie-te</a>
        </div>
        <div class="pricing-card">
          <div class="pricing-card__title">Personal Training</div>
          <div class="pricing-card__price">100<span style="font-size: 1.5rem;"> lei</span></div>
          <div class="pricing-card__period">/ ședință</div>
          <div class="pricing-card__features">
            <div class="pricing-card__feature">1-on-1 cu antrenorul</div>
            <div class="pricing-card__feature">Program personalizat</div>
            <div class="pricing-card__feature">Orar flexibil</div>
          </div>
          <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--outline-accent btn--block">Înscrie-te</a>
        </div>
      <?php endif; ?>

    </div><!-- /.pricing-grid -->

    <!-- Note -->
    <div class="reveal" style="text-align: center; margin-top: var(--space-3xl); padding: var(--space-2xl); background: var(--color-bg-card); border: 1px solid var(--color-gray-dark);">
      <p style="color: var(--color-gray); font-size: 0.9375rem;">
        <strong style="color: var(--color-primary-dark);">Notă:</strong> Prețurile sunt valabile pentru sezonul 2025-2026. Oferte speciale pentru frați și grupe disponibile. Contactează-ne pentru detalii.
      </p>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline btn--small" style="margin-top: var(--space-lg);">
        Solicită Ofertă
      </a>
    </div>

  </div>
</section>

<!-- CTA Section -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">PRIMA LECȚIE<br><em>E GRATUITĂ</em></h2>
      <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        Vino la o lecție demonstrativă gratuită ca să vezi cum decurge un antrenament Kokoro.
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        Programează Lecția Gratuită
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
