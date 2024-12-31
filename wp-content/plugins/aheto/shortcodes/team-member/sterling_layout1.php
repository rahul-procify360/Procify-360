<?php

/**
 * The Team Shortcode.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-team-member--sterling');

// parse networks
$networks = $this->parse_group($networks);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/team-member/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-team-member-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
$social_template = '<a ' . $this->get_render_attribute_string('link') . '><i class="aheto-socials__icon icon ion-social-%2$s"></i>%2$s</a>';
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ($image) : ?>
		<?php $feature_bg =  Helper::get_background_attachment($image, $sterling_image_size, $atts, 'sterling_'); ?>
		<div class="aheto-team-member__img-holder" <?php echo esc_attr($feature_bg); ?>></div>
		<div class="aheto-team-member__text">
			<?php
			// Name.
			if (!empty($name)) {
				echo '<h4 class="aheto-team-member__name">' . esc_html($name) . '</h4>';
			}
			// Designation.
			if (!empty($designation)) {
				echo '<p class="aheto-team-member__position">' . esc_html($designation) . '</p>';
			}
			?>
		</div>
	<?php endif; ?>
</div>
