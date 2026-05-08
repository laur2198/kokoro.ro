<?php
/**
 * Template Name: FAQ — Întrebări Frecvente
 *
 * Pagina FAQ — populată din ACF (faq_categorii repeater).
 * Fallback: dacă nu există date în ACF, afișează un mesaj că trebuie populat.
 *
 * @package Kokoro
 */

if (!defined('ABSPATH')) { exit; } // Prevent direct access
get_header();

$acf = function_exists('get_field');

$hero_eyebrow  = $acf ? (string) get_field('faq_hero_eyebrow')  : '';
$hero_titlu    = $acf ? (string) get_field('faq_hero_titlu')    : '';
$hero_subtitlu = $acf ? (string) get_field('faq_hero_subtitlu') : '';
$intro         = $acf ? (string) get_field('faq_intro')         : '';
$categorii     = $acf ? get_field('faq_categorii')              : [];

$telefon  = kokoro_setting('telefon', '0742 037 973');
$email    = kokoro_setting('email',   'contact@kokoro.ro');

if ($hero_eyebrow === '')  $hero_eyebrow  = 'FAQ · Întrebări Frecvente';
if ($hero_titlu === '')    $hero_titlu    = 'ÎNTREBĂRI|FRECVENTE';
if ($hero_subtitlu === '') $hero_subtitlu = 'Răspunsuri scurte și directe la întrebările pe care le-am primit cel mai des în ultimii ani.';

if (!is_array($categorii)) $categorii = [];

// Build JSON-LD FAQ schema
$schema_qa = [];
foreach ($categorii as $cat) {
    foreach (($cat['intrebari'] ?? []) as $qa) {
        $schema_qa[] = [
            '@type' => 'Question',
            'name'  => wp_strip_all_tags($qa['q'] ?? ''),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => wp_strip_all_tags($qa['a'] ?? ''),
            ],
        ];
    }
}
?>

<!-- main wrapper provided by header.php -->

<!-- HERO -->
<section class="page-header">
  <div class="container">
    <div class="section-number"><?php echo esc_html($hero_eyebrow); ?></div>
    <h1><?php echo kokoro_render_italic_title($hero_titlu, '<br>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h1>
    <p style="margin-top: var(--space-lg); max-width: 750px; line-height: 1.7; font-size: 1.0625rem;">
      <?php echo wp_kses_post($hero_subtitlu); ?>
      Dacă nu găsiți răspunsul aici, sunați la <a href="tel:<?php echo esc_attr(preg_replace('/\s+/','',$telefon)); ?>" style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html($telefon); ?></a>
      sau scrieți la <a href="mailto:<?php echo esc_attr(antispambot($email)); ?>" style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html(antispambot($email)); ?></a>.
    </p>

    <?php if (!empty($categorii)) : ?>
    <div style="display: flex; gap: var(--space-md); flex-wrap: wrap; margin-top: var(--space-2xl); align-items: center;">
      <?php foreach ($categorii as $cat) :
        $slug = $cat['slug'] ?? '';
        $titlu_short = $cat['titlu'] ?? '';
        if ($slug === '' || $titlu_short === '') continue;
      ?>
        <a href="#<?php echo esc_attr($slug); ?>" class="btn btn--outline btn--small"><?php echo esc_html($titlu_short); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">問</div>
</section>

<?php if ($intro !== '') : ?>
<section class="section section--alt">
  <div class="container container--narrow">
    <div class="reveal" style="line-height: 1.9; font-size: 1.0625rem;">
      <?php echo wp_kses_post($intro); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($categorii)) : ?>
  <?php foreach ($categorii as $idx => $cat) :
    $slug    = $cat['slug']    ?? 'cat-' . ($idx + 1);
    $eyebrow = $cat['eyebrow'] ?? sprintf('%02d — Categorie', $idx + 1);
    $titlu   = $cat['titlu']   ?? '';
    $intrebari = $cat['intrebari'] ?? [];
    if (empty($intrebari)) continue;
    // Alternating bg
    $bg_class = ($idx % 2 === 0) ? 'section--alt' : 'section--blue';
  ?>
  <section id="<?php echo esc_attr($slug); ?>" class="section <?php echo esc_attr($bg_class); ?>">
    <div class="container container--narrow">
      <div class="section__header reveal">
        <div class="section-number"><?php echo esc_html($eyebrow); ?></div>
        <h2><?php echo esc_html($titlu); ?></h2>
      </div>

      <div class="reveal" style="display: flex; flex-direction: column; gap: var(--space-xl); margin-top: var(--space-xl);">
        <?php foreach ($intrebari as $qa) :
          $q = $qa['q'] ?? '';
          $a = $qa['a'] ?? '';
          if ($q === '') continue;
        ?>
          <article style="padding: var(--space-xl); background: var(--color-white); border-left: 4px solid var(--color-accent); border-radius: 4px; color: var(--color-text);">
            <h3 style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; margin-bottom: var(--space-md); color: var(--color-text);">
              <?php echo esc_html($q); ?>
            </h3>
            <div style="line-height: 1.7; color: var(--color-gray);">
              <?php echo wp_kses_post($a); ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endforeach; ?>

  <!-- JSON-LD FAQ schema -->
  <?php if (!empty($schema_qa)) : ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": <?php echo wp_json_encode($schema_qa, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    }
    </script>
  <?php endif; ?>

<?php else : ?>
  <section class="section section--alt">
    <div class="container container--narrow" style="text-align: center;">
      <p style="color: var(--color-gray); padding: var(--space-3xl) 0;">
        FAQ-ul nu a fost încă populat. Editează pagina <strong>FAQ</strong> din admin → câmpul <strong>Categorii și Întrebări</strong>.
      </p>
    </div>
  </section>
<?php endif; ?>

<!-- CTA -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);">NU AI GĂSIT<br><em>RĂSPUNSUL?</em></h2>
      <p style="color: #0D47A1; margin: var(--space-lg) auto var(--space-2xl); max-width: 500px;">
        Sună-ne sau vino la o ședință de probă gratuită — discutăm 10-15 minute și răspundem la orice întrebare.
      </p>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/','',$telefon)); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">Sună <?php echo esc_html($telefon); ?></a>
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">Programează Probă</a>
      </div>
    </div>
  </div>
</section>

<!-- /main from header -->

<?php get_footer(); ?>
