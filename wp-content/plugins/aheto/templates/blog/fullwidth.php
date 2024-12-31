<?php
/**
 * The Blog Fullwidth template.
 *
 * @package Aheto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

aheto_get_header();

do_action( 'aheto_preloader' );

wp_enqueue_style( 'swiper' );
wp_enqueue_script( 'swiper' );
wp_enqueue_style( 'aheto-blog-list');

while ( have_posts() ) :
	the_post();

	$background = '';
	if ( has_post_thumbnail() ) {
		$background = wp_get_attachment_url( get_post_thumbnail_id() );
		$background = sprintf( ' style="background: url(%s) no-repeat center;"', $background );
	}
	?>

	<div class="aht-page__content-inner">

		<div class="aht-page__post-head text-center"<?php echo $background; ?>>

			<div class="container aheto-full-min-height-js">
                <div class="post-head--top"></div>

                <div class="post-head--middle">
	                <?php the_terms( get_the_ID(), 'category', '<div class="post-cats"><div class="post-cats-item aheto-btn aheto-btn--primary">', '</div><div class="post-cats-item aheto-btn aheto-btn--primary">', '</div></div>' ); ?>

	                <?php the_title( '<h1 class="post-title aheto-heading__title t-light">', '</h1>' ); ?>

                    <p class="post-date"><?php the_time(get_option('date_format')); ?></p>
                </div>

                <div class="post-head--bottom">
                    <div class="post-author">

		                <?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>

                        <h6 class="t-medium"><?php the_author(); ?></h6>

                    </div>
                </div>

			</div>

		</div>

		<?php
		/**
		 * Hook: aheto_before_post_container.
		 */
		do_action( 'aheto_before_post_container' );
		?>

		<div class="aht-page__post-content">

			<div class="container">

				<?php
				/**
				 * Hook: aheto_before_post_content.
				 */
				do_action( 'aheto_before_post_content' );
				?>

                <div class="content-wrapper">
	                <?php the_content(); ?>
                </div>

				<?php

				wp_link_pages( 'link_before=<span class="aht-page__pagination-nav">&link_after=</span>&before=<div class="aht-page__pagination"> <span>' . esc_html__( "Page:", 'aheto' ) . ' </span> &after=</div>' );


                /**
				 * Hook: aheto_after_post_content.
				 *
				 * @hooked aheto_post_footer_meta - 10
				 * @hooked aheto_post_author_bio - 10
				 * @hooked aheto_post_social_share - 10
				 */
				do_action( 'aheto_after_post_content' );
				?>

			</div>

		</div>

		<?php
		/**
		 * Hook: aheto_after_post_container.
		 *
		 * @hooked aheto_post_related_posts - 10
		 * @hooked aheto_post_comments - 10
		 */
		do_action( 'aheto_after_post_container' );
		?>

	</div>

	<?php
endwhile;

aheto_get_footer();
