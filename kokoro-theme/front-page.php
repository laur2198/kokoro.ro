<?php
/**
 * Template Name: Front Page
 * Homepage — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

get_header();

// -------------------------------------------------------------------
// Read all ACF fields (front-page). Empty → fall back to defaults in markup.
// -------------------------------------------------------------------
$acf = function_exists('get_field');

$hero_image      = $acf ? (string) get_field('home_hero_imagine')   : '';
$hero_eyebrow    = $acf ? (string) get_field('home_hero_eyebrow')   : '';
$hero_titlu      = $acf ? (string) get_field('home_hero_titlu')     : '';
$hero_subtitlu   = $acf ? (string) get_field('home_hero_subtitlu')  : '';
$hero_btn1_text  = $acf ? (string) get_field('home_hero_btn1_text') : '';
$hero_btn1_url   = $acf ? (string) get_field('home_hero_btn1_url')  : '';
$hero_btn2_text  = $acf ? (string) get_field('home_hero_btn2_text') : '';
$hero_btn2_url   = $acf ? (string) get_field('home_hero_btn2_url')  : '';
$hero_stats      = $acf ? get_field('home_hero_stats')              : [];
$marquee_items   = $acf ? get_field('home_marquee')                 : [];
$disc_eyebrow    = $acf ? (string) get_field('home_disc_eyebrow')   : '';
$disc_titlu      = $acf ? (string) get_field('home_disc_titlu')     : '';
$disc_limit      = $acf ? (int)    get_field('home_disc_limit')     : 4;
if ($disc_limit < 1) $disc_limit = 4;

// Valori
$valori_eyebrow  = $acf ? (string) get_field('home_valori_eyebrow')  : '';
$valori_titlu    = $acf ? (string) get_field('home_valori_titlu')    : '';
$valori_subtitlu = $acf ? (string) get_field('home_valori_subtitlu') : '';
$valori          = $acf ? get_field('home_valori')                   : [];

// Campioni preview
$camp_eyebrow    = $acf ? (string) get_field('home_camp_eyebrow')    : '';
$camp_titlu      = $acf ? (string) get_field('home_camp_titlu')      : '';
$camp_subtitlu   = $acf ? (string) get_field('home_camp_subtitlu')   : '';
$camp_text       = $acf ? (string) get_field('home_camp_text')       : '';
$camp_stats      = $acf ? get_field('home_camp_stats')               : [];
$camp_cta        = $acf ? (string) get_field('home_camp_cta')        : '';

// Testimoniale
$test_eyebrow      = $acf ? (string) get_field('home_test_eyebrow')       : '';
$test_titlu        = $acf ? (string) get_field('home_test_titlu')         : '';
$test_rating       = $acf ? (string) get_field('home_test_rating')        : '';
$test_rating_label = $acf ? (string) get_field('home_test_rating_label')  : '';
$testimoniale      = $acf ? get_field('home_test')                        : [];

// Orar preview
$orar_eyebrow = $acf ? (string) get_field('home_orar_eyebrow') : '';
$orar_titlu   = $acf ? (string) get_field('home_orar_titlu')   : '';
$orar_limit   = $acf ? (int)    get_field('home_orar_limit')   : 10;
$orar_cta     = $acf ? (string) get_field('home_orar_cta')     : '';
if ($orar_limit < 1) $orar_limit = 10;

// CTA înscriere
$cta_eyebrow   = $acf ? (string) get_field('home_cta_eyebrow')   : '';
$cta_titlu     = $acf ? (string) get_field('home_cta_titlu')     : '';
$cta_text      = $acf ? (string) get_field('home_cta_text')      : '';
$cta_btn1_text = $acf ? (string) get_field('home_cta_btn1_text') : '';
$cta_btn1_url  = $acf ? (string) get_field('home_cta_btn1_url')  : '';
$cta_btn2_text = $acf ? (string) get_field('home_cta_btn2_text') : '';
$cta_btn2_url  = $acf ? (string) get_field('home_cta_btn2_url')  : '';

// JP Quote
$jp_kanji     = $acf ? (string) get_field('home_jp_kanji')     : '';
$jp_romaji    = $acf ? (string) get_field('home_jp_romaji')    : '';
$jp_traducere = $acf ? (string) get_field('home_jp_traducere') : '';

// Fallbacks (first-run, când ACF n-are date)
if ($hero_image === '')     $hero_image     = KOKORO_URI . '/assets/images/hero-placeholder.jpg';
if ($hero_eyebrow === '')   $hero_eyebrow   = '01 — Academia';
if ($hero_titlu === '')     $hero_titlu     = 'DEVINO|CAMPION|LA KOKORO';
if ($hero_subtitlu === '')  $hero_subtitlu  = 'Ju-Jitsu pentru copii, juniori și adulți din 2008. Academie recunoscută MTS și FRAM, cu campioni mondiali în palmares.';
if ($hero_btn1_text === '') $hero_btn1_text = 'Înscrie-te Acum';
if ($hero_btn2_text === '') $hero_btn2_text = 'Descoperă Disciplinele';
if ($hero_btn1_url === '')  $hero_btn1_url  = home_url('/inscriere/');
if ($hero_btn2_url === '')  $hero_btn2_url  = home_url('/discipline/');
if ($disc_eyebrow === '')   $disc_eyebrow   = '02 — Discipline';
if ($disc_titlu === '')     $disc_titlu     = 'CE|ANTRENĂM';

if ($valori_eyebrow === '')  $valori_eyebrow  = '03 — Filozofie';
if ($valori_titlu === '')    $valori_titlu    = 'CALEA|KOKORO';
if ($valori_subtitlu === '') $valori_subtitlu = '„Kokoro" (心) înseamnă Inimă, Spirit, Minte în limba japoneză. Aceste trei principii ne ghidează pe tatami și în viață.';

if ($camp_eyebrow === '')    $camp_eyebrow    = '04 — Campioni';
if ($camp_titlu === '')      $camp_titlu      = 'PERFORMANȚĂ|MONDIALĂ';
if ($camp_subtitlu === '')   $camp_subtitlu   = 'REZULTATE DE|EXCEPȚIE';
if ($camp_text === '')       $camp_text       = 'De la înființarea în 2008, sportivii Kokoro au câștigat sute de medalii la competiții naționale și internaționale. Academiei noastre i-au fost recunoscute meritele de către Ministerul Tineretului și Sportului și Federația Română de Arte Marțiale.';
if ($camp_cta === '')        $camp_cta        = 'Vezi Toți Campionii';

if (!is_array($valori) || empty($valori)) {
    $valori = [
        ['kanji' => '礼',     'romaji' => 'Rei',     'meaning' => 'Respect — Începi cu respect, termini cu respect. Fundamentul oricărei arte marțiale.'],
        ['kanji' => '精神',   'romaji' => 'Seishin', 'meaning' => 'Spirit — Determinarea mentală care transformă efortul în performanță.'],
        ['kanji' => '修行',   'romaji' => 'Shugyo',  'meaning' => 'Disciplina Căii — Antrenamentul constant care formează caracterul și corpul.'],
    ];
}
if (!is_array($camp_stats) || empty($camp_stats)) {
    $camp_stats = [
        ['numar' => 200, 'sufix' => '+', 'label' => 'Medalii'],
        ['numar' => 3,   'sufix' => '',  'label' => 'Campioni Mondiali'],
        ['numar' => 50,  'sufix' => '+', 'label' => 'Medalii Internaționale'],
        ['numar' => 100, 'sufix' => '+', 'label' => 'Medalii Naționale'],
    ];
}

if ($test_eyebrow === '')      $test_eyebrow      = '05 — Recenzii';
if ($test_titlu === '')        $test_titlu        = 'CE SPUN|DESPRE NOI';
if ($test_rating === '')       $test_rating       = '4.8';
if ($test_rating_label === '') $test_rating_label = '96 recenzii Google';

if (!is_array($testimoniale) || empty($testimoniale)) {
    $testimoniale = [
        ['text' => '„Am ales Academia de Ju Jitsu KOKORO Brașov pentru fetița mea de 5 ani și pot spune sincer că a fost una dintre cele mai bune decizii."',                                                                                              'autor' => 'Razvan Bineata',        'sursa' => 'Google Review'],
        ['text' => '„Recomand cu toată încrederea Kokoro Brașov Academy Ju-Jitsu, un loc unde profesionalismul, disciplina și pasiunea pentru acest sport sunt duse la cel mai înalt nivel."',                                                         'autor' => 'Romina Moldovanu',       'sursa' => 'Google Review'],
        ['text' => '„Onoare, Iubire, Datorie... iată ce fiul meu învață, iată ce eu simt... Academia Kokoro Brașov!"',                                                                                                                                 'autor' => 'Eugen-Alexandru Roșca',  'sursa' => 'Google Review'],
        ['text' => '„FELICITĂRI Sensei Lucică, FELICITĂRI sportiviilor KOKORO, BRAVO grupului + familiei KOKORO! Bravo Lucică pentru munca depusă și rezultatele obținute."',                                                                          'autor' => 'Corysan Club Sportiv',   'sursa' => 'Facebook'],
        ['text' => '„Recomand cu toată inima Kokoro Brașov Academy! Fiul meu a început să practice Ju Jitsu la acest club de la 4 ani și jumătate, iar acum, la 12 ani, pot spune că a fost cea mai bună decizie."',                                   'autor' => 'Antonela Stan',          'sursa' => 'Google Review'],
        ['text' => '„Am făcut cea mai bună alegere de a-mi înscrie fetița la acest club... recomand tuturor părinților... este sănătate, sport și disciplină."',                                                                                       'autor' => 'Cristina Ratiu',         'sursa' => 'Facebook'],
    ];
}

if ($orar_eyebrow === '') $orar_eyebrow = '06 — Program';
if ($orar_titlu === '')   $orar_titlu   = 'ORARUL|ANTRENAMENTELOR';
if ($orar_cta === '')     $orar_cta     = 'Vezi Orarul Complet';

// Trage primele N rânduri din pagina Orar (dacă există)
$orar_page = kokoro_get_page_by_template('page-orar.php');
$orar_rows = [];
if ($orar_page && $acf) {
    $program = get_field('orar_program', $orar_page->ID);
    if (is_array($program)) {
        $program_sorted = kokoro_sort_program_by_day($program);
        $orar_rows      = array_slice($program_sorted, 0, $orar_limit);
    }
}
// Fallback când nu e configurat încă Orar
$orar_fallback = [
    ['zi' => 'Luni',     'ora' => '17:00 – 18:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'copii'],
    ['zi' => 'Luni',     'ora' => '18:00 – 19:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'juniori'],
    ['zi' => 'Luni',     'ora' => '19:00 – 20:30', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'adulti'],
    ['zi' => 'Marți',    'ora' => '17:00 – 18:00', 'disciplina' => 'Ju-Jitsu Autoapărare', 'grupa' => 'adulti'],
    ['zi' => 'Miercuri', 'ora' => '17:00 – 18:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'copii'],
    ['zi' => 'Miercuri', 'ora' => '18:00 – 19:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'juniori'],
    ['zi' => 'Miercuri', 'ora' => '19:00 – 20:30', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'adulti'],
    ['zi' => 'Vineri',   'ora' => '17:00 – 18:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'copii'],
    ['zi' => 'Vineri',   'ora' => '18:00 – 19:00', 'disciplina' => 'Ju-Jitsu',         'grupa' => 'juniori'],
    ['zi' => 'Vineri',   'ora' => '19:00 – 20:30', 'disciplina' => 'TRX + Ju-Jitsu',   'grupa' => 'adulti'],
];
if (empty($orar_rows)) {
    $orar_rows = array_slice($orar_fallback, 0, $orar_limit);
}

if ($cta_eyebrow === '')   $cta_eyebrow   = '07 — Început';
if ($cta_titlu === '')     $cta_titlu     = 'ÎNCEPE|CĂLĂTORIA';
if ($cta_text === '')      $cta_text      = 'Nu contează vârsta, nivelul de experiență sau condiția fizică. Contează să faci primul pas. Înscrierile sunt deschise pentru toate grupele.';
if ($cta_btn1_text === '') $cta_btn1_text = 'Înscrie-te Acum';
if ($cta_btn2_text === '') $cta_btn2_text = 'Contactează-ne';
if ($cta_btn1_url === '')  $cta_btn1_url  = home_url('/inscriere/');
if ($cta_btn2_url === '')  $cta_btn2_url  = home_url('/contact/');

if ($jp_kanji === '')     $jp_kanji     = '「継続は力なり」';
if ($jp_romaji === '')    $jp_romaji    = 'Keizoku wa chikara nari';
if ($jp_traducere === '') $jp_traducere = 'Perseverența este forță';

// Featured champion — din CPT `campion` cu flag `campion_is_featured`
$featured_q = new WP_Query([
    'post_type'      => 'campion',
    'posts_per_page' => 1,
    'meta_query'     => [
        ['key' => 'campion_is_featured', 'value' => '1'],
    ],
    'post_status'    => 'publish',
]);
$home_featured = $featured_q->have_posts() ? $featured_q->posts[0] : null;
wp_reset_postdata();

if (!is_array($hero_stats) || empty($hero_stats)) {
    $hero_stats = [
        ['numar' => 17,  'sufix' => '+', 'label' => 'Ani de activitate'],
        ['numar' => 200, 'sufix' => '+', 'label' => 'Medalii câștigate'],
        ['numar' => 3,   'sufix' => '',  'label' => 'Campioni mondiali'],
        ['numar' => 500, 'sufix' => '+', 'label' => 'Sportivi formați'],
    ];
}
if (!is_array($marquee_items) || empty($marquee_items)) {
    $marquee_items = array_map(fn($t) => ['text' => $t], [
        'Campioni Mondiali Ju-Jitsu',
        'Fondată în 2008',
        'Recunoscută MTS & FRAM',
        'Copii, Juniori & Adulți',
        '4.8★ pe Google — 96 recenzii',
        'Brașov, România',
        'Spirit, Minte, Trup',
        '柔よく剛を制す — Blândețea controlează duritatea',
    ]);
}

// Query discipline CPT (for preview cards)
$discipline_cpt = get_posts([
    'post_type'      => 'disciplina',
    'posts_per_page' => $disc_limit,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);
// Fallback când nu există încă CPT-uri — folosim cele 4 carduri hardcodate originale
$discipline_fallback = [
    ['titlu' => 'Ju-Jitsu|Competițional', 'teaser' => 'Fighting, Ne-Waza, Duo System',              'url' => home_url('/ju-jitsu-competitional/')],
    ['titlu' => 'Ju-Jitsu|Autoapărare',   'teaser' => 'Tehnici practice de self-defense',           'url' => home_url('/autoaparare/')],
    ['titlu' => 'TRX|Suspension',         'teaser' => 'Antrenament funcțional cu greutatea corpului', 'url' => home_url('/trx-suspension-training/')],
    ['titlu' => 'Personal|Training',      'teaser' => 'Preparare fizică individualizată',           'url' => home_url('/preparator-fizic/')],
];
?>

<!-- ============================================================
     SECTION 1: HERO
     ============================================================ -->
<section class="hero section--dark">
  <div class="hero__bg" style="background-image: url('<?php echo esc_url($hero_image); ?>');"></div>

  <!-- Kanji Watermark 心 -->
  <div class="kanji-watermark kanji-watermark--hero" aria-hidden="true">心</div>

  <!-- Shoji Pattern Overlay -->
  <div class="shoji-pattern" aria-hidden="true"></div>

  <div class="hero__content">
    <div class="section-number reveal"><?php echo esc_html($hero_eyebrow); ?></div>

    <h1 class="hero__headline reveal">
      <?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </h1>

    <p class="hero__subtitle reveal">
      <?php echo esc_html($hero_subtitlu); ?>
    </p>

    <div class="hero__cta reveal">
      <a href="<?php echo esc_url($hero_btn1_url); ?>" class="btn btn--primary btn--large">
        <?php echo esc_html($hero_btn1_text); ?>
      </a>
      <a href="<?php echo esc_url($hero_btn2_url); ?>" class="btn btn--outline btn--large">
        <?php echo esc_html($hero_btn2_text); ?>
      </a>
    </div>
  </div>

  <!-- Stats Bar -->
  <div class="hero__stats">
    <div class="hero__stats-inner">
      <?php foreach ($hero_stats as $stat) : ?>
        <div class="stat">
          <div class="stat__number"
               data-counter="<?php echo esc_attr($stat['numar'] ?? 0); ?>"
               <?php if (!empty($stat['sufix'])) : ?>data-suffix="<?php echo esc_attr($stat['sufix']); ?>"<?php endif; ?>>0</div>
          <div class="stat__label"><?php echo esc_html($stat['label'] ?? ''); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 2: MARQUEE TICKER
     ============================================================ -->
<div class="marquee">
  <div class="marquee__track">
    <?php foreach ($marquee_items as $item) : ?>
      <span class="marquee__item"><?php echo esc_html($item['text'] ?? ''); ?></span>
    <?php endforeach; ?>
  </div>
</div>

<!-- ============================================================
     SECTION 3: DISCIPLINE
     ============================================================ -->
<section class="section section--alt" id="discipline">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number"><?php echo esc_html($disc_eyebrow); ?></div>
      <h2><?php echo kokoro_render_italic_title($disc_titlu, ' '); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <div class="discipline-grid">
      <?php if (!empty($discipline_cpt)) : ?>
        <?php foreach ($discipline_cpt as $i => $d) :
            $did           = $d->ID;
            $titlu_home    = $acf ? (string) get_field('disciplina_titlu_home', $did)    : '';
            $teaser_home   = $acf ? (string) get_field('disciplina_teaser_home', $did)   : '';
            $desc_scurta   = $acf ? (string) get_field('disciplina_descriere_scurta', $did) : '';
            $link_custom   = $acf ? (string) get_field('disciplina_link', $did)          : '';
            $card_url      = $link_custom !== '' ? $link_custom : get_permalink($did);
            $numar         = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
            $delay_class   = 'reveal-delay-' . min($i + 1, 4);

            $card_titlu    = $titlu_home !== '' ? $titlu_home : get_the_title($did);
            $card_sub      = $teaser_home !== '' ? $teaser_home : wp_trim_words($desc_scurta, 8, '…');
        ?>
          <a href="<?php echo esc_url($card_url); ?>" class="discipline-card reveal <?php echo esc_attr($delay_class); ?>">
            <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
            <div class="discipline-card__content">
              <div class="discipline-card__number"><?php echo esc_html($numar); ?></div>
              <h3 class="discipline-card__title"><?php echo kokoro_render_italic_title($card_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
              <?php if ($card_sub !== '') : ?>
                <p class="discipline-card__subtitle"><?php echo esc_html($card_sub); ?></p>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      <?php else : ?>
        <?php foreach ($discipline_fallback as $i => $d) :
            $numar       = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
            $delay_class = 'reveal-delay-' . ($i + 1);
        ?>
          <a href="<?php echo esc_url($d['url']); ?>" class="discipline-card reveal <?php echo esc_attr($delay_class); ?>">
            <div class="discipline-card__bg" style="background-color: var(--color-bg-card);"></div>
            <div class="discipline-card__content">
              <div class="discipline-card__number"><?php echo esc_html($numar); ?></div>
              <h3 class="discipline-card__title"><?php echo kokoro_render_italic_title($d['titlu'], '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
              <p class="discipline-card__subtitle"><?php echo esc_html($d['teaser']); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 4: ABOUT / VALORI JAPONEZE
     ============================================================ -->
<section class="section section--accent" id="despre">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number" style="color: var(--color-bg);"><?php echo esc_html($valori_eyebrow); ?></div>
      <h2 style="color: var(--color-bg);">
        <?php echo kokoro_render_italic_title($valori_titlu, ' '); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </h2>
      <?php if ($valori_subtitlu !== '') : ?>
        <p style="color: var(--color-bg); opacity: 0.7; max-width: 600px; margin-top: var(--space-lg);">
          <?php echo esc_html($valori_subtitlu); ?>
        </p>
      <?php endif; ?>
    </div>

    <div class="values-grid">
      <?php foreach ($valori as $i => $v) :
          $delay = 'reveal-delay-' . min($i + 1, 4);
      ?>
        <div class="value-item reveal <?php echo esc_attr($delay); ?>">
          <div class="value-item__kanji"  style="color: var(--color-bg);"><?php echo esc_html($v['kanji']  ?? ''); ?></div>
          <div class="value-item__romaji" style="color: var(--color-bg);"><?php echo esc_html($v['romaji'] ?? ''); ?></div>
          <?php if (!empty($v['meaning'])) : ?>
            <p class="value-item__meaning" style="color: var(--color-bg); opacity: 0.7;"><?php echo esc_html($v['meaning']); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 5: CAMPIONI
     ============================================================ -->
<section class="section section--dark" id="campioni">
  <!-- Kanji Watermark -->
  <div class="kanji-watermark kanji-watermark--section" aria-hidden="true">勝利</div>

  <div class="container">
    <div class="section__header reveal">
      <div class="section-number"><?php echo esc_html($camp_eyebrow); ?></div>
      <h2><?php echo kokoro_render_italic_title($camp_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
    </div>

    <!-- Featured Champion -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-3xl); align-items: center; margin-bottom: var(--space-4xl);">
      <div class="reveal reveal--left">
        <div class="card" style="border-color: var(--color-accent);">
          <?php if ($home_featured) :
              $fid       = $home_featured->ID;
              $f_title   = get_the_title($fid);
              $f_bio     = $acf ? (string) get_field('campion_bio_scurt', $fid) : '';
              $f_centura = $acf ? (string) get_field('campion_centura', $fid) : '';
              $centura_label_map = [
                  'alba' => 'Albă', 'galbena' => 'Galbenă', 'portocalie' => 'Portocalie',
                  'verde' => 'Verde', 'albastra' => 'Albastră', 'maro' => 'Maro', 'neagra' => 'Neagră',
              ];
              $f_centura_label = $centura_label_map[$f_centura] ?? '';
          ?>
            <?php if (has_post_thumbnail($fid)) : ?>
              <?php echo get_the_post_thumbnail($fid, 'kokoro-square', [
                  'style' => 'width: 100%; height: 350px; object-fit: cover; display: block; margin-bottom: var(--space-xl);',
                  'alt'   => esc_attr($f_title),
              ]); ?>
            <?php else : ?>
              <div style="width: 100%; height: 350px; background: var(--color-bg-alt); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-xl);">
                <span style="color: var(--color-gray);">Foto <?php echo esc_html($f_title); ?></span>
              </div>
            <?php endif; ?>
            <?php if ($f_centura_label !== '') : ?>
              <div class="card__tag">Centură <?php echo esc_html($f_centura_label); ?></div>
            <?php endif; ?>
            <h3 class="card__title"><?php echo esc_html($f_title); ?></h3>
            <?php if ($f_bio !== '') : ?>
              <p class="card__text"><?php echo wp_kses_post($f_bio); ?></p>
            <?php endif; ?>
          <?php else : ?>
            <!-- Fallback static când nu există încă vreun campion featured -->
            <div style="width: 100%; height: 350px; background: var(--color-bg-alt); display: flex; align-items: center; justify-content: center; margin-bottom: var(--space-xl);">
              <span style="color: var(--color-gray);">Foto Campion Featured</span>
            </div>
            <div class="card__tag">Campion Mondial</div>
            <h3 class="card__title">Adrian Bogluț</h3>
            <p class="card__text">Campion mondial Ju-Jitsu — mândria Kokoro Brașov Academy și dovada vie că antrenamentul dedicat duce la rezultate de excepție.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="reveal reveal--right">
        <h3 class="heading-3" style="margin-bottom: var(--space-xl);">
          <?php echo kokoro_render_italic_title($camp_subtitlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </h3>
        <?php if ($camp_text !== '') : ?>
          <p style="color: var(--color-gray); margin-bottom: var(--space-2xl); line-height: 1.8;">
            <?php echo esc_html($camp_text); ?>
          </p>
        <?php endif; ?>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-lg);">
          <?php foreach ($camp_stats as $s) : ?>
            <div class="stat">
              <div class="stat__number"
                   data-counter="<?php echo esc_attr($s['numar'] ?? 0); ?>"
                   <?php if (!empty($s['sufix'])) : ?>data-suffix="<?php echo esc_attr($s['sufix']); ?>"<?php endif; ?>>0</div>
              <div class="stat__label"><?php echo esc_html($s['label'] ?? ''); ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <?php if ($camp_cta !== '') : ?>
      <div style="text-align: center;" class="reveal">
        <a href="<?php echo esc_url(home_url('/campioni/')); ?>" class="btn btn--outline-accent">
          <?php echo esc_html($camp_cta); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ============================================================
     SECTION 6: TESTIMONIALE
     ============================================================ -->
<section class="section section--alt" id="testimoniale">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number"><?php echo esc_html($test_eyebrow); ?></div>
      <h2><?php echo kokoro_render_italic_title($test_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <?php if ($test_rating !== '' || $test_rating_label !== '') : ?>
        <div class="testimonial__badge" style="margin-top: var(--space-lg);">
          <?php if ($test_rating !== '') : ?><span><?php echo esc_html($test_rating); ?></span><?php endif; ?>
          <span style="font-size: 1rem; color: var(--color-accent);">★★★★★</span>
          <?php if ($test_rating_label !== '') : ?>
            <span style="font-size: 0.875rem; color: var(--color-gray); font-weight: 400;"><?php echo esc_html($test_rating_label); ?></span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="testimonial-grid">
      <?php foreach ($testimoniale as $i => $t) :
          $delay = 'reveal-delay-' . min($i + 1, 6);
      ?>
        <div class="testimonial reveal <?php echo esc_attr($delay); ?>">
          <div class="testimonial__stars">★★★★★</div>
          <?php if (!empty($t['text'])) : ?>
            <p class="testimonial__text"><?php echo esc_html($t['text']); ?></p>
          <?php endif; ?>
          <?php if (!empty($t['autor'])) : ?>
            <div class="testimonial__author"><?php echo esc_html($t['autor']); ?></div>
          <?php endif; ?>
          <?php if (!empty($t['sursa'])) : ?>
            <div class="testimonial__source"><?php echo esc_html($t['sursa']); ?></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============================================================
     SECTION 7: ORAR (Preview)
     ============================================================ -->
<section class="section section--dark" id="orar">
  <div class="container">
    <div class="section__header reveal">
      <div class="section-number"><?php echo esc_html($orar_eyebrow); ?></div>
      <h2><?php echo kokoro_render_italic_title($orar_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
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
          <?php foreach ($orar_rows as $row) :
              $grupa_slug   = $row['grupa'] ?? '';
              $grupa_labels = ['copii' => 'Copii', 'juniori' => 'Juniori', 'adulti' => 'Adulți'];
              $grupa_label  = $grupa_labels[$grupa_slug] ?? ucfirst((string) $grupa_slug);
          ?>
            <tr>
              <td><?php echo esc_html($row['zi']         ?? ''); ?></td>
              <td><?php echo esc_html($row['ora']        ?? ''); ?></td>
              <td><?php echo esc_html($row['disciplina'] ?? ''); ?></td>
              <td>
                <?php if ($grupa_slug !== '') : ?>
                  <span class="schedule__group schedule__group--<?php echo esc_attr($grupa_slug); ?>">
                    <?php echo esc_html($grupa_label); ?>
                  </span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php if ($orar_cta !== '') : ?>
      <div style="text-align: center; margin-top: var(--space-2xl);" class="reveal">
        <a href="<?php echo esc_url(home_url('/orar/')); ?>" class="btn btn--outline-accent">
          <?php echo esc_html($orar_cta); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ============================================================
     SECTION 8: CTA ÎNSCRIERE
     ============================================================ -->
<section class="section section--accent" id="inscriere">
  <!-- Kanji watermark -->
  <div class="kanji-watermark kanji-watermark--section" style="opacity: 0.05; color: var(--color-bg);" aria-hidden="true">力</div>

  <div class="container" style="text-align: center;">
    <div class="reveal">
      <div class="section-number" style="color: var(--color-bg);"><?php echo esc_html($cta_eyebrow); ?></div>
      <h2 style="color: var(--color-bg); margin-bottom: var(--space-lg);">
        <?php echo kokoro_render_italic_title($cta_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </h2>
      <?php if ($cta_text !== '') : ?>
        <p style="color: var(--color-bg); opacity: 0.7; max-width: 600px; margin: 0 auto var(--space-2xl);">
          <?php echo esc_html($cta_text); ?>
        </p>
      <?php endif; ?>

      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <?php if ($cta_btn1_text !== '') : ?>
          <a href="<?php echo esc_url($cta_btn1_url); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
            <?php echo esc_html($cta_btn1_text); ?>
          </a>
        <?php endif; ?>
        <?php if ($cta_btn2_text !== '') : ?>
          <a href="<?php echo esc_url($cta_btn2_url); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">
            <?php echo esc_html($cta_btn2_text); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     JAPANESE QUOTE (pre-footer)
     ============================================================ -->
<?php if ($jp_kanji !== '' || $jp_romaji !== '' || $jp_traducere !== '') : ?>
<section class="section section--dark">
  <div class="container">
    <div class="jp-quote reveal">
      <?php if ($jp_kanji !== '')     : ?><div class="jp-quote__kanji"><?php       echo esc_html($jp_kanji);     ?></div><?php endif; ?>
      <?php if ($jp_romaji !== '')    : ?><div class="jp-quote__romaji"><?php      echo esc_html($jp_romaji);    ?></div><?php endif; ?>
      <?php if ($jp_traducere !== '') : ?><div class="jp-quote__translation"><?php echo esc_html($jp_traducere); ?></div><?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
