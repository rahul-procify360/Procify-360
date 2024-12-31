<?php

/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$kunst_use_dot = isset($kunst_use_dot) && !empty($kunst_use_dot) ? 'kunst-dot' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--kunst__with-image');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Button.
$button = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-features-single-layout2', $shortcode_dir . 'assets/css/kunst_layout2.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'kunst-features-single-layout2-js', $shortcode_dir . 'assets/js/kunst_layout2.min.js', array( 'jquery' ), null );
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__wrap">
            <div class="aheto-content-block__shape"></div>
            <div class="aheto-content-block__rect"></div>

			<?php if ( !empty($s_image) || !empty($kunst_hover_image) ) : ?>
				<div class="aheto-content-block__image">
					<?php echo \Aheto\Helper::get_attachment( $s_image, [], $kunst_image_size, $atts, 'kunst_' ); ?>
					<?php echo \Aheto\Helper::get_attachment( $kunst_hover_image, [], $kunst_image_size, $atts, 'kunst_' ); ?>
				</div>
			<?php endif; ?>

			<div class="aheto-content-block__inner">
				<div class="aheto-content-block__content">
					<?php if ( !empty($s_heading) ) : ?>
						<h5 class="aheto-content-block__title"><?php echo wp_kses($s_heading, 'post'); ?></h5>
					<?php endif; ?>

					<div class="aheto-content-block__info">
						<?php if ( !empty($s_description) ) : ?>
							<p class="aheto-content-block__info-text ">
								<?php echo wp_kses($s_description, 'post'); ?>
							</p>
						<?php endif; ?>
					</div>
                </div>
                <?php
                    if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) :
                        $this->add_render_attribute( 'button', $button );
                        $this->add_render_attribute( 'button', 'class', 'aheto-link aheto-btn--light' );
                        ?>
                    <div class="aheto-content-block__link">
                        <a <?php $this->render_attribute_string( 'button' ); ?>><?php echo esc_html( $button['title'] ); ?></a>
                    </div>
                <?php endif; ?>
			</div>
		</div>
	</div>
</div>
