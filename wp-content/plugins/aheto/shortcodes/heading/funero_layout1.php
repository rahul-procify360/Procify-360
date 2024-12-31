<?php
/**
 * The Heading Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--funero-simple');
$this->add_render_attribute('wrapper', 'class', $funero_align);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-heading-layout1', $shortcode_dir . 'assets/css/funero_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	// Heading.
	if ( !empty($funero_title_bg) ) {
		echo '<div class="aheto-heading__title-bg">' . esc_html($funero_title_bg) . '</div>';
	}
	if ( !empty($funero_subtitle) ) {
		if ( $funero_use_subtitle_space == true && !empty($funero_subtitle_space) ) {
				$subtitle_space = is_numeric($funero_subtitle_space) ? 'style="margin-bottom: ' . $funero_subtitle_space . 'px;"' : '';

		} else {
			$subtitle_space = '';
		}
		echo '<h6 class="aheto-heading__subtitle" ' . esc_attr($subtitle_space) . '>' . esc_html($funero_subtitle) . '</h6>';
	}

	if ( !empty($funero_title) ) {
		if ( $funero_use_title_space == true && !empty($funero_title_space) ) {
				$title_space = is_numeric($funero_title_space)  ? 'style="margin-bottom: ' . $funero_title_space . 'px;"' : '';
		} else {
			$title_space = '';
		}
		echo '<' .esc_attr( $funero_title_tag ). ' class="aheto-heading__title" ' . esc_attr($title_space) . '>' . esc_html($funero_title) . '</' . esc_attr($funero_title_tag) . '>';
	}

	if ( !empty($funero_desc) ) {
		if ( $funero_use_desc_space == true && !empty($funero_desc_space) ) {
				$desc_space =  is_numeric($funero_desc_space) ?'style="margin-bottom: ' . $funero_desc_space . 'px;"' : '';

		} else {
			$desc_space = '';
		}
		echo '<p class="aheto-heading__desc  " ' . esc_attr($desc_space) . '>' . wp_kses($funero_desc, 'post') . '</p>';
	}
	if ( !empty($funero_bottom_image) ) :
		echo Helper::get_attachment($funero_bottom_image, ['class' => 'aheto-heading__image-bottom']);
	endif; ?>
</div>

