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

$acacio_center_links  = $this->parse_group( $acacio_center_links );


if ( empty( $acacio_center_links ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-navbar aheto-navbar--acacio-simple' );
$this->add_render_attribute( 'wrapper', 'class', $columns . '-columns' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-navbar-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null);

}


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="aheto-navbar--inner">

					<?php if ( ! empty( $acacio_center_links ) ) { ?>
                        <div class="aheto-navbar--left">

							<?php foreach ( $acacio_center_links as $index => $link ) : ?>
                                <div class="aheto-navbar--item">

									<?php if ( ! empty( $link['acacio_label'] ) && ( $link['acacio_type_link'] == 'acacio_text' ) ) : ?>
                                        <span class="aheto-navbar--item-label"><?php echo esc_html( $link['acacio_label'] ); ?></span>
									<?php endif; ?>


									<?php if ( ( ! empty( $link['acacio_label'] ) || $link['acacio_add_icon'] ) && ( $link['acacio_type_link'] == 'acacio_phone' || $link['acacio_type_link'] == 'acacio_email' ) ) : ?>
                                        <span class="aheto-navbar--item-label">

                                             <?php if ( $link['acacio_type_link'] == 'acacio_phone' && $link['acacio_add_icon'] ) : ?>
                                                 <i class="ion-ios-telephone<?php echo esc_attr( $link['acacio_type_icon'] ); ?>"></i>
                                             <?php endif; ?>

											<?php if ( $link['acacio_type_link'] == 'acacio_email' && $link['acacio_add_icon'] ) : ?>
                                                <i class="ion-ios-email<?php echo esc_attr( $link['acacio_type_icon'] ); ?>"></i>
											<?php endif; ?>

											<?php if ( ! empty( $link['acacio_label'] ) ) {
												echo esc_html( $link['acacio_label'] );
											} ?>
                                        </span>
									<?php endif; ?>

									<?php if ( ! empty( $link['acacio_phone'] ) && $link['acacio_type_link'] == 'acacio_phone' ) : ?>
                                        <a href="tel:<?php echo esc_attr( $link['acacio_phone'] ); ?>"
                                           class="aheto-navbar--item-link"><?php echo esc_html( $link['acacio_phone'] ); ?></a>
									<?php endif; ?>

									<?php if ( ! empty( $link['acacio_email'] ) && $link['acacio_type_link'] == 'acacio_email' ) : ?>
                                        <a href="mailto:<?php echo esc_attr( $link['acacio_email'] ); ?>"
                                           class="aheto-navbar--item-link"><?php echo esc_html( $link['acacio_email'] ); ?></a>
									<?php endif; ?>

									<?php if ( ! empty( $link['acacio_custom_link'] ) && ! empty( $link['acacio_label'] ) && $link['acacio_type_link'] == 'acacio_custom' ) : ?>
                                        <a href="<?php echo esc_url( $link['acacio_custom_link'] ); ?>"
                                           class="aheto-navbar--item-link"><?php echo esc_html( $link['acacio_label'] ); ?></a>
									<?php endif;

									if ( $link['acacio_type_link'] == 'acacio_socials' ) {

										echo Helper::get_social_networks_list( '<a class="aheto-navbar--item-link icon" href="%1$s"><i class="ion-social-%2$s"></i></a>', 'left_links_', $this, $atts['acacio_center_links'] );

                                    } ?>
                                    <?php if ( $link['acacio_type_link'] == 'acacio_searchbox' ) : ?>
                                        <a class="icons-widget__link search-btn js-open-search" href="#">
                                            <i class="icon ion-ios-search-strong" aria-hidden="true"></i>
                                        </a>
									<?php endif; ?>
                                    <?php if ( $link['acacio_type_link'] == 'acacio_languague' && defined( 'ICL_SITEPRESS_VERSION' ) ) :

                                        $active = '';
                                        $submenu = '';
                                        foreach ( icl_get_languages( 'skip_missing=0' ) as $language_key => $args ) {
                                            if ( $args['active'] ) {
                                                $active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native">%3$s <i class="icon ion-chevron-down"></i></span></a>',
                                                    $args['country_flag_url'],
                                                    $args['language_code'],
                                                    $args['translated_name']
                                                );
                                                continue;

                                            }
                                            elseif( $args['active'] ){

                                                $active .= sprintf( '<a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle js-lang"><img class="wpml-ls-flag" src="%1$s" alt="%2$s" title="%3$s"><span class="wpml-ls-native">%2$s <i class="icon ion-chevron-down"></i></span></a>',
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
                                                    <span class="wpml-ls-native">%4$s</span>
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

                                        echo wp_kses_post($html);


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

