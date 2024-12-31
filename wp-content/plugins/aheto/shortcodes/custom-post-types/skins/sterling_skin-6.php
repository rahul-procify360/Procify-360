<?php

/**
 * Lsterling donation skin 6.
 */
use Aheto\Helper;
extract($atts);

$ID      = get_the_ID();
if ( !class_exists( 'Give' ) ) :
	return '';
endif;
$form_id = get_the_ID(); // Form ID.
$form        = new Give_Donate_Form($form_id);
$goal_option = give_get_meta($form->ID, '_give_goal_option', true);

$goal_format         = give_get_form_goal_format($form_id);
$price               = give_get_meta($form_id, '_give_set_price', true);
$color               = give_get_meta($form_id, '_give_goal_color', true);
$show_text           = isset($args['show_text']) ? filter_var($args['show_text'], FILTER_VALIDATE_BOOLEAN) : true;
$show_bar            = isset($args['show_bar']) ? filter_var($args['show_bar'], FILTER_VALIDATE_BOOLEAN) : true;
$goal_progress_stats = give_goal_progress_stats($form);

$income = $goal_progress_stats['raw_actual'];
$goal   = $goal_progress_stats['raw_goal'];

$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__sterling-6';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-skin-6', $sc_dir . 'assets/css/sterling_skin-6.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
  <div class="aheto-cpt-article__inner">
    <?php
    $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
    ?>
    <div class="aheto-cpt-article__content">
      <?php
      $terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
      $this->getTerms($atts['terms'], $terms_class);
      $this->getTitle();
      if (
        give_is_setting_enabled(get_post_meta($form_id, '_give_goal_option', true))
      ) {
        echo '<div class="give-card__progress">';
        give_show_goal_progress($form_id);
        echo '</div>';
      }
      $this->getExcerpt();
      ?>
      <?php if (!empty($atts['sterling_link_text'])) { ?>
        <div class="aheto-cpt-article__link">
          <a href="<?php the_permalink(); ?>" class="aheto-btn aheto-btn--primary">
            <?php echo esc_html($atts['sterling_link_text']); ?>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</article>
