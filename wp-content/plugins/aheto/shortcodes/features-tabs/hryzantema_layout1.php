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

$hryzantema_tabs = $this->parse_group($hryzantema_tabs);
if (empty($hryzantema_tabs)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-tabs--hr-classic');
$this->add_render_attribute('wrapper', 'class', 'js-tab');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-tabs/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-features-tabs-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>


	<div class="aheto-features-tabs__head">
		<ul class="aheto-features-tabs__list ">

			<?php foreach ($hryzantema_tabs as $index => $item) :

				$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
				$active = $index > 0 ? '' : 'active'; ?>

				<li class="aheto-features-tabs__list-item <?php echo esc_attr($active); ?>">

					<a href="#" class="aheto-features-tabs__list-link js-tab-list">
						<?php if (isset($item['hryzantema_tabs_title']) && !empty($item['hryzantema_tabs_title'])) :

							echo esc_html($item['hryzantema_tabs_title']);

						endif; ?>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>
	</div>


	<div class="aheto-features-tabs__content">
		<?php foreach ($hryzantema_tabs as $index => $item) :

			$title_tag = isset($item['title_tag']) && !empty($item['title_tag']) ? $item['title_tag'] : 'h1';
			$active = $index > 0 ? '' : 'active';
			$reverse = isset($item['reverse']) && !empty($item['reverse']) ? 'reverse' : ''; ?>

			<div class="aheto-features-tabs__box js-tab-box <?php echo esc_attr($active); ?>">
				<div class="aheto-features-tabs__box-inner <?php echo esc_attr($reverse); ?>">

					<div class="aheto-features-tabs__box-content">
						<?php if (!empty($item['hryzantema_tabs_content'])) : ?>

							<div class="aheto-features-tabs__box-description">
								<?php echo wp_kses_post($item['hryzantema_tabs_content']); ?>
							</div>

						<?php endif; ?>
					</div>

				</div>
			</div>

		<?php endforeach; ?>

	</div>


</div>
