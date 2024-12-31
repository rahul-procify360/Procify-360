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

$features = $this->parse_group($acacio_features_modern_vertical);

if ( empty($features) ) {
	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--acacio-modern-vertical');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-features-single-layout6', $shortcode_dir . 'assets/css/acacio_layout6.css', null, null);
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('acacio-features-single-layout6-js', $shortcode_dir . 'assets/js/acacio_layout6.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
			<?php foreach ( $features as $key=>$feature ) :
					$feature = wp_parse_args($feature, [
						'acacio_features_image'         => '',
						'acacio_features_counter_bg'    => '',
						'acacio_features_title'         => '',
						'acacio_features_desc'          => '',
						'acacio_features_title_image'   => '',
					]);
					extract($feature);

					if ( empty($acacio_features_title) ) {
						continue;
					} ?>
					<div class="aheto-features-block__item">
						<?php if ( isset($acacio_features_image) ) : ?>
							<div class="aheto-features-block__image">
								<?php echo \Aheto\Helper::get_attachment( $acacio_features_image, ['class' => ''], $acacio_image_size, $atts, 'acacio_'  ); ?>
							</div>
						<?php endif; ?>

						<?php if (isset($acacio_features_title) && !empty($acacio_features_title)  ) : ?>
							<div class="aheto-features-block__title" data-bg="<?php echo esc_attr($acacio_features_title_image['url']) ?>">
								<h5><?php echo esc_html($acacio_features_title); ?></h5>
								<?php echo \Aheto\Helper::get_attachment($acacio_features_title_image, ['class' => 'js-bg']); ?>

								<div class="aheto-features-block__counter">
									<?php echo \Aheto\Helper::get_attachment($acacio_features_counter_bg, ['class' => 'js-bg']); ?>
									<h3>
										<?php echo esc_html($key+1 . '.') ?>
									</h3>
								</div>

							</div>

						<?php endif; ?>

						<?php if (isset($acacio_features_desc) && !empty($acacio_features_desc) ) : ?>
							<p class="aheto-features-block__info-text ">
								<?php echo wp_kses_post($acacio_features_desc); ?>
							</p>
						<?php endif; ?>
					</div>

				<?php endforeach; ?>
	</div>

</div>
