<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'mooseoom_contacts_layout1');



/**
 * Contacts
 */

function mooseoom_contacts_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Contacts 9', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'mooseoom_layout1'], $shortcode );

	$shortcode->add_dependecy('mooseoom_light_version', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_contacts_group', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_use_content_typo', 'template',  'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_content_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_content_typo', 'mooseoom_use_content_typo', 'true');

	$shortcode->add_params([

		'mooseoom_contacts_group' => [
			'type'    => 'group',
			'heading' => esc_html__('Mooseoom Contacts', 'mooseoom'),
			'params'  => [
				'mooseoom_heading_tag' => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Heading', 'mooseoom'),
					'options' => [
						'h1'  => 'h1',
						'h2'  => 'h2',
						'h3'  => 'h3',
						'h4'  => 'h4',
						'h5'  => 'h5',
						'h6'  => 'h6',
						'p'   => 'p',
						'div' => 'div',
					],
					'default' => 'h4',
					'grid'    => 5,
				],
				'mooseoom_heading' => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'mooseoom'),
				],
				'mooseoom_address' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Address', 'mooseoom'),
				],
				'mooseoom_phone'   => [
					'type'    => 'text',
					'heading' => esc_html__('Phone', 'mooseoom'),
				],

				'mooseoom_email' => [
					'type'    => 'text',
					'heading' => esc_html__('Email', 'mooseoom'),
				],
			]
		],
		'mooseoom_use_content_typo'    => [
			'type'      => 'switch',
			'heading'   => esc_html__('Use contents content typography?', 'mooseoom'),
			'grid'      => 4,
		],
		'mooseoom_content_typo' => [
			'type'     => 'typography',
			'group'    => 'Contacts content Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contact p,{{WRAPPER}} .aheto-contact__mail,{{WRAPPER}} .aheto-contact__tel,{{WRAPPER}} .aheto-contact__info',
		],
	
	]);
	\Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add address icon?', 'mooseoom'),
        'prefix' => 'mooseoom_address_',
        'exclude' => ['align', 'color'],
        'dependency' => ['template', 'mooseoom_layout1']
    ]);
	\Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add phone icon?', 'mooseoom'),
        'prefix' => 'mooseoom_phone_',
        'exclude' => ['align', 'color'],
        'dependency' => ['template', 'mooseoom_layout1']
    ]);
	\Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add email icon?', 'mooseoom'),
        'prefix' => 'mooseoom_email_',
        'exclude' => ['align', 'color'],
        'dependency' => ['template', 'mooseoom_layout1']
    ]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'mooseoom_contacts_',
		'include'        => [ 'arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_size' ],
		'dependency'     => ['template', ['mooseoom_layout1']]
	]);
}

function mooseoom_contacts_layout1_dynamic_css($css, $shortcode)
{
	if ( !empty($shortcode->atts['mooseoom_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['mooseoom_arrows_size'] );
    }

	if (!empty($shortcode->atts['mooseoom_use_content_typo']) && !empty($shortcode->atts['mooseoom_content_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-contact p'], $shortcode->parse_typography($shortcode->atts['mooseoom_content_typo']));
		\aheto_add_props($css['global']['%1$s .aheto-contact__mail'], $shortcode->parse_typography($shortcode->atts['mooseoom_content_typo']));
		\aheto_add_props($css['global']['%1$s .aheto-contact__tel'], $shortcode->parse_typography($shortcode->atts['mooseoom_content_typo']));
		\aheto_add_props($css['global']['%1$s .aheto-contact__info'], $shortcode->parse_typography($shortcode->atts['mooseoom_content_typo']));
	}
	return $css;
}

add_filter('aheto_contacts_dynamic_css', 'mooseoom_contacts_layout1_dynamic_css', 10, 2);
