<?php
/**
 * Helper Functions.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto;

use Aheto\Helpers\Api;
use Aheto\Helpers\HTML;
use Aheto\Helpers\Strings;
use Aheto\Helpers\Choices;
use Aheto\Helpers\Options;
use Aheto\Helpers\WordPress;
use Aheto\Helpers\Conditional;

defined( 'ABSPATH' ) || exit;

/**
 * Helper class.
 */
class Helper {

	use Api, Choices, Conditional, HTML, Strings, Options, WordPress;

	/**
	 * Debug function.
	 */
	public static function d() {
		array_map( function ( $x ) {
			print_r( $x );
			echo "<br>\n";
		}, func_get_args() );
		die( 1 );
	}

	/**
	 * Debug function.
	 */
	public static function dd() {
		array_map( function ( $x ) {
			var_dump( $x );
			echo "<br>\n";
		}, func_get_args() );
		die( 1 );
	}

	/**
	 * Insert a single array item inside another array at a set position.
	 *
	 * @param array $array Array to modify. Is passed by reference, and no return is needed.
	 * @param array $new New array to insert.
	 * @param int $position Position in the main array to insert the new array.
	 */
	public static function array_insert( &$array, $new, $position ) {
		$before = array_slice( $array, 0, $position - 1 );
		$after  = array_diff_key( $array, $before );
		$array  = array_merge( $before, $new, $after );
	}

	/**
	 * Get a value from querystring.
	 *
	 * @param string $id ID to get from querystring.
	 * @param string $default If not found return default.
	 *
	 * @return mixed
	 */
	public static function param_get( $id, $default = false ) {
		return isset( $_GET[ $id ] ) ? $_GET[ $id ] : $default;
	}

	/**
	 * Get a value from POST.
	 *
	 * @param string $id ID to get from POST.
	 * @param string $default If not found return default.
	 *
	 * @return mixed
	 */
	public static function param_post( $id, $default = false ) {
		return isset( $_POST[ $id ] ) ? $_POST[ $id ] : $default;
	}

