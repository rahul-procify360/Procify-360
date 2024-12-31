<?php
$cookie_is_rtl = (isset($_COOKIE['cm_direction']) ? $_COOKIE['cm_direction'] : (isset($_COOKIE['cs_direction']) ? $_COOKIE['cs_direction'] : (isset($_COOKIE['re_direction']) ? $_COOKIE['re_direction'] : '')));
$cost_calculator_is_rtl = (is_rtl() && (($cookie_is_rtl!='' && $cookie_is_rtl!="LTR") || $cookie_is_rtl=='')) || ($cookie_is_rtl!='' && $cookie_is_rtl=="RTL") ? 1 : 0;
$cookie_main_color = (isset($_COOKIE['cm_main_color']) ? $_COOKIE['cm_main_color'] : (isset($_COOKIE['cs_main_color']) ? $_COOKIE['cs_main_color'] : (isset($_COOKIE['re_main_color']) ? $_COOKIE['re_main_color'] : '')));
$main_color = ($cookie_main_color!="" ? $cookie_main_color : (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["main_color"] : $advanced_settings["main_color"]));
if($main_color!=""): ?>
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-current-day,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label .checkbox-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider-handle:after,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider-range-min,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>input[type='checkbox']:checked + span.cost-calculator-switch-slider,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more[type="submit"]
{
	background-color: #<?php echo $main_color; ?>;
}
<?php
if(isset($id))
{
?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more:hover,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more[type="submit"]:hover
{
	background: transparent;
}
<?php
}
echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label::before,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-prev:hover span::before,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-next:hover span::before,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-summary-price,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button.ui-corner-top .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button:hover .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container:hover .ui-icon,
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li.ui-state-focus,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-summary-box::before
{
	color: #<?php echo $main_color; ?>;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label .checkbox-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider-handle .cost-slider-tooltip .cost-calculator-value,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more[type="submit"]
{
	border-color: #<?php echo $main_color; ?>;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider-handle .cost-slider-tooltip .cost-calculator-arrow::before
{
	border-color: #<?php echo $main_color; ?> transparent;
}
<?php endif;
$text_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["text_color"] : $advanced_settings["text_color"]);
if($text_color!=""): ?>
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-prev span::before,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-next span::before,
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider-handle .cost-slider-tooltip .cost-calculator-value,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button span.ui-selectmenu-text,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-price-description,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>input[type='checkbox'] + span.cost-calculator-switch-slider::after,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container p,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='text'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='email'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='number'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container textarea,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-terms-container label
{
	color: #<?php echo $text_color; ?>;
}
<?php
if(isset($id)):
echo "#" . $id; ?> .cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label,
<?php echo "#" . $id; ?> input[type='checkbox']:checked + span.cost-calculator-switch-slider::after
{
	color: #FFF;
}
<?php endif;
endif;
$border_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["border_color"] : $advanced_settings["border_color"]);
if($border_color!=""): ?>
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-datepicker,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider .ui-slider-handle,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button,
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box .cost-calculator-datepicker-container .ui-icon,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='text'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='email'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='number'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container textarea,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .g-recaptcha-wrapper
{
	border-color: #<?php echo $border_color; ?>;
}
<?php endif;
$label_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["label_color"] : $advanced_settings["label_color"]);
if($label_color!=""): ?>
.cost-calculator-datepicker.ui-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-title,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box>.vc_row>label
{
	color: #<?php echo $label_color; ?>;
}
<?php endif;
$form_label_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["form_label_color"] : $advanced_settings["form_label_color"]);
if($form_label_color!=""): ?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-flex-box label
{
	color: #<?php echo $form_label_color; ?>;
}
<?php
elseif(isset($id) && $label_color!=""): ?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-flex-box label
{
	color: #999;
}
<?php endif;
$box_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["box_color"] : $advanced_settings["box_color"]);
if($box_color!=""): ?>
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box
{
	<?php
	if($box_color!="transparent"): ?>
	background: #<?php echo $box_color; ?>;
	padding: 24px 30px 30px;
	<?php else: ?>
	background: transparent;
	<?php
	endif;
	?>
}
<?php if($box_color!="transparent"): ?>
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box.cost-calculator-transparent,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-transparent
{
	background: transparent;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-float
{
	background: none;
}
@media screen and (max-width:1189px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box
	{
		padding-left: 20px;
		padding-right: 20px;
	}
}
@media screen and (max-width:479px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box
	{
		padding: 19px 15px 25px;
	}
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box.cost-calculator-float,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-float
{
	padding: 0;
}
<?php endif;
endif;
$inactive_color = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["inactive_color"] : $advanced_settings["inactive_color"]);
if($inactive_color!=""): ?>
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-slider,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>input[type='checkbox'] + span.cost-calculator-switch-slider
{
	background-color: #<?php echo $inactive_color; ?>;
}
<?php endif; 
$primary_font = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["primary_font"] : $advanced_settings["primary_font"]);
$primary_font_custom = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["primary_font_custom"] : $advanced_settings["primary_font_custom"]);
if($primary_font_custom!="" || $primary_font!=""):
	if($primary_font_custom!="")
		$primary_font = $primary_font_custom;
	else
	{
		$primary_font_explode = explode(":", $primary_font);
		$primary_font = $primary_font_explode[0];
	}
