<?php
	/**
	 * Color settings.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto
	 * @author     UPQODE <info@upqode.com>
	 */

	$set_colors = array();

	if ( isset( $_GET['aheto-edit-skin'] ) && !empty( $_GET['aheto-edit-skin'] ) ) {
		$skin_id = $_GET['aheto-edit-skin'];

		$colors = ['active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black'];

		$settings = get_option( 'aheto_skin_' . $skin_id );

		foreach ( $colors as $color ) {
			if(isset($settings[$color]) && !empty($settings[$color])){
				$set_colors[] = $settings[$color];
			}
		}
	}



	$cmb->add_field([
		'id'     => 'color_title',
		'type'   => 'title',
		'before_row'   => '<div class="setting-panel-colors__items"> <div class="setting-panel-colors__item">',
	]);


	$cmb->add_field( [
		'id'   => 'active',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Primary</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'alter',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Alter</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'dark',
		'after' => '<span class="color-name">Dark</span>',
		'type' => 'colorpicker',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'dark2',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Dark2</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)

	]);

	$cmb->add_field( [
		'id'   => 'grey',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Grey</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'light',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Light</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'alter2',
		'type' => 'colorpicker',
		'after' => '<span class="color-name">Quaternary</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);

	$cmb->add_field( [
		'id'   => 'alter3',
		'type' => 'colorpicker',
		'after_row'   => '</div> </div> <div class="default-color__container"><div class="default-color default-color-js"> <h4 class="default-color__title">Palette Templates</h4></div></div>',
		'after' => '<span class="color-name">Tertiary</span>',
		'attributes' => array(
			'data-colorpicker' => json_encode( array(
				'palettes' => $set_colors,
			) ),
		)
	]);
