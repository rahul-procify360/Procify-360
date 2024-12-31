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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--acacio-simple-image');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-features-single-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-content-block__shape"></div>
		<div class="aheto-content-block__wrap <?php echo esc_html($acacio_content_orientation) ?>">

            <?php if (isset($s_image) && !empty($s_image)  ) : ?>
                <?php echo \Aheto\Helper::get_attachment( $s_image, ['class' => 'aheto-content-block__image'], $acacio_image_size, $atts, 'acacio_' ); ?>
            <?php endif; ?>

            <div class="aheto-content-block__content">
                <?php if (isset($acacio_title) && !empty($acacio_title) ) : ?>
                    <h5 class="aheto-content-block__title"><?php echo esc_html($acacio_title); ?></h5>
                <?php endif; ?>

                <div class="aheto-content-block__info">
                    <?php if (isset($acacio_description) && !empty($acacio_description)  ) : ?>
                        <p class="aheto-content-block__info-text ">
                            <?php echo wp_kses_post($acacio_description); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

		</div>
	</div>

</div>
