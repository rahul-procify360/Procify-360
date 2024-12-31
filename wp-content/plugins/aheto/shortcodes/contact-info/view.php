<?php
/**
 * Contact Info default templates.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'widget widget_aheto__contact_info--modern' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

$underline   = isset( $underline ) && $underline ? 'underline' : '';
$title_space = isset( $title_space ) && $title_space ? 'smaller-space' : '';

$this->add_render_attribute( 'title', 'class', 'widget_aheto__title' );
$this->add_render_attribute( 'title', 'class', $underline );
$this->add_render_attribute( 'title', 'class', $title_space );

/**
 * Set dependent style
 */
$sc_dir     = aheto()->plugin_url() . 'shortcodes/contact-info/';
$custom_css = Helper::get_settings( 'general.custom_css_including' );
$custom_css = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'contact-info-style-1', $sc_dir . 'assets/css/layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

	<?php if ( ! empty( $text_logo ) && $type_logo == 'text' ) { ?>
		<div class="widget_aheto__logo">
			<h2><?php echo esc_html( $text_logo ); ?></h2>
		</div>
	<?php } elseif ( is_array( $logo ) && ! empty( $logo['url'] ) || ! is_array( $logo ) && ! empty( $logo ) ) { ?>

		<div class="widget_aheto__logo">
			<?php echo Helper::get_attachment( $logo, [ 'class' => 'aheto-clients__img' ], $image_size, $atts ); ?>
		</div>

	<?php }

	if ( ! empty( $title ) ) : ?>
		<h2 <?php $this->render_attribute_string( 'title' ); ?>>
			<?php echo wp_kses_post( $title ); ?>
		</h2>
	<?php endif;

	if ( ! empty( $description ) ) : ?>
		<p class="widget_aheto__desc">
			<?php echo wp_kses_post( $description ); ?>
		</p>
	<?php endif; ?>

	<div class="widget_aheto__infos">

		<?php if ( ! empty( $address ) ) : ?>
			<div class="widget_aheto__info widget_aheto__info--address">
				<?php echo $this->get_icon_for( 'address' ); ?>
				<p><?php echo wp_kses_post( $address ); ?></p>
			</div>
		<?php endif;

		if ( ! empty( $website ) ) : ?>
			<div class="widget_aheto__info widget_aheto__info--wesite">
				<?php echo $this->get_icon_for( 'website' ); ?>
				<a class="widget_aheto__link" href="<?php echo esc_attr( $website ); ?>">
					<?php echo esc_html( $website ); ?>
				</a>
			</div>
		<?php endif;

		if ( ! empty( $phone ) ) :
			$tel_phone = str_replace( " ", "", $phone ); ?>
			<div class="widget_aheto__info widget_aheto__info--tel">
				<?php echo $this->get_icon_for( 'phone' ); ?>
				<a class="widget_aheto__link" href="tel:<?php echo esc_attr( $tel_phone ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
			</div>
		<?php endif;

		if ( ! empty( $email ) ) : ?>
			<div class="widget_aheto__info widget_aheto__info--mail">
				<?php echo $this->get_icon_for( 'email' ); ?>
				<a class="widget_aheto__link" href="mailto:<?php echo esc_attr( $email ); ?>">
					<?php echo esc_html( $email ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>

</div>
