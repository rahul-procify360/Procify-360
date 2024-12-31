<?php

use Aheto\Helper;

extract( $atts );

$atts['layout'] = 'slider';

// Query.
$the_query = $this->get_wp_query();

if ( ! $the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--kunst__modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set carousel params
 */
$carousel_default_params = [
	'speed'     => 500,
	'slides'    => 3,
	'slides_md' => 2,
	'slides_xs' => 1,
	'space'     => 30
]; // will use when not chosen option 'Change slider params'

$carousel_params = Helper::get_carousel_params( $atts, 'kunst_swiper_', $carousel_default_params );

$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';
$tag           = isset($title_tag) && ! empty( $title_tag) ? $title_tag : 'h4';
$counter = 1;

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-custom-post-types-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script( 'kunst-custom-post-types-layout1-js', $shortcode_dir . 'assets/js/kunst_layout1.js', array( 'jquery' ), null );
}
$reverseClass = $kunst_reverse_cpt != '' ? "aheto-cpt--reverse" : '';

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<div class="aheto-cpt--container">
		<div class="swiper <?php echo esc_attr($reverseClass); ?> ">

			<div class="swiper-container" <?php echo esc_attr( $carousel_params ); ?>>

				<div class="swiper-wrapper">
					<?php
	                    $this->add_excerpt_filter();

	                    while ( $the_query->have_posts() ) :
	                        $the_query->the_post();
	                ?>
						<div class="swiper-slide">
	                        <div class="aheto-cpt--image">
	                            <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>
	                        </div>
	                        <div class="aheto-cpt--main">
	                            <div class="aheto-cpt--info">
	                                <div class="aheto-cpt--info-cnt">
		                                <div class="aheto-cpt--line"></div>

		                                <<?php echo esc_attr($tag); ?> class="aheto-cpt-article__title">
		                                    #<?php echo esc_html($counter); ?> - <?php the_title(); ?>
		                                </<?php echo esc_attr($tag); ?>>
		                                <?php $this->getExcerpt();?>
		                                <a class="aheto-link aheto-btn--dark" href="<?php echo esc_url(get_permalink());?>"><?php esc_html_e('View Project', 'kunst'); ?></a>
	                                </div>
	                            </div>
	                        </div>
						</div>
					<?php
	                    $counter++;

	                    endwhile;

	                    $this->remove_excerpt_filter();

	                    wp_reset_query();
					?>
	            </div>
			</div>
		    <?php if ( !empty( $this->atts[ 'kunst_swiper_pagination' ] ) ) { ?>
                <?php $this->swiper_pagination('kunst_swiper_'); ?>
            <?php } ?>
	    </div>
	</div>
</div>
