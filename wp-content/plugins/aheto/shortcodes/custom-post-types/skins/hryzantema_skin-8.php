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

$icon = $this->get_icon_attributes('hryzantema_', true, true);
if ( !empty($icon) ) {
    $this->add_render_attribute('hryzantema_icon', 'class', 'aheto-cpt-article__ico icon');
    $this->add_render_attribute('hryzantema_icon', 'class', $icon['icon']);
    if ( !empty($icon['color']) ) {
        $this->add_render_attribute('hryzantema_icon', 'style', 'color:' . $icon['color']);
    }
}
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-custom-post-types-skin-8', $shortcode_dir . 'assets/css/hryzantema_skin-8.css', null, null);
	wp_enqueue_script( 'hryzantema-custom-post-types-skin-8-js', $shortcode_dir . 'assets/js/hryzantema_skin-8.min.js', array( 'jquery' ), null );
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">

        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_') ?>


        <div class="aheto-cpt-article__content">
            <p class="aheto-cpt-article__date">
                <?php
				$date = get_option( 'date_format' ) ;
				the_time( $date );
                ?>
            </p>
            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>

            <div class="aheto-cpt-article__excerpt">
                <?php the_excerpt(); ?>
            </div>
           <div class="aheto-cpt-article__link">
               <a class="aheto-link aheto-btn--light aheto-btn--no-underline" href="<?php the_permalink(); ?>">
                   Read the full article
                   <?php
                       if ( isset($icon) && !empty($icon) ) {
                           echo '<i ' . $this->get_render_attribute_string('hryzantema_icon') . '></i>';
                       }
                   ?>
               </a>
           </div>

        </div>

    </div>

</article>
