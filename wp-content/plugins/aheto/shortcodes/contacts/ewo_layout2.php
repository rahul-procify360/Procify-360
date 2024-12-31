<?php

/**
 * The Contacts Shortcode.
 */

use Aheto\Helper;

extract($atts);

$contacts = $this->parse_group($ewo_contacts_group);

if (empty($contacts)) {
  return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-contact--ewo-classic');

if (!empty($ewo_dark_style)) {
  $this->add_render_attribute('wrapper', 'class', 'aheto-contact--ewo-dark');
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
  wp_enqueue_style('ewo-contacts-layout2', $shortcode_dir . 'assets/css/ewo_layout2.css', null, null);
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
  <?php foreach ($contacts  as $contact) :
    $contact = wp_parse_args($contact, [
      'ewo_heading_tag'         => '',
      'ewo_heading'         => '',
      'ewo_address'         => '',
      'ewo_phone'         => '',
      'ewo_email'          => '',
    ]);
    extract($contact);

  ?>
    <div class="aheto-contact--ewo-clasic-item">
      <?php if ($contact['ewo_heading']) :
        echo '<' . $contact['ewo_heading_tag'] . ' class="aheto-contact__title">' . wp_kses_post($contact['ewo_heading']) . '</' . $contact['ewo_heading_tag'] . '>';
      endif; ?>

      <?php if (!empty($contact['ewo_address'])) : ?>
        <div class="aheto-contact__info">
          <p class="aheto-contact__info"><?php echo wp_kses_post($contact['ewo_address']); ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($contact['ewo_phone'])) : ?>
        <div class="aheto-contact__info">
          <a class="aheto-contact__link" href="tel:<?php echo esc_attr( str_replace(" ","", $contact['ewo_phone']) ); ?>"><?php echo esc_html($contact['ewo_phone']); ?></a>
        </div>
      <?php endif; ?>

      <?php if (!empty($contact['ewo_email'])) : ?>
        <div class="aheto-contact__info">
          <a class="aheto-contact__link" href="mailto:<?php echo esc_attr($contact['ewo_email']); ?>"><?php echo esc_html($contact['ewo_email']); ?></a>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>


</div>
