<?php
/**
 * Social network default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-socials-share' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/social-networks/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'social-networks-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aht-page__socials">

        <div class="aht-page__socials__text">
            <span><?php esc_html_e( 'Share', 'aheto' ); ?></span>
        </div>

        <div class="aht-page__socials__wrapper">
            <div class="aht-page__socials__icon"><i class="icon ion-android-share"></i></div>
            <div class="aht-page__socials__share">
                <a class="aht-page__socials__share__link" href="#"
                   data-share="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>&amp;t=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
                   target="_blank" rel="noreferrer noopener">
                    <i class="aht-page__socials__share__icon icon ion-social-facebook"></i>
                </a>
                <a class="aht-page__socials__share__link" href="#"
                   data-share="http://twitter.com/home?status=<?php echo esc_attr( urlencode( the_title( '', ' ', false ) ) ); ?><?php esc_url( the_permalink() ); ?>"
                   target="_blank" rel="noreferrer noopener">
                    <i class="aht-page__socials__share__icon icon ion-social-twitter"></i>
                </a>
                <a class="aht-page__socials__share__link" href="#"
                   data-share="http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url( the_permalink() ); ?>&amp;title=<?php echo esc_attr( urlencode( the_title( '', '', false ) ) ); ?>"
                   target="_blank" rel="noreferrer noopener">
                    <i class="aht-page__socials__share__icon icon ion-social-linkedin"></i>
                </a>
            </div>
        </div>

    </div>

</div>


