<?php
/**
 * The metabox functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\CMB2;
use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Metaboxes class.
 */
class Metaboxes {

	use CMB2;
	use Hooker;

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->action( 'admin_enqueue_scripts', 'enqueue' );
		$this->action( 'cmb2_admin_init', 'header_metabox' );
		$this->action( 'cmb2_admin_init', 'footer_metabox' );
		$this->action( 'cmb2_admin_init', 'post_metaboxes' );
		$this->action( 'cmb2_admin_init', 'portfolio_metaboxes' );
		$this->action( 'cmb2_admin_init', 'general_metaboxes' );

		$this->directory = aheto()->plugin_dir() . 'includes/metaboxes/';
	}

	/**
	 * Create metabox for header post type
	 */
	public function post_metaboxes() {
		$post_types = 'post';
		$post_types = $this->do_filter( 'metabox_post_types', $post_types );
		$cmb        = new_cmb2_box( [
			'id'           => 'aheto-post-metabox',
			'title'        => aheto()->plugin_name() . esc_html__( ' Post Options', 'aheto' ),
			'object_types' => $post_types,
			'context'      => 'normal',
			'priority'     => 'low',
			'classes_cb'   => [ $this, 'metabox_classes' ],
			'cmb_styles'   => false,
		] );

		foreach ( [ 'layout' ] as $file ) {
			include_once $this->directory . $file . '.php';
		}

		$this->cmb2_pre_init( $cmb );
	}

	/**
	 * Create metabox for header post type
	 */
	public function portfolio_metaboxes() {
		$post_types = 'aheto-portfolio';
		$post_types = $this->do_filter( 'metabox_post_types', $post_types );
		$cmb        = new_cmb2_box( [
			'id'           => 'aheto-portfolio-metabox',
			'title'        => aheto()->plugin_name() . esc_html__( ' Portfolio Options', 'aheto' ),
			'object_types' => $post_types,
			'context'      => 'normal',
			'priority'     => 'low',
			'classes_cb'   => [ $this, 'metabox_classes' ],
			'cmb_styles'   => false,
		] );

		foreach ( [ 'layout-portfolio' ] as $file ) {
			include_once $this->directory . $file . '.php';
		}

		$this->cmb2_pre_init( $cmb );
	}


	/**
	 * Create metabox for header post type
	 */
	public function general_metaboxes() {
		$post_types = get_post_types( [ 'public' => true ] );
		unset( $post_types['aheto-header'], $post_types['aheto-footer'] );
		$post_types = $this->do_filter( 'metabox_post_types', $post_types );
		$cmb        = new_cmb2_box( [
			'id'           => 'aheto-general-metabox',
			'title'        => aheto()->plugin_name() . esc_html__( ' General Options', 'aheto' ),
			'object_types' => $post_types,
			'context'      => 'normal',
			'priority'     => 'high',
			'classes_cb'   => [ $this, 'metabox_classes' ],
			'cmb_styles'   => false,
		] );

		foreach ( [ 'layout-general' ] as $file ) {
			include_once $this->directory . $file . '.php';
		}

		$this->cmb2_pre_init( $cmb );
	}

	/**
	 * Create metabox for header post type
	 */
	public function header_metabox() {
		$cmb = new_cmb2_box( [
			'id'           => 'aheto-header-metabox',
			'title'        => esc_html__( 'Header Options', 'aheto' ),
			'object_types' => 'aheto-header',
			'context'      => 'normal',
			'priority'     => 'high',
			'classes_cb'   => [ $this, 'metabox_classes' ],
			'cmb_styles'   => false,
		] );

		include_once $this->directory . 'header.php';

		$this->cmb2_pre_init( $cmb );
	}

	/**
	 * Create metabox for footer post type
	 */
	public function footer_metabox() {
		$cmb = new_cmb2_box( [
			'id'           => 'aheto-footer-metabox',
			'title'        => esc_html__( 'Footer Options', 'aheto' ),
			'object_types' => 'aheto-footer',
			'context'      => 'normal',
			'priority'     => 'high',
			'classes_cb'   => [ $this, 'metabox_classes' ],
			'cmb_styles'   => false,
		] );

		include_once $this->directory . 'footer.php';

		$this->cmb2_pre_init( $cmb );
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue() {
		$screen = get_current_screen();

		$is_frontent_editor = ( function_exists( 'vc_action' ) && vc_action() == 'vc_inline' );

		if ( ! in_array( $screen->base, [ 'post' ] ) || $is_frontent_editor ) {
			return;
		}

		\CMB2_hookup::enqueue_cmb_css();
		wp_enqueue_style( 'metabox', aheto()->plugin_url() . 'assets/admin/css/metabox.css', [
			'aheto-common',
			'aheto-cmb2'
		], aheto()->version );
		wp_enqueue_script( 'aheto-common' );
	}

	/**
	 * Add custom classes to metabox
	 *
	 * @return array
	 */
	public function metabox_classes() {
		$classes = [ 'aheto-metabox-wrap' ];

		return $classes;
	}
}
