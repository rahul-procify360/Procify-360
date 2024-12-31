<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
    foreach ( $terms_list as $term ) {
        $classes[] = 'filter-' . $term->slug;
    }
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-skin-1', $shortcode_dir . 'assets/css/noize_skin-1.css', null, null );
}

?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">
        <?php $isHasThumb = $this->getImage( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

        <div class="aheto-cpt-article__content">
            <span class="aheto-cpt-article__subtitle"><?php echo esc_html(get_the_date('F jS, Y')) .' '. esc_html(' in World' );?></span>
            <?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
                <a href="<?php the_permalink(); ?>">
                    <?php echo esc_html(get_the_title());?>
                </a>
            <?php echo '</' . $tag . '>'; ?>
        </div>
    </div>

</article>
