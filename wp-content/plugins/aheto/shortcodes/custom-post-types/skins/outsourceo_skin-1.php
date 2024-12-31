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
$classes[] = $this->getAdditionalItemClasses( $atts['layout'], false );
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );
if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
    foreach ( $terms_list as $term ) {
        $classes[] = 'filter-' . $term->slug;
    }
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('outsourceo-skin-1', $shortcode_dir . 'assets/css/outsourceo_skin-1.css', null, null);
}
$format = $this->get_post_format();
$tag    = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4'; ?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

		<?php if ( ! $atts['outsourceo_img_off'] ) {
			$isHasThumb = $this->getImage( $img_class, '', $atts['cpt_image_size'], true );
		} ?>

        <div class="aheto-cpt-article__content">

            <div class="aheto-cpt-article__date">
                <i class="ion-clock"></i>
				<?php the_time( get_option( 'date_format' ) );
				esc_html_e( ' in World', 'outsourceo' ); ?>
            </div>
			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
            <a href="<?php the_permalink(); ?>">
				<?php

				$title = get_the_title();

				if ( $atts['outsourceo_use_dot'] ) {

					$title = str_replace( '{{.}}', '<span class="outsourceo-dot dot-primary"></span>', $title );

					$words = explode( " ", $title );

					if ( count( $words ) > 0 ) {
						$last_word = $words[ count( $words ) - 1 ];

						$last_space_position = strrpos( $title, ' ' );
						$start_string        = substr( $title, 0, $last_space_position );

						$title = wp_kses( $start_string, 'post' ) . ' <span class="outsourceo-dot dot-primary">' . wp_kses( $last_word, 'post' ) . '</span>';
					} else {
						$title = '<span class="outsourceo-dot dot-primary">' . wp_kses( $title, 'post' ) . '</span>';
					}

				} else {
					$title = wp_kses( $title, 'post' );
				}

				echo $title; ?>
            </a>
			<?php echo '</' . $tag . '>';

			$this->getExcerpt(); ?>

            <div class="aheto-cpt-article__author">

				<?php
				$author_id = get_the_author_meta( 'ID' );

				echo get_avatar( $author_id, 30 ); ?>
                <strong><?php echo esc_html__( 'by ', 'outsourceo' ) . esc_html( get_the_author() ); ?></strong>
            </div>

        </div>

    </div>

</article>

