<?php
/**
 * Template Name: Formulare
 * Pagina formulare descărcabile — Kokoro Brașov Academy
 *
 * @package Kokoro
 */

if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();

$acf = function_exists('get_field');

$hero_eyebrow  = $acf ? (string) get_field('formulare_hero_eyebrow')  : '';
$hero_titlu    = $acf ? (string) get_field('formulare_hero_titlu')    : '';
$hero_subtitlu = $acf ? (string) get_field('formulare_hero_subtitlu') : '';
$formulare     = $acf ? get_field('formulare_lista')                  : [];
$instructiuni  = $acf ? get_field('formulare_instructiuni')           : [];
$dosar         = $acf ? get_field('formulare_dosar')                  : [];
$cta_titlu     = $acf ? (string) get_field('formulare_cta_titlu')     : '';
$cta_text      = $acf ? (string) get_field('formulare_cta_text')      : '';
$telefon       = kokoro_setting('telefon', '+40 742 037 973');
$wa_numar      = preg_replace('/\D/', '', kokoro_setting('whatsapp_numar', '40742037973'));

if ($hero_eyebrow === '')  $hero_eyebrow  = 'Formulare';
if ($hero_titlu === '')    $hero_titlu    = 'FORMULARE|ÎNSCRIERE';
if ($hero_subtitlu === '') $hero_subtitlu = 'Descarcă, completează și semnează formularele necesare pentru înscriere în Academia Kokoro Brașov.';
if ($cta_titlu === '')     $cta_titlu     = 'AI NEVOIE DE|AJUTOR?';
if ($cta_text === '')      $cta_text      = 'Te ajutăm să completezi corect dosarul. Sună-ne sau scrie-ne pe WhatsApp.';

if (!is_array($formulare) || empty($formulare)) {
    $formulare = [
        ['icon' => '📄', 'titlu' => 'Cerere Înscriere Club Kokoro',  'descriere' => 'Formularul principal de înscriere în club, necesar pentru toți cursanții noi.', 'fisier_url' => 'https://kokoro.ro/Fisa_Inscriere_Kokoro_2018.docx', 'buton_text' => 'Descarcă (.docx)'],
        ['icon' => '🥋', 'titlu' => 'Cerere Legitimare FRAM',        'descriere' => 'Cerere de legitimare ca sportiv la Federația Română de Arte Marțiale.', 'fisier_url' => 'https://kokoro.ro/wp-content/uploads/2013/06/CERERE_INSCRIERE.CLUB_.doc', 'buton_text' => 'Descarcă (.doc)'],
        ['icon' => '🔒', 'titlu' => 'Fișă DGPR (GDPR)',              'descriere' => 'Acordul privind prelucrarea datelor cu caracter personal — obligatoriu la înscriere.', 'fisier_url' => 'https://kokoro.ro/wp-content/uploads/2021/02/fisa-DGPR-KOKORO.docx', 'buton_text' => 'Descarcă (.docx)'],
        ['icon' => '💛', 'titlu' => 'Formular 230 — 3,5% impozit',   'descriere' => 'Direcționează 3,5% din impozitul pe venit către Clubul Sportiv Kokoro Brașov.', 'fisier_url' => 'https://kokoro.ro/formulare/formular_230-kokoro-1/', 'buton_text' => 'Vezi Formularul'],
    ];
}

if (!is_array($instructiuni) || empty($instructiuni)) {
    $instructiuni = [
        ['text' => '<strong>Descarcă</strong> formularele de mai sus (click pe butonul „Descarcă").'],
        ['text' => '<strong>Completează</strong> cu datele tale (sau ale copilului), printează și semnează.'],
        ['text' => '<strong>Pregătește restul dosarului</strong>: adeverință medic familie, copie certificat naștere/CI, 2 poze tip buletin 3/4.'],
        ['text' => '<strong>Contactează-ne</strong> ca să stabilim cum predai formularul.'],
    ];
}

if (!is_array($dosar) || empty($dosar)) {
    $dosar = [
        ['text' => 'Cerere tipizată club'],
        ['text' => 'Formular DGPR'],
        ['text' => 'Adeverință medic familie — clinic sănătos'],
        ['text' => 'Copie xerox certificat de naștere / C.I.'],
        ['text' => '2 poze tip buletin 3/4 (CI / pașaport / carnet de elev)'],
        ['text' => '150 lei taxă înscriere (o singură dată)'],
    ];
}
?>

<section class="page-header">
  <div class="container">
    <div class="section-number"><?php echo esc_html($hero_eyebrow); ?></div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="margin-top: var(--space-lg); max-width: 700px;"><?php echo esc_html($hero_subtitlu); ?></p>
  </div>
  <div class="page-header__number" aria-hidden="true">書</div>
</section>

<section class="section section--dark">
  <div class="container" style="max-width: 900px;">
    <div class="reveal" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-xl);">
      <?php foreach ($formulare as $f) : ?>
        <div style="background: var(--color-bg-card); padding: var(--space-2xl); border-radius: var(--radius-md); border: 1px solid var(--color-gray-dark);">
          <?php if (!empty($f['icon'])) : ?>
            <div style="font-size: 3rem; line-height: 1; margin-bottom: var(--space-md);"><?php echo esc_html($f['icon']); ?></div>
          <?php endif; ?>
          <h3 style="color: var(--color-text); margin-bottom: var(--space-sm);"><?php echo esc_html($f['titlu'] ?? ''); ?></h3>
          <p style="color: var(--color-gray); line-height: 1.7; margin-bottom: var(--space-lg);"><?php echo esc_html($f['descriere'] ?? ''); ?></p>
          <?php if (!empty($f['fisier_url'])) : ?>
            <a href="<?php echo esc_url($f['fisier_url']); ?>" class="btn btn--outline-accent" target="_blank" rel="noopener"><?php echo esc_html($f['buton_text'] ?? 'Descarcă'); ?></a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if (!empty($instructiuni)) : ?>
    <div class="reveal" style="margin-top: var(--space-3xl); padding: var(--space-2xl); background: var(--color-bg-card); border-left: 4px solid var(--color-accent); border-radius: var(--radius-md);">
      <h3 style="color: var(--color-accent); margin-bottom: var(--space-lg);">Cum procedezi</h3>
      <ol style="color: var(--color-text); line-height: 2; padding-left: var(--space-lg);">
        <?php foreach ($instructiuni as $i) : ?>
          <li><?php echo wp_kses_post($i['text'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <?php endif; ?>

    <?php if (!empty($dosar)) : ?>
    <div class="reveal" style="margin-top: var(--space-2xl); padding: var(--space-xl); background: var(--color-primary-dark); border-radius: var(--radius-md);">
      <h3 style="color: var(--color-white); margin-bottom: var(--space-md);">Dosar complet de înscriere</h3>
      <ul style="color: rgba(255,255,255,0.95); line-height: 2; padding-left: var(--space-lg);">
        <?php foreach ($dosar as $d) : ?>
          <li><?php echo esc_html($d['text'] ?? ''); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);"><?php echo kokoro_render_italic_title($cta_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
      <p style="color: var(--color-primary-dark); margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;"><?php echo esc_html($cta_text); ?></p>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/','',$telefon)); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">Sună <?php echo esc_html($telefon); ?></a>
        <?php if ($wa_numar !== '') : ?>
          <a href="https://wa.me/<?php echo esc_attr($wa_numar); ?>" target="_blank" rel="noopener" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">WhatsApp</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
