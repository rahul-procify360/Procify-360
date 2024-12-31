<?php
/**
 * The Coming soon Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract($atts);

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-coming-soon--default');
$this->add_render_attribute('wrapper', 'class', $light ? 'aheto-coming-soon--light' : '');
$this->add_render_attribute('wrapper', 'class', 'js-coming-soon');


$date  =  strtotime( esc_attr($time_out) );

$time_out_var = str_replace(' ', 'T', $time_out);

$this->add_render_attribute('wrapper', 'data-dates', $time_out_var);
$date  =  strtotime( esc_attr($time_out) );
$sec   = $date - time();

$days  = floor(($date - time()) / 86400);
$h1    = floor(($date - time()) / 3600);
$m1    = floor(($date - time()) / 60);
$hour  = floor($sec/60/60 - $days*24);
$hours = floor($sec/60/60);
$secs  = floor($sec % 60);
$min   = floor($sec/60 - $hours*60);

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/coming-soon/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('djo-coming-soon-layout1', $shortcode_dir . 'assets/css/djo_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-coming-soon__unit">
		<div class="aheto-coming-soon__number js-coming-soon-number days">00</div>
		<p class="aheto-coming-soon__caption js-coming-soon-caption"
		   data-desktop="<?php echo esc_attr($days_desktop); ?>"
		   data-mobile="<?php echo esc_attr($days_mobile); ?>"><?php echo esc_html($days_desktop); ?></p>
	</div>
	<span class="aheto-coming-soon__dots">:</span>
	<div class="aheto-coming-soon__unit">
		<div class="aheto-coming-soon__number js-coming-soon-number hours">00</div>
		<p class="aheto-coming-soon__caption js-coming-soon-caption"
		   data-desktop="<?php echo esc_attr($hours_desktop); ?>"
		   data-mobile="<?php echo esc_attr($hours_mobile); ?>"><?php echo esc_html($hours_desktop); ?></p>
	</div>
	<span class="aheto-coming-soon__dots">:</span>
	<div class="aheto-coming-soon__unit">
		<div class="aheto-coming-soon__number js-coming-soon-number minutes">00</div>
		<p class="aheto-coming-soon__caption js-coming-soon-caption"
		   data-desktop="<?php echo esc_attr($mins_desktop); ?>"
		   data-mobile="<?php echo esc_attr($mins_mobile); ?>"><?php echo esc_html($mins_desktop); ?></p>
	</div>
	<span class="aheto-coming-soon__dots">:</span>
	<div class="aheto-coming-soon__unit">
		<div class="aheto-coming-soon__number js-coming-soon-number seconds">00</div>
		<p class="aheto-coming-soon__caption js-coming-soon-caption"
		   data-desktop="<?php echo esc_attr($secs_desktop); ?>"
		   data-mobile="<?php echo esc_attr($secs_mobile); ?>"><?php echo esc_html($secs_desktop); ?></p>
	</div>
</div>
