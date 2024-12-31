<?php
/**
 * Title bar default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar');
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar--soapy-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'soapy-title-bar-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
		<div class="aheto-titlebar__content">
				<?php
				$title = $this->get_heading();
				if (!empty($title)) {
					$title_alignment = isset($title_alignment) && !empty($title_alignment) ? $title_alignment : '';
					echo '<' . $title_tag . ' class="aheto-titlebar__title  ' . $title_alignment . '">' .  $title . '</' . $title_tag . '>';
				}  ?>
		</div>

		<?php if ( !empty($breadcrumb) ) : ?>
			<div class="aheto-titlebar__breadcrumbs <?php echo !empty($crumb_alignment) ? $crumb_alignment : ''; ?>">
				<ul class="breadcrumbs">
					<li class="breadcrumbs__item">
						<a href="<?php echo esc_url(get_home_url()); ?>"><?php esc_html_e('Home', 'soapy'); ?></a>
					</li>
					<li class="breadcrumbs__item current"><?php echo get_the_title();?></li>
				</ul>
			</div>
		<?php endif; ?>
</div>
