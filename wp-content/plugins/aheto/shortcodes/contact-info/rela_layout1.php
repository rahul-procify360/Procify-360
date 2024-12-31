<?php
/**
 * Contact Info default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'widget_aheto__contact_info--rela-minimal');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

$underline = isset($underline) && $underline ? 'underline' : '';
$title_space = isset($title_space) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute('title', 'class', 'widget_aheto__title');
$this->add_render_attribute('title', 'class', $underline);
$this->add_render_attribute('title', 'class', $title_space);

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('rela-contact-info-layout1', $shortcode_dir . 'assets/css/rela_layout1.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php if (!empty($text_logo) && $type_logo == 'text') { ?>
        <div class="widget_aheto__logo">
            <h2><?php echo esc_html($text_logo); ?></h2>
        </div>
    <?php } elseif (is_array($logo) && !empty($logo['url']) || !is_array($logo) && !empty($logo)) { ?>

        <div class="widget_aheto__logo">
            <?php echo Helper::get_attachment($logo, ['class' => 'aheto-clients__img']); ?>
        </div>

    <?php }

    if (!empty($title)) : ?>
        <h5 <?php $this->render_attribute_string('title'); ?>>
            <?php echo wp_kses($title, 'post'); ?>
        </h5>
    <?php endif;

    if (!empty($description)) : ?>
        <p class="widget_aheto__desc">
            <?php echo wp_kses($description, 'post'); ?>
        </p>
    <?php endif; ?>

    <div class="widget_aheto__infos">

        <?php if (!empty($address)) : ?>
            <div class="widget_aheto__info widget_aheto__info--address">
                <p><?php echo wp_kses($address, 'post'); ?></p>
            </div>
        <?php endif;

        if (!empty($email)) : ?>
            <div class="widget_aheto__info widget_aheto__info--mail">
                <a class="widget_aheto__link" href="mailto:<?php echo esc_attr($email); ?>">
                    <?php echo esc_html($email); ?>
                </a>
            </div>
        <?php endif;

        if (!empty($phone)) : ?>
            <div class="widget_aheto__info widget_aheto__info--tel">
                <a class="widget_aheto__link" href="tel:<?php echo str_replace(" ", "", $phone); ?>">
                    <?php echo esc_html($phone); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>
