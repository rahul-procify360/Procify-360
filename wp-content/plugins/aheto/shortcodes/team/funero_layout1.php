<?php
/**
 * The Team Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$funero_team = $this->parse_group($funero_team);
if (empty($funero_team)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-member--funero-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-team-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ($funero_team as $index => $item) : ?>
		<div class="aheto-member__wrap">
			<?php if (!empty($item['funero_member_image'])) :
				$background_image = \Aheto\Helper::get_background_attachment($item['funero_member_image'], $image_size, $atts, '');
				?>
				<div class="aheto-member__img-holder" <?php echo esc_attr($background_image); ?>>
				</div>
			<?php endif; ?>
			<div class="aheto-member__text">
				<?php
				// Name.
				if (!empty($item['funero_member_name'])) {
					echo '<h5 class="aheto-member__name">' . wp_kses($item['funero_member_name'], 'post') . '</h5>';
				} ?>

				<?php
				// Position.
				if (!empty($item['funero_member_position'])) {
					echo '<h4 class="aheto-member__position">' . wp_kses($item['funero_member_position'], 'post') . '</h4>';
				} ?>

			</div>
		</div>
	<?php endforeach; ?>
</div>
