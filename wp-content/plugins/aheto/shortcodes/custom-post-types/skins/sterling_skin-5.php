<?php

/**
 * Sterling news skin 5.
 */
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if (isset($terms_list) && !empty($terms_list)) {
  foreach ($terms_list as $term) {
    $classes[] = 'filter-' . $term->slug;
  }
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-skin-5', $sc_dir . 'assets/css/sterling_skin-5.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

  <div class="aheto-cpt-article__inner">

    <?php $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
    <div class="aheto-cpt-article__content">
      <?php
      $terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
      $this->getTerms($atts['terms'], $terms_class);
      $this->getTitle();
      $this->getExcerpt();
      if (!empty($atts['sterling_link_text'])) { ?>
        <div class="aheto-cpt-article__link">
          <a href="<?php the_permalink(); ?>" class="aheto-link aheto-btn--primary aheto-btn--no-underline">
            <?php echo esc_html($atts['sterling_link_text']); ?>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</article>
