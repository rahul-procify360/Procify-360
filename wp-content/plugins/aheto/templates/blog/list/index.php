<?php
/**
 * Index Page
 *
 * @package aheto
 * @since 1.0
 *
 */

use Aheto\Helper;

$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$term  = get_query_var( 's' );

$count      = isset( $wp_query->found_posts ) && ! empty( $wp_query->found_posts ) ? $wp_query->found_posts : '0';
$count_text = $count == '1' ? esc_html__( 'result found', 'aheto' ) : esc_html__( 'results found', 'aheto' );

$sc_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
wp_enqueue_style( 'cpt-1', $sc_dir . 'assets/css/skin-1.css', null, null );
wp_enqueue_style( 'custom-post-types--pagination-numbers', $sc_dir . 'assets/css/pagination-numbers.css', null, null );
wp_enqueue_style( 'aheto-blog-list');
wp_enqueue_style( 'aheto-blog-list-full', aheto()->plugin_url() . 'assets/frontend/css/blog-list.css', null, null );

aheto_get_header();

do_action( 'aheto_preloader' ); ?>


    <div class="aheto-blog">
        <div class="aheto-blog--banner">
			<?php if ( is_search() ) { ?>
                <div class="aheto-blog--banner__title-wrap">
                    <h2 class="aheto-blog--banner__title">
						<?php esc_html_e( 'Search Results', 'aheto' ); ?>
                    </h2>
                </div>
			<?php } else { ?>
                <div class="aheto-blog--banner__title-wrap">
                    <h2 class="aheto-blog--banner__title"><?php esc_html_e( 'Blog', 'aheto' ); ?></h2>
                </div>
			<?php } ?>
        </div>
		<?php

		if ( have_posts() ) : ?>

            <div class="aheto-cpt aheto-cpt--grid container">

				<?php if ( is_search() ) { ?>
                    <div class="aheto-blog--banner__count-results">
                        <h1><?php esc_html_e( 'Showing results for ', 'aheto' ); ?>"<?php echo esc_html( $term ); ?>"</h1>
						<span><?php echo esc_html( $count . ' ' . $count_text ); ?></span>
                    </div>
				<?php } ?>

                <div class="aheto-cpt__list js-isotope">
                    <div class="aheto-cpt-article aheto-cpt-article--size"></div>


					<?php while ( have_posts() ) :
						the_post();


						$format = get_post_format();
						$format = isset( $format ) && ! empty( $format ) ? $format : 'image';

						if ( 'gallery' == $format ) {
							$as_slider = get_post_meta( get_the_ID(), 'aheto_post_as_slider', true );

							$format = 'on' === $as_slider ? 'slider' : $format;
						} ?>

                        <article
                                class="aheto-cpt-article aheto-cpt-article--grid aheto-cpt-article--static aheto-cpt-article--skin-1">

                            <div class="aheto-cpt-article__inner">

								<?php

								switch ( $format ) {
									case 'quote':
										Helper::getPostTerms( 'category', '-hover-light' );
										Helper::getPostQuote( 'aheto-quote aheto-quote--icon-right' );

										break;

									case 'slider':
										Helper::getPostSlider( '', true, false, 'large' );
										Helper::getPostTerms( 'category' ); ?>

                                        <div class="aheto-cpt-article__content">
											<?php Helper::getPostDate(); ?>
											<?php Helper::getPostTitle(); ?>
											<?php Helper::getPostExcerpt(); ?>
											<?php Helper::getPostLink( 'aheto-link aheto-btn--primary' ); ?>
                                        </div>
										<?php
										break;

									case 'gallery':
										Helper::getPostGallery( '', 'large' ); ?>

                                        <div class="aheto-cpt-article__content">
											<?php

											Helper::getPostTerms( 'category', 'aheto-cpt-article__terms--static' );
											Helper::getPostDate();
											Helper::getPostTitle();
											Helper::getPostExcerpt();
											Helper::getPostLink( 'aheto-link aheto-btn--primary' );
											?>
                                        </div>
										<?php

										break;

									case 'video':
										$video_btn_params = [
											'video_style' => 'aheto-btn--light',
											'video_size'  => 'aheto-btn-video--small',
										];

										Helper::getPostVideo( 'aheto-cpt-article__img', $video_btn_params, 'js-bg', 'large');
										Helper::getPostTerms( 'category' ); ?>

                                        <div class="aheto-cpt-article__content">
											<?php Helper::getPostDate(); ?>
											<?php Helper::getPostTitle(); ?>
											<?php Helper::getPostExcerpt(); ?>
											<?php Helper::getPostLink( 'aheto-link aheto-btn--primary' ); ?>
                                        </div>
										<?php

										break;

									case 'audio': ?>

                                        <div class="aheto-cpt-article__content">
											<?php

											Helper::getPostTerms( 'category', 'aheto-cpt-article__terms--static' );
											Helper::getPostAudio();
											Helper::getPostDate();
											Helper::getPostTitle();
											Helper::getPostExcerpt();
											Helper::getPostLink( 'aheto-link aheto-btn--primary' );

											?>
                                        </div>
										<?php
										break;

									case 'image':
									default:
										$isHasThumb = Helper::getPostImage( 'js-bg', '', 'large', true, true ); ?>

                                        <div class="aheto-cpt-article__content">
											<?php
											$terms_class = ! $isHasThumb ? 'aheto-cpt-article__terms--static' : '';
											Helper::getPostTerms( 'category', $terms_class );
											Helper::getPostDate();
											Helper::getPostTitle();
											Helper::getPostExcerpt();
											Helper::getPostLink( 'aheto-link aheto-btn--primary' ); ?>
                                        </div>

										<?php break;

								} ?>

                            </div>

                        </article>


					<?php endwhile; ?>

                </div>


				<?php


				if ( $wp_query->max_num_pages > 1 ) { ?>

                    <div class="aheto-cpt-pagination t-center">
						<?php echo paginate_links( array(
							'total'     => $wp_query->max_num_pages,
							'prev_text' => __( '<i class="ion-arrow-left-c"></i> PREV' ),
							'next_text' => __( 'NEXT <i class="ion-arrow-right-c"></i>' ),
						) ); ?>

                    </div>
				<?php }

				wp_reset_query(); ?>

            </div>

		<?php else : ?>

            <div class="aheto-blog--search-page">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="aheto-blog--search-page__title"><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'aheto' ); ?></h1>
                            <div class="aheto-blog--search-page__search-form">
								<?php get_search_form( true ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div>
<?php

aheto_get_footer();





