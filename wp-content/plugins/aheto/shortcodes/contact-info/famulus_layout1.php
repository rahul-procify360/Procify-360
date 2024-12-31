<?php
/**
 * Contact Info default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$contact = $this->parse_group($famulus_contact);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', ' widget_aheto__contact_info--modern-famulus');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$underline   = isset($underline) && $underline ? 'underline' : '';
$title_space = isset($title_space) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute('title', 'class', 'widget_aheto__title');
$this->add_render_attribute('title', 'class', $underline);
$this->add_render_attribute('title', 'class', $title_space);


$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-contact-info-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php if ( !empty($text_logo) && $type_logo == 'text' ) { ?>
		<div class="widget_aheto__logo">
			<h2><?php echo esc_html($text_logo); ?></h2>
		</div>
	<?php } elseif ( is_array($logo) && !empty($logo['url']) || !is_array($logo) && !empty($logo) ) { ?>

		<div class="widget_aheto__logo">
			<?php echo Helper::get_attachment($logo, ['class' => 'aheto-clients__img']); ?>
		</div>

	<?php } ?>

	<div class="widget_aheto__infos">

		<?php foreach ( $contact as $item ) : ?>
			<?php if ( !empty($item['famulus_add']) ): ?>
				<p class="widget_aheto__address">
					<?php echo wp_kses($item['famulus_add'], 'post') ?>
				</p>
			<?php endif;
			if ( $item['famulus_footer_social'] == true ) { ?>
				<div class="widget_aheto__contact">
					<?php
					echo Helper::get_social_networks_list('<a class="widget_aheto__link" href="%1$s"><i class="ion-social-%2$s"></i></a>', 'famulus_', $item);
					?>
				</div>
			<?php } ?>
			<?php if ( !empty($item['famulus_copyright']) ): ?>
				<p class="widget_aheto__copyright">
					© <?php echo ' ' . get_the_date('Y') . ' '; ?><?php echo wp_kses($item['famulus_copyright'], 'post') ?>
				</p>
			<?php endif; ?>

		<?php endforeach; ?>

	</div>

</div>
