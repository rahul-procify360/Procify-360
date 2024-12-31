<?php
	/**
	 * Oders settings.
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto
	 * @author     UPQODE <info@upqode.com>
	 */
// input.
$cmb -> add_field ( [
		'id' => 'input',
		'type' => 'group',
		'before_group_row' => '<div class="cmb-type-form__block">
								<div class="typography-info">
									<input class="input-style" type="text" placeholder="Enter Your Name Here"/>
									<div class="typography-info__shot">
									</div>
								</div>
								<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit input field</div>
								<div class="typography-close typography-close-js"></div>
							</div><span class="line"></span>',
		'repeatable' => false,
		'fields' => [
			[
				'id' => 'font',
				'type' => 'typography',
				'before_row' => '<div class="option-block">',
				'fields' => [
					'text-align' => false,
					'text-transform' => false,
					'word-spacing' => false,
					'margin-top' => false,
					'margin-bottom' => false,
					'color_hover' => false,
				],
			],
			[
				'id' => 'background',
				'type' => 'colorpicker',
				'before_field' => '<span class="title-option">Background</span>',
				'attributes' => array (
					'data-colorpicker' => json_encode ( array (
						'palettes' => $set_colors,
					) ),
				)
			],
			[
				'id' => 'border_hover',
				'type' => 'colorpicker',
				'before_field' => '<span class="title-option">Border color (hover)</span>',
				'attributes' => array (
					'data-colorpicker' => json_encode ( array (
						'palettes' => $set_colors,
					) ),
				)
			],
			[
				'id' => 'color_placeholder',
				'type' => 'colorpicker',
				'before_field' => '<span class="title-option">Placeholder Color</span>',
				'attributes' => array (
					'data-colorpicker' => json_encode ( array (
						'palettes' => $set_colors,
					) ),
				)
			],
			[
				'id' => 'padding',
				'type' => 'spacing',
				'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
				'fields' => [
					'vertical' => true,
					'horizontal' => true,
				],
			],
			[
				'id' => 'border_radius',
				'type' => 'text_small',
				'before_row' => '<div class="border-block">',
				'before_field' => '<span class="title-option">Border Radius</span>',
			],
			[
				'id' => 'border',
				'type' => 'border',
				'before_field' => '<span class="title-option">Border style</span>',
				'after_row' => '</div>',
				'fields' => [
					'all' => true,
					'style' => true,
					'color' => true,
				],
			],
			[
				'id' => 'box_shadow',
				'type' => 'box_shadow',
				'before_field' => '<span class="title-option">Box Shadow</span>',
			],
			[
				'id' => 'height_textarea',
				'before_row' => '<div class="width-block">',
				'before_field' => '<span class="title-option">Min Height</span>',
				'type' => 'text',
			],
			[
				'id' => 'width_textarea',
				'before_field' => '<span class="title-option">Min Width</span>',
				'after_row' => '</div></div>',
				'type' => 'text',
			],
		],
	] );
$cmb -> add_field ( [
	'id' => 'select',
	'type' => 'group',
	'before_group_row' => '<div class="cmb-type-form__block">
							<div class="typography-info">
								<select class="input-style">
								  <option value="value1" selected>Choose From</option>
								  <option value="value2" >Choose From</option>
								</select>
								<div class="typography-info__shot ">
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit select field</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields' => [
		[
			'id' => 'font',
			'before_row' => '<div class="option-block">',
			'type' => 'typography',
			'fields' => [
				'text-align' => false,
				'text-transform' => false,
				'word-spacing' => false,
				'margin-top' => false,
				'margin-bottom' => false,
				'color_hover' => false,
			],
		],
		[
			'id' => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'padding',
			'type' => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical' => true,
				'horizontal' => true,
			],
		],
		[
			'id' => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id' => 'border',
			'type' => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all' => true,
				'style' => true,
				'color' => true,
			],
		],
		[
			'id' => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id' => 'height_textarea',
			'before_row' => '<div class="width-block">',
			'before_field' => '<span class="title-option">Min Height</span>',
			'type' => 'text',
		],
		[
			'id' => 'width_textarea',
			'before_field' => '<span class="title-option">Min Width</span>',
			'after_row' => '</div></div>',
			'type' => 'text',
		],
	],
] );
$cmb -> add_field ( [
	'id' => 'textarea',
	'type' => 'group',
	'before_group_row' => '<div class="cmb-type-form__block">
							<div class="typography-info">
								<textarea class="input-style" type="text" placeholder="Enter Your Message Here"></textarea>	
								<div class="typography-info__shot ">
								</div>					
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit textarea field</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields' => [
		[
			'id' => 'font',
			'type' => 'typography',
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align' => false,
				'text-transform' => false,
				'word-spacing' => false,
				'margin-top' => false,
				'margin-bottom' => false,
				'color_hover' => false,
			],
		],
		[
			'id' => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'color_placeholder',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Placeholder Color</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'padding',
			'type' => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical' => true,
				'horizontal' => true,
			],
		],
		[
			'id' => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id' => 'border',
			'type' => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all' => true,
				'style' => true,
				'color' => true,
			],
		],
		[
			'id' => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id' => 'height_textarea',
			'before_row' => '<div class="width-block">',
			'before_field' => '<span class="title-option">Min Height</span>',
			'type' => 'text',
		],
		[
			'id' => 'width_textarea',
			'before_field' => '<span class="title-option">Min Width</span>',
			'after_row' => '</div></div>',
			'type' => 'text',
		],
	],
] );
$cmb -> add_field ( [
	'id' => 'checkbox',
	'type' => 'group',
	'before_group_row' => '<div class="cmb-type-form__block">
						<div class="typography-info">
							<input class="input-style" type="checkbox">
							<div class="typography-info__shot ">
							</div>			
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Сheckbox field</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields' => [
		[
			'id' => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array (
				'data-colorpicker' => json_encode ( array (
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id' => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id' => 'border',
			'type' => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all' => true,
				'style' => true,
				'color' => true,
			],
		],
		[
			'id' => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
	],
] );
