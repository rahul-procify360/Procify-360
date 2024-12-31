<?php
/**
 * Portfolio navigation templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$prev_post = get_previous_post( false, '', 'aheto-portfolio-category' );
$next_post = get_next_post( false, '', 'aheto-portfolio-category' );

$prev_post_class = empty( $prev_post ) ? 'empty-prev ' : '';
$next_post_class = empty( $next_post ) ? 'empty-next' : '';


$atts['image_height'] = 120;
$atts['image_width']  = 120;

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/portfolio-nav/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'portfolio-nav-style-3', $sc_dir . 'assets/css/layout3.css', null, null );
}


?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="portfolio-nav-modern <?php echo esc_attr( $prev_post_class . $next_post_class ) ?>">

		<?php

		if ( ! empty( $prev_post ) ) {
			$prev = get_previous_post_link(
				'<div class="portfolio-nav-modern__dir portfolio-nav-modern__dir--prev">%link</div>',
				'<h6><i class="icon ion-arrow-left-c"></i>' . __( 'Prev', 'aheto' ) . '</h6>',
				false,
				'',
				'aheto-portfolio-category'
			);

			echo str_replace( '<a', '<a class="portfolio-nav-modern__link"', $prev );
		}

		?>

        <div class="portfolio-nav-modern__list">
            <i class="portfolio-nav-modern__list-icon icon ion-ios-keypad"></i>
        </div>

		<?php

		if ( ! empty( $next_post ) ) {
			$prev = get_next_post_link(
				'<div class="portfolio-nav-modern__dir portfolio-nav-modern__dir--next">%link</div>',
				'<h6>' . __( 'Next', 'aheto' ) . '<i class="icon ion-arrow-right-c"></i></h6>',
				false,
				'',
				'aheto-portfolio-category'
			);

			echo str_replace( '<a', '<a class="portfolio-nav-modern__link"', $prev );
		}
		?>

    </div>

</div>
