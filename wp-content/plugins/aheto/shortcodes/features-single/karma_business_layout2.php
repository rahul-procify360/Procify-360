<?php

/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     KARMA <info@karma.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-single--karma-business-modern' );

// Icon.
$icon = $this->get_icon_attributes( '', true, true );

if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] . ';' );
	}
	if ( ! empty( $icon['font_size'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'font-size:' . $icon['font_size'] );
	}
}

//Title tags
$title_tag    = isset( $karma_business_title_tag ) && ! empty( $karma_business_title_tag ) ? $karma_business_title_tag : 'h2';
$subtitle_tag = isset( $karma_business_subtitle_tag ) && ! empty( $karma_business_subtitle_tag ) ? $karma_business_subtitle_tag : 'h6';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-business-features-single-layout2', $shortcode_dir . 'assets/css/karma_business_layout2.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-features-single__info">

        <div class="aheto-features-single__info-wrap">

			<?php

			if ( ! empty( $karma_business_subtitle ) ) :
				echo '<' . $subtitle_tag . ' class="aheto-features-single__subtitle">' . $this->highlight_text( $karma_business_subtitle ) . '</' . $subtitle_tag . '>'; ?>
			<?php endif; ?>

			<?php
			if ( ! empty( $s_heading ) ) :

				echo '<' . $title_tag . ' class="aheto-features-single__title">' . $this->highlight_text( $s_heading ) . '</' . $title_tag . '>'; ?>

			<?php endif; ?>

            <div class="aheto-features-single--links">

				<?php if ( $karma_business_main_add_button ) {
					echo \Aheto\Helper::get_button( $this, $atts, 'karma_business_main_' );
				} ?>

				<?php
				// Icon.
				if ( ! empty( $icon ) ) {
					?>
                    <div class="aheto-features-single__telephone">
						<?php if ( ! empty( $karma_business_phone ) ) :
							$karma_business_tel_phone = str_replace( " ", "", $karma_business_phone ); ?>
                            <a class="aheto-features-single__link aheto-features-single__tel t-light"
                               href="tel:<?php echo esc_attr( $karma_business_tel_phone ); ?>"><?php echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>' . esc_html( $karma_business_phone ); ?></a>
						<?php endif; ?>
                    </div>
				<?php } ?>

            </div>

        </div>
    </div>
</div>
