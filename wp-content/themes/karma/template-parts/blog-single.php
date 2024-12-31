<?php
/*
 * Single post
 */


$protected = '';

if ( post_password_required() ) {
	$protected = 'protected-page';
}

$get_id    = get_the_ID();
$author_id = get_the_author_meta( 'ID' );

$content_size_class = is_active_sidebar( 'karma-sidebar' ) ? 'col-12 col-lg-8' : 'col-12'; ?>

<div class="karma-blog--single-wrapper <?php echo esc_attr( $protected ); ?>">
    <div class="karma-blog--single__top-content">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="karma-blog--single__columns">
                        <div class="karma-blog--single__top-content-left">

                            <div class="karma-blog--single__categories">
								<?php the_category( ' ' ); ?>
                            </div>

							<?php the_title( '<h1 class="karma-blog--single__title">', '</h1>' ); ?>

                            <div class="karma-blog--single__date"><?php the_time( get_option( 'date_format' ) ); ?></div>

                        </div>

                        <div class="karma-blog--single__top-content-right">

                            <div class="karma-blog--single__author">

								<?php echo get_avatar( $author_id, 50 );
								echo esc_html( get_the_author() ); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container karma-blog--single__post-content">
        <div class="row">
            <div class="col-12 <?php echo esc_attr( $content_size_class ); ?>">
				<?php if ( has_post_thumbnail() ) { ?>
                    <div class="karma-blog--single__banner">
						<?php $image_url = get_the_post_thumbnail_url( $get_id, 'full' );
						$image_id        = get_post_thumbnail_id( $get_id );
						$image_alt       = get_post_meta( $image_id, '_wp_attachment_image_alt', true ); ?>

                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">

                    </div>
				<?php } ?>

                <div class="karma-blog--single__content-wrapper">

					<?php the_content();
					wp_link_pages( 'link_before=<span class="karma-blog--single__pages">&link_after=</span>&before=<div class="karma-blog--single__post-nav"> <span>' . esc_html__( "Page:", 'karma' ) . ' </span> &after=</div>' ); ?>

					<?php the_tags(
						'<div class="karma-blog--single__tags">
                        <i class="ion-ios-pricetags-outline"></i>',
						' / ',
						'</div>' ); ?>

                </div>

				<?php if ( comments_open() || '0' != get_comments_number() && wp_count_comments( $get_id ) ) { ?>
                    <div class="karma-blog--single__comments">
						<?php comments_template( '', true ); ?>
                    </div>
				<?php } ?>

                <div class="karma-blog--single__pagination">
                    <div class="karma-blog--single__pagination-prev">
						<?php $prev_post     = get_previous_post();
                            if ( ! empty( $prev_post ) ) :
                                $prev_thumbnail = get_the_post_thumbnail_url( $prev_post->ID, 'thumbnail' );
                                $prev_post_title = ! empty( get_the_title( $prev_post ) ) ? get_the_title( $prev_post ) : esc_html__( 'No title', 'karma' );
                                $prev_link       = get_permalink( $prev_post ); ?>

                                <?php if ( ! empty( $prev_thumbnail ) ) { ?>
                                <a href="<?php echo esc_url( $prev_link ); ?>" class="img-wrap">
                                    <img src="<?php echo esc_url( $prev_thumbnail ); ?>"
                                         alt="<?php echo esc_attr( $prev_post_title ); ?>">
                                </a>
                            <?php } ?>
                            <span>
                                <a href="<?php echo esc_url( $prev_link ); ?>" class="content">
                                        <?php echo wp_kses( $prev_post_title, 'post' ); ?>
                                </a>
								<?php esc_html_e( 'Prev post', 'karma' ); ?>
                            </span>

						<?php endif; ?>
                    </div>

					<?php $next_post = get_next_post(); ?>
                    <div class="karma-blog--single__pagination-next">
						<?php if ( ! empty( $next_post ) ) :
							$next_thumbnail = get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' );
							$next_post_title = ! empty( get_the_title( $next_post ) ) ? get_the_title( $next_post ) : esc_html__( 'No title', 'karma' );
							$next_link = get_permalink( $next_post ); ?>

                            <span>
                                <a href="<?php echo esc_url( $next_link ); ?>" class="content">
                                    <?php echo wp_kses( $next_post_title, 'post' ); ?>
                                </a>
								<?php esc_html_e( 'Next post', 'karma' ); ?>
                            </span>
							<?php if ( ! empty( $next_thumbnail ) ) { ?>
                            <a href="<?php echo esc_url( $next_link ); ?>" class="img-wrap">
                                <img src="<?php echo esc_url( $next_thumbnail ); ?>"
                                     alt="<?php echo esc_attr( $next_post_title ); ?>">
                            </a>
						<?php } ?>

						<?php endif; ?>
                    </div>
                </div>

            </div>
			<?php if ( is_active_sidebar( 'karma-sidebar' ) ) {

				get_sidebar( 'karma-sidebar' );

			} ?>
        </div>
    </div>
</div>