<?php
/**
 * Typography settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */


$font_fields = [
	'font-size'      => false,
	'font-weight'    => false,
	'color'          => false,
	'color_hover'    => false,
	'text-align'     => false,
	'text-transform' => false,
	'line-height'    => false,
	'letter-spacing' => false,
	'word-spacing'   => false,
	'margin-top'     => false,
	'margin-bottom'  => false,
];

$heading_fields = [
	'font-family'    => true,
	'font-weight'    => true,
	'color'          => true,
	'color_hover'    => false,
	'text-align'     => true,
	'text-transform' => true,
	'word-spacing'   => true,
	'margin-top'     => true,
	'margin-bottom'  => true,
];

$cmb->add_field([
	'id'     => 'primary_font',
	'type'   => 'typography',
	'name'   => esc_html__( 'Primary Font', 'aheto' ),
	'desc'   => esc_html__( 'Please, select Primary Font Family.', 'aheto' ),
	'fields' => $font_fields,
]);

$cmb->add_field([
	'id'     => 'secondary_font',
	'type'   => 'typography',
	'name'   => esc_html__( 'Secondary Font', 'aheto' ),
	'desc'   => esc_html__( 'Please, select Secondary Font Family.', 'aheto' ),
	'fields' => $font_fields,
]);

$cmb->add_field([
	'id'     => 'tertiary_font',
	'type'   => 'typography',
	'name'   => esc_html__( 'Tertiary Font', 'aheto' ),
	'desc'   => esc_html__( 'Please, select Tertiary Font Family.', 'aheto' ),
	'fields' => $font_fields,
]);


$cmb->add_field([
	'id'         => 'heading_responsive',
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
	'id'         => 'anchor',
	'type'       => 'title',
	'name'   => __( '<div class="typography-anchor">
						<a class="js-filter active" data-filter="all">All</a>
						<a class="js-filter" data-filter="headlines">Headlines</a>
						<a class="js-filter" data-filter="paragraphs">Paragraphs</a>
						<a class="js-filter" data-filter="links">Links</a>
						<a class="js-filter" data-filter="widgets">Widgets</a>
						<a class="js-filter" data-filter="blockquote">Blockquote</a>

					</div> ', 'aheto' ),
]);

$cmb->add_field([
	'id'     => 'headings',
	'type'   => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable"  data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">

				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading</div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields' => [
		'font-family'    => true,
		'font-weight'    => true,
		'color'          => true,
		'text-transform' => true,
		'text-align'     => false,
		'word-spacing'   => false,
		'margin-top'     => false,
		'margin-bottom'  => false,
		'letter-spacing' => false,
		'line-height'    => false,
		'font-size'      => false,
		'color_hover'    => false,
	],
]);

