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

$teams_simple = $this->parse_group($teams_simple);
if ( empty($teams_simple) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-member--famulus-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-team-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $teams_simple as $index => $item ) : ?>
		<div class="aheto-member__wrap">
			<div class="aheto-member aheto-member--classic aheto-member--border t-center">
				<?php if ( !empty($item['member_image']) ) : ?>
					<?php $background_image = 'style="background-image: url('.( $item['member_image']['url'] ). ')"'; ?>
					<div class="aheto-member__img-holder" <?php echo $background_image;?>>
					</div>
				<?php endif; ?>
				<div class="aheto-member__text">
					<?php
					// Name.
					if ( !empty($item['member_name']) ) {
						echo '<h5 class="aheto-member__name">' . wp_kses($item['member_name'], 'post') . '</h5>';
					}
					// Designation.
					if ( !empty($item['member_designation']) ) {
						echo '<p class="aheto-member__position">' . esc_html($item['member_designation']) . '</p>';
					} ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
