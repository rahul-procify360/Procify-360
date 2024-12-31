<?php
/**
 * 404 Page
 */

get_header(); ?>

    <div class="karma-error--wrap">

        <div class="karma-error--big-title"><?php esc_html_e( 'OOPS!', 'karma' ); ?></div>

        <div class="karma-error--small-title"><?php esc_html_e( '404', 'karma' ); ?></div>

        <h1 class="karma-error--title"><?php esc_html_e( 'Page not found', 'karma' ); ?></h1>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="karma-error--button"><?php esc_html_e( 'Go home', 'karma' ); ?></a>

    </div>

<?php get_footer();
