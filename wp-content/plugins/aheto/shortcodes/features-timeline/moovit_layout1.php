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

$moovit_timeline = $this->parse_group( $moovit_timeline );
if ( empty( $moovit_timeline ) ) {
	return '';
}

$this->generate_css();

$moovit_dark_version = isset( $moovit_dark_version ) && $moovit_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-timeline--moovit-modern' );
$this->add_render_attribute( 'wrapper', 'class', $moovit_dark_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-features-timeline-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('moovit-features-timeline-layout1-js', $shortcode_dir . 'assets/js/moovit_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


    <section class="aheto-timeline--moovit-modern">
        <div class="aheto-timeline__timeline">
            <div class="aheto-timeline__events-wrapper">
                <div class="aheto-timeline__events">
                    <ol>
						<?php

						$counter = 1;

						foreach ( $moovit_timeline as $item ) :
							$item = wp_parse_args( $item, [
								'moovit_timeline_date' => '',
							] );
							extract( $item );

							if ( $counter === 1 ) { ?>
                                <li><a href="#0" class="selected"
                                       data-date="<?php echo esc_attr( $moovit_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $moovit_timeline_date ); ?></h5></a>
                                </li>
							<?php } else { ?>
                                <li><a href="#0"
                                       data-date="<?php echo esc_attr( $moovit_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $moovit_timeline_date ); ?></h5></a>
                                </li>
							<?php } ?>


							<?php $counter ++;

						endforeach; ?>

                    </ol>

                    <span class="aheto-timeline__filling-line" aria-hidden="true"></span>
                </div> <!-- .events -->
            </div> <!-- .events-wrapper -->

            <ul class="aheto-timeline__navigation">
                <li><a href="#0" class="prev inactive ion-ios-arrow-left"></a></li>
                <li><a href="#0" class="next ion-ios-arrow-right"></a></li>
            </ul> <!-- .cd-timeline-navigation -->
        </div> <!-- .timeline -->

        <div class="aheto-timeline__events-content">
            <ol>
				<?php

				$counter = 1;

				foreach ( $moovit_timeline as $item ) :
					$item = wp_parse_args( $item, [
						'moovit_timeline_date'    => '',
						'moovit_timeline_image'   => '',
						'moovit_timeline_title'   => '',
						'moovit_timeline_content' => '',
						'moovit_add_button'       => '',
						'moovit_use_dot'          => '',
						'moovit_dot_color'        => '',
						'moovit_item_image_size'  => '',
					] );
					extract( $item );

					if ( $counter === 1 ) { ?>
                        <li class="selected" data-date="<?php echo esc_attr( $moovit_timeline_date ); ?>">
					<?php } else { ?>
                        <li data-date="<?php echo esc_attr( $moovit_timeline_date ); ?>">
					<?php } ?>

                    <div class="aheto-timeline__wrap">

                        <div class="aheto-timeline__image-wrap">
							<?php if ( ! empty( $moovit_timeline_image ) ) { ?>
								<?php echo Helper::get_attachment( $moovit_timeline_image, [ 'class' => 'aheto-timeline-slider__add-image' ], $moovit_image_size, $atts, 'moovit_' ); ?>
							<?php } ?>
                        </div>

                        <div class="aheto-timeline__content">
							<?php if ( ! empty( $moovit_timeline_title ) ) {
								$moovit_timeline_title = str_replace( ']]', '</span>', $moovit_timeline_title );
								$moovit_timeline_title = str_replace( '[[', '<span>', $moovit_timeline_title ); ?>
                                <h4 class="aheto-timeline__title"><?php

									if ( $moovit_use_dot ) {

										$moovit_timeline_title = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '"></span>', $moovit_timeline_title );

										$words = explode( " ", $moovit_timeline_title );

										if ( count( $words ) > 0 ) {
											$last_word = $words[ count( $words ) - 1 ];

											$last_space_position = strrpos( $moovit_timeline_title, ' ' );
											$start_string        = substr( $moovit_timeline_title, 0, $last_space_position );

											$moovit_timeline_title = wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
										} else {
											$moovit_timeline_title = '<span class="moovit-dot dot-' . esc_attr( $moovit_dot_color ) . '">' . wp_kses( $moovit_timeline_title, 'post' ) . '</span>';
										}

									} else {
										$moovit_timeline_title = wp_kses( $moovit_timeline_title, 'post' );
									}

									echo $moovit_timeline_title; ?></h4>
							<?php }

							if ( ! empty( $moovit_timeline_content ) ) { ?>
                                <p class="aheto-timeline__desc"><?php echo wp_kses( $moovit_timeline_content, 'post' ); ?></p>
							<?php }

							if ( $moovit_add_button ) { ?>
                                <div class="aheto-timeline-slider__links">
									<?php echo Helper::get_button( $this, $item, 'moovit_' ); ?>
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
