<?php
/**
 * Recent Posts default templates.
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
$this->add_render_attribute('wrapper', 'class', ' widget_recent_posts--famulus-modern');
$this->add_render_attribute('wrapper', 'class', 'modern');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


$underline        = isset($underline) && $underline ? 'underline' : '';
$hide_thumb_class = isset($hide_thumb) && $hide_thumb ? 'hide-thumb' : 'with-thumb';
$title_space      = isset($title_space) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute('title', 'class', 'widget-title');
$this->add_render_attribute('title', 'class', $underline);
$this->add_render_attribute('title', 'class', $title_space);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/recent-posts/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-recent-posts-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}


echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
// Posts Content.
$post_query = new WP_Query([
	'post_type'      => 'aheto-portfolio',
	'posts_per_page' => $limit,
]);
if ( $post_query->have_posts() ) {
	echo '<div class="widget_recent_posts__wrap">';

	// Post Loop.
	while ( $post_query->have_posts() ) {
		$post_query->the_post(); ?>

		<div class="widget_recent_posts__item">
			<?php echo get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'js-bg']); ?>
			<div class="widget_recent_posts__post-text">
				<h5>
					<a href="<?php the_permalink(); ?>"
					   class="widget_recent_posts__post-title"><?php the_title(); ?></a>
				</h5>
				<h6 class="widget_recent_posts__post-excerpt">
					<?php
					$taxonomies = get_object_taxonomies($post_type, 'objects');
					foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
						if ( $taxonomy_slug != 'post_tag' && $taxonomy_slug != 'post_format' && $taxonomy_slug != 'aheto-portfolio-tag' ) {
							$terms = get_the_terms(get_the_ID(), $taxonomy_slug);
							if ( !empty($terms) ) {
								foreach ( $terms as $term ) {
									echo strtolower($term->name) . str_repeat("&nbsp;", 3);
								}
							}
						}
					} ?>
				</h6>
			</div>
		</div>
		<?php
	}
	echo '</div>';
	wp_reset_postdata();
}
echo '</div>';
