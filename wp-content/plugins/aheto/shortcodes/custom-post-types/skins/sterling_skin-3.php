<?php

/**
 * Sterling news skin 3.
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
	wp_enqueue_style('sterling-skin-3', $sc_dir . 'assets/css/sterling_skin-3.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">
  <div class="aheto-cpt-article__inner">
    <div class="aheto-cpt-article__content-top">
      <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
    </div>

    <div class="aheto-cpt-article__content">
      <?php $this->getTitle(); ?>
      <div class="post-content--footer">
        <div class="aheto-cpt-article__date">
          <i class="icon ion-calendar"></i>
          <span><?php the_time('j F, Y'); ?></span>
        </div>
        <?php $this->get_template_part('footer'); ?>
      </div>
    </div>
  </div>
</article>
