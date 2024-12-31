<?php

/**
 * The script manager.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Frontend;

use Aheto\Helper;
use Aheto\Dynamic_CSS;
use Aheto\Traits\Hooker;
use Aheto\Generate_elementor_admin_css;
use WP_HTML_Compression;

defined('ABSPATH') || exit;

/**
 * Script_Manager class.
 */
class Script_Manager
{

	use Hooker;

	/**
	 * The Construct
	 */
	public function __construct()
	{
		$this->action('get_header', 'wp_html_compression_start', 5);
		$this->action('wp_enqueue_scripts', 'dequeue', 5);
		$this->action('wp_enqueue_scripts', 'register_styles', 5);
		$this->action('wp_enqueue_scripts', 'register_scripts', 3);
		$this->action('elementor/preview/enqueue_styles', 'elementor_style', 5);
		$this->action('elementor/preview/enqueue_scripts', 'elementor_script', 100);
		$this->action('wp_enqueue_scripts', 'enqueue', 25);
		$this->action('wp_footer', 'script_data');
		// $this->action( 'elementor/editor/after_enqueue_scripts', 'register_elementor_styles', 5 );
		$this->action('wp_print_styles', 'dequeue_gutenberg_styles', 5);

		if (!Helper::checkIE() && 'visual-composer' !== Helper::get_settings('general.builder')) {
			$this->filter('style_loader_tag', 'add_rel_preload', 10, 4);
			$this->filter('script_loader_tag', 'add_acync_script', 10, 3);
		}

		if (Helper::is_woocommerce_active()) {
			$this->action('wp_enqueue_scripts', 'woocommerce');
		}

	}

	/**
	 * Unregister Scripts and Styles
	 */
	public function dequeue()
	{
		remove_action('wp_enqueue_scripts', 'twentyseventeen_scripts');
		remove_action('wp_enqueue_scripts', 'twentynineteen_scripts');
	}

	/**
	 * Unregister Gutenberg Styles
	 */
	public function dequeue_gutenberg_styles()
	{

		if (is_page() || is_home()) {
			$post_id = get_queried_object_id();
		} else {
			$post_id = get_the_ID();
		}
		$page_template = get_page_template_slug($post_id);
		$include_scripts = false;

		if (!empty($page_template)) {
			$page_template_array = explode("_", $page_template);
			$include_scripts = $page_template_array[0] == 'aheto' ? true : false;
		}

		if ($include_scripts) {
			wp_dequeue_style('wp-block-library');
			wp_dequeue_style('wp-block-library-theme');
			wp_dequeue_style('qodeblock-style-css');
			wp_dequeue_style('qodeblock-fontawesome');
		}
	}

