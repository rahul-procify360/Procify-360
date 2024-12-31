<?php
/**
 * Buttons settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

$cmb->add_field([
	'id'         => 'button_responsive',
	'type'       => 'title',
	'name'   => __( '<div class="typography-responsive">
						<h5 class="title">Choose Device</h5>
						<span class="icon-desktop icon-desktop-js ">
							<svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.9238 0.25C18.2246 0.25 18.375 0.400391 18.375 0.701172V11.6113C18.375 11.9121 18.2246 12.0625 17.9238 12.0625H0.451172C0.150391 12.0625 0 11.9121 0 11.6113V0.701172C0 0.400391 0.150391 0.25 0.451172 0.25H17.9238ZM17.0625 10.75V1.5625H1.3125V10.75H17.0625ZM11.0742 16H7.30078C6.34375 16 5.87891 15.9043 5.90625 15.7129C5.90625 15.6582 5.96094 15.5898 6.07031 15.5078C6.17969 15.4258 6.34375 15.3164 6.5625 15.1797C6.80859 15.043 6.98633 14.9336 7.0957 14.8516C7.23242 14.7422 7.30078 14.6465 7.30078 14.5645L7.3418 12.7188H9.1875H11.0332C11.0605 13.8398 11.0742 14.4551 11.0742 14.5645C11.0742 14.6465 11.1289 14.7422 11.2383 14.8516C11.375 14.9336 11.5527 15.043 11.7715 15.1797C12.0176 15.3164 12.1953 15.4258 12.3047 15.5078C12.6328 15.7539 12.4824 15.9043 11.8535 15.959L11.0742 16Z" fill="#8082A3"/>
							</svg>
							<span>Desktop Devices</span>
						</span>
						<span class="icon-tablet  icon-tablet-js">
							<svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M13.603 0.610107H12.4694V0.610316L12.4694 0.610316H1.13358C0.507466 0.610316 0 1.11778 0 1.7439V18.2564C0 18.8825 0.507466 19.39 1.13358 19.39H12.4694L12.4913 19.3898H13.603C14.2291 19.3898 14.7366 18.8823 14.7366 18.2562V1.74369C14.7366 1.11757 14.2291 0.610107 13.603 0.610107ZM5.10112 18.5397H7.36829C7.5248 18.5397 7.65168 18.4129 7.65168 18.2563C7.65168 18.0998 7.5248 17.9729 7.36829 17.9729H5.10112C4.94461 17.9729 4.81773 18.0998 4.81773 18.2563C4.81773 18.4129 4.94461 18.5397 5.10112 18.5397ZM8.50196 18.5397C8.65848 18.5397 8.78536 18.4128 8.78536 18.2563C8.78536 18.0998 8.65848 17.9729 8.50196 17.9729C8.34545 17.9729 8.21857 18.0998 8.21857 18.2563C8.21857 18.4128 8.34545 18.5397 8.50196 18.5397ZM9.91893 18.2562C9.91893 18.4127 9.79205 18.5396 9.63554 18.5396C9.47902 18.5396 9.35214 18.4127 9.35214 18.2562C9.35214 18.0997 9.47902 17.9728 9.63554 17.9728C9.79205 17.9728 9.91893 18.0997 9.91893 18.2562ZM12.4694 17.1225L12.4694 17.1227H13.603V2.87736H12.4694L12.4694 2.87754H9.20589C8.86038 3.22287 8.56992 3.5131 8.56943 3.5131C8.26158 3.82064 7.83676 4.01112 7.36825 4.01112C6.89974 4.01112 6.47491 3.82064 6.16589 3.5131L5.53033 2.87754H1.13355V17.1229H12.4694V17.1225Z" fill="#8082A3"/>
							</svg>
							<span>Tablet Devices</span>
						</span>
						<span class="icon-mobile icon-mobile-js">
							<svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M1.08652 0H9.77867H10.8652C11.4653 0 11.9517 0.486398 11.9517 1.08652V16.9135C11.9517 17.5136 11.4653 18 10.8652 18H9.77867H1.08652C0.486398 18 0 17.5136 0 16.9135V1.08652C0 0.486398 0.486398 0 1.08652 0ZM6.74413 1.8548L7.51241 1.08652H9.77867H10.8652V14.7404H9.77867H1.08652V1.08652H4.4393C4.4393 1.08652 5.20758 1.8548 5.2083 1.8548C5.40503 2.05132 5.67648 2.17304 5.97585 2.17304C6.27523 2.17304 6.54668 2.05132 6.74413 1.8548ZM5.48438 15.6094C5.05722 15.6094 4.71094 15.9557 4.71094 16.3828C4.71094 16.81 5.05722 17.1562 5.48438 17.1562H6.64453C7.07169 17.1562 7.41797 16.81 7.41797 16.3828C7.41797 15.9557 7.07169 15.6094 6.64453 15.6094H5.48438Z" fill="#8082A3"/>
							</svg>
							<span>Mobile Devices</span>
						</span>
					</div> ', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'anchor-btn',
	'type'       => 'title',
	'name'   => __( '<div class="typography-anchor">
					<a class="js-filter active" data-filter="all">All</a>
					<a class="js-filter" data-filter="primary">Primary</a>
					<a class="js-filter" data-filter="dark">Dark</a>
					<a class="js-filter" data-filter="light">Light</a>
					<a class="js-filter" data-filter="inline">Inline</a>
					<a class="js-filter" data-filter="video">Video</a>

				</div> ', 'aheto' ),
]);

// Button.
$cmb->add_field([
	'id'         => 'button',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block ">
							<div class="typography-open typography-open-js"></div>
							<span class="example"><span class="example-js">Button</span></span>
							<div class="typography-info">
								<div class="example-btn">
									<span class="title title-js">Button Styling</span>
								</div>
								<div class="typography-info__shot">
								</div>
							</div>
							<div class="typography-close typography-close-js"></div>
						</div>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'name'   => __( '<i class="fas fa-align-left yellow-color"></i> Font', 'aheto' ),
			'desc'   => esc_html__( 'Please enter a value to customize the button font.', 'aheto' ),
			'responsive' => false,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'name'   => __( '<i class="fas fa-indent pink-color"></i>Padding', 'aheto' ),
			'desc'   => esc_html__( 'Please add padding to your button.', 'aheto' ),
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'name'   => __( '<i class="fas fa-indent pink-color"></i>Mobile Padding', 'aheto' ),
			'desc'   => esc_html__( 'Please, enter your custom paddings for the Large Button.', 'aheto' ),
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'name' => __( '<i class="fas fa-circle blue-color"></i>Border Radius', 'aheto' ),
			'desc' => esc_html__( 'Please enter a border radius for your button.', 'aheto' ),
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'name'   => __( '<i class="fas fa-window-maximize green-color"></i>Border', 'aheto' ),
			'desc'   => esc_html__( 'Please add border weight and choose style.', 'aheto' ),
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => false,
			],
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'name' => __( '<i class="fas fa-certificate yellow-color"></i>Icon Size', 'aheto' ),
			'desc' => esc_html__( 'Please enter the size of the icon.', 'aheto' ),
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'name' => __( '<i class="fas fa-outdent pink-color"></i>Icon Margin', 'aheto' ),
			'desc' => esc_html__( 'Please, enter margin for your button icon.', 'aheto' ),
		],
	],
]);

// Button Primary.
$cmb->add_field([
	'id'         => 'button_primary',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="primary">
							<div class="typography-info">
								<div class="example-btn">
									<span class="title title-js">Click This Button</span>
								</div>
								<div class="typography-info__shot">
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button Primary Large
$cmb->add_field([
	'id'         => 'button_primary_large',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="primary">
						<div class="typography-info">
							<div class="example-btn">
								<span class="title title-js">Click This Button</span>
							</div>
							<div class="typography-info__shot">
							</div>
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Large</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'before_row' => '<div class="option-block">',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button Primary Small
$cmb->add_field([
	'id'         => 'button_primary_small',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="primary">
					<div class="typography-info">
						<div class="example-btn">
							<span class="title title-js">Click This Button</span>
						</div>
						<div class="typography-info__shot">
						</div>
					</div>
					<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button small</div>
					<div class="typography-close typography-close-js"></div>
				</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'before_row' => '<div class="option-block">',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button Dark
$cmb->add_field([
	'id'         => 'button_dark',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="dark">
						<div class="typography-info">
							<div class="example-btn">
								<span class="title title-js">Click This Button</span>
							</div>
							<div class="typography-info__shot">
							</div>
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
//		[
//			'id'   => 'btn_close',
//			'type'       => 'title',
//			'name'   => __( '<div class="typography-close typography-close-js"></div>', 'aheto' ),
//		],
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button Dark Large
$cmb->add_field([
	'id'         => 'button_dark_large',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="dark">
						<div class="typography-info">
							<div class="example-btn">
								<span class="title title-js">Click This Button</span>
							</div>
							<div class="typography-info__shot">
							</div>
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Large</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button Dark Small
$cmb->add_field([
	'id'         => 'button_dark_small',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="dark">
					<div class="typography-info">
						<div class="example-btn">
							<span class="title title-js">Click This Button</span>
						</div>
						<div class="typography-info__shot">
						</div>
					</div>
					<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Small</div>
					<div class="typography-close typography-close-js"></div>
				</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Light Button.
$cmb->add_field([
	'id'         => 'button_light',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="light">
							<div class="typography-info">
								<div class="example-btn">
									<span class="title title-js">Click This Button</span>
								</div>
								<div class="typography-info__shot">
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Light Button Large
$cmb->add_field([
	'id'         => 'button_light_large',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="light">
							<div class="typography-info">
								<div class="example-btn">
									<span class="title title-js">Click This Button</span>
								</div>
								<div class="typography-info__shot">
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Large</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Light Button Small
$cmb->add_field([
	'id'         => 'button_light_small',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="light">
						<div class="typography-info">
							<div class="example-btn">
								<span class="title title-js">Click This Button</span>
							</div>
							<div class="typography-info__shot">
							</div>
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Small</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'before_row' => '<div class="option-block">',
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
				'color'          => false,
				'color_hover'    => false,
			],
		],
		[
			'id'     => 'padding',
			'type'   => 'spacing',
			'before_field' => '<span class="desktop title-option">Desktop Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'tablet_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="tablet title-option">Tablet Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'     => 'mobile_padding',
			'type'   => 'spacing',
			'before_field' => '<span class="mobile title-option">Mobile Padding</span>',
			'fields' => [
				'vertical'   => true,
				'horizontal' => true,
			],
		],
		[
			'id'   => 'border_radius',
			'type' => 'text_small',
			'before_row' => '<div class="border-block">',
			'before_field' => '<span class="title-option">Border Radius</span>',
		],
		[
			'id'     => 'border',
			'type'   => 'border',
			'before_field' => '<span class="title-option">Border style</span>',
			'after_row' => '</div>',
			'fields' => [
				'all'   => true,
				'style' => true,
				'color' => true,
			],
		],

		[
			'id'   => 'background',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'background_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Background (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'color_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Font Color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'border_hover',
			'type' => 'colorpicker',
			'before_field' => '<span class="title-option">Border color (hover)</span>',
			'attributes' => array(
				'data-colorpicker' => json_encode( array(
					'palettes' => $set_colors,
				) ),
			)
		],
		[
			'id'   => 'box_shadow',
			'type' => 'box_shadow',
			'before_field' => '<span class="title-option">Box Shadow</span>',
		],
		[
			'id'   => 'icon_size',
			'type' => 'text_small',
			'before_row' => '<div class="icon-block">',
			'before_field' => '<span class="title-option">Icon Size</span>',
		],
		[
			'id'   => 'icon_margin',
			'type' => 'text_small',
			'after_row' => '</div></div>',
			'before_field' => '<span class="title-option">Icon Margin</span>',
		],
	],
]);

// Button inline.
$cmb->add_field([
	'id'         => 'button_inline',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="inline">
							<div class="typography-info">
								<div class="example-btn">
									<span class="title title-js">Click This Button</span>
								</div>
								<div class="typography-info__shot">
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Inline</div>
							<div class="typography-close typography-close-js"></div>
						</div><span class="line"></span><div class="typography-close typography-close-js"></div>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
			]
		]
	],
]);

// Button inline dark
$cmb->add_field([
	'id'         => 'button_inline_dark',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="inline">
						<div class="typography-info">
							<div class="example-btn">
								<span class="title title-js">Click This Button</span>
							</div>
							<div class="typography-info__shot">
							</div>
						</div>
						<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Inline Dark</div>
						<div class="typography-close typography-close-js"></div>
					</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
			]
		]
	],
]);

// Button inline light
$cmb->add_field([
	'id'         => 'button_inline_light',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="inline">
					<div class="typography-info">
						<div class="example-btn">
							<span class="title title-js">Click This Button</span>
						</div>
						<div class="typography-info__shot">
						</div>
					</div>
					<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Inline Light</div>
					<div class="typography-close typography-close-js"></div>
				</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'     => 'font',
			'type'   => 'typography',
			'responsive' => true,
			'fields' => [
				'text-align'     => false,
				'text-transform' => false,
				'word-spacing'   => false,
				'margin-top'     => false,
				'margin-bottom'  => false,
			]
		]
	],
]);

// Button video .
$cmb->add_field([
	'id'         => 'button_video',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="video">
								<div class="typography-info">
									<div class="example-btn">
										<span class="title title-js"><i class="ion-ios-play"></i></span>
									</div>
									<div class="typography-info__shot">
									</div>
								</div>
								<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Video</div>
								<div class="typography-close typography-close-js"></div>
							</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'   => 'font_size',
			'type' => 'text_small',
			'before_row' => '<div class="video-btn">',
			'before_field' => '<span class="title-option">Font Size</span>',
		],
		[
			'id'   => 'btn_size',
			'type' => 'text_small',
			'after' => '</div>',
			'before_field' => '<span class="title-option">Button Size</span>',

		],
	],
]);

// Button video large.
$cmb->add_field([
	'id'         => 'button_video_large',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="video">
								<div class="typography-info">
									<div class="example-btn">
										<span class="title title-js"><i class="ion-ios-play"></i></span>
									</div>
									<div class="typography-info__shot">
									</div>
								</div>
								<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Video Large</div>
								<div class="typography-close typography-close-js"></div>
							</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'   => 'font_size',
			'type' => 'text_small',
			'before_row' => '<div class="video-btn">',
			'before_field' => '<span class="title-option">Font Size</span>',
		],
		[
			'id'   => 'btn_size',
			'type' => 'text_small',
			'after' => '</div>',
			'before_field' => '<span class="title-option">Button Size</span>',
		],
	],
]);

// Button video small.
$cmb->add_field([
	'id'         => 'button_video_small',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="video">
								<div class="typography-info">
									<div class="example-btn">
										<span class="title title-js"><i class="ion-ios-play"></i></span>
									</div>
									<div class="typography-info__shot">
									</div>
								</div>
								<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Button Video Small</div>
								<div class="typography-close typography-close-js"></div>
							</div> <span class="line"></span>',
	'repeatable' => false,
	'fields'     => [
		[
			'id'   => 'font_size',
			'type' => 'text_small',
			'before_row' => '<div class="video-btn">',
			'before_field' => '<span class="title-option">Font Size</span>',
		],
		[
			'id'   => 'btn_size',
			'type' => 'text_small',
			'after' => '</div>',
			'before_field' => '<span class="title-option">Button Size</span>',
		],
	],
]);
