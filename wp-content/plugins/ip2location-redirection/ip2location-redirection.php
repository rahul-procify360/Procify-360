<?php
/**
 * Plugin Name: IP2Location Redirection
 * Plugin URI: https://ip2location.com/resources/wordpress-ip2location-redirection
 * Description: Redirect visitors by their country.
 * Version: 1.33.0
 * Author: IP2Location
 * Author URI: https://www.ip2location.com
 * Text Domain: ip2location-redirection.
 */
$upload_dir = wp_upload_dir();
defined('FS_METHOD') || define('FS_METHOD', 'direct');
defined('IP2LOCATION_DIR') || define('IP2LOCATION_DIR', $upload_dir['basedir'] . \DIRECTORY_SEPARATOR . 'ip2location' . \DIRECTORY_SEPARATOR);
define('IPLR_ROOT', __DIR__ . \DIRECTORY_SEPARATOR);

// For development usage.
if (isset($_SERVER['DEV_MODE'])) {
	$_SERVER['REMOTE_ADDR'] = '8.8.8.8';
}

require_once IPLR_ROOT . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';

// Initial class
$ip2location_redirection = new IP2LocationRedirection();

register_activation_hook(__FILE__, [$ip2location_redirection, 'set_default_values']);

add_action('plugins_loaded', [$ip2location_redirection, 'redirect']);
// add_action('wp', [$ip2location_redirection, 'redirect']);
add_action('init', [$ip2location_redirection, 'set_locale']);
add_action('admin_enqueue_scripts', [$ip2location_redirection, 'plugin_enqueues']);
add_action('admin_init', [$ip2location_redirection, 'admin_init']);
add_action('wp_ajax_ip2location_redirection_update_ip2location_database', [$ip2location_redirection, 'update_ip2location_database']);
add_action('wp_ajax_ip2location_redirection_validate_token', [$ip2location_redirection, 'validate_token']);
add_action('wp_ajax_ip2location_redirection_validate_api_key', [$ip2location_redirection, 'validate_api_key']);
add_action('wp_ajax_ip2location_redirection_submit_feedback', [$ip2location_redirection, 'submit_feedback']);
add_action('wp_ajax_ip2location_redirection_search_post', [$ip2location_redirection, 'search_post']);
add_action('wp_ajax_ip2location_redirection_restore', [$ip2location_redirection, 'restore']);
add_action('admin_notices', [$ip2location_redirection, 'show_notice']);
add_action('wp_footer', [$ip2location_redirection, 'footer']);
add_action('admin_footer_text', [$ip2location_redirection, 'admin_footer_text']);
add_action('ip2location_redirection_hourly_event', [$ip2location_redirection, 'hourly_event']);

class IP2LocationRedirection
{
	private $session = [
		'location'    => '??',
		'lookup_mode' => '??',
		'cache'       => false,
	];

	private $debug_log = '';

	public function __construct()
	{
		// Set priority
		$this->set_priority();

		// Check for IP2Location BIN directory.
		if (!file_exists(IP2LOCATION_DIR)) {
			wp_mkdir_p(IP2LOCATION_DIR);
		}

		// Check for cache directory.
		if (!file_exists(IP2LOCATION_DIR . 'caches')) {
			wp_mkdir_p(IP2LOCATION_DIR . 'caches');
		}

		$this->debug_log = 'debug_' . hash('sha256', get_option('ip2location_redirection_private_key') . get_site_url() . get_option('admin_email')) . '.log';

		add_action('admin_menu', [$this, 'add_admin_menu']);
	}

	public function set_locale()
	{
		load_plugin_textdomain('ip2location_redirection', false, IPLR_ROOT . '/languages/');
	}

	public function add_admin_menu()
	{
		add_menu_page(__('Redirection', 'ip2location-redirection'), __('Redirection', 'ip2location-redirection'), 'manage_options', 'ip2location-redirection', [$this, 'rules_page'], 'dashicons-admin-ip2location', 31);
		add_submenu_page('ip2location-redirection', __('Rules', 'ip2location-redirection'), __('Rules', 'ip2location-redirection'), 'manage_options', 'ip2location-redirection', [$this, 'rules_page']);
		add_submenu_page('ip2location-redirection', __('IP Lookup', 'ip2location-redirection'), __('IP Lookup', 'ip2location-redirection'), 'manage_options', 'ip2location-redirection-ip-lookup', [$this, 'ip_lookup_page']);
		add_submenu_page('ip2location-redirection', __('Settings', 'ip2location-redirection'), __('Settings', 'ip2location-redirection'), 'manage_options', 'ip2location-redirection-settings', [$this, 'settings_page']);

		$this->cache_clear();
	}

