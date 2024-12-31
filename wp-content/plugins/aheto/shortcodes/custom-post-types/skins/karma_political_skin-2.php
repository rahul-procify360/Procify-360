<?php

use Aheto\Helper;

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article-def aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];

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

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-skin-2', $shortcode_dir . 'assets/css/karma_political_skin-2.css', null, null );
}

?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">
        <div class="aheto-cpt-article__content">

            <div class="aheto-cpt-article__content-header">

                <div class="aheto-cpt-article__event-content">
	                <span class="aheto-cpt-article__event-day-content"><?php echo esc_html( get_the_date('j') );?></span>
	                <span class="aheto-cpt-article__event-month-content"><?php echo esc_html( get_the_date('M') );?></span>
                </div>

                <?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                            $title = get_the_title();
                            echo $title;
                        ?>
                    </a>
                <?php echo '</' . $tag . '>'; ?>
                <?php $this->getExcerpt(); ?>

                <div class="aheto-cpt-article__image-content">
                    <?php $isHasThumb = $this->getImage( '', '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>
                </div>

			</div>

        </div>
    </div>

</article>