	/**
	 * Register Styles
	 */
	public function register_styles()
	{

		$this->skin = Helper::get_active_skin();
		$custom_css = Helper::get_settings('general.custom_css_including');
		$style_dir = aheto()->plugin_url() . 'assets/frontend/css/';
		$fonts_dir = aheto()->plugin_url() . 'assets/fonts/';
		$vendor_dir = aheto()->plugin_url() . 'assets/frontend/vendors/';
		$skin_page = Helper::get_page_skin();

		if (isset($this->skin['search_select']))
			$skin_select = $this->skin['search_select'];
		else
			$skin_select = $this->skin;

		$skin_page = !empty($skin_page) ? $skin_page : $skin_select;
		$layout = Helper::get_settings('general.blog_template', 'theme');


//
//		// Styles.
		wp_register_style('fullcalendar', $vendor_dir . 'fullcalendar/fullcalendar.min.css', null, null);
		wp_register_style('magnific', $vendor_dir . 'magnific/magnific.min.css', null, null);
		wp_register_style('lightgallery', $vendor_dir . 'lightgallery/lightgallery.min.css', null, null);
		wp_register_style('slick', $vendor_dir . 'slick/slick.min.css', null, null);
		wp_register_style('swiper', $vendor_dir . 'swiper/swiper.min.css', null, null);
		wp_register_style('owl', $vendor_dir . 'owl/owl.carousel.min.css', null, null);
		wp_register_style('lity', $vendor_dir . 'lity/lity.min.css', null, null);

		// Preloaders.
		wp_register_style('preloader-spinner', $style_dir . 'preloader-spinner.css', null, null);
		wp_register_style('preloader-simple', $style_dir . 'preloader-simple.css', null, null);
		wp_register_style('preloader-with_text', $style_dir . 'preloader-with_text.css', null, null);
		wp_register_style('preloader-with_image', $style_dir . 'preloader-with_image.css', null, null);

		// Icons.
		wp_register_style('elegant', $fonts_dir . 'elegant.min.css', null, null);
		wp_register_style('font-awesome-4.7.0', $fonts_dir . 'font-awesome.min.css', null, null);
		wp_register_style('ionicons', $fonts_dir . 'ionicons.min.css', null, null);
		wp_register_style('pe-icon-7-stroke', $fonts_dir . 'pe-icon-7-stroke.min.css', null, null);
		wp_register_style('themify', $fonts_dir . 'themify-icons.min.css', null, null);

		$builder = Helper::get_settings('general.builder') ? Helper::get_settings('general.builder') : 'elementor';
		$upload_dir = wp_upload_dir();
		$corrections = [
			'visual-composer' => 'vc-corrections.css',
		];

		wp_register_style('aheto-blog-list', $style_dir . 'blog-list.css');

		if (isset($builder) && false !== $builder) {
			wp_register_style('aheto-shop', $style_dir . 'shop.css', null, null);
			wp_register_style('style-main', $style_dir . 'style.css', null, null);
		}

		if (isset($corrections[$builder])) {
			wp_register_style('style-corrections', $style_dir . $corrections[$builder], null, null);
		}

		if (is_rtl()) {
			wp_register_style('custom-rtl-aheto', $style_dir . 'rtl_elm.css');
		}

		wp_register_style('style-skin', Dynamic_CSS::file('uri', $skin_page), null, null);


		if ($layout !== 'theme' && (is_home() || is_search() || is_category() || is_archive() || is_tag())) {
			wp_enqueue_style('swiper');
		}

		$preloader = Helper::get_settings('general.preloader');
		$preloader = isset($preloader) && !empty($preloader) ? $preloader : 'none';

		if ($preloader !== 'none' && $preloader !== 'custom') {

			wp_enqueue_style('preloader-' . $preloader);
		}

		/* Old version
		if ( ! is_admin() && ! wp_doing_ajax() && isset( aheto()->css_generator ) ) {
			if ( $uri = aheto()->css_generator->get_file_uri( get_the_ID() ) ) { // phpcs:ignore
				wp_register_style( 'aheto_shortcode_dynamic', $uri, null, '2.1.0' );
			}
			else {
				if ( file_exists($upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles/aheto-'. get_the_ID().'-elementor.css' ) ) {
					$url =  $upload_dir['baseurl'] . '/aheto-styles/aheto-'. get_the_ID().'-elementor.css';
					wp_register_style( 'aheto_shortcode_dynamic', $url, null, '2.1.0' );
				}
			}

			$frontend = aheto()->frontend;

			if ( $frontend->header_id && $uri = aheto()->css_generator->get_file_uri( $frontend->header_id ) ) {
				wp_register_style( 'aheto_header_dynamic', $uri, null, '2.1.0' );
			}

			if ( $frontend->footer_id && $uri = aheto()->css_generator->generate_css( $frontend->footer_id ) ) {
				wp_register_style( 'aheto_footer_dynamic', $uri, null, '2.1.0' );
			}
		}
		*/
		/* New version */

		$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
		if (!is_admin() && !wp_doing_ajax() && isset(aheto()->css_generator)) {

			$frontend = aheto()->frontend;
			if ($frontend) {
				$header_id = $frontend->header_id;
				$footer_id = $frontend->footer_id;
			}

			$header_id = (!empty($header_id)) ? $header_id : 0;
			$footer_id = (!empty($footer_id)) ? $footer_id : 0;

			if (get_the_ID()) {

				$post_type = get_post_type(get_the_ID());

				if (($post_type !== 'aheto-header') && ($post_type !== 'aheto-footer')) {

					update_post_meta(get_the_ID(), 'header_id', $header_id);
					update_post_meta(get_the_ID(), 'footer_id', $footer_id);

					/* don't delete!
					$uri = aheto()->css_generator->get_file_headers_footer( get_the_ID(), $header_id, $footer_id );
					if ( $uri ) {
						wp_register_style( 'aheto_shortcode_dynamic', $uri, null, '2.1.0' );
					}
					else {
						if ( file_exists($upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles/aheto-' . get_the_ID() . '-elementor.css') ) {
							$url = $upload_dir['baseurl'] . '/aheto-styles/aheto-' . get_the_ID() . '-elementor.css';
							wp_register_style('aheto_shortcode_dynamic', $url, null, '2.1.0');
						}
					}
					*/


					if (!empty($custom_css) && ($custom_css == "enabled")) {
						if (file_exists($upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'aheto-styles/aheto-' . get_the_ID() . '-elementor.css')) {
							$url = $upload_dir['baseurl'] . '/aheto-styles/aheto-' . get_the_ID() . '-elementor.css';
							wp_register_style('aheto_shortcode_dynamic', $url, null, '2.1.0');
						}
					}

				}
			}

		}
		/* */
	}

