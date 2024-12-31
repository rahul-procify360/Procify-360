<?php
/**
 * The Heading Shortcode.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--hr__modern' );
$this->add_render_attribute( 'wrapper', 'class', $alignment );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $hryzantema_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$use_dot = isset( $use_dot ) && ! empty( $use_dot ) ? 'hr-dot' : '';
$hryzantema_text_image = isset( $hryzantema_text_image ) && ! empty( $hryzantema_text_image ) ? $hryzantema_text_image : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-heading-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php
    // Heading.
    $heading = $this->get_heading();

    $disable_color = $hryzantema_highlighted_text ? 'color-none' : '';

    if ( !empty($heading) && !empty($hryzantema_text_image['url']) ) { ?>
        <<?php echo esc_attr($text_tag) ?>
            class="aheto-heading__title"
            style="background-image: url(<?php echo esc_url($hryzantema_text_image['url']); ?>);"
        >
            <?php
			$headings = $this->highlight_text( $heading, $animation );
			echo esc_html($headings) ?>
            <div class="colorful"><?php echo esc_html($headings) ?></div>
        </<?php echo esc_attr($text_tag) ?>>

    <?php } ?>

</div>
