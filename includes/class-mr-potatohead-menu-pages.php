<?php

/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 12/5/15
 * Time: 10:43 PM
 */
class Mr_Potatohead_Menu_Pages {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */


	public function __construct() {

	}

	public function admin_menu_pages(){
		// Add the top-level admin menu
		$page_title = 'Mr Potatohead Plugin Setings';
		$menu_title = 'Mr P';
		$capability = 'manage_options';
		$menu_slug = 'mph-settings';
		$function = 'mph_settings';

		$settings = new Mr_Potatohead_Settings();

		add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($settings, 'settings_page')) ;

		// Add submenu page with same slug as parent to ensure no duplicates
		$sub_menu_title = 'Settings';
		add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array( $settings, 'settings_page'));


		// Now add the submenu page for Help
		$submenu_page_title = 'Mr Potatohead Reports';
		$submenu_title = 'Reports';
		$submenu_slug = 'mph-reports';
		$submenu_function = 'mph_reports';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,$submenu_function));


	}

	public function mph_settings() {
		$settings = new Mr_Potatohead_Settings();
		$settings->settings_init();
	}

	public function mph_reports() {

		echo '<div class="wrap">';
		echo '<h2 class="mph-report-heading">' . __('Mr Potatohead Reports would go here.', MPH_TEXT_DOMAIN ) . '</h2>';
		echo '</div>';

	}


}