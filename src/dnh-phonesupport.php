<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://digitalnomadhungary.com
 * @since             1.0.0
 * @package           Dnh_Phonesupport
 *
 * @wordpress-plugin
 * Plugin Name:        DNH PhoneSupport
 * Plugin URI:        https://digitalnomadhungary.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Kolos Karácsony
 * Author URI:        https://digitalnomadhungary.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dnh-phonesupport
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
define( 'DNH_PHONESUPPORT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dnh-phonesupport-activator.php
 */
function activate_dnh_phonesupport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dnh-phonesupport-activator.php';
	Dnh_Phonesupport_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dnh-phonesupport-deactivator.php
 */
function deactivate_dnh_phonesupport() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dnh-phonesupport-deactivator.php';
	Dnh_Phonesupport_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dnh_phonesupport' );
register_deactivation_hook( __FILE__, 'deactivate_dnh_phonesupport' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dnh-phonesupport.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dnh_phonesupport() {

	$plugin = new Dnh_Phonesupport();
	$plugin->run();

}
run_dnh_phonesupport();
