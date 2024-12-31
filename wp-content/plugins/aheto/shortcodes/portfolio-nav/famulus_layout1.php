<?php
/**
 * Portfolio navigation templates.
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
$this->add_render_attribute('wrapper', 'class', 'portfolio-nav--famulus-modern');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$prev_post = get_previous_post(false, '', 'aheto-portfolio-category');
$next_post = get_next_post(false, '', 'aheto-portfolio-category');

$prev_post_class = empty($prev_post) ? 'empty-prev ' : '';
$next_post_class = empty($next_post) ? 'empty-next' : '';


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/portfolio-nav/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-portfolio-nav-layout1', $shortcode_dir . 'assets/css/famulus_layout1.css', null, null);
}

?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="portfolio-nav <?php echo esc_attr($prev_post_class . $next_post_class) ?>">

		<?php

		if ( !empty($prev_post) ) {
			$prev_post_image    = get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
			$prev_post_image_ID = get_post_thumbnail_id($prev_post->ID);
			$prev_post_alt      = get_post_meta($prev_post_image_ID, '_wp_attachment_image_alt', true);

			$prev = get_previous_post_link(
				'<div class="portfolio-nav__dir portfolio-nav__dir--prev">%link</div>',
				'<div class="portfolio-nav__dir-image"><img src="' . $prev_post_image . '" alt="' . $prev_post_alt . '" class="js-bg"></div>
					  <h5 class="portfolio-nav__dir-title">' . $prev_post->post_title .
				'<p>' . esc_html__('Prev ', 'famulus') . $famulus_prev_next . '</p>
					  </h5>',
				false,
				'',
				'aheto-portfolio-category'
			);

			echo str_replace('<a', '<a class="portfolio-nav__link"', $prev);
		}

		?>

		<div class="portfolio-nav__list">
			<a href="<?php echo get_post_type_archive_link('aheto-portfolio'); ?>" class="portfolio-nav__link">
				<i class="portfolio-nav__list-icon icon ion-ios-keypad"></i>
			</a>
		</div>

		<?php

		if ( !empty($next_post) ) {
			$next_post_image    = get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
			$next_post_image_ID = get_post_thumbnail_id($next_post->ID);
			$next_post_alt      = get_post_meta($next_post_image_ID, '_wp_attachment_image_alt', true);

			$prev = get_next_post_link(
				'<div class="portfolio-nav__dir portfolio-nav__dir--next">%link</div>',
				'<h5 class="portfolio-nav__dir-title">' . $next_post->post_title .
				'<p>' . esc_html__('Next ', 'famulus') . $famulus_prev_next . '</p>
					  </h5>
					  <div class="portfolio-nav__dir-image"><img src="' . $next_post_image . '" alt="' . $next_post_alt . '" class="js-bg"></div>',
				false,
				'',
				'aheto-portfolio-category'
			);

			echo str_replace('<a', '<a class="portfolio-nav__link"', $prev);
		}
		?>

	</div>

</div>
