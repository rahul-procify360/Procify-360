<?php

$footer_text = get_bloginfo( 'name' ) . ' ' . esc_html__( ' &copy;', 'karma' ) . date( 'Y' );

?>

</div><!-- #content -->

<footer id="footer" class="karma-footer">
	<div class="karma-footer--copyright"><?php echo wp_kses($footer_text, 'post'); ?></div>
</footer>