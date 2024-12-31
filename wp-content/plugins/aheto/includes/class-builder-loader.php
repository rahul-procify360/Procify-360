<?php
/**
 * The Builder loader
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Params;
use Aheto\Traits\Hooker;
use Aheto\Elementor\Elementor;
use Aheto\Visual_Composer\Visual_Composer;

defined( 'ABSPATH' ) || exit;

/**
 * Builder_loader class.
 */
class Builder_Loader {

	use Hooker;

	/**
	 * Loaded elements.
	 *
	 * @var array
	 */
	private $loaded = [];

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'init', 'init', 7 );
		$this->action( 'aheto_option_settings_blocks', 'blocks_management' );
//		$this->filter( 'aheto_active_leyouts', 'aheto_deactivate_layouts', 9 );
	}

	/**
	 * Init classes for specific builder.
	 */
	public function init() {
		// Init bank.
		Params::init();

		// Init builder.
		$builder = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';

		if ( 'visual-composer' === $builder && class_exists( 'Vc_Manager' ) && class_exists( 'WPBakeryShortCode' ) ) {
			new Visual_Composer;
			$this->action( 'init', 'load', 25 );

			return;
		}

		if ( 'elementor' === $builder ) {
			new Elementor;
			$this->action( 'elementor/widgets/register', 'load_elementor', 25 );

			return;
		}

	}

	/**
	 * Add block for enable/disable
	 *
	 * @param CMB2 $cmb Current CMB2 instance.
	 */
	public function blocks_management( $cmb ) {
		$cmb->add_field( [
			'id'      => 'info',
			'type'    => 'title',
			'desc'    => esc_html__( 'Turn on switcher if you want to include this shortcode to your theme.', 'aheto' ),
			'after'   => '<span class="close close-js"><i class="fas fa-times"></i></span>',
		] );
		foreach ( $this->get_elements() as $id => $shortcode ) {
			$cmb->add_field( [
				'id'      => 'block_' . $id,
				'type'    => 'switch',
				'name'    => $shortcode['title'],
//				'desc'    => esc_html__( 'Turn on switcher if you want to include this shortcode to your theme.', 'aheto' ),
				'default' => 'on',
			] );


//			if ( count( $this->aheto_all_layouts() ) > 1 ) {
//
//				$cmb->add_field( [
//					'id'      => 'block_' . $id . '_sets',
//					'type'    => 'multicheck',
//					'name'    => __( 'Enable layout sets', 'aheto' ),
//					'desc'    => esc_html__( 'Select layout sets you want to enable. At least one should be active.', 'aheto' ),
//					'options' => $this->aheto_all_layouts(),
//					'default' => 'default',
//				] );
//			}
		}
	}


	/**
	 * All layouts
	 */

	public function aheto_all_layouts() {
		$layout_sets        = array(
			'default' => esc_html__( 'Aheto', 'aheto' )
		);
		$additional_layouts = apply_filters( 'aheto_layout_sets', array() );
		$layout_sets        = array_merge( $layout_sets, $additional_layouts );

		return $layout_sets;
	}


	/**
	 * Deactivate layouts
	 */
	public function aheto_deactivate_layouts() {

		$current_options       = array();
		$disable_layouts_array = array();

		$aheto_all_layouts = $this->aheto_all_layouts();
		$aheto_folder_name = trailingslashit( dirname( plugin_basename( AHETO_FILE ) ) );

		$directory_plugin = WP_PLUGIN_DIR . '/'.$aheto_folder_name.'shortcodes/';
		$directory_addon  = WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/shortcodes/';
		$directory_theme  = get_template_directory() . '/aheto/';

		if ( count( $aheto_all_layouts ) > 1 ) {

			$aheto_all_layouts = array_keys( $aheto_all_layouts );

			foreach ( $this->get_elements() as $id => $data ) {

				$block_layout = Helper::get_settings( 'general.block_' . $id . '_sets' );


				if ( false !== $block_layout ) {

					$disable_layouts              = $aheto_all_layouts;
					$disable_layouts              = \array_diff( $disable_layouts, $block_layout );
					$disable_layouts_array[ $id ] = $disable_layouts;
				}
			}

			$current_options = array();

			foreach ( $disable_layouts_array as $key => $disable_layout ) {

				if ( $key === 'button' ) {
					continue;
				}
				$prefix_layouts  = array();
				$plugin_layouts = is_dir($directory_plugin . $key ) ? scandir( $directory_plugin . $key ) : array();
				$addon_layouts = is_dir($directory_addon . $key . '/controllers') ? scandir( $directory_addon . $key . '/controllers' ) : array();
				$theme_layouts = is_dir($directory_theme . $key ) ? scandir( $directory_theme . $key ) : array();

				$addon_layouts = array_diff( $addon_layouts, [ '.', '..' ] );
				$plugin_layouts = array_diff( $plugin_layouts, [ '.', '..' ] );
				$theme_layouts = array_diff( $theme_layouts, [ '.', '..' ] );

				if ( count( $addon_layouts ) === 0 && count( $plugin_layouts ) === 0 && count( $theme_layouts ) === 0) {
					continue;
				}

				foreach ( $disable_layout as $prefix ) {

					$prefix = $prefix === 'default' ? 'layout' : $prefix . '_';

					$filtered_layouts_addon = count( $addon_layouts ) !== 0 ? preg_grep( "/^$prefix.*$/", $addon_layouts ) : array();
					$filtered_layouts_plugin = count( $plugin_layouts ) !== 0 ? preg_grep( "/^$prefix.*$/", $plugin_layouts ) : array();
					$filtered_layouts_theme = count( $theme_layouts ) !== 0 ? preg_grep( "/^$prefix.*$/", $theme_layouts ) : array();

					$filtered_layouts = array_merge( $filtered_layouts_addon, $filtered_layouts_plugin, $filtered_layouts_theme );

					if ( count( $filtered_layouts ) !== 0 ) {
						$prefix_layouts = array_merge( $prefix_layouts, $filtered_layouts );
					}

				}

				foreach ( $prefix_layouts as $key_layout => $layout ) {
					$prefix_layouts[ $key_layout ] = str_replace( '.php', '', $layout );
				}

				$current_options[ 'aheto_' . $key ] = $prefix_layouts;
			}
		}




		return $current_options;
	}

	/**
	 * Load shortcodes
	 */
	public function load() {
		foreach ( $this->get_elements() as $id => $data ) {

			if ( false === $this->can_load_block( $id, $data ) ) {
				continue;
			}

			$data = new $data['class'];
			$data->setup();

		}
	}

	/**
	 * Load shortcodes
	 */
	public function load_elementor() {
		foreach ( $this->get_elements() as $id => $data ) {

			if ( false === $this->can_load_block( $id, $data ) ) {
				continue;
			}

			\Elementor\Plugin::instance()->widgets_manager->register( new $data['class'] );
		}
	}

	/**
	 * Can load block.
	 *
	 * @param string $block_id Block id.
	 * @param array $data Block data.
	 *
	 * @return bool
	 */
	private function can_load_block( $block_id, $data ) {
		if (
			false === Helper::get_settings( 'general.block_' . $block_id, true ) ||
			isset( $this->loaded[ $block_id ] )
		) {
			return false;
		}

		if ( isset( $data['post_type'] ) && ( is_admin() || Helper::is_ajax() ) && ! in_array( Helper::get_post_type(), $data['post_type'] ) ) {
			return false;
		}

		$this->loaded[ $block_id ] = true;

		return true;
	}

	/**
	 * Get elements to register
	 *
	 * @return array
	 */
	public function get_elements() {

		$data = [
			'banner-slider'     => [
				'title' => __( '<i class="fas fa-images"></i> <span>Banner Slider</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Banner_Slider',
			],
			'blockquote'        => [
				'title' => __( '<i class="fas fa-quote-right"></i> <span>Blockquote</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Blockquote',
			],
			'button'            => [
				'title' => __( '<i class="fas fa-square "></i> <span>Button</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Button',
			],
			'call-to-action'    => [
				'title' => __( '<i class="fas fa-paper-plane"></i> <span>Call To Action</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Call_To_Action',
			],
			'clients'           => [
				'title' => __( '<i class="fas fa-user-friends"></i> <span>Clients</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Clients',
			],
			'coming-soon'       => [
				'title' => __( '<i class="fas fa-hourglass-half"></i> <span>Coming Soon</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Coming_Soon',
			],
			'contents'          => [
				'title' => __( '<i class="fas fa-window-restore"></i> <span>Contents</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Contents',
			],
			'contacts'          => [
				'title' => __( '<i class="fas fa-phone-square"></i> <span>Contacts</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Contacts',
			],
			'contact-info'      => [
				'title' => __( '<i class="fas fa-envelope-open"></i> <span>Contact Info</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Contact_Info',
			],
			'features-single'   => [
				'title' => __( '<i class="fas fa-window-maximize"></i> <span>Features Single</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Features_Single',
			],
			'features-tabs'     => [
				'title' => __( '<i class="fas fa-table"></i> <span>Features Tabs</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Features_Tabs',
			],
			'features-slider'   => [
				'title' => __( '<i class="fas fa-window-restore "></i> <span>Features Slider</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Features_Slider',
			],
			'features-timeline' => [
				'title' => __( '<i class="fas fa-user-graduate"></i> <span>Features Timeline</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Features_Timeline',
			],
			'google-map'        => [
				'title' => __( '<i class="fas fa-map-marker-alt"></i> <span>Google Map</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Google_Map',
			],
			'heading'           => [
				'title' => __( '<i class="fas fa-heading"></i> <span>Heading</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Heading',
			],
			'instagram'         => [
				'title' => __( '<i class="fab fa-instagram"></i> <span></span>Instagram</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Instagram',
			],
			'twitter'           => [
				'title' => __( '<i class="fab fa-twitter"></i> <span>Twitter</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Twitter',
			],
			'custom-post-types' => [
				'title' => __( '<i class="fas fa-newspaper"></i> <span>Custom Post Types</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\CustomPostTypes',
			],
			'lists'             => [
				'title' => __( '<i class="fas fa-list-ol"></i> <span>Lists</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Lists',
			],
			'media'             => [
				'title' => __( '<i class="fas fa-play-circle"></i> <span>Media</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Media',
			],
			'navigation'        => [
				'title' => __( '<i class="fas fa-bars"></i> <span>Navigation</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Navigation',
			],
			'portfolio-nav'     => [
				'title' => __( '<i class="fas fa-file-image"></i> <span>Portfolio Nav</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Portfolio_Nav',
			],
			'pricing-tables'    => [
				'title' => __( '<i class="fas fa-money-check-alt"></i> <span>Pricing Tables</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Pricing_Tables',
			],
			'progress-bar'      => [
				'title' => __( '<i class="fas fa-tasks"></i> <span>Progress Bar</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Progress_Bar',
			],
			'recent-posts'      => [
				'title' => __( '<i class="fas fa-newspaper"></i> <span>Recent Posts</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Recent_Posts',
			],
			'social-networks'   => [
				'title' => __( '<i class="fas fa-share-alt"></i> <span>Social Networks</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Social_Networks',
			],
			'team'              => [
				'title' => __( '<i class="fas fa-users"></i> <span>Team</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Team',
			],
			'team-member'       => [
				'title' => __( '<i class="fas fa-user"></i> <span>Team Member</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Team_Member',
			],
			'testimonials'      => [
				'title' => __( '<i class="fas fa-comment-alt"></i> <span>Testimonials</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Testimonials',
			],
			'title-bar'         => [
				'title' => __( '<i class="fas fa-indent"></i> <span>Title Bar</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Title_Bar',
			],
			'time-schedule'     => [
				'title' => __( '<i class="fas fa-calendar-alt"></i> <span>Time Schedule</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Time_Schedule',
			],
			'contact-forms'     => [
				'title' => __( '<i class="fas fa-id-card"></i> <span>Contact Forms</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Contact_Forms',
			],
			'navbar'            => [
				'title' => __( '<i class="fas fa-info"></i> <span>Navbar</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\Navbar',
			],
			'video-btn'         => [
				'title' => __( '<i class="fas fa-play-circle"></i> <span>Video Button</span>', 'aheto' ),
				'class' => '\\Aheto\\Shortcodes\\VideoButton',
			],
		];

		$data_shortcodes = apply_filters( 'aheto_shortcodes_data', $data );


		return $this->do_filter(
			'register_elements',
			$data_shortcodes
		);
	}
}
