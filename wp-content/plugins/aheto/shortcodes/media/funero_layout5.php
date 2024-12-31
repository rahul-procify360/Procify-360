<?php
/**
 * The Funero Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
if ( !is_array($funero_images) ) {
	$image = explode(',', $funero_images);
}
if ( empty($funero_images) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-media--funero-par');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-media-layout5', $shortcode_dir . 'assets/css/funero_layout5.css', null, null);
}
$count = count($funero_images);

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php if ( 1 === $count ) :
    if ( !empty($funero_images) ) :?>
		<?php echo Helper::get_attachment($funero_images, ['class' => 'bb'], $atts['funero_media_image_size'], $atts, 'funero_media_'); ?>
	<?php
	endif;
	else : ?>

    <div class="par-wrapper">

        <?php foreach ( $funero_images as $item ) :
		if ( !empty($item) ) :?>
            <div class="par-item">
                <?php echo Helper::get_attachment($item, ['class' => 'bb'], $atts['funero_media_image_size'], $atts, 'funero_media_'); ?>
            </div>
        <?php endif;
        endforeach; ?>
    </div>
    <?php endif; ?>

</div>
