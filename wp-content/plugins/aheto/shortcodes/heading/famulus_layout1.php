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
if ( $famulus_white_text == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-heading__white-text');
}
if ( $famulus_white_add_text == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-heading__white-add-text');
}
$this->add_render_attribute('wrapper', 'class', 'aheto-heading--famulus__simple');
$this->add_render_attribute('wrapper', 'class', $alignment);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$animation = isset($title_animation) && !empty($title_animation);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-heading-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('typed');
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	// Heading.
	$heading = $this->get_heading();

	if ( !empty($famulus_subtitle) ) {
		echo '<' . $famulus_subtitle_tag . ' class="aheto-heading__subtitle">' . esc_html($famulus_subtitle) . '</' . $famulus_subtitle_tag . '>';
	}

	if ( !empty($heading) ) {
		echo '<' . $text_tag . ' class="aheto-heading__title">' . $this->highlight_text($heading, $animation) . '</' . $text_tag . '>';
	}

	if ( !empty($description) ) {
		echo '<p class="aheto-heading__desc">' . wp_kses($description, 'post') . '</p>';
	}
	if ( !empty($famulus_link_title) ) {
		echo '<a href="' . esc_url($famulus_link_url) . '" class="aheto-heading__link">' . wp_kses($famulus_link_title, 'post');
		if ( $famulus_link_arrow == true ) {
			echo '<i class="icon"></i>';
		};
		echo '</a>';
	}

	foreach ( $famulus_socials_links as $item ):
		if ( $item['famulus_socials'] == true ):?>
			<div class="aheto-heading__socials">
				<?php $networks = \Aheto\Helper::choices_social_network();
				$html           = '';
				$template       = '<a class="aheto-heading__soc-link" href="%1$s" target="_blank" rel="noreferrer noopener"><i class="ion-social-%2$s"></i>%3$s</a>';
				$prefix         = 'famulus_soc_link';
				foreach ( $networks as $key => $name ) {
					$social = $prefix . $key;
					if ( !empty($item) ) {
						if ( empty($item[$social]) ) {
							continue;
						}
						$html .= sprintf($template, esc_url($item[$social]), strtolower($name), strtoupper($name));
					} else {
						if ( empty($item[$social]) ) {
							continue;
						}
						$html .= sprintf($template, esc_url($social), strtolower($name), strtoupper($name));
					}
				}
				echo wp_kses($html, 'post'); ?>
			</div>
		<?php endif;
	endforeach; ?>
</div>
