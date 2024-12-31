<?php
/**
 * Title bar default templates.
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
$this->add_render_attribute( 'wrapper', 'class', 'aheto-titlebar' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-titlebar--moovit-modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Contrast.
$contrast = isset( $content_light ) && $content_light ? 't-white' : '';

$background_image = isset( $background ) && $background ? Helper::get_background_attachment( $background, 'full' ) : '';

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'moovit-title-bar-layout1', $shortcode_dir . 'assets/css/moovit_layout1.css', null, null );
}
?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?> <?php echo esc_attr( $background_image ); ?>>

    <div class="aheto-titlebar__overlay"></div>

    <div class="aheto-titlebar__main container">
        <div class="aheto-titlebar__content">
            <div class="aheto-titlebar__content-inner">
				<?php
				$title = $this->get_heading();
				if ( ! empty( $title ) ) {
					echo '<' . $title_tag . ' class="aheto-titlebar__title ' . $contrast . ' ">' . $title . '</' . $title_tag . '>';
				}


				if ( ! empty( $moovit_text ) ) { ?>
                    <h5 class="aheto-titlebar__description <?php echo esc_attr( $contrast ); ?>">
						<?php echo esc_html( $moovit_text ); ?>
                    </h5>
				<?php }

				if ( ! empty( $moovit_searchform ) ) : ?>

                    <div class="aheto-titlebar__input">
                        <form role="search" class="w-800" method="get" id="searchform"
                              action="<?php echo home_url( '/' ); ?>">
                            <label class="screen-reader-text"
                                   for="s"><?php esc_html_e( 'Search:', 'moovit' ); ?></label>
                            <input type="text" value="" name="s" id="s"
                                   placeholder="<?php echo esc_html( $moovit_sf_placeholder ); ?>"/>
                            <button type="submit" id="searchsubmit" class="ion-android-search"></button>
                        </form>
                    </div>
				<?php endif; ?>
            </div>
        </div>

    </div>

</div>
