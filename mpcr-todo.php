<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://malok.dev/
 * @since             1.0.0
 * @package           Mpcr_Todo
 *
 * @wordpress-plugin
 * Plugin Name:       mpcr to-do
 * Plugin URI:        https://malok.dev/
 * Description:       Simple plugin for the recruitment process.
 * Version:           1.0.0
 * Author:            Paweł Malok
 * Author URI:        https://malok.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mpcr-todo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('MPCR_TODO_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mpcr-todo-activator.php
 */
function activate_mpcr_todo()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-mpcr-todo-activator.php';
  Mpcr_Todo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mpcr-todo-deactivator.php
 */
function deactivate_mpcr_todo()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-mpcr-todo-deactivator.php';
  Mpcr_Todo_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_mpcr_todo');
register_deactivation_hook(__FILE__, 'deactivate_mpcr_todo');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-mpcr-todo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mpcr_todo()
{

  $plugin = new Mpcr_Todo();
  $plugin->run();
}
run_mpcr_todo();
