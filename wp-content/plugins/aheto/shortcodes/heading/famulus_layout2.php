<?php
/**
 * The Bg Text Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--famulus__in-one-line');
$this->add_render_attribute('wrapper', 'class', $alignment);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $famulus_white_text == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-heading__white-text');
}
if ( $famulus_white_add_text == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-heading__white-highlight-text');
}
$animation = isset($title_animation) && !empty($title_animation);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-heading-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if (!empty($heading)) { ?>
	<<?php echo esc_attr($text_tag); ?> class="aheto-heading__title">
	<?php echo wp_kses($this->highlight_text($heading, $animation), 'post'); ?>
</<?php echo esc_attr($text_tag); ?>>
<?php } ?>
<?php if ( !empty($famulus_link_title) && !empty($famulus_link_url) ) { ?>
	<?php if ( $famulus_hide_line == false ) { ?>
		<div class="aheto-heading__line"></div>
	<?php } ?>
	<a href="<?php echo esc_url($famulus_link_url); ?>"
	   class="aheto-heading__link <?php echo esc_attr($famulus_link_arrow) == true ? 'aheto-heading__link-arrow' : ''; ?>">
		<?php echo esc_html($famulus_link_title); ?>
	</a>
<?php } ?>

</div>
