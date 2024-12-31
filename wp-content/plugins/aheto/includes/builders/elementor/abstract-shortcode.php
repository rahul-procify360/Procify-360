<?php
/**
 * The Shortcode Base.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Elementor
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use ReflectionClass;
use Aheto\Traits\Hooker;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Plugin as Elementor_Plugin;
use Elementor\Controls_Manager as Controls;
use Aheto\Traits\Shortcode as Shortcode_Helper;
use Elementor\Group_Control_Typography as Typography;

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode base class.
 */
class Shortcode extends Widget_Base implements IShortcode {

	use Hooker, Shortcode_Helper;

	/**
	 * Shortcode tag.
	 *
	 * @var string
	 */
	public $slug = '';

	/**
	 * Title for human reading.
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * Hold layouts.
	 *
	 * @var array
	 */
	public $layouts = [];

	/**
	 * Hold default layout.
	 *
	 * @var string
	 */
	public $default_layout = '';

	/**
	 * List of shortcode attributes.
	 *
	 * @var array
	 */
	public $params = [];

	/**
	 * List of depedencies for params.
	 *
	 * @var array
	 */
	public $depedency = [];

	/**
	 * List of depedencies condition.
	 *
	 * @var array
	 */
	public $depedency_condition = [];

	/**
	 * Category which best suites to describe functionality of this shortcode.
	 *
	 * @var string
	 */
	public $category = null;

	/**
	 * Hold attributes by groups.
	 *
	 * @var array
	 */
	public $groups = [];

