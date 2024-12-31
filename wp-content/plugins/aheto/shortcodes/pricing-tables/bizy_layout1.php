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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--bizy-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

if ( $bizy_active === true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--bizy-active');
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
    wp_enqueue_style('bizy-pricing-tables-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableColumn ">

			<?php
                // Heading.
                if ( !empty($heading) ) {
                    $heading = str_replace(']]', '</span>', $heading);
                    $heading = str_replace('[[', '<span>', $heading);
                    echo '<h5 class="aheto-pricing__box-title">' . wp_kses($heading, 'post') . '</h5>';
				}
				?>
				<div class="aheto-pricing__price-subtitle-wrapper" >
				<?php
					if ( !empty($bizy_price) ) {
						echo '<p class="aheto-pricing__box-price">' . wp_kses($bizy_price, 'post') .'</p>';
						}
					if ( !empty($bizy_subtitle) ) {
						echo '<h6 class="aheto-pricing__subtitle">' . wp_kses($bizy_subtitle, 'post') . '</h6>';
					}

				?>
				</div>



			<?php

			$features = $this->parse_group($bizy_pricings);
			if ( !empty($features) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {?>
					<div class="aheto-pricing__box-descr-wrap " >

						<?php if ( !empty($item['bizy_pricings_label']) ) {
						echo '<p class="aheto-pricing__box-descr">' . esc_html($item['bizy_pricings_label']) . '</p>';
						}?>
					</div>
			<?php 	}
				echo '</div>';
			} ?>

			<?php // Button Link.
			if ( $bizy_events_add_button ) { ?>
				<div class="aheto-pricing__links">
					<?php echo Helper::get_button($this, $atts, 'bizy_events_'); ?>
				</div>
			<?php } ?>

	</div>
</div>
