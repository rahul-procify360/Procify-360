<?php
use Aheto\Helper;

/**
 * Ewo Skin 6
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-skin-6', $shortcode_dir . 'assets/css/ewo_skin-6.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

  <div class="aheto-cpt-article__inner">
    <?php
    switch ($format) {
      case 'quote':
        $this->getTerms($atts['terms'], '-hover-light');
        $this->getQuote('aheto-quote aheto-quote--icon-right');
        break;
      case 'slider':
        $this->getSlider('', true, false, $atts['image_size']);
        $this->getTerms($atts['terms']); ?>
        <div class="aheto-cpt-article__content">
          <?php $this->getDate(); ?>
          <?php $this->getTitle(); ?>
        </div>
      <?php
        break;
      case 'gallery':
        $this->getGallery('', $atts['image_size']); ?>
        <div class="aheto-cpt-article__content">
          <?php
          $this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
          $this->getDate();
          $this->getTitle();
          ?>
        </div>
      <?php
        break;
      case 'video':
        $video_btn_params = [
          'video_style' => 'aheto-btn--light',
          'video_size'  => 'aheto-btn-video--small',
        ];
        $this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
        $this->getTerms($atts['terms']); ?>
      <?php
        break;
      case 'audio': ?>
        <div class="aheto-cpt-article__content">
          <div class="aheto-cpt-article__content--pdng">
            <?php
            $this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
            $this->getAudio();
            ?>
          </div>
          <div class="aheto-cpt-article__footer">
            <div class="aheto-cpt-article__footer-item aheto-cpt-article__footer-item--date">
              <h5 class="aheto-cpt-article__footer-item--dateD"><?php the_time('d'); ?></h5>
              <p><?php the_time('M Y'); ?></p>
            </div>
            <div class="aheto-cpt-article__footer-item">
              <?php $this->getTitle(); ?>
            </div>
          </div>
        </div>
      <?php
        break;
      case 'image':
      default:
        $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_'); ?>
        <div class="aheto-cpt-article__content">
          <?php $terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : ''; ?>
          <?php $this->getTerms($atts['terms'], $terms_class); ?>
          <div class="aheto-cpt-article__footer">
            <div class="aheto-cpt-article__footer-item aheto-cpt-article__footer-item--date">
              <h5 class="aheto-cpt-article__footer-item--dateD"><?php the_time('d'); ?></h5>
              <p><?php the_time('M Y'); ?></p>
            </div>
            <div class="aheto-cpt-article__footer-item">
              <?php $this->getTitle(); ?>
            </div>
          </div>
        </div>
    <?php break;
    } ?>
  </div>
</article>