	/**
	 * Get image tag from attachment id.
	 *
	 * @param int $id Attachment id.
	 * @param array $args Extra attributes.
	 * @param string $size Attachment size.
	 *
	 * @return string
	 */
	public static function get_attachment( $id, $args = [], $size = 'full', $image_atts = [], $prefix = '' ) {

		$lazyload = Helper::get_settings( 'general.lazyload' );

		$height = isset( $image_atts[ $prefix . 'image_height' ] ) && ! empty( $image_atts[ $prefix . 'image_height' ] ) ? $image_atts[ $prefix . 'image_height' ] : 0;
		$width  = isset( $image_atts[ $prefix . 'image_width' ] ) && ! empty( $image_atts[ $prefix . 'image_width' ] ) ? $image_atts[ $prefix . 'image_width' ] : 0;
		$crop   = isset( $image_atts[ $prefix . 'image_crop' ] ) ? $image_atts[ $prefix . 'image_crop' ] : false;

		// From id.
		$id = isset( $id['id'] ) ? $id['id'] : $id;
		if ( absint( $id ) > 0 ) {

			$image_alt   = get_post_meta( $id, '_wp_attachment_image_alt', true );
			$args['alt'] = $image_alt;

			if ( $lazyload == 'enable' ) {

				if ( $size == 'custom' ) {

					$image_url             = wp_get_attachment_image_url( $id, 'full' );
					$image_url             = aq_resize( $image_url, $width, $height, $crop, true, true );
					$args['data-lazy-src'] = $image_url;

//					$image_new_id = attachment_url_to_postid($image_url);
//					$image_metadata = wp_get_attachment_metadata($image_new_id);
//					$args['height'] = $image_metadata['height'];
//					$args['width'] = $image_metadata['width'];

					return sprintf( '<img src="' . aheto()->plugin_url() . 'assets/images/placeholder.jpg" %s>', Helper::html_generate_attributes( $args ) );

				} else {
					$image = wp_get_attachment_image( $id, $size, false, $args );
					$image = str_replace( ' src=', ' src="' . aheto()->plugin_url() . 'assets/images/placeholder.jpg" data-lazy-src=', $image );

					return $image;
				}

			} else {

				if ( $size == 'custom' ) {
					$image_url   = wp_get_attachment_image_url( $id, 'full' );
					$image_url   = aq_resize( $image_url, $width, $height, $crop, true, true );
					$args['src'] = $image_url;

//					$image_new_id = attachment_url_to_postid($image_url);
//					$image_metadata = wp_get_attachment_metadata($image_new_id);
//					$args['height'] = $image_metadata['height'];
//					$args['width'] = $image_metadata['width'];


					return sprintf( '<img %s>', Helper::html_generate_attributes( $args ) );

				} else {
					return wp_get_attachment_image( $id, $size, false, $args );
				}


			}

		}

		// From url.
		if ( isset( $id['url'] ) && ! empty( $id['url'] ) ) {
			if ( $lazyload == 'enable' ) {

				if ( $size == 'custom' ) {
					$image_url             = wp_get_attachment_image_url( $id['url'], 'full' );
					$image_url             = aq_resize( $image_url, $width, $height, $crop, true, true );
					$args['data-lazy-src'] = $image_url;

					return sprintf( '<img src="' . aheto()->plugin_url() . 'assets/images/placeholder.jpg" %s>', Helper::html_generate_attributes( $args ) );

				} else {
					$args['data-lazy-src'] = $id['url'];

					return sprintf( '<img src="' . aheto()->plugin_url() . 'assets/images/placeholder.jpg" %s>', Helper::html_generate_attributes( $args ) );
				}

			} else {

				if ( $size == 'custom' ) {
					$image_url   = wp_get_attachment_image_url( $id['url'], 'full' );
					$image_url   = aq_resize( $image_url, $width, $height, $crop, true, true );
					$args['src'] = $image_url;

					return sprintf( '<img %s>', Helper::html_generate_attributes( $args ) );

				} else {
					$args['src'] = $id['url'];

					return sprintf( '<img %s>', Helper::html_generate_attributes( $args ) );
				}

			}
		}

		return '';
	}

	/**
	 * Get image tag from attachment id.
	 *
	 * @param int $id Attachment id.
	 * @param array $args Extra attributes.
	 * @param string $size Attachment size.
	 *
	 * @return string
	 */
	public static function get_attachment_for_swiper( $id, $args = [], $size = 'full' ) {

		if ( $id['url'] ) {
			$image            = wp_get_attachment_image_src( $id['id'], $size );
			$args['width'] = $image[1] . 'px';
			$args['height'] = $image[2] . 'px';
			$args['data-src'] = $id['url'];
			$args['alt']      = get_post_meta( $id['id'], '_wp_attachment_image_alt', true );
		} else {
			$image            = wp_get_attachment_image_src( $id, $size );
			$args['data-src'] = $image[0];
			$args['width'] = $image[1] . 'px';
			$args['height'] = $image[2] . 'px';
			$args['alt']      = get_post_meta( $id, '_wp_attachment_image_alt', true );
		}

		return sprintf( '<img %s><div class="swiper-lazy-preloader"></div>', Helper::html_generate_attributes( $args ) );
	}


