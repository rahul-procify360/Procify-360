<?php

/**
 * Kunst Skin 1
 * Created by PhpStorm.
 * User: yurii_oliiarnyk
 * Date: 20.08.19
 * Time: 15:21
 */

use Aheto\Helper;

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], true);

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {

	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term->slug;
	}

}

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( empty( $custom_css ) || ( $custom_css == "disabled" ) ) {
    wp_enqueue_style( 'kunst-custom-post-types-skin-1', $shortcode_dir . 'assets/css/kunst_skin-1.css', null, null );
}

wp_enqueue_script( 'kunst-custom-post-types-skin-1-js', $shortcode_dir . 'assets/js/kunst_skin-1.js', array( 'jquery' ), null );

?>

<article class="<?php echo esc_attr(implode(' ', $classes)) ?>">
	<div class="hide" style="display: none">
		<div class="aheto-cpt-article__content">
			<?php
				$term = $this->getTerms($atts['terms']);
				$title = $this->getTitle();
			?>
		</div>
	</div>

	<div class="aheto-cpt-article__inner">
		<?php $this->getImage($img_class, '', $atts['cpt_image_size'], false, true, $atts, 'cpt_'); ?>
	</div>
</article>
