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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--famulus-logo');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-features-single-layout7', $shortcode_dir . 'assets/css/famulus_layout7.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($s_image) ) :
		$background_image = \Aheto\Helper::get_background_attachment($s_image, $famulus_image_size, $atts);
	endif; ?>
	<div <?php $this->render_attribute_string('block_wrapper'); ?> <?php echo esc_attr($background_image); ?>>

		<?php if ( !empty($famulus_logo) ) : ?>
			<div class="aheto-content-block__image-logo">
				<?php echo \Aheto\Helper::get_attachment($famulus_logo, ['class' => '']); ?>
			</div>
		<?php endif; ?>

		<?php if ( !empty($s_heading) ) : ?>
			<h5 class="aheto-content-block__title "><?php echo wp_kses_post($this->highlight_text($s_heading)); ?></h5>
		<?php endif; ?>
		<?php if ( !empty($s_description) ) : ?>
			<h6 class="aheto-content-block__info-text ">
				<?php echo wp_kses_post($s_description); ?>
			</h6>
		<?php endif; ?>
	</div>
</div>
