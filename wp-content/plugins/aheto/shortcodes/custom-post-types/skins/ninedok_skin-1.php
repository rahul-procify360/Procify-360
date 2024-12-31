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

$ID = get_the_ID ();

$classes = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this -> getAdditionalItemClasses ( $atts['layout'], false );
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = 'aheto-cpt-article--ninedok';
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms ( get_the_ID (), $atts['terms'] );
if ( !empty( $terms_list )) {
	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term -> slug;
	}
}


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-skin-1', $shortcode_dir . 'assets/css/ninedok_skin-1.css', null, null);
}
$format = $this -> get_post_format ();

?>

<article class="<?php echo esc_attr ( implode ( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

		<?php
		$isHasThumb = !$atts['ninedok_img_off'] ? $this -> getImage ( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ) : '';


		$isHasThumb2 = !$atts['ninedok_date_off'] ? true : false;
		?>


        <div class="aheto-cpt-article__content">
			<?php
			$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
			?>

			<?php if ($isHasThumb2) { ?>
                <h6 class="aheto-cpt-article__date">
                    <i class="ion-clock"></i>
					<?php the_time ( get_option ( 'date_format' ) ); ?>
                </h6>
			<?php } ?>

			<?php
			$this -> getTitle ();
			$this -> getExcerpt ();
			?>

            <div class="aheto-cpt-article__author">

				<?php
				$author_id = get_the_author_meta ( 'ID' );

				echo get_avatar ( $author_id, 30 );
				echo esc_html__ ( 'by ', 'ninedok' ) . esc_html ( get_the_author () ); ?>
            </div>

        </div>

    </div>

</article>

