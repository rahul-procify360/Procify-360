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

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-content-block--moovit-text-with-icon' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


// Icon.
$icon = $this->get_icon_attributes( 'moovit_', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'moovit_icon', 'class', 'aheto-content-block__ico icon' );
	$this->add_render_attribute( 'moovit_icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'moovit_icon', 'style', 'color:' . $icon['color'] . ';' );
	}
	if ( ! empty( $icon['font_size'] ) ) {
		$this->add_render_attribute( 'moovit_icon', 'style', 'font-size:' . $icon['font_size'] );
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-features-single-layout3', $shortcode_dir . 'assets/css/moovit_layout3.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-content-block__info">

        <div class="aheto-content-block__info-wrap">

			<?php if ( ! empty( $icon ) ) {
				echo '<i ' . $this->get_render_attribute_string( 'moovit_icon' ) . '></i>';
			}

			if($moovit_add_url && !empty($moovit_url) && !empty(! empty( $s_heading ))){
			    echo '<a href="' . esc_url($moovit_url) . '" class="aheto-content-block__title">' . esc_html( $s_heading ) . '</a>';
			}
			elseif ( ! empty( $s_heading )  ) {
                echo '<' . $moovit_heading_tag . ' class="aheto-content-block__title">' . esc_html($s_heading) . '</' . $moovit_heading_tag . '>';
            } ?>

        </div>
    </div>
</div>
