<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$left_links = $this->parse_group($left_links);
$right_links = $this->parse_group($right_links);

$right_hide_mobile = isset($right_hide_mobile) && !empty($right_hide_mobile) ? 'hide-mobile' : '';
$left_hide_mobile = isset($left_hide_mobile) && !empty($left_hide_mobile) ? 'hide-mobile' : '';


if (empty($left_links) && empty($right_links)) {
	return '';
}

$remove_borders = $remove_borders ? 'aheto-navbar__remove-borders' : '';

$this->generate_css();


// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar aheto-navbar--modern');
$this->add_render_attribute('wrapper', 'class', $columns . '-columns');
$this->add_render_attribute('wrapper', 'class', $remove_borders);
$this->add_render_attribute('wrapper', 'class', $transparent);

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('navbar-style-1', $sc_dir . 'assets/css/layout1.css', null, null);
}


?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--wrap">
		<div class="aheto-navbar--inner">

			<?php if (!empty($left_links)) { ?>
				<div class="aheto-navbar--left <?php echo esc_attr($left_hide_mobile); ?>">

					<?php foreach ($left_links as $index => $link) : ?>

						<div class="aheto-navbar--item">

							<?php if (!empty($link['label']) && ($link['type_link'] == 'text')) : ?>
								<span class="aheto-navbar--item-label"><?php echo esc_html($link['label']); ?></span>
							<?php endif; ?>


							<?php if ((!empty($link['label']) || $link['add_icon']) && ($link['type_link'] == 'phone' || $link['type_link'] == 'email')) : ?>
								<span class="aheto-navbar--item-label">

                                 <?php if ($link['type_link'] == 'phone' && $link['add_icon']) : ?>
									 <i class="ion-ios-telephone<?php echo esc_attr($link['type_icon']); ?>"></i>
								 <?php endif; ?>

									<?php if ($link['type_link'] == 'email' && $link['add_icon']) : ?>
										<i class="ion-ios-email<?php echo esc_attr($link['type_icon']); ?>"></i>
									<?php endif; ?>

									<?php if (!empty($link['label'])) {
										echo esc_html($link['label']);
									} ?>
                            </span>
							<?php endif; ?>

							<?php if (!empty($link['phone']) && $link['type_link'] == 'phone') :
								$tel_phone = str_replace(" ", "", $link['phone']); ?>
								<a href="tel:<?php echo esc_attr($tel_phone); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['phone']); ?></a>
							<?php endif; ?>

							<?php if (!empty($link['email']) && $link['type_link'] == 'email') : ?>
								<a href="mailto:<?php echo esc_attr($link['email']); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['email']); ?></a>
							<?php endif; ?>

							<?php if (!empty($link['custom_link']) && !empty($link['label']) && $link['type_link'] == 'custom') : ?>
								<a href="<?php echo esc_url($link['custom_link']); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['label']); ?></a>
							<?php endif;


							if ($link['type_link'] == 'socials') {
								$link['font_icon'] = isset($link['font_icon']) && !empty($link['font_icon']) ? $link['font_icon'] : 'ionicons';
								$font_icon = $link['font_icon'] == 'ionicons' ? 'ion-social-' : 'el social_';
								echo Helper::get_social_networks_list('<a class="aheto-navbar--item-link icon" href="%1$s"><i class="' . $font_icon . '%2$s"></i></a>', 'left_links_', $link);

							} ?>

						</div>

					<?php endforeach; ?>


				</div>
			<?php }

			if ($columns == 'two' && !empty($right_links)) { ?>
				<div class="aheto-navbar--right <?php echo esc_attr($right_hide_mobile); ?>">

					<?php foreach ($right_links as $index => $link) : ?>

						<div class="aheto-navbar--item">

							<?php if (!empty($link['label']) && ($link['type_link'] == 'text')) : ?>
								<span class="aheto-navbar--item-label"><?php echo esc_html($link['label']); ?></span>
							<?php endif; ?>

							<?php if ((!empty($link['label']) || $link['add_icon']) && ($link['type_link'] == 'phone' || $link['type_link'] == 'email')) : ?>
								<span class="aheto-navbar--item-label">

                                 <?php if ($link['type_link'] == 'phone' && $link['add_icon']) : ?>
									 <i class="ion-ios-telephone<?php echo esc_attr($link['type_icon']); ?>"></i>
								 <?php endif; ?>

									<?php if ($link['type_link'] == 'email' && $link['add_icon']) : ?>
										<i class="ion-ios-email<?php echo esc_attr($link['type_icon']); ?>"></i>
									<?php endif; ?>

									<?php if (!empty($link['label'])) {
										echo esc_html($link['label']);
									} ?>
                            </span>
							<?php endif; ?>

							<?php if (!empty($link['phone']) && $link['type_link'] == 'phone') :
								$tel_phone = str_replace(" ", "", $link['phone']); ?>
								<a href="tel:<?php echo esc_attr($tel_phone); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['phone']); ?></a>
							<?php endif; ?>

							<?php if (!empty($link['email']) && $link['type_link'] == 'email') : ?>
								<a href="mailto:<?php echo esc_attr($link['email']); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['email']); ?></a>
							<?php endif; ?>

							<?php if (!empty($link['custom_link']) && !empty($link['label']) && $link['type_link'] == 'custom') : ?>
								<a href="<?php echo esc_url($link['custom_link']); ?>"
								   class="aheto-navbar--item-link"><?php echo esc_html($link['label']); ?></a>
							<?php endif;


							if ($link['type_link'] == 'socials') {

								$link['font_icon'] = isset($link['font_icon']) && !empty($link['font_icon']) ? $link['font_icon'] : 'ionicons';
								$font_icon = $link['font_icon'] == 'ionicons' ? 'ion-social-' : 'el social_';


								echo Helper::get_social_networks_list('<a class="aheto-navbar--item-link icon" href="%1$s"><i class="' . $font_icon . '%2$s"></i></a>', 'right_links_', $link);

							} ?>

						</div>

					<?php endforeach; ?>

				</div>
			<?php } ?>

		</div>
	</div>
</div>

