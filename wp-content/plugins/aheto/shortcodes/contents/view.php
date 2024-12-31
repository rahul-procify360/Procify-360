<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$faqs = $this->parse_group( $faqs );

if ( empty( $faqs ) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--faq' );
$this->add_render_attribute( 'wrapper', 'class', 'js-accordion-parent' );

if ( isset( $multi_active ) && ! empty( $multi_active ) ) {
	$this->add_render_attribute( 'wrapper', 'data-multiple', '1' );
}


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contents-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	foreach ( $faqs as $key => $item ) :

		$class_active = $key === 0 && $first_is_opened ? 'is-open' : '';
		$active_display = $key === 0 && $first_is_opened ? 'block' : 'none';

		if ( empty( $item['title'] ) && empty( $item['description'] ) ) {
			continue;
		}
		?>
		<div class="aheto-contents__item <?php echo esc_attr( $class_active ); ?>">

			<?php if ( ! empty( $item['title'] ) ) : ?>
				<h5 class="aheto-contents__title js-accordion"><?php echo wp_kses_post( $item['title'] ); ?></h5>
			<?php endif; ?>

			<?php if ( ! empty( $item['description'] ) ) : ?>
				<div class="aheto-contents__panel js-accordion-text"
				     style="display: <?php echo esc_attr( $active_display ); ?>">
					<p class="aheto-contents__desc">
						<?php echo wp_kses_post( $item['description'] ); ?>
					</p>
				</div>
			<?php endif; ?>

		</div>

	<?php endforeach; ?>

</div>
