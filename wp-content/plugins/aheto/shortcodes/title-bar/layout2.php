<?php
/**
 * Title bar default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

$arrows_breadcrumb = isset( $arrows_breadcrumb ) && ! empty( $arrows_breadcrumb ) ? 'all-arrows' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aht-breadcrumbs--only arrows-' . $arrows_alignment );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', $arrows_breadcrumb );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'title-bar-style-2', $sc_dir . 'assets/css/layout2.css', null, null );
}

$breadcrumb_align_desktop = isset($breadcrumb_align_desktop) && !empty($breadcrumb_align_desktop) ? $breadcrumb_align_desktop : 'left';
$breadcrumb_align_tablet = isset($breadcrumb_align_tablet) && !empty($breadcrumb_align_tablet) ? $breadcrumb_align_tablet : 'left';
$breadcrumb_align_mobile = isset($breadcrumb_align_mobile) && !empty($breadcrumb_align_mobile) ? $breadcrumb_align_mobile : 'left';

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="container">
		<?php

		if ( $breadcrumb_type == 'default' ) {
			echo str_replace( 'class="breadcrumbs', 'class="aht-breadcrumbs', aheto_get_breadcrumbs('aht-breadcrumbs text-' . esc_attr($breadcrumb_align_desktop). ' text-tab-' . esc_attr($breadcrumb_align_tablet) . ' text-mob-' . esc_attr($breadcrumb_align_mobile)) );
		} else {

			$custom_breadcrumb = $this->parse_group( $custom_breadcrumb );

			if ( ! empty( $custom_breadcrumb ) ) { ?>
                <div class="row">
                    <ul class="aht-breadcrumbs text-<?php echo esc_attr($breadcrumb_align_desktop);?> text-tab-<?php echo esc_attr($breadcrumb_align_tablet); ?> text-mob-<?php echo esc_attr($breadcrumb_align_mobile); ?>">

						<?php foreach ( $custom_breadcrumb as $key => $item ) {

							$item_link = $this->get_link_attributes( $item['link_url'] );
							$this->add_render_attribute( 'button-' . $key, $item_link );
							$this->add_render_attribute( 'button-' . $key, 'class', 'aht-breadcrumbs__link' );

							if ( isset( $item_link['href'] ) && ! empty( $item_link['href'] ) ) {

								if ( isset( $item['current_item'] ) && ! empty( $item['current_item'] ) ) { ?>
                                    <li class="aht-breadcrumbs__item current">
										<?php echo esc_html( $item['link_title'] ); ?>
                                    </li>
								<?php } else { ?>
                                    <li class="aht-breadcrumbs__item">
                                        <a <?php $this->render_attribute_string(  'button-' . $key ); ?>><?php echo esc_html( $item['link_title'] ); ?></a>
                                    </li>
								<?php } ?>

							<?php }

						} ?>

                    </ul>
                </div>

			<?php }
		}


		?>
    </div>
</div>
