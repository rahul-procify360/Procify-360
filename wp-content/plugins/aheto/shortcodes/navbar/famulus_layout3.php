<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

$famulus_fixed_menu = isset($famulus_fixed_menu) && $famulus_fixed_menu ? 'fixed-additional' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--famulus-links');
$this->add_render_attribute('wrapper', 'class', $famulus_fixed_menu);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-navbar-layout3', $shortcode_dir . 'assets/css/famulus_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-navbar--inner">
		<?php if (!empty($famulus_title)):
		$famulus_title = str_replace(']]', '</span>', $famulus_title);
		$famulus_title = str_replace('[[', '<span>', $famulus_title);
		?>
		<<?php echo esc_attr($famulus_title_tag); ?> class="aheto-navbar__title">
		<?php echo wp_kses($famulus_title, 'post'); ?>
	</<?php echo esc_attr($famulus_title_tag); ?>>
	<?php endif; ?>

	<?php foreach ( $famulus_links as $famulus_link ) {
		if ( !empty($famulus_link['famulus_link_title']) && !empty($famulus_link['famulus_link_url']) ) {
			?>
			<a href="<?php echo esc_url($famulus_link['famulus_link_url']) ?>"
			   title="<?php echo esc_attr($famulus_link['famulus_link_title']); ?>"
			   class="aheto-navbar__links">
				<span></span>
				<?php echo esc_html($famulus_link['famulus_link_title']); ?>
			</a>
		<?php }
	} ?>

	<?php
	if ( !empty($famulus_link_title_main) && !empty($famulus_link_url_main) ) {
		?>
		<a href="<?php echo esc_url($famulus_link_url_main) ?>"
		   title="<?php echo esc_attr($famulus_link_title_main); ?>"
		   class="aheto-navbar__main-link">
			<?php echo esc_html($famulus_link_title_main); ?>
			<span></span>
		</a>
	<?php }
	?>
</div>
</div>

