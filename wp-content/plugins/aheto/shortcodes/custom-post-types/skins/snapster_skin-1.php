<?php
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--snapster_skin-1';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
    foreach ($terms_list as $term) {
        $classes[] = 'filter-' . $term->slug;
    }
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' || $atts['layout'] === 'mosaics' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('snapster-skin-1', $shortcode_dir . 'assets/css/snapster_skin-1.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">
        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
        <div class="aheto-cpt-article__content">
            <?php
            $this->getTitle();
            ?>
            <div class="aheto-cpt-article__terms-wrap">
                <?php
                $this->getDate();
                $this->getTerms($atts['terms'], '', ', ');
                ?>
            </div>
        </div>
    </div>

</article>
