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


$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-7', $shortcode_dir . 'assets/css/hryzantema_skin-7.css', null, null);
} ?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">

        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_') ?>


        <div class="aheto-cpt-article__content">
            <p class="aheto-cpt-article__date">
                <i class="fa fa-clock-o"></i>
                <?php
				$date = get_option( 'date_format' ) ;
				the_time( $date );
                esc_html_e(' in World', 'hryzantema')
                ?>
            </p>
            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>

            <div class="aheto-cpt-article__excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="aheto-cpt-article__author-meta">
                <?php
                global $post;
                $url = get_avatar_url( $post, "size=30"); ?>
                <img class="aheto-cpt-article__avatar" alt="<?php the_title(); ?>" src="<?php echo esc_url($url) ?>">

                <?php  esc_html_e( 'by ' , 'hryzantema'); echo get_the_author_meta( 'first_name') . ' ' . get_the_author_meta( 'last_name');  ?>
            </div>

        </div>

    </div>

</article>
