<?php
/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-content-block aheto-content-block--aira-with-background');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());


/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-single/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('aira-features-single-with-background', $sc_dir . 'assets/css/aira_layout9.css', null, null);
}
if (  !Helper::is_Elementor_Live()) {
	wp_enqueue_script('aira-features-single-with-background-js', $sc_dir . 'assets/js/aira_layout9.min.js', array('jquery'), null);
}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

	<?php

	$background_image = !empty($s_image) ? Helper::get_background_attachment( $s_image, $aira_image_size, $atts, 'aira_' ) : ''; ?>

	<div class="aheto-content-block--bgImage" <?php echo esc_attr($background_image); ?>>
        <div class="aheto-content-block__overlay"></div>
		<div class="aheto-content-block__descr">

			<?php
			if ( !empty($s_heading) ) : ?>
				<h4 class="aheto-content-block__title"><?php echo wp_kses( $this->highlight_text($s_heading), 'post' ); ?></h4>
			<?php endif; ?>

			<div class="aheto-content-block__info">

				<?php if ( !empty($s_description) ) : ?>
					<p class="aheto-content-block__info-text">
						<?php echo wp_kses($s_description, 'post'); ?>
					</p>
				<?php endif; ?>

			</div>


            <?php
            // Button Link.
            if ($aira_add_button) { ?>
                <div class="aheto-content-block__link t-center">
                    <?php echo \Aheto\Helper::get_button($this, $atts, 'aira_'); ?>
                </div>
            <?php }
            ?>

		</div>

	</div>

</div>

