<?php # -*- coding: utf-8 -*-
declare(strict_types = 1);

/**
 *
 * @link    https://digitalnomadhungary.com
 * @since   1.0.0
 * @package Dnh_Phonesupport
 *
 * @wordpress-plugin
 * Plugin Name: DNH PhoneSupport
 * Plugin URI:  https://digitalnomadhungary.com
 * Description: Connecting callers with the PhoneSupport
 * Version:     1.0.2
 * Author:      Kolos Karácsony
 * Author URI:  https://digitalnomadhungary.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: dnh-phonesupport
 * Domain Path: src/languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    //die;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('DNH_PHONESUPPORT_VERSION', '1.0.2');

/**
 * The code that runs during plugin activation.
 * This action is documented in src/includes/class-dnh-phonesupport-activator.php
 */
function activateDnhPhonesupport()
{
    DNH\DnhPhonesupportActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/includes/class-dnh-phonesupport-deactivator.php
 */
function deactivateDnhPhonesupport()
{
    DNH\DnhPhonesupportDeactivator::deactivate();
}

\register_activation_hook(__FILE__, 'activateDnhPhonesupport');
\register_deactivation_hook(__FILE__, 'deactivateDnhPhonesupport');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function runDnhPhonesupport()
{
    $plugin = new DNH\DnhPhonesupport();
    $plugin->run();
}
runDnhPhonesupport();
