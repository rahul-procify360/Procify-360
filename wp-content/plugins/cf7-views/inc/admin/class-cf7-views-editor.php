<?php

class CF7_Views_Editor {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'register_sub_menu' ), 8 );
	}
	function register_sub_menu() {

		add_submenu_page( 'custom-settings', 'Edit View', 'Edit View', 'manage_options', 'cf7-views', array( &$this, 'views_editor' ) );
	}

	function views_editor() {
		// echo 'here'; die;
		$post_id = (int) $_GET['view_id'];
		if ( class_exists( 'WPCF7_ContactForm' ) && class_exists( 'Flamingo_Inbound_Message' ) ) {
			$forms = WPCF7_ContactForm::find();

			$view_forms = array(
				array(
					'id'    => '',
					'label' => 'Select',
				),
			);
			if ( ! empty( $forms ) ) {
				foreach ( $forms as $form ) {
					$view_forms[] = array(
						'id'    => $form->name(),
						'label' => $form->title(),
					);
				}
			}
			// delete_post_meta($post->ID, 'view_settings');
			$cf7_view_saved_settings = get_post_meta( $post_id, 'view_settings', true );
			if ( empty( $cf7_view_saved_settings ) ) {
				$cf7_view_saved_settings = '{}';
				$form_id                 = '';
				if ( ! empty( $view_forms[1]['id'] ) ) {
					$form_id = $view_forms[1]['id'];
				}
			} else {
				$view_settings = json_decode( html_entity_decode( $cf7_view_saved_settings ) );
				$form_id       = $view_settings->formId;
			}
			$form_fields      = cf7_views_get_form_fields( $form_id );
			$cf7_views_config = apply_filters(
				'cf7_views_config',
				array(
					'prefix' => 'cf7',
					'isPro'  => false,
					'addons' => array( '' ),
					'nonce'  => wp_create_nonce( 'cf7-views-builder' ),
				)
			);

			?>
				<script>
					var view_forms = '<?php echo addslashes( json_encode( $view_forms ) ); ?>';
					var _view_id = '<?php echo $post_id; ?>';
					var _view_title = '<?php echo addslashes( get_the_title( $post_id ) ); ?>';
					var _view_saved_settings = '<?php echo addslashes( $cf7_view_saved_settings ); ?>';
					var _view_form_fields =  '<?php echo addslashes( $form_fields ); ?>';
					var _view_config =  '<?php echo addslashes( json_encode( $cf7_views_config ) ); ?>';
					var cf7_views_active_addons = [];
				</script>
			<?php do_action( 'before_cf7_views_builder' ); ?>
				   <div id="views-container"></div>
			<?php do_action( 'after_cf7_views_builder' ); ?>
			<?php
		} else {
			echo sprintf(
				wp_kses(
					__( 'Please install %1$s Contact Form 7 %2$s & %3$s Flamingo %4$s to use CF7 Views', 'cf7-views' ),
					array(
						'a' => array(
							'href'  => array(),
							'title' => array(),
						),
					)
				),
				'<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/contact-form-7/' ) . '">',
				'</a>',
				'<a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/flamingo/' ) . '">',
				'</a>'
			);
		}

		?>
			<script>

			(function($){
				$(function(){
				$('#menu-dashboard').removeClass('wp-has-current-submenu','wp-menu-open menu-top');
					$('#menu-posts-cf7-views').removeClass('wp-not-current-submenu');
					$('#menu-posts-cf7-views').addClass('wp-has-current-submenu','wp-menu-open menu-top');
				})

			})(jQuery)
			</script>

		<?php
	}



}

new CF7_Views_Editor();
