<?php
/**
 * The Pricing Tables Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-pricing-tables--snapster-cf_simple' );

$random             = substr( md5( rand() ), 0, 7 );
$mail               = isset( $mail ) && ! empty( $mail ) ? $mail : '';
$snapster_cf_submit = isset( $snapster_cf_submit ) && ! empty( $snapster_cf_submit ) ? $snapster_cf_submit : esc_attr__( 'Submit', 'snapster' );
$snapster_cf_pdf    = isset( $snapster_cf_pdf ) && ! empty( $snapster_cf_pdf ) ? $snapster_cf_pdf : esc_html__('Download PDF', 'snapster');

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/pricing-tables/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'snapster-pricing-tables-layout9', $shortcode_dir . 'assets/css/snapster_layout9.css', null, null );
}
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_script('snapster-pricing-tables-layout9-js', $shortcode_dir . 'assets/js/snapster_layout9.min.js', array('jquery'), null);
} ?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $snapster_cf_mail ) ) { ?>
		<div class="aheto-pricing-tables__form <?php echo Helper::get_button( $this, $atts, 'snapster_cf_simple_', true ); ?>">
			<form id="aheto-pricing-tables__pricelistform" class="aheto-pricing-tables__send-email"
			      data-mail="<?php echo esc_attr( $snapster_cf_mail ); ?>" data-price="0">

				<input type="text" name="snapster_name"
				       placeholder="<?php esc_html_e( 'Name *', 'snapster' ); ?>" required>

				<input type="email" name="snapster_email"
				       placeholder="<?php esc_html_e( 'Email *', 'snapster' ); ?>"
				       required>

				<textarea name="snapster_message" cols="30" rows="10"
				          placeholder="<?php echo esc_attr( $snapster_cf_placeholder ); ?>"></textarea>
				<div class="aheto-pricing-tables__button-wrap">
					<?php if ( isset( $snapster_cf_term ) && ! empty( $snapster_cf_term ) ) { ?>
						<div class="aheto-pricing-tables__term-wrap">
							<label>
								<input type="checkbox" name="snapster_term" required>
								<span></span>
								<?php esc_html_e( 'I agree with the', 'snapster' ); ?> <a
									href="<?php echo esc_url( $snapster_cf_term ); ?>"
									target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Term', 'snapster' ); ?></a>
							</label>
						</div>
					<?php } ?>
					<input type="submit" id="snapster-send" value="<?php echo esc_attr( $snapster_cf_submit ); ?>">
				</div>
				<div class="aheto-pricing-tables__send-popup">
					<div class="aheto-pricing-tables__content">
						<div class="aheto-pricing-tables__close">
							<span class="aheto-pricing-tables__line"></span>
							<span class="aheto-pricing-tables__line"></span>
						</div>
						<h4 class="aheto-pricing-tables__popup-title">
							<?php esc_html_e( 'Thank you!', 'snapster' ); ?>
						</h4>
						<p class="aheto-pricing-tables__done"><?php esc_html_e( 'Your message is sent!', 'snapster' ); ?></p>
						<p class="aheto-pricing-tables__error"><?php esc_html_e( "Oooops! Your message isn't sent!", "snapster" ); ?></p>
						<a href="" class="aheto-pricing-tables__pdf-wrap aheto-btn aheto-btn--light" download>
							<?php echo esc_html( $snapster_cf_pdf ); ?>
						</a>
					</div>
				</div>
			</form>
		</div>
		<div class="aheto-pricing-tables__price-send-loader">
			<div class="aheto-pricing-tables__lds-dual-ring"></div>
		</div>

	<?php } ?>











</div>
