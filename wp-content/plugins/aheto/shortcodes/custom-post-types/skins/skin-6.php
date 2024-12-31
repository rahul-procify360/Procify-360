<?php
/**
 * Created by PhpStorm.
 * Date: 20.08.19
 * Time: 15:21
 */
use Aheto\Helper;
$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--skin-6';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$btn_style = isset($atts['btn_style']) && !empty( $atts['btn_style'] ) ? $atts['btn_style'] : 'aheto-btn--primary';

$icon = $this->get_icon_attributes( 'btn_icon_', true, true );

if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'btn_icon_' . 'icon', 'class', 'aheto-btn__icon--right' );
	$this->add_render_attribute( 'btn_icon_' . 'icon', 'class', $icon['icon'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'btn_icon_' . 'icon', 'style', 'color:' . $icon['color'] );
	}
	if ( ! empty( $icon['font_size'] ) ) {
		$this->add_render_attribute( 'btn_icon_' . 'icon', 'style', 'font-size:' . $icon['font_size'] );
	}
}

$icon_html = ! empty( $icon ) ? '<i ' . $this->get_render_attribute_string( 'btn_icon_' . 'icon' ) . '></i>' : '';


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('cpt-6', $sc_dir . 'assets/css/skin-6.css', null, null);
}

$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner">

		<!-- TOP -->
		<div class="aheto-cpt-article__content-top">
			<?php $this->getTerms($atts['terms']); ?>
			<?php $this->getTitle(); ?>
			<?php $this->getDate(); ?>
		</div>


		<?php

		switch ( $format ) {
			case 'quote':
				$this->getQuote('aheto-quote aheto-quote--icon-right');

				break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size'  => 'aheto-btn-video--large',
				];

				$this->getVideo('aheto-cpt-article__img', $video_btn_params, $img_class, $atts['cpt_image_size'], $atts, 'cpt_');
				break;

			case 'slider':
				$this->getSlider('', true, false, $atts['cpt_image_size'], $atts, 'cpt_');
				break;

			case 'gallery':
				$this->getGallery('', $atts['cpt_image_size'], $atts, 'cpt_');
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
			$this->getLink('aheto-link ' . $btn_style, '', $icon_html, 'right');
			?>
		</div>

		<?php $this->get_template_part('footer'); ?>

	</div>

</article>
