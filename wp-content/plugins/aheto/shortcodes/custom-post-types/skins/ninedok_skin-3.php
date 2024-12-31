<?php

use Aheto\Helper;

$ID = get_the_ID ();

extract ( $atts );

$classes = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $atts['layout'] === 'grid' ? 'aheto-cpt-article--static' : '';
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$classes[] = 'aheto-cpt-article--ninedok';
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';
$icon = $this -> get_icon_attributes ( 'ninedok_', true, true );
if ( !empty( $icon )) {
	$this -> add_render_attribute ( 'ninedok_icon', 'class', 'aheto-cpt-article__ico icon' );
	$this -> add_render_attribute ( 'ninedok_icon', 'class', $icon['icon'] );
	if ( !empty( $icon['color'] )) {
		$this -> add_render_attribute ( 'ninedok_icon', 'style', 'color:' . $icon['color'] );
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('ninedok-skin-2', $shortcode_dir . 'assets/css/ninedok_skin-2.css', null, null);
} ?>


<article class="aheto-cpt-article__post <?php echo esc_attr ( implode ( ' ', $classes ) ); ?>">
    <div class="aheto-cpt-article__inner">
		<?php $this -> getImage ( $img_class, '', $atts['cpt_image_size'], true, false, $atts, 'cpt_' ); ?>
        <div class="aheto-cpt-article__content">

            <h4 class="aheto-cpt-article__title">
                <a href="<?php the_permalink (); ?>">
					<?php the_title (); ?>
					<?php
					$tags = get_the_tags ();
					if ( !empty( $tags )) {
						echo '-';
						foreach ($tags as $tag) {
							$tag_link = get_tag_link ( $tag -> term_id ); ?>
                            <a href='<?php echo esc_url ( $tag_link ) ?>'
                               title='<?php echo esc_attr ( $tag -> name ) ?> Tag'
                               class='tag <?php echo esc_attr ( $tag -> slug ) ?>'>
								<?php echo wp_kses ( $tag -> name, 'post' ) ?>
                            </a>
						<?php }

					}
					?>
                </a>
            </h4>
			<?php
			$this -> getTerms ( $atts['terms'] );
			?>

            <div class="aheto-cpt-article__excerpt">
				<?php the_excerpt (); ?>
            </div>


            <div class="aheto-cpt-article__link">
                <a class="aheto-link aheto-btn--main aheto-btn--no-underline" href="<?php the_permalink (); ?>">
					<?php esc_html_e ( "View Case Study", 'ninedok' );

					if (isset( $icon ) && !empty( $icon )) {
						echo '<i ' . $this -> get_render_attribute_string ( 'ninedok_icon' ) . '></i>';
					}
					?>
                </a>
            </div>

        </div>
    </div>


</article>
