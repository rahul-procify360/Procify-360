<?php
/**
 * The Progress Bar Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/progress-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-progress-bar-layout2', $shortcode_dir . 'assets/css/outsourceo_layout2.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-progress aheto-progress--outsourceo-bar">

		<?php if ( ! empty( $heading ) ) {
			echo '<h6 class="aheto-progress__title">' . wp_kses($heading, 'post') . '</h6>';
		}

		if ( ! empty( $percentage ) ) { ?>
            <div class="aheto-progress__bar prog-bar">
                <h6 class="aheto-progress__bar-holder prog-bar-hldr">
                    <i class="aheto-progress__bar-icon icon"></i>
                    <span class="aheto-progress__bar-perc prog-bar-perc t-medium"><?php echo absint( $percentage ); ?></span><span>%</span>
                </h6>
                <div class="aheto-progress__bar-val prog-bar-val"></div>
            </div>
		<?php } ?>

    </div>

</div>




