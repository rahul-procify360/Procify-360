<?php

/**
 * Navbar templates.
 */

use Aheto\Helper;

extract($atts);

$vestry_left_links = $this->parse_group($vestry_left_links);


if (empty($vestry_left_links)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--vestry');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-navbar-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--wrap">
		<div class="aheto-navbar--inner">
			<?php if (!empty($vestry_left_links)) { ?>
				<div class="aheto-navbar--left">
					<?php foreach ($vestry_left_links as $index => $link) : ?>
						<div class="aheto-navbar--item">
							<?php if (($link['vestry_add_icon']) && ($link['vestry_type_link'] == 'address' || $link['vestry_type_link'] == 'phone')) : ?>
								<span class="aheto-navbar--item-label">
                  <?php if ($link['vestry_type_link'] == 'address' && $link['vestry_add_icon']) : ?>
					  <i class="ion-android-pin<?php echo esc_attr($link['vestry_type_icon']); ?>"></i>
				  <?php endif; ?>
									<?php if ($link['vestry_type_link'] == 'phone' && $link['vestry_add_icon']) : ?>
										<i class="ion-ios-telephone<?php echo esc_attr($link['vestry_type_icon']); ?>"></i>
									<?php endif; ?>
                </span>
							<?php endif; ?>
							<?php if (!empty($link['vestry_address']) && $link['vestry_type_link'] == 'address') : ?>
								<a href="javascript:void(0);"
								   class="aheto-navbar--item-link address"><?php echo esc_html($link['vestry_address']); ?></a>
							<?php endif; ?>
							<?php if (!empty($link['vestry_phone']) && $link['vestry_type_link'] == 'phone') : ?>
								<a href="tel:<?php echo esc_attr(str_replace(' ', '', $link['vestry_phone'])); ?>"
								   class="aheto-navbar--item-link phone"><?php echo esc_html($link['vestry_phone']); ?></a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
