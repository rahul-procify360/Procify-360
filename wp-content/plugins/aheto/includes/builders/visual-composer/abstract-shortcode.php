<?php
/**
 * The Shortcode Base.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Visual_Composer
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use ReflectionClass;
use WPBakeryShortCode;
use Aheto\Sanitize;
use Aheto\Traits\Hooker;
use Aheto\Traits\Shortcode as Shortcode_Helper;
use Aheto\Visual_Composer\Params\Responsive_Spacing;

defined('ABSPATH') || exit;

/**
 * Shortcode base class.
 */
class Shortcode extends WPBakeryShortCode implements IShortcode {


	use Hooker, Shortcode_Helper;


	private $child_shortcodes = array();

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
	 * Hold attributes.
	 *
	 * @var array
	 */
	public $atts = [];

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
	 * The constructor
	 */
	public function __construct() {
		$aheto_folder_name = trailingslashit( dirname( plugin_basename( AHETO_FILE ) ) );

		include ABSPATH . 'wp-content/plugins/'.$aheto_folder_name.'includes/frontend/class-aq-resizer.php';
		include ABSPATH . 'wp-content/plugins/'.$aheto_folder_name.'includes/frontend/class-twitter-api-exchange.php';
	}

	/**
	 * The Constructor
	 */
	public function register() {
		// Early Bail!
		if ( !isset($this->slug) && empty( $this->slug) ) {
			wp_die(esc_html__('Please define slug', 'aheto'), esc_html__('Variable Missing', 'aheto'));
		}

		// Add prefix.
		$this->slug = 'aheto_' . $this->slug;

		// Early Bail!
		if ( shortcode_exists($this->slug) ) {
			return;
		}

		add_shortcode($this->slug, [$this, 'render'] );

		$this->set_params();
		$this->pre_register();
		$this->set_map();
	}


	/**
	 * Prepare params for nested params groups
	 *
	 * @param $params
	 * @param array $new_params
	 * @return array
	 */
	private function nested_array_values($params, $new_params = [] ) {
		if ( !is_array($params) ) {
			return $params;
		}
		foreach ( $params as $key => $param ) {
			if ( $key === 'params' ) {
				$param = array_values($param);
			}

			$new_params[$key] = $this->nested_array_values($param);
		}

		return $new_params;
	}

	/**
	 * Set map for the builder
	 */
	public function set_map() {
		$keys = [
			'description',
			'icon',
			'is_container',
			'js_view',
			'php_class_name',
			'show_settings_on_create',
			'custom_markup',
			'deprecated',
			'default_content',
			'js_view',
			'allowed_container_element',
			'admin_enqueue_js',
			'as_parent',
			'as_child',
		];


		/*
		 * merge with child shortcodes parameters
		 */
		$this->merge_with_child();

		$params = array_values($this->params);

		// Required!
		$map = [
			'base'     => $this->slug,
			'name'     => $this->title,
			'params'   => $this->nested_array_values($params),
			'category' => ! empty( $this->category) ? $this->category : esc_html__('Aheto', 'aheto'),
		];


		foreach ( $keys as $key ) {

			if ( 'is_container' === $key ) {
				if ( ! empty( $this->is_container) ) {
					$map['js_view']      = 'VcColumnView';
					$map['is_container'] = $this->is_container;
				}
				continue;
			}

			if ( ! empty( $this->{$key}) ) {
				$map[$key] = $this->{$key};
			}
		}

		$this->settings  = $map;
		$this->shortcode = $this->slug;

		$custom_map = 		array(
			'name'     => $this->title,
			'base'     => $this->slug,
			'category' => __( 'Content', 'js_composer' ),
			'params'   => array(
				array(
					'type'        => 'param_group',
					'heading'     => __( 'Buttons', 'js_composer' ),
					'param_name'  => 'buttons',
					'value'       => '',
					'params'      => array(
						array(
							'type'       => 'dropdown',
							'heading'    => __( 'Button for video link', 'js_composer' ),
							'param_name' => 'video_btn',
							'value'      => array(
								'No'  => 'no',
								'Yes' => 'yes',
							),
						),
						array(
							'type'       => 'vc_link',
							'heading'    => __( 'Link/Button', 'js_composer' ),
							'param_name' => 'button',
							'dependency' => array( 'element' => 'video_btn', 'value' => 'no' ),
						),
						array(
							'type'       => 'textfield',
							'heading'    => __( 'Video link URL', 'js_composer' ),
							'description' => __( 'Insert your video link(from Youtube or Vimeo)', 'js_composer' ),
							'param_name' => 'video_link',
							'value'      => '',
							'dependency' => array( 'element' => 'video_btn', 'value' => 'yes' ),
						),
					),
				),
			)
		);

		vc_map($map);
	}

