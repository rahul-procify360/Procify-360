<?php
/**
 * Title bar default templates.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar--karma_travel-search');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


// Icon.
$icon = $this->get_icon_attributes('', true, true);
if (!empty($icon)) {
	$this->add_render_attribute('icon', 'class', 'icon');
	$this->add_render_attribute('icon', 'class', $icon['icon']);
	if (!empty($icon['color'])) {
		$this->add_render_attribute('icon', 'style', 'color:' . $icon['color'] . ';');
	}
	if (!empty($icon['font_size'])) {
		$this->add_render_attribute('icon', 'style', 'font-size:' . $icon['font_size']);
	}
}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_travel-title-bar-layout1', $shortcode_dir . 'assets/css/karma_travel_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-titlebar__main">
		<?php if ( !empty($searchform) ) : ?>
			<div class="aheto-titlebar__input <?php echo Helper::get_button($this, $atts, 'sf_', true); ?>">
				<form role="search" class="w-800" method="get" id="searchform"
					  action="<?php echo home_url('/'); ?>">
					<label>
						<?php if(!empty($icon)):?>
							<?php echo '<i ' . $this->get_render_attribute_string('icon') . '></i>';?>
						<?php endif;?>
						<?php $inp = !empty($karma_travel_input) ? $karma_travel_input : 'Enter your keywords'?>
						<?php $submit = !empty($karma_travel_submit) ? $karma_travel_submit : 'search'?>
						<input type="text" value="" name="s" id="s"
							   placeholder="<?php echo esc_attr($inp); ?>"/>
						<input type="hidden" name="post_type" value="product"/>
					</label>
					<input type="submit" id="searchsubmit"
						   value="<?php echo esc_attr($submit); ?>"/>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>

