<?php

/**
 * The Features Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

use Aheto\Helper;

extract($atts);

$tabs = $this->parse_group($pointe_tabs);
if (empty($tabs)) {
	return '';
}

$this->generate_css();

// Wrapper.
$this->add_render_attribute('wrapper', 'id', $element_id);
$this->add_render_attribute('wrapper', 'class', 'aheto-features-tabs--pointe');
$this->add_render_attribute('wrapper', 'class', 'js-tab');
$this->add_render_attribute('wrapper', 'class', $this->the_custom_classes());

/**
 * Set dependent style
 */
$sc_dir = aheto()->plugin_url() . 'shortcodes/features-tabs/';
$custom_css    = Helper::get_settings( 'general.custom_css_including' );
$custom_css    = ( isset( $custom_css ) && ! empty( $custom_css ) ) ? $custom_css : false;
if ( (empty( $custom_css ) || ( $custom_css == "disabled" ) ) && !Helper::is_Elementor_Live()) {
	wp_enqueue_style('aheto-features-tabs-layout1', $sc_dir . 'assets/css/pointe_layout1.css', null, null);
}
?>

<div <?php $this->render_attribute_string('wrapper'); ?>>


	<div class="aheto-features-tabs__head">
		<ul class="aheto-features-tabs__list ">

			<?php foreach ($tabs as $index => $item) :

				$heading_tag = isset($item['heading_tag']) && !empty($item['heading_tag']) ? $item['heading_tag'] : 'h1';
				$active = $index > 0 ? '' : 'active'; ?>

				<li class="aheto-features-tabs__list-item <?php echo esc_attr($active); ?>">

					<a href="#" class="aheto-features-tabs__list-link js-tab-list">



						<?php if ($item['main_heading']) :

							echo esc_html($item['main_heading']);

						endif; ?>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>
	</div>


	<div class="aheto-features-tabs__content">
		<?php foreach ($tabs as $index => $item) :

			$title_tag = isset($item['title_tag']) && !empty($item['title_tag']) ? $item['title_tag'] : 'h1';
			$active = $index > 0 ? '' : 'active';
			$reverse = isset($item['reverse']) && !empty($item['reverse']) ? 'reverse' : ''; ?>

			<div class="aheto-features-tabs__box js-tab-box <?php echo esc_attr($active); ?>">
				<div class="aheto-features-tabs__box-inner <?php echo esc_attr($reverse); ?>">

					<div class="aheto-features-tabs__box-content">

						<div class="aheto-features-tabs--wrapper">
							<div class="aheto-features-tabs--wrapper--inner">
								<?php if (!empty($item['title_adress'])) :

									echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . esc_html($item['title_adress']) . '</' . $title_tag . '>';

								endif; ?>
								<?php if (!empty($item['pointe_address']) && isset($item['pointe_address'])) : ?>
									<div class="aheto-features-tabs__box-dec">
										<p class="aheto-contact__adress"><?php echo wp_kses_post($item['pointe_address']); ?></p>
									</div>
								<?php endif; ?>
							</div>
							<div class="aheto-features-tabs--wrapper--inner">
								<?php if (!empty($item['title_tel'])) :

									echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . esc_html($item['title_tel']) . '</' . $title_tag . '>';

								endif; ?>
								<?php if ((!empty($item['pointe_tel']) && isset($item['pointe_tel'])) || (!empty($item['pointe_tel_2']) && isset($item['pointe_tel_2']))) : ?>
									<div class="aheto-features-tabs__box-dec">
										<a class="aheto-features-tabs__box-tel" href="tel:<?php echo esc_attr(str_replace(" ", "", $item['pointe_tel'])); ?>"><?php echo esc_html($item['pointe_tel']); ?></a>
										<a class="aheto-features-tabs__box-tel" href="tel:<?php echo esc_attr(str_replace(" ", "", $item['pointe_tel_2'])); ?>"><?php echo esc_html($item['pointe_tel_2']); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>


						<div class="aheto-features-tabs--wrapper">
							<div class="aheto-features-tabs--wrapper--inner">
								<?php if (!empty($item['title_email'])) :

									echo '<' . $title_tag . ' class="aheto-features-tabs__box-title">' . esc_html($item['title_email']) . '</' . $title_tag . '>';

								endif; ?>
								<?php if ((!empty($item['pointe_email']) && isset($item['pointe_email'])) || (!empty($item['pointe_email_2']) && isset($item['pointe_email_2']))) :
								?>
									<div class="aheto-features-tabs__box-dec">
										<a class="aheto-features-tabs__box-mail" href="mailto:<?php echo esc_attr($item['pointe_email']); ?>"><?php echo esc_html($item['pointe_email']); ?></a>
										<a class="aheto-features-tabs__box-mail" href="mailto:<?php echo esc_attr($item['pointe_email_2']); ?>"><?php echo esc_html($item['pointe_email_2']); ?></a>
									</div>
								<?php endif; ?>
							</div>
							<div class="aheto-features-tabs--wrapper--inner socials">
								<?php
								// Social Networks
								$item['font_icon'] = isset($item['font_icon']) && !empty($item['font_icon']) ? $item['font_icon'] : 'elegant';
								$font_icon         = $item['font_icon'] == 'elegant' ? 'ion-social-' : 'el social_';

								echo Helper::get_social_networks_list('<a class="aheto-features-tabs--social--link icon" href="%1$s"><i class="' . $font_icon . '%2$s"></i></a>', 'pointe_tabs_', $item);

								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
