<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="testimonial-card <?= $args["classes"] ?>">
    <div class="testimonial-card__wrapper">

        <hr>
        <?php include get_template_directory() . '/assets/icons/icon-quote-2.svg'; ?>

        <div class="testimonial-card__inner">

            <div class=" testimonial-card__stars">
                <?php
                $i = 1;
                $star_url = get_template_directory() . '/assets/icons/icon-star-2.svg';
                while ($i <= 5) {
                    echo '<span class="star">';
                    include $star_url;
                    echo '</span>';
                    $i++;
                }
                ?>
            </div>

            <blockquote class="testimonial-card__content tx-center">
                <p>
                    <?= $args["content"] ?>
                </p>
            </blockquote>

            <p class="testimonial-card__author tx-center">
                - <?= $args["author"] ?>
                <span><?= $args["role"]  ?></span>
            </p>

        </div>

        <?php include get_template_directory() . '/assets/icons/icon-quote-2.svg'; ?>
        <hr>

    </div>
</div>