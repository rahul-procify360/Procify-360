<?php
/**
 * Contact Forms default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', ' widget_aheto--funero-classic-form' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-navbar-layout2', $shortcode_dir . 'assets/css/funero_layout2.css', null, null);
}

?>
<?php
$background_image = '';
if ( $funero_image_bg ):
	$background_image = Helper::get_background_attachment($funero_image_bg, 'full', $atts);
endif;

$funero_search_button = isset($funero_search_button) && !empty($funero_search_button) && $funero_search_button !== 'default' ? 'aheto-btn ' . $funero_search_button : '';

?>
<div <?php $this->render_attribute_string( 'wrapper' ); echo ' '.esc_attr($background_image);?>>

	<?php if(!empty($funero_label)): ?>
        <h6 class="widget_aheto__label"><?php echo esc_html($funero_label);?></h6>
	<?php endif;?>
    <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
        <label>
            <input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Start typing name...', 'funero') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr__( 'Search for:' , 'funero') ?>" />
            <input type="hidden" name="post_type" value="page" />
        </label>
        <input type="submit" class="search-submit <?php echo esc_attr($funero_search_button); ?>" value="<?php echo esc_attr__( 'Search', 'funero' ) ?>" />
    </form>
</div>
