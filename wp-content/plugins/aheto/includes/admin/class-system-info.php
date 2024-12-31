<?php
/**
 * The class responsible for generating system info.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * System_Info class.
 */
class System_Info {

	/**
	 * Hold system info.
	 *
	 * @var array
	 */
	private $data = [];

	/**
	 * Display system info in tables.
	 */
	public function render() {
		$this->gather_data(); ?>

		<div class="aheto-system-info-header">

			<span class="get-system-status">
				<a href="#" class="custom-btn get-debug-report"><?php esc_html_e( 'Get System Report', 'aheto' ); ?></a>
			</span>

			<div id="debug-report" style="display:none;">
				<textarea id="debug-report-textarea" readonly="readonly"><?php $this->textarea_content(); ?></textarea>
				<p class="submit">
					<button id="copy-for-support" data-clipboard-target="#debug-report-textarea" class="button-primary"><?php esc_html_e( 'Copy for Support', 'aheto' ); ?></button>
				</p>
			</div>

		</div>

		<?php
		foreach ( $this->get_sections() as $id => $label ) :
			$data = $this->data[ $id ];
			?>
		<div class="aheto-system-info-section">
			<header>
<!--				<span class="icon icon---><?php //echo $id; ?><!--"></span> -->
                <strong><?php echo $label; ?></strong>
			</header>
			<ul>
				<?php foreach ( $data as $item ) : ?>
				<li>
					<label><?php echo $item['title']; ?><?php echo isset( $item['tooltip'] ) ? Helper::get_tooltip( $item['tooltip'] ) : ''; ?></label>
					<span><?php echo $item['value']; ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

			<?php
		endforeach;
	}

	/**
	 * Print system info in textarea.
	 */
	private function textarea_content() {
		foreach ( $this->get_sections() as $id => $label ) :
			$data = $this->data[ $id ];

			echo "\n### " . $label . " ###\n\n";

			foreach ( $data as $item ) {
				echo $item['title'] . ': ' . $item['value'] . "\n";
			}

		endforeach;
	}

	/**
	 * Get Section details.
	 *
	 * @return array
	 */
	private function get_sections() {
		return [
			'wordpress' => __( '<i class="green-color fas fa-sync-alt"></i><span>WordPress Environment</span>', 'aheto' ),
			'server'    => __( '<i class="yellow-color fas fa-server"></i><span>Server Environment</span>', 'aheto' ),
			'client'    => __( '<i class="pink-color fas fa-user-cog"></i><span>Client Environment</span>', 'aheto' ),
			'theme'     => __( '<i class="green-color fas fa-star"></i><span>Theme Information</span>', 'aheto' ),
			'plugins'   => __( '<i class="yellow-color fas fa-wrench"></i><span>Installed Plugins</span>', 'aheto' ),
		];
	}

	/**
	 * Gather system data according to sections.
	 */
	private function gather_data() {
		foreach ( $this->get_sections() as $id => $label ) {
			$method = "get_{$id}_data";
			if ( method_exists( $this, $method ) ) {
				$this->data[ $id ] = $this->$method();
			}
		}
	}

