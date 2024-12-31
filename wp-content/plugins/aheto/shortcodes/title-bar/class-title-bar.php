<?php
/**
 * The About Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Helper;
use Aheto\Frontend\Breadcrumbs;
use Aheto\Sanitize;
use Aheto\Shortcode;
use Aheto\Params;

defined('ABSPATH') || exit;

/**
 * Title_Bar class.
 */
class Title_Bar extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug           = 'title-bar';
		$this->title          = esc_html__('Title Bar', 'aheto');
		$this->icon           = 'fa fa-indent';
		$this->description    = esc_html__('Add title bar', 'aheto');
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/title-bar/previews/';
		$this->add_layout('layout1', [
			'title' => esc_html__('Default', 'aheto'),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_layout('layout2', [
			'title' => esc_html__('Classic Breadcrumb', 'aheto'),
			'image' => $dir . 'layout2.jpg',
		]);



		$this->add_dependecy('source', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_tag', 'template', ['view', 'layout1']);
		$this->add_dependecy('background', 'template', ['view', 'layout1']);
		$this->add_dependecy('overlay', 'template', ['view', 'layout1']);
		$this->add_dependecy('content_light', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_alignment', 'template', ['view', 'layout1']);
		$this->add_dependecy('height', 'template', ['view', 'layout1']);
		$this->add_dependecy('searchform', 'template', ['view', 'layout1']);
		$this->add_dependecy('content_width', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_title_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_breadcrumbs_typo', 'template', ['layout2']);
		$this->add_dependecy('breadcrumb', 'template', ['view', 'layout1']);
		$this->add_dependecy('breadcrumb_type', 'template', 'layout2');
		$this->add_dependecy('arrows_alignment', 'template', 'layout2');
		$this->add_dependecy('arrows_breadcrumb', 'template', 'layout2');
		$this->add_dependecy('links_color', 'template', 'layout2');
		$this->add_dependecy('arrows_color', 'template', 'layout2');
		$this->add_dependecy('title_bar_paddings', 'template', ['view', 'layout1','layout2']);

		$this->add_dependecy('title_typo', 'template', ['view', 'layout1']);
		$this->add_dependecy('title_typo', 'use_title_typo', 'true');

		$this->add_dependecy('breadcrumbs_typo', 'template', ['layout2']);
		$this->add_dependecy('breadcrumbs_typo', 'use_breadcrumbs_typo', 'true');

		$this->add_dependecy('breadcrumb_align_desktop', 'template', 'layout2');
		$this->add_dependecy('breadcrumb_align_tablet', 'template', 'layout2');
		$this->add_dependecy('breadcrumb_align_mobile', 'template', 'layout2');

		$this->add_dependecy('custom_breadcrumb', 'template', 'layout2');
		$this->add_dependecy('custom_breadcrumb', 'breadcrumb_type', 'custom');

		$this->add_dependecy('crumb_alignment', 'template', ['view', 'layout1']);
		$this->add_dependecy('crumb_alignment', 'breadcrumb', 'true');

		$this->add_dependecy('sf_button', 'template', ['view', 'layout1']);
		$this->add_dependecy('sf_button', 'searchform', 'true');

		$this->add_dependecy('sf_placeholder', 'template', ['view', 'layout1']);
		$this->add_dependecy('sf_placeholder', 'searchform', 'true');

		$this->add_dependecy('title', 'template', ['view', 'layout1']);
		$this->add_dependecy('title', 'source', '');

		$this->register();
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'background'      => [
				'type'    => 'attach_image',
				'heading' => esc_html__('Background', 'aheto'),
				'grid'    => 6,
			],
			'overlay'         => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Overlay Color', 'aheto'),
				'grid'      => 12,
				'selectors' => [
					'{{WRAPPER}} .aheto-titlebar__overlay' => 'background-color: {{VALUE}}',
				],
				'default'   => 'rgba(110,193,228,0.6)'
			],
			'source'      => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Heading source', 'aheto' ),
				'description' => esc_html__( 'Select heading source.', 'aheto' ),
				'options'     => [
					''           => esc_html__( 'Custom heading', 'aheto' ),
					'post_title' => esc_html__( 'Post or Page Title', 'aheto' ),
				],
				'default'    => '',
				'grid'        => 6,
			],
			'title_tag'       => [
				'type'    => 'select',
				'heading' => esc_html__('Title tag', 'aheto'),
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
				'default' => 'h2',
				'grid'    => 6,
			],
			'title'           => [
				'type'    => 'text',
				'heading' => esc_html__('Title', 'aheto'),
				'default' => esc_html__('Heading text', 'aheto'),
			],
			'title_alignment' => [
				'type'    => 'select',
				'heading' => esc_html__('Title Alignment', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
			],
			'use_title_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for title?', 'aheto'),
				'grid'    => 6,
			],
			'breadcrumb'      => [
				'type'    => 'switch',
				'heading' => esc_html__('Breadcrumb', 'aheto'),
				'grid'    => 6,
			],
			'breadcrumb_type'       => [
				'type'    => 'select',
				'heading' => esc_html__('Breadcrumb type', 'aheto'),
				'options' => [
					'default'  => 'Default',
					'custom'  => 'Custom',
				],
				'default' => 'default',
				'grid'    => 6,
			],
			'breadcrumb_align_desktop'       => [
				'type'    => 'select',
				'heading' => esc_html__('Breadcrumb Alignment (desktop)', 'aheto'),
				'options' => [
					'left'  => 'Left',
					'right'  => 'Right',
					'center'  => 'Center',
				],
				'default' => 'left',
				'grid'    => 6,
			],
			'breadcrumb_align_tablet'       => [
				'type'    => 'select',
				'heading' => esc_html__('Breadcrumb Alignment (tablet)', 'aheto'),
				'options' => [
					'left'  => 'Left',
					'right'  => 'Right',
					'center'  => 'Center',
				],
				'default' => 'left',
				'grid'    => 6,
			],
			'breadcrumb_align_mobile'       => [
				'type'    => 'select',
				'heading' => esc_html__('Breadcrumb Alignment (mobile)', 'aheto'),
				'options' => [
					'left'  => 'Left',
					'right'  => 'Right',
					'center'  => 'Center',
				],
				'default' => 'left',
				'grid'    => 6,
			],
			'arrows_alignment'       => [
				'type'    => 'select',
				'heading' => esc_html__('Arrows Alignment', 'aheto'),
				'options' => [
					'right'  => 'Right',
					'left'  => 'Left',
				],
				'default' => 'right',
				'grid'    => 6,
			],
			'arrows_breadcrumb'      => [
				'type'    => 'switch',
				'heading' => esc_html__('Add arrows for first breadcrumb item', 'aheto'),
				'grid'    => 6,
			],
			'links_color'         => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Links Color', 'aheto'),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aht-breadcrumbs__item a' => 'color: {{VALUE}}!important',
				],
			],
			'arrows_color'         => [
				'type'      => 'colorpicker',
				'heading'   => esc_html__('Arrows Color', 'aheto'),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aht-breadcrumbs__item:before' => 'color: {{VALUE}}!important',
				],
			],
			'custom_breadcrumb' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Breadcrumb', 'aheto' ),
				'params'  => [
					'link_title'           => [
						'type'    => 'text',
						'heading' => esc_html__('Breadcrumb Title', 'aheto'),
						'default' => esc_html__('Breadcrumb title', 'aheto'),
						'description' => esc_html__( 'Add title to breadcrumb.', 'aheto' ),
					],
					'link_url' => [
						'type'        => 'link',
						'heading'     => esc_html__( 'Breadcrumb URL', 'aheto' ),
						'description' => esc_html__( 'Add url to breadcrumb.', 'aheto' ),
						'default'     => [
							'url' => '#',
						],
					],
					'current_item'      => [
						'type'    => 'switch',
						'heading' => esc_html__( 'Check as current page?', 'aheto' ),
					],
				],
			],
			'crumb_alignment' => [
				'type'    => 'select',
				'heading' => esc_html__('Breadcrumb Alignment', 'aheto'),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
			],
			'searchform'      => [
				'type'    => 'switch',
				'heading' => esc_html__('Search Form', 'aheto'),
				'grid'    => 6,
			],
			'sf_placeholder'  => [
				'type'    => 'text',
				'heading' => esc_html__('Input Placeholder', 'aheto'),
				'default' => 'Keyword Search...',
				'grid'    => 6,
			],
			'sf_button'       => [
				'type'    => 'text',
				'heading' => esc_html__('Button Text', 'aheto'),
				'value'   => 'Search',
				'default' => 'SEARCH',
				'grid'    => 6,
			],
			'content_width' => [
				'type'      => 'slider',
				'heading'   => esc_html__('Content Max Width', 'aheto'),
				'grid'      => 4,
				'range'     => [
					'px' => [
						'min'  => 600,
						'max'  => 1200,
						'step' => 5,
					],
				],
				'group'     => esc_html__('Content Settings', 'aheto'),
				'selectors' => [
					'{{WRAPPER}} .aheto-titlebar__main' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
			],
			'height'        => [
				'type'      => 'slider',
				'heading'   => esc_html__('Title Bar Min Height', 'aheto'),
				'grid'      => 4,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 2000,
						'step' => 5,
					],
				],
				'group'     => esc_html__('Content Settings', 'aheto'),
				'selectors' => [
					'{{WRAPPER}} .aheto-titlebar' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			],
			'content_light' => [
				'type'    => 'switch',
				'heading' => esc_html__('Content light', 'aheto'),
				'grid'    => 4,
				'group'   => esc_html__('Content Settings', 'aheto'),
			],
			'title_bar_paddings'    => [
				'type'      => 'responsive_spacing',
				'heading'   => esc_html__( 'Title bar padding', 'aheto' ),
				'group'   => esc_html__('Content Settings', 'aheto'),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-titlebar, {{WRAPPER}} .aht-breadcrumbs--only' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			],
		];

		Params::add_image_sizer_params($this, [
			'dependency' => ['template', ['view', 'layout1']]
		]);

		Params::add_button_params($this, [
			'add_button' => false,
			'link'       => false,
			'prefix'     => 'sf_',
			'layouts'    => 'layout1',
			'dependency' => ['searchform', 'true']
		]);

		$this->add_params([
			'title_typo' => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-titlebar__title',
			],
			'use_breadcrumbs_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for breadcrumbs?', 'aheto'),
				'grid'    => 6,
			],
			'breadcrumbs_typo' => [
				'type'     => 'typography',
				'group'    => 'Breadcrumbs Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aht-breadcrumbs__item',
			],
			'advanced'   => true,
		]);
	}

	/**
	 * Get heading.
	 *
	 * @return string
	 */
	public function get_heading() {
		$source = $this->atts['source'];
		if ( 'post_title' === $source ) {
			return get_the_title();
		}

		return wp_kses_post( $this->atts['title'] );
	}


	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( !empty($this->atts['overlay']) ) {
			$selector = '%1$s .aheto-titlebar__overlay';
			$overlay  = Sanitize::color($this->atts['overlay']);

			$css['global'][$selector]['background-color'] = $overlay;
		}

		if ( !empty($this->atts['links_color']) ) {
			$selector = '%1$s .aht-breadcrumbs__link';
			$overlay  = Sanitize::color($this->atts['links_color']);

			$css['global'][$selector]['color'] = $overlay;
		}

		if ( !empty($this->atts['height']) ) {
			$height = Sanitize::size($this->atts['height']);

			$css['global']['%1$s']['min-height'] = $height;
		}

		if ( !empty($this->atts['content_width']) ) {
			$content_width = $this->atts['content_width'];
			$content_width = $content_width > 1200 ? 1200 : $content_width;
			$content_width = $content_width < 600 ? 600 : $content_width;

			$width = Sanitize::size($content_width);

			$css['global']['%1$s .container']['max-width'] = $width . '!important';
		}

		if ( !empty($this->atts['title_bar_paddings']) ) {

			$selector                   = '%1$s';
			$this->atts['title_bar_paddings'] = Sanitize::responsive_spacing($this->atts['title_bar_paddings'], 'padding');

			if ( !empty($this->atts['title_bar_paddings']['desktop']) ) {
				\aheto_add_props($css['global'][$selector], $this->atts['title_bar_paddings']['desktop']);
			}

			if ( !empty($this->atts['title_bar_paddings']['laptop']) ) {
				\aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['title_bar_paddings']['laptop']);
			}

			if ( !empty($this->atts['title_bar_paddings']['tablet']) ) {
				\aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['title_bar_paddings']['tablet']);
			}

			if ( !empty($this->atts['title_bar_paddings']['mobile']) ) {
				\aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['title_bar_paddings']['mobile']);
			}
		}

		if ( !empty($this->atts['use_title_typo']) && !empty($this->atts['title_typo']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-titlebar__title'], $this->parse_typography($this->atts['title_typo']));
		}


		return apply_filters( "aheto_title_bar_dynamic_css", $css, $this );
	}
}
