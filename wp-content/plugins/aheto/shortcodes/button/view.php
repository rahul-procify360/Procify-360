<?php
/**
 * The Button Shortcode.
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

$full_width = isset($this->atts['full_width']) && $this->atts['full_width'] ? 'full-width-button' : '';

$this->add_render_attribute( 'wrapper', 'class', $full_width );

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<div class="aheto-btn-container <?php echo esc_attr($this->atts['align']) . ' tablet-' . esc_attr($this->atts['align_tablet']) . ' mobile-' . esc_attr($this->atts['align_mobile']); ?>">

		<?php echo Helper::get_button($this, $atts);

		if ($atts['add_add_button'] ) {
			echo Helper::get_button($this, $atts, 'add_');
		} ?>

	</div>
</div>
