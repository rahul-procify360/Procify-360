<?php
/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

$ID = get_the_ID();


$karma_travel_terms = [];
$classes     = [];
$classes[]   = 'aheto-cpt-article';
$classes[]   = 'aheto-cpt-article--' . $atts['layout'];
$classes[]   = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[]   = 'aheto-cpt-article--' . $atts['skin'];
$img_class   = $atts['layout'] === 'slider' || $atts['layout'] === 'masonry' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $atts['layout'] !== 'slider' ) {
	if ( $terms_list ) {
		foreach ( $terms_list as $term ) {
			$classes[]     = 'filter-' . $term->slug;
			$karma_travel_terms[] = $term->name;
		}
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('karma_travel-skin-1', $shortcode_dir . 'assets/css/karma_travel_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<?php if ( has_post_thumbnail($ID) ) {
			$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
		} ?>


		<div class="aheto-cpt-article__content">
			<?php
			if ( class_exists('WooCommerce') ) {
				global $product;
				if ( $product ) { ?>
					<div class="aheto-cpt-article__price"><?php wc_get_template('loop/price.php'); ?></div>
				<?php }
			} ?>
			<?php $this->getTitle(); ?>
			<?php $this->getExcerpt(); ?>
		</div>
	</div>
</article>