$cmb->add_field([
	'id'         => 'heading1',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading 1</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 1</div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading2',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines"> ',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
					<span class="example example-js">Aa</span>
					<div class="typography-info">
						<span class="title title-js">Heading 2</span>
						<div class="typography-info__shot">
							<span class="font-weight"></span>
						</div>
					</div>
					<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 2</div>
				</div>
				<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading3',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading 3</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 3</div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading4',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading 4</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 4 </div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading5',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading 5</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 5</div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);

$cmb->add_field([
	'id'         => 'heading6',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="headlines">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
				<span class="example example-js">Aa</span>
				<div class="typography-info">
					<span class="title title-js">Heading 6</span>
					<div class="typography-info__shot">
						<span class="font-weight"></span>
					</div>
				</div>
				<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Heading 6</div>
			</div>
			<span class="line"></span>
			<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields'     => $heading_fields,
	'responsive' => true,
]);


$cmb->add_field([
	'id'         => 'text_font',
	'type'       => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="paragraphs">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
			<span class="example example-js">Aa</span>
			<div class="typography-info">
				<span class="title title-js">Paragraph: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</span>
				<div class="typography-info__shot">
					<span class="font-weight"></span>
				</div>
			</div>
			<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Paragraphs </div>
		</div>
		<span class="line"></span>
		<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields' => [
		'text-align'     => false,
		'text-transform' => false,
		'word-spacing'   => false,
		'margin-top'     => false,
		'margin-bottom'  => false,
		'color_hover'    => false,
	],
]);

$cmb->add_field([
	'id'     => 'links',
	'type'   => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="links">',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
			<span class="example example-js">Aa</span>
			<div class="typography-info">
				<span class="title title-js">Link</span>
				<div class="typography-info__shot">
					<span class="font-weight"></span>
				</div>
			</div>
			<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Links</div>
		</div>
		<span class="line"></span>
		<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'fields' => [
		'font-family'    => true,
		'font-size'      => true,
		'font-weight'    => true,
		'color'          => true,
		'text-align'     => false,
		'text-transform' => true,
		'line-height'    => false,
		'letter-spacing' => true,
		'word-spacing'   => false,
		'margin-top'     => false,
		'margin-bottom'  => false,
	],
]);

$cmb->add_field([
	'id'      => 'widget_title',
	'type'    => 'typography',
	'before_row'   => '<div class="setting-panel-headings__item js-filterable" data-filter="widgets"> ',
	'after_row'   => '</div>',
	'before' => '<div class="cmb-type-typography__heading">
			<span class="example example-js">Aa</span>
			<div class="typography-info">
				<span class="title title-js">Widget Title</span>
				<div class="typography-info__shot">
					<span class="font-weight"></span>
				</div>
			</div>
			<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Widget</div>
		</div>
		<span class="line"></span>
		<div class="cmb-type-typography__content"> <div class="typography-close typography-close-js"></div>',
	'after'  => '</div>',
	'classes' => 'second-line',
	'fields'  => [
		'text-align'   => false,
		'word-spacing' => false,
		'color_hover'    => false,
	],
]);

$fields = [
	[
		'id'     => 'quote',
		'type'   => 'typography',
		'before' => '<div class="typography-close typography-close-js"></div><span class="block-title">Blockquote</span>',
		'fields' => [
			'color_hover'    => false,
			'font-size'      => false,
			'text-align'     => false,
			'text-transform' => false,
			'line-height'    => false,
			'word-spacing'   => false,
			'margin-top'     => false,
			'margin-bottom'  => false,
		],
	],
	[
		'id'     => 'author',
		'type'   => 'typography',
		'before' => '<span class="block-title">Author</span>',
		'fields' => [
			'color_hover'    => false,
			'text-align'     => false,
			'word-spacing'   => false,
			'margin-bottom'  => false,
		],
	]
];

$cmb->add_field([
	'id'         => 'quoutes',
	'type'       => 'group',
	'before_group_row' => '	<div class="cmb-type-typography__block js-filterable" data-filter="blockquote">
							<div class="typography-info">
								<span class="example example-js">Aa</span>
								<div class="example-blockquote">
									<p class="quote">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
									   sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat
									   volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper
									   suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                    <cite class="author">Lorem Ipsum</cite>
                                    <div class="typography-info__shot quote">
										<span class="title">Quoutes:</span>
									</div>
									<div class="typography-info__shot author">
										<span class="title">Author:</span>
									</div>
								</div>

							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Blockquote</div>
						</div> <span class="line"></span>',
	'repeatable' => false,
	'fields'     => $fields,
]);

$fields_bg = $fields;

array_push($fields_bg, [
	'id'   => 'qoute_bg',
	'type' => 'colorpicker',
	'name' => esc_html__( 'Blockquote Background', 'aheto' ),
	'attributes' => array(
		'data-colorpicker' => json_encode( array(
			'palettes' => $set_colors,
		) ),
	)
]);

$cmb->add_field([
	'id'         => 'quoutes_bg',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="blockquote">
							<div class="typography-info">
								<span class="example example-js">Aa</span>
								<div class="example-blockquote">
									<p class="quote">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
									   sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat
									   volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper
									   suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                    <cite class="author">Lorem Ipsum</cite>
                                    <div class="typography-info__shot quote">
										<span class="title">Quoutes:</span>
									</div>
									<div class="typography-info__shot author">
										<span class="title">Author:</span>
									</div>
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Blockquote</div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => $fields_bg,
]);

$fields_border = $fields;

array_push($fields_border, [
	'id'   => 'qoute_border',
	'type' => 'colorpicker',
	'name' => esc_html__( 'Border Color', 'aheto' ),
	'attributes' => array(
		'data-colorpicker' => json_encode( array(
			'palettes' => $set_colors,
		) ),
	)
]);

$cmb->add_field([
	'id'         => 'quoutes_border',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="blockquote">
							<div class="typography-info">
								<span class="example example-js">Aa</span>
								<div class="example-blockquote">
									<p class="quote">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
									   sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat
									   volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper
									   suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                    <cite class="author">Lorem Ipsum</cite>
                                    <div class="typography-info__shot quote">
										<span class="title">Quoutes:</span>
									</div>
									<div class="typography-info__shot author">
										<span class="title">Author:</span>
									</div>
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Blockquote</div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => $fields_border,
]);

$fields_line = $fields;

array_push($fields_line, [
	'id'   => 'qoute_line',
	'type' => 'colorpicker',

	'name' => esc_html__( 'Line Color', 'aheto' ),
	'attributes' => array(
		'data-colorpicker' => json_encode( array(
			'palettes' => $set_colors,
		) ),
	)
]);

$cmb->add_field([
	'id'         => 'quoutes_line',
	'type'       => 'group',
	'before_group_row' => '<div class="cmb-type-typography__block js-filterable" data-filter="blockquote">
							<div class="typography-info">
								<span class="example example-js">Aa</span>
								<div class="example-blockquote">
									<p class="quote">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
									   sed diem nonummy nibh euismod tincidunt ut lacreet dolore magna aliguam erat
									   volutpat. Ut wisis enim ad minim veniam, quis nostrud exerci tution ullamcorper
									   suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                    <cite class="author">Lorem Ipsum</cite>
                                    <div class="typography-info__shot quote">
										<span class="title">Quoutes:</span>
									</div>
									<div class="typography-info__shot author">
										<span class="title">Author:</span>
									</div>
								</div>
							</div>
							<div class="typography-open typography-open-js"><i class="icon ion-compose"></i> Edit Blockquote</div>
						</div><span class="line"></span>',
	'repeatable' => false,
	'fields'     => $fields_line,
]);
