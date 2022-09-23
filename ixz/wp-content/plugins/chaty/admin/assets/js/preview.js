var previewChannelList = [];
var advanceCustomCSS = "";
jQuery(document).ready(function(){
    change_custom_preview();

    jQuery(document).on("mouseover", ".csaas.open-on-hover .csaas-i-trigger:not(.single-channel)", function () {
        if(!jQuery(this).closest(".csaas-widget").hasClass("csaas-open") && !jQuery(this).closest(".csaas-widget").hasClass("on-csaas-widget")) {
            jQuery(this).closest(".csaas-widget").addClass("on-csaas-widget");
            jQuery(this).find(".csaas-cta-main").trigger("click");
        }
    }).on("mouseleave", ".csaas.open-on-hover .csaas-i-trigger:not(.single-channel)", function () {
        if(!jQuery(this).closest(".csaas-widget").hasClass("csaas-open") ) {
            jQuery(this).closest(".csaas-widget").removeClass("on-csaas-widget")
        }
    });

    jQuery(document).on("click", ".csaas-i-trigger:not(.single-channel)", function(){
        jQuery(this).closest(".csass").removeClass("form-open");
        jQuery(this).closest(".csaas-widget").toggleClass("csaas-open");
        jQuery(".csaas-outer-forms").removeClass("active");
        jQuery(".form-open").removeClass("form-open");
        jQuery(".chaty-preview").height(234);
        jQuery(".preview .page").height(250);
    });

    jQuery(document).on("click", "#whatsapp_embedded_window_Whatsapp", function(){
        change_custom_preview();
    });

    jQuery(document).on("click", "a.csaas-whatsapp-form", function(e){
        e.preventDefault();
        // e.stopPropagation();
        var dataForm = jQuery(this).data('form');
        if(!isEmpty(dataForm)) {
            if(jQuery("#"+dataForm).length) {
                if(jQuery(this).closest(".csaas").hasClass("form-open")) {
                    jQuery("#" + dataForm).removeClass("is-active");

                    jQuery(this).closest(".csaas-widget").addClass("csaas-open");
                    jQuery(this).closest(".csaas").removeClass("form-open");
                    jQuery("#" + dataForm).removeClass("active");
                } else {

                    var widgetSize = 36;
                    var totalSize = parseInt(jQuery("#" + dataForm).height() / 2) + widgetSize + 20;
                    if (totalSize > 234) {
                        jQuery(".chaty-preview").height(totalSize + 10);
                        jQuery(".preview .page").height(totalSize + 26);
                    }

                    var buttonHtml = jQuery(this).html();
                    jQuery("#" + dataForm).addClass("is-active");

                    jQuery(this).closest(".csaas-widget").removeClass("csaas-open");
                    jQuery(this).closest(".csaas").addClass("form-open");
                    jQuery("#" + dataForm).addClass("active");

                    jQuery(this).closest(".csaas-widget").find(".open-csaas-channel").html(buttonHtml);
                }
            }
        }
    });

    jQuery(document).on("click", ".csaas-close-button, .csaas-close-agent-list", function(e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery(".csaas-outer-forms").removeClass("active");
        jQuery("#csaas-widget-0").removeClass("form-open");
        if(jQuery("#csaas-widget-0").find(".csaas-widget").hasClass("csaas-no-close-button")) {
            jQuery("#csaas-widget-0").find(".csaas-widget").addClass("csaas-open");
        }
        jQuery(".chaty-preview").height(234);
        jQuery(".preview .page").height(250);
    });

    jQuery(document).on("click", "a.csaas-qr-code-form", function(e){
        e.preventDefault();
        var dataForm = jQuery(this).data('form');
        if(!isEmpty(dataForm)) {
            if(jQuery("#"+dataForm).length) {

                var widgetSize = 40;
                var totalSize = parseInt(jQuery("#"+dataForm).height()/2) + widgetSize + 20;
                if(totalSize > 234) {
                    jQuery(".chaty-preview").height(totalSize+10);
                    jQuery(".preview .page").height(totalSize+26);
                }

                var buttonHtml = jQuery(this).html();

                jQuery(this).closest(".csaas-widget").removeClass("csaas-open");
                jQuery(this).closest(".csaas").addClass("form-open");
                jQuery("#"+dataForm).addClass("active");

                jQuery(this).closest(".csaas-widget").find(".open-csaas-channel").html(buttonHtml);
            }
        }
    });

    jQuery(document).on("click", "a.csaas-contact-us-form", function(e){
        e.preventDefault();
        // e.stopPropagation();
        var dataForm = jQuery(this).data('form');
        if(!isEmpty(dataForm)) {
            if(jQuery("#"+dataForm).length) {
                var widgetSize = 40;
                var totalSize = parseInt(jQuery("#"+dataForm).height()/2) + widgetSize + 20;

                if(totalSize > 234) {
                    jQuery(".chaty-preview").height(totalSize+10);
                    jQuery(".preview .page").height(totalSize+26);
                }

                var buttonHtml = jQuery(this).html();

                jQuery(this).closest(".csaas-widget").removeClass("csaas-open");
                jQuery(this).closest(".csaas").addClass("form-open");
                jQuery("#"+dataForm).addClass("active");
                jQuery("#"+dataForm).find(".csaas-ajax-success-message").remove();
                jQuery("#"+dataForm).find(".csaas-ajax-error-message").remove();
                jQuery("#"+dataForm).find(".has-csaas-error").removeClass("has-csaas-error");

                jQuery(this).closest(".csaas-widget").find(".open-csaas-channel").html(buttonHtml);
            }
        }
    });

    jQuery(document).on("keyup", "#cht_social_message_Contact_Us_form_title", function(){
       jQuery(".csaas-contact-form-title").text(jQuery(this).val());
    });

    jQuery(document).on("keyup", "#button_text_for_Contact_Us", function(){
       jQuery("#csaas-submit-button-0").text(jQuery(this).val());
    });

    jQuery(document).on("change", ".form-field-setting-col input[type='text']", function(){
        change_custom_preview();
    });

    jQuery(document).on("click", ".form-field-setting-col input[type='checkbox']", function(){
        change_custom_preview();
    });

    jQuery(document).on("change", ".chaty-agent-name, #chaty_default_state, #chaty_icons_view", function(){
        change_custom_preview();
    });

    jQuery(document).on("keyup", "input[name='cht_close_button_text']", function(){
        change_custom_preview();
    });

    jQuery(document).on("change", "input[name='cht_close_button_text']", function(){
        change_custom_preview();
    });

    jQuery(document).on("click", ".chaty-preview input, .chaty-preview button", function(e){
        e.preventDefault();
    });

    jQuery(document).on("click", ".csaas-channel.csaas-agent-button", function(e){
        e.preventDefault();
        // e.stopPropagation();
        var dataForm = jQuery(this).data('form');
        if(!isEmpty(dataForm)) {
            if(jQuery("#"+dataForm).length) {
                if(jQuery(this).closest(".csaas").hasClass("form-open")) {
                    jQuery(this).closest(".csaas-widget").addClass("csaas-open");
                    jQuery(this).closest(".csaas").removeClass("form-open");
                    jQuery("#" + dataForm).removeClass("active");
                } else {
                    var widgetSize = 40;
                    var totalSize = parseInt(jQuery("#" + dataForm).height() / 2) + widgetSize + 20;
                    if (totalSize > 234) {
                        jQuery(".chaty-preview").height(totalSize + 10);
                        jQuery(".preview .page").height(totalSize + 26);
                    }

                    var buttonHtml = jQuery(this).html();
                    jQuery("#" + dataForm).addClass("is-active");

                    jQuery(this).closest(".csaas-widget").removeClass("csaas-open");
                    jQuery(this).closest(".csaas").addClass("form-open");
                    jQuery("#" + dataForm).addClass("active");

                    jQuery(this).closest(".csaas-widget").find(".open-csaas-channel").html(buttonHtml);
                }
            }
        }
    });

    jQuery(document).on("click", "#trigger_on_time, #chaty_trigger_on_scroll, #cht_close_button", function(){
        change_custom_preview();
    });
});


