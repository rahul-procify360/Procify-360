<?php
use Aheto\Helper;

/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--bizy_skin-1';
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' || $atts['layout'] === 'mosaics' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $terms_list ) {
    foreach ( $terms_list as $term ) {
        $classes[] = 'filter-' . $term->slug;
    }
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('bizy-skin-1', $shortcode_dir . 'assets/css/bizy_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="aheto-cpt-article__inner">
        <?php 	if ( has_post_thumbnail($ID) ) {
            $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts,  'cpt_');
        } ?>
        <div class="aheto-cpt-article__content">
            <?php $terms_class = !has_post_thumbnail($ID) ? 'aheto-cpt-article__terms--static' : '';
            $this->getTerms($atts['terms'], $terms_class);
            $this->getTitle(); ?>
        </div>
    </div>
</article>

