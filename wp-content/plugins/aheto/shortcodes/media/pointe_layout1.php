<?php
/**
 * The Pointe Media Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

if ( empty($pointe_image) ) {
	return '';
}
$pointe_image = $this->parse_group($pointe_image);
$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto_media aheto_media__pointe');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/media/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('magnific');
	wp_enqueue_style('pointe-media-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('pointe-media-layout1-js', $sc_dir . 'assets/js/pointe_layout1.min.js', array('jquery'), null);
	wp_enqueue_script('magnific');
	wp_enqueue_script('isotope');

}
?>
<div <?php $this->render_attribute_string('wrapper'); ?>>

<div class="boxed-grid-gallery-wrap">

<div class="boxed-grid-filters">

	<?php
		// All filtr button.
		if ( !empty($pointe_flitr_all )) {
			echo '<button class="button is-checked" data-media="*">' . wp_kses_post($pointe_flitr_all) . '</button>';
		}
		?>

	<?php
	$categories_filter_array = array();

	foreach ( $pointe_image as $image ) {
		$categories_filter = get_the_terms( $image['id'], 'media-category' );
		if ( ! empty( $categories_filter ) ) {
			foreach ( $categories_filter as $filter ) {
				if (!in_array($filter->slug, $categories_filter_array)) {
					$categories_filter_array[] = $filter->slug; ?>
					<button class="button" data-media=".<?php echo esc_attr($filter->slug); ?>">
						<?php echo esc_html($filter->name); ?>
					</button>
				<?php } ?>

			<?php }
		}
	} ?>
</div>

<div class="aheto_media__pointe__gallery">
	<?php foreach ( $pointe_image as $image ) {
		$url        = ( ! empty( $image['id'] ) && is_numeric( $image['id'] ) ) ? wp_get_attachment_image_url( $image['id'], 'full' ) : '';
		$attachment =  Helper::get_attachment($image['id']);
		$categories = get_the_terms( $image['id'], 'media-category' );
		$categories = ! empty( $categories ) ? $categories : '';
		$category   = array();
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $item ) {
				$category[] = $item->slug;
			}
			$category = implode( " ", $category );

		}else{
			$category = '';
		} ?>

		<a href="<?php echo esc_url( $url ); ?>" class="item item-filter <?php echo esc_attr($category); ?>">
			<div class="item-filter-wrapper">
			<?php if ( ! empty( $url ) ) { ?>
				<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr($title); ?>" class="s-img-switch js-bg">
			<?php } ?>

			</div>
		</a>

	<?php } ?>
</div>
</div>


</div>
