<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://digitalnomadhungary.com
 * @since      1.0.0
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/public
 */

namespace DNH;

use Twilio\Twiml;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    DnhPhonesupport
 * @subpackage DnhPhonesupport/public
 * @author     Kolos Karácsony <karacsony.kolos@gmail.com>
 */
class DnhPhonesupportPublic
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
         * defined in DnhPhonesupportLoader as all of the hooks are defined
         * in that particular class.
         *
         * The DnhPhonesupportLoader will then create the relationship
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
         * defined in DnhPhonesupportLoader as all of the hooks are defined
         * in that particular class.
         *
         * The DnhPhonesupportLoader will then create the relationship
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
    /**
     * Register the API routes for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function registerApiRoutes()
    {
        \register_rest_route(
            'callcenter',
            '/incoming/',
            ['methods' =>
                ['POST'],
                'callback' => __CLASS__  . '::respondIncoming',
            ]
        );
    }

    public static function respondIncoming($request)
    {
        header('content-type: text/xml');
        $response = new TwiML;
        $caller = $_REQUEST['Caller'];

        $caller_info = self::getCallerInfo($caller);

        $api_details = get_option('dnh-phonesupport');
        if (is_array($api_details) and count($api_details) != 0) {
            $messages['response_ok'] = $api_details['response_ok'];
            $messages['response_early'] = $api_details['response_early'];
            $messages['response_late'] = $api_details['response_late'];
            $messages['response_not_registered'] = $api_details['response_not_registered'];
            $messages = str_replace('{caller_name}', $caller_info['name'], $messages);
        } else {
            $messages['response_ok'] = "Hi {$caller_info['name']}! Thank you for calling the Digital Nomad Hungary phone support, we are redirecting you to one of our Agents.";
            $messages['response_early'] = "Hi {$caller_info['name']}! We are sorry, but you are not entitled to use our Phone Support, the start date of your package is not passed. Please visit the digitalnomadhungary.com website to buy one of our packages for today.";
            $messages['response_late'] = "Hi {$caller_info['name']}! We are sorry, but you are not entitled to use our Phone Support, the final date of your package is already passed. Please visit the digitalnomadhungary.com website to buy one of our packages for today.";
            $messages['response_not_registered'] = "We are sorry, but you are not entitled to use our Phone Support. Please visit the digitalnomadhungary.com website to buy one of our packages first.";
        }

        if ($caller_info['registered']) {
            if ($caller_info['is_active']) {
                $supporter =  self::getSupporter();
                $response->say($messages['response_ok'], ['voice' => 'alice']);
                $response->dial($supporter);
            } else {
                if ($caller_info['too_early']) {
                    $response->say($messages['response_early'], ['voice' => 'alice']);
                } else {
                    $response->say($messages['response_late'], ['voice' => 'alice']);
                }
            }
        } else {
            $response->say($messages['response_not_registered'], ['voice' => 'alice']);
        }

        echo $response;
        die();
    }

    public static function getCallerInfo($caller)
    {
        $wc_category = '30';
        $api_details = get_option('dnh-phonesupport');
        if (is_array($api_details) and count($api_details) != 0) {
            $wc_category = $api_details['wc_category'];
        }
        $caller_info = ['registered' => false, 'is_active' => false, 'too_early' => false, 'too_late' => 'false'];
        $args = ['billing_phone' => $caller,  'status' => ['processing','completed']];
        $orders = wc_get_orders($args); //kifizetett megrendelések, ahol a fizető száma megegyezik a bejövő hívás számával
        $items = [];
        foreach ($orders as $key => $order) {
            //Check for packages with phone-support
            $items = $order->get_items(); //a megrendelés elemei (pl 5 nap Basic package + főző workshop)
            foreach ($items as $key => $item) {
                $product = $item->get_product(); // az elemekhez tartozó termékek
                if (in_array($wc_category, $product->get_tag_ids())) {  //ha a termékhez jár telefonsupport (30:Phone Support WC-Tag ID-ja)
                    $caller_info['registered'] = true;
                    $order_data = $order->get_data();
                    $caller_info['name'] = $order_data['billing']['first_name'];
                    $dateNow = date('Y-m-d'); //date now
                    $dateNow=date('Y-m-d', strtotime($dateNow));
                    $supportBegin= wc_get_order_item_meta($item->get_id(), '_ebs_start_format');
                    $supportBegin = date('Y-m-d', strtotime($supportBegin));
                    $supportEnd= wc_get_order_item_meta($item->get_id(), '_ebs_end_format');
                    $supportEnd = date('Y-m-d', strtotime($supportEnd));
                    if (($dateNow >= $supportBegin) && ($dateNow <= $supportEnd)) {
                        $caller_info['is_active'] = true;
                    } else {
                        if ($dateNow > $supportEnd) {
                            $caller_info['too_late'] = true;
                        } else {
                            $caller_info['too_early'] = true;
                        }
                    }
                }
            }
        }

        return $caller_info;
    }

    public static function getSupporter()
    {
        $fallback_number = '+36304768347';
        $api_details = get_option('dnh-phonesupport');
        if (is_array($api_details) and count($api_details) != 0) {
            $fallback_number = $api_details['fallback_number'];
        }
        $client = new Google_Client();
        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='.plugin_dir_path(__FILE__) . 'DH_Phone_Support-7f197c8c78b6.json'
        );
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName("DNH_Phone_support");
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAccessType('offline');

        $service = new Google_Service_Calendar($client);
        //var_dump($service->calendarList);
        $calendarId = 'digitalnomadhungary.com_g24ojjbpltr888k30f9b198mno@group.calendar.google.com';
        $optParams = [
            'maxResults' => 250,
            //  'orderBy' => 'startTime',
            'timeMax' => date('c', strtotime("+1 minutes")),
            'timeMin' => date('c'),
        ];

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        if (empty($events)) {
            return $fallback_number;
        } else {
            foreach ($events as $event) {
                if ($event->getDescription() != '') {
                    return $event->getDescription();
                }
            }
        }
        return $fallback_number;
    }


    public function customValidateBillingPhone($fields, $errors)
    {
        $is_correct = preg_match('/[\+]([0-9]{6,20})$/', $fields['billing_phone']);
        if ($fields['billing_phone'] && !$is_correct) {
            $errors->add('validation', __('The Phone field should start with a <strong>+</strong> and <strong>be between 6 and 20 digits</strong>.'));
        }
    }


    // // Custom validation for Billing Phone checkout field -TODO: WORKING ONLY AFTER TRYING TO PAY!!
    // public function customValidateBillingPhone() {
    //    $is_correct = preg_match('/[\+]([0-9]{6,20})$/', $_POST['billing_phone']);
    //    if ( $_POST['billing_phone'] && !$is_correct) {
    //        wc_add_notice( __( 'The Phone field should start with a <strong>+</strong> and <strong>be between 6 and 20 digits</strong>.' ), 'error' );
    //    }
    // }

    public function customOverrideCheckoutFields($fields)
    {
        $fields['billing']['billing_phone']['label'] = 'Phone (please use the following format: +12112111111)';
        $fields['billing']['billing_phone']['required'] = true;
        //unset($fields['billing']['billing_phone']['validate']);
        foreach (WC()->cart->get_cart() as $cart_item) {
            if (in_array('30', $cart_item['data']->get_tag_ids())) {  //ha a termékhez jár telefonsupport (30:Phone Support WC-Tag ID-ja)
                $fields['billing']['billing_phone']['label'] = 'Phone (Please use the following format: +12112111111. You can use our Phone Support just from this phonenumber.)';
            }
        }
        return $fields;
    }


    public function myWoocommerceAddError($error)
    {
        $myerror = str_replace('Billing Phone (please use the following format: +12112111111)', 'Phone', $error);

        $myerror = str_replace('Billing Phone (Please use the following format: +12112111111. You can use our Phone Support just from this phonenumber.)', 'Phone', $myerror);
        return $myerror;
    }
}
