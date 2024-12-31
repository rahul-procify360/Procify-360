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
$famulus_faq_modern = $this->parse_group($famulus_faq_modern);

if ( empty($famulus_faq_modern) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--faq-famulus-modern');
$this->add_render_attribute('wrapper', 'class', 'js-accordion-parent');

if ( isset($multi_active) && !empty($multi_active) ) {
	$this->add_render_attribute('wrapper', 'data-multiple', '1');
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-contents-layout4', $shortcode_dir . 'assets/css/famulus_layout4.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-contents__faq-heading">
		<p class="aheto-contents__faq-heading-title-position">
			<?php _e('Position', 'famulus'); ?>
		</p>
		<p class="aheto-contents__faq-heading-title-type">
			<?php _e('Type', 'famulus'); ?>
		</p>
	</div>
	<?php
	foreach ( $famulus_faq_modern as $key => $item ) :
		$class_active = $key === 0 && $first_is_opened ? 'is-open' : '';
		$active_display = $key === 0 && $first_is_opened ? 'block' : 'none';

		if ( empty($item['famulus_item_title']) && empty($item['famulus_item_desc']) ) {
			continue;
		} ?>
		<div class="aheto-contents__item <?php echo esc_attr($class_active); ?>">
			<?php if ( !empty($item['famulus_item_title']) ) : ?>
				<h5 class="aheto-contents__title js-accordion"><?php echo wp_kses($item['famulus_item_title'], 'post'); ?></h5>
			<?php endif; ?>
			<?php if ( !empty($item['famulus_item_type']) ) : ?>
				<p class="aheto-contents__type"><?php echo wp_kses($item['famulus_item_type'], 'post'); ?></p>
			<?php endif; ?>
			<?php echo Helper::get_button($this, $item, 'famulus_faq_btn_'); ?>
			<span class="aheto-contents__border"></span>
			<?php if ( !empty($item['famulus_item_desc']) ) : ?>
				<div class="aheto-contents__panel js-accordion-text"
					 style="display: <?php echo esc_attr($active_display); ?>">
					<p class="aheto-contents__desc">
						<?php echo wp_kses($item['famulus_item_desc'], 'post'); ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
