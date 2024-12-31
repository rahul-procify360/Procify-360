<?php
/**
 * About default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

// Query.
$the_query = $this->get_wp_query();
if ( ! $the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--outsourceo-metro' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-custom-post-types-layout1', $shortcode_dir . 'assets/css/outsourceo_layout1.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php
	$this->add_excerpt_filter();

	$counter = 1;

	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		if ( $counter === 1 ) {
			$count_class = 'first';
		} else {
			$count_class = 'others';
		}

		$background_image = has_post_thumbnail() ? Helper::get_background_attachment( get_post_thumbnail_id(), $cpt_image_size, $atts, 'cpt_' ) : ''; ?>

        <article class="aheto-cpt__post <?php echo esc_attr( $count_class ); ?>">

            <div class="aheto-cpt__figure s-back-switch" <?php echo esc_attr( $background_image ); ?>>

                <div class="aheto-cpt__inner">
                    <div class="aheto-cpt__info">
                        <div class="aheto-cpt__tax">
							<?php the_terms( get_the_ID(), 'category', '<div class="aheto-cpt__cats">', '', '</div>' ); ?>
                        </div>
						<?php if ( $counter === 1 ) { ?>
                            <div class="aheto-cpt__author">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 25 ); ?>
                                <div class="aheto-cpt__author-name">
                                    <span><?php esc_html_e( 'by', 'outsourceo' ); ?></span> <?php the_author(); ?></div>
                            </div>
                            <div class="aheto-cpt__date">
                                <p><?php the_time( get_option( 'date_format' ) ); ?></p>
                            </div>
						<?php } ?>
                    </div>
					<?php if ( $counter === 1 ) { ?>
                        <h4 class="aheto-cpt__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<?php } else { ?>
                        <h5 class="aheto-cpt__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<?php } ?>
                </div>

            </div>

        </article>

		<?php $counter ++;

	endwhile;

	$this->remove_excerpt_filter();

	wp_reset_postdata();
	?>

</div>
