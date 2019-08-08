<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/public
 */

namespace DNH;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/public
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class Dnh_Phonesupport_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $_plugin_name    The ID of this plugin.
     */
    private $_plugin_name;

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
     * @param      string    $_plugin_name       The name of the plugin.
     * @param      string    $_version    The version of this plugin.
     */
    public function __construct($_plugin_name, $_version)
    {
        $this->_plugin_name = $_plugin_name;
        $this->_version = $_version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
            $this->_plugin_name,
            plugin_dir_url(__FILE__) . '../../assets/css/dnh-phonesupport-public.css',
            [],
            $this->_version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
            $this->_plugin_name,
            plugin_dir_url(__FILE__) . '../../assets/js/dnh-phonesupport-public.js',
            [ 'jquery' ],
            $this->_version,
            false
        );
    }
}
