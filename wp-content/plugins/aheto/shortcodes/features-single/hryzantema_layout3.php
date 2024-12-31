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
$hryzantema_active = isset($hryzantema_active) && $hryzantema_active ? 'active' : '';
// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('block_wrapper', 'class', $hryzantema_active);
// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--hr-simple-scaled');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-features-simple-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__shape"></div>
        <div class="aheto-features-block__wrap">

            <?php if ( !empty($s_image)  ) : ?>
                <?php echo \Aheto\Helper::get_attachment( $s_image, ['class' => 'aheto-features-block__image'], $hryzantema_image_size, $atts, 'hryzantema_' ); ?>
            <?php endif; ?>

            <div class="aheto-features-block__content">
                <?php if ( !empty($s_heading)) : ?>
                    <h4 class="aheto-content-block__title"><?php echo esc_html($s_heading); ?></h4>
                <?php endif; ?>

                <?php if ( !empty($hryzantema_subtitle)  ) : ?>
                    <h5 class="aheto-content-block__subtitle"><?php echo esc_html($hryzantema_subtitle); ?></h5>
                <?php endif; ?>

                <div class="aheto-features-block__info">
                    <?php if ( !empty($s_description) ) : ?>
                        <p class="aheto-content-block__info-text ">
                            <?php echo wp_kses_post($s_description); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if ($hryzantema_main_add_button == true) { ?>
                    <div class="aheto-features__links">
                        <?php echo \Aheto\Helper::get_button( $this, $atts, 'hryzantema_main_' ); ?>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>

</div>
