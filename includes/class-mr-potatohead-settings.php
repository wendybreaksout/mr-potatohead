<?php
/**
 * Created by PhpStorm.
 * User: wendyemerson
 * Date: 2020-10-30
 * Time: 12:57
 */

class Mr_Potatohead_Settings {

	private $options_name = MPH_OPTION_NAME;
	private $version = MR_POTATOHEAD_VERSION;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

	}


	/*
	 * Get the plugin option name.
	 *
	 * @return string plugin option name.
	 */
	public function get_options_name() {
		return $this->options_name;
	}

	public function add_option_defaults() {

		if ( current_user_can( 'activate_plugins' ) ) {

			$options = array(
				'version' => $this->version,
				'img_url' => MPH_PLUGIN_URL . 'public/images/potato.png',
				'width'   => 400,
				'height'  => 400,
				'remove_data_on_uninstall' => 'false'
			);


			add_option( $this->options_name, $options );
		}
	}

	/*
	 * This function was intended to be called to delete the
	 * options from the database.
	 *
	 * @todo Can this delete_options() be removed.
	 * @since 1.0.0
	 */

	public function delete_options() {
		if ( current_user_can('delete_plugins') ) {
			delete_option($this->options_name );
		}
	}

	public function get_version() {
		$option = get_option( $this->options_name);
		return $option['version'];
	}

	public function get_width() {
		$option = get_option( $this->options_name);
		return $option['width'];
	}

	public function get_height() {
		$option = get_option( $this->options_name);
		return $option['height'];
	}

	public function get_img_url() {
		$option = get_option( $this->options_name);
		return $option['img_url'];
	}

	public function settings_init(  ) {

		register_setting( 'mph-settings-group', $this->options_name, array( $this, 'sanitize') );

		add_settings_section(
			'mph-settings-general-section',
			__( 'Mr Potatohead General Settings', MPH_TEXT_DOMAIN ),
			array($this, 'mph_settings_general_info'),
			'mph-settings-page'
		);

		add_settings_field(
			'remove_data_on_uninstall',
			__( 'Remove plugin posts, settings, and other data on deactivation.', MPH_TEXT_DOMAIN ),
			array($this, 'mph_remove_data_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);



		// settings field google maps api key
		add_settings_field(
			'width',
			__( 'Mr P Width', MPH_TEXT_DOMAIN ),
			array($this, 'width_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);

		// settings field google maps api key
		add_settings_field(
			'height',
			__( 'Mr P Height', MPH_TEXT_DOMAIN ),
			array($this, 'height_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);


		// settings field google maps api key
		add_settings_field(
			'img_url',
			__( 'Mr P Body Image URL', MPH_TEXT_DOMAIN ),
			array($this, 'img_url_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);





	}

	public function settings_page(  ) {

		$this->add_option_defaults();

		?>
        <div class="wrap">
            <form action='options.php' method='post'>

                <h2>Mr Potatohead Settings</h2>
                <div id="mph-settings-container">
					<?php
					settings_fields( 'mph-settings-group' );
					do_settings_sections( 'mph-settings-page' );
					submit_button();
					?>
                </div>

            </form>
        </div>
		<?php

	}


	public function get_remove_data_on_uninstall() {
		$option = get_option( $this->options_name);
		return $option['remove_data_on_uninstall'];
	}


	public function add_mph_options_page( ) {

		// Add the top-level admin menu
		$page_title = 'Mr Potatohead Plugin Setings';
		$menu_title = 'Mr P';
		$capability = 'manage_options';
		$menu_slug = 'mph-settings';
		$function = 'settings_page';
		add_options_page($page_title, $menu_title, $capability, $menu_slug, array($this, $function)) ;

	}
	
	public function sanitize( $input ) {

		$new_input = array();

		if( isset( $input['remove_data_on_uninstall'] ) ) {
			$new_input['remove_data_on_uninstall'] = sanitize_text_field( $input['remove_data_on_uninstall'] );
		}
		else {
			// set to default
			$new_input['remove_data_on_uninstall'] = false ;
		}


		if( isset( $input['width'] ) )
			$new_input['width'] = intval( $input['width'] );

		if( isset( $input['height'] ) )
			$new_input['height'] = intval( $input['height'] );


		if( isset( $input['img_url'] ) )
			$new_input['img_url'] = sanitize_text_field( $input['img_url'] );


		return $new_input ;

		
	}

	public function mph_settings_general_info () {
		echo '<p>' . __("General settings for Mr Potatohead Plugin", MPH_TEXT_DOMAIN) . '</p>';

	}

	public function width_render() {
		$options = get_option( $this->options_name );
		?>
		<input type="text" size="4" name="mr_potatohead[width]"
		       value="<?php echo $options['width']; ?>">
		<?php
	}


	public function height_render() {
		$options = get_option( $this->options_name );
		?>
		<input type="text" size="4" name="mr_potatohead[height]"
		       value="<?php echo $options['height']; ?>">
		<?php
	}


	public function img_url_render() {
		$options = get_option( $this->options_name );
		?>
		<input type="text" size="100" name="mr_potatohead[img_url]"
		       value="<?php echo $options['img_url']; ?>">
		<?php

	}

	public function mph_remove_data_render() {
		$options = get_option( $this->options_name );
		?>
		<input id="remove_mph_data_input" type="checkbox" name="mr_potatohead[remove_data_on_uninstall]" <?php checked( $options['remove_data_on_uninstall'], 1 ); ?> value='1'>
		<br><label for="remove_mph_data_input"><em>Leave this unchecked unless you really want to remove the data you have stored using this plugin.</em></label>
		<?php
	}


}