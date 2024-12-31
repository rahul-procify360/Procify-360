<?php
/**
 * The Video Button Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $this->atts['element_id'] );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-video-container <?php echo esc_attr( $this->atts['align'] ); ?>">
		<?php echo Helper::get_video_button( $atts ); ?>
	</div>
</div>