	/**
	 * Gather WordPress Data.
	 *
	 * @return array
	 */
	private function get_wordpress_data() {
		$data = [];

		$data[] = [
			'title'   => esc_html__( 'Home URL', 'aheto' ),
			'tooltip' => esc_html__( 'The URL of your site\'s homepage', 'aheto' ),
			'value'   => esc_url( home_url() ),
		];

		$data[] = [
			'title'   => esc_html__( 'Site URL', 'aheto' ),
			'tooltip' => esc_html__( 'The root URL of your site', 'aheto' ),
			'value'   => esc_url( site_url() ),
		];

		$data[] = [
			'title'   => esc_html__( 'WP Version', 'aheto' ),
			'tooltip' => esc_html__( 'The version of WordPress installed on your site', 'aheto' ),
			'value'   => get_bloginfo( 'version' ),
		];

		$data[] = [
			'title'   => esc_html__( 'WP Multisite', 'aheto' ),
			'tooltip' => esc_html__( 'Whether or not you have WordPress Multisite enabled', 'aheto' ),
			'value'   => is_multisite() ? esc_html__( 'Yes', 'aheto' ) : esc_html__( 'No', 'aheto' ),
		];

		$data[] = [
			'title'   => esc_html__( 'WP Memory Limit', 'aheto' ),
			'tooltip' => esc_html__( 'The maximum amount of memory (RAM) that your site can use at one time', 'aheto' ),
			'value'   => size_format( Helper::let_to_num( WP_MEMORY_LIMIT ) ),
		];

		$data[] = [
			'title'   => esc_html__( 'WP Debug Mode', 'aheto' ),
			'tooltip' => esc_html__( 'Displays whether or not WordPress is in Debug Mode', 'aheto' ),
			'value'   => defined( 'WP_DEBUG' ) && WP_DEBUG ? esc_html__( 'Enabled', 'aheto' ) : esc_html__( 'Disabled', 'aheto' ),
		];

		$data[] = [
			'title'   => esc_html__( 'WP Language', 'aheto' ),
			'tooltip' => esc_html__( 'The current language used by WordPress. Default = English', 'aheto' ),
			'value'   => get_locale(),
		];

		$wp_up  = wp_upload_dir();
		$data[] = [
			'title'   => esc_html__( 'WP Uploads Directory', 'aheto' ),
			'tooltip' => esc_html__( 'Check the upload directory is writable', 'aheto' ),
			'value'   => is_writable( $wp_up['basedir'] ) ? esc_html__( 'Writable', 'aheto' ) : esc_html__( 'Readable', 'aheto' ),
		];

		$limit  = absint( ini_get( 'memory_limit' ) );
		$usage  = function_exists( 'memory_get_usage' ) ? round( memory_get_usage() / 1024 / 1024, 2 ) : 0;
		$data[] = [
			'title'   => esc_html__( 'Memory Usage', 'aheto' ),
			'tooltip' => esc_html__( 'Current system memory usage status', 'aheto' ),
			/* translators: 1. memory usage, 2. memory limit */
			'value'   => sprintf( esc_html__( '%1$s MB OF %2$s MB', 'aheto' ), $usage, $limit ),
		];

		return $data;
	}

	/**
	 * Gather Server Data.
	 *
	 * @return array
	 */
	private function get_server_data() {
		global $wpdb;

		$data = [];

		$data[] = [
			'title'   => esc_html__( 'Server Info', 'aheto' ),
			'tooltip' => esc_html__( 'Information about the web server that is currently hosting your site', 'aheto' ),
			'value'   => esc_html( $_SERVER['SERVER_SOFTWARE'] ),
		];

		$data[] = [
			'title'   => esc_html__( 'PHP Version', 'aheto' ),
			'tooltip' => esc_html__( 'The version of PHP installed on your hosting server', 'aheto' ),
			'value'   => function_exists( 'phpversion' ) ? esc_html( phpversion() ) : esc_html__( 'Not sure', 'aheto' ),
		];

		$data[] = [
			'title'   => esc_html__( 'MYSQL Version', 'aheto' ),
			'tooltip' => esc_html__( 'The version of MySQL installed on your hosting server', 'aheto' ),
			'value'   => $wpdb->db_version(),
		];

		$data[] = [
			'title'   => esc_html__( 'PHP Post Max Size', 'aheto' ),
			'tooltip' => esc_html__( 'The largest file size that can be contained in one post', 'aheto' ),
			'value'   => size_format( Helper::let_to_num( ini_get( 'post_max_size' ) ) ),
		];

		$data[] = [
			'title'   => esc_html__( 'PHP Max Execution Time', 'aheto' ),
			'tooltip' => esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'aheto' ),
			'value'   => ini_get( 'max_execution_time' ),
		];

		$data[] = [
			'title'   => esc_html__( 'PHP Max Input Vars', 'aheto' ),
			'tooltip' => esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads', 'aheto' ),
			'value'   => ini_get( 'max_input_vars' ),
		];

		$data[] = [
			'title'   => esc_html__( 'ZipArchive', 'aheto' ),
			'tooltip' => esc_html__( 'ZipArchive is required for importing', 'aheto' ),
			'value'   => class_exists( 'ZipArchive' ) ? esc_html__( 'Enabled', 'aheto' ) : esc_html__( 'Disabled', 'aheto' ),
		];

		$data[] = [
			'title'   => esc_html__( 'Max Upload Size', 'aheto' ),
			'tooltip' => esc_html__( 'The largest file size that can be uploaded to your WordPress installation', 'aheto' ),
			'value'   => size_format( Helper::let_to_num( ini_get( 'upload_max_filesize' ) ) ),
		];

		$time_zone = '';
		if ( date_default_timezone_get() ) {
			$time_zone = date_default_timezone_get();
		}
		if ( ini_get( 'date.timezone' ) ) {
			$time_zone .= ' ' . ini_get( 'date.timezone' );
		}
		$data[] = [
			'title' => esc_html__( 'Default Time Zone', 'aheto' ),
			'value' => $time_zone,
		];

