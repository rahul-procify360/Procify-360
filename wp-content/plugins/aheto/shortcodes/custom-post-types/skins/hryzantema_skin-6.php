<?php

use Aheto\Helper;

$ID = get_the_ID();

extract( $atts );

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if(isset($terms_list) && !empty($terms_list)){
    foreach ( $terms_list as $term ) {
        $classes[] = 'filter-' . $term->slug;
    }
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-6', $shortcode_dir . 'assets/css/hryzantema_skin-6.css', null, null);
} ?>


<article class="aheto-cpt-article__post <?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="aheto-cpt-article__inner">
        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>
        <div class="aheto-cpt-article__content">

            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
                <?php
                $tags = get_the_tags();
                if(!empty($tags)) {
                    echo '-';
                    foreach ( $tags as $tag ) {
                        $tag_link = get_tag_link( $tag->term_id ); ?>
                        <a href='<?php echo esc_url($tag_link) ?>' title='<?php echo esc_attr($tag->name) ?> Tag' class='tag <?php echo esc_attr($tag->slug) ?>'>
                            <?php echo  wp_kses_post($tag->name) ?>
                        </a>
                    <?php  }

                }
                ?>
            </h4>
            <?php
            $this->getTerms($atts['terms']);
            ?>

            <div class="aheto-cpt-article__excerpt">
                <?php the_excerpt(); ?>
            </div>

            <div class="aheto-cpt-article__button">
                <a href="<?php the_permalink(); ?>">
                    <?php echo esc_html__('View Case Study', 'hryzantema'); ?>
                    <i class="fa fa-angle-right aheto-btn__icon--right"></i>
                </a>
            </div>
        </div>
    </div>


</article>

