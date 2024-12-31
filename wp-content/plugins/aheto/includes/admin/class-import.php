<?php
/**
 * The importer
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Aheto\Helper;
use Aheto\Traits\Ajax;
use Aheto\Template_Kit\API;

defined( 'ABSPATH' ) || exit;

/**
 * Import class.
 */
global $page_slug;

class Import {

	use Ajax;

	/**
	 * The Constructor
	 */
	public function __construct() {
		$this->ajax( 'import_page', 	 'import_page' );
		$this->ajax( 'import_template',  'import_template' );
		$this->ajax( 'import_skin',      'import_skin' );
		$this->ajax( 'import_header',    'import_header_footer' );
	}

	/**
	 * Import page.
	 */
	public function import_page() {
		$this->verify_nonce( 'aheto_ajax_page_importer' );
		$template_id = !empty( $_POST['templateID'] ) ? $_POST['templateID'] : 0;
		$page_title  = !empty( $_POST['pageTitle'] )  ? $_POST['pageTitle']  : '';

		$builder     = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		$template    = API::get()->get_template_by_id( $template_id, $builder );

		if ( false === $template ) {
			$this->error( 'Something went wrong.' );
		}

		if ( empty( $page_title ) ) {
			$this->error( 'Empty page name.' );
		}

		if ( 'elementor' === $builder ) {
			$elementor = new \Aheto\Elementor\Importer;
			$page_id   = $elementor->creating_page(  $page_title, 'page' );
//			$page_id   = $elementor->import_template( $template, $page_title, 'page' ); //- old version

			if ( is_wp_error( $page_id ) ) {
				$this->error( $page_id->get_error_messages() );
			}

			update_option( 'created_importing_page', $page_id );
			$this->success( 'Successfully created.' );
		}
	}

	/**
	 * Import page into library.
	 */
	public function import_skin() {
		$this->verify_nonce( 'aheto_ajax_skin_importer' );

		$template_id = !empty( $_POST['templateID'] ) ? $_POST['templateID'] : 0;
		$page_title  = !empty( $_POST['pageTitle'] )  ? $_POST['pageTitle']  : '';
		$page_slug   = !empty( $_POST['slugId'] )     ? $_POST['slugId']     : '';

		$builder     = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		$template    = API::get()->get_skin_by_id( $template_id );

		if ( empty( $template->title ) && empty( $template->content ) ) {
			$this->error( 'Something wrong with template.' );
		}

		if ( 'elementor' === $builder ) {
			$elementor = new \Aheto\Elementor\Importer;
			$response  = $elementor->import_skin( $template );

			if ( !$response['status'] ) {
				$this->error( $response['message'] );
			}

			$this->success( $response['message'] );
		}
	}

	/**
	 * Import header/footer template.
	 */
	public function import_header_footer() {
		$this->verify_nonce( 'aheto_ajax_header_footer_importer' );

		$template_id = !empty( $_POST['templateID'] ) ? $_POST['templateID'] : 0;
		$page_title  = !empty( $_POST['pageTitle'] )  ? $_POST['pageTitle']  : '';
		$page_slug   = !empty( $_POST['slugId'] )     ? $_POST['slugId'] 	 : '';

		$builder     = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		$template    = API::get()->get_header_footer_by_id( $template_id );

		if ( empty( $template->title ) && empty( $template->content ) ) {
			$this->error( 'Something wrong with template.' );
		}

		$type 	  = $template->cpt_type;
		$cpt_type = '';
		if ( $type == 'headers' ) {
			$cpt_type = 'headers';
		}
		elseif ( $type == 'footers' ) {
			$cpt_type = 'footers';
		}

		if ( 'elementor' === $builder ) {
			$elementor = new \Aheto\Elementor\Importer;
			$response  = $elementor->import_header_footer_json( $template, $cpt_type );

			if ( !$response['success'] ) {
				$this->error( $response['message'] );
			}

			$this->success( 'Successfully imported.' );
		}
	}

	/**
	 * Import page into library.
	 */
	public function import_template() {
		$this->verify_nonce( 'aheto_ajax_page_importer' );

		$template_id = !empty( $_POST['templateID'] ) ? $_POST['templateID'] : 0;
		$page_title  = 'PostTitle';
		$page_slug	 = !empty( $_POST['slugId'] ) ? $_POST['slugId'] : '';

		$builder     = Helper::get_settings( 'general.builder' ) ? Helper::get_settings( 'general.builder' ) : 'elementor';
		$template    = API::get()->get_template_by_id( $template_id, $builder );


		if ( false === $template[0] ) {
			$this->error( 'Something wrong with template.' );
		}

		$page_id  = get_option( 'created_importing_page' );

		if ( empty( $page_id) ) {
			$this->error( 'You should create page before importing.' );
		}

		if ( 'elementor' === $builder ) {
			$elementor = new \Aheto\Elementor\Importer;

			$page      = $elementor->import_template_page( $template, $page_id, 'page', false );

			if ( !$page['success'] ) {
				$this->error( $page['error'] );
			}

			$this->success( 'Successfully imported.' );
		}
	}

}
