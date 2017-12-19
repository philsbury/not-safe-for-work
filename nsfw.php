<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://philsbury.uk
 * @since             1.0.0
 * @package           Nsfw
 *
 * @wordpress-plugin
 * Plugin Name:       NSFW
 * Description:       Add NSFW checkbox flags to posts and attachments.
 * Version:           0.1.0
 * Author:            Phil Baker
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nsfw
 * Domain Path:       /languages
 * GitHub Plugin URI: philsbury/nsfw
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 0.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NSFW_VERSION', '0.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nsfw-activator.php
 */
function activate_nsfw() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nsfw-activator.php';
	Nsfw_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nsfw-deactivator.php
 */
function deactivate_nsfw() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nsfw-deactivator.php';
	Nsfw_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nsfw' );
register_deactivation_hook( __FILE__, 'deactivate_nsfw' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nsfw.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nsfw() {

	$plugin = new Nsfw();
	$plugin->run();

}
run_nsfw();

if(!function_exists('get_nsfw_ids')){
	function get_nsfw_ids(){
		return Nsfw_Public::getNSFW();
	}
}