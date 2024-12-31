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

extract( $atts );

$this->generate_css();

$aira_active = $aira_active ? 'aheto-pricing__active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget widget_aheto' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $aira_active );

// Block Wrapper.
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-features--aira-group' );

$aira_overlay  = isset( $aira_overlay ) && ! empty( $aira_overlay ) ? 'overlay-show' : '';
$aira_link_url = isset( $aira_link_url ) && ! empty( $aira_link_url ) ? $aira_link_url : '#';



/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-features-single-group', $sc_dir . 'assets/css/aira_layout6.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div <?php $this->render_attribute_string( 'block_wrapper' ); ?>>

        <a href="<?php echo esc_url( $aira_link_url ); ?>">

			<?php $background_image = \Aheto\Helper::get_background_attachment( $s_image, $aira_image_size, $atts, 'aira_' ); ?>

            <div class="aheto-features-block__wrap s-back-switch <?php echo esc_attr( $aira_overlay ); ?>" <?php echo esc_attr( $background_image ); ?>>
				<?php if ( $aira_overlay ) : ?>
                    <span class="aheto-features-block__overlay">
                    </span>
				<?php endif; ?>

				<?php if ( ! empty( $s_heading ) || ! empty( $s_description ) || ! empty( $aira_logo_image ) ) : ?>
                    <div class="aheto-features-block__info">
						<?php if ( ! empty( $aira_logo_image ) ) : ?>
                            <div class="aheto-features-block__image-logo">
								<?php echo \Aheto\Helper::get_attachment( $aira_logo_image, [], $aira_logo_image_size, $atts, 'aira_logo_' ); ?>
                            </div>
						<?php endif; ?>

                        <?php if ( ! empty( $s_heading ) ) : ?>
                            <h6><p class="aheto-features-block__title"><?php echo esc_html( $s_heading ); ?></p></h6>
                        <?php endif; ?>

						<?php if ( ! empty( $s_description ) ) : ?>
                            <h6><p class="aheto-features-block__text ">
									<?php echo wp_kses_post( $s_description ); ?>
                                </p></h6>
						<?php endif; ?>
                    </div>
				<?php endif; ?>

            </div>
        </a>

    </div>

</div>
