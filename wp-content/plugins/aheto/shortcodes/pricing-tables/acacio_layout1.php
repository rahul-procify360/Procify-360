<?php
/**
 * The Pricing Tables Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Button Link.
$link = $this->get_button_attributes( 'link' );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-pricing-tables-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );

}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing aheto-pricing--acacio-default <?php echo esc_attr(isset($acacio_active) && $acacio_active ? 'active': ''); ?>">

        <?php
        // Heading.
        if ( !empty($heading) ) {
            echo '<div class="aheto-pricing__header"><h5 class="aheto-pricing__title">' . wp_kses_post( $heading ) . '</h5></div>';
        }
        ?>

        <div class="aheto-pricing__content">

            <div class="aheto-pricing__cost">
                <?php
                // Price.
                if ( !empty($price) ) {
                    echo '<div class="aheto-pricing__cost-value">' . esc_html( $price ) . '</div>';
                }

                // Description.
                if ( !empty($description) ) {
                    echo '<div class="aheto-pricing__cost-time">' . wp_kses_post( $description ) . '</div>';
                }
                ?>
            </div>

            <?php
            $features = $this->parse_group( $features );
            if ( ! empty( $features ) ) {

                echo '<div class="aheto-pricing__description"><ul>';

                foreach ( $features as $item ) {
                    echo '<li>';
                    if ( isset( $item['feature'] ) ) {
                        echo '[ok]' === $item['feature'] ? '<i class="ion-checkmark aheto-pricing__list-ico-ok"></i>' : wp_kses_post( $item['feature'] );
                    } else {
                        echo '&nbsp;';
                    }
                    echo '</li>';
                }

                echo '</ul></div>';
            }

            if ($acacio_add_button) { ?>
                <div class="aheto-pricing__links">
                    <?php if ( $acacio_add_button ) {
                        echo \Aheto\Helper::get_button( $this, $atts, 'acacio_' );
                    } ?>
                </div>
            <?php }

            // Tag Line.
            if ( !empty($tag) ) {
                echo '<div class="aheto-pricing__options"><div class="aheto-pricing__options-item">' . esc_html( $tag ) . '</div></div>';
            }
            ?>

        </div>

    </div>

</div>
