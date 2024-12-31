<?php
/**
 * The template for displaying post social share links
 *
 * @package Aheto
 */

?>
<div class="aht-page__socials">

	<div class="aht-page__socials__share text-center">
		<a class="aht-page__socials__share__link" href="#" data-share="http://www.facebook.com/sharer.php?u=<?php esc_url(the_permalink()); ?>&amp;t=<?php echo esc_attr(urlencode(the_title('', '', false))); ?>" target="_blank" rel="nofollow noopener noreferrer">
			<i class="aht-page__socials__share__icon icon ion-social-facebook"></i>
		</a>
		<a class="aht-page__socials__share__link" href="#" data-share="https://twitter.com/intent/tweet?text=<?php echo esc_attr(urlencode(the_title('', ' ', false))); ?><?php esc_url( the_permalink() ); ?>" target="_blank" rel="nofollow noopener noreferrer">
			<i class="aht-page__socials__share__icon icon ion-social-twitter"></i>
		</a>
		<a class="aht-page__socials__share__link" href="#" data-share="http://linkedin.com/shareArticle?mini=true&amp;url=<?php esc_url(the_permalink()); ?>&amp;title=<?php echo esc_attr(urlencode(the_title('', '', false))); ?>" target="_blank" rel="nofollow noopener noreferrer">
			<i class="aht-page__socials__share__icon icon ion-social-linkedin"></i>
		</a>
	</div>

</div>