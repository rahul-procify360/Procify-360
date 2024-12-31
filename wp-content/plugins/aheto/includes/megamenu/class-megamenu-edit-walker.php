<?php
/**
 * The Mega-Menu editor walker functionality
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Admin;

use Walker_Nav_Menu_Edit;

defined( 'ABSPATH' ) || exit;

/**
 * Megamenu_Edit_Walker class.
 */
class Megamenu_Edit_Walker extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 *
	 * We're injecting our custom fields after the div.submitbox
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Nav menu ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args, $id );
		$output .= preg_replace(
			// NOTE: Check this regex from time to time!
			'/(?=<(fieldset|p)[^>]+class="[^"]*field-move)/',
			$this->get_fields( $item, $depth, $args ),
			$item_output
		);
	}

	/**
	 * Get custom fields
	 *
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Menu item args.
	 *
	 * @return string Form fields
	 */
	protected function get_fields( $item, $depth, $args = [] ) {
		$item_id = esc_attr( $item->ID );

		$item_icon = $item->icon == 0 ? '' : $item->icon;

		ob_start(); ?>

		<p class="field-icon description description-wide">
			<label for="edit-menu-item-icon-<?php echo $item_id; ?>">
				<?php _e( 'Font Awesome Icon <code>example: fa fa-chevron-right</code>', 'aheto' ); ?>
				<br/>
				<input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item_icon ); ?>" />
			</label>
		</p>

		<?php if($depth === 0){ ?>
			<p class="field-is-megamenu description">
				<label for="edit-menu-item-megamenu-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-megamenu-<?php echo $item_id; ?>" value="<?php echo $item_id; ?>" name="menu-item-megamenu[<?php echo $item_id; ?>]"<?php checked( $item->is_megamenu, true ); ?> />
					<?php _e( 'Is Mega Menu Parent?', 'aheto' ); ?>
				</label>
			</p>

			<p class="field-is-image description">
				<label for="edit-menu-item-image-<?php echo $item_id; ?>">
					<input type="checkbox" id="edit-menu-item-image-<?php echo $item_id; ?>" value="<?php echo $item_id; ?>" name="menu-item-image[<?php echo $item_id; ?>]" <?php checked( $item->is_image, true ); ?> />
					<?php _e( 'Show Preview images in Mega Menu childrens?', 'aheto' ); ?>
				</label>
			</p>
		<?php }

		return ob_get_clean();
	}
}
