<?php
/**
 * The Team Shortcode.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-team-member--rela-simple');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

    <div class="aheto-team-member__text t-center">
        <?php

        if (!empty($name)) {
            echo '<h5 class="aheto-team-member__name">' . wp_kses($name, 'post') . '</h5>';
        }

        if (!empty($designation)) {
            echo '<p class="aheto-team-member__position">' . esc_html($designation) . '</p>';
        }
        ?>
    </div>
</div>
