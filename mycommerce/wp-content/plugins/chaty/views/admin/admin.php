<?php
/**
 * Admin Chaty Settings
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

if (defined('ABSPATH') === false) {
    exit;
}


$isPro = $this->is_pro();
if (!$isPro) {
    if (get_option('cht_position') == 'custom') {
        update_option('cht_position', 'right');
    }

    $social = get_option('cht_numb_slug');
    $social = explode(",", $social);
    $social = array_splice($social, 0, 3);
    $social = implode(',', $social);
    update_option('cht_numb_slug', $social);
    if (get_option('cht_custom_color') != '') {
        update_option('cht_custom_color', '');
        update_option('cht_color', '#A886CD');
    }
}

$chtLicenseKey = get_option('cht_license_key');
$proClass      = (!$isPro && $chtLicenseKey !== "") ? "none_pro" : "";
?>
<h2></h2>
<div class="container <?php echo esc_attr($proClass) ?>" dir="ltr" id="chaty-container">
    <header class="header">
        <img src="<?php echo esc_url(CHT_PLUGIN_URL.'admin/assets/images/logo.svg'); ?>" alt="Chaty" class="logo">
        <?php settings_errors(); ?>
        <div class="ml-auto">
            <a class="btn-white" href="<?php echo esc_url(admin_url("admin.php?page=chaty-upgrade")) ?>">
                <?php esc_html_e('Create New Widget', 'chaty'); ?>
            </a>
            <a target="_blank" class="btn-red" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
                <?php esc_html_e('Upgrade Now', 'chaty'); ?>
                <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.4674 7.42523L11.8646 0.128021C11.7548 0.128021 11.6449 0 11.4252 0C11.3154 0 11.0956 0 10.9858 0.128021L9.44777 1.92032C9.22806 2.17636 9.22806 2.56042 9.33791 2.81647L11.7548 6.017H0.549289C0.219716 6.017 0 6.27304 0 6.6571V9.21753C0 9.60159 0.219716 9.85763 0.549289 9.85763H11.8646L9.44777 13.0582C9.22806 13.3142 9.22806 13.6983 9.44777 13.9543L11.0956 15.6186C11.2055 15.7466 11.3154 15.7466 11.4252 15.7466C11.5351 15.7466 11.7548 15.6186 11.8646 15.4906L17.4674 8.19336C17.5772 8.06534 17.5772 7.68127 17.4674 7.42523Z" transform="translate(0.701416 18.3653) rotate(-90)" fill="white"/>
                </svg>
            </a>
        </div>
    </header>

    <main class="main">
        <form id="cht-form" action="options.php" method="POST" enctype="multipart/form-data">
            <?php settings_fields($this->pluginSlug); ?>
            <div id="chaty-header"></div>
            <div class="chaty-header">
                <ul class="chaty-app-tabs">
                    <li>
                        <a href="javascript:;" class="chaty-tab <?php echo ($step == 1) ? "active" : "completed" ?>" data-tab-id="chaty-tab-social-channel" id="chaty-social-channel" data-tab="first" data-tab-index="">
                            <span class="chaty-tabs-heading">Step 1</span>
                            <span class="chaty-tabs-subheading">Choose your chat channels</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="chaty-tab <?php echo ($step == 2) ? "active" : (($step == 3) ? "completed" : "") ?>" data-tab-id="chaty-tab-customize-widget" id="chaty-app-customize-widget" data-tab-index="" data-tab="middle" data-forced-save="yes">
                            <span class="chaty-tabs-heading">Step 2</span>
                            <span class="chaty-tabs-subheading">Customize social widget launcher</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="chaty-tab <?php echo ($step == 3) ? "active" : "" ?>" data-tab-id="chaty-tab-triger-targeting" id="chaty-triger-targeting" data-tab="last" data-tab-index="" data-forced-save="yes">
                            <span class="chaty-tabs-heading">Step 3</span>
                            <span class="chaty-tabs-subheading">Triggers and targeting</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="chaty-header-sticky"></div>

            <svg class="read-only" aria-hidden="true" width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="linear-gradient" x1="0.892" y1="0.192" x2="0.128" y2="0.85" gradientUnits="objectBoundingBox">
                        <stop offset="0" stop-color="#4a64d5"></stop>
                        <stop offset="0.322" stop-color="#9737bd"></stop>
                        <stop offset="0.636" stop-color="#f15540"></stop>
                        <stop offset="1" stop-color="#fecc69"></stop>
                    </linearGradient>
                </defs>
                <circle class="color-element" cx="19.5" cy="19.5" r="19.5" fill="url(#linear-gradient)"></circle>
                <path id="Path_1923" data-name="Path 1923" d="M13.177,0H5.022A5.028,5.028,0,0,0,0,5.022v8.155A5.028,5.028,0,0,0,5.022,18.2h8.155A5.028,5.028,0,0,0,18.2,13.177V5.022A5.028,5.028,0,0,0,13.177,0Zm3.408,13.177a3.412,3.412,0,0,1-3.408,3.408H5.022a3.411,3.411,0,0,1-3.408-3.408V5.022A3.412,3.412,0,0,1,5.022,1.615h8.155a3.412,3.412,0,0,1,3.408,3.408v8.155Z" transform="translate(10 10.4)" fill="#fff"></path>
                <path id="Path_1924" data-name="Path 1924" d="M45.658,40.97a4.689,4.689,0,1,0,4.69,4.69A4.695,4.695,0,0,0,45.658,40.97Zm0,7.764a3.075,3.075,0,1,1,3.075-3.075A3.078,3.078,0,0,1,45.658,48.734Z" transform="translate(-26.558 -26.159)" fill="#fff"></path>
                <path id="Path_1925" data-name="Path 1925" d="M120.105,28.251a1.183,1.183,0,1,0,.838.347A1.189,1.189,0,0,0,120.105,28.251Z" transform="translate(-96.119 -14.809)" fill="#fff"></path>
            </svg>
            <div class="preview-section-overlay"></div>
            <div class="preview-section-chaty  wrap">
                <svg class="read-only" aria-hidden="true" width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="linear-gradient" x1="0.892" y1="0.192" x2="0.128" y2="0.85" gradientUnits="objectBoundingBox">
                            <stop offset="0" stop-color="#4a64d5"></stop>
                            <stop offset="0.322" stop-color="#9737bd"></stop>
                            <stop offset="0.636" stop-color="#f15540"></stop>
                            <stop offset="1" stop-color="#fecc69"></stop>
                        </linearGradient>
                    </defs>
                    <circle class="color-element" cx="19.5" cy="19.5" r="19.5" fill="url(#linear-gradient)"></circle>
                    <path id="Path_1923" data-name="Path 1923" d="M13.177,0H5.022A5.028,5.028,0,0,0,0,5.022v8.155A5.028,5.028,0,0,0,5.022,18.2h8.155A5.028,5.028,0,0,0,18.2,13.177V5.022A5.028,5.028,0,0,0,13.177,0Zm3.408,13.177a3.412,3.412,0,0,1-3.408,3.408H5.022a3.411,3.411,0,0,1-3.408-3.408V5.022A3.412,3.412,0,0,1,5.022,1.615h8.155a3.412,3.412,0,0,1,3.408,3.408v8.155Z" transform="translate(10 10.4)" fill="#fff"></path>
                    <path id="Path_1924" data-name="Path 1924" d="M45.658,40.97a4.689,4.689,0,1,0,4.69,4.69A4.695,4.695,0,0,0,45.658,40.97Zm0,7.764a3.075,3.075,0,1,1,3.075-3.075A3.078,3.078,0,0,1,45.658,48.734Z" transform="translate(-26.558 -26.159)" fill="#fff"></path>
                    <path id="Path_1925" data-name="Path 1925" d="M120.105,28.251a1.183,1.183,0,1,0,.838.347A1.189,1.189,0,0,0,120.105,28.251Z" transform="translate(-96.119 -14.809)" fill="#fff"></path>
                </svg>
                <div class="preview" id="admin-preview">
                    <div class="h2"><span class="header-tooltip"><span class="header-tooltip-text">Please make all your live tests in <a href="https://www.computerworld.com/article/3356840/how-to-go-incognito-in-chrome-firefox-safari-and-edge.html" target="_blank">incognito mode</a>. Some of the features like call to action, attention effect, and trigger will appear for your website visitors just once until they engage with the chat widget, so to emulate it you'll need to use incognito mode</span> <span class="dashicons dashicons-editor-help"></span></span><?php echo esc_attr('Preview', 'chaty'); ?>:</div>

                    <div class="page">
                        <div class="page-header">
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <svg width="33" height="38" viewBox="0 0 33 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d)">
                                    <ellipse cx="0.855225" cy="0.745508" rx="0.855225" ry="0.745508" transform="translate(15.6492 13.0053) scale(1 -1)" fill="#828282"/>
                                </g>
                                <g filter="url(#filter1_d)">
                                    <ellipse cx="0.855225" cy="0.745508" rx="0.855225" ry="0.745508" transform="translate(15.6492 15.6891) scale(1 -1)" fill="#828282"/>
                                </g>
                                <g filter="url(#filter2_d)">
                                    <ellipse cx="0.855225" cy="0.745508" rx="0.855225" ry="0.745508" transform="translate(15.6492 18.373) scale(1 -1)" fill="#828282"/>
                                </g>
                                <defs>
                                    <filter id="filter0_d" x="0.64917" y="0.514328" width="31.7105" height="31.491" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 255 0"/>
                                        <feOffset dy="4"/>
                                        <feGaussianBlur stdDeviation="7.5"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                                    </filter>
                                    <filter id="filter1_d" x="0.64917" y="3.1981" width="31.7105" height="31.491" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 255 0"/>
                                        <feOffset dy="4"/>
                                        <feGaussianBlur stdDeviation="7.5"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                                    </filter>
                                    <filter id="filter2_d" x="0.64917" y="5.88202" width="31.7105" height="31.491" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 255 0"/>
                                        <feOffset dy="4"/>
                                        <feGaussianBlur stdDeviation="7.5"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                                    </filter>
                                </defs>
                            </svg>
                        </div>


                        <?php $position = $this->get_position_style(); ?>
                        <div class="page-body">
                            <div class="chaty-preview">

                            </div>
                        </div>
                    </div>
                    <div class="switch-preview">
                        <input data-gramm_editor="false" type="radio" id="previewDesktop" name="switchPreview" class="js-switch-preview switch-preview__input" checked="checked">
                        <label for="previewDesktop" class="switch-preview__label switch-preview__desktop">
                            <?php esc_html_e('Desktop', 'chaty'); ?>
                        </label>
                        <input data-gramm_editor="false" type="radio" id="previewMobile" name="switchPreview" class="js-switch-preview switch-preview__input">
                        <label for="previewMobile" class="switch-preview__label switch-preview__mobile">
                            <?php esc_html_e('Mobile', 'chaty'); ?>
                        </label>
                    </div>
                </div>
            </div>

            <!--/* Social channel list section */-->
            <div id="chaty-tab-social-channel" class="social-channel-tabs <?php echo ($step == 1) ? "active" : "" ?>">
                <?php require_once 'channels-section.php'; ?>
            </div>

            <!--/* Customize widget section */-->
            <div id="chaty-tab-customize-widget" class="social-channel-tabs <?php echo ($step == 2) ? "active" : "" ?>">
                <?php require_once 'customize-widget-section.php'; ?>
            </div>

            <!--/* Customize widget section */-->
            <div id="chaty-tab-triger-targeting" class="social-channel-tabs <?php echo ($step == 3) ? "active" : "" ?>">
                <?php require_once 'trigger-and-target.php'; ?>

                <!--/* Widget launch section */-->
                <?php require_once 'launch-section.php'; ?>

                <!--/* form submit button */-->
                <?php
                // submit_button(null, null, null, false); ?>
            </div>

            <div class="footer-buttons step-<?php echo esc_attr($step) ?>">
                <button type="button" class="back-button" id="back-button"><?php esc_html_e('Back', 'chaty'); ?></button>
                <button type="button" class="next-button" id="next-button"><?php esc_html_e('Next', 'chaty'); ?></button>
                <input type="submit" class="save-button" id="save-button" name="save_button" value="<?php esc_html_e('Save', 'chaty'); ?>" />
                <input type="submit" class="save-dashboard-button" id="save-dashboard-button" name="save_and_view_dashboard" value="<?php esc_html_e('Save & View Dashboard', 'chaty'); ?>" />
                <input type="hidden" name="current_step" value="<?php echo esc_attr($step) ?>" id="current_step">
            </div>
        </form>
    </main>

    <?php require_once 'help.php'; ?>
</div>
<?php require_once 'popup.php';
