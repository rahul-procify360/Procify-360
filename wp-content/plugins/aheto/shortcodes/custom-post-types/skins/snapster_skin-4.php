<?php
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--snapster_skin-4';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' || $atts['layout'] === 'mosaics' ? 'js-bg' : '';
$tag = isset( $this->atts['title_tag'] ) && ! empty( $this->atts['title_tag'] ) ? $this->atts['title_tag'] : 'h4';

$snapster_slides_title = isset($atts['snapster_slides_title']) && !empty($atts['snapster_slides_title']) ? $atts['snapster_slides_title'] : esc_html__('Book', 'snapster');
$snapster_grayscale = isset($atts['snapster_grayscale']) && $atts['snapster_grayscale'] ? 'grayscale' : '';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('snapster-skin-4', $sc_dir . 'assets/css/snapster_skin-4.css', null, null);
	wp_enqueue_script('snapster-skin-4-js', $sc_dir . 'assets/js/snapster_skin-4.js', array('jquery'), null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

    <div class="aheto-cpt-article__inner <?php echo esc_attr($snapster_grayscale); ?>">
        <<?php echo esc_attr($tag); ?> class="aheto-cpt-article__title" data-title="<?php echo esc_attr($snapster_slides_title); ?>"></<?php echo esc_attr($tag); ?>>
		<?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
    </div>

</article>
