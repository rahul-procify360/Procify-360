<?php

namespace Aheto;
//use Aheto\Template_Kit\API;

class Generate_elementor_admin_css
{

	private $plugins_dir;
	private $addons_dir;
	private $themes_dir;
	private $plugins_vendors_dir;
	private $general_css;
	private $script_js;
	private $skins_dir;
	private $css;
	private $js;
	public static $css_name = 'aheto-elementor-css.css';
	public static $js_name  = 'aheto-elementor-js.js';

	/**
	 * Generate_elementor_admin_css constructor.
	 *
	 * @param $plugin
	 */
	public function __construct( $plugin ){

		$this->plugins_dir           = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR .'aheto' . DIRECTORY_SEPARATOR . 'shortcodes';
		$this->addons_dir            = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR .'aheto-wdsg-add-ons' . DIRECTORY_SEPARATOR . 'shortcodes';
		$this->plugins_vendors_dir   = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR .'aheto' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'vendors';
		$this->skins_dir             = get_template_directory() . DIRECTORY_SEPARATOR .'aheto/shortcodes/custom-post-types/assets/css';
		$this->themes_dir  		     = get_template_directory() . DIRECTORY_SEPARATOR .'aheto';
		$this->general_css 		     = get_template_directory() . DIRECTORY_SEPARATOR .'assets' . DIRECTORY_SEPARATOR .'css' . DIRECTORY_SEPARATOR . 'general.css';
		$this->script_js             = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR .'aheto' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'vendors' .  DIRECTORY_SEPARATOR .'script.min.js';
		$is_active = $plugin['name'] == 'Elementor';


		if ( ! $is_active ) {
			return;
		}

		if ( $this->elementor_file_exist( self::$css_name ) ) {
			self::delete_existed_file( self::$css_name );
		}

		if ( $this->elementor_file_exist( self::$js_name )  ) {
			self::delete_existed_file( self::$js_name );
		}

		if ( $this->aheto_demo_file_exist() ) {
			self::delete_aheto_demo_file();
		}


//		$template_kit = API::get();
//		$allowed_theme     = apply_filters( 'aheto_template_kit_category', false );
//		$templates = array();
//
//
//		if (isset($_GET['category_id'])) {
//			$category_id = $_GET['category_id'];
//			$templates    = $template_kit->get_templates("",$category_id,"pages","");
//		}
//		else {
//			$templates    = $template_kit->get_themes_grouped();
//		}

		$this->css = $this->pass_all_shortcode_css();
		$this->js  = $this->pass_all_shortcode_js();
		$this->create_css_file( $this->css );
		$this->create_js_file( $this->js );

	}

	/**
	 * Function deleting existed file
	 *
	 * @param $file
	 */
	public function delete_existed_file ( $file ) {
		$file_path  = self::aheto_upload_dir() . DIRECTORY_SEPARATOR .  $file;
		unlink( $file_path );
	}

	/**
	 * Function checking if file exists
	 *
	 * @param $file_name
	 * @return bool
	 */
	public function elementor_file_exist( $file_name ) {
		$folder_path = self::aheto_upload_dir();
		$file_path   = $folder_path . DIRECTORY_SEPARATOR . $file_name;
		return file_exists( $file_path );
	}

	/**
	 * Function checking if file exists
	 *
	 * @param $file_name
	 * @return bool
	 */
	public function aheto_demo_file_exist( ) {
		$folder_path = self::aheto_demo_upload_dir();

		$files = is_dir($folder_path) ? scandir($folder_path) : '';
		$files = !empty($files) ? array_diff( $files, array('.', '..', '.DS_Store') ) : '';

		return is_array($files) && count($files) > 0 ? true : false;
	}


	/**
	 * Function deleting existed file
	 *
	 * @param $file
	 */
	public function delete_aheto_demo_file ( ) {

		$file_path  = self::aheto_demo_upload_dir() . DIRECTORY_SEPARATOR . '*';

		$files = glob($file_path);

		if(is_array($files) && count($files)){

			foreach($files as $file){

				if(is_file($file)) {
					unlink($file);
				}

			}
		}
	}

	/**
	 * Function gettong upload dir path
	 *
	 * @return string
	 */
	public static function aheto_upload_dir() {
		$upload_dir = wp_upload_dir();
		return $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles';
	}

	/**
	 * Function gettong upload dir path
	 *
	 * @return string
	 */
	public static function aheto_demo_upload_dir() {
		$upload_dir = wp_upload_dir();
		return $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-demo';
	}

	/**
	 * Function gettong upload url path
	 *
	 * @return string
	 */
	public static function aheto_upload_url() {
		$upload_dir = wp_upload_dir();
		return $upload_dir['baseurl'] . '/aheto-styles';
	}