	/**
	 * Element render attributes.
	 *
	 * Holds all the render attributes of the element. Used to store data like
	 * the HTML class name and the class value, or HTML element ID name and value.
	 *
	 * @access private
	 *
	 * @var array
	 */
	private $render_attributes = [];

	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return $this->slug;
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return empty( $this->icon ) ? 'fa fa-code' : $this->icon;
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ! empty( $this->category ) ? [ $this->category ] : [ 'aheto' ];
	}

	/**
	 * The Class constructor.
	 *
	 * @param array $data
	 * @param null $args
	 *
	 * @throws \Exception
	 */
	public function __construct( $data = [], $args = null ) {
		$this->setup();
		include plugin_dir_path( __DIR__ ) . '../frontend/class-aq-resizer.php';
		include plugin_dir_path( __DIR__ ) . '../frontend/class-twitter-api-exchange.php';
		parent::__construct( $data, $args );
	}

	/**
	 * Register the shortcode
	 */
	public function register() {
		// Add prefix.
		$this->slug = 'aheto_' . $this->slug;

		// Early Bail!
		if ( ! isset( $this->slug ) && empty( $this->slug ) ) {
			wp_die( esc_html__( 'Please define slug', 'aheto' ), esc_html__( 'Variable Missing', 'aheto' ) );
		}

		$this->set_params();
		$this->pre_register();
	}

	/**
	 * Set map for the builder
	 */
	public function set_map() {
	}


	/**
	 * Generate Conditions/Dependencies for Sections
	 */
	protected function get_section_conditions( $group_info ) {
		$terms = array();

		foreach ( $group_info as $param_id ) {
			if ( ! isset( $this->depedency[ $param_id ] ) || empty( $this->depedency[ $param_id ] ) ) {

			} else {
				foreach ( $this->depedency[ $param_id ] as $element => $values ) {
					if ( isset( $conditions[ $element ] ) ) {
						$conditions[ $element ] = array_unique( array_merge( $conditions[ $element ], $values ) );
					} else {
						$conditions[ $element ] = array_unique( $values );
					}
				}
			}
		}


		if ( isset( $conditions ) and is_array( $conditions ) ) {
			$terms = array( 'relation' => 'or' );
			foreach ( $conditions as $key => $value ) {
				if ( ! in_array( $key, $group_info ) ) {
					if ( is_array( $value ) and count( $value ) > 1 ) {
						$operator = "in";
					} else {
						$operator = "==";
					}

					$terms['terms'][] =
						array(
							'name'     => $key,
							'operator' => $operator,
							'value'    => array_values( $value )
						);
				}
			}
		}
		// Check if there are any real values
		if ( isset( $terms ) and count( $terms ) < 2 ) {
			$terms = "";
		}

		return $terms;
	}

	/**
	 * Register controls
	 */

	protected function register_controls() {

		foreach ( $this->groups as $label => $group ) {

			$group_id = $group[0];
			if ( $group_id === "template" ) {
				$tab = Controls::TAB_LAYOUT;
			} else {
				$tab = Controls::TAB_CONTENT;
			}


			$terms = $this->get_section_conditions( $group );


			//var_dump($terms);
			$tabs = array( "content", "layout" );

			if ( $label != "Content" and $label !== "Layout" ) {

				$transform_param = array(
					'label'      => $label,
					'tab'        => $tab,
					'conditions' => $terms
				);
			} else {

				$transform_param = [
					'label' => $label,
					'tab'   => $tab
				];
			}


			$this->start_controls_section( $label . '_section', $transform_param );
			foreach ( $group as $id ) {
				$param = $this->params[ $id ];
				if ( in_array( $param['type'], [ 'css_editor' ] ) ) {
					continue;
				}
				// Transform by type for VC.
				$method = 'transform_' . $param['type'];
				if ( method_exists( $this, $method ) ) {
					$this->$method( $id, $param );
				} else {
					$this->add_control( $id, $param );
				}
			}
			$this->end_controls_section();
		}
	}

	/**
	 * Prepare params according to the builder
	 *
	 * @param  array $params Params to prepare.
	 * @param  bool $repeater Fields of repeater.
	 *
	 * @return array
	 */
	public function prepare_params( $params, $repeater = false ) {

		$new_params = [];

//		$params = $this->deactivate_all_inactivated( $params ); // deactivating with db
		$params = $this->deactivate_not_excluded( $params ); // deactivating manually

		foreach ( $params as $id => $param ) {
			// Exclude params.
			if ( in_array( $id, [ 'advanced' ] ) ) {
				continue;
			}

			$param = $this->set_param_id( $id, $param );
			$param = $this->maybe_global_param( $param, $new_params, $repeater );
			if ( false === $param ) {
				continue;
			}
			$param = $this->maybe_group_param( $param );

			// Exclude for elementor.
			if ( in_array( $param['type'], [ 'posttypes', 'taxonomies', 'loop', 'widgetised_sidebars' ] ) ) {
				continue;
			}

			// Set label for elementor.
			if ( isset( $param['heading'] ) ) {
				$param['label'] = $param['heading'];
				unset( $param['heading'] );
			}

			// Transform types and conditions.
			$this->transform_types( $param );
			$this->transform_conditions( $id, $param );

			// If repeater set no group.
			if ( $repeater ) {
				$new_params[ $id ] = $param;
				continue;
			}

			// Set group for elementor.
			if ( ! isset( $param['group'] ) ) {
				$param['group'] = esc_html__( 'Content', 'aheto' );
			}
			$new_params[ $id ] = $param;

			if ( ! isset( $this->groups[ $param['group'] ] ) ) {
				$this->groups[ $param['group'] ] = [];
			}

			$this->groups[ $param['group'] ][] = $id;
		}


		return $new_params;
	}

	/**
	 * Function deactivating all not active layouts
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function deactivate_not_excluded( $params ) {

		$current_options   = apply_filters( 'aheto_active_leyouts', array() );
		$aheto_folder_name = trailingslashit( dirname( plugin_basename( AHETO_FILE ) ) );


		/*
		 *
		 * example of input array
		  $current_options = Array(
			'aheto_banner-slider' => Array(
				'aheto_layout1',
			),
			'aheto_clients' => Array(
				'layout1',
			),
			'aheto_media' => Array(
				'layout1',
				'layout2',
			),
			'aheto_progress-bar' => Array(
				'layout1',
				'layout2',
				'layout3',
				'layout4',
			),
			'aheto_contact-forms' => Array(
				'layout1',
				'layout2',
				'layout3',
				'layout4',
				'layout5',
			),
		);
		*/

		if ( empty( $current_options ) ) {
			return $params;
		}

		if ( isset( $params['template'] ) ) {

			foreach ( $params['template'] as $layout => &$values ) {

				if ( is_array( $values ) ) {

					foreach ( $values as $k => &$lay ) {

						$current_theme_dir = get_template_directory();

						$current_theme_dir_arr    = explode( '/themes/', $current_theme_dir );
						$current_theme_dir_search = $current_theme_dir_arr[1];


						$pos_plugin = strpos( $lay['image'], '//assets.aheto.co/' );
						$pos_addon  = strpos( $lay['image'], 'plugins/aheto-wdsg-add-ons/shortcodes/' );
						$pos_theme  = strpos( $lay['image'], 'themes/' . $current_theme_dir . '/aheto/' );

						$default_layout = 'layout1';
						$active_layouts = $params['template']['layouts'];

						if ( $pos_plugin !== false ) {

							$get_shortcode_name = explode( 'aheto.co/', $lay['image'] );
							$get_shortcode_name = explode( '/previews', $get_shortcode_name[1] );
							$get_shortcode_name = $get_shortcode_name[0];

							$name = "aheto_" . $get_shortcode_name;

							if ( isset( $current_options[ $name ] ) ) {

								// Change default layout if it is in deactivated layouts

								foreach ( $current_options[ $name ] as $layout_to_deactivate ) {
									unset( $active_layouts[ $layout_to_deactivate ] );
								}

								$theme_path = $current_theme_dir . '/aheto/' . $get_shortcode_name;

								$new_default_layout = false !== $this->theme_layouts_show( $theme_path ) ? $this->theme_layouts_show( $theme_path ) : $this->array_key_first( $active_layouts );

								$params['template']['default'] = $new_default_layout;

								$uniques = $current_options[ $name ];

								if ( in_array( $k, $uniques ) ) {

									unset( $values[ $k ] );
								}
							}


						}


					}

				}


			}
		}

		return $params;

	}

	private function theme_layouts_show( $theme_path ) {

		$theme_layouts = is_dir( $theme_path ) ? scandir( $theme_path ) : false;

		if ( is_array( $theme_layouts ) ) {

			$theme_layouts = array_diff( $theme_layouts, array( "assets", "previews", ".", ".." ) );

			foreach ( $theme_layouts as $lay_name ) {

				if ( strrpos( $lay_name, "layout" ) ) {
					return substr( $lay_name, 0, strpos( $lay_name, "." ) );
				}

			}
		}

		return false;

	}

	/**
	 * Function getting first key from array ( for PHP v. more 7.1 )
	 *
	 * @param array $arr
	 *
	 * @return int|string|null
	 */
	private function array_key_first( array $arr ) {

		foreach ( $arr as $key => $unused ) {
			return $key;
		}

		return null;
	}

	/**
	 * Function deactivating layouts with db
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function deactivate_all_inactivated( $params ) {

		$current_options = get_option( 'aheto-layouts' );
		if ( isset( $params['template'] ) ) {

			foreach ( $params['template'] as $layout => &$values ) {

				if ( is_array( $values ) ) {

					foreach ( $values as $k => &$lay ) {

						$pos = strpos( $lay['image'], 'plugins/aheto/shortcodes/' );

						if ( $pos !== false ) {

							$get_shortcode_name = explode( 'plugins/aheto/shortcodes/', $lay['image'] );
							$get_shortcode_name = explode( '/previews', $get_shortcode_name[1] );
							$get_shortcode_name = $get_shortcode_name[0];
							$name               = "aheto_" . $get_shortcode_name;

							if ( isset( $current_options[ $name ] ) ) {
								$uniques = $current_options[ $name ]['uniques'];
								if ( ! in_array( $k, $uniques ) ) {
									unset( $values[ $k ] );
								}

							} else {
								unset( $values[ $k ] );
							}
						}
					}
				}
			}
		}

		return $params;

	}

	/**
	 * Render shortcode
	 */
	public function render() {
		$atts = $this->get_settings_for_display();

		// Set props.
		$atts['element_id']  = $atts['_element_id'];
		$atts['css_classes'] = $atts['_css_classes'];

		unset( $atts['_element_id'], $atts['_css_classes'] );

		$this->pre_output( $atts );

		// Locate template file.
		$located = $this->locate_template( $atts );
		if ( ! $located ) {
			/* translators: 1. shortcode name, 2. default file */
			trigger_error( sprintf( esc_html__( 'Template file is missing for `%1$s` shortcode. Make sure you have atleast `%2$s` file in your theme or plugin folder.', 'aheto' ), $this->title, 'view.php' ) );

			return;
		}

		$atts['_id'] = uniqid( $this->slug . '_' );
		$this->atts  = $atts;

		include $located;
	}

	/**
	 * Before output if you want to process attributes per shortcode
	 *
	 * @param array $atts Array of shortcode sattributes.
	 */
	public function pre_output( &$atts ) {
	}

	/**
	 * Locate the shortcode view file
	 * Shortcode file looking order
	 *
	 * Plugin Directory
	 * {atts[template]}.php
	 * view.php
	 *
	 * @param  array $atts Array of attributes.
	 *
	 * @return string Located file
	 */
	private function locate_template( $atts ) {

		// Get shortcode directory.
		$reflection       = new ReflectionClass( get_class( $this ) );
		$directory_plugin = trailingslashit( dirname( $reflection->getFilename() ) );
		$directory_addon  = WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/shortcodes/';
		$directory_theme  = get_template_directory() . '/aheto/';

		$template_key = str_replace( 'template-', '', $this->get_template_name() );

		$all_plugins = (array) get_option( 'active_plugins', array() );

		if ( ! empty( $atts['template'] ) ) {

			$template_name_addon  = $directory_addon . $template_key . '/' . $atts['template'] . '.php';
			$template_name_theme  = $directory_theme . $template_key . '/' . $atts['template'] . '.php';
			$template_name_plugin = $directory_plugin . $atts['template'] . '.php';

			// Check template in addon directory.
			if ( in_array('aheto-wdsg-add-ons/index.php', $all_plugins) && file_exists( $template_name_addon ) ) {
				return $template_name_addon;
			} // Check template in theme directory.
			elseif ( file_exists( $template_name_theme ) ) {
				return $template_name_theme;
			} // Check template in plugin directory.
			elseif ( file_exists( $template_name_plugin ) ) {
				return $template_name_plugin;
			}
		}

		// Check default template in shortcode directory.
		if ( file_exists( $directory_plugin . 'view.php' ) ) {
			return $directory_plugin . 'view.php';
		}

		return false;
	}

	/**
	 * Transform conditions
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 */
	public function transform_conditions( $param_id, &$param ) {
		if ( ! isset( $this->depedency[ $param_id ] ) || empty( $this->depedency[ $param_id ] ) ) {
			return;
		}

		foreach ( $this->depedency[ $param_id ] as $element => $values ) {
			$param['condition'][ $element ] = array_unique( $values );
		}
	}

	/**
	 * Transform types
	 *
	 * @param array $param Array of param.
	 */
	public function transform_types( &$param ) {
		$hash = [
			// UI Controls.
			'heading'          => Controls::HEADING,
			'raw_html'         => Controls::RAW_HTML,
			'button'           => Controls::BUTTON,
			'divider'          => Controls::DIVIDER,

			// Data Controls.
			'text'             => Controls::TEXT,
			'number'           => Controls::NUMBER,
			'textarea'         => Controls::TEXTAREA,
			'editor'           => Controls::WYSIWYG,
			'code'             => Controls::CODE,
			'hidden'           => Controls::HIDDEN,
			'switcher'         => Controls::SWITCHER,
			'popover_toggle'   => Controls::POPOVER_TOGGLE,
			'select'           => Controls::SELECT,
			'select2'          => Controls::SELECT2,
			'choose'           => Controls::CHOOSE,
			'color'            => Controls::COLOR,
			'icon'             => Controls::ICON,
			'font'             => Controls::FONT,
			'date_time'        => Controls::DATE_TIME,
			'animation'        => Controls::ANIMATION,
			'hover_animation'  => Controls::HOVER_ANIMATION,
			'gallery'          => Controls::GALLERY,
			'repeater'         => Controls::REPEATER,

			// Multiple Controls.
			'url'              => Controls::URL,
			'media'            => Controls::MEDIA,
			'image_dimensions' => Controls::IMAGE_DIMENSIONS,
			'text_shadow'      => Controls::TEXT_SHADOW,
			'box_shadow'       => Controls::BOX_SHADOW,

			// Unit Controls.
			'slider'           => Controls::SLIDER,
			'dimensions'       => Controls::DIMENSIONS,

			// Conversion.
			'textfield'        => Controls::TEXT,
			'title'            => Controls::HEADING,
			'switch'           => Controls::SWITCHER,
			'checkbox'         => Controls::SWITCHER,
			'colorpicker'      => Controls::COLOR,
			'attach_image'     => Controls::MEDIA,
			'attach_images'    => Controls::GALLERY,
			'iconpicker'       => Controls::ICON,
			'link'             => Controls::URL,
			'group'            => Controls::REPEATER,
			'autocomplete'     => Controls::SELECT2,
			'textarea_safe'    => Controls::TEXTAREA,
		];


		$type = $param['type'];
		if ( isset( $hash[ $type ] ) ) {
			$param['type'] = $hash[ $type ];
		}

		if ( Controls::SWITCHER === $param['type'] ) {
			$param['return_value'] = 'true';
		}
	}

	/**
	 * Add spacing control for elementor
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 */
	public function transform_responsive_spacing( $param_id, $param ) {
		$param['type']       = Controls::DIMENSIONS;
		$param['size_units'] = [ 'px', '%', 'em' ];

		unset( $param['id'] );

//		$this->add_control( $param_id, $param );
		$this->add_responsive_control( $param_id, $param );
	}

	/**
	 * Add repeater control for elementor
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 */
	public function transform_repeater( $param_id, $param ) {
		$repeater = new Repeater;
		foreach ( $param['params'] as $id => $subfield ) {

			// Transform by type for VC.
			$method = 'transform_' . $subfield['type'];
			if ( method_exists( $this, $method ) ) {
				$this->$method( $id, $subfield, $repeater );
			} else {
				$repeater->add_control( $id, $subfield );
			}
		}

		unset( $param['params'] );

		$param['fields'] = $repeater->get_controls();
		$this->add_control( $param_id, $param );
	}

	/**
	 * Add typography control for elementor
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 */
	public function transform_typography( $param_id, $param ) {

		// Alignment param.
		if ( ( $param['type'] == 'typography' ) && ( isset( $param['settings']['text_align'] ) ) && ( $param['settings']['text_align'] ) ) {
			$align_param = [
				'label'   => __( 'Alignment', 'aheto' ),
				'type'    => Controls::CHOOSE,
				'default' => 'left',
				'toggle'  => true,
				'options' => [
					'left'   => [
						'title' => __( 'Left', 'aheto' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'aheto' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'aheto' ),
						'icon'  => 'fa fa-align-right',
					],
				],
			];
		} else {
			$align_param = [];
		}

		// Color param.
		$color_param          = $param;
		$color_param['type']  = Controls::COLOR;
		$color_param['label'] = esc_html__( 'Text Color', 'aheto' );
		unset( $color_param['settings'] );
		if ( isset( $color_param['selector'] ) ) {
			$selectors = explode( ',', $color_param['selector'] );
			unset( $color_param['selector'] );
			$color_param['selectors'] = [];
			foreach ( $selectors as $selector ) {
				$color_param['selectors'][ $selector ] = 'color: {{VALUE}}';
				if ( ! empty( $align_param ) ) {
					$align_param['selectors'][ $selector ] = 'text-align: {{VALUE}}';
				}
			}
		}

		$this->transform_conditions( $param_id, $color_param );
		if ( ! empty( $align_param ) ) {
			$this->transform_conditions( $param_id, $align_param );
			$this->add_responsive_control( $param_id . '_align', $align_param );
		}

		$this->add_control( $param_id . '_color', $color_param );

		$param['name'] = $param_id;
		unset( $param['settings'] );
		$this->add_group_control( Typography::get_type(), $param );
	}

	/**
	 * Add icon control for elementor
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 * @param Control $control Control instance.
	 */
	public function transform_icon( $param_id, $param, $control = false ) {
		$param['name']    = $param_id;
		$param['options'] = $param['settings']['source'];
		$param['include'] = array_keys( $param['settings']['source'] );
		unset( $param['settings'] );
		if ( false !== $control ) {
			$control->add_control( $param_id, $param );
		} else {
			$this->add_control( $param_id, $param );
		}
	}

	/**
	 * Set WPAUTOP for shortcode output
	 *
	 * @param  string $content Content to render.
	 * @param  boolean $autop Automatically add <p> tag.
	 *
	 * @return string
	 */
	public function do_the_content( $content, $autop = true ) {
		return $content;
	}

	/**
	 * Parse group values.
	 *
	 * @param  string $atts Group value to parse.
	 *
	 * @return mixed
	 */
	public function parse_group( $atts ) {
		return $atts;
	}

	/**
	 * Get render attribute string.
	 *
	 * Used to retrieve the value of the render attribute.
	 *
	 * @param array|string $element The element.
	 *
	 * @return string Render attribute string, or an empty string if the attribute
	 *                is empty or not exist.
	 */
	public function get_render_attribute_string( $element ) {
		if ( empty( $this->render_attributes[ $element ] ) ) {
			return '';
		}

		return Helper::html_generate_attributes( $this->render_attributes[ $element ], '', true );
	}

	/**
	 * Add render attribute.
	 *
	 * Used to add attributes to a specific HTML element.
	 *
	 * The HTML tag is represented by the element parameter, then you need to
	 * define the attribute key and the attribute key. The final result will be:
	 * `<element attribute_key="attribute_value">`.
	 *
	 * Example usage:
	 *
	 * `$this->add_render_attribute( 'wrapper', 'class', 'custom-widget-wrapper-class' );`
	 * `$this->add_render_attribute( 'widget', 'id', 'custom-widget-id' );`
	 * `$this->add_render_attribute( 'button', [ 'class' => 'custom-button-class', 'id' => 'custom-button-id' ] );`
	 *
	 * @param array|string $element The HTML element.
	 * @param array|string $key Optional. Attribute key. Default is null.
	 * @param array|string $value Optional. Attribute value. Default is null.
	 * @param bool $overwrite Optional. Whether to overwrite existing
	 *                                attribute. Default is false, not to overwrite.
	 *
	 * @return Element_Base Current instance of the element.
	 */
	public function add_render_attribute( $element, $key = null, $value = null, $overwrite = false ) {
		if ( is_array( $element ) ) {
			foreach ( $element as $element_key => $attributes ) {
				$this->add_render_attribute( $element_key, $attributes, null, $overwrite );
			}

			return $this;
		}

		if ( is_array( $key ) ) {
			foreach ( $key as $attribute_key => $attributes ) {
				$this->add_render_attribute( $element, $attribute_key, $attributes, $overwrite );
			}

			return $this;
		}

		if ( empty( $this->render_attributes[ $element ][ $key ] ) ) {
			$this->render_attributes[ $element ][ $key ] = [];
		}

		settype( $value, 'array' );

		if ( $overwrite ) {
			$this->render_attributes[ $element ][ $key ] = $value;
		} else {
			$this->render_attributes[ $element ][ $key ] = array_merge( $this->render_attributes[ $element ][ $key ], $value );
		}

		return $this;
	}

	/**
	 * Get link attributes
	 *
	 * @param  array $link Link attribute value.
	 * @param  boolean $fallback Fallback to home_url.
	 * @return array
	 *
	 */
	public function get_link_attributes( $link, $fallback = false ) {

		// Fallback to home_url.
		$attributes['href'] = true === $fallback ? esc_url( home_url( '/' ) ) : $fallback;

		if ( strlen( $link['url'] ) > 0 ) {
			$attributes['href'] = esc_url( trim( $link['url'] ) );
			if ( ! empty( $link['nofollow'] ) ) {
				$attributes['rel'] = 'nofollow';
			}

			if ( ! empty( $link['is_external'] ) ) {
				$attributes['target'] = '_blank';
				if( isset($attributes['rel']) && !empty($attributes['rel']) ){
					$attributes['rel'] .= ' noreferrer noopener';
				}
			}

			if ( ! empty( $link['custom_attributes'] ) ) {

				$custom_attr = explode( '|' , $link['custom_attributes'] );
				$custom_attr_value = str_replace(',', ' ', $custom_attr[1]);

				if($custom_attr[0] !== 'href' && $custom_attr[0] !== 'target' && $custom_attr[0] !== 'rel'){
					$attributes[$custom_attr[0]] = $custom_attr_value;
				}else{
					$attributes[$custom_attr[0]] .= ' ' . $custom_attr_value;
				}

			}

		}

		return $attributes;
	}

	/**
	 * Generate CSS.
	 */
	public function generate_css() {

	}

	protected function merge_with_child() {
		if ( ! empty( $this->child_shortcodes ) ) {
			foreach ( $this->child_shortcodes as $child_shortcode ) {
				$this->params = array_merge( $this->params, $child_shortcode->getSettings()['params'] );
			}
		}
	}

	public function get_shortcode_name() {
		return ! empty( $this->slug ) ? explode( '_', $this->slug )[1] : '';
	}

	/**
	 * add the children shortcode in main shortcode
	 *
	 * @param $name
	 */
	public function set_child_shortcode( $name, $group = '' ) {
		$class = '\Aheto\Shortcodes\\' . $name;

		if ( ! isset( $this->child_shortcodes[ $name ] ) && class_exists( $class ) ) {

			$shortcode        = new $class();
			$shortcode->group = $group;

			$shortcode->setup();
			$shortcode->set_params();
			$this->child_shortcodes[ $name ] = $shortcode;
		}
	}

	/**
	 * returns the children shortcode
	 *
	 * @param $name
	 *
	 * @return bool|mixed
	 */
	public function get_child_shortcode( $name ) {
		if ( isset( $this->child_shortcodes[ $name ] ) ) {
			return $this->child_shortcodes[ $name ];
		}

		return false;
	}

	public function show_child_shortcode( $name ) {
		if ( $shortcode = $this->get_child_shortcode( $name ) ) {
			echo $shortcode->render( $this->atts );
		}
	}

	/**
	 * set template slug
	 * @return string
	 */
	protected function get_template_name() {
		$template = ! empty( $this->group ) ? $this->group . '_' : '';

//	    return $template . 'template-' . str_replace('aheto_', '', $this->slug);
		return 'template-' . str_replace( 'aheto_', '', $this->slug );
	}
}
