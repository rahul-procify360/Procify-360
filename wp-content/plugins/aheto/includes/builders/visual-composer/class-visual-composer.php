<?php
/**
 * The Visual Composer Configurator.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Visual_Composer
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Visual_Composer;

use Aheto\Params;
use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Visual_Composer\Params\Typography;
use Aheto\Visual_Composer\Params\Image_Selector;
use Aheto\Visual_Composer\Params\Responsive_Spacing;

defined( 'ABSPATH' ) || exit;

/**
 * Visual_Composer base class.
 */
class Visual_Composer {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$manager = vc_manager();

		$manager->disableUpdater(); // Disable update notification.
		$manager->setEditorDefaultPostTypes( [ 'post', 'page', 'aheto-header', 'aheto-footer', 'aheto-portfolio' ] ); // Set post types.
		$manager->setCustomUserShortcodesTemplateDir( get_template_directory() . '/aheto' ); // Set new theme directory.

		$this->action( 'vc_before_init', 'remove_all_pointers' );
		$this->action( 'vc_after_init', 'add_params' );
		$this->action( 'admin_print_scripts-post.php', 'enqueue', 99 );
		$this->action( 'admin_print_scripts-post-new.php', 'enqueue', 99 );
		$this->action( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'add_unique_class', 10, 3 );
		$this->action( 'vc_shortcode_output', 'add_generated_css', 10, 4 );

		// Change shortcode template.
		$this->filter( 'vc_shortcode_set_template_vc_row', 'set_template_row' );
		$this->filter( 'vc_shortcode_set_template_vc_tta_tabs', 'set_template_tab' );
		$this->filter( 'vc_map_get_attributes', 'map_get_attributes', 10, 2 );

		// Custom Params.
		new Typography;
		new Image_Selector;
		new Responsive_Spacing;
	}

	/**
	 * Disable Instructional/Help Pointers
	 */
	public function remove_all_pointers() {
		remove_action( 'admin_enqueue_scripts', 'vc_pointer_load' );
	}

	/**
	 * Load vc scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'aheto-vc-script', aheto()->assets() . 'admin/css/visual-composer.css', null, aheto()->version );
		wp_enqueue_script( 'aheto-vc-script', aheto()->assets() . 'admin/js/visual-composer.js', [ 'jquery' ], aheto()->version, true );
	}

	/**
	 * Add extra params to builtin shortcodes.
	 */
	public function add_params() {
		$advanced_params = Params::get_prepared_param( 'advanced' );

		$width = [
			'type'       => 'textfield',
			'heading'    => __( 'Content Width', 'aheto' ),
			'param_name' => 'content_width',
			'weight'     => 2,
			'dependency' => [
				'element' => 'full_width',
				'value'   => [ 'stretch_row_content', 'stretch_row_content_no_spaces' ],
			],
		];

		vc_remove_param( 'vc_row', 'css' );
		vc_add_param( 'vc_row', $width );
		vc_add_params( 'vc_row', $advanced_params );
		\Aheto\Visual_Composer\Params\Shapes::register_param();

		vc_remove_param( 'vc_row_inner', 'css' );
		vc_add_params( 'vc_row_inner', $advanced_params );

		// Update Column Gaps.
		$column_gaps                  = \WPBMap::getParam( 'vc_row', 'gap' );
		$column_gaps['value']['None'] = 'none';
		vc_update_shortcode_param( 'vc_row', $column_gaps );
		vc_update_shortcode_param( 'vc_row_inner', $column_gaps );

		vc_remove_param( 'vc_column', 'css' );
		vc_add_params( 'vc_column', $advanced_params );

		vc_remove_param( 'vc_column_inner', 'css' );
		vc_add_params( 'vc_column_inner', $advanced_params );

		vc_remove_param( 'vc_column_text', 'css' );
		vc_add_params( 'vc_column_text', $advanced_params );

		// Tab.
		$tab_remove = [
			'css',
			'title',
			'style',
			'shape',
			'color',
			'no_fill_content_area',
			'spacing',
			'gap',
			'tab_position',
			'alignment',
			'autoplay',
			'active_section',
			'pagination_style',
			'pagination_color',
			'css_animation',
		];
		foreach ( $tab_remove as $param ) {
			vc_remove_param( 'vc_tta_tabs', $param );
		}

		$tab_remove = [
			'add_icon',
			'i_position',
			'i_type',
			'i_icon_fontawesome',
			'i_icon_openiconic',
			'i_icon_typicons',
			'i_icon_entypo',
			'i_icon_linecons',
			'i_icon_monosocial',
			'i_icon_material',
			'el_class',
		];
		foreach ( $tab_remove as $param ) {
			vc_remove_param( 'vc_tta_section', $param );
		}

		$icon_params = Params::get_prepared_param( 'icon', [
			'add_icon' => true,
			'exclude'  => [ 'align' ],
		] );
		vc_add_params( 'vc_tta_section', $icon_params );
	}

	/**
	 * Set tab template.
	 */
	public function set_template_tab() {
		return aheto()->plugin_dir() . 'includes/builders/visual-composer/shortcodes/vc_tab_container.php';
	}

	/**
	 * Set row template.
	 */
	public function set_template_row() {
		return aheto()->plugin_dir() . 'includes/builders/visual-composer/shortcodes/vc_row.php';
	}

	/**
	 * Map attributes
	 *
	 * @param  array  $atts Array of attributes.
	 * @param  string $tag  Shortcode base.
	 * @return array
	 */
	public function map_get_attributes( $atts, $tag ) {
		if ( 'vc_tta_section' === $tag && ! isset( $atts['i_position'] ) ) {
			$atts['i_position'] = '';
		}

		return $atts;
	}

	/**
	 * Add unique class to visual-composer element.
	 *
	 * @param string $classes Classes.
	 * @param string $slug    Shortcode slug.
	 * @param array  $atts    Attributes array.
	 */
	public function add_unique_class( $classes, $slug, $atts ) {
		return uniqid( "{$slug}_" ) . ' ' . $classes;
	}

	/**
	 * Add generated css for advanced tab.
	 *
	 * @param string $html   Rendered output.
	 * @param object $object Shortcode object.
	 * @param array  $atts   Array of attributes.
	 * @param string $slug   Slug of shortcode.
	 */
	public function add_generated_css( $html, $object, $atts, $slug ) {
		$only = [ 'vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner', 'vc_column_text', 'vc_tta_tabs' ];
		if ( ! in_array( $slug, $only, true ) ) {
			return $html;
		}
		$index       = strpos( $html, "{$slug}_" );
		$atts['_id'] = substr( $html, $index, strlen( $slug ) + 14 );

		return \Aheto\Helper::generate_css( $atts ) . $html;
	}
}
