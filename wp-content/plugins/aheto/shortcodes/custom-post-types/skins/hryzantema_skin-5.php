<?php
use Aheto\Helper;

/**
 * Created by PhpStorm.
 * User: yurii_oliiarnyk
 * Date: 20.08.19
 * Time: 15:21
 */

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
foreach ( $terms_list as $term ) {
    $classes[] = 'filter-' . $term->slug;
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-5', $shortcode_dir . 'assets/css/hryzantema_skin-5.css', null, null);
} ?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">

        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>

        <div class="aheto-cpt-article__content">
            <p class="aheto-cpt-article__date">
                <i class="fa fa-clock-o"></i>
                <?php
				$date = get_option( 'date_format' ) ;
                the_time($date );
                esc_html_e(' in World', 'hryzantema')
                ?>
            </p>
            <?php

            $this->getTitle();

            ?>

        </div>

    </div>

</article>
