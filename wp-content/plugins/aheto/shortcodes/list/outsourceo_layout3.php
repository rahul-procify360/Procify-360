<?php
/**
 * The List Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$lists = $this->parse_group( $outsourceo_table_lists );
if ( empty( $lists ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-list--outsourceo-table-links' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'outsourceo-list-layout3', $shortcode_dir . 'assets/css/outsourceo_layout3.css', null, null );
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $outsourceo_first_column ) || ! empty( $outsourceo_second_column ) || ! empty( $outsourceo_third_column ) ) {

		$outsourceo_first_column  = ! empty( $outsourceo_first_column ) ? $outsourceo_first_column : '';
		$outsourceo_second_column = ! empty( $outsourceo_second_column ) ? $outsourceo_second_column : '';
		$outsourceo_third_column  = ! empty( $outsourceo_third_column ) ? $outsourceo_third_column : ''; ?>

        <div class="aheto-list--main-row">
            <div class="aheto-list--column">
				<?php echo wp_kses( $outsourceo_first_column, 'post' ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses( $outsourceo_second_column, 'post' ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses( $outsourceo_third_column, 'post' ); ?>
            </div>
        </div>
	<?php } ?>

	<?php foreach ( $lists as $item ) { ?>

        <div class="aheto-list--row">
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $outsourceo_first_column, 'post' ); ?></h6>
                <h5><?php echo wp_kses( $item['outsourceo_first_item'], 'post' ); ?></h5>
            </div>
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $outsourceo_second_column, 'post' ); ?></h6>
				<?php echo wp_kses( $item['outsourceo_second_item'], 'post' ); ?>
            </div>
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $outsourceo_third_column, 'post' ); ?></h6>
				<?php echo wp_kses( $item['outsourceo_third_item'], 'post' ); ?>
            </div>
            <div class="aheto-list--column">
				<?php if ( $item['outsourceo_main_add_button'] ) { ?>
                    <div class="aheto-banner-slider__links">
						<?php echo Aheto\Helper::get_button( $this, $item, 'outsourceo_main_' ); ?>
                    </div>
				<?php } ?>
            </div>
        </div>

	<?php } ?>

</div>
