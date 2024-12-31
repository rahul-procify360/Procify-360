<?php
/**
 * Template kit template.
 *
 * @package Aheto
 */

use Aheto\Helper;
use Aheto\Template_Kit\API;

$template_kit = API::get();

$allowed_theme     = apply_filters( 'aheto_template_kit_category', false );


$templates = array();


if (isset($_GET['category_id'])) {
	$category_id = $_GET['category_id'];
	$templates    = $template_kit->get_templates("",$category_id,"pages","");
}
else {
	$templates    = $template_kit->get_themes_grouped();
}

Helper::add_json( 'templates', $templates );
Helper::add_json( 'security', wp_create_nonce( 'aheto_ajax_page_importer' ) );

if(!Helper::get_ml()){ ?>
    <p class="notice notice-error is-dismissible"><?php esc_html_e('Please make sure your ', 'aheto');?><strong>memory_limit</strong><?php esc_html_e(' is greater than 256MB.', 'aheto');?></p>
<?php }

if(!Helper::get_et()){ ?>
    <p class="notice notice-error is-dismissible"><?php esc_html_e('Please make sure your ', 'aheto');?><strong>max_execution_time</strong><?php esc_html_e(' is greater than 60.', 'aheto');?></p>
<?php } ?>

<div class="wrap aheto-wrap limit-wrap">

	<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

	<div class="aheto-wrap__container">



			<div class="aheto-filter-wrap">

			<?php if (!isset($category_id)){ ?>


				<div class="filter-content">

					<?php

                    foreach ( $templates as $index => $template ) {
						if (strlen($template['aheto-category-screenshot'])>5){
						if ((isset($allowed_theme) and strtolower($template['main_theme'])==strtolower($allowed_theme)) or (!isset($allowed_theme)) or ($allowed_theme=="vision")) {
						?>

							<a href="<?php echo  get_admin_url(get_current_blog_id(), '/admin.php?page=aheto-templates&category_id='.$template['slug']); ?>">

				<div class="post post-js">
                            <div class="post__img post__img-js">
                                <img class="post__img-page" data-lazy-src="<?php echo esc_url_raw( $template['aheto-category-screenshot'] ); ?>" src="<?php echo aheto()->plugin_url() . 'assets/images/placeholder.gif'; ?>" />
                            </div>
                            <span><?php echo esc_html( $template['name'] ); ?></span>
                        </div>
                    </a>
					<?php } } } ?>

				</div>

			<?php } else { ?>	
				<a href="<?php echo  get_admin_url(get_current_blog_id(), '/admin.php?page=aheto-templates'); ?>" class="custom-btn">
                    <i class="fa fa-caret-left"></i> Back to categories</a>
					<h3>Homepages</h3>
				<div class="filter-content">

					<?php foreach ( $templates as $index => $template ) { 
					if (strpos(strtolower($template['title']), "home") !== false) {
						?>

                          <div class="post post-js tk-<?php echo join( ' tk-', $template['categories']['classes'] ); ?>" data-index="<?php echo $index; ?>" data-slug="<?php echo strtolower($template['tags']['terms'][0]) ;?>">
                            <div class="post__img post__img-js">
                                <img class="post__img-page" data-lazy-src="<?php echo esc_url_raw( $template['thumbnail'] ); ?>" src="<?php echo aheto()->plugin_url() . 'assets/images/placeholder.jpg'; ?>" />
                            </div>
                            <span><?php echo esc_html( $template['title'] ); ?></span>
                        </div>
					<?php } } ?>

				</div>
					<h3>Inner Pages</h3>
				<div class="filter-content">

					<?php foreach ( $templates as $index => $template ) { 
						if (strpos(strtolower($template['title']), "home") === false) {
						?>   <div class="post post-js tk-<?php echo join( ' tk-', $template['categories']['classes'] ); ?>" data-index="<?php echo $index; ?>" data-slug="<?php echo strtolower($template['tags']['terms'][0]) ;?>">
                            <div class="post__img post__img-js">
                                <img class="post__img-page" data-lazy-src="<?php echo esc_url_raw( $template['thumbnail'] ); ?>" src="<?php echo aheto()->plugin_url() . 'assets/images/placeholder.jpg'; ?>" />
                            </div>
                            <span><?php echo esc_html( $template['title'] ); ?></span>
                        </div>
					<?php }} ?>

				</div>

				<div id="template-modal-content" class="template-kit-content">
					<div class="template-kit-col-left">
						<img class="template-screenshot" />
					</div>

					<!-- POPUP CONTENT START -->
					<div class="template-kit-col-right">
						<div class="template-kit-import">
							<h3>
                                <a target="_blank" href="#" class="template-preview"><span class="img-box"><img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/sidebar-icon/import-export.png" /></span></a><span class="template-title"></span> <small>&times;</small>
							</h3>

							<div>
								<img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/template-kit/icon-import-2.png" />
								<h4><?php esc_html_e( 'Import template', 'aheto' ); ?></h4>
								<p><?php esc_html_e( 'Import settings by locating setting file and click "Import template".', 'aheto' ); ?></p>
								<a href="#" class="action-template-import custom-btn secondary"><?php esc_html_e( 'Import template', 'aheto' ); ?></a>
								<img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/loader.gif" id="loader_importing_page" style="margin-left:auto;margin-right:auto;display: none;" />
							</div>
						</div>

						<div class="template-kit-create-page" >
							<form action="">
								<input type="hidden" class="template-id" name="aheto_page_template_id" value="">
                                <input type="hidden" class="template-slug" name="aheto_page_template_slug" value="">
								<input type="text" class="aheto-page-name" value="" placeholder="<?php esc_html_e( 'Enter a Page Name', 'aheto' ); ?>">
								<button type="submit" class="action-template-create-page"><?php esc_html_e( 'Create', 'aheto' ); ?></button>
							</form>
							<img src="<?php echo aheto()->plugin_url(); ?>assets/admin/img/loader.gif" id="loader_creating_page" style="position: absolute;top: 40px;right: 175px;display: none;" />
                            <p><?php esc_html_e( 'Create a new page from this template to make it available as a draft page in your Page list.', 'aheto' ); ?></p>
                        </div>
					</div>
					<!-- POPUP CONTENT END -->
				</div>

			<?php }  ?>
			</div>

		</div>

	</div> 
 
