<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aheto
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
wp_enqueue_script( 'frontend-js', aheto()->plugin_url() . 'assets/frontend/js/frontend.js', [ 'jquery' ], '1.0.0', true );

$discussion = aheto_get_discussion_data();
?>
<div class="aht-page__content-inner">

	<div id="comments" class="container <?php echo comments_open() ? 'aht-page__comments-area' : 'aht-page__comments-area comments-closed'; ?>">

		<div class="aheto-heading t-center <?php echo $discussion->responses > 0 ? 'comments-title-wrap' : 'comments-title-wrap no-responses'; ?>">

			<h3 class="t-light comments-title">
			<?php
			printf(
				/* translators: 1: number of comments, 2: post title */
				_nx(
					'%1$s Comment',
					'%1$s Comments',
					$discussion->responses,
					'comments title',
					'aheto'
				),
				number_format_i18n( $discussion->responses )
			);
			?>
			</h3><!-- .comments-title -->

		</div><!-- .comments-title-flex -->


		<?php
		if ( have_comments() ) :

			// Show comment form at top if showing newest comments at the top.
			if ( comments_open() ) {
				aheto_comment_form( 'desc' );
			}

			?>
			<ol class="comment-list">
				<?php

				wp_list_comments(
					array(
						'walker'      => new \Aheto\Frontend\Walker_Comment,
						'avatar_size' => 50,
						'short_ping'  => true,
						'style'       => 'ol',
					)
				);
				?>
			</ol><!-- .comment-list -->
			<?php

			// Show comment navigation.
			if ( have_comments() ) :
				$comments_text = __( 'Comments', 'aheto' );
				the_comments_navigation(
					array(
						'prev_text' => sprintf( '<span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', __( 'Previous', 'aheto' ), __( 'Comments', 'aheto' ) ),
						'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', __( 'Next', 'aheto' ), __( 'Comments', 'aheto' ) ),
					)
				);
			endif;

			// Show comment form at bottom if showing newest comments at the bottom.
			if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
				?>
				<div class="comment-form-flex aheto-form-btn aheto-btn--primary">
					<span class="screen-reader-text"><?php _e( 'Leave a comment', 'aheto' ); ?></span>
                    <h3 class="comments-title" aria-hidden="true"><?php _e( 'Leave a comment', 'aheto' ); ?></h3>
					<?php aheto_comment_form( 'asc' ); ?>
				</div>
				<?php
			endif;

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() ) :
				?>
				<p class="no-comments">
					<?php _e( 'Comments are closed.', 'aheto' ); ?>
				</p>
				<?php
			endif;

		else :

			// Show comment form.
			aheto_comment_form( true );

		endif; // if have_comments().
		?>
	</div><!-- #comments -->

</div>
