<?php
/**
 * The template for displaying related posts
 *
 * @package Aheto
 */

$post_id   = get_the_ID();
$post_tags = wp_get_post_tags( $post_id );
if ( empty( $post_tags ) ) {
	return;
}

$tag_ids = wp_list_pluck( $post_tags, 'term_id' );

$related_query = new WP_Query([
	'tag__in'             => $tag_ids,
	'post__not_in'        => [ $post_id ],
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => 1,
]);

if ( ! $related_query->have_posts() ) {
	return;
}

wp_enqueue_style( 'swiper' );
wp_enqueue_script( 'swiper' );
?>
<div class="aht-page__related-posts">

	<div class="aht-page__content-inner">

		<div class="container">

			<div class="aheto-heading t-center">

				<h3><?php esc_html_e( 'More Recent Stories', 'aheto' ); ?></h3>

			</div>

			<div class="swiper aht-page__recent-posts">

				<div class="swiper-container" data-autoplay="5000" data-speed="1500" data-spaces="30" data-simulate_touch="true" data-slides="2" data-slides_lg="2" data-slides_md="2" data-slides_sm="2" data-slides_xs="1" data-loop="1">

					<div class="swiper-wrapper">

						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();

							$post_id = get_the_ID();
							$no_image     = !has_post_thumbnail() ? ' no-image' : '';
							$image_id = get_post_thumbnail_id($post_id);
							$author_id =  get_the_author_meta('ID'); ?>


                                <div class="swiper-slide">
                                    <div class="aht-page__recent-posts__info-wrap">
	                                    <?php if ( !empty($image_id) ) {
		                                    $image = wp_get_attachment_image_url($image_id, 'thumbnail');
		                                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true ); ?>
                                            <div class="aht-page__recent-posts__media">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="js-bg-swiper swiper-lazy">
                                            </div>
	                                    <?php } ?>

                                        <div class="aht-page__recent-posts__text">
                                            <h5><a href="<?php the_permalink(); ?>"
                                                   class="aht-page__recent-posts__title"><?php the_title(); ?></a></h5>
                                            <div class="aht-page__recent-posts__info-wrap-date">
                                                <a href="<?php the_permalink(); ?>">
			                                        <?php the_time( get_option( 'date_format' ) ); ?>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

							<?php
						endwhile;

						wp_reset_query();
						?>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>
