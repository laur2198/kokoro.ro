<?php
/**
 * Template Name: Cursuri Inițiere
 * Cursuri de inițiere Ju-Jitsu — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Cursuri Inițiere</div>
    <h1>DESCOPERĂ<br><em>JU-JITSU</em></h1>
    <p style="color: rgba(255,255,255,0.8); margin-top: var(--space-lg); max-width: 600px;">
      Cursuri de inițiere pentru copii de la 4 ani, juniori și adulți. Nicio experiență anterioară necesară — prima lecție e gratuită!
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">初</div>
</section>

<!-- Pentru cine -->
<section class="section section--dark">
  <div class="container">
    <div class="grid-2-col">
      <div class="reveal reveal--left">
        <div class="section-number">01 — Pentru Copii</div>
        <h2 style="margin-top: var(--space-md);">GRUPE DE<br><em>INIȚIERE</em></h2>
        <p style="margin-top: var(--space-xl); line-height: 1.8;">
          Kokoro Brașov Academy oferă cursuri de inițiere în Ju-Jitsu pentru copii cu vârsta minimă de 4 ani. Antrenamentele sunt adaptate vârstei și nivelului fiecărui copil.
        </p>
        <p style="margin-top: var(--space-md); line-height: 1.8;">
          Prin joc și exerciții specifice, copiii dezvoltă coordonarea, echilibrul, încrederea în sine și disciplina — calități esențiale atât pe tatami cât și în viață.
        </p>
        <div style="margin-top: var(--space-xl);">
          <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large">Înscrie Copilul</a>
        </div>
      </div>
      <div class="reveal reveal--right">
        <div style="width: 100%; height: 400px; background: var(--color-bg-alt); display: flex; align-items: center; justify-content: center; border: 1px solid var(--color-gray-dark);">
          <span style="color: var(--color-gray);">Foto Cursuri Copii</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Ce învață -->
<section class="section section--accent">
  <div class="container">
    <div class="section__header reveal" style="text-align: center;">
      <div class="section-number">02 — Beneficii</div>
      <h2>CE ÎNVAȚĂ<br><em>COPILUL TĂU</em></h2>
    </div>

    <div class="discipline-grid" style="gap: var(--space-lg);">
      <div class="card reveal reveal-delay-1">
        <div class="card__number">01</div>
        <h4 class="card__title">Disciplină</h4>
        <p class="card__text">Regulile dojo-ului japonez învață respectul, punctualitatea și autocontrolul.</p>
      </div>
      <div class="card reveal reveal-delay-2">
        <div class="card__number">02</div>
        <h4 class="card__title">Încredere</h4>
        <p class="card__text">Fiecare tehnică învățată și fiecare centură câștigată construiesc încrederea în sine.</p>
      </div>
      <div class="card reveal reveal-delay-3">
        <div class="card__number">03</div>
        <h4 class="card__title">Condiție Fizică</h4>
        <p class="card__text">Coordonare, echilibru, forță și flexibilitate — dezvoltate natural prin antrenamente.</p>
      </div>
      <div class="card reveal reveal-delay-4">
        <div class="card__number">04</div>
        <h4 class="card__title">Autoapărare</h4>
        <p class="card__text">Tehnici practice de protecție adaptate vârstei, pentru siguranța copilului.</p>
      </div>
    </div>
  </div>
</section>

<!-- Grupe -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal" style="text-align: center;">
      <div class="section-number">03 — Grupe</div>
      <h2>GRUPELE DE<br><em>INIȚIERE</em></h2>
    </div>

    <div class="pricing-grid reveal">
      <div class="pricing-card">
        <div class="pricing-card__title">Mini Kokoro</div>
        <div class="pricing-card__price" style="font-size: 2.5rem;">4-7 ani</div>
        <div class="pricing-card__period">Grădiniță Ju-Jitsu</div>
        <div class="pricing-card__features">
          <div class="pricing-card__feature">2 antrenamente / săptămână</div>
          <div class="pricing-card__feature">Jocuri educative și motricitate</div>
          <div class="pricing-card__feature">Tehnici de bază adaptate</div>
          <div class="pricing-card__feature">Durata: 45 minute / ședință</div>
        </div>
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--block">Înscrie-te</a>
      </div>

      <div class="pricing-card pricing-card--featured">
        <div class="pricing-card__title">Copii</div>
        <div class="pricing-card__price" style="font-size: 2.5rem;">8-12 ani</div>
        <div class="pricing-card__period">Ju-Jitsu Copii</div>
        <div class="pricing-card__features">
          <div class="pricing-card__feature">2-3 antrenamente / săptămână</div>
          <div class="pricing-card__feature">Tehnici Ju-Jitsu complete</div>
          <div class="pricing-card__feature">Pregătire pentru grade (centuri)</div>
          <div class="pricing-card__feature">Participare competiții</div>
          <div class="pricing-card__feature">Durata: 60 minute / ședință</div>
        </div>
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--block">Înscrie-te</a>
      </div>

      <div class="pricing-card">
        <div class="pricing-card__title">Juniori & Adulți</div>
        <div class="pricing-card__price" style="font-size: 2.5rem;">13+ ani</div>
        <div class="pricing-card__period">Începători</div>
        <div class="pricing-card__features">
          <div class="pricing-card__feature">2-3 antrenamente / săptămână</div>
          <div class="pricing-card__feature">Ju-Jitsu + Autoapărare</div>
          <div class="pricing-card__feature">Pregătire fizică inclusă</div>
          <div class="pricing-card__feature">Durata: 60-90 minute / ședință</div>
        </div>
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--outline-accent btn--block">Înscrie-te</a>
      </div>
    </div>
  </div>
</section>

<!-- Testimonial + CTA -->
<section class="section section--blue">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <blockquote style="border: none; max-width: 700px; margin: 0 auto var(--space-2xl);">
        <p style="font-size: 1.25rem; text-align: center; color: var(--color-white);">
          „Am ales Academia de Ju Jitsu KOKORO Brașov pentru fetița mea de 5 ani și pot spune sincer că a fost una dintre cele mai bune decizii."
        </p>
      </blockquote>
      <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">— Razvan Bineata, Google Review</p>

      <div style="margin-top: var(--space-2xl);">
        <h3 style="color: var(--color-white);">PRIMA LECȚIE E <em>GRATUITĂ</em></h3>
        <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap; margin-top: var(--space-xl);">
          <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--secondary btn--large">Programează Lecția Gratuită</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline-white btn--large">Contactează-ne</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
