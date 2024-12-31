<?php
/**
 * The Aira Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($pointe_image) ) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute( 'wrapper', 'class', 'aheto_media--pointe-gall' );
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
    wp_enqueue_style( 'pointe-media-layout3', $sc_dir . 'assets/css/pointe_layout3.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
	wp_enqueue_script('pointe-media-layout3-js', $sc_dir . 'assets/js/pointe_layout3.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto_media__img">
        <?php
        foreach ($pointe_image as $image) {
            ?>
            <div data-mfp-src="<?php echo esc_url($image['url']) ?>" class="aheto_media__item <?php echo esc_attr($pointe_media_width); ?>">
                    <span>
                        <?php echo Helper::get_attachment($image, ['class' => 'js-bg'], $pointe_image_size, $atts, 'pointe_'); ?>
                    </span>
            </div>
            <?php
        } ?>
    </div>
</div>
