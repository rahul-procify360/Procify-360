<?php
/**
 * The template for displaying Author info
 *
 * @package Aheto
 */

if ( empty( get_the_author_meta( 'description' ) ) ) {
	return;
}

?>
<div class="aht-page__post-author-info">

    <div class="aht-page__post-author-info-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
    </div>

    <div class="aht-page__post-author-info-content">
        <p>
            <b>
				<?php
				printf(
				/* translators: %s: post author */
					__( 'About the author: %s', 'aheto' ),
					esc_html( get_the_author() )
				);
				?>
            </b>
        </p>
        <p>
	        <?php the_author_meta( 'description' ); ?>
        </p>

        <div class="aht-page__post-author-info-button">
	        <?php echo esc_html__('More posts by ', 'aheto'); ?>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <?php echo esc_html( get_the_author() ); ?>
            </a>
        </div>

    </div>

</div>
