<?php
/**
 * Kunst Contact Info default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget_kunst--info__simple' );
$this->add_render_attribute( 'wrapper', 'class', $kunst_align );
$this->add_render_attribute( 'wrapper', 'class', 'align-tab-' . $kunst_align_tablet );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $kunst_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget_kunst__title' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'kunst-contact-info-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <?php if ( ! empty( $kunst_image ) ) : ?>
        <?php echo Helper::get_attachment($kunst_image, ['class' => 'widget_kunst__image'], $kunst_image_size, $atts, 'kunst_'); ?>
	<?php endif; ?>
    <?php if ( ! empty( $kunst_title ) ) : ?>
        <h4 class="widget_kunst__title">
			<?php echo wp_kses( $kunst_title, 'post' ); ?>
        </h4>
	<?php endif; ?>
    <div class="widget_kunst--info__simple--content">
        <?php if ( ! empty( $kunst_address ) ) : ?>
            <div class="widget_kunst--info__simple--address">
                <p class="widget_kunst--info__simple--link-address"><?php echo wp_kses( $kunst_address, 'post' ); ?></p>
            </div>
        <?php endif;
        if ( ! empty( $kunst_phone ) ) :
            $kunst_tel_phone = str_replace( " ", "", $kunst_phone );
        ?>
            <div class="widget_kunst--info__simple--tel">
                <a class="widget_kunst--info__simple--link-tel" href="tel:<?php echo esc_attr( $kunst_tel_phone ); ?>">
                    <?php echo esc_html( $kunst_phone ); ?>
                </a>
            </div>
        <?php endif;
            if ( ! empty( $kunst_email ) ) :
        ?>
            <div class="widget_kunst--info__simple--mail">
                <a class="widget_kunst--info__simple--link-email" href="mailto:<?php echo esc_attr( $kunst_email ); ?>">
                    <?php echo esc_html( $kunst_email ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
