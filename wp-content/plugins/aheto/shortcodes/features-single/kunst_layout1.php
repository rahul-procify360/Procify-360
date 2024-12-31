<?php

/**
 * The Kunst Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-features--kunst__modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Button.
$button = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-features-single-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
        <div class="aheto-features-block__shape"></div>
		<div class="aheto-features-block__wrap">
			<?php
				if ( ! empty( $kunst_number_section ) ) :
			?>
				<div class="aheto-features-block__number">
					<?php echo esc_html($kunst_number_section); ?>
				</div>
			<?php endif; ?>

			<?php if ( $s_image ) : ?>
				<div class="aheto-features-block__image">
					<?php echo \Aheto\Helper::get_attachment( $s_image, [], $kunst_image_size, $atts, 'kunst_' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( !empty($s_heading) ) : ?>
				<h4 class="aheto-features-block__title aheto-content-block__title"><?php echo esc_html($s_heading); ?></h4>
			<?php endif; ?>

			<?php if ( !empty($s_description) ) : ?>
				<div class="aheto-features-block__info">
					<p class="aheto-features-block__info-text aheto-content-block__info-text">
						<?php echo wp_kses($s_description, 'post'); ?>
					</p>
				</div>
			<?php endif; ?>

			<?php
				if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) :
					$this->add_render_attribute( 'button', $button );
					$this->add_render_attribute( 'button', 'class', 'aheto-link aheto-btn--dark' );
			?>
				<div class="aheto-features-block__btn">
					<a <?php $this->render_attribute_string( 'button' ); ?>><?php echo esc_html( $button['title'] ); ?></a>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>
