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
$famulus_icon = $this->parse_group($famulus_icon);

if ( empty($famulus_icon) ) {
	return '';
}
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contents--famulus-icon-simple');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-content-layout5', $shortcode_dir . 'assets/css/famulus_layout5.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<?php foreach ( $famulus_icon as $item ) : ?>
		<div class="aheto-contents__icon-wrap">
			<?php if ( !empty($item['famulus_icon_font']) ): ?>
				<?php
				$icon = $item['famulus_icon_font'];

				if ( $icon == 'ionicons' ) { ?>
					<i class="<?php echo wp_kses($item['famulus_icon_ionicons'], 'post'); ?>"></i>
				<?php } else { ?>
					<i class="<?php echo wp_kses($item['famulus_icon_font-awesome'], 'post'); ?>"></i>
				<?php } ?>
			<?php endif; ?>
			<?php if ( !empty($item['famulus_item_title']) ): ?>
				<p class="aheto-contents__title"><?php echo esc_html($item['famulus_item_title']); ?></p>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
