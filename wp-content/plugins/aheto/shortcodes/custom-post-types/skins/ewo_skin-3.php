<?php

use Aheto\Helper;

/**
 * Ewo Skin 3.
 */

$ID = get_the_ID();

$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses( $atts['layout'], false );
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$ewo_link = isset( $atts['ewo_link'] ) && ! empty( $atts['ewo_link'] ) ? $atts['ewo_link'] : esc_html__( 'READ FULL POST', 'ewo' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ewo-skin-3', $shortcode_dir . 'assets/css/ewo_skin-3.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

		<?php

		switch ( $format ) {
			case 'quote':
				$this->getTerms( $atts['terms'], '-hover-light' );
				$this->getQuote( 'aheto-quote aheto-quote--icon-right' );

				break;

			case 'slider':
				$this->getSlider( '', true, false, $atts['image_size'] );
				$this->getTerms( $atts['terms'] ); ?>

                <div class="aheto-cpt-article__content">
					<?php $this->getDate(); ?>
					<?php $this->getTitle(); ?>
					<?php $this->getExcerpt(); ?>
					<?php $this->getLink( 'aheto-link aheto-btn--primary' ); ?>
                </div>
				<?php
				break;

			case 'gallery':
				$this->getGallery( '', $atts['image_size'] ); ?>

                <div class="aheto-cpt-article__content">
					<?php

					$this->getTerms( $atts['terms'], 'aheto-cpt-article__terms--static' );
					$this->getDate();
					$this->getTitle();
					$this->getExcerpt();
					$this->getLink( 'aheto-link aheto-btn--primary' );
					?>
                </div>
				<?php

				break;

			case 'video':
				$video_btn_params = [
					'video_style' => 'aheto-btn--light',
					'video_size'  => 'aheto-btn-video--small',
				];

				$this->getVideo( 'aheto-cpt-article__img', $video_btn_params, $img_class, $atts['image_size'] );
				$this->getTerms( $atts['terms'] ); ?>

                <div class="aheto-cpt-article__content">
					<?php $this->getDate(); ?>
					<?php $this->getTitle(); ?>
					<?php $this->getExcerpt(); ?>
					<?php $this->getLink( 'aheto-link aheto-btn--primary' ); ?>

                </div>
				<?php

				break;

			case 'audio': ?>

                <div class="aheto-cpt-article__content">
					<?php

					$this->getTerms( $atts['terms'], 'aheto-cpt-article__terms--static' );
					$this->getAudio();
					$this->getDate();
					$this->getTitle();
					$this->getExcerpt();
					?>

                    <div class="aheto-cpt-article__link">
                        <a class="aheto-link aheto-btn--light aheto-btn--no-underline" href="<?php the_permalink(); ?>">
							<?php echo esc_html($ewo_link); ?>
                            <i class="ion-ios-arrow-forward"></i>
                        </a>
                    </div>
                </div>
				<?php
				break;

			case 'image':
			default:
				$isHasThumb = $this->getImage( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>

                <div class="aheto-cpt-article__content">
					<?php $terms_class = ! $isHasThumb ? 'aheto-cpt-article__terms--static' : ''; ?>
					<?php $this->getTerms( $atts['terms'], $terms_class ); ?>
					<?php $this->getDate(); ?>
					<?php $this->getTitle(); ?>
					<?php $this->getExcerpt(); ?>
                    <div class="aheto-cpt-article__link">
                        <a class="aheto-link aheto-btn--light aheto-btn--no-underline" href="<?php the_permalink(); ?>">
	                        <?php echo esc_html($ewo_link); ?>
                            <i class="ion-ios-arrow-forward"></i>
                        </a>
                    </div>
                </div>

				<?php break;
		} ?>

    </div>

</article>
