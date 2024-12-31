<?php


class Header_Footer_Generator
{

    private $error = null;

    private $storage;

    public function __construct() {

        $this->storage = new stdClass();

        // todo will be changed after implementation API
        $this->storage->header = [
            'content' => '[vc_row][vc_column][vc_wp_custommenu nav_menu="' . $this->get_active_menu() . '"][/vc_column][/vc_row]',
            'header_css_classes' => 'test-class'
        ];
        $this->storage->footer = [
            'content' => '[vc_row][vc_column][vc_column_text border_heading="" box_heading=""]<p style="text-align: center;">Developed with love by Aheto</p>[/vc_column_text][/vc_column][/vc_row]',
            'footer_css_classes' => 'test-class',
            'footer_text_color' => '#81d742',
            'footer_link_color' => '#d36130',
            'footer_padding' => 'a:5:{s:3:"top";s:2:"10";s:5:"right";s:2:"10";s:6:"bottom";s:2:"10";s:4:"left";s:2:"10";s:5:"units";s:2:"px";}',
            'footer_background' => 'a:6:{s:5:"color";s:7:"#424242";s:8:"position";s:8:"left top";s:6:"repeat";s:6:"repeat";s:10:"attachment";s:6:"scroll";s:4:"size";s:2:"10";s:5:"image";s:0:"";}'
        ];

        $this->verify_nonce();
    }

    /**
     * create header post
     */
    public function header_create() {

        if ( $this->error ) return;

        $title = ( ! empty( $_POST['header-name'] ) ) ? sanitize_text_field( $_POST['header-name'] ) : 'Test header';

        $id = wp_insert_post( array(
            'post_title' => $title,
            'post_type'    => 'aheto-header',
            'post_status'  => 'publish',
            'post_content' => $this->get_header_from_storage( 'content' )
        ) );

        if ( ! empty( $id ) && ! is_wp_error( $id ) ) {
            update_post_meta($id, 'aheto_header_css_classes', $this->get_header_from_storage('header_css_classes'));
        }
    }

    /**
     * create footer post
     */
    public function footer_create() {

        if ( $this->error ) return;

        $title = ( ! empty( $_POST['footer-name'] ) ) ? sanitize_text_field( $_POST['header-name'] ) : 'Test footer';

        $id = wp_insert_post( array(
            'post_title' => $title,
            'post_type'    => 'aheto-footer',
            'post_status'  => 'publish',
            'post_content' => $this->get_footer_from_storage( 'content' )
        ) );

        if ( ! empty( $id ) && ! is_wp_error( $id ) ) {
            update_post_meta( $id, 'aheto_footer_css_classes', $this->get_footer_from_storage( 'footer_css_classes' ) );
            update_post_meta( $id, 'aheto_footer_text_color', $this->get_footer_from_storage( 'footer_text_color' ) );
            update_post_meta( $id, 'aheto_footer_link_color', $this->get_footer_from_storage( 'footer_link_color' ) );
            update_post_meta( $id, 'aheto_footer_padding', $this->get_footer_from_storage( 'footer_padding', true ) );
            update_post_meta( $id, 'aheto_footer_background', $this->get_footer_from_storage( 'footer_background', true ) );
        }
    }

    /**
     * get from storag
     *
     * @param $id
     * @return string
     */
    private function get_header_from_storage( $id ) {
        return ( isset( $this->storage->header[ $id ] ) ) ? $this->storage->header[ $id ] : '';
    }

    /**
     * get from storag
     *
     * @param $id
     * @param bool $unserialize
     * @return mixed|string
     */
    private function get_footer_from_storage( $id, $unserialize = false ) {
        $data = ( isset( $this->storage->footer[ $id ] ) ) ? $this->storage->footer[ $id ] : '';
        return $unserialize ? unserialize( $data ) : $data;
    }

    /**
     * get active menu in wordpress
     *
     * @return int
     */
    public function get_active_menu() {
        return absint( get_user_option( 'nav_menu_recently_edited' ) );
    }

    /**
     * verify nonce
     *
     * @return bool
     */
    private function verify_nonce() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'aheto-setup' ) ) {
            $this->set_error( __( 'Error: Nonce verification failed', 'aheto' ) );

            return false;
        }

        return true;
    }

    /**
     * set error
     *
     * @param $error
     */
    public function set_error( $error ) {
        $this->error = $error;
    }

    /**
     * set error
     *
     * @return null
     */
    public function get_error() {
        return $this->error;
    }
}