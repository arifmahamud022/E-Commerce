<?php
/**
 * Contact form leads
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

if (defined('ABSPATH') === false) {
    exit;
}

$value = get_option('cht_social_'.$social['slug']);
// get setting for media if already saved
$imageUrl = plugin_dir_url("")."chaty/admin/assets/images/chaty-default.png";
if (empty($value)) {
    // Initialize default values if not found
    $value = [
        'value'      => '',
        'is_mobile'  => 'checked',
        'is_desktop' => 'checked',
        'image_id'   => '',
        'title'      => $social['title'],
        'bg_color'   => "",
    ];
}

if (!isset($value['bg_color']) || empty($value['bg_color'])) {
    $value['bg_color'] = $social['color'];
    // Initialize background color value if not exists. 2.1.0 change
}

if (!isset($value['image_id'])) {
    $value['image_id'] = '';
    // Initialize custom image id if not exists. 2.1.0 change
}

if (!isset($value['title'])) {
    $value['title'] = $social['title'];
    // Initialize title if not exists. 2.1.0 change
}

if (!isset($value['fa_icon'])) {
    $value['fa_icon'] = "";
    // Initialize title if not exists. 2.1.0 change
}

if (!isset($value['value'])) {
    $value['value'] = "";
    // Initialize title if not exists. 2.1.0 change
}

$imageId = $value['image_id'];
$status  = 0;
if (!empty($imageId)) {
    $imageUrl = wp_get_attachment_image_src($imageId, "full")[0];
    // get custom image URL if exists
    $status = 1;
}

if ($imageUrl == "") {
    $imageUrl = plugin_dir_url("")."chaty/admin/assets/images/chaty-default.png";
    // Initialize with default image if custom image is not exists
    $status  = 0;
    $imageId = "";
}

$color = "";
if (!empty($value['bg_color'])) {
    $color = "background-color: ".$value['bg_color'];
    // set background color of icon it it is exists
}

if ($social['slug'] == "Whatsapp") {
    $val            = $value['value'];
    $val            = str_replace("+", "", $val);
    $value['value'] = $val;
} else if ($social['slug'] == "Facebook_Messenger") {
    $val = $value['value'];
    $val = str_replace("facebook.com", "m.me", $val);
    // Replace facebook.com with m.me version 2.0.1 change.
    $val = str_replace("www.", "", $val);
    // Replace www. with blank version 2.0.1 change.
    $value['value'] = $val;

    $val       = trim($val, "/");
    $valArray  = explode("/", $val);
    $total     = (count($valArray) - 1);
    $lastValue = $valArray[$total];
    $lastValue = explode("-", $lastValue);
    $totalText = (count($lastValue) - 1);
    $totalText = $lastValue[$totalText];

    if (is_numeric($totalText)) {
        $valArray[$total] = $totalText;
        $value['value']   = implode("/", $valArray);
    }
}//end if

$value['value'] = esc_attr__(wp_unslash($value['value']));
$value['title'] = esc_attr__(wp_unslash($value['title']));

$svgIcon = $social['svg'];

$helpTitle = "";
$helpText  = "";
$helpLink  = "";

if ((isset($social['help']) && !empty($social['help'])) || isset($social['help_link'])) {
    $helpTitle = isset($social['help_title']) ? $social['help_title'] : "Doesn't work?";
    $helpText  = isset($social['help']) ? $social['help'] : "";
    if (isset($social['help_link']) && !empty($social['help_link'])) {
        $helpLink = $social['help_link'];
    }
}

$channelType = "";
$placeholder = $social['example'];
if ($social['slug'] == "Link" || $social['slug'] == "Custom_Link" || $social['slug'] == "Custom_Link_3" || $social['slug'] == "Custom_Link_4" || $social['slug'] == "Custom_Link_5") {
    if (isset($value['channel_type'])) {
        $channelType = esc_attr__(wp_unslash($value['channel_type']));
    }

    if (!empty($channelType)) {
        foreach ($this->socials as $icon) {
            if ($icon['slug'] == $channelType) {
                $svgIcon = $icon['svg'];

                $placeholder = $icon['example'];

                if ((isset($icon['help']) && !empty($icon['help'])) || isset($icon['help_link'])) {
                    $helpTitle = isset($icon['help_title']) ? $icon['help_title'] : "Doesn't work?";
                    $helpText  = isset($icon['help']) ? $icon['help'] : "";
                    if (isset($icon['help_link']) && !empty($icon['help_link'])) {
                        $helpLink = $icon['help_link'];
                    }
                }
            }
        }
    }
}//end if

if (empty($channelType)) {
    $channelType = $social['slug'];
}

if ($channelType == "Telegram") {
    $value['value'] = trim($value['value'], "@");
}

$isAgent = 0;
?>
<!-- Social media setting box: start -->
<li data-id="<?php echo esc_attr($social['slug']) ?>" class="chaty-channel <?php echo ($isAgent == 1) ? "has-agent-view" : "" ?>" data-channel="<?php echo esc_attr($channelType) ?>" id="chaty-social-<?php echo esc_attr($social['slug']) ?>">
    <div class="channels-selected__item <?php echo esc_attr(($status) ? "img-active" : "") ?> <?php echo esc_attr(($this->is_pro()) ? 'pro' : 'free'); ?> 1 available">
        <div class="chaty-default-settings">
            <div class="move-icon">
                <img src="<?php echo esc_url(plugin_dir_url("")."/chaty/admin/assets/images/move-icon.png") ?>">
            </div>
            <div class="icon icon-md active" data-label="<?php echo esc_attr($social['title']); ?>" id="chaty_image_<?php echo esc_attr($social['slug']) ?>">
                <span style="" class="custom-chaty-image custom-image-<?php echo esc_attr($social['slug']) ?>" id="image_data_<?php echo esc_attr($social['slug']) ?>">
                    <img src="<?php echo esc_url($imageUrl) ?>" />
                    <span onclick="remove_chaty_image('<?php echo esc_attr($social['slug']) ?>')" class="remove-icon-img"></span>
                </span>
                <span class="default-chaty-icon <?php echo (isset($value['fa_icon'])&&!empty($value['fa_icon'])) ? "has-fa-icon" : "" ?> custom-icon-<?php echo esc_attr($social['slug']) ?> default_image_<?php echo esc_attr($social['slug']) ?>" >
                    <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <?php echo $svgIcon; ?>
                    </svg>
                    <span class="facustom-icon" style="background-color: <?php echo esc_attr($value['bg_color']) ?>"><i class="<?php echo esc_attr($value['fa_icon']) ?>"></i></span>
                </span>
            </div>

            <?php if ($social['slug'] != 'Contact_Us') { ?>
                <!-- Social Media input  -->
                <?php if (($social['slug'] == "Whatsapp" || $channelType == "Whatsapp") && !empty($value['value'])) {
                    $value['value'] = trim($value['value'], "+");
                    $value['value'] = "+".$value['value'];
                } ?>
                <div class="channels__input-box">
                    <input data-label="<?php echo esc_attr($social['title']) ?>" placeholder="<?php echo esc_attr($placeholder); ?>" type="text" class="channels__input custom-channel-<?php echo esc_attr__($channelType) ?> <?php echo isset($social['attr']) ? $social['attr'] : "" ?>" name="cht_social_<?php echo esc_attr($social['slug']); ?>[value]" value="<?php echo esc_attr(wp_unslash($value['value'])); ?>" data-gramm_editor="false" id="channel_input_<?php echo esc_attr($social['slug']); ?>" />
                </div>
            <?php } ?>
            <div class="channels__device-box">
                <div class="device-box">
                    <?php
                    $slug      = esc_attr__($this->del_space($social['slug']));
                    $slug      = str_replace(' ', '_', $slug);
                    $isDesktop = isset($value['is_desktop']) && $value['is_desktop'] == "checked" ? "checked" : '';
                    $isMobile  = isset($value['is_mobile']) && $value['is_mobile'] == "checked" ? "checked" : '';
                    ?>
                    <!-- setting for desktop -->
                    <label class="device_view" for="<?php echo esc_attr($slug); ?>Desktop">
                        <input type="checkbox" id="<?php echo esc_attr($slug); ?>Desktop" class="channels__view-check sr-only js-chanel-icon js-chanel-desktop" data-type="<?php echo str_replace(' ', '_', strtolower(esc_attr__($this->del_space($social['slug'])))); ?>" name="cht_social_<?php echo esc_attr($social['slug']); ?>[is_desktop]" value="checked" data-gramm_editor="false" <?php echo esc_attr($isDesktop) ?> />
                        <span class="channels__view-txt">
                            <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.3333 10.0001C14.0667 10.0001 14.6667 9.40008 14.6667 8.66675V2.00008C14.6667 1.26675 14.0667 0.666748 13.3333 0.666748H2.66667C1.93333 0.666748 1.33333 1.26675 1.33333 2.00008V8.66675C1.33333 9.40008 1.93333 10.0001 2.66667 10.0001H0.666667C0.3 10.0001 0 10.3001 0 10.6667C0 11.0334 0.3 11.3334 0.666667 11.3334H15.3333C15.7 11.3334 16 11.0334 16 10.6667C16 10.3001 15.7 10.0001 15.3333 10.0001H13.3333ZM3.33333 2.00008H12.6667C13.0333 2.00008 13.3333 2.30008 13.3333 2.66675V8.00008C13.3333 8.36675 13.0333 8.66675 12.6667 8.66675H3.33333C2.96667 8.66675 2.66667 8.36675 2.66667 8.00008V2.66675C2.66667 2.30008 2.96667 2.00008 3.33333 2.00008Z" />
                            </svg>
                        </span>
                        <span class="device-tooltip">
                            <span class="on"><?php esc_html_e("Hide on desktop", "chaty") ?></span>
                            <span class="off"><?php esc_html_e("Show on desktop", "chaty") ?></span>
                        </span>
                    </label>

                    <!-- setting for mobile -->
                    <label class="device_view" for="<?php echo esc_attr($slug); ?>Mobile">
                        <input type="checkbox" id="<?php echo esc_attr($slug); ?>Mobile" class="channels__view-check sr-only js-chanel-icon js-chanel-mobile" data-type="<?php echo str_replace(' ', '_', strtolower(esc_attr__($this->del_space($social['slug'])))); ?>" name="cht_social_<?php echo esc_attr($social['slug']); ?>[is_mobile]" value="checked" data-gramm_editor="false" <?php echo esc_attr($isMobile) ?> >
                        <span class="channels__view-txt">
                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.33301 0.666748H1.99967C1.07967 0.666748 0.333008 1.41341 0.333008 2.33341V13.6667C0.333008 14.5867 1.07967 15.3334 1.99967 15.3334H7.33301C8.25301 15.3334 8.99967 14.5867 8.99967 13.6667V2.33341C8.99967 1.41341 8.25301 0.666748 7.33301 0.666748ZM4.66634 14.6667C4.11301 14.6667 3.66634 14.2201 3.66634 13.6667C3.66634 13.1134 4.11301 12.6667 4.66634 12.6667C5.21967 12.6667 5.66634 13.1134 5.66634 13.6667C5.66634 14.2201 5.21967 14.6667 4.66634 14.6667ZM7.66634 12.0001H1.66634V2.66675H7.66634V12.0001Z" />
                            </svg>
                        </span>
                        <span class="device-tooltip">
                            <span class="on"><?php esc_html_e("Hide on desktop", "chaty") ?></span>
                            <span class="off"><?php esc_html_e("Show on desktop", "chaty") ?></span>
                        </span>
                    </label>
                </div>
            </div>

            <?php if ($slug != 'Custom_Link' && $slug != 'Custom_Link_3' && $slug != 'Custom_Link_4' && $slug != 'Custom_Link_5' && $slug != 'Contact_Us' && $slug != 'Link') { ?>
                <div class="channels__agent-box">
                    <a href="#" class="add-agent-btn">
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.25 5.14286C6.69975 5.14286 7.875 3.99159 7.875 2.57143C7.875 1.15127 6.69975 0 5.25 0C3.80025 0 2.625 1.15127 2.625 2.57143C2.625 3.99159 3.80025 5.14286 5.25 5.14286Z" fill="white"/>
                            <path d="M5.25 6.85714C8.1495 6.85714 10.5 9.15968 10.5 12H0C0 9.15968 2.35051 6.85714 5.25 6.85714Z" fill="white"/>
                            <path d="M12.25 3.42857C12.25 2.95518 11.8582 2.57143 11.375 2.57143C10.8918 2.57143 10.5 2.95518 10.5 3.42857V4.28571H9.625C9.14175 4.28571 8.75 4.66947 8.75 5.14286C8.75 5.61624 9.14175 6 9.625 6H10.5V6.85714C10.5 7.33053 10.8918 7.71429 11.375 7.71429C11.8582 7.71429 12.25 7.33053 12.25 6.85714V6H13.125C13.6082 6 14 5.61624 14 5.14286C14 4.66947 13.6082 4.28571 13.125 4.28571H12.25V3.42857Z" fill="white"/>
                        </svg> <?php esc_html_e("Add Agents", "chaty"); ?>
                    </a>
                </div>
            <?php } else if($slug != 'Contact_Us') { ?>
                <div class="channels__agent-box transparent">
                    <a href="#" class="add-agent-btn">
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.25 5.14286C6.69975 5.14286 7.875 3.99159 7.875 2.57143C7.875 1.15127 6.69975 0 5.25 0C3.80025 0 2.625 1.15127 2.625 2.57143C2.625 3.99159 3.80025 5.14286 5.25 5.14286Z" fill="white"/>
                            <path d="M5.25 6.85714C8.1495 6.85714 10.5 9.15968 10.5 12H0C0 9.15968 2.35051 6.85714 5.25 6.85714Z" fill="white"/>
                            <path d="M12.25 3.42857C12.25 2.95518 11.8582 2.57143 11.375 2.57143C10.8918 2.57143 10.5 2.95518 10.5 3.42857V4.28571H9.625C9.14175 4.28571 8.75 4.66947 8.75 5.14286C8.75 5.61624 9.14175 6 9.625 6H10.5V6.85714C10.5 7.33053 10.8918 7.71429 11.375 7.71429C11.8582 7.71429 12.25 7.33053 12.25 6.85714V6H13.125C13.6082 6 14 5.61624 14 5.14286C14 4.66947 13.6082 4.28571 13.125 4.28571H12.25V3.42857Z" fill="white"/>
                        </svg>
                        <?php esc_html_e("Add Agents", "chaty"); ?>
                    </a>
                </div>
            <?php }//end if
            ?>

            <?php
            $closeClass = "active";
            if ($social['slug'] == 'Contact_Us') {
                $settingStatus = get_option("chaty_contact_us_setting");
                if ($settingStatus === false) {
                    $closeClass = "";
                }
            }
            ?>


            <!-- button for advance setting -->
            <div class="chaty-settings <?php echo esc_attr($closeClass) ?>" data-nonce="<?php echo wp_create_nonce($social['slug']."-settings") ?>" id="<?php echo esc_attr($social['slug']); ?>-close-btn" onclick="toggle_chaty_setting('<?php echo esc_attr($social['slug']); ?>')">
                <a href="javascript:;"><span class="dashicons dashicons-admin-generic"></span> Settings</a>
            </div>
            <?php if ($social['slug'] != 'Contact_Us') { ?>
                <!-- example for social media -->
                <div class="input-example">
                    <?php esc_html_e('For example', 'chaty'); ?>:
                    <span class="inline-box channel-example">
                        <?php if ($social['slug'] == "Poptin") { ?>
                            <br/>
                        <?php } ?>
                        <?php echo esc_attr($placeholder); ?>
                    </span>
                </div>

                <!-- checking for extra help message for social media -->
                <div class="help-section">
                    <?php if ((isset($social['help']) && !empty($social['help'])) || isset($social['help_link'])) { ?>
                        <div class="viber-help">
                            <?php if (isset($helpLink) && !empty($helpLink)) { ?>
                                <a class="help-link" href="<?php echo esc_url($helpLink) ?>" target="_blank"><?php echo esc_attr($helpTitle); ?></a>
                            <?php } else if (isset($helpText) && !empty($helpText)) { ?>
                                <?php
                                $allowedHTML = [
                                    'a'      => [
                                        'href'  => [],
                                        'title' => [],
                                    ],
                                    'br'     => [],
                                    'em'     => [],
                                    'strong' => [],
                                ]; ?>
                                <span class="help-text"><?php echo wp_kses($helpText, $allowedHTML); ?></span> <!-- $helpText contains HTML -->
                                <span class="help-title"><?php echo esc_attr($helpTitle); ?></span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php }//end if
            ?>
        </div>

        <?php if ($social['slug'] == "Whatsapp" || $social['slug'] == "Link" || $social['slug'] == "Custom_Link" || $social['slug'] == "Custom_Link_3" || $social['slug'] == "Custom_Link_4" || $social['slug'] == "Custom_Link_5") { ?>
            <div class="Whatsapp-settings advanced-settings extra-chaty-settings">
                <?php $embeddedWindow = isset($value['embedded_window']) ? $value['embedded_window'] : "no"; ?>
                <div class="chaty-setting-col">
                    <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[embedded_window]" value="no" >
                    <label class="chaty-switch full-width chaty-embedded-window" for="whatsapp_embedded_window_<?php echo esc_attr($social['slug']); ?>">
                        <input type="checkbox" class="embedded_window-checkbox" name="cht_social_<?php echo esc_attr($social['slug']); ?>[embedded_window]" id="whatsapp_embedded_window_<?php echo esc_attr($social['slug']); ?>" value="yes" <?php checked($embeddedWindow, "yes") ?> >
                        <div class="chaty-slider round"></div>
                        WhatsApp Chat Popup &#128172;
                        <div class="html-tooltip top">
                            <span class="dashicons dashicons-editor-help"></span>
                            <span class="tooltip-text top">
                                Show an embedded WhatsApp window to your visitors with a welcome message. Your users can start typing their own message and start a conversation with you right away once they are forwarded to the WhatsApp app.
                                <img src="<?php echo esc_url(CHT_PLUGIN_URL) ?>/admin/assets/images/whatsapp-popup.gif" />
                            </span>
                        </div>
                    </label>
                </div>
                <!-- advance setting for Whatsapp -->
                <div class="whatsapp-welcome-message <?php echo ($embeddedWindow == "yes") ? "active" : "" ?>">
                    <div class="chaty-setting-col">
                        <label style="display: block; width: 100%" for="cht_social_embedded_message_<?php echo esc_attr($social['slug']); ?>">Welcome message</label>
                        <div class="full-width">
                            <div class="full-width">
                                <?php $unique_id = uniqid(); ?>
                                <?php $embeddedMessage = isset($value['embedded_message']) ? $value['embedded_message'] : esc_html__("How can I help you? :)", "chaty"); ?>
                                <textarea class="chaty-setting-textarea chaty-whatsapp-setting-textarea" data-id="<?php echo esc_attr($unique_id) ?>" id="cht_social_embedded_message_<?php echo esc_attr($unique_id) ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[embedded_message]" ><?php echo esc_textarea($embeddedMessage) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="chaty-setting-col">
                        <?php $isDefaultOpen = isset($value['is_default_open']) ? $value['is_default_open'] : ""; ?>
                        <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[is_default_open]" value="no" >
                        <label class="chaty-switch" for="whatsapp_default_open_embedded_window_<?php echo esc_attr($social['slug']); ?>">
                            <input type="checkbox" name="cht_social_<?php echo esc_attr($social['slug']); ?>[is_default_open]" id="whatsapp_default_open_embedded_window_<?php echo esc_attr($social['slug']); ?>" value="yes" <?php checked($isDefaultOpen, "yes") ?> >
                            <div class="chaty-slider round"></div>
                            Open the window on load
                            <span class="icon label-tooltip" data-label="Open the WhatsApp chat popup on page load, after the user sends a message or closes the window, the window will stay closed to avoid disruption"><span class="dashicons dashicons-editor-help"></span></span>
                        </label>
                    </div>
                </div>
            </div>
        <?php }//end if
        ?>

        <!-- advance setting fields: start -->
        <?php $className = !$this->is_pro() ? "not-is-pro" : ""; ?>
        <div class="chaty-advance-settings <?php echo esc_attr($className); ?>" style="<?php echo (empty($closeClass) && $social['slug'] == 'Contact_Us') ? "display:block" : ""; ?>">
            <!-- Settings for custom icon and color -->
            <div class="chaty-setting-col">
                <label>Icon Appearance</label>
                <div>
                    <!-- input for custom color -->
                    <input type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[bg_color]" class="chaty-color-field" value="<?php echo esc_attr($value['bg_color']) ?>" />

                    <!-- button to upload custom image -->
                    <?php if ($this->is_pro()) { ?>
                        <a onclick="upload_chaty_image('<?php echo esc_attr($social['slug']); ?>')" href="javascript:;" class="upload-chaty-icon"><span class="dashicons dashicons-upload"></span> Custom Image</a>

                        <!-- hidden input value for image -->
                        <input id="cht_social_image_<?php echo esc_attr($social['slug']); ?>" type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[image_id]" value="<?php echo esc_attr($imageId) ?>" />
                    <?php } else { ?>
                        <div class="pro-features upload-image">
                            <div class="pro-item">
                                <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>" class="upload-chaty-icon"><span class="dashicons dashicons-upload"></span> Custom Image</a>
                            </div>
                            <div class="pro-button">
                                <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>"><?php esc_html_e('Upgrade to Pro', 'chaty');?></a>
                            </div>
                        </div>

                        <div class="pro-features upload-image">
                            <div class="pro-item">
                                <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>" class="upload-chaty-icon">Change Icon</a>
                            </div>
                            <div class="pro-button">
                                <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>"><?php esc_html_e('Upgrade to Pro', 'chaty');?></a>
                            </div>
                        </div>
                    <?php }//end if
                    ?>
                </div>
            </div>
            <div class="clear clearfix"></div>

            <?php if ($social['slug'] == "Link" || $social['slug'] == "Custom_Link" || $social['slug'] == "Custom_Link_3" || $social['slug'] == "4" || $social['slug'] == "Custom_Link_5") {
                $channelType = "";
                if (isset($value['channel_type'])) {
                    $channelType = esc_attr__(wp_unslash($value['channel_type']));
                }

                $socials = $this->socials;
                ?>
                <div class="chaty-setting-col">
                    <label>Channel type</label>
                    <div>
                        <!-- input for custom title -->
                        <select class="channel-select-input" name="cht_social_<?php echo esc_attr($social['slug']); ?>[channel_type]" value="<?php echo esc_attr($value['channel_type']) ?>">
                            <option value="<?php echo esc_attr($social['slug']) ?>">Custom channel</option>
                            <?php foreach ($socials as $socialIcon) {
                                $selected = ($socialIcon['slug'] == $channelType) ? "selected" : "";
                                if ($socialIcon['slug'] != 'Custom_Link' && $socialIcon['slug'] != 'Custom_Link_3' && $socialIcon['slug'] != 'Custom_Link_4' && $socialIcon['slug'] != 'Custom_Link_5' && $socialIcon['slug'] != 'Contact_Us' && $socialIcon['slug'] != 'Link') { ?>
                                    <option <?php echo esc_attr($selected) ?> value="<?php echo esc_attr($socialIcon['slug']) ?>"><?php echo esc_attr($socialIcon['title']) ?></option>
                                <?php }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="clear clearfix"></div>
            <?php }//end if
            ?>

            <div class="chaty-setting-col">
                <label>On Hover Text</label>
                <div>
                    <input type="text" class="chaty-title" name="cht_social_<?php echo esc_attr($social['slug']); ?>[title]" value="<?php echo esc_attr($value['title']) ?>">
                </div>
            </div>
            <div class="clear clearfix"></div>

            <div class="Contact_Us-settings advanced-settings">
                <div class="clear clearfix"></div>
                <div class="chaty-setting-col">
                    <label>Contact Form Title</label>
                    <div>
                        <?php $contactFormTitle = isset($value['contact_form_title']) ? $value['contact_form_title'] : esc_html__("Contact Us", "chaty"); ?>
                        <input id="cht_social_message_<?php echo esc_attr($social['slug']); ?>_form_title" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[contact_form_title]" value="<?php echo esc_attr($contactFormTitle) ?>" >
                    </div>
                </div>
                <?php
                $fields = [
                    'name'    => [
                        'title'       => "Name",
                        'placeholder' => "Enter your name",
                        'is_required' => 1,
                        'type'        => 'input',
                        'is_enabled'  => 1,
                    ],
                    'email'   => [
                        'title'       => "Email",
                        'placeholder' => "Enter your email address",
                        'is_required' => 1,
                        'type'        => 'email',
                        'is_enabled'  => 1,
                    ],
                    'phone'   => [
                        'title'       => "Phone",
                        'placeholder' => "Enter your phone number",
                        'is_required' => 1,
                        'type'        => 'input',
                        'is_enabled'  => 1,
                    ],
                    'message' => [
                        'title'       => "Message",
                        'placeholder' => "Enter your message",
                        'is_required' => 1,
                        'type'        => 'textarea',
                        'is_enabled'  => 1,
                    ],
                ];
                echo '<div class="form-field-setting-col">';
                foreach ($fields as $label => $field) {
                    $savedValue = isset($value[$label]) ? $value[$label] : [];
                    $fieldValue = [
                        'is_active'   => (isset($savedValue['is_active'])) ? $savedValue['is_active'] : 'yes',
                        'is_required' => (isset($savedValue['is_required'])) ? $savedValue['is_required'] : 'yes',
                        'placeholder' => (isset($savedValue['placeholder'])) ? $savedValue['placeholder'] : $field['placeholder'],
                    ];
                    ?>
                    <div class="field-setting-col">
                        <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[<?php echo esc_attr($label) ?>][is_active]" value="no">
                        <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[<?php echo esc_attr($label) ?>][is_required]" value="no">

                        <div class="left-section">
                            <label class="chaty-switch chaty-switch-toggle" for="field_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>">
                                <input type="checkbox" class="chaty-field-setting" name="cht_social_<?php echo esc_attr($social['slug']); ?>[<?php echo esc_attr($label) ?>][is_active]" id="field_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>" value="yes" <?php checked($fieldValue['is_active'], "yes") ?>>
                                <div class="chaty-slider round"></div>
                                <?php echo esc_attr($field['title']) ?>
                            </label>
                        </div>
                        <div class="right-section">
                            <div class="field-settings <?php echo ($fieldValue['is_active'] == "yes") ? "active" : "" ?>">
                                <div class="inline-block">
                                    <label class="inline-block" for="field_required_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>">Required?</label>
                                    <div class="inline-block">
                                        <label class="chaty-switch" for="field_required_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>">
                                            <input type="checkbox" name="cht_social_<?php echo esc_attr($social['slug']); ?>[<?php echo esc_attr($label) ?>][is_required]" id="field_required_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>" value="yes" <?php checked($fieldValue['is_required'], "yes") ?>>
                                            <div class="chaty-slider round"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear clearfix"></div>
                        <div class="field-settings <?php echo ($fieldValue['is_active'] == "yes") ? "active" : "" ?>">
                            <div class="chaty-setting-col">
                                <label for="placeholder_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>">Placeholder text</label>
                                <div>
                                    <input id="placeholder_for_<?php echo esc_attr($social['slug']); ?>_<?php echo esc_attr($label) ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[<?php echo esc_attr($label) ?>][placeholder]" value="<?php echo esc_attr($fieldValue['placeholder']) ?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($label != 'message') { ?>
                        <div class="chaty-separator"></div>
                    <?php } ?>
                <?php }//end foreach

                echo '</div>'; ?>
                <div class="form-field-setting-col">
                    <div class="form-field-title">Submit Button</div>
                    <div class="color-box">
                        <div class="clr-setting">
                            <?php $fieldValue = isset($value['button_text_color']) ? $value['button_text_color'] : "#ffffff" ?>
                            <div class="chaty-setting-col">
                                <label for="button_text_color_for_<?php echo esc_attr($social['slug']); ?>">Text color</label>
                                <div>
                                    <input id="button_text_color_for_<?php echo esc_attr($social['slug']); ?>" class="chaty-color-field button-color" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[button_text_color]" value="<?php echo esc_attr($fieldValue); ?>" >
                                </div>
                            </div>
                        </div>
                        <?php $fieldValue = isset($value['button_bg_color']) ? $value['button_bg_color'] : "#A886CD" ?>
                        <div class="clr-setting">
                            <div class="chaty-setting-col">
                                <label for="button_bg_color_for_<?php echo esc_attr($social['slug']); ?>">Background color</label>
                                <div>
                                    <input id="button_bg_color_for_<?php echo esc_attr($social['slug']); ?>" class="chaty-color-field button-color" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[button_bg_color]" value="<?php echo esc_attr($fieldValue); ?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $fieldValue = isset($value['button_text']) ? $value['button_text'] : "Chat" ?>
                    <div class="chaty-setting-col">
                        <label for="button_text_for_<?php echo esc_attr($social['slug']); ?>">Button text</label>
                        <div>
                            <input id="button_text_for_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[button_text]" value="<?php echo esc_attr($fieldValue); ?>" >
                        </div>
                    </div>
                    <?php $fieldValue = isset($value['thanks_message']) ? $value['thanks_message'] : "Your message was sent successfully" ?>
                    <div class="chaty-setting-col">
                        <label for="thanks_message_for_<?php echo esc_attr($social['slug']); ?>">Thank you message</label>
                        <div>
                            <input id="thanks_message_for_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[thanks_message]" value="<?php echo esc_attr($fieldValue); ?>" >
                        </div>
                    </div>
                    <div class="chaty-separator"></div>
                    <?php $fieldValue = isset($value['redirect_action']) ? $value['redirect_action'] : "no" ?>
                    <div class="chaty-setting-col">
                        <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[redirect_action]" value="no" >
                        <label class="chaty-switch full-width" for="redirect_action_<?php echo esc_attr($social['slug']); ?>">
                            <input type="checkbox" class="chaty-redirect-setting" name="cht_social_<?php echo esc_attr($social['slug']); ?>[redirect_action]" id="redirect_action_<?php echo esc_attr($social['slug']); ?>" value="yes" <?php checked($fieldValue, "yes") ?> >
                            <div class="chaty-slider round"></div>
                            Redirect visitors after submission
                        </label>
                    </div>
                    <div class="redirect_action-settings <?php echo ($fieldValue == "yes") ? "active" : "" ?>">
                        <?php $fieldValue = isset($value['redirect_link']) ? $value['redirect_link'] : "" ?>
                        <div class="chaty-setting-col">
                            <label for="redirect_link_for_<?php echo esc_attr($social['slug']); ?>">Redirect link</label>
                            <div>
                                <input id="redirect_link_for_<?php echo esc_attr($social['slug']); ?>" placeholder="<?php echo site_url("/") ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[redirect_link]" value="<?php echo esc_attr($fieldValue); ?>" >
                            </div>
                        </div>
                        <?php $fieldValue = isset($value['link_in_new_tab']) ? $value['link_in_new_tab'] : "no" ?>
                        <div class="chaty-setting-col">
                            <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_in_new_tab]" value="no" >
                            <label class="chaty-switch full-width" for="link_in_new_tab_<?php echo esc_attr($social['slug']); ?>">
                                <input type="checkbox" class="chaty-field-setting" name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_in_new_tab]" id="link_in_new_tab_<?php echo esc_attr($social['slug']); ?>" value="yes" <?php checked($fieldValue, "yes") ?> >
                                <div class="chaty-slider round"></div>
                                Open in a new tab
                            </label>
                        </div>
                    </div>
                    <div class="chaty-separator"></div>
                    <?php $fieldValue = isset($value['close_form_after']) ? $value['close_form_after'] : "no" ?>
                    <div class="chaty-setting-col">
                        <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[close_form_after]" value="no" >
                        <label class="chaty-switch full-width" for="close_form_after_<?php echo esc_attr($social['slug']); ?>">
                            <input type="checkbox" class="chaty-close_form_after-setting" name="cht_social_<?php echo esc_attr($social['slug']); ?>[close_form_after]" id="close_form_after_<?php echo esc_attr($social['slug']); ?>" value="yes" <?php checked($fieldValue, "yes") ?> >
                            <div class="chaty-slider round"></div>
                            Close form automatically after submission
                            <span class="icon label-tooltip inline-message" data-label="Close the form automatically after a few seconds based on your choice"><span class="dashicons dashicons-editor-help"></span></span>
                        </label>
                    </div>
                    <div class="close_form_after-settings <?php echo ($fieldValue == "yes") ? "active" : "" ?>">
                        <?php $fieldValue = isset($value['close_form_after_seconds']) ? $value['close_form_after_seconds'] : "3" ?>
                        <div class="chaty-setting-col">
                            <label for="close_form_after_seconds_<?php echo esc_attr($social['slug']); ?>">Close after (Seconds)</label>
                            <div>
                                <input id="close_form_after_seconds_<?php echo esc_attr($social['slug']); ?>" type="number" name="cht_social_<?php echo esc_attr($social['slug']); ?>[close_form_after_seconds]" value="<?php echo esc_attr($fieldValue); ?>" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-field-setting-col no-margin">
                    <input type="hidden" value="no" name="cht_social_<?php echo esc_attr($social['slug']); ?>[send_leads_in_email]" >
                    <input type="hidden" value="yes" name="cht_social_<?php echo esc_attr($social['slug']); ?>[save_leads_locally]" >
                    <?php $fieldValue = isset($val['save_leads_locally']) ? $val['save_leads_locally'] : "yes" ?>
                    <div class="chaty-setting-col">
                        <label for="save_leads_locally_<?php echo esc_attr($social['slug']); ?>" class="full-width chaty-switch">
                            <input type="checkbox" disabled id="save_leads_locally_<?php echo esc_attr($social['slug']); ?>" value="yes" name="cht_social_<?php echo esc_attr($social['slug']); ?>[save_leads_locally]" <?php checked($fieldValue, "yes") ?> >
                            <div class="chaty-slider round"></div>
                            Save leads to <a href="<?php echo admin_url("admin.php?page=chaty-contact-form-feed") ?>" target="_blank">this site</a>
                            <div class="html-tooltip top no-position">
                                <span class="dashicons dashicons-editor-help"></span>
                                <span class="tooltip-text top">Your leads will be saved in your local database, you'll be able to find them <a target="_blank" href="<?php echo admin_url("admin.php?page=chaty-contact-form-feed") ?>">here</a></span>
                            </div>
                        </label>
                    </div>
                    <?php $fieldValue = isset($value['send_leads_in_email']) ? $value['send_leads_in_email'] : "no" ?>
                    <div class="chaty-setting-col">
                        <label for="save_leads_to_email_<?php echo esc_attr($social['slug']); ?>" class="email-setting full-width chaty-switch">
                            <input class="email-setting-field" disabled type="checkbox" id="save_leads_to_email_<?php echo esc_attr($social['slug']); ?>" value="yes" name="cht_social_<?php echo esc_attr($social['slug']); ?>[send_leads_in_email]" >
                            <div class="chaty-slider round"></div>
                            Send leads to your email
                            <span class="icon label-tooltip" data-label="Get your leads by email, whenever you get a new email you'll get an email notification"><span class="dashicons dashicons-editor-help"></span></span>
                            <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>">(<?php esc_html_e('Upgrade to Pro', 'chaty');?>)</a>
                        </label>
                    </div>
                    <div class="email-settings <?php echo ($fieldValue == "yes") ? "active" : "" ?>">
                        <div class="chaty-setting-col">
                            <label for="email_for_<?php echo esc_attr($social['slug']); ?>">Email address</label>
                            <div>
                                <?php $fieldValue = isset($value['email_address']) ? $value['email_address'] : "" ?>
                                <input id="email_for_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[email_address]" value="<?php echo esc_attr($fieldValue); ?>" >
                            </div>
                        </div>
                        <div class="chaty-setting-col">
                            <label for="sender_name_for_<?php echo esc_attr($social['slug']); ?>">Sender's name</label>
                            <div>
                                <?php $fieldValue = isset($value['sender_name']) ? $value['sender_name'] : "" ?>
                                <input id="sender_name_for_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[sender_name]" value="<?php echo esc_attr($fieldValue); ?>" >
                            </div>
                        </div>
                        <div class="chaty-setting-col">
                            <label for="email_subject_for_<?php echo esc_attr($social['slug']); ?>">Email subject</label>
                            <div>
                                <?php $fieldValue = isset($value['email_subject']) ? $value['email_subject'] : "New lead from Chaty - {name} - {date} {hour}" ?>
                                <input id="email_subject_for_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[email_subject]" value="<?php echo esc_attr($fieldValue); ?>" >
                                <div class="mail-merge-tags"><span>{name}</span><span>{phone}</span><span>{email}</span><span>{date}</span><span>{hour}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($this->is_pro()) { ?>
                <div class="clear clearfix"></div>
                <div class="Whatsapp-settings advanced-settings">
                    <!-- advance setting for Whatsapp -->
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Pre Set Message <span class="icon label-tooltip inline-tooltip" data-label="Add your own pre-set message that's automatically added to the user's message. You can also use merge tags and add the URL or the title of the current visitor's page. E.g. you can add the current URL of a product to the message so you know which product the visitor is talking about when the visitor messages you"><span class="dashicons dashicons-editor-help"></span></span></label>
                        <div>
                            <?php $preSetMessage = isset($value['pre_set_message']) ? $value['pre_set_message'] : ""; ?>
                            <input id="cht_social_message_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[pre_set_message]" value="<?php echo esc_attr($preSetMessage) ?>" >
                            <span class="supported-tags"><span class="icon label-tooltip support-tooltip" data-label="{title} tag grabs the page title of the webpage">{title}</span> and  <span class="icon label-tooltip support-tooltip" data-label="{url} tag grabs the URL of the page">{url}</span> tags are supported</span>
                        </div>
                    </div>
                </div>
                <div class="Email-settings advanced-settings">
                    <!-- advance setting for Email -->
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Mail Subject <span class="icon label-tooltip inline-tooltip" data-label="Add your own pre-set message that's automatically added to the user's message. You can also use merge tags and add the URL or the title of the current visitor's page. E.g. you can add the current URL of a product to the message so you know which product the visitor is talking about when the visitor messages you"><span class="dashicons dashicons-editor-help"></span></span></label>
                        <div>
                            <?php $mailSubject = isset($value['mail_subject']) ? $value['mail_subject'] : ""; ?>
                            <input id="cht_social_message_<?php echo esc_attr($social['slug']); ?>" type="text" name="cht_social_<?php echo esc_attr($social['slug']); ?>[mail_subject]" value="<?php echo esc_attr($mailSubject) ?>" >
                            <span class="supported-tags"><span class="icon label-tooltip support-tooltip" data-label="{title} tag grabs the page title of the webpage">{title}</span> and  <span class="icon label-tooltip support-tooltip" data-label="{url} tag grabs the URL of the page">{url}</span> tags are supported</span>
                        </div>
                    </div>
                </div>
                <div class="WeChat-settings advanced-settings">
                    <!-- advance setting for WeChat -->
                    <?php
                    $qrCode = isset($value['qr_code']) ? $value['qr_code'] : "";
                    // Initialize QR code value if not exists. 2.1.0 change
                    $imageUrl = "";
                    $status   = 0;
                    if ($qrCode != "") {
                        $imageUrl = wp_get_attachment_image_src($qrCode, "full")[0];
                        // get custom Image URL if exists
                    }

                    if ($imageUrl == "") {
                        $imageUrl = plugin_dir_url("")."chaty/admin/assets/images/chaty-default.png";
                        // Initialize with default image URL if URL is not exists
                    } else {
                        $status = 1;
                    }
                    ?>
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Upload QR Code</label>
                        <div>
                            <!-- Button to upload QR Code image -->
                            <a class="cht-upload-image <?php echo esc_attr(($status) ? "active" : "") ?>" id="upload_qr_code" href="javascript:;" onclick="upload_qr_code('<?php echo esc_attr($social['slug']); ?>')">
                                <img id="cht_social_image_src_<?php echo esc_attr($social['slug']); ?>" src="<?php echo esc_url($imageUrl) ?>" alt="<?php echo esc_attr($value['title']) ?>">
                                <span class="dashicons dashicons-upload"></span>
                            </a>

                            <!-- Button to remove QR Code image -->
                            <a href="javascript:;" class="remove-qr-code remove-qr-code-<?php echo esc_attr($social['slug']); ?> <?php echo esc_attr(($status) ? "active" : "") ?>" onclick="remove_qr_code('<?php echo esc_attr($social['slug']); ?>')"><span class="dashicons dashicons-no-alt"></span></a>

                            <!-- input hidden field for QR Code -->
                            <input id="upload_qr_code_val-<?php echo esc_attr($social['slug']); ?>" type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[qr_code]" value="<?php echo esc_attr($qrCode) ?>" >
                        </div>
                    </div>
                </div>
                <div class="Link-settings Custom_Link-settings Custom_Link_3-settings Custom_Link_4-settings Custom_Link_5-settings advanced-settings">
                    <?php $isChecked = (!isset($value['new_window']) || $value['new_window'] == 1) ? 1 : 0; ?>
                    <!-- Advance setting for Custom Link -->
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label >Open In a New Tab</label>
                        <div>
                            <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[new_window]" value="0" >
                            <label class="channels__view" for="cht_social_window_<?php echo esc_attr($social['slug']); ?>">
                                <input id="cht_social_window_<?php echo esc_attr($social['slug']); ?>" type="checkbox" class="channels__view-check" name="cht_social_<?php echo esc_attr($social['slug']); ?>[new_window]" value="1" <?php checked($isChecked, 1) ?> >
                                <span class="channels__view-txt">&nbsp;</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="Linkedin-settings advanced-settings">
                    <?php $isChecked = isset($value['link_type']) ? $value['link_type'] : "personal"; ?>
                    <!-- Advance setting for Custom Link -->
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label >LinkedIn</label>
                        <div>
                            <label>
                                <input type="radio" <?php checked($isChecked, "personal") ?> name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_type]" value="personal">
                                Personal
                            </label>
                            <label>
                                <input type="radio" <?php checked($isChecked, "company") ?> name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_type]" value="company">
                                Company
                            </label>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="clear clearfix"></div>
                <div class="Whatsapp-settings advanced-settings">
                    <?php $preSetMessage = isset($value['pre_set_message']) ? $value['pre_set_message'] : ""; ?>
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Pre Set Message <span class="icon label-tooltip inline-tooltip" data-label="Add your own pre-set message that's automatically added to the user's message. You can also use merge tags and add the URL or the title of the current visitor's page. E.g. you can add the current URL of a product to the message so you know which product the visitor is talking about when the visitor messages you"><span class="dashicons dashicons-editor-help"></span></span></label>
                        <div>
                            <div class="pro-features">
                                <div class="pro-item">
                                    <div class="pre-message-whatsapp">
                                        <input disabled id="cht_social_message_<?php echo esc_attr($social['slug']); ?>" type="text" name="" value="<?php echo esc_attr($preSetMessage) ?>" >
                                        <span class="supported-tags"><span class="icon label-tooltip support-tooltip" data-label="{title} tag grabs the page title of the webpage">{title}</span> and  <span class="icon label-tooltip support-tooltip" data-label="{url} tag grabs the URL of the page">{url}</span> tags are supported</span>
                                        <button data-button="cht_social_message_<?php echo esc_attr($social['slug']); ?>" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0m0 22C6.486 22 2 17.514 2 12S6.486 2 12 2s10 4.486 10 10-4.486 10-10 10"></path><path d="M8 7a2 2 0 1 0-.001 3.999A2 2 0 0 0 8 7M16 7a2 2 0 1 0-.001 3.999A2 2 0 0 0 16 7M15.232 15c-.693 1.195-1.87 2-3.349 2-1.477 0-2.655-.805-3.347-2H15m3-2H6a6 6 0 1 0 12 0"></path></svg></button>
                                    </div>
                                </div>
                                <div class="pro-button">
                                    <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>"><?php esc_html_e('Upgrade to Pro', 'chaty');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Email-settings advanced-settings">
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Mail Subject <span class="icon label-tooltip inline-tooltip" data-label="Add your own pre-set message that's automatically added to the user's message. You can also use merge tags and add the URL or the title of the current visitor's page. E.g. you can add the current URL of a product to the message so you know which product the visitor is talking about when the visitor messages you"><span class="dashicons dashicons-editor-help"></span></span></label>
                        <div>
                            <div class="pro-features">
                                <div class="pro-item">
                                    <input disabled id="cht_social_message_<?php echo esc_attr($social['slug']); ?>" type="text" name="" value="" >
                                    <span class="supported-tags"><span class="icon label-tooltip support-tooltip" data-label="{title} tag grabs the page title of the webpage">{title}</span> and  <span class="icon label-tooltip support-tooltip" data-label="{url} tag grabs the URL of the page">{url}</span> tags are supported</span>
                                </div>
                                <div class="pro-button">
                                    <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>"><?php esc_html_e('Upgrade to Pro', 'chaty');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="WeChat-settings advanced-settings">
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label>Upload QR Code</label>
                        <div>
                            <a target="_blank" class="cht-upload-image-pro" id="upload_qr_code" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>" >
                                <span class="dashicons dashicons-upload"></span>
                            </a>
                            <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl());?>"><?php esc_html_e('Upgrade to Pro', 'chaty');?></a>
                        </div>
                    </div>
                </div>
                <div class="Link-settings Custom_Link-settings Custom_Link_3-settings Custom_Link_4-settings Custom_Link_5-settings advanced-settings">
                    <?php $isChecked = 1; ?>
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label >Open In a New Tab</label>
                        <div>
                            <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[new_window]" value="0" >
                            <label class="channels__view" for="cht_social_window_<?php echo esc_attr($social['slug']); ?>">
                                <input id="cht_social_window_<?php echo esc_attr($social['slug']); ?>" type="checkbox" class="channels__view-check" name="cht_social_<?php echo esc_attr($social['slug']); ?>[new_window]" value="1" checked >
                                <span class="channels__view-txt">&nbsp;</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="Linkedin-settings advanced-settings">
                    <?php $isChecked = "personal"; ?>
                    <!-- Advance setting for Custom Link -->
                    <div class="clear clearfix"></div>
                    <div class="chaty-setting-col">
                        <label >LinkedIn</label>
                        <div>
                            <label>
                                <input type="radio" <?php checked($isChecked, "personal") ?> name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_type]" value="personal">
                                Personal
                            </label>
                            <label>
                                <input type="radio" <?php checked($isChecked, "company") ?> name="cht_social_<?php echo esc_attr($social['slug']); ?>[link_type]" value="company">
                                Company
                            </label>
                        </div>
                    </div>
                </div>
            <?php }//end if
            ?>

            <?php $useWhatsappWeb = isset($value['use_whatsapp_web']) ? $value['use_whatsapp_web'] : "yes"; ?>
            <div class="Whatsapp-settings advanced-settings">
                <div class="clear clearfix"></div>
                <div class="chaty-setting-col">
                    <label>Whatsapp Web</label>
                    <input type="hidden" name="cht_social_<?php echo esc_attr($social['slug']); ?>[use_whatsapp_web]" value="no" />
                    <div>
                        <div class="checkbox">
                            <label for="cht_social_<?php echo esc_attr($social['slug']); ?>_use_whatsapp_web" class="chaty-checkbox">
                                <input class="sr-only" type="checkbox" id="cht_social_<?php echo esc_attr($social['slug']); ?>_use_whatsapp_web" name="cht_social_<?php echo esc_attr($social['slug']); ?>[use_whatsapp_web]" value="yes" <?php echo checked($useWhatsappWeb, "yes") ?> />
                                <span></span>
                                Use Whatsapp Web directly on desktop
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!in_array($social['slug'], ["Contact_Us", "Link", "Custom_Link", "Custom_Link_3", "Custom_Link_4", "Custom_Link_5", "Custom_Link_6"])) { ?>
            <div class="agent-button">
                <button type="button" class="agent-button-action" data-slug="<?php echo esc_attr($social['slug']); ?>"><span class="dashicons dashicons-plus-alt"></span> <?php esc_html_e("Add Agents", "chaty"); ?></button>
            </div>
        <?php } ?>
        <!-- advance setting fields: end -->


        <!-- remove social media setting button: start -->
        <button type="button" class="btn-cancel" data-social="<?php echo esc_attr($social['slug']); ?>">
            <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(2.26764 0.0615997) rotate(45)" fill="white"/>
                <rect width="15.6301" height="2.24494" rx="1.12247" transform="translate(13.3198 1.649) rotate(135)" fill="white"/>
            </svg>
        </button>
        <!-- remove social media setting button: end -->
    </div>
</li>
<!-- Social media setting box: end -->