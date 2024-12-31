<?php
/**
 * The Blog right sidebar template.
 *
 * @package Aheto
 */

use Aheto\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

aheto_get_header();
do_action( 'aheto_preloader' );

wp_enqueue_style( 'swiper' );
wp_enqueue_script( 'swiper' );
wp_enqueue_style( 'aheto-blog-list');

$sidebar_1 = Helper::get_settings( 'general.single_template_sidebar_1' );
$sidebar_1 = isset($sidebar_1['search_select']) && !empty($sidebar_1['search_select']) ? $sidebar_1['search_select'] : '';

$active_sidebar = is_active_sidebar( $sidebar_1 ) ? 'aht-page__sidebar-active' : '';

$object = new Aheto\Frontend\Breadcrumbs;
echo '<div class="aht-page__breadcrumbs"><div class="container">' . $object->get_breadcrumb( 'aht-page__breadcrumbs-list', 'aht-page__breadcrumbs-item' ) . '</div></div>';



while ( have_posts() ) :

	the_post(); ?>


    <div class="aht-page__content-inner-wrap aht-page__right-sb">

        <div class="container">
            <div class="aht-page__content-wrapper">

                <div class="aht-page__content <?php echo esc_attr($active_sidebar); ?>">

					<?php
					/**
					 * Hook: aheto_before_post_container.
					 */
					do_action( 'aheto_before_post_container' );
					?>

                    <div class="aht-page__post-head text-center">

						<?php the_terms( get_the_ID(), 'category', '<div class="post-cats"><div class="post-cats-item aheto-btn aheto-btn--primary">', '</div><div class="post-cats-item aheto-btn aheto-btn--primary">', '</div></div>' ); ?>

						<?php the_title( '<h1 class="post-title aheto-heading__title">', '</h1>' ); ?>

                        <p class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></p>


						<?php if ( has_post_thumbnail() ) {

							$thumbnail_id = get_post_thumbnail_id();

							echo Helper::get_attachment( $thumbnail_id, [ 'class' => 'post-head__main-img' ], 'full' );

						} ?>


                    </div>

					<?php
					/**
					 * Hook: aheto_before_post_content.
					 */
					do_action( 'aheto_before_post_content' );
					?>

                    <div class="aht-page__content-post">
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


					/**
					 * Hook: aheto_after_post_container.
					 *
					 * @hooked aheto_post_related_posts - 10
					 * @hooked aheto_post_comments - 10
					 */
					do_action( 'aheto_after_post_container' );
					?>

                </div>

	            <?php if ( is_active_sidebar( $sidebar_1 ) ) : ?>
                    <div class="aht-page__sb">

                        <div class="aht-page__sb-inner">

				            <?php dynamic_sidebar( $sidebar_1 ); ?>

                        </div>

                    </div>
	            <?php endif; ?>

            </div>

        </div>

    </div>

	<?php
endwhile;

aheto_get_footer();
