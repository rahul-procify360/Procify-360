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
$this->add_render_attribute('wrapper', 'class', $align);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--famulus-creative');

$overlay  = isset($overlay) && !empty($overlay) ? 'overlay-show' : '';
$link_url = isset($link_url) && !empty($link_url) ? $link_url : '#';


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-features-single-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>

		<?php
		// Icon.
		if ( !empty($s_image) ) { ?>
			<div class="aheto-content-block__img-wrap">
				<?php echo '<img src="' . $s_image['url'] . '" alt="' . $s_heading . '">'; ?>
			</div>
		<?php } ?>

		<div class="aheto-content-block__info-wrap">
			<?php if ( !empty($s_heading) ) : ?>
				<h5 class="aheto-content-block__title"><?php echo wp_kses_post($this->highlight_text($s_heading)); ?></h5>
			<?php endif; ?>

			<?php if ( !empty($s_description) ) : ?>
				<p class="aheto-content-block__info-text">
					<?php echo wp_kses_post($s_description); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>

</div>
