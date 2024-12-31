<?php
/**
 * The import export template.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Admin
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;
	$img = aheto()->assets() . 'admin/img/sidebar-icon/';
?>
<div class="wrap" style="max-width: 1220px">
	<span class="wp-header-end"></span>
</div>

<div class="wrap aheto-wrap limit-wrap main-wrap">

	<?php include_once Helper::get_admin_view( 'sidebar-nav' ); ?>

	<div class="aheto-option-content">

		<div class="aheto-option-header">
			<h4><span class="img-box"><img src="<?php echo esc_attr($img . 'import-export.png' ); ?>" alt="<?php echo get_admin_page_title(); ?>"/></span><?php echo get_admin_page_title(); ?>
                <span class="aheto-switch right-sidebar-option">
                    <input type="checkbox" value="false" id="aheto-right-sidebar-option">
                    <label for="aheto-right-sidebar-option"></label>
                </span>
            </h4>
		</div>

		<div class="aheto-option-body">

            <div class="aheto-import-export-section-wrap">

                <h3>
                    <?php esc_html_e( 'Import and Export your settings for re-use on (another) blog.', 'aheto' ); ?>
                </h3>
                <p>
	                <?php esc_html_e( 'You start a new website and would like to take your saved templates? Simply export your templates and import them to your new website with ' . aheto()->plugin_name() . ' Import/Export option.', 'aheto' ); ?>
                </p>
                <div class="aheto-help two-col">

                    <div class="col">

                        <div class="aheto-box">

                            <div class="aheto-box-title">

                                <h4><?php esc_html_e( 'Export Settings', 'aheto' ); ?></h4>

                            </div>

                            <form class="aheto-box-content export" action="" method="post">

                                <ul class="aheto-list-icon">

                                    <li>
                                        <span class="img-box"><img src="<?php echo esc_attr($img . 'import-export.png' ); ?>" alt="<?php echo get_admin_page_title(); ?>"/></span>
                                        <div>
                                            <strong><?php esc_html_e( 'Panels', 'aheto' ); ?></strong>
                                            <p><?php esc_html_e( 'Choose the panels to export.', 'aheto' ); ?></p>
                                        </div>
                                    </li>

                                    <li>

                                        <ul class="cmb2-checkbox-list no-select-all cmb2-list">
								            <?php foreach ( aheto()->settings->get_keys() as $id => $key ) : ?>
                                                <li>
                                                    <input type="checkbox" class="cmb2-option" name="panels[]" id="<?php echo $key; ?>" value="<?php echo $key; ?>" checked="checked"> <label for="<?php echo $key; ?>"><?php echo ucwords( str_replace( '-', ' ', $key ) ); ?></label>
                                                </li>
								            <?php endforeach; ?>
                                        </ul>

                                    </li>
									<hr/>
									<li>
										<p><?php echo __( "Please choose only one skin." , "aheto" );?></p>
										<ul class="cmb2-checkbox-list no-select-all cmb2-list">
											<?php foreach ( Helper::skins()  as $id => $name ) : ?>
												<li>
													<input type="radio" class="cmb2-option" name="skins" id="<?php echo $id; ?>" value="<?php echo $id; ?>" >
													<label for="<?php echo $id; ?>">Skin <?php echo ucwords( str_replace( '-', ' ', $name ) ); ?></label>
												</li>
											<?php endforeach; ?>
										</ul>
									</li>

                                </ul>

                                <input type="hidden" name="object_id" value="export-plz">

                                <br>
                                <button type="submit" class="custom-btn "><?php esc_html_e( 'Export', 'aheto' ); ?></button>

                            </form>

                        </div>

                    </div>

                    <div class="col">

                        <div class="aheto-box">

                            <div class="aheto-box-title">

                                <h4><?php esc_html_e( 'Import Settings', 'aheto' ); ?></h4>

                            </div>

                            <form class="aheto-box-content import" action="" method="post" enctype="multipart/form-data" accept-charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">

                                <ul class="aheto-list-icon">

                                    <li>
                                        <span class="img-box img-box__route"><img src="<?php echo esc_attr($img . 'import-export.png' ); ?>" alt="<?php echo get_admin_page_title(); ?>"/></span>
                                        <div>
                                            <strong><?php esc_html_e( 'Settings File', 'aheto' ); ?></strong>
                                            <p><?php esc_html_e( 'Import settings by locating setting file and click "Import settings".', 'aheto' ); ?></p>
                                        </div>
                                    </li>

                                    <li>
                                        <input type="file" name="import-me" value="">
                                    </li>

                                </ul>

                                <input type="hidden" name="object_id" value="import-plz">
                                <input type="hidden" name="action" value="wp_handle_upload">
                                <br>
                                <button type="submit" class="custom-btn"><?php esc_html_e( 'Import', 'aheto' ); ?></button>

                            </form>

                        </div>

                    </div>

                </div>
            </div>


		</div>

	</div>

</div>
