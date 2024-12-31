<?php
/**
 * Contact Info default templates.
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
$this->add_render_attribute( 'wrapper', 'class', 'widget_aheto__contact--mooseoom' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );
$this->add_render_attribute( 'title', 'class', $underline );
$this->add_render_attribute( 'title', 'class', $title_space );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-contact-info-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php
	if ( ! empty( $title ) ) : ?>
        <h2 <?php $this->render_attribute_string( 'title' ); ?>>
			<?php echo wp_kses_post( $title ); ?>
        </h2>
	<?php endif;
	?>
    <div class="widget_aheto__infos">
		<?php if ( ! empty( $address ) ) : ?>
            <div class="widget_aheto__info widget_aheto__info--address">
				<?php echo wp_kses_post($this->get_icon_for( 'mooseoom_address' )); ?>
                <p><?php echo wp_kses_post( $address ); ?></p>
            </div>
		<?php endif;
		if ( ! empty( $phone ) ) :
			$tel_phone = str_replace( " ", "", $phone ); ?>
            <div class="widget_aheto__info widget_aheto__info--tel">
				<?php echo wp_kses_post($this->get_icon_for( 'mooseoom_phone' )); ?>
                <a class="widget_aheto__link" href="tel:<?php echo esc_attr( $tel_phone ); ?>">
					<?php echo esc_html( $phone ); ?>
                </a>
            </div>
		<?php endif;
		if ( ! empty( $email ) ) : ?>
            <div class="widget_aheto__info widget_aheto__info--mail">
				<?php echo wp_kses_post($this->get_icon_for( 'mooseoom_email' )); ?>
                <a class="widget_aheto__link" href="mailto:<?php echo esc_attr( $email ); ?>">
					<?php echo esc_html( $email ); ?>
                </a>
            </div>
		<?php endif; ?>
    </div>
</div>
