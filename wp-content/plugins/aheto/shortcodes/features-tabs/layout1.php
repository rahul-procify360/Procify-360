<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$tabs = $this->parse_group( $tabs );
if ( empty( $tabs ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-features-tabs--classic' );
$this->add_render_attribute( 'wrapper', 'class', 'js-tab' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-tabs/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'features-tabs-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


    <div class="aheto-features-tabs__head">
        <ul class="aheto-features-tabs__list ">

			<?php foreach ( $tabs as $index => $item ) :

				$heading_tag = isset( $item['heading_tag'] ) && ! empty( $item['heading_tag'] ) ? $item['heading_tag'] : 'h1';
				$active = $index > 0 ? '' : 'active'; ?>

                <li class="aheto-features-tabs__list-item <?php echo esc_attr( $active ); ?>">

                    <a href="#" class="aheto-features-tabs__list-link js-tab-list">

						<?php if ( $item['icon'] ) : ?>
                            <i class="aheto-features-tabs__list-ico ti-<?php echo esc_attr( $item['icon'] ); ?>"></i>
						<?php endif; ?>

						<?php if ( $item['main_heading'] ) :

							echo esc_html( $item['main_heading'] );

						endif; ?>
                    </a>
                </li>
			<?php endforeach; ?>

        </ul>
    </div>


    <div class="aheto-features-tabs__content">
		<?php foreach ( $tabs as $index => $item ) :

			$title_tag = isset( $item['title_tag'] ) && ! empty( $item['title_tag'] ) ? $item['title_tag'] : 'h1';
			$active = $index > 0 ? '' : 'active';
			$reverse = isset( $item['reverse'] ) && ! empty( $item['reverse'] ) ? 'reverse' : ''; ?>

            <div class="aheto-features-tabs__box js-tab-box <?php echo esc_attr( $active ); ?>">
                <div class="aheto-features-tabs__box-inner <?php echo esc_attr( $reverse ); ?>">

					<?php if ( ! empty( $item['image'] ) ) : ?>
                        <div class="aheto-features-tabs__box-img">
							<?php echo Helper::get_attachment( $item['image'], [ 'class' => 'img' ], $image_size, $atts ); ?>
                        </div>
					<?php endif; ?>


                    <div class="aheto-features-tabs__box-content">
						<?php if ( $item['title'] ) :

							echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . esc_html( $item['title'] ) . '</' . $title_tag . '>';

						endif; ?>


						<?php if ( $item['description'] ) : ?>

                            <div class="aheto-features-tabs__box-description">
								<?php echo esc_html( $item['description'] ); ?>
                            </div>

						<?php endif; ?>


						<?php if ( $item['main_add_button'] || $item['add_add_button'] ) { ?>

                            <div class="aheto-features-tabs__box-buttons">


								<?php echo Helper::get_button( $this, $item, 'main_' );

								echo Helper::get_button( $this, $item, 'add_' ); ?>

                            </div>

						<?php } ?>


                    </div>

                </div>
            </div>

		<?php endforeach; ?>

    </div>


</div>
