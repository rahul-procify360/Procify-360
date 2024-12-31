<?php
/**
 * The Features Shortcode.
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
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

// Block Wrapper.
$this->add_render_attribute('block_wrapper', 'class', 'aheto-content--karma_events-no-image');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_events-features-single-layout1', $shortcode_dir . 'assets/css/karma_events_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__content">
		<div class="aheto-content-block__heading">
			<?php if ( !empty($s_heading) ) : ?>
				<h2 class="aheto-content-block__title ">
					<?php if ( !empty($karma_events_after_title) ) : ?>
						<span class="aheto-content-block__after-title "><?php echo wp_kses_post($karma_events_after_title); ?></span>
					<?php endif; ?>
					<?php
					$title = $this->highlight_text($s_heading);
					echo wp_kses_post($title); ?>
				</h2>
			<?php endif; ?>
		</div>
		<?php if ( !empty($s_description) ) : ?>
			<p class="aheto-content-block__info-text ">
				<?php echo wp_kses_post($s_description); ?>
			</p>
		<?php endif; ?>
		</div>
		<?php if ( !empty($karma_events_link_title) && !empty($karma_events_link_url) ) : ?>
			<a href="<?php echo esc_url($karma_events_link_url);?>" class="aheto-content-block__link ">
				<?php echo esc_html($karma_events_link_title); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
