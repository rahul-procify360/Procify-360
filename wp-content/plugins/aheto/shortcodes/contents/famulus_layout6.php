<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$famulus_simple_link = $this->parse_group($famulus_simple_link);

if ( empty($famulus_simple_link) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--famulus-simple-link');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-content-layout6', $shortcode_dir . 'assets/css/famulus_layout6.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $famulus_simple_link as $item ) : ?>
		<div class="aheto-contents__text-wrap">
			<?php if ( !empty($item['famulus_title_simple']) ):
				echo '<' . $item['famulus_title_tag_simple'] . ' class="aheto-contents__title">' .
					$item['famulus_title_simple']
					. '</' . $item['famulus_title_tag_simple'] . '>';
			endif; ?>
			<div class="aheto-contents__text">
				<?php if ( !empty($item['famulus_text']) ): ?>
					<p class="aheto-contents__desc">
						<?php echo esc_html($item['famulus_text']) ?>
					</p>
				<?php endif; ?>
				<?php if ( !empty($item['famulus_link_title_simple']) ): ?>
					<a href="<?php echo esc_url($item['famulus_link_url_simple']); ?>"
					   class="aheto-contents__link">
						<?php echo esc_html($item['famulus_link_title_simple']) ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
