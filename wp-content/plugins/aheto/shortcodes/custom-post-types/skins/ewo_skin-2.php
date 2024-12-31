<?php

use Aheto\Helper;

/**
 * Ewo Skin 2
 */

$classes    = [];
$classes[]  = 'aheto-cpt-article';
$classes[]  = 'aheto-cpt-article--' . $atts['layout'];
$classes[]  = 'aheto-cpt-article--' . $atts['skin'];
$classes[]  = $this->getAdditionalItemClasses( $atts['layout'], true );
$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );
$img_class  = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$ewo_link = isset( $atts['ewo_link'] ) && ! empty( $atts['ewo_link'] ) ? $atts['ewo_link'] : esc_html__( 'READ FULL POST', 'ewo' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-skin-2', $shortcode_dir . 'assets/css/ewo_skin-2.css', null, null);
	wp_enqueue_script( 'ewo-skin-2-js', $shortcode_dir . 'assets/js/ewo_skin-2.min.js', array( 'jquery' ), null );
}

?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ) ?>">
    <div class="aheto-cpt-article__inner">
		<?php $this->getImage( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>
        <div class="aheto-cpt-article__content">
            <p class="aheto-cpt-article__date">
				<?php the_time( get_option( 'date_format' ) ); ?>
				<?php echo wp_kses_post( 'in World' ) ?>
            </p>
            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
            <div class="aheto-cpt-article__excerpt">
				<?php the_excerpt(); ?>
            </div>
            <div class="aheto-cpt-article__link">
                <a class="aheto-link aheto-btn--light aheto-btn--no-underline" href="<?php the_permalink(); ?>">
					<?php echo esc_html( $ewo_link ); ?>
                    <i class="ion-ios-arrow-forward"></i>
                </a>
            </div>
        </div>
    </div>
</article>
