<?php

/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

extract( $atts );

use Aheto\Helper;

$this->generate_css();


// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-heading--kunst__simple' );
$this->add_render_attribute( 'wrapper', 'class', $kunst_align );
$this->add_render_attribute( 'wrapper', 'class', 'align-tab-' . $kunst_align_tablet );
$this->add_render_attribute( 'wrapper', 'class', 'align-mob-' . $kunst_align_mobile );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/heading/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;lse;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-heading-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php if ( !empty( $image['id'] ) ) :?>
		<div class="aheto-heading__img "><?php echo Helper::get_attachment( $image ); ?></div>
	<?php endif; ?>

	<div class="aheto-heading__content <?php echo esc_attr($kunst_style); ?>">
		<?php

	        //Heading.
	        if ( 'post_title' === $source ) {
	            $kunst_heading = get_the_title();
	        }

	        if ( !empty( $kunst_subtitle ) ) {
	            echo '<' . $kunst_subtitle_tag . ' class="aheto-heading__subtitle"> <span class="aheto-heading__frame"> '. esc_html($kunst_subtitle) .'</span></' . $kunst_subtitle_tag . '>';
	        }

	        if ( !empty( $kunst_heading ) ) {
	            echo '<' . $text_tag . ' class="aheto-heading__title">' . wp_kses($kunst_heading, 'post') . '</' . $text_tag . '>';
	        }

		?>
	</div>

</div>
