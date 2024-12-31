<?php

/**
 * CPT Event Greed.
 *
 */

use Aheto\Helper;

extract($atts);
$atts['layout'] = 'grid';

// Query.
$the_query = $this->get_wp_query();
if (!$the_query->have_posts()) {
	return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'vestry_skin-6';

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt--vestry-grid');
$this->add_render_attribute('wrapper', 'class', $skin ? 'js-popup-gallery' : '');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('vestry-custom-post-types-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php
	$this->add_excerpt_filter();
	$content = [];
	$filters = [];

	$content[] = '<div class="aheto-cpt-article aheto-cpt-article--size"></div>';

	$id = 'aheto_cpt_' . rand(0, 1000);
	while ($the_query->have_posts()) :
		$the_query->the_post();

		ob_start();

		$terms_list = get_the_terms(get_the_ID(), $terms);

		if (!empty($terms_list)) {
			$filters    = array_merge($filters, $terms_list);
		}

		$this->get_skin_part($skin, $atts);

		$content[] = ob_get_clean();
	endwhile;

	$this->remove_excerpt_filter();

	$this->cpt_filter($add_filter, $filters, $id, $all_items_text, $add_center_filter);

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr($id) . '">' . join("\n", $content) . '</div>';

	$this->cpt_load_more($atts, $the_query->max_num_pages, $id);
	$this->cpt_pagination($atts, $the_query->max_num_pages);

	wp_reset_postdata(); ?>

</div>