?>
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .ui-widget,
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='text'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='email'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container input[type='number'],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container textarea,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-terms-container label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-terms-container label a,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>input[type='checkbox'] + span.cost-calculator-switch-slider::after,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button span.ui-selectmenu-text,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more[type="submit"],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-flex-box label,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-datepicker,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-datepicker table td,
.cost-calculator-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-datepicker table th,
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li
{
	font-family: '<?php echo $primary_font; ?>';
}
<?php endif;
$secondary_font = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["secondary_font"] : $advanced_settings["secondary_font"]);
$secondary_font_custom = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["secondary_font_custom"] : $advanced_settings["secondary_font_custom"]);
if($secondary_font_custom!="" || $secondary_font!=""):
	if($secondary_font_custom!="")
		$secondary_font = $secondary_font_custom;
	else
	{
		$secondary_font_explode = explode(":", $secondary_font);
		$secondary_font = $secondary_font_explode[0];
	}
?>
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h1,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h2,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h3,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h4,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h5,
body <?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container h6,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-summary-price
{
	font-family: '<?php echo $secondary_font; ?>';
}
<?php endif; 
$calculator_skin = (isset($cost_calculator_global_form_options) ? $cost_calculator_global_form_options["calculator_skin"] : $advanced_settings["calculator_skin"]);
if($calculator_skin=="carservice")
{
?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box textarea
{
	height: 190px;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu 
{
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
	box-shadow: none;
}
.cost-calculator-datepicker.ui-datepicker<?php echo (isset($id) ? "-" . $id : ""); ?> .ui-datepicker-title
{
	font-weight: 600;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label+.cost-calculator-switch,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+input+.cost-calculator-checkbox-label.cost-calculator-checkbox-default,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column.vc_column_container,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box input[type="text"],
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.cost-slider-container,
body <?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .cost-calculator-box input+input.cost-calculator-big,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+select+.ui-selectmenu-button,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.select_container+.ui-selectmenu-button,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.cost-calculator-datepicker-container
{
	margin-top: 20px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box .cost-calculator-block:first-child input
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box>.vc_row>label
{
	display: block;
	font-weight: 600;
	background: #F5F5F5;
	padding: 11px 16px 13px;
	line-height: 26px
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label.cost-calculator-switch 
{
	padding: 0;
	font-weight: 400;
	background: none;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box
{
	display: block;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column.vc_column_container
{
	width: 100%;
	margin-left: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box .wpb_column.vc_column_container:first-child
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-flex-box label
{
	margin-top: 28px;
	margin-bottom: -49px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box .cost-calculator-block:first-child label
{
	margin-top: 8px;
	margin-bottom: -29px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container .vc_row
{
	margin: 0;
	padding: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column div.cost-calculator-box.cost-calculator-float
{
	margin: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label
{
	margin-right: -1px;
	margin-top: -1px;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
	padding: 12px 15px 10px 20px;
	color: #A4AAB3;
	background: #FFF;
	font-weight: 400;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default
{
	width: 14px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label::before
{
	position: relative;
	top: -2px;
	left: -4px;
	z-index: 1;
	font-size: 16px;
	color: #FFF;
	margin-right: 10px;
	font-family: "cc-template";
	content: "c";
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	vertical-align: middle;
	speak: none;
	line-height: 1;
	direction: ltr;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label
{
	<?php
	if($label_color!=""): ?>
	color: #333;
	<?php
	endif;
	if($border_color!=""): ?>
	border-color: #E2E6E7;
	<?php
	endif;
	?>
	background: #F5F5F5;

}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label::before
{
	color: #FFF;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default::before
{
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label .checkbox-box
{
	position: absolute;
	margin-left: 0;
	left: 12px;
	width: 22px;
	height: 22px;
	border: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container .ui-icon
{
	border-left: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	padding: 14px 12px 17px;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li
{
	border-top: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li:first-child
{
	padding-top: 13px;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li:last-child
{
	padding-bottom: 13px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more
{
	position: relative;
	display: block;
	font-weight: 600;
	padding: 19px 0 20px;
	line-height: normal;
	letter-spacing: 1px;
	border: none;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more span
{
	position: relative;
	z-index: 10;
	margin: 0 24px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more::before
{
	position: absolute;
	content: "";
	width: 5px;
	height: 100%;
	top: 0;
	left: 0;
	background: rgba(0,0,0,0.1);
	transition: all 0.2s ease 0s;
	-webkit-transition: all 0.2s ease 0s;
	-moz-transition: all 0.2s ease 0s;
	z-index: 9;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more:hover
{
	background: #<?php echo($main_color!="" ? $main_color : "1E69B8"); ?>;
	color: #FFF;
	opacity: 1;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more:hover::before
{
	width: 100%;
	background: rgba(0,0,0,0.12);
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box
{
	border: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	padding: 26px 30px 28px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-summary-price
{
	float: right;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-price-description
{
	text-align: right;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-column-with-recaptcha
{
	display: -ms-flexbox;
	display: -webkit-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: column-reverse;
	-webkit-flex-direction: column-reverse;
	-moz-flex-direction: column-reverse;
	flex-direction: column-reverse;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row.wpb_row.cost-calculator-row-with-recaptcha .vc_column_container.wpb_column
{
	width: 100%;
	margin-left: 0;
	margin-right: 0;
	margin-top: 22px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row.wpb_row.cost-calculator-row-with-recaptcha .vc_column_container.wpb_column:first-child
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .wpb_column div.g-recaptcha-wrapper
{
	float: none;
	margin: 0;
	border-color: #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	-ms-flex-item-align: start;
	-webkit-align-self: start;
	-moz-align-self: start;
	align-self: start;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .vc_row.wpb_row.cost-calculator-contact-box-submit-container div.vc_row.wpb_row.cost-calculator-button-with-recaptcha
{
	float: none;
	margin-top: 20px;
	margin-left: 0;
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .cost-calculator-recaptcha-container
{
	clear: both;
	margin-top: 20px;
	display: -ms-flexbox;
	display: -webkit-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: column-reverse;
	-webkit-flex-direction: column-reverse;
	-moz-flex-direction: column-reverse;
	flex-direction: column-reverse;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-terms-container
{
	padding-bottom: 20px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha .cost-calculator-terms-container
{
	padding-bottom: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .cost-calculator-terms-container
{
	-ms-flex-order: 1;
	-webkit-order: 1;
	-moz-order: 1;
	order: 1;
	height: auto;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .cost-calculator-contact-box-submit-container .cost-calculator-column-with-recaptcha .cost-calculator-recaptcha-container .vc_row.wpb_row.cost-calculator-button-with-recaptcha,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container + .vc_row
{
	margin-top: 20px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .cost-calculator-column-with-recaptcha .cost-calculator-terms-container
{
	-ms-flex-item-align: start;
	-webkit-align-self: start;
	-moz-align-self: start;
	align-self: start;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-row-with-recaptcha p
{
	padding: 0;
}
@media screen and (max-width:767px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.wpb_column div.vc_row.cost-calculator-contact-box-submit-container .vc_col-sm-6
	{
		margin-top: 20px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.wpb_column div.vc_row.cost-calculator-contact-box-submit-container .vc_col-sm-6:first-child
	{
		margin-top: 0;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-fieldset-with-recaptcha .cost-calculator-terms-container
	{
		padding-bottom: 0;
	}
}
<?php
if($cost_calculator_is_rtl)
{
?>
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column.vc_column_container
{
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container .ui-icon
{
	border-left: none;
	border-right: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label
{
	margin-left: -1px;
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default::before
{
	left: -2px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more::before
{
	content: none;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more::after
{
	position: absolute;
	content: "";
	width: 5px;
	height: 100%;
	top: 0;
	right: 0;
	background: rgba(0,0,0,0.1);
	transition: all 0.2s ease 0s;
	-webkit-transition: all 0.2s ease 0s;
	-moz-transition: all 0.2s ease 0s;
	z-index: 9;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-more:hover::after
{
	width: 100%;
	background: rgba(0,0,0,0.12);
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-summary-price
{
	float: left;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-price-description
{
	text-align: left;
}
<?php
}
}
else if($calculator_skin=="renovate")
{
?>
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu 
{
	-moz-box-shadow: none;
	-webkit-box-shadow: none;
	box-shadow: none;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.cost-calculator-datepicker-container
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box
{
	padding: 30px;
	margin-top: 1px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-float,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.margin-top-10
{	
	margin-top: 10px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box:first-child
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label
{
	float: left;
	border-left: 4px solid #<?php echo($main_color!="" ? $main_color : "F4BC16"); ?>;
	padding: 14px 0 12px 15px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label.cost-calculator-switch 
{
	float: right;
	margin: 0;
	padding: 0;
	border: none;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-slider-container
{
	float: right;
	clear: none;
	width: 55%;
	margin-left: 5%;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.cost-slider-container
{
	margin-top: 0;
}
body <?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .cost-calculator-box input.cost-calculator-big
{
	width: 55%;
}
body <?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .cost-calculator-box input+input.cost-calculator-big
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label
{
	float: right;
	clear: none;
	border: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	padding: 12px 28px;
	-moz-border-radius: 0;
	-webkit-border-radius: 0;
	border-radius: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default
{
	width: 14px;
	margin-top: 9px;
	margin-right: 0;
	padding: 1px 7px 4px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label::before
{
	display: none;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default::before
{
	display: inline;
	position: relative;
	left: -3px;
	top: 1px;
	z-index: 1;
	color: #FFF;
	font-size: 20px;
	font-family: "cc-template" !important;
	content: "c";
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	vertical-align: middle;
	speak: none;
	line-height: 1;
	direction: ltr;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input[type="checkbox"]:checked+.cost-calculator-checkbox-label.cost-calculator-checkbox-default
{
	background: #FFF;
	border: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-summary-box::before
{
	float: left;
	border: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	padding: 19px;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box
{
	margin-top: 20px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column
{
	margin-left: 30px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column:first-child,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column:first-child
{
	margin-left: 0;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-flex-box label
{
	margin-top: 28px;
	margin-bottom: -49px;
	padding: 0;
	border: none;
	float: none;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box .cost-calculator-block:first-child label
{
	margin-top: 8px;
	margin-bottom: -29px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='text'],
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='email'],
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='number']
{
	float: none;
	clear: both;
	width: 100%;
	margin-top: 20px;
	margin-left: 0;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box .cost-calculator-block:first-child input
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box
{
	text-align: right;
	margin-top: 10px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box.cost-calculator-align-center
{
	text-align: center;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-summary-price
{
	font-size: 40px;
}
<?php
if($box_color!="" && $box_color!="transparent"): ?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container
{
	background: #<?php echo $box_color; ?>;
	margin: 0;
	padding: 0 30px 30px;
}
<?php
endif;
?>
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container .vc_row
{
	margin-top: 18px;
	padding-bottom: 17px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .vc_row
{
	text-align: right;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container div.cost-calculator-box p.cost-calculator-price-description,
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.vc_row.cost-calculator-contact-box-submit-container .wpb_column p
{
	font-size: 14px;
	font-weight: 400;
	margin-top: 14px;
	padding: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+select+.ui-selectmenu-button,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.select_container+.ui-selectmenu-button
{
	margin-top: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container .ui-icon
{
	border-left: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	padding: 14px 12px 17px;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li
{
	border-top: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li:first-child
{
	padding-top: 13px;
}
.cost-calculator-dropdown<?php echo (isset($id) ? "-" . $id : ""); ?>.ui-selectmenu-menu .ui-menu li:last-child
{
	padding-bottom: 13px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button
{
	width: 55% !important;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-more
{	
	font-size: 12px;
	font-weight: 700;
	padding: 16px 23px 15px;
	line-height: normal;
	letter-spacing: 1px;
	-webkit-transition: all 0.3s ease 0s;
	-moz-transition: all 0.3s ease 0s;
	transition: all 0.3s ease 0s;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-column-with-recaptcha
{
	display: -ms-flexbox;
	display: -webkit-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: column-reverse;
	-webkit-flex-direction: column-reverse;
	-moz-flex-direction: column-reverse;
	flex-direction: column-reverse;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-column-with-recaptcha .g-recaptcha-wrapper
{
	float: none;
	margin: 0;
	-ms-flex-item-align: flex-end;
	-webkit-align-self: flex-end;
	-moz-align-self: flex-end;
	align-self: flex-end;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .vc_row.cost-calculator-contact-box-submit-container div.cost-calculator-column-with-recaptcha .vc_row.wpb_row.cost-calculator-button-with-recaptcha
{
	float: none;
	margin-top: 48px;
	margin-left: 0;
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .cost-calculator-recaptcha-container
{
	display: -ms-flexbox;
	display: -webkit-flexbox;
	display: -webkit-flex;
	display: flex;
	-ms-flex-direction: column-reverse;
	-webkit-flex-direction: column-reverse;
	-moz-flex-direction: column-reverse;
	flex-direction: column-reverse;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-recaptcha-container div.g-recaptcha-wrapper
{
	float: none;
	margin: 0;
	-ms-flex-item-align: flex-end;
	-webkit-align-self: flex-end;
	-moz-align-self: flex-end;
	align-self: flex-end;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .cost-calculator-contact-box-submit-container .vc_row.wpb_row.cost-calculator-button-with-recaptcha
{
	margin-top: 30px;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .cost-calculator-contact-box-submit-container .cost-calculator-recaptcha-container .vc_row.wpb_row.cost-calculator-button-with-recaptcha
{
	float: none;
	margin-top: 48px;
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container + .vc_row
{
	margin-top: 48px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha .cost-calculator-terms-container
{
	max-width: 378px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .cost-calculator-column-with-recaptcha .cost-calculator-terms-container
{
	-ms-flex-order: 1;
	-webkit-order: 1;
	-moz-order: 1;
	order: 1;
	height: auto;
	-ms-flex-item-align: flex-end;
	-webkit-align-self: flex-end;
	-moz-align-self: flex-end;
	align-self: flex-end;
}
@media screen and (max-width:1189px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box div.cost-slider-container
	{
		clear: both;
		width: 100%;
		margin-left: 0;
		margin-top: 10px;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container.cost-calculator-fieldset-with-recaptcha p,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container.cost-calculator-row-with-recaptcha p,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.vc_row.cost-calculator-contact-box-submit-container .wpb_column p
	{
		margin-top: 0;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.cost-calculator-summary-box::before
	{
		font-size: 48px;
		height: 48px;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.cost-calculator-summary-box.cc-template-wallet::before
	{
		line-height: 52px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row.wpb_row.cost-calculator-row-with-recaptcha .vc_column_container.wpb_column
	{
		width: 100%;
		margin-left: 0;
		margin-right: 0;
		margin-top: 26px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row.wpb_row.cost-calculator-row-with-recaptcha .vc_column_container.wpb_column:first-child
	{
		margin-top: 0;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container div.g-recaptcha-wrapper,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-column-with-recaptcha div.g-recaptcha-wrapper
	{
		float: none;
		margin: 0;
		-ms-flex-item-align: start;
		-webkit-align-self: start;
		-moz-align-self: start;
		align-self: start;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha .cost-calculator-recaptcha-container div.g-recaptcha-wrapper
	{
		margin-right: 0;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha
	{
		display: -ms-flexbox;
		display: -webkit-flexbox;
		display: -webkit-flex;
		display: flex;
		-ms-flex-direction: column-reverse;
		-webkit-flex-direction: column-reverse;
		-moz-flex-direction: column-reverse;
		flex-direction: column-reverse;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-fieldset-with-recaptcha .cost-calculator-terms-container
	{
		-ms-flex-order: 1;
		-webkit-order: 1;
		-moz-order: 1;
		order: 1;
		height: auto;
		-ms-flex-item-align: start;
		-webkit-align-self: start;
		-moz-align-self: start;
		align-self: start;
		padding-bottom: 30px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .cost-calculator-column-with-recaptcha .cost-calculator-terms-container
	{
		-ms-flex-item-align: start;
		-webkit-align-self: start;
		-moz-align-self: start;
		align-self: start;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-fieldset-with-recaptcha .cost-calculator-terms-container
	{
		max-width: 100%;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .vc_row.cost-calculator-contact-box-submit-container div.vc_row.wpb_row.cost-calculator-button-with-recaptcha,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .vc_row.cost-calculator-contact-box-submit-container div.cost-calculator-column-with-recaptcha .vc_row.wpb_row.cost-calculator-button-with-recaptcha,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .vc_row.cost-calculator-contact-box-submit-container.cost-calculator-fieldset-with-recaptcha .cost-calculator-recaptcha-container .vc_row.wpb_row.cost-calculator-button-with-recaptcha
	{
		float: none;
		margin-top: 48px;
		margin-left: auto;
		margin-right: auto;
	}
}
@media screen and (max-width:767px)
{
	body <?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .cost-calculator-box input.cost-calculator-big
	{
		width: 100%;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column
	{
		margin-left: 0;
		margin-top: 20px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box .cost-calculator-flex-box fieldset.wpb_column:first-child,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column:first-child,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-contact-box-submit-container .wpb_column:first-child
	{
		margin-top: 0;
	}
	body <?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .cost-calculator-box input+input.cost-calculator-big,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+select+.ui-selectmenu-button,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.select_container+.ui-selectmenu-button,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box input+.cost-calculator-datepicker-container
	{
		margin-top: 15px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button
	{
		width: 100% !important;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container
	{
		width: 100%;
		clear: both;
		float: left;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container .cost-calculator-contact-box-submit-container .wpb_column
	{
		margin-top: 20px;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-flex-box textarea
	{
		height: 190px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container + .vc_row
	{
		float: right;
	}
}
@media screen and (max-width:479px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box,
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form .cost-calculator-contact-box-submit-container
	{
		padding: 15px;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-summary-box::before
	{
		display: none;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container div.g-recaptcha-wrapper
	{
		width: 268px;
	}
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.vc_row.cost-calculator-contact-box-submit-container .wpb_column p
	{
		margin-top: 0;
	}
}
<?php
if($cost_calculator_is_rtl)
{
?>
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label
{
	float: right;
	border-right: 4px solid #<?php echo($main_color!="" ? $main_color : "F4BC16"); ?>;
	border-left: none;
	padding: 14px 15px 12px 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label.cost-calculator-switch 
{
	float: left;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-slider-container
{
	float: left;
	width: 55%;
	margin-left: 0;
	margin-right: 5%;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='text'],
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='email'],
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box.cost-calculator-contact-box input[type='number']
{
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.vc_row .wpb_column .cost-calculator-box.cost-calculator-summary-box
{
	text-align: left;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label.cost-calculator-checkbox-label.cost-calculator-checkbox-default
{
	float: left;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box label.cost-calculator-checkbox-label.cost-calculator-checkbox-default
{
	margin-left: 0;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-checkbox-label.cost-calculator-checkbox-default::before
{
	left: 0;
	right: -3px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-box .ui-selectmenu-button
{
	float: left;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .ui-selectmenu-button .ui-icon,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-calculator-datepicker-container .ui-icon
{
	border-left: none;
	border-right: 1px solid #<?php echo($border_color!="" ? $border_color : "E2E6E7"); ?>;
	
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-summary-box::before
{
	float: right;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box div.cost-calculator-flex-box fieldset.wpb_column,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column
{
	margin-left: 0;
	margin-right: 30px;
}
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box div.cost-calculator-flex-box fieldset.wpb_column:first-child,
<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column:first-child
{
	margin-right: 0;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .vc_row
{
	text-align: left;
}
<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-form.cost-calculator-container .cost-calculator-contact-box-submit-container .cost-calculator-recaptcha-container .vc_row.wpb_row.cost-calculator-button-with-recaptcha
{
	margin-left: 0;
	margin-right: auto;
}
@media screen and (max-width:1189px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-box .cost-slider-container
	{
		margin-right: 0;
	}
}
@media screen and (max-width:767px)
{
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>.cost-calculator-contact-box div.cost-calculator-flex-box fieldset.wpb_column,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box.cost-calculator-flex-box fieldset.wpb_column
	{
		margin-right: 0;
	}
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container,
	<?php echo (isset($id) ? "#" . $id . " " : ""); ?>div.cost-calculator-contact-box-submit-container .vc_col-sm-6 .cost-calculator-terms-container + .vc_row
	{
		float: left;
	}
}
@media screen and (max-width:479px)
{
	<?php echo (isset($id) ? "#" . $id : ""); ?>.cost-calculator-container div.g-recaptcha
	{
		margin-right: -35px;
	}
}
<?php
}
}
?>