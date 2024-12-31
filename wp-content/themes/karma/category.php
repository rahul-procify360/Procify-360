<?php
/**
 * Category Template
 */
$count = isset( $posts->found_posts ) && ! empty( $posts->found_posts ) ? $posts->found_posts : '0';
$count_text = $count == '1' ? esc_html__( 'result found', 'karma' ) : esc_html__( 'results found', 'karma' );

get_header(); ?>
    <div class="karma-blog--banner">
		<?php if ( is_search() ) { ?>
            <div class="karma-blog--banner__title-wrap">
                <h1 class="karma-blog--banner__title"><?php esc_html_e( 'Showing results for ', 'karma' ); ?>
                    <span>"<?php echo esc_html( $term ); ?>"</span></h1>
                <div class="karma-blog--banner__count-results"><?php echo esc_html( $count . ' ' . $count_text ); ?></div>
            </div>
		<?php } else { ?>
            <div class="karma-blog--banner__title-wrap">
                <h1 class="karma-blog--banner__title"><?php esc_html_e( 'Blog', 'karma' ); ?></h1>
            </div>
		<?php } ?>
    </div>

<?php

if ( have_posts() ) :
	get_template_part( 'template-parts/blog', 'list-category' );

else : ?>
    <div class="karma-blog--search-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="karma-blog--search-page__title"><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'karma' ); ?></h3>
                    <div class="karma-blog--search-page__search-form">
						<?php get_search_form( true ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;

get_footer();