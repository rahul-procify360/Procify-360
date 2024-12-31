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


$funero_terms = [];
$classes      = [];
$classes[]    = 'aheto-cpt-article';
$classes[]    = 'aheto-cpt-article--' . $atts['layout'];
$classes[]    = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[]    = 'aheto-cpt-article--' . $atts['skin'];
$img_class    = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( $terms_list ) {
	foreach ( $terms_list as $term ) {
		$classes[]      = 'filter-' . $term->slug;
		$funero_terms[] = $term->name;
	}
}
$format = $this->get_post_format();

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-skin-1', $shortcode_dir . 'assets/css/funero_skin-1.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<?php if ( $format == 'quote' ): ?>
		<div class="aheto-cpt-article__quote-wrap">
			<?php
			$this->getQuote('aheto-cpt-article__quote');
			?>
		</div>
	<?php endif; ?>
	<div class="aheto-cpt-article__inner">

		<?php
		if ( has_post_thumbnail($ID) ) {
			$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
		}
		?>

		<div class="aheto-cpt-article__content">
			<?php
			$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
			?>
			<?php if ( !empty($atts['funero_subtitle']) ): ?>
			<p class="aheto-cpt-article__subtitle"><?php echo esc_html($atts['funero_subtitle']); ?></p>
			<?php endif; ?>
			<?php
			$this->getTitle();
			$this->getExcerpt(); ?>
			<?php if ( !empty($atts['funero_link_text_skin']) ):
				$link = get_permalink(); ?>
				<div class="aheto-cpt-article__links">
					<a href="<?php echo esc_url($link); ?>"><?php echo esc_html($atts['funero_link_text_skin']); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>

