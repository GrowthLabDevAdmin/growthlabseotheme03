<?php
if (!defined('ABSPATH')) {
    exit;
}

if (get_field('toggle_block')):
    foreach (get_fields() as $key => $value) $$key = $value;
?>

    <section
        id="<?= $block_id ?? "" ?>"
        class="
        block 
        content-intro
        <?= isset($background_type) && $background_type ? $background_type : 'light' ?>
        <?= isset($background_type) && $background_type ? $background_type : 'light' ?>
        "
        <?php if (isset($extract_block_from_content) && $extract_block_from_content) echo "data-extract='$place'"; ?>>

        <?php
        if (isset($background_image) && $background_image && $background_type === 'image') img_print_picture_tag(img: $background_image, is_cover: true, classes: "content-intro__bg bg-image gradient-overlay");
        ?>

        <div class="content-intro__wrapper container">

            <?php foreach (get_field("columns") as $column => $col) $$column = $col; ?>

            <div class="col col--image <?= isset($featured_image_position) && $featured_image_position ? $featured_image_position : "left" ?>">
                <?php
                if (isset($featured_image) && $featured_image) {
                    $options = get_field_options("options");

                    if ($options["logo_symbol"]) {
                        img_print_picture_tag(img: $options["logo_symbol"], max_size: "medium", classes: "col__symbol");
                    }

                    img_print_picture_tag(
                        img: $featured_image,
                        max_size: $featured_image_position !== "bottom" ? "cover-mobile" : "cover-desktop",
                        min_size: "featured-small",
                        classes: "col__image"
                    );
                }
                ?>
            </div>

            <div class="col">
                <?php
                if (isset($pretitle) && $pretitle) print_title($pretitle, $pretitle_tag, "col__pretitle pretitle");
                if (isset($title) && $title) echo "<div class='col__title'>$title</div>";
                ?>
                <div class="col__content formatted-text">
                    <?= $content ?? "" ?>
                </div>
            </div>

            <?php foreach (get_field("cta_box") as $box => $data) $$box = $data; ?>
            <div class="inner-cta-box">

                <?php if ($content && isset($content)): ?>
                    <div class="inner-cta-box__content formatted-text">
                        <?= $content ?>
                    </div>
                <?php endif ?>

                <div class="inner-cta-box__buttons">
                    <?php if ($cta_link && isset($cta_link) && $cta_link["url"]): ?>
                        <a href="<?= $cta_link["url"] ?>" target="<?= $cta_link["target"] ?>" class="btn btn--primary-dark" aria-label="<?= esc_attr($cta_link["title"]) ?>">
                            <span><?= $cta_link["title"] ?></span>
                        </a>
                    <?php endif ?>
                    <?php if ($cta_link_2 && isset($cta_link_2) && $cta_link_2["url"]): ?>
                        <a href="<?= $cta_link_2["url"] ?>" target="<?= $cta_link_2["target"] ?>" class="btn" aria-label="<?= esc_attr($cta_link_2["title"]) ?>">
                            <?php if (str_contains($cta_link_2["url"], 'tel:')) include get_template_directory() . '/assets/icons/icon-phone.svg' ?>
                            <span><?= $cta_link_2["title"] ?></span>
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>

    </section>

<?php
endif;
?>