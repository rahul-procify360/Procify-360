<?php
/**
 * The Twitter Shortcode.
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto\Shortcodes
 * @author     UPQODE <info@upqode.com>
 */

namespace Aheto\Shortcodes;

use Aheto\Shortcode;
use TwitterAPIExchange;

defined( 'ABSPATH' ) || exit;

/**
 * Twitter class.
 */
class Twitter extends Shortcode {

	/**
	 * Setup
	 */
	public function setup() {
		$this->slug  = 'twitter';
		$this->title = esc_html__( 'Twitter', 'aheto' );
		$this->icon  = 'fa fa-twitter';
		$this->description = esc_html__( 'Add Twitter posts', 'aheto' );
		$this->default_layout = 'view';

		$dir = '//assets.aheto.co/twitter/previews/';
		$this->add_layout( 'layout1', [
			'title' => esc_html__( 'Classic', 'aheto' ),
			'image' => $dir . 'layout1.jpg',
		]);

		$this->add_dependecy('twitter_user', 'template', ['view', 'layout1']);
		$this->add_dependecy('number', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_typo_user', 'template', ['view', 'layout1']);
		$this->add_dependecy('use_typo_descr', 'template', ['view', 'layout1']);

		$this->add_dependecy('typo_user', 'template', ['view', 'layout1']);
		$this->add_dependecy('typo_user', 'use_typo_user', 'true');

		$this->add_dependecy('typo_descr', 'template', ['view', 'layout1']);
		$this->add_dependecy('typo_descr', 'use_typo_descr', 'true');


		$this->register();
	}


	/**
	 * Set shortcode params
	 */
	public function set_params() {
		$this->params = [
			'twitter_user'     => [
				'type'    => 'text',
				'heading' => esc_html__( 'Twitter username', 'aheto' ),
			],
			'number'      => [
				'type'    => 'text',
				'heading' => esc_html__('Count of twitts', 'aheto'),
			],
			'light_style'     => [
				'type'    => 'switch',
				'heading' => esc_html__('Enable light style?', 'aheto'),
				'grid'    => 3,
			],

			'use_typo_user' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for username?', 'aheto'),
				'grid'    => 3,
			],
			'typo_user'     => [
				'type'     => 'typography',
				'group'    => 'Username Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-twitter--slug',
			],

			'use_typo_descr' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for twitter text?', 'aheto'),
				'grid'    => 3,
			],
			'typo_descr'     => [
				'type'     => 'typography',
				'group'    => 'Twitter text Typography',
				'settings' => [
					'tag' => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-twitter--description',
			],

			'advanced' => true,
		];
	}

	/*
	 * Get Twitts
	 * @return array
	 */

	public function aheto_get_twitts( $user, $followers = false, $count_twitts = 3 ) {

		$settings = array(
			'oauth_access_token' => '701500526060560384-77sHD0m3MkfV6rIXHOUji6g3nsHHVyV',
			'oauth_access_token_secret' => 'uIrQEnal1ZzJxdLgbTOyhhz8ssHqAAZDHcJGqY22n9L07',
			'consumer_key' => 'Ci7s7QCVRWJzwG8tZlAgoeUSu',
			'consumer_secret' => 'ov3ikpwwoihQCK1Ib0Q29SpqYyp8OxnvA4dXdysxwtwFWgET6h'
		);

		if ($followers) {
			$url = 'https://api.twitter.com/1.1/users/show.json?';
			$requestMethod = 'GET';
			$getfield = '?user_id='. $user .'&amp;screen_name='. $user .'';
			$twitter = new TwitterAPIExchange($settings);

			$data = $twitter->setGetfield($getfield)
			                ->buildOauth($url, $requestMethod)
			                ->performRequest();

			return $data;
		}
		else {
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$requestMethod = 'GET';
			$getfield = '?screen_name='. $user .'&count='. $count_twitts .'&exclude_replies=true&skip_status=1';
			$twitter = new TwitterAPIExchange($settings);

			$data = $twitter->setGetfield($getfield)
			                ->buildOauth($url, $requestMethod)
			                ->performRequest();

			$twitts = json_decode( $data );
			if( ! empty( $twitts ) && is_array( $twitts ) ) {

				return $twitts;
			}
		}

		return array();
	}




/**
	 * Pre dynamic CSS.
	 *
	 * @param  array $css Array of dynamic CSS.
	 * @return array
	 */
	public function pre_dynamic_css( $css ) {

		if ( !empty($this->atts['use_typo_user']) && !empty($this->atts['typo_user']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-twitter--slug'], $this->parse_typography($this->atts['typo_user']));
		}

		if ( !empty($this->atts['use_typo_descr']) && !empty($this->atts['typo_descr']) ) {
			\aheto_add_props($css['global']['%1$s .aheto-twitter--description'], $this->parse_typography($this->atts['typo_descr']));
		}


		return apply_filters( "aheto_twitter_dynamic_css", $css, $this );
	}

}
