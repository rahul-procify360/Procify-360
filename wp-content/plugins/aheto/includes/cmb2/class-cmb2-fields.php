<?php
/**
 * The CMB2 fields for the plugin.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\CMB2
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CMB2;

use Aheto\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * CMB2_Fields class.
 */
class CMB2_Fields {

	use Hooker;
	use Helpers;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		$this->action( 'cmb2_render_notice', 'render_notice' );
		$this->action( 'cmb2_render_switch', 'render_switch', 10, 5 );
		$this->action( 'cmb2_render_background', 'render_background', 10, 5 );
		$this->action( 'cmb2_render_image_select', 'render_image_select', 10, 5 );
		$this->action( 'cmb2_render_search_select', 'render_search_select', 10, 5 );

		// Classes.
		$this->filter( 'cmb2_render_class_border', 'render_by_class' );
		$this->filter( 'cmb2_render_class_spacing', 'render_by_class' );
		$this->filter( 'cmb2_render_class_box_shadow', 'render_by_class' );
		$this->filter( 'cmb2_render_class_typography', 'render_by_class' );
	}

	/**
	 * Return types class name.
	 *
	 * @return string
	 */
	public function render_by_class() {
		$hash = [
			'border'     => '\\Aheto\CMB2\\Border',
			'spacing'    => '\\Aheto\CMB2\\Spacing',
			'box_shadow' => '\\Aheto\CMB2\\Box_Shadow',
			'typography' => '\\Aheto\CMB2\\Typography',
		];

		$current = \str_replace( 'cmb2_render_class_', '', current_filter() );
		return $hash[ $current ];
	}

	/**
	 * Render notice field.
	 *
	 * @param array $field The passed in CMB2_Field object.
	 */
	public function render_notice( $field ) {
		$hash = [
			'error'   => 'notice notice-alt notice-error error inline',
			'info'    => 'notice notice-alt notice-info info inline',
			'warning' => 'notice notice-alt notice-warning warning inline',
		];

		echo '<div class="' . $hash[ $field->args( 'what' ) ] . '"><p>' . $field->args( 'content' ) . '</p></div>';
	}

	/**
	 * Render switch field.
	 *
	 * @param array  $field             The passed in CMB2_Field object.
	 * @param mixed  $escaped_value     The value of this field escaped.
	 *                                  It defaults to sanitize_text_field`
	 *                                  If you need the unescaped value, you can access it
	 *                                  via $field->value().
	 * @param int    $object_id         The ID of the current object.
	 * @param string $object_type       The type of object you are working with.
	 *                                  Most commonly, `post` (this applies to all post-types),
	 *                                  but could also be `comment`, `user` or `options-page`.
	 * @param object $field_type_object This `CMB2_Types` object.
	 */
	public function render_switch( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$field->args['options'] = [
			'off' => esc_html( $field->get_string( 'off', __( 'Off', 'aheto' ) ) ),
			'on'  => esc_html( $field->get_string( 'on', __( 'On', 'aheto' ) ) ),
		];
		$field->set_options();

		echo $field_type_object->radio_inline([
			'id'   => $field_type_object->_id(),
			'name' => $field_type_object->_name(),
		]);
	}




	/**
	 * Render background field.
	 *
	 * @param array  $field             The passed in CMB2_Field object.
	 * @param mixed  $escaped_value     The value of this field escaped.
	 *                                  It defaults to sanitize_text_field`
	 *                                  If you need the unescaped value, you can access it
	 *                                  via $field->value().
	 * @param int    $object_id         The ID of the current object.
	 * @param string $object_type       The type of object you are working with.
	 *                                  Most commonly, `post` (this applies to all post-types),
	 *                                  but could also be `comment`, `user` or `options-page`.
	 * @param object $field_type_object This `CMB2_Types` object.
	 */
	public function render_background( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		$value = wp_parse_args( $escaped_value, [
			'color'      => '',
			'image'      => '',
			'position'   => '',
			'size'       => '',
			'repeat'     => '',
			'attachment' => '',
		]);

		$this->render_grid( 'start' );

		// Color.
		$this->render_label( esc_html__( 'Color', 'aheto' ), $field_type_object->_id( '_color' ) );
		echo $field_type_object->colorpicker([
			'id'   => $field_type_object->_id( '_color' ),
			'name' => $field_type_object->_name( '[color]' ),
			'desc' => '',
		], $value['color'] );

		$this->render_grid( 'start' );

		// Position.
		$this->render_label( esc_html__( 'Position', 'aheto' ), $field_type_object->_id( '_position' ) );
		echo $field_type_object->select([
			'id'      => $field_type_object->_id( '_position' ),
			'name'    => $field_type_object->_name( '[position]' ),
			'desc'    => '',
			'options' => $this->select_options(
				[
					'off'           => esc_html__( 'None', 'aheto' ),
					'left top'      => esc_html__( 'Left Top', 'aheto' ),
					'left center'   => esc_html__( 'Left Center', 'aheto' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'aheto' ),
					'right top'     => esc_html__( 'Right Top', 'aheto' ),
					'right center'  => esc_html__( 'Right Center', 'aheto' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'aheto' ),
					'center top'    => esc_html__( 'Center Top', 'aheto' ),
					'center center' => esc_html__( 'Center Center', 'aheto' ),
					'center bottom' => esc_html__( 'Center Bottom', 'aheto' ),
				],
				$value['position']
			),
		]);

		// Repeat.
		$this->render_grid();
		$this->render_label( esc_html__( 'Repeat', 'aheto' ), $field_type_object->_id( '_repeat' ) );
		echo $field_type_object->select([
			'id'      => $field_type_object->_id( '_repeat' ),
			'name'    => $field_type_object->_name( '[repeat]' ),
			'desc'    => '',
			'options' => $this->select_options(
				[
					'off'      => esc_html__( 'None', 'aheto' ),
					'repeat'   => esc_html__( 'Repeat', 'aheto' ),
					'repeat-x' => esc_html__( 'Repeat-X', 'aheto' ),
					'repeat-y' => esc_html__( 'Repeat-Y', 'aheto' ),
					'space'    => esc_html__( 'Space', 'aheto' ),
					'round'    => esc_html__( 'Round', 'aheto' ),
				],
				$value['repeat']
			),
		]);
		$this->render_grid( 'end' );

		$this->render_grid( 'start' );

		// Attachment.
		$this->render_label( esc_html__( 'Attachment', 'aheto' ), $field_type_object->_id( '_attachment' ) );
		echo $field_type_object->select([
			'id'      => $field_type_object->_id( '_attachment' ),
			'name'    => $field_type_object->_name( '[attachment]' ),
			'desc'    => '',
			'options' => $this->select_options(
				[
					'off'    => esc_html__( 'None', 'aheto' ),
					'scroll' => esc_html__( 'Scroll', 'aheto' ),
					'fixed'  => esc_html__( 'Fixed', 'aheto' ),
					'local'  => esc_html__( 'Local', 'aheto' ),
				],
				$value['attachment']
			),
		]);

		$this->render_grid();

		// Size.
		$this->render_label( esc_html__( 'Size', 'aheto' ), $field_type_object->_id( '_size' ) );
		echo $field_type_object->input([
			'id'          => $field_type_object->_id( '_size' ),
			'name'        => $field_type_object->_name( '[size]' ),
			'desc'        => '',
			'value'       => $value['size'],
			'placeholder' => esc_html__( 'auto, length, cover, contain', 'aheto' ),
		]);

		$this->render_grid( 'end' );

		$this->render_grid();

		// Image.
		$field->args['options']      = [ 'url' => false ];
		$field->args['preview_size'] = 'thumbnail';
		$field->args['query_args']   = [
			'type' => [
				'image/gif',
				'image/jpeg',
				'image/png',
			],
		];
		$field->set_options();

		$this->render_label( esc_html__( 'Image', 'aheto' ), $field_type_object->_id( '_image' ) );
		echo $field_type_object->file([
			'id'    => $field_type_object->_id( '_image' ),
			'name'  => $field_type_object->_name( '[image]' ),
			'desc'  => '',
			'value' => $value['image'],
		]);

		$this->render_grid( 'end' );
	}



	/**
	 * Render Image select field for post types.
	 *
	 * @param array  $field             The passed in CMB2_Field object.
	 * @param mixed  $escaped_value     The value of this field escaped.
	 *                                  It defaults to sanitize_text_field`
	 *                                  If you need the unescaped value, you can access it
	 *                                  via $field->value().
	 * @param int    $object_id         The ID of the current object.
	 * @param string $object_type       The type of object you are working with.
	 *                                  Most commonly, `post` (this applies to all post-types),
	 *                                  but could also be `comment`, `user` or `options-page`.
	 * @param object $field_type_object This `CMB2_Types` object.
	 */
	public function render_image_select( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

//		wp_enqueue_style( 'select2', aheto()->assets() . 'select2/select2.min.css', null, '4.0' );
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', null, '4.0' );
//		wp_enqueue_script( 'select2', aheto()->assets() . 'select2/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_style( 'cmb2-image-select-field', aheto()->assets() . 'admin/css/cmb2-image-select.css', null, aheto()->version );
		wp_enqueue_script( 'cmb2-image-select-field', aheto()->assets() . 'admin/js/cmb2-image-select.js', [ 'jquery' ], aheto()->version, true );

        $value = wp_parse_args( $escaped_value, ['image_select' => ''] );

        echo $field_type_object->select([
            'id'      => $field_type_object->_id( '_image_select' ),
            'name'    => $field_type_object->_name( '[image_select]' ),
            'desc'    => $field_type_object->_desc('_image_select'),
            'options' => $this->select_options(
                $field_type_object->field->args['options'],
                $value['image_select']
            ),
        ]);

//		echo $field_type_object->select([
//			'id'      => $field_type_object->_id( '_image_select' ),
//			'name'    => $field_type_object->_name( '[image_select]' ),
//			'desc'    => '',
//			'options' => $field_type_object->concat_items(),
//		]);
	}


	/**
	 * Render Search select field.
	 *
	 * @param array  $field             The passed in CMB2_Field object.
	 * @param mixed  $escaped_value     The value of this field escaped.
	 *                                  It defaults to sanitize_text_field`
	 *                                  If you need the unescaped value, you can access it
	 *                                  via $field->value().
	 * @param int    $object_id         The ID of the current object.
	 * @param string $object_type       The type of object you are working with.
	 *                                  Most commonly, `post` (this applies to all post-types),
	 *                                  but could also be `comment`, `user` or `options-page`.
	 * @param object $field_type_object This `CMB2_Types` object.
	 */
	public function render_search_select( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {


//		wp_enqueue_style( 'select2', aheto()->assets() . 'select2/select2.min.css', null, '4.0' );
		wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', null, '4.0' );
//		wp_enqueue_script( 'select2', aheto()->assets() . 'select2/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', [ 'jquery' ], '4.0', true );
		wp_enqueue_script( 'cmb2-search-select-field', aheto()->assets() . 'admin/js/cmb2-search-select.js', [ 'jquery' ], aheto()->version, true );

        $value = wp_parse_args( $escaped_value, ['search_select' => ''] );

        echo $field_type_object->select([
            'id'      => $field_type_object->_id( '_search_select' ),
            'name'    => $field_type_object->_name( '[search_select]' ),
            'desc'    => $field_type_object->_desc('_search_select'),
            'options' => $this->select_options(
                $field_type_object->field->args['options'],
                $value['search_select']
            ),
        ]);

//		echo $field_type_object->select([
//			'id'      => $field_type_object->_id( '_search_select' ),
//			'name'    => $field_type_object->_name( '[search_select]' ),
//			'desc'    => '',
//			'options' => $field_type_object->concat_items(),
//		]);
	}
}
