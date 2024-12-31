<?php

/**
 * The Heading Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Karma <info@karma.com>
 */

extract($atts);

use Aheto\Helper;

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-twitter--karma-political__simple');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/twitter/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'karma-political-twitter-style-1', $shortcode_dir . 'assets/css/karma_political_layout1.css', null, null );
}

$number = isset( $number ) && ! empty( $number ) && is_numeric( $number ) ? $number : 1;

?>


<div <?php $this->render_attribute_string('wrapper'); ?>>

    <?php $twitts = $this->aheto_get_twitts( $twitter_user );

	    if ( ! empty( $twitts ) && is_array( $twitts ) ):

	        $counter = 1;

	        for ( $counter = 0; $counter < $number; $counter ++ ) {

	            $twitt = isset( $twitts[ $counter ] ) && ! empty( $twitts[ $counter ] ) ? $twitts[ $counter ] : '';

	            if ( ! empty( $twitt ) ) { ?>
	                <div class="aheto-twitter--wrap">
	                    <div class="aheto-twitter--icon ion-social-twitter"></div>

						<?php if ( ! empty( $karma_political_desc ) || ! empty( $karma_political_hash ) || ! empty( $karma_political_link ) ): ?>
							<div class="aheto-twitter--content">
								<?php if ( ! empty( $karma_political_desc ) ) { ?>
									<div class="aheto-twitter--desc">
										<?php echo wp_kses_post( $karma_political_desc ); ?>
									</div>
								<?php } ?>

								<?php if ( ! empty( $karma_political_hash ) ) { ?>
									<div class="aheto-twitter--hash">
										<?php echo esc_html( $karma_political_hash ); ?>
	                                </div>
                                <?php } ?>

                                <?php if ( ! empty( $karma_political_link ) ) { ?>
                                    <div class="aheto-twitter--link">
                                        <a href="<?php echo esc_attr( $karma_political_link ); ?>" ><?php echo esc_html( $karma_political_link ); ?></a>
                                    </div>
                                <?php } ?>
							</div>
						<?php endif; ?>
	                </div>
	            <?php } ?>
	        <?php }
	    endif
    ?>

</div>
