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

$icon = $this->get_icon_attributes('aira_', true, true);
if (!empty($icon)) {
    $this->add_render_attribute('aira_icon', 'class', 'aheto-cpt-article__ico icon');
    $this->add_render_attribute('aira_icon', 'class', $icon['icon']);
    if (!empty($icon['color'])) {
        $this->add_render_attribute('aira_icon', 'style', 'color:' . $icon['color']);
    }
}
/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('aira-cpt-3', $sc_dir . 'assets/css/aira_skin-3.css', null, null);
	wp_enqueue_script('aira-cpt-3-js', $sc_dir . 'assets/js/aira_skin-3.min.js', array('jquery'), null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">
        <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_') ?>

        <div class="aheto-cpt-article__overlay"></div>

        <div class="aheto-cpt-article__content">
            <div class="aheto-cpt-article__top_wrap">
                <p class="aheto-cpt-article__date dot_divider">
                    <?php
                    the_time(get_option('date_format'));
                    ?>
                </p>
                <p class="aheto-cpt-article__terms dot_divider">
                    <?php the_category(', '); ?>
                </p>

            </div>

            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>

            <div class="aheto-cpt-article__excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="aheto-cpt-article__link">
                <a class="aheto-link aheto-btn--light aheto-btn--no-underline" href="<?php the_permalink(); ?>">

                    <?php esc_html_e("Read full article", 'aira');

                    if (isset($icon) && !empty($icon)) {
                        echo '<i ' . $this->get_render_attribute_string('aira_icon') . '></i>';
                    }
                    ?>
                </a>
            </div>

        </div>

    </div>

</article>
