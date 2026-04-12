  <?php
  if (!defined('ABSPATH')) {
    exit;
  }
  ?>

  <footer id="site-footer" role="contentinfo" class="site-footer">

    <?php
    global $post;
    $post_id = $post ? $post->ID : 0;

    $options = get_current_language_options();
    foreach ($options as $key => $value) $$key = $value;
    $phone_number = $contact_phone ?: $main_phone_number;


    if (isset($footer_background_image) && $footer_background_image) img_print_picture_tag(img: $footer_background_image, is_cover: true, classes: "site-footer__bg bg-image");
    ?>

    <?php
    // Form
    if (!$form_section['hide_section'] && !get_field('hide_form_section')) {
      foreach ($form_section as $form_field => $form_content) $$form_field = $form_content;
      $args = [
        'logo' => $logo ?? null,
        'title' => isset($contact_form_title) && $contact_form_title ? $contact_form_title : "",
        'tag' => isset($contact_form_title_tag) && $contact_form_title_tag ? $contact_form_title_tag : "p",
        'description' => isset($contact_form_description) && $contact_form_description ? $contact_form_description : "",
        'form' => isset($contact_form) && $contact_form ? $contact_form : null,
      ];
      get_template_part('template-parts/footer', 'form', $args);
    }
    ?>

    <?php
    // Menu
    if (!$menu_section['hide_section'] && !get_field('hide_menu_section')) {
      if (isset($menu_section['menu']) && $menu_section['menu']) {
        wp_nav_menu(
          array(
            'menu'  => $menu_section['menu'],
            'container'          => 'nav',
            'container_class' => 'footer-menu',
            'menu_class'      => 'footer-menu__wrapper container',
            'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
            'link_before'          => '<span>',
            'link_after'              => '</span>'
          )
        );
      }
    }
    ?>

    <?php
    if (!$copyright_section['hide_section'] && !get_field("hide_copyright_section")):
      foreach ($copyright_section as $copy_field => $copy_content) $$copy_field = $copy_content;
    ?>
      <section class="copyright-footer">
        <div class="copyright-footer__wrapper container">
          <p class="copyright-footer__advertisement">
            <?= $copyright ?>
          </p>

          <a href="https://growthlabseo.com/" target="_blank" class="copyright-footer__logo" aria-label="Growth Lab SEO">
            <img src="<?= get_stylesheet_directory_uri() . "/assets/img/Growth-Lab-Logo.png" ?>" alt="Growth Lab SEO Logo" width="270" height="50">
          </a>

        </div>
      </section>
    <?php
    endif;
    ?>
  </footer>

  <?php wp_footer(); ?>

  </body>

  </html>