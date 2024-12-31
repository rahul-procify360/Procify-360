<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--djo-with-image js-svg-replace');

$use_dot = isset($use_dot) && $use_dot == true ? 'djo-dot' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-features-single-layout3', $shortcode_dir . 'assets/css/djo_layout3.css', null, null);
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('djo-features-single-layout3-js', $shortcode_dir . 'assets/js/djo_layout3.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__wrap">
			<?php if ( ! empty($s_image['url']) ) :
				$image_alt = get_the_title($s_image['id']) ? get_the_title($s_image['id']) : 'icon';
			?>

				<div class="aheto-content-block__image">
					<img src="<?php echo esc_url( $s_image['url'] ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="svg">
				</div>
			<?php endif; ?>

			<div class="aheto-content-block__inner">

				<div class="aheto-content-block__content">

					<?php if ( ! empty( $s_heading ) ) : ?>
						<h5 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h5>
					<?php endif; ?>

					<div class="aheto-content-block__info">
						<?php if ( ! empty( $s_description ) ) : ?>
							<p class="aheto-content-block__info-text ">
								<?php echo wp_kses_post($s_description); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
