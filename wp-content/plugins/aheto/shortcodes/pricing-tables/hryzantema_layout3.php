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

$hryzantema_active = isset($hryzantema_active) && $hryzantema_active ? 'active' : '';

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('hryzantema-pricing-tables-layout3', $shortcode_dir . 'assets/css/hryzantema_layout3.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <div class="aheto-pricing aheto-pricing--hr-classic-2 <?php echo esc_attr($hryzantema_active); ?>">
        <div class="aheto-pricing__wrapper">
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
						echo '<div class="aheto-pricing__cost-value">' . esc_html($price) . '</div>';
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

                    echo '<div class="aheto-pricing__description"><ul class="t-left">';

                    foreach ( $features as $item ) {
                        echo '<li>';
                        if ( !empty( $item['feature'] ) ) {
                            echo wp_kses_post( $item['feature'] );
                        } else {
                            echo '&nbsp;';
                        }
                        echo '</li>';
                    }

                    echo '</ul></div>';
                }

                // Button Link.
                if ( $hryzantema_add_button == true ) { ?>
                    <div class="aheto-pricing__link">
                        <?php echo \Aheto\Helper::get_button($this, $atts, 'hryzantema_'); ?>
                    </div>
                <?php }
                ?>
            </div>
        </div>


    </div>
</div>
