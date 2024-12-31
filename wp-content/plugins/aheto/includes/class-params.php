<?php
/**
 * The parameters bank.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

defined( 'ABSPATH' ) || exit;

/**
 * Params class.
 */
class Params {

	/**
	 * Params storage.
	 *
	 * @var array
	 */
	private static $storage = [];

	/**
	 * Get param from storage
	 *
	 * @param  string $id Id to get param from bank.
	 * @param  array $current Params to override.
	 *
	 * @return array
	 */
	public static function get_param( $id, $current ) {
		$id = sanitize_key( $id );

		if ( ! isset( self::$storage[ $id ] ) ) {
			/* translators: ID of param. */
			_doing_it_wrong( 'get_param', wp_kses_post( sprintf( __( 'ID: <strong>%s</strong>, didn\'t exists in the system', 'aheto' ), $id ) ), null );

			return false;
		}

		$current = array_merge( self::$storage[ $id ], $current );
		unset( $current['id'] );

		return $current;
	}

	/**
	 * Prepare to add in pre-added shortcodes.
	 *
	 * @param  string $id Id to get param from bank.
	 * @param  array $args Params to override.
	 *
	 * @return array
	 */
	public static function get_prepared_param( $id, $args = [] ) {
		$shortcode = new \Aheto\Shortcode;

		// Get param.
		$params = [];
		if ( 'icon' !== $id ) {
			$params = self::get_param( $id, [] );
			unset( $params['is_group'] );
			unset( $params['element_id'] );
			unset( $params['css_classes'] );
		} else {
			self::add_icon_params( $shortcode, $args );
			$params = $shortcode->params;
		}

		return $shortcode->prepare_params( $params );
	}

	/**
	 * Add params into storage
	 *
	 * @param  array $params Array of multiple-params.
	 */
	public static function add_params( $params, $group = '' ) {
		// Early Bail!
		if ( empty( $params ) ) {
			return;
		}

		foreach ( $params as $id => $param ) {
			self::add_param( $id, $param, $group );
		}
	}

	/**
	 * Add param into storage
	 *
	 * @param  string $id Id to add param into bank.
	 * @param  array $param Array of params.
	 */
	public static function add_param( $id, $param ) {
		$id = sanitize_key( $id );

		if ( isset( self::$storage[ $id ] ) ) {
			/* translators: ID of param. */
			_doing_it_wrong( 'add_param', wp_kses_post( sprintf( __( 'ID: <strong>%s</strong>, already exists in the system', 'aheto' ), $id ) ), null );
		}

		self::$storage[ $id ] = $param;
	}

	/**
	 * Remove param from storage
	 *
	 * @param  string $id Id to remove param from bank.
	 */
	public static function remove_param( $id ) {
		$id = sanitize_key( $id );

		if ( ! isset( self::$storage[ $id ] ) ) {
			/* translators: ID of param. */
			_doing_it_wrong( 'remove_param', wp_kses_post( sprintf( __( 'ID: <strong>%s</strong>, didn\'t exists in the system', 'aheto' ), $id ) ), null );
		}

		unset( self::$storage[ $id ] );
	}

