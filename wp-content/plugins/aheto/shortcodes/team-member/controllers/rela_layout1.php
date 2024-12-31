<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'rela_team_member_layout1');


/**
 * Team Member
 */
function rela_team_member_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/team-member/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Team member 13', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['name', 'designation'], ['rela_layout1'], $shortcode);

}