<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

$skin = isset( $skin ) && ! empty( $skin ) ? $skin : 'skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--slider' );
$this->add_render_attribute( 'wrapper', 'class', $skin ? 'js-popup-gallery' : '' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     => 500,
	'slides'    => 3,
	'slides_md' => 2,
	'slides_xs' => 1,
	'spaces'    => 30
]; // will use when not chosen option 'Change slider params'



$carousel_params = Helper::get_carousel_params( $atts, 'swiper_', $carousel_default_params );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'custom-post-types-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php
    $filters = [];
    $id = 'aheto_cpt_' . rand( 0, 1000 );
    ?>

    <div class="swiper" data-cpt-id="<?php echo esc_attr( $id ); ?>">

        <div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

            <div class="swiper-wrapper">

				<?php
				$this->add_excerpt_filter();

				while ( $the_query->have_posts() ) :
					$the_query->the_post();

					$terms_list = get_the_terms( get_the_ID(), $terms );

					if ( isset($terms_list) && is_array($terms_list) ) {
						$filters = array_merge( $filters, $terms_list );
					} ?>

                    <div class="swiper-slide">
						<?php $this->get_skin_part( $skin, $atts, '', 'swiper_' ); ?>
                    </div>
				<?php
				endwhile;

				$this->remove_excerpt_filter();

				wp_reset_query();
				?>

            </div>

			<?php $this->swiper_pagination( 'swiper_' ); ?>

        </div>

		<?php $this->swiper_arrow( 'swiper_' ); ?>

    </div>

    <?php $this->cpt_filter( $add_filter, $filters, $id, $all_items_text, $add_center_filter, true, $the_query->max_num_pages ); ?>

</div>
