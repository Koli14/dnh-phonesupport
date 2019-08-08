<?php

namespace DNH;

/**
 * Fired during plugin activation
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 *
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class Dnh_Phonesupport_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $pluginlog = plugin_dir_path(__FILE__).'debug.log';
        $message = 'ACTIVATED'.PHP_EOL;
        error_log($message, 3, $pluginlog);
    }
}
