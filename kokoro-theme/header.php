<?php
$header_meta_desc = kokoro_setting('meta_descriere', 'Kokoro Brașov Academy — Ju-Jitsu pentru copii, juniori și adulți din 2008. Campioni mondiali, antrenori dedicați.');
$header_cta_text  = kokoro_setting('header_cta_text', 'Înscrie-te');
$header_cta_url   = kokoro_setting('header_cta_url',  '');
if ($header_cta_url === '') $header_cta_url = home_url('/inscriere/');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo esc_attr($header_meta_desc); ?>">
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
    <a href="<?php echo esc_url($header_cta_url); ?>" class="btn btn--primary btn--small navbar__cta-desktop">
      <?php echo esc_html($header_cta_text); ?>
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
  <a href="<?php echo esc_url($header_cta_url); ?>" class="btn btn--primary btn--large">
    <?php echo esc_html($header_cta_text); ?>
  </a>
</div>

<main id="content" role="main">
