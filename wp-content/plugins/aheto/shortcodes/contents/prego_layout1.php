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

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents__prego' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('prego-contents-layout1', $shortcode_dir . 'assets/css/prego_layout1.css', null, '');
}
if (!Helper::is_Elementor_Live()) {
    wp_enqueue_script('prego-contents-layout1-js', $shortcode_dir . 'assets/js/prego_layout1.min.js', array('jquery'), '1.0.2', true);
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php if(isset($prego_image['id']) && !empty($prego_image['id'])){ ?>
        <div class="aheto-contents__image">
            <div class="aheto-contents__image-inner">
                <?php echo Helper::get_attachment($prego_image, [], $prego_image_size, $atts, 'prego_');

                if(is_array($prego_items) && count($prego_items)){
                    foreach ($prego_items as $item){ ?>
                        <div class="aheto-contents__point elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" data-id="<?php echo esc_attr( $item['_id'] ); ?>">
                            <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M11.5 23C17.8513 23 23 17.8513 23 11.5C23 5.14873 17.8513 0 11.5 0C5.14873 0 0 5.14873 0 11.5C0 17.8513 5.14873 23 11.5 23Z" fill="var(--c-active)"/>
                                <path d="M11.5007 16.2916C14.147 16.2916 16.2923 14.1463 16.2923 11.4999C16.2923 8.85356 14.147 6.70825 11.5007 6.70825C8.85429 6.70825 6.70898 8.85356 6.70898 11.4999C6.70898 14.1463 8.85429 16.2916 11.5007 16.2916Z" fill="var(--c-active)"/>
                                <path d="M11.5007 17.2916C14.6993 17.2916 17.2923 14.6986 17.2923 11.4999C17.2923 8.30127 14.6993 5.70825 11.5007 5.70825C8.302 5.70825 5.70898 8.30127 5.70898 11.4999C5.70898 14.6986 8.302 17.2916 11.5007 17.2916Z" stroke="var(--c-light)" stroke-width="1"/>
                            </svg>

                            <div class="aheto-contents__point-content">
                                <?php if(!empty($item['prego_item_title'])){ ?>
                                    <span><?php echo esc_html($item['prego_item_title']); ?></span>
                                <?php } ?>
                                <?php if(!empty($item['prego_item_text'])){ ?>
                                    <span><?php echo esc_html($item['prego_item_text']); ?></span>
                                <?php } ?>
                            </div>

                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    <?php } ?>

    <div class="aheto-contents__content">
        <?php if(!empty($prego_subheading)){ ?>
            <h6><?php echo esc_html($prego_subheading); ?></h6>
        <?php }
        if(!empty($prego_heading)){ ?>
            <h2><?php echo esc_html($prego_heading); ?></h2>
        <?php }
        if(is_array($prego_items) && count($prego_items)){
            foreach ($prego_items as $item){ ?>
                <div class="aheto-contents__item" data-id="<?php echo esc_attr( $item['_id'] ); ?>">
                    <?php if(!empty($item['prego_item_title'])){ ?>
                        <span><?php echo esc_html($item['prego_item_title']); ?></span>
                    <?php } ?>
                    <?php if(!empty($item['prego_item_text'])){ ?>
                        <span><?php echo esc_html($item['prego_item_text']); ?></span>
                    <?php } ?>
                </div>
            <?php }
        }?>
    </div>



</div>
