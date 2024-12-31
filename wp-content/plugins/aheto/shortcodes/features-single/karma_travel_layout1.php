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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--karma_travel');
// Icon.
$icon = $this->get_icon_attributes('', true, true);
if ( !empty($icon) ) {
	$this->add_render_attribute('icon', 'class', 'icon');
	$this->add_render_attribute('icon', 'class', $icon['icon']);
	if ( !empty($icon['color']) ) {
		$this->add_render_attribute('icon', 'style', 'color:' . $icon['color'] . ';');
	}
	if ( !empty($icon['font_size']) ) {
		$this->add_render_attribute('icon', 'style', 'font-size:' . $icon['font_size']);
	}
}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_travel-features-single-layout1', $shortcode_dir . 'assets/css/karma_travel_layout1.css', null, null);
}

?>
<?php $background_image = '';
if ( !empty($karma_travel_image) ) {
	$background_image = Helper::get_background_attachment($karma_travel_image, 'full', $atts);
} ?>
<div <?php $this->render_attribute_string('wrapper'); ?> >

	<div <?php $this->render_attribute_string('block_wrapper'); ?> <?php echo esc_attr($background_image); ?>>

		<div class="aheto-content-block__content">
			<?php if ( !empty($s_heading) ) : ?>
				<h2 class="aheto-content-block__title ">
					<?php echo '<i ' . $this->get_render_attribute_string('icon') . '></i>'; ?>
					<?php if ( !empty($karma_travel_link_url) ) : ?>
						<a href="<?php echo esc_url($karma_travel_link_url); ?>">
							<?php echo wp_kses_post($this->highlight_text($s_heading)); ?>
						</a>
					<?php else: ?>
						<?php echo wp_kses_post($this->highlight_text($s_heading)); ?>
					<?php endif; ?>
				</h2>
			<?php endif; ?>
			<?php if ( !empty($s_description) ) : ?>
				<p class="aheto-content-block__info-text ">
					<?php echo wp_kses_post($s_description); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
