<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'karma_dark_portfolio_social_networks_layout1');

/**
 * Social Networks
 */

function karma_dark_portfolio_social_networks_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout('karma_dark_portfolio_layout1', [
		'title' => esc_html__('Passiflora Simple', 'karma_dark_portfolio'),
		'image' => $preview_dir . 'karma_dark_portfolio_layout1.jpg',
	]);
	aheto_demos_add_dependency('networks', ['karma_dark_portfolio_layout1'], $shortcode);


	$shortcode->add_dependecy('karma_dark_portfolio_link_color', 'template', 'karma_dark_portfolio_layout1');
	$shortcode->add_dependecy('karma_dark_portfolio_link_border', 'template', 'karma_dark_portfolio_layout1');
	$shortcode->add_dependecy('karma_dark_portfolio_link_hover_overlay', 'template', 'karma_dark_portfolio_layout1');
	$shortcode->add_dependecy('karma_dark_portfolio_link_size', 'template', 'karma_dark_portfolio_layout1');
	$shortcode->add_dependecy('karma_dark_portfolio_link_hover_color', 'template', 'karma_dark_portfolio_layout1');
	$shortcode->add_dependecy('karma_dark_portfolio_paddings', 'template', 'karma_dark_portfolio_layout1');
	
	
	$shortcode->add_params([
		'karma_dark_portfolio_link_color' => [
			'type'      => 'colorpicker',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Color link', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-socials__link' => 'color: {{VALUE}}' ],
		],
		'karma_dark_portfolio_link_hover_color' => [
			'type'      => 'colorpicker',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Color link on hover', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-socials__link:hover' => 'color: {{VALUE}}' ],
		],
		'karma_dark_portfolio_link_border' => [
			'type'      => 'colorpicker',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Border color link', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-socials__link' => 'border-color: {{VALUE}}' ],
		],
		'karma_dark_portfolio_link_hover_overlay' => [
			'type'      => 'colorpicker',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Overlay link on hover', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-socials__link:hover' => 'background: {{VALUE}}' ],
		],
		'karma_dark_portfolio_link_size'     => [
			'type'      => 'text',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Link font-size', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-socials__link i' => 'font-size: {{VALUE}}px' ],
			'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
		],
		'karma_dark_portfolio_link_paddings'    => [
			'type'      => 'responsive_spacing',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Link padding', 'karma' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-socials__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'karma_dark_portfolio_link_margins'    => [
			'type'      => 'responsive_spacing',
			'group' => 'Link Typography',
			'heading'   => esc_html__( 'Link margin', 'karma' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-socials__link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
	]);
}
function karma_dark_portfolio_social_networks_layout1_dynamic_css($css, $shortcode) {
	if ( isset( $shortcode->atts['karma_dark_portfolio_link_color'] ) && !empty($shortcode->atts['karma_dark_portfolio_link_color'] ) ) {
		$css['global']['%1$s .aheto-socials__link:hover']['color'] = \Aheto\Sanitize::color( $shortcode->atts['karma_dark_portfolio_link_color'] );
	}
	if ( isset( $shortcode->atts['karma_dark_portfolio_link_hover_color'] ) && !empty($shortcode->atts['karma_dark_portfolio_link_hover_color'] ) ) {
		$css['global']['%1$s .aheto-socials__link:hover']['color'] = \Aheto\Sanitize::color( $shortcode->atts['karma_dark_portfolio_link_hover_color'] );
	}
	if ( isset( $shortcode->atts['karma_dark_portfolio_link_border'] ) && !empty($shortcode->atts['karma_dark_portfolio_link_border'] ) ) {
		$css['global']['%1$s .aheto-socials__link:hover']['background'] = \Aheto\Sanitize::color( $shortcode->atts['karma_dark_portfolio_link_border'] );
	}
	if ( isset( $shortcode->atts['karma_dark_portfolio_link_hover_color'] ) && !empty($shortcode->atts['karma_dark_portfolio_link_hover_color'] ) ) {
		$css['global']['%1$s .aheto-socials__link:hover']['background'] = \Aheto\Sanitize::color( $shortcode->atts['karma_dark_portfolio_link_hover_color'] );
	}
	if ( ! empty( $this->atts['karma_dark_portfolio_link_size'] ) ) {
		$css['global']['%1$s .aheto-socials__link i']['font-size'] = Sanitize::size( $this->atts['karma_dark_portfolio_link_size'] );
	}
	return $css;
}
add_filter('aheto_social_networks_dynamic_css', 'karma_dark_portfolio_social_networks_layout1_dynamic_css', 10, 2);
