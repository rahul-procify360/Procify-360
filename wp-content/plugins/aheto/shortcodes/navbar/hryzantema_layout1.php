<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$hryzantema_center_links  = $this->parse_group( $hryzantema_center_links );

$hryzantema_align_items = isset($hryzantema_align_items) && !empty($hryzantema_align_items) ? $hryzantema_align_items : 'initial';
$hryzantema_dark_style = isset($hryzantema_dark_style) && $hryzantema_dark_style ? 'aheto-navbar--hr-simple-dark' : '';


if ( empty( $hryzantema_center_links ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-navbar--hr-simple' );
$this->add_render_attribute( 'wrapper', 'class', $hryzantema_dark_style );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-navbar-layout1', $shortcode_dir . 'assets/css/hryzantema_layout1.css', null, null);
}?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="aheto-navbar--inner" style="justify-content: <?php echo esc_attr($hryzantema_align_items);?>">

        <?php if ( ! empty( $hryzantema_center_links ) ) { ?>
            <?php foreach ( $hryzantema_center_links as $index => $link ) : ?>
                <div class="aheto-navbar--item">

                    <?php if ( ! empty( $link['hryzantema_label'] ) && ( $link['hryzantema_type_link'] == 'hryzantema_text' ) ) : ?>
                        <span class="aheto-navbar--item-label"><?php echo esc_html( $link['hryzantema_label'] ); ?></span>
                    <?php endif; ?>


                    <?php if ( ( ! empty( $link['hryzantema_label'] ) || $link['hryzantema_add_icon'] ) && ( $link['hryzantema_type_link'] == 'hryzantema_phone' || $link['hryzantema_type_link'] == 'hryzantema_email' ) ) : ?>
                        <span class="aheto-navbar--item-label">

                                             <?php if ( $link['hryzantema_type_link'] == 'hryzantema_phone' && $link['hryzantema_add_icon'] ) : ?>
                                                 <i class="ion-ios-telephone<?php echo esc_attr( $link['hryzantema_type_icon'] ); ?>"></i>
                                             <?php endif; ?>

                            <?php if ( $link['hryzantema_type_link'] == 'hryzantema_email' && $link['hryzantema_add_icon'] ) : ?>
                                <i class="ion-ios-email<?php echo esc_attr( $link['hryzantema_type_icon'] ); ?>"></i>
                            <?php endif; ?>

                            <?php if ( ! empty( $link['hryzantema_label'] ) ) {
                                echo esc_html( $link['hryzantema_label'] );
                            } ?>
                                        </span>
                    <?php endif; ?>

                    <?php if ( ! empty( $link['hryzantema_phone'] ) && $link['hryzantema_type_link'] == 'hryzantema_phone' ) : ?>
                        <a href="tel:<?php echo esc_attr( $link['hryzantema_phone'] ); ?>"
                           class="aheto-navbar--item-link"><?php echo esc_html( $link['hryzantema_phone'] ); ?></a>
                    <?php endif; ?>

                    <?php if ( ! empty( $link['hryzantema_email'] ) && $link['hryzantema_type_link'] == 'hryzantema_email' ) : ?>
                        <a href="mailto:<?php echo esc_attr( $link['hryzantema_email'] ); ?>"
                           class="aheto-navbar--item-link"><?php echo esc_html( $link['hryzantema_email'] ); ?></a>
                    <?php endif; ?>

                    <?php if ( $link['hryzantema_type_link'] == 'hryzantema_searchbox' ) : ?>
                        <a class="icons-widget__link search-btn js-open-search" href="#">
                            <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>
        <?php } ?>

    </div>
</div>

