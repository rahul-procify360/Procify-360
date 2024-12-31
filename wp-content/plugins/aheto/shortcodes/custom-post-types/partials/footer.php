<div class="aheto-cpt-article__footer">

	<div class="aheto-cpt-article__author aheto-cpt-article__footer-item">

		<?php echo get_avatar(get_the_author_meta('ID'), 35); ?>
		<span><?php the_author(); ?></span>

	</div>

	<?php $likes = get_post_meta(get_the_ID(), 'aheto_post_likes', true); ?>
	<div class="aheto-cpt-article__likes aheto-cpt-article__footer-item">
		<i class="icon ion-heart"></i>
		<span><?php echo $likes ? $likes : 0; ?> <?php esc_html_e('Likes', 'aheto'); ?></span>
	</div>

	<?php if ( !post_password_required() && (comments_open() || get_comments_number()) ) : ?>
		<div class="aheto-cpt-article__comments aheto-cpt-article__footer-item">
			<i class="icon ion-chatbubble-working"></i>
			<span><?php comments_popup_link(__('0 Comments', 'aheto'), __('1 Comment', 'aheto'), __('% Comment', 'aheto')); ?></span>
		</div>
	<?php endif; ?>

</div>
