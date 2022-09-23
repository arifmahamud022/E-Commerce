<?php
/**
 * Chaty Popups for widget and contact form lead
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

if (defined('ABSPATH') === false) {
    exit;
}
?>
<section class="section section2" xmlns="http://www.w3.org/1999/html">
    <h1 class="section-title">
        <strong><?php esc_html_e('Step', 'chaty');?> 2:</strong> <?php esc_html_e('Customize your widget', 'chaty');?>
    </h1>
    <?php $class = count($this->socials) > 1 ? "active" : ""; ?>
    <div class="form-horizontal">
        <?php
        $color = $this->get_current_color();
        $color = empty($color) ? '#A886CD' : $color;
        ?>
        <div class="form-horizontal__item o-channel <?php echo esc_attr($class) ?>">
            <label class="align-top form-horizontal__item-label"><?php esc_html_e('Color', 'chaty'); ?>:</label>
            <div>
                <div class="color-picker-dropdown">
                    <div class="color-picker-box">
                        <div class="color-picker-radio">
                            <label style="background-color: #A886CD">
                                <input type="checkbox" name="cht_color" value="#A886CD" title="Purple" <?php checked($color, '#A886CD') ?> >
                                <span></span>
                            </label>

                            <label style="background-color: #86CD91">
                                <input type="checkbox" name="cht_color" value="#86CD91" title="Green" <?php checked($color, '#86CD91') ?>  />
                                <span></span>
                            </label>

                            <label style="background-color: #4F6ACA">
                                <input type="checkbox" name="cht_color" value="#4F6ACA" title="Blue" <?php checked($color, '#4F6ACA') ?> />
                                <span></span>
                            </label>

                            <label style="background-color: #FF6060">
                                <input type="checkbox" name="cht_color" value="#FF6060" title="Red" <?php checked($color, '#FF6060') ?>  >
                                <span></span>
                            </label>

                            <label style="background-color: #000">
                                <input type="checkbox" name="cht_color" value="#000" title="Black" <?php checked($color, '#000') ?>  >
                                <span></span>
                            </label>

                            <label style="background-color: #EEF075">
                                <input type="checkbox" name="cht_color" value="#EEF075" title="Yellow" <?php checked($color, '#EEF075') ?>  >
                                <span></span>
                            </label>

                            <label style="background-color: #FF95EE">
                                <input type="checkbox" name="cht_color" value="#FF95EE" title="Pink" <?php checked($color, '#FF95EE') ?> >
                                <span></span>
                            </label>
                        </div>

                        <div class="color-picker-custom">
                            <?php if ($this->is_pro()) : ?>
                                <div>
                                    <?php
                                    $os = [
                                        "#86CD91",
                                        "#A886CD",
                                        "#4F6ACA",
                                        "#FF6060",
                                        "#000",
                                        "#EEF075",
                                        "#FF95EE",
                                    ];
                                    if (in_array($color, $os)) {
                                        $color = '';
                                    }
                                    ?>
                                    <?php if ($color) : ?>
                                        <div class="circle" style="background-color: <?php echo esc_attr($color); ?> "></div>
                                        <?php esc_html_e('Custom color', 'chaty'); ?>
                                    <?php else : ?>
                                        <div class="circle">?</div><?php esc_html_e('Custom color', 'chaty'); ?>
                                    <?php endif ?>
                                </div>
                                <div>
                                    <input type="input" name="cht_custom_color" placeholder="HEX code: #ffffff" value="<?php echo esc_attr($color); ?>" />
                                    <button class="btn-red">Ok</button>
                                </div>
                            <?php else : ?>
                                <div>
                                    <div class="circle">?</div>
                                    <?php esc_html_e('Custom color', 'chaty'); ?>
                                    <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
                                        (<?php esc_html_e('Upgrade to Pro', 'chaty'); ?>)
                                    </a>
                                </div>
                                <div>
                                    <input type="input" name="cht_custom_colo" placeholder="HEX code: #ffffff" value="" readonly style="cursor:not-allowed;width: 172px;" />
                                    <button class="btn-red"><?php esc_html_e('Ok', 'chaty'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php $color = $this->get_current_color(); ?>
                        <button class="color-picker-btn-close">
                            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0L4.31505 3.77708L8.63008 0" transform="translate(1.37436 1.31006)" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M0 0L4.31505 3.77708L8.63008 0" transform="translate(1.37436 1.31006)" stroke="#4F4F4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <button class="color-picker-btn">
                        <?php $color = !empty($color) ? $color : '#A886CD'; ?>
                        <span class="circle" style="background-color: <?php echo esc_attr($color) ?>"></span>
                        <span class="text">
                            <?php
                            if (!empty($color)) {
                                $colors = $this->colors;
                                if (isset($colors[$color])) {
                                    echo esc_attr($colors[$color]);
                                } else {
                                    esc_html_e('Custom', 'chaty');
                                }
                            } else {
                                esc_html_e('Purple', 'chaty');
                            }
                            ?>
                        </span>
                        <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0L4.31505 3.77708L8.63008 0" transform="translate(1.37436 1.31006)" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M0 0L4.31505 3.77708L8.63008 0" transform="translate(1.37436 1.31006)" stroke="#4F4F4F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-horizontal__item">
            <label class="align-top form-horizontal__item-label">Position:</label>
            <div>
                <?php
                $position = get_option('cht_position');
                $position = ($position != "left" && $position != "right") ? "right" : $position;
                ?>
                <label class="custom-control custom-radio" for="left-position">
                    <input type="radio" id="left-position" name="cht_position" class="custom-control-input" <?php checked($position, "left") ?> value="left" />
                    <span class="custom-control-label"><?php esc_html_e('Left', 'chaty'); ?></span>
                </label>

                <label class="custom-control custom-radio" for="right-position">
                    <input type="radio" id="right-position" name="cht_position" class="custom-control-input" <?php checked($position, "right") ?> value="right" />
                    <span class="custom-control-label"><?php esc_html_e('Right', 'chaty'); ?></span>
                </label>

                <?php if ($this->is_pro()) : ?>
                    <label class="custom-control custom-radio" for="positionCustom">
                        <input type="radio" id="positionCustom" name="cht_position" class="custom-control-input position-pro-radio" <?php checked($position, "custom") ?>  value="custom" />
                        <span class="custom-control-label">
                            <?php esc_html_e('Custom', 'chaty'); ?>
                        </span>
                    </label>
                <?php else : ?>
                    <span class="custom-control custom-radio free-custom-radio" style="pointer-events: none">
                        <input type="radio" class="custom-control-input" disabled>
                        <span class="custom-control-label"><?php esc_html_e('Custom Position', 'chaty'); ?> </span>
                    </span>
                    <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">(<?php esc_html_e('Upgrade to Pro', 'chaty'); ?>)</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-horizontal__item">
            <label class="align-top form-horizontal__item-label"><?php esc_html_e('Call to action', 'chaty'); ?>:</label>
            <div class="disable-message" data-label='When the default state is set to "Opened by default", the "Call to action" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <script type="text/javascript">
                    var keynum, lines = 1;
                    function limitLines(obj, e) {
                        // IE
                        if (window.event) {
                            keynum = e.keyCode;
                            // Netscape/Firefox/Opera
                        } else if (e.which) {
                            keynum = e.which;
                        }
                        if (keynum == 13) {
                            var text = jQuery(".test_textarea").val();
                            var lines = text.split(/\r|\r\n|\n/);
                            var count = lines.length;
                            console.log(count); // Outputs 4
                            if (count >= obj.rows) {
                                return false;
                            } else {
                                lines++;
                            }
                        }
                    }
                </script>
                <?php
                $cta = get_option('cht_cta');
                // $cta = str_replace(array("\r","\n"),"",$cta);
                ?>
                <textarea type="text" data-gramm_editor="false" data-value="<?php echo esc_attr($cta) ?>" class="test_textarea" cols="40" rows="2" name="cht_cta" value="<?php echo esc_attr(wp_unslash($cta)) ?>" placeholder="<?php esc_html_e('Message us!', 'chaty'); ?>" onkeydown="return limitLines(this, event)"><?php echo esc_attr($cta) ?></textarea>
            </div>
        </div>

        <div class="color-setting">
            <div class="color-box">
                <div class="clr-setting">
                    <?php
                    $val = get_option("cht_cta_text_color");
                    $val = ($val === false) ? "#333333" : $val;
                    ?>
                    <div class="form-horizontal__item flex-center">
                        <label class="form-horizontal__item-label"><?php esc_html_e('Call to action text color', 'chaty');?>:</label>
                        <div class="disable-message" data-label='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                            <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_cta_text_color" id="cht_cta_text_color">
                        </div>
                    </div>
                </div>
                <div class="clr-setting">
                    <?php
                    $val = get_option("cht_cta_bg_color");
                    $val = ($val === false) ? "#ffffff" : $val;
                    ?>
                    <div class="form-horizontal__item flex-center">
                        <label class="form-horizontal__item-label"><?php esc_html_e('Call to action background', 'chaty');?>:</label>
                        <div class="disable-message" data-label='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                            <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_cta_bg_color" id="cht_cta_bg_color">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-horizontal__item flex-center">
            <label class="align-top form-horizontal__item-label">
                <span class="header-tooltip">
                    <span class="header-tooltip-text text-center">Choose how the CTA button would appear. &quot;Hide after first click&quot; hides the CTA button after the first visit. If you select the second option, the CTA stays visible all the time</span>
                    <span class="dashicons dashicons-editor-help"></span>
                </span>
                <?php esc_html_e('Call to action behavior', 'chaty'); ?>:
            </label>
            <div class="cta-action-radio">
                <?php
                $ctaAction = get_option('cht_cta_action');
                $ctaAction = empty($ctaAction) ? "click" : $ctaAction;
                ?>
                <div class=" disable-message" data-label='When the default state is set to "Opened by default", the "Show call to action" feature doesn&apos;t apply because the Chaty widget is already open.' for="all_time-cht_cta_action">
                    <label class="custom-control custom-radio">
                        <input type="radio" id="click-cht_cta_action" name="cht_cta_action" class="custom-control-input" <?php checked($ctaAction, "click") ?> value="click" />
                        <span class="custom-control-label"><?php esc_html_e('Hide after first click', 'chaty'); ?></span>
                    </label>
                </div>
                <div class=" disable-message" data-label='When the default state is set to "Opened by default", the "Show call to action" feature doesn&apos;t apply because the Chaty widget is already open.' for="all_time-cht_cta_action">
                    <label class="custom-control custom-radio">
                        <input type="radio" id="all_time-cht_cta_action" name="cht_cta_action" class="custom-control-input" <?php checked($ctaAction, "all_time") ?> value="all_time" />
                        <span class="custom-control-label"><?php esc_html_e('Show all the time', 'chaty'); ?></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-horizontal__item flex-center">
            <label class="form-horizontal__item-label">
                <span class="header-tooltip">
                    <span class="header-tooltip-text text-center">The attention effect will appear on your site until your website visitors engage with the widget for the first time. After the first engagement, the attention effect will not appear again.</span>
                    <span class="dashicons dashicons-editor-help"></span>
                </span>
                <?php esc_html_e('Attention effect', 'chaty');?>:
            </label>
            <div class="disable-message" data-label='When the default state is set to "Opened by default", the "Attention effect" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <?php
                $group   = '';
                $effects = [
                    ""           => "None",
                    "jump"       => "Bounce",
                    "waggle"     => "Waggle",
                    "sheen"      => "Sheen",
                    "spin"       => "Spin",
                    "fade"       => "Fade",
                    "shockwave"  => "Shockwave",
                    "blink"      => "Blink",
                    "pulse-icon" => "Pulse",
                ];
                $effect  = get_option('chaty_attention_effect');
                $effect  = empty($effect) ? "" : $effect;
                ?>
                <select name="chaty_attention_effect" class="chaty-select" id="chaty_attention_effect" data-effect="<?php echo esc_attr($effect) ?>">
                    <?php foreach ($effects as $key => $value) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($effect, $key); ?>><?php echo esc_attr($value); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>


        <div class="form-horizontal__item flex-center">
            <label class="form-horizontal__item-label"><span class="icon label-tooltip" data-label="Increase your click-rate by displting a pending messages icon near your Chaty widget to let your visitors know that you're waiting for them to contact you."><span class="dashicons dashicons-editor-help"></span></span> <?php esc_html_e('Pending messages', 'chaty');?>:</label>
            <div class="disable-message" data-label='When the default state is set to "Opened by default", the "Pending messages" feature doesn&apos;t apply because the Chaty widget is already open.'>
                <label class="switch">
                    <?php
                    $checked     = get_option('cht_pending_messages');
                    $checked     = empty($checked) ? "off" : $checked;
                    $activeClass = ($checked == "on") ? "active" : "";
                    ?>
                    <span class="switch__label"><?php esc_html_e('Off', 'chaty');?></span>
                    <input type="hidden" name="cht_pending_messages" value="off">
                    <input type="checkbox" id="cht_pending_messages" name="cht_pending_messages" value="on" <?php checked($checked, "on") ?> >
                    <span class="switch__styled"></span>
                    <span class="switch__label"><?php esc_html_e('On', 'chaty');?></span>
                </label>
            </div>
        </div>
        <?php
        $val = get_option("cht_number_of_messages");
        $val = ($val === false || empty($val)) ? "1" : $val;
        ?>

        <div class="form-horizontal__item flex-center pending-message-items <?php echo esc_attr($activeClass) ?>">
            <label class="form-horizontal__item-label"><?php esc_html_e('Number of messages', 'chaty');?>:</label>
            <div>
                <input value="<?php echo esc_attr($val) ?>" type="number" class="cht-input" name="cht_number_of_messages" id="cht_number_of_messages">
            </div>
        </div>

        <?php
        $val = get_option("cht_number_color");
        $val = ($val === false || empty($val)) ? "#ffffff" : $val;
        ?>

        <div class="form-horizontal__item flex-center pending-message-items <?php echo esc_attr($activeClass) ?>">
            <label class="form-horizontal__item-label"><?php esc_html_e('Number color', 'chaty');?>:</label>
            <div>
                <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_number_color" id="cht_number_color">
            </div>
        </div>

        <?php
        $val = get_option("cht_number_bg_color");
        $val = ($val === false || empty($val)) ? "#dd0000" : $val;
        ?>
        <div class="form-horizontal__item flex-center pending-message-items <?php echo esc_attr($activeClass) ?>">
            <label class="form-horizontal__item-label"><?php esc_html_e('Background color', 'chaty');?>:</label>
            <div>
                <input value="<?php echo esc_attr($val) ?>" type="text" class="chaty-color-field" name="cht_number_bg_color" id="cht_number_bg_color">
            </div>
        </div>

        <div class="form-horizontal__item widget-icon__block o-channel <?php echo esc_attr($class) ?>">
            <label class="form-horizontal__item-label">Widget icon:</label>
            <?php
            $proClass   = $this->is_pro() ? "has-pro" : "has-free";
            $widgetIcon = get_option('widget_icon');
            ?>
            <label class="widget-icon__wrap <?php echo esc_attr($proClass)  ?>">
                <label class="custom-control custom-radio">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i " value="chat-base" data-type="chat-base" data-gramm_editor="false" <?php checked($widgetIcon, "chat-base") ?> />
                    <i class="icon-chat" data-type="chat-base">
                        <svg version="1.1" id="ch" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.7 54 54"
                             style="enable-background:new -496 507.7 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }
                                .st0 { fill: #808080; }
                            </style>
                            <g>
                                <circle cx="-469" cy="534.7" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-459.9,523.7h-20.3c-1.9,0-3.4,1.5-3.4,3.4v15.3c0,1.9,1.5,3.4,3.4,3.4h11.4l5.9,4.9c0.2,0.2,0.3,0.2,0.5,0.2 h0.3c0.3-0.2,0.5-0.5,0.5-0.8v-4.2h1.7c1.9,0,3.4-1.5,3.4-3.4v-15.3C-456.5,525.2-458,523.7-459.9,523.7z"/>
                            <path class="st0" d="M-477.7,530.5h11.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-11.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,530.8-478.2,530.5-477.7,530.5z"/>
                            <path class="st0" d="M-477.7,533.5h7.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-7.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,533.9-478.2,533.5-477.7,533.5z"/>
                        </svg>
                    </i>
                    <span class="custom-control-label"></span>
                </label>
                <?php $widgetIcon = get_option('widget_icon'); ?>
                <?php $disabled = (!$this->is_pro()) ? "disabled" : ""; ?>

                <label class="custom-control custom-radio">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-smile" data-type="chat-smile" data-gramm_editor="false" <?php checked($widgetIcon, "chat-smile") ?>  >
                    <i class="icon-chat" data-type="chat-smile">
                        <svg version="1.1" id="smile" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.8 507.1 54 54" style="enable-background:new -496.8 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }
                                .st2 { fill: none; stroke: #808080; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
                            </style>
                            <g>
                                <circle cx="-469.8" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-459.5,523.5H-482c-2.1,0-3.7,1.7-3.7,3.7v13.1c0,2.1,1.7,3.7,3.7,3.7h19.3l5.4,5.4c0.2,0.2,0.4,0.2,0.7,0.2c0.2,0,0.2,0,0.4,0c0.4-0.2,0.6-0.6,0.6-0.9v-21.5C-455.8,525.2-457.5,523.5-459.5,523.5z"/>
                            <path class="st2" d="M-476.5,537.3c2.5,1.1,8.5,2.1,13-2.7"/>
                            <path class="st2" d="M-460.8,534.5c-0.1-1.2-0.8-3.4-3.3-2.8"/>
                        </svg>
                    </i>
                    <span class="custom-control-label"></span>
                </label>


                <label class="custom-control custom-radio">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-bubble" data-type="chat-bubble" data-gramm_editor="false" <?php checked($widgetIcon, "chat-bubble") ?> />
                    <i class="icon-chat" data-type="chat-bubble">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.9 507.1 54 54" style="enable-background:new -496.9 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 { fill: #FFFFFF; }</style>
                            <g>
                                <circle cx="-469.9" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-472.6,522.1h5.3c3,0,6,1.2,8.1,3.4c2.1,2.1,3.4,5.1,3.4,8.1c0,6-4.6,11-10.6,11.5v4.4c0,0.4-0.2,0.7-0.5,0.9 c-0.2,0-0.2,0-0.4,0c-0.2,0-0.5-0.2-0.7-0.4l-4.6-5c-3,0-6-1.2-8.1-3.4s-3.4-5.1-3.4-8.1C-484.1,527.2-478.9,522.1-472.6,522.1z M-462.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-464.6,534.6-463.9,535.3-462.9,535.3z M-469.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-471.7,534.6-471,535.3-469.9,535.3z M-477,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-478.8,534.6-478.1,535.3-477,535.3z"/>
                        </svg>
                    </i>
                    <span class="custom-control-label"></span>
                </label>


                <label class="custom-control custom-radio <?php echo esc_attr(!$this->is_pro() ? "add-border" : "") ?>">
                    <input type="radio" name="widget_icon" class="custom-control-input js-widget-i" value="chat-db" data-type="chat-db" data-gramm_editor="false" <?php checked($widgetIcon, "chat-db") ?> />
                    <i class="icon-chat" data-type="chat-db">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.1 54 54" style="enable-background:new -496 507.1 54 54;" xml:space="preserve">
                            <style type="text/css">.st1 {fill: #FFFFFF;}</style>
                            <g>
                                <circle cx="-469" cy="534.1" r="27" fill="#a886cd"/>
                            </g>
                            <path class="st1" d="M-464.6,527.7h-15.6c-1.9,0-3.5,1.6-3.5,3.5v10.4c0,1.9,1.6,3.5,3.5,3.5h12.6l5,5c0.2,0.2,0.3,0.2,0.7,0.2 c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18.2C-461.1,529.3-462.7,527.7-464.6,527.7z"/>
                            <path class="st1" d="M-459.4,522.5H-475c-1.9,0-3.5,1.6-3.5,3.5h13.9c2.9,0,5.2,2.3,5.2,5.2v11.6l1.9,1.9c0.2,0.2,0.3,0.2,0.7,0.2 c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18C-455.9,524.1-457.5,522.5-459.4,522.5z"/>
                        </svg>
                    </i>
                    <span class="custom-control-label"></span>
                </label>

                <?php if (!$this->is_pro()) : ?>
                <div class="custom-control custom-radio upgrade-upload-btn">
                    <?php else : ?>
                    <label class="custom-control custom-radio" id="image-upload-content">
                        <?php endif; ?>
                        <div class="form-group" id="image-upload">
                            <div id="elPreviewImage"></div>
                            <div class="file-loading">
                                <input type="file" id="testUpload" name="cht_widget_img" <?php if (!$this->is_pro()) {
                                    echo 'disabled';
                                } ?> >
                            </div>
                            <div id="errorBlock" class="help-block"></div>
                        </div>
                        <?php if ($this->is_pro()) : ?>
                            <input type="radio" name="widget_icon" class="custom-control-input js-widget-i js-upload" value="chat-image" data-gramm_editor="false" <?php checked($widgetIcon, "chat-image") ?> <?php echo esc_attr($disabled) ?>  data-type="chat-image" id="uploadInput" >
                            <span class="custom-control-label"></span>
                        <?php endif; ?>
                        <?php if (!$this->is_pro()) : ?>
                        <span class="custom-control-label"></span>
                        <a class="upgrade-link" target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>"><?php esc_html_e('Upgrade to Pro', 'chaty'); ?></a>
                </div>
                <?php else : ?>
            </label>
            <?php endif; ?>


            <script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        $('#testUpload').fileinput({
                            showCaption: false,
                            showCancel: false,
                            showClose: false,
                            showRemove: false,
                            showUpload: false,
                            browseIcon: "<i class='icon-upload'></i>",
                            browseLabel: 'Upload',
                            browseClass: 'file-browse',
                            overwriteInitial: false,
                            initialPreviewCount: false,
                            allowedFileTypes: ['image'],
                            maxFileCount: 1,
                            initialPreviewAsData: true,
                            elPreviewImage: '#elPreviewImage',
                            initialPreview: [
                                "<?php echo esc_url($this->getCustomWidgetImg()) ?>",
                            ],
                            layoutTemplates: {
                                progress: '',
                                actionDelete: '',
                                actionZoom: '',
                                preview: ''
                            }
                        });
                    });
                }(jQuery));
            </script>
        </div>

    </div>

    <div class="form-horizontal__item font-section">
        <label class="form-horizontal__item-label">Font Family:</label>
        <div>
            <?php
            $font = get_option('cht_widget_font');
            $font = ($font === false)?"System Stack":$font;
            ?>
            <select name="cht_widget_font" class="form-fonts">
                <option value="">Select font family</option>
                <?php $group = '';
                foreach ($fonts as $key => $value):
                    if ($value != $group) {
                        echo '<optgroup label="' . $value . '">';
                        $group = $value;
                    }
                    $key_value = $key;
                    if($key == "-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif") {
                        $key_value = 'system_font';
                    }
                    ?>
                    <option data-group="<?php echo esc_attr($value); ?>" value="<?php echo esc_attr($key_value); ?>" data-type="<?php echo esc_attr($value); ?>" <?php selected($font, $key_value); ?>><?php echo esc_attr($key); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-horizontal__item">
        <label class="form-horizontal__item-label">Widget size:</label>
        <div>
            <?php
            $size = get_option('cht_widget_size');
            $size = empty($size) ? 54 : $size;
            ?>
            <input type="number" min="24" max="100" name="cht_widget_size" class="widget-size__input" data-gramm_editor="false" value="<?php echo esc_attr($size); ?>" />
            <span class="custom-control-label">px</span>
        </div>
    </div>

    <div class="form-horizontal__item flex-center">
        <input type="hidden" name="cht_google_analytics" value="0" >
        <label class="form-horizontal__item-label"><?php esc_html_e('Google Analytics', 'chaty');?>:</label>
        <div>
            <label class="switch">
                <?php
                $checked = get_option('cht_google_analytics');
                ?>
                <span class="switch__label"><?php esc_html_e('Off', 'chaty');?></span>

                <input data-gramm_editor="false" type="checkbox" name="cht_google_analytics" value="1" <?php checked($checked, 1) ?> <?php echo esc_attr($disabled) ?> >
                <span class="switch__styled"></span>
                <span class="switch__label"><?php esc_html_e('On', 'chaty');?></span>
                <?php if (!$this->is_pro()) :
                    ?><a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">(<?php esc_html_e('Upgrade to Pro', 'chaty'); ?>)</a><?php
                endif ?>
            </label>
        </div>
    </div>

    <input type="hidden" id="chaty_site_url" value="<?php echo site_url("/") ?>" >
    <?php $requestData = filter_input_array(INPUT_GET); ?>
    <?php if (isset($requestData['page']) && $requestData['page'] == "chaty-widget-settings") { ?>
        <input type="hidden" name="widget" value="new-widget" >
    <?php } else if (isset($requestData['widget']) && !empty($requestData['widget']) && is_numeric($requestData['widget']) && $requestData['widget'] > 0) { ?>
        <input type="hidden" name="widget" value="<?php echo esc_attr($requestData['widget']) ?>" >
    <?php } ?>
</section>
<div id="custom-css"></div>
