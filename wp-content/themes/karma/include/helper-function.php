<?php

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Create custom html structure for comments
 */
if ( !function_exists('karma_comment') ) {
	function karma_comment($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback': ?>
				<div class="pinback">
					<span class="pin-title"><?php esc_html_e('Pingback: ', 'karma'); ?></span><?php comment_author_link(); ?>
					<?php edit_comment_link(esc_html__('(Edit)', 'karma'), '<span class="edit-link">', '</span>'); ?>

				<?php
				break;
			default:
				// generate comments
				?>
			<div <?php comment_class('karma-blog--single__comments-item'); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="karma-blog--single__comments-item-wrap">
					<div class="karma-blog--single__comments-content">
                        <span class="person-img">
							<?php echo get_avatar($comment, '80', '', '', array('class' => 'img-person')); ?>
                        </span>
						<div class="comment-content">
							<div class="author-wrap">
								<div class="author">
									<?php comment_author(); ?>
								</div>
								<?php comment_reply_link(
									array_merge($args,
										array(
											'reply_text' => esc_html__('Reply', 'karma'),
											'after'      => '',
											'depth'      => $depth,
											'max_depth'  => $args['max_depth']
										)
									)
								); ?>
							</div>

							<div class="comment-text">
								<?php comment_text(); ?>
							</div>

                            <div class="comment-date">
								<?php comment_date(get_option('date_format')); ?>
                            </div>
						</div>
					</div>
				</div>
				<?php
				break;
		endswitch;
	}
}


/**
 * Filter for excerpt more string
 */

if ( !function_exists('karma_excerpt_more') ) {
	function karma_excerpt_more() {
		return ' ...';
	}

	add_filter('excerpt_more', 'karma_excerpt_more');
}


/**
 * Header template
 */

if ( ! function_exists( 'karma_main_header_html' ) ) {
	function karma_main_header_html() {

		$active_plugin = function_exists( 'aheto' ) ? true : false;
	    $template_name = $active_plugin ? 'aheto' : 'theme';

		get_template_part( 'template-parts/' . $template_name . '-header' );

	}
}

add_action( 'karma_main_header', 'karma_main_header_html' );



/**
 * Footer template
 */

if ( ! function_exists( 'karma_main_footer_html' ) ) {
	function karma_main_footer_html() {

		$active_plugin = function_exists( 'aheto' ) ? true : false;
		$template_name = $active_plugin ? 'aheto' : 'theme';

		get_template_part( 'template-parts/' . $template_name . '-footer' );

	}
}


add_action( 'karma_main_footer', 'karma_main_footer_html' );


/*
 * Check woocommerce page
 */
if ( ! function_exists( 'karma_is_realy_woocommerce_page' ) ) {
	function karma_is_realy_woocommerce_page() {
		if ( function_exists( "is_woocommerce" ) && is_woocommerce() ) {
			return true;
		}
		$woocommerce_keys = array(
			"woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id"
		);

		foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID() == get_option( $wc_page_id, 0 ) ) {
				return true;
			}
		}

		return false;
	}
}
function karma_add_dependency($id, $args = array(), $shortcode)
{

    if ( is_array( $id ) ) {

        foreach ( $id as $slug ) {
            $param = (array)$shortcode->depedency[$slug]['template'];
            $shortcode->depedency[$slug]['template'] = array_merge($args, $param );
        }

    } else {
        $param = (array)$shortcode->depedency[$id]['template'];
        $shortcode->depedency[$id]['template'] = array_merge($args, $param );
    }

    return;
}