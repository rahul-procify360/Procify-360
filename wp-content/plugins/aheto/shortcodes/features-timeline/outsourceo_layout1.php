<?php
/**
 * The Features Timeline Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$outsourceo_timeline = $this->parse_group( $outsourceo_timeline );
if ( empty( $outsourceo_timeline ) ) {
	return '';
}

$this->generate_css();

$outsourceo_dark_version = isset( $outsourceo_dark_version ) && $outsourceo_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-timeline--outsourceo-modern' );
$this->add_render_attribute( 'wrapper', 'class', $outsourceo_dark_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-features-timeline-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('outsourceo-features-timeline-layout1-js', $shortcode_dir . 'assets/js/outsourceo_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <section class="aheto-timeline--outsourceo-modern">
        <div class="aheto-timeline__timeline">
            <div class="aheto-timeline__events-wrapper">
                <div class="aheto-timeline__events">
                    <ol>
						<?php

						$counter = 1;

						foreach ( $outsourceo_timeline as $item ) :
							$item = wp_parse_args( $item, [
								'outsourceo_timeline_date' => '',
							] );
							extract( $item );

							if ( $counter === 1 ) { ?>
                                <li><a href="#0" class="selected"
                                       data-date="<?php echo esc_attr( $outsourceo_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $outsourceo_timeline_date ); ?></h5></a>
                                </li>
							<?php } else { ?>
                                <li><a href="#0"
                                       data-date="<?php echo esc_attr( $outsourceo_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $outsourceo_timeline_date ); ?></h5></a>
                                </li>
							<?php } ?>


							<?php $counter ++;

						endforeach; ?>

                    </ol>

                    <span class="aheto-timeline__filling-line" aria-hidden="true"></span>
                </div> <!-- .events -->
            </div> <!-- .events-wrapper -->

            <ul class="aheto-timeline__navigation">
                <li><a href="#0" class="prev inactive ion-android-arrow-dropleft"></a></li>
                <li><a href="#0" class="next ion-android-arrow-dropright"></a></li>
            </ul> <!-- .cd-timeline-navigation -->
        </div> <!-- .timeline -->

        <div class="aheto-timeline__events-content">
            <ol>
				<?php

				$counter = 1;

				foreach ( $outsourceo_timeline as $item ) :
					$item = wp_parse_args( $item, [
						'outsourceo_timeline_date'    => '',
						'outsourceo_timeline_image'   => '',
						'outsourceo_timeline_title'   => '',
						'outsourceo_timeline_content' => '',
						'outsourceo_add_button'       => '',
						'outsourceo_use_dot'          => '',
						'outsourceo_dot_color'        => '',
					] );
					extract( $item );

					if ( $counter === 1 ) { ?>
                        <li class="selected" data-date="<?php echo esc_attr( $outsourceo_timeline_date ); ?>">
					<?php } else { ?>
                        <li data-date="<?php echo esc_attr( $outsourceo_timeline_date ); ?>">
					<?php } ?>

                    <div class="aheto-timeline__wrap">

                        <div class="aheto-timeline__image-wrap">
							<?php if ( ! empty( $outsourceo_timeline_image ) ) { ?>
								<?php echo Helper::get_attachment( $outsourceo_timeline_image, [ 'class' => 'aheto-timeline-slider__add-image' ], $outsourceo_image_size, $atts, 'outsourceo_' ); ?>
							<?php } ?>
                        </div>

                        <div class="aheto-timeline__content">
							<?php if ( ! empty( $outsourceo_timeline_title ) ) {
								$outsourceo_timeline_title = str_replace( ']]', '</span>', $outsourceo_timeline_title );
								$outsourceo_timeline_title = str_replace( '[[', '<span>', $outsourceo_timeline_title ); ?>
                                <h3 class="aheto-timeline__title">
									<?php if ( $outsourceo_use_dot ) {

										$outsourceo_timeline_title = str_replace( '{{.}}', '<span class="outsourceo-dot dot-' . esc_attr( $outsourceo_dot_color ) . '"></span>', $outsourceo_timeline_title );

										$words = explode( " ", $outsourceo_timeline_title );

										if ( count( $words ) > 0 ) {
											$last_word = $words[ count( $words ) - 1 ];

											$last_space_position = strrpos( $outsourceo_timeline_title, ' ' );
											$start_string        = substr( $outsourceo_timeline_title, 0, $last_space_position );

											$outsourceo_timeline_title = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-' . esc_attr( $outsourceo_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
										} else {
											$outsourceo_timeline_title = '<span class="outsourceo-dot dot-' . esc_attr( $outsourceo_dot_color ) . '">' . wp_kses( $outsourceo_timeline_title, 'post' ) . '</span>';
										}

									} else {
										$outsourceo_timeline_title = wp_kses( $outsourceo_timeline_title, 'post' );
									}

									echo $outsourceo_timeline_title; ?></h3>
							<?php }

							if ( ! empty( $outsourceo_timeline_content ) ) { ?>
                                <p class="aheto-timeline__desc"><?php echo wp_kses( $outsourceo_timeline_content, 'post' ); ?></p>
							<?php }

							if ( $outsourceo_add_button ) { ?>
                                <div class="aheto-timeline-slider__links">
									<?php echo Helper::get_button( $this, $item, 'outsourceo_' ); ?>
                                </div>
							<?php } ?>
                        </div>
                    </div>
                    </li>
					<?php
					$counter ++;

				endforeach; ?>

            </ol>
        </div> <!-- .events-content -->
    </section>

</div>
