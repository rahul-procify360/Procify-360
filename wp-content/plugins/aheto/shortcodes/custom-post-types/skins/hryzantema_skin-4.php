<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
    foreach ( $terms_list as $term ) {
        $classes[] = 'filter-' . $term->slug;
    }
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4';
$hide_thumb = $atts['hryzantema_hide_thumbnail'] ? 'hide-thumb' : '';
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-4', $shortcode_dir . 'assets/css/hryzantema_skin-4.css', null, null);
} ?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?> <?php echo esc_attr($hide_thumb); ?>">

    <div class="aheto-cpt-article__inner">

        <?php $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

        <div class="aheto-cpt-article__content">
            <?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
            <?php  $title = get_the_title();  ?>
            <a href="<?php the_permalink(); ?>">
				<?php echo wp_kses_post($title); ?>
            </a>
            <?php echo '</' . $tag . '>'; ?>

            <?php $this->getExcerpt(); ?>
        </div>
    </div>

</article>

