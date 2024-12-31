<?php

/**
 * The Kunst Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Kunst <info@kunst.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'block_wrapper', 'class', 'aheto-content-block--kunst__year' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/features-single/';

$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;

if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'kunst-features-single-layout3', $shortcode_dir . 'assets/css/kunst_layout3.css', null, null );
}

$vertClass = $kunst_vertical_line !== '' ? esc_attr( 'sep-act' ) : '';

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
	<div <?php $this->render_attribute_string('block_wrapper'); ?>>
		<div class="aheto-content-block__info-year <?php echo esc_attr($vertClass); ?>">

			<?php if ( !empty($kunst_year) ) : ?>
				<h4 class="aheto-content-block__year "><?php echo esc_html($kunst_year); ?></h4>
			<?php endif; ?>

			<?php if ( !empty($kunst_year_desc) ) : ?>
				<p class="aheto-content-block__year-desc">
					<?php echo esc_html($kunst_year_desc); ?>
				</p>
			<?php endif; ?>

		</div>

		<?php if ( $kunst_vertical_line !== '' ) : ?>
			<span class="aheto-content-block__separator"></span>
		<?php endif; ?>

		<div class="aheto-content-block__info">
			<?php if ( !empty($kunst_title) ) : ?>
				<?php if ( !empty($kunst_link_title) ) : ?>
					<a href="<?php echo esc_attr( $kunst_link_title );?>">
						<h4 class="aheto-content-block__title "><?php echo esc_html($kunst_title); ?></h4>
					</a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( !empty($kunst_desc) ) : ?>
				<p class="aheto-content-block__info-text ">
					<?php echo esc_html($kunst_desc); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>
