<?php
	/**
	 * The Shortcode.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto/Traits
	 * @author     UPQODE <info@upqode.com>
	 */

	namespace Aheto\Traits;

	use Aheto\Helper;
	use Aheto\Params;

	defined( 'ABSPATH' ) || exit;

	/**
	 * Shortcode class.
	 */
	trait Shortcode {

		/**
		 * Set param id if scalar
		 *
		 * @param  string $id Param id.
		 * @param  bool $param Param value.
		 *
		 * @return array
		 */
		public function set_param_id( $id, $param ) {
			if ( is_scalar( $param ) ) {
				$param = [ 'id' => $id ];
			}

			if ( ! isset( $param['id'] ) ) {
				$param['id'] = $id;
			}

			return $param;
		}

		/**
		 * Maybe a global param set it.
		 *
		 * @param  array $param Param value.
		 * @param  array $params Param array.
		 * @param  bool $repeater Fields of repeater.
		 *
		 * @return bool|array
		 */
		public function maybe_global_param( $param, &$params, $repeater ) {
			if ( ! isset( $param['type'] ) && ! empty( $param['id'] ) ) {
				$global_id = isset( $param['global'] ) ? $param['global'] : $param['id'];
				$param     = Params::get_param( $global_id, $param );

				unset( $param['global'] );
				if ( isset( $param['is_group'] ) ) {
					unset( $param['is_group'] );

					// Prefix if any provided.
					if ( isset( $param['prefix'] ) ) {
						$prefix = $param['prefix'] . '_';
						unset( $param['prefix'] );

						// Append prefix.
						foreach ( $param as $id => $new_param ) {
							$param[ $prefix . $id ] = $new_param;
							unset( $param[ $id ] );
						}
					}

					$params = $params + $this->prepare_params( $param, $repeater );

					return false;
				}
			}

			return $param;
		}

		/**
		 * Maybe a group param loop it.
		 *
		 * @param  array $param Param value.
		 *
		 * @return array
		 */
		public function maybe_group_param( $param ) {
			if ( 'group' === $param['type'] ) {
				$param['params'] = $this->prepare_params( $param['params'], true );
			}

			return $param;
		}

		/**
		 * A pre register routine.
		 */
		public function pre_register() {
			// For developers.
			$this->do_action( 'before_shortcode_register', $this->slug, $this );
			$this->do_action( 'before_' . $this->slug . '_register', $this );

			// Prepare params.
			if ( ! empty( $this->layouts ) ) {
				$template['template'] = [
					'type'    => 'image_selector',
					'heading' => esc_html__( 'Templates', 'aheto' ),
					'group' =>'Layout',
					'default' => $this->get_default_layout(),
					'layouts' => $this->get_layouts(),
				];

				// Add template selector.
				$this->params = $template + $this->params;
			}

			$this->params = $this->prepare_params( $this->params );
		}

		/**
		 * Get layout
		 */
		public function get_layouts() {
			return $this->layouts;
		}

		/**
		 * Get default layout
		 * if default layout not set default layout will be first layout
		 */
		public function get_default_layout() {
			if ( $this->default_layout !== '' ) {
				return $this->default_layout;
			}

			$layouts = $this->get_layouts();

			if ( is_array( $layouts ) ) {
				return key( $layouts );
			}

			return '';
		}

		/**
		 * Add new layout
		 *
		 * @param string $id Layout id.
		 * @param string $data Hold layout data.
		 */
		public function add_layout( $id, $data ) {
			$this->layouts[ $id ] = $data;
		}

		/**
		 * Remove layout
		 *
		 * @param string $id Layout id to remove.
		 */
		public function remove_layout( $id ) {
			if ( isset( $this->layouts[ $id ] ) ) {
				unset( $this->layouts[ $id ] );
			}
		}

		/**
		 * Add new params
		 *
		 * @param array $params Hold params.
		 * @param string $group Group name.
		 */
		public function add_params( $params, $group = '' ) {
			foreach ( $params as $id => $args ) {
				$this->add_param( $id, $args, $group );
			}
		}

		/**
		 * Add new param
		 *
		 * @param string $id Param id.
		 * @param string $args Hold param data.
		 * @param string $group Group name data.
		 */
		public function add_param( $id, $args, $group = '' ) {
			if ( $group ) {
				$this->params[ $group ]['params'][ $id ] = $args;
			} else {
				$this->params[ $id ] = $args;
			}
		}

		/**
		 * Remove param
		 *
		 * @param string $id Param id to remove.
		 * @param string $group Group id with param.
		 */
		public function remove_param( $id, $group = '' ) {
			if ( $group ) {
				if ( isset( $this->params[ $group ]['params'][ $id ] ) ) {
					unset( $this->params[ $group ]['params'][ $id ] );
				}
			} else {
				if ( isset( $this->params[ $id ] ) ) {
					unset( $this->params[ $id ] );
				}
			}
		}



		/**
		 * Add Dependency
		 *
		 * @param string $param Param id.
		 * @param string $element Element id.
		 * @param string $value Value.
		 * @param string $condition Checking condition.
		 */
		public function add_dependecy( $param, $element, $value, $condition = 'value' ) {
			$this->depedency_condition[ $param ][ $element ] = $condition;

			if ( ! isset( $this->depedency[ $param ] ) ) {
				$this->depedency[ $param ] = [];
			}

			if ( ! isset( $this->depedency[ $param ][ $element ] ) ) {
				$this->depedency[ $param ][ $element ] = [];
			}

			if ( is_array( $value ) ) {
				foreach ( $value as $new ) {
					$this->depedency[ $param ][ $element ][] = $new;
				}

				return;
			}

			$this->depedency[ $param ][ $element ][] = $value;
		}


		/**
		 * Remove Dependency
		 *
		 * @param string $param Param id.
		 * @param string $element Element id.
		 * @param string $value Value.
		 */
		public function remove_dependecy( $param, $element, $value ) {
			if ( ! isset( $this->depedency[ $param ] ) || ! isset( $this->depedency[ $param ][ $element ] ) ) {
				return;
			}

			$index = array_search( $value, $this->depedency[ $param ][ $element ], true );
			if ( false === $index ) {
				return;
			}

			unset( $this->depedency[ $param ][ $element ][ $index ] );
		}

		/**
		 * Get button data
		 *
		 * @param  string $prefix Prefix if any.
		 * @param  array $atts Array of attributes to parse data from.
		 *
		 * @return array
		 */
		public function get_button_attributes( $prefix = '', $atts = false ) {
			$atts   = false === $atts ? $this->atts : $atts;
			$prefix = '' !== $prefix ? $prefix . '_' : '';
			$button = [];

			if ( isset( $atts[ $prefix . 'url' ] ) && ! empty( $atts[ $prefix . 'url' ] ) ) {
				$button = $this->get_link_attributes( $atts[ $prefix . 'url' ] );

			}
			if ( isset( $atts[ $prefix . 'title' ] ) && ! empty( $atts[ $prefix . 'title' ] ) ) {
				$button['title'] = $atts[ $prefix . 'title' ];
			}

			return $button;
		}

		/**
		 * Get icon data
		 *
		 * @param  string $prefix Prefix if any.
		 * @param  bool $add_icon Add icon is set or not.
		 * @param  array $attr Attr array
		 *
		 * @return array
		 */
		public function get_icon_attributes( $prefix = '', $add_icon = false, $attr = [] ) {
			if ( ! empty( $attr ) ) {
//			$attr = $this->attr;
				$attr = $this->atts;
			}


			return Helper::get_icon_attributes( $attr, $prefix, $add_icon );
		}

		/**
		 * Get classes
		 *
		 * @return string
		 */
		public function the_custom_classes() {
			return [ $this->atts['_id'], $this->atts['css_classes'] ];
		}

		/**
		 * Render attribute string.
		 *
		 * Used to retrieve the value of the render attribute.
		 *
		 * @param array|string $element The element.
		 */
		public function render_attribute_string( $element ) {
			echo $this->get_render_attribute_string( $element );
		}

		/**
		 * Get swiper pagination.
		 *
		 * @param string $id Attribute id.
		 */
		public function swiper_pagination( $prefix = '' ) {
			if ( empty( $this->atts[ $prefix . 'pagination' ] ) ) {
				return;
			}

			echo '<div class="swiper-pagination"></div>';
		}

		/**
		 * Get swiper arrows.
		 *
		 * @param string $id Attribute id.
		 */
		public function swiper_arrow( $prefix = '' ) {
			if ( empty( $this->atts[ $prefix . 'arrows' ] ) ) {
				return;
			}

			if ( isset( $this->atts[ $prefix . 'arrows_style' ] ) && $this->atts[ $prefix . 'arrows_style' ] === 'number' ) {
				$span_prev  = '<span class="swiper-slides-prev"></span> ';
				$span_total = '<span class="swiper-slides-total"></span>';
				$span_next  = '<span class="swiper-slides-next"></span> ';

				echo '<div class="swiper-button-prev swiper-button-prev--number">' . $span_prev . $span_total . '</div><div class="swiper-button-next swiper-button-next--number">' . $span_next . $span_total . '</div>';

				return;
			}

			if( isset( $this->atts[ $prefix . 'arrows_style' ] ) && $this->atts[ $prefix . 'arrows_style' ] === 'number_zero' ){
				$span_prev  = '<span class="swiper-slides-prev"></span> ';
				$span_total = '<span class="swiper-slides-total"></span>';
				$span_next  = '<span class="swiper-slides-next"></span> ';

				echo '<div class="swiper-button-prev swiper-button-prev--number-zero">' . $span_prev . $span_total . '</div><div class="swiper-button-next swiper-button-next--number-zero">' . $span_next . $span_total . '</div>';

				return;
			}

			echo '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
		}

	}