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
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content-block--soapy-classic');
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-features-single-layout3', $shortcode_dir . 'assets/css/soapy_layout3.css', null, null);
}


?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__img-wrap">
			<?php if ( !empty($soapy_image_left) ) {
				echo Helper::get_attachment($soapy_image_left, ['class' => 'aheto-content-block__image']);
			} ?>
		</div>
		<div class="aheto-content-block__info">
			<?php

            $title_tag = isset($soapy_title_tag) && !empty($soapy_title_tag) ? $soapy_title_tag : 'h4';

            if ( !empty($soapy_title) ) :

                echo '<' . $title_tag . ' class="aheto-content-block__title">' . wp_kses($soapy_title, 'post') . '</' . $title_tag . '>';

             endif; ?>
			<?php if ( !empty($soapy_desc) ) : ?>
				<p class="aheto-content-block__info-text ">
					<?php echo wp_kses($soapy_desc, 'post'); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
