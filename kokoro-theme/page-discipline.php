<?php
/**
 * Template Name: Discipline
 * Pagina discipline — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Discipline</div>
    <h1>ARTA <em>LUPTEI</em><br>NOBILE</h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      De la Ju-Jitsu competițional la autoapărare și pregătire fizică — descoperă disciplinele Kokoro Brașov Academy.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">柔術</div>
</section>

<!-- Japanese Quote -->
<section class="section section--alt" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="jp-quote">
      <div class="jp-quote__kanji">「柔よく剛を制す」</div>
      <div class="jp-quote__romaji">Ju yoku go wo seisu</div>
      <div class="jp-quote__translation">Blândețea controlează duritatea — filozofia Ju-Jitsu</div>
    </div>
  </div>
</section>

<!-- Discipline Grid -->
<section class="section section--dark">
  <div class="container">
    <div class="discipline-grid" style="gap: var(--space-lg);">

      <!-- 01: Ju-Jitsu Competițional -->
      <a href="<?php echo esc_url(home_url('/ju-jitsu-competitional/')); ?>" class="discipline-card reveal reveal-delay-1" style="min-height: 400px;">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">01</div>
          <h3 class="discipline-card__title">Ju-Jitsu Competițional</h3>
          <p class="discipline-card__subtitle">
            Disciplina noastră de bază — Fighting, Ne-Waza (sol) și Duo System.
            Pregătire pentru competiții naționale și internaționale.
            Grupe: copii, juniori, adulți.
          </p>
          <span class="btn btn--outline-accent btn--small" style="margin-top: var(--space-lg); display: inline-flex;">Află Mai Mult</span>
        </div>
      </a>

      <!-- 02: Autoapărare -->
      <a href="<?php echo esc_url(home_url('/autoaparare/')); ?>" class="discipline-card reveal reveal-delay-2" style="min-height: 400px;">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">02</div>
          <h3 class="discipline-card__title">Ju-Jitsu Autoapărare</h3>
          <p class="discipline-card__subtitle">
            Tehnici practice de self-defense pentru situații reale.
            Potrivit pentru femei, oameni de afaceri, și oricine vrea să se simtă în siguranță.
          </p>
          <span class="btn btn--outline-accent btn--small" style="margin-top: var(--space-lg); display: inline-flex;">Află Mai Mult</span>
        </div>
      </a>

      <!-- 03: TRX -->
      <a href="<?php echo esc_url(home_url('/trx-suspension-training/')); ?>" class="discipline-card reveal reveal-delay-3" style="min-height: 400px;">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">03</div>
          <h3 class="discipline-card__title">TRX Suspension Training</h3>
          <p class="discipline-card__subtitle">
            Antrenament funcțional cu greutatea propriului corp.
            Dezvoltă forța, echilibrul și rezistența — complement perfect pentru Ju-Jitsu.
          </p>
          <span class="btn btn--outline-accent btn--small" style="margin-top: var(--space-lg); display: inline-flex;">Află Mai Mult</span>
        </div>
      </a>

      <!-- 04: Personal Training -->
      <a href="<?php echo esc_url(home_url('/preparator-fizic/')); ?>" class="discipline-card reveal reveal-delay-4" style="min-height: 400px;">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">04</div>
          <h3 class="discipline-card__title">Personal Training</h3>
          <p class="discipline-card__subtitle">
            Pregătire fizică individualizată — program personalizat pentru obiectivele tale,
            de la slăbit la performanță sportivă.
          </p>
          <span class="btn btn--outline-accent btn--small" style="margin-top: var(--space-lg); display: inline-flex;">Află Mai Mult</span>
        </div>
      </a>

    </div>
  </div>
</section>

<!-- Belt Progression -->
<section class="section section--alt">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <div class="section-number">Progresie</div>
      <h2 style="margin-bottom: var(--space-2xl);">SISTEMUL DE <em>CENTURI</em></h2>

      <div class="belt-progression" style="justify-content: center; gap: var(--space-md); flex-wrap: wrap;">
        <div style="text-align: center;">
          <div class="belt belt--white" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Albă</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--yellow" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Galbenă</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--orange" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Portocalie</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--green" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Verde</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--blue" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Albastră</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--brown" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Maro</span>
        </div>
        <div style="text-align: center;">
          <div class="belt belt--black" style="width: 60px; height: 8px; margin: 0 auto var(--space-xs);"></div>
          <span class="text-xs text-gray">Neagră</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">ALEGE <em>DISCIPLINA</em><br>TA</h2>
      <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        Nu știi ce ți se potrivește? Vino la o lecție demonstrativă gratuită și descoperă!
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        Programează Lecția Gratuită
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
