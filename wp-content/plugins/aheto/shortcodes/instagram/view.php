<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $token ) ) {
	return;
}

$this->generate_css();

$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-instagram--classic' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'aheto-instagram--title' );
$this->add_render_attribute( 'title', 'class', $underline );
$this->add_render_attribute( 'title', 'class', $title_space );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/instagram/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'instagram-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $title ) ) : ?>

		<h5 <?php $this->render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $title ); ?></h5>

	<?php endif; ?>

	<ul class="aheto-instagram__list"></ul>

</div>
<script>
    ;(function ($) {
        $( () => {
            jQuery.fn.spectragram.accessData = {
                accessToken: '<?php echo $token; ?>'
            }
            $('.aheto-instagram__list', '.<?php echo $atts['_id']; ?>').spectragram('getUserFeed', {
                size: 'small',
                max: <?php echo $limit ? $limit : 6; ?>
            });
        });
    })(jQuery);
</script>
