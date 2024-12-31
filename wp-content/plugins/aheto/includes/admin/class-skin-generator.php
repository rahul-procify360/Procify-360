<?php
/**
 * The skin generator.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Dynamic_CSS;
use Aheto\Traits\Hooker;
use Aheto\Admin\Options;

defined( 'ABSPATH' ) || exit;

/**
 * Skin_Generator class.
 */
class Skin_Generator {

	use Hooker;

	/**
	 * Hold option keys.
	 *
	 * @var array
	 */
	private $keys = [];

	/**
	 * Hold option data.
	 *
	 * @var array
	 */
	private $options = null;


	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'admin_init', 'delete_skin', 10 );
		$this->action( 'admin_init', 'clone_skin', 10 );
		$this->action( 'cmb2_admin_init', 'register', 5 );
		$this->action( 'cmb2_save_options-page_fields_aheto-skin-generator_options', 'save_skins', 10, 3 );
		$this->filter( 'cmb2_override_option_get_aheto-skin-generator', 'set_options' );

		$this->action( 'admin_init', 'maybe_redirect', 30 );

		$this->action( 'wp_ajax_change_skin_name', 'change_skin_name' );
	}

	/**
	 * General Settings.
	 */
	public function register() {
		$file = aheto()->plugin_dir() . 'includes/skin/';
		$img = aheto()->assets() . 'admin/img/sidebar-icon/';
		$multiply_skins = Helper::get_settings( 'general.multiply_skins' );

		/**
		 * Allow developers to add new section into skin generator panel.
		 *
		 * @param array $tabs
		 */
		$tabs = $this->do_filter( 'skin_generator_settings', [
			'skins'        => [
				'icon'  => $img . 'skin.png',
				'title' => esc_html__( 'Skins', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the skins options.', 'aheto' ),
				'file'  => $file . 'skins.php',
			],
			'colors'       => [
				'icon'  => $img . 'skin.png',
				'title' => esc_html__( 'Colors', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the colors options.', 'aheto' ),
				'file'  => $file . 'colors.php',
			],
			'typography'     => [
				'icon'  => $img . 'skin.png',
				'title' => esc_html__( 'Typography', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the typography options.', 'aheto' ),
				'file'  => $file . 'typography.php',
			],
			'buttons'      => [
				'icon'  => $img . 'skin.png',
				'title' => esc_html__( 'Buttons', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the buttons options.', 'aheto' ),
				'file'  => $file . 'buttons.php',
			],
			'form'   => [
				'icon'  => $img . 'skin.png',
				'title' => esc_html__( 'Form', 'aheto' ),
				'desc'  => esc_html__( 'This tab contains the oders options.', 'aheto' ),
				'file'  => $file . 'form.php',
			],
//			'oders'   => [
//				'icon'  => $img . 'skin.png',
//				'title' => esc_html__( 'Oddes', 'aheto' ),
//				'desc'  => esc_html__( 'This tab contains the oders options.', 'aheto' ),
//				'file'  => $file . 'oddes.php',
//			],
		]);


		if($multiply_skins){
			unset($tabs['skins']);
		}

		new Options([
			'prefix'     => 'skin',
			'key'        => 'aheto-skin-generator',
			'menu_icon'  => 'ion-ios-color-wand',
			'title'      => esc_html( 'Design', 'aheto' ),
			'menu_title' => esc_html( 'Design', 'aheto' ),
			'tabs'       => $tabs,
		]);
	}

	/**
	 * Check if certain fields got updated.
	 *
	 * @param int   $object_id The ID of the current object.
	 * @param array $updated   Array of field ids that were updated.
	 *                         Will only include field ids that had values change.
	 * @param CMB2  $cmb       This CMB2 object.
	 */
	public function save_skins( $object_id, $updated, $cmb ) {
		$options = cmb2_options( $object_id )->get_options();


		// just fix one bug with old json default skin
		if($_POST['skin_name'] == 'Aheto Default' && $options['skin'] == 'karma'){
			$options['skin'] = 'default';
			self::update_skin_options( 'default', $options );
		}


		// Update skin data if no new skin created.
		if ( ! isset( $_POST['new_skin'] ) || empty( $_POST['new_skin'] ) ) {
			self::update_skin_options( $_POST['skin'], $options );
			return;
		}

		$new_skin     = $_POST['new_skin'];
		$new_skin_key = str_replace( '-', '_', sanitize_title( $new_skin ) );

		$options['skin'] = $new_skin_key;

		self::update_skin_choices( $new_skin_key, $new_skin );
		self::update_skin_options( $new_skin_key, $options );

		// Set new skin selected.
		cmb2_options( $object_id )->update( 'skin', $new_skin_key, true );
	}

	/**
	 * Delete skin.
	 */
	public function delete_skin() {
		if ( ! isset( $_GET['aheto-delete-skin'] ) || empty( $_GET['aheto-delete-skin'] ) ) {
			return;
		}

		$skins   = Helper::skins();
		$skin_id = $_GET['aheto-delete-skin'];
		if ( empty( $skins ) || ! isset( $skins[ $skin_id ] ) ) {
			return;
		}

		unset( $skins[ $skin_id ] );
		Helper::skins( $skins );
		Dynamic_CSS::delete( $skin_id );
		Helper::add_notification( esc_html__( 'Skin successfully deleted.', 'aheto' ) );
		wp_redirect( Helper::get_admin_url( 'skin-generator' ) );
		exit;
	}

	/**
	 * Update skin options and generate dynamic CSS.
	 *
	 * @param string $skin    Skin key.
	 * @param array  $options Skin options.
	 */
	public static function update_skin_options( $skin, $options ) {

		new Dynamic_CSS( $skin, $options );
		update_option( 'aheto_skin_' . $skin, $options );
	}

	/**
	 * Save Skin choices.
	 *
	 * @param string $key   New skin key.
	 * @param string $label New skin label.
	 */
	public static function update_skin_choices( $key, $label ) {
		$skins = Helper::skins();
		if ( empty( $skins ) ) {
			$skins = [];
		}
		$skins[ $key ] = $label;
		Helper::skins( $skins );
	}

	/**
	 * Set option handler for form.
	 *
	 * @param array $opts Array of options.
	 */
	public function set_options( $opts ) {

		if ( ! isset( $_GET['aheto-edit-skin'] ) || empty( $_GET['aheto-edit-skin'] ) ) {

			return $opts;
		}

		return get_option( 'aheto_skin_' . $_GET['aheto-edit-skin'] );
	}

    /**
     * clone skin
     */
	public function clone_skin() {

        if ( ! isset( $_GET['aheto-clone-skin'] ) || empty( $_GET['aheto-clone-skin'] ) ) {
            return;
        }

        $skins   = Helper::skins();
        $skin_id = $_GET['aheto-clone-skin'];
        if ( empty( $skins ) || ! isset( $skins[ $skin_id ] ) ) {
            return;
        }

        $skin_option = Helper::skin( 'skin_' . $skin_id );
        $skin_id     = $this->unique_skin_id( $skin_id, $skins );

        $skin_option['skin'] = $skin_id;
        $new_skin_name       = $this->build_skin_name_by_id( $skin_id );

        self::update_skin_choices( $skin_id, $new_skin_name );
        self::update_skin_options( $skin_id, $skin_option );

        Helper::add_notification( esc_html__( 'Skin successfully cloned.', 'aheto' ) );

		$active_skin = Helper::get_active_skin();
		wp_redirect( Helper::get_admin_url( 'skin-generator', [ 'aheto-edit-skin' => $active_skin ] ) );
		exit;
	}

    /**
     * generate a unique identifier for skin
     *
     * @param $skin_id
     * @param $skins
     * @return string
     */
    private function unique_skin_id( $skin_id, $skins ) {
	    $last = null;
        $main_skin_id = preg_replace('/_clone_.*/', '', $skin_id );

	    foreach ( $skins as $skin_key => $skin ) {
            $search_key = preg_replace('/_clone_.*/', '', $skin_key );
	        if ( $search_key == $main_skin_id ) {
                $last = $skin_key;
            }
        }

        if ( $pos = strpos( $last, 'clone' ) ) {
            $count = substr( $last,  $pos + 6 );
            $count++;
        } else {
            $count = 1;
        }

        return $main_skin_id . '_clone_' . $count;
    }

    /**
     * generates name by skin id
     *
     * @param $skin_id
     * @return mixed
     */
    private function build_skin_name_by_id( $skin_id ) {
        return str_replace( '_', ' ', lcfirst( sanitize_title( $skin_id ) ) );
    }

    /**
     * redirect to active skin
     */
    public function maybe_redirect() {

        $is_page_skin    = isset( $_GET['page'] ) && $_GET['page'] == 'aheto-skin-generator';
        $not_form_action = empty( $_POST ) && count( $_GET ) == 1;
        /**
         * we do redirects when there are none form actions
         */
        if ( $is_page_skin && $not_form_action ) {
            $active_skin = Helper::get_active_skin();

            if ( ! empty( $active_skin ) ) {
                wp_redirect(Helper::get_admin_url('skin-generator', ['aheto-edit-skin' => $active_skin]));

            }
        }
    }

    /**
     * update the skins name
     */
    public function change_skin_name() {
        $class = 'notice-error';
        $skin_id   = ( ! empty( $_POST['skin_id'] ) ) ? sanitize_text_field( $_POST['skin_id'] ) : '';
        $skin_name = ( ! empty( $_POST['skin_name'] ) ) ? sanitize_text_field( $_POST['skin_name'] ) : '';

        $skins = Helper::skins();

        if ( isset( $skins[ $skin_id ] ) ) {
            $old_name      = $skins[ $skin_id ];
            $new_skin_name = ( ! empty( $skin_name ) && $old_name != $skin_name ) ? $skin_name : null;

            if ( $new_skin_name ) {
                self::update_skin_choices( $skin_id, $new_skin_name );
                $msg   = esc_html__( 'Skin name successfully updated.', 'aheto' );
                $class = 'notice-success';
            } else {
                $msg = esc_html__( 'Could not update skin name.', 'aheto' );
            }
        } else {
            $msg = esc_html__( 'Could not update skin name.', 'aheto' );
        }
        $output = '<div class="notice ' . $class . ' aheto-alert"><p>' . $msg . '</p></div>';

        wp_send_json( $output );
    }
}
