<?php
/**
 * Title bar default templates.
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
$this->add_render_attribute('wrapper', 'class', 'aheto-titlebar--title-with-search');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/title-bar/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'acacio-title-bar-layout1', $shortcode_dir . 'assets/css/acacio_layout1.css', null, null );

}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>

	<div class="aheto-titlebar__main">
		<div class="aheto-titlebar__content">
			<div class="aheto-titlebar__content-inner">
				<?php
				$title = $this->get_heading();
				if (!empty($title)) {
					echo '<' . $title_tag . ' class="aheto-titlebar__title">' .  $title . '</' . $title_tag . '>';
				}  ?>

				<?php if ( !empty($searchform) ) : ?>
					<div class="aheto-titlebar__input <?php echo Helper::get_button($this, $atts, 'sf_', true); ?>">
						<form role="search" class="w-800" method="get" id="searchform"
							  action="<?php echo home_url('/'); ?>">

							<label class="screen-reader-text" for="s">Search: </label>

							<input type="text" value="" name="s" id="s"
								   placeholder="<?php echo esc_html($sf_placeholder); ?>"/>

							<?php if ( !empty( $sf_button ) ) { ?>
								<input type="submit" id="searchsubmit" value="<?php echo esc_html($sf_button); ?>"/>
							<?php } else { ?>
								<div class="submit-wrap ion-android-search">
									<input class="not-value" type="submit" id="searchsubmit" value=""/>
								</div>
							<?php } ?>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>

</div>
