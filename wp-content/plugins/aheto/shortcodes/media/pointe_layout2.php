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

$lists = $this->parse_group($pointe_medias);
if (empty($lists)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-media aheto-media--pointe-isotope');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('pointe-media-layout2', $sc_dir . 'assets/css/pointe_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('pointe-media-layout2-js', $sc_dir . 'assets/js/pointe_layout2.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div class="aheto-media__head">
		<ul class="aheto-media__list ">
			<li class="aheto-media__list-item active">
		<?php if ( !empty($pointe_flitr_all )) {
			echo '<a href="#" class="aheto-media__list-link js-tab-list active" data-pricing-filter="*">' . wp_kses_post($pointe_flitr_all) . '</a>';
		}
		?>
			</li>
			<?php
			$all_filters = array();
			foreach ($pointe_medias as $index => $item) :
				$item['pointe_medias_heading'] = !empty($item['pointe_medias_heading']) ? $item['pointe_medias_heading'] : '';
				$filter_heading = str_replace(' ', '_', $item['pointe_medias_heading']);
				$filter_heading = strtolower($filter_heading);
				if (!in_array($item['pointe_medias_heading'], $all_filters)) {

					$all_filters[] = $item['pointe_medias_heading'];
					$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
					$active = $index > 0 ? '' : 'active'; ?>

					<li class="aheto-media__list-item ">
						<a href="#" data-pricing-filter=".<?php echo esc_html($filter_heading); ?>" class="aheto-media__list-link js-tab-list">
							<?php if ($item['pointe_medias_heading']) :

								echo esc_html($item['pointe_medias_heading']);

							endif; ?>
						</a>
					</li>
			<?php
				}
			endforeach; ?>
		</ul>
	</div>

	<div class="aheto-media__content">
		<?php
		$counter = 1;
		foreach ($pointe_medias as $index => $item) :
			$filter_heading = str_replace(' ', '_', $item['pointe_medias_heading']);
			$filter_heading = strtolower($filter_heading);
		?>
			<?php $counter < 9 ? $hide_item = '' : $hide_item = 'hide-item'; ?>
			<div class="aheto-media__box js-isotope-box <?php echo esc_attr($filter_heading); ?> <?php echo esc_attr($hide_item); ?>  ?>">
				<div class="aheto-media__box-inner">
					<?php
					if (!empty($item['pointe_image2'])) {
						echo Helper::get_attachment($item['pointe_image2']);
					}
					?>
					<div class="aheto_video-btn__image">
						<?php echo \Aheto\Helper::get_video_button($item, 'pointe_'); ?>
					</div>
				</div>
			</div>
			<?php $counter++; ?>
		<?php endforeach; ?>

	</div>
	<div class="aheto-list--pointe-table-links-button <?php echo esc_attr($this->atts['pointe_align']); ?>">
		<a href="#" class="aheto-link aheto-btn--dark aheto-btn--no-underline" target="_self"><i class="fa fa-circle aheto-btn__icon--left"></i>VIEW MORE</a>
	</div>
</div>
