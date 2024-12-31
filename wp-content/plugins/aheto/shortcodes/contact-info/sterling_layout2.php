<?php

/**
 * Contact Info 2.
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto__contact_info--sterling2');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-contacts-2', $sc_dir . 'assets/css/sterling_layout2.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <?php if (!empty($sterling_description)) : ?>
    <p class="widget_aheto__desc">
      <?php echo esc_html($sterling_description); ?>
    </p>
  <?php endif; ?>

  <div class="widget_aheto__infos">

    <?php if (!empty($sterling_address)) : ?>
      <div class="widget_aheto__info">
        <?php echo wp_kses($this->get_icon_for('address'), 'post'); ?>
        <span class="widget_aheto__info-item"><?php echo esc_html($sterling_address); ?></span>
      </div>
    <?php endif;

    if (!empty($sterling_phone)) : $sterling_tel_phone = str_replace(" ", "", $sterling_phone)  ?>
      <div class="widget_aheto__info">
        <?php echo wp_kses($this->get_icon_for('phone'), 'post'); ?>
        <a class="widget_aheto__info-item" href="tel:<?php echo esc_attr($sterling_tel_phone); ?>">
          <?php echo esc_html($sterling_phone); ?>
        </a>
        <?php if (!empty($sterling_phone2)) : $sterling_tel_phone2 = str_replace(" ", "", $sterling_phone2)  ?>
          <a class="widget_aheto__info-item" href="tel:<?php echo esc_attr($sterling_tel_phone2); ?>">
            <?php echo esc_html($sterling_phone2); ?>
          </a>
        <?php endif; ?>
      </div>
    <?php endif;

    if (!empty($sterling_email)) : ?>
      <div class="widget_aheto__info">
        <?php echo wp_kses($this->get_icon_for('email'), 'post'); ?>
        <a class="widget_aheto__link widget_aheto__info-item" href="mailto:<?php echo esc_attr($sterling_email); ?>">
          <?php echo esc_html($sterling_email); ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>
