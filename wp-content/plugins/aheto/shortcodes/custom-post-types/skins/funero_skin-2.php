<?php

use Aheto\Helper;

/**
 * Skin 3.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */
extract($atts);

$ID = get_the_ID();

if ( !class_exists( 'Give' ) ) :
	return '';
endif;

$form_id     = get_the_ID(); // Form ID.
$form        = new Give_Donate_Form($form_id);
$goal_option = give_get_meta($form->ID, '_give_goal_option', true);

// Sanity check - ensure form has pass all condition to show goal.
if ( (isset($args['show_goal']) && !filter_var($args['show_goal'], FILTER_VALIDATE_BOOLEAN))
	|| empty($form->ID)
	|| (is_singular('give_forms') && !give_is_setting_enabled($goal_option))
	|| !give_is_setting_enabled($goal_option) || 0 === $form->goal
) {
	return false;
}

$goal_format         = give_get_form_goal_format($form_id);
$price               = give_get_meta($form_id, '_give_set_price', true);
$color               = give_get_meta($form_id, '_give_goal_color', true);
$show_text           = isset($args['show_text']) ? filter_var($args['show_text'], FILTER_VALIDATE_BOOLEAN) : true;
$show_bar            = isset($args['show_bar']) ? filter_var($args['show_bar'], FILTER_VALIDATE_BOOLEAN) : true;
$goal_progress_stats = give_goal_progress_stats($form);

$income = $goal_progress_stats['raw_actual'];
$goal   = $goal_progress_stats['raw_goal'];

$classes   = [];
$classes[] = 'aheto-cpt-article aheto-cpt-article__funero-2';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'grid' ? 'js-bg' : '';

$terms_list = get_the_terms(get_the_ID(), $atts['terms']);
if ( !$atts['terms'] == 'give_forms_category' ) {
	if ( isset($terms_list) && !empty($terms_list) ) {
		foreach ( $terms_list as $term ) {
			$classes[] = 'filter-' . $term->slug;
		}
	}
}

/**
 * Set dependent style
 */
$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('funero-skin-2', $shortcode_dir . 'assets/css/funero_skin-2.css', null, null);
}
$format = $this->get_post_format();

?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">
		<?php
		$isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true, true, $atts, 'cpt_');
		?>
		<div class="aheto-cpt-article__content">
			<?php
			$terms_class = !$isHasThumb ? 'aheto-cpt-article__terms--static' : '';
			$this->getTerms($atts['terms'], $terms_class);
			if (
			give_is_setting_enabled(get_post_meta($form_id, '_give_goal_option', true))
			) {
				echo '<div class="give-card__progress">';
				give_show_goal_progress($form_id);
				echo '</div>';
			}
			$this->getTitle();
			?>
			<?php if ( !empty($atts['funero_link_text']) ) { ?>
				<div class="aheto-cpt-article__link">
					<a href="<?php the_permalink(); ?>" class="aheto-btn aheto-btn--primary">
						<?php echo esc_html($atts['funero_link_text']); ?>
					</a>
				</div>
			<?php } ?>
		</div>

	</div>

</article>
