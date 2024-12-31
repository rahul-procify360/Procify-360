<?php

/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

extract($atts);

use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contact-form--karma-political__simple');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-forms/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'karma_political-contact-forms-layout1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-contact-form__form">

		<?php if ( ! empty( $contact_form ) ) : ?>

            <div class="<?php echo Helper::get_button( $this, $atts, 'form_', true ); ?>">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $contact_form ) . '"]' ); ?>
            </div>

		<?php endif; ?>

    </div>

</div>
