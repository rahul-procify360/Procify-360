<?php
use Aheto\Helper;

/**
 * Skin 2.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

$ID = get_the_ID();
extract( $atts );

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if(!empty($terms_list)){
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}
$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h5';

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('aira-skin-2', $sc_dir . 'assets/css/aira_skin-2.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<?php
		$isHasThumb = !$atts['aira_img_off'] ? $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_') : '';
		$isHasThumb2 = !$atts['aira_date_off'] ? true : false;
        $isHasThumb3 = !$atts['aira_author_off'] ? true : false;
		?>

		<div class="aheto-cpt-article__content">
			<?php
			$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
			?>

			<?php if ( $isHasThumb2 ) { ?>
				<div class="aheto-cpt-article__date">
					<i class="ion-clock"></i>
					<?php the_time(get_option('date_format')); ?>
				</div>
			<?php } ?>

            <?php
                $this->getTitle();
             ?>

            <?php
                $this->getExcerpt();
            ?>

            <?php if ($isHasThumb3) { ?>
                <div class="aheto-cpt-article__author">

                    <?php
                    $author_id = get_the_author_meta('ID');

                    echo get_avatar($author_id, 30);
                    echo esc_html__('by ', 'aira') . esc_html(get_the_author()); ?>
                </div>
            <?php } ?>
		</div>

	</div>

</article>

