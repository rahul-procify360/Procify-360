<?php

/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     KARMA <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

$tabs = $this->parse_group($karma_business_tabs);
if (empty($tabs)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-tabs--karma-business');
$this->add_render_attribute('wrapper', 'class', 'js-tab');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-tabs/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma-business-layout1', $shortcode_dir . 'assets/css/karma_business_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-features-tabs__content">
		<?php foreach ($tabs as $index => $item) :

			$title_tag = isset($item['karma_business_title_tag']) && !empty($item['karma_business_title_tag']) ? $item['karma_business_title_tag'] : 'h1';
			$active = $index > 0 ? '' : 'active';
			$reverse = isset($item['karma_business_reverse']) && !empty($item['karma_business_reverse']) ? 'reverse' : '';
			$hide_divider = isset($item['karma_business_hidedivider']) && !empty($item['karma_business_hidedivider']) ? 'hide' : '';
			$hide_overlay = isset($item['karma_business_hideoverlay']) && !empty($item['karma_business_hideoverlay']) ? 'hide-overlay' : '';
			$background_image = Helper::get_background_attachment($item['karma_business_bg_image'], $image_size, $atts, ''); ?>

			<div class="aheto-features-tabs__box js-tab-box <?php echo esc_attr($active); ?>">
				<div class="aheto-features-tabs__box-inner <?php echo esc_attr($reverse); ?>" <?php echo esc_attr($background_image); ?>>


					<div class="aheto-features-tabs__box-content <?php echo esc_attr($hide_overlay); ?>">

						<?php if (!empty($item['karma_business_title'])) :

							echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . wp_kses($item['karma_business_title'], 'post') . '</' . $title_tag . '>';

						endif; ?>

						<div class="aheto-features-tabs__box-divider <?php echo esc_attr($hide_divider); ?>"></div>

						<?php if ($item['main_add_button'] || $item['add_add_button']) { ?>

							<div class="aheto-features-tabs__box-buttons">

								<?php
								    echo Helper::get_button($this, $item, 'main_');
                                    echo Helper::get_button($this, $item, 'add_');
                                ?>

							</div>

						<?php } ?>


					</div>

				</div>
			</div>

		<?php endforeach; ?>

	</div>

	<div class="aheto-features-tabs__head">
		<ul class="aheto-features-tabs__list ">

			<?php foreach ($tabs as $index => $item) :

				$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
				$active = $index > 0 ? '' : 'active'; ?>

				<li class="aheto-features-tabs__list-item <?php echo esc_attr($active); ?>">

					<a href="#" class="aheto-features-tabs__list-link js-tab-list">
						<?php
                            $indexNamber = $index;
                            $indexNamber++;

                            echo '<span>' . str_pad($indexNamber, 2, "0", STR_PAD_LEFT) . '.' . '</span>'
                        ?>


						<?php if ( !empty($item['karma_business_main_heading'] )) :

							echo esc_html($item['karma_business_main_heading']);

						endif; ?>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>
	</div>


</div>
