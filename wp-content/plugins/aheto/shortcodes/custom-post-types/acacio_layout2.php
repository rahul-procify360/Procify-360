<?php

use Aheto\Helper;

extract( $atts );

$atts['layout'] = '';

wp_enqueue_script('isotope');

// Query.
$the_query = $this->get_wp_query();
if ( ! $the_query->have_posts() ) {
	return;
}

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-cpt--acacio-metro' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );



/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-custom-post-types-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('acacio-custom-post-types-layout2-js', $shortcode_dir . 'assets/js/acacio_layout2.js', array('jquery'), null);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-cpt--acacio-metro-sizer"></div>
    <?php
    $this->add_excerpt_filter();

    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        ?>
        <?php $this->get_skin_part($skin, $atts); ?>
    <?php
    endwhile;

    $this->remove_excerpt_filter();

    wp_reset_postdata();
    ?>

</div>
