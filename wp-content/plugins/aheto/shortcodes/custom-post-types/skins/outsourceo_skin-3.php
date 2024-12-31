<?php
use Aheto\Helper;

/**
 * Skin 1.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     Upqode <info@upqode.com>
 */

$ID = get_the_ID();

$classes = [];
$classes[] = 'aheto-cpt-article';
$classes[] = 'aheto-cpt-article--' . $atts['layout'];
$classes[] = $this->getAdditionalItemClasses($atts['layout'], false);
$classes[] = 'aheto-cpt-article--' . $atts['skin'];
$img_class = $atts['layout'] === 'slider' || $atts['layout'] === 'grid' ? 'js-bg' : '';


/**
 * Set dependent style
 */

$shortcode_dir = aheto()->plugin_url() . 'shortcodes/custom-post-types/';
if (!Helper::is_Elementor_Live()) {
	wp_enqueue_style('outsourceo-skin-3', $shortcode_dir . 'assets/css/outsourceo_skin-3.css', null, null);
}

$format = $this->get_post_format();
$tag = isset($atts['title_tag']) && !empty($atts['title_tag']) ? $atts['title_tag'] : 'h4';

$outsourceo_terms_bg = isset($atts['outsourceo_terms_bg']) && $atts['outsourceo_terms_bg'] ? 'disable-bg-terms' : ''; ?>

<article class="<?php echo esc_attr(implode(' ', $classes)); ?>">

	<div class="aheto-cpt-article__inner">

		<?php $isHasThumb = $this->getImage($img_class, '', $atts['cpt_image_size'], true); ?>

		<div class="aheto-cpt-article__content <?php echo esc_attr($outsourceo_terms_bg); ?>">
			<?php $this->getTerms($atts['terms'], '', ', '); ?>

			<?php echo '<' . $tag . ' class="aheto-cpt-article__title">'; ?>
			<a href="<?php the_permalink(); ?>">
				<?php

				$title = get_the_title();

				if ($atts['outsourceo_use_dot']) {

					$title = str_replace('{{.}}', '<span class="outsourceo-dot dot-primary"></span>', $title);

					$words = explode(" ", $title);

					if (count($words) > 0) {
						$last_word = $words[count($words) - 1];

						$last_space_position = strrpos($title, ' ');
						$start_string = substr($title, 0, $last_space_position);

						$title = wp_kses($start_string, 'post') . ' <span class="outsourceo-dot dot-primary">' . wp_kses($last_word, 'post') . '</span>';
					} else {
						$title = '<span class="outsourceo-dot dot-primary">' . wp_kses($title, 'post') . '</span>';
					}

				} else {
					$title = wp_kses($title, 'post');
				}

				echo $title; ?>
			</a>
			<?php echo '</' . $tag . '>';
			$this->getExcerpt();
			?>
			<div class="aheto-cpt-article__footer">
				<div class="aheto-cpt-article__author">
					<?php
					$author_id = get_the_author_meta('ID');

					echo get_avatar($author_id, 30); ?>
					<strong><?php echo esc_html__('by ', 'outsourceo') . esc_html(get_the_author()); ?></strong>
					<span class="aheto-cpt-article__date">
                        <?php the_time(get_option('date_format')); ?>
                    </span>
				</div>
			</div>


		</div>

	</div>

</article>

