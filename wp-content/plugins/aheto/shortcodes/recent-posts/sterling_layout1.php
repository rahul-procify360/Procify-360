<?php

/**
 * Recent Posts default templates.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_recent_posts--sterling');


$hide_thumb_class = isset($hide_thumb) && $hide_thumb ? 'hide-thumb' : 'with-thumb';

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/recent-posts/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-recent-post', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';

// Posts Content.
$post_query = new WP_Query([
	'post_type'      => $post_type,
	'posts_per_page' => $limit,
]);
if ($post_query->have_posts()) {
	echo '<ul>';

	// Post Loop.
	while ($post_query->have_posts()) {
		$post_query->the_post();
		$post_id = get_the_ID(); ?>
		<li class="<?php echo esc_attr($hide_thumb_class); ?>">
			<?php if (!$hide_thumb && has_post_thumbnail($post_id)) {
				$post_image       = array();
				$post_image['id'] = get_post_thumbnail_id($post_id);
				$background_image = Helper::get_background_attachment($post_image, 'full'); ?>
				<div class="widget-img" <?php echo esc_attr($background_image); ?>></div>
			<?php } ?>
			<div class="widget-text">
				<a href="<?php the_permalink(); ?>" class="post-title"><?php the_title(); ?></a>
				<span class="post-date"><?php echo get_the_date('d M, Y'); ?></span>
			</div>
		</li>
<?php

	}
	echo '</ul>';
	wp_reset_postdata();
}

echo '</div>';
