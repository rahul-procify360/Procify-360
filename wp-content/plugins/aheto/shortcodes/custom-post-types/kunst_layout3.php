<?php

use Aheto\Helper;

extract( $atts );
$atts['layout'] = 'mosaics';

// Query.
$the_query = $this->get_wp_query();

if ( !$the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--kunst__mosaics' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$tag     = isset($title_tag) && ! empty( $title_tag) ? $title_tag : 'h4';

$img_class = 'js-bg';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-custom-post-types-layout3', $shortcode_dir . 'assets/css/kunst_layout3.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php
        $this->add_excerpt_filter();

        while ( $the_query->have_posts() ) :
            $the_query->the_post();
    ?>

        <div class="aheto-cpt--image">

            <?php $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_'); ?>

            <div class="aheto-cpt--main">
                <div class="aheto-cpt--info">
                    <div class="aheto-cpt--line"></div>
                    <div class="aheto-cpt--content">
                        <span class="aheto-cpt--content-subtitle"><?php $this->getTerms($atts['terms']); ?></span>
                        <span class="aheto-cpt--content-author-date"><?php echo esc_html(get_the_date('jS F Y')) .' '. esc_html(' | ' ) . ' ' . esc_html( 'by ' . get_the_author() );?></span>
                    </div>
                    <a href="<?php the_permalink(); ?>">
                        <<?php echo esc_attr($tag); ?> class="aheto-cpt-article__title">
                            <?php the_title(); ?>
                        </<?php echo esc_attr($tag); ?>>
                    </a>
                </div>
            </div>
        </div>

    <?php
        endwhile;

        $this->remove_excerpt_filter();

        wp_reset_query();
    ?>

</div>
