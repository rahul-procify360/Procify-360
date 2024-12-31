<?php
/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */
use Aheto\Helper;
$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--skin-1';
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' || $atts['layout'] === 'mosaics' ? 'js-bg' : '';
$btn_style = 'aheto-link ' . $atts['btn_style'];
$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$swiper_prefix = isset($swiper_prefix) ? $swiper_prefix : '';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('cpt-1', $sc_dir . 'assets/css/skin-1.css', null, null);
}
$format = $this->get_post_format();
?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<?php

		switch ( $format ) {
			case 'quote':
				$this->getTerms($atts['terms'], '-hover-light');
				$this->getQuote('aheto-quote aheto-quote--icon-right');

				break;

			case 'slider':
				$this->getSlider('', true, false, $atts['cpt_image_size'], $atts, 'cpt_');
				$this->getTerms($atts['terms']); ?>

				<div class="aheto-cpt-article__content">
					<?php $this->getDate(); ?>
					<?php $this->getTitle(); ?>
					<?php $this->getExcerpt(); ?>
					<?php $this->getLink($btn_style); ?>
				</div>
				<?php
				break;

			case 'gallery':
				$this->getGallery('', $atts['cpt_image_size'], $atts, 'cpt_'); ?>

				<div class="aheto-cpt-article__content">
					<?php

					$this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
					$this->getDate();
					$this->getTitle();
					$this->getExcerpt();
					$this->getLink($btn_style);
					?>
				</div>
				<?php

				break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size'  => 'aheto-btn-video--small',
				];

				$this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, $atts['cpt_image_size'], $atts, 'cpt_');
				$this->getTerms($atts['terms']); ?>

				<div class="aheto-cpt-article__content">
					<?php $this->getDate(); ?>
					<?php $this->getTitle(); ?>
					<?php $this->getExcerpt(); ?>
					<?php $this->getLink($btn_style); ?>
				</div>
				<?php

				break;

			case 'audio': ?>

				<div class="aheto-cpt-article__content">
					<?php

					$this->getTerms($atts['terms'], 'aheto-cpt-article__terms--static');
					$this->getAudio();
					$this->getDate();
					$this->getTitle();
					$this->getExcerpt();
					$this->getLink($btn_style);

					?>
				</div>
				<?php
				break;

			case 'image':
			default:
				$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_', $swiper_prefix); ?>

				<div class="aheto-cpt-article__content">
					<?php
					$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
					$this->getTerms($atts['terms'], $terms_class);
					$this->getDate();
					$this->getTitle();
					$this->getExcerpt();
					$this->getLink($btn_style); ?>
				</div>

				<?php break;

		} ?>

	</div>

</article>

