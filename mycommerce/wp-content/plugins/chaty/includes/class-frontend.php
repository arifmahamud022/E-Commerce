<?php
/**
 * Class Chaty front end
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

namespace CHT\frontend;

use CHT\admin\CHT_Admin_Base;
use CHT\admin\CHT_Social_Icons;

if (defined('ABSPATH') === false) {
    exit;
}

$adminBase = CHT_ADMIN_INC.'/class-admin-base.php';
require_once $adminBase;

$socialIcons = CHT_ADMIN_INC.'/class-social-icons.php';
require_once $socialIcons;

class CHT_Frontend extends CHT_Admin_Base
{

    /**
     * The widget number of settings
     *
     * @var    string    $widgetNumber    The Slug of this plugin.
     * @since  1.0.0
     * @access public
     */
    public $widgetNumber;


    /**
     * CHT_Frontend constructor.
     */
    public function __construct()
    {
        $this->socials = CHT_Social_Icons::get_instance()->get_icons_list();
        if (wp_doing_ajax()) {
            add_action('wp_ajax_choose_social', [$this, 'choose_social_handler']);
            add_action('wp_ajax_get_chaty_settings', [$this, 'get_chaty_settings']);

            // Return setting for a social media in html.
            add_action('wp_ajax_chaty_front_form_save_data', [$this, 'chaty_front_form_save_data']);
            add_action('wp_ajax_nopriv_chaty_front_form_save_data', [$this, 'chaty_front_form_save_data']);

            add_action('wp_ajax_remove_chaty_widget', [$this, 'remove_chaty_widget']);
            // Remove social media widget.
            add_action('wp_ajax_change_chaty_widget_status', [$this, 'change_chaty_widget_status']);
            // Remove social media widget.
        }

        $inEditors = $this->check_for_editors();
        if (!($inEditors)) {
            add_action('wp_enqueue_scripts', [$this, 'cht_front_end_css_and_js']);
        }

    }//end __construct()


    /**
     * checking for wp editors
     *
     * @since  1.0.0
     * @access public
     * @return $status
     */
    function check_for_editors()
    {
        $isElementor   = isset($_GET['elementor-preview']) ? 1 : 0;
        $isCtBuilder   = isset($_GET['ct_builder']) ? 1 : 0;
        $isDiviTheme   = isset($_GET['et_fb']) ? 1 : 0;
        $isZionBuilder = isset($_GET['zionbuilder-preview']) ? 1 : 0;
        $isSiteOrigin  = isset($_GET['siteorigin_panels_live_editor']) ? 1 : 0;
        $flBuilder     = isset($_GET['fl_builder']) ? 1 : 0;
        return ($isCtBuilder || $isElementor || $isDiviTheme || $isZionBuilder || $isSiteOrigin || $flBuilder) ? 1 : 0;

    }//end check_for_editors()


    /**
     * Remove chaty widget settings
     *
     * @since  1.0.0
     * @access public
     * @return $response
     */
    public function remove_chaty_widget()
    {
        if (current_user_can('manage_options')) {
            $widgetIndex = filter_input(INPUT_POST, 'widget_index');
            $widgetNonce = filter_input(INPUT_POST, 'widget_nonce');
            if (isset($widgetIndex) && !empty($widgetIndex) && !empty($widgetNonce) && wp_verify_nonce($widgetNonce, "chaty_remove_".$widgetIndex)) {
                $options = [
                    'mobile'  => '1',
                    'desktop' => '1',
                ];
                delete_option("cht_active");
                delete_option("chaty_icons_view");
                delete_option("chaty_icons_view");
                delete_option("cht_cta_text_color");
                delete_option("cht_cta_bg_color");
                delete_option("cht_pending_messages");
                delete_option("cht_number_of_messages");
                delete_option("cht_number_color");
                delete_option("cht_number_bg_color");
                delete_option("cht_cta_switcher");
                delete_option("chaty_attention_effect");
                delete_option("chaty_default_state");
                delete_option("chaty_trigger_on_time");
                delete_option("chaty_trigger_time");
                delete_option("chaty_trigger_on_exit");
                delete_option("chaty_trigger_on_scroll");
                delete_option("chaty_trigger_on_page_scroll");
                delete_option("cht_close_button");
                delete_option("cht_close_button_text");
                delete_option("chaty_updated_on");
                delete_option("cht_widget_title");
                delete_option("cht_widget_font");

                foreach ($this->socials as $social) {
                    delete_option('cht_social_'.$social['slug']);
                }

                update_option('cht_devices', $options);
                update_option('cht_position', 'right');
                update_option('cht_cta', 'Contact us');
                update_option('cht_numb_slug', ',Phone,Whatsapp');
                update_option('cht_social_whatsapp', '');
                update_option('cht_social_phone', '');
                update_option('cht_widget_size', '54');
                update_option('widget_icon', 'chat-base');
                update_option('cht_widget_img', '');
                update_option('cht_color', '#A886CD');
                echo esc_url(admin_url("admin.php?page=chaty-app"));
                exit;
            }//end if
        }//end if

    }//end remove_chaty_widget()


    /**
     * Update chaty widget status
     *
     * @since  1.0.0
     * @access public
     * @return $response
     */
    public function change_chaty_widget_status()
    {
        if (current_user_can('manage_options')) {
            $widgetIndex = filter_input(INPUT_POST, 'widget_index');
            $widgetNonce = filter_input(INPUT_POST, 'widget_nonce');
            if (isset($widgetIndex) && !empty($widgetIndex) && !empty($widgetNonce) && wp_verify_nonce($widgetNonce, "chaty_remove_".$widgetIndex)) {
                $widgetIndex = trim($widgetIndex, "_");
                if (empty($widgetIndex) || $widgetIndex == 0) {
                    $widgetIndex = "";
                } else {
                    $widgetIndex = "_".$widgetIndex;
                }

                $status = get_option("cht_active".$widgetIndex);
                if ($status) {
                    update_option("cht_active".$widgetIndex, 0);
                } else {
                    update_option("cht_active".$widgetIndex, 1);
                }
            }
        }

        echo "1";
        exit;

    }//end change_chaty_widget_status()


    /**
     * To save form submitted by visitors
     *
     * @since  1.0.0
     * @access public
     * @return $response
     */
    function chaty_front_form_save_data()
    {
        $response = [
            'status'  => 0,
            'error'   => 0,
            'errors'  => [],
            'message' => '',
        ];
        $postData = filter_input_array(INPUT_POST);
        if (isset($postData['nonce']) && isset($postData['widget']) && wp_verify_nonce($postData['nonce'], "chaty_widget_nonce".$postData['widget'])) {
            $name    = isset($postData['name']) ? $postData['name'] : "";
            $phone   = isset($postData['email']) ? $postData['phone'] : "";
            $email   = isset($postData['phone']) ? $postData['email'] : "";
            $message = isset($postData['message']) ? $postData['message'] : "";
            $refURL  = isset($postData['ref_url']) ? $postData['ref_url'] : "";
            $widget  = $postData['widget'];
            $channel = $postData['channel'];

            $value = get_option('cht_social_'.$channel);
            // get saved settings for button
            $errors = [];
            if (!empty($value)) {
                $fieldSetting = isset($value['name']) ? $value['name'] : [];
                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes" && isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes" && empty($name)) {
                    $error    = [
                        'field'   => 'chaty-field-name',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                $fieldSetting = isset($value['phone']) ? $value['phone'] : [];
                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes" && isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes" && empty($phone)) {
                    $error    = [
                        'field'   => 'chaty-field-phone',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                $fieldSetting = isset($value['email']) ? $value['email'] : [];
                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes" && isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes") {
                    if (empty($email)) {
                        $error    = [
                            'field'   => 'chaty-field-email',
                            'message' => esc_attr("this field is required", 'chaty'),
                        ];
                        $errors[] = $error;
                    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error    = [
                            'field'   => 'chaty-field-email',
                            'message' => esc_attr("email address is not valid", 'chaty'),
                        ];
                        $errors[] = $error;
                    }
                }

                $fieldSetting = isset($value['message']) ? $value['message'] : [];
                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes" && isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes" && empty($message)) {
                    $error    = [
                        'field'   => 'chaty-field-message',
                        'message' => esc_attr("this field is required", 'chaty'),
                    ];
                    $errors[] = $error;
                }

                if (empty($errors)) {
                    $widget = trim($widget, "_");
                    $response['message']          = esc_attr($value['thanks_message']);
                    $response['redirect_action']  = esc_attr($value['redirect_action']);
                    $response['redirect_link']    = esc_url($value['redirect_link']);
                    $response['link_in_new_tab']  = esc_attr($value['link_in_new_tab']);
                    $response['close_form_after'] = esc_attr($value['close_form_after']);
                    $response['close_form_after_seconds'] = esc_attr($value['close_form_after_seconds']);

                    date_default_timezone_set(get_option('timezone_string'));
                    $currentDate = date("Y-m-d H:i:s");

                    global $wpdb;
                    $chatyTable  = $wpdb->prefix.'chaty_contact_form_leads';
                    $insert       = [];
                    $fieldSetting = isset($value['name']) ? $value['name'] : [];
                    if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                        $insert['name'] = esc_sql(sanitize_text_field($name));
                    }

                    $fieldSetting = isset($value['email']) ? $value['email'] : [];
                    if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                        $insert['email'] = esc_sql(sanitize_text_field($email));
                    }

                    $fieldSetting = isset($value['phone']) ? $value['phone'] : [];
                    if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                        $insert['phone_number'] = esc_sql(sanitize_text_field($phone));
                    }

                    $fieldSetting = isset($value['message']) ? $value['message'] : [];
                    if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                        $insert['message'] = esc_sql(sanitize_text_field($message));
                    }

                    $insert['ref_page']   = esc_url(esc_sql(sanitize_text_field($refURL)));
                    $insert['ip_address'] = esc_url($this->get_user_ipaddress());
                    $insert['widget_id']  = esc_sql(sanitize_text_field($widget));
                    $insert['created_on'] = esc_sql($currentDate);
                    $wpdb->insert($chatyTable, $insert);

                    $showFirst = get_option("show_first_chaty_lead_box");
                    if ($showFirst === false) {
                        add_option("show_first_chaty_lead_box", 1);
                    }

                    $response['status'] = 1;
                } else {
                    $response['errors'] = $errors;
                    $response['error']  = 1;
                }//end if
            } else {
                $response['message'] = "Invalid request, Please try again";
            }//end if
        } else {
            $response['message'] = "Invalid request, Please try again";
        }//end if

        echo json_encode($response);
        exit;

    }//end chaty_front_form_save_data()


    /**
     * To load JS/CSS files to visitors
     *
     * @since  1.0.0
     * @access public
     * @return $css
     */
    function cht_front_end_css_and_js()
    {
        if ($this->canInsertWidget()) :
            // Initialize widget if widget is enable for current page
            $social = $this->get_social_icon_list();
            // get active icon list
            $chtActive = get_option("cht_active");

            // $bgColor = $this->get_current_color();
            // get custom background color for widget
            $defColor    = get_option('cht_color');
            $customColor = get_option('cht_custom_color');
            // checking for custom color
            if (!empty($customColor)) {
                $color = $customColor;
            } else {
                $color = $defColor;
            }

            $bgColor = strtoupper($color);

            $len = count($social);
            // get total active channels
            $cta = nl2br(get_option('cht_cta'));
            // $cta = str_replace(array("\r", "\n"), "", $cta);
            $cta = str_replace("&amp;#39;", "'", $cta);
            $cta = str_replace("&#39;", "'", $cta);
            $cta = esc_attr__(wp_unslash($cta));
            $cta = html_entity_decode($cta);

            $isPro = get_option('cht_token');
            // is PRO version
            $isPro = (empty($isPro) || $isPro == null) ? 0 : 1;

            $positionSide = get_option('positionSide');
            // get widget position
            $chtBottomSpacing = get_option('cht_bottom_spacing');
            // get widget position from bottom
            $chtSideSpacing = get_option('cht_side_spacing');
            // get widget position from left/Right
            $chtWidgetSize = get_option('cht_widget_size');
            // get widget size
            $positionSide = empty($positionSide) ? 'right' : $positionSide;
            // Initialize widget position if not exists
            $chtSideSpacing = ($chtSideSpacing) ? $chtSideSpacing : '25';
            // Initialize widget from left/Right if not exists
            $chtWidgetSize = ($chtWidgetSize) ? $chtWidgetSize : '54';
            // Initialize widget size if not exists
            $position = get_option('cht_position');
            $position = ($position) ? $position : 'right';
            // Initialize widget position if not exists
            $total            = ($chtSideSpacing + $chtWidgetSize + $chtSideSpacing);
            $chtBottomSpacing = ($chtBottomSpacing) ? $chtBottomSpacing : '25';
            // Initialize widget bottom position if not exists
            $chtSideSpacing = ($chtSideSpacing) ? $chtSideSpacing : '25';
            // Initialize widget left/Right position if not exists
            $imageId  = "";
            $imageUrl = plugin_dir_url("")."chaty-pro/admin/assets/images/chaty-default.png";
            // Initialize default image
            $analytics = get_option("cht_google_analytics");
            // check for google analytics enable or not
            $analytics = empty($analytics) ? 0 : $analytics;
            // Initialize google analytics flag to 0 if not data not exists
            $text = get_option("cht_close_button_text");
            // close button settings
            $close_text = ($text === false) ? "Hide" : $text;

            $imageUrl = "";
            if ($imageId != "") {
                $imageData = wp_get_attachment_image_src($imageId, "full");
                if (!empty($imageData) && is_array($imageData)) {
                    $imageUrl = $imageData[0];
                    // change close button image if exists
                }
            }

            $fontFamily = get_option('cht_widget_font');
            if ($fontFamily == "System Stack") {
                $fontFamily = "-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen-Sans,Ubuntu,Cantarell,Helvetica Neue,sans-serif";
            }

            // add inline css for custom position
            $animationClass = get_option("chaty_attention_effect");
            $animationClass = empty($animationClass) ? "" : $animationClass;

            $timeTrigger = get_option("chaty_trigger_on_time");
            $timeTrigger = empty($timeTrigger) ? "no" : $timeTrigger;

            $triggerTime = get_option("chaty_trigger_time");
            $triggerTime = (empty($triggerTime) || !is_numeric($triggerTime) || $triggerTime < 0) ? "0" : $triggerTime;

            $exitIntent = get_option("chaty_trigger_on_exit");
            $exitIntent = empty($exitIntent) ? "no" : $exitIntent;

            $onPageScroll = get_option("chaty_trigger_on_scroll");
            $onPageScroll = empty($onPageScroll) ? "no" : $onPageScroll;

            $pageScroll = get_option("chaty_trigger_on_page_scroll");
            $pageScroll = (empty($pageScroll) || !is_numeric($pageScroll) || $pageScroll < 0) ? "0" : $pageScroll;

            $state = get_option("chaty_default_state");
            $state = empty($state) ? "click" : $state;

            $hasCloseButton = get_option("cht_close_button");
            $hasCloseButton = empty($hasCloseButton) ? "yes" : $hasCloseButton;
            $hasCloseButton = ($hasCloseButton == "yes")?1:0;

            $displayDays  = get_option("cht_date_and_time_settings");
            $displayRules = [];

            $gmt = "";
            if (!empty($displayDays)) {
                $count = 0;
                foreach ($displayDays as $key => $value) {
                    if ($count == 0) {
                        $gmt = intval($value['gmt']);
                        $count++;
                    }

                    $record         = [];
                    $record['days'] = ($value['days'] - 1);
                    $record['start_time']  = $value['start_time'];
                    $record['start_hours'] = intval(date("G", strtotime(date("Y-m-d ".$value['start_time']))));
                    $record['start_min']   = intval(date("i", strtotime(date("Y-m-d ".$value['start_time']))));
                    $record['end_time']    = $value['end_time'];
                    $record['end_hours']   = intval(date("G", strtotime(date("Y-m-d ".$value['end_time']))));
                    $record['end_min']     = intval(date("i", strtotime(date("Y-m-d ".$value['end_time']))));
                    $displayRules[]        = $record;
                }
            }

            $displayConditions = 0;
            if (!empty($displayRules)) {
                $displayConditions = 1;
            }

            $mode = get_option("chaty_icons_view");
            $mode = empty($mode) ? "vertical" : $mode;

            $pendingMessages = get_option("cht_pending_messages");
            $pendingMessages = ($pendingMessages === false) ? "off" : $pendingMessages;

            $clickSetting = get_option("cht_cta_action");
            $clickSetting = ($clickSetting === false) ? "click" : $clickSetting;

            $chtNumberOfMessages = get_option("cht_number_of_messages");
            $chtNumberOfMessages = ($chtNumberOfMessages === false) ? 0 : $chtNumberOfMessages;

            $numberColor = get_option("cht_number_color");
            $numberColor = ($numberColor === false) ? "#ffffff" : $numberColor;

            $numberBgColor = get_option("cht_number_bg_color");
            $numberBgColor = ($numberBgColor === false) ? "#dd0000" : $numberBgColor;

            $chtCtaTextColor = get_option("cht_cta_text_color");
            $chtCtaTextColor = ($chtCtaTextColor === false) ? "#dd0000" : $chtCtaTextColor;

            $chtCtaBgColor = get_option("cht_cta_bg_color");
            $chtCtaBgColor = ($chtCtaBgColor === false) ? "#ffffff" : $chtCtaBgColor;

            if (empty($chtNumberOfMessages)) {
                $pendingMessages = "off";
            }

            $bgColor = ($bgColor) ? $bgColor : '#A886CD';

            $hideWidget = "no";
            $hideTime   = 0;

            $data = [];
            $data['ajax_url']  = admin_url("admin-ajax.php");
            $data['analytics'] = 0;

            $state = ($state == "open")?"open":$state;
            if($state == "open") {
                $pending_messages = 0;
                $cta = "";
                $animation_class = "";
            }

            // Widget setting array.
            $setting = [];
            $setting['show_close_button'] = $hasCloseButton;
            $setting['position']          = $position;
            $setting['custom_position']   = 1;
            $setting['bottom_spacing']    = $chtBottomSpacing;
            $setting['side_spacing']      = $chtSideSpacing;
            $setting['icon_view']         = $mode;
            $setting['default_state']     = $state;
            $setting['cta_text']          = html_entity_decode($cta);
            $setting['cta_text_color']    = $chtCtaTextColor;
            $setting['cta_bg_color']      = $chtCtaBgColor;
            $setting['show_cta']          = ($clickSetting == "click") ? "first_click" : "all_time";
            $setting['is_pending_mesg_enabled']    = $pendingMessages;
            $setting['pending_mesg_count']         = $chtNumberOfMessages;
            $setting['pending_mesg_count_color']   = $numberColor;
            $setting['pending_mesg_count_bgcolor'] = $numberBgColor;
            $setting['widget_icon']        = get_option('widget_icon');
            $setting['widget_icon_url']    = '';
            $setting['font_family']        = $fontFamily;
            $setting['widget_size']        = $chtWidgetSize;
            $setting['custom_widget_size'] = $chtWidgetSize;
            $setting['is_google_analytics_enabled'] = $analytics;
            $setting['close_text']       = $close_text;
            $setting['widget_color']     = $bgColor;
            $setting['widget_rgb_color'] = $this->getRGBColor($bgColor);
            $setting['has_custom_css']   = empty($custom_css) ? 0 : 1;
            $setting['custom_css']       = '';
            $setting['widget_token']     = wp_create_nonce("chaty_widget_nonce");
            $setting['widget_index']     = '';
            $setting['attention_effect'] = $animationClass;

            $widgetSetting       = [];
            $widgetSetting['id'] = empty($index) ? 0 : $index;
            $widgetSetting['identifier'] = 0;
            $widgetSetting['settings']   = $setting;

            $trigger = [];
            $trigger['has_time_delay'] = ($timeTrigger == "yes") ? 1 : 0;
            $trigger['time_delay']     = $triggerTime;
            $trigger['exit_intent']    = ($exitIntent == "yes") ? 1 : 0;
            $trigger['has_display_after_page_scroll'] = ($onPageScroll == "yes") ? 1 : 0;
            $trigger['display_after_page_scroll']     = $pageScroll;
            $trigger['auto_hide_widget'] = ($hideWidget == "yes") ? 1 : 0;
            $trigger['hide_after']       = $hideTime;

            $trigger['show_on_pages_rules'] = [];

            $trigger['time_diff'] = 0;
            $trigger['has_date_scheduling_rules'] = 0;
            $trigger['date_scheduling_rules']     = [
                'start_date_time' => '',
                'end_date_time'   => '',

            ];
            $trigger['date_scheduling_rules_timezone'] = 0;

            $trigger['day_hours_scheduling_rules_timezone'] = 0;
            $trigger['has_day_hours_scheduling_rules']      = [];
            $trigger['day_hours_scheduling_rules']          = [];
            $trigger['day_time_diff']        = 0;
            $trigger['show_on_direct_visit'] = 0;
            $trigger['show_on_referrer_social_network'] = 0;
            $trigger['show_on_referrer_search_engines'] = 0;
            $trigger['show_on_referrer_google_ads']     = 0;
            $trigger['show_on_referrer_urls']           = [];
            $trigger['has_show_on_specific_referrer_urls'] = 0;
            $trigger['has_traffic_source'] = 0;
            $trigger['has_countries']      = 0;
            $trigger['countries']          = [];
            $trigger['has_target_rules']   = 0;

            $widgetSetting['triggers'] = $trigger;

            $widgetSetting['channels'] = $social;

            $data['chaty_widgets']   = [];
            $data['chaty_widgets'][] = $widgetSetting;
            $data['data_analytics_settings'] = "off";


            if ($len >= 1 && !empty($data['chaty_widgets'])) {
                $chaty_updated_on = get_option("chaty_updated_on");
                if (empty($chaty_updated_on)) {
                    $chaty_updated_on = time();
                }

                // add js for front end widget
                if (!empty($fontFamily)) {
                    if (!in_array($fontFamily, ["Arial", "Tahoma", "Verdana", "Helvetica", "Times New Roman", "Trebuchet MS", "Georgia", "System Stack", "-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen-Sans,Ubuntu,Cantarell,Helvetica Neue,sans-serif"])) {
                        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family='.urlencode($fontFamily), false, false);
                    }
                }

                // WP change this
                wp_enqueue_style('chaty-front-css', CHT_PLUGIN_URL."css/chaty-front.min.css", [], $chaty_updated_on);
                // wp_add_inline_style('chaty-front-css', $chaty_css);
                wp_enqueue_script("chaty-front-end", CHT_PLUGIN_URL."js/cht-front-script.min.js", [ 'jquery' ], $chaty_updated_on, false);
                wp_localize_script('chaty-front-end', 'chaty_settings',  $data);
            }//end if
        endif;

    }//end cht_front_end_css_and_js()


    /**
     * To get widget settings
     *
     * @since  1.0.0
     * @access public
     * @return $settings
     */
    public function get_chaty_settings()
    {
        $slug    = filter_input(INPUT_POST, 'social');
        $channel = filter_input(INPUT_POST, 'channel');
        $status  = 0;
        $data    = [];
        if (!empty($slug)) {
            foreach ($this->socials as $social) {
                if ($social['slug'] == $slug) {
                    break;
                }
            }

            if (!empty($social)) {
                $status       = 1;
                $data         = $social;
                $data['help'] = "";
                $data['help_text'] = "";
                $data['help_link'] = "";
                if ((isset($social['help']) && !empty($social['help'])) || isset($social['help_link'])) {
                    $data['help_title'] = isset($social['help_title']) ? $social['help_title'] : "Doesn't work?";
                    $data['help_text']  = isset($social['help']) ? $social['help'] : "";
                    if (isset($data['help_link']) && !empty($data['help_link'])) {
                        $data['help_link'] = $data['help_link'];
                    } else {
                        $data['help_title'] = $data['help_title'];
                    }
                }
            }
        }//end if

        $response            = [];
        $response['data']    = $data;
        $response['status']  = $status;
        $response['channel'] = $channel;
        echo json_encode($response);
        die;

    }//end get_chaty_settings()


    /**
     * To get widget channel setting
     *
     * @since  1.0.0
     * @access public
     * @return $settings
     */
    public function choose_social_handler()
    {
        check_ajax_referer('cht_nonce_ajax', 'nonce_code');
        $slug = filter_input(INPUT_POST, 'social');

        if ($slug != null && !empty($slug)) {
            foreach ($this->socials as $social) {
                if ($social['slug'] == $slug) {
                    break;
                }
            }

            if (!$social) {
                return;
                // Return if social media setting not found.
            }

            $widgetIndex = filter_input(INPUT_POST, 'widget_index');

            ob_start();
            include CHT_DIR.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."channel.php";
            $html = ob_get_clean();
            echo json_encode($html);
        }

        wp_die();

    }//end choose_social_handler()


    /**
     * To get channel list
     *
     * @since  1.0.0
     * @access public
     * @return $channels
     */
    public function get_social_icon_list()
    {
        $social = get_option('cht_numb_slug'.$this->widgetNumber);
        // get saved social media list
        $social = explode(",", $social);

        $arr = [];
        foreach ($social as $keySoc) :
            foreach ($this->socials as $key => $social) :
                // compare with Default Social media list
                if ($social['slug'] != $keySoc) {
                    continue;
                    // return if slug is not equal
                }

                $number = "";
                $index  = "";
                $value  = get_option('cht_social'.$this->widgetNumber.'_'.$social['slug']);
                // get saved settings for button
                if ($value) {
                    $slug      = strtolower($social['slug']);
                    $channelId = "cht-channel-0";
                    $channelId = trim($channelId, "_");
                    if (!empty($value['value']) || $slug == "contact_us" || (isset($value['is_agent']) && $value['is_agent'])) {
                        $url           = "";
                        $mobileURL     = "";
                        $desktopTarget = "";
                        $mobileTarget  = "";
                        $qrCodeImage   = "";

                        $channelType = $slug;

                        if (!isset($value['value'])) {
                            $value['value'] = "";
                        }

                        $svgIcon = $social['svg'];
                        if ($slug == "link" || $slug == "custom_link" || $slug == "custom_link_3" || $slug == "custom_link_4" || $slug == "custom_link_5") {
                            if (isset($value['channel_type']) && !empty($value['channel_type'])) {
                                $channelType = $value['channel_type'];

                                foreach ($this->socials as $icon) {
                                    if ($icon['slug'] == $channelType) {
                                        $svgIcon = $icon['svg'];
                                    }
                                }
                            }
                        }

                        $channelType   = strtolower($channelType);
                        $channelId     = "cht-channel-".$number.$index;
                        $channelId     = trim($channelId, "_");
                        $preSetMessage = "";

                        if ($channelType == "viber") {
                            // Viber change to exclude + from number for desktop
                            $val = $value['value'];
                            if (is_numeric($val)) {
                                $fc = substr($val, 0, 1);
                                if ($fc == "+") {
                                    $length = (-1 * (strlen($val) - 1));
                                    $val    = substr($val, $length);
                                }

                                if (!wp_is_mobile()) {
                                    // Viber change to include + from number for mobile
                                    $val = "+".$val;
                                }
                            }
                        } else if ($channelType == "whatsapp") {
                            // Whatspp change to exclude + from phone number
                            $val = $value['value'];
                            $val = str_replace("+", "", $val);
                        } else if ($channelType == "facebook_messenger") {
                            // Facebook change to change URL from facebook.com to m.me version 2.1.0 change
                            $val = $value['value'];
                            $val = str_replace("facebook.com", "m.me", $val);
                            // Facebook change to remove www. from URL. version 2.1.0 change
                            $val = str_replace("www.", "", $val);

                            $val       = trim($val, "/");
                            $valArray  = explode("/", $val);
                            $total     = (count($valArray) - 1);
                            $lastValue = $valArray[$total];
                            $lastValue = explode("-", $lastValue);
                            $totalText = (count($lastValue) - 1);
                            $totalText = $lastValue[$totalText];

                            if (is_numeric($totalText)) {
                                $valArray[$total] = $totalText;
                                $val = implode("/", $valArray);
                            }
                        } else {
                            $val = $value['value'];
                        }//end if

                        if (!isset($value['title'])) {
                            $value['title'] = $social['title'];
                            // Initialize title with default title if not exists. version 2.1.0 change
                        }

                        $imageURL = "";

                        // get custom image URL if uploaded. version 2.1.0 change
                        if (isset($value['image_id']) && !empty($value['image_id'])) {
                            $imageId = $value['image_id'];
                            if (!empty($imageId)) {
                                $imageData = wp_get_attachment_image_src($imageId, "full");
                                if (!empty($imageData) && is_array($imageData)) {
                                    $imageURL = $imageData[0];
                                }
                            }
                        }

                        $onClickFn = "";
                        // get custom icon background color if exists. version 2.1.0 change
                        if (!isset($value['bg_color']) || empty($value['bg_color'])) {
                            $value['bg_color'] = '';
                        }

                        if ($channelType == "whatsapp") {
                            // setting for Whatsapp URL
                            $val = str_replace("+", "", $val);
                            $val = str_replace(" ", "", $val);
                            $val = str_replace("-", "", $val);
                            if (isset($value['use_whatsapp_web']) && $value['use_whatsapp_web'] == "no") {
                                $url = "https://wa.me/".$val;
                            } else {
                                $url           = "https://web.whatsapp.com/send?phone=".$val;
                                $desktopTarget = "_blank";
                            }
                            $url = esc_url($url);
                            $mobileURL = "https://wa.me/".esc_attr($val);
                        } else if ($channelType == "phone") {
                            // setting for Phone
                            $url = "tel:".esc_attr($val);
                        } else if ($channelType == "sms") {
                            // setting for SMS
                            $url = "sms:".esc_attr($val);
                        } else if ($channelType == "telegram") {
                            // setting for Telegram
                            $val           = ltrim($val, "@");
                            $url           = "https://telegram.me/".$val;
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                            $url           = esc_url($url);
                        } else if ($channelType == "line" || $channelType == "google_maps" || $channelType == "poptin" || $channelType == "waze") {
                            // setting for Line, Google Map, Link, Poptin, Waze, Custom Link
                            $url           = esc_url($val);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                        } else if ($channelType == "link" || $channelType == "custom_link" || $channelType == "custom_link_3" || $channelType == "custom_link_4" || $channelType == "custom_link_5") {
                            $url      = $val;
                            $isExist = strpos($val, "javascript");
                            $isViber = strpos($val, "viber");
                            if ($isViber !== false) {
                                $url = esc_attr($val);
                            } else if ($isExist === false) {
                                $url = esc_url($val);
                                if ($channelType == "custom_link" || $channelType == "link" || $channelType == "custom_link_3" || $channelType == "custom_link_4" || $channelType == "custom_link_5") {
                                    $desktopTarget = (isset($value['new_window']) && $value['new_window'] == 0) ? "" : "_blank";
                                    $mobileTarget  = (isset($value['new_window']) && $value['new_window'] == 0) ? "" : "_blank";
                                }
                            } else {
                                $url       = "javascript:;";
                                $onClickFn     = str_replace('"', "'", $val);
                                $onClickFn     = str_replace('`', "'", $onClickFn);
                                $onClickFn     = urldecode($onClickFn);
                            }
                        } else if ($channelType == "wechat") {
                            // setting for WeChat
                            $url = "javascript:;";
                            if (!empty($value['title'])) {
                                $value['title'] .= ": ".esc_attr($val);
                            } else {
                                $value['title'] = esc_attr($val);
                            }

                            $qr_code = isset($value['qr_code']) ? $value['qr_code'] : "";
                            if (!empty($qr_code)) {
                                $imageData = wp_get_attachment_image_src($qr_code, "full");
                                if (!empty($imageData) && is_array($imageData)) {
                                    $qrCodeImage = $imageData[0];
                                }
                            }
                        } else if ($channelType == "viber") {
                            // setting for Viber
                            $url = esc_attr($val);
                        } else if ($channelType == "snapchat") {
                            // setting for SnapChat
                            $url           = "https://www.snapchat.com/add/".$val;
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                            $url  = esc_url($val);
                        } else if ($channelType == "waze") {
                            // setting for Waze
                            $url = "javascript:;";
                            $value['title'] .= ": ".esc_attr($val);
                        } else if ($channelType == "vkontakte") {
                            // setting for vkontakte
                            $url           = "https://vk.me/".esc_attr($val);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                            $url  = esc_url($val);
                        } else if ($channelType == "skype") {
                            // setting for Skype
                            $url = "skype:".esc_attr($val)."?chat";
                        } else if ($channelType == "email") {
                            // setting for Email
                            $url         = "mailto:".esc_attr($val);;
                            $mailSubject = (isset($value['mail_subject']) && !empty($value['mail_subject'])) ? $value['mail_subject'] : "";
                            $mailSubject = esc_attr($mailSubject);
                            if ($mailSubject != "") {
                                $url .= "?subject=".rawurlencode($mailSubject);
                            }
                        } else if ($channelType == "facebook_messenger") {
                            // setting for facebook URL
                            $url = esc_url($val);
                            $url = str_replace("http:", "https:", $url);
                            if (wp_is_mobile()) {
                                $mobileTarget = "";
                            } else {
                                $desktopTarget = "_blank";
                            }
                            $url = esc_url($url);
                        } else if ($channelType == "twitter") {
                            // setting for Twitter
                            $url           = "https://twitter.com/".esc_attr($val);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                            $url           = esc_url($url);
                        } else if ($channelType == "instagram") {
                            // setting for Instagram
                            $url           = "https://www.instagram.com/".esc_attr($val);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                            $url           = esc_url($url);
                        } else if ($channelType == "linkedin") {
                            // setting for Linkedin
                            $linkType = !isset($value['link_type']) || $value['link_type'] == "company" ? "company" : "personal";
                            if ($linkType == "personal") {
                                $url = "https://www.linkedin.com/in/".esc_attr($val);
                            } else {
                                $url = "https://www.linkedin.com/company/".esc_attr($val);
                            }
                            $url           = esc_url($url);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                        } else if ($channelType == "slack") {
                            // setting for Twitter
                            $url           = esc_url($url);
                            $desktopTarget = "_blank";
                            $mobileTarget  = "_blank";
                        } else if ($channelType == "tiktok") {
                            $val            = $value['value'];
                            $firstCharacter = substr($val, 0, 1);
                            if ($firstCharacter != "@") {
                                $val = "@".$val;
                            }

                            $url           = esc_url("https://www.tiktok.com/".$val);
                            $desktopTarget = $mobileTarget = "_blank";
                            $url           = esc_url($url);
                        }//end if

                        // Instagram checking for custom color
                        if ($channelType == "instagram" && $value['bg_color'] == "#ffffff") {
                            $value['bg_color'] = "";
                        }

                        $svg = trim(preg_replace('/\s\s+/', '', $svgIcon));

                        $isMobile  = isset($value['is_mobile']) ? 1 : 0;
                        $isDesktop = isset($value['is_desktop']) ? 1 : 0;

                        if (empty($mobileURL)) {
                            $mobileURL = $url;
                        }

                        $svgClass = ($channelType == "contact_us") ? "color-element" : "";

                        $svg = '<svg aria-hidden="true" class="ico_d '.$svgClass.'" width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(0deg);">'.$svg.'</svg>';

                        $bgColor  = $value['bg_color'];
                        $rgbColor = $this->getRGBColor($value['bg_color']);
                        $url      = htmlspecialchars($url);

                        $contactFields       = [];
                        $contactFormSettings = [];

                        $valid = true;

                        if ($channelType == "contact_us") {
                            $url           = "javascript:;";
                            $desktopTarget = "";
                            $mobileTarget  = "";
                            if (isset($value['name']) || isset($value['email']) || isset($value['message'])) {
                                $fieldSetting = $value['name'];
                                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                                    $contactFields[] = [
                                        "field"       => "name",
                                        "is_required" => (isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => isset($fieldSetting['placeholder']) ? esc_attr($fieldSetting['placeholder']) : "Enter your name",
                                        "type"        => "text",
                                    ];
                                }

                                $fieldSetting = $value['email'];
                                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                                    $contactFields[] = [
                                        "field"       => "email",
                                        "is_required" => (isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => isset($fieldSetting['placeholder']) ? esc_attr($fieldSetting['placeholder']) : "Enter your name",
                                        "type"        => "email",
                                    ];
                                }

                                $fieldSetting = $value['phone'];
                                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                                    $contactFields[] = [
                                        "field"       => "phone",
                                        "is_required" => (isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => isset($fieldSetting['placeholder']) ? esc_attr($fieldSetting['placeholder']) : "Enter your name",
                                        "type"        => "text",
                                    ];
                                }

                                $fieldSetting = $value['message'];
                                if (isset($fieldSetting['is_active']) && $fieldSetting['is_active'] == "yes") {
                                    $contactFields[] = [
                                        "field"       => "message",
                                        "is_required" => (isset($fieldSetting['is_required']) && $fieldSetting['is_required'] == "yes") ? 1 : 0,
                                        "placeholder" => isset($fieldSetting['placeholder']) ? esc_attr($fieldSetting['placeholder']) : "Enter your name",
                                        "type"        => "textarea",
                                    ];
                                }
                            }//end if

                            if (!empty($contactFields)) {
                                $contactFormSettings = [
                                    "button_text_color"  => isset($value['button_text_color']) ? esc_attr($value['button_text_color']) : "#ffffff",
                                    "button_bg_color"    => isset($value['button_bg_color']) ? esc_attr($value['button_bg_color']) : "#A886CD",
                                    "button_text"        => isset($value['button_text']) ? esc_attr($value['button_text']) : "Chat",
                                    "contact_form_title" => isset($value['contact_form_title']) ? esc_attr($value['contact_form_title']) : "Contact Us",
                                ];
                            } else {
                                $valid = false;
                            }
                        }//end if

                        if ($valid) {
                            $preSetMessage      = isset($value['pre_set_message']) ? esc_attr($value['pre_set_message']) : "";
                            $isDefaultOpen      = (isset($value['is_default_open'])&&$value['is_default_open'] == "yes") ? 1 : 0;
                            $hasWelcomeMessage  = (isset($value['embedded_window'])&&$value['embedded_window'] == "yes") ? 1 : 0;
                            $embeddedMessage    = isset($value['embedded_message']) ? $value['embedded_message'] : "";
                            $channelAccountType = isset($value['link_type']) ? esc_attr($value['link_type']) : "personal";
                            $mailSubject        = isset($value['mail_subject']) ? esc_attr($value['mail_subject']) : "";
                            $isUseWebVersion    = (isset($value['use_whatsapp_web']) && $value['use_whatsapp_web'] == "no") ? 0 : 1;
                            $isOpenNewTab       = (isset($value['is_open_new_tab']) && $value['is_open_new_tab'] == 0) ? 0 : 1;
                            $channelType        = isset($value['channel_type']) && !empty($value['channel_type']) ? $value['channel_type'] : $social['slug'];
                            $allowed_html    = [
                                'a'      => [
                                    'href'  => [],
                                    'title' => [],
                                ],
                                'p'      => [],
                                'br'     => [],
                                'em'     => [],
                                'strong' => [],
                            ];
                            $embeddedMessage = wp_kses($embeddedMessage, $allowed_html);

                            $widgetToken = wp_create_nonce("chaty_widget_nonce".$index);

                            $agentFaIcon = isset($value['fa_icon']) ? $value['fa_icon'] : "";
                            if (!empty($agentFaIcon)) {
                                $svg           = "<span class='chaty-custom-channel-icon'><i class='{$agentFaIcon}'></i></span>";
                                $this->hasFont = true;
                            }

                            $data  = [
                                "channel"               => $social['slug'],
                                "value"                 => esc_attr__(wp_unslash($val)),
                                "hover_text"            => esc_attr__(wp_unslash($value['title'])),
                                "svg_icon"              => $svg,
                                "is_desktop"            => $isDesktop,
                                "is_mobile"             => $isMobile,
                                "icon_color"            => $bgColor,
                                "icon_rgb_color"        => $rgbColor,
                                "channel_type"          => esc_attr($channelType),
                                "custom_image_url"      => esc_url($imageURL),
                                "order"                 => "",
                                "pre_set_message"       => esc_attr($preSetMessage),
                                "is_use_web_version"    => esc_attr($isUseWebVersion),
                                "is_open_new_tab"       => esc_attr($isOpenNewTab),
                                "is_default_open"       => esc_attr($isDefaultOpen),
                                "has_welcome_message"   => esc_attr($hasWelcomeMessage),
                                "chat_welcome_message"  => $embeddedMessage,
                                "qr_code_image_url"     => esc_url($qrCodeImage),
                                "mail_subject"          => esc_attr($mailSubject),
                                "channel_account_type"  => esc_attr($channelAccountType),
                                "contact_form_settings" => $contactFormSettings,
                                "contact_fields"        => $contactFields,
                                "url"                   => $url,
                                "mobile_target"         => $mobileTarget,
                                "desktop_target"        => $desktopTarget,
                                "target"                => $desktopTarget,
                                "is_agent"              => 0,
                                "agent_data"            => [],
                                "header_text"           => '',
                                "header_sub_text"       => '',
                                "header_bg_color"       => '',
                                "header_text_color"     => '',
                                "widget_token"          => $widgetToken,
                                "widget_index"          => $index,
                                "click_event"           => $onClickFn,
                            ];
                            $arr[] = $data;
                        }//end if
                    }//end if
                }//end if
            endforeach;
        endforeach;
        return $arr;

    }//end get_social_icon_list()


    /**
     * To get RGB code from hexa code
     *
     * @since  1.0.0
     * @access public
     * @return $color
     */
    public function getRGBColor($color)
    {
        if (!empty($color)) {
            if (strpos($color, '#') !== false) {
                $color = $this->hex2rgba($color);
            }

            if (strpos($color, 'rgba(') !== false || strpos($color, 'rgb(') !== false) {
                $color   = explode(",", $color);
                $color   = str_replace(["rgba(", "rgb(", ")"], ["", "", ""], $color);
                $string  = "";
                $string .= ((isset($color[0])) ? trim($color[0]) : "0").",";
                $string .= ((isset($color[1])) ? trim($color[1]) : "0").",";
                $string .= ((isset($color[2])) ? trim($color[2]) : "0");
                return $string;
            }
        }

        return "0,0,0";

    }//end getRGBColor()


    /**
     * To get color hexa code to RGB code
     *
     * @since  1.0.0
     * @access public
     * @return $color
     */
    public function hex2rgba($color, $opacity=false)
    {

        $default = 'rgb(0,0,0)';

        // Return default if no color provided
        if (empty($color)) {
            return $default;
        }

        // Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        // Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = [
                $color[0].$color[1],
                $color[2].$color[3],
                $color[4].$color[5],
            ];
        } else if (strlen($color) == 3) {
            $hex = [
                $color[0].$color[0],
                $color[1].$color[1],
                $color[2].$color[2],
            ];
        } else {
            return $default;
        }

        // Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        // Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1) {
                $opacity = 1.0;
            }

            $output = 'rgba('.implode(",", $rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",", $rgb).')';
        }

        // Return rgb(a) color string
        return $output;

    }//end hex2rgba()


    /**
     * To check widget status active or not
     *
     * @since  1.0.0
     * @access public
     * @return $status
     */
    private function canInsertWidget()
    {
        return get_option('cht_active') && $this->checkChannels();

    }//end canInsertWidget()


    /**
     * To get active channel lists
     *
     * @since  1.0.0
     * @access public
     * @return $status
     */
    private function checkChannels()
    {
        $social = explode(",", get_option('cht_numb_slug'));
        $res    = false;
        foreach ($social as $name) {
            $value = get_option('cht_social_'.strtolower($name));
            $res   = $res || !empty($value['value']) || ($name == "Contact_Us");
        }

        return $res;

    }//end checkChannels()


    /**
     * To get USER IP Address
     *
     * @since  1.0.0
     * @access public
     * @return $ipAddress
     */
    function get_user_ipaddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // ip pass from proxy
            $ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']));
        } else {
            $ip = sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR']));
        }

        return $ip;

    }//end get_user_ipaddress()


}//end class


return new CHT_Frontend();
