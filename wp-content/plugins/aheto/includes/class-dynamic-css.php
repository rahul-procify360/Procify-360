<?php
/**
 * The skin generator.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helper;
use Aheto\Traits\Hooker;
use Aheto\Admin\Options;

defined( 'ABSPATH' ) || exit;

/**
 * Handle generating the dynamic CSS.
 *
 * @link    http://aristath.github.io/css/wordpress/2015/04/05/optimize-inline-css.html
 * @link    http://aristath.github.io/blog/avoid-dynamic-css-in-head
 */
class Dynamic_CSS {

	use Hooker;

	/**
	 * The Constructor
	 *
	 * @param string $skin    Skin key.
	 * @param array  $options Skin options.
	 */
	public function __construct( $skin, $options ) {
		$this->skin    = $skin;
		$this->options = $options;

		$this->make_dynamic_css( 'dynamic' );
		$this->make_dynamic_css( 'dynamic_admin' );
	}

	/**
	 * This function takes care of creating the CSS.
	 */
	private function make_dynamic_css( $type ) {
		$wp_filesystem = Helper::init_filesystem();

		// Creates the content of the CSS file.
		// We're adding a warning at the top of the file to prevent users from editing it.
		// The warning is then followed by the actual CSS content.
		if ( $type == 'dynamic' ) {
			$content = $this->calculate_dynamic_css();
		}
		elseif ( $type == 'dynamic_admin' ) {
			$this->skin    =  'admin-' .$this->skin;
			$content = $this->calculate_dynamic_admin_css();
		}
		// When using domain-mapping plugins we have to make sure that any references to the original domain
		// are replaced with references to the mapped domain.
		// We're also stripping protocols from these domains so that there are no issues with SSL certificates.
		if ( defined( 'DOMAIN_MAPPING' ) && DOMAIN_MAPPING ) {

			if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {

				// The mapped domain of the site.
				$mapped_domain = domain_mapping_siteurl( false );
				$mapped_domain = str_replace( [ 'https://', 'http://' ], '//', $mapped_domain );

				// The original domain of the site.
				$original_domain = get_original_url( 'siteurl' );
				$original_domain = str_replace( [ 'https://', 'http://' ], '//', $original_domain );

				// Replace original domain with mapped domain.
				$content = str_replace( $original_domain, $mapped_domain, $content );
			}
		}

		// Strip protocols. This helps avoid any issues with https sites.
		$content = str_replace( [ 'https://', 'http://' ], '//', $content );

		// Build the transient name.
		if ( $type == 'dynamic' ) {
			$transient_name = 'aheto_dynamic_css_' . $this->skin;
		}
		elseif ( $type == 'dynamic_admin' ) {
			$transient_name = 'aheto_dynamic_admin_css_' . $this->skin;
		}


		// it's safe to continue without any additional checks as to the validity of the file.
//		var_dump('$this->skin', $this->skin);die;
		//here create file!!
		if ( $this->can_write() ) {
			if ( ! $wp_filesystem->put_contents( self::file( 'path', $this->skin ), $content ) ) {
				// Writing to the file failed.
				$this->set_transient( $transient_name, $content );
			}
		} else {
			$this->set_transient( $transient_name, $content );
		}
	}

	/**
	 * Determines if the CSS file is writable.
	 *
	 * @return bool
	 */
	private function can_write() {

		// Get the blog ID.
		$blog_id = 1;
		if ( is_multisite() ) {
			$current_site = get_blog_details();
			$blog_id      = $current_site->blog_id;
		}

		// Get the upload directory for this site.
		$upload_dir = wp_upload_dir();

		// If this is a multisite installation, append the blogid to the filename.
		$blog_id     = ( is_multisite() && $blog_id > 1 ) ? '-blog-' . $blog_id : null;
		$file_name   = '/aheto' . $blog_id . '-' . $this->skin . '.css';
		$folder_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles';

		// Does the folder exist?
		if ( file_exists( $folder_path ) ) {

			// Folder exists, but is it actually writable?
			if ( ! is_writable( $folder_path ) ) {

				// Folder is not writable.
				// Does the file exist?
				if ( ! file_exists( $folder_path . $file_name ) ) {

					// If the file does not exist, then we can't create it
					// since its parent folder is not writable.
					return false;
				} else {

					// The file exists. Is it writable?
					if ( ! is_writable( $folder_path . $file_name ) ) {

						// Nope, it's not writable.
						return false;
					}
				}
			} else {

				// The folder is writable.
				// Does the file exist?
				if ( file_exists( $folder_path . $file_name ) ) {

					// File exists. Is it writable?
					if ( ! is_writable( $folder_path . $file_name ) ) {

						// Nope, it's not writable.
						return false;
					}
				}
			}
		} else {
			// Can we create the folder?
			// returns true if yes and false if not.
			return wp_mkdir_p( $folder_path );
		}

		// If we passed all of the above tests
		// then the file is writable.
		return true;
	}

