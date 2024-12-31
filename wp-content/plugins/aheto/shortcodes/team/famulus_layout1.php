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

$teams = $this->parse_group($teams);
if ( empty($teams) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-member--famulus-classic');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-team-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $teams as $index => $item ) :
		$background_image = \Aheto\Helper::get_background_attachment($item['member_image'], 'medium_large', $atts, '');
		?>
		<div class="aheto-member__wrap">
			<div class="aheto-member aheto-member--classic aheto-member--border t-center">
				<?php if ( !empty($item['member_image']) ) : ?>
					<div class="aheto-member__img-holder" <?php echo esc_attr($background_image); ?>>
					</div>
				<?php endif; ?>
				<div class="aheto-member__text">
					<?php
					// Name.
					if ( !empty($item['member_name']) ) {
						echo '<h5 class="aheto-member__name">' . wp_kses($item['member_name'], 'post') . '</h5>';
					} ?>
					<div class="aheto-member__desc-wrap">

						<?php // Designation.
						if ( !empty($item['member_designation']) ) {
							echo '<p class="aheto-member__position">' . esc_html($item['member_designation']) . '</p>';
						}
						// Field Values Decode.
						if ( $item['member_social'] == true ) { ?>
							<div class="aheto-member__contact">
								<?php
								echo Helper::get_social_networks_list('<a class="aheto-member__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>', '', $item);
								?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
