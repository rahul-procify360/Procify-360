<?php
/**
 * Post Format Audio
 *
 * @package Aheto
 */

use Aheto\Helper;

$audio = Helper::get_post_meta( 'post_audio_file' );
if ( empty( $audio ) ) {
	return;
}

?>
<div class="audio-wrapper">

	<audio controls>
		<source src="<?php echo esc_url( $audio ); ?>" type="audio/mpeg">
	</audio>

</div>
