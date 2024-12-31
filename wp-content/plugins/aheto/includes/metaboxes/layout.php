<?php
/**
 * Layout metabox settings.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

$cmb->add_field([
	'id'      => 'aheto_post_as_slider',
	'type'    => 'radio_inline',
	'name'    => esc_html__( 'Post Gallery as Slider', 'aheto' ),
	'desc'    => esc_html__( 'You can enable/disable slider for post gallery.', 'aheto' ),
	'default' => 'off',
	'classes' => 'post-format-row post-format-gallery',
	'options' => [
		'off' => esc_html__( 'Off', 'aheto' ),
		'on'  => esc_html__( 'On', 'aheto' ),
	],
]);

$cmb->add_field([
	'id'      => 'aheto_post_gallery',
	'type'    => 'file_list',
	'classes' => 'post-format-row post-format-gallery',
	'name'    => esc_html__( 'Post Gallery', 'aheto' ),
	'desc'    => esc_html__( 'You can add images for post gallery here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_post_blockquote',
	'type'    => 'textarea',
	'classes' => 'post-format-row post-format-quote',
	'name'    => esc_html__( 'Quote', 'aheto' ),
	'desc'    => esc_html__( 'You can add text for post qoute here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_post_blockquote_author',
	'type'    => 'text',
	'classes' => 'post-format-row post-format-quote',
	'name'    => esc_html__( 'Quote Author', 'aheto' ),
	'desc'    => esc_html__( 'You can add author name for post qoute here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_post_video_link',
	'type'    => 'text',
	'classes' => 'post-format-row post-format-video',
	'name'    => esc_html__( 'Video Link', 'aheto' ),
	'desc'    => esc_html__( 'You can add video link for post here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_post_audio_file',
	'type'    => 'file',
	'classes' => 'post-format-row post-format-audio',
	'name'    => esc_html__( 'Audio File', 'aheto' ),
	'desc'    => esc_html__( 'You can add audio file for post here.', 'aheto' ),
]);

$cmb->add_field([
	'id'      => 'aheto_external_link',
	'type'    => 'text',
	'name'    => esc_html__( 'External Link', 'aheto' ),
	'desc'    => esc_html__( 'You can add external link for post here.', 'aheto' ),
]);

$cmb->add_field([
	'id'         => 'aheto_cpt_width',
	'type'       => 'radio_inline',
	'name'       => esc_html__( 'Double Width', 'aheto' ),
	'desc'       => esc_html__( 'You can enable/disable double width for post.', 'aheto' ),
	'default'    => 'off',
	'options'    => [
		'off' => esc_html__( 'Off', 'aheto' ),
		'on'  => esc_html__( 'On', 'aheto' ),
	],
]);

$cmb->add_field([
	'id'         => 'aheto_cpt_height',
	'type'       => 'radio_inline',
	'name'       => esc_html__( 'Double Height', 'aheto' ),
	'desc'       => esc_html__( 'You can enable/disable double height for post.', 'aheto' ),
	'default'    => 'off',
	'options'    => [
		'off' => esc_html__( 'Off', 'aheto' ),
		'on'  => esc_html__( 'On', 'aheto' ),
	],
]);
