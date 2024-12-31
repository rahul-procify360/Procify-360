<?php
/**
 * Contact Info default templates.
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
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Section.
$this->add_render_attribute( 'section', 'class', 'widget widget_time_schedule--classic' );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget-title' );
$this->add_render_attribute( 'title', 'class', $underline );
$this->add_render_attribute( 'title', 'class', $title_space );


$schedules = $this->parse_group( $schedules );
if ( empty( $schedules ) ) {
	return '';
}

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/time-schedule/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;


if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'time-schedule-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}


?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <section <?php $this->render_attribute_string( 'section' ); ?>>

		<?php if ( ! empty( $title ) ) : ?>
            <h5 <?php $this->render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $title ); ?></h5>
		<?php endif; ?>

        <div class="widget-schedules">
            <ul>
				<?php if ( ! empty( $schedules ) ) {

					foreach ( $schedules as $schedule ) :

						if ( isset( $schedule['highlight'] ) && ! empty( $schedule['highlight'] ) ) { ?>

                            <li><b><?php echo esc_html( $schedule['day'] ); ?><span
                                            class="pull-right"><?php echo esc_html( $schedule['time'] ); ?></span></b>
                            </li>

						<?php } else { ?>

                            <li><?php echo esc_html( $schedule['day'] ); ?><span
                                        class="pull-right"><?php echo esc_html( $schedule['time'] ); ?></span></li>

						<?php }

					endforeach;

				} ?>
            </ul>

        </div>

    </section>

</div>
