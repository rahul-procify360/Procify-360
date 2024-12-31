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

$lists = $this->parse_group( $aira_table_lists );
if ( empty( $lists ) ) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-list--aira-table-links' );


/**
 * Set dependent style
 */

$sc_dir = aheto()->plugin_url() . 'shortcodes/list/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-table-list', $sc_dir . 'assets/css/aira_layout1.css', null, null);
}
?>
<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $aira_first_column ) || ! empty( $aira_second_column ) || ! empty( $aira_third_column ) ) {

		$aira_first_column = !empty($aira_first_column) ? $aira_first_column : '';
		$aira_second_column = !empty($aira_second_column) ? $aira_second_column : '';
		$aira_third_column = !empty($aira_third_column) ? $aira_third_column : '';
	    ?>
        <div class="aheto-list--main-row">
            <div class="aheto-list--column">
				<?php echo wp_kses( $aira_first_column, 'post' ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses( $aira_second_column, 'post' ); ?>
            </div>
            <div class="aheto-list--column">
				<?php echo wp_kses( $aira_third_column, 'post' ); ?>
            </div>
        </div>
	<?php } ?>

	<?php foreach ( $lists as $item ) { ?>

        <div class="aheto-list--row">
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $aira_first_column, 'post' ); ?></h6>
				<h5><?php echo wp_kses( $item['aira_first_item'], 'post' ); ?></h5>
            </div>
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $aira_second_column, 'post' ); ?></h6>
				<?php echo wp_kses( $item['aira_second_item'], 'post' ); ?>
            </div>
            <div class="aheto-list--column">
                <h6><?php echo wp_kses( $aira_third_column, 'post' ); ?></h6>
				<?php echo wp_kses( $item['aira_third_item'], 'post' ); ?>
            </div>
            <div class="aheto-list--column">
                <?php if ( $item['aira_main_add_button'] ) { ?>
                <div class="aheto-list__link">
		            <?php echo Aheto\Helper::get_button($this, $item, 'aira_main_'); ?>
                </div>
                <?php } ?>
            </div>
        </div>

	<?php } ?>

</div>