	/**
	 * Prepare params according to the builder
	 *
	 * @param  array $params Params to prepare.
	 * @param  bool $repeater Fields of repeater.
	 * @return array
	 */
	public function prepare_params($params, $repeater = false) {
		$new_params = [];

		//		$params = $this->deactivate_all_inactivated( $params ); // deactivating with db
		$params = $this->deactivate_not_excluded( $params ); // deactivating manually

		foreach ( $params as $id => $param ) {
			$param = $this->set_param_id($id, $param);
			$param = $this->maybe_global_param($param, $new_params, $repeater);
			if ( false === $param ) {
				continue;
			}

			$param = $this->maybe_group_param($param);

			// Set slug name.
			$slug                = $this->get_shortcode_name();
			$param['slug']       = $slug;
			$param['id']         = $id;
			$param['param_name'] = $id;


			// Set grid class.
			if ( isset($param['grid'] ) ) {
				$param['edit_field_class'] = 'vc_column-with-padding vc_col-xs-' . $param['grid'];
				unset($param['grid'] );
			}

			// Transform types, options and conditions.
			$this->transform_types($param);
			$this->transform_options($param);
			$this->transform_conditions($id, $param);

			// Transform by type for VC.
			$method = 'transform_' . $param['type'];
			if ( \method_exists($this, $method) ) {
				$this->$method($param);
			}

			$new_params[$id] = $param;
		}

		return $new_params;
	}

