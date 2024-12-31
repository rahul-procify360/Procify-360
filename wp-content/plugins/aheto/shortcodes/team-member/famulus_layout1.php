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

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-team-member--famulus-simple');
$this->add_render_attribute('wrapper', 'class', $famulus_align);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team-member/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-team-member-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}

// parse networks
$networks = $this->parse_group($networks);
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($image) ) : ?>
		<div class="aheto-team-member__img-holder">
			<?php echo Helper::get_attachment($image, ['class' => 'aheto-team-member__img'], $image_size); ?>
		</div>
	<?php endif; ?>

	<div class="aheto-team-member__text">
		<?php
		// Name.
		if ( !empty($name) ) {
			echo '<h5 class="aheto-team-member__name">' . wp_kses($name, 'post') . '</h5>';
		}

		// Designation.
		if ( !empty($designation) ) {
			echo '<p class="aheto-team-member__position">' . esc_html($designation) . '</p>';
		}

		// Field Values Decode.
		if ( !empty($networks) ) { ?>
			<div class="aheto-team-member__contact">
				<?php echo Helper::get_social_networks($networks, '<a class="aheto-team-member__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>'); ?>
			</div>
		<?php } ?>
	</div>
</div>
