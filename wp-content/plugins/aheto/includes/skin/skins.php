<?php
	/**
	 * Skins settings.
	 *
	 * @since      1.0.0
	 * @package    Aheto
	 * @subpackage Aheto
	 * @author     UPQODE <info@upqode.com>
	 */

	use Aheto\Helper;

	$cmb->add_field([
		'id'    => 'skins',
		'type'  => 'title',
		'after' => function() {
			?>
            <div class="skins__blocks">
                <div class="skins__block skins__block-add skins__open-popup-js">
                    <div class="skins__inner">
                        <img src="<?php echo esc_url( aheto()->plugin_dashboard_skin_create() ); ?>" alt="<?php aheto()->plugin_name(); ?>"
                             class="">
                    </div>
                    <div>
                        <span class="aheto_skin_name">Create New Skin</span>
                    </div>
                    <div class="cmb-td  skins__popup skins__popup-js">
                        <input type="text" class="regular-text" placeholder="Enter Skin Name" name="new_skin" id="new_skin" value="">
                        <button type="submit" class="custom-btn  button-create-new">Create Skin</button>
                    </div>
                </div>
				<?php
					$url = Helper::get_admin_url( 'skin-generator' );

					$selected_skin = Helper::get_active_skin();

					foreach ( Helper::skins() as $id => $name ) {
						$active = ( $selected_skin == $id ) ? 'active_skin' : '';
						$settings = get_option('aheto_skin_' . $id);
						$colors = ['active', 'alter', 'alter2', 'alter3', 'grey', 'light', 'dark', 'dark2', 'white', 'black'];
						$item = '';
						$font = $settings["headings"]["font-family"];
						$fontHeading = $settings["headings"]["font-family"];
						$fontHeadingWeight = isset($settings["headings"]["font-weight"]) ? $settings["headings"]["font-weight"] : 'normal';
						$fontHeadingLS = isset($settings["headings"]["letter-spacing"]) ? $settings["headings"]["letter-spacing"] : 0;
						$fontHeadingColor = isset($settings["headings"]["color"]) ? $settings["headings"]["color"] : $settings['dark'];
						$fontHeadingLH = isset($settings["headings"]["line-height"]) ? $settings["headings"]["line-height"] : 'inherit';

						$fontParagraphWeight = isset($settings["headings"]["font-weight"]) ? $settings["headings"]["font-weight"] : 'normal';
						$fontParagraphLS = isset($settings["headings"]["letter-spacing"]) ? $settings["headings"]["letter-spacing"] : 0;
						$fontParagraphColor = isset($settings["headings"]["color"]) ? $settings["headings"]["color"] : $settings['grey'];
						$fontParagraphLH = isset($settings["headings"]["line-height"]) ? $settings["headings"]["line-height"] : 'inherit';


						if(!empty($settings["heading1"]["font-family"])){
							$fontHeading = $settings["heading1"]["font-family"];
						}

						if(!empty($settings["heading1"]["font-weight"])){
							$fontHeadingWeight = $settings["heading1"]["font-weight"];
						}

						if(!empty($settings["heading1"]["letter-spacing"])){
							$fontHeadingLS = $settings["heading1"]["letter-spacing"];
						}

						if(!empty($settings["heading1"]["color"])){
							$fontHeadingColor = $settings["heading1"]["color"];
						}

						if(!empty($settings["heading1"]["line-height"])){
							$fontHeadingLH = $settings["heading1"]["line-height"];
						}


						if(!empty($settings["text_font"]["font-family"])){
							$fontparagraph = $settings["text_font"]["font-family"];
						}

						if(!empty($settings["text_font"]["font-weight"])){
							$fontParagraphWeight = $settings["text_font"]["font-weight"];
						}

						if(!empty($settings["text_font"]["letter-spacing"])){
							$fontParagraphLS = $settings["text_font"]["letter-spacing"];
						}

						if(!empty($settings["text_font"]["color"])){
							$fontParagraphColor = $settings["text_font"]["color"];
						}

						if(!empty($settings["text_font"]["line-height"])){
							$fontParagraphLH = $settings["text_font"]["line-height"];
						}

						foreach ( $colors as $color ) {
							if(isset($settings[$color]) && !empty($settings[$color])){
								$item .= "<li  class='skins__item'>" . "<span class='skins__color' style = 'background-color:". esc_attr( $settings[$color]) ."'>". "</span>" . "</li>";
							}
						}
						printf(
							'<div class="skins__block" id="%2$s">
							<div class="skins__inner" data-href="%3$s">
								<div class="skins__colors">
									<span class="title">Colors</span>
									<ul class="skins__items">%7$s</ul>
								</div>
								<div class="skins__typography">
									<span class="title">Typography</span>
									<div class="example" style = "font-family: %8$s">Aa<span class="font-family">%8$s</span></div>
									<div class="font">
										<div class="heading" style = "font-family: %9$s;font-weight: %11$s;letter-spacing: %12$s;line-height: %13$s;color: %14$s;">By Jove, my quick study of lexicography won a prize!<span class="font-family">%9$s</span></div>
										<div class="paragraph"  style = "font-family: %10$s;font-weight: %15$s;letter-spacing: %16$s;line-height: %17$s;color: %18$s;">By Jove, my quick study of lexicography won a prize!<span class="font-family">%10$s</span></div>
									</div>
									
								</div>	
							</div>
							<div class="skins__footer">
							    <input type="text" name="skin_name" class="aheto_skin_name" value="%1$s" data-skin_id="%2$s">
							    <div class="skins__nav">
                                    <div class="skins__nav-icon skins__nav-icon-js">
                                        <span class="icon__dots icon__dots-js">
                                           <span class="icon__dots-item"></span>
                                           <span class="icon__dots-item"></span>
                                           <span class="icon__dots-item"></span>                          
                                        </span>
                                        <ul class="skins__menu">
                                            <li class="skins__menu-item"><a href="%5$s"><i class="icon ion-android-close"></i>Delete</a></li>
                                            <li class="skins__menu-item"><a href="%4$s"><i class="icon ion-ios-browsers-outline"></i>Clone</a></li>
                                        </ul>
                                    </div>						    
                                </div>
                            </div>
						</div>',
							$name,
							$id,
							$url . '&open&aheto-edit-skin=' . $id,
							$url . '&aheto-clone-skin=' . $id,
							$url . '&aheto-delete-skin=' . $id,
							$active,
							$item,
							$font,
							$fontHeading,
							$fontparagraph,
							$fontHeadingWeight,
							$fontHeadingLS,
							$fontHeadingLH,
							$fontHeadingColor,
							$fontParagraphWeight,
							$fontParagraphLS,
							$fontParagraphColor,
							$fontParagraphLH
						);
					}?>
            </div>
			<?php
		},
	]);

	$skin_name = ( isset( $_GET['aheto-edit-skin'] ) ) ? $_GET['aheto-edit-skin'] : '';




	$cmb->add_field([
		'id'   => 'skin',
		'type' => 'hidden',
		'default' => $skin_name
	]);

//$cmb->add_field([
//	'id'          => 'new_skin',
//	'type'        => 'text',
//	'name'        => esc_html__( 'New Skin Name', 'aheto' ),
//	'classes'     => 'with-button',
//	'after_field' => '<button type="submit" class="custom-btn  button-create-new">Create New Skin</a>',
//	'save_field'  => false,
//]);
