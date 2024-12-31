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
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar--karma_education-search');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-title-bar-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-titlebar__main">
		<?php if ( !empty($searchform) ) : ?>
			<div class="aheto-titlebar__input <?php echo Helper::get_button($this, $atts, 'sf_', true); ?>">
				<form role="search" class="w-800" method="get" id="searchform"
					  action="<?php echo home_url('/'); ?>">
					<label>
						<input type="text" value="" name="s" id="s"
							   placeholder="<?php esc_attr_e('Enter your keywords', 'karma_education'); ?>"/>
						<input type="hidden" name="post_type" value="product"/>
					</label>
					<input type="submit" id="searchsubmit"
						   value="<?php esc_attr_e('search for course', 'karma_education'); ?>"/>
				</form>
			</div>
		<?php endif; ?>
	</div>
</div>