	/**
	 * Init storage
	 */
	public static function init() {

		$params = [
			'css' => [
				'type'    => 'css_editor',
				'heading' => esc_html__( 'CSS box', 'aheto' ),
				'group'   => esc_html__( 'Design Options', 'aheto' ),
			],

			'title' => [
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'aheto' ),
				'admin_label' => true,
			],

			'limit' => [
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Limit', 'aheto' ),
				'admin_label' => true,
			],

			'networks' => [
				'type'    => 'group',
				'heading' => esc_html__( 'Networks', 'aheto' ),
				'params'  => [
					'network' => [
						'type'    => 'select',
						'heading' => esc_html__( 'Network', 'aheto' ),
						'options' => Helper::choices_social_network(),
					],
					'url'     => [
						'type'    => 'text',
						'heading' => esc_html__( 'Url', 'aheto' ),
					],
				],
			],
			'align'    => [
				'type'    => 'select',
				'heading' => esc_html__( 'Align', 'aheto' ),
				'options' => Helper::choices_alignment(),
				'description' => esc_html__( 'It works only when custom font option for align is off', 'aheto' ),
			],

			'scheme' => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Scheme', 'aheto' ),
				'description' => esc_html__( 'Select title scheme', 'aheto' ),
				'options'     => [
					''        => esc_html__( 'Default', 'aheto' ),
					'inverse' => esc_html__( 'Inverse', 'aheto' ),
				],
			],
		];

		self::add_params( $params );
		self::add_button_shortcode_params();
		self::add_advanced_params();
	}

	/**
	 * Add button params.
	 */
	private static function add_button_shortcode_params() {
		$button  = [ 'is_group' => true ];
		$builder = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';

		// Button.
		if ( 'elementor' === $builder ) {
			$button['title'] = [
				'type'        => 'text',
				'heading'     => esc_html__( 'Link Text', 'aheto' ),
				'description' => esc_html__( 'Add link to button.', 'aheto' ),
				'default'     => esc_html__( 'Click Me', 'aheto' ),
			];
		}

		$button['url'] = [
			'type'        => 'link',
			'heading'     => esc_html__( 'Link', 'aheto' ),
			'description' => esc_html__( 'Add url to button.', 'aheto' ),
			'placeholder' => __( 'https://your-link.com', 'aheto' ),
			'default'     => [
				'url' => '#',
			],
		];

		self::add_param( 'button', $button );
	}

	/**
	 * Add carousel params.
	 */
	public static function add_carousel_params( $shortcode, $args = [] ) {
		$args = wp_parse_args( $args, [
			'custom_options' => false,
			'add_label'      => esc_html__( 'Change slider options?', 'aheto' ),
			'group'          => esc_html__( 'Slider Options', 'aheto' ),
			'include'        => [],
			'prefix'         => '',
			'dependency'     => false,
		] );

		extract( $args );

		$all_params = [];

		if ( $custom_options ) {
			$shortcode->add_param( $prefix . 'custom_options', [
				'type'    => 'switch',
				'heading' => $add_label,
				'group'   => $group,
				'default' => false,
			] );
			if ( $dependency ) {
				$shortcode->add_dependecy( $prefix . 'custom_options', $dependency[0], $dependency[1] );
			}
		}

		// arrow field.
		if ( in_array( 'arrows', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Arrows', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'arrows';
		}

		// arrows_color.
		if ( in_array( 'arrows_color', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows_color', [
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Arrows color', 'aheto' ),
				'description' => esc_html__( 'Select arrows color.', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors' => [ '{{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}}',
				                 '{{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}}'],
			] );

			$shortcode->add_dependecy( $prefix . 'arrows_color', $prefix . 'arrows', 'true' );

			$all_params[] = 'arrows_color';
		}


		// arrows hover color.
		if ( in_array( 'arrows_hover_color', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows_hover_color', [
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Arrows hover color', 'aheto' ),
				'description' => esc_html__( 'Select arrows hover color.', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors' => [ '{{WRAPPER}} .swiper-button-next:hover' => 'color: {{VALUE}}',
				                 '{{WRAPPER}} .swiper-button-prev:hover' => 'color: {{VALUE}}'],
			] );

			$shortcode->add_dependecy( $prefix . 'arrows_hover_color', $prefix . 'arrows', 'true' );

			$all_params[] = 'arrows_hover_color';
		}


		// arrows_size
		if ( in_array( 'arrows_size', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows_size', [
				'type'    => 'text',
				'heading' => esc_html__('Arrows font size', 'aheto'),
				'description' => esc_html__( 'Enter arrows font size with units.', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors' => [ '{{WRAPPER}} .swiper-button-next' => 'font-size: {{VALUE}}',
				                 '{{WRAPPER}} .swiper-button-prev' => 'font-size: {{VALUE}}' ],
			] );

			$shortcode->add_dependecy( $prefix . 'arrows_size', $prefix . 'arrows', 'true' );

			$all_params[] = 'arrows_size';
		}

		// arrow_style field.
		if ( in_array( 'arrows_style', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows_style', [
				'type'    => 'select',
				'heading' => esc_html__( 'Arrow style', 'aheto' ),
				'group'   => $group,
				'options' => [
					'default'     => esc_html__( 'Default', 'aheto' ),
					'number'      => esc_html__( 'Number', 'aheto' ),
					'number_zero' => esc_html__( 'Number with zero', 'aheto' ),
				],
				'default' => 'default'
			] );

			$shortcode->add_dependecy( $prefix . 'arrows_style', $prefix . 'arrows', 'true' );

			$all_params[] = 'arrows_style';
		}

		// arrow_style numbers typo.
		if ( in_array( 'arrows_num_typo', $include ) ) {
			$shortcode->add_param( $prefix . 'arrows_num_typo', [
				'type'     => 'typography',
				'heading' => esc_html__( 'Numbers typography', 'aheto' ),
				'group'   => $group,
				'settings' => [
					'tag'        => false,
					'text_align' => false,
					'color' => false,
					'color_hover' => false,
				],
				'selector' => '{{WRAPPER}} .swiper-button-next span, .swiper-button-prev span',
			] );

			$shortcode->add_dependecy( $prefix . 'arrows_num_typo', $prefix . 'arrows_style', ['number', 'number_zero'] );

			$all_params[] = 'arrows_num_typo';
		}

		// Pagination field.
		if ( in_array( 'pagination', $include ) ) {
			$shortcode->add_param( $prefix . 'pagination', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Pagination', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'pagination';
		}

		// Effect field.
		if ( in_array( 'effect', $include ) ) {
			$shortcode->add_param( $prefix . 'effect', [
				'type'    => 'select',
				'heading' => esc_html__( 'Effect Type', 'aheto' ),
				'options' => [
					'slide'     => esc_html__( 'Slide', 'aheto' ),
					'fade'      => esc_html__( 'Fade', 'aheto' ),
					'cube'      => esc_html__( 'Cube', 'aheto' ),
					'flip'      => esc_html__( 'Flip', 'aheto' ),
					'coverflow' => esc_html__( 'Coverflow', 'aheto' ),
				],
				'group'   => $group,
			] );

			$all_params[] = 'effect';
		}

		// Effect field.
		if ( in_array( 'direction', $include ) ) {
			$shortcode->add_param( $prefix . 'direction', [
				'type'    => 'select',
				'heading' => esc_html__( 'Direction', 'aheto' ),
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'aheto' ),
					'vertical'   => esc_html__( 'Vertical', 'aheto' ),
				],
				'group'   => $group,
			] );

			$all_params[] = 'direction';
		}

		// Effect field.
		if ( in_array( 'loop', $include ) ) {
			$shortcode->add_param( $prefix . 'loop', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Loop', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'loop';
		}

		// Effect field.
		if ( in_array( 'overflow', $include ) ) {
			$shortcode->add_param( $prefix . 'overflow', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Overflow visible', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'overflow';
		}

		if ( in_array( 'simulate_touch', $include ) ) {
			$shortcode->add_param( $prefix . 'simulate_touch', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Simulate Touch', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'simulate_touch';
		}
		if ( in_array( 'centeredSlides', $include ) ) {
			$shortcode->add_param( $prefix . 'centeredSlides', [
				'type'    => 'switch',
				'heading' => esc_html__( 'Centered Slides', 'aheto' ),
				'group'   => $group,
			] );

			$all_params[] = 'centeredSlides';
		}

		// Autoplay field.
		if ( in_array( 'autoplay', $include ) ) {
			$shortcode->add_param( $prefix . 'autoplay', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Autoplay', 'aheto' ),
				'description' => esc_html__( 'Enter autoplay speed(in ms). 0 - autoplay off.', 'aheto' ),
				'value'       => 0,
				'group'       => $group,
			] );

			$all_params[] = 'autoplay';
		}

		// Autoplay field.
		if ( in_array( 'initial_slide', $include ) ) {
			$shortcode->add_param( $prefix . 'initial_slide', [
				'type'    => 'text',
				'heading' => esc_html__( 'Initial slide', 'aheto' ),
				'value'   => 0,
				'group'   => $group,
			] );

			$all_params[] = 'initial_slide';
		}

		// Speed field.
		if ( in_array( 'speed', $include ) ) {
			$shortcode->add_param( $prefix . 'speed', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Speed', 'aheto' ),
				'description' => esc_html__( 'Enter speed(in ms).', 'aheto' ),
				'value'       => 500,
				'group'       => $group,
			] );

			$all_params[] = 'speed';
		}

		// Slides fields.
		if ( in_array( 'slides', $include ) ) {
			$shortcode->add_param( $prefix . 'slides', [
				'type'    => 'text',
				'heading' => esc_html__( 'Slides count', 'aheto' ),
				'value'   => 1,
				'group'   => $group,
			] );

			$all_params[] = 'slides';

			$shortcode->add_param( $prefix . 'slides_lg', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides count(lg)', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_lg';

			$shortcode->add_param( $prefix . 'slides_md', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides count(md)', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_md';

			$shortcode->add_param( $prefix . 'slides_sm', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides count(sm)', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_sm';

			$shortcode->add_param( $prefix . 'slides_xs', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides count(xs)', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_xs';
		}

		if ( in_array( 'slides_group', $include ) ) {
			$shortcode->add_param( $prefix . 'slides_group', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides per group', 'aheto' ),
				'description' => esc_html__( 'Set numbers of slides to define and enable group sliding. Useful to use with Slides count > 1', 'aheto' ),
				'value'       => 4,
				'group'       => $group,
			] );

			$all_params[] = 'slides_group';

			$shortcode->add_param( $prefix . 'slides_group_lg', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides group count(lg)', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_group_lg';

			$shortcode->add_param( $prefix . 'slides_group_md', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides group count(md)', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_group_md';

			$shortcode->add_param( $prefix . 'slides_group_sm', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides group count(sm)', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_group_sm';

			$shortcode->add_param( $prefix . 'slides_group_xs', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Slides group count(xs)', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'value'       => 1,
				'grid'        => 6,
				'group'       => $group,
			] );

			$all_params[] = 'slides_group_xs';
		}

		// Spaces fields.
		if ( in_array( 'spaces', $include ) ) {
			$shortcode->add_param( $prefix . 'spaces', [
				'type'    => 'text',
				'heading' => esc_html__( 'Spaces between slides', 'aheto' ),
				'group'   => $group,
				'selectors'   => [ '{{WRAPPER}} .swiper' => '--swiper-spaces: {{VALUE}}' ],
			] );

			$all_params[] = 'spaces';

			$shortcode->add_param( $prefix . 'spaces_lg', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(lg)', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors'   => [ '{{WRAPPER}} .swiper' => '--swiper-spaces-lg: {{VALUE}}' ],
			] );

			$all_params[] = 'spaces_lg';

			$shortcode->add_param( $prefix . 'spaces_md', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(md)', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors'   => [ '{{WRAPPER}} .swiper' => '--swiper-spaces-md: {{VALUE}}' ],
			] );

			$all_params[] = 'spaces_md';

			$shortcode->add_param( $prefix . 'spaces_sm', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(sm)', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors'   => [ '{{WRAPPER}} .swiper' => '--swiper-spaces-sm: {{VALUE}}' ],
			] );

			$all_params[] = 'spaces_sm';

			$shortcode->add_param( $prefix . 'spaces_xs', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(xs)', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
				'selectors'   => [ '{{WRAPPER}} .swiper' => '--swiper-spaces-xs: {{VALUE}}' ],
			] );

			$all_params[] = 'spaces_xs';
		}

		// Lazy field.
		if ( in_array( 'lazy', $include ) ) {
			$shortcode->add_param( $prefix . 'lazy', [
				'type'        => 'text',
				'heading'     => esc_html__( 'Lazy load image', 'aheto' ),
				'description' => esc_html__( 'Amount of next/prev slides to preload lazy images in.(if 0 - lazy load off)', 'aheto' ),
				'value'       => 0,
				'group'       => $group,
			] );

			$all_params[] = 'lazy';
		}

		if ( $dependency ) {
			$dependency = ( $dependency ? $dependency : [ '', '' ] );
			foreach ( $all_params as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		// Should add dependency.
		if ( $custom_options ) {
			$dependency_custom = [ $prefix . 'custom_options', 'true' ];
			foreach ( $all_params as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency_custom[0], $dependency_custom[1] );
			}
		}
	}

	/**
	 * @param        $shortcode
	 * @param array $args
	 * @param string $group_id
	 */
	public static function add_networks_params( $shortcode, $args = [], $group_id = '' ) {

		/* ------ PARSE & EXTRACT DEFAULT ARGUMENTS ------ */
		$args = wp_parse_args( $args, [
			'group'      => esc_html__( 'Networks Settings', 'aheto' ),
			'prefix'     => '',
			'dependency' => false,
		] );
		extract( $args );


		$networks = Helper::choices_social_network();

		foreach ( $networks as $key => $name ) {

			$shortcode->add_param(
				$prefix . $key, [
				'type'        => 'text',
				'group'       => $group,
				'heading'     => $name,
				'description' => esc_html__( 'Add url to ', 'aheto' ) . $name,
				'placeholder' => __( 'https://', 'aheto' ),
			], $group_id );


			if ( $dependency ) {
				$dependency = $dependency ? $dependency : [ '', '' ];

				$shortcode->add_dependecy( $prefix . $key, $dependency[0], $dependency[1] );

			}

		}

	}


	/**
	 * @param        $shortcode
	 * @param array $args
	 * @param string $group_id
	 */
	public static function add_button_params( $shortcode, $args = [], $group_id = '' ) {
		$builder = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';

		/* ------ PARSE & EXTRACT DEFAULT ARGUMENTS ------ */
		$args = wp_parse_args( $args, [
			'add_button' => true,
			'add_label'  => esc_html__( 'Add button?', 'aheto' ),
			'group'      => esc_html__( 'Button Settings', 'aheto' ),
			'prefix'     => '',
			'layouts'    => '',
			'icons'      => false,
			'link'       => true,
			'include'    => [
				'style',
				'size',
				'type',
				'shadow',
				'underline',
				'underline_anime',
				'full_width',
			],
			'dependency' => false,
		] );
		extract( $args );


		/* ------ ADD BUTTON ------ */
		if ( $add_button ) {
			$shortcode->add_param( $prefix . 'add_button', [
				'type'    => 'switch',
				'heading' => $add_label,
				'group'   => $group,
			], $group_id );

			if ( $dependency ) {
				$shortcode->add_dependecy( $prefix . 'add_button', $dependency[0], $dependency[1] );
			}
		}

		/* ------ LAYOUTS ------ */
		if ( ! $layouts ) {

			$button_dir = '//assets.aheto.co/button/previews/';

			$all_layouts = array(
				'layout1' => [
					'title' => esc_html__( 'Classic', 'aheto' ),
					'image' => $button_dir . 'classic.jpg',
				],
				'layout2' => [
					'title' => esc_html__( 'With Underline', 'aheto' ),
					'image' => $button_dir . 'underline.jpg',
				]
			);

			$all_layouts = apply_filters( "aheto_button_all_layouts", $all_layouts );

			$shortcode->add_param(
				$prefix . 'layouts', [
				'type'    => 'image_selector',
				'heading' => esc_html__( 'Layout', 'aheto' ),
				'group'   => $group,
				'layouts' => $all_layouts,
				'default' => 'layout1'
			], $group_id );
		}

		/* ------ LINK ------ */
		if ( $link ) {
			if ( 'elementor' === $builder ) {
				$shortcode->add_param(
					$prefix . 'title', [
					'type'        => 'text',
					'group'       => $group,
					'heading'     => esc_html__( 'Name', 'aheto' ),
					'description' => esc_html__( 'Add name to button.', 'aheto' ),
					'default'     => esc_html__( 'Click Me', 'aheto' ),
				], $group_id );
			}

			$shortcode->add_param(
				$prefix . 'url', [
				'type'        => 'link',
				'group'       => $group,
				'heading'     => esc_html__( 'Link', 'aheto' ),
				'description' => esc_html__( 'Add url to button.', 'aheto' ),
				'placeholder' => __( 'https://your-link.com', 'aheto' ),
				'default'     => [
					'url' => '#',
				],
			], $group_id );
		}

		/* ------ STYLE ------ */
		if ( in_array( 'style', $include ) ) {
			$shortcode->add_param(
				$prefix . 'style', [
				'type'    => 'select',
				'grid'    => 6,
				'group'   => $group,
				'heading' => esc_html__( 'Style', 'aheto' ),
				'options' => [
					'aheto-btn--primary' => esc_html__( 'Primary', 'aheto' ),
					'aheto-btn--dark'    => esc_html__( 'Dark', 'aheto' ),
					'aheto-btn--light'   => esc_html__( 'Light', 'aheto' ),
				],
				'default' => 'aheto-btn--primary',
			], $group_id );
		}


		/* ------ UNDERLINE ------ */
		if ( in_array( 'underline', $include ) && $layouts != 'layout1' ) {
			$shortcode->add_param(
				$prefix . 'underline', [
				'type'    => 'switch',
				'group'   => $group,
				'grid'    => 6,
				'heading' => esc_html__( 'Remove underline?', 'aheto' ),
				'default' => '',
			], $group_id );


			$shortcode->add_dependecy( $prefix . 'underline', $prefix . 'layouts', 'layout2' );

		}

		if ( in_array( 'underline_anime', $include ) && $layouts != 'layout1' ) {
			$shortcode->add_param(
				$prefix . 'underline_anime', [
				'type'    => 'switch',
				'group'   => $group,
				'grid'    => 6,
				'heading' => esc_html__( 'Add animation for underline?', 'aheto' ),
				'default' => '',
			], $group_id );


			$shortcode->add_dependecy( $prefix . 'underline_anime', $prefix . 'layouts', 'layout2' );

		}

		/* ------ SIZE ------ */
		if ( in_array( 'size', $include ) && $layouts != 'layout2' ) {

			$shortcode->add_param(
				$prefix . 'size', [
				'type'    => 'select',
				'group'   => $group,
				'heading' => esc_html__( 'Size', 'aheto' ),
				'grid'    => 6,
				'options' => [
					''                 => esc_html__( 'Standart', 'aheto' ),
					'aheto-btn--small' => esc_html__( 'Small', 'aheto' ),
					'aheto-btn--large' => esc_html__( 'Large', 'aheto' ),
				],
				'default' => '',
			], $group_id );
		}

		/* ------ TYPE ------ */
		if ( in_array( 'type', $include ) && $layouts != 'layout2' ) {
			$shortcode->add_param(
				$prefix . 'type', [
				'type'    => 'select',
				'group'   => $group,
				'heading' => esc_html__( 'Type', 'aheto' ),
				'grid'    => 6,
				'options' => [
					''                       => esc_html__( 'Default', 'aheto' ),
					'aheto-btn--reverse'     => esc_html__( 'Reverse', 'aheto' ),
					'aheto-btn--transparent' => esc_html__( 'Transparent', 'aheto' ),
				],
				'default' => '',
			], $group_id );
		}

		/* ------ SHADOW ------ */
		if ( in_array( 'shadow', $include ) && $layouts != 'layout2' ) {
			$shortcode->add_param(
				$prefix . 'shadow', [
				'type'        => 'switch',
				'group'       => $group,
				'grid'        => 6,
				'heading'     => esc_html__( 'Box shadow', 'aheto' ),
				'description' => esc_html__( 'It only works if the box-shadow is specified in skin generator.', 'aheto' ),
			], $group_id );
		}
		/* ------ SHADOW ------ */
		if ( in_array( 'full_width', $include ) && $layouts != 'layout2' ) {
			$shortcode->add_param(
				$prefix . 'full_width', [
				'type'        => 'switch',
				'group'       => $group,
				'grid'        => 6,
				'heading'     => esc_html__( 'Enable Full width', 'aheto' ),
			], $group_id );
		}

		/* ------ ICON ------ */

		if ( $icons ) {

			self::add_icon_params( $shortcode, [
				'add_icon' => true,
				'prefix'   => $prefix,
				'group'    => $group,
				'exclude'  => [ 'align', 'color' ],
			], $group_id );

			$shortcode->add_param(
				$prefix . 'icon_position', [
				'type'    => 'select',
				'group'   => $group,
				'heading' => esc_html__( 'Icon position', 'aheto' ),
				'options' => [
					'left'  => esc_html__( 'Left', 'aheto' ),
					'right' => esc_html__( 'Right', 'aheto' ),
				],
				'default' => 'left',
			], $group_id );

			$shortcode->add_dependecy( $prefix . 'icon_position', $prefix . 'add_icon', 'true' );
		}

		/* ------ ADD DEPENDENCY ------ */

		$all_button_options = array(
			'title',
			'url',
			'style',
			'add_icon',
			'icon_position',
			'layouts',
			'size',
			'type',
			'shadow',
			'full_width',
			'underline',
			'underline_anime'
		);

		$all_button_options = apply_filters( "aheto_button_all_option", $all_button_options );

		if ( $dependency ) {
			foreach ( $all_button_options as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		if ( $add_button ) {
			$dependency = $add_button ? [ $prefix . 'add_button', 'true' ] : ( $dependency ? $dependency : [ '', '' ] );

			foreach ( $all_button_options as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		if ( $layouts != 'layout1' ) {

			$layouts_box_options = array( 'layout1' );
			$layouts_box_options = apply_filters( "aheto_button_box_options", $layouts_box_options );

			$shortcode->add_dependecy( $prefix . 'size', $prefix . 'layouts', $layouts_box_options );
			$shortcode->add_dependecy( $prefix . 'type', $prefix . 'layouts', 'layout1' );
			$shortcode->add_dependecy( $prefix . 'shadow', $prefix . 'layouts', 'layout1' );
			$shortcode->add_dependecy( $prefix . 'full_width', $prefix . 'layouts', 'layout1' );


		}

	}

	/**
	 * @param        $shortcode
	 * @param array $args
	 * @param string $group_id
	 */
	public static function add_video_button_params( $shortcode, $args = [], $group_id = '' ) {
		/* ------ PARSE & EXTRACT DEFAULT ARGUMENTS ------ */

		$args = wp_parse_args( $args, [
			'add_button' => true,
			'add_label'  => esc_html__( 'Add video button?', 'aheto' ),
			'prefix'     => '',
			'group'      => esc_html__( 'General', 'aheto' ),
			'link'       => true,
			'style'      => true,
			'dependency' => false,
		] );
		extract( $args );


		/* ------ ADD BUTTON ------ */
		if ( $add_button ) {
			$shortcode->add_param( $prefix . 'add_video_button', [
				'type'    => 'switch',
				'heading' => $add_label,
				'group'   => $group,
			], $group_id );

			if ( $dependency ) {
				$shortcode->add_dependecy( $prefix . 'add_video_button', $dependency[0], $dependency[1] );
			}
		}

		/* ------ LINK ------ */
		if ( $link ) {
			$shortcode->add_param(
				$prefix . 'video_link', [
				'type'        => 'text',
				'group'       => $group,
				'default'     => '#',
				'heading'     => esc_html__( 'Video link', 'aheto' ),
				'description' => esc_html__( 'Add link to button.', 'aheto' ),
			], $group_id );
		}

		/* ------ STYLE ------ */
		if ( $style ) {
			$shortcode->add_param(
				$prefix . 'video_style', [
				'type'    => 'select',
				'grid'    => 6,
				'group'   => $group,
				'heading' => esc_html__( 'Style', 'aheto' ),
				'options' => [
					'aheto-btn--primary' => esc_html__( 'Primary', 'aheto' ),
					'aheto-btn--dark'    => esc_html__( 'Dark', 'aheto' ),
					'aheto-btn--light'   => esc_html__( 'Light', 'aheto' ),
				],
				'default' => 'aheto-btn--primary',
			], $group_id );
		}

		/* ------ SIZE ------ */
		$shortcode->add_param(
			$prefix . 'video_size', [
			'type'    => 'select',
			'group'   => $group,
			'heading' => esc_html__( 'Size', 'aheto' ),
			'grid'    => 6,
			'options' => [
				''                       => esc_html__( 'Standart', 'aheto' ),
				'aheto-btn-video--small' => esc_html__( 'Small', 'aheto' ),
				'aheto-btn-video--large' => esc_html__( 'Large', 'aheto' ),
			],
			'default' => '',
		], $group_id );

		/* ------ ADD DEPENDENCY ------ */


		if ( $dependency ) {
			foreach ( [ 'video_link', 'video_style', 'video_size' ] as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		// Should add dependency.
		if ( $add_button ) {
			$dependency_custom = [ $prefix . 'add_video_button', 'true' ];
			foreach ( [ 'video_link', 'video_style', 'video_size' ] as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency_custom[0], $dependency_custom[1] );
			}
		}
	}


	/**
	 * Advance params.
	 */
	private static function add_advanced_params() {
		$params['is_group'] = true;

		$params['margin'] = [
			'type'    => 'responsive_spacing',
			'heading' => esc_html__( 'Margin', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		$params['padding'] = [
			'type'    => 'responsive_spacing',
			'heading' => esc_html__( 'Padding', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		$params['zindex'] = [
			'type'    => 'text',
			'heading' => esc_html__( 'Z-Index', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		$params['bgtype'] = [
			'type'    => 'select',
			'heading' => esc_html__( 'Background Type', 'aheto' ),
			'options' => [
				'classic'  => esc_html__( 'Classic', 'aheto' ),
				'gradient' => esc_html__( 'Gradient', 'aheto' ),
			],
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		// Classic.
		$params['bgcolor'] = [
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'classic',
			],
		];

		$params['bgimage'] = [
			'type'       => 'attach_image',
			'heading'    => esc_html__( 'Background Image', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'classic',
			],
		];

		$params['bgstyle'] = [
			'type'       => 'select',
			'heading'    => esc_html__( 'Background Style', 'aheto' ),
			'options'    => [
				''          => esc_html__( 'Theme defaults', 'aheto' ),
				'cover'     => esc_html__( 'Cover', 'aheto' ),
				'contain'   => esc_html__( 'Contain', 'aheto' ),
				'no-repeat' => esc_html__( 'No Repeat', 'aheto' ),
				'repeat'    => esc_html__( 'Repeat', 'aheto' ),
			],
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'classic',
			],
		];

		// Gradient.
		$params['gcolor1'] = [
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Color', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'gradient',
			],
		];

		$params['gcolor1_loc'] = [
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Location', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'gradient',
			],
		];

		$params['gcolor2'] = [
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Second Color', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'gradient',
			],
		];

		$params['gcolor2_loc'] = [
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Location', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'gradient',
			],
		];

		$params['gtype'] = [
			'type'       => 'select',
			'heading'    => esc_html__( 'Gradient Type', 'aheto' ),
			'options'    => [
				'linear' => esc_html__( 'Linear', 'aheto' ),
				'radial' => esc_html__( 'Radial', 'aheto' ),
			],
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'bgtype',
				'value'   => 'gradient',
			],
		];

		$params['glinear_angle'] = [
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Angle', 'aheto' ),
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'gtype',
				'value'   => 'linear',
			],
		];

		$params['gradial_position'] = [
			'type'       => 'select',
			'heading'    => esc_html__( 'Position', 'aheto' ),
			'options'    => [
				'center center' => esc_html__( 'Center Center', 'aheto' ),
				'center left'   => esc_html__( 'Center Left', 'aheto' ),
				'center right'  => esc_html__( 'Center Right', 'aheto' ),
				'top center'    => esc_html__( 'Top Center', 'aheto' ),
				'top left'      => esc_html__( 'Top Left', 'aheto' ),
				'top right'     => esc_html__( 'Top Right', 'aheto' ),
				'bottom center' => esc_html__( 'Bottom Center', 'aheto' ),
				'bottom left'   => esc_html__( 'Bottom Left', 'aheto' ),
				'bottom right'  => esc_html__( 'Bottom Right', 'aheto' ),
			],
			'group'      => esc_html__( 'Advanced', 'aheto' ),
			'grid'       => 6,
			'dependency' => [
				'element' => 'gtype',
				'value'   => 'radial',
			],
		];

		$params['element_id'] = [
			'type'    => 'textfield',
			'heading' => esc_html__( 'CSS ID', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		$params['css_classes'] = [
			'type'    => 'textfield',
			'heading' => esc_html__( 'CSS Classes', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 6,
		];

		// Border.
		$params['border_heading'] = [
			'type'    => 'title',
			'heading' => esc_html__( 'Border', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
		];

		$params['border_width'] = [
			'type'    => 'responsive_spacing',
			'heading' => esc_html__( 'Width', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
			'units'   => [ 'px', '%' ],
		];

		$params['border_style'] = [
			'type'    => 'select',
			'heading' => esc_html__( 'Style', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
			'options' => [
				'none'    => esc_html__( 'None', 'aheto' ),
				'solid'   => esc_html__( 'Solid', 'aheto' ),
				'dotted'  => esc_html__( 'Dotted', 'aheto' ),
				'dashed'  => esc_html__( 'Dashed', 'aheto' ),
				'hidden'  => esc_html__( 'Hidden', 'aheto' ),
				'double'  => esc_html__( 'Double', 'aheto' ),
				'groove'  => esc_html__( 'Groove', 'aheto' ),
				'ridge'   => esc_html__( 'Ridge', 'aheto' ),
				'inset'   => esc_html__( 'Inset', 'aheto' ),
				'outset'  => esc_html__( 'Outset', 'aheto' ),
				'initial' => esc_html__( 'Initial', 'aheto' ),
				'inherit' => esc_html__( 'Inherit', 'aheto' ),
			],
		];

		$params['border_color'] = [
			'type'    => 'colorpicker',
			'heading' => esc_html__( 'Color', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['border_radius'] = [
			'type'    => 'responsive_spacing',
			'heading' => esc_html__( 'Border Radius', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'units'   => [ 'px', '%' ],
			'text'    => [
				'top'    => 'Top Left',
				'right'  => 'Top Right',
				'bottom' => 'Bottom Left',
				'left'   => 'Bottom Right',
			],
		];

		// Box Shadow.
		$params['box_heading'] = [
			'type'    => 'title',
			'heading' => esc_html__( 'Box Shadow', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
		];

		$params['bs_color'] = [
			'type'    => 'colorpicker',
			'heading' => esc_html__( 'Color', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['bs_hoffset'] = [
			'type'    => 'text',
			'heading' => esc_html__( 'Horizontal', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['bs_voffset'] = [
			'type'    => 'text',
			'heading' => esc_html__( 'Vertical', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['bs_blur'] = [
			'type'    => 'text',
			'heading' => esc_html__( 'Blur', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['bs_spread'] = [
			'type'    => 'text',
			'heading' => esc_html__( 'Spread', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
		];

		$params['bs_position'] = [
			'type'    => 'select',
			'heading' => esc_html__( 'Position', 'aheto' ),
			'group'   => esc_html__( 'Advanced', 'aheto' ),
			'grid'    => 4,
			'options' => [
				''      => esc_html__( 'Outline', 'aheto' ),
				'inset' => esc_html__( 'Inset', 'aheto' ),
			],
		];

		$params['custom_css'] = [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Custom CSS', 'aheto' ),
			'description' => esc_html__( 'Use "selector" for parent container.', 'aheto' ),
			'group'       => esc_html__( 'Custom CSS', 'aheto' ),
		];

		self::add_param( 'advanced', $params );
	}

	/**
	 * Icon params.
	 *
	 * @param Shortcode $shortcode Shortcode instance.
	 * @param array $args Arguments.
	 * @param string $group_id Group Id.
	 */
	public static function add_icon_params( $shortcode, $args = [], $group_id = '' ) {
		$builder = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		$args    = wp_parse_args( $args, [
			'add_icon'   => false,
			'add_label'  => esc_html__( 'Add icon?', 'aheto' ),
			'group'      => 'elementor' === $builder ? 'Icon' : '',
			'exclude'    => [],
			'prefix'     => '',
			'dependency' => false,
		] );
		extract( $args );

		require_once aheto()->plugin_dir() . 'includes/aheto-icons.php';

		$options = [
			'elegant'          => esc_html__( 'Elegant', 'aheto' ),
			'font-awesome'     => esc_html__( 'Font Awesome', 'aheto' ),
			'ionicons'         => esc_html__( 'Ion Icons', 'aheto' ),
			'pe-icon-7-stroke' => esc_html__( 'Stroke Icon 7', 'aheto' ),
			'themify'          => esc_html__( 'Themify Icons', 'aheto' ),
		];

		$selected = (array) Helper::get_settings( 'general.font-icons' );
		if ( is_array( $selected ) ) {
			foreach ( $options as $id => $label ) {
				if ( ! in_array( $id, $selected ) ) {
					unset( $options[ $id ] );
				}
			}
		}

		if ( $add_icon ) {
			$shortcode->add_param( $prefix . 'add_icon', [
				'type'    => 'switch',
				'heading' => $add_label,
				'group'   => $group,
				'grid'    => 6,
			], $group_id );

			if ( $dependency ) {
				$shortcode->add_dependecy( $prefix . 'add_icon', $dependency[0], $dependency[1] );
			}
		}

		$shortcode->add_param( $prefix . 'icon_font', [
			'type'    => 'select',
			'heading' => esc_html__( 'Icon library', 'aheto' ),
			'options' => $options,
			'grid'    => 6,
			'group'   => $group,
		], $group_id );


		// Icon alignment field.
		if ( ! in_array( 'align', $exclude ) ) {
			$shortcode->add_param( $prefix . 'icon_align', [
				'type'    => 'select',
				'heading' => esc_html__( 'Align', 'aheto' ),
				'options' => Helper::choices_alignment(),
				'grid'    => 6,
				'group'   => $group,
			], $group_id );
		}

		foreach ( $options as $id => $label ) {

			$shortcode->add_param( $prefix . 'icon_' . $id, [
				'type'        => 'iconpicker',
				'heading'     => $label,
				'description' => esc_html__( 'Select icon from library.', 'aheto' ),
				'group'       => $group,
				'grid'        => 6,
				'settings'    => [
					'emptyIcon'    => false,
					'type'         => $id,
					'iconsPerPage' => 4000,
					'source'       => ahet_get_icons( $id ),
				],
			], $group_id );

			$shortcode->add_dependecy( $prefix . 'icon_' . $id, $prefix . 'icon_font', $id );

		}

		// Icon color field.
		if ( ! in_array( 'color', $exclude ) ) {
			$shortcode->add_param( $prefix . 'icon_color', [
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Icon color', 'aheto' ),
				'description' => esc_html__( 'Select icon color.', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
			], $group_id );
		}

		// Icon font_size field.
		if ( ! in_array( 'font_size', $exclude ) ) {
			$shortcode->add_param( $prefix . 'icon_fz', [
				'type'    => 'text',
				'heading' => esc_html__('Icon font size', 'aheto'),
				'description' => esc_html__( 'Enter icon font size with units.', 'aheto' ),
				'grid'        => 6,
				'group'       => $group,
			], $group_id );
		}

		if ( $dependency ) {
			foreach ( [ 'icon_font', 'icon_color', 'icon_align', 'icon_fz' ] as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		if ( $add_icon ) {
			$dependency = $add_icon ? [ $prefix . 'add_icon', 'true' ] : ( $dependency ? $dependency : [ '', '' ] );

			foreach ( $options as $id => $label ) {
				$shortcode->add_dependecy( $prefix . 'icon_' . $id, $dependency[0], $dependency[1] );
			}


			foreach ( [ 'icon_font', 'icon_color', 'icon_align', 'icon_fz' ] as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}


		// Should add dependency.
//		if ( $add_icon || $dependency ) {
//			$dependency = $add_icon ? [$prefix . 'add_icon', 'true'] : ($dependency ? $dependency : ['', '']);
//			foreach ( ['icon_font', 'icon_color', 'icon_align'] as $param ) {
//				$shortcode->add_dependecy($prefix . $param, $dependency[0], $dependency[1]);
//			}
//		}
	}


	public static function add_image_sizer_params( $shortcode, $args = [], $group_id = '' ) {

		$args = wp_parse_args( $args, [
			'group'      => esc_html__( 'Images size', 'aheto' ),
			'prefix'     => '',
			'dependency' => false,
		] );
		extract( $args );

		$shortcode->add_param( $prefix . 'image_size', [
			'type'    => 'select',
			'heading' => 'Image original size',
			'options' => Helper::choices_image_size( true ),
			'default' => 'full',
			'group'   => $group,
		], $group_id );

		$shortcode->add_param( $prefix . 'image_width', [
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image Width', 'aheto' ),
			'description' => esc_html__( 'Only number. Do not use bigger number then image original width.', 'aheto' ),
			'admin_label' => true,
			'group'       => $group,
		], $group_id );

		$shortcode->add_param( $prefix . 'image_height', [
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image Height', 'aheto' ),
			'description' => esc_html__( 'Only number. Do not use bigger number then image original height.', 'aheto' ),
			'admin_label' => true,
			'group'       => $group,
		], $group_id );

		$shortcode->add_param( $prefix . 'image_crop', [
			'type'    => 'switch',
			'heading' => esc_html__( 'Crop image?', 'aheto' ),
			'group'   => $group,
			'default' => '',
		], $group_id );


		if ( $dependency ) {
			$dependency = ( $dependency ? $dependency : [ '', '' ] );
			foreach ( [ 'image_size', 'image_height', 'image_width', 'image_crop' ] as $param ) {
				$shortcode->add_dependecy( $prefix . $param, $dependency[0], $dependency[1] );
			}
		}

		// Should add dependency.

		$dependency_custom = [ 'image_height', 'image_width', 'image_crop' ];
		foreach ( $dependency_custom as $param ) {
			$shortcode->add_dependecy( $prefix . $param, $prefix . 'image_size', 'custom' );
		}

	}


}
