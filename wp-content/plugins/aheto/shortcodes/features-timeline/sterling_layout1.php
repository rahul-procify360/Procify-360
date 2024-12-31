<?php

/**
 * The Features Timeline Shortcode.
 */

use Aheto\Helper;

extract($atts);

$sterling_timeline = $this->parse_group($sterling_timeline);
if (empty($sterling_timeline)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-timeline--sterling-modern');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-features-timeline-layout1', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('sterling-features-timeline-layout1-js', $sc_dir . 'assets/js/sterling_layout1.min.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<section class="aheto-timeline--sterling-modern">
		<div class="aheto-timeline__timeline">
			<div class="aheto-timeline__events-wrapper">
				<div class="aheto-timeline__events">
					<ol>
						<?php $counter = 1;
						foreach ($sterling_timeline as $item) :
							$item = wp_parse_args($item, [
								'sterling_timeline_date' => '',
							]);
							extract($item);
							if ($counter === 1) { ?>
								<li><a href="#0" class="selected"
									   data-date="<?php echo esc_attr($sterling_timeline_date); ?>">
										<h5><?php echo esc_html($sterling_timeline_date); ?></h5>
									</a>
								</li>
							<?php } else { ?>
								<li><a href="#0" data-date="<?php echo esc_attr($sterling_timeline_date); ?>">
										<h5><?php echo esc_html($sterling_timeline_date); ?></h5>
									</a>
								</li>
							<?php } ?>
							<?php $counter++;
						endforeach; ?>
					</ol>
					<span class="aheto-timeline__filling-line" aria-hidden="true"></span>
				</div>
			</div>

			<ul class="aheto-timeline__navigation">
				<li><a href="#0" class="prev inactive ion-android-arrow-back"></a></li>
				<li><a href="#0" class="next ion-android-arrow-forward"></a></li>
			</ul>
		</div>
		<div class="aheto-timeline__events-content">
			<ol>
				<?php $counter = 1;
				foreach ($sterling_timeline as $item) :
					$item = wp_parse_args($item, [
						'sterling_timeline_date' => '',
						'sterling_timeline_image' => '',
						'sterling_timeline_title' => '',
						'sterling_timeline_content' => '',
						'sterling_add_button' => '',
					]);
					extract($item);
					if ($counter === 1) { ?>
						<li class="selected" data-date="<?php echo esc_attr($sterling_timeline_date); ?>">
					<?php } else { ?>
						<li data-date="<?php echo esc_attr($sterling_timeline_date); ?>">
					<?php } ?>
					<div class="aheto-timeline__wrap">
						<div class="aheto-timeline__image-wrap">
							<?php if (!empty($sterling_timeline_image)) { ?>
								<?php echo Helper::get_attachment($sterling_timeline_image, ['class' => 'aheto-timeline-slider__add-image'], $sterling_image_size, $atts, 'sterling_'); ?>
							<?php } ?>
						</div>
						<div class="aheto-timeline__content">
							<?php if (!empty($sterling_timeline_title)) {
								$sterling_timeline_title = str_replace(']]', '</span>', $sterling_timeline_title);
								$sterling_timeline_title = str_replace('[[', '<span>', $sterling_timeline_title); ?>
								<h4 class="aheto-timeline__title"><?php echo wp_kses($sterling_timeline_title, 'post'); ?></h4>
							<?php }
							if (!empty($sterling_timeline_content)) { ?>
								<p class="aheto-timeline__desc"><?php echo wp_kses($sterling_timeline_content, 'post'); ?></p>
							<?php }
							if ($sterling_add_button) { ?>
								<div class="aheto-timeline-slider__links">
									<?php echo Helper::get_button($this, $item, 'sterling_'); ?>
								</div>
							<?php } ?>
						</div>
					</div>
					</li>
					<?php
					$counter++;
				endforeach; ?>
			</ol>
		</div>
	</section>
</div>
