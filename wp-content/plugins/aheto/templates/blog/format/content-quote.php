<?php
/**
 * Post Format Quote
 *
 * @package Aheto
 */

use Aheto\Helper;

$quote  = Helper::get_post_meta( 'post_blockquote' );
$author = Helper::get_post_meta( 'post_blockquote_author' );
?>
<div class="content-wrapper">
    <blockquote class="wp-block-quote">
        <p><?php echo wp_kses_post( $quote ); ?></p>
        <cite><?php echo esc_html( $author ); ?></cite>
    </blockquote>

</div>