	/**
	 * Get image tag from attachment id.
	 *
	 * @param int $id Attachment id.
	 * @param array $args Extra attributes.
	 * @param string $size Attachment size.
	 *
	 * @return string
	 */
	public static function get_background_attachment( $id, $size = 'full', $image_atts = [], $prefix = '', $swiper_lazy = false ) {

		$height = isset( $image_atts[ $prefix . 'image_height' ] ) && ! empty( $image_atts[ $prefix . 'image_height' ] ) ? $image_atts[ $prefix . 'image_height' ] : 0;
		$width  = isset( $image_atts[ $prefix . 'image_width' ] ) && ! empty( $image_atts[ $prefix . 'image_width' ] ) ? $image_atts[ $prefix . 'image_width' ] : 0;
		$crop   = isset( $image_atts[ $prefix . 'image_crop' ] ) ? $image_atts[ $prefix . 'image_crop' ] : false;

		// From id.
		$id = isset( $id['id'] ) ? $id['id'] : $id;
		if ( absint( $id ) > 0 ) {

			if ( $size == 'custom' ) {

				$image_url = wp_get_attachment_image_url( $id, 'full' );
				$image_url = aq_resize( $image_url, $width, $height, $crop, true, true );

				$background_image = $swiper_lazy ? "data-background=" . $image_url : "style=background-image:url(" . $image_url . ")";

				return $background_image;

			} else {
				$image_url        = wp_get_attachment_image_url( $id, $size );
				$background_image = $swiper_lazy ? "data-background=" . $image_url : "style=background-image:url(" . $image_url . ")";

				return $background_image;
			}

		}

		// From url.
		if ( isset( $id['url'] ) && ! empty( $id['url'] ) ) {

			if ( $size == 'custom' ) {

				$image_url        = wp_get_attachment_image_url( $id['url'], 'full' );
				$image_url        = aq_resize( $image_url, $width, $height, $crop, true, true );
				$background_image = $swiper_lazy ? "data-background=" . $image_url : "style=background-image:url(" . $image_url . ")";

				return $background_image;
			} else {
				$image_url        = wp_get_attachment_image_url( $id['url'], $size );
				$background_image = $swiper_lazy ? "data-background=" . $image_url : "style=background-image:url(" . $image_url . ")";

				return $background_image;
			}
		}

		return '';
	}