	/**
	 * Register Scripts
	 */
	public function register_scripts()
	{
		$vendor_dir = aheto()->plugin_url() . 'assets/frontend/vendors/';

		// Get aheto option.
		$options = get_option('aheto-general-settings');
		$google_map_api = isset($options['google_api_key']) && !empty($options['google_api_key']) ? $options['google_api_key'] : '';

		$layout = Helper::get_settings('general.blog_template', 'theme');

		// Scripts.
		wp_register_script('fullcalendar', $vendor_dir . 'fullcalendar/fullcalendar.min.js', null, null, true);
		if(!empty($google_map_api)){
			wp_register_script('googlemap-api', (is_ssl() ? 'https' : 'http') . '://maps.googleapis.com/maps/api/js?key=' . $google_map_api . '&language=en', null, null, true);
		}
		wp_register_script('googlemap', $vendor_dir . 'googlemap/google-maps.js', null, null, true);

		wp_register_script('isotope', $vendor_dir . 'isotope/isotope.min.js', null, null, true);
		wp_register_script('magnific', $vendor_dir . 'magnific/magnific.min.js', ['jquery'], null, true);
		wp_register_script('lightgallery', $vendor_dir . 'lightgallery/lightgallery.min.js', ['jquery'], null, true);
		wp_register_script('parallax', $vendor_dir . 'parallax/parallax.min.js', null, null, true);
		wp_register_script('slick', $vendor_dir . 'slick/slick.min.js', null, null, true);
		wp_register_script('mousewheel', $vendor_dir . 'mousewheel/mousewheel.min.js', null, null, true);
		wp_register_script('owl', $vendor_dir . 'owl/owl.carousel.min.js', null, null, true);
		wp_register_script('swiper', $vendor_dir . 'swiper/swiper.min.js', null, null, true);
		wp_register_script('spectragram', $vendor_dir . 'spectragram/spectragram.min.js', null, null, true);
		wp_register_script('typed', $vendor_dir . 'typed/typed.min.js', null, null, true);
		wp_register_script('lity', $vendor_dir . 'lity/lity.min.js', null, null, true);
		wp_register_script('tweenmax-all', $vendor_dir . 'tweenmax/tweenmax.min.js', null, null, true);
		wp_register_script('scrollmagic', $vendor_dir . 'scrollmagic/scrollmagic.min.js', null, null, true);
		wp_register_script('anime', $vendor_dir . 'anime/anime.min.js', null, null, true);
		wp_register_script('barba', $vendor_dir . 'barba/barba.min.js', null, null, true);
		wp_register_script('aheto-search-filter', $vendor_dir . 'search/search.min.js', ['jquery'], '1.0.1', true);
		wp_register_script('aheto-lazy', $vendor_dir . 'lazyload/lazyload.min.js', null, aheto()->version, true);
		wp_register_script('aheto-main', $vendor_dir . 'script.min.js', ['jquery', 'imagesloaded'], aheto()->version, true);

		wp_localize_script('frontend-js', 'get',
			array(
				'ajaxurl' => admin_url('admin-ajax.php')
			)
		);

		if ($layout !== 'theme' && (is_home() || is_search() || is_category() || is_archive() || is_tag())) {
			wp_enqueue_script('imagesloaded');
			wp_enqueue_script('swiper');
			wp_enqueue_script('isotope');
		}


	}

