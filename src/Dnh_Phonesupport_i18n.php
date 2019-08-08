<?php

namespace DNH;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class Dnh_Phonesupport_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'dnh-phonesupport',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
