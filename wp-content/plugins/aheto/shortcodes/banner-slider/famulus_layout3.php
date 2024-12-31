<?php
/**
 * The Banner Slider Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($famulus_image_bc) ) {
	return '';
}

$this->generate_css();
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());
$this->add_render_attribute('wrapper', 'class', 'aheto-banner-wrap--famulus-breadcrumbs');

$title_class = '';

if ( $famulus_white_bc == true ) {
	$this->add_render_attribute('wrapper', 'class', 'aheto-banner-wrap--white');
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/banner-slider/';
$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('famulus-banner-slider-layout3', $shortcode_dir . 'assets/css/famulus_layout3.css', null, null);
}
?>
<?php
$background_image = '';

if ( !empty($famulus_image_bc) ) :
	$background_image = Helper::get_background_attachment($famulus_image_bc, 'full');
endif; ?>

<div <?php $this->render_attribute_string('wrapper'); ?> <?php echo esc_attr($background_image); ?>>

	<?php if ( $famulus_img_overlay_bc == true ) : ?>
		<div class="aheto-banner-wrap__overlay"></div>
	<?php endif; ?>
	<div class="aheto-banner-wrap__container">
		<?php if ( !empty($famulus_title_bc) ) : ?>
			<h1 class="aheto-banner-wrap__title <?php echo esc_attr($title_class); ?>">
				<?php echo esc_html($famulus_title_bc); ?>
			</h1>
		<?php else: ?>
			<h1 class="aheto-banner-wrap__title <?php echo esc_attr($title_class); ?>">
				<?php echo get_the_title(); ?>
			</h1>
		<?php endif; ?>
		<ul class="aheto-banner-wrap__breadcrumbs">
			<li>
				<a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'aheto'); ?></a>
			</li>
			<?php global $post;
			if ( is_page() && $post->post_parent ) { ?>
				<li>
					<a href="<?php echo esc_url(get_the_permalink($post->post_parent)); ?>"><?php echo get_the_title($post->post_parent); ?></a>
				</li>
			<?php } ?>
			<li><?php the_title(); ?></li>
		</ul>
	</div>
</div>
