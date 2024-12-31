<?php

/**
 * The Team Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     KUNST <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$kunst_teams = $this->parse_group($kunst_teams);

if ( empty($kunst_teams) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-team--kunst__simple');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/team/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-team-layout1', $shortcode_dir . 'assets/css/kunst_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php foreach ( $kunst_teams as $index => $item ) : ?>

        <div class="aheto-team--person" <?php $this->render_attribute_string('item'); ?>>

            <?php if ( $item['kunst_member_image'] ) { ?>
                <div class="aheto-team--img-holder">
                    <div class="aheto-team--box">
                        <div class="aheto-team--img">
                            <?php echo \Aheto\Helper::get_attachment( $item['kunst_member_image'], [], $image_size, $atts ); ?>
                        </div>
                        <?php if ( !empty( $item['kunst_member_social'] ) ) { ?>
                            <div class="aheto-team--contact">
                                <div class="aheto-team--contact-box">
                                    <?php
                                        echo Helper::get_social_networks_list('<a class="aheto-member__link" href="%1$s" target="_blank"><i class="ion-social-%2$s"></i></a>', 'kunst', $item);
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="aheto-team--img-shape"></div>
                </div>
            <?php } ?>

            <div class="aheto-team--text">
                <?php
                    // Name.
                    if ( !empty( $item['kunst_member_name'] ) ) {
                        echo '<h3 class="aheto-team--name">' . wp_kses($item['kunst_member_name'], 'post') . '</h3>';
                    }

                    // Designation.
                    if ( !empty( $item['kunst_member_designation'] ) ) {
                        echo '<p class="aheto-team--position">' . esc_html($item['kunst_member_designation']) . '</p>';
                    }
                ?>
            </div>

        </div>

    <?php endforeach; ?>

</div>
