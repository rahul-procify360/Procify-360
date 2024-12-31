<?php

use Aheto\Helper;

/**
 * Ewo Skin 4
 */

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if (isset($terms_list) && !empty($terms_list)) {
  foreach ($terms_list as $term) {
    $classes[] = 'filter-' . $term->slug;
  }
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-skin-4', $shortcode_dir . 'assets/css/ewo_skin-4.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
  <div class="aheto-cpt-article__inner">
    <div class="aheto-cpt-article__img">
      <?php
      if (has_post_thumbnail()) {
        echo Helper::get_attachment(get_post_thumbnail_id(), ['class' => 'js-bg'], $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
      }
      ?>
    </div>
    <a href="<?php the_permalink(); ?>" class="aheto-cpt-article__link"></a>
    <div class="aheto-cpt-article__content">
      <?php $terms_class =  'aheto-cpt-article__terms--static' ; ?>
      <?php $this->getTerms($atts['terms'], $terms_class); ?>
      <h5 class="aheto-cpt-article__title">
        <?php the_title(); ?>
      </h5>
    </div>
  </div>
</article>
