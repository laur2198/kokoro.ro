<?php
/**
 * Template Name: Front Page
 * Homepage — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();
?>

<!-- ============================================================
     SECTION 1: HERO
     ============================================================ -->
<section class="hero section--blue">
  <div class="hero__bg" style="background-image: url('<?php echo esc_url(KOKORO_URI . '/assets/images/hero-placeholder.jpg'); ?>');"></div>

  <!-- Kanji Watermark 心 -->
  <div class="kanji-watermark kanji-watermark--hero" aria-hidden="true">心</div>

  <!-- Shoji Pattern Overlay -->
  <div class="shoji-pattern" aria-hidden="true"></div>

  <div class="hero__content">
    <div class="section-number reveal">01 — Academia</div>

    <h1 class="hero__headline reveal">
      DEVINO<br>
      <em>CAMPION</em><br>
      LA KOKORO
    </h1>

    <p class="hero__subtitle reveal">
      Ju-Jitsu pentru copii, juniori și adulți din 2008. Academie recunoscută MTS și FRAM, cu campioni mondiali în palmares.
    </p>

    <div class="hero__cta reveal">
      <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large">
        Înscrie-te Acum
      </a>
      <a href="<?php echo esc_url(home_url('/discipline/')); ?>" class="btn btn--outline-white btn--large">
        Descoperă Disciplinele
      </a>
    </div>
  </div>

</section>

<!-- ============================================================
     SECTION 2: MARQUEE TICKER
     ============================================================ -->
<div class="marquee">
  <div class="marquee__track">
    <span class="marquee__item">Campioni Mondiali Ju-Jitsu</span>
    <span class="marquee__item">Fondată în 2008</span>
    <span class="marquee__item">Recunoscută MTS & FRAM</span>
    <span class="marquee__item">Copii, Juniori & Adulți</span>
    <span class="marquee__item">4.8★ pe Google — 96 recenzii</span>
    <span class="marquee__item">Brașov, România</span>
    <span class="marquee__item">Spirit, Minte, Trup</span>
    <span class="marquee__item">柔よく剛を制す — Blândețea controlează duritatea</span>
  </div>
</div>

<!-- ============================================================
     SECTION 3: DISCIPLINE
     ============================================================ -->
<section class="section section--alt" id="discipline">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">02 — Discipline</div>
      <h2>CE <em>ANTRENĂM</em></h2>
    </div>

    <div class="discipline-grid">
      <!-- Ju-Jitsu Competițional -->
      <a href="<?php echo esc_url(home_url('/ju-jitsu-competitional/')); ?>" class="discipline-card reveal reveal-delay-1">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">01</div>
          <h3 class="discipline-card__title">Ju-Jitsu<br>Competițional</h3>
          <p class="discipline-card__subtitle">Fighting, Ne-Waza, Duo System</p>
        </div>
      </a>

      <!-- Autoapărare -->
      <a href="<?php echo esc_url(home_url('/autoaparare/')); ?>" class="discipline-card reveal reveal-delay-2">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">02</div>
          <h3 class="discipline-card__title">Ju-Jitsu<br>Autoapărare</h3>
          <p class="discipline-card__subtitle">Tehnici practice de self-defense</p>
        </div>
      </a>

      <!-- Ju-Jitsu Contact -->
      <a href="<?php echo esc_url(home_url('/ju-jitsu-contact/')); ?>" class="discipline-card reveal reveal-delay-3">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">03</div>
          <h3 class="discipline-card__title">Ju-Jitsu<br>Contact</h3>
          <p class="discipline-card__subtitle">Probă de competiție full-contact — bronz mondial 2025</p>
        </div>
      </a>

      <!-- Personal Training -->
      <a href="<?php echo esc_url(home_url('/preparator-fizic/')); ?>" class="discipline-card reveal reveal-delay-4">
        <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
        <div class="discipline-card__content">
          <div class="discipline-card__number">04</div>
          <h3 class="discipline-card__title">Personal<br>Training</h3>
          <p class="discipline-card__subtitle">Preparare fizică individualizată</p>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4: ABOUT / VALORI JAPONEZE
     ============================================================ -->
<section class="section section--accent" id="despre">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">03 — Filozofie</div>
      <h2>CALEA <em>KOKORO</em></h2>
      <p style="max-width: 600px; margin-top: var(--space-lg);">
        „Kokoro" (心) înseamnă Inimă, Spirit, Minte în limba japoneză. Aceste trei principii ne ghidează pe tatami și în viață.
      </p>
    </div>

    <div class="values-grid">
      <!-- Rei -->
      <div class="value-item reveal reveal-delay-1">
        <div class="value-item__kanji">礼</div>
        <div class="value-item__romaji">Rei</div>
        <p class="value-item__meaning">Respect — Începi cu respect, termini cu respect. Fundamentul oricărei arte marțiale.</p>
      </div>

      <!-- Seishin -->
      <div class="value-item reveal reveal-delay-2">
        <div class="value-item__kanji">精神</div>
        <div class="value-item__romaji">Seishin</div>
        <p class="value-item__meaning">Spirit — Determinarea mentală care transformă efortul în performanță.</p>
      </div>

      <!-- Shugyo -->
      <div class="value-item reveal reveal-delay-3">
        <div class="value-item__kanji">修行</div>
        <div class="value-item__romaji">Shugyo</div>
        <p class="value-item__meaning">Disciplina Căii — Antrenamentul constant care formează caracterul și corpul.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5: CAMPIONI
     ============================================================ -->
<section class="section section--dark" id="campioni">
  <!-- section--dark is now white bg -->
  <!-- Kanji Watermark -->
  <div class="kanji-watermark kanji-watermark--section" aria-hidden="true">勝利</div>

  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">04 — Campioni</div>
      <h2>PERFORMANȚĂ<br><em>MONDIALĂ</em></h2>
    </div>

    <!-- Featured Champion -->
    <div class="grid-2-col" style="margin-bottom: var(--space-4xl);">
      <div class="reveal reveal--left">
        <div class="card" style="border-color: var(--color-primary);">
          <div style="width: 100%; height: 350px; background: var(--color-bg-alt); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-xl);">
            <span style="color: var(--color-gray);">Foto Adrian Bogluț</span>
          </div>
          <div class="card__tag">Campion Mondial</div>
          <h3 class="card__title">Adrian Bogluț</h3>
          <p class="card__text">Campion mondial Ju-Jitsu — mândria Kokoro Brașov Academy și dovada vie că antrenamentul dedicat duce la rezultate de excepție.</p>
        </div>
      </div>

      <div class="reveal reveal--right">
        <h3 class="heading-3" style="margin-bottom: var(--space-xl);">REZULTATE DE<br><em>EXCEPȚIE</em></h3>
        <p style="color: var(--color-gray); margin-bottom: var(--space-lg); line-height: 1.8;">
          De la înființarea în 2008, sportivii Kokoro au câștigat sute de medalii la competiții naționale și internaționale. Adrian Bogluț a scris istorie — primul român medaliat la Ju-Jitsu Contact la un Campionat Mondial.
        </p>
        <p style="color: var(--color-gray); margin-bottom: var(--space-2xl); line-height: 1.8;">
          Academiei noastre i-au fost recunoscute meritele de către Ministerul Tineretului și Sportului și Federația Română de Arte Marțiale.
        </p>
        <div class="grid-2-col--stats" style="margin-top: var(--space-2xl);">
          <div class="stat">
            <div class="stat__number" data-counter="17" data-suffix="+">0</div>
            <div class="stat__label">Ani de activitate</div>
          </div>
          <div class="stat">
            <div class="stat__number" data-counter="200" data-suffix="+">0</div>
            <div class="stat__label">Medalii câștigate</div>
          </div>
          <div class="stat">
            <div class="stat__number" data-counter="3">0</div>
            <div class="stat__label">Campioni mondiali</div>
          </div>
          <div class="stat">
            <div class="stat__number" data-counter="500" data-suffix="+">0</div>
            <div class="stat__label">Sportivi formați</div>
          </div>
        </div>
        <a href="<?php echo esc_url(home_url('/campioni/')); ?>" class="btn btn--outline-accent" style="margin-top: var(--space-2xl);">Vezi Toți Campionii</a>
      </div>
    </div>

  </div>
</section>

<!-- ============================================================
     SECTION 6: TESTIMONIALE
     ============================================================ -->
<section class="section section--alt" id="testimoniale">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">05 — Recenzii</div>
      <h2>CE SPUN<br><em>DESPRE NOI</em></h2>
      <div class="testimonial__badge" style="margin-top: var(--space-lg);">
        <span>4.8</span>
        <span style="font-size: 1rem; color: var(--color-accent);">★★★★★</span>
        <span style="font-size: 0.875rem; color: var(--color-gray); font-weight: 400;">96 recenzii Google</span>
      </div>
    </div>

    <div class="testimonial-grid">

      <!-- Review 1 -->
      <div class="testimonial reveal reveal-delay-1">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „Am ales Academia de Ju Jitsu KOKORO Brașov pentru fetița mea de 5 ani și pot spune sincer că a fost una dintre cele mai bune decizii."
        </p>
        <div class="testimonial__author">Razvan Bineata</div>
        <div class="testimonial__source">Google Review</div>
      </div>

      <!-- Review 2 -->
      <div class="testimonial reveal reveal-delay-2">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „Recomand cu toată încrederea Kokoro Brașov Academy Ju-Jitsu, un loc unde profesionalismul, disciplina și pasiunea pentru acest sport sunt duse la cel mai înalt nivel."
        </p>
        <div class="testimonial__author">Romina Moldovanu</div>
        <div class="testimonial__source">Google Review</div>
      </div>

      <!-- Review 3 -->
      <div class="testimonial reveal reveal-delay-3">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „Onoare, Iubire, Datorie... iată ce fiul meu învață, iată ce eu simt... Academia Kokoro Brașov!"
        </p>
        <div class="testimonial__author">Eugen-Alexandru Roșca</div>
        <div class="testimonial__source">Google Review</div>
      </div>

      <!-- Review 4 - Facebook -->
      <div class="testimonial reveal reveal-delay-4">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „FELICITĂRI Sensei Lucică, FELICITĂRI sportiviilor KOKORO, BRAVO grupului + familiei KOKORO! Bravo Lucică pentru munca depusă și rezultatele obținute."
        </p>
        <div class="testimonial__author">Corysan Club Sportiv</div>
        <div class="testimonial__source">Facebook</div>
      </div>

      <!-- Review 5 -->
      <div class="testimonial reveal reveal-delay-5">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „Recomand cu toată inima Kokoro Brașov Academy! Fiul meu a început să practice Ju Jitsu la acest club de la 4 ani și jumătate, iar acum, la 12 ani, pot spune că a fost cea mai bună decizie."
        </p>
        <div class="testimonial__author">Antonela Stan</div>
        <div class="testimonial__source">Google Review</div>
      </div>

      <!-- Review 6 -->
      <div class="testimonial reveal reveal-delay-6">
        <div class="testimonial__stars">★★★★★</div>
        <p class="testimonial__text">
          „Am făcut cea mai bună alegere de a-mi înscrie fetița la acest club... recomand tuturor părinților... este sănătate, sport și disciplină."
        </p>
        <div class="testimonial__author">Cristina Ratiu</div>
        <div class="testimonial__source">Facebook</div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7: ORAR (Preview)
     ============================================================ -->
<section class="section section--blue" id="orar">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number">06 — Program</div>
      <h2>ORARUL<br><em>ANTRENAMENTELOR</em></h2>
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
          <tr>
            <td>Luni</td>
            <td>16:00 – 17:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
          </tr>
          <tr>
            <td>Luni</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
          </tr>
          <tr>
            <td>Luni</td>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
          </tr>
          <tr>
            <td>Marți</td>
            <td>16:00 – 17:00</td>
            <td>Ju-Jitsu Autoapărare</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
          </tr>
          <tr>
            <td>Miercuri</td>
            <td>16:00 – 17:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
          </tr>
          <tr>
            <td>Miercuri</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
          </tr>
          <tr>
            <td>Miercuri</td>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
          </tr>
          <tr>
            <td>Vineri</td>
            <td>16:00 – 17:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--copii">Copii</span></td>
          </tr>
          <tr>
            <td>Vineri</td>
            <td>17:00 – 18:00</td>
            <td>Ju-Jitsu</td>
            <td><span class="schedule__group schedule__group--juniori">Juniori</span></td>
          </tr>
          <tr>
            <td>Vineri</td>
            <td>19:00 – 20:30</td>
            <td>Ju-Jitsu Contact</td>
            <td><span class="schedule__group schedule__group--adulti">Adulți</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="text-align: center; margin-top: var(--space-2xl);" class="reveal">
      <a href="<?php echo esc_url(home_url('/orar/')); ?>" class="btn btn--outline-accent">
        Vezi Orarul Complet
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 8: CTA ÎNSCRIERE
     ============================================================ -->
<section class="section section--accent" id="inscriere">
  <!-- Kanji watermark -->
  <div class="kanji-watermark kanji-watermark--section" style="opacity: 0.05;" aria-hidden="true">力</div>

  <div class="container" style="text-align: center;">
    <div class="reveal">
      <div class="section-number">07 — Început</div>
      <h2 style="margin-bottom: var(--space-lg);">
        ÎNCEPE<br><em>CĂLĂTORIA</em>
      </h2>
      <p style="max-width: 600px; margin: 0 auto var(--space-2xl);">
        Nu contează vârsta, nivelul de experiență sau condiția fizică. Contează să faci primul pas. Înscrierile sunt deschise pentru toate grupele.
      </p>

      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large">
          Înscrie-te Acum
        </a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-primary-dark); color: var(--color-primary-dark);">
          Contactează-ne
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     JAPANESE QUOTE (pre-footer)
     ============================================================ -->
<section class="section section--blue">
  <div class="container">
    <div class="jp-quote reveal">
      <div class="jp-quote__kanji">「継続は力なり」</div>
      <div class="jp-quote__romaji">Keizoku wa chikara nari</div>
      <div class="jp-quote__translation">Perseverența este forță</div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
