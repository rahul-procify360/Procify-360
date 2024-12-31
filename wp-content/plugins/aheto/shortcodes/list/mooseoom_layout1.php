<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;
extract($atts);

$lists = $this->parse_group($mooseoom_links);
if ( empty($lists) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--mooseoom-links');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('mooseoom-list-layout1', $shortcode_dir . 'assets/css/mooseoom_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<ul>
		<?php
		foreach ( $lists as $item ) { ?>
			<li><a href="<?php echo esc_url($item['mooseoom_url']); ?>"><?php echo wp_kses_post($item['mooseoom_text']); ?></a></li>
		<?php }
		?>
	</ul>

</div>
