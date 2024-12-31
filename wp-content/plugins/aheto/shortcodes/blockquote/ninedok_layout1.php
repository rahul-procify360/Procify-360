<?php
/**
 * The Blockquote Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract ( $atts );


$blockquote = $this -> parse_group ( $ninedok_modern_blockquote );

if (empty( $blockquote )) {
	return '';
}

$this -> generate_css ();

// Wrapper.
$this -> add_render_attribute ( 'wrapper', 'class', $this -> the_custom_classes () );
$this -> add_render_attribute ( 'blockqoute', 'class', 'aheto-quote--ninedok-simple' );
$this -> add_render_attribute ( 'blockqoute', 'class', 'aheto-quote' );
$this -> add_render_attribute ( 'blockqoute', 'class', $ninedok_align );

if (isset( $icon_position ) && $icon_position) {
	$this -> add_render_attribute ( 'blockqoute', 'class', $icon_position );
	$this -> add_render_attribute ( 'blockqoute', 'class', $icon_size );
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/blockquote/';
$custom_css = Helper ::get_settings ( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && !empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style ( 'ninedok-blockquote-layout1', $shortcode_dir . 'assets/css/ninedok_layout1.css', null, null );
} ?>
<div <?php $this -> render_attribute_string ( 'wrapper' ); ?>>
    <div class="aheto-quote-container">
		<?php foreach ($blockquote as $item) { ?>

            <blockquote <?php $this -> render_attribute_string ( 'blockqoute' ); ?>>

				<?php
				// Cite.
				if (isset( $item['ninedok_author'] ) && !empty( $item['ninedok_author'] )) {
					echo '<cite class="aheto-quote__author">' . wp_kses ( $item['ninedok_author'], 'post' ) . '</cite>';
				}

				// Qoute.
				$qoute_tag = isset( $qoute_tag ) && !empty( $qoute_tag ) ? $qoute_tag : 'h1';
				echo '<' . $qoute_tag . ' class="aheto-quote__text">' . wp_kses ( $item['ninedok_qoute'], 'post' ) . '</' . $qoute_tag . '>';

				// Author.
				if (isset( $item['ninedok_date'] ) && !empty( $item['ninedok_date'] )) {
					echo '<p class="aheto-quote__date">' . wp_kses ( $item['ninedok_date'], 'post' ) . '</p>';
				}
				?>

            </blockquote>

		<?php } ?>
    </div>
	<?php if ( !empty( $ninedok_bg_text )) { ?>
        <div class="aheto-quote__bg-text"><?php echo esc_html ( $ninedok_bg_text ); ?></div>
	<?php } ?>
</div>
