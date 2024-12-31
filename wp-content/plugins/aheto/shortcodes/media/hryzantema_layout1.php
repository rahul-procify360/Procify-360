<?php
/**
 * The HR Consult Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($hryzantema_image) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-single-img--hr' );
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_script('hryzantema-media-layout1', $shortcode_dir . 'assets/js/hryzantema_layout1.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php $size = !empty($hryzantema_max_width_hide['size']) ? 'data-width="'.esc_attr($hryzantema_max_width_hide['size']).'"' : ''?>
    <div class="aheto-single-img <?php echo esc_attr($align); ?>" <?php echo $size; ?>>
        <?php if ( !empty($hryzantema_image)) : ?>
            <?php echo \Aheto\Helper::get_attachment( $hryzantema_image, ['class' => 'aheto-single-img__img'], $hryzantema_image_size, $atts, 'hryzantema_' ); ?>
        <?php endif; ?>
    </div>

</div>
