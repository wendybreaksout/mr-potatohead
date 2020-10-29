<?php
/**
 * Created by PhpStorm.
 * User: wendyemerson
 * Date: 2020-10-29
 * Time: 12:21
 */

class Mr_Potatohead_Shortcodes {

	private $settings;

	private $shortcodes = array(
			'mr_potatohead',
	);


	/*
	 * Constructor
	 */

	public function __construct() {
		// $this->settings = new CrowdMap_Settings();
	}


	public function register_shortcodes() {

		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, $shortcode ) );
		}

	}

	public function mr_potatohead ( $atts ) {

		/** @var $img string */

		$atts_actual = shortcode_atts(
			array(
				'img'  =>  MPH_PLUGIN_URL . '/public/images/potato.png',
				'width' => 400,
				'height' => 400
			),
			$atts );

		extract( $atts_actual );

		$output = '<img src="' . $img . '">';
		return $output;

	}


}