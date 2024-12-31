<?php

/**
 * Skin 6 Event.
 */
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__vestry-6';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$ID = get_the_ID();

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if (isset($terms_list) && !empty($terms_list)) {
  foreach ($terms_list as $term) {
    $classes[] = 'filter-' . $term->slug;
  }
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

global $post;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('vestry-skin-6', $shortcode_dir . 'assets/css/vestry_skin-6.css', null, null);
	wp_enqueue_script('vestry-skin-6-js', $shortcode_dir . 'assets/js/vestry_skin-6.min.js', array('jquery'), null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">
  <div class="aheto-cpt-article__inner">
    <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
    <div class="aheto-cpt-article__content">
      <?php
      $this->getTerms($atts['terms'], '', ', ');
      $this->getTitle();
      ?>
      <div class="aheto-cpt-article__content-links">
          <div class="audio-links">
          <?php if (!empty($audio_url)) { ?>
            <a href="<?php echo esc_attr($audio_url) ?>" class="aheto-link aheto-btn--primary aheto-btn--no-underline" download>
              <i class="aheto-content-block__ico icon ion-ios-cloud-download"></i>
            </a>
          <?php } ?>
          <?php if (!empty($audio_url)) { ?>
            <a href="javascript:void(0);" class="aheto-link aheto-btn--primary aheto-btn--no-underline clickAudS">
              <i class="aheto-content-block__ico icon ion-headphone"></i>
              <audio id="<?php echo esc_attr($ID) ?>" src="<?php echo esc_attr($audio_url) ?>"></audio>
            </a>
          <?php } ?>
            <a href="<?php echo esc_attr($atts['vestry_audio_page']); ?>" class="aheto-link aheto-btn--primary aheto-btn--no-underline">
              <i class="aheto-content-block__ico icon ion-ios-copy"></i>
            </a>
            <a href="<?php the_permalink(); ?>" class="aheto-link aheto-btn--primary aheto-btn--no-underline">
              <i class="aheto-content-block__ico icon ion-ios-musical-notes"></i>
            </a>
          </div>
        <?php if (!empty($atts['vestry_link_text'])) { ?>
          <a href="<?php the_permalink(); ?>" class="more_link aheto-link aheto-btn--primary aheto-btn--no-underline">
            <?php echo esc_html($atts['vestry_link_text']); ?>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>
</article>
