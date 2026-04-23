</main><!-- /#content -->

<?php
$contact_telefon  = kokoro_setting('telefon',  '+40 740 123 456');
$contact_email    = kokoro_setting('email',    'contact@kokoro.ro');
$contact_adresa   = kokoro_setting('adresa',   'Brașov, România');
$contact_oras     = kokoro_setting('oras',     'Brașov, România');
$contact_maps     = kokoro_setting('maps_url', '');

$social_facebook  = kokoro_setting('facebook',  '');
$social_instagram = kokoro_setting('instagram', '');
$social_youtube   = kokoro_setting('youtube',   '');
$social_tiktok    = kokoro_setting('tiktok',    '');

$footer_descriere      = kokoro_setting('footer_descriere',      'Kokoro Brașov Academy — academie de Ju-Jitsu fondată în 2008. Recunoscută MTS și FRAM. Formăm campioni și caractere puternice prin disciplină, respect și perseverență.');
$footer_kanji          = kokoro_setting('footer_kanji',          '武道');
$footer_disc_titlu     = kokoro_setting('footer_disc_titlu',     'Discipline');
$footer_disc_limit     = (int) kokoro_setting('footer_disc_limit', 4);
if ($footer_disc_limit < 1) $footer_disc_limit = 4;
$footer_nav_titlu      = kokoro_setting('footer_nav_titlu',      'Navigare');
$footer_contact_titlu  = kokoro_setting('footer_contact_titlu',  'Contact');
$footer_copyright      = kokoro_setting('footer_copyright',      'Kokoro Brașov Academy. Toate drepturile rezervate.');
$footer_tagline        = kokoro_setting('footer_tagline',        'Kokoro — Inimă, Spirit, Minte');

$wa_numar = preg_replace('/\D/', '', kokoro_setting('whatsapp_numar', '40740123456'));
$wa_arata = function_exists('get_field') ? (bool) get_field('set_whatsapp_arata', 'option') : true;

