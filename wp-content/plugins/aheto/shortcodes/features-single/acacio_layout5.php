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
$acacio_active = isset($acacio_active) && $acacio_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('block_wrapper', 'class', $acacio_active);

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-features--acacio-simple-scaled-subtitle');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-features-single-layout5', $shortcode_dir . 'assets/css/acacio_layout5.css', null, null);

}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__shape"></div>
		<div class="aheto-features-block__wrap">

            <?php if (isset($s_image) && !empty($s_image)) : ?>
                <?php echo \Aheto\Helper::get_attachment( $s_image, ['class' => 'aheto-features-block__image'], $acacio_image_size, $atts, 'acacio_' ); ?>
            <?php endif; ?>

            <div class="aheto-features-block__content">
                <?php if (isset($s_heading)  && !empty($s_heading) ) : ?>
                    <h2 class="aheto-content-block__title">
                        <?php echo esc_html($s_heading); ?><?php if (!empty($acacio_end_symbol) && isset($acacio_end_symbol)) { ?><span><?php echo esc_html($acacio_end_symbol); ?></span>
                        <?php } ?>

                    </h2>
                <?php endif; ?>

                <?php if (isset($acacio_subtitle) && !empty($acacio_subtitle) ) : ?>
                    <h5 class="aheto-features-block__subtitle"><?php echo esc_html($acacio_subtitle); ?></h5>
                <?php endif; ?>

                <div class="aheto-features-block__info">
                    <?php if (isset($s_description) && !empty($s_description)) : ?>
                        <p class="aheto-content-block__info-text ">
                            <?php echo wp_kses_post($s_description); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if ($acacio_main_add_button) { ?>
                    <div class="aheto-features__links">
                        <?php if ( $acacio_main_add_button ) {
                            echo \Aheto\Helper::get_button( $this, $atts, 'acacio_main_' );
                        } ?>
                    </div>
                <?php } ?>
            </div>

		</div>

	</div>

</div>
