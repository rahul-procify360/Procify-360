<?php
/**
 * The template tags.
 *
 * Functions for the templating system.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     UPQODE <info@upqode.com>
 */

defined( 'ABSPATH' ) || exit;

/**
 * Load header template.
 */
function aheto_get_header() {
	aheto_load_template( 'header' );
}

/**
 * Load footer template.
 */
function aheto_get_footer() {
	aheto_load_template( 'footer' );
}

/**
 * Load post footer meta template.
 */
function aheto_post_footer_meta() {
	aheto_load_template( 'post-footer-meta' );
}

/**
 * Load post format content if avilable.
 */
function aheto_post_format_content() {
	aheto_load_template( 'blog/format/content-' . get_post_format() );
}

/**
 * Load post author bio template.
 */
function aheto_post_author_bio() {
	aheto_load_template( 'author-bio' );
}

/**
 * Load post social share template.
 */
function aheto_post_social_share() {
	aheto_load_template( 'social-share' );
}

/**
 * Load related posts template.
 */
function aheto_post_related_posts() {
	aheto_load_template( 'related-posts' );
}

/**
 * Load post comments template.
 */
function aheto_post_comments() {
	add_filter( 'comments_template', 'aheto_post_comments_template' );
	comments_template();
	remove_filter( 'comments_template', 'aheto_post_comments_template' );
}

/**
 * Return post comment template.
 *
 * @return string
 */
function aheto_post_comments_template() {
	return aheto_locate_template( 'comments' );
}


/**
 * Header markup.
 */
function aheto_preloader_markup() {

	$preloader       = aheto()->settings->get( 'general.preloader' );
	$preloader_text  = aheto()->settings->get( 'general.preloader_text' );
	$preloader_image = aheto()->settings->get( 'general.preloader_image' );
	$preloader_html  = aheto()->settings->get( 'general.preloader_html' );

	if ( isset( $preloader ) ) {
		switch ( $preloader ) {
			case "simple": ?>
                <div class="aheto-preloader"></div>
				<?php
				break;
			case "with_text":
				if ( ! empty( $preloader_text ) ) { ?>
                    <div class="aheto-preloader">
                        <div class="aheto-preloader__wrap">
                            <svg viewBox="0 0 600 300">
                                <symbol id="aheto-preloader__text">
                                    <text text-anchor="middle" x="50%" y="50%"
                                          dy="0.35em"><?php echo esc_html( $preloader_text ); ?></text>
                                </symbol>
                                <use class="aheto-preloader__text" xlink:href="#aheto-preloader__text"></use>
                                <use class="aheto-preloader__text" xlink:href="#aheto-preloader__text"></use>
                                <use class="aheto-preloader__text" xlink:href="#aheto-preloader__text"></use>
                            </svg>
                        </div>
                    </div>
					<?php
				}
				break;
			case "with_image":
				if ( ! empty( $preloader_image ) ) { ?>
                    <div class="aheto-preloader with_image">

                        <img src="<?php echo esc_url( $preloader_image ); ?>" alt="<?php bloginfo( 'name' ); ?>">

                    </div>
				<?php }
				break;
			case "spinner": ?>
                <div class="aheto-preloader">
                    <div class="aheto-preloader__spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
				<?php
				break;
			case "custom":
				if ( ! empty( $preloader_html ) ) {
					echo wp_kses_post( $preloader_html );
				}
				break;
		}
	}
}


/**
 * Header markup.
 */
function aheto_header_markup() {
	$frontend = aheto()->frontend;

	$frontend->header_id = is_array( $frontend->header_id ) ? $frontend->header_id['image_select'] : $frontend->header_id;

	if ( ! $frontend->header_id ) {
		return;
	}

	$classes   = [];
	$classes[] = 'aheto-header';
	$classes[] = get_post_meta( $frontend->header_id, 'aheto_header_css_classes', true );
	$classes[] = get_post_meta( $frontend->header_id, 'aheto_header_position', true ); ?>

    <header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader"
            class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php echo $frontend->get_builder_content_for_display( $frontend->header_id ); ?>
    </header>

<?php
}

