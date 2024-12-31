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

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--azyn_skin-1';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--azyn-mosaics' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('azyn-skin-1', $sc_dir . 'assets/css/azyn_skin-1.css', null, null);
	wp_enqueue_style( 'custom-post-types-azyn-layout1', $sc_dir . 'assets/css/azyn_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('azyn-skin-1-js', $sc_dir . 'assets/js/azyn_skin-1.min.js', array('jquery'), null);
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	$this->add_excerpt_filter();
	$content = [];
	$filters = [];

	$id = 'aheto_cpt_' . rand( 0, 1000 );
	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		ob_start(); ?>

		<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
			<div class="aheto-cpt-article__inner">
				<div class="aheto-cpt-article__image-wrap">
					<?php 	if ( has_post_thumbnail(get_the_ID()) ) {
						$isHasThumb = $this->getImage('', '', $atts['cpt_image_size'], true, true, $atts,  'cpt_');
					} ?>
				</div>
				<div class="aheto-cpt-article__content">
					<?php $terms_class = !has_post_thumbnail(get_the_ID()) ? 'aheto-cpt-article__terms--static' : '';
					$this->getTitle();
					$this->getTerms($atts['terms'], $terms_class); ?>
				</div>
			</div>
		</article>


		<?php

		$content[] = ob_get_clean();
	endwhile;

	$this->remove_excerpt_filter();

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr( $id ) . '">' . join( "\n", $content ) . '</div>';

	$this->cpt_load_more( $atts, $the_query->max_num_pages, $id );
	$this->cpt_pagination( $atts, $the_query->max_num_pages );

	wp_reset_query(); ?>

</div>
