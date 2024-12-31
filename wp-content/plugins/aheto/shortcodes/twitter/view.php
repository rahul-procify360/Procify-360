<?php
/**
 * Twitter templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

if ( empty( $twitter_user ) ) {
	return;
}

$this->generate_css();

$light_style = isset( $light_style ) && $light_style ? 'light-style' : '';

$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-twitter--classic' );
$this->add_render_attribute( 'wrapper', 'class', $light_style );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/twitter/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'twitter-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}


$number = isset( $number ) && ! empty( $number ) && is_numeric( $number ) ? $number : 1; ?>

	<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

		<?php $twitts = $this->aheto_get_twitts( $twitter_user );

		if ( ! empty( $twitts ) && is_array( $twitts ) ):

			$counter = 1;


			for ( $counter = 0; $counter < $number; $counter ++ ) {

				$twitt = isset( $twitts[ $counter ] ) && ! empty( $twitts[ $counter ] ) ? $twitts[ $counter ] : '';


				if ( ! empty( $twitt ) ) { ?>
					<div class="aheto-twitter--wrap">
						<div class="aheto-twitter--icon ion-social-twitter"></div>

						<div class="aheto-twitter--content">
							<?php if ( ! empty( $twitt->text ) ): ?>
								<div class="aheto-twitter--description">
									<?php echo wp_kses_post( $twitt->text ); ?>
								</div>
							<?php endif;

							if ( ! empty( $twitter_user ) ): ?>
								<div class="aheto-twitter--slug">
									@<?php echo esc_html( $twitter_user ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php } ?>
			<?php }

		endif ?>

	</div>


<?php
