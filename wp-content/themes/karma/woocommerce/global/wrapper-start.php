<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$karma_img = '';
$karma_background_image = '';

if (function_exists('aheto')) {
    $karma_shop_image = Aheto\Helper::get_settings('theme-options.karma_shop_image');
    $karma_background_image = isset($karma_shop_image) && !empty($karma_shop_image) ? "style=background-image:url(" . $karma_shop_image . ")" : '';
    $karma_img = isset($karma_shop_image) && !empty($karma_shop_image) ? 'with-image' : '';
}

if (is_shop()) { ?>
    <div class="karma-shop-banner <?php echo esc_attr($karma_img); ?> " <?php echo esc_attr($karma_background_image); ?>>
        <h1 class="title"><?php woocommerce_page_title(); ?></h1>
    </div>
<?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-12">

<?php

