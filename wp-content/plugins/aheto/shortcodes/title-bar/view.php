<?php
/**
 * Title bar default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-titlebar' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-titlebar--layout1' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

// Contrast.
$contrast = isset( $content_light ) && $content_light ? 't-white' : '';

$background_image = isset( $background ) && $background ? Helper::get_background_attachment( $background, $image_size, $atts ) : '';

$title_tag = isset($title_tag) && !empty($title_tag) ? $title_tag : 'h2';

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'title-bar-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?> <?php echo esc_attr( $background_image ); ?>>

    <div class="aheto-titlebar__overlay"></div>

    <div class="aheto-titlebar__main container">
        <div class="aheto-titlebar__content">
            <div class="aheto-titlebar__content-inner">
				<?php
				$title = $this->get_heading();
				if ( !empty($title) ) {
					$title_alignment = isset( $title_alignment ) && ! empty( $title_alignment ) ? $title_alignment : '';
					echo '<' . $title_tag . ' class="aheto-titlebar__title ' . $contrast . ' ' . $title_alignment . '">' . $title . '</' . $title_tag . '>';
				} ?>

				<?php if ( ! empty( $searchform ) ) : ?>

                    <div class="aheto-titlebar__input <?php echo Helper::get_button( $this, $atts, 'sf_', true ); ?>">
                        <form role="search" class="w-800" method="get" id="searchform"
                              action="<?php echo home_url( '/' ); ?>">
                            <label class="screen-reader-text" for="s">Search: </label>
                            <input type="text" value="" name="s" id="s"
                                   placeholder="<?php echo esc_html( $sf_placeholder ); ?>"/>
                            <input type="submit" id="searchsubmit" value="<?php echo esc_html( $sf_button ); ?>"/>
                        </form>
                    </div>
				<?php endif; ?>
            </div>
        </div>

		<?php if ( ! empty( $breadcrumb ) ) : ?>
            <div class="aheto-titlebar__breadcrumbs <?php echo $contrast; ?> <?php echo ! empty( $crumb_alignment ) ? $crumb_alignment : ''; ?>">
				<?php
				$object = new Aheto\Frontend\Breadcrumbs;
				echo $object->get_breadcrumb(); ?>
            </div>
		<?php endif; ?>

    </div>

</div>
