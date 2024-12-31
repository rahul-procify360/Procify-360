<?php

use Aheto\Helper;

$ID = get_the_ID();


$classes   = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms( get_the_ID(), $atts['terms'] );

if ( isset( $terms_list ) && ! empty( $terms_list ) ) {
	foreach ( $terms_list as $term ) {
		$classes[] = 'filter-' . $term->slug;
	}
}

$tag = isset( $atts['title_tag'] ) && ! empty( $atts['title_tag'] ) ? $atts['title_tag'] : 'h4';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('moovit-skin-5', $shortcode_dir . 'assets/css/moovit_skin-5.css', null, null);
} ?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

    <div class="aheto-cpt-article__inner">

		<?php $isHasThumb = $this->getImage( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>

        <div class="aheto-cpt-article__content">
			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
            <a href="<?php the_permalink(); ?>"><?php

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

			<?php $this->getTerms( $atts['terms'], '', ', ' ); ?>
        </div>
    </div>

</article>


