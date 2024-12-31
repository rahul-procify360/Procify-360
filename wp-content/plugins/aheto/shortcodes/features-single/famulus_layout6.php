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

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $align);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--famulus-with-icon-modern');

if ( $famulus_active == true ) {
	$this->add_render_attribute('block_wrapper', 'class', 'active');
}
$link_url = isset($link_url) && !empty($link_url) ? $link_url : '#';
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-features-single-layout6', $shortcode_dir . 'assets/css/famulus_layout6.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__wrap <?php if ( $famulus_img_full == true ) echo ' aheto-content-block__wrap-img-full ' ?>">
			<?php if ( !empty($s_image) ) : ?>
				<?php if ( $famulus_img_full == true ):
					$background_image = \Aheto\Helper::get_background_attachment($s_image, $famulus_image_size, $atts);

					?>
					<div class="aheto-content-block__image-full" <?php echo esc_attr($background_image); ?>>
					</div>
				<?php else: ?>
					<div class="aheto-content-block__image">
						<?php echo \Aheto\Helper::get_attachment($s_image, ['class' => 'svg'], $famulus_image_size, $atts); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="aheto-content-block__inner <?php if ( $famulus_img_full == true ) echo ' aheto-content-block__inner-img-full ' ?>">

				<div class="aheto-content-block__content">

					<?php if ( !empty($s_heading) ) : ?>
						<h4 class="aheto-content-block__title "><?php echo wp_kses_post($this->highlight_text($s_heading)); ?></h4>
					<?php endif; ?>

					<div class="aheto-content-block__info">
						<?php if ( !empty($s_description) ) : ?>
							<p class="aheto-content-block__info-text ">
								<?php echo wp_kses_post($s_description); ?>
							</p>
						<?php endif; ?>
					</div>
					<div class="aheto-content-block__link-wrap">
						<?php if ( !empty($link_title) ) : ?>
							<a href="<?php echo esc_url($link_url['url']); ?>" class="aheto-content-block__link-text ">
								<?php echo wp_kses_post($link_title); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
