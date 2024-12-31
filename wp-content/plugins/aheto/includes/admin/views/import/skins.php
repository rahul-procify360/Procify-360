<?php
/**
 * Template kit skin template.
 *
 * @package Aheto
 */

use Aheto\Helper;
use Aheto\Template_Kit\API;

$api = new API;

$categories   = $api->get_skins_categories();
$templates    = $api->get_skinss();

$cat_theme 	  = apply_filters( 'aheto_template_kit_category', false );
$cat_theme 	  = ( $cat_theme && is_string( $cat_theme ) ) ? $cat_theme : '';

Helper::add_json( 'templates', $templates );
Helper::add_json( 'security', wp_create_nonce( 'aheto_ajax_skin_importer' ) );
if(!Helper::get_ml()){ ?>
    <p class="notice notice-error is-dismissible"><?php esc_html_e('Please make sure your ', 'aheto');?><strong>memory_limit</strong><?php esc_html_e(' is greater than 256MB.', 'aheto');?></p>
<?php }

if(!Helper::get_et()){ ?>
    <p class="notice notice-error is-dismissible"><?php esc_html_e('Please make sure your ', 'aheto');?><strong>max_execution_time</strong><?php esc_html_e(' is greater than 60.', 'aheto');?></p>
<?php } ?>

<div class="wrap aheto-wrap limit-wrap">

	<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

	<div class="aheto-wrap__container">


<!--					 <div class="filter-link-content">-->
<!--						--><?php //if ( isset( $categories['all'] ) ) { ?>
<!--							<a data-filter="tk-all" data-title="all" class="filter-link">-->
<!--								--><?php //echo __("All", 'aheto'); ?><!-- (--><?php //echo count( $templates ); ?><!--)-->
<!--							</a>-->
<!--						--><?php //} ?>
<!--						--><?php //foreach ( $categories as $label => $v ) : ?>
<!--							--><?php //if ( $label != 'all' ) { ?>
<!--								<a data-filter="tk---><?php //echo sanitize_title_with_dashes( strtolower( $label ) ); ?><!--" data-title="--><?php //echo $label; ?><!--" class="filter-link">-->
<!--									--><?php //echo $label; ?>
<!--								</a>-->
<!--							--><?php //} ?>
<!--						--><?php //endforeach; ?>
<!---->
<!--					</div>-->


				<div class="filter-content">

					<?php foreach ( $templates as $index => $template ) : ?>
                        <div class="post post-skins tk-<?php echo join( ' tk-', $template['categories']['classes'] ); ?>" data-index="<?php echo $index; ?>" data-slug="<?php echo strtolower($cat_theme) ;?>">
                            <img data-lazy-src="<?php echo esc_url_raw( $template['thumbnail'] ); ?>" src="<?php echo aheto()->plugin_url() . 'assets/images/placeholder.jpg'; ?>" />
                            <span><?php echo esc_html( $template['title'] ); ?></span>
                        </div>
					<?php endforeach; ?>

				</div>

				<div id="template-modal-content" class="template-kit-content">
					<div class="template-kit-col-left">
						<img class="template-screenshot" src="" alt=""/>
					</div>

					<!-- POPUP CONTENT START -->
					<div class="template-kit-col-right">
						<div class="template-kit-import">
							<h3>
								<a target="_blank" href="#" class="template-preview">
                                    <img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/import-export.png" />
                                </a>
                                <span class="template-title"></span> <small>&times;</small>
							</h3>

							<div>
								<img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/template-kit/icon-import-2.png" />
								<h4><?php esc_html_e( 'Import skin', 'aheto' ); ?></h4>
								<p><?php esc_html_e( 'Import settings by locating setting file and click "Import template".', 'aheto' ); ?></p>
								<a href="#" class="action-skin-import custom-btn "><?php esc_html_e( 'Import skin', 'aheto' ); ?></a>
								<img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/loader.gif" id="loader_importing_page" style="margin-left:auto;margin-right:auto;display: none;" />
							</div>
						</div>
					</div>
					<!-- POPUP CONTENT END -->


		</div>

	</div>

</div>
