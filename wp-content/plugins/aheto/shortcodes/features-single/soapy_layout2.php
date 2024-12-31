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
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-modern');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-features-single-layout2', $shortcode_dir . 'assets/css/soapy_layout2.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>
			style="background:
			<?php if ( empty($soapy_color1) || empty($soapy_color2) ) { ?>
				<?php echo esc_attr($soapy_color1 . $soapy_color2); ?>
			<?php } else { ?>
					linear-gradient(155deg, <?php echo esc_attr($soapy_color1)?> 40%, <?php echo esc_attr($soapy_color2)?> )
			<?php } ?>">
		<?php if ( !empty($soapy_image_bg) ):
			$background_image = Helper::get_background_attachment($soapy_image_bg, $soapy_image_size, $atts, '');

		endif; ?>
		<div class="aheto-content-block__wrap" <?php echo esc_attr($background_image); ?>>
			<div class="aheto-content-block__text">
				<?php if ( !empty($soapy_title) ) : ?>
					<h4 class="aheto-content-block__title "><?php echo wp_kses($soapy_title, 'post'); ?></h4>
				<?php endif; ?>
				<div class="aheto-content-block__info">
					<?php if ( !empty($soapy_desc) ) : ?>
						<p class="aheto-content-block__info-text ">
							<?php echo wp_kses($soapy_desc, 'post'); ?>
						</p>
					<?php endif; ?>

					<?php if ( !empty($soapy_link_title) ) :
						$button = $this->get_link_attributes( $soapy_link_url );
						$this->add_render_attribute( 'button', $button );
						$this->add_render_attribute( 'button', 'class', 'aheto-content-block__link' ); ?>
						<div class="aheto-content-block__link-wrap <?php echo esc_attr($soapy_align); ?>">
							<a <?php $this->render_attribute_string( 'button' ); ?>>
								<?php echo esc_html($soapy_link_title); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
