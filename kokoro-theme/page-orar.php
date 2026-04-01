<?php
/**
 * Template Name: Orar
 * Pagina orar — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<section class="page-header">
  <div class="container">
    <div class="section-number">Orar</div>
    <h1>PROGRAMUL<br><em>ANTRENAMENTELOR</em></h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 600px;">
      Alege grupa și orele care ți se potrivesc. Antrenamentele au loc în sala Kokoro din Brașov.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">修行</div>
</section>

<!-- Legend -->
<section class="section section--alt" style="padding: var(--space-xl) 0;">
  <div class="container">
    <div style="display: flex; gap: var(--space-xl); justify-content: center; flex-wrap: wrap;">
      <div style="display: flex; align-items: center; gap: var(--space-sm);">
        <span class="schedule__group schedule__group--copii">Copii</span>
        <span class="text-sm text-gray">4-12 ani</span>
      </div>
      <div style="display: flex; align-items: center; gap: var(--space-sm);">
        <span class="schedule__group schedule__group--juniori">Juniori</span>
        <span class="text-sm text-gray">13-17 ani</span>
      </div>
      <div style="display: flex; align-items: center; gap: var(--space-sm);">
        <span class="schedule__group schedule__group--adulti">Adulți</span>
        <span class="text-sm text-gray">18+ ani</span>
      </div>
    </div>
  </div>
</section>

<!-- Schedule Table -->
<section class="section section--dark">
  <div class="container">
    <div class="schedule-wrapper reveal">
      <table class="schedule">
        <thead>
          <tr>
            <th>Zi</th>
            <th>Oră</th>
            <th>Disciplină</th>
            <th>Grupă</th>
            <th>Antrenor</th>
          </tr>
        </thead>
        <tbody>
          <!-- Luni -->
          <tr>
            <td rowspan="3" style="font-weight: 700; color: var(--color-white); vertical-align: middle;">LUNI</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>18:00 – 19:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu Competițional</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>

          <!-- Marți -->
          <tr>
            <td rowspan="2" style="font-weight: 700; color: var(--color-white); vertical-align: middle;">MARȚI</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu Contact</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">—</td>
          </tr>
          <tr>
            <td>18:00 – 19:30</td>
            <td>Ju-Jitsu Autoapărare</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>

          <!-- Miercuri -->
          <tr>
            <td rowspan="3" style="font-weight: 700; color: var(--color-white); vertical-align: middle;">MIERCURI</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>18:00 – 19:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu Competițional</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>

          <!-- Joi -->
          <tr>
            <td rowspan="2" style="font-weight: 700; color: var(--color-white); vertical-align: middle;">JOI</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu Contact</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">—</td>
          </tr>
          <tr>
            <td>18:00 – 19:30</td>
            <td>Ju-Jitsu Autoapărare</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>

          <!-- Vineri -->
          <tr>
            <td rowspan="3" style="font-weight: 700; color: var(--color-white); vertical-align: middle;">VINERI</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>18:00 – 19:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>
          <tr>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu Contact</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">Sensei Lucică</td>
          </tr>

          <!-- Sâmbătă -->
          <tr>
            <td style="font-weight: 700; color: var(--color-white);">SÂMBĂTĂ</td>
            <td>10:00 – 12:00</td>
            <td>Personal Training</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
            <td style="color: var(--color-white);">După programare</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-bg-card); border: 1px solid var(--color-gray-dark);">
      <p style="color: var(--color-gray); font-size: 0.9375rem;">
        <strong style="color: var(--color-accent);">Notă:</strong> Programul poate suferi modificări în perioada competițiilor sau vacanțelor. Verifică pagina de Facebook sau contactează-ne pentru confirmarea orelor.
      </p>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">ALEGE <em>GRUPA</em> TA</h2>
      <p style="color: var(--color-bg); opacity: 0.7; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        Prima lecție este gratuită. Vino și descoperă Ju-Jitsu la Kokoro!
      </p>
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
        Înscrie-te Acum
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
