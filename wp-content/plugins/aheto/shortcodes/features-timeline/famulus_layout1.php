<?php
/**
 * The Features Timeline Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$famulus_timeline = $this->parse_group($famulus_timeline);
if ( empty($famulus_timeline) ) {
	return '';
}


$this->generate_css();

$famulus_dark_version = isset($famulus_dark_version) && $famulus_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute('wrapper', 'class', 'aheto-timeline--famulus-modern');
$this->add_render_attribute('wrapper', 'class', $famulus_dark_version);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-features-timeline-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('famulus-features-timeline-layout1-js', $shortcode_dir . 'assets/js/famulus_layout1.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>


	<section class="aheto-timeline--famulus-modern">
		<div class="aheto-timeline__timeline">
			<div class="aheto-timeline__events-wrapper">
				<div class="aheto-timeline__events">
					<ol>
						<?php

						$counter = 1;

						foreach ( $famulus_timeline as $item ) :
							$item = wp_parse_args($item, [
								'famulus_timeline_date' => '',
							]);
							extract($item);

							if ( $counter === 1 ) { ?>
								<li><a href="#0" class="selected"
									   data-date="<?php echo esc_attr($famulus_timeline_date); ?>">
										<h5><?php echo esc_html($famulus_timeline_date); ?></h5></a>
								</li>
							<?php } else { ?>
								<li><a href="#0"
									   data-date="<?php echo esc_attr($famulus_timeline_date); ?>">
										<h5><?php echo esc_html($famulus_timeline_date); ?></h5></a>
								</li>
							<?php } ?>


							<?php $counter++;

						endforeach; ?>

					</ol>

					<span class="aheto-timeline__filling-line" aria-hidden="true"></span>
				</div> <!-- .events -->
			</div> <!-- .events-wrapper -->

			<ul class="aheto-timeline__navigation">
				<li><a href="#0" class="prev inactive ion-arrow-left-b"></a></li>
				<li><a href="#0" class="next ion-arrow-right-b"></a></li>
			</ul> <!-- .cd-timeline-navigation -->
		</div> <!-- .timeline -->

		<div class="aheto-timeline__events-content">
			<ol>
				<?php

				$counter = 1;

				foreach ( $famulus_timeline as $item ) :
					$item = wp_parse_args($item, [
						'famulus_timeline_date'    => '',
						'famulus_timeline_image'   => '',
						'famulus_timeline_title'   => '',
						'famulus_timeline_content' => '',
						'famulus_add_button'       => '',
					]);
					extract($item);

					if ( $counter === 1 ) { ?>
						<li class="selected" data-date="<?php echo esc_attr($famulus_timeline_date); ?>">
					<?php } else { ?>
						<li data-date="<?php echo esc_attr($famulus_timeline_date); ?>">
					<?php } ?>

					<div class="aheto-timeline__wrap">

						<div class="aheto-timeline__image-wrap">
							<?php if ( !empty($famulus_timeline_image) ) { ?>
								<?php echo Helper::get_attachment($famulus_timeline_image, ['class' => 'aheto-timeline-slider__add-image']); ?>
							<?php } ?>
						</div>

						<div class="aheto-timeline__content">
							<?php if ( !empty($famulus_timeline_title) ) {
								$famulus_timeline_title = str_replace(']]', '</span>', $famulus_timeline_title);
								$famulus_timeline_title = str_replace('[[', '<span>', $famulus_timeline_title); ?>
								<h3 class="aheto-timeline__title"><?php echo wp_kses_post($famulus_timeline_title); ?></h3>
							<?php }

							if ( !empty($famulus_timeline_content) ) { ?>
								<p class="aheto-timeline__desc"><?php echo wp_kses_post($famulus_timeline_content); ?></p>
							<?php }

							if ( $famulus_add_button ) { ?>
								<div class="aheto-timeline-slider__links">
									<?php echo Helper::get_button($this, $item, 'famulus_'); ?>
								</div>
							<?php } ?>
						</div>
					</div>
					</li>
					<?php
					$counter++;

				endforeach; ?>

			</ol>
		</div> <!-- .events-content -->
	</section>

</div>
