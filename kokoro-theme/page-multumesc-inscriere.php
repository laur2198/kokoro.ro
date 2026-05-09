<?php
/**
 * Template Name: Mulțumim — Înscriere
 *
 * Pagină dedicată de confirmare după trimiterea formularului de înscriere.
 * Beneficii vs banner generic:
 *  - Conversion goal tracking pe URL specific (Google Analytics)
 *  - Cross-sell links (discipline, antrenori, orar)
 *  - Reassurance + next steps mai clare decât banner top-of-page
 *
 * Sticky CTA bar mobile (Faza 4) NU apare aici (e bottom of funnel — nu vrem
 * CTA dublu cu „Sună acum" care competiționează cu mesajul de confirmare).
 *
 * Schema noindex (kokoro_seo_noindex ACF) evită indexarea în Google.
 *
 * @package Kokoro
 */

defined('ABSPATH') || exit;
get_header();

$kk_tel  = kokoro_setting('telefon', '+40 742 037 973');
$kk_wa   = preg_replace('/\D/', '', kokoro_setting('whatsapp_numar', '40742037973'));
?>

<section class="page-header" style="text-align: center;">
  <div class="container container--narrow">
    <div class="section-number">Înscriere</div>
    <h1 style="margin-top: var(--space-md);">
      MULȚUMIM!<br><em>TE-AM PRIMIT</em>
    </h1>
    <p style="color: var(--color-gray); margin-top: var(--space-lg); max-width: 580px; margin-left: auto; margin-right: auto; font-size: 1.0625rem; line-height: 1.7;">
      Te contactăm în <strong style="color: var(--color-white);">maxim 24 de ore</strong> pentru a programa antrenamentul gratuit al copilului tău.
    </p>
  </div>
  <div class="page-header__number" aria-hidden="true">感謝</div>
</section>

<!-- 3 elemente reassurance -->
<section class="section section--alt">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--space-2xl); text-align: center;">

      <div class="reveal reveal-delay-1">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);" aria-hidden="true">📞</div>
        <h3 class="heading-5" style="margin-bottom: var(--space-sm);">Te sunăm</h3>
        <p style="color: var(--color-gray); font-size: 0.9375rem; line-height: 1.6;">
          Te contactăm la numărul de telefon completat pentru a stabili ziua și ora primei lecții.
        </p>
      </div>

      <div class="reveal reveal-delay-2">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);" aria-hidden="true">📧</div>
        <h3 class="heading-5" style="margin-bottom: var(--space-sm);">Verifică email-ul</h3>
        <p style="color: var(--color-gray); font-size: 0.9375rem; line-height: 1.6;">
          Dacă ai completat email-ul, vei primi confirmarea și detaliile primei lecții acolo.
        </p>
      </div>

      <div class="reveal reveal-delay-3">
        <div style="font-size: 2.5rem; line-height: 1; margin-bottom: var(--space-md);" aria-hidden="true">💬</div>
        <h3 class="heading-5" style="margin-bottom: var(--space-sm);">Întrebări urgente?</h3>
        <p style="color: var(--color-gray); font-size: 0.9375rem; line-height: 1.6;">
          Scrie-ne pe
          <a href="https://wa.me/<?php echo esc_attr($kk_wa); ?>" target="_blank" rel="noopener" style="color: var(--color-accent); font-weight: 700;">WhatsApp</a>
          sau sună la
          <a href="tel:<?php echo esc_attr(kokoro_phone_to_e164($kk_tel)); ?>" style="color: var(--color-accent); font-weight: 700; white-space: nowrap;"><?php echo esc_html($kk_tel); ?></a>.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- Cross-sell strip -->
<section class="section section--dark">
  <div class="container container--narrow" style="text-align: center;">
    <div class="section-number" style="justify-content: center;">Între timp</div>
    <h2 style="margin-bottom: var(--space-2xl);">DESCOPERĂ<br><em>KOKORO</em></h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-lg);">
      <a href="<?php echo esc_url(home_url('/discipline/')); ?>" class="card reveal reveal-delay-1" style="text-decoration: none; padding: var(--space-xl); text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--space-sm);" aria-hidden="true">🥋</div>
        <h3 class="heading-5" style="color: var(--color-white); margin-bottom: var(--space-xs);">Disciplinele noastre</h3>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Ju-Jitsu, Autoapărare, Personal Training</p>
      </a>

      <a href="<?php echo esc_url(home_url('/antrenori/')); ?>" class="card reveal reveal-delay-2" style="text-decoration: none; padding: var(--space-xl); text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--space-sm);" aria-hidden="true">先生</div>
        <h3 class="heading-5" style="color: var(--color-white); margin-bottom: var(--space-xs);">Despre antrenori</h3>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Sensei Lucian și echipa Kokoro</p>
      </a>

      <a href="<?php echo esc_url(home_url('/orar/')); ?>" class="card reveal reveal-delay-3" style="text-decoration: none; padding: var(--space-xl); text-align: center;">
        <div style="font-size: 2rem; margin-bottom: var(--space-sm);" aria-hidden="true">🗓️</div>
        <h3 class="heading-5" style="color: var(--color-white); margin-bottom: var(--space-xs);">Vezi orarul</h3>
        <p style="color: var(--color-gray); font-size: 0.875rem;">Programul antrenamentelor săptămânale</p>
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
