<?php
/**
 * Custom Page Template
 */

get_header();

$protected = '';

if (post_password_required()) {
    $protected = 'protected-page';
}

while (have_posts()) : the_post(); ?>

    <div class="karma-blog--single-wrapper <?php echo esc_attr($protected); ?>">

        <?php if (function_exists('is_woocommerce') && (is_cart() || is_checkout() || is_account_page())) {

            $karma_img = '';
            $karma_background_image = '';

            if (function_exists('aheto')) {
                $karma_shop_image = Aheto\Helper::get_settings('theme-options.karma_shop_image');
                $karma_background_image = isset($karma_shop_image) && !empty($karma_shop_image) ? "style=background-image:url(" . $karma_shop_image . ")" : '';
                $karma_img = isset($karma_shop_image) && !empty($karma_shop_image) ? 'with-image' : '';
            } ?>

            <div class="karma-shop-banner <?php echo esc_attr($karma_img); ?> " <?php echo esc_attr($karma_background_image); ?>>
                <h1 class="title"><?php the_title(); ?></h1>
            </div>

        <?php } else { ?>
            <div class="karma-blog--single__top-content">

                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <?php the_title('<h1 class="karma-blog--single__title text-center">', '</h1>'); ?>

                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>


        <div class="container karma-blog--single__post-content">
            <div class="row">
                <div class="col-12">

                    <div class="karma-blog--single__content-wrapper page">

                        <?php the_content();
                        wp_link_pages('link_before=<span class="karma-blog--single__pages">&link_after=</span>&before=<div class="karma-blog--single__post-nav"> <span>' . esc_html__("Page:", 'karma') . ' </span> &after=</div>'); ?>

                    </div>

                    <?php if (comments_open() || '0' != get_comments_number() && wp_count_comments($get_id)) { ?>
                        <div class="karma-blog--single__comments page">
                            <?php comments_template('', true); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


<?php
endwhile;

get_footer();
