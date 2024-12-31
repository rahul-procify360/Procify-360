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


$soapy_terms = [];
$classes     = [];
$classes[]   = 'aheto-cpt-article';
$classes[]   = 'aheto-cpt-article--' . $atts['layout'];
$classes[]  = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'masonry' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $atts['layout'] !== 'slider' ) {
	if ( $terms_list ) {
		foreach ( $terms_list as $term ) {
			$classes[]     = 'filter-' . $term->slug;
			$soapy_terms[] = $term->name;
		}
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('soapy-skin-5', $shortcode_dir . 'assets/css/soapy_skin-5.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="aheto-cpt-article__inner">
		<?php if ( has_post_thumbnail($ID) ) {
			$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
		} ?>

		<?php
		if ( class_exists('WooCommerce') ) {
			global $product;
			if ( $product ) {
				$date1 = strtotime(get_the_date('Y/m/d H:i:s'));
				$date2 = strtotime(date('Y/m/d H:i:s'));
				$diff  = abs($date2 - $date1);
				$days  = round(abs($date1 - $date2) / 86400);

				if ( !$product->is_in_stock() ) { ?>
					<div class="aheto-cpt-article__label">
						<?php esc_html_e('Sold', 'soapy'); ?>
					</div>
				<?php } else if ( $product->is_on_sale() ) { ?>
					<div class="aheto-cpt-article__label">
						<?php esc_html_e('Hot', 'soapy'); ?>
					</div>
				<?php } else if ( $days < 7 ) { ?>
					<div class="aheto-cpt-article__label">
						<?php esc_html_e('New', 'soapy'); ?>
					</div>
				<?php }
			}
		}
		?>

		<div class="aheto-cpt-article__content">
			<?php $this->getTitle();
			if ( class_exists('WooCommerce') ) {
				global $product;
				if ( $product ) { ?>
					<div class="aheto-cpt-article__price"><?php wc_get_template('loop/price.php'); ?></div>
					<div class="aheto-cpt-article__btn">
						<?php if (!is_admin()): ?>
						<a class="aheto-cpt-article__btn-disabled">
							<?php endif; ?>
						<?php do_action('woocommerce_after_shop_loop_item'); ?></div>
				<?php }
			} ?>
		</div>
	</div>
</article>
