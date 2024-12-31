<?php
/**
 * The Testimonials Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$aira_testimonials = $this->parse_group($aira_testimonials);
if ( empty($aira_testimonials) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper');
$this->add_render_attribute('wrapper', 'class', 'aheto-tm-wrapper--aira-modern');

$aira_dark_version = isset($aira_dark_version) && $aira_dark_version ? 'dark-version' : '';
$this->add_render_attribute('wrapper', 'class', $aira_dark_version);

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'    => 1000,
	'autoplay' => false,
	'spaces'   => 30,
	'slides'   => 3,
	'arrows'    => true
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params($atts, 'aira_swiper_', $carousel_default_params);


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/testimonials/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-testimonials-modern', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('aira-testimonials-modern-js', $sc_dir . 'assets/js/aira_layout1.min.js', array('jquery'), null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php if (!empty($aira_bg_text)) { ?>
        <div class="aheto-tm__bg-text"><?php echo esc_html($aira_bg_text); ?></div>
    <?php } ?>

    <div class="swiper">

        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?>>

            <div class="swiper-wrapper">

                <?php foreach ($aira_testimonials as $item) : ?>

                    <div class="swiper-slide">

                        <div class="aheto-tm__slide-wrap">

                            <div class="aheto-tm__content">
                                <?php
                                // Testimonial.
                                if (isset($item['aira_testimonial'])) {
                                    echo '<h4 class="aheto-tm__text">' . wp_kses($item['aira_testimonial'], 'post') . '</h4>';
                                } ?>
                            </div>

                            <div class="aheto-tm__author">

                                <?php if (!empty($item['aira_image'])) : ?>
                                    <div class="aheto-tm__avatar">
                                        <?php echo Helper::get_attachment($item['aira_image'], ['class' => 'js-bg'], array(63, 63)); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="aheto-tm__info">
                                    <?php
                                    // Name.
                                    if (isset($item['aira_name'])) {
                                        echo '<h5 class="aheto-tm__name">' . wp_kses($item['aira_name'], 'post') . '</h5>';
                                    }

                                    // Company.
                                    if (isset($item['aira_company'])) {
                                        echo '<p class="aheto-tm__position">' . wp_kses($item['aira_company'], 'post') . '</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
