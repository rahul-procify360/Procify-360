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

$lists = $this->parse_group( $acacio_table_lists );
if ( empty( $lists ) ) {
	return '';
}
$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-list--acacio-table-links' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-list-layout2', $shortcode_dir . 'assets/css/acacio_layout2.css', null, null );
}

?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $acacio_first_column ) || ! empty( $acacio_second_column ) || ! empty( $acacio_third_column ) ) {

		$acacio_first_column = !empty($acacio_first_column) ? $acacio_first_column : '';
		$acacio_second_column = !empty($acacio_second_column) ? $acacio_second_column : '';
		$acacio_third_column = !empty($acacio_third_column) ? $acacio_third_column : '';
	    ?>
        <div class="aheto-list--main-row">
            <div class="aheto-list--column">
				<?php echo wp_kses_post( $acacio_first_column ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses_post( $acacio_second_column ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses_post( $acacio_third_column ); ?>
            </div>
        </div>
	<?php } ?>

	<?php foreach ( $lists as $item ) { ?>
        <div class="aheto-list--row">
            <div class="aheto-list--column">
                <h5 class="aheto-list--column-heading"><?php echo wp_kses_post( $acacio_first_column ); ?></h5>
				<h5><?php echo wp_kses_post( $item['acacio_first_item'] ); ?></h5>
            </div>
            <div class="aheto-list--column">
                <h5 class="aheto-list--column-heading"><?php echo wp_kses_post( $acacio_second_column ); ?></h5>
				<p><?php echo wp_kses_post( $item['acacio_second_item'] ); ?></p>
            </div>
            <div class="aheto-list--column">
                <h5 class="aheto-list--column-heading"><?php echo wp_kses_post( $acacio_third_column ); ?></h5>
				<p><?php echo wp_kses_post( $item['acacio_third_item'] ); ?></p>
            </div>
            <div class="aheto-list--column">
                <?php if ( $item['acacio_main_add_button'] ) { ?>
                <div class="aheto-list__links">
		            <?php echo Aheto\Helper::get_button($this, $item, 'acacio_main_'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
	<?php } ?>
</div>
