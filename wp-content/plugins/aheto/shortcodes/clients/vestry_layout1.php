<?php

/**
 * The Clients Shortcode.
 */

use Aheto\Helper;

extract( $atts );

$clients = $this->parse_group( $clients );
if ( empty( $clients ) ) {
	return '';
}

$this->generate_css();

$item_per_row = isset( $item_per_row ) && ! empty( $item_per_row ) ? $item_per_row : 2;

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-clients--vestry-modern' );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-clients--' . $item_per_row . '-in-row' );
$this->add_render_attribute( 'wrapper', 'class', $hover_style );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/clients/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style( 'vestry-clients-layout1', $shortcode_dir . 'assets/css/vestry_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>
	<?php foreach ( $clients as $key => $item ) :
		if ( $item['image'] ) :
			$button = $this->get_link_attributes( $item['link_url'] );
			$this->add_render_attribute( 'button-' . $key, $button ); ?>
            <div class="aheto-clients__holder">
				<?php if ( isset( $button['href'] ) && ! empty( $button['href'] ) ) : ?>
                    <a <?php $this->render_attribute_string( 'button-' . $key ); ?>>
						<?php echo Helper::get_attachment( $item['image'] ); ?>
                    </a>
				<?php else :
					echo Helper::get_attachment( $item['image'] );
				endif; ?>
            </div>
		<?php endif;

	endforeach; ?>
</div>