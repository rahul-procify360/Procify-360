<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'sterling_custom_post_types_skins');

/**
 * Custom Post Type
 */

function sterling_custom_post_types_skins($shortcode)

{

  // CUSTOM SKIN

	$aheto_skins      = $shortcode->params['skin']['options'];
	$sterling_skins = array(
		'sterling_skin-1' => esc_html__('Sterling donation skin 1', 'sterling'),
		'sterling_skin-2' => esc_html__('Sterling news skin 2', 'sterling'),
		'sterling_skin-3' => esc_html__('Sterling news skin 3', 'sterling'),
		'sterling_skin-4' => esc_html__('Sterling footer skin 4', 'sterling'),
		'sterling_skin-5' => esc_html__('Sterling CS skin 5', 'sterling'),
		'sterling_skin-6' => esc_html__('Sterling donation skin 6', 'sterling'),
	);

  $all_skins                            = array_merge($aheto_skins, $sterling_skins);
  $shortcode->params['skin']['options'] = $all_skins;

  $shortcode->add_dependecy('sterling_icon_size', 'skin', ['sterling_skin-1', 'sterling_skin-6']);

  $shortcode->add_dependecy('sterling_use_income_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_income_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_income_typo', 'sterling_use_income_typo', 'true');

  $shortcode->add_dependecy('sterling_use_goal_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_goal_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_goal_typo', 'sterling_use_goal_typo', 'true');

  $shortcode->add_dependecy('sterling_use_day_typo', 'skin', ['sterling_skin-2']);
  $shortcode->add_dependecy('sterling_day_typo', 'skin', ['sterling_skin-2']);
  $shortcode->add_dependecy('sterling_day_typo', 'sterling_use_day_typo', 'true');

  $shortcode->add_dependecy('sterling_use_month_typo', 'skin', ['sterling_skin-2']);
  $shortcode->add_dependecy('sterling_month_typo', 'skin', ['sterling_skin-2']);
  $shortcode->add_dependecy('sterling_month_typo', 'sterling_use_month_typo', 'true');
  
  $shortcode->add_dependecy('sterling_use_terms_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_terms_typo', 'skin', ['sterling_skin-1', 'sterling_skin-6']);
  $shortcode->add_dependecy('sterling_terms_typo', 'sterling_use_terms_typo', 'true');
  
  $shortcode->add_dependecy('sterling_link_text', 'skin', ['sterling_skin-1', 'sterling_skin-2', 'sterling_skin-5', 'sterling_skin-6']);

  $shortcode->add_params([
    'sterling_use_terms_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__( 'Use custom font for terms?', 'sterling' ),
      'grid'    => 2,
    ],
    'sterling_terms_typo' => [
      'type'     => 'typography',
      'group'    => 'Terms Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-cpt-article__terms a',
    ],
    'sterling_icon_size' => [
      'type'    => 'text',
      'heading' => esc_html__('Icon font size on hover', 'sterling'),
      'selectors' => ['{{WRAPPER}} .aheto-cpt-article__img:after' => 'font-size: {{VALUE}}']
    ],
    'sterling_use_income_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Icome number?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_income_typo'        => [
      'type'     => 'typography',
      'group'    => 'Income Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .give-goal-progress .income',
    ],
    'sterling_use_goal_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Goal number?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_goal_typo'        => [
      'type'     => 'typography',
      'group'    => 'Goal Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .give-goal-progress .goal-text',
    ],
    'sterling_use_day_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Day?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_day_typo'        => [
      'type'     => 'typography',
      'group'    => 'Day Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-cpt-article__date span',
    ],
    'sterling_use_month_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Month?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_month_typo'        => [
      'type'     => 'typography',
      'group'    => 'Month Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-cpt-article__date p',
    ],
    'sterling_link_text' => [
      'type'    => 'text',
      'heading' => esc_html__('Text for button', 'sterling'),
      'default' => 'DONATE NOW',
    ],
  ]);
}