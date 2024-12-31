<?php
/**
 * The CSS Generator abstract
 *
 * @since      1.0.0
 * @package    Aheto\CSS\Generator
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\CSS\Generator;

defined( 'ABSPATH' ) || exit;

/**
 * CLass Visual_Composer
 */
class Visual_Composer extends Generator {

	/**
	 * Builder slug.
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return array|null
	 */
	protected $slug = 'visual-composer';

	/**
	 * Parse content for css.
	 *
	 * @param int $post_id Current post id.
	 *
	 * @return array
	 */
	public function parse_content( int $post_id ) {
		$data = [];

		if ( ! empty( $_POST['content'] ) ) {
			$content = $_POST['content'];
		} else {
			$post = get_post( $post_id );

			if ( ! empty( $post ) && ! is_wp_error( $post ) ) {
				$content = $post->post_content;
			} else {
				return $data;
			}
		}

		return $this->get_elements( $content );
	}

	private function get_elements( $content ) {
		global $shortcode_tags;

		if ( false === strpos( $content, '[' ) ) {
			return false;
		}

		if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
			return false;
		}

		// Find all registered tag names in $content.
		preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
		$tagnames = array_intersect( array_keys( $shortcode_tags ), $matches[1] );

		if ( empty( $tagnames ) ) {
			return false;
		}

		$content = do_shortcodes_in_html_tags( $content, $ignore_html, $tagnames );
		$pattern = get_shortcode_regex( $tagnames );

		$matches = [];
		preg_match_all( "/$pattern/", \stripslashes( $content ), $matches );

		return $this->parse_attributes( $matches );
	}

	private function parse_attributes( $matches ) {
		$data = [];

		foreach ( $matches[2] as $index => $shortcode ) {
			if ( ! isset( $data[ $shortcode ] ) ) {
				$data[ $shortcode ] = [];
			}

			if ( isset( $matches[3][ $index ] ) ) {
				$attrs    = shortcode_parse_atts( $matches[3][ $index ] );
				$template = ! empty( $attrs['template'] ) ? $attrs['template'] : 'view';

				$data[ $shortcode ][ $template ] = true;
			}
		}

		return $data;
	}
}
