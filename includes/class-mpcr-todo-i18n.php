<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://malok.dev/
 * @since      1.0.0
 *
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mpcr_Todo
 * @subpackage Mpcr_Todo/includes
 * @author     Paweł Malok <pawelmalok@gmail.com>
 */
class Mpcr_Todo_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mpcr-todo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
