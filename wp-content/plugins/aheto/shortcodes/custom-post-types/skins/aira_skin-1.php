<?php
/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

$ID = get_the_ID();
extract( $atts );

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if(!empty($terms_list)){
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h5';


$content_after = isset($aira_content_after) && $aira_content_after ? 'aheto-cpt-article__content-after' : '';
/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('aira-skin-1', $sc_dir . 'assets/css/aira_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

    <div class="aheto-cpt-article__inner">

        <?php
        $isHasThumb = !$atts['aira_img_off'] ? $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_') : '';

        $isHasThumb2 = !$atts['aira_date_off'] ? true : false;

        $isHasThumb3 = !$atts['aira_author_off'] ? true : false;
        ?>

        <div class="aheto-cpt-article__content <?php echo esc_attr( $content_after );?>">
            <?php
            $terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
            ?>

            <?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
            <a href="<?php the_permalink(); ?>"><?php

                $title = get_the_title();

                echo aira_dot_string( $title, $atts['aira_dot'], $atts['aira_dot_color'] ); ?>
            </a>
            <?php echo '</' . $tag . '>'; ?>

            <?php if ($isHasThumb2) { ?>
                <div class="aheto-cpt-article__date">
                    <?php the_time(get_option('date_format'));

                    if (!empty($atts['aira_date_label'])) {
                        echo '<span>' . ' ' . esc_html($atts['aira_date_label']) . '</span>';
                    }

                    ?>

                </div>
            <?php } ?>

            <?php
            $this->getExcerpt();
            ?>

            <?php if ($isHasThumb3) { ?>
                <div class="aheto-cpt-article__author">

                    <?php
                    $author_id = get_the_author_meta('ID');

                    echo get_avatar($author_id, 30);
                    echo esc_html__('by ', 'aira') . esc_html(get_the_author()); ?>
                </div>
            <?php } ?>

        </div>

    </div>

</article>

