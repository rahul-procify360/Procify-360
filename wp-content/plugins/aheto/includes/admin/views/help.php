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
            <h4><span class="img-box"><svg width="32" height="33" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M32 16.6154H26.3999C25.3467 16.6154 24.3867 17.2523 23.96 18.2491L20.5466 26.1831C20.3467 26.6676 19.8799 27 19.3333 27C18.7334 27 18.2266 26.5847 18.0532 26.0168L12.6133 7.21396C12.4399 6.64605 11.9333 6.23077 11.3333 6.23077C10.7334 6.23077 10.2266 6.64605 10.0532 7.21396L7.90674 14.6493C7.56006 15.8122 6.53345 16.6154 5.34668 16.6154H0C0 7.44924 7.17334 0 16 0C24.8267 0 32 7.44924 32 16.6154Z" fill="#686B92"/>
<path d="M32 16.3846C32 25.5508 24.8267 33 16 33C7.17334 33 0 25.5508 0 16.3846H5.34668C6.53345 16.3846 7.56006 15.5814 7.90674 14.4185L10.0532 6.98319C10.2266 6.41528 10.7334 6 11.3333 6C11.9333 6 12.4399 6.41528 12.6133 6.98319L18.0532 25.786C18.2266 26.3539 18.7334 26.7692 19.3333 26.7692C19.8799 26.7692 20.3467 26.4369 20.5466 25.9524L23.96 18.0184C24.3867 17.0215 25.3467 16.3846 26.3999 16.3846H32Z" fill="#2AB9A5"/>
</svg>
</span><span class="options-page-title"><?php echo get_admin_page_title(); ?></span>
                <span class="aheto-switch right-sidebar-option">
                    <input type="checkbox" value="false" id="aheto-right-sidebar-option">
                    <label for="aheto-right-sidebar-option"></label>
                </span>
            </h4>

		</div>

		<div class="aheto-option-body">

			<?php
			// Navigation.
			include_once Helper::get_admin_view( 'help/sub-nav' );

			// Body.
			$current = Helper::param_get( 'view', 'welcome' );
			include_once Helper::get_admin_view( 'help/' . $current );
			?>

		</div>

	</div>


</div>