	public static function is_Elementor_Live(){
		return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

	/**
	 * Get button html from arguments $args
	 *
	 * @param        $shortcode
	 * @param array $args
	 * @param string $prefix
	 * @param boold $form
	 *
	 * @return string
	 */
	public static function get_button( $shortcode, $args = [], $prefix = '', $form = false ) {

		$args = wp_parse_args( $args, [
			$prefix . 'url'           => '',
			$prefix . 'title'         => '',
			$prefix . 'layouts'       => 'layout1',
			$prefix . 'style'         => 'aheto-btn--primary',
			$prefix . 'size'          => '',
			$prefix . 'type'          => '',
			$prefix . 'shadow'        => '',
			$prefix . 'full_width'    => '',
			$prefix . 'underline'     => '',
			$prefix . 'underline_anime' => '',
			$prefix . 'add_icon'      => false,
			$prefix . 'icon_position' => 'left',
		] );




		// render button classes
		$button_class = [];

		switch ( $args[ $prefix . 'layouts' ] ) {
			case 'layout1':
				$button_class[] = $form ? 'aheto-form-btn' : 'aheto-btn';
				$button_class[] = $args[ $prefix . 'style' ];
				$button_class[] = $args[ $prefix . 'size' ];
				$button_class[] = $args[ $prefix . 'type' ];
				$button_class[] = $args[ $prefix . 'shadow' ] ? 'aheto-btn--shadow' : '';
				$button_class[] = $args[ $prefix . 'full_width' ] ? 'aheto-btn--full-width' : '';

				break;

			case 'layout2':
				$button_class[] = $form ? 'aheto-form-link' : 'aheto-link';
				$button_class[] = $args[ $prefix . 'style' ];
				$button_class[] = $args[ $prefix . 'underline' ] ? 'aheto-btn--no-underline' : '';
				$button_class[] = $args[ $prefix . 'underline_anime' ] ? 'aheto-btn--underline-anime' : '';

				break;

			default:
				$button_class[] = $form ? 'cs-form-btn' : 'cs-btn';
				$button_class[] = $args[ $prefix . 'size' ];
				$button_class[] = $args[ $prefix . 'style' ];
				$button_class[] = $args[ $prefix . 'layouts' ];
		}

		if ( $form ) {
			return esc_attr( implode( ' ', $button_class ) );
		}

		// get button attribute
		$button = $shortcode->get_button_attributes( '', [
			'url'   => $args[ $prefix . 'url' ],
			'title' => $args[ $prefix . 'title' ],
		] );


		// return if some not isset or empty
		if ( ! isset( $button['href'] ) && ! isset( $button['title'] ) ) {
			return '';
		}

		// render icon output html
		$icon_class       = [];
		$icon_left_output = $icon_right_output = '';
		if ( $args[ $prefix . 'add_icon' ] ) {
			$icon = Helper::get_icon_attributes( $args, $prefix, $args[ $prefix . 'add_icon' ] );

			$icon_class[]      = $icon['icon'];
			$icon_class[]      = $args[ $prefix . 'icon_position' ] === 'right' ? 'aheto-btn__icon--right' : 'aheto-btn__icon--left';
			$icon_left_output  .= $args[ $prefix . 'icon_position' ] !== 'right' ? "<i class='" . esc_attr( implode( ' ', $icon_class ) ) . "'></i>" : '';
			$icon_right_output .= $args[ $prefix . 'icon_position' ] === 'right' ? "<i class='" . esc_attr( implode( ' ', $icon_class ) ) . "'></i>" : '';
		}

		// render button output html
		$href   = isset( $button['href'] ) ? esc_url( $button['href'] ) : '';
		$target = isset( $button['target'] ) ? esc_attr( $button['target'] ) : '_self';
		$rel = '';

		if( isset( $button['target'] ) && $button['target'] == '_blank' ){
			$rel = 'noreferrer noopener';
        }

		if(isset( $button['rel'] ) && ! empty( $button['rel'] )){
			$rel = !empty ($rel ) ? $rel . ' ' . $button['rel'] : $button['rel'];
		}

		$rel = !empty($rel) ? 'rel="' . esc_attr($rel) . '"' : '';

		$button['title'] = isset($button['title']) && !empty($button['title']) ? $button['title'] : '';
		$aria_label = isset($button['title']) && !empty($button['title']) ? $button['title'] : esc_attr__('Button', 'aheto');

		$button_output = '<a href="' . $href . '" class="' . esc_attr( implode( ' ', $button_class ) ) . '" target="' . $target . '"' . $rel . ' aria-label="' . esc_attr( $aria_label ) .'">';
		$button_output .= $icon_left_output;
		$button_output .= esc_html( $button['title'] );
		$button_output .= $icon_right_output;
		$button_output .= '</a>';

		return $button_output;
	}

	/**
	 * Get video button html from arguments $args
	 *
	 * @param array $args
	 * @param string $prefix
	 *
	 * @return string
	 */
	public static function get_video_button( $args = [], $prefix = '' ) {
		wp_enqueue_script( 'magnific' );
		wp_enqueue_style( 'magnific' );

		$args = wp_parse_args( $args, [
			$prefix . 'video_link'  => '',
			$prefix . 'video_style' => 'aheto-btn--primary',
			$prefix . 'video_size'  => '',
			$prefix . 'video_class' => '',
		] );

		// return if some not isset or empty
		if ( ! isset( $args[ $prefix . 'video_link' ] ) || empty( $args[ $prefix . 'video_link' ] ) ) {
			return '';
		}

		$button_class = [];

		$button_class[] = 'js-video-btn';
		$button_class[] = 'aheto-btn-video';
		$button_class[] = $args[ $prefix . 'video_style' ];
		$button_class[] = $args[ $prefix . 'video_size' ];
		$button_class[] = $args[ $prefix . 'video_class' ];

		// render button output html
		$button_output = "<a href='" . esc_url( $args[ $prefix . 'video_link' ] ) . "' class='" . esc_attr( implode( ' ', $button_class ) ) . "'>";
		$button_output .= "<i class='ion-ios-play'></i>";
		$button_output .= "</a>";

		return $button_output;
	}

	/**
	 * Get carousel params
	 *
	 * @param array $args all arguments
	 * @param string $prefix prefix
	 * @param string $default if user don't choose option Change slider options
	 * @param array $additional other options (some hardcode)
	 *
	 * @return mixed data-attributes for swiper init
	 */
	public static function get_carousel_params( $args = [], $prefix = '', $default = '', $additional = [] ) {
		$params_arr = [];

		if ( $args[ $prefix . 'custom_options' ] ) {
			$all_params = [
				'effect',
				'loop',
				'autoplay',
				'speed',
				'simulate_touch',
				'initial_slide',
				'direction',
				'overflow',
				'centeredSlides',
				'slides_group',
				'slides_group_lg',
				'slides_group_md',
				'slides_group_sm',
				'slides_group_xs',
				'lazy',
				'slides',
				'slides_lg',
				'slides_md',
				'slides_sm',
				'slides_xs',
				'spaces',
				'spaces_lg',
				'spaces_md',
				'spaces_sm',
				'spaces_xs'
			];


			foreach ( $all_params as $param ) {
				if ( isset( $args[ $prefix . $param ] ) && $args[ $prefix . $param ] ) {
					$params_arr[ $param ] = $args[ $prefix . $param ];
				}
			}
		} else {
			$params_arr = $default;
		}

		$params_arr = wp_parse_args( $additional, $params_arr );

		array_walk( $params_arr, function ( $val, $key ) use ( &$result ) {
			$result .= "data-$key=$val ";
		} );

		return $result;
	}

	/**
	 * Get social network html as group
	 *
	 * @param array $networks Array of network.
	 * @param string $template Template string.
	 *
	 * @return string
	 */
	public static function get_social_networks( $networks, $template ) {
		if ( empty( $networks ) ) {
			return '';
		}

		$html = '';
		foreach ( $networks as $network ) {
			if ( empty( $network['url'] ) ) {
				continue;
			}

			$html .= sprintf( $template, esc_url( $network['url'] ), strtolower( $network['network'] ) );
		}

		return $html;
	}


	/**
	 * Get social network html as list
	 *
	 * @param array $networks Array of network.
	 * @param string $template Template string.
	 *
	 * @return string
	 */
	public static function get_social_networks_list( $template, $prefix = '', $params = '' ) {


		if ( empty( $template ) ) {
			return '';
		}


		$networks = Helper::choices_social_network();

		$html = '';

		foreach ( $networks as $key => $name ) {


			$social = $prefix . $key;

			if ( ! empty( $params ) ) {

				if ( empty( $params[ $social ] ) ) {
					continue;
				}

				$html .= sprintf( $template, esc_url( $params[ $social ] ), strtolower( $name ) );

			} else {

				if ( empty( $social ) ) {
					continue;
				}

				$html .= sprintf( $template, esc_url( $social ), strtolower( $name ) );

			}

		}

		return $html;
	}


	/**
	 * @param $link - video link
	 * @param $class
	 *
	 * audio html
	 */
	public static function get_audio( $link, $class = '' ) {
		if ( $link ) { ?>
            <audio controls class="js-audio <?php echo esc_attr( $class ); ?>">
                <source src="<?php echo esc_url( $link ); ?>" type="audio/mpeg">
            </audio>
		<?php }
	}


	public static function getPostImage( $imgClass = '', $mod = '', $size = 'full', $link = false, $forceOutput = true, $image_atts = [], $prefix = '' ) {
		$classes = [];

		$has_thumb = has_post_thumbnail();

		$has_bg = strpos( $imgClass, 'js-bg' ) !== false ? true : false;

		if ( ! $has_thumb && ! $forceOutput ) {
			return false;
		}

		$classes[] = 'aheto-cpt-article__img';
		if ( $mod ) {
			$classes[] = $mod;
		}
		if ( $has_bg ) {
			$classes[] = 's-back-switch';
		}

		$post_image_id = get_post_thumbnail_id();
		$image         = array();
		$image['id']   = $post_image_id;

		$background_image = $has_thumb && $has_bg ? Helper::get_background_attachment( $image, $size, $image_atts, $prefix ) : ''; ?>

        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( $background_image ); ?>>
			<?php if ( $has_thumb && ! $has_bg ) :
				echo Helper::get_attachment( $image, [ 'class' => $imgClass ], $size, $image_atts, $prefix );
			endif;

			if ( $link ) : ?>
                <a class="aheto-cpt-article__img-link" href="<?php the_permalink(); ?>"
                   title="<?php the_title(); ?>"></a>
			<?php endif; ?>
        </div>

		<?php
		return $has_thumb;
	}

	/**
	 * @param string $mod
	 */
	public static function getPostDate( $mod = '' ) {
		$classes = [];

		$classes[] = 'aheto-cpt-article__date';
		if ( $mod ) {
			$classes[] = $mod;
		} ?>
        <time datetime="<?php the_time( 'Y-m-d' ); ?>"
              class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
	<?php }

	/**
	 * @param string $mod
	 */
	public static function getPostTitle( $mod = '' ) {
		$classes   = [];
		$classes[] = 'aheto-cpt-article__title';
		if ( $mod ) {
			$classes[] = $mod;
		}

		$title_attr    = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
		$title_content = '<a title="' . get_the_title() . '" href="' . get_the_permalink() . '">' . get_the_title() . '</a>';


		echo '<h4 ' . $title_attr . '>' . $title_content . '</h4>';
	}

	/**
	 * @param string $mod
	 */
	public static function getPostExcerpt( $mod = '' ) {
		$classes   = [];
		$classes[] = 'aheto-cpt-article__excerpt';
		if ( $mod ) {
			$classes[] = $mod;
		} ?>

        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php the_excerpt(); ?>
        </div>
	<?php }

	/**
	 * @param string $mod
	 * @param string $name
	 */
	public static function getPostLink( $mod = '', $name = '' ) {
		$classes   = [];
		$classes[] = 'aheto-cpt-article__btn';

		if ( $mod ) {
			$classes[] = $mod;
		}

		if ( empty( $name ) ) {
			$name = esc_html__( 'Read full post', 'aheto' );
		}
		?>
        <div class="aheto-cpt-article__btn-wrap">
            <a href="<?php the_permalink(); ?>"
               class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php echo esc_html( $name ); ?></a>
        </div>
	<?php }

	/**
	 * @param        $id
	 * @param        $terms
	 * @param string $class
	 * @param string $sep
	 */
	public static function getPostTerms( $terms, $class = '', $sep = '' ) {
		the_terms( get_the_ID(), $terms, '<div class="aheto-cpt-article__terms ' . $class . '">', $sep, '</div>' );
	}

	/**
	 * @param string $mod
	 */
	public static function getPostQuote( $mod = '' ) {
		$content = get_post_meta( get_the_ID(), 'aheto_post_blockquote', true );
		$author  = get_post_meta( get_the_ID(), 'aheto_post_blockquote_author', true );

		$classes   = [];
		$classes[] = 'aheto-cpt-article__quote';

		if ( $mod ) {
			$classes[] = $mod;
		}
		?>
        <blockquote class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
            <h3><?php echo wp_kses_post( $content ); ?></h3>
			<?php if ( ! empty( $author ) ) { ?>
                <cite><?php echo esc_html( $author ); ?></cite>
			<?php } ?>
        </blockquote>
		<?php
	}

	/**
	 * @param string $mod
	 * @param bool $arrows
	 * @param bool $pag
	 * @param string $img_size
	 */
	public static function getPostSlider( $mod = '', $arrows = true, $pag = false, $img_size = 'full', $image_atts = [], $prefix = '' ) {
		$classes   = [];
		$classes[] = 'aheto-cpt-article__slider';
		if ( $mod ) {
			$classes[] = $mod;
		}

		?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

            <div class="swiper">

                <div class="swiper-container" data-speed="1500" data-slide="1" data-autoplay="5000" data-loop="1"
                     data-simulate_touch="1">

                    <div class="swiper-wrapper">

						<?php
						$files           = get_post_meta( get_the_ID(), 'aheto_post_gallery', true );
						foreach ( (array) $files as $attachment_id => $attachment_url ) :

							$image = array();
							$image['id'] = $attachment_id;

							$background_image = Helper::get_background_attachment( $image, $img_size, $image_atts, $prefix ); ?>

                            <div class="swiper-slide s-back-switch" <?php echo esc_attr( $background_image ); ?>></div>

						<?php endforeach; ?>

                    </div>

                </div>

				<?php if ( $arrows ) { ?>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
				<?php } ?>
            </div>

        </div>

	<?php }

	/**
	 * @param string $mod
	 * @param string $img_size
	 *
	 * @return bool
	 */
	public static function getPostGallery( $mod = '', $img_size = 'full', $image_atts = [], $prefix = '' ) {
		$files = get_post_meta( get_the_ID(), 'aheto_post_gallery', true );

		if ( empty( $files ) ) {
			return false;
		}


		$classes   = [];
		$classes[] = 'aheto-cpt-article__gallery';
		$classes[] = 'js-popup-gallery';

		if ( $mod ) {
			$classes[] = $mod;
		}

		wp_enqueue_script( 'magnific' );

		?>

        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

			<?php foreach ( (array) $files as $attachment_id => $attachment_url ) :

				$image = array();
				$image['id'] = $attachment_id;

				$background_image = Helper::get_background_attachment( $image, $img_size, $image_atts, $prefix ); ?>

                <div class="aheto-cpt-article__gallery-image s-back-switch" <?php echo esc_attr( $background_image ); ?>>

                    <a href="<?php echo $attachment_url; ?>" class="js-popup-gallery-link">
                        <i class="icon ion-ios-search-strong"></i>
                    </a>

                </div>
			<?php endforeach; ?>

        </div>
		<?php

		return true;
	}

	/**
	 * @param $mod
	 *
	 * @return bool
	 */
	public static function getPostAudio( $mod = '' ) {
		$audio = get_post_meta( get_the_ID(), 'aheto_post_audio_file', true );

		if ( empty( $audio ) ) {
			return;
		}

		$classes   = [];
		$classes[] = 'aheto-cpt-article__audio';

		if ( $mod ) {
			$classes[] = $mod;
		}

		?>

        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php Helper::get_audio( $audio ); ?>
        </div>
		<?php

		return 1;
	}

	public static function getPostVideo( $mod = '', $btn_params = [], $img_class = '', $img_size = 'full', $image_atts = [], $prefix = '' ) {
		if ( ! has_post_thumbnail() ) {
			return 0;
		}

		$link = esc_url( get_post_meta( get_the_ID(), 'aheto_post_video_link', true ) );

		if ( ! $link ) {
			return 0;
		}

		$btn_params['video_link']  = $link;
		$btn_params['video_class'] = 'aheto-cpt-article__video-btn';

		$has_bg = strpos( $img_class, 'js-bg' ) !== false ? true : false;

		$classes   = [];
		$classes[] = 'aheto-cpt-article__video';

		if ( $mod ) {
			$classes[] = $mod;
		}

		if ( $has_bg ) {
			$classes[] = 's-back-switch';
		}

		$post_image_id = get_post_thumbnail_id();
		$image         = array();
		$image['id']   = $post_image_id;

		$background_image = $has_bg ? Helper::get_background_attachment( $image, $img_size, $image_atts, $prefix ) : ''; ?>

        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo esc_attr( $background_image ); ?>>
			<?php if ( ! $has_bg ) {
				echo Helper::get_attachment( $image, [ 'class' => $img_class ], $img_size, $image_atts, $prefix );
			}

			echo Helper::get_video_button( $btn_params ); ?>
        </div>
		<?php

		return 1;
	}
}
