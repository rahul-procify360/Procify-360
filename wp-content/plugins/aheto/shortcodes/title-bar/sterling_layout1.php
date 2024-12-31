<?php

/**
 * Title bar templates.
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'sterling-breadcrumbs--only');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'sterling-title-bar-layout1', $shortcode_dir . 'assets/css/sterling_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-titlebar__content">
		<?php
		$title = $this->get_heading();
		if (!empty($title)) {
			$title_alignment = isset($title_alignment) && !empty($title_alignment) ? $title_alignment : '';
			echo '<h3 class="aheto-titlebar__title">' .  $title . '</h3>';
		}  ?>
	</div>
	<ul class="aht-breadcrumbs">
		<li class="aht-breadcrumbs__item">
			<a href="<?php echo esc_url(get_home_url('/')); ?>"><?php esc_html_e('Home', 'sterling'); ?></a>
		</li>
		<li class="aht-breadcrumbs__item current"><?php echo get_the_title(); ?></li>
	</ul>
</div>
