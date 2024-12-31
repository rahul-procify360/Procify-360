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
$famulus_info = $this->parse_group($famulus_info);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', ' widget_aheto__contact_info--famulus-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-contact-info-layout2', $shortcode_dir . 'assets/css/famulus_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $famulus_info as $item ) : ?>
		<div class="widget_aheto__infos">
			<?php if ( !empty($item['icon_font']) ): ?>
				<div class="widget_aheto__icon">
					<?php
					$icon = $item['icon_font'];
					if ( $icon == 'ionicons' ) { ?>
						<i class="<?php echo wp_kses($item['icon_ionicons'], 'post'); ?>"></i>
					<?php } else { ?>
						<i class="<?php echo wp_kses($item['icon_font-awesome'], 'post'); ?>"></i>
					<?php } ?>
				</div>
			<?php endif; ?>
			<div class="widget_aheto__text-block">

				<?php if ( !empty($item['famulus_title']) ) { ?>
					<div class="widget_aheto__title">
						<?php echo wp_kses($item['famulus_title'], 'post') ?>
					</div>
				<?php } ?>
				<?php if ( !empty($item['famulus_desc']) ): ?>
					<p class="widget_aheto__desc">
						<?php echo wp_kses($item['famulus_desc'], 'post') ?>
					</p>
				<?php endif; ?>
				<?php if ( !empty($item['famulus_location']) ): ?>
					<p class="widget_aheto__link">
						<i class="ion-android-home"></i>
						<?php echo wp_kses($item['famulus_location'], 'post') ?>
					</p>
				<?php endif; ?>
				<?php if ( !empty($item['famulus_phone']) ): ?>
					<p class="widget_aheto__link">
						<i class="ion-android-call"></i>
						<a href="tel:<?php echo esc_attr(str_replace(" ", "", $item['famulus_phone'])); ?>">
							<?php _e('Phone:', 'famulus') ?>
							<?php echo wp_kses($item['famulus_phone'], 'post') ?></a>
					</p>
				<?php endif; ?>
				<?php if ( !empty($item['famulus_email']) ): ?>
					<p class="widget_aheto__link">
						<i class="ion-android-mail"></i>
						<a href="mailto:<?php echo esc_html($item['famulus_email']) ?>">
							<?php _e('Email:', 'famulus') ?>
							<?php echo wp_kses($item['famulus_email'], 'post') ?></a>
					</p>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
