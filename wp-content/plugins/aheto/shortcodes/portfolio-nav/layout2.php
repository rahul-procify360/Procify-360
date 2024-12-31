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
$this->add_render_attribute( 'wrapper', 'class', 'portfolio-tags-wrap' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$terms_list = wp_get_post_terms( get_the_ID(), 'aheto-portfolio-tag' );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/portfolio-nav/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'portfolio-nav-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}


?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $terms_list ) ) { ?>

        <div class="portfolio-tags-wrap__list">

            <i class="ion-ios-pricetags-outline"></i>

			<?php foreach ( $terms_list as $term ) { ?>

                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>

			<?php } ?>

        </div>

	<?php } ?>

</div>
