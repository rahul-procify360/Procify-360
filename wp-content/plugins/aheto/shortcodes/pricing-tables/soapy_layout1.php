<?php
/**
 * The Pricing Tables Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--soapy-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
if ( $soapy_active == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-pricing--soapy-active');
}
// Button Link.
$link = $this->get_button_attributes('link');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-pricing-tables-layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-pricing aheto-pricing--tableColumn ">
		<div class="aheto-pricing__content ">

			<?php
			// Heading.
			if ( !empty($heading )) {
				$heading = str_replace(']]', '</span>', $heading);
				$heading = str_replace('[[', '<span>', $heading);
				echo '<h5 class="aheto-pricing__box-title">' . wp_kses($heading, 'post') . '</h5>';
			}
			?>

			<div class="aheto-pricing__box-price">
				<?php
				// Price.
				if ( !empty($price) ) {
					echo esc_html($price);
				}
				?>
			</div>

			<?php if ( !empty($soapy_subtitle )) { ?>
				<div class="aheto-pricing__subtitle"><?php echo esc_html($soapy_subtitle); ?></div>
			<?php } ?>
			<?php
			$features = $this->parse_group($features);
			if ( !empty($features) ) {

				echo '<div class="aheto-pricing__list">';

				foreach ( $features as $key => $item ) {
					$classes = empty($item['feature']) ? 'is-empty' : '';
					echo '<p class="aheto-pricing__box-descr  ' . $classes . '" data-height-key="key-' . esc_attr($key) . '">';
					echo '[ok]' === $item['feature'] ? '<i class="ion-checkmark aheto-pricing__list-ico-ok"></i>' : wp_kses($item['feature'], 'post');
					echo '</p>';
				}

				echo '</div>';
			}

			// Button Link.
			if ( isset($link['href']) && !empty($link['title']) ) {
				$this->add_render_attribute('button', $link);
				$this->add_render_attribute('button', 'class', 'aheto-btn aheto-pricing__btn');
				printf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string('button'),
					esc_html($link['title'])
				);
			}
			?>

		</div>
	</div>

</div>
