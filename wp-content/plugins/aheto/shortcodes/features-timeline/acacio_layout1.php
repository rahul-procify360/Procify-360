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

$acacio_timeline = $this->parse_group( $acacio_timeline );
if ( empty( $acacio_timeline ) ) {
    return '';
}

$this->generate_css();

$acacio_dark_version = isset( $acacio_dark_version ) && $acacio_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-timeline--acacio-modern' );
$this->add_render_attribute( 'wrapper', 'class', $acacio_dark_version );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-features-timeline-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('acacio-features-timeline-layout1-js', $shortcode_dir . 'assets/js/acacio_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>


    <section class="aheto-timeline--acacio-modern">
        <div class="aheto-timeline__timeline">
            <div class="aheto-timeline__events-wrapper">
                <div class="aheto-timeline__events">
                    <ol>
                        <?php

                        $counter = 1;

                        foreach ( $acacio_timeline as $item ) :
                            $item = wp_parse_args( $item, [
                                'acacio_timeline_date' => '',
                            ] );
                            extract( $item );

                            if ( $counter === 1 ) { ?>
                                <li><a href="#0" class="selected"
                                       data-date="<?php echo esc_attr( $acacio_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $acacio_timeline_date ); ?></h5></a>
                                </li>
                            <?php } else { ?>
                                <li><a href="#0"
                                       data-date="<?php echo esc_attr( $acacio_timeline_date ); ?>">
                                        <h5><?php echo esc_html( $acacio_timeline_date ); ?></h5></a>
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

                foreach ( $acacio_timeline as $item ) :
                    $item = wp_parse_args( $item, [
                        'acacio_timeline_date'    => '',
                        'acacio_timeline_image'   => '',
                        'acacio_timeline_title'   => '',
                        'acacio_timeline_content' => '',
                        'acacio_add_button'       => '',
                        'acacio_use_dot'          => '',
                        'acacio_dot_color'        => '',
                        'acacio_item_image_size'  => '',
                    ] );
                    extract( $item );

                    if ( $counter === 1 ) { ?>
                        <li class="selected" data-date="<?php echo esc_attr( $acacio_timeline_date ); ?>">
                    <?php } else { ?>
                        <li data-date="<?php echo esc_attr( $acacio_timeline_date ); ?>">
                    <?php } ?>

                    <div class="aheto-timeline__wrap">

                        <div class="aheto-timeline__image-wrap">
                            <?php if ( ! empty( $acacio_timeline_image ) ) { ?>
                                <?php echo Helper::get_attachment( $acacio_timeline_image, [ 'class' => 'aheto-timeline-slider__add-image' ], 'full' ); ?>
                            <?php } ?>
                        </div>

                        <div class="aheto-timeline__content">
                            <?php if ( ! empty( $acacio_timeline_title ) ) {
                                $acacio_timeline_title = str_replace( ']]', '</span>', $acacio_timeline_title );
                                $acacio_timeline_title = str_replace( '[[', '<span>', $acacio_timeline_title ); ?>
                                <h4 class="aheto-timeline__title"><?php

                                    if ( $acacio_use_dot ) {

                                        $acacio_timeline_title = str_replace( '{{.}}', '<span class="acacio-dot dot-' . esc_attr( $acacio_dot_color ) . '"></span>', $acacio_timeline_title );

                                        $words = explode( " ", $acacio_timeline_title );

                                        if ( count( $words ) > 0 ) {
                                            $last_word = $words[ count( $words ) - 1 ];

                                            $last_space_position = strrpos( $acacio_timeline_title, ' ' );
                                            $start_string        = substr( $acacio_timeline_title, 0, $last_space_position );

                                            $acacio_timeline_title = wp_kses( $start_string, 'post' ) . ' <span class="acacio-dot dot-' . esc_attr( $acacio_dot_color ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
                                        } else {
                                            $acacio_timeline_title = '<span class="acacio-dot dot-' . esc_attr( $acacio_dot_color ) . '">' . wp_kses( $acacio_timeline_title, 'post' ) . '</span>';
                                        }

                                    } else {
                                        $acacio_timeline_title = wp_kses( $acacio_timeline_title, 'post' );
                                    }

                                    echo $acacio_timeline_title; ?></h4>
                            <?php }

                            if ( ! empty( $acacio_timeline_content ) ) { ?>
                                <p class="aheto-timeline__desc"><?php echo wp_kses( $acacio_timeline_content, 'post' ); ?></p>
                            <?php }

                            if ( $acacio_add_button ) { ?>
                                <div class="aheto-timeline-slider__links">
                                    <?php echo Helper::get_button( $this, $item, 'acacio_' ); ?>
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