// Disciplinele pentru footer (pull din CPT)
$footer_disc = get_posts([
    'post_type'      => 'disciplina',
    'posts_per_page' => $footer_disc_limit,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);
?>

<!-- Footer -->
<footer class="footer" role="contentinfo">

  <!-- Torii Gate Separator -->
  <div class="torii-separator torii-separator--alt">
    <div class="torii-separator__icon">
      <?php echo kokoro_svg('torii-gate'); ?>
    </div>
  </div>

  <div class="container">
    <div class="footer__grid">

      <!-- Brand Column -->
      <div class="footer__brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo">
          <?php if (has_custom_logo()) : ?>
            <?php
              $logo_id = get_theme_mod('custom_logo');
              $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" width="60" height="60">
          <?php endif; ?>
        </a>
        <?php if ($footer_descriere !== '') : ?>
          <p class="footer__description"><?php echo esc_html($footer_descriere); ?></p>
        <?php endif; ?>
        <?php if ($footer_kanji !== '') : ?>
          <div class="footer__kanji" aria-hidden="true"><?php echo esc_html($footer_kanji); ?></div>
        <?php endif; ?>
      </div>

      <!-- Navigation Column -->
      <div>
        <h4 class="footer__heading"><?php echo esc_html($footer_nav_titlu); ?></h4>
        <nav class="footer__links" aria-label="Footer navigation">
          <?php
            // Folosește meniul WP cu locația „footer". Dacă nu e setat, fallback la pagini comune.
            if (has_nav_menu('footer')) {
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'menu_class'     => '',
                    'depth'          => 1,
                    'link_class'     => 'footer__link',
                    'fallback_cb'    => false,
                    'walker'         => new Kokoro_Footer_Link_Walker(),
                ]);
            } else {
                $pages_default = [
                    'despre-noi' => 'Despre Noi',
                    'discipline' => 'Discipline',
                    'orar'       => 'Orar',
                    'tarife'     => 'Tarife',
                    'campioni'   => 'Campioni',
                    'galerie'    => 'Galerie',
                ];
                foreach ($pages_default as $slug => $label) {
                    printf(
                        '<a href="%s" class="footer__link">%s</a>',
                        esc_url(home_url('/' . $slug . '/')),
                        esc_html($label)
                    );
                }
            }
          ?>
        </nav>
      </div>

      <!-- Discipline Column -->
      <div>
        <h4 class="footer__heading"><?php echo esc_html($footer_disc_titlu); ?></h4>
        <nav class="footer__links">
          <?php if (!empty($footer_disc)) : ?>
            <?php foreach ($footer_disc as $d) :
                $link_custom = function_exists('get_field') ? (string) get_field('disciplina_link', $d->ID) : '';
                $url = $link_custom !== '' ? $link_custom : get_permalink($d->ID);
            ?>
              <a href="<?php echo esc_url($url); ?>" class="footer__link"><?php echo esc_html(get_the_title($d->ID)); ?></a>
            <?php endforeach; ?>
          <?php else : ?>
            <a href="<?php echo esc_url(home_url('/ju-jitsu-competitional/')); ?>" class="footer__link">Ju-Jitsu Competițional</a>
            <a href="<?php echo esc_url(home_url('/autoaparare/')); ?>" class="footer__link">Ju-Jitsu Autoapărare</a>
            <a href="<?php echo esc_url(home_url('/trx-suspension-training/')); ?>" class="footer__link">TRX Suspension Training</a>
            <a href="<?php echo esc_url(home_url('/preparator-fizic/')); ?>" class="footer__link">Personal Training</a>
          <?php endif; ?>
        </nav>
      </div>

      <!-- Contact Column -->
      <div>
        <h4 class="footer__heading"><?php echo esc_html($footer_contact_titlu); ?></h4>
        <div class="footer__links">
          <?php if ($contact_oras !== '') : ?>
            <?php if ($contact_maps !== '') : ?>
              <a href="<?php echo esc_url($contact_maps); ?>" target="_blank" rel="noopener" class="footer__link"><?php echo esc_html($contact_oras); ?></a>
            <?php else : ?>
              <p class="footer__link"><?php echo esc_html($contact_oras); ?></p>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($contact_telefon !== '') : ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_telefon)); ?>" class="footer__link"><?php echo esc_html($contact_telefon); ?></a>
          <?php endif; ?>
          <?php if ($contact_email !== '') : ?>
            <a href="mailto:<?php echo esc_attr(antispambot($contact_email)); ?>" class="footer__link"><?php echo esc_html(antispambot($contact_email)); ?></a>
          <?php endif; ?>
        </div>

        <!-- Social Links -->
        <?php if ($social_facebook || $social_instagram || $social_youtube || $social_tiktok) : ?>
          <div class="footer__social" style="margin-top: var(--space-lg);">
            <?php if ($social_facebook) : ?>
              <a href="<?php echo esc_url($social_facebook); ?>" class="footer__social-link" aria-label="Facebook" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
            <?php endif; ?>
            <?php if ($social_instagram) : ?>
              <a href="<?php echo esc_url($social_instagram); ?>" class="footer__social-link" aria-label="Instagram" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            <?php endif; ?>
            <?php if ($social_youtube) : ?>
              <a href="<?php echo esc_url($social_youtube); ?>" class="footer__social-link" aria-label="YouTube" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              </a>
            <?php endif; ?>
            <?php if ($social_tiktok) : ?>
              <a href="<?php echo esc_url($social_tiktok); ?>" class="footer__social-link" aria-label="TikTok" target="_blank" rel="noopener">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
              </a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

    </div><!-- /.footer__grid -->

    <!-- Bottom Bar -->
    <div class="footer__bottom">
      <p class="footer__copyright">
        &copy; <?php echo date('Y'); ?> <?php echo esc_html($footer_copyright); ?>
      </p>
      <?php if ($footer_tagline !== '') : ?>
        <p class="footer__copyright">
          <span class="kanji--inline" aria-hidden="true">心</span> <?php echo esc_html($footer_tagline); ?>
        </p>
      <?php endif; ?>
    </div>

  </div><!-- /.container -->
</footer>

<?php if ($wa_arata && $wa_numar !== '') : ?>
<!-- WhatsApp Float Button -->
<a href="https://wa.me/<?php echo esc_attr($wa_numar); ?>" class="whatsapp-float" aria-label="Contactează-ne pe WhatsApp" target="_blank" rel="noopener">
  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
  </svg>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
