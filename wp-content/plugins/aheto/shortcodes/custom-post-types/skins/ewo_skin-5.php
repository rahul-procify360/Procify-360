<?php

use Aheto\Helper;

/**
 * Ewo Skin 5
 */

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$format = $this->get_post_format();
$format = isset($format) && !empty($format) ? $format : 'image';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-skin-5', $shortcode_dir . 'assets/css/ewo_skin-5.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner">

		<div class="aheto-cpt-article__content-top">
			<?php $this->getTerms($atts['terms']); ?>
			<?php $this->getTitle(); ?>
		</div>

		<?php

		switch ($format) {
			case 'quote':
				$this->getQuote('aheto-quote aheto-quote--icon-right');

				break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size'  => 'aheto-btn-video--large',
				];

				$this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_');
				break;

			case 'slider':
				$this->getSlider('', true, false, $atts['image_size']);
				break;

			case 'gallery':
				$this->getGallery('', $atts['image_size']);
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
			?>

		</div>

		<div class="aheto-cpt-article__footer">
			<div class="aheto-cpt-article__author aheto-cpt-article__footer-item">
				<?php echo get_avatar(get_the_author_meta('ID'), 35); ?>
				<span><?php the_author(); ?></span>
			</div>

			<div class="aheto-cpt-article__likes aheto-cpt-article__footer-item">
				<i class="icon ion-calendar"></i>
				<?php $this->getDate(); ?>
			</div>

			<?php if (!post_password_required() && (comments_open() || get_comments_number())) : ?>
				<div class="aheto-cpt-article__comments aheto-cpt-article__footer-item">
					<i class="icon ion-chatbubble-working"></i>
					<span><?php comments_popup_link(__('0 Comments', 'ewo'), __('1 Comment', 'ewo'), __('% Comment', 'ewo')); ?></span>
				</div>
			<?php endif; ?>

			<?php $likes = get_post_meta(get_the_ID(), 'aheto_post_likes', true); ?>
			<div class="aheto-cpt-article__likes aheto-cpt-article__footer-item">
				<i class="icon ion-heart"></i>
				<span><?php echo wp_kses_post($likes) ? $likes : 0; ?> <?php esc_html_e('Likes', 'ewo'); ?></span>
			</div>
		</div>

	</div>

</article>
