<?php

class CF7_Views_List_Table {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'disable_add_new' ) );
		add_filter( 'views_edit-cf7-views', array( $this, 'cf7_views_list_header' ) );
		add_filter( 'get_edit_post_link', array( $this, 'edit_view_link' ), 100, 2 );
		add_filter( 'post_row_actions', array( $this, 'remove_quick_edit' ), 100, 2 );
	}

	/**
	 * Add Add new button and logo on CF7 views page
	 *
	 * @param [type] $views
	 * @return void
	 */
	public function cf7_views_list_header( $views ) {
		if ( class_exists( 'WPCF7_ContactForm' ) && class_exists( 'Flamingo_Inbound_Message' ) ) {
			$forms      = WPCF7_ContactForm::find();
			$view_forms = array();
			if ( ! empty( $forms ) ) {
				foreach ( $forms as $form ) {
					$view_forms[ $form->name() ] = $form->title();
				}
			}
			?>
		<script>
			var view_forms = '<?php echo addslashes( json_encode( $view_forms ) ); ?>';
		</script>
			<?php
			echo '<div class="cf7-views-header"><img  src="' . CF7_VIEWS_URL . '/assets/images/logo.png" class="cf7-views-logo" alt="logo" >
		<a class=" add_new_cf7_view">Add New</a></div>
	';
		}
		return $views;
	}

	/**
	 * Update Edit View link which dislays on View title hover in View Table
	 *
	 * @param [type] $link
	 * @param [type] $post_id
	 * @return void
	 */
	public function edit_view_link( $link, $post_id ) {
		$post_type = get_post_type( $post_id );

		if ( $post_type === 'cf7-views' ) {
			return admin_url( 'admin.php?page=cf7-views&view_id=' . $post_id );
		}

		return $link;
	}

	/**
	 * Remove Quick Edit Link for CF7 Views
	 *
	 * @param [type] $actions
	 * @param [type] $post
	 * @return void
	 */
	public function remove_quick_edit( $actions, $post ) {
		if ( $post->post_type == 'cf7-views' ) {
			// Remove "Quick Edit"
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	}

	function disable_add_new() {
		// Hide sidebar link
		global $submenu;

		unset( $submenu['edit.php?post_type=cf7-views'][10] );
		// $submenu['edit.php?post_type=cf7-views'][10][2] = 'edit.php?post_type=cf7-views?addnew=true';
	}



}
new CF7_Views_List_Table();