	/**
	 * Function deactivating all not active layouts
	 *
	 * @param $params
	 * @return mixed
	 */
	public function deactivate_not_excluded( $params ) {

			$current_options = apply_filters( 'aheto_active_leyouts', array() );
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

							$current_theme_dir_arr = explode( '/themes/', $current_theme_dir );
							$current_theme_dir_search = $current_theme_dir_arr[1];



							$pos_plugin = strpos( $lay['image'], '//assets.aheto.co/' );
							$pos_addon  = strpos( $lay['image'], 'plugins/aheto-wdsg-add-ons/shortcodes/' );
							$pos_theme = strpos( $lay['image'], 'themes/'. $current_theme_dir .'/aheto/' );

							$default_layout = 'layout1';
							$active_layouts = $params['template']['layouts'];


							if ( $pos_plugin !== false ) {

								$get_shortcode_name = explode( 'aheto.co/', $lay['image'] );
								$get_shortcode_name = explode( '/previews', $get_shortcode_name[1] );
								$get_shortcode_name = $get_shortcode_name[0];

								$name  = "aheto_" . $get_shortcode_name;

								if ( isset( $current_options[ $name ] ) ) {

									// Change default layout if it is in deactivated layouts

										foreach ( $current_options[ $name ] as $layout_to_deactivate ) {
											unset( $active_layouts[ $layout_to_deactivate ] );
										}

										$theme_path = $current_theme_dir . '/aheto/' .  $get_shortcode_name;


										$new_default_layout = false !== $this->theme_layouts_show($theme_path) ? $this->theme_layouts_show($theme_path) : $this->array_key_first( $active_layouts );


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

		private function theme_layouts_show($theme_path) {

			$theme_layouts = is_dir($theme_path) ? scandir($theme_path ) : false;

			$theme_layouts = array_diff($theme_layouts,array("assets", "previews",".",".."));

			if (is_array($theme_layouts))
			foreach ($theme_layouts as $lay_name) {

						if (strrpos($lay_name, "layout"))
											return	substr($lay_name,0, strpos($lay_name, "."));

										}
				return false;

		}

	/**
	 * Function deactivating layouts with db
	 *
	 * @param $params
	 * @return mixed
	 */
	public function deactivate_all_inactivated ( $params ) {

		$current_options  =  get_option('aheto-layouts');
		if ( isset( $params['template'] ) ) {

			foreach ( $params['template'] as $layout => &$values ) {

				if ( is_array ( $values ) ) {

					foreach ($values as $k => &$lay) {

						$pos = strpos($lay['image'], 'plugins/aheto/shortcodes/');

						if ($pos !== false) {

							$get_shortcode_name = explode('plugins/aheto/shortcodes/', $lay['image']);
							$get_shortcode_name = explode('/previews', $get_shortcode_name[1]);
							$get_shortcode_name = $get_shortcode_name[0];
							$name               = "aheto_" . $get_shortcode_name;

							if ( isset( $current_options[$name] ) ) {

								$uniques =  $current_options[$name]['uniques'];
								if ( !in_array( $k, $uniques ) ) {
									unset( $values[$k] );
								}

							}
							else {
								unset($values[$k]);
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
	 *
	 * @param  array $atts Array of shortcode sattributes.
	 * @param  string $content Shortcode content.
	 * @return string
	 */
	public function render($atts, $content = '') {

		$this->render_attributes = [];

		$atts = $this->prepareAtts($atts);
		$atts = vc_map_get_attributes($this->slug, $atts);
		$this->pre_output($atts, $content);

		// Locate template file.
		$located = $this->locate_template($atts);

		if ( !$located ) {
			/* translators: 1. shortcode name, 2. default file */
			trigger_error(sprintf(esc_html__('Template file is missing for `%1$s` shortcode. Make sure you have atleast `%2$s` file in your theme or plugin folder.', 'aheto'), $this->title, 'view.php'));
			return;
		}

		$atts['content'] = $content;
		$atts['_id']     = uniqid($this->slug . '_');
		$this->atts      = $atts;

		$this->enqueue_styles();
		$this->enqueue_scripts();

		ob_start();
		include $located;
		return ob_get_clean();
	}

	/**
	 * Before output if you want to process attributes per shortcode
	 *
	 * @param  array $atts Array of shortcode sattributes.
	 * @param  string $content Shortcode content.
	 */
	public function pre_output(&$atts, &$content) {
	}

	/**
	 * Locate the shortcode view file
	 * Shortcode file looking order
	 *
	 * Theme Directory
	 * {slug}-{atts[template]}.php
	 * {slug}-view.php
	 *
	 * Plugin Directory
	 * {atts[template]}.php
	 * view.php
	 *
	 * @param  array $atts Array of attributes.
	 * @return string Located file
	 */
	private function locate_template($atts) {

		$template_key = str_replace( 'template-', '', $this->get_template_name() );

		// Check template in plugin addon directory.
		if ( ! empty( $atts['template'] ) ) {

			$directory_addon  = WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/shortcodes/';
			$template_name_addon = $directory_addon . $template_key . '/' . $atts['template'] . '.php';

			if ( is_plugin_active( WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/index.php' ) && file_exists( $template_name_addon ) ) {
				return $template_name_addon;
			}
		}

		// Check template in theme directory.
		if ( ! empty( $atts['template'] ) ) {

			$template_name = $template_key . '/' . $atts['template'] . '.php';

			$user_template = vc_shortcodes_theme_templates_dir($template_name);

			if ( is_file($user_template) ) {
				return $user_template;
			}
		}

		// Check default template in theme directory.
		$template_name = $template_key . '/view.php';
		$user_template = vc_shortcodes_theme_templates_dir( $template_name );

		if ( is_file($user_template) ) {
			return $user_template;
		}

		// Get shortcode directory.
		$reflection = new ReflectionClass(get_class($this));
		$directory  = trailingslashit(dirname($reflection->getFilename()));


		// Check template in shortcode directory.

		if ( ! empty( $atts['template'] ) ) {
			$template_name = $directory . $atts['template'] . '.php';

			if ( file_exists($template_name) ) {

				return $template_name;
			}
		}

		// Check default template in shortcode directory.
		if ( file_exists($directory . 'view.php') ) {
			return $directory . 'view.php';
		}

		return false;
	}

	/**
	 * Get script dependencies.
	 *
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @return array Element scripts dependencies.
	 */
	public function get_script_depends() {
		return [];
	}

	/**
	 * Get style dependencies.
	 *
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @return array Element styles dependencies.
	 */
	public function get_style_depends() {
		return [];
	}

	/**
	 * Enqueue scripts.
	 *
	 * Registers all the scripts defined as element dependencies and enqueues
	 * them. Use `get_script_depends()` method to add custom script dependencies.
	 */
	public function enqueue_scripts() {
		foreach ( $this->get_script_depends() as $script ) {
			wp_enqueue_script($script);
		}
	}

	/**
	 * Enqueue styles.
	 *
	 * Registers all the styles defined as element dependencies and enqueues
	 * them. Use `get_style_depends()` method to add custom style dependencies.
	 */
	public function enqueue_styles() {
		foreach ( $this->get_style_depends() as $style ) {
			wp_enqueue_style($style);
		}
	}

	/**
	 * Transform types
	 *
	 * @param array $param Array of param.
	 */
	public function transform_types(&$param) {
		$hash = [
			'animation' => 'animation_style',
			'link'      => 'vc_link',
			'text'      => 'textfield',
			'slider'    => 'textfield',
			'select'    => 'dropdown',
			'editor'    => 'textarea_html',
			'group'     => 'param_group',
			'switch'    => 'checkbox',
		];

		$type = $param['type'];
		if ( isset($hash[$type] ) ) {
			$param['type'] = $hash[$type];
		}
	}

	/**
	 * Transform options to VC
	 *
	 * @param array $param Array of param.
	 */
	public function transform_options(&$param) {
		if ( !isset($param['options'] ) ) {
			return;
		}

		// Convert options.
		foreach ( $param['options'] as $value => $text ) {
			$param['value'][$text] = $value;
		}
		unset($param['options'] );
	}

	/**
	 * Transform conditions
	 *
	 * @param string $param_id Id of param.
	 * @param array $param Array of param.
	 */
	public function transform_conditions($param_id, &$param) {
		if ( !isset($this->depedency[$param_id] ) || empty( $this->depedency[$param_id] ) ) {
			return;
		}

		foreach ( $this->depedency[$param_id] as $element => $values ) {
			$condition           = $this->depedency_condition[$param_id][$element];
			$param['dependency'] = [
				'element'  => $element,
				$condition => array_unique($values),
			];
		}
	}

	/**
	 * Set WPAUTOP for shortcode output
	 *
	 * @param  string $content Content to render.
	 * @param  boolean $autop Automatically add <p> tag.
	 * @return string
	 */
	public function do_the_content($content, $autop = true) {

		if ( $autop ) {
			$content = wpautop(preg_replace('/<\/?p\>/', "\n", $content) . "\n");
		}

		return do_shortcode(shortcode_unautop($content));
	}

	/**
	 * Get link attributes
	 *
	 * @param  array $link Link attribute value.
	 * @param  boolean $fallback Fallback to home_url.
	 * @return array
	 */
	public function get_link_attributes($link, $fallback = false) {

		// Fallback to home_url.
		$attributes['href'] = true === $fallback ? esc_url(home_url('/')) : $fallback;

		// Link.
		$link = '||' === $link ? '' : $link;
		$link = vc_build_link($link);
		if ( strlen($link['url'] ) > 0 ) {
			$attributes['href']  = esc_url(trim($link['url'] ));
			$attributes['title'] = esc_attr(trim($link['title'] ));
			if ( ! empty( $link['target'] ) ) {
				$attributes['target'] = esc_attr(trim($link['target'] ));
			}
		}

		return $attributes;
	}

	/**
	 * Parse group values.
	 *
	 * @param  string $atts Group value to parse.
	 * @return mixed
	 */
	public function parse_group($atts) {
		return vc_param_group_parse_atts($atts);
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
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array|string $element The HTML element.
	 * @param array|string $key Optional. Attribute key. Default is null.
	 * @param array|string $value Optional. Attribute value. Default is null.
	 * @param bool $overwrite Optional. Whether to overwrite existing
	 *                                attribute. Default is false, not to overwrite.
	 *
	 * @return Element_Base Current instance of the element.
	 */
	public function add_render_attribute($element, $key = null, $value = null, $overwrite = false) {
		if ( is_array($element) ) {
			foreach ( $element as $element_key => $attributes ) {
				$this->add_render_attribute($element_key, $attributes, null, $overwrite);
			}

			return $this;
		}

		if ( is_array($key) ) {
			foreach ( $key as $attribute_key => $attributes ) {
				$this->add_render_attribute($element, $attribute_key, $attributes, $overwrite);
			}

			return $this;
		}

		if ( empty( $this->render_attributes[$element][$key] ) ) {
			$this->render_attributes[$element][$key] = [];
		}

		settype($value, 'array');

		if ( $overwrite ) {
			$this->render_attributes[$element][$key] = $value;
		} else {
			$this->render_attributes[$element][$key] = array_merge($this->render_attributes[$element][$key], $value);
		}

		return $this;
	}

	/**
	 * Get render attribute string.
	 *
	 * Used to retrieve the value of the render attribute.
	 *
	 * @param array|string $element The element.
	 * @return string Render attribute string, or an empty string if the attribute
	 *                is empty or not exist.
	 */
	public function get_render_attribute_string($element) {
		if ( empty( $this->render_attributes[$element] ) ) {
			return '';
		}

		return Helper::html_generate_attributes( $this->render_attributes[$element], '', true );
	}

	/**
	 * Generate CSS.
	 */
	public function generate_css() {

		$css = $this->get_advanced_css_array();

		if ( \method_exists($this, 'pre_dynamic_css') ) {
			$css = $this->pre_dynamic_css($css);
		}

		$css = Helper::dynamic_css_parser($css);


		if ( '%1$s{}' === $css ) {
			$css = '';
		}
		$custom_css = isset($this->atts['custom_css'] ) ? trim($this->atts['custom_css'] ) : '';
		if ( empty( $css) && empty( $custom_css) ) {
			return;
		}

		$css = str_replace('%1$s', '.' . $this->atts['_id'], $css);
		$custom_css = str_replace('selector', '.' . $this->atts['_id'], $custom_css);

		echo '<style>' . $css . $custom_css . '</style>';

	}

	/**
	 * Get dynamic css array for advanced tab.
	 *
	 * @return array
	 */
	public function get_advanced_css_array() {
		$css      = [];
		$selector = '%1$s';

		$this->atts = wp_parse_args($this->atts, [
			'bs_position'  => '',
			'bs_hoffset'   => '',
			'bs_voffset'   => '',
			'bs_blur'      => '',
			'bs_spread'    => '',
			'bs_color'     => '',
			'border_width' => '',
			'border_style' => '',
			'border_color' => '',
		] );

		// Box Shadow.
		$css['global'][$selector]['box-shadow'] = Sanitize::box_shadow([
			'inset'   => $this->atts['bs_position'],
			'hoffset' => $this->atts['bs_hoffset'],
			'voffset' => $this->atts['bs_voffset'],
			'blur'    => $this->atts['bs_blur'],
			'spread'  => $this->atts['bs_spread'],
			'color'   => $this->atts['bs_color'],
		] );

		$breakpoint_md = '@media (max-width: 1199px)';
		$breakpoint_sm = '@media (max-width: 991px)';
		$breakpoint_xs = '@media (max-width: 767px)';

		// Padding.
		if ( isset($this->atts['padding'] ) ) {
			$this->atts['padding'] = Responsive_Spacing::parse($this->atts['padding'] );
			if ( ! empty( $this->atts['padding']['desktop'] ) ) {
				aheto_add_props($css['global'][$selector], $this->atts['padding']['desktop'] );
			}

			if ( ! empty( $this->atts['padding']['laptop'] ) ) {
				aheto_add_props($css[$breakpoint_md][$selector], $this->atts['padding']['laptop'] );
			}

			if ( ! empty( $this->atts['padding']['tablet'] ) ) {
				aheto_add_props($css[$breakpoint_sm][$selector], $this->atts['padding']['tablet'] );
			}

			if ( ! empty( $this->atts['padding']['mobile'] ) ) {
				aheto_add_props($css[$breakpoint_xs][$selector], $this->atts['padding']['mobile'] );
			}
		}

		// Margin.
		if ( isset($this->atts['margin'] ) ) {
			$this->atts['margin'] = Responsive_Spacing::parse($this->atts['margin'], 'margin');
			if ( ! empty( $this->atts['margin']['desktop'] ) ) {
				aheto_add_props($css['global'][$selector], $this->atts['margin']['desktop'] );
			}

			if ( ! empty( $this->atts['margin']['laptop'] ) ) {
				aheto_add_props($css[$breakpoint_md][$selector], $this->atts['margin']['laptop'] );
			}

			if ( ! empty( $this->atts['margin']['tablet'] ) ) {
				aheto_add_props($css[$breakpoint_sm][$selector], $this->atts['margin']['tablet'] );
			}

			if ( ! empty( $this->atts['margin']['mobile'] ) ) {
				aheto_add_props($css[$breakpoint_xs][$selector], $this->atts['margin']['mobile'] );
			}
		}

		// Border.
		$this->atts['border_width'] = Responsive_Spacing::parse($this->atts['border_width'], [$this->atts['border_style'], $this->atts['border_color']] );
		if ( ! empty( $this->atts['border_width']['desktop'] ) ) {
			aheto_add_props($css['global'][$selector], $this->atts['border_width']['desktop'] );
		}

		if ( ! empty( $this->atts['border_width']['laptop'] ) ) {
			aheto_add_props($css[$breakpoint_md][$selector], $this->atts['border_width']['laptop'] );
		}

		if ( ! empty( $this->atts['border_width']['tablet'] ) ) {
			aheto_add_props($css[$breakpoint_sm][$selector], $this->atts['border_width']['tablet'] );
		}

		if ( ! empty( $this->atts['border_width']['mobile'] ) ) {
			aheto_add_props($css[$breakpoint_xs][$selector], $this->atts['border_width']['mobile'] );
		}

		// Border Radius.
		if ( isset($this->atts['border_radius'] ) ) {
			$this->atts['border_radius'] = Responsive_Spacing::parse($this->atts['border_radius'], 'border-radius');
			if ( ! empty( $this->atts['border_radius']['desktop'] ) ) {
				aheto_add_props($css['global'][$selector], $this->atts['border_radius']['desktop'] );
			}

			if ( ! empty( $this->atts['border_radius']['laptop'] ) ) {
				aheto_add_props($css[$breakpoint_md][$selector], $this->atts['border_radius']['laptop'] );
			}

			if ( ! empty( $this->atts['border_radius']['tablet'] ) ) {
				aheto_add_props($css[$breakpoint_sm][$selector], $this->atts['border_radius']['tablet'] );
			}

			if ( ! empty( $this->atts['border_radius']['mobile'] ) ) {
				aheto_add_props($css[$breakpoint_xs][$selector], $this->atts['border_radius']['mobile'] );
			}
		}

		// Z-Index.
		if ( ! empty( $this->atts['zindex'] ) ) {
			$css['global'][$selector]['z-index'] = $this->atts['zindex'];
		}

		// Background.
		if ( isset( $this->atts['bgtype'] ) && 'gradient' === $this->atts['bgtype'] ) {
			$css['global'][$selector]['background-color'] = 'transparent';

			if ( isset( $this->atts['gtype'] ) && 'radial' === $this->atts['gtype'] ) {
				$css['global'][$selector]['background-image'] = sprintf(
					'radial-gradient(at %1$s, %2$s %3$s, %4$s %5$s)',
					$this->atts['gradial_position'],
					Sanitize::color( $this->atts['gcolor1'] ),
					Sanitize::size( $this->atts['gcolor1_loc'], '%' ),
					Sanitize::color( $this->atts['gcolor2'] ),
					Sanitize::size( $this->atts['gcolor2_loc'], '%' )
				);
			} else {
				$css['global'][$selector]['background-image'] = sprintf(
					'linear-gradient(%1$sdeg, %2$s %3$s, %4$s %5$s)',
					$this->atts['glinear_angle'],
					Sanitize::color( $this->atts['gcolor1'] ),
					Sanitize::size( $this->atts['gcolor1_loc'], '%' ),
					Sanitize::color( $this->atts['gcolor2'] ),
					Sanitize::size( $this->atts['gcolor2_loc'], '%' )
				);
			}

		} else {
			if ( ! empty( $this->atts['bgcolor'] ) ) {
				$css['global'][$selector]['background-color'] = $this->atts['bgcolor'];
			}
			if ( ! empty( $this->atts['bgimage'] ) ) {
				$css['global'][$selector]['background-image']    = 'url(' . wp_get_attachment_url($this->atts['bgimage'] ) . ')';
				$css['global'][$selector]['background-position'] = 'center';
				$css['global'][$selector]['background-repeat']   = 'no-repeat';
			}
			if ( ! empty( $this->atts['bgstyle'] ) ) {
				$css['global'][$selector]['background-size'] = $this->atts['bgstyle'];
			}
		}


		return $css;
	}

	/**
	 * Get typography.
	 *
	 * @param  array $value Value to parse.
	 * @return array
	 */
	public function parse_typography($value) {
		$value = vc_parse_multi_attribute(str_replace('_', '-', $value));

		if ( 'Use default:regular' !== $value['font-family'] ) {
			if ( isset($value['font-family'] ) ) {
				$value['font-family'] = explode(':', $value['font-family'] );
				$value['font-family'] = $value['font-family'][0];
			}

			if ( isset($value['font-style'] ) ) {
				$value['font-style']  = explode(':', $value['font-style'] );
				$value['font-weight'] = $value['font-style'][1];
				$value['font-style']  = $value['font-style'][2];
			}
		} else {
			unset($value['font-family'], $value['font-style'] );
		}

		if ( isset($value['font-size'] ) ) {
			$value['font-size'] = Sanitize::size($value['font-size'] );
		}

		return $value;
	}

	/**
	 * set template slug
	 * @return string
	 */
	protected function get_template_name() {
		$template = ! empty( $this->group) ? $this->group . '_' : '';
//	    return $template . 'template-' . str_replace('aheto_', '', $this->slug);
		return 'template-' . str_replace('aheto_', '', $this->slug);
	}

	protected function merge_with_child() {


		if ( ! empty( $this->child_shortcodes) ) {

			foreach ( $this->child_shortcodes as $child_shortcode ) {
//                $this->params['banners']['params'] = array_merge( $this->params['banners']['params'], $child_shortcode->getSettings()['params'] );

//                print_r( $child_shortcode->params );die;
				foreach ( $child_shortcode->params as $key => $val ) {
					$this->params['banners']['params'][$key] = $val;


					if ( $key == 'icon_position' ) {
						break;
					}
				}
			}

			if ( isset($this->params['banners'] ) ) {

//                print_r( $this->params['banners']['params'] );die;
			}
		}
	}

	public function get_shortcode_name() {
		return ! empty( $this->slug) ? explode('_', $this->slug)[1] : '';
	}

	/**
	 * add the children shortcode in main shortcode
	 *
	 * @param $name
	 */
	public function set_child_shortcode($name, $group = '') {
		$class = '\Aheto\Shortcodes\\' . $name;

		if ( !isset($this->child_shortcodes[$name] ) && class_exists($class) ) {

			$shortcode        = new $class();
			$shortcode->group = $group;
			$shortcode->setup();
//            $shortcode->set_params();
			$this->child_shortcodes[$name] = $shortcode;
		}
	}

	/**
	 * returns the children shortcode
	 *
	 * @param $name
	 * @return bool|mixed
	 */
	public function get_child_shortcode($name) {
		if ( isset($this->child_shortcodes[$name] ) ) {
			return $this->child_shortcodes[$name];
		}

		return false;
	}

	public function show_child_shortcode($name) {
		if ( $shortcode = $this->get_child_shortcode($name) ) {
			echo $shortcode->render($this->atts);
		}
	}
}
