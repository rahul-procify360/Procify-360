<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4';
$hide_author = (isset($atts['moovit_hide_author']) && $atts['moovit_hide_author'] == '') ? 'flex' : 'none';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('moovit-skin-3', $shortcode_dir . 'assets/css/moovit_skin-3.css', null, null);
} ?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

        <div class="aheto-cpt-article__content">
            <div class="aheto-cpt-article__date">
                <i class="ion-clock"></i>
				<?php the_time( get_option( 'date_format' ) ); ?>
            </div>
			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
            <a href="<?php the_permalink(); ?>">
				<?php

				$title = get_the_title();

				if ( $atts['moovit_dot'] ) {

					$title = str_replace( '{{.}}', '<span class="moovit-dot dot-' . esc_attr( $atts['moovit_dot_color'] ) . '"></span>', $title );

					$words = explode( " ", $title );

					if ( count( $words ) > 0 ) {
						$last_word = $words[ count( $words ) - 1 ];

						$last_space_position = strrpos( $title, ' ' );
						$start_string        = substr( $title, 0, $last_space_position );

						$title = wp_kses( $start_string, 'post' ) . ' <span class="moovit-dot dot-' . esc_attr( $atts['moovit_dot_color'] ) . '">' . wp_kses( $last_word, 'post' ) . '</span>';
					} else {
						$title = '<span class="moovit-dot dot-' . esc_attr( $atts['moovit_dot_color'] ) . '">' . wp_kses( $title, 'post' ) . '</span>';
					}

				} else {
					$title = wp_kses( $title, 'post' );
				}

				echo $title; ?>
            </a>
			<?php echo '</' . $tag . '>'; ?>

			<?php $this->getExcerpt(); ?>

            <div class="aheto-cpt-article__author"  style="display:<?php echo esc_attr($hide_author);?>">

				<?php
				$author_id = get_the_author_meta( 'ID' );
				$author_avatar_size = esc_html( $atts['moovit_avatar_size'] );

				echo get_avatar( $author_id, $author_avatar_size );
				echo esc_html__( 'by ', 'moovit' ) . esc_html( get_the_author() ); ?>
            </div>
			<?php if ( isset( $atts['moovit_link_text'] ) && ! empty( $atts['moovit_link_text'] ) ) {
			    $link_underline = isset($atts['moovit_link_underline']) && $atts['moovit_link_underline'] ? '' : 'aheto-btn--no-underline'; ?>
                <div class="aheto-cpt-article__link">

                    <a href="<?php the_permalink(); ?>" class="aheto-link aheto-btn--dark <?php echo esc_attr($link_underline); ?>">
						<?php echo esc_html( $atts['moovit_link_text'] ); ?>
                        <?php if(!(isset($atts['moovit_link_icon']) && $atts['moovit_link_icon'])){ ?>
                            <i class="ion-arrow-right-c aheto-btn__icon--right"></i>
                        <?php } ?>
                    </a>
                </div>
			<?php } ?>
        </div>
    </div>

</article>

