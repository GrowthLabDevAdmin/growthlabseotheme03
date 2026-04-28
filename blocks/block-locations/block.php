<?php
if (!defined('ABSPATH')) {
    exit;
}

if (get_field('toggle_block')):
    foreach (get_fields() as $key => $value) $$key = $value;
?>

    <section
        class="block locations"
        <?php if (isset($extract_block_from_content) && $extract_block_from_content) echo "data-extract='$place'"; ?>>

        <div class="locations__wrapper container">

            <div class="locations__content tx-center">
                <?php
                if (isset($pretitle) && $pretitle) print_title($pretitle, $pretitle_tag, "locations__pretitle pretitle");
                if (isset($title) && $title) print_title($title, $title_tag, "locations__title tx-center");
                echo $main_content;
                ?>
            </div>

            <div class="locations-cards">
                <?php
                if ($show_all_locations) {
                    $options = get_current_language_options();
                    $locations = $options['offices'];
                } else {
                    $locations = $offices;
                }
                if (!empty($locations)):
                ?>
                    <div class="locations-cards__grid">
                        <?php
                        foreach ($locations as $location) {
                            get_template_part(
                                'template-parts/location',
                                'card',
                                array(
                                    'accordion' => $enable_accordion_items ?? false,
                                    'location' => $location,
                                    'classes' => "locations-cards__card"
                                )
                            );
                        }
                        ?>
                    </div>
                <?php
                endif;
                ?>
            </div>

            <?php if (isset($cta_link) && $cta_link): ?>
                <a href="<?= $cta_link['url'] ?>" target="<?= $cta_link['target'] ?>" class="locations__btn btn--primary-dark" aria-label="<?= esc_attr($cta_link['title']) ?>">
                    <span><?= $cta_link['title'] ?></span>
                </a>
            <?php endif; ?>

        </div>
    </section>

<?php
endif;
?>