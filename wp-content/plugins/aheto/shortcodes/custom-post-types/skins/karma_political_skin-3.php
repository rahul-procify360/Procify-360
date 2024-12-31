<?php
/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */
use Aheto\Helper;

$ID = get_the_ID();

$karma_political_terms = [];
$classes    = [];
$classes[]  = 'aheto-cpt-article';
$classes[]  = 'aheto-cpt-article--' . $atts['layout'];
$classes[]  = 'aheto-cpt-article--' . $atts['skin'];

$img_class  = $atts['layout'] === 'slider' || $atts['layout'] === 'masonry' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $atts['layout'] !== 'slider' ) {
	if ( $terms_list ) {
		foreach ( $terms_list as $term ) {
			$classes[]    = 'filter-' . $term->slug;
			$karma_political_terms[] = $term->name;
		}
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'karma-political-skin-3', $shortcode_dir . 'assets/css/karma_political_skin-3.css', null, null );
}

$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<div class="aheto-cpt-article__content">
           <div class="aheto-cpt-article__product-image">
                <?php if ( has_post_thumbnail($ID) ) {
                    $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
                } ?>
            </div>

			<?php
			    $this->getTitle();

                if (class_exists('WooCommerce')) {
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
