<?php
use Aheto\Helper;

/**
 * Skin 4.
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
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';
$classes[] = 'aheto-cpt-article--ninedok';
$terms_list = get_the_terms ( get_the_ID (), $atts['terms'] );
if (isset( $terms_list ) && !empty( $terms_list )) {
	foreach ($terms_list as $term) {
		$classes[] = 'filter-' . $term -> slug;
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-skin-4', $shortcode_dir . 'assets/css/ninedok_skin-4.css', null, null);
}

$format = $this -> get_post_format ();

?>

<article class="<?php echo esc_attr ( implode ( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

		<?php

		switch ($format) {
			case 'quote':
				$this -> getTerms ( $atts['terms'], '-hover-light' );
				$content = get_post_meta ( get_the_ID (), 'aheto_post_blockquote', true );
				$author = get_post_meta ( get_the_ID (), 'aheto_post_blockquote_author', true );
				$classes = [];
				$classes[] = 'aheto-cpt-article__quote aheto-quote aheto-quote--icon-right';


				?>
                <blockquote class="<?php echo esc_attr ( implode ( ' ', $classes ) ); ?>">
                    <h4><?php echo wp_kses ( $content, 'post' ); ?></h4>
					<?php if ( !empty( $author )) { ?>
                        <cite><?php echo esc_html ( $author ); ?></cite>
					<?php } ?>
                </blockquote>
				<?php

				break;

			case 'slider':
				$this -> getSlider ( '', true, false, $atts['cpt_image_size'], $atts, 'cpt_' );
				$this -> getTerms ( $atts['terms'] ); ?>

                <div class="ahetmscpt-article__content">
					<?php $this -> getDate (); ?>
					<?php $this -> getTitle (); ?>
					<?php $this -> getExcerpt (); ?>
					<?php $this -> getLink ( 'aheto-link aheto-btn--primary' ); ?>
                </div>
				<?php
				break;

			case 'gallery':
				$this -> getGallery ( '', $atts['cpt_image_size'], $atts, 'cpt_' ); ?>

                <div class="aheto-cpt-article__content">
					<?php

					$this -> getTerms ( $atts['terms'], 'aheto-cpt-article__terms--static' );
					$this -> getDate ();
					$this -> getTitle ();
					$this -> getExcerpt ();
					$this -> getLink ( 'aheto-link aheto-btn--primary' );
					?>
                </div>
				<?php

				break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size' => 'aheto-btn-video--small',
				];

				$this -> getVideo ( 'aheto-cpt-article__img', $video_btn_params, $img_class, $atts['cpt_image_size'], $atts, 'cpt_' );
				$this -> getTerms ( $atts['terms'] ); ?>

                <div class="aheto-cpt-article__content">
					<?php $this -> getDate (); ?>
					<?php $this -> getTitle (); ?>
					<?php $this -> getExcerpt (); ?>
					<?php $this -> getLink ( 'aheto-link aheto-btn--primary' ); ?>
                </div>
				<?php

				break;

			case 'audio': ?>

                <div class="aheto-cpt-article__content">
					<?php

					$this -> getTerms ( $atts['terms'], 'aheto-cpt-article__terms--static' );
					$this -> getAudio ();
					$this -> getDate ();
					$this -> getTitle ();
					$this -> getExcerpt ();
					$this -> getLink ( 'aheto-link aheto-btn--primary' );

					?>
                </div>
				<?php
				break;

			case 'image':
			default:

				$isHasThumb = null;
				if (has_post_thumbnail ( $ID )) {
					$isHasThumb = $this -> getImage ( $img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_' );
				}

				?>

                <div class="aheto-cpt-article__content">
					<?php

					$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';

					$this -> getTerms ( $atts['terms'], $terms_class );
					$this -> getDate ();
					$this -> getTitle ();
					$this -> getExcerpt ();
					$this -> getLink ( 'aheto-link aheto-btn--primary' ); ?>
                </div>

				<?php break;

		} ?>

    </div>

</article>