		$data[] = [
			'title' => esc_html__( 'cURL', 'aheto' ),
			'value' => function_exists( 'curl_version' ) ? curl_version()['version'] : esc_html__( 'Not Enabled', 'aheto' ),
		];

		return $data;
	}

	/**
	 * Gather Client Data.
	 *
	 * @return array
	 */
	private function get_client_data() {
		$data = [];

		$data[] = [
			'title'   => esc_html__( 'Operating System', 'aheto' ),
			'tooltip' => esc_html__( 'Operating system you are using', 'aheto' ),
			'value'   => esc_html( $this->get_platform() ),
		];

		$data[] = [
			'title'   => esc_html__( 'Browser', 'aheto' ),
			'tooltip' => esc_html__( 'Browser you are using', 'aheto' ),
			'value'   => esc_html( $this->get_browser() ),
		];

		return $data;
	}

	/**
	 * Gather Theme Data.
	 *
	 * @return array
	 */
	private function get_theme_data() {
		$data  = [];
		$theme = wp_get_theme();

		$data[] = [
			'title' => esc_html__( 'Name', 'aheto' ),
			'value' => $theme->name,
		];

		$data[] = [
			'title' => esc_html__( 'Version', 'aheto' ),
			'value' => $theme->version,
		];

		$data[] = [
			'title' => esc_html__( 'Author', 'aheto' ),
			'value' => '<a href="' . esc_url( $theme->themeuri ) . '">' . $theme->author . '</a>',
		];

		return $data;
	}

	/**
	 * Gather Plugins Data.
	 *
	 * @return array
	 */
	private function get_plugins_data() {
		$data = [];

		$active_plugins = (array) get_option( 'active_plugins', [] );
		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', [] ) );
		}

		foreach ( $active_plugins as $plugin ) {
			$plugin_data    = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_string = '';
			$network_string = '';

			if ( ! empty( $plugin_data['Name'] ) ) {

				$data[] = [
					'title' => esc_html( $plugin_data['Name'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string,
					/* translators: author link */
					'value' => sprintf( _x( 'by %s', 'by author', 'aheto' ), $plugin_data['Author'] ),
				];
			}
		}

		return $data;
	}
	/**
	 * Get browser details.
	 *
	 * @return string
	 */
	private function get_browser() {
		$browser       = 'Unknown Browser';
		$user_agent    = $_SERVER['HTTP_USER_AGENT'];
		$browser_array = [
			'/msie/i'      => 'Internet Explorer',
			'/firefox/i'   => 'Firefox',
			'/chrome/i'    => 'Chrome',
			'/safari/i'    => 'Safari',
			'/opera/i'     => 'Opera',
			'/netscape/i'  => 'Netscape',
			'/maxthon/i'   => 'Maxthon',
			'/konqueror/i' => 'Konqueror',
			'/mobile/i'    => 'Handheld Browser',
		];

		foreach ( $browser_array as $regex => $value ) {
			if ( preg_match( $regex, $user_agent ) ) {
				$browser = $value;
				break;
			}
		}

		$version = substr( $user_agent, strpos( $user_agent, $browser ) + strlen( $browser ) + 1, 2 );
		$version = $version ? ' ' . $version : '';
		return $browser . $version;
	}

	/**
	 * Get OS details.
	 *
	 * @return string
	 */
	private function get_platform() {
		$platform   = 'Unknown OS Platform';
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$os_array   = [
			'/windows nt 10/i'      => 'Windows 10',
			'/windows nt 6.2/i'     => 'Windows 8',
			'/windows nt 6.1/i'     => 'Windows 7',
			'/windows nt 6.0/i'     => 'Windows Vista',
			'/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     => 'Windows XP',
			'/windows xp/i'         => 'Windows XP',
			'/windows nt 5.0/i'     => 'Windows 2000',
			'/windows me/i'         => 'Windows ME',
			'/win98/i'              => 'Windows 98',
			'/win95/i'              => 'Windows 95',
			'/win16/i'              => 'Windows 3.11',
			'/macintosh|mac os x/i' => 'Mac OS X',
			'/mac_powerpc/i'        => 'Mac OS 9',
			'/linux/i'              => 'Linux',
			'/ubuntu/i'             => 'Ubuntu',
			'/iphone/i'             => 'iPhone',
			'/ipod/i'               => 'iPod',
			'/ipad/i'               => 'iPad',
			'/android/i'            => 'Android',
			'/blackberry/i'         => 'BlackBerry',
			'/webos/i'              => 'Mobile',
		];

		foreach ( $os_array as $regex => $value ) {
			if ( preg_match( $regex, $user_agent ) ) {
				$platform = $value;
				break;
			}
		}

		return $platform;
	}
}
