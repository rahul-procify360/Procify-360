<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract($atts);

$lists = $this->parse_group($lists);
if ( empty($lists) ) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--hr-numbers');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-list-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
}?>
<div <?php $this->render_attribute_string('wrapper'); ?>>
    <ol>
        <?php
        foreach ( $lists as $index=>$item ) {
        	if(!empty($item['list'])):?>
            <li>
                <b><?php echo wp_kses_post($index + 1)  ?></b>
                <p><?php echo wp_kses_post($item['list'])  ?></p>
            </li>
        <?php endif;
        } ?>
    </ol>

</div>
