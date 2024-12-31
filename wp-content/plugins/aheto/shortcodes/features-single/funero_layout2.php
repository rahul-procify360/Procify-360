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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--funero-images');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-features-single-layout2', $shortcode_dir . 'assets/css/funero_layout2.css', null, null);
}
$title_top = isset($funero_title_top) && $funero_title_top ? 'image-title-reverse' : '';
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
	<div class ="image-title-wrapper <?php echo esc_attr( $title_top ); ?>">
	<?php
		if ( !empty($funero_image) ) { ?>
			<div class="aheto-content-block__image-wrap ">
				<?php echo Helper::get_attachment($funero_image, ['class' => 'aheto-content-block__image'], $image_size, $atts); ?>
			</div>
		<?php } ?>
		<?php if ( !empty($funero_title) ) : ?>
			<h4 class="aheto-content-block__title "><?php echo esc_html($funero_title); ?></h4>
		<?php endif; ?>
	</div>

		<?php if ( !empty($funero_desc) ) : ?>
			<p class="aheto-content-block__desc "><?php echo esc_html($funero_desc); ?></p>
		<?php endif; ?>
	</div>
</div>
