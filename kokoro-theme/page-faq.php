<?php
/**
 * Template Name: FAQ — Întrebări Frecvente
 *
 * Template dedicat pentru pagina FAQ (slug recomandat: faq).
 * Conținutul Q&A se editează din ACF repeater `kokoro_faq` (intrebare/raspuns)
 * pe pagina respectivă. Schema FAQPage e randată automat din wp_footer prin
 * kokoro_render_jsonld_faqpage().
 *
 * Hero, intro și CTA sunt editabile prin titlu + conținut + ACF custom fields:
 *   - faq_intro_titlu (text) — titlu secțiune intro
 *   - faq_cta_titlu (text)   — titlu CTA final
 *   - faq_cta_text (wysiwyg) — text CTA final
 * Toate au fallback-uri sensible dacă nu sunt populate.
 *
 * @package Kokoro
 */

get_header();

if (!have_posts()) { get_footer(); return; }
the_post();

$acf = function_exists('get_field');
$intro_titlu = $acf ? (string) get_field('faq_intro_titlu') : '';
$cta_titlu   = $acf ? (string) get_field('faq_cta_titlu')   : '';
$cta_text    = $acf ? (string) get_field('faq_cta_text')    : '';
$tel         = function_exists('kokoro_setting') ? kokoro_setting('telefon', '0742 037 973') : '0742 037 973';
$tel_link    = preg_replace('/[^0-9+]/', '', $tel);
if (strpos($tel_link, '+') !== 0 && strpos($tel_link, '0') === 0) {
    $tel_link = '+4' . $tel_link;
}
$email       = function_exists('kokoro_setting') ? kokoro_setting('email', 'contact@kokoro.ro') : 'contact@kokoro.ro';
?>

<!-- ============================================================
     SECTION 1: HERO
     ============================================================ -->
<section class="page-header">
  <div class="container">
    <div class="section-number">FAQ · Întrebări Frecvente</div>
    <h1><?php echo esc_html(get_the_title() ?: 'ÎNTREBĂRI FRECVENTE'); ?></h1>
    <?php if (get_the_content()) : ?>
      <div style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 750px; line-height: 1.7; font-size: 1.0625rem;">
        <?php the_content(); ?>
      </div>
    <?php else : ?>
      <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 750px; line-height: 1.7; font-size: 1.0625rem;">
        Răspunsuri scurte și directe la întrebările pe care le-am primit cel mai des în ultimii ani — despre înscriere, programe, tarife, echipament, locație. Dacă nu găsiți răspunsul aici, ne puteți suna la <a href="tel:<?php echo esc_attr($tel_link); ?>" style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html($tel); ?></a> sau scrie la <a href="mailto:<?php echo esc_attr($email); ?>" style="color: var(--color-accent); font-weight: 700;"><?php echo esc_html($email); ?></a>.
      </p>
    <?php endif; ?>
  </div>
  <div class="page-header__number" aria-hidden="true">問</div>
</section>

<!-- ============================================================
     SECTION 2: INTRO
     ============================================================ -->
<?php if ($intro_titlu) : ?>
<section class="section section--dark">
  <div class="container container--narrow">
    <div class="section__header reveal">
      <div class="section-number">Despre acest FAQ</div>
      <h2><?php echo wp_kses_post($intro_titlu); ?></h2>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============================================================
     SECTION 3: FAQ LIST (din ACF repeater kokoro_faq)
     ============================================================ -->
<?php kokoro_render_faq_section(); ?>

<!-- ============================================================
     SECTION 4: CTA FINAL
     ============================================================ -->
<section class="section section--accent">
  <div class="container" style="text-align: center;">
    <div class="reveal">
      <h2 style="color: var(--color-bg);"><?php echo esc_html($cta_titlu ?: 'N-AȚI GĂSIT RĂSPUNSUL AICI?'); ?></h2>
      <div style="color: var(--color-bg); opacity: 0.85; margin: var(--space-lg) auto var(--space-2xl); max-width: 700px; line-height: 1.7;">
        <?php if ($cta_text) :
            echo wp_kses_post(wpautop($cta_text));
        else : ?>
          <p>Pentru întrebări specifice (caz medical particular, situație individuală, dubii despre program), sunați-ne direct sau veniți la o ședință de probă gratuită. Discutăm onest 10-15 minute înainte de antrenament și vă spunem dacă vă putem ajuta — fără obligație de înscriere.</p>
        <?php endif; ?>
      </div>
      <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap; align-items: center;">
        <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--large" style="background: var(--color-bg); color: var(--color-accent); border-color: var(--color-bg);">
          Programați O Ședință De Probă
        </a>
        <a href="tel:<?php echo esc_attr($tel_link); ?>" class="btn btn--outline btn--large" style="border-color: var(--color-bg); color: var(--color-bg);">
          <?php echo esc_html($tel); ?>
        </a>
      </div>
      <p style="color: var(--color-bg); opacity: 0.7; margin-top: var(--space-xl); font-size: 0.9375rem;">
        Sau scrieți-ne la <a href="mailto:<?php echo esc_attr($email); ?>" style="color: var(--color-bg); font-weight: 700;"><?php echo esc_html($email); ?></a>
      </p>
    </div>
  </div>
</section>

<?php get_footer();
