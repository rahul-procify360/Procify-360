<?php
/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();


// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-content-block--karma_marketing-layout2');
$this->add_render_attribute('wrapper', 'class', 't-center');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_marketing-features-single-layout2', $shortcode_dir . 'assets/css/karma_marketing_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php if ( !empty($karma_marketing_number) ): ?>
		<div class="aheto-content-block__number"><?php echo esc_html($karma_marketing_number); ?></div>
	<?php endif; ?>
    <?php if ( !empty($s_heading) && !empty($s_description) ) : ?>
        <div class="aheto-content-block__text-wrap">
            <?php if ( !empty($s_heading) ) : ?>
                <h5 class="aheto-content-block__title"><?php echo $this->highlight_text($s_heading); ?></h5>
            <?php endif; ?>

            <?php if ( !empty($s_description) ) : ?>
                <p class="aheto-content-block__info-text">
                    <?php echo esc_html($s_description); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
