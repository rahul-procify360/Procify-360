<?php

use Aheto\Helper;

extract( $atts );

$ID = get_the_ID();

$use_shadow = $acacio_use_shadow ? 'box-shadow': '';

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = $use_shadow;
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
foreach ( $terms_list as $term ) {
    $classes[] = 'filter-' . $term->slug;
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$format = $this->get_post_format();
$format = isset($format) && !empty($format) ? $format : 'image';
/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('acacio-skin-7', $shortcode_dir . 'assets/css/acacio_skin-7.css', null, null);
	wp_enqueue_script( 'acacio-skin-7-js', $shortcode_dir . 'assets/js/acacio_skin-7.js', array( 'jquery' ), null );
}
?>


<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner">

        <!-- TOP -->
        <div class="aheto-cpt-article__content-top">
            <?php $this->getTerms($atts['terms']); ?>
            <?php $this->getTitle(); ?>
            <?php $this->getDate(); ?>
        </div>


        <?php

        switch ( $format ) {
            case 'quote':
                $this->getQuote('aheto-quote aheto-quote--icon-right');

                break;

            case 'video':
                $video_btn_params = [
                    'video_style' => 'aheto-btn--light',
                    'video_size'  => 'aheto-btn-video--large',
                ];

                $this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, $atts['cpt_image_size'], true, false, $atts, 'cpt_');
                break;

            case 'slider':
                $this->getSlider('', true, false, $atts['cpt_image_size'], true, false, $atts, 'cpt_');
                break;

            case 'gallery':
                $this->getGallery('', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
                break;

            case 'audio':
                $this->getAudio('is-audio-large');
                break;

            case 'image':
            default:
                $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');

        } ?>

        <div class="aheto-cpt-article__content">
            <?php
            $this->getExcerpt();
            $this->getLink('aheto-link aheto-btn--dark aheto-btn--reverse');
            ?>

        </div>

        <?php $this->get_template_part('footer'); ?>

    </div>

</article>

