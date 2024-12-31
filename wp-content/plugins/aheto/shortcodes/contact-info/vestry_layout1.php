<?php

/**
 * Contact Info default templates.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__contact_info--vestry');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('title', 'class', 'widget_aheto__title');

/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('vestry-contact-info-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null);
}

?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php

    if (!empty($vestry_description)) : ?>
        <p class="widget_aheto__desc">
            <?php echo esc_html($vestry_description); ?>
        </p>
    <?php endif; ?>

    <div class="widget_aheto__infos">

        <?php if (!empty($vestry_address)) : ?>
            <div class="widget_aheto__info widget_aheto__info--address">
                <?php echo wp_kses($this->get_icon_for('address'), 'post'); ?>
                <p class="widget_aheto__info-item"><?php echo esc_html($vestry_address); ?></p>
            </div>
        <?php endif;

        if (!empty($vestry_phone)) : $vestry_tel_phone = str_replace(" ", "", $vestry_phone)  ?>
            <div class="widget_aheto__info widget_aheto__info--tel">
                <?php echo wp_kses($this->get_icon_for('phone'), 'post'); ?>
                <a class="widget_aheto__link widget_aheto__info-item" href="tel:<?php echo esc_attr($vestry_tel_phone); ?>">
                    <?php echo esc_html($vestry_phone); ?>
                </a>
                <?php if (!empty($vestry_phone2)) : $vestry_tel_phone2 = str_replace(" ", "", $vestry_phone2)  ?>
                    <a class="widget_aheto__link widget_aheto__info-item" href="tel:<?php echo esc_attr($vestry_tel_phone2); ?>">
                        <?php echo esc_html($vestry_phone2); ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($vestry_phone3)) : $vestry_tel_phone3 = str_replace(" ", "", $vestry_phone3)  ?>
                    <a class="widget_aheto__link widget_aheto__info-item" href="tel:<?php echo esc_attr($vestry_tel_phone3); ?>">
                        <?php echo esc_html($vestry_phone3); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif;

        if (!empty($vestry_email)) : ?>
            <div class="widget_aheto__info widget_aheto__info--mail">
                <?php echo wp_kses($this->get_icon_for('email'), 'post'); ?>
                <a class="widget_aheto__link widget_aheto__info-item" href="mailto:<?php echo esc_attr($vestry_email); ?>">
                    <?php echo esc_html($vestry_email); ?>
                </a>
            </div>
        <?php endif;

        if (!empty($vestry_time)) : ?>
            <div class="widget_aheto__info widget_aheto__info--time">
                <?php echo wp_kses($this->get_icon_for('time'), 'post'); ?>
                <p class="widget_aheto__info-item"><?php echo esc_html($vestry_time); ?></p>
            </div>
        <?php endif; ?>

    </div>

</div>
