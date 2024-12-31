<?php
/**
 * Custom Post Type Masonry Layout.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);
$atts['layout'] = 'grid';

// Query.
$the_query = $this->get_wp_query();
if (!$the_query->have_posts()) {
	return;
}

$skin = isset($skin) && !empty($skin) ? $skin : 'skin-1';

// Wrapper.
$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt');
$this->add_render_attribute('wrapper', 'class', 'aheto-cpt--soapy-grid');
$this->add_render_attribute('wrapper', 'class', $skin ? 'js-popup-gallery' : '');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-custom-post-types--layout1', $shortcode_dir . 'assets/css/soapy_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('soapy-custom-post-types--layout1-js', $shortcode_dir . 'assets/js/soapy_layout1.js', array('jquery'), null);
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
			$filters = array_merge($filters, $terms_list);
		}

		$this->get_skin_part($skin, $atts);

		$content[] = ob_get_clean();
	endwhile;

	$this->remove_excerpt_filter();
	if ($soapy_add_filter) { ?>

		<div class="aheto-cpt-filter">
			<ul class="aheto-cpt-filter__cat">
				<li class="aheto-cpt-filter__item aheto-cpt-filter__item--all">
					<a href="#" class="is-active" data-cpt-filter="*"
					   data-cpt-id="<?php echo esc_attr($id); ?>"><?php echo esc_html($soapy_all_items_text); ?></a>
				</li>

				<?php

				$filters_unique = [];
				foreach ($filters as $current) {
					if (!in_array($current, $filters_unique)) {
						$filters_unique[] = $current;
					}
				}
				$num = 0;
				foreach ($filters_unique as $term) :
					$num++;
					if ($num <= 4): ?>
						<li class="aheto-cpt-filter__item">
							<a href="#" data-cpt-filter=".filter-<?php echo esc_attr($term->slug); ?>"
							   data-cpt-id="<?php echo esc_attr($id); ?>"><?php echo esc_html($term->name); ?></a>
						</li>
					<?php endif;
				endforeach; ?>
			</ul>
			<div class="aheto-cpt-filter__item-right">

				<div class="aheto-cpt-filter__item-info">
					<?php
					$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$ppp = get_query_var('posts_per_page');
					$start = $posts_limit;
					$end = $posts_limit * $page;
					$total = $the_query->found_posts;
					if ($end > $total) {
						$start = $start - $end + $total;
					} ?>
					<?php esc_html_e('Showing ', 'soapy'); ?><?php echo esc_html($start); ?><?php esc_html_e(' of ', 'soapy'); ?><?php echo esc_html($total); ?><?php esc_html_e(' results', 'soapy'); ?>
				</div>
				<div class="aheto-cpt-filter__item-row">
					<a href="#" class="aheto-cpt-filter__item-row-main aheto-cpt-filter__item-row2  js-inRow"
					   data-count="2">
						<span class="aheto-cpt-filter__item-f3"></span>
					</a>
					<a href="#" class="aheto-cpt-filter__item-row-main aheto-cpt-filter__item-row3 is-active js-inRow"
					   data-count="3">
						<span class="aheto-cpt-filter__item-f3"></span>
						<span class="aheto-cpt-filter__item-s3"></span>
					</a>
					<a href="#" class="aheto-cpt-filter__item-row-main aheto-cpt-filter__item-row4 js-inRow"
					   data-count="4">
						<span class="aheto-cpt-filter__item-f3"></span>
						<span class="aheto-cpt-filter__item-s3"></span>
					</a>
				</div>
			</div>
		</div>
		<?php
	}

	echo '<div class="aheto-cpt__list js-isotope" data-cpt-id="' . esc_attr($id) . '">' . join("\n", $content) . '</div>';

	$this->cpt_load_more($atts, $the_query->max_num_pages, $id);
	$this->cpt_pagination($atts, $the_query->max_num_pages, $id);
	wp_reset_query(); ?>

</div>
