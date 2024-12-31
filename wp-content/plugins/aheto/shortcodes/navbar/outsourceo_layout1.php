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

$outsourceo_navbar_links  = $this->parse_group( $outsourceo_navbar_links );

$outsourceo_center_hide_mobile = isset( $right_hide_mobile ) && ! empty( $right_hide_mobile ) ? 'hide-mobile' : '';
$outsourceo_dark_style = isset( $outsourceo_dark_style ) && ! empty( $outsourceo_dark_style ) ? 'dark-style' : '';

if ( empty( $outsourceo_navbar_links ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-navbar--outsourceo-simple' );
$this->add_render_attribute( 'wrapper', 'class', $columns . '-columns' );
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_dark_style );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-navbar-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="aheto-navbar--inner">

					<?php if ( ! empty( $outsourceo_navbar_links ) ) { ?>
                        <div class="aheto-navbar--<?php echo esc_attr($outsourceo_align); ?> <?php echo esc_attr( $outsourceo_center_hide_mobile ); ?>">

							<?php foreach ( $outsourceo_navbar_links as $index => $link ) : ?>

                                <div class="aheto-navbar--item">

									<?php if ( ! empty( $link['outsourceo_label'] ) && ( $link['outsourceo_type_link'] == 'text' ) ) : ?>
                                        <span class="aheto-navbar--item-label"><?php echo esc_html( $link['outsourceo_label'] ); ?></span>
									<?php endif; ?>


									<?php if ( ( ! empty( $link['outsourceo_label'] ) || $link['outsourceo_add_icon'] ) && ( $link['outsourceo_type_link'] == 'phone' || $link['outsourceo_type_link'] == 'email' ) ) : ?>
                                        <span class="aheto-navbar--item-label">

                                             <?php if ( $link['outsourceo_type_link'] == 'phone' && $link['outsourceo_add_icon'] ) : ?>
                                                 <i class="ion-ios-telephone<?php echo esc_attr( $link['outsourceo_type_icon'] ); ?>"></i>
                                             <?php endif; ?>

											<?php if ( $link['outsourceo_type_link'] == 'email' && $link['outsourceo_add_icon'] ) : ?>
                                                <i class="ion-ios-email<?php echo esc_attr( $link['outsourceo_type_icon'] ); ?>"></i>
											<?php endif; ?>

											<?php if ( ! empty( $link['outsourceo_label'] ) ) {
												echo esc_html( $link['outsourceo_label'] );
											} ?>
                                        </span>
									<?php endif; ?>

									<?php if ( ! empty( $link['outsourceo_phone'] ) && $link['outsourceo_type_link'] == 'phone' ) : ?>
                                        <a href="tel:<?php echo esc_attr( str_replace(' ','', $link['outsourceo_phone'])); ?>"
                                           class="aheto-navbar--item-link phone"><?php echo esc_html( $link['outsourceo_phone'] ); ?></a>
									<?php endif; ?>

									<?php if ( ! empty( $link['outsourceo_email'] ) && $link['outsourceo_type_link'] == 'email' ) : ?>
                                        <a href="mailto:<?php echo esc_attr( $link['outsourceo_email'] ); ?>"
                                           class="aheto-navbar--item-link email"><?php echo esc_html( $link['outsourceo_email'] ); ?></a>
									<?php endif; ?>

									<?php if ( ! empty( $link['outsourceo_custom_link'] ) && ! empty( $link['outsourceo_label'] ) && $link['outsourceo_type_link'] == 'custom' ) : ?>
                                        <a href="<?php echo esc_url( $link['outsourceo_custom_link'] ); ?>"
                                           class="aheto-navbar--item-link"><?php echo esc_html( $link['outsourceo_label'] ); ?></a>
									<?php endif; ?>
                                    <?php if ( $link['outsourceo_type_link'] == 'searchbox' ) : ?>
                                        <a class="icons-widget__link search-btn js-open-search" href="#">
                                            <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                                        </a>
									<?php endif; ?>
                                    <?php if ( $link['outsourceo_type_link'] == 'languague' && defined( 'ICL_SITEPRESS_VERSION' ) ) :

                                        $active = '';
                                        $submenu = '';
                                        foreach ( icl_get_languages( 'skip_missing=0' ) as $language_key => $args ) {
                                            if ( $args['active'] ) {
                                                $active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native"><i class="icon ion-android-arrow-dropdown"></i></span></a>',
                                                    $args['country_flag_url'],
                                                    $args['language_code'],
                                                    $args['translated_name']
                                                );
                                                continue;

                                            }
                                            elseif( $args['active'] ){

                                                $active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native"><i class="icon ion-android-arrow-dropdown"></i></span></a>',
                                                    $args['country_flag_url'],
                                                    $args['language_code'],
                                                    $args['translated_name']
                                                );
                                                continue;
                                            }


                                            $submenu .= sprintf(
                                                '<li class="wpml-ls-slot-sidebar-1 wpml-ls-item wpml-ls-item-de">
                                                <a href="%1$s">
                                                    <img class="wpml-ls-flag" src="%2$s" alt="%3$s" title="%4$s">
                                                    <span class="wpml-ls-native"></span>
                                                </a>
                                            </li>',
                                                $args['url'],
                                                $args['country_flag_url'],
                                                $args['language_code'],
                                                $args['translated_name']
                                            );

                                        }

                                        $html  = '<div class="wpml-ls-sidebars-sidebar-1 wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown"><ul class="multi-lang">';
                                        $html .= '<li tabindex="0" class="wpml-ls-slot-sidebar-1 wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-dropdown">';
                                        $html .= $active;
                                        if ( ! empty( $submenu ) ) {
                                            $html .= '<ul class="wpml-ls-sub-menu js-lang-list">';
                                            $html .= $submenu;
                                            $html .= '</ul>';
                                        }
                                        $html .= '</li></ul></div>';

                                        echo wp_kses($html, 'post');

                                        endif; ?>
                                </div>

							<?php endforeach; ?>


                        </div>
					<?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

