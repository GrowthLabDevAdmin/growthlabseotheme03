<section class="contact-form-footer">
    <div class="contact-form-footer__wrapper container">
        <div class="contact-form-footer__inner">

            <div class="contact-form-footer__col">
                <?php
                img_print_picture_tag($args['logo'], max_size: 'medium', classes: 'contact-form-footer__logo');
                print_title($args['title'], $args['tag'], "contact-form-footer__title");
                ?>

                <div class="contact-form-footer__description formatted-text">
                    <?php echo wp_kses_post(wpautop($args['description'])); ?>
                </div>
            </div>

            <div class="contact-form-footer__col">

                <div class="contact-form-footer__form">
                    <?php gravity_form($args['form'], display_title: false, display_description: false); ?>
                </div>

            </div>

        </div>

    </div>
</section>