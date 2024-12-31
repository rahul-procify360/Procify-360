<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

extract($atts);
use Aheto\Helper;

$features = $this->parse_group($hr_features_modern_horizontal);

if ( empty($features) ) {
	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--hr-modern-horizontal');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-features-single-layout7', $shortcode_dir . 'assets/css/hryzantema_layout7.css', null, null);
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('hryzantema-features-single-layout7-js', $shortcode_dir . 'assets/js/hryzantema_layout7.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
			<?php foreach ( $features as $key=>$feature ) :
                $feature = wp_parse_args($feature, [
						'hryzantema_features_image'         => '',
						'hryzantema_features_counter_bg'    => '',
						'hryzantema_features_title'         => '',
						'hryzantema_features_desc'          => '',
						'hryzantema_features_title_image'   => '',
					]);
					extract($feature);

                    if ( empty($hryzantema_features_title) ) {
                        continue;
                    } ?>
					<div class="aheto-features-block__item">
						<?php if ( !empty($hryzantema_features_title) && !empty($hryzantema_features_title_image['url'])) : ?>
                            <?php
                                $hryzantema_feature_counter_bg = !empty($hryzantema_features_counter_bg) ?  \Aheto\Helper::get_background_attachment( $hryzantema_features_counter_bg, $hryzantema_image_size, $atts, 'hryzantema_' ) : '';

                                $hryzantema_feature_title_bg =  !empty($hryzantema_features_title_image) ?  \Aheto\Helper::get_background_attachment( $hryzantema_features_title_image, $hryzantema_image_size, $atts, 'hryzantema_' ) : '';
                            ?>
							<div class="aheto-features-block__title" data-bg="<?php echo esc_url($hryzantema_features_title_image['url']) ?>" <?php echo esc_attr($hryzantema_feature_title_bg); ?>>

								<h5><?php echo esc_html($hryzantema_features_title); ?></h5>


								<div class="aheto-features-block__counter" <?php echo esc_attr($hryzantema_feature_counter_bg); ?>>
									<h3>
										<?php echo wp_kses_post($key+1 . '.') ?>
									</h3>
								</div>

							</div>


						<?php endif; ?>
					</div>

				<?php endforeach; ?>
	</div>

</div>
