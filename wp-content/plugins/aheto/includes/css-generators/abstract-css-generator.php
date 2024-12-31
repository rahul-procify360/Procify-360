<?php
/**
 * The CSS Generator abstract
 *
 * @since      1.0.0
 * @package    Aheto\CSS\Generator
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CSS\Generator;

defined( 'ABSPATH' ) || exit;

use Aheto\Traits\Hooker;

/**
 * [abstract description]
 */
abstract class Generator implements Parser {

	use Hooker;

	/**
	 * Builder slug.
	 *
	 * @var string
	 */
	protected $slug = '';

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->filter( 'save_post', 'generate', 10, 1 );
	}

	/**
	 * Save css
	 *
	 * @param int $post_id Current post id.
	 */
	public function generate( $post_id ) {
		if ( wp_is_post_revision( $post_id ) || 'publish' !== get_post( $post_id )->post_status || is_attachment( $post_id ) ) {
			return;
		}

		$header_id = (int) get_post_meta( $post_id, 'header_id', true );
		$footer_id = (int) get_post_meta( $post_id, 'footer_id', true );

		$header_id = ! empty( $header_id ) ? $header_id : 0;
		$footer_id = ! empty( $footer_id ) ? $footer_id : 0;

		$post_type = get_post_type( $post_id );

		if ( ( $post_type !== 'aheto-header' ) && ( $post_type !== 'aheto-footer' ) ) {
			$this->generate_css_headers_footer( $post_id, $header_id, $footer_id );
		}
		/* For headers / footers - no pages
		else {
			$this->generate_css( $post_id );
		}
		*/

	}

	/**
	 * Return the generated css file uri
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return bool|mixed|string
	 */
	public function get_file_uri( $post_id ) {
		if ( is_array( $post_id ) ) {
			return false;
		}

		$css_url = get_transient( "aheto_shortcode_css_{$post_id}_{$this->slug}" );
		if ( false === $css_url ) {
			$css_url = $this->generate_css( $post_id );
		}

		return $css_url;
	}

	/**
	 * Function getting generated css file uri via header and footer
	 *
	 * @param $post_id
	 * @param $header_id
	 * @param $footer_id
	 *
	 * @return bool|mixed|null
	 */
	public function get_file_headers_footer( $post_id, $header_id, $footer_id ) {
		if ( is_array( $post_id ) ) {
			return false;
		}

		$css_url = get_transient( "aheto_shortcode_css_{$post_id}_{$this->slug}" );
		if ( false === $css_url ) {
			$css_url = $this->generate_css_headers_footer( $post_id, $header_id, $footer_id );
		}

		return $css_url;
	}

	/**
	 * Collect all the css files in one.
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return mixed|null
	 */
	private function generate_css( $post_id ) {
		$all_css = '';
		if ( ! empty( $_POST['actions'] ) ) {
			$content = json_decode( stripslashes( $_POST['actions'] ), true );
		}

		$layouts_data = array();
		$elements     = ( isset( $content['save_builder']['data']['elements'] ) ) ? $content['save_builder']['data']['elements'] : [];

		$this->recursive_headers_footer( $elements, $layouts_data );

		update_post_meta( $post_id, 'layouts', $layouts_data );

		foreach ( $layouts_data as $shortcode => $layouts ) {
			foreach ( $layouts as $layout => $index ) {
				if ( file_exists( $path = $this->get_shortcode_css( $shortcode, $layout ) ) ) { // phpcs:ignore
					$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
					$all_css .= $css;
				} elseif ( file_exists( $path = $this->get_theme_css( $shortcode, $layout ) ) ) { // phpcs:ignore
					$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
					$all_css .= $css;
				} elseif ( file_exists( $path = $this->get_shortcode_css( $shortcode, 'main-css' ) ) ) { // phpcs:ignore

					/*
					 * When the css file is one for all layouts
					*/

					$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
					$all_css .= $css;
				}

			}
		}

		$post_type = get_post_type( $post_id );
		$css_url   = '';


		if ( $post_type == 'page') {
			$css_url = $this->create_file( $all_css, $post_id );
			$this->set_transient( $post_id, $css_url );
		}


		return $css_url;
	}

	/**
	 * Collect all the css files in one.
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return mixed|null
	 */
	private function generate_css_headers_footer( $post_id, $header_id, $footer_id ) {
		$all_css = '';
//		$layouts_data = $this->parse_content( $post_id ); - old version

		$layouts_data = $this->parse_header_footer_data( $post_id );
		$header_data  = $this->parse_header_footer_data( $header_id );
		$footer_data  = $this->parse_header_footer_data( $footer_id );

		if ( ! empty( $layouts_data ) ) {
			foreach ( $layouts_data as $shortcode => $layouts ) {
				foreach ( $layouts as $layout => $index ) {
					if ( file_exists( $path = $this->get_shortcode_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_theme_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_shortcode_css( $shortcode, 'main-css' ) ) ) { // phpcs:ignore
						/*
						 * When the css file is one for all layouts
						*/

						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					}
				}
			}
		}

		if ( ! empty( $header_data ) ) {
			foreach ( $header_data as $shortcode => $layouts ) {
				foreach ( $layouts as $layout => $index ) {
					if ( file_exists( $path = $this->get_shortcode_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_theme_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_shortcode_css( $shortcode, 'main-css' ) ) ) { // phpcs:ignore
						/*
						 * When the css file is one for all layouts
						 *
						 */

						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					}
				}
			}
		}

		if ( ! empty( $footer_data ) ) {
			foreach ( $footer_data as $shortcode => $layouts ) {
				foreach ( $layouts as $layout => $index ) {
					if ( file_exists( $path = $this->get_shortcode_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_theme_css( $shortcode, $layout ) ) ) { // phpcs:ignore
						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					} elseif ( file_exists( $path = $this->get_shortcode_css( $shortcode, 'main-css' ) ) ) { // phpcs:ignore
						/*
						 * When the css file is one for all layouts
						 */

						$css     = file_get_contents( $path, FILE_USE_INCLUDE_PATH );
						$all_css .= $css;
					}
				}
			}
		}

		$css_url = $this->create_file( $all_css, $post_id );
		$this->set_transient( $post_id, $css_url );

		return $css_url;
	}

	/**
	 * Function parsing header footer posts data
	 *
	 * @param $id
	 *
	 * @return array
	 */
	private function parse_header_footer_data( $id ) {

		$get_data_type = get_post_meta( $id, '_elementor_data', true );
		$get_data = !is_array($get_data_type) ? json_decode( get_post_meta( $id, '_elementor_data', true ), true ) : $get_data_type;
		$array    = array();

		$this->recursive_headers_footer( $get_data, $array );

		return $array;
	}

	/**
	 * Recursive Function getting layouts
	 *
	 * @param $elements
	 * @param $data
	 */
	private function recursive_headers_footer( $elements, &$data ) {

	// "Commented" I have deactivated Deactivated Layouts.
	//	$deactivated_layouts = apply_filters( 'aheto_active_leyouts', array() );


		if ( ! empty( $elements ) ) {
			foreach ( $elements as $element ) {

				if ( isset( $element['widgetType'] ) && ! empty( $element['widgetType'] ) ) {

					$shortcode_all_layouts = $this->get_all_layouts_by_shortcode( $element['widgetType'] );

					$shortcode_all_layouts = ( ! empty( $shortcode_all_layouts ) ) ? $shortcode_all_layouts : array();

					if ( ! isset( $data[ $element['widgetType'] ] ) ) {
						$data[ $element['widgetType'] ] = [];
					}

					if ( empty( $deactivated_layouts[ $element['widgetType'] ] ) || ! empty( $element['settings']['template'] ) ) {
						$template = ( ! empty( $element['settings']['template'] ) ) ? $element['settings']['template'] : 'view';
					} else {
						$first_element = $this->get_key_first_layout( $element['widgetType'], $shortcode_all_layouts, $deactivated_layouts );
						$template      = ( empty( $first_element ) ) ? 'view' : $first_element;
					}

					$data[ $element['widgetType'] ][ $template ] = true;
				}

				if ( isset( $element['elements'] ) && ! empty( $element['elements'] ) ) {
					$this->recursive_headers_footer( $element['elements'], $data );
				}
			}
		}
	}

	/**
	 * Generate a common css file for all shortcodes.
	 *
	 * @param string $css_code Generated css.
	 * @param int $post_id Current post id.
	 *
	 * @return string
	 */
	private function create_file( $css_code, $post_id ) {
		if ( empty( $css_code ) ) {
			return false;
		}

		// Get the blog ID.
		$blog_id = 1;
		if ( is_multisite() ) {
			$current_site = get_blog_details();
			$blog_id      = $current_site->blog_id;
		}

		// Get the upload directory for this site.
		$upload_dir = wp_upload_dir();

		// If this is a multisite installation, append the blogid to the filename.
		$blog_id   = ( is_multisite() && $blog_id > 1 ) ? '-blog-' . $blog_id : null;
		$file_name = 'aheto' . $blog_id . '-' . $post_id . '-' . $this->slug . '.css';
		// The complete path to the file.
		$file_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles' . DIRECTORY_SEPARATOR . $file_name;
		if ( file_exists( $file_path ) ) {
			unlink( $file_path );
		}

		$css_code = str_replace( "\n", '', $css_code );
		$result   = file_put_contents( $file_path, $css_code );
		chmod( $file_path, 0777 );

		if ( $result ) {
			// Build the URL of the file.
			return trailingslashit( $upload_dir['baseurl'] ) . 'aheto-styles/' . $file_name;
		}

		return false;
	}

	/**
	 * Get all layout by shortcode from plugins and themes
	 *
	 * @param $shortcode
	 *
	 * @return array
	 */
	private function get_all_layouts_by_shortcode( $shortcode ) {

		$short_name = explode( 'aheto_', $shortcode );

		if (!isset($short_name[1]))
			return true;

		$short_name = $short_name[1];


		$plugins_dir = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'aheto' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . $short_name;
		$addon_dir   = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'aheto-wdsg-add-ons' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . $short_name;
		$themes_dir  = get_template_directory() . DIRECTORY_SEPARATOR . 'aheto' . DIRECTORY_SEPARATOR . $short_name;

		$all_layouts = array();
		$dirs_plugin = ( is_dir( $plugins_dir ) ) ? scandir( $plugins_dir ) : array();
		$dirs_themes = ( is_dir( $themes_dir ) ) ? scandir( $themes_dir ) : array();
		$dirs_addon  = ( is_plugin_active(WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'aheto-wdsg-add-ons/index.php') && is_dir( $addon_dir ) ) ? scandir( $addon_dir ) : array();

		$plugins_data = ( ! empty( $dirs_plugin ) ) ? $this->get_from_dirs( $dirs_plugin, $short_name ) : array();
		$themes_data  = ( ! empty( $dirs_themes ) ) ? $this->get_from_dirs( $dirs_themes, $short_name ) : array();
		$addon_data   = ( ! empty( $dirs_addon ) ) ? $this->get_from_dirs( $dirs_addon, $short_name ) : array();

		if ( ! empty( $plugins_data ) || ! empty( $themes_data ) || ! empty( $addon_data ) ) {
			$all_layouts = array_merge( $plugins_data, $themes_data, $addon_data );
		}

		return $all_layouts;

	}

	/**
	 * Function getting layouts by shortcode name ( from plugin folder and theme folder )
	 *
	 * @param $dirs
	 * @param $short_name
	 *
	 * @return array
	 */
	private function get_from_dirs( $dirs, $short_name ) {

		$layouts = array();
		foreach ( $dirs as $dir ) {
			$pos  = strpos( $dir, $short_name );
			$pos1 = strpos( $dir, 'layout' );

			// TODO
			// Replace  strpos to another function for futire version PHP ( chr() for example )

			if ( ( $dir == '.' ) || ( $dir == '..' ) || ( $dir == 'assets' ) || ( $dir == 'previews' ) || ( $pos !== false ) || ( $pos == 'controllers' ) ) {
				continue;
			} elseif ( $pos1 !== false ) {
				$key             = str_replace( '.php', '', $dir );
				$layouts[ $key ] = true;
			}
		}

		return $layouts;

	}

	/**
	 * Function getting first active layout of shortcode
	 *
	 * @param $active
	 * @param $all
	 *
	 * @return int|string|null
	 */
	private function get_key_first_layout( $widget_type, $all, $deactivated ) {

		$res = array();
		foreach ( $all as $layout => $v ) {
			if ( ! in_array( $layout, $deactivated[ $widget_type ] ) ) {
				$res[] = $layout;
			}
		}

		foreach ( $res as $key => $layouts ) {
			return $layouts;
		}

		return null;
	}

	/**
	 * Return the path to the CSS file.
	 *
	 * @param string $shortcode Shortcode slug.
	 * @param string $layout Layout name.
	 *
	 * @return string
	 */
	private function get_shortcode_css( $shortcode, $layout ) {
		$shortcode = str_replace( 'aheto_', '', $shortcode );

		return aheto()->plugin_dir() . "shortcodes/{$shortcode}/assets/css/{$layout}.css";
	}

	/**
	 * Return the path to the CSS file from theme.
	 *
	 * @param string $shortcode Shortcode slug.
	 * @param string $layout Layout name.
	 *
	 * @return string
	 */
	private function get_theme_css( $shortcode, $layout ) {
		$shortcode = str_replace( 'aheto_', '', $shortcode );

		return get_template_directory() . "/aheto/{$shortcode}/assets/css/{$layout}.css";
	}

	/**
	 * Set transient for url css file
	 *
	 * @param int $post_id Current post id.
	 * @param string $uri Url.
	 */
	private function set_transient( $post_id, $uri ) {
		$name = "aheto_shortcode_css_{$post_id}_{$this->slug}";
		delete_transient( $name );
		set_transient( $name, $uri, DAY_IN_SECONDS * 30 );
	}

}