function change_custom_preview() {

    if(!jQuery("#trigger_on_time").is(":checked")){
        jQuery("#chaty_trigger_time").prop("disabled", true);
    } else {
        jQuery("#chaty_trigger_time").prop("disabled", false);
    }

    if(!jQuery("#chaty_trigger_on_scroll").is(":checked")){
        jQuery("#chaty_trigger_on_page_scroll").prop("disabled", true);
    } else {
        jQuery("#chaty_trigger_on_page_scroll").prop("disabled", false);
    }

    if(jQuery("#chaty_default_state").val() == "open" && jQuery("#channel-list > .icon.active").length > 1) {
        jQuery("#chaty_attention_effect").val("");
        jQuery("#chaty_attention_effect, .test_textarea").attr("disabled", true);
        jQuery("#chaty_attention_effect option:first-child").text("Doesn't apply for the open state");
        if(jQuery(".test_textarea").val() != "Doesn't apply for the open state") {
            jQuery(".test_textarea").attr("data-value", jQuery(".test_textarea").val());
        }
        jQuery(".test_textarea").val("Doesn't apply for the open state");
        jQuery("#cht_number_of_messages").attr("disabled", true);
        jQuery("#cht_pending_messages").attr("disabled", true);
        jQuery(".disable-message").addClass("label-tooltip").addClass("icon");
        jQuery("#cht_pending_messages").attr("checked", false);
        jQuery(".pending-message-items").removeClass("active");
        jQuery(".cta-action-radio input").attr("disabled", true);
    } else {
        jQuery("#chaty_attention_effect, .test_textarea").attr("disabled", false);
        jQuery("#chaty_attention_effect option:first-child").text("None");
        jQuery(".test_textarea").attr("placeholder","");
        if(jQuery(".test_textarea").val() == "Doesn't apply for the open state") {
            jQuery(".test_textarea").val(jQuery(".test_textarea").attr("data-value"));
        }
        jQuery("#cht_number_of_messages").attr("disabled", false);
        jQuery("#cht_pending_messages").attr("disabled", false);
        jQuery(".disable-message").removeClass("label-tooltip").removeClass("icon");
        jQuery(".cta-action-radio input").attr("disabled", false);
    }


    if(jQuery(".chaty-bg-color").length) {
        jQuery(".chaty-bg-color").each(function () {
            if(jQuery(this).closest(".chaty-channel").data("channel") == "Instagram") {
                if(jQuery(this).val() != "#ffffff") {
                    jQuery(this).closest("li.chaty-channel").find(".chaty-main-svg").find(".color-element").attr("fill", jQuery(this).val());
                }
            } else {
                jQuery(this).closest("li.chaty-channel").find(".chaty-main-svg").find(".color-element").attr("fill", jQuery(this).val());
            }
        });
    }
    if(jQuery(".agent-icon-color").length) {
        jQuery(".agent-icon-color").each(function () {
            if(jQuery(this).closest(".chaty-channel").data("channel") == "Instagram") {
                if(jQuery(this).val() != "#ffffff") {
                    jQuery(this).closest("li.chaty-channel").find(".chaty-main-svg").find(".color-element").attr("fill", jQuery(this).val());
                }
            } else {
                jQuery(this).closest("li.chaty-channel").find(".chaty-main-svg").find(".color-element").attr("fill", jQuery(this).val());
            }
        });
    }
    jQuery(".chaty-preview").height(234);
    jQuery(".preview .page").height(250);
    jQuery(".chaty-preview").html("");
    previewChannelList = [];
    var isDesktop = jQuery("#previewDesktop").is(":checked")?true:false;
    if(!isDesktop) {
        jQuery("#admin-preview .page").addClass("mobile");
    } else {
        jQuery("#admin-preview .page").removeClass("mobile");
    }
    if(jQuery("#channels-selected-list > li:not(.chaty-cls-setting)").length >= 2) {
        jQuery("#chaty-social-close").show();
    } else {
        jQuery("#chaty-social-close").hide();
    }
    jQuery(".csaas-outer-forms").remove();
    if(jQuery("#chaty_default_state").val() == "open") {
        jQuery(".hide-show-button").addClass("active");
    } else {
        jQuery(".hide-show-button").removeClass("active");
    }
    if(jQuery("#channels-selected-list > li").length > 0) {
        advanceCustomCSS = "";
        var activeChannels = getActiveChannels();
        if(activeChannels) {
            var widgetPosition = getWidgetPosition();
            widgetPosition = (widgetPosition == "right") ? "right" : "left";
            var toolTipPosition = getToolTipPosition();
            var widgetHtml = "<div style='display:none' class='csaas csaas-id-0 csaas-widget-0 csaas-key-0' id='csaas-widget-0' data-key='0' data-id='0' data-identifier='0' data-nonce='0' >" +
                "<div class='csaas-widget " + widgetPosition + "-position'>" +
                "<div class='csaas-channels'>" +
                "<div class='csaas-channel-list'></div>" +
                "<div class='csaas-i-trigger'></div>" +
                "</div>" +
                "</div>" +
                "</div>";
            jQuery(".chaty-preview").append(widgetHtml);

            if(previewChannelList.length == 1) {
                var channelHtml = getChannelSetting(previewChannelList[0], 0, toolTipPosition);

                jQuery("#csaas-widget-0 .csaas-i-trigger").html(channelHtml);
                jQuery("#csaas-widget-0 .csaas-i-trigger").addClass("single-channel");
                jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel").addClass("single");

                jQuery("#csaas-widget-0 .csaas-widget").addClass("has-single");
                var ctaText = jQuery(".test_textarea").val();
                if(!isEmpty(ctaText)) {
                    jQuery("#csaas-widget-0 .csaas-tooltip").removeClass("csaas-tooltip");
                    jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel").attr("data-hover", ctaText);
                    jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel").addClass("active").addClass("csaas-tooltip").addClass(toolTipPosition);
                }
            } else {
                for(i=0; i<previewChannelList.length; i++) {
                    var channel = previewChannelList[i];
                    var channelHtml = getChannelSetting(channel, 0, toolTipPosition);
                    jQuery("#csaas-widget-0 .csaas-channel-list").append(channelHtml);

                    // if(channel != "Instagram" || (channel.icon_color != "#ffffff" && channel.icon_color != "#fff")) {
                    //     customCSS += "#csaas-widget-0 ."+channel+"-channel .color-element{ fill: "+channel.icon_color+"; color: "+channel.icon_color+";}";
                    //     customCSS += "#csaas-widget-0 .channel-icon-"+channel+" .color-element{ fill: "+channel.icon_color+"; color: "+channel.icon_color+";}";
                    // }
                    //
                    // customCSS += "#csaas-widget-0 ."+channel+"-channel .chaty-custom-icon { background-color: "+channel.icon_color+"; }";
                    // customCSS += "#csaas-widget-0 ."+channel+"-channel .chaty-svg { background-color: "+channel.icon_color+";}";
                    // customCSS += "#csaas-widget-0 .channel-icon-"+channel+" .chaty-svg { background-color: "+channel.icon_color+";}";
                }

                var widgetIcon = getCTAWidgetIcon();
                var ctaText = jQuery(".test_textarea").val();

                if(jQuery("#chaty_default_state").val() == "open") {
                    ctaText = "";
                }

                var ctaToolTipPosition = toolTipPosition;
                if(jQuery("#chaty_icons_view").val() == "horizontal") {
                    if(widgetPosition == "left") {
                        ctaToolTipPosition = "right";
                    } else {
                        ctaToolTipPosition = "left";
                    }
                }

                var widgetButton = '<div class="csaas-channel csaas-cta-main csaas-tooltip '+ctaToolTipPosition+' active" data-widget="0"  data-hover="'+ctaText+'">' +
                    '<div class="csaas-cta-button">' +
                    '<button type="button" class="open-csaas">' +
                    widgetIcon +
                    '</button>' +
                    '<button type="button" class="open-csaas-channel"></button>' +
                    '</div>' +
                    '</div>';
                jQuery("#csaas-widget-0 .csaas-i-trigger").html(widgetButton);

                /* close button */
                var closeHtml = '<div class="csaas-channel csaas-cta-close csaas-tooltip '+toolTipPosition+'" data-hover="'+jQuery("input[name='cht_close_button_text']").val()+'">' +
                    '<div class="csaas-cta-button"><button type="button">' +
                    '<span class="csaas-svg">' +
                    '<svg viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="26" cy="26" rx="26" ry="26" fill="'+ jQuery("input[name='cht_color']:checked").val() +'"></ellipse><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(18.35 15.6599) scale(0.998038 1.00196) rotate(45)" fill="white"></rect><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(37.5056 18.422) scale(0.998038 1.00196) rotate(135)" fill="white"></rect></svg>' +
                    '</span>' +
                    '</button>' +
                    '</div>' +
                    '</div>';
                jQuery("#csaas-widget-0 .csaas-i-trigger").append(closeHtml);
            }

            if(jQuery("#chaty_default_state").val() != "open" || previewChannelList.length == 1) {
                checkForPendingMessage();
                checkForWidgetAnimation();
            }

            var extraSpace = 0;
            /* check for close button */
            if(jQuery("#chaty_default_state").val() == "open" && !jQuery("#cht_close_button").is(":checked")) {
                jQuery("#csaas-widget-0 .csaas-widget").addClass("csaas-no-close-button");
                extraSpace = 1;
            }

            /* check for State */
            if(jQuery("#chaty_default_state").val() == "hover") {
                jQuery("#csaas-widget-0").addClass("open-on-hover");
            } else if(jQuery("#chaty_default_state").val() == "open") {
                jQuery("#csaas-widget-0 .csaas-widget").addClass("default-open");
                jQuery("#csaas-widget-0 .csaas-widget").addClass("csaas-open");
                if(!jQuery("#cht_close_button").is(":checked")) {
                    jQuery("#csaas-widget-0 .csaas-widget").addClass("csaas-open");
                }
            }


            var widgetSize = isDesktop?36:28;
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .custom-chaty-image {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0  .facustom-icon { width: "+widgetSize+"px; height: "+widgetSize+"px; line-height: "+widgetSize+"px; font-size:"+(parseInt(widgetSize/2))+"px; text-align: center; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel a img {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel a {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .chaty-custom-icon {display:block; width: "+widgetSize+"px; height: "+widgetSize+"px; line-height: "+widgetSize+"px; font-size: "+parseInt(widgetSize/2)+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel button {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .csaas-svg {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .custom-agent-image {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .facustom-icon {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .custom-agent-image img {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .csaas-svg img {width: "+widgetSize+"px; height: "+widgetSize+"px; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-channel .csaas-svg .csaas-custom-channel-icon {width: "+widgetSize+"px; height: "+widgetSize+"px; line-height: "+widgetSize+"px; display: block; font-size:"+(parseInt(widgetSize/2))+"px; }";

            if(jQuery("#chaty_icons_view").val() == "vertical") {
                //customCSS += "#chaty-widget-"+widgetRecord.id+" .csaas-channel-list {bottom: "+(widgetSize+4)+"px; }";
                advanceCustomCSS += "#csaas-widget-0 .csaas-channel-list {height: "+(activeChannels*(widgetSize+8))+"px; }";
                advanceCustomCSS += "#csaas-widget-0 .csaas-channel-list {width: "+(widgetSize+8)+"px; }";

                for(var i=0; i<=activeChannels; i++) {
                    advanceCustomCSS += "#csaas-widget-0 .csaas-open .csaas-channel-list .csaas-channel:nth-child("+(i+1)+") {-webkit-transform: translateY(-"+((widgetSize+8)*(activeChannels - i - extraSpace))+"px); transform: translateY(-"+((widgetSize+8)*(activeChannels - i - extraSpace))+"px);}";
                }
            } else {
                jQuery("#csaas-widget-0 .csaas-widget").addClass("hor-mode");
                advanceCustomCSS += "#csaas-widget-0 .csaas-channel-list {width: "+(activeChannels*(widgetSize+8))+"px; }";
                advanceCustomCSS += "#csaas-widget-0 .csaas-channel-list {height: "+(widgetSize)+"px; }";
                // customCSS += "#csaas-widget-0 .csaas-widget.left-position.hor-mode .csaas-channel-list {left: "+(widgetSize+8)+"px; }";
                // customCSS += "#csaas-widget-0 .csaas-widget.right-position.hor-mode .csaas-channel-list {right: "+(widgetSize+8)+"px; }";

                for(var i=0; i<=activeChannels; i++) {
                    advanceCustomCSS += "#csaas-widget-0 .csaas-widget.left-position.hor-mode.csaas-open .csaas-channel-list .csaas-channel:nth-child("+(i+1)+") {-webkit-transform: translateX("+((widgetSize+8)*(activeChannels - i - extraSpace))+"px); transform: translateX("+((widgetSize+8)*(activeChannels - i - extraSpace))+"px);}";
                    advanceCustomCSS += "#csaas-widget-0 .csaas-widget.right-position.hor-mode.csaas-open .csaas-channel-list .csaas-channel:nth-child("+(i+1)+") {-webkit-transform: translateX(-"+((widgetSize+8)*(activeChannels - i - extraSpace))+"px); transform: translateX(-"+((widgetSize+8)*(activeChannels - i - extraSpace))+"px);}";
                }
            }

            /* set on hover text color */
            advanceCustomCSS += "#csaas-widget-0 .csaas-tooltip:after {background-color: "+jQuery("#cht_cta_bg_color").val()+"; color: "+jQuery("#cht_cta_text_color").val()+"}";
            advanceCustomCSS += "#csaas-widget-0 .csaas-tooltip.top:before {border-top-color: "+jQuery("#cht_cta_bg_color").val()+"; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-tooltip.left:before {border-left-color: "+jQuery("#cht_cta_bg_color").val()+"; }";
            advanceCustomCSS += "#csaas-widget-0 .csaas-tooltip.right:before {border-right-color: "+jQuery("#cht_cta_bg_color").val()+";}";


            /* Contact Us Button */
            advanceCustomCSS += "#csaas-submit-button-0 {color: "+jQuery("#button_text_color_for_Contact_Us").val()+" !important; background: "+jQuery("#button_bg_color_for_Contact_Us").val()+" !important;}"

            updateWidgetViews();

            jQuery("#custom-css").html("<style>"+advanceCustomCSS+"</style>");
            jQuery(".csaas-outer-forms").show();
            jQuery(".csaas-outer-forms").addClass(widgetPosition);
        }
    }

    if(imageDataEvent != false && jQuery("#testUpload").val() != "" && jQuery("input[name='widget_icon']:checked").val() == "chat-image") {
        if(jQuery("#cta-image").length) {
            var output = document.getElementById('cta-image');
            output.src = URL.createObjectURL(imageDataEvent.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
                //jQuery("#image-upload").addClass("has-custom-image");
            }
        }
    }
}

function updateWidgetViews() {
    jQuery("#csaas-widget-0").addClass("active");
}

function checkForWidgetAnimation() {
    if(jQuery("#chaty_attention_effect").val() != "none" && jQuery("#chaty_attention_effect").val() != "") {
        jQuery("#csaas-widget-0").attr("data-animation", jQuery("#chaty_attention_effect").val());
        if(jQuery("#csaas-widget-0 .csaas-widget").hasClass("has-single")) {
            jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel a").addClass("csaas-animation-"+jQuery("#chaty_attention_effect").val());
        } else {
            jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-cta-main .csaas-cta-button").addClass("csaas-animation-"+jQuery("#chaty_attention_effect").val());
        }
    }
}

function checkForPendingMessage() {
    if(jQuery("#cht_pending_messages").is(":checked") && jQuery("#cht_number_of_messages").val() != "") {
        var attention_effect = jQuery("#chaty_attention_effect").val();
        if(jQuery("#csaas-widget-0 .csaas-widget").hasClass("has-single")) {
            if (attention_effect == "bounce" || attention_effect == "jump" || attention_effect == "waggle" || attention_effect == "pulse" || attention_effect == "pulse-icon") {
                jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel .chaty-icon").append("<span class='ch-pending-msg'>" + jQuery("#cht_number_of_messages").val() + "</span>");
            } else {
                jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-channel a").after("<span class='ch-pending-msg'>" + jQuery("#cht_number_of_messages").val() + "</span>");
            }
        } else {
            if (attention_effect == "bounce" || attention_effect == "jump" || attention_effect == "waggle" || attention_effect == "pulse" || attention_effect == "pulse-icon") {
                jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-cta-main .csaas-cta-button").append("<span class='ch-pending-msg'>" + jQuery("#cht_number_of_messages").val() + "</span>");
            } else {
                jQuery("#csaas-widget-0 .csaas-i-trigger .csaas-cta-main").append("<span class='ch-pending-msg'>" + jQuery("#cht_number_of_messages").val() + "</span>");
            }
        }

        jQuery(".ch-pending-msg").css("color", jQuery("#cht_number_color").val());
        jQuery(".ch-pending-msg").css("background-color", jQuery("#cht_number_bg_color").val());
    }
}

function getCTAWidgetIcon() {
    var widgetIcon = 'chat-base';
    if(jQuery("input[name='widget_icon']:checked").val() != "") {
        widgetIcon = jQuery("input[name='widget_icon']:checked").val();
    }
    if(widgetIcon == "chat-image") {
        if(jQuery("#elPreviewImage img").length) {
            return "<span class='csaas-svg' style='background: "+jQuery("input[name='cht_color']:checked").val()+"'><img id='cta-image' src='"+jQuery("#elPreviewImage img").attr("src")+"' alt='Chaty Widget' /></span>";
        }
        widgetIcon = 'chat-base';
    }

    return '<span class="csaas-svg">'+getSvgIcon(widgetIcon, jQuery("input[name='cht_color']:checked").val())+"</span>";
}
function getSvgIcon(iconName, widgetColor) {
    switch(iconName) {
        case"chat-smile":
            return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-496.8 507.1 54 54" style="enable-background:new -496.8 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;} .chaty-sts2{fill:none;stroke:#808080;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}</style><g><circle cx="-469.8" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-459.5,523.5H-482c-2.1,0-3.7,1.7-3.7,3.7v13.1c0,2.1,1.7,3.7,3.7,3.7h19.3l5.4,5.4c0.2,0.2,0.4,0.2,0.7,0.2c0.2,0,0.2,0,0.4,0c0.4-0.2,0.6-0.6,0.6-0.9v-21.5C-455.8,525.2-457.5,523.5-459.5,523.5z"/><path class="chaty-sts2" d="M-476.5,537.3c2.5,1.1,8.5,2.1,13-2.7"/><path class="chaty-sts2" d="M-460.8,534.5c-0.1-1.2-0.8-3.4-3.3-2.8"/></svg>';
        case"chat-bubble":
            return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-496.9 507.1 54 54" style="enable-background:new -496.9 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;}</style><g><circle  cx="-469.9" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-472.6,522.1h5.3c3,0,6,1.2,8.1,3.4c2.1,2.1,3.4,5.1,3.4,8.1c0,6-4.6,11-10.6,11.5v4.4c0,0.4-0.2,0.7-0.5,0.9   c-0.2,0-0.2,0-0.4,0c-0.2,0-0.5-0.2-0.7-0.4l-4.6-5c-3,0-6-1.2-8.1-3.4s-3.4-5.1-3.4-8.1C-484.1,527.2-478.9,522.1-472.6,522.1z   M-462.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-464.6,534.6-463.9,535.3-462.9,535.3z   M-469.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-471.7,534.6-471,535.3-469.9,535.3z   M-477,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-478.8,534.6-478.1,535.3-477,535.3z"/></svg>';
        case"chat-db":
            return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-496 507.1 54 54" style="enable-background:new -496 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;}</style><g><circle  cx="-469" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-464.6,527.7h-15.6c-1.9,0-3.5,1.6-3.5,3.5v10.4c0,1.9,1.6,3.5,3.5,3.5h12.6l5,5c0.2,0.2,0.3,0.2,0.7,0.2c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18.2C-461.1,529.3-462.7,527.7-464.6,527.7z"/><path class="chaty-sts1" d="M-459.4,522.5H-475c-1.9,0-3.5,1.6-3.5,3.5h13.9c2.9,0,5.2,2.3,5.2,5.2v11.6l1.9,1.9c0.2,0.2,0.3,0.2,0.7,0.2c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18C-455.9,524.1-457.5,522.5-459.4,522.5z"/></svg>';
        default:
            return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-496 507.7 54 54" style="enable-background:new -496 507.7 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill: #FFFFFF;}.chaty-st0{fill: #808080;}</style><g><circle cx="-469" cy="534.7" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-459.9,523.7h-20.3c-1.9,0-3.4,1.5-3.4,3.4v15.3c0,1.9,1.5,3.4,3.4,3.4h11.4l5.9,4.9c0.2,0.2,0.3,0.2,0.5,0.2 h0.3c0.3-0.2,0.5-0.5,0.5-0.8v-4.2h1.7c1.9,0,3.4-1.5,3.4-3.4v-15.3C-456.5,525.2-458,523.7-459.9,523.7z"/><path class="chaty-st0" d="M-477.7,530.5h11.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-11.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,530.8-478.2,530.5-477.7,530.5z"/><path class="chaty-st0" d="M-477.7,533.5h7.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-7.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,533.9-478.2,533.5-477.7,533.5z"/></svg>'
    }
}

function getChannelSetting(channel, widgetId, toolTipPosition) {
    var extraClass = "";
    if(jQuery("#chaty-social-"+channel).hasClass("has-agent-view")) {
        createAgentList(channel, widgetId);

        channelIcon = getChannelIcon(channel, widgetId);
        channelLink = getChannelURL(channel, channelIcon, toolTipPosition, widgetId);

        return "<div data-form='csaas-form-"+widgetId+"-"+channel+"' class='csaas-channel csaas-agent-button csaas-agent-"+widgetId+"-"+channel+" " + channel + "-channel" + extraClass + "' id='" + channel + "-" + widgetId + "-channel' data-id='" + channel + "-" + widgetId + "' data-widget='" + widgetId + "' data-channel='" + channel + "'>" + channelLink + "</div>";
    } else {
        var channelIcon = getChannelIcon(channel, widgetId);
        var channelLink = getChannelURL(channel, channelIcon, toolTipPosition, widgetId);

        return "<div class='csaas-channel " + channel + "-channel" + extraClass + "' id='" + channel + "-" + widgetId + "-channel' data-id='" + channel + "-" + widgetId + "' data-widget='" + widgetId + "' data-channel='" + channel + "'>" + channelLink + "</div>";
    }
}

function createAgentList(channel, widgetId) {
    var isDesktop = jQuery("#previewDesktop").is(":checked")?true:false;
    var formHtml = "";
    var widgetIndex = 0;
    formHtml += "<div style='display:none;' class='csaas-outer-forms csaas-agent-data csaas-agent-data-"+widgetId+" csaas-form-"+widgetId+"' data-channel='"+channel+"' id='csaas-form-"+widgetId+"-"+channel+"' data-widget='"+widgetId+"' data-index='"+widgetIndex+"'>";
    formHtml += "<div class='csaas-form'>";
    formHtml += "<div class='csaas-form-body'>";
    formHtml += "<div role='button' class='csaas-close-agent-list'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 330 330' xmlns:v='https://vecta.io/nano'><path d='M325.607 79.393c-5.857-5.857-15.355-5.858-21.213.001l-139.39 139.393L25.607 79.393c-5.857-5.857-15.355-5.858-21.213.001s-5.858 15.355 0 21.213l150.004 150a15 15 0 0 0 21.212-.001l149.996-150c5.859-5.857 5.859-15.355.001-21.213z'/></svg></div>";
    formHtml += "<div class='csaas-agent-header agent-info-"+widgetId+"-"+channel+"'>";
    if(!isEmpty(jQuery("#cht_social_agent_title_"+channel).val())) {
        formHtml += "<div class='agent-main-header'>"+jQuery("#cht_social_agent_title_"+channel).val()+"</div>";
    }
    if(!isEmpty(jQuery("#cht_social_agent_sub_title_"+channel).val())) {
        formHtml += "<div class='agent-sub-header'>"+jQuery("#cht_social_agent_sub_title_"+channel).val()+"</div>";
    }
    formHtml += "</div>";
    if(jQuery("#chaty-social-"+channel+" .chaty-agent-list .agent-list .agent-channel-setting").length) {
        jQuery("#chaty-social-"+channel+" .chaty-agent-list .agent-list .agent-channel-setting").each(function(){
            var thisIndex = jQuery(this).data("item");
            //if((isDesktop && jQuery("#"+channel+"Desktop-"+thisIndex).is(":checked")) || (!isDesktop && jQuery("#"+channel+"Mobile-"+thisIndex).is(":checked"))) {
                var agentIcon = jQuery("#image_agent_data_" + channel + "-" + thisIndex).html();
                if (jQuery("#image_agent_data_" + channel + "-" + thisIndex).hasClass("img-active")) {
                    agentIcon = "<div class='chaty-icon img-active'>" + agentIcon + "</div>";
                } else if (jQuery("#image_agent_data_" + channel + "-" + thisIndex).hasClass("icon-active")) {
                    agentIcon = "<div class='chaty-icon icon-active'>" + agentIcon + "</div>";
                } else {
                    agentIcon = "<div class='chaty-icon'>" + agentIcon + "</div>";
                }
                var agentLink = getAgentURL(channel, widgetId, thisIndex, agentIcon, jQuery("#agent-" + channel + "-" + thisIndex + " .chaty-agent-name").val());
                formHtml += "<div class='csaas-agent agent-info-" + widgetId + "-" + channel + " agent-info-" + thisIndex + "'>" + agentLink + "</div>";
            //}
        });
    }
    formHtml += "</div>";
    formHtml += "</div>";
    formHtml += "</div>";
    jQuery(".chaty-preview").append(formHtml);

    jQuery(".csaas-agent-header.agent-info-"+widgetId+"-"+channel).css("background", jQuery("#agent_head_bg_color_"+channel).val());
    jQuery(".csaas-agent-header.agent-info-"+widgetId+"-"+channel).css("color", jQuery("#agent_head_text_color_"+channel).val());
}

function getAgentURL(channel, widgetId, key, agentIcon, agentTitle) {
    return "<a href='javascript:;' ><span class='csaas-agent-icon'>"+agentIcon+"</span><span class='csaas-agent-title'>"+agentTitle+"</span></a>";
}

function getChannelIcon(channel, widgetId) {
    if(!jQuery("#chaty-social-"+channel).hasClass("has-agent-view")) {
        if (jQuery("#chaty_image_" + channel).length) {
            var widgetIcon = jQuery("#chaty_image_" + channel).html();
            if (jQuery("#chaty_image_" + channel).hasClass("icon-active")) {
                return "<div class='chaty-icon icon-active'>" + widgetIcon + "</div>";
            } else if (jQuery("#chaty_image_" + channel).hasClass("img-active")) {
                return "<div class='chaty-icon img-active'>" + widgetIcon + "</div>";
            }
            return "<div class='chaty-icon'>" + widgetIcon + "</div>";
        }
    } else {
        if (jQuery("#image_agent_data_agent-" + channel).length) {
            var widgetIcon = jQuery("#image_agent_data_agent-" + channel).html();
            if (jQuery("#image_agent_data_agent-" + channel).hasClass("icon-active")) {
                return "<div class='chaty-icon icon-active'>" + widgetIcon + "</div>";
            } else if (jQuery("#image_agent_data_agent-" + channel).hasClass("img-active")) {
                return "<div class='chaty-icon img-active'>" + widgetIcon + "</div>";
            }
            return "<div class='chaty-icon'>" + widgetIcon + "</div>";
        }
    }
}

function getChannelURL(channel, channelIcon, toolTipPosition, widgetId) {
    var extraClass = "";

    if(!jQuery("#chaty-social-"+channel).hasClass("has-agent-view")) {
        if (channel == "Whatsapp") {
            if (jQuery("#chaty-social-"+channel+" .embedded_window-checkbox").is(":checked") &&jQuery("#chaty-social-"+channel+" .chaty-whatsapp-setting-textarea").val() != "") {
                extraClass += " has-csaas-box csaas-whatsapp-form";
                startMakingWhatsAppPopup(channel, widgetId);
            }
        } else if(channel == "WeChat") {
            if(jQuery(".remove-qr-code-"+channel).hasClass("active")) {
                extraClass += " has-csaas-box csaas-qr-code-form";
                startMakingWeChatChannel(channel, 0);
            }
        } else if(channel == "Contact_Us") {
            extraClass += " has-csaas-box csaas-contact-us-form";
            startMakingContactForm(channel, 0);
        }
    }
    if(!jQuery("#chaty-social-"+channel).hasClass("has-agent-view")) {
        return "<a href='javascript:;' class='csaas-tooltip " + toolTipPosition + extraClass + "' data-form='csaas-form-" + widgetId + "-" + channel + "' data-hover='" + jQuery("#chaty-social-" + channel + " .chaty-title").val() + "'>" + channelIcon + "</a>";
    } else {
        return "<a href='javascript:;' class='csaas-tooltip " + toolTipPosition + extraClass + "' data-form='csaas-form-" + widgetId + "-" + channel + "' data-hover='" + jQuery("#cht_social_agent_text_" + channel ).val() + "'>" + channelIcon + "</a>";
    }
}

function startMakingContactForm(channel, widgetId) {
    var formHtml = "";
    var widgetIndex = 0;
    formHtml += "<div style='display:none;' class='csaas-outer-forms csaas-contact-form-box csaas-form-"+widgetId+"' data-channel='"+channel+"' id='csaas-form-"+widgetId+"-"+channel+"' data-widget='"+widgetId+"' data-index='"+widgetIndex+"'>";
    formHtml += "<div class='csaas-form'>";
    formHtml += "<div class='csaas-form-body'>";
    formHtml += "<div role='button' class='close-csaas-form'><div class='csaas-close-button'></div></div>";
    //formHtml += "<form class='csaas-ajax-contact-form' id='csaas-ajax-contact-form-"+widgetIndex+"' method='post' data-channel='"+channel+"' data-widget='"+widgetId+"' >";
    formHtml += "<div class='csaas-contact-form-body'>";
    formHtml += "<div class='csaas-contact-form-title'>"+jQuery("#cht_social_message_"+channel+"_form_title").val()+"</div>";
    formHtml += "<div class='csaas-contact-inputs'>";

    if(jQuery("#field_for_Contact_Us_name").is(":checked")) {
        formHtml += "<div class='csaas-contact-input'>";
        formHtml += "<input type='text' readonly class='csaas-input-field' placeholder='" + jQuery("#placeholder_for_Contact_Us_name").val() + "' />";
        formHtml += "</div>";
    }
    if(jQuery("#field_for_Contact_Us_email").is(":checked")) {
        formHtml += "<div class='csaas-contact-input'>";
        formHtml += "<input type='text' readonly class='csaas-input-field' placeholder='" + jQuery("#placeholder_for_Contact_Us_email").val() + "' />";
        formHtml += "</div>";
    }
    if(jQuery("#field_for_Contact_Us_phone").is(":checked")) {
        formHtml += "<div class='csaas-contact-input'>";
        formHtml += "<input type='text' readonly class='csaas-input-field' placeholder='" + jQuery("#placeholder_for_Contact_Us_phone").val() + "' />";
        formHtml += "</div>";
    }
    if(jQuery("#field_for_Contact_Us_message").is(":checked")) {
        formHtml += "<div class='csaas-contact-input'>";
        formHtml += "<textarea type='text' readonly class='csaas-textarea-field' placeholder='" + jQuery("#placeholder_for_Contact_Us_message").val() + "' ></textarea>";
        formHtml += "</div>";
    }
    /*$.each(channel.contact_fields, function (key, contactField) {
    formHtml += "<div class='csaas-contact-input'>";
        var isRequired = isTrue(contactField.is_required)?"is-required":"";
        if(contactField.type == "textarea") {
        formHtml += "<textarea type='" + contactField.type + "' class='csaas-textarea-field "+isRequired+" field-"+contactField.field+"' placeholder='" + contactField.placeholder + "' name='" + contactField.field + "' id='" + contactField.field + "-" + widgetId + "' ></textarea>"
        } else {
        formHtml += "<input type='" + contactField.type + "' class='csaas-input-field "+isRequired+" field-"+contactField.field+"' placeholder='" + contactField.placeholder + "' name='" + contactField.field + "' id='" + contactField.field + "-" + widgetId + "' />"
        }
        formHtml += "</div>";
    });*/
    formHtml += "<div class='csaas-contact-form-button'><button type='submit' id='csaas-submit-button-"+widgetId+"' class='csaas-submit-button'>"+jQuery("#button_text_for_"+channel).val()+"</button></div>";
    formHtml += "</div>"; // csaas-contact-inputs
    formHtml += "</div>"; // csaas-contact-form-body
    //formHtml += "</form>";
    formHtml += "</div>";
    formHtml += "</div>";
    formHtml += "</div>";
    jQuery(".chaty-preview").append(formHtml);
}

function startMakingWeChatChannel(channel, widgetId) {
    var formHtml = "";
    var widgetIndex = 0;
    formHtml += "<div style='display:none;' class='csaas-outer-forms csaas-form-"+widgetId+"' data-channel='"+channel+"' id='csaas-form-"+widgetId+"-"+channel+"' data-widget='"+widgetId+"' data-index='"+widgetIndex+"'>";
    formHtml += "<div class='csaas-form'>";
    formHtml += "<div class='csaas-form-body'>";
    formHtml += "<div role='button' class='close-csaas-form is-whatsapp-btn'><div class='csaas-close-button'></div></div>";
    formHtml += "<div class='qr-code-image'><img src='"+jQuery("#cht_social_image_src_"+channel).attr("src")+"' alt='WeChat' /></div>";
    formHtml += "</div>";
    formHtml += "</div>";
    formHtml += "</div>";
    jQuery(".chaty-preview").append(formHtml);
}

function startMakingWhatsAppPopup(channel, widgetId) {
    var formHtml = "";
    var widgetIndex = widgetId;
    var formAction = "";
    var formTarget = "";
    formHtml += "<div style='display:none;' class='csaas-outer-forms csaas-form-"+widgetId+"' data-channel='"+channel+"' id='csaas-form-"+widgetId+"-"+channel+"' data-widget='"+widgetId+"' data-index='"+widgetIndex+"'>";
    formHtml += "<div class='csaas-whatsapp-form'>";
    formHtml += "<div class='csaas-whatsapp-body'>";
    formHtml += "<div role='button' class='close-csaas-form is-whatsapp-btn'><div class='csaas-close-button'></div></div>";
    formHtml += "<div class='csaas-whatsapp-message'></div>";
    formHtml += "</div>";
    formHtml += "<div class='csaas-whatsapp-footer'>";
    //formHtml += "<form action='"+formAction+"' target='"+formTarget+"' class='whatsapp-csaas-form' data-widget='"+widgetId+"' data-channel='"+channel+"'>";
    formHtml += "<div class='csaas-whatsapp-data'>";
    formHtml += "<div class='csaas-whatsapp-field'>";
    formHtml += "<input name='text' readonly type='text' class='csass-whatsapp-input' />";
    formHtml += "</div>";
    formHtml += "<div class='csaas-whatsapp-button'>";
    formHtml += "<button type='submit'>";
    formHtml += "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path fill='#ffffff' d='M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z'></path></svg>";
    formHtml += "</button>";
    formHtml += "</div>";
    formHtml += "</div>";
    //formHtml += "</form>";
    formHtml += "</div>";
    formHtml += "</div>";
    formHtml += "</div>";
    jQuery(".chaty-preview").append(formHtml);
    jQuery("#csaas-form-"+widgetId+"-"+channel+" .csaas-whatsapp-message").html(jQuery(".chaty-whatsapp-setting-textarea").val());
    var preSetMessage = jQuery(".pre-set-message-whatsapp").val();
    if(!isEmpty(channel.pre_set_message)) {
        jQuery("#csaas-form-"+widgetId+"-"+channel+" .csass-whatsapp-input").val(preSetMessage);
    }
    jQuery("#chaty-form-"+widgetId+"-"+channel).show();
}

function isEmpty(varVal) {
    if(varVal == null || varVal == "" || jQuery.trim(varVal) == "" ) {
        return true
    }
    return false;
}

function getWidgetPosition() {
    if(jQuery("input[name='cht_position']:checked").val() == "custom") {
        if(jQuery("input[name='positionSide']:checked").val() == "left") {
            return "left";
        }
    } else if(jQuery("input[name='cht_position']:checked").val() == "left") {
        return "left";
    }
    return "right";
}

function getToolTipPosition() {
    var widgetPos = getWidgetPosition();
    if(jQuery("#chaty_icons_view").val() == "vertical") {
        return (widgetPos == "right")?"left":"right";
    } else if(previewChannelList.length > 1) {
        return "top";
    }
    return (widgetPos == "right")?"left":"right";
}

function getActiveChannels() {
    var channelCount = 0;
    if(jQuery("#channels-selected-list > li:not(.chaty-cls-setting)").length) {
        var isDesktop = jQuery("#previewDesktop").is(":checked")?true:false;
        jQuery("#channels-selected-list > li:not(.csaas-cls-setting)").each(function(){
            if(jQuery(this).hasClass("has-agent-view")) {
                if(isDesktop && jQuery(this).find(".agent-desktop-device").is(":checked")) {
                    previewChannelList.push(jQuery(this).data("id"));
                    channelCount++;
                } else if(!isDesktop && jQuery(this).find(".agent-mobile-device").is(":checked")) {
                    channelCount++;
                    previewChannelList.push(jQuery(this).data("id"));
                }
            } else {
                if(isDesktop && jQuery(this).find(".js-chanel-desktop").is(":checked")) {
                    channelCount++;
                    previewChannelList.push(jQuery(this).data("id"));
                } else if(!isDesktop && jQuery(this).find(".js-chanel-mobile").is(":checked")) {
                    channelCount++;
                    previewChannelList.push(jQuery(this).data("id"));
                }
            }
        });
    }
    return channelCount;
}