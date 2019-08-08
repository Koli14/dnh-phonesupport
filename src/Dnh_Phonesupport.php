<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 */

namespace DNH;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Dnh_Phonesupport
 * @subpackage Dnh_Phonesupport/includes
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */


class Dnh_Phonesupport
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Dnh_Phonesupport_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('DNH_PHONESUPPORT_VERSION')) {
            $this->version = DNH_PHONESUPPORT_VERSION;
        } else {
            $this->version = '1.0.2';
        }
        $this->plugin_name = 'dnh-phonesupport';

        $this->_loadDependencies();
        $this->_setLocale();
        $this->_defineAdminHooks();
        $this->_definePublicHooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Dnh_Phonesupport_Loader. Orchestrates the hooks of the plugin.
     * - Dnh_Phonesupport_i18n. Defines internationalization functionality.
     * - Dnh_Phonesupport_Admin. Defines all hooks for the admin area.
     * - Dnh_Phonesupport_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function _loadDependencies()
    {
        $this->loader = new Dnh_Phonesupport_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Dnh_Phonesupport_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function _setLocale()
    {
        $plugin_i18n = new Dnh_Phonesupport_I18n();

        $this->loader->addAction(
            'plugins_loaded',
            $plugin_i18n,
            'loadPluginTextdomain'
        );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function _defineAdminHooks()
    {
        $plugin_admin = new Dnh_Phonesupport_Admin(
            $this->getPluginName(),
            $this->getVersion()
        );

        $this->loader->addAction(
            'admin_enqueueScripts',
            $plugin_admin,
            'enqueueStyles'
        );
        $this->loader->addAction(
            'admin_enqueueScripts',
            $plugin_admin,
            'enqueueScripts'
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function _definePublicHooks()
    {
        $plugin_public = new Dnh_Phonesupport_Public(
            $this->getPluginName(),
            $this->getVersion()
        );

        $this->loader->addAction(
            'wp_enqueueScripts',
            $plugin_public,
            'enqueueStyles'
        );
        $this->loader->addAction(
            'wp_enqueueScripts',
            $plugin_public,
            'enqueueScripts'
        );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Dnh_Phonesupport_Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}
