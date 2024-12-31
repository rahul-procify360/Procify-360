<?php
/**
 * Help page template.
 *
 * @package Aheto
 */

use Aheto\Helper;
?>

<div class="wrap" style="max-width: 1220px">
    <span class="wp-header-end"></span>
</div>

<div class="wrap aheto-wrap limit-wrap main-wrap">

	<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

	<div class="aheto-option-content">

		<div class="aheto-option-header">

			<h4><span class="img-box"><img src="<?php echo esc_attr($img . 'template-kits.png' ); ?>" alt="<?php echo get_admin_page_title(); ?>"/></span><?php echo get_admin_page_title(); ?>
                <span class="aheto-switch right-sidebar-option">
                    <input type="checkbox" value="false" id="aheto-right-sidebar-option">
                    <label for="aheto-right-sidebar-option"></label>
                </span>
            </h4>

		</div>

		<div class="aheto-option-body">

			<?php
			// Navigation.
			include_once Helper::get_admin_view( 'import/sub-nav' );

			// Body.
			$current = Helper::param_get( 'view', 'pages' );
			include_once Helper::get_admin_view( 'import/' . $current );
			?>

		</div>

	</div>


</div>
