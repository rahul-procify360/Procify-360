<?php
/**
 * The Google Map Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Sanitize;
use Aheto\Helper;

extract($atts);
if (empty($addresses)) {
	return;
}


$addresses = $this->parse_group($addresses);

$all_addresses = array();
$all_markers = array();

foreach ($addresses as $list) {
	$all_addresses[] = $list['address'];
}

$address = implode("|", $all_addresses);


// Get aheto option.
$options = get_option('aheto-general-settings');
$google_map_style = isset($options['google_api_style']) && !empty($options['google_api_style']) ? $options['google_api_style'] : '';
$height = is_array($height) && !empty($height['size']) ? $height['size'] . $height['unit'] : $height;
$height = Sanitize::size($height);
$marker = is_array($marker) && !empty($marker['id']) ? $marker['id'] : $marker;


foreach ($addresses as $list) {

	$custom_marker = wp_get_attachment_url($marker);

	if (isset($list['choose_marker']) && $list['choose_marker'] == 'custom' && !empty($list['item_marker'])) {
		$custom_marker_id = is_array($list['item_marker']) && !empty($list['item_marker']['id']) ? $list['item_marker']['id'] : $list['item_marker'];
		$custom_marker = wp_get_attachment_url($custom_marker_id);
	}

	$all_markers[] = $custom_marker;
}

$markers = implode("|", $all_markers);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-map--karma-events1');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/google-map/';

$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_events-google-map-layout1', $shortcode_dir . 'assets/css/karma_events_layout1.css', null, null);
} ?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-map" data-height="<?php echo esc_attr($height); ?>"
		<?php if(!empty($overlay)){ ?>
		 data-overlay="<?php echo esc_attr($overlay); ?>"
		<?php } ?>
		 <?php if(!empty($google_map_style)){ ?>
			 data-style="<?php echo esc_attr($google_map_style); ?>"
		 <?php } ?>
		<?php if(!empty($zoom)){ ?>
		 data-zoom="<?php echo esc_attr($zoom); ?>"
		<?php } ?>
		 data-address="<?php echo esc_attr($address); ?>"
		<?php if (!empty($markers)) { ?>
			data-markers="<?php echo esc_attr($markers); ?>"
		<?php }

		if (!empty($marker)) { ?>
			data-active-marker-img="<?php echo wp_get_attachment_url($marker); ?>"
			data-marker-img="<?php echo wp_get_attachment_url($marker); ?>"
		<?php } ?> >
	</div>
	<div class="aheto-map__contact">
		<?php if (!empty($karma_events_titles)) : ?>
			<h2 class="aheto-map__title ">
				<?php echo wp_kses_post($karma_events_titles); ?>
			</h2>
		<?php endif; ?>
		<?php if (!empty($karma_events_phone)) : ?>
			<a href="tel:<?php echo esc_attr($karma_events_phone); ?>" class="aheto-map__desc ">
				<i class="icon ion-ios-telephone"></i>
				<?php echo wp_kses_post($karma_events_phone); ?>
			</a>
		<?php endif; ?>
		<?php if (!empty($karma_events_address)) : ?>
			<p class="aheto-map__desc ">
				<i class="icon ion-android-map"></i>
				<?php echo wp_kses_post($karma_events_address); ?>
			</p>
		<?php endif; ?>
		<?php if (!empty($karma_events_email)) : ?>
			<a href="mailto:<?php echo esc_attr($karma_events_email); ?>" class="aheto-map__desc ">
				<i class="icon ion-android-mail"></i>
				<?php echo wp_kses_post($karma_events_email); ?>
			</a>
		<?php endif; ?>
		<?php if (!empty($karma_events_hours)) : ?>
			<p class="aheto-map__desc ">
				<i class="icon ion-ios-clock"></i>
				<?php echo wp_kses_post($karma_events_hours); ?>
			</p>
		<?php endif; ?>
		<?php if ($karma_events_add_button == true) { ?>
			<?php echo Helper::get_button($this, $atts, 'karma_events_'); ?>
		<?php } ?>
	</div>
</div>
