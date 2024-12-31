<?php
use Aheto\Helper;

/**
 * Created by PhpStorm.
 * User: yurii_oliiarnyk
 * Date: 20.08.19
 * Time: 15:21
 */

$classes = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if(!empty($terms_list)) {
    foreach ($terms_list as $term) {
        $classes[] = 'filter-' . $term->slug;
    }
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('aira-cpt-4', $sc_dir . 'assets/css/aira_skin-4.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">
        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_') ?>

        <div class="aheto-cpt-article__content">
            <h5 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h5>
            <?php $this->getTerms($atts['terms']); ?>
        </div>

    </div>

</article>
