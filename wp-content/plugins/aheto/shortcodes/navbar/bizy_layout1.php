<?php
/**
 * Time Schedule default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$bizy_links = $this->parse_group($bizy_links);


if (empty($bizy_links)) {
    return '';
}

$this->generate_css();

// Wrapper.ƒ
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-navbar aheto-navbar--bizy-simple');


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/navbar/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('bizy-navbar-layout1', $shortcode_dir . 'assets/css/bizy_layout1.css', null, null);
}
 $icon_circle = isset($bizy_icon_circle) &&  $bizy_icon_circle ? 'icon-circle' : '';
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-navbar--wrap">

        <div class="aheto-navbar--inner">

            <?php if (!empty($bizy_links)) { ?>
                <div class="aheto-navbar--left">

                    <?php foreach ($bizy_links as $index => $link) : ?>

                        <div class="aheto-navbar--item">

                            <?php if($link['bizy_add_icon'] && !empty($link['bizy_icon_font'])){

                                $font = 'bizy_icon_' . $link['bizy_icon_font']; ?>

                                <i class="<?php echo wp_kses($link[$font], 'post'); echo esc_attr(' '. $icon_circle); ?>"></i>

                            <?php }

                            if (!empty($link['bizy_label']) && !empty($link['bizy_url'])) : ?>
                                <a href="<?php echo esc_url($link['bizy_url']); ?>"
                                   class="aheto-navbar--item-label aheto-navbar--item-link"><?php echo esc_html($link['bizy_label']); ?></a>
                            <?php endif; ?>
                            <?php if (!empty($link['bizy_label']) && empty($link['bizy_url'])) : ?>
                                <span class="aheto-navbar--item-label"><?php echo esc_html($link['bizy_label']); ?></span>
                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </div>
            <?php } ?>

        </div>
    </div>
</div>

