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

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_style('acacio-skin-4', $shortcode_dir . 'assets/css/acacio_skin-4.css', null, null);
}
?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">
        <?php if ( has_post_thumbnail() ) :
            $post_image = Helper::get_background_attachment( get_post_thumbnail_id() );
        endif;

        ?>
        <div class="aheto-cpt-article__img" <?php echo esc_attr($post_image); ?>>
        <div class="aheto-cpt-article__content">

            <?php

            $this->getTitle();
            $this->getTerms($atts['terms'], '', ', ');

            ?>

        </div>
    </div>

</article>

