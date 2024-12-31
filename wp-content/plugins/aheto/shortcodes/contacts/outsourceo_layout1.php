<?php
/**
 * The Contacts Shortcode.
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

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-contact--outsourceo-simple">

		<?php if ( !empty($s_heading) ) : ?>
			<h5 class="aheto-contact__type t-medium"><?php echo wp_kses($s_heading, 'post'); ?></h5>
		<?php endif; ?>

		<?php if ( !empty($outsourceo_text) ) : ?>
			<p class="aheto-contact__info t-light"><?php echo wp_kses($outsourceo_text, 'post'); ?></p>
		<?php endif; ?>

	</div>


</div>
