<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Kokoro Brașov Academy — Cursuri autoapărare Brașov, Ju-Jitsu pentru copii, juniori și adulți din 2008. Autoapărare, Ju-Jitsu competițional, Ju-Jitsu Contact. Campioni mondiali.">
  <meta name="keywords" content="autoapărare Brașov, cursuri autoapărare, ju-jitsu Brașov, arte marțiale Brașov, kokoro Brașov, autoapărare copii, ju-jitsu copii Brașov, ju-jitsu contact, cursuri ju-jitsu">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Sakura Petals Container -->
<div class="sakura-container" aria-hidden="true"></div>

<!-- Navbar -->
<nav class="navbar" role="navigation" aria-label="<?php esc_attr_e('Meniu principal', 'kokoro'); ?>">
  <div class="navbar__inner">

    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar__logo" aria-label="Kokoro Brașov Academy — Acasă">
      <?php if (has_custom_logo()) : ?>
        <?php
          $logo_id = get_theme_mod('custom_logo');
          $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" width="50" height="50">
      <?php else : ?>
        <img src="<?php echo esc_url(KOKORO_URI . '/assets/images/logo-placeholder.svg'); ?>" alt="<?php bloginfo('name'); ?>" width="50" height="50">
      <?php endif; ?>
      <span class="navbar__logo-text">Kokoro <span>Academy</span></span>
    </a>

    <!-- Desktop Menu -->
    <div class="navbar__menu">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'kokoro-menu',
          'walker'         => new Kokoro_Nav_Walker(),
          'fallback_cb'    => false,
          'depth'          => 2,
        ]);
      ?>
    </div>

    <!-- Desktop CTA -->
    <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--small navbar__cta-desktop">
      Înscrie-te
    </a>

    <!-- Hamburger Button -->
    <button class="navbar__hamburger" aria-label="<?php esc_attr_e('Deschide meniu', 'kokoro'); ?>" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="navbar__mobile-menu" aria-hidden="true">
  <button class="navbar__close" aria-label="<?php esc_attr_e('Închide meniu', 'kokoro'); ?>">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  </button>
  <?php
    wp_nav_menu([
      'theme_location' => 'primary',
      'container'      => false,
      'menu_class'     => 'kokoro-menu',
      'walker'         => new Kokoro_Nav_Walker(),
      'fallback_cb'    => false,
      'depth'          => 1,
    ]);
  ?>
  <a href="<?php echo esc_url(home_url('/inscriere/')); ?>" class="btn btn--primary btn--large">
    Înscrie-te Acum
  </a>
</div>

<main id="content" role="main">