	/**
	 * Function getting shortodes folders data
	 *
	 * @param $type
	 * @return array
	 */
	private function get_shortcode_path_data( $type ) {
		$dirs_plugin   = ( is_dir( $this->plugins_dir ) && file_exists( $this->plugins_dir ) ) ? scandir( $this->plugins_dir ) : '';
		$dirs_addons   = ( is_dir( $this->addons_dir ) && file_exists( $this->addons_dir ) )   ? scandir( $this->addons_dir )  : '';
		$dirs_themes   = ( is_dir( $this->themes_dir ) && file_exists( $this->themes_dir ) )   ? scandir( $this->themes_dir )  : '';
		$vendor_plugin = ( is_dir( $this->plugins_vendors_dir ) && file_exists( $this->plugins_vendors_dir ) ) ? scandir( $this->plugins_vendors_dir ) : '';
		$skins_dir     = ( is_dir( $this->skins_dir ) && file_exists( $this->skins_dir ) ) ? scandir( $this->skins_dir ) : '';

		$res = [];

		if ( !empty( $dirs_plugin ) ) {
			foreach ( $dirs_plugin as $dir ) {
				if ( $dir == '.' || $dir == '..' ) continue;

				$key = $this->plugins_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $type;
				if ( file_exists( $key ) && is_dir( $key ) ) {
					$res[$key] = scandir( $key );
				}
			}
		}

		if ( !empty( $vendor_plugin ) ) {
			foreach ( $vendor_plugin as $dir ) {
				if ( $dir == '.' || $dir == '..' ) continue;

				$key =  $this->plugins_vendors_dir . DIRECTORY_SEPARATOR . $dir;
				if ( file_exists( $key ) && is_dir( $key ) ) {
					$res[ $key ] = scandir( $key );
				}
			}
		}

		if ( !empty( $dirs_themes ) ) {
			foreach ( $dirs_themes as $dir ) {
				if ( $dir == '.' || $dir == '..' ) continue;

				$key = $this->themes_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $type;
				if ( $key && file_exists( $key ) && is_dir( $key ) ) {
					$res[$key] = scandir( $key );
				}
			}
		}
		if ( !empty( $dirs_addons ) ) {
			foreach ( $dirs_addons as $dir ) {
				if ( $dir == '.' || $dir == '..' ) continue;

				$key = $this->addons_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $type;
				if ( $key && file_exists( $key ) && is_dir( $key ) ) {
					$res[$key] = scandir( $key );
				}
			}
		}

		if ( !empty( $skins_dir ) ) {
			foreach ( $skins_dir as $dir ) {
				if ( $dir == '.' || $dir == '..' ) continue;

				$key = $skins_dir;

				if ( $key && file_exists( $key ) && is_dir( $key ) ) {
					$res[$key] = scandir( $key );
				}
			}
		}

		return $res;
	}

	/**
	 * Function  collecting css code for shortcodes
	 *
	 * @return string
	 */
	private function pass_all_shortcode_css() {
		$css_data = $this->get_shortcode_path_data('css');
		$css = '';

		foreach ( $css_data as $path => $files ) {

			foreach ( $files as $file ) {

				$file_info = new \SplFileInfo( $file );
				if ( $file_info->getExtension() == 'css' ) {
					$css .= file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
				}

			}

		}

		if ( file_exists( $this->general_css ) ) {
			$general_css = file_get_contents( $this->general_css );
			$general_css = str_replace(
				"<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' fill='%23dddddd'><polygon points='0,0 100,0 50,50'/></svg>",
				'',
				$general_css
			);
			$css .= $general_css;
		}

		$css1 = str_replace( "\n", '', $css );

		return $css1;
	}

	/**
	 * Function  collecting js code for shortcodes
	 *
	 * @return string
	 */
	private function pass_all_shortcode_js() {
		$js_data  = $this->get_shortcode_path_data('js');

		$js = '';
		$ar = [];
		foreach ( $js_data as $path => $files ) {

			foreach ( $files as $file ) {

				$file_info = new \SplFileInfo( $file );
				$pos  = strpos( $file_info->getBasename(), '.min.js');
				$name = explode( '.', $file_info->getBasename() );
				$name = $name[0];

				if ( $file_info->getExtension() == 'js' ) {

					if ( $pos !== false ) {

						if ( ( !isset( $ar[$path][$name] ) ) || ( ( isset( $ar[$path][$name] ) && ( $ar[$path][$name]['type'] == 'simple' )  ) ) ) {
							$ar[$path][$name]['type'] = 'min';
							$ar[$path][$name]['path'] = $path . DIRECTORY_SEPARATOR . $file;
//								$js .= file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
						}
					}
					else {
						if ( !isset( $ar[$path][$name] ) ) {
							$ar[$path][$name]['type'] = 'simple';
							$ar[$path][$name]['path'] = $path . DIRECTORY_SEPARATOR . $file;
//								$js .= file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
						}
					}
//					$js .= file_get_contents( $path . DIRECTORY_SEPARATOR . $file );
				}
			}

		}

		foreach ( $ar as $k => $v) {

			if ( !is_array( $v ) ) {
				$js .= file_get_contents( $v['path'] );
			}

			if ( is_array( $v ) ) {
				foreach ( $v as $layout => $content ) {
					$js .= file_get_contents( $content['path'] );
				}
			}

		}

		if ( file_exists( $this->script_js ) ) {
			$script_js = file_get_contents( $this->script_js );
			$js .= $script_js;
		}

		return $js;
	}

	/**
	 * Function creating css file
	 *
	 * @param $css
	 */
	private function create_css_file( $css ) {
		$name  = self::aheto_upload_dir() . DIRECTORY_SEPARATOR . self::$css_name;
		file_put_contents( $name, $css );
		chmod( $name, 0777 );
	}

	/**
	 * Function creating js file
	 *
	 * @param $js
	 */
	private function create_js_file( $js ) {
		$name  = self::aheto_upload_dir() . DIRECTORY_SEPARATOR . self::$js_name;
		file_put_contents( $name, $js );
		chmod( $name, 0777 );
	}

}
