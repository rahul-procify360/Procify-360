<?php

use Aheto\Helper;

/**
 * Skin 4.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__funero-3';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
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
	wp_enqueue_style('funero-skin-3', $shortcode_dir . 'assets/css/funero_skin-3.css', null, null);
	wp_enqueue_script('wc-cart');
}


?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
  <div class="aheto-cpt-article__inner">
    <?php if (has_post_thumbnail($ID)) {
      $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
    } ?>
    <div class="aheto-cpt-article__content">
      <?php
      $this->getTitle();
      ?>
      <?php
      if (class_exists('WooCommerce')) {
        global $product;
        if ($product) { ?>
          <div class="aheto-cpt-article__price"><?php wc_get_template('loop/price.php'); ?></div>
      <?php }
      } ?>
    </div>
  </div>
</article>
