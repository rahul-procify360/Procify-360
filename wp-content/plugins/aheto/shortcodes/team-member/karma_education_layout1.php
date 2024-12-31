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
$this->add_render_attribute('wrapper', 'class', 'aheto-team-member--karma_education-simple');
$this->add_render_attribute('wrapper', 'class', $karma_education_align);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team-member/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_education-team-member-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}

// parse networks
$networks = $this->parse_group($networks);

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-team-member__img-wrap">

		<?php if ( !empty($image) ) :
			$background_image = Helper::get_background_attachment($image, $image_size, $atts); ?>
			<div class="aheto-team-member__img-holder" <?php echo esc_attr($background_image);?>>
			</div>
		<?php endif; ?>

		<?php if ( !empty($networks) ) { ?>
			<div class="aheto-team-member__contact">
				<?php echo Helper::get_social_networks($networks, '<a class="aheto-team-member__link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i></a>'); ?>
			</div>
		<?php } ?>

	</div>
	<div class="aheto-team-member__text">
		<?php
            // Designation.
            if ( !empty($designation) ) {
                echo '<p class="aheto-team-member__position">' . esc_html($designation) . '</p>';
            }

            // Name.
            if ( !empty($name) ) {
                echo '<h5 class="aheto-team-member__name">' . wp_kses($name, 'post') . '</h5>';
            }

            // Designation.
            if ( !empty($karma_education_desc) ) {
                echo '<p class="aheto-team-member__desc">' . esc_html($karma_education_desc) . '</p>';
            }

            // Link.
            if ( !empty($karma_education_link) ) {
                echo '<a href="'.esc_url($karma_education_link).'" class="aheto-team-member__link-bottom">+</a>';
            }
		?>
	</div>
</div>
