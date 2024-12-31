<?php
use Aheto\Helper;

/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
foreach ( $terms_list as $term ) {
	$classes[] = 'filter-' . $term->slug;
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-skin-7', $shortcode_dir . 'assets/css/famulus_skin-7.css', null, null);
	wp_enqueue_script('famulus-skin-7-js', $shortcode_dir . 'assets/js/famulus_skin-7.min.js', array('jquery'), null);
}

$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner">

		<!-- TOP -->
		<div class="aheto-cpt-article__content-top">
			<?php $this->getTerms($atts['terms']); ?>
			<h2 class="aheto-cpt-article__title ">
				<a href="<?php echo esc_url(get_permalink()); ?>" class="js-postTitle"
				   title="<?php echo esc_attr(get_the_title()); ?>">
					<?php echo wp_kses_post(get_the_title()); ?>
				</a>
			</h2>
			<time datetime="<?php the_time('Y-m-d'); ?>"
				  class="aheto-cpt-article__date">
				<?php the_time('d M Y'); ?>
			</time>
		</div>


		<?php

		switch ( $format ) {
			case 'quote':
				$content = get_post_meta(get_the_ID(), 'aheto_post_blockquote', true);
				$author = get_post_meta(get_the_ID(), 'aheto_post_blockquote_author', true);
				?>
				<blockquote class="aheto-cpt-article__quote aheto-quote aheto-quote--icon-right">
					<h4><?php echo wp_kses_post($content); ?></h4>
					<?php if ( !empty($author) ) { ?>
						<cite><?php echo esc_html($author); ?></cite>
					<?php } ?>
				</blockquote>
				<?php break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size'  => 'aheto-btn-video--large',
				];

				$this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, $atts['image_size']);
				break;

			case 'slider':
				$this->getSlider('', true, false, $atts['cpt_image_size']);
				break;

			case 'gallery':
				$this->getGallery('', $atts['cpt_image_size']);
				break;

			case 'audio':
				$this->getAudio('is-audio-large');
				break;

			case 'image':
			default:
				$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, false);

		} ?>

		<div class="aheto-cpt-article__content">
			<?php
			$this->getExcerpt();
			$this->getLink('aheto-link aheto-btn--primary');
			?>

		</div>

		<?php $this->get_template_part('footer'); ?>

	</div>

</article>

