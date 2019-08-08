<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/includes
 */

namespace DNH;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/includes
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class DnhPhonesupportI18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function loadPluginTextdomain()
    {
        load_plugin_textdomain(
            'dnh-phonesupport',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
