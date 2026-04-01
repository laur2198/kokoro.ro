<?php
/**
 * Template Name: Campioni
 * Pagina campioni — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Campioni</div>
    <h1>PERFORMANȚĂ<br><em>MONDIALĂ</em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      De la înființare, sportivii Kokoro Brașov au cucerit sute de medalii la competiții naționale și internaționale.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">勝利</div>
</section>

<!-- Stats Section -->
<section class="section section--accent" style="padding: var(--space-2xl) 0;">
  <div class="container">
    <div class="hero__stats-inner" style="padding: 0; justify-content: space-around;">
      <div class="stat">
        <div class="stat__number" style="color: var(--color-bg);" data-counter="3">0</div>
        <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;">Campioni Mondiali</div>
      </div>
      <div class="stat">
        <div class="stat__number" style="color: var(--color-bg);" data-counter="200" data-suffix="+">0</div>
        <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;">Medalii Totale</div>
      </div>
      <div class="stat">
        <div class="stat__number" style="color: var(--color-bg);" data-counter="50" data-suffix="+">0</div>
        <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;">Medalii Internaționale</div>
      </div>
      <div class="stat">
        <div class="stat__number" style="color: var(--color-bg);" data-counter="17" data-suffix="+">0</div>
        <div class="stat__label" style="color: var(--color-bg); opacity: 0.7;">Ani de Competiții</div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Champion -->
<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">01 — Campion Mondial</div>
      <h2>ADRIAN <em>BOGLUȚ</em></h2>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl); align-items: center;" class="reveal">
      <div>
        <div style="width: 100%; height: 450px; background: var(--color-bg-card); border: 1px solid var(--color-gray-dark); display: flex; align-items: center; justify-content: center;">
          <span style="color: var(--color-gray);">Foto Adrian Bogluț — Campion Mondial</span>
        </div>
      </div>
      <div>
        <div class="card__tag">Campion Mondial Ju-Jitsu</div>
        <h3 class="heading-3" style="margin: var(--space-lg) 0;">MÂNDRIA<br><em>KOKORO</em></h3>
        <p style="color: var(--color-gray); line-height: 1.8; margin-bottom: var(--space-xl);">
          Adrian Bogluț este cel mai titrat sportiv al academiei Kokoro Brașov. Campion mondial la Ju-Jitsu, el este dovada vie că munca, disciplina și spiritul Kokoro duc la cele mai înalte performanțe.
        </p>
        <div class="belt-progression" style="margin-bottom: var(--space-lg);">
          <div class="belt belt--black" style="width: 80px; height: 8px;"></div>
          <span class="text-sm" style="color: var(--color-white);">Centură Neagră</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Palmares / Results -->
<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">02 — Palmares</div>
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
          <tr>
            <td style="color: var(--color-accent); font-weight: 700;">2024</td>
            <td>Campionatul Mondial Ju-Jitsu</td>
            <td><span class="card__tag" style="margin: 0;">Aur</span></td>
            <td style="color: var(--color-white);">Adrian Bogluț</td>
          </tr>
          <tr>
            <td style="color: var(--color-accent); font-weight: 700;">2024</td>
            <td>Campionatul Național Ju-Jitsu</td>
            <td><span class="card__tag" style="margin: 0;">Multiple medalii</span></td>
            <td style="color: var(--color-white);">Echipa Kokoro</td>
          </tr>
          <tr>
            <td style="color: var(--color-accent); font-weight: 700;">2023</td>
            <td>Campionatul European Ju-Jitsu</td>
            <td><span class="card__tag" style="margin: 0;">Argint</span></td>
            <td style="color: var(--color-white);">Adrian Bogluț</td>
          </tr>
          <tr>
            <td style="color: var(--color-accent); font-weight: 700;">2023</td>
            <td>Campionatul Național Ju-Jitsu</td>
            <td><span class="card__tag" style="margin: 0;">Aur</span></td>
            <td style="color: var(--color-white);">Echipa Kokoro</td>
          </tr>
          <tr>
            <td style="color: var(--color-accent); font-weight: 700;">2022</td>
            <td>Cupa României Ju-Jitsu</td>
            <td><span class="card__tag" style="margin: 0;">Multiple medalii</span></td>
            <td style="color: var(--color-white);">Echipa Kokoro</td>
          </tr>
        </tbody>
      </table>
    </div>

    <p style="color: var(--color-gray); text-align: center; margin-top: var(--space-xl); font-size: 0.875rem;">
      Tabelul include doar o selecție a rezultatelor. Palmaresul complet este disponibil la cerere.
    </p>
  </div>
</section>

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

<?php get_footer(); ?>
