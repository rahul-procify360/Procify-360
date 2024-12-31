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

extract($atts);

$rela_timeline = $this->parse_group($rela_timeline);
if (empty($rela_timeline)) {
    return '';
}


$this->generate_css();

$rela_dark_version = isset($rela_dark_version) && $rela_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-timeline--rela-modern');
$this->add_render_attribute('wrapper', 'class', $rela_dark_version);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-features-timeline-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('rela-features-timeline-layout1-js', $shortcode_dir . 'assets/js/rela_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>


    <section class="aheto-timeline--rela-modern">
        <div class="aheto-timeline__timeline">
            <div class="aheto-timeline__events-wrapper">
                <div class="aheto-timeline__events">
                    <ol>
                        <?php

                        $counter = 1;

                        foreach ($rela_timeline as $item) :
                            $item = wp_parse_args($item, [
                                'rela_timeline_date' => '',
                            ]);
                            extract($item);

                            if ($counter === 1) { ?>
                                <li><a href="#0" class="selected"
                                       data-date="<?php echo esc_attr($rela_timeline_date); ?>">
                                        <h5><?php echo esc_html($rela_timeline_date); ?></h5></a>
                                </li>
                            <?php } else { ?>
                                <li><a href="#0"
                                       data-date="<?php echo esc_attr($rela_timeline_date); ?>">
                                        <h5><?php echo esc_html($rela_timeline_date); ?></h5></a>
                                </li>
                            <?php } ?>


                            <?php $counter++;

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

                foreach ($rela_timeline as $item) :
                    $item = wp_parse_args($item, [
                        'rela_timeline_date' => '',
                        'rela_timeline_image' => '',
                        'rela_timeline_title' => '',
                        'rela_timeline_content' => '',
                        'rela_add_button' => '',
                    ]);
                    extract($item);

                    if ($counter === 1) { ?>
                        <li class="selected" data-date="<?php echo esc_attr($rela_timeline_date); ?>">
                    <?php } else { ?>
                        <li data-date="<?php echo esc_attr($rela_timeline_date); ?>">
                    <?php } ?>

                    <div class="aheto-timeline__wrap">

                        <div class="aheto-timeline__image-wrap">
                            <?php if (!empty($rela_timeline_image)) { ?>
                                <?php echo Helper::get_attachment($rela_timeline_image, ['class' => 'aheto-timeline-slider__add-image'], $rela_image_size, $atts, 'rela_'); ?>
                            <?php } ?>
                        </div>

                        <div class="aheto-timeline__content">
                            <?php if (!empty($rela_timeline_title)) {
                                $rela_timeline_title = str_replace(']]', '</span>', $rela_timeline_title);
                                $rela_timeline_title = str_replace('[[', '<span>', $rela_timeline_title); ?>
                                <h4 class="aheto-timeline__title"><?php echo wp_kses($rela_timeline_title, 'post'); ?></h4>
                            <?php }

                            if (!empty($rela_timeline_content)) { ?>
                                <p class="aheto-timeline__desc"><?php echo wp_kses($rela_timeline_content, 'post'); ?></p>
                            <?php }

                            if ($rela_add_button) { ?>
                                <div class="aheto-timeline-slider__links">
                                    <?php echo Helper::get_button($this, $item, 'rela_'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    </li>
                    <?php
                    $counter++;

                endforeach; ?>

            </ol>
        </div> <!-- .events-content -->
    </section>

</div>