/**
 * Footer markup.
 */
function aheto_footer_markup() {
	$frontend = aheto()->frontend;

	$frontend->footer_id = is_array( $frontend->footer_id ) ? $frontend->footer_id['image_select'] : $frontend->footer_id;

	if ( ! $frontend->footer_id ) {
		return;
	}

	?>
    <footer class="aheto-footer <?php echo get_post_meta( $frontend->footer_id, 'aheto_footer_css_classes', true ); ?>">

        <div class="container">

			<?php echo $frontend->get_builder_content_for_display( $frontend->footer_id ); ?>

        </div>

        <?php do_action('aheto_after_footer'); ?>

    </footer>
	<?php
}

/**
 * Bredcrumb.
 */
function aheto_get_breadcrumbs($ul_class = 'breadcrumbs', $li_class = 'breadcrumbs__item') {
	$object = new Aheto\Frontend\Breadcrumbs;

	return $object->get_breadcrumb($ul_class, $li_class);
}

/**
 * Bredcrumb.
 */
function aheto_the_breadcrumbs() {
	echo aheto_get_breadcrumbs();
}


/**
 * Search box.
 */
function aheto_search_box() {

	wp_enqueue_style( 'aheto-search', aheto()->plugin_url() . 'assets/frontend/css/search.css', null, aheto()->version );

	?>
    <div class="site-search" id="search-box">
        <button class="close-btn js-close-search"><i class="fa fa-times" aria-hidden="true"></i></button>
        <div class="form-container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>"
                              autocomplete="off">
                            <div class="input-group">
                                <input type="search" value="" name="s" class="search-field"
                                       placeholder="<?php esc_html_e( 'Enter Keyword', 'aheto' ); ?>" required="">
                            </div>
                        </form>
                        <p class="search-description"><?php esc_html_e( 'Input your search keywords and press Enter.', 'aheto' ); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function aheto_get_discussion_data() {
	static $discussion, $post_id;

	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) {
		return $discussion; /* If we have discussion information for post ID, return cached object */
	} else {
		$post_id = $current_post_id;
	}

	$comments = get_comments(
		[
			'post_id' => $current_post_id,
			'orderby' => 'comment_date_gmt',
			'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
			'status'  => 'approve',
			'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
		]
	);

	$authors = [];
	foreach ( $comments as $comment ) {
		$authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
	}

	$authors    = array_unique( $authors );
	$discussion = (object) [
		'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
		'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
	];

	return $discussion;
}

/**
 * Comment Form.
 *
 * @param bool|string $order Orderby.
 */
function aheto_comment_form( $order ) {
	if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {
		comment_form(
			array(
				'logged_in_as' => null,
				'title_reply'  => null,
				'class_form'   => 'comment-form aheto-form-btn aheto-btn--primary',
				'format'       => 'xhtml',
				'fields'       => array(
					'author' => '<p class="comment-form-author"><label for="author">Name *</label> <input id="author" required name="author" type="text" value="" size="30" /></p>',
					'email'  => '<p class="comment-form-email"><label for="email">E-mail *</label> <input id="email" required name="email" type="email" value="" size="30" /></p>',
					'url'    => '<p class="comment-form-url"><label for="url">Website</label> <input id="url" name="url" type="text" value="" size="30" /></p>'
				)
			)
		);
	}
}


/**
 * 404 redirect page.
 */

function aheto_404_redirect() {

	$redirect_page_id = \Aheto\Helper::get_settings( 'general.404_redirect' );
	$redirect_page_slug = \Aheto\Helper::get_settings( 'general.404_redirect_slug' );


	if ( is_404() && isset( $redirect_page_id ) && ! empty( $redirect_page_id ) && $redirect_page_id !== 0 && !$redirect_page_slug) {

		$redirect_page_url = get_permalink( $redirect_page_id );

		header( 'HTTP/1.1 301 Moved Permanently' );
		header( "Location: " . $redirect_page_url );

		exit();
	}
}


