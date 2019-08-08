<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/admin
 */

namespace DNH;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/admin
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class Dnh_Phonesupport_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $_pluginName    The ID of this plugin.
     */
    private $_pluginName;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $_version    The current version of this plugin.
     */
    private $_version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $_pluginName       The name of this plugin.
     * @param      string    $_version    The version of this plugin.
     */
    public function __construct($_pluginName, $_version)
    {
        $this->_pluginName = $_pluginName;
        $this->_version = $_version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueStyles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Dnh_Phonesupport_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Dnh_Phonesupport_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style(
            $this->_pluginName,
            plugin_dir_url(__FILE__) . '../../assets/css/dnh-phonesupport-admin.css',
            [],
            $this->_version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Dnh_Phonesupport_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Dnh_Phonesupport_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script(
            $this->_pluginName,
            plugin_dir_url(__FILE__) . '../../assets/js/dnh-phonesupport-admin.js',
            [ 'jquery' ],
            $this->_version,
            false
        );
    }
}
