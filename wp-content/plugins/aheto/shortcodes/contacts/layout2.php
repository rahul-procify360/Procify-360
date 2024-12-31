<?php
/**
 * The Contacts Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$button = $this->get_button_attributes('link');
$networks = $this->parse_group($networks);
$use_newtab = isset($use_newtab) && $use_newtab ? '_blank' : '_self';
$rel_attr = isset($use_newtab) && $use_newtab ? 'rel="noreferrer noopener"' : '';
/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('contacts-style-2', $sc_dir . 'assets/css/layout2.css', null, null);
}


?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-contact aheto-contact--modern">

		<?php if (!empty($s_heading)) : ?>
			<p class="aheto-contact__type t-uppercase t-medium"><?php echo wp_kses_post($s_heading); ?></p>
		<?php endif; ?>

		<?php if (!empty($address)) : ?>
			<h3 class="aheto-contact__info t-light"><?php echo wp_kses_post($address); ?></h3>
		<?php endif; ?>

		<?php if (!empty($email)) : ?>
			<a class="aheto-contact__link aheto-contact__mail t-light"
			   href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
		<?php endif; ?>

		<?php if (!empty($phone)) :
			$tel_phone = str_replace(" ", "", $phone); ?>
			<a class="aheto-contact__link aheto-contact__tel t-light"
			   href="tel:<?php echo esc_attr($tel_phone); ?>"><?php echo esc_html($phone); ?></a>
		<?php endif; ?>

		<?php
		if (isset($button['href']) && !empty($button['href'])) :
			$this->add_render_attribute('button', $button);
			$this->add_render_attribute('button', 'class', 'aheto-contact__link-dir aheto-link aheto-btn--primary');
			?>
			<div class="aheto-contact__link-holder">
				<a <?php $this->render_attribute_string('button'); ?>><?php echo esc_html($button['title']); ?></a>
			</div>
		<?php endif; ?>

		<?php if (!empty($networks)) { ?>
			<div class="aht-socials">

				<?php echo Helper::get_social_networks($networks, '<a class="aht-socials__link" href="%1$s"  target=' . $use_newtab . ' ' . $rel_attr . '><i class="aht-socials__icon icon ion-social-%2$s"></i></a>'); ?>

			</div>
		<?php } ?>

	</div>

</div>
