<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_pricing-tables_register', 'snapster_pricing_tables_layout8' );


/**
 * Pricing Tables Shortcode
 */

function snapster_pricing_tables_layout8( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'snapster_layout8', [
		'title' => esc_html__( 'Snapster Contact form (modern)', 'snapster' ),
		'image' => $preview_dir . 'snapster_layout8.jpg',
	] );

	$shortcode->add_dependecy( 'snapster_cf_mail', 'template', 'snapster_layout8' );
	$shortcode->add_dependecy( 'snapster_cf_placeholder', 'template', 'snapster_layout8' );
	$shortcode->add_dependecy( 'snapster_cf_term', 'template', 'snapster_layout8' );
	$shortcode->add_dependecy( 'snapster_cf_enable_light', 'template', 'snapster_layout8' );
	$shortcode->add_dependecy( 'snapster_cf_submit', 'template', 'snapster_layout8' );
	$shortcode->add_dependecy( 'snapster_cf_pdf', 'template', 'snapster_layout8' );


	$shortcode->add_params( [
		'snapster_cf_mail'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Send message to (your email)', 'snapster' ),
			'default' => '',
		],
		'snapster_cf_placeholder'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Placeholder for field message in form', 'snapster' ),
			'default' => '',
		],
		'snapster_cf_submit'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for submit button in form', 'snapster' ),
			'default' => '',
		],
		'snapster_cf_term'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Term link', 'snapster' ),
			'description' => esc_html__( 'Please add your Term link', 'snapster' ),
			'default' => '',
		],
		'snapster_cf_pdf'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for download PDF button', 'snapster' ),
			'default' => '',
		],
		'snapster_cf_enable_light'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable light style?', 'snapster'),
			'grid'    => 3,
		],

	] );


	\Aheto\Params::add_button_params($shortcode, array(
		'add_button' => false,
		'link'       => false,
		'prefix'     => 'snapster_cf_modern_',
		'layouts'    => 'layout1',
		'dependency' => ['template', ['snapster_layout8']]
	));



}


add_filter( 'aheto_pricing_tables_dynamic_css', 'snapster_pricing_tables_layout8_dynamic_css', 10, 2 );

add_action( 'wp_ajax_aheto_pricing_tables', 'snapster_pricing_tables_layout8_ajax_send_mail');
add_action( 'wp_ajax_nopriv_aheto_pricing_tables', 'snapster_pricing_tables_layout8_ajax_send_mail' );

function snapster_pricing_tables_layout8_ajax_send_mail() {

	parse_str( $_POST['form'], $params );

	$mail_to = isset($_POST['mail_to']) ? sanitize_email( $_POST['mail_to'] ) : '';
	$placeholder = isset($_POST['placeholder']) ? sanitize_text_field( $_POST['placeholder'] ) : '';
	$email = isset($params['snapster_email']) ? sanitize_email( $params['snapster_email'] ) : '';
	$name = isset($params['snapster_name']) ? sanitize_text_field( $params['snapster_name'] ) : '';
	$date = isset( $params['snapster_date']) ? sanitize_text_field( $params['snapster_date'] ) : '';
	$location = isset( $params['snapster_location']) ? sanitize_text_field( $params['snapster_location'] ) : '';
	$message_text = isset( $params['snapster_message']) ? sanitize_text_field( $params['snapster_message'] ) : '';
	$price = isset($_POST['price']) ? sanitize_text_field( $_POST['price'] ) : '';
	$subject = esc_html__('Message from ', 'snapster') . get_bloginfo();
	$res_pdf = '';

	if(isset($_POST['packages']) && !empty($_POST['packages'])){

		$packages = explode('&', $_POST['packages']);
		$res_pdf = snapster_pricing_tables_layout8_render_pdf( $params, $packages, $price, $placeholder );
	}

	$message = esc_html__('Name: ', 'snapster') . $name . "\r\n";
	$message .= esc_html__('Email: ', 'snapster') . $email . "\r\n";

	if(!empty($date)){
		$message .= esc_html__('Date: ', 'snapster') . $date . "\r\n";
	}
	if(!empty($location)){
		$message .= esc_html__('Location: ', 'snapster') . $location . "\r\n";
	}
	if(!empty($message_text)) {
		$message .= esc_html__( 'Message: ', 'snapster' ) . $message_text . "\r\n";
	}
	$message .= esc_html__('Total Price: ', 'snapster') . $price . "\r\n";
	$message .= esc_html__('Price list: ', 'snapster') . $res_pdf . "\r\n";

	$headers[] = 'Content-Type: text/html; charset=utf-8; \n\r From: '. get_bloginfo() .'\n\r';
	$send_message = mail( $mail_to, $subject, $message, $headers );


	if ( $send_message ) {
		wp_send_json( $res_pdf );
	} else {
		wp_send_json( 'error');
	}

}


function snapster_pricing_tables_layout8_render_pdf( $params = array(), $packages = array(), $price = '', $placeholder = '' ) {

	$upload_dir = wp_upload_dir();
	$time = time();
	$file = "{$upload_dir['path']}/price_list-{$time}.pdf";

	ob_start();
	require_once aheto()->plugin_url() . 'shortcodes/pricing-tables/pdf-template/pricelist-pdf.php';
	$pdfHtml = ob_get_clean();


	$domPdf = new \Dompdf\Dompdf( array(
		'isRemoteEnabled' => true,
		'isHtml5ParserEnabled' => true,
	) );

	$domPdf->loadHtml( $pdfHtml );
	$domPdf->render();
	if ( file_put_contents( $file, $domPdf->output() ) ) {
		$file_url = "{$upload_dir['url']}/price_list-{$time}.pdf";
		return $file_url;
	}
	return false;

}