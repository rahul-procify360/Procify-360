<?php
use Aheto\Helper;
/**
 * Navbar templates.
 */

extract($atts);

$sterling_left_links  = $this->parse_group($sterling_left_links);

if (empty($sterling_left_links)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar--sterling');

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('sterling-navbar', $sc_dir . 'assets/css/sterling_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <?php if (!empty($sterling_descr)) : ?>
    <span class="aheto-navbar--item"><?php echo esc_html($sterling_descr); ?></span>
  <?php endif; ?>
  <?php if (!empty($sterling_left_links)) { ?>
    <?php foreach ($sterling_left_links as $index => $link) : ?>
      <div class="aheto-navbar--item">
        <?php if (($link['sterling_add_icon']) && ($link['sterling_type_link'] == 'mail' || $link['sterling_type_link'] == 'phone')) : ?>
          <span class="aheto-navbar--item-label">
            <?php if ($link['sterling_type_link'] == 'phone' && $link['sterling_add_icon']) : ?>
              <i class="ion-ios-telephone<?php echo esc_attr($link['sterling_type_icon']); ?>"></i>
            <?php endif; ?>
            <?php if ($link['sterling_type_link'] == 'mail' && $link['sterling_add_icon']) : ?>
              <i class="ion-android-mail<?php echo esc_attr($link['sterling_type_icon']); ?>"></i>
            <?php endif; ?>
          </span>
        <?php endif; ?>

        <?php if (!empty($link['sterling_phone']) && $link['sterling_type_link'] == 'phone') : ?>
          <a href="tel:<?php echo esc_attr(str_replace(' ', '', $link['sterling_phone'])); ?>" class="aheto-navbar--item-link phone"><?php echo esc_html($link['sterling_phone']); ?></a>
        <?php endif; ?>
        <?php if (!empty($link['sterling_mail']) && $link['sterling_type_link'] == 'mail') : ?>
          <a href="mailto:<?php echo esc_attr(str_replace(' ', '', $link['sterling_mail'])); ?>" class="aheto-navbar--item-link email"><?php echo esc_html($link['sterling_mail']); ?></a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php } ?>
</div>
