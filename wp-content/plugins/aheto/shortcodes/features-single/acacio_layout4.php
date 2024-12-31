<?php
/**
 * The Features Modern with hover Shortcode.
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

// Button.
$button = $this->get_button_attributes( 'link' );
// Icon.
$icon = $this->get_icon_attributes( '', true, true );
if ( ! empty( $icon ) ) {
	$this->add_render_attribute( 'icon', 'class', 'aheto-content-block__ico aheto-content-block__ico--lg icon' );
	$this->add_render_attribute( 'icon', 'class', $icon['icon'] );
	$this->add_render_attribute( 'icon', 'class', $icon['align'] );
	if ( ! empty( $icon['color'] ) ) {
		$this->add_render_attribute( 'icon', 'style', 'color:' . $icon['color'] );
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('acacio-features-single-layout4', $shortcode_dir . 'assets/css/acacio_layout4.css', null, null);
}


?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
    <?php if (isset($s_image) && !empty($s_image)  ) : ?>
        <?php $feature_bg =  \Aheto\Helper::get_background_attachment( $s_image, $acacio_image_size, $atts, 'acacio_' ); ?>
    <?php endif; ?>
	<div class="aheto-content-block t-center aheto-content-block--light aheto-content-block--bgImg" <?php echo esc_attr($feature_bg); ?>>



		<div class="aheto-content-block__descr">

			<?php
			if (isset($s_heading) && !empty($s_heading) ) :
				// Icon.
				if ( ! empty( $icon ) ) {
					echo '<i ' . $this->get_render_attribute_string( 'icon' ) . '></i>';
				}
				?>
			<h3 class="aheto-content-block__title t-light"><?php echo wp_kses_post($this->highlight_text( $s_heading )); ?></h3>
			<?php endif; ?>

			<div class="aheto-content-block__info">

				<?php if (isset($s_description) && !empty($s_description) ) : ?>
				<p class="aheto-content-block__info-text">
					<?php echo wp_kses_post( $s_description ); ?>
				</p><br>
				<?php endif; ?>


            </div>
            <?php if ($acacio_main_add_button ) { ?>
                    <div class="aheto-btn-container t-center">
                        <?php if ( $acacio_main_add_button ) {
                            echo \Aheto\Helper::get_button( $this, $atts, 'acacio_main_' );
                        } ?>
                    </div>
                <?php } ?>

		</div>

	</div>

</div>