	public function admin_init()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'download_ip2location_redirection_backup') {
			$results = $GLOBALS['wpdb']->get_results("SELECT option_name, option_value FROM {$GLOBALS['wpdb']->prefix}options WHERE option_name LIKE 'ip2location_redirection_%'", OBJECT);

			if ($results) {
				$options = [];

				foreach ($results as $result) {
					$options[$result->option_name] = $result->option_value;
				}

				ob_end_flush();
				header('Content-type: application/json');
				header('Content-Disposition: attachment; filename="ip2location_redirection.json"');
				exit(json_encode($options));
			}
		}
	}

	public function restore()
	{
		header('Content-Type: application/json');

		if (!current_user_can('administrator')) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => __('Permission denied.', 'ip2location-redirection'),
			]));
		}

		check_admin_referer('restore', '__nonce');

		if (!isset($_FILES['file-restore'])) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => __('No file is uploaded.', 'ip2location-redirection'),
			]));
		}

		$file = tempnam(sys_get_temp_dir(), 'restore');

		move_uploaded_file($_FILES['file-restore']['tmp_name'], $file);

		if (($rows = json_decode(file_get_contents($file))) === null) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => __('Invalid file format.', 'ip2location-redirection'),
			]));
		}

		foreach ($rows as $key => $value) {
			update_option($key, $value);
		}

		update_option('ip2location_redirection_session_message', 'Restore completed.');

		exit(json_encode([
			'status' => 'OK',
		]));
	}

	public function show_notice()
	{
		if ($this->is_setup_completed()) {
			return;
		}

		echo '
		<div class="error">
			<p>
			' . sprintf(__('IP2Location Redirection requires the IP2Location BIN database to work. %1$sSetup your database%2$s now.', 'ip2location-redirection'), '<a href="' . get_admin_url() . 'admin.php?page=ip2location-redirection">', '</a>') . '
			</p>
		</div>';
	}

	public function plugin_enqueues($hook)
	{
		wp_enqueue_style('iplr-styles', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/css/styles.css', []);

		switch ($hook) {
			case 'plugins.php':
				wp_enqueue_script('jquery-ui-dialog');
				wp_enqueue_style('wp-jquery-ui-dialog');

				wp_enqueue_script('iplr-feedback-js', plugins_url('/assets/js/feedback.js', __FILE__), ['jquery'], null, true);

				break;

			case 'toplevel_page_ip2location-redirection':
				add_action('wp_enqueue_script', 'load_jquery');

				wp_enqueue_script('iplr-rules-js', plugins_url('/assets/js/rules.js?t=' . microtime(true), __FILE__), ['jquery'], null, true);
				wp_enqueue_script('iplr-chosen-js', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.jquery.min.js', [], null, true);
				wp_enqueue_script('iplr-tagsinput-js', plugins_url('/assets/js/jquery.tagsinput.min.js', __FILE__), [], null, true);
				wp_enqueue_script('iplr-jquery-ui', plugins_url('/assets/js/jquery-ui.min.js', __FILE__), [], null, true);

				wp_enqueue_style('iplr-chosen-css', esc_url_raw('https://cdnjs.cloudflare.com/ajax/libs/chosen/1.7.0/chosen.min.css'), [], null);
				wp_enqueue_style('iplr-tagsinput-css', esc_url_raw('https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css'), [], null);
				wp_enqueue_style('iplr-custom-styles', untrailingslashit(plugins_url('/', __FILE__)) . '/assets/css/customs.css', []);

				break;

			case 'redirection_page_ip2location-redirection-settings':
				wp_register_script('iplr-jquery-upload-file-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-file-upload/4.0.11/jquery.uploadfile.min.js', null, null, true);
				wp_enqueue_script('iplr-jquery-upload-file-js');

				wp_register_style('iplr-jquery-upload-file-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-file-upload/4.0.11/uploadfile.min.css');
				wp_enqueue_style('iplr-jquery-upload-file-css');

				wp_enqueue_script('iplr_admin_script_js', plugins_url('/assets/js/settings.js', __FILE__), ['jquery'], null, true);
				break;
		}
	}

	public function set_default_values()
	{
		// Initial default settings
		add_option('ip2location_redirection_api_key', '');
		add_option('ip2location_redirection_database', '');
		add_option('ip2location_redirection_debug_log_enabled', '0');
		add_option('ip2location_redirection_enable_region_redirect', '0');
		add_option('ip2location_redirection_download_ipv4_only', '0');
		add_option('ip2location_redirection_enabled', '1');
		add_option('ip2location_redirection_first_redirect', '0');
		add_option('ip2location_redirection_ignore_query_string', '1');
		add_option('ip2location_redirection_ip_whitelist', '');
		add_option('ip2location_redirection_lookup_mode', 'bin');
		add_option('ip2location_redirection_noredirect_enabled', '0');
		add_option('ip2location_redirection_rules', '[]');
		add_option('ip2location_redirection_skip_bots', '0');
		add_option('ip2location_redirection_token', '');
		add_option('ip2location_redirection_real_ip_header', '');

		// Create scheduled task
		if (!wp_next_scheduled('ip2location_redirection_hourly_event')) {
			wp_schedule_event(time(), 'hourly', 'ip2location_redirection_hourly_event');
		}
	}

	public function update_ip2location_database()
	{
		check_ajax_referer('update-database', '__nonce');

		@set_time_limit(300);

		header('Content-Type: application/json');

		if (!current_user_can('administrator')) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => __('Permission denied.', 'ip2location-redirection'),
			]));
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		try {
			$this->sanitize_post_inputs();

			$token = (isset($_POST['token'])) ? sanitize_text_field($_POST['token']) : '';
			$enable_region = (isset($_POST['enable_region']) && $_POST['enable_region'] == 'true') ? true : false;
			$ipv4_only = (isset($_POST['ipv4_only']) && $_POST['ipv4_only'] == 'true') ? true : false;

			$ipv6 = ($ipv4_only) ? '' : 'IPV6';

			if ($enable_region) {
				$code = 'DB3BIN' . $ipv6;
			} else {
				$code = 'DB1BIN' . $ipv6;
			}

			$working_dir = IP2LOCATION_DIR . 'working' . \DIRECTORY_SEPARATOR;
			$zip_file = $working_dir . 'database.zip';

			// Remove existing working directory
			$wp_filesystem->delete($working_dir, true);

			// Create working directory
			$wp_filesystem->mkdir($working_dir);

			if (!class_exists('WP_Http')) {
				include_once ABSPATH . WPINC . '/class-http.php';
			}

			$request = new WP_Http();

			// Check download permission
			$response = $request->request('https://www.ip2location.com/download-info?' . http_build_query([
				'package' => $code,
				'token'   => $token,
				'source'  => 'wp_redirection',
			]));

			$parts = explode(';', $response['body']);

			if ($parts[0] != 'OK') {
				// Download LITE version
				if ($enable_region) {
					$code = 'DB3LITEBIN' . $ipv6;
				} else {
					$code = 'DB1LITEBIN' . $ipv6;
				}

				$response = $request->request('https://www.ip2location.com/download-info?' . http_build_query([
					'package' => $code,
					'token'   => $token,
					'source'  => 'wp_redirection',
				]));

				$parts = explode(';', $response['body']);

				if ($parts[0] != 'OK') {
					exit(json_encode([
						'status'  => 'ERROR',
						'message' => __('You do not have permission to download this database.', 'ip2location-redirection'),
					]));
				}
			}

			// Start downloading BIN database from IP2Location website
			$response = $request->request('https://www.ip2location.com/download?' . http_build_query([
				'file'   => $code,
				'token'  => $token,
				'source' => 'wp_redirection',
			]), [
				'timeout'          => 300,
				'follow_redirects' => true,
			]);

			if ((isset($response->errors)) || (!in_array('200', $response['response']))) {
				$wp_filesystem->delete($working_dir, true);

				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('Connection timed out while downloading database.', 'ip2location-redirection'),
				]));
			}

			// Save downloaded package.
			$fp = fopen($zip_file, 'w');

			if (!$fp) {
				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('No permission to write into file system.', 'ip2location-redirection'),
				]));
			}

			fwrite($fp, $response['body']);
			fclose($fp);

			if (filesize($zip_file) < 51200) {
				$message = file_get_contents($zip_file);
				$wp_filesystem->delete($working_dir, true);

				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('Downloaded database is corrupted. Please try again later.', 'ip2location-redirection'),
				]));
			}

			// Unzip the package to working directory
			$result = unzip_file($zip_file, $working_dir);

			// Once extracted, delete the package.
			unlink($zip_file);

			if (is_wp_error($result)) {
				$wp_filesystem->delete($working_dir, true);

				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('There is problem when decompress the database.', 'ip2location-redirection'),
				]));
			}

			// File the BIN database
			$bin_database = '';
			$files = scandir($working_dir);

			foreach ($files as $file) {
				if (strtoupper(substr($file, -4)) == '.BIN') {
					$bin_database = $file;
					break;
				}
			}

			// Move file to IP2Location directory
			$wp_filesystem->move($working_dir . $bin_database, IP2LOCATION_DIR . $bin_database, true);

			update_option('ip2location_redirection_lookup_mode', 'bin');
			update_option('ip2location_redirection_database', $bin_database);
			update_option('ip2location_redirection_token', $token);
			update_option('ip2location_redirection_download_ipv4_only', ($ipv4_only) ? 1 : 0);
			update_option('ip2location_redirection_enable_region_redirect', ($enable_region) ? 1 : 0);

			// Remove working directory
			$wp_filesystem->delete($working_dir, true);

			// Flush caches
			$this->cache_flush();

			exit(json_encode([
				'status'  => 'OK',
				'message' => '',
			]));
		} catch (Exception $e) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => $e->getMessage(),
			]));
		}
	}

	public function validate_token()
	{
		check_ajax_referer('validate-token', '__nonce');

		header('Content-Type: application/json');

		try {
			$this->sanitize_post_inputs();

			$token = (isset($_POST['token'])) ? sanitize_text_field($_POST['token']) : '';

			// Check download permission
			$response = wp_remote_get('https://www.ip2location.com/download-info?' . http_build_query([
				'package' => 'DB1BIN',
				'token'   => $token,
				'source'  => 'wp_redirection',
			]));

			$parts = explode(';', $response['body']);

			if ($parts[0] != 'OK') {
				$response = wp_remote_get('https://www.ip2location.com/download-info?' . http_build_query([
					'package' => 'DB1LITEBIN',
					'token'   => $token,
					'source'  => 'wp_redirection',
				]));

				$parts = explode(';', $response['body']);

				if ($parts[0] != 'OK') {
					exit(json_encode([
						'status'  => 'ERROR',
						'message' => __('Invalid download token.', 'ip2location-redirection'),
					]));
				}
			}

			update_option('ip2location_redirection_token', $token);

			exit(json_encode([
				'status'  => 'OK',
				'message' => '',
			]));
		} catch (Exception $e) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => $e->getMessage(),
			]));
		}
	}

	public function validate_api_key()
	{
		header('Content-Type: application/json');

		if (!current_user_can('administrator')) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => __('Permission denied.', 'ip2location-redirection'),
			]));
		}

		check_admin_referer('validate-api-key', '__nonce');

		try {
			$apiKey = (isset($_POST['key'])) ? sanitize_text_field($_POST['key']) : '';

			if (empty($apiKey)) {
				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('Invalid API key.', 'ip2location-redirection'),
				]));
			}

			// Check download permission
			$response = wp_remote_get('https://api.ip2location.io/?' . http_build_query([
				'key'    => $apiKey,
				'source' => 'wp_redirection',
			]));

			if (!isset($response['response']['code'])) {
				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('Remote server is not responding. Please try again later.', 'ip2location-redirection'),
				]));
			}

			if ($response['response']['code'] != 200) {
				exit(json_encode([
					'status'  => 'ERROR',
					'message' => __('Invalid API key.', 'ip2location-redirection'),
				]));
			}

			update_option('ip2location_redirection_lookup_mode', 'ws');
			update_option('ip2location_redirection_api_key', $apiKey);

			exit(json_encode([
				'status'  => 'OK',
				'message' => '',
			]));
		} catch (Exception $e) {
			exit(json_encode([
				'status'  => 'ERROR',
				'message' => $e->getMessage(),
			]));
		}
	}

	public function search_post()
	{
		header('Content-Type: application/json');

		$keyword = (isset($_POST['search'])) ? sanitize_text_field($_POST['search']) : '';

		$results = [];

		if (mb_strlen($keyword) < 3) {
			$results[] = [
				'id'   => '',
				'name' => 'No result',
			];
			exit(json_encode($results));
		}

		$rows = $GLOBALS['wpdb']->get_results("SELECT `ID`, `post_type`, `post_title` FROM `{$GLOBALS['wpdb']->prefix}posts` WHERE `post_title` LIKE '%$keyword%' AND `post_status` = 'publish' AND `post_type` IN ('post', 'page', 'product') LIMIT 25");

		if (count($rows) > 0) {
			foreach ($rows as $row) {
				$results[] = [
					'id'   => (($row->post_type == 'page') ? 'page-' : 'post-') . $row->ID,
					'name' => (($row->post_type == 'page') ? 'Page' : 'Post') . ' → ' . $row->post_title,
				];
			}
		} else {
			$results[] = [
				'id'   => '',
				'name' => 'No result',
			];
		}

		exit(json_encode($results));
	}

	public function submit_feedback()
	{
		check_ajax_referer('submit-feedback', '__nonce');

		$this->sanitize_post_inputs();

		$feedback = (isset($_POST['feedback'])) ? sanitize_text_field($_POST['feedback']) : '';
		$others = (isset($_POST['others'])) ? sanitize_text_field($_POST['others']) : '';

		$options = [
			1 => __('I no longer need the plugin', 'ip2location-redirection'),
			2 => __('I couldn\'t get the plugin to work', 'ip2location-redirection'),
			3 => __('The plugin doesn\'t meet my requirements', 'ip2location-redirection'),
			4 => __('Other concerns', 'ip2location-redirection') . (($others) ? (' - ' . $others) : ''),
4		];

		if (isset($options[$feedback])) {
			wp_remote_get('https://www.ip2location.com/wp-plugin-feedback?' . http_build_query([
				'name'    => 'ip2location-redirection',
				'message' => $options[$feedback],
			]), ['timeout' => 5]);
		}
	}

	public function rules_page()
	{
		$general_status = '';
		$cache_warning = '';

		$rules = [];
		$wpml_settings = get_option('icl_sitepress_settings');

		if (($name = $this->cache_plugin_detected()) !== false) {
			$cache_warning = '
			<div class="error">
				<p>
					It appears that you are currently using <strong>' . $name . '</strong>, which is not fully compatible with the IP2Location Redirection. This may lead to unintended issues. We recommend disabling and uninstalling the cache plugin.
				</p>
			</div>';
		}

		$this->sanitize_post_inputs();

		$enable_redirection = (isset($_POST['submit']) && isset($_POST['enable_redirection'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['enable_redirection'])) ? 0 : get_option('ip2location_redirection_enabled'));
		$first_redirect = (isset($_POST['submit']) && isset($_POST['first_redirect'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['first_redirect'])) ? 0 : get_option('ip2location_redirection_first_redirect'));
		$enable_noredirect = (isset($_POST['submit']) && isset($_POST['enable_noredirect'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['enable_noredirect'])) ? 0 : get_option('ip2location_redirection_noredirect_enabled'));
		$ignore_query_string = (isset($_POST['submit']) && isset($_POST['ignore_query_string'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['ignore_query_string'])) ? 0 : get_option('ip2location_redirection_ignore_query_string'));
		$skip_bots = (isset($_POST['submit']) && isset($_POST['skip_bots'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['skip_bots'])) ? 0 : get_option('ip2location_redirection_skip_bots'));
		$ip_whitelist = (isset($_POST['ip_whitelist'])) ? sanitize_text_field($_POST['ip_whitelist']) : get_option('ip2location_redirection_ip_whitelist');

		if (isset($_POST['submit'])) {
			check_admin_referer('save-rules');

			if (isset($_POST['country_codes']) && is_array($_POST['country_codes'])) {
				$index = 0;

				foreach ($_POST['country_codes'] as $country_codes) {
					$country_codes = explode(',', $country_codes);

					$rule_status = (isset($_POST['rule_status'][$index])) ? $_POST['rule_status'][$index] : '';
					$status_code = (isset($_POST['status_code'][$index])) ? $_POST['status_code'][$index] : '';
					$wpml_code = (isset($_POST['wpml_code'][$index])) ? $_POST['wpml_code'][$index] : '';

					$from = (isset($_POST['from'][$index])) ? $_POST['from'][$index] : '';
					$to = (isset($_POST['to'][$index])) ? $_POST['to'][$index] : '';

					$post_from = (isset($_POST['post_from'][$index])) ? $_POST['post_from'][$index] : '';
					$post_to = (isset($_POST['post_to'][$index])) ? $_POST['post_to'][$index] : '';

					$url_from = (isset($_POST['url_from'][$index])) ? $_POST['url_from'][$index] : '';
					$url_to = (isset($_POST['url_to'][$index])) ? $_POST['url_to'][$index] : '';

					$new_parameter = (isset($_POST['new_parameter'][$index])) ? $_POST['new_parameter'][$index] : '';

					$domain_from = (isset($_POST['domain_from'][$index])) ? $_POST['domain_from'][$index] : '';
					$domain_to = (isset($_POST['domain_to'][$index])) ? $_POST['domain_to'][$index] : '';

					$keep_query = (isset($_POST['keep_query'][$index])) ? $_POST['keep_query'][$index] : '';

					// Domain redirection must redirect from domain to domain
					if (($from == 'domain' && $to != 'domain') || $to == 'domain' && $from != 'domain') {
						++$index;
						continue;
					}

					// Destination cannot be empty
					if (empty($to)) {
						++$index;
						continue;
					}

					if ($from != 'url') {
						$url_from = '';
					}

					if ($to != 'url') {
						$url_to = '';
					}

					if ($from != 'domain' || $to != 'domain') {
						$domain_from = '';
						$domain_to = '';
					}

					if ($from != 'post') {
						$post_from = '';
					}

					if ($to != 'post') {
						$post_to = '';
					}

					// Validate domain name
					if ($from == 'domain' && !preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,20}$/', $domain_from)) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . sprintf(__('%1$s is not a domain name.', 'ip2location-redirection'), '<strong>' . $domain_from . '</strong>') . '
							</p>
						</div>';

						break;
					}

					if ($to == 'domain' && !preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,20}$/', $domain_to)) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . sprintf(__('%1$s is not a domain name.', 'ip2location-redirection'), '<strong>' . $domain_to . '</strong>') . '
							</p>
						</div>';

						break;
					}

					// Both URL from and to cannot be same.
					if ($from == 'url' && $to == 'url' && $url_from == $url_to) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . __('Target URL and destination URL cannot be same.', 'ip2location-redirection') . '
							</p>
						</div>';

						break;
					}

					// Both domain from and to cannot be same.
					if ($from == 'domain' && $to == 'domain' && $domain_from == $domain_to) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . sprintf(__('Target domain and destination domain %1$s cannot be same.', 'ip2location-redirection'), '<strong>' . $domain_from . '</strong>') . '
							</p>
						</div>';

						break;
					}

					if ($from == 'url' && !filter_var($url_from, \FILTER_VALIDATE_URL)) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . sprintf(__('%1$s is not a valid URL.', 'ip2location-redirection'), '<strong>' . $_POST['url_form'][$index] . '</strong>') . '
							</p>
						</div>';

						break;
					}

					if ($to == 'url' && !filter_var($url_to, \FILTER_VALIDATE_URL)) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . sprintf(__('%1$s is not a valid URL.', 'ip2location-redirection'), '<strong>' . $url_to . '</strong>') . '
							</p>
						</div>';

						break;
					}

					// Both post/page from and to cannot be same.
					if ($from == 'post' && $to == 'post' && $post_from == $post_to) {
						$general_status .= '
						<div id="message" class="error">
							<p>
								' . __('Target post and destination post cannot be same.', 'ip2location-redirection') . '
							</p>
						</div>';

						break;
					}

					$idx = 0;
					foreach ($country_codes as $country_code) {
						if ($_POST['exclude'][$index]) {
							$country_codes[$idx] = (substr($country_code, 0, 1) == '-') ? $country_code : ('-' . $country_code);
						} else {
							$country_codes[$idx] = (substr($country_code, 0, 1) == '-') ? substr($country_code, 1) : $country_code;
						}

						++$idx;
					}

					if ($from == 'domain') {
						$url_from = $domain_from;
						$url_to = $domain_to;

						if ($keep_query) {
							$url_from = '*' . $url_from;
						}
					}

					$rules[] = [
						'is_active'     => ($rule_status == '1'),
						'country_codes' => $country_codes,
						'page_from'     => ($from == 'post') ? $post_from : $from,
						'page_to'       => ($to == 'post') ? $post_to : $to,
						'url_from'      => $url_from,
						'url_to'        => $url_to,
						'new_parameter' => $new_parameter,
						'language_code' => $wpml_code,
						'http_code'     => $status_code,
					];

					++$index;
				}
			}

			$records = explode(';', $ip_whitelist);

			if (count($records) > 0) {
				$filtered = [];

				foreach ($records as $record) {
					// CIDR notation
					if (strpos($record, '/') !== false) {
						list($ip, $range) = explode('/', $record);

						if (filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
							if ($range >= 1 && $range <= 32) {
								$filtered[] = $record;
							}
						} elseif (filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)) {
							if ($range >= 1 && $range <= 128) {
								$filtered[] = $record;
							}
						}
					} elseif (filter_var($record, \FILTER_VALIDATE_IP)) {
						$filtered[] = $record;
					}
				}

				$ip_whitelist = implode(';', $filtered);
			}

			if (empty($general_status)) {
				update_option('ip2location_redirection_enabled', $enable_redirection);
				update_option('ip2location_redirection_first_redirect', $first_redirect);
				update_option('ip2location_redirection_rules', json_encode($rules));
				update_option('ip2location_redirection_noredirect_enabled', $enable_noredirect);
				update_option('ip2location_redirection_ignore_query_string', $ignore_query_string);
				update_option('ip2location_redirection_skip_bots', $skip_bots);
				update_option('ip2location_redirection_ip_whitelist', $ip_whitelist);

				$general_status = '
				<div id="message" class="updated">
					<p>' . __('Changes saved.', 'ip2location-redirection') . '</p>
				</div>';
			}
		}

		echo '
		<div class="wrap">
			<h1>' . __('Rules', 'ip2location-redirection') . '</h1>

			' . $cache_warning . '
			' . $general_status . '

			<form method="post" novalidate="novalidate">
				<table class="form-table">
					<tr>
						<td>
							<label for="enable_redirection">
								<input type="checkbox" name="enable_redirection" id="enable_redirection"' . (($enable_redirection) ? ' checked' : '') . '>
								' . __('Enable Redirection', 'ip2location-redirection') . '
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label for="first_redirect">
								<input type="checkbox" name="first_redirect" id="first_redirect"' . (($first_redirect) ? ' checked' : '') . '>
								' . __('Redirect on first visit only. Subsequent visits will be ignored.', 'ip2location-redirection') . '
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<table class="wp-list-table widefat striped">
								<thead>
									<tr>
										<th>' . __('Location', 'ip2location-redirection') . '</th>
										<th>' . __('From', 'ip2location-redirection') . '</th>
										<th>' . __('Destination', 'ip2location-redirection') . '</th>
										<th>' . __('Status', 'ip2location-redirection') . '</th>
										<th colspan="2">&nbsp;</th>
									</tr>
								</thead>
								<tbody id="rules">
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<p style="margin-bottom:10px">
								<strong>' . __('Exclude the below IP addresses from redirection:', 'ip2location-redirection') . '</strong>
							</p>

							<fieldset>
								<input type="text" name="ip_whitelist" id="ip_whitelist" value="' . $ip_whitelist . '" class="regular-text ip-address-list" />
								<p class="description">' . __('Please enter IP address or CIDR notation.', 'ip2location-redirection') . '</p>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td>
							<label for="enable_noredirect">
								<input type="checkbox" name="enable_noredirect" id="enable_noredirect"' . (($enable_noredirect) ? ' checked' : '') . '>
								' . sprintf(__('Skip redirection if %1$s found in URL. For example,', 'ip2location-redirection'), '<strong>noredirect=true</strong>') . ' https://www.example.com/?page=1&<code>noredirect=true</code>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label for="ignore_query_string">
								<input type="checkbox" name="ignore_query_string" id="ignore_query_string"' . (($ignore_query_string) ? ' checked' : '') . '>
								' . __('Ignore query strings and parameters when matching page.', 'ip2location-redirection') . '
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<label for="skip_bots">
								<input type="checkbox" name="skip_bots" id="skip_bots"' . (($skip_bots) ? ' checked' : '') . '>
								' . __('Do not redirect bots and crawlers.', 'ip2location-redirection') . '
							</label>
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="' . __('Save Changes', 'ip2location-redirection') . '" />
				</p>
				<input type="hidden" id="validate_token_nonce" value="' . wp_create_nonce('validate-token') . '">
				' . wp_nonce_field('save-rules') . '
			</form>

			<div class="clear"></div>
		</div>
		<input type="hidden" id="is_region_supported" value="' . (($this->is_region_supported()) ? 'true' : 'false') . '">';

		if (($records = json_decode(get_option('ip2location_redirection_rules'))) !== null) {
			if (!isset($records[0]->is_active)) {
				$list = [];

				foreach ($records as $values) {
					if (count($values) == 5) {
						$list[] = [
							'is_active'     => true,
							'country_codes' => explode(';', $values[0]),
							'page_from'     => $values[1],
							'page_to'       => $values[2],
							'url_from'      => '',
							'url_to'        => $values[3],
							'new_parameter' => '',
							'language_code' => '',
							'http_code'     => $values[4],
						];
					} elseif (count($values) == 7) {
						$list[] = [
							'is_active'     => (bool) $values[6],
							'country_codes' => explode(';', $values[0]),
							'page_from'     => $values[1],
							'page_to'       => $values[2],
							'url_from'      => $values[3],
							'url_to'        => $values[4],
							'new_parameter' => '',
							'language_code' => '',
							'http_code'     => $values[5],
						];
					} elseif (count($values) == 8) {
						$list[] = [
							'is_active'     => (bool) $values[7],
							'country_codes' => explode(';', $values[0]),
							'page_from'     => $values[1],
							'page_to'       => $values[2],
							'url_from'      => $values[3],
							'url_to'        => $values[4],
							'new_parameter' => '',
							'language_code' => $values[5],
							'http_code'     => $values[6],
						];
					} else {
						$list[] = [
							'is_active'     => (bool) $values[8],
							'country_codes' => explode(';', $values[0]),
							'page_from'     => $values[1],
							'page_to'       => $values[2],
							'url_from'      => $values[3],
							'url_to'        => $values[4],
							'new_parameter' => $values[5],
							'language_code' => $values[6],
							'http_code'     => $values[7],
						];
					}
				}

				update_option('ip2location_redirection_rules', json_encode($list));
			}
		}

		$rules = json_decode(get_option('ip2location_redirection_rules'));

		if ($rules) {
			for ($i = 0; $i < count($rules); ++$i) {
				if (substr($rules[$i]->page_from, 0, 4) == 'page') {
					$rules[$i]->page_from .= ';Page → ' . $this->get_post_title(substr($rules[$i]->page_from, 5));
				}

				if (substr($rules[$i]->page_from, 0, 4) == 'post') {
					$rules[$i]->page_from .= ';Post → ' . $this->get_post_title(substr($rules[$i]->page_from, 5));
				}

				if (substr($rules[$i]->page_to, 0, 4) == 'page') {
					$rules[$i]->page_to .= ';Page → ' . $this->get_post_title(substr($rules[$i]->page_to, 5));
				}

				if (substr($rules[$i]->page_to, 0, 4) == 'post') {
					$rules[$i]->page_to .= ';Post → ' . $this->get_post_title(substr($rules[$i]->page_to, 5));
				}
			}
		}

		$scripts = [];

		$scripts[] = '';
		$scripts[] = '<script>';
		$scripts[] = 'var rules = ' . json_encode($rules) . ';';
		$scripts[] = 'var wpml_installed = ' . (($wpml_settings) ? 'true' : 'false') . ';';
		$scripts[] = '</script>';

		echo implode("\n", $scripts);

		if (!$this->is_setup_completed()) {
			echo '
			<div id="modal-get-started" class="ip2location-modal" style="display:block">
				<div class="ip2location-modal-content">
					<div align="center" style="margin:10px auto;">
						<img src="' . plugins_url('/assets/img/logo.png', __FILE__) . '" width="200" height="24" align="center" alt="IP2Location"><br>
						<img src="' . plugins_url('/assets/img/get-started.png', __FILE__) . '" width="160" height="125" align="center" style="margin-top:5px;" alt="IP2Location Redirection">
					</div>
					<p style="margin-top:0;">
						' . sprintf(__('%1$sIP2Location Redirection%2$s is a plugin designed to redirect visitors or traffic based on their geolocation determined by their IP address.', 'ip2location-redirection'), '<strong>', '</strong>') . '
					</p>
					<p>
						' . __('Please follow these steps to complete the setup.', 'ip2location-redirection') . '
					</p>';

			if (!extension_loaded('bcmath')) {
				echo '
					<span class="dashicons dashicons-warning"></span> ' . sprintf(__('IP2Location requires %1$s PHP extension enabled. Please enable this extension in your %2$s.', 'ip2location-redirection'), '<strong>bcmath</strong>', '<strong>php.ini</strong>') . '
					<p style="text-align:center;margin-top:25px">
						<button class="button button-primary" style="padding:3px 18px;" disabled>' . __('Get Started', 'ip2location-redirection') . '</button>
					</p>';
			} else {
				echo '
					<p style="text-align:center;margin-top:25px">
						<button class="button button-primary" id="btn-get-started" style="padding:3px 18px;">' . __('Get Started', 'ip2location-redirection') . '</button>
					</p>';
			}

			echo '
				</div>
			</div>

			<div id="modal-step-1" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div class="ip2location-sel-form">
						<div class="ip2location-sel-con">
							<h1 style="line-height:1.2;font-size:23px;text-align:center;margin-bottom:25px;">' . __('Choose Query Method', 'ip2location-redirection') . '</h1>
							<div class="ip2location-sel-img-div">
								<input width="100" type="radio" name="ipl-sel" id="db" value="db" checked>
								<label for="db">
									<span class="ip2location-sel-img">
										<img src="' . plugins_url('/assets/img/db.png', __FILE__) . '" width="90" height="90" align="center" alt="IP2Location BIN Database">
									</span>
								</label>
								<h4 style="margin-bottom:0;">' . __('IP2Location BIN Database (Local Query)', 'ip2location-redirection') . '</h4>
								<p style="margin-top:8px;">' . __('Free geolocation database download', 'ip2location-redirection') . '</p>
							</div>
							<div class="ip2location-sel-img-div">
								<input type="radio" name="ipl-sel" id="api" value="api" >
								<label for="api">
									<span class="ip2location-sel-img">
										<img src="' . plugins_url('/assets/img/api.png', __FILE__) . '" width="90" height="90" align="center" alt="IP2Location.io IP Geolocation API">
									</span>
								</label>
								<h4 style="margin-bottom:0;">' . __('IP2Location.io IP Geolocation API (Remote Query)', 'ip2location-redirection') . '</h4>
								<p style="margin-top:8px;">' . __('Free 30K IP geolocation queries per month', 'ip2location-redirection') . '</p>
							</div>
						</div>
					</div>
					<p style="text-align:right;margin-top:15px">
						<button id="btn-to-step-1" class="button button-primary" style="padding:3px 18px;">' . __('Next', 'ip2location-redirection') . ' &raquo;</button>
					</p>
				</div>
			</div>

			<!-- db -->
			<div id="modal-db-step-1" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div align="center">
						<h1 style="line-height:1.2;font-size:23px;margin-bottom:25px;">' . __('Set Up IP2Location LITE BIN Database', 'ip2location-redirection') . '</h1>
						<table class="setup ip2location-steps" width="200">
							<tr>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-1-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 1"><br>
									' . __('Step 1', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-2.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 2"><br>
									' . __('Step 2', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-3.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 3"><br>
									' . __('Step 3', 'ip2location-redirection') . '
								</td>
							</tr>
						</table>
						<div class="ip2location-line"></div>
					</div>
					<form>
						<p>
							<label>' . __('Enter IP2Location LITE download token', 'ip2location-redirection') . '</label>
							<input type="text" id="setup_token" class="regular-text code" maxlength="64" style="width:100%; margin-top: 10px; margin-bottom: 4px;">
						</p>
						<p class="description">
							' . sprintf(__('Don\'t have an account yet? Sign up a %1$s free IP geolocation account%2$s to obtain your download token.', 'ip2location-redirection'), '<a href="https://lite.ip2location.com/sign-up#wordpress-wzdir" target="_blank">', '</a>') . '
						</p>
						<p id="token_status" style="margin-top:20px;margin-bottom:20px;">&nbsp;</p>
					</form>
					<p style="text-align:right;margin-top:15px">
						<button id="btn-to-db-step-0" class="button button-secondary" style="padding:3px 18px;margin-right:8px;" >&laquo; ' . __('Previous', 'ip2location-redirection') . '</button>
						<button id="btn-to-db-step-2" class="button button-primary" style="padding:3px 18px;" disabled>' . __('Next', 'ip2location-redirection') . ' &raquo;</button>
					</p>
				</div>
			</div>

			<div id="modal-db-step-2" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div align="center">
						<h1 style="line-height:1.2;font-size:23px;margin-bottom:25px;">' . __('Download IP2Location BIN Database', 'ip2location-redirection') . '</h1>
						<table class="setup ip2location-steps" width="200">
							<tr>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-1-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 1"><br>
									' . __('Step 1', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-2-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 2"><br>
									' . __('Step 2', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-3.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 3"><br>
									' . __('Step 3', 'ip2location-redirection') . '
								</td>
							</tr>
						</table>
						<div class="ip2location-line"></div>
					</div>

					<form style="height:140px">
						<p id="ip2location_download_status"></p>
					</form>
					<p style="text-align:right;margin-top:30px">
						<button id="btn-to-db-step-1" class="button button-secondary" style="padding:3px 18px;margin-right:8px;" disabled>&laquo; ' . __('Previous', 'ip2location-redirection') . '</button>
						<button id="btn-to-db-step-3" class="button button-primary" style="padding:3px 18px;" disabled>' . __('Next', 'ip2location-redirection') . ' &raquo;</button>
					</p>
				</div>
			</div>

			<div id="modal-db-step-3" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div align="center">
						<h1 style="line-height:1.2;font-size:23px;margin-bottom:25px;">' . __('Configure The Rules', 'ip2location-redirection') . '</h1>
						<table class="setup ip2location-steps" width="200">
							<tr>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-1-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 1"><br>
									' . __('Step 1', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-2-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 2"><br>
									' . __('Step 2', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-3-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 3"><br>
									' . __('Step 3', 'ip2location-redirection') . '
								</td>
							</tr>
						</table>
						<div class="ip2location-line"></div>
					</div>

					<form style="height:75px;">
						<p>
							' . __('Please click the “Finish” button to start configuring your rules.', 'ip2location-redirection') . '
						</p>
					</form>
					<p style="text-align:right;margin-top:30px">
						<button class="button button-primary" style="padding:3px 18px;" onclick="window.location.href=\'' . admin_url('admin.php?page=ip2location-redirection') . '\';">' . __('Finish', 'ip2location-redirection') . '</button>
					</p>
				</div>
			</div>

			<!-- api -->
			<div id="modal-api-step-1" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div align="center">
						<h1 style="line-height:1.2;font-size:23px;margin-bottom:25px;">' . __('Set Up IP2Location.io IP Geolocation Service', 'ip2location-redirection') . '</h1>
						<table class="setup ip2location-steps" width="200">
							<tr>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-1-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 1"><br>
									' . __('Step 1', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-3.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 2"><br>
									' . __('Step 2', 'ip2location-redirection') . '
								</td>
							</tr>
						</table>
						<div class="ip2location-api-line"></div>
					</div>
					<form>
						<p>
							<label>' . __('Enter IP2Location.io IP Geolocation API key', 'ip2location-redirection') . '</label>
							<input type="text" id="setup_api_key" class="regular-text code" maxlength="64" style="width:100%;margin-top: 10px; margin-bottom: 4px;">
						</p>
						<p class="description">
							' . sprintf(__('Don\'t have an account yet? Sign up a %1$s free IP geolocation plan%2$s to obtain your API key.', 'ip2location-redirection'), '<a href="https://www.ip2location.io/sign-up?ref=wp_ir" target="_blank">', '</a>') . '
						</p>
						<p id="api_status">&nbsp;</p>
					</form>
					<p style="text-align:right;margin-top:30px">
						<button id="btn-to-api-step-0" class="button button-secondary" style="padding:3px 18px;margin-right:8px;">&laquo; ' . __('Previous', 'ip2location-redirection') . '</button>
						<button id="btn-to-api-step-2" class="button button-primary" style="padding:3px 18px;" >' . __('Next', 'ip2location-redirection') . ' &raquo;</button>
					</p>
				</div>
			</div>

			<div id="modal-api-step-2" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<div align="center">
						<h1 style="line-height:1.2;font-size:23px;margin-bottom:25px;">' . __('Configure The Rules', 'ip2location-redirection') . '</h1>
						<table class="setup ip2location-steps" width="200">
							<tr>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-1-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 1"><br>
									' . __('Step 1', 'ip2location-redirection') . '
								</td>
								<td align="center">
									<img src="' . plugins_url('/assets/img/step-3-selected.png', __FILE__) . '" width="36" height="36" align="center" alt="Wizard Step 2"><br>
									' . __('Step 2', 'ip2location-redirection') . '
								</td>
							</tr>
						</table>
						<div class="ip2location-api-line"></div>
					</div>

					<form style="height:75px;">
						<p>
							' . __('Please click the “Finish” button to start configuring your rules.', 'ip2location-redirection') . '
						</p>
					</form>
					<p style="text-align:right;margin-top:30px">
						<button class="button button-primary" style="padding:3px 18px;" onclick="window.location.href=\'' . admin_url('admin.php?page=ip2location-redirection&tab=general') . '\';">' . __('Finish', 'ip2location-redirection') . '</button>
					</p>
				</div>
			</div>
			<input type="hidden" id="update_nonce" value="' . wp_create_nonce('update-database') . '">
			<input type="hidden" id="validate_api_key_nonce" value="' . wp_create_nonce('validate-api-key') . '">';
		}
	}

	public function ip_lookup_page()
	{
		$disabled = (!$this->is_setup_completed());

		$this->sanitize_post_inputs();

		$ip_lookup_status = '';

		$ip_address = (isset($_POST['ip_address'])) ? sanitize_text_field($_POST['ip_address']) : $this->get_ip();

		if (isset($_POST['submit'])) {
			if (!filter_var($ip_address, \FILTER_VALIDATE_IP, \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE)) {
				$ip_lookup_status = '
				<div id="message" class="error">
					<p>
						<strong>' . __('ERROR', 'ip2location-redirection') . '</strong>:
						' . __('Please enter a valid IP address.', 'ip2location-redirection') . '
					</p>
				</div>';
			} else {
				$result = $this->get_location($ip_address);

				if (empty($result['country_code'])) {
					$ip_lookup_status = '
					<div id="message" class="error">
						<p>
							<strong>' . __('ERROR', 'ip2location-redirection') . '</strong>:
							' . sprintf(__('Unable to lookup IP address %1$s.', 'ip2location-redirection'), '<strong>' . htmlspecialchars($ip_address) . '</strong>') . '
						</p>
					</div>';
				} else {
					$ip_lookup_status = '
					<div id="message" class="updated">
						<p>
							' . sprintf(__('IP address %1$s belongs to %2$s.', 'ip2location-redirection'), '<code>' . htmlspecialchars($ip_address) . '</code>', '<strong>' . $result['country_name'] . ' (' . $result['country_code'] . ')' . (($result['region_name']) ? (', ' . $result['region_name']) : '') . '</strong>') . '
						</p>
					</div>';
				}
			}
		}

		echo '
		<div class="wrap">
			<h1>' . __('IP Lookup', 'ip2location-redirection') . '</h1>

			' . $ip_lookup_status . '

			<form method="post" novalidate="novalidate">
				<table class="form-table">
					<tr>
						<th scope="row"><label for="ip_address">' . __('IP Address', 'ip2location-redirection') . '</label></th>
						<td>
							<input name="ip_address" type="text" id="ip_address" value="' . htmlspecialchars($ip_address) . '" class="regular-text"' . (($disabled) ? ' disabled' : '') . ' />
							<p class="description">' . __('Enter a valid IP address to lookup for country information.', 'ip2location-redirection') . '</p>
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="' . __('Lookup', 'ip2location-redirection') . '"' . (($disabled) ? ' disabled' : '') . ' />
				</p>
			</form>

			<div class="clear"></div>
		</div>';
	}

	public function settings_page()
	{
		$disabled = (!$this->is_setup_completed());

		$this->sanitize_post_inputs();

		$settings_status = '';

		$real_ip_headers = [
			'REMOTE_ADDR',
			'HTTP_CF_CONNECTING_IP',
			'HTTP_CLIENT_IP',
			'HTTP_FORWARDED',
			'HTTP_INCAP_CLIENT_IP',
			'HTTP_X_FORWARDED',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_REAL_IP',
			'HTTP_X_SUCURI_CLIENTIP',
		];

		$lookup_mode = (isset($_POST['lookup_mode'])) ? sanitize_text_field($_POST['lookup_mode']) : get_option('ip2location_redirection_lookup_mode');
		$api_key = (isset($_POST['api_key'])) ? sanitize_text_field($_POST['api_key']) : get_option('ip2location_redirection_api_key');
		$download_token = (isset($_POST['download_token'])) ? sanitize_text_field($_POST['download_token']) : get_option('ip2location_redirection_token');
		$enable_region_redirection = (isset($_POST['lookup_mode']) && isset($_POST['enable_region_redirection'])) ? 1 : ((isset($_POST['lookup_mode']) && !isset($_POST['enable_region_redirection'])) ? 0 : get_option('ip2location_redirection_enable_region_redirect'));
		$download_ipv4_only = (isset($_POST['lookup_mode']) && isset($_POST['download_ipv4_only'])) ? 1 : ((isset($_POST['lookup_mode']) && !isset($_POST['download_ipv4_only'])) ? 0 : get_option('ip2location_redirection_download_ipv4_only'));
		$enable_debug_log = (isset($_POST['submit']) && isset($_POST['enable_debug_log'])) ? 1 : ((isset($_POST['submit']) && !isset($_POST['enable_debug_log'])) ? 0 : get_option('ip2location_redirection_debug_log_enabled'));
		$real_ip_header = (isset($_POST['real_ip_header'])) ? sanitize_text_field($_POST['real_ip_header']) : get_option('ip2location_redirection_real_ip_header');

		if (!in_array($real_ip_header, array_values($real_ip_headers))) {
			$real_ip_header = '';
		}

		if (!$this->is_region_supported()) {
			$enable_region_redirection = 0;
		}

		if (isset($_POST['submit'])) {
			check_admin_referer('save-settings');

			if ($lookup_mode == 'ws') {
				if (!empty($api_key)) {
					$response = wp_remote_get('https://api.ip2location.io/?' . http_build_query([
						'key' => $api_key,
						'src' => 'wordpress-wzdir',
					]));

					$json = json_decode($response['body']);

					if (isset($json->error)) {
						$response = wp_remote_get('https://api.ip2location.com/v2/?' . http_build_query([
							'key'   => $api_key,
							'check' => 1,
						]));

						$json = json_decode($response['body']);

						if (empty($json)) {
							$settings_status = '
							<div class="error">
								<p>
									<strong>' . __('ERROR', 'ip2location-redirection') . '</strong>:
									' . __('Error when accessing IP2Location web service gateway.', 'ip2location-redirection') . '
								</p>
							</div>';
						} else {
							if (!preg_match('/^[0-9]+$/', $json->response)) {
								$settings_status = '
								<div class="error">
									<p>
										<strong>' . __('ERROR', 'ip2location-redirection') . '</strong>:
										' . __('Invalid IP2Location API key.', 'ip2location-redirection') . '
									</p>
								</div>';
							} else {
								update_option('ip2location_redirection_api_key', $api_key);
							}
						}
					} else {
						if (!preg_match('/^[0-9]+$/', $json->response)) {
							$settings_status = '
							<div class="error">
								<p>
									<strong>' . __('ERROR', 'ip2location-redirection') . '</strong>:
									' . __('Invalid IP2Location API key.', 'ip2location-redirection') . '
								</p>
							</div>';
						} else {
							update_option('ip2location_redirection_api_key', $api_key);
						}
					}
				} else {
					update_option('ip2location_redirection_api_key', '');
				}
			}

			if (empty($settings_status)) {
				if (!$enable_debug_log) {
					if (file_exists(IPLR_ROOT . $this->debug_log)) {
						@unlink(IPLR_ROOT . $this->debug_log);
					}
				} else {
					if (!get_option('ip2location_redirection_private_key')) {
						add_option('ip2location_redirection_private_key', hash('sha256', microtime(true) . get_site_url() . get_option('admin_email')));
					}
				}

				update_option('ip2location_redirection_lookup_mode', $lookup_mode);
				update_option('ip2location_redirection_enable_region_redirect', $enable_region_redirection);
				update_option('ip2location_redirection_token', $download_token);
				update_option('ip2location_redirection_debug_log_enabled', $enable_debug_log);
				update_option('ip2location_redirection_download_ipv4_only', $download_ipv4_only);
				update_option('ip2location_redirection_real_ip_header', $real_ip_header);

				$settings_status .= '
				<div id="message" class="updated">
					<p>' . __('Changes saved.', 'ip2location-redirection') . '</p>
				</div>';
			}
		}

		$date = $this->get_database_date();

		echo '
		<div class="wrap">
			<h1>' . __('Settings', 'ip2location-redirection') . '</h1>

			' . $settings_status;

		if (get_option('ip2location_redirection_session_message')) {
			echo '
			<div class="updated">
				<p>' . get_option('ip2location_redirection_session_message') . '</p>
			</div>';

			update_option('ip2location_redirection_session_message', '');
		}

		echo '
			<form method="post" novalidate="novalidate">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="lookup_mode">' . __('Lookup Mode', 'ip2location-redirection') . '</label>
						</th>
						<td>
							<select name="lookup_mode" id="lookup_mode"' . (($disabled) ? ' disabled' : '') . '>
								<option value="bin"' . (($lookup_mode == 'bin') ? ' selected' : '') . '> ' . __('Local BIN Database', 'ip2location-redirection') . '</option>
								<option value="ws"' . (($lookup_mode == 'ws') ? ' selected' : '') . '> ' . __('API Web Service', 'ip2location-redirection') . '</option>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<div id="bin_database"' . (($lookup_mode == 'ws') ? ' style="display:none"' : '') . '>
								<div class="iplr-panel">
									<table class="form-table">
									<tr>
										<th scope="row">
											<label for="download_token">' . __('Download Token', 'ip2location-redirection') . '</label>
										</th>
										<td>
											<input type="text" name="download_token" id="download_token" value="' . $download_token . '" class="regular-text code input-field"' . (($disabled) ? ' disabled' : '') . ' />
											<p class="description">
												' . __('Enter your IP2Location download token.', 'ip2location-redirection') . '
											</p>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<label for="enable_region_redirection">
												<input type="checkbox" name="enable_region_redirection" id="enable_region_redirection" value="true"' . (($enable_region_redirection) ? ' checked' : '') . (($disabled) ? ' disabled' : '') . '> ' . __('Enable region database', 'ip2location-redirection') . '
											</label>

											<p class="description">
												' . __('A larger database will be downloaded. Disable this option if your system has limited resources.', 'ip2location-redirection') . '
											</p>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<label for="download_ipv4_only">
												<input type="checkbox" name="download_ipv4_only" id="download_ipv4_only" value="true"' . (($download_ipv4_only) ? ' checked' : '') . (($disabled) ? ' disabled' : '') . '> ' . __('Download IPv4 database only', 'ip2location-redirection') . '
											</label>

											<p class="description">
												' . __('Download a smaller database which is faster in lookup speed. Perfect for website with only IPv4 supported.', 'ip2location-redirection') . '
											</p>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label>' . __('Database File', 'ip2location-redirection') . '</label>
										</th>
										<td>
											<div>' . ((!is_file(IP2LOCATION_DIR . get_option('ip2location_redirection_database'))) ? '<span class="dashicons dashicons-warning" title="' . __('Database file not found.', 'ip2location-redirection') . '"></span>' : '') . get_option('ip2location_redirection_database') . '
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label>' . __('Database Path', 'ip2location-redirection') . '</label>
										</th>
										<td>
											<div>' . IP2LOCATION_DIR . '</div>
										</td>
									</tr>
									<tr>
										<th scope="row">
											<label>' . __('Database Date', 'ip2location-redirection') . '</label>
										</th>
										<td>
											' . (($date) ?: '-') . '
										</td>
									</tr>
									<tr>
										<td></td>
										<td id="update_status"><td>
									</tr>
									<tr>
										<td></td>
										<td><button id="update_ip2location_database" type="button" class="button button-secondary"' . (($disabled) ? ' disabled' : '') . '>' . __('Update Database', 'ip2location-redirection') . '</button></td>
									</tr>
								</table>
								</div>';

		if (preg_match('/LITE/', get_option('ip2location_redirection_database'))) {
			echo '
								<p class="description">
									' . sprintf(__('If you are looking for high accuracy result, you should consider using the commercial version of %1$sIP2Location BIN database%2$s.', 'ip2location-redirection'), '<a href="https://www.ip2location.com/database/db3-ip-country-region-city#wordpress-wzdir" target="_blank">', '</a>') . '
								</p>';
		}
		echo '
							</div>
							<div id="api_web_service"' . (($lookup_mode == 'bin') ? ' style="display:none"' : '') . '>
								<div class="iplr-panel">
									<table class="form-table">';

		$legacyApi = false;

		if (!empty($api_key) && preg_match('/^[0-9A-Z]{10}$/', $api_key)) {
			$response = wp_remote_get('https://api.ip2location.com/v2/?' . http_build_query([
				'key'   => $api_key,
				'check' => 1,
			]));

			$json = json_decode($response['body']);

			if (!empty($json)) {
				$legacyApi = true;
			}
		}

		echo '
									<tr>
										<th scope="row">
											<label for="api_key">' . __('API Key', 'ip2location-redirection') . '</label>
										</th>
										<td>
											<input name="api_key" type="text" id="api_key" value="' . htmlspecialchars($api_key) . '" class="regular-text" />';

		if ($legacyApi) {
			echo ' <strong><i>(legacy API)</i></strong>';
		}

		echo '
											<p class="description">' . sprintf(__('Your IP2Location %1$sGeolocation%2$s API key.', 'ip2location-redirection'), '<a href="https://www.ip2location.io/pricing" target="_blank">', '</a>') . '</p>
										</td>
									</tr>';

		if (!empty($api_key) && $legacyApi) {
			if (!empty($json)) {
				if (preg_match('/^[0-9]+$/', $json->response)) {
					echo '
									<tr>
										<th scope="row">
											<label for="available_credit">' . __('Available Credit', 'ip2location-redirection') . '</label>
										</th>
										<td>
											' . number_format($json->response, 0, '', ',') . '
										</td>
									</tr>';
				}
			}
		}

		echo '
									</table>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label for="enable_debug_log">
								<input type="checkbox" name="enable_debug_log" id="enable_debug_log" value="1"' . (($enable_debug_log == 1) ? ' checked' : '') . (($disabled) ? ' disabled' : '') . ' /> ' . __('Enable Debugging Log', 'ip2location-redirection') . '
								<p class="description">
									' . sprintf(__('Debug log will store under %1s.', 'ip2location-redirection'), IPLR_ROOT . $this->debug_log) . '
									<br>
									<strong>For security concerns, please disable this option after completed debugging process.</strong>
								</p>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label>' . __('Real IP Detection', 'ip2location-redirection') . '</label>
						</th>
						<td>
							<select name="real_ip_header" id="real_ip_header">
								<option value=""' . ((empty($real_ip_header)) ? ' selected' : '') . '> No Override</option>';
		foreach ($real_ip_headers as $value) {
			echo '
								<option value="' . $value . '"' . (($real_ip_header == $value) ? ' selected' : '') . '> ' . $value . '</option>';
		}

		echo '
							</select>
							<p class="description">
								' . __('If your WordPress is installed behind a reverse proxy or load balancer, the real IP address of the visitors may not forwarded correctly and causing inaccurate country results. Use this option to override the IP detected by IP2Location.', 'ip2location-redirection') . '
							</p>
							<p class="description">
								' . __('Detected IP: <strong>' . $this->get_ip() . '</strong>.', 'ip2location-redirection') . '
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label>' . __('Backup', 'ip2location-redirection') . '</label>
						</th>
						<td>
							<button id="btn_download_backup" type="button" class="button button-secondary">' . __('Download Backup', 'ip2location-redirection') . '</button>
							<p class="description">
								' . __('Download all settings to restore your configuration on new installation.', 'ip2location-redirection') . '
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label>' . __('Restore', 'ip2location-redirection') . '</label>
						</th>
						<td>
							<div id="file-restore"></div>
							<p class="description">
								' . __('Restore settings from previous installation.', 'ip2location-redirection') . '
							</p>
							<input type="hidden" id="restore_nonce" value="' . wp_create_nonce('restore') . '">
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="' . __('Save Changes', 'ip2location-redirection') . '"' . (($disabled) ? ' disabled' : '') . ' />
				</p>

				<input type="hidden" id="update_nonce" value="' . wp_create_nonce('update-database') . '">
				' . wp_nonce_field('save-settings') . '
			</form>

			<form id="form_download_backup" method="post">
				<input type="hidden" name="action" value="download_ip2location_redirection_backup">
			</from>

			<div class="clear"></div>
		</div>';
	}

	public function redirect()
	{
		// Disable redirection on admin pages
		if (is_admin()) {
			return;
		}

		// Disable redirection on admin pages
		if (substr($_SERVER['REQUEST_URI'], 0, 9) == '/wp-login' || substr($_SERVER['REQUEST_URI'], 0, 9) == '/wp-admin') {
			return;
		}

		// Disable redirection on administrator session
		if (current_user_can('administrator')) {
			return;
		}

		// Ignore static files
		if (preg_match('/\.(7z|apk|avi|avif|bin|bmp|bz2|class|css|csv|dmg|doc|docx|ejs|eot|eps|exe|flac|gif|gz|ico|iso|jar|jpeg|jpg|js|mid|midi|mkv|mp3|mp4|ogg|otf|pdf|pict|pls|png|ppt|pptx|ps|rar|svg|svgz|swf|tar|tif|tiff|ttf|webm|webp|woff|woff2|xls|xlsx|zip|zst)$/i', $_SERVER['REQUEST_URI'])) {
			return;
		}

		// Ignore internal XHR calls
		if (preg_match('/wp-json|admin-ajax|wc-ajax|jm-ajax|doing_wp_cron/', $_SERVER['REQUEST_URI'])) {
			return;
		}

		if (!get_option('ip2location_redirection_enabled')) {
			$this->write_debug_log(__('Redirection disabled.', 'ip2location-redirection'));

			return;
		}

		// Overwrite headers to prevent content being cached
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Cache-Control: max-age=0, no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');

		if (get_option('ip2location_redirection_ip_whitelist')) {
			$records = explode(';', get_option('ip2location_redirection_ip_whitelist'));

			foreach ($records as $record) {
				// CIDR notation
				if (strpos($record, '/') !== false) {
					if ($this->cidr_match($this->get_ip(), $record)) {
						$this->write_debug_log('IP is in whitelist.');

						return;
					}
				} else {
					if ($this->get_ip() == $record) {
						$this->write_debug_log('IP is in whitelist.');

						return;
					}
				}
			}
		}

		if (get_option('ip2location_redirection_skip_bots') && $this->is_bot()) {
			$this->write_debug_log('Web crawler detected.');

			return;
		}

		if (get_option('ip2location_redirection_noredirect_enabled')) {
			if (isset($_GET['noredirect']) && trim($_GET['noredirect']) == 'true') {
				$this->write_debug_log('"noredirect" parameter is found.');

				return;
			}
		}

		if (get_option('ip2location_redirection_first_redirect')) {
			if (isset($_COOKIE['ip2location_redirection_first_visit']) && strpos($_COOKIE['ip2location_redirection_first_visit'], ';') !== false) {
				list($time, $hash) = explode(';', $_COOKIE['ip2location_redirection_first_visit']);

				if (md5($time . 'a09f0749-6683-5ada-882c-eb3263a252d3') == $hash) {
					$this->write_debug_log('Non-first visits.');

					return;
				}
			}
		}

		$time = time();

		setcookie('ip2location_redirection_first_visit', $time . ';' . md5($time . 'a09f0749-6683-5ada-882c-eb3263a252d3'), strtotime('+24 hours'), '/', '', true, true);

		if (($rules = json_decode(get_option('ip2location_redirection_rules'))) !== null) {
			$result = $this->get_location($this->get_ip());

			if (empty($result['country_code'])) {
				$this->write_debug_log('Cannot identify location.', 'ERROR');

				return;
			}

			foreach ($rules as $rule) {
				if (isset($rule->is_active)) {
					$is_active = $rule->is_active;
					$country_codes = $rule->country_codes;
					$page_from = $rule->page_from;
					$page_to = $rule->page_to;
					$url_from = $rule->url_from;
					$url_to = $rule->url_to;
					$new_parameter = $rule->new_parameter ?? '';
					$wpml_code = $rule->language_code;
					$http_code = $rule->http_code;
				} else {
					// Legacy supports
					if (count($rule) == 5) {
						$is_active = true;
						$country_codes = explode(';', $rule[0]);
						$page_from = $rule[1];
						$page_to = $rule[2];
						$url_from = '';
						$url_to = $rule[3];
						$new_parameter = '';
						$wpml_code = '';
						$http_code = $rule[4];
					} elseif (count($rule) == 7) {
						$is_active = (bool) $rule[6];
						$country_codes = explode(';', $rule[0]);
						$page_from = $rule[1];
						$page_to = $rule[2];
						$url_from = $rule[3];
						$url_to = $rule[4];
						$new_parameter = '';
						$wpml_code = '';
						$http_code = $rule[5];
					} elseif (count($rule) == 8) {
						$is_active = (bool) $rule[7];
						$country_codes = explode(';', $rule[0]);
						$page_from = $rule[1];
						$page_to = $rule[2];
						$url_from = $rule[3];
						$url_to = $rule[4];
						$new_parameter = '';
						$wpml_code = $rule[5];
						$http_code = $rule[6];
					} elseif (count($rule) == 9) {
						$is_active = (bool) $rule[8];
						$country_codes = explode(';', $rule[0]);
						$page_from = $rule[1];
						$page_to = $rule[2];
						$url_from = $rule[3];
						$url_to = $rule[4];
						$new_parameter = $rules[5];
						$wpml_code = $rule[6];
						$http_code = $rule[7];
					}
				}

				if (!$is_active) {
					continue;
				}

				if ($this->is_country_match($result, $country_codes)) {
					$this->write_debug_log('"' . $result['country_code'] . '" is listed in [' . implode(', ', $country_codes) . ']', 'MATCHED');

					if ($page_from == 'domain') {
						// Keep query string
						if (substr($url_from, 0, 1) == '*') {
							if (substr($url_from, 1) == $_SERVER['HTTP_HOST']) {
								$this->write_debug_log('Domain "' . $url_from . '" matched "' . $_SERVER['HTTP_HOST'] . '".', 'MATCHED');
								$this->redirect_to(str_replace(substr($url_from, 1), $url_to . ((!empty($new_parameter) ? (((strpos($url_to, '?') === false) ? '?' : '&') . $new_parameter) : '')), $this->get_current_url()), $http_code);
							} else {
								$this->write_debug_log('Domain "' . $url_from . '" not match "' . $_SERVER['HTTP_HOST'] . '".');
							}
						} else {
							if ($url_from == $_SERVER['HTTP_HOST']) {
								$this->write_debug_log('Domain "' . $url_from . '" matched "' . $_SERVER['HTTP_HOST'] . '".', 'MATCHED');
								$this->redirect_to(str_replace($url_from, $url_to . ((!empty($new_parameter) ? ('?' . $new_parameter) : '')), $this->get_current_url(false)), $http_code);
							} else {
								$this->write_debug_log('Domain "' . $url_from . '" not match "' . $_SERVER['HTTP_HOST'] . '".');
							}
						}
					}

					if (get_option('ip2location_redirection_ignore_query_string') && strpos($this->get_current_url(), '?') !== false) {
						// Remove query string
						$current_url = trim(substr($this->get_current_url(), 0, strpos($this->get_current_url(), '?')), '/');
					} else {
						$current_url = trim($this->get_current_url(), '/');
					}

					if ($page_from == 'any' || ($page_from == 'home' && $this->is_home()) || ($page_from == 'url' && $current_url == trim($url_from, '/'))) {
						if ($page_to == 'url') {
							if ($_SERVER['QUERY_STRING']) {
								parse_str($_SERVER['QUERY_STRING'], $query_string);

								unset($query_string['page_id'], $query_string['p']);

								$parts = parse_url($url_to);

								$post_query = [];

								if (isset($parts['query'])) {
									parse_str($parts['query'], $post_query);
								}

								$path = (isset($parts['path'])) ? $parts['path'] : '';

								$queries = array_merge($query_string, $post_query);

								unset($queries['p']);

								$extra_queries = [];

								if (!empty($new_parameter)) {
									parse_str($new_parameter, $extra_queries);
								}

								$target_url = $this->build_url($parts['scheme'], $parts['host'], $path, array_merge($queries, $extra_queries));

								// Prevent infinite loop
								if (trim($this->get_current_url(), '/') == trim($url_to, '/')) {
									return;
								}

								$this->redirect_to($target_url, $http_code);
							}

							// Prevent infinite loop
							if (trim($this->get_current_url(), '/') == trim($url_to, '/')) {
								return;
							}

							$this->redirect_to($url_to, $http_code);
						}

						list($page_type, $page_id) = explode('-', $page_to);

						// Prevent infinite loop
						if ($page_id === $this->get_page_id()) {
							return;
						}

						// Prevent infinite loop
						if (rtrim($this->get_current_url(), '/') == rtrim($this->get_permalink($page_id), '/')) {
							return;
						}

						$target_url = $this->get_permalink($page_id);

						if ($wpml_code) {
							$wpml_settings = get_option('icl_sitepress_settings');

							if ($wpml_settings['language_negotiation_type'] == 1) {
								$parts = parse_url($target_url);
								$parts['path'] = '/' . $wpml_code . $parts['path'];
								$target_url = $this->build_url($parts['scheme'], $parts['host'], $parts['path'], []);
							} elseif ($wpml_settings['language_negotiation_type'] == 3) {
								$target_url .= '?lang=' . $wpml_code;
							}
						}

						$this->redirect_to($target_url, $http_code);
					}

					if ($page_from == 'home') {
						$page_id = get_option('page_on_front');
					} else {
						if (strpos($page_from, '-') === false) {
							if ($page_from == 'url') {
								$this->write_debug_log('URL "' . $this->get_current_url() . '" not match "' . $url_from . '".');
							} else {
								$this->write_debug_log('Invalid page "' . $page_from . '".');
							}

							continue;
						}

						list($page_type, $page_id) = explode('-', $page_from);
					}

					if ($page_id === $this->get_page_id()) {
						if ($page_to == 'url') {
							if ($_SERVER['QUERY_STRING']) {
								parse_str($_SERVER['QUERY_STRING'], $query_string);

								unset($query_string['page_id'], $query_string['p'], $query_string['add-to-cart']);

								$parts = parse_url($url_to);

								$post_query = [];

								if (isset($parts['query'])) {
									parse_str($parts['query'], $post_query);
								}

								$queries = array_merge($post_query, $query_string);

								unset($queries['p']);

								$extra_queries = [];

								if (!empty($new_parameter)) {
									parse_str($new_parameter, $extra_queries);
								}

								$this->redirect_to($this->build_url($parts['scheme'], $parts['host'], $parts['path'], array_merge($queries, $extra_queries)), $http_code);
							}

							$this->redirect_to($url_to, $http_code);
						}

						list($page_type, $page_id) = explode('-', $page_to);

						if ($_SERVER['QUERY_STRING']) {
							parse_str($_SERVER['QUERY_STRING'], $query_string);

							unset($query_string['page_id'], $query_string['p'], $query_string['add-to-cart']);

							$post_url = $this->get_permalink($page_id);
							$parts = parse_url($post_url);

							$post_query = [];

							if (isset($parts['query'])) {
								parse_str($parts['query'], $post_query);
							}

							$queries = array_merge($post_query, $query_string);

							if ($wpml_code) {
								$wpml_settings = get_option('icl_sitepress_settings');

								if ($wpml_settings['language_negotiation_type'] == 1) {
									$parts['path'] = '/' . $wpml_code . str_replace('/' . $wpml_code, '', $parts['path']);
								} elseif ($wpml_settings['language_negotiation_type'] == 3) {
									$queries = array_merge($queries, ['lang' => $wpml_code]);
								}
							}

							$extra_queries = [];

							if (!empty($new_parameter)) {
								parse_str($new_parameter, $extra_queries);
							}

							$this->redirect_to($this->build_url($parts['scheme'], $parts['host'], $parts['path'], array_merge($queries, $extra_queries)), $http_code);
						}

						$link = $this->get_permalink($page_id);

						if ($wpml_code) {
							$wpml_settings = get_option('icl_sitepress_settings');

							if ($wpml_settings['language_negotiation_type'] == 1) {
								$parts = parse_url($link);
								$parts['path'] = '/' . $wpml_code . $parts['path'];
								$link = $this->build_url($parts['scheme'], $parts['host'], $parts['path'], []);
							} elseif ($wpml_settings['language_negotiation_type'] == 3) {
								$link .= '?lang=' . $wpml_code;
							}
						}

						if (!empty($new_parameter)) {
							$link .= ((strpos($link, '?') === false) ? '?' : '&') . $new_parameter;
						}

						$this->redirect_to($link, $http_code);
					}

					$this->write_debug_log('Page is not matched.');
				} else {
					$this->write_debug_log('"' . $result['country_code'] . '" is NOT listed in [' . implode(', ', $country_codes) . ']');
				}
			}
		}
	}

	public function footer()
	{
		echo "<!--\n";
		echo "The IP2Location Redirection is using IP2Location LITE geolocation database. Please visit https://lite.ip2location.com for more information.\n";
		echo sha1(microtime()) . "\n";
		echo "-->\n";
	}

	public function write_debug_log($message, $action = 'ABORTED')
	{
		if (!get_option('ip2location_redirection_debug_log_enabled')) {
			return;
		}

		error_log(json_encode([
			'time'      => gmdate('Y-m-d H:i:s'),
			'client_ip' => $this->get_ip(),
			'location'  => $this->session['location'],
			'lookup_by' => $this->session['lookup_mode'],
			'cache'     => $this->session['cache'],
			'uri'       => $this->get_current_url(),
			'message'   => $message,
			'action'    => $action,
		]) . "\n", 3, IPLR_ROOT . $this->debug_log);
	}

	public function admin_footer_text($footer_text)
	{
		global $pagenow;

		$current_screen = get_current_screen();

		if ($current_screen && strpos($current_screen->id, 'ip2location-redirection') !== false) {
			$footer_text .= sprintf(
				__('Enjoyed %1$s? Please leave us a %2$s rating. A huge thanks in advance!', 'ip2location-redirection'),
				'<strong>' . __('IP2Location Redirection', 'ip2location-redirection') . '</strong>',
				'<a href="https://wordpress.org/support/plugin/ip2location-redirection/reviews/?filter=5/#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a>');
		}

		if ($pagenow == 'plugins.php') {
			return $footer_text . '
			<div id="ip2location-redirection-feedback-modal" class="ip2location-modal">
				<div class="ip2location-modal-content">
					<span class="ip2location-close">&times;</span>

					<p>
						<h3>' . __('Would you mind sharing with us the reason to deactivate the plugin?', 'ip2location-redirection') . '</h3>
					</p>
					<span id="ip2location-redirection-feedback-response"></span>
					<p>
						<label>
							<input type="radio" name="ip2location-redirection-feedback" value="1"> ' . __('I no longer need the plugin', 'ip2location-redirection') . '
						</label>
					</p>
					<p>
						<label>
							<input type="radio" name="ip2location-redirection-feedback" value="2"> ' . __('I couldn\'t get the plugin to work', 'ip2location-redirection') . '
						</label>
					</p>
					<p>
						<label>
							<input type="radio" name="ip2location-redirection-feedback" value="3"> ' . __('The plugin doesn\'t meet my requirements', 'ip2location-redirection') . '
						</label>
					</p>
					<p>
						<label>
							<input type="radio" name="ip2location-redirection-feedback" value="4"> ' . __('Other concerns', 'ip2location-redirection') . '
							<br><br>
							<textarea id="ip2location-redirection-feedback-other" style="display:none;width:100%"></textarea>
						</label>
					</p>
					<p>
						<div style="float:left">
							<input type="button" id="ip2location-redirection-submit-feedback-button" class="button button-danger" value="' . __('Submit & Deactivate', 'ip2location-redirection') . '" />
						</div>
						<div style="float:right">
							<a href="#">' . __('Skip & Deactivate', 'ip2location-redirection') . '</a>
						</div>
						<div style="clear:both"></div>
					</p>

					<input type="hidden" id="ip2location-redirection-submit-feedback-nonce" value="' . wp_create_nonce('submit-feedback') . '">
				</div>
			</div>';
		}

		return $footer_text;
	}

	public function hourly_event()
	{
		$this->cache_clear();
		$this->set_priority();
	}

	private function cache_plugin_detected()
	{
		$plugins = [
			'Breeze'           => 'breeze/breeze.php',
			'Cache Enabler'    => 'cache-enabler/cache-enabler.php',
			'LiteSpeed Cache'  => 'litespeed-cache/litespeed-cache.php',
			'Super Page Cache' => 'wp-cloudflare-page-cache/wp-cloudflare-super-page-cache.php',
			'W3 Total Cache'   => 'w3-total-cache/w3-total-cache.php',
			'WP Fastest Cache' => 'wp-fastest-cache/wpFastestCache.php',
			'WP Optimizer'     => 'wp-optimize/wp-optimize.php',
			'WP Rocket'        => 'wp-rocket/wp-rocket.php',
			'WP Super Cache'   => 'wp-super-cache/wp-cache.php',
		];


		foreach ($plugins as $name => $path) {
			if (is_plugin_active($path)) {
				return $name;
			}
		}

		return false;
	}

	private function set_priority()
	{
		global $pagenow;

		// Do not do this in plugins page to prevent deactivation issues.
		if ($pagenow != 'plugins.php') {
			// Make sure this plugin loaded as first priority.
			$this_plugin = plugin_basename(trim(preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . '/$2', __FILE__)));
			$active_plugins = get_option('active_plugins');
			$this_plugin_key = array_search($this_plugin, $active_plugins);

			if ($this_plugin_key) {
				array_splice($active_plugins, $this_plugin_key, 1);
				array_unshift($active_plugins, $this_plugin);
				update_option('active_plugins', $active_plugins);
			}
		}
	}

	private function sanitize_post_inputs()
	{
		if (isset($_POST) && is_array($_POST)) {
			foreach ($_POST as $key => $values) {
				if (is_array($values)) {
					foreach ($values as $index => $value) {
						$values[$index] = strip_tags($value);
					}

					$_POST[$key] = $values;
				} else {
					$_POST[$key] = strip_tags($values);
				}
			}
		}
	}

	private function is_country_match($result, $codes)
	{
		$country_code = $result['country_code'];
		$region_code = $result['region_code'];

		if (is_array($codes)) {
			$index = 0;

			foreach ($codes as $country) {
				if ($country_code == $country) {
					return true;
				}

				if (strpos($country, '.') !== false) {
					if ($region_code == $country) {
						return true;
					}
				}

				if (strpos($country, '.') !== false) {
					if (substr($country, 0, 1) == '-' && substr($country, 1) != $region_code) {
						++$index;
					}
				} else {
					if (substr($country, 0, 1) == '-' && substr($country, 1) != $country_code) {
						++$index;
					}
				}

				if ($index == count($codes)) {
					return true;
				}
			}

			return false;
		}

		if ($country_code == $codes) {
			return true;
		}

		if (substr($codes, 0, 1) == '-' && substr($codes, 1) != $country_code) {
			return true;
		}

		return false;
	}

	private function is_bot()
	{
		if (preg_match('/baidu|bingbot|facebookexternalhit|googlebot|-google|ia_archiver|msnbot|naverbot|pingdom|seznambot|slurp|teoma|twitter|yandex|yeti|linkedinbot|pinterest/i', $this->get_user_agent())) {
			return true;
		}

		return false;
	}

	private function get_user_agent()
	{
		return (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null;
	}

	private function get_ip()
	{
		if (get_option('ip2location_redirection_real_ip_header')) {
			return $_SERVER[get_option('ip2location_redirection_real_ip_header')] ?? $_SERVER['REMOTE_ADDR'];
		}

		// Possible using CloudFlare service
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
			// Make sure originated IP is coming from CloudFlare network
			$networks = [
				'173.245.48.0/20',
				'103.21.244.0/22',
				'103.22.200.0/22',
				'103.31.4.0/22',
				'141.101.64.0/18',
				'108.162.192.0/18',
				'190.93.240.0/20',
				'188.114.96.0/20',
				'197.234.240.0/22',
				'198.41.128.0/17',
				'162.158.0.0/15',
				'104.16.0.0/13',
				'104.24.0.0/14',
				'172.64.0.0/13',
				'131.0.72.0/22',
				'2400:cb00::/32',
				'2606:4700::/32',
				'2803:f800::/32',
				'2405:b500::/32',
				'2405:8100::/32',
				'2a06:98c0::/29',
				'2c0f:f248::/32',
			];

			foreach ($networks as $network) {
				if ($this->cidr_match($_SERVER['REMOTE_ADDR'], $network)) {
					return $_SERVER['HTTP_CF_CONNECTING_IP'];
				}
			}
		}

		// Possible Securi Firewall
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			// Make sure originated IP is coming from Securi network
			$networks = [
				'192.88.134.0/23',
				'185.93.228.0/22',
				'66.248.200.0/22',
				'208.109.0.0/22',
				'2a02:fe80::/29',
			];

			foreach ($networks as $network) {
				if ($this->cidr_match($_SERVER['REMOTE_ADDR'], $network)) {
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
				}
			}
		}

		// Possible local reverse proxy server
		if (!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			if (isset($_SERVER['HTTP_X_REAL_IP']) && filter_var($_SERVER['HTTP_X_REAL_IP'], \FILTER_VALIDATE_IP, \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE)) {
				return $_SERVER['HTTP_X_REAL_IP'];
			}

			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				// Get server IP address
				$server_ip = (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : '';

				$ip = trim(current(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));

				if (filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_NO_PRIV_RANGE | \FILTER_FLAG_NO_RES_RANGE) && $ip != $server_ip) {
					return $ip;
				}
			}
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	private function is_home()
	{
		if (isset($_SERVER['REQUEST_URI']) && preg_replace('/\?[^$]*/', '', $_SERVER['REQUEST_URI']) == '/') {
			return true;
		}

		return is_home();
	}

	private function build_url($scheme, $host, $path, $queries)
	{
		if (!$host) {
			return $path . (($queries) ? ('?' . http_build_query($queries)) : '');
		}

		return $scheme . '://' . $host . (($path) ?: '/') . (($queries) ? ('?' . http_build_query($queries)) : '');
	}

	private function get_current_url($add_query = true)
	{
		$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		$parts = parse_url($current_url);

		$queries = [];

		if (isset($parts['query'])) {
			parse_str($parts['query'], $queries);
		}

		return $this->build_url($parts['scheme'], $parts['host'], (isset($parts['path'])) ? $parts['path'] : '', ($add_query) ? $queries : []);
	}

	private function redirect_to($url, $mode)
	{
		if (preg_match('/page_id=([0-9]+)$/', $url, $matches)) {
			$url = $this->get_permalink($matches[1]);
		}

		$url = preg_replace('/^\/+/', '/', $url);

		$this->write_debug_log('Destination: ' . $url, 'REDIRECTED');

		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $url, true, $mode);

		exit;
	}

	private function get_location($ip)
	{
		// Read result from cache to prevent duplicate lookup.
		if ($data = $this->cache_get($ip)) {
			$this->session['location'] = $data->country_code . (($data->region_code) ? (', ' . $data->region_code) : '');
			$this->session['lookup_mode'] = 'Cache';
			$this->session['cache'] = true;

			return [
				'country_code' => $data->country_code,
				'country_name' => $data->country_name,
				'region_code'  => $data->region_code,
				'region_name'  => $data->region_name,
			];
		}

		switch (get_option('ip2location_redirection_lookup_mode')) {
			// IP2Location Web Service
			case 'ws':
				$this->session['lookup_mode'] = 'WS';

				$response = wp_remote_get('https://api.ip2location.io/?' . http_build_query([
					'key'            => get_option('ip2location_redirection_api_key'),
					'ip'             => $ip,
					'source'         => 'wp-redirection',
					'source_version' => '1.26.7',
				]));

				$json = json_decode($response['body']);

				if (isset($json->error)) {
					$response = wp_remote_get('https://api.ip2location.com/v2/?' . http_build_query([
						'key'     => get_option('ip2location_redirection_api_key'),
						'ip'      => $ip,
						'package' => (get_option('ip2location_redirection_enable_region_redirect')) ? 'WS3' : 'WS1',
					]));

					$json = json_decode($response['body']);

					if (empty($json)) {
						$this->write_debug_log('Web service timed out.', 'ERROR');

						return [
							'country_code' => '',
							'country_name' => '',
							'region_code'  => '',
							'region_name'  => '',
						];
					} elseif ($json->response != 'OK') {
						$this->write_debug_log($json->response, 'ERROR');

						return [
							'country_code' => '',
							'country_name' => '',
							'region_code'  => '',
							'region_name'  => '',
						];
					}
				}

				// Store result into cache for later use.
				$caches = [
					'country_code' => $json->country_code,
					'country_name' => $this->get_country_name($json->country_code),
					'region_code'  => $this->get_region_code($json->country_code, $json->region_name),
					'region_name'  => $json->region_name,
				];

				$this->cache_add($ip, $caches);

				$this->session['location'] = $caches['country_code'] . (($caches['region_code']) ? (', ' . $caches['region_code']) : '');

				return [
					'country_code' => $caches['country_code'],
					'country_name' => $caches['country_name'],
					'region_code'  => $caches['region_code'],
					'region_name'  => $caches['region_name'],
				];
				break;

				// Local BIN database
			default:
			case 'bin':
				$this->session['lookup_mode'] = 'BIN';

				// Make sure IP2Location database is exist.
				if (!is_file(IP2LOCATION_DIR . get_option('ip2location_redirection_database'))) {
					$this->write_debug_log('Database not found.', 'ERROR');

					return [
						'country_code' => '',
						'country_name' => '',
						'region_code'  => '',
						'region_name'  => '',
					];
				}

				// Create IP2Location object.
				$db = new \IP2Location\Database(IP2LOCATION_DIR . get_option('ip2location_redirection_database'), \IP2Location\Database::FILE_IO);

				// Get geolocation by IP address.
				$response = $db->lookup($ip, \IP2Location\Database::ALL);

				if (!isset($response['countryCode'])) {
					return [
						'country_code' => '',
						'country_name' => '',
						'region_code'  => '',
						'region_name'  => '',
					];
				}

				// Store result into cache for later use.
				$caches = [
					'country_code' => $response['countryCode'],
					'country_name' => $response['countryName'],
					'region_code'  => '',
					'region_name'  => '',
				];

				if (!preg_match('/unavailable/', $response['regionName'])) {
					$caches['region_code'] = $this->get_region_code($response['countryCode'], $response['regionName']);
					$caches['region_name'] = $response['regionName'];
				}

				$this->cache_add($ip, $caches);

				$this->session['location'] = $caches['country_code'] . (($caches['region_code']) ? (', ' . $caches['region_code']) : '');

				return [
					'country_code' => $caches['country_code'],
					'country_name' => $caches['country_name'],
					'region_code'  => $caches['region_code'],
					'region_name'  => $caches['region_name'],
				];
				break;
		}
	}

	private function get_country_name($code)
	{
		$countries = ['AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia (Plurinational State of)', 'BQ' => 'Bonaire, Sint Eustatius and Saba', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'CV' => 'Cabo Verde', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo (Democratic Republic of the)', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CW' => 'Curacao', 'CY' => 'Cyprus', 'CZ' => 'Czechia', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island and Mcdonald Islands', 'VA' => 'Holy See', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran (Islamic Republic of)', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'Korea (Democratic People\'s Republic of)', 'KR' => 'Korea (Republic of)', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'North Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia (Federated States of)', 'MD' => 'Moldova (Republic of)', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine, State of', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena, Ascension and Tristan da Cunha', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (French Part)', 'PM' => 'Saint Pierre and Miquelon', 'VC' => 'Saint Vincent and The Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome and Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SX' => 'Sint Maarten (Dutch Part)', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia and The South Sandwich Islands', 'SS' => 'South Sudan', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard and Jan Mayen', 'SZ' => 'Eswatini', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan (Province of China)', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania, United Republic of', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom of Great Britain and Northern Ireland', 'US' => 'United States', 'UM' => 'United States Minor Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela (Bolivarian Republic of)', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands (British)', 'VI' => 'Virgin Islands (U.S.)', 'WF' => 'Wallis and Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'];

		return (isset($countries[$code])) ? $countries[$code] : '';
	}

	private function get_region_code($country_code, $region_name)
	{
		$regions = [
			'AD' => ['AD.07' => 'Andorra la Vella', 'AD.02' => 'Canillo', 'AD.03' => 'Encamp', 'AD.08' => 'Escaldes-Engordany', 'AD.04' => 'La Massana', 'AD.05' => 'Ordino', 'AD.06' => 'Sant Julia de Loria'],
			'AE' => ['AE.AJ' => '\'Ajman', 'AE.AZ' => 'Abu Zaby', 'AE.FU' => 'Al Fujayrah', 'AE.SH' => 'Ash Shariqah', 'AE.DU' => 'Dubayy', 'AE.RK' => 'Ra\'s al Khaymah', 'AE.UQ' => 'Umm al Qaywayn'],
			'AF' => ['AF.BDS' => 'Badakhshan', 'AF.BDG' => 'Badghis', 'AF.BGL' => 'Baghlan', 'AF.BAL' => 'Balkh', 'AF.BAM' => 'Bamyan', 'AF.DAY' => 'Daykundi', 'AF.FRA' => 'Farah', 'AF.FYB' => 'Faryab', 'AF.GHA' => 'Ghazni', 'AF.GHO' => 'Ghor', 'AF.HEL' => 'Helmand', 'AF.HER' => 'Herat', 'AF.JOW' => 'Jowzjan', 'AF.KAB' => 'Kabul', 'AF.KAN' => 'Kandahar', 'AF.KAP' => 'Kapisa', 'AF.KHO' => 'Khost', 'AF.KNR' => 'Kunar', 'AF.KDZ' => 'Kunduz', 'AF.LAG' => 'Laghman', 'AF.LOG' => 'Logar', 'AF.NAN' => 'Nangarhar', 'AF.NIM' => 'Nimroz', 'AF.NUR' => 'Nuristan', 'AF.PKA' => 'Paktika', 'AF.PIA' => 'Paktiya', 'AF.PAN' => 'Panjshayr', 'AF.PAR' => 'Parwan', 'AF.SAM' => 'Samangan', 'AF.SAR' => 'Sar-e Pul', 'AF.TAK' => 'Takhar', 'AF.URU' => 'Uruzgan', 'AF.WAR' => 'Wardak', 'AF.ZAB' => 'Zabul'],
			'AG' => ['AG.10' => 'Barbuda', 'AG.11' => 'Redonda', 'AG.03' => 'Saint George', 'AG.04' => 'Saint John', 'AG.05' => 'Saint Mary', 'AG.06' => 'Saint Paul', 'AG.07' => 'Saint Peter', 'AG.08' => 'Saint Philip'],
			'AL' => ['AL.01' => 'Berat', 'AL.09' => 'Diber', 'AL.02' => 'Durres', 'AL.03' => 'Elbasan', 'AL.04' => 'Fier', 'AL.05' => 'Gjirokaster', 'AL.06' => 'Korce', 'AL.07' => 'Kukes', 'AL.08' => 'Lezhe', 'AL.10' => 'Shkoder', 'AL.11' => 'Tirane', 'AL.12' => 'Vlore'],
			'AM' => ['AM.AG' => 'Aragacotn', 'AM.AR' => 'Ararat', 'AM.AV' => 'Armavir', 'AM.ER' => 'Erevan', 'AM.GR' => 'Gegark\'unik\'', 'AM.KT' => 'Kotayk\'', 'AM.LO' => 'Lori', 'AM.SH' => 'Sirak', 'AM.SU' => 'Syunik\'', 'AM.TV' => 'Tavus', 'AM.VD' => 'Vayoc Jor'],
			'AO' => ['AO.BGO' => 'Bengo', 'AO.BGU' => 'Benguela', 'AO.BIE' => 'Bie', 'AO.CAB' => 'Cabinda', 'AO.CCU' => 'Cuando Cubango', 'AO.CNO' => 'Cuanza-Norte', 'AO.CUS' => 'Cuanza-Sul', 'AO.CNN' => 'Cunene', 'AO.HUA' => 'Huambo', 'AO.HUI' => 'Huila', 'AO.LUA' => 'Luanda', 'AO.LNO' => 'Lunda-Norte', 'AO.LSU' => 'Lunda-Sul', 'AO.MAL' => 'Malange', 'AO.MOX' => 'Moxico', 'AO.NAM' => 'Namibe', 'AO.UIG' => 'Uige', 'AO.ZAI' => 'Zaire'],
			'AR' => ['AR.B' => 'Buenos Aires', 'AR.K' => 'Catamarca', 'AR.H' => 'Chaco', 'AR.U' => 'Chubut', 'AR.C' => 'Ciudad Autonoma de Buenos Aires', 'AR.X' => 'Cordoba', 'AR.W' => 'Corrientes', 'AR.E' => 'Entre Rios', 'AR.P' => 'Formosa', 'AR.Y' => 'Jujuy', 'AR.L' => 'La Pampa', 'AR.F' => 'La Rioja', 'AR.M' => 'Mendoza', 'AR.N' => 'Misiones', 'AR.Q' => 'Neuquen', 'AR.R' => 'Rio Negro', 'AR.A' => 'Salta', 'AR.J' => 'San Juan', 'AR.D' => 'San Luis', 'AR.Z' => 'Santa Cruz', 'AR.S' => 'Santa Fe', 'AR.G' => 'Santiago del Estero', 'AR.V' => 'Tierra del Fuego', 'AR.T' => 'Tucuman'],
			'AT' => ['AT.1' => 'Burgenland', 'AT.2' => 'Karnten', 'AT.3' => 'Niederosterreich', 'AT.4' => 'Oberosterreich', 'AT.5' => 'Salzburg', 'AT.6' => 'Steiermark', 'AT.7' => 'Tirol', 'AT.8' => 'Vorarlberg', 'AT.9' => 'Wien'],
			'AU' => ['AU.ACT' => 'Australian Capital Territory', 'AU.NSW' => 'New South Wales', 'AU.NT' => 'Northern Territory', 'AU.QLD' => 'Queensland', 'AU.SA' => 'South Australia', 'AU.TAS' => 'Tasmania', 'AU.VIC' => 'Victoria', 'AU.WA' => 'Western Australia'],
			'AZ' => ['AZ.ABS' => 'Abseron', 'AZ.AGC' => 'Agcabadi', 'AZ.AGM' => 'Agdam', 'AZ.AGS' => 'Agdas', 'AZ.AGA' => 'Agstafa', 'AZ.AGU' => 'Agsu', 'AZ.AST' => 'Astara', 'AZ.BA' => 'Baki', 'AZ.BAL' => 'Balakan', 'AZ.BAR' => 'Barda', 'AZ.BEY' => 'Beylaqan', 'AZ.BIL' => 'Bilasuvar', 'AZ.CAB' => 'Cabrayil', 'AZ.CAL' => 'Calilabad', 'AZ.CUL' => 'Culfa', 'AZ.DAS' => 'Daskasan', 'AZ.FUZ' => 'Fuzuli', 'AZ.GAD' => 'Gadabay', 'AZ.GA' => 'Ganca', 'AZ.GOR' => 'Goranboy', 'AZ.GOY' => 'Goycay', 'AZ.GYG' => 'Goygol', 'AZ.HAC' => 'Haciqabul', 'AZ.IMI' => 'Imisli', 'AZ.ISM' => 'Ismayilli', 'AZ.KAL' => 'Kalbacar', 'AZ.KAN' => 'Kangarli', 'AZ.KUR' => 'Kurdamir', 'AZ.LAC' => 'Lacin', 'AZ.LA' => 'Lankaran', 'AZ.LER' => 'Lerik', 'AZ.MAS' => 'Masalli', 'AZ.MI' => 'Mingacevir', 'AZ.NA' => 'Naftalan', 'AZ.NX' => 'Naxcivan', 'AZ.NEF' => 'Neftcala', 'AZ.OGU' => 'Oguz', 'AZ.ORD' => 'Ordubad', 'AZ.QAB' => 'Qabala', 'AZ.QAX' => 'Qax', 'AZ.QAZ' => 'Qazax', 'AZ.QOB' => 'Qobustan', 'AZ.QBA' => 'Quba', 'AZ.QBI' => 'Qubadli', 'AZ.QUS' => 'Qusar', 'AZ.SAT' => 'Saatli', 'AZ.SAB' => 'Sabirabad', 'AZ.SBN' => 'Sabran', 'AZ.SAD' => 'Sadarak', 'AZ.SAH' => 'Sahbuz', 'AZ.SAK' => 'Saki', 'AZ.SAL' => 'Salyan', 'AZ.SMI' => 'Samaxi', 'AZ.SKR' => 'Samkir', 'AZ.SMX' => 'Samux', 'AZ.SAR' => 'Sharur', 'AZ.SR' => 'Sirvan', 'AZ.SIY' => 'Siyazan', 'AZ.SM' => 'Sumqayit', 'AZ.SUS' => 'Susa', 'AZ.TAR' => 'Tartar', 'AZ.TOV' => 'Tovuz', 'AZ.UCA' => 'Ucar', 'AZ.XAC' => 'Xacmaz', 'AZ.XA' => 'Xankandi', 'AZ.XIZ' => 'Xizi', 'AZ.XCI' => 'Xocali', 'AZ.XVD' => 'Xocavand', 'AZ.YAR' => 'Yardimli', 'AZ.YEV' => 'Yevlax', 'AZ.ZAN' => 'Zangilan', 'AZ.ZAQ' => 'Zaqatala', 'AZ.ZAR' => 'Zardab'],
			'BA' => ['BA.BRC' => 'Brcko distrikt', 'BA.BIH' => 'Federacija Bosne i Hercegovine', 'BA.SRP' => 'Republika Srpska'],
			'BB' => ['BB.01' => 'Christ Church', 'BB.02' => 'Saint Andrew', 'BB.03' => 'Saint George', 'BB.04' => 'Saint James', 'BB.05' => 'Saint John', 'BB.06' => 'Saint Joseph', 'BB.07' => 'Saint Lucy', 'BB.08' => 'Saint Michael', 'BB.09' => 'Saint Peter', 'BB.10' => 'Saint Philip', 'BB.11' => 'Saint Thomas'],
			'BD' => ['BD.A' => 'Barisal', 'BD.B' => 'Chittagong', 'BD.C' => 'Dhaka', 'BD.D' => 'Khulna', 'BD.E' => 'Rajshahi', 'BD.F' => 'Rangpur', 'BD.G' => 'Sylhet'],
			'BE' => ['BE.VAN' => 'Antwerpen', 'BE.WBR' => 'Brabant wallon', 'BE.BRU' => 'Brussels Hoofdstedelijk Gewest', 'BE.WHT' => 'Hainaut', 'BE.WLG' => 'Liege', 'BE.VLI' => 'Limburg', 'BE.WLX' => 'Luxembourg', 'BE.WNA' => 'Namur', 'BE.VOV' => 'Oost-Vlaanderen', 'BE.VLG' => 'Vlaams Gewest', 'BE.VBR' => 'Vlaams-Brabant', 'BE.VWV' => 'West-Vlaanderen', 'BE.WAL' => 'wallonne, Region'],
			'BF' => ['BF.BAL' => 'Bale', 'BF.BAM' => 'Bam', 'BF.BAN' => 'Banwa', 'BF.BAZ' => 'Bazega', 'BF.BGR' => 'Bougouriba', 'BF.BLG' => 'Boulgou', 'BF.BLK' => 'Boulkiemde', 'BF.COM' => 'Comoe', 'BF.GAN' => 'Ganzourgou', 'BF.GNA' => 'Gnagna', 'BF.GOU' => 'Gourma', 'BF.HOU' => 'Houet', 'BF.IOB' => 'Ioba', 'BF.KAD' => 'Kadiogo', 'BF.KEN' => 'Kenedougou', 'BF.KMD' => 'Komondjari', 'BF.KMP' => 'Kompienga', 'BF.KOS' => 'Kossi', 'BF.KOP' => 'Koulpelogo', 'BF.KOT' => 'Kouritenga', 'BF.KOW' => 'Kourweogo', 'BF.LER' => 'Leraba', 'BF.LOR' => 'Loroum', 'BF.MOU' => 'Mouhoun', 'BF.NAO' => 'Nahouri', 'BF.NAM' => 'Namentenga', 'BF.NAY' => 'Nayala', 'BF.NOU' => 'Noumbiel', 'BF.OUB' => 'Oubritenga', 'BF.OUD' => 'Oudalan', 'BF.PAS' => 'Passore', 'BF.PON' => 'Poni', 'BF.SNG' => 'Sanguie', 'BF.SMT' => 'Sanmatenga', 'BF.SEN' => 'Seno', 'BF.SIS' => 'Sissili', 'BF.SOM' => 'Soum', 'BF.SOR' => 'Sourou', 'BF.TAP' => 'Tapoa', 'BF.TUI' => 'Tuy', 'BF.YAG' => 'Yagha', 'BF.YAT' => 'Yatenga', 'BF.ZIR' => 'Ziro', 'BF.ZON' => 'Zondoma', 'BF.ZOU' => 'Zoundweogo'],
			'BG' => ['BG.01' => 'Blagoevgrad', 'BG.02' => 'Burgas', 'BG.08' => 'Dobrich', 'BG.07' => 'Gabrovo', 'BG.26' => 'Haskovo', 'BG.09' => 'Kardzhali', 'BG.10' => 'Kyustendil', 'BG.11' => 'Lovech', 'BG.12' => 'Montana', 'BG.13' => 'Pazardzhik', 'BG.14' => 'Pernik', 'BG.15' => 'Pleven', 'BG.16' => 'Plovdiv', 'BG.17' => 'Razgrad', 'BG.18' => 'Ruse', 'BG.27' => 'Shumen', 'BG.19' => 'Silistra', 'BG.20' => 'Sliven', 'BG.21' => 'Smolyan', 'BG.23' => 'Sofia', 'BG.22' => 'Sofia (stolitsa)', 'BG.24' => 'Stara Zagora', 'BG.25' => 'Targovishte', 'BG.03' => 'Varna', 'BG.04' => 'Veliko Tarnovo', 'BG.05' => 'Vidin', 'BG.06' => 'Vratsa', 'BG.28' => 'Yambol'],
			'BH' => ['BH.13' => 'Al \'Asimah', 'BH.14' => 'Al Janubiyah', 'BH.15' => 'Al Muharraq', 'BH.17' => 'Ash Shamaliyah'],
			'BI' => ['BI.BB' => 'Bubanza', 'BI.BM' => 'Bujumbura Mairie', 'BI.BL' => 'Bujumbura Rural', 'BI.BR' => 'Bururi', 'BI.CA' => 'Cankuzo', 'BI.CI' => 'Cibitoke', 'BI.GI' => 'Gitega', 'BI.KR' => 'Karuzi', 'BI.KY' => 'Kayanza', 'BI.KI' => 'Kirundo', 'BI.MA' => 'Makamba', 'BI.MU' => 'Muramvya', 'BI.MY' => 'Muyinga', 'BI.MW' => 'Mwaro', 'BI.NG' => 'Ngozi', 'BI.RM' => 'Rumonge', 'BI.RT' => 'Rutana', 'BI.RY' => 'Ruyigi'],
			'BJ' => ['BJ.AL' => 'Alibori', 'BJ.AK' => 'Atacora', 'BJ.AQ' => 'Atlantique', 'BJ.BO' => 'Borgou', 'BJ.CO' => 'Collines', 'BJ.KO' => 'Couffo', 'BJ.DO' => 'Donga', 'BJ.LI' => 'Littoral', 'BJ.MO' => 'Mono', 'BJ.OU' => 'Oueme', 'BJ.PL' => 'Plateau', 'BJ.ZO' => 'Zou'],
			'BN' => ['BN.BE' => 'Belait', 'BN.BM' => 'Brunei-Muara', 'BN.TE' => 'Temburong', 'BN.TU' => 'Tutong'],
			'BO' => ['BO.H' => 'Chuquisaca', 'BO.C' => 'Cochabamba', 'BO.B' => 'El Beni', 'BO.L' => 'La Paz', 'BO.O' => 'Oruro', 'BO.N' => 'Pando', 'BO.P' => 'Potosi', 'BO.S' => 'Santa Cruz', 'BO.T' => 'Tarija'],
			'BQ' => ['BQ.BO' => 'Bonaire', 'BQ.SA' => 'Saba', 'BQ.SE' => 'Sint Eustatius'],
			'BR' => ['BR.AC' => 'Acre', 'BR.AL' => 'Alagoas', 'BR.AP' => 'Amapa', 'BR.AM' => 'Amazonas', 'BR.BA' => 'Bahia', 'BR.CE' => 'Ceara', 'BR.DF' => 'Distrito Federal', 'BR.ES' => 'Espirito Santo', 'BR.GO' => 'Goias', 'BR.MA' => 'Maranhao', 'BR.MT' => 'Mato Grosso', 'BR.MS' => 'Mato Grosso do Sul', 'BR.MG' => 'Minas Gerais', 'BR.PA' => 'Para', 'BR.PB' => 'Paraiba', 'BR.PR' => 'Parana', 'BR.PE' => 'Pernambuco', 'BR.PI' => 'Piaui', 'BR.RN' => 'Rio Grande do Norte', 'BR.RS' => 'Rio Grande do Sul', 'BR.RJ' => 'Rio de Janeiro', 'BR.RO' => 'Rondonia', 'BR.RR' => 'Roraima', 'BR.SC' => 'Santa Catarina', 'BR.SP' => 'Sao Paulo', 'BR.SE' => 'Sergipe', 'BR.TO' => 'Tocantins'],
			'BS' => ['BS.AK' => 'Acklins', 'BS.BY' => 'Berry Islands', 'BS.BI' => 'Bimini', 'BS.BP' => 'Black Point', 'BS.CI' => 'Cat Island', 'BS.CO' => 'Central Abaco', 'BS.CS' => 'Central Andros', 'BS.CE' => 'Central Eleuthera', 'BS.FP' => 'City of Freeport', 'BS.CK' => 'Crooked Island and Long Cay', 'BS.EG' => 'East Grand Bahama', 'BS.EX' => 'Exuma', 'BS.GC' => 'Grand Cay', 'BS.HI' => 'Harbour Island', 'BS.HT' => 'Hope Town', 'BS.IN' => 'Inagua', 'BS.LI' => 'Long Island', 'BS.MC' => 'Mangrove Cay', 'BS.MG' => 'Mayaguana', 'BS.MI' => 'Moore\'s Island', 'BS.NP' => 'New Providence', 'BS.NO' => 'North Abaco', 'BS.NS' => 'North Andros', 'BS.NE' => 'North Eleuthera', 'BS.RI' => 'Ragged Island', 'BS.RC' => 'Rum Cay', 'BS.SS' => 'San Salvador', 'BS.SO' => 'South Abaco', 'BS.SA' => 'South Andros', 'BS.SE' => 'South Eleuthera', 'BS.SW' => 'Spanish Wells', 'BS.WG' => 'West Grand Bahama'],
			'BT' => ['BT.33' => 'Bumthang', 'BT.12' => 'Chhukha', 'BT.22' => 'Dagana', 'BT.GA' => 'Gasa', 'BT.13' => 'Haa', 'BT.44' => 'Lhuentse', 'BT.42' => 'Monggar', 'BT.11' => 'Paro', 'BT.43' => 'Pema Gatshel', 'BT.23' => 'Punakha', 'BT.45' => 'Samdrup Jongkhar', 'BT.14' => 'Samtse', 'BT.31' => 'Sarpang', 'BT.15' => 'Thimphu', 'BT.TY' => 'Trashi Yangtse', 'BT.41' => 'Trashigang', 'BT.32' => 'Trongsa', 'BT.21' => 'Tsirang', 'BT.24' => 'Wangdue Phodrang', 'BT.34' => 'Zhemgang'],
			'BW' => ['BW.CE' => 'Central', 'BW.CH' => 'Chobe', 'BW.GH' => 'Ghanzi', 'BW.KG' => 'Kgalagadi', 'BW.KL' => 'Kgatleng', 'BW.KW' => 'Kweneng', 'BW.NE' => 'North East', 'BW.NW' => 'North West', 'BW.SE' => 'South East', 'BW.SO' => 'Southern'],
			'BY' => ['BY.BR' => 'Brestskaya voblasts\'', 'BY.HO' => 'Homyel\'skaya voblasts\'', 'BY.HM' => 'Horad Minsk', 'BY.HR' => 'Hrodzenskaya voblasts\'', 'BY.MA' => 'Mahilyowskaya voblasts\'', 'BY.MI' => 'Minskaya voblasts\'', 'BY.VI' => 'Vitsyebskaya voblasts\''],
			'BZ' => ['BZ.BZ' => 'Belize', 'BZ.CY' => 'Cayo', 'BZ.CZL' => 'Corozal', 'BZ.OW' => 'Orange Walk', 'BZ.SC' => 'Stann Creek', 'BZ.TOL' => 'Toledo'],
			'CA' => ['CA.AB' => 'Alberta', 'CA.BC' => 'British Columbia', 'CA.MB' => 'Manitoba', 'CA.NB' => 'New Brunswick', 'CA.NL' => 'Newfoundland and Labrador', 'CA.NT' => 'Northwest Territories', 'CA.NS' => 'Nova Scotia', 'CA.NU' => 'Nunavut', 'CA.ON' => 'Ontario', 'CA.PE' => 'Prince Edward Island', 'CA.QC' => 'Quebec', 'CA.SK' => 'Saskatchewan', 'CA.YT' => 'Yukon'],
			'CD' => ['CD.BU' => 'Bas-Uele', 'CD.EQ' => 'Equateur', 'CD.HK' => 'Haut-Katanga', 'CD.HL' => 'Haut-Lomami', 'CD.HU' => 'Haut-Uele', 'CD.IT' => 'Ituri', 'CD.KS' => 'Kasai', 'CD.KC' => 'Kasai Central', 'CD.KE' => 'Kasai Oriental', 'CD.KN' => 'Kinshasa', 'CD.BC' => 'Kongo Central', 'CD.KG' => 'Kwango', 'CD.KL' => 'Kwilu', 'CD.LO' => 'Lomami', 'CD.LU' => 'Lualaba', 'CD.MN' => 'Mai-Ndombe', 'CD.MA' => 'Maniema', 'CD.MO' => 'Mongala', 'CD.NK' => 'NorD.Kivu', 'CD.NU' => 'NorD.Ubangi', 'CD.SA' => 'Sankuru', 'CD.SK' => 'SuD.Kivu', 'CD.SU' => 'SuD.Ubangi', 'CD.TA' => 'Tanganyika', 'CD.TO' => 'Tshopo', 'CD.TU' => 'Tshuapa'],
			'CF' => ['CF.BB' => 'Bamingui-Bangoran', 'CF.BGF' => 'Bangui', 'CF.BK' => 'Basse-Kotto', 'CF.KB' => 'Gribingui', 'CF.HM' => 'Haut-Mbomou', 'CF.HK' => 'Haute-Kotto', 'CF.KG' => 'Kemo-Gribingui', 'CF.LB' => 'Lobaye', 'CF.HS' => 'Mambere-Kadei', 'CF.MB' => 'Mbomou', 'CF.NM' => 'Nana-Mambere', 'CF.MP' => 'Ombella-Mpoko', 'CF.UK' => 'Ouaka', 'CF.AC' => 'Ouham', 'CF.OP' => 'Ouham-Pende', 'CF.SE' => 'Sangha', 'CF.VK' => 'Vakaga'],
			'CG' => ['CG.11' => 'Bouenza', 'CG.BZV' => 'Brazzaville', 'CG.8' => 'Cuvette', 'CG.15' => 'Cuvette-Ouest', 'CG.5' => 'Kouilou', 'CG.2' => 'Lekoumou', 'CG.7' => 'Likouala', 'CG.9' => 'Niari', 'CG.14' => 'Plateaux', 'CG.16' => 'Pointe-Noire', 'CG.12' => 'Pool', 'CG.13' => 'Sangha'],
			'CH' => ['CH.AG' => 'Aargau', 'CH.AR' => 'Appenzell Ausserrhoden', 'CH.AI' => 'Appenzell Innerrhoden', 'CH.BL' => 'Basel-Landschaft', 'CH.BS' => 'Basel-Stadt', 'CH.BE' => 'Bern', 'CH.FR' => 'Fribourg', 'CH.GE' => 'Geneve', 'CH.GL' => 'Glarus', 'CH.GR' => 'Graubunden', 'CH.JU' => 'Jura', 'CH.LU' => 'Luzern', 'CH.NE' => 'Neuchatel', 'CH.NW' => 'Nidwalden', 'CH.OW' => 'Obwalden', 'CH.SG' => 'Sankt Gallen', 'CH.SH' => 'Schaffhausen', 'CH.SZ' => 'Schwyz', 'CH.SO' => 'Solothurn', 'CH.TG' => 'Thurgau', 'CH.TI' => 'Ticino', 'CH.UR' => 'Uri', 'CH.VS' => 'Valais', 'CH.VD' => 'Vaud', 'CH.ZG' => 'Zug', 'CH.ZH' => 'Zurich'],
			'CI' => ['CI.AB' => 'Abidjan', 'CI.BS' => 'Bas-Sassandra', 'CI.CM' => 'Comoe', 'CI.DN' => 'Denguele', 'CI.GD' => 'Goh-Djiboua', 'CI.LC' => 'Lacs', 'CI.LG' => 'Lagunes', 'CI.MG' => 'Montagnes', 'CI.SM' => 'Sassandra-Marahoue', 'CI.SV' => 'Savanes', 'CI.VB' => 'Vallee du Bandama', 'CI.WR' => 'Woroba', 'CI.YM' => 'Yamoussoukro', 'CI.ZZ' => 'Zanzan'],
			'CL' => ['CL.AI' => 'Aisen del General Carlos Ibanez del Campo', 'CL.AN' => 'Antofagasta', 'CL.AP' => 'Arica y Parinacota', 'CL.AT' => 'Atacama', 'CL.BI' => 'Biobio', 'CL.CO' => 'Coquimbo', 'CL.AR' => 'La Araucania', 'CL.LI' => 'Libertador General Bernardo O\'Higgins', 'CL.LL' => 'Los Lagos', 'CL.LR' => 'Los Rios', 'CL.MA' => 'Magallanes', 'CL.ML' => 'Maule', 'CL.NB' => 'Nuble', 'CL.RM' => 'Region Metropolitana de Santiago', 'CL.TA' => 'Tarapaca', 'CL.VS' => 'Valparaiso'],
			'CM' => ['CM.AD' => 'Adamaoua', 'CM.CE' => 'Centre', 'CM.ES' => 'Est', 'CM.EN' => 'Extreme-Nord', 'CM.LT' => 'Littoral', 'CM.NO' => 'Nord', 'CM.NW' => 'Nord-Ouest', 'CM.OU' => 'Ouest', 'CM.SU' => 'Sud', 'CM.SW' => 'Sud-Ouest'],
			'CN' => ['CN.AH' => 'Anhui', 'CN.BJ' => 'Beijing', 'CN.CQ' => 'Chongqing', 'CN.FJ' => 'Fujian', 'CN.GS' => 'Gansu', 'CN.GD' => 'Guangdong', 'CN.GX' => 'Guangxi', 'CN.GZ' => 'Guizhou', 'CN.HI' => 'Hainan', 'CN.HE' => 'Hebei', 'CN.HL' => 'Heilongjiang', 'CN.HA' => 'Henan', 'CN.HB' => 'Hubei', 'CN.HN' => 'Hunan', 'CN.JS' => 'Jiangsu', 'CN.JX' => 'Jiangxi', 'CN.JL' => 'Jilin', 'CN.LN' => 'Liaoning', 'CN.NM' => 'Nei Mongol', 'CN.NX' => 'Ningxia', 'CN.QH' => 'Qinghai', 'CN.SN' => 'Shaanxi', 'CN.SD' => 'Shandong', 'CN.SH' => 'Shanghai', 'CN.SX' => 'Shanxi', 'CN.SC' => 'Sichuan', 'CN.TJ' => 'Tianjin', 'CN.XJ' => 'Xinjiang', 'CN.XZ' => 'Xizang', 'CN.YN' => 'Yunnan', 'CN.ZJ' => 'Zhejiang'],
			'CO' => ['CO.AMA' => 'Amazonas', 'CO.ANT' => 'Antioquia', 'CO.ARA' => 'Arauca', 'CO.ATL' => 'Atlantico', 'CO.BOL' => 'Bolivar', 'CO.BOY' => 'Boyaca', 'CO.CAL' => 'Caldas', 'CO.CAQ' => 'Caqueta', 'CO.CAS' => 'Casanare', 'CO.CAU' => 'Cauca', 'CO.CES' => 'Cesar', 'CO.CHO' => 'Choco', 'CO.COR' => 'Cordoba', 'CO.CUN' => 'Cundinamarca', 'CO.DC' => 'Distrito Capital de Bogota', 'CO.GUA' => 'Guainia', 'CO.GUV' => 'Guaviare', 'CO.HUI' => 'Huila', 'CO.LAG' => 'La Guajira', 'CO.MAG' => 'Magdalena', 'CO.MET' => 'Meta', 'CO.NAR' => 'Narino', 'CO.NSA' => 'Norte de Santander', 'CO.PUT' => 'Putumayo', 'CO.QUI' => 'Quindio', 'CO.RIS' => 'Risaralda', 'CO.SAP' => 'San Andres, Providencia y Santa Catalina', 'CO.SAN' => 'Santander', 'CO.SUC' => 'Sucre', 'CO.TOL' => 'Tolima', 'CO.VAC' => 'Valle del Cauca', 'CO.VAU' => 'Vaupes', 'CO.VID' => 'Vichada'],
			'CR' => ['CR.A' => 'Alajuela', 'CR.C' => 'Cartago', 'CR.G' => 'Guanacaste', 'CR.H' => 'Heredia', 'CR.L' => 'Limon', 'CR.P' => 'Puntarenas', 'CR.SJ' => 'San Jose'],
			'CU' => ['CU.15' => 'Artemisa', 'CU.09' => 'Camaguey', 'CU.08' => 'Ciego de Avila', 'CU.06' => 'Cienfuegos', 'CU.12' => 'Granma', 'CU.14' => 'Guantanamo', 'CU.11' => 'Holguin', 'CU.99' => 'Isla de la Juventud', 'CU.03' => 'La Habana', 'CU.10' => 'Las Tunas', 'CU.04' => 'Matanzas', 'CU.16' => 'Mayabeque', 'CU.01' => 'Pinar del Rio', 'CU.07' => 'Sancti Spiritus', 'CU.13' => 'Santiago de Cuba', 'CU.05' => 'Villa Clara'],
			'CV' => ['CV.BV' => 'Boa Vista', 'CV.BR' => 'Brava', 'CV.MA' => 'Maio', 'CV.MO' => 'Mosteiros', 'CV.PA' => 'Paul', 'CV.PN' => 'Porto Novo', 'CV.PR' => 'Praia', 'CV.RB' => 'Ribeira Brava', 'CV.RG' => 'Ribeira Grande', 'CV.RS' => 'Ribeira Grande de Santiago', 'CV.SL' => 'Sal', 'CV.CA' => 'Santa Catarina', 'CV.CF' => 'Santa Catarina do Fogo', 'CV.CR' => 'Santa Cruz', 'CV.SD' => 'Sao Domingos', 'CV.SF' => 'Sao Filipe', 'CV.SO' => 'Sao Lourenco dos Orgaos', 'CV.SM' => 'Sao Miguel', 'CV.SS' => 'Sao Salvador do Mundo', 'CV.SV' => 'Sao Vicente', 'CV.TA' => 'Tarrafal', 'CV.TS' => 'Tarrafal de Sao Nicolau'],
			'CY' => ['CY.04' => 'Ammochostos', 'CY.06' => 'Keryneia', 'CY.03' => 'Larnaka', 'CY.01' => 'Lefkosia', 'CY.02' => 'Lemesos', 'CY.05' => 'Pafos'],
			'CZ' => ['CZ.31' => 'Jihocesky kraj', 'CZ.64' => 'Jihomoravsky kraj', 'CZ.41' => 'Karlovarsky kraj', 'CZ.63' => 'Kraj Vysocina', 'CZ.52' => 'Kralovehradecky kraj', 'CZ.51' => 'Liberecky kraj', 'CZ.80' => 'Moravskoslezsky kraj', 'CZ.71' => 'Olomoucky kraj', 'CZ.53' => 'Pardubicky kraj', 'CZ.32' => 'Plzensky kraj', 'CZ.10' => 'Praha, Hlavni mesto', 'CZ.20' => 'Stredocesky kraj', 'CZ.42' => 'Ustecky kraj', 'CZ.72' => 'Zlinsky kraj'],
			'DE' => ['DE.BW' => 'Baden-Wurttemberg', 'DE.BY' => 'Bayern', 'DE.BE' => 'Berlin', 'DE.BB' => 'Brandenburg', 'DE.HB' => 'Bremen', 'DE.HH' => 'Hamburg', 'DE.HE' => 'Hessen', 'DE.MV' => 'Mecklenburg-Vorpommern', 'DE.NI' => 'Niedersachsen', 'DE.NW' => 'Nordrhein-Westfalen', 'DE.RP' => 'Rheinland-Pfalz', 'DE.SL' => 'Saarland', 'DE.SN' => 'Sachsen', 'DE.ST' => 'Sachsen-Anhalt', 'DE.SH' => 'Schleswig-Holstein', 'DE.TH' => 'Thuringen'],
			'DJ' => ['DJ.AS' => 'Ali Sabieh', 'DJ.AR' => 'Arta', 'DJ.DI' => 'Dikhil', 'DJ.DJ' => 'Djibouti', 'DJ.OB' => 'Obock', 'DJ.TA' => 'Tadjourah'],
			'DK' => ['DK.84' => 'Hovedstaden', 'DK.82' => 'Midtjylland', 'DK.81' => 'Nordjylland', 'DK.85' => 'Sjaelland', 'DK.83' => 'Syddanmark'],
			'DM' => ['DM.02' => 'Saint Andrew', 'DM.03' => 'Saint David', 'DM.04' => 'Saint George', 'DM.05' => 'Saint John', 'DM.06' => 'Saint Joseph', 'DM.07' => 'Saint Luke', 'DM.08' => 'Saint Mark', 'DM.09' => 'Saint Patrick', 'DM.10' => 'Saint Paul', 'DM.11' => 'Saint Peter'],
			'DO' => ['DO.02' => 'Azua', 'DO.03' => 'Baoruco', 'DO.04' => 'Barahona', 'DO.05' => 'Dajabon', 'DO.01' => 'Distrito Nacional (Santo Domingo)', 'DO.06' => 'Duarte', 'DO.08' => 'El Seibo', 'DO.07' => 'Elias Pina', 'DO.09' => 'Espaillat', 'DO.30' => 'Hato Mayor', 'DO.19' => 'Hermanas Mirabal', 'DO.10' => 'Independencia', 'DO.11' => 'La Altagracia', 'DO.12' => 'La Romana', 'DO.13' => 'La Vega', 'DO.14' => 'Maria Trinidad Sanchez', 'DO.28' => 'Monsenor Nouel', 'DO.15' => 'Monte Cristi', 'DO.29' => 'Monte Plata', 'DO.16' => 'Pedernales', 'DO.17' => 'Peravia', 'DO.18' => 'Puerto Plata', 'DO.20' => 'Samana', 'DO.21' => 'San Cristobal', 'DO.31' => 'San Jose de Ocoa', 'DO.22' => 'San Juan', 'DO.23' => 'San Pedro de Macoris', 'DO.24' => 'Sanchez Ramirez', 'DO.25' => 'Santiago', 'DO.26' => 'Santiago Rodriguez', 'DO.32' => 'Santo Domingo', 'DO.27' => 'Valverde'],
			'DZ' => ['DZ.01' => 'Adrar', 'DZ.44' => 'Ain Defla', 'DZ.46' => 'Ain Temouchent', 'DZ.16' => 'Alger', 'DZ.23' => 'Annaba', 'DZ.05' => 'Batna', 'DZ.08' => 'Bechar', 'DZ.06' => 'Bejaia', 'DZ.52' => 'Beni Abbes', 'DZ.07' => 'Biskra', 'DZ.09' => 'Blida', 'DZ.50' => 'Bordj Badji Mokhtar', 'DZ.34' => 'Bordj Bou Arreridj', 'DZ.10' => 'Bouira', 'DZ.35' => 'Boumerdes', 'DZ.02' => 'Chlef', 'DZ.25' => 'Constantine', 'DZ.56' => 'Djanet', 'DZ.17' => 'Djelfa', 'DZ.32' => 'El Bayadh', 'DZ.57' => 'El Meghaier', 'DZ.58' => 'El Meniaa', 'DZ.39' => 'El Oued', 'DZ.36' => 'El Tarf', 'DZ.47' => 'Ghardaia', 'DZ.24' => 'Guelma', 'DZ.33' => 'Illizi', 'DZ.54' => 'In Guezzam', 'DZ.53' => 'In Salah', 'DZ.18' => 'Jijel', 'DZ.40' => 'Khenchela', 'DZ.03' => 'Laghouat', 'DZ.28' => 'M\'sila', 'DZ.29' => 'Mascara', 'DZ.26' => 'Medea', 'DZ.43' => 'Mila', 'DZ.27' => 'Mostaganem', 'DZ.45' => 'Naama', 'DZ.31' => 'Oran', 'DZ.30' => 'Ouargla', 'DZ.51' => 'Ouled Djellal', 'DZ.04' => 'Oum el Bouaghi', 'DZ.48' => 'Relizane', 'DZ.20' => 'Saida', 'DZ.19' => 'Setif', 'DZ.22' => 'Sidi Bel Abbes', 'DZ.21' => 'Skikda', 'DZ.41' => 'Souk Ahras', 'DZ.11' => 'Tamanrasset', 'DZ.12' => 'Tebessa', 'DZ.14' => 'Tiaret', 'DZ.49' => 'Timimoun', 'DZ.37' => 'Tindouf', 'DZ.42' => 'Tipaza', 'DZ.38' => 'Tissemsilt', 'DZ.15' => 'Tizi Ouzou', 'DZ.13' => 'Tlemcen', 'DZ.55' => 'Touggourt'],
			'EC' => ['EC.A' => 'Azuay', 'EC.B' => 'Bolivar', 'EC.F' => 'Canar', 'EC.C' => 'Carchi', 'EC.H' => 'Chimborazo', 'EC.X' => 'Cotopaxi', 'EC.O' => 'El Oro', 'EC.E' => 'Esmeraldas', 'EC.W' => 'Galapagos', 'EC.G' => 'Guayas', 'EC.I' => 'Imbabura', 'EC.L' => 'Loja', 'EC.R' => 'Los Rios', 'EC.M' => 'Manabi', 'EC.S' => 'Morona Santiago', 'EC.N' => 'Napo', 'EC.D' => 'Orellana', 'EC.Y' => 'Pastaza', 'EC.P' => 'Pichincha', 'EC.SE' => 'Santa Elena', 'EC.SD' => 'Santo Domingo de los Tsachilas', 'EC.U' => 'Sucumbios', 'EC.T' => 'Tungurahua', 'EC.Z' => 'Zamora Chinchipe'],
			'EE' => ['EE.37' => 'Harjumaa', 'EE.39' => 'Hiiumaa', 'EE.44' => 'Ida-Virumaa', 'EE.51' => 'Jarvamaa', 'EE.49' => 'Jogevamaa', 'EE.59' => 'Laane-Virumaa', 'EE.57' => 'Laanemaa', 'EE.67' => 'Parnumaa', 'EE.65' => 'Polvamaa', 'EE.70' => 'Raplamaa', 'EE.74' => 'Saaremaa', 'EE.78' => 'Tartumaa', 'EE.82' => 'Valgamaa', 'EE.84' => 'Viljandimaa', 'EE.86' => 'Vorumaa'],
			'EG' => ['EG.DK' => 'Ad Daqahliyah', 'EG.BA' => 'Al Bahr al Ahmar', 'EG.BH' => 'Al Buhayrah', 'EG.FYM' => 'Al Fayyum', 'EG.GH' => 'Al Gharbiyah', 'EG.ALX' => 'Al Iskandariyah', 'EG.IS' => 'Al Isma\'iliyah', 'EG.GZ' => 'Al Jizah', 'EG.MNF' => 'Al Minufiyah', 'EG.MN' => 'Al Minya', 'EG.C' => 'Al Qahirah', 'EG.KB' => 'Al Qalyubiyah', 'EG.LX' => 'Al Uqsur', 'EG.WAD' => 'Al Wadi al Jadid', 'EG.SUZ' => 'As Suways', 'EG.SHR' => 'Ash Sharqiyah', 'EG.ASN' => 'Aswan', 'EG.AST' => 'Asyut', 'EG.BNS' => 'Bani Suwayf', 'EG.PTS' => 'Bur Sa\'id', 'EG.DT' => 'Dumyat', 'EG.JS' => 'Janub Sina\'', 'EG.KFS' => 'Kafr ash Shaykh', 'EG.MT' => 'Matruh', 'EG.KN' => 'Qina', 'EG.SIN' => 'Shamal Sina\'', 'EG.SHG' => 'Suhaj'],
			'ER' => ['ER.MA' => 'Al Awsat', 'ER.DU' => 'Al Janubi', 'ER.AN' => 'Ansaba', 'ER.DK' => 'Janubi al Bahri al Ahmar', 'ER.GB' => 'Qash-Barkah', 'ER.SK' => 'Shimali al Bahri al Ahmar'],
			'ES' => ['ES.AN' => 'Andalucia', 'ES.AR' => 'Aragon', 'ES.AS' => 'Asturias, Principado de', 'ES.CN' => 'Canarias', 'ES.CB' => 'Cantabria', 'ES.CL' => 'Castilla y Leon', 'ES.CM' => 'Castilla-La Mancha', 'ES.CT' => 'Catalunya', 'ES.CE' => 'Ceuta', 'ES.EX' => 'Extremadura', 'ES.GA' => 'Galicia', 'ES.IB' => 'Illes Balears', 'ES.RI' => 'La Rioja', 'ES.MD' => 'Madrid, Comunidad de', 'ES.ML' => 'Melilla', 'ES.MC' => 'Murcia, Region de', 'ES.NC' => 'Navarra, Comunidad Foral de', 'ES.PV' => 'Pais Vasco', 'ES.VC' => 'Valenciana, Comunidad'],
			'ET' => ['ET.AA' => 'Addis Ababa', 'ET.AF' => 'Afar', 'ET.AM' => 'Amara', 'ET.BE' => 'Benshangul-Gumaz', 'ET.DD' => 'Dire Dawa', 'ET.GA' => 'Gambela Peoples', 'ET.HA' => 'Harari People', 'ET.OR' => 'Oromia', 'ET.SI' => 'Sidama', 'ET.SO' => 'Somali', 'ET.SN' => 'Southern Nations, Nationalities and Peoples', 'ET.SW' => 'Southwest Ethiopia Peoples', 'ET.TI' => 'Tigrai'],
			'FI' => ['FI.01' => 'Ahvenanmaan maakunta', 'FI.02' => 'Etela-Karjala', 'FI.03' => 'Etela-Pohjanmaa', 'FI.04' => 'Etela-Savo', 'FI.05' => 'Kainuu', 'FI.06' => 'Kanta-Hame', 'FI.07' => 'Keski-Pohjanmaa', 'FI.08' => 'Keski-Suomi', 'FI.09' => 'Kymenlaakso', 'FI.10' => 'Lappi', 'FI.16' => 'Paijat-Hame', 'FI.11' => 'Pirkanmaa', 'FI.12' => 'Pohjanmaa', 'FI.13' => 'Pohjois-Karjala', 'FI.14' => 'Pohjois-Pohjanmaa', 'FI.15' => 'Pohjois-Savo', 'FI.17' => 'Satakunta', 'FI.18' => 'Uusimaa', 'FI.19' => 'Varsinais-Suomi'],
			'FJ' => ['FJ.C' => 'Central', 'FJ.E' => 'Eastern', 'FJ.N' => 'Northern', 'FJ.R' => 'Rotuma', 'FJ.W' => 'Western'],
			'FM' => ['FM.TRK' => 'Chuuk', 'FM.KSA' => 'Kosrae', 'FM.PNI' => 'Pohnpei', 'FM.YAP' => 'Yap'],
			'FR' => ['FR.ARA' => 'Auvergne-Rhone-Alpes', 'FR.BFC' => 'Bourgogne-Franche-Comte', 'FR.BRE' => 'Bretagne', 'FR.CVL' => 'Centre-Val de Loire', 'FR.COR' => 'Corse', 'FR.GES' => 'Grand-Est', 'FR.HDF' => 'Hauts-de-France', 'FR.IDF' => 'Ile-de-France', 'FR.NOR' => 'Normandie', 'FR.NAQ' => 'Nouvelle-Aquitaine', 'FR.OCC' => 'Occitanie', 'FR.PDL' => 'Pays-de-la-Loire', 'FR.PAC' => 'Provence-Alpes-Cote-d\'Azur'],
			'GA' => ['GA.1' => 'Estuaire', 'GA.2' => 'Haut-Ogooue', 'GA.3' => 'Moyen-Ogooue', 'GA.4' => 'Ngounie', 'GA.5' => 'Nyanga', 'GA.6' => 'Ogooue-Ivindo', 'GA.7' => 'Ogooue-Lolo', 'GA.8' => 'Ogooue-Maritime', 'GA.9' => 'Woleu-Ntem'],
			'GB' => ['GB.ENG' => 'England', 'GB.NIR' => 'Northern Ireland', 'GB.SCT' => 'Scotland', 'GB.WLS' => 'Wales'],
			'GD' => ['GD.01' => 'Saint Andrew', 'GD.02' => 'Saint David', 'GD.03' => 'Saint George', 'GD.04' => 'Saint John', 'GD.05' => 'Saint Mark', 'GD.06' => 'Saint Patrick', 'GD.10' => 'Southern Grenadine Islands'],
			'GE' => ['GE.AB' => 'Abkhazia', 'GE.AJ' => 'Ajaria', 'GE.GU' => 'Guria', 'GE.IM' => 'Imereti', 'GE.KA' => 'K\'akheti', 'GE.KK' => 'Kvemo Kartli', 'GE.MM' => 'Mtskheta-Mtianeti', 'GE.RL' => 'Rach\'a-Lechkhumi-Kvemo Svaneti', 'GE.SZ' => 'Samegrelo-Zemo Svaneti', 'GE.SJ' => 'Samtskhe-Javakheti', 'GE.SK' => 'Shida Kartli', 'GE.TB' => 'Tbilisi'],
			'GH' => ['GH.AF' => 'Ahafo', 'GH.AH' => 'Ashanti', 'GH.BO' => 'Bono', 'GH.BE' => 'Bono East', 'GH.CP' => 'Central', 'GH.EP' => 'Eastern', 'GH.AA' => 'Greater Accra', 'GH.NP' => 'Northern', 'GH.OT' => 'Oti', 'GH.SV' => 'Savannah', 'GH.UE' => 'Upper East', 'GH.UW' => 'Upper West', 'GH.TV' => 'Volta', 'GH.WP' => 'Western', 'GH.WN' => 'Western North'],
			'GL' => ['GL.AV' => 'Avannaata Kommunia', 'GL.KU' => 'Kommune Kujalleq', 'GL.QT' => 'Kommune Qeqertalik', 'GL.SM' => 'Kommuneqarfik Sermersooq', 'GL.QE' => 'Qeqqata Kommunia'],
			'GM' => ['GM.B' => 'Banjul', 'GM.M' => 'Central River', 'GM.L' => 'Lower River', 'GM.N' => 'North Bank', 'GM.U' => 'Upper River', 'GM.W' => 'Western'],
			'GN' => ['GN.BE' => 'Beyla', 'GN.BF' => 'Boffa', 'GN.B' => 'Boke', 'GN.C' => 'Conakry', 'GN.CO' => 'Coyah', 'GN.DB' => 'Dabola', 'GN.DL' => 'Dalaba', 'GN.DI' => 'Dinguiraye', 'GN.DU' => 'Dubreka', 'GN.F' => 'Faranah', 'GN.FA' => 'Faranah', 'GN.FO' => 'Forecariah', 'GN.FR' => 'Fria', 'GN.GA' => 'Gaoual', 'GN.GU' => 'Guekedou', 'GN.K' => 'Kankan', 'GN.KE' => 'Kerouane', 'GN.D' => 'Kindia', 'GN.KS' => 'Kissidougou', 'GN.KB' => 'Koubia', 'GN.KN' => 'Koundara', 'GN.KO' => 'Kouroussa', 'GN.L' => 'Labe', 'GN.LA' => 'Labe', 'GN.LE' => 'Lelouma', 'GN.LO' => 'Lola', 'GN.MC' => 'Macenta', 'GN.ML' => 'Mali', 'GN.M' => 'Mamou', 'GN.MD' => 'Mandiana', 'GN.N' => 'Nzerekore', 'GN.PI' => 'Pita', 'GN.SI' => 'Siguiri', 'GN.TE' => 'Telimele', 'GN.TO' => 'Tougue', 'GN.YO' => 'Yomou'],
			'GQ' => ['GQ.AN' => 'Annobon', 'GQ.BN' => 'Bioko Norte', 'GQ.BS' => 'Bioko Sur', 'GQ.CS' => 'Centro Sur', 'GQ.DJ' => 'Djibloho', 'GQ.KN' => 'Kie-Ntem', 'GQ.LI' => 'Litoral', 'GQ.WN' => 'Wele-Nzas'],
			'GR' => ['GR.69' => 'Agion Oros', 'GR.A' => 'Anatoliki Makedonia kai Thraki', 'GR.I' => 'Attiki', 'GR.G' => 'Dytiki Ellada', 'GR.C' => 'Dytiki Makedonia', 'GR.F' => 'Ionia Nisia', 'GR.D' => 'Ipeiros', 'GR.B' => 'Kentriki Makedonia', 'GR.M' => 'Kriti', 'GR.L' => 'Notio Aigaio', 'GR.J' => 'Peloponnisos', 'GR.H' => 'Sterea Ellada', 'GR.E' => 'Thessalia', 'GR.K' => 'Voreio Aigaio'],
			'GT' => ['GT.AV' => 'Alta Verapaz', 'GT.BV' => 'Baja Verapaz', 'GT.CM' => 'Chimaltenango', 'GT.CQ' => 'Chiquimula', 'GT.PR' => 'El Progreso', 'GT.ES' => 'Escuintla', 'GT.GU' => 'Guatemala', 'GT.HU' => 'Huehuetenango', 'GT.IZ' => 'Izabal', 'GT.JA' => 'Jalapa', 'GT.JU' => 'Jutiapa', 'GT.PE' => 'Peten', 'GT.QZ' => 'Quetzaltenango', 'GT.QC' => 'Quiche', 'GT.RE' => 'Retalhuleu', 'GT.SA' => 'Sacatepequez', 'GT.SM' => 'San Marcos', 'GT.SR' => 'Santa Rosa', 'GT.SO' => 'Solola', 'GT.SU' => 'Suchitepequez', 'GT.TO' => 'Totonicapan', 'GT.ZA' => 'Zacapa'],
			'GW' => ['GW.BA' => 'Bafata', 'GW.BM' => 'Biombo', 'GW.BS' => 'Bissau', 'GW.BL' => 'Bolama', 'GW.CA' => 'Cacheu', 'GW.GA' => 'Gabu', 'GW.OI' => 'Oio', 'GW.QU' => 'Quinara', 'GW.TO' => 'Tombali'],
			'GY' => ['GY.BA' => 'Barima-Waini', 'GY.CU' => 'Cuyuni-Mazaruni', 'GY.DE' => 'Demerara-Mahaica', 'GY.EB' => 'East Berbice-Corentyne', 'GY.ES' => 'Essequibo Islands-West Demerara', 'GY.MA' => 'Mahaica-Berbice', 'GY.PM' => 'Pomeroon-Supenaam', 'GY.PT' => 'Potaro-Siparuni', 'GY.UD' => 'Upper Demerara-Berbice', 'GY.UT' => 'Upper Takutu-Upper Essequibo'],
			'HN' => ['HN.AT' => 'Atlantida', 'HN.CH' => 'Choluteca', 'HN.CL' => 'Colon', 'HN.CM' => 'Comayagua', 'HN.CP' => 'Copan', 'HN.CR' => 'Cortes', 'HN.EP' => 'El Paraiso', 'HN.FM' => 'Francisco Morazan', 'HN.GD' => 'Gracias a Dios', 'HN.IN' => 'Intibuca', 'HN.IB' => 'Islas de la Bahia', 'HN.LP' => 'La Paz', 'HN.LE' => 'Lempira', 'HN.OC' => 'Ocotepeque', 'HN.OL' => 'Olancho', 'HN.SB' => 'Santa Barbara', 'HN.VA' => 'Valle', 'HN.YO' => 'Yoro'],
			'HR' => ['HR.07' => 'Bjelovarsko-bilogorska zupanija', 'HR.12' => 'Brodsko-posavska zupanija', 'HR.19' => 'Dubrovacko-neretvanska zupanija', 'HR.21' => 'Grad Zagreb', 'HR.18' => 'Istarska zupanija', 'HR.04' => 'Karlovacka zupanija', 'HR.06' => 'Koprivnicko-krizevacka zupanija', 'HR.02' => 'Krapinsko-zagorska zupanija', 'HR.09' => 'Licko-senjska zupanija', 'HR.20' => 'Medimurska zupanija', 'HR.14' => 'Osjecko-baranjska zupanija', 'HR.11' => 'Pozesko-slavonska zupanija', 'HR.08' => 'Primorsko-goranska zupanija', 'HR.15' => 'Sibensko-kninska zupanija', 'HR.03' => 'Sisacko-moslavacka zupanija', 'HR.17' => 'Splitsko-dalmatinska zupanija', 'HR.05' => 'Varazdinska zupanija', 'HR.10' => 'Viroviticko-podravska zupanija', 'HR.16' => 'Vukovarsko-srijemska zupanija', 'HR.13' => 'Zadarska zupanija', 'HR.01' => 'Zagrebacka zupanija'],
			'HT' => ['HT.AR' => 'Artibonite', 'HT.CE' => 'Centre', 'HT.GA' => 'Grande\'Anse', 'HT.NI' => 'Nippes', 'HT.ND' => 'Nord', 'HT.NE' => 'Nord-Est', 'HT.NO' => 'Nord-Ouest', 'HT.OU' => 'Ouest', 'HT.SD' => 'Sud', 'HT.SE' => 'Sud-Est'],
			'HU' => ['HU.BK' => 'Bacs-Kiskun', 'HU.BA' => 'Baranya', 'HU.BE' => 'Bekes', 'HU.BZ' => 'Borsod-Abauj-Zemplen', 'HU.BU' => 'Budapest', 'HU.CS' => 'Csongrad', 'HU.FE' => 'Fejer', 'HU.GS' => 'Gyor-Moson-Sopron', 'HU.HB' => 'Hajdu-Bihar', 'HU.HE' => 'Heves', 'HU.JN' => 'Jasz-Nagykun-Szolnok', 'HU.KE' => 'Komarom-Esztergom', 'HU.NO' => 'Nograd', 'HU.PE' => 'Pest', 'HU.SO' => 'Somogy', 'HU.SZ' => 'Szabolcs-Szatmar-Bereg', 'HU.TO' => 'Tolna', 'HU.VA' => 'Vas', 'HU.VE' => 'Veszprem', 'HU.ZA' => 'Zala'],
			'ID' => ['ID.AC' => 'Aceh', 'ID.BA' => 'Bali', 'ID.BT' => 'Banten', 'ID.BE' => 'Bengkulu', 'ID.GO' => 'Gorontalo', 'ID.JK' => 'Jakarta Raya', 'ID.JA' => 'Jambi', 'ID.JB' => 'Jawa Barat', 'ID.JT' => 'Jawa Tengah', 'ID.JI' => 'Jawa Timur', 'ID.KB' => 'Kalimantan Barat', 'ID.KS' => 'Kalimantan Selatan', 'ID.KT' => 'Kalimantan Tengah', 'ID.KI' => 'Kalimantan Timur', 'ID.KU' => 'Kalimantan Utara', 'ID.BB' => 'Kepulauan Bangka Belitung', 'ID.KR' => 'Kepulauan Riau', 'ID.LA' => 'Lampung', 'ID.ML' => 'Maluku', 'ID.MU' => 'Maluku Utara', 'ID.NB' => 'Nusa Tenggara Barat', 'ID.NT' => 'Nusa Tenggara Timur', 'ID.PP' => 'Papua', 'ID.PB' => 'Papua Barat', 'ID.PE' => 'Papua Pengunungan', 'ID.PS' => 'Papua Selatan', 'ID.PT' => 'Papua Tengah', 'ID.RI' => 'Riau', 'ID.SR' => 'Sulawesi Barat', 'ID.SN' => 'Sulawesi Selatan', 'ID.ST' => 'Sulawesi Tengah', 'ID.SG' => 'Sulawesi Tenggara', 'ID.SA' => 'Sulawesi Utara', 'ID.SB' => 'Sumatera Barat', 'ID.SS' => 'Sumatera Selatan', 'ID.SU' => 'Sumatera Utara', 'ID.YO' => 'Yogyakarta'],
			'IE' => ['IE.CW' => 'Carlow', 'IE.CN' => 'Cavan', 'IE.CE' => 'Clare', 'IE.CO' => 'Cork', 'IE.DL' => 'Donegal', 'IE.D' => 'Dublin', 'IE.G' => 'Galway', 'IE.KY' => 'Kerry', 'IE.KE' => 'Kildare', 'IE.KK' => 'Kilkenny', 'IE.LS' => 'Laois', 'IE.LM' => 'Leitrim', 'IE.LK' => 'Limerick', 'IE.LD' => 'Longford', 'IE.LH' => 'Louth', 'IE.MO' => 'Mayo', 'IE.MH' => 'Meath', 'IE.MN' => 'Monaghan', 'IE.OY' => 'Offaly', 'IE.RN' => 'Roscommon', 'IE.SO' => 'Sligo', 'IE.TA' => 'Tipperary', 'IE.WD' => 'Waterford', 'IE.WH' => 'Westmeath', 'IE.WX' => 'Wexford', 'IE.WW' => 'Wicklow'],
			'IL' => ['IL.D' => 'HaDarom', 'IL.M' => 'HaMerkaz', 'IL.Z' => 'HaTsafon', 'IL.HA' => 'Hefa', 'IL.TA' => 'Tel Aviv', 'IL.JM' => 'Yerushalayim'],
			'IN' => ['IN.AN' => 'Andaman and Nicobar Islands', 'IN.AP' => 'Andhra Pradesh', 'IN.AR' => 'Arunachal Pradesh', 'IN.AS' => 'Assam', 'IN.BR' => 'Bihar', 'IN.CH' => 'Chandigarh', 'IN.CT' => 'Chhattisgarh', 'IN.DN' => 'Dadra and Nagar Haveli', 'IN.DH' => 'Dadra and Nagar Haveli and Daman and Diu', 'IN.DL' => 'Delhi', 'IN.GA' => 'Goa', 'IN.GJ' => 'Gujarat', 'IN.HR' => 'Haryana', 'IN.HP' => 'Himachal Pradesh', 'IN.JK' => 'Jammu and Kashmir', 'IN.JH' => 'Jharkhand', 'IN.KA' => 'Karnataka', 'IN.KL' => 'Kerala', 'IN.LA' => 'Ladakh', 'IN.LD' => 'Lakshadweep', 'IN.MP' => 'Madhya Pradesh', 'IN.MH' => 'Maharashtra', 'IN.MN' => 'Manipur', 'IN.ML' => 'Meghalaya', 'IN.MZ' => 'Mizoram', 'IN.NL' => 'Nagaland', 'IN.OR' => 'Odisha', 'IN.PY' => 'Puducherry', 'IN.PB' => 'Punjab', 'IN.RJ' => 'Rajasthan', 'IN.SK' => 'Sikkim', 'IN.TN' => 'Tamil Nadu', 'IN.TG' => 'Telangana', 'IN.TR' => 'Tripura', 'IN.UP' => 'Uttar Pradesh', 'IN.UT' => 'Uttarakhand', 'IN.WB' => 'West Bengal'],
			'IQ' => ['IQ.AN' => 'Al Anbar', 'IQ.BA' => 'Al Basrah', 'IQ.MU' => 'Al Muthanna', 'IQ.QA' => 'Al Qadisiyah', 'IQ.NA' => 'An Najaf', 'IQ.AR' => 'Arbil', 'IQ.SU' => 'As Sulaymaniyah', 'IQ.BB' => 'Babil', 'IQ.BG' => 'Baghdad', 'IQ.DA' => 'Dahuk', 'IQ.DQ' => 'Dhi Qar', 'IQ.DI' => 'Diyala', 'IQ.KA' => 'Karbala\'', 'IQ.KI' => 'Kirkuk', 'IQ.MA' => 'Maysan', 'IQ.NI' => 'Ninawa', 'IQ.SD' => 'Salah ad Din', 'IQ.WA' => 'Wasit'],
			'IR' => ['IR.32' => 'Alborz', 'IR.03' => 'Ardabil', 'IR.02' => 'Azarbayjan-e Gharbi', 'IR.01' => 'Azarbayjan-e Sharqi', 'IR.06' => 'Bushehr', 'IR.08' => 'Chahar Mahal va Bakhtiari', 'IR.04' => 'Esfahan', 'IR.14' => 'Fars', 'IR.19' => 'Gilan', 'IR.27' => 'Golestan', 'IR.24' => 'Hamadan', 'IR.23' => 'Hormozgan', 'IR.05' => 'Ilam', 'IR.15' => 'Kerman', 'IR.17' => 'Kermanshah', 'IR.29' => 'Khorasan-e Jonubi', 'IR.30' => 'Khorasan-e Razavi', 'IR.31' => 'Khorasan-e Shomali', 'IR.10' => 'Khuzestan', 'IR.18' => 'Kohgiluyeh va Bowyer Ahmad', 'IR.16' => 'Kordestan', 'IR.20' => 'Lorestan', 'IR.22' => 'Markazi', 'IR.21' => 'Mazandaran', 'IR.28' => 'Qazvin', 'IR.26' => 'Qom', 'IR.12' => 'Semnan', 'IR.13' => 'Sistan va Baluchestan', 'IR.07' => 'Tehran', 'IR.25' => 'Yazd', 'IR.11' => 'Zanjan'],
			'IS' => ['IS.7' => 'Austurland', 'IS.1' => 'Hofudborgarsvaedi', 'IS.6' => 'Nordurland eystra', 'IS.5' => 'Nordurland vestra', 'IS.8' => 'Sudurland', 'IS.2' => 'Sudurnes', 'IS.4' => 'Vestfirdir', 'IS.3' => 'Vesturland'],
			'IT' => ['IT.65' => 'Abruzzo', 'IT.77' => 'Basilicata', 'IT.78' => 'Calabria', 'IT.72' => 'Campania', 'IT.45' => 'Emilia-Romagna', 'IT.36' => 'Friuli-Venezia Giulia', 'IT.62' => 'Lazio', 'IT.42' => 'Liguria', 'IT.25' => 'Lombardia', 'IT.57' => 'Marche', 'IT.67' => 'Molise', 'IT.21' => 'Piemonte', 'IT.75' => 'Puglia', 'IT.88' => 'Sardegna', 'IT.82' => 'Sicilia', 'IT.52' => 'Toscana', 'IT.32' => 'Trentino-Alto Adige', 'IT.55' => 'Umbria', 'IT.23' => 'Valle d\'Aosta', 'IT.34' => 'Veneto'],
			'JM' => ['JM.13' => 'Clarendon', 'JM.09' => 'Hanover', 'JM.01' => 'Kingston', 'JM.12' => 'Manchester', 'JM.04' => 'Portland', 'JM.02' => 'Saint Andrew', 'JM.06' => 'Saint Ann', 'JM.14' => 'Saint Catherine', 'JM.11' => 'Saint Elizabeth', 'JM.08' => 'Saint James', 'JM.05' => 'Saint Mary', 'JM.03' => 'Saint Thomas', 'JM.07' => 'Trelawny', 'JM.10' => 'Westmoreland'],
			'JO' => ['JO.AJ' => '\'Ajlun', 'JO.AQ' => 'Al \'Aqabah', 'JO.AM' => 'Al \'Asimah', 'JO.BA' => 'Al Balqa\'', 'JO.KA' => 'Al Karak', 'JO.MA' => 'Al Mafraq', 'JO.AT' => 'At Tafilah', 'JO.AZ' => 'Az Zarqa\'', 'JO.IR' => 'Irbid', 'JO.JA' => 'Jarash', 'JO.MN' => 'Ma\'an', 'JO.MD' => 'Madaba'],
			'JP' => ['JP.23' => 'Aichi', 'JP.05' => 'Akita', 'JP.02' => 'Aomori', 'JP.12' => 'Chiba', 'JP.38' => 'Ehime', 'JP.18' => 'Fukui', 'JP.40' => 'Fukuoka', 'JP.07' => 'Fukushima', 'JP.21' => 'Gifu', 'JP.10' => 'Gunma', 'JP.34' => 'Hiroshima', 'JP.01' => 'Hokkaido', 'JP.28' => 'Hyogo', 'JP.08' => 'Ibaraki', 'JP.17' => 'Ishikawa', 'JP.03' => 'Iwate', 'JP.37' => 'Kagawa', 'JP.46' => 'Kagoshima', 'JP.14' => 'Kanagawa', 'JP.39' => 'Kochi', 'JP.43' => 'Kumamoto', 'JP.26' => 'Kyoto', 'JP.24' => 'Mie', 'JP.04' => 'Miyagi', 'JP.45' => 'Miyazaki', 'JP.20' => 'Nagano', 'JP.42' => 'Nagasaki', 'JP.29' => 'Nara', 'JP.15' => 'Niigata', 'JP.44' => 'Oita', 'JP.33' => 'Okayama', 'JP.47' => 'Okinawa', 'JP.27' => 'Osaka', 'JP.41' => 'Saga', 'JP.11' => 'Saitama', 'JP.25' => 'Shiga', 'JP.32' => 'Shimane', 'JP.22' => 'Shizuoka', 'JP.09' => 'Tochigi', 'JP.36' => 'Tokushima', 'JP.13' => 'Tokyo', 'JP.31' => 'Tottori', 'JP.16' => 'Toyama', 'JP.30' => 'Wakayama', 'JP.06' => 'Yamagata', 'JP.35' => 'Yamaguchi', 'JP.19' => 'Yamanashi'],
			'KE' => ['KE.01' => 'Baringo', 'KE.02' => 'Bomet', 'KE.03' => 'Bungoma', 'KE.04' => 'Busia', 'KE.05' => 'Elgeyo/Marakwet', 'KE.06' => 'Embu', 'KE.07' => 'Garissa', 'KE.08' => 'Homa Bay', 'KE.09' => 'Isiolo', 'KE.10' => 'Kajiado', 'KE.11' => 'Kakamega', 'KE.12' => 'Kericho', 'KE.13' => 'Kiambu', 'KE.14' => 'Kilifi', 'KE.15' => 'Kirinyaga', 'KE.16' => 'Kisii', 'KE.17' => 'Kisumu', 'KE.18' => 'Kitui', 'KE.19' => 'Kwale', 'KE.20' => 'Laikipia', 'KE.21' => 'Lamu', 'KE.22' => 'Machakos', 'KE.23' => 'Makueni', 'KE.24' => 'Mandera', 'KE.25' => 'Marsabit', 'KE.26' => 'Meru', 'KE.27' => 'Migori', 'KE.28' => 'Mombasa', 'KE.29' => 'Murang\'a', 'KE.30' => 'Nairobi City', 'KE.31' => 'Nakuru', 'KE.32' => 'Nandi', 'KE.33' => 'Narok', 'KE.34' => 'Nyamira', 'KE.35' => 'Nyandarua', 'KE.36' => 'Nyeri', 'KE.37' => 'Samburu', 'KE.38' => 'Siaya', 'KE.39' => 'Taita/Taveta', 'KE.40' => 'Tana River', 'KE.41' => 'Tharaka-Nithi', 'KE.42' => 'Trans Nzoia', 'KE.43' => 'Turkana', 'KE.44' => 'Uasin Gishu', 'KE.45' => 'Vihiga', 'KE.46' => 'Wajir', 'KE.47' => 'West Pokot'],
			'KG' => ['KG.B' => 'Batken', 'KG.GB' => 'Bishkek Shaary', 'KG.C' => 'Chuy', 'KG.J' => 'Jalal-Abad', 'KG.N' => 'Naryn', 'KG.GO' => 'Osh Shaary', 'KG.T' => 'Talas', 'KG.Y' => 'Ysyk-Kol'],
			'KH' => ['KH.2' => 'Baat Dambang', 'KH.1' => 'Banteay Mean Choay', 'KH.23' => 'Kaeb', 'KH.3' => 'Kampong Chaam', 'KH.4' => 'Kampong Chhnang', 'KH.5' => 'Kampong Spueu', 'KH.6' => 'Kampong Thum', 'KH.7' => 'Kampot', 'KH.8' => 'Kandaal', 'KH.9' => 'Kaoh Kong', 'KH.10' => 'Kracheh', 'KH.11' => 'Mondol Kiri', 'KH.22' => 'Otdar Mean Chey', 'KH.24' => 'Pailin', 'KH.12' => 'Phnom Penh', 'KH.15' => 'Pousaat', 'KH.18' => 'Preah Sihanouk', 'KH.13' => 'Preah Vihear', 'KH.14' => 'Prey Veaeng', 'KH.16' => 'Rotanak Kiri', 'KH.17' => 'Siem Reab', 'KH.19' => 'Stueng Traeng', 'KH.20' => 'Svaay Rieng', 'KH.21' => 'Taakaev', 'KH.25' => 'Tbong Khmum'],
			'KI' => ['KI.G' => 'Gilbert Islands', 'KI.L' => 'Line Islands', 'KI.P' => 'Phoenix Islands'],
			'KM' => ['KM.A' => 'Anjouan', 'KM.G' => 'Grande Comore', 'KM.M' => 'Moheli'],
			'KN' => ['KN.01' => 'Christ Church Nichola Town', 'KN.02' => 'Saint Anne Sandy Point', 'KN.03' => 'Saint George Basseterre', 'KN.04' => 'Saint George Gingerland', 'KN.05' => 'Saint James Windward', 'KN.06' => 'Saint John Capisterre', 'KN.07' => 'Saint John Figtree', 'KN.08' => 'Saint Mary Cayon', 'KN.09' => 'Saint Paul Capisterre', 'KN.10' => 'Saint Paul Charlestown', 'KN.11' => 'Saint Peter Basseterre', 'KN.12' => 'Saint Thomas Lowland', 'KN.13' => 'Saint Thomas Middle Island', 'KN.15' => 'Trinity Palmetto Point'],
			'KP' => ['KP.04' => 'Chagang-do', 'KP.09' => 'Hamgyong-bukto', 'KP.08' => 'Hamgyong-namdo', 'KP.06' => 'Hwanghae-bukto', 'KP.05' => 'Hwanghae-namdo', 'KP.07' => 'Kangwon-do', 'KP.03' => 'P\'yongan-bukto', 'KP.02' => 'P\'yongan-namdo', 'KP.01' => 'P\'yongyang', 'KP.13' => 'Rason', 'KP.10' => 'Ryanggang-do'],
			'KR' => ['KR.26' => 'Busan-gwangyeoksi', 'KR.43' => 'Chungcheongbuk-do', 'KR.44' => 'Chungcheongnam-do', 'KR.27' => 'Daegu-gwangyeoksi', 'KR.30' => 'Daejeon-gwangyeoksi', 'KR.42' => 'Gangwon-do', 'KR.29' => 'Gwangju-gwangyeoksi', 'KR.41' => 'Gyeonggi-do', 'KR.47' => 'Gyeongsangbuk-do', 'KR.48' => 'Gyeongsangnam-do', 'KR.28' => 'Incheon-gwangyeoksi', 'KR.49' => 'Jeju-teukbyeoljachido', 'KR.45' => 'Jeollabuk-do', 'KR.46' => 'Jeollanam-do', 'KR.11' => 'Seoul-teukbyeolsi', 'KR.31' => 'Ulsan-gwangyeoksi'],
			'KW' => ['KW.KU' => 'Al \'Asimah', 'KW.AH' => 'Al Ahmadi', 'KW.FA' => 'Al Farwaniyah', 'KW.JA' => 'Al Jahra\'', 'KW.HA' => 'Hawalli', 'KW.MU' => 'Mubarak al Kabir'],
			'KZ' => ['KZ.10' => 'Abay oblysy', 'KZ.75' => 'Almaty', 'KZ.19' => 'Almaty oblysy', 'KZ.11' => 'Aqmola oblysy', 'KZ.15' => 'Aqtobe oblysy', 'KZ.71' => 'Astana', 'KZ.23' => 'Atyrau oblysy', 'KZ.27' => 'Batys Qazaqstan oblysy', 'KZ.47' => 'Mangghystau oblysy', 'KZ.55' => 'Pavlodar oblysy', 'KZ.35' => 'Qaraghandy oblysy', 'KZ.39' => 'Qostanay oblysy', 'KZ.43' => 'Qyzylorda oblysy', 'KZ.63' => 'Shyghys Qazaqstan oblysy', 'KZ.79' => 'Shymkent', 'KZ.59' => 'Soltustik Qazaqstan oblysy', 'KZ.61' => 'Turkistan oblysy', 'KZ.62' => 'Ulytau oblysy', 'KZ.31' => 'Zhambyl oblysy', 'KZ.33' => 'Zhetisu oblysy'],
			'LA' => ['LA.AT' => 'Attapu', 'LA.BK' => 'Bokeo', 'LA.BL' => 'Bolikhamxai', 'LA.CH' => 'Champasak', 'LA.HO' => 'Houaphan', 'LA.KH' => 'Khammouan', 'LA.LM' => 'Louang Namtha', 'LA.LP' => 'Louangphabang', 'LA.OU' => 'Oudomxai', 'LA.PH' => 'Phongsali', 'LA.SL' => 'Salavan', 'LA.SV' => 'Savannakhet', 'LA.VI' => 'Viangchan', 'LA.XA' => 'Xaignabouli', 'LA.XS' => 'Xaisomboun', 'LA.XE' => 'Xekong', 'LA.XI' => 'Xiangkhouang'],
			'LB' => ['LB.AK' => 'Aakkar', 'LB.BH' => 'Baalbek-Hermel', 'LB.BI' => 'Beqaa', 'LB.BA' => 'Beyrouth', 'LB.AS' => 'Liban-Nord', 'LB.JA' => 'Liban-Sud', 'LB.JL' => 'Mont-Liban', 'LB.NA' => 'Nabatiye'],
			'LC' => ['LC.01' => 'Anse la Raye', 'LC.12' => 'Canaries', 'LC.02' => 'Castries', 'LC.03' => 'Choiseul', 'LC.05' => 'Dennery', 'LC.06' => 'Gros Islet', 'LC.07' => 'Laborie', 'LC.08' => 'Micoud', 'LC.10' => 'Soufriere', 'LC.11' => 'Vieux Fort'],
			'LI' => ['LI.01' => 'Balzers', 'LI.02' => 'Eschen', 'LI.03' => 'Gamprin', 'LI.04' => 'Mauren', 'LI.05' => 'Planken', 'LI.06' => 'Ruggell', 'LI.07' => 'Schaan', 'LI.08' => 'Schellenberg', 'LI.09' => 'Triesen', 'LI.10' => 'Triesenberg', 'LI.11' => 'Vaduz'],
			'LK' => ['LK.2' => 'Central Province', 'LK.5' => 'Eastern Province', 'LK.7' => 'North Central Province', 'LK.6' => 'North Western Province', 'LK.4' => 'Northern Province', 'LK.9' => 'Sabaragamuwa Province', 'LK.3' => 'Southern Province', 'LK.8' => 'Uva Province', 'LK.1' => 'Western Province'],
			'LR' => ['LR.BM' => 'Bomi', 'LR.BG' => 'Bong', 'LR.GP' => 'Gbarpolu', 'LR.GB' => 'Grand Bassa', 'LR.CM' => 'Grand Cape Mount', 'LR.GG' => 'Grand Gedeh', 'LR.GK' => 'Grand Kru', 'LR.LO' => 'Lofa', 'LR.MG' => 'Margibi', 'LR.MY' => 'Maryland', 'LR.MO' => 'Montserrado', 'LR.NI' => 'Nimba', 'LR.RI' => 'River Cess', 'LR.RG' => 'River Gee', 'LR.SI' => 'Sinoe'],
			'LS' => ['LS.D' => 'Berea', 'LS.B' => 'Botha-Bothe', 'LS.C' => 'Leribe', 'LS.E' => 'Mafeteng', 'LS.A' => 'Maseru', 'LS.F' => 'Mohale\'s Hoek', 'LS.J' => 'Mokhotlong', 'LS.H' => 'Qacha\'s Nek', 'LS.G' => 'Quthing', 'LS.K' => 'Thaba-Tseka'],
			'LT' => ['LT.AL' => 'Alytaus apskritis', 'LT.KU' => 'Kauno apskritis', 'LT.KL' => 'Klaipedos apskritis', 'LT.MR' => 'Marijampoles apskritis', 'LT.PN' => 'Panevezio apskritis', 'LT.SA' => 'Siauliu apskritis', 'LT.TA' => 'Taurages apskritis', 'LT.TE' => 'Telsiu apskritis', 'LT.UT' => 'Utenos apskritis', 'LT.VL' => 'Vilniaus apskritis'],
			'LU' => ['LU.CA' => 'Capellen', 'LU.CL' => 'Clervaux', 'LU.DI' => 'Diekirch', 'LU.EC' => 'Echternach', 'LU.ES' => 'Esch-sur-Alzette', 'LU.GR' => 'Grevenmacher', 'LU.LU' => 'Luxembourg', 'LU.ME' => 'Mersch', 'LU.RD' => 'Redange', 'LU.RM' => 'Remich', 'LU.VD' => 'Vianden', 'LU.WI' => 'Wiltz'],
			'LV' => ['LV.011' => 'Adazu novads', 'LV.002' => 'Aizkraukles novads', 'LV.007' => 'Aluksnes novads', 'LV.111' => 'Augsdaugavas novads', 'LV.015' => 'Balvu novads', 'LV.016' => 'Bauskas novads', 'LV.022' => 'Cesu novads', 'LV.DGV' => 'Daugavpils', 'LV.112' => 'Dienvidkurzemes novads', 'LV.026' => 'Dobeles novads', 'LV.033' => 'Gulbenes novads', 'LV.042' => 'Jekabpils novads', 'LV.JEL' => 'Jelgava', 'LV.041' => 'Jelgavas novads', 'LV.JUR' => 'Jurmala', 'LV.052' => 'Kekavas novads', 'LV.047' => 'Kraslavas novads', 'LV.050' => 'Kuldigas novads', 'LV.LPX' => 'Liepaja', 'LV.054' => 'Limbazu novads', 'LV.056' => 'Livanu novads', 'LV.058' => 'Ludzas novads', 'LV.059' => 'Madonas novads', 'LV.062' => 'Marupes novads', 'LV.067' => 'Ogres novads', 'LV.068' => 'Olaines novads', 'LV.073' => 'Preilu novads', 'LV.REZ' => 'Rezekne', 'LV.077' => 'Rezeknes novads', 'LV.RIX' => 'Riga', 'LV.080' => 'Ropazu novads', 'LV.087' => 'Salaspils novads', 'LV.088' => 'Saldus novads', 'LV.089' => 'Saulkrastu novads', 'LV.091' => 'Siguldas novads', 'LV.094' => 'Smiltenes novads', 'LV.097' => 'Talsu novads', 'LV.099' => 'Tukuma novads', 'LV.101' => 'Valkas novads', 'LV.113' => 'Valmieras novads', 'LV.102' => 'Varaklanu novads', 'LV.VEN' => 'Ventspils', 'LV.106' => 'Ventspils novads'],
			'LY' => ['LY.BU' => 'Al Butnan', 'LY.JA' => 'Al Jabal al Akhdar', 'LY.JG' => 'Al Jabal al Gharbi', 'LY.JI' => 'Al Jafarah', 'LY.JU' => 'Al Jufrah', 'LY.KF' => 'Al Kufrah', 'LY.MJ' => 'Al Marj', 'LY.MB' => 'Al Marqab', 'LY.WA' => 'Al Wahat', 'LY.NQ' => 'An Nuqat al Khams', 'LY.ZA' => 'Az Zawiyah', 'LY.BA' => 'Banghazi', 'LY.DR' => 'Darnah', 'LY.GT' => 'Ghat', 'LY.MI' => 'Misratah', 'LY.MQ' => 'Murzuq', 'LY.NL' => 'Nalut', 'LY.SB' => 'Sabha', 'LY.SR' => 'Surt', 'LY.TB' => 'Tarabulus', 'LY.WD' => 'Wadi al Hayat', 'LY.WS' => 'Wadi ash Shati\''],
			'MA' => ['MA.05' => 'Beni-Mellal-Khenifra', 'MA.06' => 'Casablanca-Settat', 'MA.12' => 'Dakhla-Oued Ed-Dahab (EH)', 'MA.08' => 'Draa-Tafilalet', 'MA.03' => 'Fes- Meknes', 'MA.10' => 'Guelmim-Oued Noun (EH-partial)', 'MA.02' => 'L\'Oriental', 'MA.11' => 'Laayoune-Sakia El Hamra (EH-partial)', 'MA.07' => 'Marrakech-Safi', 'MA.04' => 'Rabat-Sale-Kenitra', 'MA.09' => 'Souss-Massa', 'MA.01' => 'Tanger-Tetouan-Al Hoceima'],
			'MC' => ['MC.FO' => 'Fontvieille', 'MC.JE' => 'Jardin Exotique', 'MC.CL' => 'La Colle', 'MC.CO' => 'La Condamine', 'MC.GA' => 'La Gare', 'MC.SO' => 'La Source', 'MC.LA' => 'Larvotto', 'MC.MA' => 'Malbousquet', 'MC.MO' => 'Monaco-Ville', 'MC.MG' => 'Moneghetti', 'MC.MC' => 'Monte-Carlo', 'MC.MU' => 'Moulins', 'MC.PH' => 'Port-Hercule', 'MC.SR' => 'Saint-Roman', 'MC.SD' => 'Sainte-Devote', 'MC.SP' => 'Spelugues', 'MC.VR' => 'Vallon de la Rousse'],
			'MD' => ['MD.AN' => 'Anenii Noi', 'MD.BA' => 'Balti', 'MD.BS' => 'Basarabeasca', 'MD.BD' => 'Bender', 'MD.BR' => 'Briceni', 'MD.CA' => 'Cahul', 'MD.CL' => 'Calarasi', 'MD.CT' => 'Cantemir', 'MD.CS' => 'Causeni', 'MD.CU' => 'Chisinau', 'MD.CM' => 'Cimislia', 'MD.CR' => 'Criuleni', 'MD.DO' => 'Donduseni', 'MD.DR' => 'Drochia', 'MD.DU' => 'Dubasari', 'MD.ED' => 'Edinet', 'MD.FA' => 'Falesti', 'MD.FL' => 'Floresti', 'MD.GA' => 'Gagauzia, Unitatea teritoriala autonoma', 'MD.GL' => 'Glodeni', 'MD.HI' => 'Hincesti', 'MD.IA' => 'Ialoveni', 'MD.LE' => 'Leova', 'MD.NI' => 'Nisporeni', 'MD.OC' => 'Ocnita', 'MD.OR' => 'Orhei', 'MD.RE' => 'Rezina', 'MD.RI' => 'Riscani', 'MD.SI' => 'Singerei', 'MD.SD' => 'Soldanesti', 'MD.SO' => 'Soroca', 'MD.SV' => 'Stefan Voda', 'MD.SN' => 'Stinga Nistrului, unitatea teritoriala din', 'MD.ST' => 'Straseni', 'MD.TA' => 'Taraclia', 'MD.TE' => 'Telenesti', 'MD.UN' => 'Ungheni'],
			'ME' => ['ME.01' => 'Andrijevica', 'ME.02' => 'Bar', 'ME.03' => 'Berane', 'ME.04' => 'Bijelo Polje', 'ME.05' => 'Budva', 'ME.06' => 'Cetinje', 'ME.07' => 'Danilovgrad', 'ME.22' => 'Gusinje', 'ME.08' => 'Herceg-Novi', 'ME.09' => 'Kolasin', 'ME.10' => 'Kotor', 'ME.11' => 'Mojkovac', 'ME.12' => 'Niksic', 'ME.23' => 'Petnjica', 'ME.13' => 'Plav', 'ME.14' => 'Pljevlja', 'ME.15' => 'Pluzine', 'ME.16' => 'Podgorica', 'ME.17' => 'Rozaje', 'ME.18' => 'Savnik', 'ME.19' => 'Tivat', 'ME.24' => 'Tuzi', 'ME.20' => 'Ulcinj', 'ME.21' => 'Zabljak'],
			'MG' => ['MG.T' => 'Antananarivo', 'MG.D' => 'Antsiranana', 'MG.F' => 'Fianarantsoa', 'MG.M' => 'Mahajanga', 'MG.A' => 'Toamasina', 'MG.U' => 'Toliara'],
			'MH' => ['MH.ALL' => 'Ailinglaplap', 'MH.ALK' => 'Ailuk', 'MH.ARN' => 'Arno', 'MH.AUR' => 'Aur', 'MH.KIL' => 'Bikini & Kili', 'MH.EBO' => 'Ebon', 'MH.ENI' => 'Enewetak & Ujelang', 'MH.JAB' => 'Jabat', 'MH.JAL' => 'Jaluit', 'MH.KWA' => 'Kwajalein', 'MH.LAE' => 'Lae', 'MH.LIB' => 'Lib', 'MH.LIK' => 'Likiep', 'MH.MAJ' => 'Majuro', 'MH.MAL' => 'Maloelap', 'MH.MEJ' => 'Mejit', 'MH.MIL' => 'Mili', 'MH.NMK' => 'Namdrik', 'MH.NMU' => 'Namu', 'MH.RON' => 'Rongelap', 'MH.UJA' => 'Ujae', 'MH.UTI' => 'Utrik', 'MH.WTH' => 'Wotho', 'MH.WTJ' => 'Wotje'],
			'MK' => ['MK.801' => 'Aerodrom', 'MK.802' => 'Aracinovo', 'MK.201' => 'Berovo', 'MK.501' => 'Bitola', 'MK.401' => 'Bogdanci', 'MK.601' => 'Bogovinje', 'MK.402' => 'Bosilovo', 'MK.602' => 'Brvenica', 'MK.803' => 'Butel', 'MK.815' => 'Cair', 'MK.109' => 'Caska', 'MK.814' => 'Centar', 'MK.313' => 'Centar Zupa', 'MK.210' => 'Cesinovo-Oblesevo', 'MK.816' => 'Cucer Sandevo', 'MK.303' => 'Debar', 'MK.304' => 'Debarca', 'MK.203' => 'Delcevo', 'MK.502' => 'Demir Hisar', 'MK.103' => 'Demir Kapija', 'MK.406' => 'Dojran', 'MK.503' => 'Dolneni', 'MK.804' => 'Gazi Baba', 'MK.405' => 'Gevgelija', 'MK.805' => 'Gjorce Petrov', 'MK.604' => 'Gostivar', 'MK.102' => 'Gradsko', 'MK.807' => 'Ilinden', 'MK.606' => 'Jegunovce', 'MK.205' => 'Karbinci', 'MK.808' => 'Karpos', 'MK.104' => 'Kavadarci', 'MK.307' => 'Kicevo', 'MK.809' => 'Kisela Voda', 'MK.206' => 'Kocani', 'MK.407' => 'Konce', 'MK.701' => 'Kratovo', 'MK.702' => 'Kriva Palanka', 'MK.504' => 'Krivogastani', 'MK.505' => 'Krusevo', 'MK.703' => 'Kumanovo', 'MK.704' => 'Lipkovo', 'MK.105' => 'Lozovo', 'MK.207' => 'Makedonska Kamenica', 'MK.308' => 'Makedonski Brod', 'MK.607' => 'Mavrovo i Rostusa', 'MK.506' => 'Mogila', 'MK.106' => 'Negotino', 'MK.507' => 'Novaci', 'MK.408' => 'Novo Selo', 'MK.310' => 'Ohrid', 'MK.208' => 'Pehcevo', 'MK.810' => 'Petrovec', 'MK.311' => 'Plasnica', 'MK.508' => 'Prilep', 'MK.209' => 'Probistip', 'MK.409' => 'Radovis', 'MK.705' => 'Rankovce', 'MK.509' => 'Resen', 'MK.107' => 'Rosoman', 'MK.811' => 'Saraj', 'MK.812' => 'Sopiste', 'MK.706' => 'Staro Nagoricane', 'MK.211' => 'Stip', 'MK.312' => 'Struga', 'MK.410' => 'Strumica', 'MK.813' => 'Studenicani', 'MK.817' => 'Suto Orizari', 'MK.108' => 'Sveti Nikole', 'MK.608' => 'Tearce', 'MK.609' => 'Tetovo', 'MK.403' => 'Valandovo', 'MK.404' => 'Vasilevo', 'MK.101' => 'Veles', 'MK.301' => 'Vevcani', 'MK.202' => 'Vinica', 'MK.603' => 'Vrapciste', 'MK.806' => 'Zelenikovo', 'MK.605' => 'Zelino', 'MK.204' => 'Zrnovci'],
			'ML' => ['ML.BKO' => 'Bamako', 'ML.7' => 'Gao', 'ML.1' => 'Kayes', 'ML.8' => 'Kidal', 'ML.2' => 'Koulikoro', 'ML.9' => 'Menaka', 'ML.5' => 'Mopti', 'ML.4' => 'Segou', 'ML.3' => 'Sikasso', 'ML.10' => 'Taoudenit', 'ML.6' => 'Tombouctou'],
			'MM' => ['MM.07' => 'Ayeyarwady', 'MM.02' => 'Bago', 'MM.14' => 'Chin', 'MM.11' => 'Kachin', 'MM.12' => 'Kayah', 'MM.13' => 'Kayin', 'MM.03' => 'Magway', 'MM.04' => 'Mandalay', 'MM.15' => 'Mon', 'MM.18' => 'Nay Pyi Taw', 'MM.16' => 'Rakhine', 'MM.01' => 'Sagaing', 'MM.17' => 'Shan', 'MM.05' => 'Tanintharyi', 'MM.06' => 'Yangon'],
			'MN' => ['MN.073' => 'Arhangay', 'MN.071' => 'Bayan-Olgiy', 'MN.069' => 'Bayanhongor', 'MN.067' => 'Bulgan', 'MN.037' => 'Darhan uul', 'MN.061' => 'Dornod', 'MN.063' => 'Dornogovi', 'MN.059' => 'Dundgovi', 'MN.057' => 'Dzavhan', 'MN.065' => 'Govi-Altay', 'MN.064' => 'Govi-Sumber', 'MN.039' => 'Hentiy', 'MN.043' => 'Hovd', 'MN.041' => 'Hovsgol', 'MN.053' => 'Omnogovi', 'MN.035' => 'Orhon', 'MN.055' => 'Ovorhangay', 'MN.049' => 'Selenge', 'MN.051' => 'Suhbaatar', 'MN.047' => 'Tov', 'MN.1' => 'Ulaanbaatar', 'MN.046' => 'Uvs'],
			'MR' => ['MR.07' => 'Adrar', 'MR.03' => 'Assaba', 'MR.05' => 'Brakna', 'MR.08' => 'Dakhlet Nouadhibou', 'MR.04' => 'Gorgol', 'MR.10' => 'Guidimaka', 'MR.01' => 'Hodh ech Chargui', 'MR.02' => 'Hodh el Gharbi', 'MR.12' => 'Inchiri', 'MR.13' => 'Nouakchott Ouest', 'MR.15' => 'Nouakchott Sud', 'MR.09' => 'Tagant', 'MR.11' => 'Tiris Zemmour', 'MR.06' => 'Trarza'],
			'MT' => ['MT.01' => 'Attard', 'MT.02' => 'Balzan', 'MT.03' => 'Birgu', 'MT.04' => 'Birkirkara', 'MT.05' => 'Birzebbuga', 'MT.06' => 'Bormla', 'MT.07' => 'Dingli', 'MT.08' => 'Fgura', 'MT.09' => 'Floriana', 'MT.10' => 'Fontana', 'MT.13' => 'Ghajnsielem', 'MT.14' => 'Gharb', 'MT.15' => 'Gharghur', 'MT.16' => 'Ghasri', 'MT.17' => 'Ghaxaq', 'MT.11' => 'Gudja', 'MT.12' => 'Gzira', 'MT.18' => 'Hamrun', 'MT.19' => 'Iklin', 'MT.20' => 'Isla', 'MT.21' => 'Kalkara', 'MT.22' => 'Kercem', 'MT.23' => 'Kirkop', 'MT.24' => 'Lija', 'MT.25' => 'Luqa', 'MT.26' => 'Marsa', 'MT.27' => 'Marsaskala', 'MT.28' => 'Marsaxlokk', 'MT.29' => 'Mdina', 'MT.30' => 'Mellieha', 'MT.31' => 'Mgarr', 'MT.32' => 'Mosta', 'MT.33' => 'Mqabba', 'MT.34' => 'Msida', 'MT.35' => 'Mtarfa', 'MT.36' => 'Munxar', 'MT.37' => 'Nadur', 'MT.38' => 'Naxxar', 'MT.39' => 'Paola', 'MT.40' => 'Pembroke', 'MT.41' => 'Pieta', 'MT.42' => 'Qala', 'MT.43' => 'Qormi', 'MT.44' => 'Qrendi', 'MT.45' => 'Rabat Gozo', 'MT.46' => 'Rabat Malta', 'MT.47' => 'Safi', 'MT.49' => 'Saint John', 'MT.48' => 'Saint Julian\'s', 'MT.50' => 'Saint Lawrence', 'MT.53' => 'Saint Lucia\'s', 'MT.51' => 'Saint Paul\'s Bay', 'MT.52' => 'Sannat', 'MT.54' => 'Santa Venera', 'MT.55' => 'Siggiewi', 'MT.56' => 'Sliema', 'MT.57' => 'Swieqi', 'MT.58' => 'Ta\' Xbiex', 'MT.59' => 'Tarxien', 'MT.60' => 'Valletta', 'MT.61' => 'Xaghra', 'MT.62' => 'Xewkija', 'MT.63' => 'Xghajra', 'MT.64' => 'Zabbar', 'MT.65' => 'Zebbug Gozo', 'MT.66' => 'Zebbug Malta', 'MT.67' => 'Zejtun', 'MT.68' => 'Zurrieq'],
			'MU' => ['MU.AG' => 'Agalega Islands', 'MU.BL' => 'Black River', 'MU.CC' => 'Cargados Carajos Shoals', 'MU.FL' => 'Flacq', 'MU.GP' => 'Grand Port', 'MU.MO' => 'Moka', 'MU.PA' => 'Pamplemousses', 'MU.PW' => 'Plaines Wilhems', 'MU.PL' => 'Port Louis', 'MU.RR' => 'Riviere du Rempart', 'MU.RO' => 'Rodrigues Islands', 'MU.SA' => 'Savanne'],
			'MV' => ['MV.01' => 'Addu City', 'MV.03' => 'Faadhippolhu', 'MV.04' => 'Felidhu Atoll', 'MV.29' => 'Fuvammulah', 'MV.05' => 'Hahdhunmathi', 'MV.08' => 'Kolhumadulu', 'MV.MLE' => 'Male', 'MV.12' => 'Mulaku Atoll', 'MV.02' => 'North Ari Atoll', 'MV.27' => 'North Huvadhu Atoll', 'MV.13' => 'North Maalhosmadulu', 'MV.24' => 'North Miladhunmadulu', 'MV.14' => 'North Nilandhe Atoll', 'MV.07' => 'North Thiladhunmathi', 'MV.00' => 'South Ari Atoll', 'MV.28' => 'South Huvadhu Atoll', 'MV.20' => 'South Maalhosmadulu', 'MV.25' => 'South Miladhunmadulu', 'MV.17' => 'South Nilandhe Atoll', 'MV.23' => 'South Thiladhunmathi'],
			'MW' => ['MW.BA' => 'Balaka', 'MW.BL' => 'Blantyre', 'MW.CK' => 'Chikwawa', 'MW.CR' => 'Chiradzulu', 'MW.CT' => 'Chitipa', 'MW.DE' => 'Dedza', 'MW.DO' => 'Dowa', 'MW.KR' => 'Karonga', 'MW.KS' => 'Kasungu', 'MW.LK' => 'Likoma', 'MW.LI' => 'Lilongwe', 'MW.MH' => 'Machinga', 'MW.MG' => 'Mangochi', 'MW.MC' => 'Mchinji', 'MW.MU' => 'Mulanje', 'MW.MW' => 'Mwanza', 'MW.MZ' => 'Mzimba', 'MW.NE' => 'Neno', 'MW.NB' => 'Nkhata Bay', 'MW.NK' => 'Nkhotakota', 'MW.NS' => 'Nsanje', 'MW.NU' => 'Ntcheu', 'MW.NI' => 'Ntchisi', 'MW.PH' => 'Phalombe', 'MW.RU' => 'Rumphi', 'MW.SA' => 'Salima', 'MW.TH' => 'Thyolo', 'MW.ZO' => 'Zomba'],
			'MX' => ['MX.AGU' => 'Aguascalientes', 'MX.BCN' => 'Baja California', 'MX.BCS' => 'Baja California Sur', 'MX.CAM' => 'Campeche', 'MX.CHP' => 'Chiapas', 'MX.CHH' => 'Chihuahua', 'MX.CMX' => 'Ciudad de Mexico', 'MX.COA' => 'Coahuila de Zaragoza', 'MX.COL' => 'Colima', 'MX.DUR' => 'Durango', 'MX.GUA' => 'Guanajuato', 'MX.GRO' => 'Guerrero', 'MX.HID' => 'Hidalgo', 'MX.JAL' => 'Jalisco', 'MX.MEX' => 'Mexico', 'MX.MIC' => 'Michoacan de Ocampo', 'MX.MOR' => 'Morelos', 'MX.NAY' => 'Nayarit', 'MX.NLE' => 'Nuevo Leon', 'MX.OAX' => 'Oaxaca', 'MX.PUE' => 'Puebla', 'MX.QUE' => 'Queretaro', 'MX.ROO' => 'Quintana Roo', 'MX.SLP' => 'San Luis Potosi', 'MX.SIN' => 'Sinaloa', 'MX.SON' => 'Sonora', 'MX.TAB' => 'Tabasco', 'MX.TAM' => 'Tamaulipas', 'MX.TLA' => 'Tlaxcala', 'MX.VER' => 'Veracruz de Ignacio de la Llave', 'MX.YUC' => 'Yucatan', 'MX.ZAC' => 'Zacatecas'],
			'MY' => ['MY.01' => 'Johor', 'MY.02' => 'Kedah', 'MY.03' => 'Kelantan', 'MY.04' => 'Melaka', 'MY.05' => 'Negeri Sembilan', 'MY.06' => 'Pahang', 'MY.08' => 'Perak', 'MY.09' => 'Perlis', 'MY.07' => 'Pulau Pinang', 'MY.12' => 'Sabah', 'MY.13' => 'Sarawak', 'MY.10' => 'Selangor', 'MY.11' => 'Terengganu', 'MY.14' => 'Wilayah Persekutuan Kuala Lumpur', 'MY.15' => 'Wilayah Persekutuan Labuan', 'MY.16' => 'Wilayah Persekutuan Putrajaya'],
			'MZ' => ['MZ.P' => 'Cabo Delgado', 'MZ.G' => 'Gaza', 'MZ.I' => 'Inhambane', 'MZ.B' => 'Manica', 'MZ.L' => 'Maputo', 'MZ.N' => 'Nampula', 'MZ.A' => 'Niassa', 'MZ.S' => 'Sofala', 'MZ.T' => 'Tete', 'MZ.Q' => 'Zambezia'],
			'NA' => ['NA.ER' => 'Erongo', 'NA.HA' => 'Hardap', 'NA.KA' => 'Karas', 'NA.KE' => 'Kavango East', 'NA.KW' => 'Kavango West', 'NA.KH' => 'Khomas', 'NA.KU' => 'Kunene', 'NA.OW' => 'Ohangwena', 'NA.OH' => 'Omaheke', 'NA.OS' => 'Omusati', 'NA.ON' => 'Oshana', 'NA.OT' => 'Oshikoto', 'NA.OD' => 'Otjozondjupa', 'NA.CA' => 'Zambezi'],
			'NE' => ['NE.1' => 'Agadez', 'NE.2' => 'Diffa', 'NE.3' => 'Dosso', 'NE.4' => 'Maradi', 'NE.8' => 'Niamey', 'NE.5' => 'Tahoua', 'NE.6' => 'Tillaberi', 'NE.7' => 'Zinder'],
			'NG' => ['NG.AB' => 'Abia', 'NG.FC' => 'Abuja Federal Capital Territory', 'NG.AD' => 'Adamawa', 'NG.AK' => 'Akwa Ibom', 'NG.AN' => 'Anambra', 'NG.BA' => 'Bauchi', 'NG.BY' => 'Bayelsa', 'NG.BE' => 'Benue', 'NG.BO' => 'Borno', 'NG.CR' => 'Cross River', 'NG.DE' => 'Delta', 'NG.EB' => 'Ebonyi', 'NG.ED' => 'Edo', 'NG.EK' => 'Ekiti', 'NG.EN' => 'Enugu', 'NG.GO' => 'Gombe', 'NG.IM' => 'Imo', 'NG.JI' => 'Jigawa', 'NG.KD' => 'Kaduna', 'NG.KN' => 'Kano', 'NG.KT' => 'Katsina', 'NG.KE' => 'Kebbi', 'NG.KO' => 'Kogi', 'NG.KW' => 'Kwara', 'NG.LA' => 'Lagos', 'NG.NA' => 'Nasarawa', 'NG.NI' => 'Niger', 'NG.OG' => 'Ogun', 'NG.ON' => 'Ondo', 'NG.OS' => 'Osun', 'NG.OY' => 'Oyo', 'NG.PL' => 'Plateau', 'NG.RI' => 'Rivers', 'NG.SO' => 'Sokoto', 'NG.TA' => 'Taraba', 'NG.YO' => 'Yobe', 'NG.ZA' => 'Zamfara'],
			'NI' => ['NI.BO' => 'Boaco', 'NI.CA' => 'Carazo', 'NI.CI' => 'Chinandega', 'NI.CO' => 'Chontales', 'NI.AN' => 'Costa Caribe Norte', 'NI.AS' => 'Costa Caribe Sur', 'NI.ES' => 'Esteli', 'NI.GR' => 'Granada', 'NI.JI' => 'Jinotega', 'NI.LE' => 'Leon', 'NI.MD' => 'Madriz', 'NI.MN' => 'Managua', 'NI.MS' => 'Masaya', 'NI.MT' => 'Matagalpa', 'NI.NS' => 'Nueva Segovia', 'NI.SJ' => 'Rio San Juan', 'NI.RI' => 'Rivas'],
			'NL' => ['NL.DR' => 'Drenthe', 'NL.FL' => 'Flevoland', 'NL.FR' => 'Fryslan', 'NL.GE' => 'Gelderland', 'NL.GR' => 'Groningen', 'NL.LI' => 'Limburg', 'NL.NB' => 'Noord-Brabant', 'NL.NH' => 'Noord-Holland', 'NL.OV' => 'Overijssel', 'NL.UT' => 'Utrecht', 'NL.ZE' => 'Zeeland', 'NL.ZH' => 'Zuid-Holland'],
			'NO' => ['NO.42' => 'Agder', 'NO.34' => 'Innlandet', 'NO.22' => 'Jan Mayen (Arctic Region)', 'NO.15' => 'More og Romsdal', 'NO.18' => 'Nordland', 'NO.03' => 'Oslo', 'NO.11' => 'Rogaland', 'NO.21' => 'Svalbard (Arctic Region)', 'NO.50' => 'Troendelag', 'NO.54' => 'Troms og Finnmark', 'NO.50' => 'Trondelag', 'NO.38' => 'Vestfold og Telemark', 'NO.46' => 'Vestland', 'NO.30' => 'Viken'],
			'NP' => ['NP.BA' => 'Bagmati', 'NP.BH' => 'Bheri', 'NP.DH' => 'Dhawalagiri', 'NP.GA' => 'Gandaki', 'NP.JA' => 'Janakpur', 'NP.KA' => 'Karnali', 'NP.KO' => 'Kosi', 'NP.LU' => 'Lumbini', 'NP.MA' => 'Mahakali', 'NP.ME' => 'Mechi', 'NP.NA' => 'Narayani', 'NP.RA' => 'Rapti', 'NP.SA' => 'Sagarmatha', 'NP.SE' => 'Seti'],
			'NR' => ['NR.01' => 'Aiwo', 'NR.02' => 'Anabar', 'NR.03' => 'Anetan', 'NR.04' => 'Anibare', 'NR.05' => 'Baitsi', 'NR.06' => 'Boe', 'NR.07' => 'Buada', 'NR.08' => 'Denigomodu', 'NR.09' => 'Ewa', 'NR.10' => 'Ijuw', 'NR.11' => 'Meneng', 'NR.12' => 'Nibok', 'NR.13' => 'Uaboe', 'NR.14' => 'Yaren'],
			'NZ' => ['NZ.AUK' => 'Auckland', 'NZ.BOP' => 'Bay of Plenty', 'NZ.CAN' => 'Canterbury', 'NZ.CIT' => 'Chatham Islands Territory', 'NZ.GIS' => 'Gisborne', 'NZ.HKB' => 'Hawke\'s Bay', 'NZ.MWT' => 'Manawatu-Wanganui', 'NZ.MBH' => 'Marlborough', 'NZ.NSN' => 'Nelson', 'NZ.NTL' => 'Northland', 'NZ.OTA' => 'Otago', 'NZ.STL' => 'Southland', 'NZ.TKI' => 'Taranaki', 'NZ.TAS' => 'Tasman', 'NZ.WKO' => 'Waikato', 'NZ.WGN' => 'Wellington', 'NZ.WTC' => 'West Coast'],
			'OM' => ['OM.DA' => 'Ad Dakhiliyah', 'OM.BU' => 'Al Buraymi', 'OM.WU' => 'Al Wusta', 'OM.ZA' => 'Az Zahirah', 'OM.BJ' => 'Janub al Batinah', 'OM.SJ' => 'Janub ash Sharqiyah', 'OM.MA' => 'Masqat', 'OM.MU' => 'Musandam', 'OM.BS' => 'Shamal al Batinah', 'OM.SS' => 'Shamal ash Sharqiyah', 'OM.ZU' => 'Zufar'],
			'PA' => ['PA.1' => 'Bocas del Toro', 'PA.4' => 'Chiriqui', 'PA.2' => 'Cocle', 'PA.3' => 'Colon', 'PA.5' => 'Darien', 'PA.EM' => 'Embera', 'PA.KY' => 'Guna Yala', 'PA.6' => 'Herrera', 'PA.7' => 'Los Santos', 'PA.NT' => 'Naso Tjer Di', 'PA.NB' => 'Ngobe-Bugle', 'PA.8' => 'Panama', 'PA.10' => 'Panama Oeste', 'PA.9' => 'Veraguas'],
			'PE' => ['PE.AMA' => 'Amazonas', 'PE.ANC' => 'Ancash', 'PE.APU' => 'Apurimac', 'PE.ARE' => 'Arequipa', 'PE.AYA' => 'Ayacucho', 'PE.CAJ' => 'Cajamarca', 'PE.CUS' => 'Cusco', 'PE.CAL' => 'El Callao', 'PE.HUV' => 'Huancavelica', 'PE.HUC' => 'Huanuco', 'PE.ICA' => 'Ica', 'PE.JUN' => 'Junin', 'PE.LAL' => 'La Libertad', 'PE.LAM' => 'Lambayeque', 'PE.LIM' => 'Lima', 'PE.LOR' => 'Loreto', 'PE.MDD' => 'Madre de Dios', 'PE.MOQ' => 'Moquegua', 'PE.PAS' => 'Pasco', 'PE.PIU' => 'Piura', 'PE.PUN' => 'Puno', 'PE.SAM' => 'San Martin', 'PE.TAC' => 'Tacna', 'PE.TUM' => 'Tumbes', 'PE.UCA' => 'Ucayali'],
			'PG' => ['PG.NSB' => 'Bougainville', 'PG.CPM' => 'Central', 'PG.CPK' => 'Chimbu', 'PG.EBR' => 'East New Britain', 'PG.ESW' => 'East Sepik', 'PG.EHG' => 'Eastern Highlands', 'PG.EPW' => 'Enga', 'PG.GPK' => 'Gulf', 'PG.HLA' => 'Hela', 'PG.JWK' => 'Jiwaka', 'PG.MPM' => 'Madang', 'PG.MRL' => 'Manus', 'PG.MBA' => 'Milne Bay', 'PG.MPL' => 'Morobe', 'PG.NCD' => 'National Capital District (Port Moresby)', 'PG.NIK' => 'New Ireland', 'PG.NPP' => 'Northern', 'PG.SHM' => 'Southern Highlands', 'PG.WBK' => 'West New Britain', 'PG.SAN' => 'West Sepik', 'PG.WPD' => 'Western', 'PG.WHM' => 'Western Highlands'],
			'PH' => ['PH.ABR' => 'Abra', 'PH.AGN' => 'Agusan del Norte', 'PH.AGS' => 'Agusan del Sur', 'PH.AKL' => 'Aklan', 'PH.ALB' => 'Albay', 'PH.ANT' => 'Antique', 'PH.APA' => 'Apayao', 'PH.AUR' => 'Aurora', 'PH.BAS' => 'Basilan', 'PH.BAN' => 'Bataan', 'PH.BTN' => 'Batanes', 'PH.BTG' => 'Batangas', 'PH.BEN' => 'Benguet', 'PH.BIL' => 'Biliran', 'PH.BOH' => 'Bohol', 'PH.BUK' => 'Bukidnon', 'PH.BUL' => 'Bulacan', 'PH.CAG' => 'Cagayan', 'PH.CAN' => 'Camarines Norte', 'PH.CAS' => 'Camarines Sur', 'PH.CAM' => 'Camiguin', 'PH.CAP' => 'Capiz', 'PH.CAT' => 'Catanduanes', 'PH.CAV' => 'Cavite', 'PH.CEB' => 'Cebu', 'PH.NCO' => 'Cotabato', 'PH.DVO' => 'Davao Occidental', 'PH.DAO' => 'Davao Oriental', 'PH.COM' => 'Davao de Oro', 'PH.DAV' => 'Davao del Norte', 'PH.DAS' => 'Davao del Sur', 'PH.DIN' => 'Dinagat Islands', 'PH.EAS' => 'Eastern Samar', 'PH.GUI' => 'Guimaras', 'PH.IFU' => 'Ifugao', 'PH.ILN' => 'Ilocos Norte', 'PH.ILS' => 'Ilocos Sur', 'PH.ILI' => 'Iloilo', 'PH.ISA' => 'Isabela', 'PH.KAL' => 'Kalinga', 'PH.LUN' => 'La Union', 'PH.LAG' => 'Laguna', 'PH.LAN' => 'Lanao del Norte', 'PH.LAS' => 'Lanao del Sur', 'PH.LEY' => 'Leyte', 'PH.MAG' => 'Maguindanao', 'PH.MAD' => 'Marinduque', 'PH.MAS' => 'Masbate', 'PH.MDC' => 'Mindoro Occidental', 'PH.MDR' => 'Mindoro Oriental', 'PH.MSC' => 'Misamis Occidental', 'PH.MSR' => 'Misamis Oriental', 'PH.MOU' => 'Mountain Province', 'PH.00' => 'National Capital Region', 'PH.NEC' => 'Negros Occidental', 'PH.NER' => 'Negros Oriental', 'PH.NSA' => 'Northern Samar', 'PH.NUE' => 'Nueva Ecija', 'PH.NUV' => 'Nueva Vizcaya', 'PH.PLW' => 'Palawan', 'PH.PAM' => 'Pampanga', 'PH.PAN' => 'Pangasinan', 'PH.QUE' => 'Quezon', 'PH.QUI' => 'Quirino', 'PH.RIZ' => 'Rizal', 'PH.ROM' => 'Romblon', 'PH.WSA' => 'Samar', 'PH.SAR' => 'Sarangani', 'PH.SIG' => 'Siquijor', 'PH.SOR' => 'Sorsogon', 'PH.SCO' => 'South Cotabato', 'PH.SLE' => 'Southern Leyte', 'PH.SUK' => 'Sultan Kudarat', 'PH.SLU' => 'Sulu', 'PH.SUN' => 'Surigao del Norte', 'PH.SUR' => 'Surigao del Sur', 'PH.TAR' => 'Tarlac', 'PH.TAW' => 'Tawi-Tawi', 'PH.ZMB' => 'Zambales', 'PH.ZSI' => 'Zamboanga Sibugay', 'PH.ZAN' => 'Zamboanga del Norte', 'PH.ZAS' => 'Zamboanga del Sur'],
			'PK' => ['PK.JK' => 'Azad Jammu and Kashmir', 'PK.BA' => 'Balochistan', 'PK.GB' => 'Gilgit-Baltistan', 'PK.IS' => 'Islamabad', 'PK.KP' => 'Khyber Pakhtunkhwa', 'PK.PB' => 'Punjab', 'PK.SD' => 'Sindh'],
			'PL' => ['PL.02' => 'Dolnoslaskie', 'PL.04' => 'Kujawsko-pomorskie', 'PL.10' => 'Lodzkie', 'PL.06' => 'Lubelskie', 'PL.08' => 'Lubuskie', 'PL.12' => 'Malopolskie', 'PL.14' => 'Mazowieckie', 'PL.16' => 'Opolskie', 'PL.18' => 'Podkarpackie', 'PL.20' => 'Podlaskie', 'PL.22' => 'Pomorskie', 'PL.24' => 'Slaskie', 'PL.26' => 'Swietokrzyskie', 'PL.28' => 'Warminsko-mazurskie', 'PL.30' => 'Wielkopolskie', 'PL.32' => 'Zachodniopomorskie'],
			'PS' => ['PS.BTH' => 'Bethlehem', 'PS.DEB' => 'Deir El Balah', 'PS.GZA' => 'Gaza', 'PS.HBN' => 'Hebron', 'PS.JEN' => 'Jenin', 'PS.JRH' => 'Jericho and Al Aghwar', 'PS.JEM' => 'Jerusalem', 'PS.KYS' => 'Khan Yunis', 'PS.NBS' => 'Nablus', 'PS.NGZ' => 'North Gaza', 'PS.QQA' => 'Qalqilya', 'PS.RFH' => 'Rafah', 'PS.RBH' => 'Ramallah', 'PS.SLT' => 'Salfit', 'PS.TBS' => 'Tubas', 'PS.TKM' => 'Tulkarm'],
			'PT' => ['PT.01' => 'Aveiro', 'PT.02' => 'Beja', 'PT.03' => 'Braga', 'PT.04' => 'Braganca', 'PT.05' => 'Castelo Branco', 'PT.06' => 'Coimbra', 'PT.07' => 'Evora', 'PT.08' => 'Faro', 'PT.09' => 'Guarda', 'PT.10' => 'Leiria', 'PT.11' => 'Lisboa', 'PT.12' => 'Portalegre', 'PT.13' => 'Porto', 'PT.30' => 'Regiao Autonoma da Madeira', 'PT.20' => 'Regiao Autonoma dos Acores', 'PT.14' => 'Santarem', 'PT.15' => 'Setubal', 'PT.16' => 'Viana do Castelo', 'PT.17' => 'Vila Real', 'PT.18' => 'Viseu'],
			'PW' => ['PW.002' => 'Aimeliik', 'PW.004' => 'Airai', 'PW.010' => 'Angaur', 'PW.050' => 'Hatohobei', 'PW.100' => 'Kayangel', 'PW.150' => 'Koror', 'PW.212' => 'Melekeok', 'PW.214' => 'Ngaraard', 'PW.218' => 'Ngarchelong', 'PW.222' => 'Ngardmau', 'PW.224' => 'Ngatpang', 'PW.226' => 'Ngchesar', 'PW.227' => 'Ngeremlengui', 'PW.228' => 'Ngiwal', 'PW.350' => 'Peleliu', 'PW.370' => 'Sonsorol'],
			'PY' => ['PY.16' => 'Alto Paraguay', 'PY.10' => 'Alto Parana', 'PY.13' => 'Amambay', 'PY.ASU' => 'Asuncion', 'PY.19' => 'Boqueron', 'PY.5' => 'Caaguazu', 'PY.6' => 'Caazapa', 'PY.14' => 'Canindeyu', 'PY.11' => 'Central', 'PY.1' => 'Concepcion', 'PY.3' => 'Cordillera', 'PY.4' => 'Guaira', 'PY.7' => 'Itapua', 'PY.8' => 'Misiones', 'PY.12' => 'Neembucu', 'PY.9' => 'Paraguari', 'PY.15' => 'Presidente Hayes', 'PY.2' => 'San Pedro'],
			'QA' => ['QA.DA' => 'Ad Dawhah', 'QA.KH' => 'Al Khawr wa adh Dhakhirah', 'QA.WA' => 'Al Wakrah', 'QA.RA' => 'Ar Rayyan', 'QA.MS' => 'Ash Shamal', 'QA.SH' => 'Ash Shihaniyah', 'QA.ZA' => 'Az Za\'ayin', 'QA.US' => 'Umm Salal'],
			'RO' => ['RO.AB' => 'Alba', 'RO.AR' => 'Arad', 'RO.AG' => 'Arges', 'RO.BC' => 'Bacau', 'RO.BH' => 'Bihor', 'RO.BN' => 'Bistrita-Nasaud', 'RO.BT' => 'Botosani', 'RO.BR' => 'Braila', 'RO.BV' => 'Brasov', 'RO.B' => 'Bucuresti', 'RO.BZ' => 'Buzau', 'RO.CL' => 'Calarasi', 'RO.CS' => 'Caras-Severin', 'RO.CJ' => 'Cluj', 'RO.CT' => 'Constanta', 'RO.CV' => 'Covasna', 'RO.DB' => 'Dambovita', 'RO.DJ' => 'Dolj', 'RO.GL' => 'Galati', 'RO.GR' => 'Giurgiu', 'RO.GJ' => 'Gorj', 'RO.HR' => 'Harghita', 'RO.HD' => 'Hunedoara', 'RO.IL' => 'Ialomita', 'RO.IS' => 'Iasi', 'RO.IF' => 'Ilfov', 'RO.MM' => 'Maramures', 'RO.MH' => 'Mehedinti', 'RO.MS' => 'Mures', 'RO.NT' => 'Neamt', 'RO.OT' => 'Olt', 'RO.PH' => 'Prahova', 'RO.SJ' => 'Salaj', 'RO.SM' => 'Satu Mare', 'RO.SB' => 'Sibiu', 'RO.SV' => 'Suceava', 'RO.TR' => 'Teleorman', 'RO.TM' => 'Timis', 'RO.TL' => 'Tulcea', 'RO.VL' => 'Valcea', 'RO.VS' => 'Vaslui', 'RO.VN' => 'Vrancea'],
			'RS' => ['RS.00' => 'Beograd', 'RS.14' => 'Borski okrug', 'RS.11' => 'Branicevski okrug', 'RS.23' => 'Jablanicki okrug', 'RS.06' => 'Juznobacki okrug', 'RS.04' => 'Juznobanatski okrug', 'RS.09' => 'Kolubarski okrug', 'RS.25' => 'Kosovski okrug', 'RS.28' => 'Kosovsko-Mitrovacki okrug', 'RS.29' => 'Kosovsko-Pomoravski okrug', 'RS.08' => 'Macvanski okrug', 'RS.17' => 'Moravicki okrug', 'RS.20' => 'Nisavski okrug', 'RS.24' => 'Pcinjski okrug', 'RS.26' => 'Pecki okrug', 'RS.22' => 'Pirotski okrug', 'RS.10' => 'Podunavski okrug', 'RS.13' => 'Pomoravski okrug', 'RS.27' => 'Prizrenski okrug', 'RS.19' => 'Rasinski okrug', 'RS.18' => 'Raski okrug', 'RS.01' => 'Severnobacki okrug', 'RS.03' => 'Severnobanatski okrug', 'RS.02' => 'Srednjebanatski okrug', 'RS.07' => 'Sremski okrug', 'RS.12' => 'Sumadijski okrug', 'RS.21' => 'Toplicki okrug', 'RS.15' => 'Zajecarski okrug', 'RS.05' => 'Zapadnobacki okrug', 'RS.16' => 'Zlatiborski okrug'],
			'RU' => ['RU.AD' => 'Adygeya, Respublika', 'RU.AL' => 'Altay, Respublika', 'RU.ALT' => 'Altayskiy kray', 'RU.AMU' => 'Amurskaya oblast\'', 'RU.ARK' => 'Arkhangel\'skaya oblast\'', 'RU.AST' => 'Astrakhanskaya oblast\'', 'RU.BA' => 'Bashkortostan, Respublika', 'RU.BEL' => 'Belgorodskaya oblast\'', 'RU.BRY' => 'Bryanskaya oblast\'', 'RU.BU' => 'Buryatiya, Respublika', 'RU.CE' => 'Chechenskaya Respublika', 'RU.CHE' => 'Chelyabinskaya oblast\'', 'RU.CHU' => 'Chukotskiy avtonomnyy okrug', 'RU.CU' => 'Chuvashskaya Respublika', 'RU.DA' => 'Dagestan, Respublika', 'RU.IN' => 'Ingushetiya, Respublika', 'RU.IRK' => 'Irkutskaya oblast\'', 'RU.IVA' => 'Ivanovskaya oblast\'', 'RU.KB' => 'Kabardino-Balkarskaya Respublika', 'RU.KGD' => 'Kaliningradskaya oblast\'', 'RU.KL' => 'Kalmykiya, Respublika', 'RU.KLU' => 'Kaluzhskaya oblast\'', 'RU.KAM' => 'Kamchatskiy kray', 'RU.KC' => 'Karachayevo-Cherkesskaya Respublika', 'RU.KR' => 'Kareliya, Respublika', 'RU.KEM' => 'Kemerovskaya oblast\'', 'RU.KHA' => 'Khabarovskiy kray', 'RU.KK' => 'Khakasiya, Respublika', 'RU.KHM' => 'Khanty-Mansiyskiy avtonomnyy okrug', 'RU.KIR' => 'Kirovskaya oblast\'', 'RU.KO' => 'Komi, Respublika', 'RU.KOS' => 'Kostromskaya oblast\'', 'RU.KDA' => 'Krasnodarskiy kray', 'RU.KYA' => 'Krasnoyarskiy kray', 'RU.KGN' => 'Kurganskaya oblast\'', 'RU.KRS' => 'Kurskaya oblast\'', 'RU.LEN' => 'Leningradskaya oblast\'', 'RU.LIP' => 'Lipetskaya oblast\'', 'RU.MAG' => 'Magadanskaya oblast\'', 'RU.ME' => 'Mariy El, Respublika', 'RU.MO' => 'Mordoviya, Respublika', 'RU.MOS' => 'Moskovskaya oblast\'', 'RU.MOW' => 'Moskva', 'RU.MUR' => 'Murmanskaya oblast\'', 'RU.NEN' => 'Nenetskiy avtonomnyy okrug', 'RU.NIZ' => 'Nizhegorodskaya oblast\'', 'RU.NGR' => 'Novgorodskaya oblast\'', 'RU.NVS' => 'Novosibirskaya oblast\'', 'RU.OMS' => 'Omskaya oblast\'', 'RU.ORE' => 'Orenburgskaya oblast\'', 'RU.ORL' => 'Orlovskaya oblast\'', 'RU.PNZ' => 'Penzenskaya oblast\'', 'RU.PER' => 'Permskiy kray', 'RU.PRI' => 'Primorskiy kray', 'RU.PSK' => 'Pskovskaya oblast\'', 'RU.ROS' => 'Rostovskaya oblast\'', 'RU.RYA' => 'Ryazanskaya oblast\'', 'RU.SA' => 'Saha, Respublika', 'RU.SAK' => 'Sakhalinskaya oblast\'', 'RU.SAM' => 'Samarskaya oblast\'', 'RU.SPE' => 'Sankt-Peterburg', 'RU.SAR' => 'Saratovskaya oblast\'', 'RU.SE' => 'Severnaya Osetiya, Respublika', 'RU.SMO' => 'Smolenskaya oblast\'', 'RU.STA' => 'Stavropol\'skiy kray', 'RU.SVE' => 'Sverdlovskaya oblast\'', 'RU.TAM' => 'Tambovskaya oblast\'', 'RU.TA' => 'Tatarstan, Respublika', 'RU.TOM' => 'Tomskaya oblast\'', 'RU.TUL' => 'Tul\'skaya oblast\'', 'RU.TVE' => 'Tverskaya oblast\'', 'RU.TYU' => 'Tyumenskaya oblast\'', 'RU.TY' => 'Tyva, Respublika', 'RU.UD' => 'Udmurtskaya Respublika', 'RU.ULY' => 'Ul\'yanovskaya oblast\'', 'RU.VLA' => 'Vladimirskaya oblast\'', 'RU.VGG' => 'Volgogradskaya oblast\'', 'RU.VLG' => 'Vologodskaya oblast\'', 'RU.VOR' => 'Voronezhskaya oblast\'', 'RU.YAN' => 'Yamalo-Nenetskiy avtonomnyy okrug', 'RU.YAR' => 'Yaroslavskaya oblast\'', 'RU.YEV' => 'Yevreyskaya avtonomnaya oblast\'', 'RU.ZAB' => 'Zabaykal\'skiy kray'],
			'RW' => ['RW.02' => 'Est', 'RW.03' => 'Nord', 'RW.04' => 'Ouest', 'RW.05' => 'Sud', 'RW.01' => 'Ville de Kigali'],
			'SA' => ['SA.14' => '\'Asir', 'SA.11' => 'Al Bahah', 'SA.08' => 'Al Hudud ash Shamaliyah', 'SA.12' => 'Al Jawf', 'SA.03' => 'Al Madinah al Munawwarah', 'SA.05' => 'Al Qasim', 'SA.01' => 'Ar Riyad', 'SA.04' => 'Ash Sharqiyah', 'SA.06' => 'Ha\'il', 'SA.09' => 'Jazan', 'SA.02' => 'Makkah al Mukarramah', 'SA.10' => 'Najran', 'SA.07' => 'Tabuk'],
			'SB' => ['SB.CT' => 'Capital Territory (Honiara)', 'SB.CE' => 'Central', 'SB.CH' => 'Choiseul', 'SB.GU' => 'Guadalcanal', 'SB.IS' => 'Isabel', 'SB.MK' => 'Makira-Ulawa', 'SB.ML' => 'Malaita', 'SB.RB' => 'Rennell and Bellona', 'SB.TE' => 'Temotu', 'SB.WE' => 'Western'],
			'SC' => ['SC.02' => 'Anse Boileau', 'SC.03' => 'Anse Etoile', 'SC.05' => 'Anse Royale', 'SC.01' => 'Anse aux Pins', 'SC.04' => 'Au Cap', 'SC.06' => 'Baie Lazare', 'SC.07' => 'Baie Sainte Anne', 'SC.08' => 'Beau Vallon', 'SC.09' => 'Bel Air', 'SC.10' => 'Bel Ombre', 'SC.11' => 'Cascade', 'SC.16' => 'English River', 'SC.12' => 'Glacis', 'SC.13' => 'Grand Anse Mahe', 'SC.14' => 'Grand Anse Praslin', 'SC.26' => 'Ile Perseverance I', 'SC.27' => 'Ile Perseverance II', 'SC.15' => 'La Digue', 'SC.24' => 'Les Mamelles', 'SC.17' => 'Mont Buxton', 'SC.18' => 'Mont Fleuri', 'SC.19' => 'Plaisance', 'SC.20' => 'Pointe Larue', 'SC.21' => 'Port Glaud', 'SC.25' => 'Roche Caiman', 'SC.22' => 'Saint Louis', 'SC.23' => 'Takamaka'],
			'SD' => ['SD.NB' => 'Blue Nile', 'SD.DC' => 'Central Darfur', 'SD.DE' => 'East Darfur', 'SD.GD' => 'Gedaref', 'SD.GZ' => 'Gezira', 'SD.KA' => 'Kassala', 'SD.KH' => 'Khartoum', 'SD.DN' => 'North Darfur', 'SD.KN' => 'North Kordofan', 'SD.NO' => 'Northern', 'SD.RS' => 'Red Sea', 'SD.NR' => 'River Nile', 'SD.SI' => 'Sennar', 'SD.DS' => 'South Darfur', 'SD.KS' => 'South Kordofan', 'SD.DW' => 'West Darfur', 'SD.GK' => 'West Kordofan', 'SD.NW' => 'White Nile'],
			'SE' => ['SE.K' => 'Blekinge lan', 'SE.W' => 'Dalarnas lan', 'SE.X' => 'Gavleborgs lan', 'SE.I' => 'Gotlands lan', 'SE.N' => 'Hallands lan', 'SE.Z' => 'Jamtlands lan', 'SE.F' => 'Jonkopings lan', 'SE.H' => 'Kalmar lan', 'SE.G' => 'Kronobergs lan', 'SE.BD' => 'Norrbottens lan', 'SE.T' => 'Orebro lan', 'SE.E' => 'Ostergotlands lan', 'SE.M' => 'Skane lan', 'SE.D' => 'Sodermanlands lan', 'SE.AB' => 'Stockholms lan', 'SE.C' => 'Uppsala lan', 'SE.S' => 'Varmlands lan', 'SE.AC' => 'Vasterbottens lan', 'SE.Y' => 'Vasternorrlands lan', 'SE.U' => 'Vastmanlands lan', 'SE.O' => 'Vastra Gotalands lan'],
			'SH' => ['SH.AC' => 'Ascension', 'SH.HL' => 'Saint Helena', 'SH.TA' => 'Tristan da Cunha'],
			'SI' => ['SI.001' => 'Ajdovscina', 'SI.213' => 'Ankaran', 'SI.195' => 'Apace', 'SI.002' => 'Beltinci', 'SI.148' => 'Benedikt', 'SI.149' => 'Bistrica ob Sotli', 'SI.003' => 'Bled', 'SI.150' => 'Bloke', 'SI.004' => 'Bohinj', 'SI.005' => 'Borovnica', 'SI.006' => 'Bovec', 'SI.151' => 'Braslovce', 'SI.007' => 'Brda', 'SI.009' => 'Brezice', 'SI.008' => 'Brezovica', 'SI.152' => 'Cankova', 'SI.011' => 'Celje', 'SI.012' => 'Cerklje na Gorenjskem', 'SI.013' => 'Cerknica', 'SI.014' => 'Cerkno', 'SI.153' => 'Cerkvenjak', 'SI.196' => 'Cirkulane', 'SI.015' => 'Crensovci', 'SI.016' => 'Crna na Koroskem', 'SI.017' => 'Crnomelj', 'SI.018' => 'Destrnik', 'SI.019' => 'Divaca', 'SI.154' => 'Dobje', 'SI.020' => 'Dobrepolje', 'SI.155' => 'Dobrna', 'SI.021' => 'Dobrova-Polhov Gradec', 'SI.156' => 'Dobrovnik', 'SI.022' => 'Dol pri Ljubljani', 'SI.157' => 'Dolenjske Toplice', 'SI.023' => 'Domzale', 'SI.024' => 'Dornava', 'SI.025' => 'Dravograd', 'SI.026' => 'Duplek', 'SI.027' => 'Gorenja vas-Poljane', 'SI.028' => 'Gorisnica', 'SI.207' => 'Gorje', 'SI.029' => 'Gornja Radgona', 'SI.030' => 'Gornji Grad', 'SI.031' => 'Gornji Petrovci', 'SI.158' => 'Grad', 'SI.032' => 'Grosuplje', 'SI.159' => 'Hajdina', 'SI.160' => 'Hoce-Slivnica', 'SI.161' => 'Hodos', 'SI.162' => 'Horjul', 'SI.034' => 'Hrastnik', 'SI.035' => 'Hrpelje-Kozina', 'SI.036' => 'Idrija', 'SI.037' => 'Ig', 'SI.038' => 'Ilirska Bistrica', 'SI.039' => 'Ivancna Gorica', 'SI.040' => 'Izola', 'SI.041' => 'Jesenice', 'SI.163' => 'Jezersko', 'SI.042' => 'Jursinci', 'SI.043' => 'Kamnik', 'SI.044' => 'Kanal', 'SI.045' => 'Kidricevo', 'SI.046' => 'Kobarid', 'SI.047' => 'Kobilje', 'SI.048' => 'Kocevje', 'SI.049' => 'Komen', 'SI.164' => 'Komenda', 'SI.050' => 'Koper', 'SI.197' => 'Kosanjevica na Krki', 'SI.165' => 'Kostel', 'SI.051' => 'Kozje', 'SI.052' => 'Kranj', 'SI.053' => 'Kranjska Gora', 'SI.166' => 'Krizevci', 'SI.054' => 'Krsko', 'SI.055' => 'Kungota', 'SI.056' => 'Kuzma', 'SI.057' => 'Lasko', 'SI.058' => 'Lenart', 'SI.059' => 'Lendava', 'SI.060' => 'Litija', 'SI.061' => 'Ljubljana', 'SI.062' => 'Ljubno', 'SI.063' => 'Ljutomer', 'SI.208' => 'Log-Dragomer', 'SI.064' => 'Logatec', 'SI.065' => 'Loska dolina', 'SI.066' => 'Loski Potok', 'SI.167' => 'Lovrenc na Pohorju', 'SI.067' => 'Luce', 'SI.068' => 'Lukovica', 'SI.069' => 'Majsperk', 'SI.198' => 'Makole', 'SI.070' => 'Maribor', 'SI.168' => 'Markovci', 'SI.071' => 'Medvode', 'SI.072' => 'Menges', 'SI.073' => 'Metlika', 'SI.074' => 'Mezica', 'SI.169' => 'Miklavz na Dravskem polju', 'SI.075' => 'Miren-Kostanjevica', 'SI.212' => 'Mirna', 'SI.170' => 'Mirna Pec', 'SI.076' => 'Mislinja', 'SI.199' => 'Mokronog-Trebelno', 'SI.077' => 'Moravce', 'SI.078' => 'Moravske Toplice', 'SI.079' => 'Mozirje', 'SI.080' => 'Murska Sobota', 'SI.081' => 'Muta', 'SI.082' => 'Naklo', 'SI.083' => 'Nazarje', 'SI.084' => 'Nova Gorica', 'SI.085' => 'Novo Mesto', 'SI.086' => 'Odranci', 'SI.171' => 'Oplotnica', 'SI.087' => 'Ormoz', 'SI.088' => 'Osilnica', 'SI.089' => 'Pesnica', 'SI.090' => 'Piran', 'SI.091' => 'Pivka', 'SI.092' => 'Podcetrtek', 'SI.172' => 'Podlehnik', 'SI.093' => 'Podvelka', 'SI.200' => 'Poljcane', 'SI.173' => 'Polzela', 'SI.094' => 'Postojna', 'SI.174' => 'Prebold', 'SI.095' => 'Preddvor', 'SI.175' => 'Prevalje', 'SI.096' => 'Ptuj', 'SI.097' => 'Puconci', 'SI.098' => 'Race-Fram', 'SI.099' => 'Radece', 'SI.100' => 'Radenci', 'SI.101' => 'Radlje ob Dravi', 'SI.102' => 'Radovljica', 'SI.103' => 'Ravne na Koroskem', 'SI.176' => 'Razkrizje', 'SI.209' => 'Recica ob Savinji', 'SI.201' => 'Rence-Vogrsko', 'SI.104' => 'Ribnica', 'SI.177' => 'Ribnica na Pohorju', 'SI.106' => 'Rogaska Slatina', 'SI.105' => 'Rogasovci', 'SI.107' => 'Rogatec', 'SI.108' => 'Ruse', 'SI.033' => 'Salovci', 'SI.178' => 'Selnica ob Dravi', 'SI.109' => 'Semic', 'SI.183' => 'Sempeter-Vrtojba', 'SI.117' => 'Sencur', 'SI.118' => 'Sentilj', 'SI.119' => 'Sentjernej', 'SI.120' => 'Sentjur', 'SI.211' => 'Sentrupert', 'SI.110' => 'Sevnica', 'SI.111' => 'Sezana', 'SI.121' => 'Skocjan', 'SI.122' => 'Skofja Loka', 'SI.123' => 'Skofljica', 'SI.112' => 'Slovenj Gradec', 'SI.113' => 'Slovenska Bistrica', 'SI.114' => 'Slovenske Konjice', 'SI.124' => 'Smarje pri Jelsah', 'SI.206' => 'Smarjeske Toplice', 'SI.125' => 'Smartno ob Paki', 'SI.194' => 'Smartno pri Litiji', 'SI.179' => 'Sodrazica', 'SI.180' => 'Solcava', 'SI.126' => 'Sostanj', 'SI.202' => 'Sredisce ob Dravi', 'SI.115' => 'Starse', 'SI.127' => 'Store', 'SI.203' => 'Straza', 'SI.181' => 'Sveta Ana', 'SI.204' => 'Sveta Trojica v Slovenskih goricah', 'SI.182' => 'Sveti Andraz v Slovenskih Goricah', 'SI.116' => 'Sveti Jurij ob Scavnici', 'SI.210' => 'Sveti Jurij v Slovenskih goricah', 'SI.205' => 'Sveti Tomaz', 'SI.184' => 'Tabor', 'SI.010' => 'Tisina', 'SI.128' => 'Tolmin', 'SI.129' => 'Trbovlje', 'SI.130' => 'Trebnje', 'SI.185' => 'Trnovska Vas', 'SI.131' => 'Trzic', 'SI.186' => 'Trzin', 'SI.132' => 'Turnisce', 'SI.133' => 'Velenje', 'SI.187' => 'Velika Polana', 'SI.134' => 'Velike Lasce', 'SI.188' => 'Verzej', 'SI.135' => 'Videm', 'SI.136' => 'Vipava', 'SI.137' => 'Vitanje', 'SI.138' => 'Vodice', 'SI.139' => 'Vojnik', 'SI.189' => 'Vransko', 'SI.140' => 'Vrhnika', 'SI.141' => 'Vuzenica', 'SI.142' => 'Zagorje ob Savi', 'SI.190' => 'Zalec', 'SI.143' => 'Zavrc', 'SI.146' => 'Zelezniki', 'SI.191' => 'Zetale', 'SI.147' => 'Ziri', 'SI.192' => 'Zirovnica', 'SI.144' => 'Zrece', 'SI.193' => 'Zuzemberk'],
			'SK' => ['SK.BC' => 'Banskobystricky kraj', 'SK.BL' => 'Bratislavsky kraj', 'SK.KI' => 'Kosicky kraj', 'SK.NI' => 'Nitriansky kraj', 'SK.PV' => 'Presovsky kraj', 'SK.TC' => 'Trenciansky kraj', 'SK.TA' => 'Trnavsky kraj', 'SK.ZI' => 'Zilinsky kraj'],
			'SL' => ['SL.E' => 'Eastern', 'SL.NW' => 'North Western', 'SL.N' => 'Northern', 'SL.S' => 'Southern', 'SL.W' => 'Western Area'],
			'SM' => ['SM.01' => 'Acquaviva', 'SM.06' => 'Borgo Maggiore', 'SM.02' => 'Chiesanuova', 'SM.07' => 'Citta di San Marino', 'SM.03' => 'Domagnano', 'SM.04' => 'Faetano', 'SM.05' => 'Fiorentino', 'SM.08' => 'Montegiardino', 'SM.09' => 'Serravalle'],
			'SN' => ['SN.DK' => 'Dakar', 'SN.DB' => 'Diourbel', 'SN.FK' => 'Fatick', 'SN.KA' => 'Kaffrine', 'SN.KL' => 'Kaolack', 'SN.KE' => 'Kedougou', 'SN.KD' => 'Kolda', 'SN.LG' => 'Louga', 'SN.MT' => 'Matam', 'SN.SL' => 'Saint-Louis', 'SN.SE' => 'Sedhiou', 'SN.TC' => 'Tambacounda', 'SN.TH' => 'Thies', 'SN.ZG' => 'Ziguinchor'],
			'SO' => ['SO.AW' => 'Awdal', 'SO.BK' => 'Bakool', 'SO.BN' => 'Banaadir', 'SO.BR' => 'Bari', 'SO.BY' => 'Bay', 'SO.GA' => 'Galguduud', 'SO.GE' => 'Gedo', 'SO.HI' => 'Hiiraan', 'SO.JD' => 'Jubbada Dhexe', 'SO.JH' => 'Jubbada Hoose', 'SO.MU' => 'Mudug', 'SO.NU' => 'Nugaal', 'SO.SA' => 'Sanaag', 'SO.SD' => 'Shabeellaha Dhexe', 'SO.SH' => 'Shabeellaha Hoose', 'SO.SO' => 'Sool', 'SO.TO' => 'Togdheer', 'SO.WO' => 'Woqooyi Galbeed'],
			'SR' => ['SR.BR' => 'Brokopondo', 'SR.CM' => 'Commewijne', 'SR.CR' => 'Coronie', 'SR.MA' => 'Marowijne', 'SR.NI' => 'Nickerie', 'SR.PR' => 'Para', 'SR.PM' => 'Paramaribo', 'SR.SA' => 'Saramacca', 'SR.SI' => 'Sipaliwini', 'SR.WA' => 'Wanica'],
			'SS' => ['SS.EC' => 'Central Equatoria', 'SS.EE' => 'Eastern Equatoria', 'SS.JG' => 'Jonglei', 'SS.LK' => 'Lakes', 'SS.BN' => 'Northern Bahr el Ghazal', 'SS.UY' => 'Unity', 'SS.NU' => 'Upper Nile', 'SS.WR' => 'Warrap', 'SS.BW' => 'Western Bahr el Ghazal', 'SS.EW' => 'Western Equatoria'],
			'ST' => ['ST.01' => 'Agua Grande', 'ST.02' => 'Cantagalo', 'ST.03' => 'Caue', 'ST.04' => 'Lemba', 'ST.05' => 'Lobata', 'ST.06' => 'Me-Zochi', 'ST.P' => 'Principe'],
			'SV' => ['SV.AH' => 'Ahuachapan', 'SV.CA' => 'Cabanas', 'SV.CH' => 'Chalatenango', 'SV.CU' => 'Cuscatlan', 'SV.LI' => 'La Libertad', 'SV.PA' => 'La Paz', 'SV.UN' => 'La Union', 'SV.MO' => 'Morazan', 'SV.SM' => 'San Miguel', 'SV.SS' => 'San Salvador', 'SV.SV' => 'San Vicente', 'SV.SA' => 'Santa Ana', 'SV.SO' => 'Sonsonate', 'SV.US' => 'Usulutan'],
			'SY' => ['SY.HA' => 'Al Hasakah', 'SY.LA' => 'Al Ladhiqiyah', 'SY.QU' => 'Al Qunaytirah', 'SY.RA' => 'Ar Raqqah', 'SY.SU' => 'As Suwayda\'', 'SY.DR' => 'Dar\'a', 'SY.DY' => 'Dayr az Zawr', 'SY.DI' => 'Dimashq', 'SY.HL' => 'Halab', 'SY.HM' => 'Hamah', 'SY.HI' => 'Hims', 'SY.ID' => 'Idlib', 'SY.RD' => 'Rif Dimashq', 'SY.TA' => 'Tartus'],
			'SZ' => ['SZ.HH' => 'Hhohho', 'SZ.LU' => 'Lubombo', 'SZ.MA' => 'Manzini', 'SZ.SH' => 'Shiselweni'],
			'TD' => ['TD.BG' => 'Bahr el Ghazal', 'TD.BA' => 'Batha', 'TD.BO' => 'Borkou', 'TD.CB' => 'Chari-Baguirmi', 'TD.EE' => 'Ennedi-Est', 'TD.EO' => 'Ennedi-Ouest', 'TD.GR' => 'Guera', 'TD.HL' => 'Hadjer Lamis', 'TD.KA' => 'Kanem', 'TD.LC' => 'Lac', 'TD.LO' => 'Logone-Occidental', 'TD.LR' => 'Logone-Oriental', 'TD.MA' => 'Mandoul', 'TD.ME' => 'Mayo-Kebbi-Est', 'TD.MO' => 'Mayo-Kebbi-Ouest', 'TD.MC' => 'Moyen-Chari', 'TD.OD' => 'Ouaddai', 'TD.SA' => 'Salamat', 'TD.SI' => 'Sila', 'TD.TA' => 'Tandjile', 'TD.TI' => 'Tibesti', 'TD.ND' => 'Ville de Ndjamena', 'TD.WF' => 'Wadi Fira'],
			'TG' => ['TG.C' => 'Centrale', 'TG.K' => 'Kara', 'TG.M' => 'Maritime', 'TG.P' => 'Plateaux', 'TG.S' => 'Savanes'],
			'TH' => ['TH.37' => 'Amnat Charoen', 'TH.15' => 'Ang Thong', 'TH.38' => 'Bueng Kan', 'TH.31' => 'Buri Ram', 'TH.24' => 'Chachoengsao', 'TH.18' => 'Chai Nat', 'TH.36' => 'Chaiyaphum', 'TH.22' => 'Chanthaburi', 'TH.50' => 'Chiang Mai', 'TH.57' => 'Chiang Rai', 'TH.20' => 'Chon Buri', 'TH.86' => 'Chumphon', 'TH.46' => 'Kalasin', 'TH.62' => 'Kamphaeng Phet', 'TH.71' => 'Kanchanaburi', 'TH.40' => 'Khon Kaen', 'TH.81' => 'Krabi', 'TH.10' => 'Krung Thep Maha Nakhon', 'TH.52' => 'Lampang', 'TH.51' => 'Lamphun', 'TH.42' => 'Loei', 'TH.16' => 'Lop Buri', 'TH.58' => 'Mae Hong Son', 'TH.44' => 'Maha Sarakham', 'TH.49' => 'Mukdahan', 'TH.26' => 'Nakhon Nayok', 'TH.73' => 'Nakhon Pathom', 'TH.48' => 'Nakhon Phanom', 'TH.30' => 'Nakhon Ratchasima', 'TH.60' => 'Nakhon Sawan', 'TH.80' => 'Nakhon Si Thammarat', 'TH.55' => 'Nan', 'TH.96' => 'Narathiwat', 'TH.39' => 'Nong Bua Lam Phu', 'TH.43' => 'Nong Khai', 'TH.12' => 'Nonthaburi', 'TH.13' => 'Pathum Thani', 'TH.94' => 'Pattani', 'TH.82' => 'Phangnga', 'TH.93' => 'Phatthalung', 'TH.56' => 'Phayao', 'TH.67' => 'Phetchabun', 'TH.76' => 'Phetchaburi', 'TH.66' => 'Phichit', 'TH.65' => 'Phitsanulok', 'TH.14' => 'Phra Nakhon Si Ayutthaya', 'TH.54' => 'Phrae', 'TH.83' => 'Phuket', 'TH.25' => 'Prachin Buri', 'TH.77' => 'Prachuap Khiri Khan', 'TH.85' => 'Ranong', 'TH.70' => 'Ratchaburi', 'TH.21' => 'Rayong', 'TH.45' => 'Roi Et', 'TH.27' => 'Sa Kaeo', 'TH.47' => 'Sakon Nakhon', 'TH.11' => 'Samut Prakan', 'TH.74' => 'Samut Sakhon', 'TH.75' => 'Samut Songkhram', 'TH.19' => 'Saraburi', 'TH.91' => 'Satun', 'TH.33' => 'Si Sa Ket', 'TH.17' => 'Sing Buri', 'TH.90' => 'Songkhla', 'TH.64' => 'Sukhothai', 'TH.72' => 'Suphan Buri', 'TH.84' => 'Surat Thani', 'TH.32' => 'Surin', 'TH.63' => 'Tak', 'TH.92' => 'Trang', 'TH.23' => 'Trat', 'TH.34' => 'Ubon Ratchathani', 'TH.41' => 'Udon Thani', 'TH.61' => 'Uthai Thani', 'TH.53' => 'Uttaradit', 'TH.95' => 'Yala', 'TH.35' => 'Yasothon'],
			'TJ' => ['TJ.DU' => 'Dushanbe', 'TJ.KT' => 'Khatlon', 'TJ.GB' => 'Kuhistoni Badakhshon', 'TJ.RA' => 'Nohiyahoi Tobei Jumhuri', 'TJ.SU' => 'Sughd'],
			'TL' => ['TL.AL' => 'Aileu', 'TL.AN' => 'Ainaro', 'TL.BA' => 'Baucau', 'TL.BO' => 'Bobonaro', 'TL.CO' => 'Cova Lima', 'TL.DI' => 'Dili', 'TL.ER' => 'Ermera', 'TL.LA' => 'Lautem', 'TL.LI' => 'Liquica', 'TL.MT' => 'Manatuto', 'TL.MF' => 'Manufahi', 'TL.OE' => 'Oecussi', 'TL.VI' => 'Viqueque'],
			'TM' => ['TM.A' => 'Ahal', 'TM.B' => 'Balkan', 'TM.D' => 'Dasoguz', 'TM.L' => 'Lebap', 'TM.M' => 'Mary'],
			'TN' => ['TN.31' => 'Beja', 'TN.13' => 'Ben Arous', 'TN.23' => 'Bizerte', 'TN.81' => 'Gabes', 'TN.71' => 'Gafsa', 'TN.32' => 'Jendouba', 'TN.41' => 'Kairouan', 'TN.42' => 'Kasserine', 'TN.73' => 'Kebili', 'TN.12' => 'L\'Ariana', 'TN.14' => 'La Manouba', 'TN.33' => 'Le Kef', 'TN.53' => 'Mahdia', 'TN.82' => 'Medenine', 'TN.52' => 'Monastir', 'TN.21' => 'Nabeul', 'TN.61' => 'Sfax', 'TN.43' => 'Sidi Bouzid', 'TN.34' => 'Siliana', 'TN.51' => 'Sousse', 'TN.83' => 'Tataouine', 'TN.72' => 'Tozeur', 'TN.11' => 'Tunis', 'TN.22' => 'Zaghouan'],
			'TO' => ['TO.01' => '\'Eua', 'TO.02' => 'Ha\'apai', 'TO.03' => 'Niuas', 'TO.04' => 'Tongatapu', 'TO.05' => 'Vava\'u'],
			'TR' => ['TR.01' => 'Adana', 'TR.02' => 'Adiyaman', 'TR.03' => 'Afyonkarahisar', 'TR.04' => 'Agri', 'TR.68' => 'Aksaray', 'TR.05' => 'Amasya', 'TR.06' => 'Ankara', 'TR.07' => 'Antalya', 'TR.75' => 'Ardahan', 'TR.08' => 'Artvin', 'TR.09' => 'Aydin', 'TR.10' => 'Balikesir', 'TR.74' => 'Bartin', 'TR.72' => 'Batman', 'TR.69' => 'Bayburt', 'TR.11' => 'Bilecik', 'TR.12' => 'Bingol', 'TR.13' => 'Bitlis', 'TR.14' => 'Bolu', 'TR.15' => 'Burdur', 'TR.16' => 'Bursa', 'TR.17' => 'Canakkale', 'TR.18' => 'Cankiri', 'TR.19' => 'Corum', 'TR.20' => 'Denizli', 'TR.21' => 'Diyarbakir', 'TR.81' => 'Duzce', 'TR.22' => 'Edirne', 'TR.23' => 'Elazig', 'TR.24' => 'Erzincan', 'TR.25' => 'Erzurum', 'TR.26' => 'Eskisehir', 'TR.27' => 'Gaziantep', 'TR.28' => 'Giresun', 'TR.29' => 'Gumushane', 'TR.30' => 'Hakkari', 'TR.31' => 'Hatay', 'TR.76' => 'Igdir', 'TR.32' => 'Isparta', 'TR.34' => 'Istanbul', 'TR.35' => 'Izmir', 'TR.46' => 'Kahramanmaras', 'TR.78' => 'Karabuk', 'TR.70' => 'Karaman', 'TR.36' => 'Kars', 'TR.37' => 'Kastamonu', 'TR.38' => 'Kayseri', 'TR.79' => 'Kilis', 'TR.71' => 'Kirikkale', 'TR.39' => 'Kirklareli', 'TR.40' => 'Kirsehir', 'TR.41' => 'Kocaeli', 'TR.42' => 'Konya', 'TR.43' => 'Kutahya', 'TR.44' => 'Malatya', 'TR.45' => 'Manisa', 'TR.47' => 'Mardin', 'TR.33' => 'Mersin', 'TR.48' => 'Mugla', 'TR.49' => 'Mus', 'TR.50' => 'Nevsehir', 'TR.51' => 'Nigde', 'TR.52' => 'Ordu', 'TR.80' => 'Osmaniye', 'TR.53' => 'Rize', 'TR.54' => 'Sakarya', 'TR.55' => 'Samsun', 'TR.63' => 'Sanliurfa', 'TR.56' => 'Siirt', 'TR.57' => 'Sinop', 'TR.73' => 'Sirnak', 'TR.58' => 'Sivas', 'TR.59' => 'Tekirdag', 'TR.60' => 'Tokat', 'TR.61' => 'Trabzon', 'TR.62' => 'Tunceli', 'TR.64' => 'Usak', 'TR.65' => 'Van', 'TR.77' => 'Yalova', 'TR.66' => 'Yozgat', 'TR.67' => 'Zonguldak'],
			'TT' => ['TT.ARI' => 'Arima', 'TT.CHA' => 'Chaguanas', 'TT.CTT' => 'Couva-Tabaquite-Talparo', 'TT.DMN' => 'Diego Martin', 'TT.MRC' => 'Mayaro-Rio Claro', 'TT.PED' => 'Penal-Debe', 'TT.PTF' => 'Point Fortin', 'TT.POS' => 'Port of Spain', 'TT.PRT' => 'Princes Town', 'TT.SFO' => 'San Fernando', 'TT.SJL' => 'San Juan-Laventille', 'TT.SGE' => 'Sangre Grande', 'TT.SIP' => 'Siparia', 'TT.TOB' => 'Tobago', 'TT.TUP' => 'Tunapuna-Piarco'],
			'TV' => ['TV.FUN' => 'Funafuti', 'TV.NMG' => 'Nanumaga', 'TV.NMA' => 'Nanumea', 'TV.NIT' => 'Niutao', 'TV.NUI' => 'Nui', 'TV.NKF' => 'Nukufetau', 'TV.NKL' => 'Nukulaelae', 'TV.VAI' => 'Vaitupu'],
			'TW' => ['TW.CHA' => 'Changhua', 'TW.CYQ' => 'Chiayi', 'TW.HSQ' => 'Hsinchu', 'TW.HUA' => 'Hualien', 'TW.KHH' => 'Kaohsiung', 'TW.KEE' => 'Keelung', 'TW.KIN' => 'Kinmen', 'TW.LIE' => 'Lienchiang', 'TW.MIA' => 'Miaoli', 'TW.NAN' => 'Nantou', 'TW.NWT' => 'New Taipei', 'TW.PEN' => 'Penghu', 'TW.PIF' => 'Pingtung', 'TW.TXG' => 'Taichung', 'TW.TNN' => 'Tainan', 'TW.TPE' => 'Taipei', 'TW.TTT' => 'Taitung', 'TW.TAO' => 'Taoyuan', 'TW.ILA' => 'Yilan', 'TW.YUN' => 'Yunlin'],
			'TZ' => ['TZ.01' => 'Arusha', 'TZ.02' => 'Dar es Salaam', 'TZ.03' => 'Dodoma', 'TZ.27' => 'Geita', 'TZ.04' => 'Iringa', 'TZ.05' => 'Kagera', 'TZ.06' => 'Kaskazini Pemba', 'TZ.07' => 'Kaskazini Unguja', 'TZ.28' => 'Katavi', 'TZ.08' => 'Kigoma', 'TZ.09' => 'Kilimanjaro', 'TZ.10' => 'Kusini Pemba', 'TZ.11' => 'Kusini Unguja', 'TZ.12' => 'Lindi', 'TZ.26' => 'Manyara', 'TZ.13' => 'Mara', 'TZ.14' => 'Mbeya', 'TZ.15' => 'Mjini Magharibi', 'TZ.16' => 'Morogoro', 'TZ.17' => 'Mtwara', 'TZ.18' => 'Mwanza', 'TZ.29' => 'Njombe', 'TZ.19' => 'Pwani', 'TZ.20' => 'Rukwa', 'TZ.21' => 'Ruvuma', 'TZ.22' => 'Shinyanga', 'TZ.30' => 'Simiyu', 'TZ.23' => 'Singida', 'TZ.31' => 'Songwe', 'TZ.24' => 'Tabora', 'TZ.25' => 'Tanga'],
			'UA' => ['UA.43' => 'Avtonomna Respublika Krym', 'UA.71' => 'Cherkaska oblast', 'UA.74' => 'Chernihivska oblast', 'UA.77' => 'Chernivetska oblast', 'UA.12' => 'Dnipropetrovska oblast', 'UA.14' => 'Donetska oblast', 'UA.26' => 'Ivano-Frankivska oblast', 'UA.63' => 'Kharkivska oblast', 'UA.65' => 'Khersonska oblast', 'UA.68' => 'Khmelnytska oblast', 'UA.35' => 'Kirovohradska oblast', 'UA.30' => 'Kyiv', 'UA.32' => 'Kyivska oblast', 'UA.09' => 'Luhanska oblast', 'UA.46' => 'Lvivska oblast', 'UA.48' => 'Mykolaivska oblast', 'UA.51' => 'Odeska oblast', 'UA.53' => 'Poltavska oblast', 'UA.56' => 'Rivnenska oblast', 'UA.40' => 'Sevastopol', 'UA.59' => 'Sumska oblast', 'UA.61' => 'Ternopilska oblast', 'UA.05' => 'Vinnytska oblast', 'UA.07' => 'Volynska oblast', 'UA.21' => 'Zakarpatska oblast', 'UA.23' => 'Zaporizka oblast', 'UA.18' => 'Zhytomyrska oblast'],
			'UG' => ['UG.314' => 'Abim', 'UG.301' => 'Adjumani', 'UG.322' => 'Agago', 'UG.323' => 'Alebtong', 'UG.315' => 'Amolatar', 'UG.324' => 'Amudat', 'UG.216' => 'Amuria', 'UG.316' => 'Amuru', 'UG.302' => 'Apac', 'UG.303' => 'Arua', 'UG.217' => 'Budaka', 'UG.218' => 'Bududa', 'UG.201' => 'Bugiri', 'UG.235' => 'Bugweri', 'UG.420' => 'Buhweju', 'UG.117' => 'Buikwe', 'UG.219' => 'Bukedea', 'UG.118' => 'Bukomansibi', 'UG.220' => 'Bukwo', 'UG.225' => 'Bulambuli', 'UG.416' => 'Buliisa', 'UG.401' => 'Bundibugyo', 'UG.430' => 'Bunyangabu', 'UG.402' => 'Bushenyi', 'UG.202' => 'Busia', 'UG.221' => 'Butaleja', 'UG.119' => 'Butambala', 'UG.233' => 'Butebo', 'UG.120' => 'Buvuma', 'UG.226' => 'Buyende', 'UG.317' => 'Dokolo', 'UG.121' => 'Gomba', 'UG.304' => 'Gulu', 'UG.403' => 'Hoima', 'UG.417' => 'Ibanda', 'UG.203' => 'Iganga', 'UG.418' => 'Isingiro', 'UG.204' => 'Jinja', 'UG.318' => 'Kaabong', 'UG.404' => 'Kabale', 'UG.405' => 'Kabarole', 'UG.213' => 'Kaberamaido', 'UG.427' => 'Kagadi', 'UG.428' => 'Kakumiro', 'UG.237' => 'Kalaki', 'UG.101' => 'Kalangala', 'UG.222' => 'Kaliro', 'UG.122' => 'Kalungu', 'UG.102' => 'Kampala', 'UG.205' => 'Kamuli', 'UG.413' => 'Kamwenge', 'UG.414' => 'Kanungu', 'UG.206' => 'Kapchorwa', 'UG.236' => 'Kapelebyong', 'UG.335' => 'Karenga', 'UG.126' => 'Kasanda', 'UG.406' => 'Kasese', 'UG.207' => 'Katakwi', 'UG.112' => 'Kayunga', 'UG.433' => 'Kazo', 'UG.407' => 'Kibaale', 'UG.103' => 'Kiboga', 'UG.227' => 'Kibuku', 'UG.432' => 'Kikuube', 'UG.419' => 'Kiruhura', 'UG.421' => 'Kiryandongo', 'UG.408' => 'Kisoro', 'UG.434' => 'Kitagwenda', 'UG.305' => 'Kitgum', 'UG.319' => 'Koboko', 'UG.325' => 'Kole', 'UG.306' => 'Kotido', 'UG.208' => 'Kumi', 'UG.333' => 'Kwania', 'UG.228' => 'Kween', 'UG.123' => 'Kyankwanzi', 'UG.422' => 'Kyegegwa', 'UG.415' => 'Kyenjojo', 'UG.125' => 'Kyotera', 'UG.326' => 'Lamwo', 'UG.307' => 'Lira', 'UG.229' => 'Luuka', 'UG.104' => 'Luwero', 'UG.124' => 'Lwengo', 'UG.114' => 'Lyantonde', 'UG.336' => 'Madi-Okollo', 'UG.223' => 'Manafwa', 'UG.320' => 'Maracha', 'UG.105' => 'Masaka', 'UG.409' => 'Masindi', 'UG.214' => 'Mayuge', 'UG.209' => 'Mbale', 'UG.410' => 'Mbarara', 'UG.423' => 'Mitooma', 'UG.115' => 'Mityana', 'UG.308' => 'Moroto', 'UG.309' => 'Moyo', 'UG.106' => 'Mpigi', 'UG.107' => 'Mubende', 'UG.108' => 'Mukono', 'UG.334' => 'Nabilatuk', 'UG.311' => 'Nakapiripirit', 'UG.116' => 'Nakaseke', 'UG.109' => 'Nakasongola', 'UG.230' => 'Namayingo', 'UG.234' => 'Namisindwa', 'UG.224' => 'Namutumba', 'UG.327' => 'Napak', 'UG.310' => 'Nebbi', 'UG.231' => 'Ngora', 'UG.424' => 'Ntoroko', 'UG.411' => 'Ntungamo', 'UG.328' => 'Nwoya', 'UG.337' => 'Obongi', 'UG.331' => 'Omoro', 'UG.329' => 'Otuke', 'UG.321' => 'Oyam', 'UG.312' => 'Pader', 'UG.332' => 'Pakwach', 'UG.210' => 'Pallisa', 'UG.110' => 'Rakai', 'UG.429' => 'Rubanda', 'UG.425' => 'Rubirizi', 'UG.431' => 'Rukiga', 'UG.412' => 'Rukungiri', 'UG.435' => 'Rwampara', 'UG.111' => 'Sembabule', 'UG.232' => 'Serere', 'UG.426' => 'Sheema', 'UG.215' => 'Sironko', 'UG.211' => 'Soroti', 'UG.212' => 'Tororo', 'UG.113' => 'Wakiso', 'UG.313' => 'Yumbe', 'UG.330' => 'Zombo'],
			'UM' => ['UM.81' => 'Baker Island', 'UM.84' => 'Howland Island', 'UM.86' => 'Jarvis Island', 'UM.67' => 'Johnston Atoll', 'UM.89' => 'Kingman Reef', 'UM.71' => 'Midway Islands', 'UM.76' => 'Navassa Island', 'UM.95' => 'Palmyra Atoll', 'UM.79' => 'Wake Island'],
			'US' => ['US.AL' => 'Alabama', 'US.AK' => 'Alaska', 'US.AZ' => 'Arizona', 'US.AR' => 'Arkansas', 'US.CA' => 'California', 'US.CO' => 'Colorado', 'US.CT' => 'Connecticut', 'US.DE' => 'Delaware', 'US.DC' => 'District of Columbia', 'US.FL' => 'Florida', 'US.GA' => 'Georgia', 'US.HI' => 'Hawaii', 'US.ID' => 'Idaho', 'US.IL' => 'Illinois', 'US.IN' => 'Indiana', 'US.IA' => 'Iowa', 'US.KS' => 'Kansas', 'US.KY' => 'Kentucky', 'US.LA' => 'Louisiana', 'US.ME' => 'Maine', 'US.MD' => 'Maryland', 'US.MA' => 'Massachusetts', 'US.MI' => 'Michigan', 'US.MN' => 'Minnesota', 'US.MS' => 'Mississippi', 'US.MO' => 'Missouri', 'US.MT' => 'Montana', 'US.NE' => 'Nebraska', 'US.NV' => 'Nevada', 'US.NH' => 'New Hampshire', 'US.NJ' => 'New Jersey', 'US.NM' => 'New Mexico', 'US.NY' => 'New York', 'US.NC' => 'North Carolina', 'US.ND' => 'North Dakota', 'US.OH' => 'Ohio', 'US.OK' => 'Oklahoma', 'US.OR' => 'Oregon', 'US.PA' => 'Pennsylvania', 'US.RI' => 'Rhode Island', 'US.SC' => 'South Carolina', 'US.SD' => 'South Dakota', 'US.TN' => 'Tennessee', 'US.TX' => 'Texas', 'US.UT' => 'Utah', 'US.VT' => 'Vermont', 'US.VA' => 'Virginia', 'US.WA' => 'Washington', 'US.WV' => 'West Virginia', 'US.WI' => 'Wisconsin', 'US.WY' => 'Wyoming'],
			'UY' => ['UY.AR' => 'Artigas', 'UY.CA' => 'Canelones', 'UY.CL' => 'Cerro Largo', 'UY.CO' => 'Colonia', 'UY.DU' => 'Durazno', 'UY.FS' => 'Flores', 'UY.FD' => 'Florida', 'UY.LA' => 'Lavalleja', 'UY.MA' => 'Maldonado', 'UY.MO' => 'Montevideo', 'UY.PA' => 'Paysandu', 'UY.RN' => 'Rio Negro', 'UY.RV' => 'Rivera', 'UY.RO' => 'Rocha', 'UY.SA' => 'Salto', 'UY.SJ' => 'San Jose', 'UY.SO' => 'Soriano', 'UY.TA' => 'Tacuarembo', 'UY.TT' => 'Treinta y Tres'],
			'UZ' => ['UZ.AN' => 'Andijon', 'UZ.BU' => 'Buxoro', 'UZ.FA' => 'Farg\'ona', 'UZ.JI' => 'Jizzax', 'UZ.NG' => 'Namangan', 'UZ.NW' => 'Navoiy', 'UZ.QA' => 'Qashqadaryo', 'UZ.QR' => 'Qoraqalpog\'iston Respublikasi', 'UZ.SA' => 'Samarqand', 'UZ.SI' => 'Sirdaryo', 'UZ.SU' => 'Surxondaryo', 'UZ.TK' => 'Toshkent', 'UZ.XO' => 'Xorazm'],
			'VC' => ['VC.01' => 'Charlotte', 'VC.06' => 'Grenadines', 'VC.03' => 'Saint David', 'VC.04' => 'Saint George', 'VC.05' => 'Saint Patrick'],
			'VE' => ['VE.Z' => 'Amazonas', 'VE.B' => 'Anzoategui', 'VE.C' => 'Apure', 'VE.D' => 'Aragua', 'VE.E' => 'Barinas', 'VE.F' => 'Bolivar', 'VE.G' => 'Carabobo', 'VE.H' => 'Cojedes', 'VE.Y' => 'Delta Amacuro', 'VE.W' => 'Dependencias Federales', 'VE.A' => 'Distrito Capital', 'VE.I' => 'Falcon', 'VE.J' => 'Guarico', 'VE.X' => 'La Guaira', 'VE.K' => 'Lara', 'VE.L' => 'Merida', 'VE.M' => 'Miranda', 'VE.N' => 'Monagas', 'VE.O' => 'Nueva Esparta', 'VE.P' => 'Portuguesa', 'VE.R' => 'Sucre', 'VE.S' => 'Tachira', 'VE.T' => 'Trujillo', 'VE.U' => 'Yaracuy', 'VE.V' => 'Zulia'],
			'VN' => ['VN.44' => 'An Giang', 'VN.43' => 'Ba Ria - Vung Tau', 'VN.54' => 'Bac Giang', 'VN.53' => 'Bac Kan', 'VN.55' => 'Bac Lieu', 'VN.56' => 'Bac Ninh', 'VN.50' => 'Ben Tre', 'VN.31' => 'Binh Dinh', 'VN.57' => 'Binh Duong', 'VN.58' => 'Binh Phuoc', 'VN.40' => 'Binh Thuan', 'VN.59' => 'Ca Mau', 'VN.CT' => 'Can Tho', 'VN.04' => 'Cao Bang', 'VN.DN' => 'Da Nang', 'VN.33' => 'Dak Lak', 'VN.72' => 'Dak Nong', 'VN.71' => 'Dien Bien', 'VN.39' => 'Dong Nai', 'VN.45' => 'Dong Thap', 'VN.30' => 'Gia Lai', 'VN.03' => 'Ha Giang', 'VN.63' => 'Ha Nam', 'VN.HN' => 'Ha Noi', 'VN.23' => 'Ha Tinh', 'VN.61' => 'Hai Duong', 'VN.HP' => 'Hai Phong', 'VN.73' => 'Hau Giang', 'VN.SG' => 'Ho Chi Minh', 'VN.14' => 'Hoa Binh', 'VN.66' => 'Hung Yen', 'VN.34' => 'Khanh Hoa', 'VN.47' => 'Kien Giang', 'VN.28' => 'Kon Tum', 'VN.01' => 'Lai Chau', 'VN.35' => 'Lam Dong', 'VN.09' => 'Lang Son', 'VN.02' => 'Lao Cai', 'VN.41' => 'Long An', 'VN.67' => 'Nam Dinh', 'VN.22' => 'Nghe An', 'VN.18' => 'Ninh Binh', 'VN.36' => 'Ninh Thuan', 'VN.68' => 'Phu Tho', 'VN.32' => 'Phu Yen', 'VN.24' => 'Quang Binh', 'VN.27' => 'Quang Nam', 'VN.29' => 'Quang Ngai', 'VN.13' => 'Quang Ninh', 'VN.25' => 'Quang Tri', 'VN.52' => 'Soc Trang', 'VN.05' => 'Son La', 'VN.37' => 'Tay Ninh', 'VN.20' => 'Thai Binh', 'VN.69' => 'Thai Nguyen', 'VN.21' => 'Thanh Hoa', 'VN.26' => 'Thua Thien-Hue', 'VN.46' => 'Tien Giang', 'VN.51' => 'Tra Vinh', 'VN.07' => 'Tuyen Quang', 'VN.49' => 'Vinh Long', 'VN.70' => 'Vinh Phuc', 'VN.06' => 'Yen Bai'],
			'VU' => ['VU.MAP' => 'Malampa', 'VU.PAM' => 'Penama', 'VU.SAM' => 'Sanma', 'VU.SEE' => 'Shefa', 'VU.TAE' => 'Tafea', 'VU.TOB' => 'Torba'],
			'WF' => ['WF.AL' => 'Alo', 'WF.SG' => 'Sigave', 'WF.UV' => 'Uvea'],
			'WS' => ['WS.AA' => 'A\'ana', 'WS.AL' => 'Aiga-i-le-Tai', 'WS.AT' => 'Atua', 'WS.FA' => 'Fa\'asaleleaga', 'WS.GE' => 'Gaga\'emauga', 'WS.GI' => 'Gagaifomauga', 'WS.PA' => 'Palauli', 'WS.SA' => 'Satupa\'itea', 'WS.TU' => 'Tuamasaga', 'WS.VF' => 'Va\'a-o-Fonoti', 'WS.VS' => 'Vaisigano'],
			'YE' => ['YE.AD' => '\'Adan', 'YE.AM' => '\'Amran', 'YE.AB' => 'Abyan', 'YE.DA' => 'Ad Dali\'', 'YE.BA' => 'Al Bayda\'', 'YE.HU' => 'Al Hudaydah', 'YE.JA' => 'Al Jawf', 'YE.MR' => 'Al Mahrah', 'YE.MW' => 'Al Mahwit', 'YE.SA' => 'Amanat al \'Asimah', 'YE.DH' => 'Dhamar', 'YE.HD' => 'Hadramawt', 'YE.HJ' => 'Hajjah', 'YE.IB' => 'Ibb', 'YE.LA' => 'Lahij', 'YE.MA' => 'Ma\'rib', 'YE.RA' => 'Raymah', 'YE.SD' => 'Sa\'dah', 'YE.SN' => 'San\'a\'', 'YE.SH' => 'Shabwah', 'YE.TA' => 'Ta\'izz', 'YE.SU' => 'Arkhabil Suqutra'],
			'ZA' => ['ZA.EC' => 'Eastern Cape', 'ZA.FS' => 'Free State', 'ZA.GT' => 'Gauteng', 'ZA.NL' => 'Kwazulu-Natal', 'ZA.LP' => 'Limpopo', 'ZA.MP' => 'Mpumalanga', 'ZA.NW' => 'North-West', 'ZA.NC' => 'Northern Cape', 'ZA.WC' => 'Western Cape'],
			'ZM' => ['ZM.02' => 'Central', 'ZM.08' => 'Copperbelt', 'ZM.03' => 'Eastern', 'ZM.04' => 'Luapula', 'ZM.09' => 'Lusaka', 'ZM.10' => 'Muchinga', 'ZM.06' => 'North-Western', 'ZM.05' => 'Northern', 'ZM.07' => 'Southern', 'ZM.01' => 'Western'],
			'ZW' => ['ZW.BU' => 'Bulawayo', 'ZW.HA' => 'Harare', 'ZW.MA' => 'Manicaland', 'ZW.MC' => 'Mashonaland Central', 'ZW.ME' => 'Mashonaland East', 'ZW.MW' => 'Mashonaland West', 'ZW.MV' => 'Masvingo', 'ZW.MN' => 'Matabeleland North', 'ZW.MS' => 'Matabeleland South', 'ZW.MI' => 'Midlands'],
		];

		if (isset($regions[$country_code])) {
			foreach ($regions[$country_code] as $region_code => $name) {
				if ($name == $region_name) {
					return $region_code;
				}
			}
		}

		return false;
	}

	private function is_setup_completed()
	{
		if (get_option('ip2location_redirection_lookup_mode') == 'ws' && get_option('ip2location_redirection_api_key')) {
			return true;
		}

		if (get_option('ip2location_redirection_lookup_mode') == 'bin' && is_file(IP2LOCATION_DIR . get_option('ip2location_redirection_database'))) {
			return true;
		}

		return false;
	}

	private function get_database_date()
	{
		if (!is_file(IP2LOCATION_DIR . get_option('ip2location_redirection_database'))) {
			return;
		}

		$obj = new \IP2Location\Database(IP2LOCATION_DIR . get_option('ip2location_redirection_database'), \IP2Location\Database::FILE_IO);

		return date('Y-m-d', strtotime(str_replace('.', '-', $obj->getDatabaseVersion())));
	}

	private function is_region_supported()
	{
		if (get_option('ip2location_redirection_lookup_mode') == 'ws' && get_option('ip2location_redirection_api_key')) {
			return true;
		}

		if (!is_file(IP2LOCATION_DIR . get_option('ip2location_redirection_database'))) {
			return null;
		}

		$obj = new \IP2Location\Database(IP2LOCATION_DIR . get_option('ip2location_redirection_database'), \IP2Location\Database::FILE_IO);

		$result = $obj->lookup('8.8.8.8', \IP2Location\Database::ALL);

		if (preg_match('/unavailable/', $result['regionName'])) {
			return false;
		}

		return true;
	}

	private function cidr_match($ip, $cidr)
	{
		list($subnet, $mask) = explode('/', $cidr);

		if (filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4) && filter_var($subnet, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
			return (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet);
		} elseif (filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6) && filter_var($subnet, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6)) {
			$ip = inet_pton($ip);
			$subnet = inet_pton($subnet);

			$binMask = str_repeat('f', $mask / 4);
			switch ($mask % 4) {
				case 0:
					break;
				case 1:
					$binMask .= '8';
					break;
				case 2:
					$binMask .= 'c';
					break;
				case 3:
					$binMask .= 'e';
					break;
			}

			$binMask = str_pad($binMask, 32, '0');
			$binMask = pack('H*', $binMask);

			return ($ip & $binMask) == $subnet;
		}

		return false;
	}

	private function cache_add($key, $value)
	{
		$value = is_array($value) ? $value : [$value];
		file_put_contents(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . md5($key . '_ip2location_redirection') . '.json', json_encode($value));
	}

	private function cache_get($key)
	{
		if (file_exists(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . md5($key . '_ip2location_redirection') . '.json')) {
			return json_decode(file_get_contents(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . md5($key . '_ip2location_redirection') . '.json'));
		}

		return null;
	}

	private function cache_clear($day = 1)
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		$now = time();
		$files = scandir(IP2LOCATION_DIR . 'caches');

		foreach ($files as $file) {
			if (substr($file, -5) == '.json') {
				if ($now - filemtime(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . $file) >= 60 * 60 * 24 * $day) {
					$wp_filesystem->delete(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . $file);
				}
			}
		}
	}

	private function cache_flush()
	{
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		$files = scandir(IP2LOCATION_DIR . 'caches');

		foreach ($files as $file) {
			if (substr($file, -5) == '.json') {
				$wp_filesystem->delete(IP2LOCATION_DIR . 'caches' . \DIRECTORY_SEPARATOR . $file);
			}
		}
	}

	private function get_page_id()
	{
		$post_name = preg_replace('/\/?\?.+$/', '', trim($_SERVER['REQUEST_URI'], '/'));

		if (strrpos($post_name, '/') !== false) {
			$post_name = substr($post_name, strrpos($post_name, '/') + 1);
		}

		$results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$GLOBALS['wpdb']->prefix}posts WHERE post_name = '$post_name'", OBJECT);

		return ($results) ? $results[0]->ID : null;
	}

	private function get_post_title($post_id)
	{
		return $GLOBALS['wpdb']->get_var("SELECT `post_title` FROM {$GLOBALS['wpdb']->prefix}posts WHERE `ID` = '$post_id'");
	}

	private function get_permalink($page_id)
	{
		$results = $GLOBALS['wpdb']->get_results("SELECT * FROM {$GLOBALS['wpdb']->prefix}posts WHERE `ID` = '$page_id'", OBJECT);

		if ($results) {
			if (preg_match('/page_id=[0-9]+$/', $results[0]->guid)) {
				return '/' . $results[0]->post_name;
			}

			return $results[0]->guid;
		}

		return null;
	}
}
