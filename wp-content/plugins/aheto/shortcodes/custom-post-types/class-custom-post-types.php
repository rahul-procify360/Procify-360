<?php
/**
 * The CustomPostTypes Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Helper;
use Aheto\Shortcode;
use Aheto\Sanitize;

defined( 'ABSPATH' ) || exit;

/**
 * CustomPostTypes class.
 */
class CustomPostTypes extends Shortcode {

	/**ƒ
	 * Setup
	 */
	public function setup() {
		$this->slug        = 'custom-post-types';
		$this->title       = esc_html__( 'Custom Post Types', 'aheto' );
		$this->icon        = 'fa fa-newspaper-o';
		$this->description = esc_html__( 'Add Custom Post Types Content', 'aheto' );
		$this->partials    = plugin_dir_path( __FILE__ );
		$this->default_layout = 'view';

		// Layouts.
		$dir = '//assets.aheto.co/custom-post-types/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Slider', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		] );

		$this->add_layout( 'layout2', [
			'title' => esc_html__( 'Grid', 'aheto' ),
			'image' => $dir . 'layout2.jpg',
		] );

		$this->add_layout( 'layout3', [
			'title' => esc_html__( 'Masonry', 'aheto' ),
			'image' => $dir . 'layout3.jpg',
		] );

		$this->add_layout( 'layout4', [
			'title' => esc_html__( 'Mosaics', 'aheto' ),
			'image' => $dir . 'layout4.jpg',
		] );

		$layouts = [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ];

		$this->add_dependecy( 'skin', 'template', [ 'view','layout1', 'layout2', 'layout3' ] );
		$this->add_dependecy ('use_external_link', 'skin', ['skin-3']);
		$this->add_dependecy( 'mosaics_skin', 'template', [ 'layout4' ] );
		$this->add_dependecy( 'mosaics_columns', 'template', [ 'layout4' ] );
		$this->add_dependecy( 'use_term', 'template', $layouts );
		$this->add_dependecy( 'use_heading', 'template', $layouts );
		$this->add_dependecy ('use_blockquote', 'skin', ['skin-6']);
		$this->add_dependecy ('t_blockquote', 'use_blockquote', 'true');
		$this->add_dependecy ('use_author', 'skin', ['skin-6']);
		$this->add_dependecy ('t_author', 'use_author', 'true');
		$this->add_dependecy ('btn_style', 'skin', ['skin-1', 'skin-6']);

		// Dependency.
		$this->add_dependecy( 'include', 'post_type', 'ids' );
		$this->add_dependecy( 'custom_query', 'post_type', 'custom' );
		$this->add_dependecy( 'meta_key', 'orderby', [ 'meta_value', 'meta_value_num' ] );

		$choices = $this->choices_post_types();
		unset( $choices['custom'], $choices['ids'] );
		$choices = \array_keys( $choices );
		$this->add_dependecy( 'offset', 'post_type', $choices );
		$this->add_dependecy( 'taxonomies', 'post_type', $choices );
		$this->add_dependecy( 'order', 'post_type', $choices );
		$this->add_dependecy( 'orderby', 'post_type', $choices );
		$this->add_dependecy( 'exclude', 'post_type', $choices );

		$choices_w_ids = $this->choices_post_types();
		unset( $choices_w_ids['custom'] );
		$choices_w_ids = \array_keys( $choices_w_ids );
		$this->add_dependecy( 'posts_limit', 'post_type', $choices_w_ids );

		$this->add_dependecy( 't_heading', 'template', $layouts );
		$this->add_dependecy( 't_heading', 'use_heading', 'true' );
		$this->add_dependecy( 't_term', 'template', $layouts );
		$this->add_dependecy( 't_term', 'use_term', 'true' );

		// filters & loading
		$this->add_dependecy( 'add_filter', 'template', [ 'view','layout1', 'layout2', 'layout3' ] );

		$this->add_dependecy( 'all_items_text', 'template',  [ 'view','layout1', 'layout2', 'layout3' ]);
		$this->add_dependecy( 'all_items_text', 'add_filter', 'true' );


		$this->add_dependecy( 'add_center_filter', 'template',  [ 'view','layout1', 'layout2', 'layout3' ]);

		$this->add_dependecy( 'add_center_filter', 'add_filter', 'true' );

		$this->add_dependecy( 'use_filter', 'template',  [ 'view','layout1', 'layout2', 'layout3' ]);
		$this->add_dependecy( 'use_filter', 'add_filter', 'true' );

		$this->add_dependecy( 'c_filter', 'template',  [ 'view','layout1', 'layout2', 'layout3' ]);
		$this->add_dependecy( 'c_filter', 'add_filter', 'true' );

		$this->add_dependecy( 't_filter', 'template',  [ 'view','layout1', 'layout2', 'layout3' ]);
		$this->add_dependecy( 't_filter', 'use_filter', 'true' );

		$this->add_dependecy( 'add_load_more', 'template', [ 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'add_pagination', 'template', [ 'layout2', 'layout3', 'layout4' ] );

		$this->add_dependecy( 'load_more_type', 'template', [ 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'load_more_type', 'add_load_more', 'true' );

		$this->add_dependecy( 'load_more_text', 'template', [ 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'load_more_text', 'add_load_more', 'true' );

		$this->add_dependecy( 'load_more_loading_text', 'template', [ 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'load_more_loading_text', 'add_load_more', 'true' );

		// spaces & count
		$this->add_dependecy( 'spaces', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'item_per_row', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'spaces_lg', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'item_per_row_lg', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'spaces_md', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'item_per_row_md', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'spaces_sm', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'item_per_row_sm', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'spaces_xs', 'template', [ 'layout2', 'layout3' ] );
		$this->add_dependecy( 'item_per_row_xs', 'template', [ 'layout2', 'layout3' ] );

		$this->add_dependecy( 'title_tag', 'template', [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ] );
		$this->add_dependecy( 'image_height', 'template', [ 'view', 'layout1', 'layout2', 'layout3' ] );

		// Builder.
		if ( 'visual-composer' === Helper::get_settings( 'general.builder' ) ) {
			require_once vc_path_dir( 'CONFIG_DIR', 'grids/vc-grids-functions.php' );
			require_once vc_path_dir( 'CONFIG_DIR', 'grids/class-vc-grids-common.php' );

			if ( 'vc_get_autocomplete_suggestion' === vc_request_param( 'action' ) || 'vc_edit_form' === vc_post_param( 'action' ) ) {

				// Narrow data taxonomies.
				add_filter( 'vc_autocomplete_aheto_custom-post-types_taxonomies_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
				add_filter( 'vc_autocomplete_aheto_custom-post-types_taxonomies_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

				// Narrow data taxonomies for exclude_filter.
				add_filter( 'vc_autocomplete_aheto_custom-post-types_exclude_callback', [
					$this,
					'autocomplete_posts_field'
				], 10, 0 );
				add_filter( 'vc_autocomplete_aheto_custom-post-types_include_callback', [
					$this,
					'autocomplete_posts_field'
				], 10, 0 );

				add_filter( 'vc_autocomplete_aheto_custom-post-types_exclude_render', 'vc_exclude_field_render', 10, 1 );
				add_filter( 'vc_autocomplete_aheto_custom-post-types_include_render', 'vc_include_field_render', 10, 1 );
			}
		}

		$this->register();
		$this->action( 'wp_print_footer_scripts', 'taxonomies_autocomplete' );
	}

	public function taxonomies_autocomplete()
	{
		$url = admin_url('admin-ajax.php');

		if(is_admin()){
			?>
			<script type="text/javascript">
				function initElements($scope) {
					if(typeof elementor !== "undefined" && typeof elementor.widgetsCache["aheto_custom-post-types"].controls.taxonomies !== "undefined") {
						elementor.widgetsCache["aheto_custom-post-types"].controls.taxonomies.select2options.ajax = {
							url: '<?php echo $url; ?>',
							dataType: 'json',
							data: function (params) {
								return {
									query: params.term,
									action: 'autocomplete_aheto_taxonomies'
								}
							},
							processResults: function (data) {
								return {
									results: data
								}
							}
						}
						elementor.widgetsCache["aheto_custom-post-types"].controls.exclude.select2options.ajax = {
							url: '<?php echo $url; ?>',
							dataType: 'json',
							data: function (params) {
								return {
									query: params.term,
									action: 'autocomplete_aheto_exclude_field_search',
									postType: jQuery('select', '.elementor-control-post_type.elementor-control-type-select').val()
								}
							},
							processResults: function (data) {
								return {
									results: data
								}
							}
						}
						elementor.widgetsCache["aheto_custom-post-types"].controls.include.select2options.ajax = {
							url: '<?php echo $url; ?>',
							dataType: 'json',
							data: function (params) {
								return {
									query: params.term,
									action: 'autocomplete_aheto_include_field_search'
								}
							},
							processResults: function (data) {
								return {
									results: data
								}
							}
						}
					}
				}
				window.addEventListener('load', function() {
					setTimeout(() => {
						initElements();
					}, 4000);
				});
				(typeof elementor !== "undefined") && elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {
					if ( 'aheto_custom-post-types' === model.attributes.widgetType ) {
						initElements();
						setTimeout(() => {
							initElements();
						}, 1000);
					}
				} );
			</script>
			<?php
		}
	}

	/**
	 * Set dependent scripts
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'lity', 'swiper', 'isotope', 'imagesloaded' ];
	}

	/**
	 * Set dependent style
	 *
	 * @return array
	 */
	public function get_style_depends() {
		return [ 'lity', 'swiper' ];
	}

	/**
	 * Get the element raw data.
	 *
	 * Retrieve the raw element data, including the id, type, settings, child
	 * elements and whether it is an inner element.
	 *
	 * The data with the HTML used always to display the data, but the Elementor
	 * editor uses the raw data without the HTML in order not to render the data
	 * again.
	 *
	 * @param bool $with_html_content Optional. Whether to return the data with
	 *                                HTML content or without. Used for caching.
	 *                                Default is false, without HTML.
	 *
	 * @return array Element raw data.
	 */
	public function get_raw_data( $with_html_content = false ) {
		$data = parent::get_raw_data( $with_html_content );

		// Taxonomies.
		$value = isset( $data['settings']['taxonomies'] ) ? $data['settings']['taxonomies'] : false;
		if ( $value ) {
			$terms = $this->taxonomies_field_render( $value );
			if ( $terms ) {
				$control            = $this->get_controls( 'taxonomies' );
				$control['options'] = [];

				foreach ( $terms as $term ) {
					if ( ! empty( $term ) ) {
						$control['options'][ $term->term_id ] = $term->name;
					}
				}
				$this->update_control( 'taxonomies', $control );
			}
		}

		// Exclude.
		$value = isset( $data['settings']['exclude'] ) ? $data['settings']['exclude'] : false;
		if ( $value ) {
			$this->post_field_render( 'exclude', $value );
		}

		// Include.
		$value = isset( $data['settings']['include'] ) ? $data['settings']['include'] : false;
		if ( $value ) {
			$this->post_field_render( 'include', $value );
		}

		return apply_filters( "aheto_cpt_get_raw_data", $data, $this );
	}

	/**
	 * Get render control for posts autocomplete.
	 */
	public function post_field_render( $control_id, $ids ) {
		$control            = $this->get_controls( $control_id );
		$control['options'] = [];


		if(is_array($ids)){
			foreach ( $ids as $post_id ) {
				$post = get_post( $post_id );
				if ( ! is_null( $post ) ) {
					$control['options'][ $post_id ] = $post->post_title;
				}
			}
		}else{
			$post = get_post( $ids );
			if ( ! is_null( $post ) ) {
				$control['options'][ $ids ] = $post->post_title;
			}
		}

		$this->update_control( $control_id, $control );
	}


	/**
	 * Get render value for taxonomies.
	 *
	 * @param mixed $term Term id.
	 *
	 * @return array|bool
	 */
	private function taxonomies_field_render( $term ) {
		$taxonomies = Helper::get_taxonomies_types();
		$terms      = get_terms(
			array_keys( $taxonomies ),
			[
				'include'    => (array) $term,
				'hide_empty' => false,
			]
		);

		if ( is_array( $terms ) ) {
			return $terms;
		}

		return false;
	}

	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->add_params( [
			'skin' => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Skin', 'aheto' ),
				'description' => esc_html__( 'Select skin for your post types.', 'aheto' ),
				'options'     => [
					'skin-1' => 'Skin 1',
					'skin-2' => 'Skin 2',
					'skin-3' => 'Skin 3',
					'skin-4' => 'Skin 4',
					'skin-5' => 'Skin 5',
					'skin-6' => 'Skin 6',
					'skin-7' => 'Skin 7',
					'skin-8' => 'Skin 8',
				],
				'default'     => 'skin-1',
				'grid'     => 6,
			],
			'mosaics_skin' => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Mosaics Skin', 'aheto' ),
				'description' => esc_html__( 'Select skin for your post types.', 'aheto' ),
				'options'     => [
					'skin-8' => 'Mosaics Skin 1',
					'skin-1' => 'Mosaics Skin 2',
					'skin-2' => 'Mosaics Skin 3',
					'skin-4' => 'Mosaics Skin 4',
				],
				'default'     => 'skin-8',
				'grid'     => 6,
			],
			'mosaics_columns' => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Mosaics Columns', 'aheto' ),
				'description' => esc_html__( 'Select skin for your post types.', 'aheto' ),
				'options'     => [
					'two' => 'Two',
					'three' => 'Three',
				],
				'default'     => 'two',
				'grid'     => 6,
			],
			'use_external_link'        => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Use external link?', 'aheto' ),
				'description' => esc_html__( 'You can set external link in post detail page', 'aheto' ),
				'grid'        => 6,
				'default'     => '',
			],
			'btn_style' => [
				'type'        => 'select',
				'heading' => esc_html__( 'Button style', 'aheto' ),
				'options' => [
					'aheto-btn--primary' => esc_html__( 'Primary', 'aheto' ),
					'aheto-btn--dark'    => esc_html__( 'Dark', 'aheto' ),
					'aheto-btn--light'   => esc_html__( 'Light', 'aheto' ),
				],
				'default' => 'aheto-btn--primary',
				'grid'     => 6,
			],
		] );

		$image_sizer_layouts = [ 'view', 'layout1', 'layout2', 'layout3', 'layout4' ];
		$image_sizer_layouts = apply_filters( "aheto_cpt_image_sizer_layouts", $image_sizer_layouts );

		\Aheto\Params::add_image_sizer_params( $this, [
			'prefix'     => 'cpt_',
			'dependency' => [ 'template', $image_sizer_layouts ]
		] );

		$this->add_params( [
			'add_filter'        => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Add filters?', 'aheto' ),
				'group'       => esc_html__( 'Filters', 'aheto' ),
				'description' => esc_html__( 'This will display filters on the top', 'aheto' ),
				'grid'        => 6,
				'default'     => '',
			],
			'all_items_text'    => [
				'type'    => 'text',
				'group'   => esc_html__( 'Filters', 'aheto' ),
				'heading' => esc_html__( 'All items text', 'aheto' ),
				'default' => esc_html__( 'All Projects', 'aheto' ),
				'value'   => esc_html__( 'All Projects', 'aheto' ),
				'grid'    => 6,
			],
			'add_center_filter' => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Enable Centered Style?', 'aheto' ),
				'group'       => esc_html__( 'Filters', 'aheto' ),
				'description' => esc_html__( 'This will display filters on the center', 'aheto' ),
				'grid'        => 6,
			],
			'use_filter'    => [
				'type'        => 'switch',
				'group'       => esc_html__( 'Filters', 'aheto' ),
				'heading'     => esc_html__( 'Use custom font for filter?', 'aheto' ),
				'grid'        => 3,
			],
			't_filter'      => [
				'type'     => 'typography',
				'group'    => 'Filter Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-filter a',
			],
			'c_filter'       => [
				'type'      => 'colorpicker',
				'group'       => esc_html__( 'Filters', 'aheto' ),
				'heading'   => esc_html__('Custom color for filter active', 'aheto'),
				'grid'      => 6,
				'selectors' => [
					'{{WRAPPER}} .aheto-cpt-filter a:hover'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .aheto-cpt-filter a.is-active' => 'color: {{VALUE}}',
				],
			],
		] );

		$this->add_params( [
			'add_pagination'         => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Add pagination?', 'aheto' ),
				'description' => esc_html__( 'Do not use pagination and load more options together', 'aheto' ),
				'group'       => esc_html__( 'Pagination', 'aheto' ),
			]
		] );



		$this->add_params( [
			'add_load_more'          => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Add load more?', 'aheto' ),
				'description' => esc_html__( 'Do not use pagination and load more options together', 'aheto' ),
				'group'       => esc_html__( 'Load More', 'aheto' ),
			],
			'load_more_type'         => [
				'type'    => 'select',
				'heading' => esc_html__( 'Load more type', 'aheto' ),
				'group'   => esc_html__( 'Load More', 'aheto' ),
				'options' => [
					'button' => esc_html__( 'Button', 'aheto' ),
					'scroll' => esc_html__( 'Infinity scroll', 'aheto' ),
				],
			],
			'load_more_text'         => [
				'type'    => 'text',
				'group'   => esc_html__( 'Load More', 'aheto' ),
				'heading' => esc_html__( 'Button name(static)', 'aheto' ),
				'default' => esc_html__( 'LOAD MORE', 'aheto' ),
				'value'   => esc_html__( 'LOAD MORE', 'aheto' ),
				'grid'    => 6,
			],
			'load_more_loading_text' => [
				'type'    => 'text',
				'group'   => esc_html__( 'Load More', 'aheto' ),
				'heading' => esc_html__( 'Button name(loading)', 'aheto' ),
				'default' => esc_html__( 'LOADING...', 'aheto' ),
				'value'   => esc_html__( 'LOADING...', 'aheto' ),
				'grid'    => 6,
			],
		] );

		\Aheto\Params::add_button_params( $this, [
			'add_button' => false,
			'prefix'     => 'load_more_btn_',
			'link'       => false,
			'group'      => esc_html__( 'Load More', 'aheto' ),
			'dependency' => [ 'load_more_type', 'button' ],
		] );


		\Aheto\Params::add_icon_params( $this, [
			'add_icon'   => true,
			'add_label'  => esc_html__( 'Add icon for button?', 'aheto' ),
			'prefix'     => 'btn_icon_',
			'exclude'    => [ 'align' ],
			'group'       => esc_html__( 'Content', 'aheto' ),
			'dependency' => [ 'skin', 'skin-6' ]
		] );

		// Data Settings.
		$this->add_params( [
			'post_type'       => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Data source', 'aheto' ),
				'description' => esc_html__( 'Select content type for your grid.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'options'     => $this->choices_post_types(),
				'grid'        => 8,
			],
			'terms'           => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Terms', 'aheto' ),
				'description' => esc_html__( 'Select terms. It works for skins that have a terms.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'options'     => Helper::get_taxonomies_list(),
			],
			'only_with_thumb' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Hide posts that have not main thumbnails?', 'aheto' ),
				'group'   => esc_html__( 'Data Settings', 'aheto' ),
				'label_block' => true
			],
			'posts_limit'     => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Total items', 'aheto' ),
				'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'value'       => 4,
				'default'     => 4,
				'grid'        => 6,
			],
			'offset'          => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Offset', 'aheto' ),
				'description' => esc_html__( 'Number of posts which will be skipped from start.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'grid'        => 6,
			],
			'orderby'         => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Order by', 'aheto' ),
				'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'grid'        => 6,
				'options'     => [
					'date'           => esc_html__( 'Date', 'aheto' ),
					'ID'             => esc_html__( 'Order by post ID', 'aheto' ),
					'author'         => esc_html__( 'Author', 'aheto' ),
					'title'          => esc_html__( 'Title', 'aheto' ),
					'modified'       => esc_html__( 'Last modified date', 'aheto' ),
					'parent'         => esc_html__( 'Post/page parent ID', 'aheto' ),
					'comment_count'  => esc_html__( 'Number of comments', 'aheto' ),
					'menu_order'     => esc_html__( 'Menu order/Page Order', 'aheto' ),
					'meta_value'     => esc_html__( 'Meta value', 'aheto' ),
					'meta_value_num' => esc_html__( 'Meta value number', 'aheto' ),
					'rand'           => esc_html__( 'Random order', 'aheto' ),
				],
			],
			'order'           => [
				'type'        => 'select',
				'heading'     => esc_html__( 'Sort order', 'aheto' ),
				'description' => esc_html__( 'Select sorting order.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'grid'        => 6,
				'options'     => [
					'DESC' => esc_html__( 'Descending', 'aheto' ),
					'ASC'  => esc_html__( 'Ascending', 'aheto' ),
				],
			],
			'meta_key'        => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Meta key', 'aheto' ),
				'description' => esc_html__( 'Input meta key for grid ordering.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'grid'        => 6,
			],
			'excerpt_length'  => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Excerpt Length', 'aheto' ),
				'description' => esc_html__( 'Set the excerpt length or leave blank to set default 55 words', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
				'value'       => 10,
				'grid'        => 6,
			],
			'taxonomies'      => [
				'type'           => 'autocomplete',
				'heading'        => esc_html__( 'Narrow data source', 'aheto' ),
				'description'    => esc_html__( 'Enter categories, tags or custom taxonomies.', 'aheto' ),
				'group'          => esc_html__( 'Data Settings', 'aheto' ),
				'settings'       => [
					'multiple'       => true,
					'min_length'     => 1,
					'groups'         => true,
					'unique_values'  => true,
					'display_inline' => true,
					'delay'          => 500,
					'auto_focus'     => true,
				],
				'multiple'       => true,
				'label_block'       => true,
				'select2options' => [
					'ajax' => null,
				],

			],
			'exclude'         => [
				'type'           => 'autocomplete',
				'heading'        => esc_html__( 'Exclude', 'aheto' ),
				'description'    => esc_html__( 'Exclude posts, pages, etc. by title.', 'aheto' ),
				'group'          => esc_html__( 'Data Settings', 'aheto' ),
				'settings'       => [
					'multiple' => true,
					'groups'   => true,
				],
				'multiple'       => true,
				'label_block'       => true,
				'select2options' => [
					'ajax' => null,
				],
			],
			'include'         => [
				'type'           => 'autocomplete',
				'heading'        => esc_html__( 'Include only', 'aheto' ),
				'description'    => esc_html__( 'Add posts, pages, etc. by title.', 'aheto' ),
				'group'          => esc_html__( 'Data Settings', 'aheto' ),
				'label_block'       => true,
				'settings'       => [
					'multiple' => true,
					'sortable' => true,
					'groups'   => true,
				],
				'multiple'       => true,
				'select2options' => [
					'ajax' => null,
				],
			],
			'custom_query'    => [
				'type'        => 'textarea_safe',
				'heading'     => esc_html__( 'Custom query', 'aheto' ),
				'description' => __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'aheto' ),
				'group'       => esc_html__( 'Data Settings', 'aheto' ),
			],
		] );

		$this->add_params( [
			'title_tag'       => [
				'type'    => 'select',
				'heading' => esc_html__( 'Element tag for title', 'aheto' ),
				'group'   => esc_html__( 'Content Settings', 'aheto' ),
				'options' => [
					'h1'  => 'h1',
					'h2'  => 'h2',
					'h3'  => 'h3',
					'h4'  => 'h4',
					'h5'  => 'h5',
					'h6'  => 'h6',
					'p'   => 'p',
					'div' => 'div',
				],
				'default' => 'h4',
			],
			'item_per_row'    => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Item per row', 'aheto' ),
				'group'     => esc_html__( 'Content Settings', 'aheto' ),
				'default'   => 3,
				'value'     => 3,
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-cpt__list' => '--count: {{VALUE}}' ],
			],
			'spaces'          => [
				'type'      => 'text',
				'heading'   => esc_html__( 'Spaces', 'aheto' ),
				'group'     => esc_html__( 'Content Settings', 'aheto' ),
				'default'   => 30,
				'value'     => 30,
				'grid'      => 6,
				'selectors' => [ '{{WRAPPER}} .aheto-cpt__list' => '--spaces: {{VALUE}}' ],
			],
			'item_per_row_lg' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(lg)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'default'     => 3,
				'value'       => 3,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--count-lg: {{VALUE}}' ],
			],
			'spaces_lg'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(lg)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 1200px', 'aheto' ),
				'default'     => 30,
				'value'       => 30,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--spaces-lg: {{VALUE}}' ],
			],
			'item_per_row_md' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(md)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'default'     => 2,
				'value'       => 2,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--count-md: {{VALUE}}' ],
			],
			'spaces_md'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(md)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 991px', 'aheto' ),
				'default'     => 20,
				'value'       => 20,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--spaces-md: {{VALUE}}' ],
			],
			'item_per_row_sm' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(sm)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'default'     => 2,
				'value'       => 2,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--count-sm: {{VALUE}}' ],
			],
			'spaces_sm'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(sm)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 768px', 'aheto' ),
				'default'     => 20,
				'value'       => 20,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--spaces-sm: {{VALUE}}' ],
			],
			'item_per_row_xs' => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Item per row(xs)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'default'     => 1,
				'value'       => 1,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--count-xs: {{VALUE}}' ],
			],
			'spaces_xs'       => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Spaces(xs)', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'description' => esc_html__( '< 480px', 'aheto' ),
				'default'     => 15,
				'value'       => 15,
				'grid'        => 6,
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt__list' => '--spaces-xs: {{VALUE}}' ],
			],
			'image_height'    => [
				'type'        => 'text',
				'heading'     => esc_html__( 'Image Height', 'aheto' ),
				'description' => esc_html__( 'Height relative to image width (percentage). Value between 30-100. Only for masonry layout and grid layout', 'aheto' ),
				'group'       => esc_html__( 'Content Settings', 'aheto' ),
				'selectors'   => [ '{{WRAPPER}} .aheto-cpt-article' => '--img-height: {{VALUE}}' ],
			],
		] );

		$this->add_params( [
			'use_heading' => [
				'type'    => 'switch',
				'heading' => esc_html__( 'Use custom font for title?', 'aheto' ),
				'grid'    => 3,
			],
			't_heading'   => [
				'type'     => 'typography',
				'group'    => 'Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-article__title',
			],
			'use_term'    => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Use custom font for terms?', 'aheto' ),
				'description' => esc_html__( 'It works for skins that have a terms.', 'aheto' ),
				'grid'        => 3,
			],
			't_term'      => [
				'type'     => 'typography',
				'group'    => 'Term Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-article__terms',
			],
			'use_blockquote'    => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Use custom font for blockquote?', 'aheto' ),
				'description' => esc_html__( 'It works for skins that have a blockquote.', 'aheto' ),
				'grid'        => 3,
			],
			't_blockquote'      => [
				'type'     => 'typography',
				'group'    => 'Blockquote Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-article__quote > h3',
			],
			'use_author'    => [
				'type'        => 'switch',
				'heading'     => esc_html__( 'Use custom font for Author?', 'aheto' ),
				'description' => esc_html__( 'It works for skins that have a Author.', 'aheto' ),
				'grid'        => 3,
			],
			't_author'      => [
				'type'     => 'typography',
				'group'    => 'Author Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-cpt-article__quote cite',
			]
		] );

		// Swiper Settings.
		$carousel_params = [
			'custom_options' => true,
			'prefix'         => 'swiper_',
			'include'        => [
				'pagination',
				'arrows',
				'loop',
				'autoplay',
				'overflow',
				'centeredSlides',
				'speed',
				'slides',
				'spaces',
				'simulate_touch',
				'arrows_color',
				'arrows_size',
				'lazy'
			],
			'dependency'     => [ 'template', [ 'view', 'layout1' ] ],
		];

		$carousel_params = apply_filters( "aheto_cpt_carousel", $carousel_params );

		\Aheto\Params::add_carousel_params( $this, $carousel_params );

		// Advanced Settings.
		$this->add_params( [ 'advanced' => true ] );
	}

	/**
	 * Get WP_Query.
	 *
	 * @return WP_Query
	 */
	protected function get_wp_query() {

		return new \WP_Query( $this->build_query() );
	}

	/**
	 * Build WP_Query.
	 *
	 * @return array
	 */
	protected function build_query() {
		extract( $this->atts );


		// Custom query.
		if ( 'custom' === $post_type && ! empty( $custom_query ) ) {

			//$custom_query = preg_match( '/^#E\-8_/', $custom_query ) ? rawurldecode( base64_decode( preg_replace( '/^#E\-8_/', '', $custom_query ) ) ) : $custom_query;
			$query = html_entity_decode( $custom_query, ENT_QUOTES, 'utf-8' );

			return wp_parse_args( $query );
		}

		// IDs only.
		if ( 'ids' === $post_type ) {

			if ( empty( $include ) ) {
				$include = - 1;
			}

			$include  = wp_parse_id_list( $include );
			$settings = [
				'posts_per_page'      => isset( $posts_limit ) ? (int) $posts_limit : 100,
				'post__in'            => $include,
				'ignore_sticky_posts' => true,
				'post_type'           => 'any',
				'orderby'             => 'post__in',
				'paged'               => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			];

			if ( isset( $only_with_thumb ) && $only_with_thumb ) {
				$settings['meta_query'] = [
					[
						'key' => '_thumbnail_id',
					],
				];
			}

			return $settings;
		}

		$settings = [
			'posts_per_page'      => isset( $posts_limit ) ? (int) $posts_limit : 100,
			'offset'              => $offset,
			'orderby'             => $orderby,
			'order'               => $order,
			'meta_key'            => in_array( $orderby, [ 'meta_value', 'meta_value_num' ] ) ? $meta_key : '',
			'post_type'           => $post_type,
			'post__not_in'        => wp_parse_id_list( $exclude ),
			'ignore_sticky_posts' => true,
			'paged'               => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		];

		if ( $settings['posts_per_page'] < 1 ) {
			$settings['posts_per_page'] = 100;
		}

		if ( isset( $only_with_thumb ) && $only_with_thumb ) {
			$settings['meta_query'] = [
				[
					'key' => '_thumbnail_id',
				],
			];
		}


		if ( ! empty( $taxonomies ) ) {
			$vc_taxonomies_types = get_taxonomies( [ 'public' => true ] );

			$terms = get_terms( array_keys( $vc_taxonomies_types ), [
				'hide_empty' => false,
				'include'    => $taxonomies,
			] );

			$settings['tax_query'] = [];

			$tax_queries = [];

			foreach ( $terms as $t ) {

				if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
					$tax_queries[ $t->taxonomy ] = [
						'taxonomy' => $t->taxonomy,
						'field'    => 'id',
						'terms'    => [ $t->term_id ],
						'relation' => 'IN',
					];
				} else {
					$tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
				}
			}
			$settings['tax_query']             = array_values( $tax_queries );
			$settings['tax_query']['relation'] = 'OR';
		}

		wp_reset_postdata();

		return $settings;
	}

	/**
	 * Add excerpt filter.
	 */
	public function add_excerpt_filter() {
		$this->filter( 'excerpt_more', 'excerpt_more' );
		$this->filter( 'excerpt_length', 'excerpt_lengh', 999 );
		$this->filter( 'wp_trim_excerpt', 'wp_trim_excerpt', 10, 2 );
	}

	/**
	 * Remove excerpt filter.
	 */
	public function remove_excerpt_filter() {
		$this->remove_filter( 'excerpt_more', 'excerpt_more' );
		$this->remove_filter( 'excerpt_length', 'excerpt_lengh', 999 );
		$this->remove_filter( 'wp_trim_excerpt', 'wp_trim_excerpt', 10, 2 );
	}

	/**
	 * Set excerpt length.
	 *
	 * @param  int $length Length of excerpt.
	 *
	 * @return int
	 */
	public function excerpt_lengh( $length ) {
		return empty( $this->atts['excerpt_length'] ) ? $length : $this->atts['excerpt_length'];
	}

	/**
	 * Set excerpt more text.
	 *
	 * @param  string $more Excerpt more text.
	 *
	 * @return string
	 */
	public function excerpt_more( $more ) {
		return empty( $this->atts['excerpt_more'] ) ? $more : $this->atts['excerpt_more'];
	}

	/**
	 * Trim excerpt as well.
	 *
	 * @param string $text The trimmed text.
	 * @param string $raw_excerpt The text prior to trimming.
	 *
	 * @return string
	 */
	public function wp_trim_excerpt( $text, $raw_excerpt ) {
		if ( '' === $raw_excerpt ) {
			return $text;
		}

		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

		return wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}

	/**
	 * Get template part.
	 *
	 * @param string $part Part name.
	 */
	protected function get_template_part( $part, $atts = [] ) {
		$file = "{$this->partials}partials/{$part}.php";
		if ( file_exists( $file ) ) {
			include $file;
		}
	}

	/**
	 * Get skin part.
	 *
	 * @param string $part Part name.
	 */
	protected function get_skin_part( $part, $atts, $counter = 1, $swiper_prefix = '' ) {

		$directory_addon  = WP_PLUGIN_DIR . '/aheto-wdsg-add-ons/shortcodes/custom-post-types/';
		$directory_theme = get_template_directory() . '/aheto/custom-post-types/';
		$file_theme            = "{$directory_theme}skins/{$part}.php";
		$file_addon            = "{$directory_addon}skins/{$part}.php";

		if ( file_exists( $file_theme ) ) {
			require $file_theme;

		}elseif(file_exists( $file_addon ) ){
			require $file_addon;

		}else {
			$file = "{$this->partials}skins/{$part}.php";
			if ( file_exists( $file ) ) {
				require $file;
			}
		}
	}

	/**
	 * Get post format.
	 *
	 * @return string
	 */
	protected function get_post_format() {
		$format = get_post_format();
		$format = $format ? $format : 'image';

		if ( 'gallery' !== $format ) {
			return $format;
		}

		$as_slider = get_post_meta( get_the_ID(), 'aheto_post_as_slider', true );

		return 'on' === $as_slider ? 'slider' : $format;
	}

	/**
	 * Get term classes.
	 *
	 * @param  string $taxonomy Taxonomy.
	 *
	 * @return string
	 */
	protected function get_terms( $taxonomy ) {
		$data  = [];
		$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return $data;
		}

		foreach ( $terms as $term ) {
			$data[ $term->term_id ] = $term->name;
		}

		return $data;
	}

	/**
	 * Post type choices.
	 *
	 * @return array
	 */
	private function choices_post_types() {
		$list       = [];
		$excluded   = [
			'revision',
			'attachment',
			'nav_menu_item',
			'aheto-footer',
			'aheto-header',
			'aheto-mega-menu',
			'wpcf7_contact_form',
			'vc_grid_item',
		];
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$post_types = apply_filters( 'aheto_choices_post_types', $post_types );

		if ( is_array( $post_types ) && ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type => $obj ) {
				if ( ! in_array( $post_type, $excluded ) ) {
					$list[ $post_type ] = $obj->label;
				}
			}
		}
		$list['custom'] = esc_html__( 'Custom query', 'aheto' );
		$list['ids']    = esc_html__( 'List of IDs', 'aheto' );

		return $list;
	}

	/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 *
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {
		if ( ! empty( $this->atts['use_heading'] ) && ! empty( $this->atts['t_heading'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__title'], $this->parse_typography( $this->atts['t_heading'] ) );
		}

		if ( isset( $this->atts['use_blockquote'] ) && $this->atts['use_blockquote']  && isset($this->atts['t_blockquote']) && ! empty( $this->atts['t_blockquote'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote > h3'], $this->parse_typography( $this->atts['t_blockquote'] ) );
		}

		if ( isset( $this->atts['use_author'] ) && $this->atts['use_author']  && isset($this->atts['t_author']) && ! empty( $this->atts['t_author'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote cite'], $this->parse_typography( $this->atts['t_author'] ) );
		}

		if ( ! empty( $this->atts['use_term'] ) && ! empty( $this->atts['t_term'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__terms'], $this->parse_typography( $this->atts['t_term'] ) );
		}

		if ( ! empty( $this->atts['use_filter'] ) && ! empty( $this->atts['t_filter'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-cpt-filter a'], $this->parse_typography( $this->atts['t_filter'] ) );
		}

		if ( !empty($this->atts['c_filter']) ) {
			$color = Sanitize::color($this->atts['color']);
			$css['global']['%1$s .aheto-cpt-filter a:hover']['color']    = $color;
			$css['global']['%1$s .aheto-cpt-filter a.is-active']['color'] = $color;
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--count'] = $this->atts['item_per_row'];
		}

		if ( $this->isSpacesValid( $this->atts['spaces'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--spaces'] = $this->atts['spaces'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_lg'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--count-lg'] = $this->atts['item_per_row_lg'];
		}

		if ( $this->isSpacesValid( $this->atts['spaces_lg'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--spaces-lg'] = $this->atts['spaces_lg'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_md'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--count-md'] = $this->atts['item_per_row_md'];
		}

		if ( $this->isSpacesValid( $this->atts['spaces_md'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--spaces-md'] = $this->atts['spaces_md'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_sm'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--count-sm'] = $this->atts['item_per_row_sm'];
		}

		if ( $this->isSpacesValid( $this->atts['spaces_sm'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--spaces-sm'] = $this->atts['spaces_sm'];
		}

		if ( $this->isSpacesValid( $this->atts['item_per_row_xs'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--count-xs'] = $this->atts['item_per_row_xs'];
		}

		if ( $this->isSpacesValid( $this->atts['spaces_xs'] ) ) {
			$css['global']['%1$s .aheto-cpt__list.js-isotope']['--spaces-xs'] = $this->atts['spaces_xs'];
		}

		if ( ! empty( $this->atts['image_height'] ) && is_numeric( $this->atts['image_height'] ) && $this->atts['image_height'] > 0 ) {
			$css['global']['%1$s .aheto-cpt-article']['--img-height'] = $this->atts['image_height'];
		}

		if ( !empty($this->atts['arrows_color']) ) {
			$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($this->atts['arrows_color']);
		}

		if ( !empty($this->atts['arrows_size']) ) {
			$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size($this->atts['arrows_size'] );
		}

		return apply_filters( "aheto_cpt_dynamic_css", $css, $this );
	}

	/**
	 * @param $space
	 *
	 * @return bool
	 */
	public function isSpacesValid( $space ) {
		return isset( $space ) && is_numeric( $space ) && $space >= 0;
	}

	/**
	 * @param $count
	 *
	 * @return bool
	 */
	public function isItemsValid( $count ) {
		return ! empty( $count ) && is_numeric( $count ) && $count > 0;
	}

	/**
	 * Autocomplete posts field search
	 */
	public function autocomplete_posts_field() {
		$query = isset( $_REQUEST['query'] ) ? $_REQUEST['query'] : false;
		if ( false ) {
			return [];
		}

		$data        = [];
		$search_args = [
			's'                => $query,
			'post_type'        => isset( $_REQUEST['postType'] ) ? $_REQUEST['postType'] : 'any',
			'posts_per_page'   => - 1,
			'suppress_filters' => false,
		];

		if ( 0 === strlen( $search_args['s'] ) ) {
			unset( $search_args['s'] );
		}

		$this->filter( 'posts_search', 'search_by_title_only', 100, 2 );
		$posts = get_posts( $search_args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = [
					'value' => $post->ID,
					'label' => $post->post_title,
					'group' => $post->post_type,
				];
			}
		}

		wp_send_json( $data );
	}

	/**
	 * Search by title only
	 *
	 * @param string $search Search term.
	 * @param \WP_Query $wp_query Query instance.
	 *
	 * @return string
	 */
	public function search_by_title_only( $search, $wp_query ) {
		global $wpdb;

		if ( empty( $search ) ) {
			return $search; // skip processing - no search term in query.
		}

		$q = $wp_query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';

		$search    = '';
		$searchand = '';

		foreach ( (array) $q['search_terms'] as $term ) {
			$term      = $wpdb->esc_like( $term );
			$like      = $n . $term . $n;
			$search    .= $wpdb->prepare( "{$searchand}($wpdb->posts.post_title LIKE %s)", $like );
			$searchand = ' AND ';
		}

		if ( ! empty( $search ) ) {
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() ) {
				$search .= " AND ($wpdb->posts.post_password = '') ";
			}
		}

		return $search;
	}

	/**
	 * @param bool $add_filter
	 * @param      $filters
	 * @param      $id
	 */
	public function cpt_filter( $add_filter, $filters, $id, $all_items_text, $add_center_filter, $is_swiper = false, $pages = 0 ) {

		if ( isset($add_filter) && $add_filter ) {
			$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
			wp_enqueue_style( 'custom-post-types--filter', $sc_dir . 'assets/css/filter1.css', null, null );

			$add_center_filter = $add_center_filter ? 'center-filter' : '';
			$swiperClass = isset($is_swiper) && $is_swiper ? ' swiper-filter' : '';
			?>

			<ul class="aheto-cpt-filter <?php echo esc_attr( $add_center_filter . $swiperClass); ?>">
				<li class="aheto-cpt-filter__item aheto-cpt-filter__item--all">
					<a href="#" class="is-active" data-filter="*"
					   data-cpt-id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $all_items_text ); ?></a>
				</li>

				<?php

				$filters_unique = [];
				foreach ( $filters as $current ) {
					if ( ! in_array( $current, $filters_unique ) ) {
						$filters_unique[] = $current;
					}
				}

				foreach ( $filters_unique as $term ) : ?>
					<li class="aheto-cpt-filter__item">
						<a href="#" data-filter=".filter-<?php echo esc_attr( $term->slug ); ?>"
						   data-cpt-id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $term->name ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php
		}
	}

	/**
	 * Create load more html & init wp ajax
	 *
	 * @param $atts  array width settings
	 * @param $pages number pages
	 * @param $id
	 */
	public function cpt_load_more( $atts, $pages, $id ) {
		if ( $atts['add_load_more'] && $pages > 1 ) {

			wp_localize_script(
				'aheto-main',
				$id,
				[
					'ajaxurl'  => admin_url( 'admin-ajax.php' ),
					'nextPage' => ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) + 1,
					'maxPage'  => $pages,
					'nextLink' => next_posts( 0, false ),
				]
			);

			$atts['load_more_loading_text'] = $atts['load_more_loading_text'] ? $atts['load_more_loading_text'] : esc_html__( 'Loading...' );
			$atts['load_more_btn_title']    = $atts['load_more_text'] ? $atts['load_more_text'] : esc_html__( 'LOAD MORE' );

			switch ( $atts['load_more_type'] ) {
				case 'scroll':
					$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
					wp_enqueue_style( 'custom-post-types--pagination-scroll', $sc_dir . 'assets/css/pagination-scroll.css', null, null );
					{ ?>
						<div class="aheto-cpt-load aheto-cpt-load--scroll t-center js-lazyload-infinity"
							 data-cpt-id="<?php echo esc_attr( $id ); ?>"
							 data-loading-text="<?php echo esc_attr( $atts['load_more_loading_text'] ); ?>"
							 data-static-text="<?php echo esc_attr( $atts['load_more_btn_title'] ); ?>">
							<p>
								<i class="ion-load-d"></i><span><?php echo esc_html( $atts['load_more_btn_title'] ); ?></span>
							</p>
						</div>
						<?php

						break;
					}

				case 'button':
				default:
					$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
					wp_enqueue_style( 'custom-post-types--pagination-button', $sc_dir . 'assets/css/pagination-button.css', null, null );

					{
						?>
						<div class="aheto-cpt-load aheto-cpt-load--button t-center js-lazyload-button"
							 data-cpt-id="<?php echo esc_attr( $id ); ?>"
							 data-loading-text="<?php echo esc_attr( $atts['load_more_loading_text'] ); ?>"
							 data-static-text="<?php echo esc_attr( $atts['load_more_btn_title'] ); ?>">
							<?php echo Helper::get_button( $this, $atts, 'load_more_btn_' ); ?>
						</div>
					<?php }
			} ?>
		<?php }
	}

	/**
	 * Create load more html & init wp ajax
	 *
	 * @param $atts  array width settings
	 * @param $pages number pages
	 * @param $id
	 */
	public function cpt_pagination( $atts, $pages ) {

		if ( $atts['add_pagination'] && $pages > 1 ) {

			$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
			wp_enqueue_style( 'custom-post-types--pagination-numbers', $sc_dir . 'assets/css/pagination-numbers.css', null, null ); ?>

			<div class="aheto-cpt-pagination t-center">
				<?php echo paginate_links( array(
					'total' => $pages,
					'prev_text'          => __( '<i class="ion-arrow-left-c"></i> PREV' ),
					'next_text'          => __( 'NEXT <i class="ion-arrow-right-c"></i>' ),
				) ); ?>

			</div>
		<?php }
	}

	/**
	 * @param string $imgClass
	 * @param string $mod
	 * @param string $size
	 * @param bool $link
	 * @param bool $forceOutput
	 *
	 * @return bool
	 */
	public function getImage( $imgClass = '', $mod = '', $size = 'full', $link = false, $forceOutput = true, $image_atts = [], $prefix = '', $swiper_prefix = '' ) {

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
		$swiper_lazy = !empty($swiper_prefix) ? $image_atts[$swiper_prefix . 'lazy'] : false;

		$classes[] = $swiper_lazy ? 'swiper-lazy' : '';

		$post_image_id = get_post_thumbnail_id();
		$image         = array();
		$image['id']   = $post_image_id;

		$background_image = $has_thumb && $has_bg ? Helper::get_background_attachment( $image, $size, $image_atts, $prefix, $swiper_lazy ) : ''; ?>

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
	public function getDate( $mod = '' ) {
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
	public function getTitle( $mod = '' ) {
		$classes   = [];
		$classes[] = 'aheto-cpt-article__title';
		if ( $mod ) {
			$classes[] = $mod;
		}

		$aheto_external_link  = get_post_meta( get_the_ID(), 'aheto_external_link', true );
		$post_link = isset($aheto_external_link) && !empty($aheto_external_link) && 'skin-3' === $this->atts['skin'] ? $aheto_external_link : get_permalink( get_the_ID());
		$target = isset($aheto_external_link) && !empty($aheto_external_link) ? '_blank' : '_self';

		$tag           = isset( $this->atts['title_tag'] ) && ! empty( $this->atts['title_tag'] ) ? $this->atts['title_tag'] : 'h4';
		$title_attr    = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
		$title_content = '<a title="' . get_the_title() . '" href="' . $post_link . '" target="' . esc_attr($target) . '">' . get_the_title() . '</a>';


		echo '<' . $tag . ' ' . $title_attr . '>' . $title_content . '</' . $tag . '>';
	}

	/**
	 * @param string $mod
	 */
	public function getExcerpt( $mod = '' ) {
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
	public function getLink( $mod = '', $name = '', $icon_html = '', $icon_position = 'left' ) {
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
			   class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<?php if(!empty( $icon_html ) && $icon_position === 'left'){
					echo $icon_html;
				}
				echo esc_html( $name );

				if(!empty( $icon_html ) && $icon_position === 'right'){
					echo $icon_html;
				} ?>
			</a>
		</div>
	<?php }

	/**
	 * @param        $terms
	 * @param string $class
	 * @param string $sep
	 */
	public function getTerms( $terms, $class = '', $sep = '' ) {
		the_terms( get_the_ID(), $terms, '<div class="aheto-cpt-article__terms ' . $class . '">', $sep, '</div>' );
	}

	/**
	 * @param string $mod
	 */
	public function getQuote( $mod = '' ) {
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
	public function getSlider( $mod = '', $arrows = true, $pag = false, $img_size = 'full', $image_atts = [], $prefix = '' ) {
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
	public function getGallery( $mod = '', $img_size = 'full', $image_atts = [], $prefix = '' ) {
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
		wp_enqueue_style( 'magnific' );

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
	public function getAudio( $mod = '' ) {
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

	public function getVideo( $mod = '', $btn_params = [], $img_class = '', $img_size = 'full', $image_atts = [], $prefix = '' ) {
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

	/**
	 * @param $layout
	 * @param $isOnlyImage
	 *
	 * @return string
	 */
	public function getAdditionalItemClasses( $layout, $isOnlyImage ) {
		if ( $layout === 'mosaics' ) {
			return 'aheto-cpt-article--static';
		}

		if ( $layout !== 'grid' ) {
			return '';
		}

		if ( ! $isOnlyImage ) {
			return 'aheto-cpt-article--static';
		}

		$double_width  = get_post_meta( get_the_ID(), 'aheto_cpt_width', true );
		$double_height = get_post_meta( get_the_ID(), 'aheto_cpt_height', true );

		$width  = isset( $double_width ) && $double_width === 'on';
		$height = isset( $double_height ) && $double_height === 'on';

		if ( $width && $height ) {
			return 'aheto-cpt-article--double';
		}

		if ( $width ) {
			return 'aheto-cpt-article--width';
		}

		if ( $height ) {
			return 'aheto-cpt-article--height';
		}

		return '';
	}
}
