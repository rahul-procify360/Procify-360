<?php
/**
 * The Contents Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
use Aheto\Helper;

extract( $atts );

$this->generate_css();

$noize_active = isset($noize_active) && $noize_active ? 'active' : '';

// Wrapper.
$this->generate_css();
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );
//
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--noize-isotope' );

$this->add_render_attribute( 'wrapper', 'class', 'aheto-contents--noize-lay1' );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contents/';
if ( !Helper::is_Elementor_Live()) {
	wp_enqueue_script('isotope');
	wp_enqueue_script('noize-contents-layout1-js', $shortcode_dir . 'assets/js/noize_layout1.js', array('jquery'), null);
}

$custom_css    = Helper::get_settings('general.custom_css_including');
$custom_css    = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;

if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style( 'noize-contents-layout1', $shortcode_dir . 'assets/css/noize_layout1.css', null, null );
}

?>

<div <?php $this->render_attribute_string('wrapper'); ?>>
    <div class="aheto-contents__head">
        <ul class="aheto-contents__list ">

            <li class="aheto-contents__list-item active">
                <a href="#" data-contents-filter="*" class="aheto-contents__list-link js-tab-list aheto-contents__content">
                    <?php esc_html_e('All', 'noize'); ?>
                </a>
            </li>

            <?php
            $all_filters = array();

            foreach ( $noize_contents as $index => $item ) :

                $item['noize_contents_category'] = !empty($item['noize_contents_category']) ? $item['noize_contents_category'] : '';

                $filter_heading = str_replace( ' ', '_', $item['noize_contents_category'] );
                $filter_heading = strtolower($filter_heading);

                if (!in_array($item['noize_contents_category'], $all_filters)) {

                    $all_filters[] = $item['noize_contents_category'];

                    $heading_tag = isset( $item['heading_tag'] ) && ! empty( $item['heading_tag'] ) ? $item['heading_tag'] : 'h4'; ?>

                    <li class="aheto-contents__list-item">
                        <a href="#" data-contents-filter=".<?php echo esc_html( $filter_heading ); ?>" class="aheto-contents__list-link js-tab-list aheto-contents__content">
                            <?php if ( $item['noize_contents_category'] ) :

                                echo esc_html( $item['noize_contents_category'] );

                            endif; ?>
                        </a>
                    </li>
                    <?php
                }
            endforeach; ?>

        </ul>
    </div>


    <div class="aheto-contents__content">

        <?php foreach ( $noize_contents as $index => $item ) :
            $filter_heading = str_replace( ' ', '_', $item['noize_contents_category'] );
            $filter_heading = strtolower($filter_heading);

            if ( empty($item['noize_contents_heading']) && empty($item['noize_contents_descr']) ) {
                continue;
            }
            ?>

            <div class="aheto-contents__item-content js-isotope-box <?php echo esc_attr( $filter_heading ); ?>">

                <?php if ( !empty($item['noize_contents_heading']) && isset($item['noize_contents_heading']) ) : ?>
                    <h5 class="aheto-contents__title-content cs-js-accordion"><?php echo wp_kses_post($item['noize_contents_heading']); ?></h5>
                <?php endif; ?>

                <?php if ( !empty($item['noize_contents_descr']) && isset($item['noize_contents_descr']) ) : ?>
                    <div class="aheto-contents__panel-content cs-js-accordion-text">
                        <p class="aheto-contents__desc-content">
                            <?php echo wp_kses_post($item['noize_contents_descr']); ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>