	/**
	 * Function including admin scripts
	 *
	 */
	public function admin_scripts()
	{
		$plugin_url = aheto()->plugin_url();

		wp_enqueue_script('aheto_skin', $plugin_url . 'assets/admin/js/skin.js', null, null, true);
		wp_enqueue_script('aheto_admin_js', $plugin_url . 'assets/admin/js/aheto-admin.js', null, null, true);
		wp_localize_script('aheto_skin', 'ajax', ['url' => admin_url('admin-ajax.php')]);
		wp_localize_script('aheto_admin_js', 'get',
			array(
				'ajaxurl' => admin_url('admin-ajax.php')
			)
		);
	}

	/**
	 * Function for including admin css / js
	 *
	 */
	public function elementor_style()
	{

		$path_css = Generate_elementor_admin_css::aheto_upload_url() . '/' . Generate_elementor_admin_css::$css_name;

		if (isset($_SERVER['HTTPS']) &&
			($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}

		if ($protocol == 'https://') {
			$path_css = str_replace('http://', $protocol, $path_css);
		}

		wp_enqueue_style('aheto_elementor_shortcode_dynamic_css', $path_css, null, time());
	}

	public function elementor_script()
	{

		$path_js = Generate_elementor_admin_css::aheto_upload_url() . '/' . Generate_elementor_admin_css::$js_name;

		if (isset($_SERVER['HTTPS']) &&
			($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$protocol = 'https://';
		} else {
			$protocol = 'http://';
		}

		if ($protocol == 'https://') {
			$path_js = str_replace('http://', $protocol, $path_js);
		}

		wp_enqueue_script('aheto_elementor_shortcode_dynamic_js', $path_js, ['jquery', 'elementor-frontend'], time(), true);
	}

	/**
	 * Enqueue Scripts and Styles
	 */
	public function enqueue()
	{
		$skin_name = Helper::get_page_skin();

		if (isset($this->skin['search_select']))
			$skin_select = $this->skin['search_select'];
		else
			$skin_select = $this->skin;

		$skin_name = !empty($skin_name) ? $skin_name : $skin_select;
//		$skin_name = is_array( $this->skin ) && isset( $this->skin['search_select'] ) ? $this->skin['search_select'] : '';
		$fonts = get_transient('aheto_google_fonts_' . $skin_name);

		if (false !== $fonts) {
			wp_enqueue_style('aheto_google_fonts', $fonts, null, null);
		}

		$font_icons = (array)Helper::get_settings('general.font-icons');

		if (!empty($font_icons)) {
			foreach ($font_icons as $handle) {
				$handle = $handle === 'font-awesome' ? 'font-awesome-4.7.0' : $handle;
				wp_enqueue_style($handle);
			}
		}

		wp_enqueue_style('style-main');
		if (is_rtl()) {
			wp_enqueue_style('custom-rtl-aheto');
		}

		if (function_exists("is_woocommerce") && Helper::is_woocommerce_active()) {
			wp_enqueue_style('aheto-shop');
		} else {
			$woocommerce_keys = array(
				"woocommerce_shop_page_id",
				"woocommerce_terms_page_id",
				"woocommerce_cart_page_id",
				"woocommerce_checkout_page_id",
				"woocommerce_pay_page_id",
				"woocommerce_thanks_page_id",
				"woocommerce_myaccount_page_id",
				"woocommerce_edit_address_page_id",
				"woocommerce_view_order_page_id",
				"woocommerce_change_password_page_id",
				"woocommerce_logout_page_id",
				"woocommerce_lost_password_page_id"
			);

			foreach ($woocommerce_keys as $wc_page_id) {
				if (get_the_ID() == get_option($wc_page_id, 0)) {
					wp_enqueue_style('aheto-shop');
				}
			}


		}


		wp_enqueue_style('style-corrections');
		wp_enqueue_style('style-skin');

		if (!is_admin()) {
			wp_enqueue_style('aheto_shortcode_dynamic');
//			wp_enqueue_style( 'aheto_header_dynamic' );
//			wp_enqueue_style( 'aheto_footer_dynamic' );
		}

		$disable_gutenberg = Helper::get_settings('general.disable_gutenberg');
		$disable_gutenberg = (isset($disable_gutenberg) && !empty($disable_gutenberg)) ? $disable_gutenberg : false;

		if (isset($disable_gutenberg) && $disable_gutenberg === 'enabled') {
			wp_dequeue_style('wp-block-library');
			wp_dequeue_style('wp-block-library-theme');
			wp_dequeue_style('wc-block-style');
			wp_dequeue_style('storefront-gutenberg-blocks');
		}

	}

	/**
	 * Enqueue main script
	 */
	public function script_data()
	{
		$lazyload = Helper::get_settings('general.lazyload');
		if ($lazyload == 'enable') {
			wp_enqueue_script('aheto-lazy');
		}
		wp_enqueue_script('aheto-main');
	}

	/**
	 * Optimize WooCommerce Scripts
	 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 */
	public function woocommerce()
	{

		if (Helper::is_woocommerce_active() || is_cart() || is_checkout()) {
			return;
		}

		// Dequeue styles.
		wp_dequeue_style('woocommerce-layout');
		wp_dequeue_style('woocommerce-smallscreen');
		wp_dequeue_style('woocommerce-general');
		wp_dequeue_style('woocommerce_prettyPhoto_css');

		// Dequeue scripts.
		wp_dequeue_script('wc-add-payment-method');
		wp_dequeue_script('wc_price_slider');
		wp_dequeue_script('wc-add-to-cart-variation');
		wp_dequeue_script('prettyPhoto');
		wp_dequeue_script('prettyPhoto-init');

		wp_dequeue_script('wc-cart-fragments');
		wp_dequeue_script('woocommerce');
//		wp_dequeue_script( 'wc-add-to-cart' ); -- need to delete
		wp_dequeue_script('wc-checkout');
		wp_dequeue_script('wc-cart');
		wp_dequeue_script('wc-single-product');
	}

	/**
	 * Added preload attribute for link tag in head
	 *
	 * @return string
	 */
	public function add_rel_preload($html, $handle, $href, $media)
	{

		$preload_css = Helper::get_settings('general.preload_css');
		$preload_css = (isset($preload_css) && !empty($preload_css)) ? $preload_css : false;

		if (is_admin() || $preload_css !== 'enabled') {
			return $html;
		}

		$google_fonts_handles = [
			'google-fonts-1',
			'google-fonts-2',
			'google-fonts-3',
			'google-fonts-4',
			'google-fonts-5',
			'google-fonts-6'
		];


		if (in_array($handle, $google_fonts_handles)) {

			$swapHref = $href . '&display=swap';

			$html = <<<EOT
<link rel="preload stylesheet preconnect" as="style" id="$handle" href="$swapHref" type="text/css" media="$media" crossorigin />
EOT;
		} else {
			$html = <<<EOT
<link rel="preload stylesheet preconnect" as="style" id="$handle" href="$href" type="text/css" media="$media" crossorigin />
EOT;
		}

		return $html;
	}

	/**
	 * Added async attribute for script tag in footer
	 *
	 * @return string
	 */

	public function add_acync_script($tag, $handle, $src)
	{

		$defer_js = Helper::get_settings('general.defer_js');
		$defer_js = (isset($defer_js) && !empty($defer_js)) ? $defer_js : false;

		if (is_admin() || $defer_js !== 'enabled') {
			return $tag;
		}

		$scripts_defer = [
			'fullcalendar',
			'magnific',
			'lightgallery',
			'slick',
			'parallax',
			'spectragram',
			'swiper',
			'lity',
			'aheto-lazy',
			'googlemap-api',
			'googlemap',
			'isotope',
			'aheto-main',
			'wpdp-scripts2',
		];


		if (in_array($handle, $scripts_defer)) {
			return "<script src='$src' defer></script>";
		} else {
			return $tag;
		}

	}

	public function wp_html_compression_finish($html)
	{
		return new WP_HTML_Compression($html);
	}

	public function wp_html_compression_start()
	{

		$minify_html = Helper::get_settings('general.minify_html');
		$minify_html = (isset($minify_html) && !empty($minify_html)) ? $minify_html : false;

		if (isset($minify_html) && $minify_html === 'enabled' && !is_user_logged_in()) {

			ob_start(array($this, 'wp_html_compression_finish'));
		}
	}

}




