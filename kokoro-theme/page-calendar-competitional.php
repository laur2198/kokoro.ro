<?php
/**
 * Template Name: Calendar Competițional
 * Calendar competiții — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Calendar</div>
    <h1>CALENDAR<br><em>COMPETIȚIONAL</em></h1>
    <p style="color: rgba(255,255,255,0.8); margin-top: var(--space-lg); max-width: 600px;">
      Competițiile la care participă sportivii Kokoro Brașov în sezonul 2025-2026.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">戦</div>
</section>

<section class="section section--dark">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">2026</div>
      <h2>COMPETIȚII<br><em>INTERNAȚIONALE</em></h2>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Dată</th>
            <th>Competiție</th>
            <th>Locație</th>
            <th>Disciplină</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Ianuarie 2026</td>
            <td>Open Genova</td>
            <td>Genova, Italia</td>
            <td><span class="card__tag" style="margin: 0;">Ju-Jitsu</span></td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Martie 2026</td>
            <td>Campionatul European</td>
            <td>Creta, Grecia</td>
            <td><span class="card__tag" style="margin: 0;">Ju-Jitsu</span></td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Mai 2026</td>
            <td>Paris Open</td>
            <td>Paris, Franța</td>
            <td><span class="card__tag" style="margin: 0;">Ju-Jitsu</span></td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Noiembrie 2026</td>
            <td>Campionatul Mondial</td>
            <td>Antalya, Turcia</td>
            <td><span class="card__tag" style="margin: 0;">Ju-Jitsu</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">2026</div>
      <h2>COMPETIȚII<br><em>NAȚIONALE</em></h2>
    </div>

    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Dată</th>
            <th>Competiție</th>
            <th>Locație</th>
            <th>Categorii</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Februarie 2026</td>
            <td>Campionatul Național — Ne-Waza</td>
            <td>România</td>
            <td>Copii, Juniori, Adulți</td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Aprilie 2026</td>
            <td>Cupa României</td>
            <td>România</td>
            <td>Copii, Juniori, Adulți</td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Iunie 2026</td>
            <td>Campionatul Național — Fighting</td>
            <td>România</td>
            <td>Juniori, Adulți</td>
          </tr>
          <tr>
            <td style="color: var(--color-primary); font-weight: 700;">Octombrie 2026</td>
            <td>Campionatul Național — Ju-Jitsu Contact</td>
            <td>România</td>
            <td>Adulți</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-white); border: 1px solid var(--color-gray-dark);">
      <p style="color: var(--color-gray); font-size: 0.9375rem;">
        <strong style="color: var(--color-primary-dark);">Notă:</strong> Calendarul poate suferi modificări de la federație. Urmărește pagina noastră de Facebook pentru actualizări în timp real.
      </p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section section--blue">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2>VREI SĂ<br><em>CONCUREZI?</em></h2>
      <p style="color: rgba(255,255,255,0.8); max-width: 500px; margin: var(--space-lg) auto var(--space-2xl);">
        Pregătim sportivi pentru competiții de la nivel local la mondial. Înscrie-te și antrenează-te cu campioni!
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--secondary btn--large">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
