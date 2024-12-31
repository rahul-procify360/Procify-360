<?php
/**
 * The Contacts Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

use Aheto\Helper;

extract( $atts );

$this->generate_css();

// Wrapper.
$this->add_render_attribute( 'wrapper', 'id', $element_id );
$this->add_render_attribute( 'wrapper', 'class', 'aheto-contact__prego js-tab' );
$this->add_render_attribute( 'wrapper', 'class', $this->the_custom_classes() );


/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/contacts/';
$custom_css = Helper::get_settings('general.custom_css_including');
$custom_css = (isset($custom_css) && !empty($custom_css)) ? $custom_css : false;
if ((empty($custom_css) || ($custom_css == "disabled")) && !Helper::is_Elementor_Live()) {
    wp_enqueue_style('prego-contacts-layout1', $shortcode_dir . 'assets/css/prego_layout1.css', null, '');
}

$api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );

?>

<div <?php $this->render_attribute_string( 'wrapper' ); ?>>

    <?php if(is_array($prego_items) && count($prego_items)){ ?>

        <div class="aheto-contact__head">
                <?php

                if(!empty($prego_heading)){ ?>
                    <h2 class="aheto-contact__heading"><?php echo esc_html($prego_heading); ?></h2>
                <?php } ?>


                <div class="aheto-contact__head-inner">
                    <?php $count = 1;

                    foreach ($prego_items as $item){

                        $active = $count === 1 ? ' active' : '';?>
                        <div class="aheto-contact__h-item<?php echo esc_attr($active); ?>">
                            <div class="js-tab-list">
                                <?php if($item['prego_image']){
                                    echo Helper::get_attachment($item['prego_image']);
                                } ?>
                                <div class="aheto-contact__text">
                                    <?php if(!empty($item['prego_main_title'])){ ?>
                                        <h4><?php echo esc_html($item['prego_main_title']); ?></h4>
                                    <?php }
                                    if(!empty($item['prego_main_address'])){ ?>
                                        <p><?php echo wpautop($item['prego_main_address']); ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $count++;

                    } ?>
                </div>

            </div>
        <div class="aheto-contact__content">
                <?php

                $int = 1;
                foreach ($prego_items as $item){
                    $class = $int === 1 ? ' active': '';?>
                    <div class="aheto-contact__c-item js-tab-box <?php echo esc_attr($class); ?>">
                        <?php

                        if ( !empty( $item['prego_office_address'] ) ) {
                            if ( 0 === absint( $item['prego_zoom']['size'] ) ) {
                                $item['prego_zoom']['size'] = 10;
                            }

                            $params = [
                                rawurlencode( $item['prego_office_address'] ),
                                absint( $item['prego_zoom']['size'] ),
                            ];

                            if ( $api_key ) {
                                $params[] = $api_key;

                                $url = 'https://www.google.com/maps/embed/v1/place?key=%3$s&q=%1$s&amp;zoom=%2$d';
                            } else {
                                $url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
                            } ?>

                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    src="<?php echo esc_url( vsprintf( $url, $params ) ); ?>"
                                    title="<?php echo esc_attr( $item['prego_office_address'] ); ?>"
                                    aria-label="<?php echo esc_attr( $item['prego_office_address'] ); ?>"
                            ></iframe>

                        <?php } ?>

                        <div class="aheto-contact__sidebar">
                            <?php if(!empty($item['prego_office_title'])){ ?>
                                <h5><?php if($item['prego_office_image']){
                                        echo Helper::get_attachment($item['prego_office_image']);
                                    }

                                    echo esc_html($item['prego_office_title']); ?></h5>
                            <?php }
                            if(!empty($item['prego_office_address'])){ ?>
                                <div><?php echo wpautop($item['prego_office_address']); ?></div>
                            <?php } ?>

                            <?php if(!empty($item['prego_schedule_title'])){ ?>
                                <h5><?php if($item['prego_schedule_image']){
                                        echo Helper::get_attachment($item['prego_schedule_image']);
                                    }

                                    echo esc_html($item['prego_schedule_title']); ?></h5>
                            <?php }
                            if(!empty($item['prego_schedule'])){ ?>
                                <div><?php echo wpautop($item['prego_schedule']); ?></div>
                            <?php } ?>

                            <?php if(!empty($item['prego_phone_title'])){ ?>
                                <h5><?php if($item['prego_phone_image']){
                                        echo Helper::get_attachment($item['prego_phone_image']);
                                    }

                                    echo esc_html($item['prego_phone_title']); ?></h5>
                            <?php }
                            if(!empty($item['prego_phone'])){ ?>
                                <div><?php echo wpautop($item['prego_phone']); ?></div>
                            <?php } ?>
                        </div>

                    </div>
                <?php
                    $int++;
                } ?>
            </div>

    <?php } ?>

</div>
