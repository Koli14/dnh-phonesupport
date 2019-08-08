<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/admin
 */

namespace DNH;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/admin
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class DnhPhonesupportAdmin
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
         * defined in DnhPhonesupportLoader as all of the hooks are defined
         * in that particular class.
         *
         * The DnhPhonesupportLoader will then create the relationship
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
         * defined in DnhPhonesupportLoader as all of the hooks are defined
         * in that particular class.
         *
         * The DnhPhonesupportLoader will then create the relationship
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
    public function addPhonesupportAdminSetting()
    {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
        add_options_page(
            'Phone support Settings',
            'Phone support',
            'manage_options',
            $this->_pluginName,
            [$this, 'displayPhonesupportSettingsPage']
    );
    }

    /**
     * Render the settings page for this plugin.( The html file )
     *
     * @since    1.0.0
     */

    public function displayPhonesupportSettingsPage()
    {
        include_once('partials/phonesupport-admin-display.php');
    }

    /**
     * Registers and Defines the necessary fields we need.
     *
     */
    public function phonesupportAdminSettingsSave()
    {
        register_setting($this->_pluginName, $this->_pluginName, [$this, 'plugin_options_validate']);

        add_settings_section('phonesupport_main', 'Main Settings', [$this, 'phonesupportSectionText'], 'phonesupport-settings-page');
        add_settings_field('fallback_number', 'Fallback Phone Number', [$this, 'phonesupportSettingFallbackNumber'], 'phonesupport-settings-page', 'phonesupport_main');

        add_settings_section('phonesupport_responses', 'Twilio responses', [$this, 'phonesupportTwilioSectionText'], 'phonesupport-settings-page');
        add_settings_field('response_ok', 'Caller has Active support', [$this, 'phonesupportSettingResponseOk'], 'phonesupport-settings-page', 'phonesupport_responses');
        add_settings_field('response_early', 'Caller calls too early', [$this, 'phonesupportSettingResponseEarly'], 'phonesupport-settings-page', 'phonesupport_responses');
        add_settings_field('response_late', 'Caller calls too late', [$this, 'phonesupportSettingResponseLate'], 'phonesupport-settings-page', 'phonesupport_responses');
        add_settings_field('response_not_registered', 'Phone number not found', [$this, 'phonesupportSettingResponseNotRegistered'], 'phonesupport-settings-page', 'phonesupport_responses');

        add_settings_section('other_settings', 'Other Settings', [$this, 'phonesupportOtherSectionText'], 'phonesupport-settings-page');
        add_settings_field('wc_category', 'Select the Product Tag for wich you want to provide support', [$this, 'phonesupportSettingWcCategory'], 'phonesupport-settings-page', 'other_settings');
    }

    /**
     * Displays the settings sub header
     *
     */
    public function phonesupportSectionText()
    {
        echo '<h3></h3>';
    }

    /**
     * Displays the settings sub header
     *
     */
    public function phonesupportTwilioSectionText()
    {
        echo '<h3></h3>';
    }

    public function phonesupportOtherSectionText()
    {
        echo '<h3></h3>';
    }
    /**
     * Renders the fallback_number input field
     *
     */
    public function phonesupportSettingFallbackNumber()
    {
        $options = get_option($this->_pluginName);
        echo "<input id='plugin_text_string' name='$this->_pluginName[fallback_number]' size='40' type='text' value='{$options['fallback_number']}' />";
    }

    public function phonesupportSettingResponseOk()
    {
        $options = get_option($this->_pluginName);
        echo "<textarea name='$this->_pluginName[response_ok]' id='plugin_text_string' cols='60' rows='4' wrap='soft'>{$options['response_ok']}</textarea>";
    }

    public function phonesupportSettingResponseEarly()
    {
        $options = get_option($this->_pluginName);
        echo "<textarea name='$this->_pluginName[response_early]' id='plugin_text_string' cols='60' rows='4' wrap='soft'>{$options['response_early']}</textarea>";
    }

    public function phonesupportSettingResponseLate()
    {
        $options = get_option($this->_pluginName);
        echo "<textarea name='$this->_pluginName[response_late]' id='plugin_text_string' cols='60' rows='4' wrap='soft'>{$options['response_late']}</textarea>";
    }

    public function phonesupportSettingResponseNotRegistered()
    {
        $options = get_option($this->_pluginName);
        echo "<textarea name='$this->_pluginName[response_not_registered]' id='plugin_text_string' cols='60' rows='4' wrap='soft'>{$options['response_not_registered']}</textarea>";
    }

    public function phonesupportSettingWcCategory()
    {
        $options = get_option($this->_pluginName);
        $categories = get_terms('product_tag', 'orderby=name&hide_empty=0');
        $category_options = [];
        if ($categories) {
            foreach ($categories as $cat) {
                $category_options[ $cat->term_id ] = $cat->name;
            }
        }
        echo "<select id='plugin_text_string' name='$this->_pluginName[wc_category]'>";
        foreach ($category_options as $id => $option) {
            if ($id == $options['wc_category']) {
                echo "<option value={$id} selected='selected'>{$option}</option>";
            }
            echo "<option value={$id}>{$option}</option>";
        }
    }





    /**
     * Sanitises all input fields.
     *
     */
    public function plugin_options_validate($input)
    {
        $newinput['fallback_number'] = trim($input['fallback_number']);
        $newinput['response_ok'] = trim($input['response_ok']);
        $newinput['response_early'] = trim($input['response_early']);
        $newinput['response_late'] = trim($input['response_late']);
        $newinput['response_not_registered'] = trim($input['response_not_registered']);
        $newinput['wc_category'] = trim($input['wc_category']);

        return $newinput;
    }
}
