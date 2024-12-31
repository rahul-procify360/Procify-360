<?php

/**
 * The Features Timeline Shortcode.
 */

use Aheto\Helper;

extract($atts);

$vestry_timeline = $this->parse_group($vestry_timeline);
if (empty($vestry_timeline)) {
	return '';
}

$this->generate_css();

$vestry_dark_version = isset($vestry_dark_version) && $vestry_dark_version ? 'dark-version' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-timeline--vestry-modern');
$this->add_render_attribute('wrapper', 'class', $vestry_dark_version);


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-timeline/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'vestry-features-timeline-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('vestry-features-timeline-layout1-js', $shortcode_dir . 'assets/js/vestry_layout1.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
	<section class="aheto-timeline--vestry-modern">
		<div class="aheto-timeline__events-content">
			<ol>
				<?php
				$counter = 1;
				foreach ($vestry_timeline as $item) :
					$item = wp_parse_args($item, [
						'vestry_timeline_date'    => '',
						'vestry_timeline_image'   => '',
						'vestry_timeline_title'   => '',
						'vestry_timeline_content' => '',
						'vestry_add_button'       => '',
					]);
					extract($item);
					if ($counter === 1) { ?>
						<li class="selected" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
						<?php } else { ?>
						<li data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
						<?php } ?>
						<div class="aheto-timeline__wrap">
							<div class="aheto-timeline__image-wrap">
								<?php if (!empty($vestry_timeline_image)) { ?>
									<?php echo Helper::get_attachment($vestry_timeline_image, ['class' => 'aheto-timeline-slider__add-image'], $vestry_image_size, $atts, 'vestry_'); ?>
								<?php } ?>
							</div>
							<div class="aheto-timeline__content">
								<?php if (!empty($vestry_article_date)) { ?>
									<p class="aheto-timeline__subtitle"><?php echo esc_html( $vestry_article_date ); ?></p>
								<?php }
								if (!empty($vestry_timeline_title)) { ?>
									<h3 class="aheto-timeline__title"><?php echo esc_html($vestry_timeline_title); ?></h3>
								<?php }
								if (!empty($vestry_timeline_content)) { ?>
									<p class="aheto-timeline__desc"><?php echo esc_html($vestry_timeline_content); ?></p>
								<?php } ?>
							</div>
						</div>
						</li>
					<?php
					$counter++;
				endforeach; ?>
			</ol>
		</div> <!-- .events-content -->
		<div class="aheto-timeline__timeline">
			<div class="aheto-timeline__events-wrapper">
				<div class="aheto-timeline__events">
					<ol>
						<?php
						$counter = 1;
						foreach ($vestry_timeline as $item) :
							$item = wp_parse_args($item, [
								'vestry_timeline_date' => '',
							]);
							extract($item);
							if ($counter === 1) { ?>
								<li><a href="#0" class="selected" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
										<h5><?php echo esc_html($vestry_timeline_date); ?></h5>
									</a>
								</li>
							<?php } else { ?>
								<li><a href="#0" data-date="<?php echo esc_attr($vestry_timeline_date); ?>">
										<h5><?php echo esc_html($vestry_timeline_date); ?></h5>
									</a>
								</li>
							<?php } ?>
						<?php $counter++;
						endforeach; ?>
					</ol>
					<span class="aheto-timeline__filling-line" aria-hidden="true"></span>
				</div>
			</div>
		</div>
	</section>
</div>