	/**
	 * Delete skin file.
	 *
	 * @param string $skin_id Skin id.
	 *
	 * @return bool
	 */
	public static function delete( $skin_id ) {
		$wp_filesystem = Helper::init_filesystem();
		return $wp_filesystem->delete( self::file( 'path', $skin_id ) );
	}

	/**
	 * Gets the css path or url to the stylesheet.
	 *
	 * @param string $target Path or Uri.
	 * @param string $skin   Skin name to genrate filename for.
	 *
	 * @return string Path or url to the file depending on the $target var.
	 */
	public static function file( $target = 'path', $skin = '' ) {

		// Get the blog ID.
		$blog_id = 1;
		if ( is_multisite() ) {
			$current_site = get_blog_details();
			$blog_id      = $current_site->blog_id;
		}

		// Get the upload directory for this site.
		$upload_dir = wp_upload_dir();

		// If this is a multisite installation, append the blogid to the filename.
		$blog_id     = ( is_multisite() && $blog_id > 1 ) ? '-blog-' . $blog_id : null;
		$file_name   = 'aheto' . $blog_id . '-' . $skin . '.css';
		$folder_path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles';

		// The complete path to the file.
		$file_path = $folder_path . DIRECTORY_SEPARATOR . $file_name;

		// Get the URL directory of the stylesheet.
		$css_uri_folder = $upload_dir['baseurl'];

		// Build the URL of the file.
		$css_uri = trailingslashit( $css_uri_folder ) . 'aheto-styles/' . $file_name;

		// Take care of domain mapping.
		// When using domain mapping we have to make sure that the URL to the file
		// does not include the original domain but instead the mapped domain.
		if ( defined( 'DOMAIN_MAPPING' ) && DOMAIN_MAPPING ) {
			if ( function_exists( 'domain_mapping_siteurl' ) && function_exists( 'get_original_url' ) ) {
				$mapped_domain   = domain_mapping_siteurl( false );
				$original_domain = get_original_url( 'siteurl' );
				$css_uri         = str_replace( $original_domain, $mapped_domain, $css_uri );
			}
		}

		// Strip protocols from the URL.
		// Make sure we don't have any issues with sites using HTTPS/SSL.
		$css_uri = str_replace( 'https://', '//', $css_uri );
		$css_uri = str_replace( 'http://', '//', $css_uri );

		// Return the path or the URL
		// depending on the $target we have defined when calling this method.
		if ( 'path' === $target ) {
			return $file_path;
		}

		$timestamp = ( file_exists( $file_path ) ) ? '?timestamp=' . filemtime( $file_path ) : '';
		return $css_uri . $timestamp;
	}

	/**
	 * Save dynamic css to trasient.
	 *
	 * @param string $transient_name Transient key.
	 * @param string $content        Dynamic CSS.
	 */
	private function set_transient( $transient_name, $content ) {
		delete_transient( $transient_name );
		set_transient( $transient_name, $content );
	}

	/**
	 * Dynamic CSS Generator -------------------------------------------------
	 */

	/**
	 * Caluclate dynamic css
	 *
	 * @return string
	 */
	private function calculate_dynamic_css() {

		include_once aheto()->plugin_dir() . 'includes/dynamic-css.php';

		$css_array 		 = $this->do_filter( 'dynamic_css_array', 		aheto_dynamic_css_array ( $this->options ) );

		$dynamic_css  = "/********* Compiled - Do not edit *********/\n";
		$dynamic_css .= $this->get_dynamic_css( $css_array ) . "\n";
		$dynamic_css .= '/* cached */';

		return $dynamic_css;
	}


	/**
	 * Caluclate dynamic admin css
	 *
	 * @return string
	 */
	private function calculate_dynamic_admin_css() {

		include_once aheto()->plugin_dir() . 'includes/dynamic-css.php';
		$css_admin_array = $this->do_filter( 'dynamic_admin_css_array', aheto_dynamic_admin_css_array ( $this->options ) );

		$dynamic_admin_css  = "/********* Compiled - Do not edit *********/\n";
		$dynamic_admin_css .= $this->get_dynamic_admin_css( $css_admin_array ) . "\n";
		$dynamic_admin_css .= '/* cached */';

		return $dynamic_admin_css;
	}

	/**
	 * Get dynamically-generated CSS.
	 *
	 * @param array $css The CSS array.
	 *
	 * @return string
	 */
	private function get_dynamic_css( $css ) {
		if ( ! empty( $css['google_fonts'] ) ) {
			set_transient( 'aheto_google_fonts_' . $this->skin, $css['google_fonts'] );
		}
		unset( $css['google_fonts'] );
		return $this->do_filter( 'dynamic_css', Helper::dynamic_css_parser( $css ) );
	}

	/**
	 * Get dynamically-generated CSS.
	 *
	 * @param array $css The CSS array.
	 *
	 * @return string
	 */
	private function get_dynamic_admin_css( $css ) {
		if ( ! empty( $css['google_fonts'] ) ) {
			set_transient( 'aheto_google_fonts_' . $this->skin, $css['google_fonts'] );
		}
		unset( $css['google_fonts'] );
		return $this->do_filter( 'dynamic_admin_css', Helper::dynamic_css_parser( $css ) );
	}
}
