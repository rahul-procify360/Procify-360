<?php
/**
 * Blog settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'      => 'single_template',
	'type'    => 'radio_inline',
	'name'    => __( '<i class="fas fa-columns"></i> <span>Single Post Template</span>', 'aheto' ),
	'desc'    => esc_html__( 'Choose a template style for the single post page.', 'aheto' ),
	'options' => [
		'theme'         => esc_html__( 'Use Theme Default', 'aheto' ),
		'fullwidth'     => esc_html__( 'Fullwidth', 'aheto' ),
		'left-sidebar'  => esc_html__( 'Left Sidebar', 'aheto' ),
		'right-sidebar' => esc_html__( 'Right Sidebar', 'aheto' ),
		'both-sidebar'  => esc_html__( 'Both Sidebars', 'aheto' ),
	],
	'default' => 'theme',
]);



$cmb->add_field([
	'id'      => 'blog_template',
	'type'    => 'search_select',
	'name'    => __( '<i class="fas fa-th-list"></i> <span>Blog List Template</span>', 'aheto' ),
	'desc'    => esc_html__( 'Choose a template style for the blog page.', 'aheto' ),
	'options' => [
		'theme'         => esc_html__( 'Use Theme Default', 'aheto' ),
		'aheto_blog'     => aheto()->plugin_name() . esc_html__( ' Default', 'aheto' ),
	],
	'default' => 'theme',
]);

//$cmb->add_field([
//	'id'      => 'blog_template',
//	'type'    => 'search_select',
//	'name'    => __( '<i class="fas fa-th-list yellow-color"></i> <span>Blog List Template</span>', 'aheto' ),
//	'desc'    => esc_html__( 'Choose a template style for the blog page.', 'aheto' ),
//	'options' => Helper::choices_post_templates(),
//]);

//$cmb->add_field([
//	'id'      => 'blog_template',
//	'type'    => 'search_select',
//	'name'    => __( '<i class="fas fa-th-list yellow-color"></i> <span>Blog List Template</span>', 'aheto' ),
//	'desc'    => esc_html__( 'Choose a template style for the blog page.', 'aheto' ),
//	'options' => Helper::choices_post_templates(),
//]);

$cmb->add_field([
	'id'      => 'single_template_sidebar_1',
	'type'    => 'search_select',
	'name'    => __( '<i class="fas fa-list-alt"></i> <span>Sidebar 1</span>', 'aheto' ),
	'desc'    => esc_html__( 'Please choose main sidebar that will be used as Sidebar 1.', 'aheto' ),
	'options' => Helper::choices_sidebars(),
	'dep'     => [
		[ 'single_template', 'left-sidebar' ],
		[ 'single_template', 'right-sidebar' ],
		[ 'single_template', 'both-sidebar' ],
	],
]);


$cmb->add_field([
	'id'      => 'single_template_sidebar_2',
	'type'    => 'search_select',
	'name'    => __( '<i class="fas fa-list-alt"></i> <span>Sidebar 2</span>', 'aheto' ),
	'desc'    => esc_html__( 'Please choose additional sidebar that will be used as Sidebar 2.', 'aheto' ),
	'options' => Helper::choices_sidebars(),
	'dep'     => [ [ 'single_template', 'both-sidebar' ] ],
]);
