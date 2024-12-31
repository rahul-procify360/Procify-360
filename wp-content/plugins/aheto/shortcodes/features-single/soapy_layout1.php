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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-simple');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-features-single-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}

$image_left = '';
$image_right = '';
if ( !empty($soapy_image_left) ) {
	$image_left = Helper::get_attachment($soapy_image_left, ['class' => 'aheto-content-block__image left']);
}
if ( !empty($soapy_image_right) ) {
	$image_right = Helper::get_attachment($soapy_image_right, ['class' => 'aheto-content-block__image right']);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__wrap">
			<div class="aheto-content-block__shape"></div>
			<?php if (!empty( $soapy_title) ) : ?>
				<h4 class="aheto-content-block__title "><?php echo wp_kses($image_left.$soapy_title.$image_right, 'post'); ?></h4>
			<?php endif; ?>
			<div class="aheto-content-block__info">
				<?php if (!empty( $soapy_desc )) : ?>
					<p class="aheto-content-block__info-text ">
						<?php echo wp_kses($soapy_desc, 'post'); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
