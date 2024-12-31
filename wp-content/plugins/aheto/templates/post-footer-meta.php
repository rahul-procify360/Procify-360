<?php
/**
 * The template for displaying post meta info
 *
 * @package Aheto
 */

wp_enqueue_script( 'frontend-js', aheto()->plugin_url() . 'assets/frontend/js/frontend.js', [ 'jquery' ], '1.0.0', true );

?>
<div class="aht-page__post-meta">

	<div class="row">

		<div class="col-sm-8 col-md-9">

			<?php the_terms( get_the_ID(), 'post_tag', '<div class="tags"><span class="tags-title">' . esc_html__('Tags: ', 'aheto') . '</span>', ', ', '</div>' ); ?>

		</div>

		<?php $class = ( is_user_logged_in() ) ? 'active' : 'disabled' ?>
		<div class="col-sm-4 col-md-3">
			<?php $likes = get_post_meta( get_the_ID(), 'aheto_post_likes', true ); ?>
			<a href="#" class="likes <?php echo $class;?>" data-postid="<?php echo get_the_ID();?>">
				<i class="fa fa-heart"></i>
				<span class="count"><?php echo $likes ? count( $likes ) : 0; ?></span>
				<?php esc_html_e( 'Likes', 'aheto' ); ?>
			</a>
		</div>
	</div>

</div>
