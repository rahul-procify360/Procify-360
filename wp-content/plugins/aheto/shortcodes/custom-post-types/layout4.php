<?php
/**
 * Custom Post Type Masonry Layout.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'mosaics';

// Query.
$the_query = $this->get_wp_query();
if ( ! $the_query->have_posts() ) {
	return;
}

$mosaics_skin = isset( $mosaics_skin ) && ! empty( $mosaics_skin ) ? $mosaics_skin : 'skin-8';
$mosaics_columns = isset($mosaics_columns) && !empty($mosaics_columns) ? $mosaics_columns : 'two';


// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--mosaics' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt__columns-' . $mosaics_columns );
$this->add_render_attribute( 'wrapper', 'class', 'js-popup-gallery' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'custom-post-types-style-4', $sc_dir . 'assets/css/layout4.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	$this->add_excerpt_filter();
	$content = [];
	$filters = [];

	$id = 'aheto_cpt_' . rand( 0, 1000 );
	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		ob_start();

		$this->get_skin_part( $mosaics_skin, $atts );

		$content[] = ob_get_clean();
	endwhile;

	$this->remove_excerpt_filter();

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr( $id ) . '">' . join( "\n", $content ) . '</div>';

	$this->cpt_load_more( $atts, $the_query->max_num_pages, $id );
	$this->cpt_pagination( $atts, $the_query->max_num_pages );

	wp_reset_query(); ?>

</div>
