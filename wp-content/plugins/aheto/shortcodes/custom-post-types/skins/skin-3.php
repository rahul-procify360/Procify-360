<?php
/**
 * Created by PhpStorm.
 * User: yurii_oliiarnyk
 * Date: 20.08.19
 * Time: 15:21
 */

use Aheto\Helper;

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--skin-3';
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$has_bg = strpos( $img_class, 'js-bg' ) !== false ? true : false;
$bg_class = $has_bg ? 's-back-switch' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if ( !empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('magnific');
	wp_enqueue_style('magnific');
	wp_enqueue_style('cpt-3', $sc_dir . 'assets/css/skin-3.css', null, null);
}
?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">

	<div class="aheto-cpt-article__inner">

		<?php if ( has_post_thumbnail() ) {
			$aheto_external_link  = get_post_meta( get_the_ID(), 'aheto_external_link', true );
			$post_link = isset($aheto_external_link) && !empty($aheto_external_link) ? $aheto_external_link : get_permalink();
			$target = isset($aheto_external_link) && !empty($aheto_external_link) ? '_blank' : '_self';

			$post_image_id = get_post_thumbnail_id();
			$image = array();
			$image['id'] = $post_image_id;

			$background_image = $has_bg ? Helper::get_background_attachment($image, $atts['cpt_image_size'], $atts, 'cpt_') : ''; ?>

			<div class="aheto-cpt-article__img <?php echo esc_attr( $bg_class ); ?>" <?php echo esc_attr( $background_image ); ?>>

				<?php if(!$has_bg){
	                echo Helper::get_attachment($image, ['class' => $img_class], $atts['cpt_image_size'], $atts, 'cpt_');
                }

				$attach = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
				<a class="aheto-cpt-article__link" href="<?php echo esc_url($post_link); ?>" target="<?php echo esc_attr($target); ?>"></a>
				<a class="aheto-cpt-article__popup js-popup-gallery-link" data-title="<?php the_title(); ?>"
				   href="<?php echo esc_url($attach[0]); ?>">
					<i class="icon ion-ios-search-strong" aria-hidden="true"></i>
				</a>
			</div>

		<?php } ?>

		<div class="aheto-cpt-article__content">

			<?php
			$this->getTitle();
			$this->getTerms($atts['terms'], '', ', ');
			?>

		</div>

	</div>

</article>
