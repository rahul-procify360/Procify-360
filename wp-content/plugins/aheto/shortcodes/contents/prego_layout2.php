<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$prego_items = $this->parse_group($prego_items_cards);
if (empty($prego_items)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents__prego-cards' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('prego-contents-layout2', $shortcode_dir . 'assets/css/prego_layout2.css', null, '');
}
if (!Helper::is_Elementor_Live()) {
    wp_enqueue_script('prego-contents-layout2-js', $shortcode_dir . 'assets/js/prego_layout2.min.js', array('jquery'), '', true);
}
$carousel_params = Helper::get_carousel_params($atts, 'prego_tm_swiper_');
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <div class="swiper">
        <div class="swiper-container" <?php echo esc_attr($carousel_params); ?> data-pagination-type="progressbar" data-slides="auto" data-spaces="15">
            <div class="swiper-wrapper">
                <?php foreach ($prego_items as $item) : ?>
                    <div class="swiper-slide">
                        <div class="aheto-contents__content">
                            <?php if ($item['prego_item_image']) : ?>
                                <?php echo Helper::get_attachment($item['prego_item_image'], [], 'full'); ?>
                            <?php endif;

                            if(!empty($item['prego_item_title'])){ ?>
                                <h4><?php echo esc_html($item['prego_item_title']) ?></h4>
                            <?php }

                            if(!empty($item['prego_item_text'])){ ?>
                                <div class="aheto-contents__text"><?php echo esc_html($item['prego_item_text']) ?></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
