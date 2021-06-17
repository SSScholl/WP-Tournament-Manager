<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Author Uri
 * @since             1.0.0
 * @package           Tourney_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Tournament Manager
 * Plugin URI:        Plugin Uri
 * Description:       Tournament Manager Plugin
 * Version:           1.0.0
 * Author:            Michael Scholl
 * Author URI:        Author Uri
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tourney-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TOURNEY_MANAGER_VERSION', '1.0.0' );

/**
 * Store plugin base dir, for easier access later from other classes.
 * (eg. Include, pubic or admin)
 */
define( 'TOURNEY_MANAGER_BASE_DIR', plugin_dir_path( __FILE__ ) );

/********************************************
* RUN CODE ON PLUGIN UPGRADE AND ADMIN NOTICE
*
* @tutorial run_code_on_plugin_upgrade_and_admin_notice.php
*/
define( 'TOURNEY_MANAGER_BASE_NAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tourney-manager-activator.php
 */
function activate_tourney_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tourney-manager-activator.php';
	Tourney_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tourney-manager-deactivator.php
 */
function deactivate_tourney_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tourney-manager-deactivator.php';
	Tourney_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tourney_manager' );
register_deactivation_hook( __FILE__, 'deactivate_tourney_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tourney-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tourney_manager() {

	$plugin = new Tourney_Manager();
	$plugin->run();

}
run_tourney_manager();
