<?php

/**
 * The Pricing Tables Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma_education-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

if ( $karma_education_active == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--karma_education-active');
}

// Button Link.
$link = $this->get_button_attributes('link');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('karma_education-pricing-tables-layout1', $shortcode_dir . 'assets/css/karma_education_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableColumn ">
		<div class="aheto-pricing__content ">
			<?php if ( !empty($karma_education_image) ) { ?>
				<div class="aheto-pricing__box-image">
					<?php echo Helper::get_attachment($karma_education_image, [], 'thumbnail', $atts); ?>
				</div>
			<?php } ?>

			<?php
                // Heading.
                if ( !empty($heading) ) {
                    $heading = str_replace(']]', '</span>', $heading);
                    $heading = str_replace('[[', '<span>', $heading);
                    echo '<h5 class="aheto-pricing__box-title">' . wp_kses($heading, 'post') . '</h5>';
                }

                if ( !empty($karma_education_subtitle) ) {
                    echo '<h6 class="aheto-pricing__subtitle">' . wp_kses($karma_education_subtitle, 'post') . '</h6>';
                }
			?>

			<?php

			$features = $this->parse_group($karma_education_pricings);
			if ( !empty($features) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {?>
					<div class="aheto-pricing__box-descr-wrap " >
						<?php if ( !empty($item['karma_education_pricings_heading']) ) {
						echo '<p class="aheto-pricing__box-price">' . esc_html($item['karma_education_pricings_heading']) . '</p>';
						}?>
						<?php if ( !empty($item['karma_education_pricings_label']) ) {
						echo '<p class="aheto-pricing__box-descr">' . esc_html($item['karma_education_pricings_label']) . '</p>';
						}?>
					</div>
			<?php 	}
				echo '</div>';
			} ?>

			<?php // Button Link.
			if ( $karma_events_add_button ) { ?>
				<div class="aheto-pricing__links">
					<?php echo Helper::get_button($this, $atts, 'karma_events_'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
