<?php
/**
 * The Mega-Menu Nav walker functionality
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Walker_Nav_Menu;

defined( 'ABSPATH' ) || exit;

/**
 * Megamenu_Nav_Walker class.
 */
class Megamenu_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Is megamenu item.
	 *
	 * @var bool
	 */
	public $is_megamenu = false;
	public $is_image = false;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Tag.
		$tag = 'ul';

		// Default class.
		$classes = array( 'sub-menu' );
		if ( $this->is_megamenu && 0 === $depth ) {
			$tag       = 'div';
			$classes[] = 'mega-menu';
			if(isset($this->is_image) && $this->is_image){
				$classes[] = 'main-header__pages-list';
			}
		}

		if ( $this->is_megamenu && 1 === $depth ) {
			$classes = [ 'mega-menu__list' ];
		}

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<{$tag}{$class_names}>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		$tag = $this->is_megamenu && 0 === $depth ? 'div' : 'ul';

		$output .= "$indent</{$tag}>{$n}";
	}

	/**
	 * Start the element output.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Menu item args.
	 * @param int    $id     Nav menu ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$icon            = '';
		$old_link_before = '';
		if ( $item->icon ) {
			$old_link_before   = $args->link_before;
			$args->link_before = '<i class="' . $item->icon . '"></i> ' . $args->link_before;
		}

		// Megamenu Column Title.
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		if ( $this->is_megamenu && 1 === $depth ) {
			$output .= '<div class="mega-menu__col"><div class="mega-menu__title">' . $title . '</div>';
			return;
		}

		// Megamenu Column Content.
		if ( $this->is_megamenu && $depth >= 2 && ! empty( $item->description ) ) {
			$output .= '<div class="mega-menu__col">' . do_shortcode( $item->description );
			return;
		}

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args, $id );

		if ( 0 === $depth ) {
			$this->is_megamenu = $item->is_megamenu;
			$this->is_image = $item->is_image;
		}

		if ( $item->is_megamenu ) {
			$item_output = str_replace( 'class="', 'class="menu-item--mega-menu ', $item_output );
		}

		if ( $item->is_megamenu && 0 === $depth && isset($this->is_image) && $this->is_image ) {
			$item_output = str_replace( 'class="', 'class="main-header__pages-list-wrap ', $item_output );
		}

		if ( $item->icon ) {
			$args->link_before = $old_link_before;
		}

		if ( $this->is_megamenu && 2 === $depth && isset($this->is_image) && $this->is_image ) {
			$image_url = !empty($item->object_id) ? get_the_post_thumbnail_url($item->object_id, 'full') : '';

			if(!empty($image_url)){
				$item_output = str_replace( '</a>', '<span class="main-header__pages-list-image" style="background-image:url('. $image_url .')"></span></a>', $item_output );
			}
		}

		$output .= $item_output;
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$tag = $this->is_megamenu && 1 === $depth ? 'div' : 'li';

		$output .= "</{$tag}>{$n}";
	}
}
