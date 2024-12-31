<?php
/**
 * Post Format Gallery
 *
 * @package Aheto
 */

use Aheto\Helper;

$as_slider = Helper::get_post_meta( 'post_as_slider' );
$gallery   = Helper::get_post_meta( 'post_gallery' );

if ( ! $as_slider ) {
	wp_enqueue_style( 'lity' );
	wp_enqueue_script( 'lity' );
	?>
	<div class="gallery-wrapper">

		<?php foreach ( (array) $gallery as $attachment_id => $attachment_url ) : ?>
		<div class="gallery-image">

			<a href="<?php echo $attachment_url; ?>" class="gallery-overlay" data-lity>
				<i class="icon ion-ios-search-strong"></i>
			</a>

			<?php echo \Aheto\Helper::get_attachment( $attachment_id, [ 'class' => 'js-bg' ] ); ?>

		</div>
		<?php endforeach; ?>

	</div>
	<?php
	return;
}
?>
<div class="swiper swiper--blog-gallery">

	<div class="swiper-container" data-speed="600" data-spacebetween="0" data-slidesperview="responsive" data-add-slides="1" data-lg-slides="1" data-md-slides="1" data-sm-slides="1" data-xs-slides="1">

		<div class="swiper-wrapper">

			<?php foreach ( (array) $gallery as $attachment_id => $attachment_url ) : ?>
			<div class="swiper-slide">
				<?php echo \Aheto\Helper::get_attachment( $attachment_id, [ 'class' => 'js-bg' ] ); ?>
			</div>
			<?php endforeach; ?>

		</div>

	</div>

	<div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
	<div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>

</div>
