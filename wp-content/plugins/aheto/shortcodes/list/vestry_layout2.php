<?php

/**
 * The List Links Shortcode.
 *
 */

use Aheto\Helper;

extract($atts);

$lists = $this->parse_group($vestry_lists);
if (empty($lists)) {
    return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-list--vestry-bullets');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('vestry-list-layout2', $shortcode_dir . 'assets/css/vestry_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <ul>
        <?php
        foreach ($lists as $item) { ?>
            <li>
                <a class="vestry-list-links" href="<?php echo esc_url($item['vestry_link_url']['url']); ?>">
                    <?php echo esc_html($item['vestry_link_text']); ?>
                </a>
            </li>
        <?php }
        ?>
    </ul>
</div>
