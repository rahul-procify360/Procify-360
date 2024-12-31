<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Karma
 */

if ( ! is_active_sidebar( 'karma-sidebar' ) ) {
	return;
}
?>

<div class="col-12 col-lg-4">
    <div class="karma-blog--sidebar">
		<?php dynamic_sidebar( 'karma-sidebar' ); ?>
    </div>
</div>

