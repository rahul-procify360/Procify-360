<?php
/**
 * The CMB2 functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto/Traits
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Traits;

use Aheto\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Hooker class.
 */
trait CMB2 {

	/**
	 * Set field arguments based on type.
	 *
	 * @param CMB2 $cmb CMB2 metabox object.
	 */
	public function cmb2_pre_init( $cmb ) {
		$defaults      = [];
		$save_defaults = ( 'options-page' === $cmb->object_type() ) && empty( get_option( $this->key ) );

		// Loop fields.
		foreach ( $cmb->prop( 'fields' ) as $id => $field_args ) {
			$type  = $field_args['type'];
			$field = $cmb->get_field( $id );

			if ( in_array( $type, [
				'meta_tab_container_open',
				'tab_container_open',
				'tab_container_close',
				'tab_open',
				'tab_close',
				'raw'
			] ) ) {
				$field->args['save_field']    = false;
				$field->args['render_row_cb'] = [ $this, "render_{$type}" ];
			} elseif ( 'notice' === $type ) {
				$field->args['save_field'] = false;
			}

			if ( ! empty( $field_args['dep'] ) ) {
				$this->set_dependencies( $field, $field_args );
			}

			if ( $save_defaults && ( isset( $field_args['default'] ) || isset( $field_args['default_cb'] ) ) ) {
				$defaults[ $id ] = $field->get_default();
			}
		}

		// Save Defaults if any.
		if ( $save_defaults && ! empty( $defaults ) ) {
			add_option( $this->key, $defaults );
		}
	}

	/**
	 * Generate the dependency html for JavaScript.
	 *
	 * @param CMB2_Field $field CMB2 field object.
	 * @param array $args Dependency array.
	 */
	protected function set_dependencies( $field, $args ) {
		if ( ! isset( $args['dep'] ) || empty( $args['dep'] ) ) {
			return;
		}

		$dependency = '';
		$relation   = key( $args['dep'] );

		if ( 'relation' === $relation ) {
			$relation = current( $args['dep'] );
			unset( $args['dep']['relation'] );
		} else {
			$relation = 'OR';
		}
		foreach ( $args['dep'] as $dependence ) {
			$compasrison = isset( $dependence[2] ) ? $dependence[2] : '=';
			$dependency  .= '<span class="hidden" data-field="' . $dependence[0] . '" data-comparison="' . $compasrison . '" data-value="' . $dependence[1] . '"></span>';
		}

		$where                 = 'group' === $args['type'] ? 'after_group' : 'after_field';
		$field->args[ $where ] = '<div class="cmb-dependency hidden" data-relation="' . strtolower( $relation ) . '">' . $dependency . '</div>';
	}

	/**
	 * Render raw field.
	 *
	 * @param  array $field_args Array of field arguments.
	 * @param  CMB2_Field $field The field object.
	 *
	 * @return CMB2_Field
	 */
	public function render_raw( $field_args, $field ) {

		if ( $field->args( 'file' ) ) {
			include $field->args( 'file' );
		} elseif ( $field->args( 'content' ) ) {
			echo $field->args( 'content' );
		}

		return $field;
	}

	/**
	 * Render tab container opening <div> for option panel.
	 *
	 * @param  array $field_args Array of field arguments.
	 * @param  CMB2_Field $field The field object.
	 *
	 * @return CMB2_Field
	 */
	public function render_tab_container_open( $field_args, $field ) {
		$active = ! empty( $_GET['cmb2-setting-tab'] ) ? $_GET['cmb2-setting-tab'] : 'general';

		?>
    <div id="<?php echo $field->prop( 'id' ); ?>" class="cmb2-panel-container">

        <div class="save-settings">
            <div class="options-page-title-wrap">
                <span class="img-box">
                    <img/>
                </span>
                <h4 class="options-page-title"></h4>
            </div>

            <div class="inputs-wrap">
				<?php if ( 'options-page' === $field->object_type() ) : ?>
                    <input type="submit" name="reset-cmb" id="cmb2-reset-cmb" value="Reset "
                           class="custom-btn default">
                    <lable class="custom-btn__icon">
                        <input type="submit" name="submit-cmb" id="submit-cmb" class="custom-btn" value="Save">
                    </lable>
				<?php endif; ?>
            </div>
        </div>
        <div class="cmb2-tabs-navigation wp-clearfix">

			<?php
			foreach ( $field->args( 'tabs' ) as $id => $tab ) :


				if ( empty( $tab ) ) {
					continue;
				}

				if ( isset( $tab['type'] ) && 'seprator' === $tab['type'] ) : ?>
                    <span><?php echo $tab['title']; ?></span>
                <?php else : ?>
                    <a href="#setting-panel-<?php echo $id; ?>"<?php echo isset($tab['icon']) && !empty($tab['icon']) ? 'data-icon="'. $tab['icon'] .'"' : 'hidden'; ?> <?php echo $id === $active ? 'class="active"' : ''; ?>><?php echo $tab['title']; ?></a>
                <?php endif; ?>

			<?php endforeach; ?>
        </div>
        <div class="cmb2-tabs-content">

		<?php

		return $field;
	}

	/**
	 * Render tab container closing <div>.
	 *
	 * @param  array $field_args Array of field arguments.
	 * @param  CMB2_Field $field The field object.
	 *
	 * @return CMB2_Field
	 */
	public function render_tab_container_close( $field_args, $field ) {
		echo '</div><!-- /.cmb2-tab-content-wrapper -->';
		echo '</div><!-- /#' . $field->prop( 'id' ) . ' -->';

		return $field;
	}

	/**
	 * Render tab content opening <div>.
	 *
	 * @param  array $field_args Array of field arguments.
	 * @param  CMB2_Field $field The field object.
	 *
	 * @return CMB2_Field
	 */
	public function render_tab_open( $field_args, $field ) {
		echo '<div id="' . $field->prop( 'id' ) . '" class="cmb2-panel">';

		return $field;
	}

	/**
	 * Render tab content closing <div>.
	 *
	 * @param  array $field_args Array of field arguments.
	 * @param  CMB2_Field $field The field object.
	 *
	 * @return CMB2_Field
	 */
	public function render_tab_close( $field_args, $field ) {
		echo '</div><!-- /#' . $field->prop( 'id' ) . ' -->';

		return $field;
	}

	/**
	 * Handles sanitization for HTML entities.
	 *
	 * @param  mixed $value The unsanitized value from the form.
	 *
	 * @return mixed Sanitized value to be stored.
	 */
	public function sanitize_htmlentities( $value ) {
		return htmlentities( $value );
	}

	/**
	 * Inject config into class
	 *
	 * @param array $config Array of configuration to add into class as variables.
	 */
	public function config( $config = [] ) {

		if ( ! empty( $config ) ) {
			foreach ( $config as $key => $value ) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Is the page is currrent page.
	 *
	 * @return boolean
	 */
	public function is_current_page() {
		$page   = isset( $_REQUEST['page'] ) && ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : false;
		$action = isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) ? $_REQUEST['action'] : false;

		return $page === $this->key || $action === $this->key;
	}
}
