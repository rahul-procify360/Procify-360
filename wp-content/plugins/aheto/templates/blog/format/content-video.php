<?php
/**
 * Post Format Video
 *
 * @package Aheto
 */

use Aheto\Helper;

$video = Helper::get_post_meta( 'post_video_link' );
if ( empty( $video ) ) {
	return;
}

wp_enqueue_style( 'lity' );
wp_enqueue_script( 'lity' );
?>
<div class="image-wrapper video-wrapper">

	<a href="<?php echo esc_url( $video ); ?>" data-lity>
		<?php
		if ( has_post_thumbnail() ) {
			echo \Aheto\Helper::get_attachment( get_post_thumbnail_id(), [ 'class' => 'js-bg' ] );
		}
		?>
	</a>

</div>
