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

$timelines = $this->parse_group( $timelines );
if ( empty( $timelines ) ) {
	return '';
}

$counter = 1;

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'features-timeline-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-content-block--time-scale">
		<?php
		foreach ( $timelines as $item ) :
			$class = 0 === ( $counter % 2 ) ? ' reversed' : '';
			?>

            <div class="aheto-content-block__item<?php echo $class; ?>">

                <div class="aheto-content-block__content">

					<?php if ( $item['heading'] ) : ?>
                        <h6 class="aheto-content-block__title t-bold"><?php echo wp_kses_post( $item['heading'] ); ?></h6>
					<?php endif; ?>

					<?php if ( $item['image'] ) :
						$background_image = Helper::get_background_attachment( $item['image'], $image_size, $atts ); ?>
                        <div class="aheto-content-block__photo" <?php echo esc_attr( $background_image ); ?>></div>
					<?php endif; ?>

					<?php if ( $item['description'] ) : ?>
                        <p>
							<?php echo wp_kses_post( $item['description'] ); ?>
                        </p>
					<?php endif; ?>

                </div>

				<?php if ( $item['time'] ) : ?>
                    <div class="aheto-content-block__info">
                        <div class="aheto-content-block__date"><?php echo esc_html( $item['time'] ); ?></div>
                    </div>
				<?php endif; ?>

            </div>

			<?php
			$counter ++;
		endforeach;
		?>

    </div>

</div>
