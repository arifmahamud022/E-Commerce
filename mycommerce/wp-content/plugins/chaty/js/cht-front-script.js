(function (factory) {
    "use strict";
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof module !== 'undefined' && module.exports) {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }
}(function ($, undefined) {
    var widgetData = [];
    var clientCountry = '';
    var isChatyInMobile = (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) ? 1 : 0;
    var defaultFontFamily = ["System Stack", "Arial", "Tahoma", "Verdana", "Helvetica", "Times New Roman", "Trebuchet MS", "Georgia"];
    var chatyEnv = 'dev';                           // change it to 'app' to remove log from console
    var isBoatUser = false;
    /**
     *
     * Trigger Variables
     *
     **/
    var chatyHasTimeDelay = false;
    var chatyMaxTimeInterval = 0;
    var chatyHasPageScroll = false;
    var chatyHasExitIntent = false;
    var chatyPageScrolls = [];
    var chatyTimeInterval;
    var chatyIntervalTime = 0;
    var lastScrollPer = 0;
    var customExtraCSS = "";
    var chatyHideTimeInterval;
    var chatyHideIntervalTime = 0;

    $(document).ready(function () {
        var botPattern = "(googlebot\/|bot|Googlebot-Mobile|Googlebot-Image|Google favicon|Mediapartners-Google|bingbot|slurp|java|wget|curl|Commons-HttpClient|Python-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail.RU_Bot|discobot|heritrix|findthatfile|europarchive.org|NerdByNature.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web-archive-net.com.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks-robot|it2media-domain-crawler|ip-web-crawler.com|siteexplorer.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e.net|GrapeshotCrawler|urlappendbot|brainobot|fr-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf.fr_bot|A6-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j-asr|Domain Re-Animator Bot|AddThis)";
        var re = new RegExp(botPattern, 'i');
        var userAgent = navigator.userAgent;
        if (re.test(userAgent)) {
            isBoatUser = true;
        }

        if (chaty_settings.data_analytics_settings != "on" || chaty_settings.data_analytics_settings == "off") {
            isBoatUser = true;
        }

        if (typeof chaty_settings == "undefined" || chaty_settings.chaty_widgets.length == 0) {
            console.log("Chaty settings doesn't exists");
        } else {
            widgetData = chaty_settings.chaty_widgets;
            checkForCountry();
        }

        $(document).on("click", "html, body", function (e) {
            $(".form-open").removeClass("form-open");
            $(".chaty-outer-forms").removeClass("active");
            $(".chaty .chaty-widget.chaty-no-close-button").addClass("chaty-open");
        });

        $(document).on("click", ".chaty, .chaty-outer-forms", function (e) {
            e.stopPropagation();
        });

        $(document).on("submit", ".whatsapp-chaty-form", function () {

            if ($(this).hasClass("form-google-analytics")) {
                var widgetChannel = "Whatsapp";
                if (window.hasOwnProperty("gtag")) {
                    gtag("event", "chaty_" + widgetChannel, {
                        eventCategory: "chaty_" + widgetChannel,
                        event_action: "chaty_" + widgetChannel,
                        method: "chaty_" + widgetChannel
                    });
                }
                if (window.hasOwnProperty("ga")) {
                    var ga_settings = window.ga.getAll()[0];
                    ga_settings && ga_settings.send("event", "click", {
                        eventCategory: "chaty_" + widgetChannel,
                        eventAction: "chaty_" + widgetChannel,
                        method: "chaty_" + widgetChannel
                    })
                }
            }
            var widgetId = $(this).data('widget');
            var chatyChannel = $(this).data('channel');


            var clickStatus = checkChatyCookieExpired(widgetId, "c-" + chatyChannel);

            if ((!isEmpty(widgetId) || widgetId == 0) && clickStatus) {
                saveChatyCookieString(widgetId, "c-" + chatyChannel);
                var widgetNonce = $("#chaty-widget-" + widgetId).data("nonce");
                if (!isBoatUser) {
                    $.ajax({
                        url: chaty_settings.ajax_url,
                        data: {
                            widgetId: widgetId,
                            userId: widgetId,
                            isMobile: isChatyInMobile,
                            channel: chatyChannel,
                            nonce: widgetNonce,
                            action: 'update_chaty_channel_click'
                        },
                        method: 'post',
                    });
                }
            }

            if ($("#chaty-widget-" + widgetId).length) {
                $("#chaty-widget-" + widgetId).removeClass("form-open");
                $(this).closest(".chaty-outer-forms").removeClass("active");
                if ($("#chaty-widget-" + widgetId).find(".chaty-widget").hasClass("cssas-no-close-button")) {
                    $("#chaty-widget-" + widgetId).find(".chaty-widget").addClass("chaty-open")
                }
            }
        });

        $(document).on("click", ".chaty-close-button, .chaty-close-agent-list", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var widgetId = $(this).closest(".chaty-outer-forms").data('widget');
            if (!isEmpty(widgetId) || widgetId == 0) {
                if ($("#chaty-widget-" + widgetId).length) {
                    $("#chaty-widget-" + widgetId).removeClass("form-open");
                    $(this).closest(".chaty-outer-forms").removeClass("active");
                    if ($("#chaty-widget-" + widgetId).find(".chaty-widget").hasClass("chaty-no-close-button")) {
                        $("#chaty-widget-" + widgetId).find(".chaty-widget").addClass("chaty-open");
                    }
                }
                if ($(this).closest(".chaty-whatsapp-form").length) {
                    var dataChannel = $(this).closest(".chaty-outer-forms").data('channel');
                    if (!isEmpty(dataChannel)) {
                        var clickStatus = checkChatyCookieExpired(widgetId, "c-" + dataChannel);
                        if (clickStatus) {
                            saveChatyCookieString(widgetId, "c-" + dataChannel);
                        }
                    }
                    var visibleStatus = checkChatyCookieExpired(widgetId, 'v-widget');
                    if (visibleStatus) {
                        updateWidgetViews(widgetId);
                    }
                }
            }
        });

        $(document).on("click", "a.chaty-qr-code-form", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            var dataForm = $(this).data('form');
            if (!isEmpty(dataForm)) {
                if ($("#" + dataForm).length) {
                    var buttonHtml = $(this).html();

                    if($("#" + dataForm).hasClass("active")) {
                        $(this).closest(".chaty-widget").addClass("chaty-open");
                        $(this).closest(".chaty").removeClass("form-open");
                        $("#" + dataForm).removeClass("active");
                    } else {
                        $(this).closest(".chaty-widget").removeClass("chaty-open");
                        $(this).closest(".chaty").addClass("form-open");
                        $("#" + dataForm).addClass("active");

                        $(this).closest(".chaty-widget").find(".open-chaty-channel").html(buttonHtml);
                    }
                }
            }
        });

        $(document).on("click", "a.chaty-contact-us-form", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            var dataForm = $(this).data('form');
            if (!isEmpty(dataForm)) {
                if ($("#" + dataForm).length) {
                    var buttonHtml = $(this).html();

                    if($("#" + dataForm).hasClass("active")) {
                        $(this).closest(".chaty-widget").addClass("chaty-open");
                        $(this).closest(".chaty").removeClass("form-open");
                        $("#" + dataForm).removeClass("active");

                    } else {
                        $(this).closest(".chaty-widget").removeClass("chaty-open");
                        $(this).closest(".chaty").addClass("form-open");
                        $("#" + dataForm).addClass("active");
                        $("#" + dataForm).find(".chaty-ajax-success-message").remove();
                        $("#" + dataForm).find(".chaty-ajax-error-message").remove();
                        $("#" + dataForm).find(".has-chaty-error").removeClass("has-chaty-error");

                        $(this).closest(".chaty-widget").find(".open-chaty-channel").html(buttonHtml);
                    }
                }
            }
        });

        $(document).on("click", "a.chaty-whatsapp-form", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            var dataForm = $(this).data('form');
            if (!isEmpty(dataForm)) {
                if ($("#" + dataForm).length) {
                    var buttonHtml = $(this).html();
                    $("#" + dataForm).addClass("is-active");
                    if($("#" + dataForm).hasClass("active")) {
                        $(this).closest(".chaty-widget").addClass("chaty-open");
                        $(this).closest(".chaty").removeClass("form-open");
                        $("#" + dataForm).removeClass("active");
                    } else {
                        $(this).closest(".chaty-widget").removeClass("chaty-open");
                        $(this).closest(".chaty").addClass("form-open");
                        $("#" + dataForm).addClass("active");

                        $(this).closest(".chaty-widget").find(".open-chaty-channel").html(buttonHtml);
                    }
                }
            }
        });

        $(document).on("click", ".chaty-channel.chaty-agent-button", function (e) {
            e.preventDefault();
            // e.stopPropagation();
            var dataForm = $(this).data('form');
            if (!isEmpty(dataForm)) {
                if ($("#" + dataForm).length) {
                    if (!$(this).closest(".chaty-widget").hasClass("has-single")) {
                        var buttonHtml = $(this).html();
                        $("#" + dataForm).addClass("is-active");

                        $(this).closest(".chaty-widget").removeClass("chaty-open");
                        $(this).closest(".chaty").addClass("form-open");
                        $("#" + dataForm).addClass("active");

                        $(this).closest(".chaty-widget").find(".open-chaty-channel").html(buttonHtml);
                    } else {
                        if ($(this).closest(".chaty").hasClass("form-open")) {
                            $(this).closest(".chaty-widget").addClass("chaty-open");
                            $(this).closest(".chaty").removeClass("form-open");
                            $("#" + dataForm).removeClass("active");
                        } else {
                            var buttonHtml = $(this).html();
                            $("#" + dataForm).addClass("is-active");

                            $(this).closest(".chaty-widget").removeClass("chaty-open");
                            $(this).closest(".chaty").addClass("form-open");
                            $("#" + dataForm).addClass("active");

                            $(this).closest(".chaty-widget").find(".open-chaty-channel").html(buttonHtml);
                        }
                    }
                }
            }

        });

        /* track google analytics event */
        $(document).on("click", ".chaty-channel.has-gae", function (e) {
            e.stopPropagation();
            var widgetChannel = $(this).data("channel");
            if (widgetChannel !== undefined && widgetChannel != "" && widgetChannel != null) {
                if (window.hasOwnProperty("gtag")) {
                    gtag("event", "chaty_" + widgetChannel, {
                        eventCategory: "chaty_" + widgetChannel,
                        event_action: "chaty_" + widgetChannel,
                        method: "chaty_" + widgetChannel
                    });
                }
                if (window.hasOwnProperty("ga")) {
                    var ga_settings = window.ga.getAll()[0];
                    ga_settings && ga_settings.send("event", "click", {
                        eventCategory: "chaty_" + widgetChannel,
                        eventAction: "chaty_" + widgetChannel,
                        method: "chaty_" + widgetChannel
                    })
                }
            }
        });

        /* toggle widget on CTA button click */
        $(document).on("click", ".chaty-i-trigger:not(.single-channel)", function () {
            if ($(this).closest(".chaty").hasClass("form-open")) {
                $(this).closest(".chaty").removeClass("form-open");
                $(this).closest(".chaty-widget").addClass("chaty-open");
            } else {
                $(this).closest(".chaty-widget").toggleClass("chaty-open");
            }
            $(".chaty-outer-forms").removeClass("active");
            if ($(this).closest(".chaty").find(".chaty-widget").hasClass("chaty-no-close-button")) {
                $(this).closest(".chaty").find(".chaty-widget").addClass("chaty-open");
            }
        });

        /* Open widget on hover */
        if (!isChatyInMobile) {
            $(document).on("mouseover", "body:not(.chaty-in-mobile) .chaty.open-on-hover .chaty-i-trigger:not(.single-channel)", function () {
                if (!$(this).closest(".chaty-widget").hasClass("chaty-open") && !$(this).closest(".chaty-widget").hasClass("on-chaty-widget")) {
                    $(this).closest(".chaty-widget").addClass("on-chaty-widget");
                    $(this).find(".chaty-cta-main").trigger("click");
                }
            }).on("mouseleave", "body:not(.chaty-in-mobile) .chaty.open-on-hover .chaty-i-trigger:not(.single-channel)", function () {
                if (!$(this).closest(".chaty-widget").hasClass("chaty-open")) {
                    $(this).closest(".chaty-widget").removeClass("on-chaty-widget")
                }
            });
        }

        /* check for channel or widget click event */
        $(document).on("click", ".chaty-channel", function (e) {
            // return;
            var clickStatus;
            var chatyChannel;
            var chatyChannels = [];
            var isSingle = 0;
            var chatyWidgetIdentifier;
            var chatyWidgetId = $(this).closest(".chaty").data("id");
            if (typeof chatyWidgetId != 'undefined') {
                chatyWidgetIdentifier = $("#chaty-widget-" + chatyWidgetId).data("identifier");
                if (typeof chatyWidgetIdentifier != 'undefined') {
                    var userId = $("#chaty-widget-" + chatyWidgetId).data("user");
                    removeChatyAnimation(chatyWidgetId);
                    if ($(this).hasClass("chaty-cta-main") || $(this).hasClass("chaty-cta-close")) {
                        clickStatus = checkChatyCookieExpired(chatyWidgetId, 'c-widget');
                        $("#chaty-widget-" + chatyWidgetId).find(".ch-pending-msg").remove();
                        if (clickStatus) {
                            saveChatyCookieString(chatyWidgetId, "c-widget");
                            if ($(this).hasClass("chaty-cta-main")) {
                                chatyChannels = [];
                                $("#chaty-widget-" + chatyWidgetId + " .chaty-channel-list").find(".chaty-channel").each(function () {
                                    chatyChannel = $(this).data("channel");
                                    clickStatus = checkChatyCookieExpired(chatyWidgetId, "v-" + chatyChannel);
                                    if (clickStatus && typeof chatyChannel != 'undefined') {
                                        saveChatyCookieString(chatyWidgetId, "v-" + chatyChannel);
                                        chatyChannels.push(chatyChannel);
                                    }
                                });
                                var widgetNonce = $("#chaty-widget-" + chatyWidgetId).data("nonce");
                                if (!isBoatUser) {
                                    $.ajax({
                                        url: chaty_settings.ajax_url,
                                        data: {
                                            widgetId: chatyWidgetId,
                                            userId: userId,
                                            isMobile: isChatyInMobile,
                                            channels: chatyChannels,
                                            isSingle: 0,
                                            nonce: widgetNonce,
                                            action: 'update_chaty_widget_click'
                                        },
                                        method: 'post',
                                    });
                                }
                            }
                        }
                        if ($("#chaty-widget-" + chatyWidgetId).hasClass("first_click")) {
                            $("#chaty-widget-" + chatyWidgetId + " .chaty-cta-main").removeClass("active");
                            $("#chaty-widget-" + chatyWidgetId + " .chaty-cta-main").removeClass("chaty-tooltip");
                        }
                    } else if ($(this).hasClass("single")) {
                        $("#chaty-widget-" + chatyWidgetId).find(".ch-pending-msg").remove();
                        clickStatus = checkChatyCookieExpired(chatyWidgetId, 'c-widget');
                        var widgetNonce = $("#chaty-widget-" + chatyWidgetId).data("nonce")
                        if (clickStatus) {
                            saveChatyCookieString(chatyWidgetId, 'c-widget');
                            isSingle = 0;
                            chatyChannels = [];
                            chatyChannel = $(this).data("channel");
                            clickStatus = checkChatyCookieExpired(chatyWidgetId, "c-" + chatyChannel);
                            if (clickStatus) {
                                chatyChannels.push(chatyChannel);
                                isSingle = 1;
                            }
                            if (!isBoatUser) {
                                $.ajax({
                                    url: chaty_settings.ajax_url,
                                    data: {
                                        widgetId: chatyWidgetId,
                                        userId: userId,
                                        isMobile: isChatyInMobile,
                                        channels: chatyChannels,
                                        isSingle: isSingle,
                                        nonce: widgetNonce,
                                        action: 'update_chaty_widget_click'
                                    },
                                    method: 'post',
                                });
                            }
                        }

                        /* checking for CTA status */
                        if ($("#chaty-widget-" + chatyWidgetId).hasClass("first_click")) {
                            $("#chaty-widget-" + chatyWidgetId + " .chaty-tooltip").removeClass("chaty-tooltip");
                            $("#chaty-widget-" + chatyWidgetId + " .single-channel a").addClass("chaty-tooltip");
                        }
                    } else if ($(this).hasClass("chaty-channel")) {
                        chatyChannel = $(this).data("channel");
                        clickStatus = checkChatyCookieExpired(chatyWidgetId, "c-" + chatyChannel);
                        if (clickStatus) {
                            saveChatyCookieString(chatyWidgetId, "c-" + chatyChannel);
                            var widgetNonce = $("#chaty-widget-" + chatyWidgetId).data("nonce");
                            if (!isBoatUser) {
                                $.ajax({
                                    url: chaty_settings.ajax_url,
                                    data: {
                                        widgetId: chatyWidgetId,
                                        userId: userId,
                                        isMobile: isChatyInMobile,
                                        channel: chatyChannel,
                                        nonce: widgetNonce,
                                        action: 'update_chaty_channel_click'
                                    },
                                    method: 'post',
                                });
                            }
                        }
                    }
                }
            }
        });

        $(document).on("submit", ".chaty-ajax-contact-form", function (e) {
            e.preventDefault();
            var inputErrorCounter = 0;
            $(this).find(".has-chaty-error").each(function () {
                $(this).removeClass("has-chaty-error");
            });
            $(this).find(".chaty-error-msg").remove();
            $(this).find(".chaty-ajax-error-message").remove();
            $(this).find(".chaty-ajax-success-message").remove();
            $(this).find(".is-required").each(function () {
                if (jQuery.trim($(this).val()) == "") {
                    inputErrorCounter++;
                    $(this).addClass("has-chaty-error");
                }
            });
            if (inputErrorCounter == 0) {
                var $form = $(this);
                $(".chaty-contact-submit-btn").attr("disabled", true);
                jQuery.ajax({
                    url: chaty_settings.ajax_url,
                    data: {
                        action: "chaty_front_form_save_data",
                        name: $form.find(".field-name").length ? $form.find(".field-name").val() : "",
                        email: $form.find(".field-email").length ? $form.find(".field-email").val() : "",
                        phone: $form.find(".field-phone").length ? $form.find(".field-phone").val() : "",
                        message: $form.find(".field-message").length ? $form.find(".field-message").val() : "",
                        nonce: $form.data("token"),
                        channel: $form.data("channel"),
                        widget: $form.data("index"),
                        ref_url: window.location.href
                    },
                    type: 'post',
                    async: true,
                    defer: true,
                    success: function (response) {
                        response = jQuery.parseJSON(response);
                        $(".chaty-ajax-error-message").remove();
                        $(".chaty-ajax-success-message").remove();
                        $(".chaty-contact-submit-btn").attr("disabled", false);
                        if (response.status == 1) {
                            $(".chaty-contact-inputs").append("<div class='chaty-ajax-success-message'>" + response.message + "</div>");
                            $(".field-name, .field-email, .field-message, .field-phone").val("");
                            if (response.redirect_action == "yes") {
                                if (response.link_in_new_tab == "yes") {
                                    window.open(response.redirect_link, '_blank');
                                } else {
                                    window.location = response.redirect_link;
                                }
                            }
                            if (response.close_form_after == "yes") {
                                setTimeout(function () {
                                    if ($(".chaty-outer-forms.active").length) {
                                        var widgetId = $(".chaty-outer-forms.active").data('widget');
                                        if (!isEmpty(widgetId) || widgetId == 0) {
                                            if ($("#chaty-widget-" + widgetId).length) {
                                                $("#chaty-widget-" + widgetId).removeClass("form-open");
                                                $(".chaty-outer-forms.active").removeClass("active");
                                                if ($("#chaty-widget-" + widgetId).find(".chaty-widget").hasClass("chaty-no-close-button")) {
                                                    $("#chaty-widget-" + widgetId).find(".chaty-widget").addClass("chaty-open")
                                                }
                                            }
                                        }
                                    }
                                }, parseInt(response.close_form_after_seconds) * 1000);
                            }
                        } else if (response.error == 1) {
                            if (response.errors.length) {
                                for (var i = 0; i < response.errors.length; i++) {
                                    $("." + response.errors[i].field).addClass("has-chaty-error");
                                    $("." + response.errors[i].field).after("<span class='chaty-error-msg'>" + response.errors[i].message + "</span>");
                                }
                            }
                        } else {
                            $(".chaty-contact-inputs").append("<div class='chaty-ajax-error-message'>" + response.message + "</div>");
                        }
                    }
                });
            } else {
                $(".has-chaty-error:first").focus();
            }
            return false;
        });

        /* Click function for Call */
        $(document).on("click", ".chaty-widget.has-single .chaty-i-trigger .chaty-channel:not(.chaty-agent-button).Phone-channel", function () {
            window.location = $(this).find("a").prop("href");
        });

        $(document).on("click", ".chaty-widget.has-single .chaty-i-trigger .chaty-channel:not(.chaty-agent-button).Phone-channel a", function (e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
        });
    });

    /**
     *
     * To remove animation when widget is clicked
     * Added On: 09/29/2021
     * Added By: Chirag Thummar
     *
     * */
    function removeChatyAnimation(widgetId) {
        if ($("#chaty-widget-" + widgetId).data("animation") != undefined && $("#chaty-widget-" + widgetId).data("animation") != "none") {
            var animationClass = "chaty-animation-" + $("#chaty-widget-" + widgetId).data("animation");
            $("#chaty-widget-" + widgetId + " ." + animationClass).removeClass(animationClass);
        }
    }

    function checkForCountry() {
        var hasCountryFilter = false;
        if (widgetData.length) {
            $.each(widgetData, function (key, widgetRecord) {
                if (isTrue(widgetRecord.triggers.has_countries) && !isEmpty(widgetRecord.triggers.countries) && widgetRecord.triggers.countries.length) {
                    hasCountryFilter = true;
                }
            });
        }
        if (hasCountryFilter) {
            clientCountry = getUserCountry();
            if (clientCountry != '') {
                startMakingWidgets();
            } else {
                getClientCountry();
            }
        } else {
            startMakingWidgets();
        }
    }

    /**
     *
     * Get client country from cloudflare API
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */

    function getClientCountry() {
        var $ipurl = 'https://www.cloudflare.com/cdn-cgi/trace';
        $.get($ipurl, function (cloudflaredata) {
            var currentCountry = cloudflaredata.match("loc=(.*)");
            if (currentCountry.length > 1) {
                currentCountry = currentCountry[1];
                if (currentCountry) {
                    currentCountry = currentCountry.toUpperCase();
                    if (currentCountry == "") {
                        currentCountry = "-";
                    }
                    setUserCountry(currentCountry);
                    startMakingWidgets();
                }
            }
        });
    }

    /**
     *
     * Creating widgets from API response
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */
    function startMakingWidgets() {
        if (widgetData.length) {
            $.each(widgetData, function (key, widgetRecord) {
                var customCSS = "";
                var advanceCustomCSS = "";
                var activeChannels = 0;
                var channelSetting = {};

                /* check for country filter */
                var widgetStatus = checkForUserCountry(widgetRecord);
                widgetStatus = widgetStatus && checkForTimeSchedule(widgetRecord);
                widgetStatus = widgetStatus && checkForDayAndTimeSchedule(widgetRecord);

                $.each(widgetRecord.channels, function (key, channel) {
                    var channelStatus = checkForChannel(channel);
                    if (channelStatus) {
                        activeChannels++;
                        channelSetting = channel;
                    }
                });

                if (widgetStatus && activeChannels > 0 && !$("#chaty-widget-" + widgetRecord.id).length) {
                    var widgetPosition = getWidgetPosition(widgetRecord.settings);
                    widgetPosition = (widgetPosition == "right") ? "right" : "left";
                    var toolTipPosition = getToolTipPosition(widgetRecord);
                    var widgetHtml = "<div style='display: none' class='chaty chaty-id-" + widgetRecord.id + " chaty-widget-" + widgetRecord.id + " chaty-key-" + key + "' id='chaty-widget-" + widgetRecord.id + "' data-key='" + key + "' data-id='" + widgetRecord.id + "' data-identifier='" + widgetRecord.identifier + "' data-nonce='" + widgetRecord.settings.widget_token + "' >" +
                        "<div class='chaty-widget " + widgetPosition + "-position'>" +
                        "<div class='chaty-channels'>" +
                        "<div class='chaty-channel-list'></div>" +
                        "<div class='chaty-i-trigger'></div>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                    $("body").append(widgetHtml);

                    if (isTrue(widgetRecord.triggers.auto_hide_widget) && parseInt(widgetRecord.triggers.hide_after) > 0) {
                        $("#chaty-widget-" + widgetRecord.id).addClass("auto-hide-chaty");
                        $("#chaty-widget-" + widgetRecord.id).attr("data-time", widgetRecord.triggers.hide_after);
                    }

                    var clickStatus = checkChatyCookieExpired(widgetRecord.id, 'c-widget');
                    $("#chaty-widget-" + widgetRecord.id).addClass(widgetRecord.settings.show_cta);
                    if (activeChannels == 1) {
                        if (widgetRecord.settings.icon_view != "vertical") {
                            toolTipPosition = (widgetPosition != "right") ? "right" : "left";
                        }
                        var channelHtml = getChannelSetting(channelSetting, widgetRecord.id, toolTipPosition);
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger").html(channelHtml);
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger").addClass("single-channel");
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel").addClass("single");

                        $("#chaty-widget-" + widgetRecord.id + " .chaty-widget").addClass("has-single");

                        var ctaText = widgetRecord.settings.cta_text;
                        if (widgetRecord.settings.show_cta == "first_click") {
                            if (clickStatus) {
                                $("#chaty-widget-" + widgetRecord.id + " .chaty-tooltip").removeClass("chaty-tooltip");
                                // $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel").attr("data-hover", ctaText);
                                // $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel a").attr("data-hover", ctaText);
                                $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel").addClass("active").addClass("chaty-tooltip").addClass("pos-"+toolTipPosition);

                                $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel").append("<span class='on-hover-text'>"+ctaText+"</span>").addClass("active").addClass("has-on-hover");
                                $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel a").append("<span class='on-hover-text'>"+ctaText+"</span>").addClass("has-on-hover");
                            } else {
                                // $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel").removeClass("active");
                                // $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel a").attr("data-hover", ctaText);
                                $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-channel a").append("<span class='on-hover-text'>"+ctaText+"</span>").removeClass("active").addClass("has-on-hover");
                            }
                        }
                        if (widgetRecord.settings.show_cta == "all_time") {
                            $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-tooltip").append("<span class='on-hover-text'>"+ctaText+"</span>").addClass("active").addClass("has-on-hover");
                        }

                        var channel = channelSetting;
                        if (channel.channel_type != "Instagram" || (channel.icon_color != "#ffffff" && channel.icon_color != "#fff")) {
                            customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .color-element{ fill: " + channel.icon_color + "; color: " + channel.icon_color + ";}";
                            customCSS += "#chaty-widget-" + widgetRecord.id + " .channel-icon-" + channel.channel_type + " .color-element{ fill: " + channel.icon_color + "; color: " + channel.icon_color + ";}";
                        }

                        customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .chaty-custom-icon { background-color: " + channel.icon_color + "; }";
                        customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .chaty-svg { background-color: " + channel.icon_color + ";}";
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .channel-icon-" + channel.channel_type + " .chaty-svg { background-color: " + channel.icon_color + ";}";


                        if(channel.channel_type == "Contact_Us") {
                            customCSS += ".chaty-contact-form-box #chaty-submit-button-" + widgetRecord.id + " {background-color: "+channel.contact_form_settings.button_bg_color+"; color: "+channel.contact_form_settings.button_text_color+";} ";
                        }
                    } else {
                        $.each(widgetRecord.channels, function (key, channel) {
                            var channelStatus = checkForChannel(channel);
                            if (channelStatus) {
                                if (isValueEmpty(channel.channel_type)) {
                                    channel.channel_type = channel.channel;
                                }

                                var channelHtml = getChannelSetting(channel, widgetRecord.id, toolTipPosition);
                                $("#chaty-widget-" + widgetRecord.id + " .chaty-channel-list").append(channelHtml);

                                if (channel.channel_type != "Instagram" || (channel.icon_color != "#ffffff" && channel.icon_color != "#fff")) {
                                    customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .color-element{ fill: " + channel.icon_color + "; color: " + channel.icon_color + ";}";
                                    customCSS += "#chaty-widget-" + widgetRecord.id + " .channel-icon-" + channel.channel_type + " .color-element{ fill: " + channel.icon_color + "; color: " + channel.icon_color + ";}";
                                }

                                customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .chaty-custom-icon { background-color: " + channel.icon_color + "; }";
                                customCSS += "#chaty-widget-" + widgetRecord.id + " ." + channel.channel_type + "-channel .chaty-svg { background-color: " + channel.icon_color + ";}";
                                customCSS += "#chaty-widget-" + widgetRecord.id + " .channel-icon-" + channel.channel_type + " .chaty-svg { background-color: " + channel.icon_color + ";}";

                                if(channel.channel_type == "Contact_Us") {
                                    customCSS += ".chaty-contact-form-box #chaty-submit-button-" + widgetRecord.id + " {background-color: "+channel.contact_form_settings.button_bg_color+"; color: "+channel.contact_form_settings.button_text_color+";} ";
                                }
                            }
                        });

                        var widgetIcon = getWidgetIcon(widgetRecord.settings, widgetRecord.id);
                        /* check for widget CTA button */
                        var ctaText = widgetRecord.settings.cta_text;
                        if (widgetRecord.settings.show_cta == "first_click") {
                            if (!clickStatus) {
                                ctaText = "";
                            }
                        }

                        var ctaToolTipPosition = toolTipPosition;
                        if (widgetRecord.settings.icon_view == "horizontal") {
                            if (widgetPosition == "left") {
                                ctaToolTipPosition = "right";
                            } else {
                                ctaToolTipPosition = "left";
                            }
                        }

                        var widgetButton = '<div class="chaty-channel chaty-cta-main chaty-tooltip has-on-hover pos-' + ctaToolTipPosition + ' active" data-widget="' + widgetRecord.id + '" >' +
                            '<span class="on-hover-text">'+ctaText+'</span>' +
                            '<div class="chaty-cta-button">' +
                            '<button type="button" class="open-chaty">' +
                            widgetIcon +
                            '</button>' +
                            '<button type="button" class="open-chaty-channel"></button>' +
                            '</div>' +
                            '</div>';
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger").html(widgetButton);

                        /* close button */
                        var closeHtml = '<div class="chaty-channel chaty-cta-close chaty-tooltip pos-' + toolTipPosition + '" data-hover="' + widgetRecord.settings.close_text + '">' +
                            '<div class="chaty-cta-button"><button type="button">' +
                            '<span class="chaty-svg">' +
                            '<svg viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="26" cy="26" rx="26" ry="26" fill="' + widgetRecord.settings.widget_color + '"></ellipse><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(18.35 15.6599) scale(0.998038 1.00196) rotate(45)" fill="white"></rect><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(37.5056 18.422) scale(0.998038 1.00196) rotate(135)" fill="white"></rect></svg>' +
                            '</span>' +
                            '</button>' +
                            '</div>' +
                            '</div>';
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger").append(closeHtml);
                    }

                    var clickStatus = checkChatyCookieExpired(widgetRecord.id, 'c-widget');
                    if (clickStatus && (widgetRecord.settings.default_state != "open" || activeChannels == 1)) {
                        checkForPendingMessage(widgetRecord.settings, widgetRecord.id);
                        checkForWidgetAnimation(widgetRecord.settings, widgetRecord.id);
                    }

                    var extraSpace = 0;
                    /* check for close button */
                    if (widgetRecord.settings.default_state == "open" && !isTrue(widgetRecord.settings.show_close_button)) {
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-widget").addClass("chaty-no-close-button").addClass("chaty-open");
                        extraSpace = 1;
                    }

                    /* checking for google analytics */
                    if (isTrue(widgetRecord.settings.is_google_analytics_enabled)) {
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-channel-list .chaty-channel").addClass("has-gae");
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger.single-channel .chaty-channel").addClass("has-gae");

                        $(".chaty-outer-forms.chaty-whatsapp-form.chaty-form-" + widgetRecord.id + " form.add-analytics").addClass("form-google-analytics");
                    }

                    /* checking for custom CSS */
                    if (isTrue(widgetRecord.settings.has_custom_css) && !isEmpty(widgetRecord.settings.custom_css)) {
                        advanceCustomCSS += widgetRecord.settings.custom_css;
                    }

                    /* check for State */
                    if (widgetRecord.settings.default_state == "hover") {
                        $("#chaty-widget-" + widgetRecord.id).addClass("open-on-hover");
                    } else if (widgetRecord.settings.default_state == "open") {
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-widget").addClass("default-open");
                        if (clickStatus || !isTrue(widgetRecord.settings.show_close_button)) {
                            $("#chaty-widget-" + widgetRecord.id + " .chaty-widget").addClass("chaty-open");
                        }
                    }

                    /* set widget channel height */
                    var widgetSize = getWidgetSize(widgetRecord.settings.widget_size, widgetRecord.settings.custom_widget_size);
                    widgetSize = parseInt(widgetSize);
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel > a {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel > a .chaty-custom-icon {display:block; width: " + widgetSize + "px; height: " + widgetSize + "px; line-height: " + widgetSize + "px; font-size: " + parseInt(widgetSize / 2) + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel button {width: " + widgetSize + "px; height: " + widgetSize + "px; margin: 0; padding:0; outline: none; border-radius: 50%;}";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel .chaty-svg {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel .chaty-svg img {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel span.chaty-icon {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel a {width: " + widgetSize + "px; height: " + widgetSize + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel .chaty-svg .chaty-custom-channel-icon {width: " + widgetSize + "px; height: " + widgetSize + "px; line-height: " + widgetSize + "px; display: block; font-size:" + (parseInt(widgetSize / 2)) + "px; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-cta-button {background-color: " + widgetRecord.settings.widget_color + "; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .chaty-cta-button button {background-color: " + widgetRecord.settings.widget_color + "; }";

                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-i-trigger .ch-pending-msg {background-color: " + widgetRecord.settings.pending_mesg_count_bgcolor + "; color: " + widgetRecord.settings.pending_mesg_count_color + "; }";

                    

                    if (widgetRecord.settings.icon_view == "vertical") {
                        //customCSS += "#chaty-widget-"+widgetRecord.id+" .chaty-channel-list {bottom: "+(widgetSize+4)+"px; }";
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel-list {height: " + (activeChannels * (widgetSize + 8)) + "px; }";
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel-list {width: " + (widgetSize + 8) + "px; }";

                        for (var i = 0; i <= activeChannels; i++) {
                            customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-open .chaty-channel-list .chaty-channel:nth-child(" + (i + 1) + ") {-webkit-transform: translateY(-" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px); transform: translateY(-" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px);}";
                        }
                    } else {
                        $("#chaty-widget-" + widgetRecord.id + " .chaty-widget").addClass("hor-mode");
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel-list {width: " + (activeChannels * (widgetSize + 8)) + "px; }";
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-channel-list {height: " + (widgetSize) + "px; }";
                        // customCSS += "#chaty-widget-"+widgetRecord.id+" .chaty-widget.left-position.hor-mode .chaty-channel-list {left: "+(widgetSize+8)+"px; }";
                        // customCSS += "#chaty-widget-"+widgetRecord.id+" .chaty-widget.right-position.hor-mode .chaty-channel-list {right: "+(widgetSize+8)+"px; }";

                        for (var i = 0; i <= activeChannels; i++) {
                            customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-widget.left-position.hor-mode.chaty-open .chaty-channel-list .chaty-channel:nth-child(" + (i + 1) + ") {-webkit-transform: translateX(" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px); transform: translateX(" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px);}";
                            customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-widget.right-position.hor-mode.chaty-open .chaty-channel-list .chaty-channel:nth-child(" + (i + 1) + ") {-webkit-transform: translateX(-" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px); transform: translateX(-" + ((widgetSize + 8) * (activeChannels - i - extraSpace)) + "px);}";
                        }
                    }


                    /* set widget position */
                    var bottomSpacing = widgetRecord.settings.bottom_spacing;
                    var sideSpacing = widgetRecord.settings.side_spacing;
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-widget {bottom: "+(bottomSpacing)+"px}";

                    if (widgetPosition == "left") {
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-widget {left: " + sideSpacing + "px; right: auto;}";
                        customCSS += ".chaty-outer-forms.pos-left.chaty-form-" + widgetRecord.id + " {left: " + sideSpacing + "px}";
                        $(".chaty-form-" + widgetRecord.id).addClass("pos-left");
                    } else {
                        customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-widget {right: " + sideSpacing + "px; left:auto;}";
                        $(".chaty-form-" + widgetRecord.id).addClass("pos-right");
                        customCSS += ".chaty-outer-forms.pos-right.chaty-form-" + widgetRecord.id + " {right: " + sideSpacing + "px; left:auto;}";
                    }
                    $(".chaty-form-" + widgetRecord.id).show();

                    var formBottomPos = widgetSize + 15 + parseInt(bottomSpacing)
                    customCSS += ".chaty-outer-forms.active.chaty-form-" + widgetRecord.id + " {-webkit-transform: translateY(-"+formBottomPos+"px); transform: translateY(-"+formBottomPos+"px)} ";

                    /* set on hover text color */
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip:after {background-color: " + widgetRecord.settings.cta_bg_color + "; color: " + widgetRecord.settings.cta_text_color + "}";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-top:before {border-top-color: " + widgetRecord.settings.cta_bg_color + "; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-left:before {border-left-color: " + widgetRecord.settings.cta_bg_color + "; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-right:before {border-right-color: " + widgetRecord.settings.cta_bg_color + ";}";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .on-hover-text {background-color: " + widgetRecord.settings.cta_bg_color + "; color: " + widgetRecord.settings.cta_text_color + "}";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-top .on-hover-text:before {border-top-color: " + widgetRecord.settings.cta_bg_color + "; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-left .on-hover-text:before {border-left-color: " + widgetRecord.settings.cta_bg_color + "; }";
                    customCSS += "#chaty-widget-" + widgetRecord.id + " .chaty-tooltip.pos-right .on-hover-text:before {border-right-color: " + widgetRecord.settings.cta_bg_color + ";}";

                    /* checking for triggers */
                    var visibleStatus = checkChatyCookieExpired(widgetRecord.id, 'v-widget');

                    if (visibleStatus) {
                        if (isTrue(widgetRecord.triggers.exit_intent) || (isTrue(widgetRecord.triggers.has_time_delay) && parseInt(widgetRecord.triggers.time_delay) > 0) || (isTrue(widgetRecord.triggers.has_display_after_page_scroll) && parseInt(widgetRecord.triggers.display_after_page_scroll) > 0)) {
                            /* checking for time delay */

                            if ((isTrue(widgetRecord.triggers.has_time_delay) && parseInt(widgetRecord.triggers.time_delay) > 0)) {
                                chatyHasTimeDelay = true;
                                if (parseInt(widgetRecord.triggers.time_delay) > chatyMaxTimeInterval) {
                                    chatyMaxTimeInterval = widgetRecord.triggers.time_delay;
                                }
                                $("#chaty-widget-" + widgetRecord.id).addClass("on-chaty-delay");
                                $("#chaty-widget-" + widgetRecord.id).addClass("delay-time-" + parseInt(widgetRecord.triggers.time_delay));
                                $("#chaty-widget-" + widgetRecord.id).attr("data-time", parseInt(widgetRecord.triggers.time_delay));
                            }

                            /* checking for page scroll */
                            if ((isTrue(widgetRecord.triggers.has_display_after_page_scroll) && parseInt(widgetRecord.triggers.display_after_page_scroll) > 0)) {
                                chatyHasPageScroll = true;
                                $("#chaty-widget-" + widgetRecord.id).addClass("on-chaty-scroll");
                                $("#chaty-widget-" + widgetRecord.id).addClass("page-scroll-" + parseInt(widgetRecord.triggers.display_after_page_scroll));
                                $("#chaty-widget-" + widgetRecord.id).attr("data-scroll", parseInt(widgetRecord.triggers.display_after_page_scroll));
                            }

                            /* checking for exit intent */
                            if (isTrue(widgetRecord.triggers.exit_intent)) {
                                chatyHasExitIntent = true;
                                $("#chaty-widget-" + widgetRecord.id).addClass("on-chaty-exit-intent");
                            }
                        } else {
                            // saveChatyCookieString(widgetRecord.id, 'v-widget');
                            updateWidgetViews(widgetRecord.id);
                            $("#chaty-widget-" + widgetRecord.id).addClass("active");
                        }
                    } else {
                        updateWidgetViews(widgetRecord.id);
                        $("#chaty-widget-" + widgetRecord.id).addClass("active");
                    }

                    /* check for font family */
                    if (!isEmpty(widgetRecord.settings.font_family) && widgetRecord.settings.font_family != "none") {

                        /* check for default browser font */
                        var fontFamily = widgetRecord.settings.font_family;
                        if ($.inArray(fontFamily, defaultFontFamily) != -1) {
                            if (fontFamily == "System Stack") {
                                fontFamily = "-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen-Sans,Ubuntu,Cantarell,Helvetica Neue,sans-serif";
                            }
                        } else {
                            /* load fonts from google */
                            $('head').append('<link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=' + fontFamily + '&display=swap">');
                            $('head').append('<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' + fontFamily + '&display=swap">');
                        }
                        customCSS += "#chaty-widget-" + widgetRecord.id + ", #chaty-widget-" + widgetRecord.id + " .chaty-tooltip:after {font-family: " + fontFamily + "}";
                    }
                }

                if(chatyHasExitIntent) {
                    bindExitIntentFunction();
                }

                /* set dynamic CSS for widget */
                if (customCSS != "") {
                    if (!$("#custom-chaty-css").length) {
                        $("head").append("<style id='custom-chaty-css'></style>");
                    }
                    $("#custom-chaty-css").append(customCSS);
                }

                /* set dynamic CSS for widget */
                if (advanceCustomCSS != "") {
                    if (!$("#custom-advance-chaty-css").length) {
                        $("head").append("<style id='custom-advance-chaty-css'></style>");
                    }
                    $("#custom-advance-chaty-css").append(advanceCustomCSS);
                }

                if (key == (widgetData.length - 1)) {

                }
            });
            if (!$("#custom-advance-chaty-css").length) {
                $("head").append("<style id='custom-advance-chaty-css'></style>");
            }
            $("#custom-advance-chaty-css").append(customExtraCSS);
        }

        removeEmptyTooltip();
        checkForchatyTriggers();
    }


    /**
     *
     * Checking for Channel (is normal chhanel or agent channel)
     * Added On: 10/19/2021
     * Added By: Chirag Thummar
     *
     * */

    function checkForChannel(channel) {
        if (isTrue(channel.is_agent)) {
            if (channel.agent_data.length) {
                if (((!isChatyInMobile && isTrue(channel.is_agent_desktop)) || (isChatyInMobile && isTrue(channel.is_agent_mobile)))) {
                    return true;
                }
            }
        } else {
            if (((!isChatyInMobile && isTrue(channel.is_desktop)) || (isChatyInMobile && isTrue(channel.is_mobile))) && (channel.value != '' || channel.channel == "Contact_Us")) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * Update widget views
     * Added On: 10/19/2021
     * Added By: Chirag Thummar
     *
     * */

    function updateWidgetViews(widgetId) {
        if ($("#chaty-widget-" + widgetId + " .chaty-channel.chaty-default-open").length) {
            // $(".chaty-outer-forms").show();
            var dataForm = $("#chaty-widget-" + widgetId + " .chaty-channel.chaty-default-open a.chaty-whatsapp-form").data('form');
            if (!isEmpty(dataForm)) {
                var clickStatus = checkChatyCookieExpired(widgetId, "c-" + $("#chaty-widget-" + widgetId + " .chaty-channel.chaty-default-open").data('channel'));
                if (clickStatus) {
                    $("#" + dataForm).addClass("is-active");
                    if ($("#" + dataForm).length) {
                        var buttonHtml = $("#chaty-widget-" + widgetId + " .chaty-channel.chaty-default-open a.chaty-whatsapp-form").html();

                        removeChatyAnimation(widgetId);
                        $("#chaty-widget-" + widgetId   ).find(".ch-pending-msg").remove();
                        $("#chaty-widget-" + widgetId + " .chaty-widget").removeClass("chaty-open");
                        $("#chaty-widget-" + widgetId).addClass("form-open");
                        $("#" + dataForm).addClass("active");

                        $("#chaty-widget-" + widgetId + " .open-chaty-channel").html(buttonHtml);
                        $("#chaty-widget-" + widgetId).addClass("active");

                        $("#chaty-widget-" + widgetId).addClass("active");
                        if ($("#chaty-widget-" + widgetId).hasClass("auto-hide-chaty")) {
                            var hideAfter = parseInt($("#chaty-widget-" + widgetId).data("time"));
                            if (hideAfter > 0) {
                                hideAfter = hideAfter + chatyHideIntervalTime;
                                $("#chaty-widget-" + widgetId).addClass("hide-after-" + hideAfter);
                            }
                        }

                        if (chaty_settings.data_analytics_settings == "on") {
                            var widgetChannels = [];
                            var widgetChannel = $("#chaty-widget-" + widgetId + " .chaty-channel.chaty-default-open").data('channel');
                            var viewChannelStatus = checkChatyCookieExpired(widgetId, "v-" + widgetChannel);

                            if (viewChannelStatus && typeof widgetChannel != 'undefined') {
                                saveChatyCookieString(widgetId, "v-" + widgetChannel);
                                widgetChannels.push(widgetChannel);
                            }

                            if (!isBoatUser && widgetChannels.length) {
                                var widgetNonce = $("#chaty-widget-" + widgetId).data("nonce");
                                $.ajax({
                                    url: chaty_settings.ajax_url,
                                    data: {
                                        widgetId: widgetId,
                                        channels: widgetChannels,
                                        userId: widgetId,
                                        isMobile: isChatyInMobile,
                                        widgetNonce: widgetNonce,
                                        action: 'update_chaty_channel_views',
                                    },
                                    type: 'post',
                                    success: function (response) {

                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        monitorErrorLog(XMLHttpRequest, textStatus, errorThrown);
                                    }
                                });
                            }
                        }
                        return;
                    }
                }
            }
        }

        $("#chaty-widget-" + widgetId).addClass("active");
        if ($("#chaty-widget-" + widgetId).hasClass("auto-hide-chaty")) {
            var hideAfter = parseInt($("#chaty-widget-" + widgetId).data("time"));
            if (hideAfter > 0) {
                hideAfter = hideAfter + chatyHideIntervalTime;
                $("#chaty-widget-" + widgetId).addClass("hide-after-" + hideAfter);
            }
        }

        var viewStatus = checkChatyCookieExpired(widgetId, "v-widget");
        if (viewStatus) {
            saveChatyCookieString(widgetId, 'v-widget');
            var userId = $("#chaty-widget-" + widgetId).data("user");
            var widgetChannels = [];
            var isSingle = 0;
            var isDefaultOpen = 0;
            var widgetChannel;
            var widgetKey = $("#chaty-widget-" + widgetId).data("key");
            if (typeof widgetData[widgetKey] != undefined) {
                var activeWidgets = chatyGetCookie("activechatyWidgets");
                if (activeWidgets != null) {
                    activeWidgets = activeWidgets.split(",");
                    if ($.inArray(widgetId, activeWidgets) == -1) {
                        activeWidgets.push(widgetId);
                        activeWidgets = activeWidgets.join(",");
                        chatySetCookie("activechatyWidgets", activeWidgets, 1);
                    }
                } else {
                    activeWidgets = widgetId;
                    chatySetCookie("activechatyWidgets", activeWidgets, 1);
                }
            }
            if ($("#chaty-widget-" + widgetId + " .chaty-widget").hasClass("has-single")) {
                isSingle = 1;
                widgetChannel = $("#chaty-widget-" + widgetId + " .chaty-channel").data("channel");
                var viewChannelStatus = checkChatyCookieExpired(widgetId, "v-" + widgetChannel);
                if (viewChannelStatus && typeof widgetChannel != 'undefined') {
                    saveChatyCookieString(widgetId, "v-" + widgetChannel);
                    widgetChannels.push(widgetChannel);
                }
            } else if ($("#chaty-widget-" + widgetId + " .chaty-widget").hasClass("chaty-open")) {
                isDefaultOpen = 1;
                $("#chaty-widget-" + widgetId + " .chaty-channel-list .chaty-channel").each(function () {
                    widgetChannel = $(this).data("channel");
                    var viewChannelStatus = checkChatyCookieExpired(widgetId, "v-" + widgetChannel);
                    if (viewChannelStatus && typeof widgetChannel != 'undefined') {
                        saveChatyCookieString(widgetId, "v-" + widgetChannel);
                        widgetChannels.push(widgetChannel);
                    }
                });
            }
            if (viewStatus && !isBoatUser) {
                var widgetNonce = $("#chaty-widget-" + widgetId).data("nonce");
                if (!isBoatUser) {
                    $.ajax({
                        url: chaty_settings.ajax_url,
                        data: {
                            widgetId: widgetId,
                            channels: widgetChannels,
                            userId: widgetId,
                            isMobile: isChatyInMobile,
                            isOpen: isDefaultOpen,
                            isSingle: isSingle,
                            widgetNonce: widgetNonce,
                            action: 'update_chaty_widget_views',
                        },
                        type: 'post',
                        success: function (response) {

                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            monitorErrorLog(XMLHttpRequest, textStatus, errorThrown);
                        }
                    });
                }
            }
        }
    }

    /**
     *
     * check for visitor status and update it if required
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function updateVisitorCount(widgetId) {
        var userId = $("#chaty-widget-" + widgetId).data("user");
        var isOldUser = chatySaasCheckCookie("triggeredFor" + userId);
        if (!isOldUser) {
            chatySetCookie("triggeredFor" + userId, widgetId, 2);
            /*$.ajax({
                url: VISITOR_COUNT_API,
                data: {
                    widgetId: widgetId,
                    channels: [],
                    userId: userId
                },
                type: 'post',
                success: function (response) {

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    monitorErrorLog(XMLHttpRequest, textStatus, errorThrown);
                }
            });*/
        }
    }

    /**
     *
     * Check for Triggers if exists
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */

    function getWidgetSize(widgetSize, customSize) {
        return widgetSize;
    }

    /**
     *
     * To get widget CTA icon by it's key
     * Added On: 09/29/2021
     * Added By: Chirag Thummar
     *
     * */
    function getSvgIcon(iconName, widgetColor) {
        switch (iconName) {
            case"chat-smile":
                return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.8 507.1 54 54" style="enable-background-color:new -496.8 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;} .chaty-sts2{fill:none;stroke:#808080;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;}</style><g><circle cx="-469.8" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-459.5,523.5H-482c-2.1,0-3.7,1.7-3.7,3.7v13.1c0,2.1,1.7,3.7,3.7,3.7h19.3l5.4,5.4c0.2,0.2,0.4,0.2,0.7,0.2c0.2,0,0.2,0,0.4,0c0.4-0.2,0.6-0.6,0.6-0.9v-21.5C-455.8,525.2-457.5,523.5-459.5,523.5z"/><path class="chaty-sts2" d="M-476.5,537.3c2.5,1.1,8.5,2.1,13-2.7"/><path class="chaty-sts2" d="M-460.8,534.5c-0.1-1.2-0.8-3.4-3.3-2.8"/></svg>';
            case"chat-bubble":
                return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496.9 507.1 54 54" style="enable-background-color:new -496.9 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;}</style><g><circle  cx="-469.9" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-472.6,522.1h5.3c3,0,6,1.2,8.1,3.4c2.1,2.1,3.4,5.1,3.4,8.1c0,6-4.6,11-10.6,11.5v4.4c0,0.4-0.2,0.7-0.5,0.9   c-0.2,0-0.2,0-0.4,0c-0.2,0-0.5-0.2-0.7-0.4l-4.6-5c-3,0-6-1.2-8.1-3.4s-3.4-5.1-3.4-8.1C-484.1,527.2-478.9,522.1-472.6,522.1z   M-462.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-464.6,534.6-463.9,535.3-462.9,535.3z   M-469.9,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-471.7,534.6-471,535.3-469.9,535.3z   M-477,535.3c1.1,0,1.8-0.7,1.8-1.8c0-1.1-0.7-1.8-1.8-1.8c-1.1,0-1.8,0.7-1.8,1.8C-478.8,534.6-478.1,535.3-477,535.3z"/></svg>';
            case"chat-db":
                return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.1 54 54" style="enable-background-color:new -496 507.1 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill:#FFFFFF;}</style><g><circle  cx="-469" cy="534.1" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-464.6,527.7h-15.6c-1.9,0-3.5,1.6-3.5,3.5v10.4c0,1.9,1.6,3.5,3.5,3.5h12.6l5,5c0.2,0.2,0.3,0.2,0.7,0.2c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18.2C-461.1,529.3-462.7,527.7-464.6,527.7z"/><path class="chaty-sts1" d="M-459.4,522.5H-475c-1.9,0-3.5,1.6-3.5,3.5h13.9c2.9,0,5.2,2.3,5.2,5.2v11.6l1.9,1.9c0.2,0.2,0.3,0.2,0.7,0.2c0.2,0,0.2,0,0.3,0c0.3-0.2,0.5-0.5,0.5-0.9v-18C-455.9,524.1-457.5,522.5-459.4,522.5z"/></svg>';
            default:
                return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-496 507.7 54 54" style="enable-background-color:new -496 507.7 54 54;" xml:space="preserve"><style type="text/css">.chaty-sts1{fill: #FFFFFF;}.chaty-st0{fill: #808080;}</style><g><circle cx="-469" cy="534.7" r="27" fill="' + widgetColor + '"/></g><path class="chaty-sts1" d="M-459.9,523.7h-20.3c-1.9,0-3.4,1.5-3.4,3.4v15.3c0,1.9,1.5,3.4,3.4,3.4h11.4l5.9,4.9c0.2,0.2,0.3,0.2,0.5,0.2 h0.3c0.3-0.2,0.5-0.5,0.5-0.8v-4.2h1.7c1.9,0,3.4-1.5,3.4-3.4v-15.3C-456.5,525.2-458,523.7-459.9,523.7z"/><path class="chaty-st0" d="M-477.7,530.5h11.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-11.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,530.8-478.2,530.5-477.7,530.5z"/><path class="chaty-st0" d="M-477.7,533.5h7.9c0.5,0,0.8,0.4,0.8,0.8l0,0c0,0.5-0.4,0.8-0.8,0.8h-7.9c-0.5,0-0.8-0.4-0.8-0.8l0,0C-478.6,533.9-478.2,533.5-477.7,533.5z"/></svg>'
        }
    }

    /**
     *
     * To get channel settings
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */

    function getChannelSetting(channel, widgetId, toolTipPosition) {
        var extraClass = "";
        if (isTrue(channel.is_agent)) {
            if (channel.agent_data.length) {
                var activeAgents = 0;
                var activeAgent = [];
                $.each(channel.agent_data, function (key, agent) {
                    if (agent.value != "") {
                        activeAgents++;
                        activeAgent = agent;
                    }
                });
                if (activeAgents > 0) {
                    var channelIcon, channelLink;
                    var widgetIndex = getWidgetIndex(widgetId);
                    if (widgetIndex == null) {
                        widgetIndex = -1;
                    }
                    createAgentList(channel, widgetId);
                    channelIcon = getChannelIcon(channel, widgetId);
                    channelLink = getChannelURL(channel, channelIcon, toolTipPosition, widgetId);

                    if (channel.channel != "Instagram" || (channel.icon_color != "#ffffff" && channel.icon_color != "#fff")) {
                        customExtraCSS += ".chaty-agent-" + widgetId + "-" + channel.channel + " .color-element {fill: " + channel.icon_color + "; color: " + channel.icon_color + ";}";
                    }
                    customExtraCSS += ".chaty-agent-" + widgetId + "-" + channel.channel + " .chaty-custom-icon { background-color: " + channel.icon_color + ";}";
                    customExtraCSS += ".chaty-agent-" + widgetId + "-" + channel.channel + " .chaty-svg-img { background-color: " + channel.icon_color + ";}";
                    return "<div data-form='chaty-form-" + widgetId + "-" + channel.channel_type + "' class='chaty-channel chaty-agent-button chaty-agent-" + widgetId + "-" + channel.channel + " " + channel.channel + "-channel" + extraClass + "' id='" + channel.channel + "-" + widgetId + "-channel' data-id='" + channel.channel_type + "-" + widgetId + "' data-widget='" + widgetId + "' data-channel='" + channel.channel + "'>" + channelLink + "</div>";

                }
            }
        } else {
            if (isValueEmpty(channel.channel_type)) {
                channel.channel_type = channel.channel;
            }
            var channelIcon = getChannelIcon(channel, widgetId);
            var channelLink = getChannelURL(channel, channelIcon, toolTipPosition, widgetId);
            if (channel.channel_type == "Contact_Us") {
                extraClass += " has-chaty-box chaty-contact-form";
            } else if (channel.channel_type == "Whatsapp") {
                if (isTrue(channel.has_welcome_message) && !isEmpty(channel.chat_welcome_message)) {
                    if (isTrue(channel.is_default_open)) {
                        var clickStatus = checkChatyCookieExpired(widgetId, "c-" + channel.channel_type);
                        if (clickStatus) {
                            extraClass += " chaty-default-open"
                        }
                    }
                }
            }
            return "<div class='chaty-channel " + channel.channel + "-channel" + extraClass + "' id='" + channel.channel + "-" + widgetId + "-channel' data-id='" + channel.channel_type + "-" + widgetId + "' data-widget='" + widgetId + "' data-channel='" + channel.channel + "'>" + channelLink + "</div>";
        }
    }


    function createAgentList(channel, widgetId) {
        var formHtml = "";
        var widgetIndex = getWidgetIndex(widgetId);
        if (widgetIndex == null) {
            widgetIndex = -1;
        }
        formHtml += "<div style='display:none;' class='chaty-outer-forms chaty-agent-data chaty-agent-data-" + widgetId + " chaty-form-" + widgetId + "' data-channel='" + channel.channel_type + "' id='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-widget='" + widgetId + "' data-index='" + widgetIndex + "'>";
        formHtml += "<div class='chaty-form'>";
        formHtml += "<div class='chaty-form-body'>";
        formHtml += "<div role='button' class='chaty-close-agent-list'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 330 330' xmlns:v='https://vecta.io/nano'><path d='M325.607 79.393c-5.857-5.857-15.355-5.858-21.213.001l-139.39 139.393L25.607 79.393c-5.857-5.857-15.355-5.858-21.213.001s-5.858 15.355 0 21.213l150.004 150a15 15 0 0 0 21.212-.001l149.996-150c5.859-5.857 5.859-15.355.001-21.213z'/></svg></div>";
        formHtml += "<div class='chaty-agent-header agent-info-" + widgetId + "-" + channel.channel + "'>";
        if (!isEmpty(channel.header_text)) {
            formHtml += "<div class='agent-main-header'>" + channel.header_text + "</div>";
        }
        if (!isEmpty(channel.header_sub_text)) {
            formHtml += "<div class='agent-sub-header'>" + channel.header_sub_text + "</div>";
        }
        formHtml += "</div>";
        $.each(channel.agent_data, function (key, agent) {
            if (agent.value != "") {
                var agentIcon = agent.svg_icon;
                if (!isEmpty(agent.agent_image)) {
                    agentIcon = "<img class='chaty-agent-img' src='" + agent.agent_image + "' alt='" + agent.agent_title + "' />"
                }
                var agentLink = getAgentURL(agent, channel, widgetId, key, agentIcon, agent.agent_title);
                formHtml += "<div class='chaty-agent agent-info-" + widgetId + "-" + channel.channel + " agent-info-" + key + "'>" + agentLink + "</div>";
            }
            customExtraCSS += ".agent-info-" + widgetId + "-" + channel.channel + ".agent-info-" + key + " .chaty-agent-icon img { background-color: " + agent.agent_bg_color + "; } ";
            if (channel.channel != "Instagram" || (agent.agent_bg_color != "#ffffff" && agent.agent_bg_color != "#fff")) {
                customExtraCSS += ".agent-info-" + widgetId + "-" + channel.channel + ".agent-info-" + key + " .chaty-agent-icon .color-element { fill: " + agent.agent_bg_color + "; } ";
            }
            customExtraCSS += ".agent-info-" + widgetId + "-" + channel.channel + ".agent-info-" + key + " .chaty-custom-icon { background-color: " + agent.agent_bg_color + "; } ";
        });
        formHtml += "</div>";
        formHtml += "</div>";
        formHtml += "</div>";
        customExtraCSS += ".chaty-agent-header.agent-info-" + widgetId + "-" + channel.channel + " { background-color: " + channel.header_bg_color + "; color: " + channel.header_text_color + " } ";
        customExtraCSS += ".agent-info-" + widgetId + "-" + channel.channel + " .chaty-close-agent-list svg { fill: " + channel.header_text_color + " } ";
        $("body").append(formHtml);
    }

    function getAgentChannelURL(channel, agent, widgetId, channelIcon, toolTipPosition) {
        var agentURL = agent.value;
        var agentTarget = "_blank";
        if (channel.channel_type == "Whatsapp") {
            var whatsAppNumber = getWhatsAppNumber(agent.value);
            if (isChatyInMobile) {
                agentTarget = "";
                agentURL = "https://wa.me/" + whatsAppNumber;
            } else {
                agentTarget = "_blank";
                agentURL = "https://web.whatsapp.com/send?phone=" + whatsAppNumber;
            }
        } else if (channel.channel_type == "WeChat") {
            agentTarget = "";
            agentURL = "javascript:;";
        } else if (channel.channel_type == "Email") {
            agentTarget = "";
            agentURL = "mailto:" + agent.value;
        } else if (channel.channel_type == "Facebook_Messenger") {
            if (isChatyInMobile) {
                agentTarget = "";
            } else {
                agentTarget = "_blank";
            }
        } else if (channel.channel_type == "SMS") {
            agentTarget = "";
            agentURL = "sms:" + agent.value;
        } else if (channel.channel_type == "Telegram") {
            agentURL = trimChar(agent.value, "@");
            agentURL = "https://telegram.me/" + agentURL;
            agentTarget = "_blank";
        } else if (channel.channel_type == "Twitter") {
            agentURL = "https://twitter.com/" + $.trim(agent.value);
        } else if (channel.channel_type == "Phone") {
            agentTarget = "";
            agentURL = "tel:" + $.trim(agent.value);
        } else if (channel.channel_type == "Skype") {
            agentTarget = "";
            agentURL = "skype:" + $.trim(agent.value) + "?chat";
        } else if (channel.channel_type == "Snapchat") {
            agentURL = "https://www.snapchat.com/add/" + $.trim(agent.value);
        } else if (channel.channel_type == "Vkontakte") {
            agentURL = "https://vk.me/" + $.trim(agent.value);
        } else if (channel.channel_type == "Linkedin") {
            if (agent.link_type == "personal") {
                agentURL = "https://www.linkedin.com/in/" + $.trim(agent.value);
            } else {
                agentURL = "https://www.linkedin.com/company/" + $.trim(agent.value);
            }
        } else if (channel.channel_type == "Viber") {
            agentURL = trimChar(agent.value, "+");
            if (!isNaN(agentURL)) {
                agentURL = agentURL.replace("+", "");
                if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
                    agentURL = "+" + agentURL;
                }
                agentURL = "viber://chat?number=" + agentURL;
            }
            agentTarget = "";
        } else if (channel.channel_type == "TikTok") {
            agentURL = trimChar($.trim(agent.value), "@");
            agentURL = "https://www.tiktok.com/@" + agentURL;
            agentTarget = "";
        }
        return "<a href='" + agentURL + "' target='" + agentTarget + "' class='chaty-tooltip pos-" + toolTipPosition + "' data-form='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-hover='" + channel.hover_text + "'>" + channelIcon + "</a>";
    }

    function getAgentURL(agent, channel, widgetId, key, agentIcon, agentTitle) {
        var agentURL = agent.value;
        var agentTarget = "_blank";
        if (channel.channel_type == "Whatsapp") {
            var whatsAppNumber = getWhatsAppNumber(agent.value);
            if (isChatyInMobile) {
                agentTarget = "";
                agentURL = "https://wa.me/" + whatsAppNumber;
            } else {
                agentTarget = "_blank";
                agentURL = "https://web.whatsapp.com/send/?phone=" + whatsAppNumber;
            }
        } else if (channel.channel_type == "WeChat") {
            agentTarget = "";
            agentURL = "javascript:;";
        } else if (channel.channel_type == "Email") {
            agentTarget = "";
            agentURL = "mailto:" + agent.value;
        } else if (channel.channel_type == "Facebook_Messenger") {
            if (isChatyInMobile) {
                agentTarget = "";
            } else {
                agentTarget = "_blank";
            }
        } else if (channel.channel_type == "SMS") {
            agentTarget = "";
            agentURL = "sms:" + agent.value;
        } else if (channel.channel_type == "Telegram") {
            agentURL = trimChar(agent.value, "@");
            agentURL = "https://telegram.me/" + agentURL;
            agentTarget = "_blank";
        } else if (channel.channel_type == "Twitter") {
            agentURL = "https://twitter.com/" + $.trim(agent.value);
        } else if (channel.channel_type == "Phone") {
            agentTarget = "";
            agentURL = "tel:" + $.trim(agent.value);
        } else if (channel.channel_type == "Skype") {
            agentTarget = "";
            agentURL = "skype:" + $.trim(agent.value) + "?chat";
        } else if (channel.channel_type == "Snapchat") {
            agentURL = "https://www.snapchat.com/add/" + $.trim(agent.value);
        } else if (channel.channel_type == "Vkontakte") {
            agentURL = "https://vk.me/" + $.trim(agent.value);
        } else if (channel.channel_type == "Linkedin") {
            if (agent.link_type == "personal") {
                agentURL = "https://www.linkedin.com/in/" + $.trim(agent.value);
            } else {
                agentURL = "https://www.linkedin.com/company/" + $.trim(agent.value);
            }
        } else if (channel.channel_type == "Viber") {
            agentURL = trimChar(agent.value, "+");
            if (!isNaN(agentURL)) {
                agentURL = agentURL.replace("+", "");
                if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
                    agentURL = "+" + agentURL;
                }
                agentURL = "viber://chat?number=" + agentURL;
            }
            agentTarget = "";
        } else if (channel.channel_type == "TikTok") {
            agentURL = trimChar($.trim(agent.value), "@");
            agentURL = "https://www.tiktok.com/@" + agentURL;
            agentTarget = "";
        }
        return "<a href='" + agentURL + "' target='" + agentTarget + "'><span class='chaty-agent-icon'>" + agentIcon + "</span><span class='chaty-agent-title'>" + agentTitle + "</span></a>";
    }

    function getWhatsAppNumber(phoneNumber) {
        phoneNumber = trimChar(phoneNumber, "+");
        phoneNumber = phoneNumber.replace(/ /g, "");
        phoneNumber = phoneNumber.replace(/-/g, "");
        phoneNumber = phoneNumber.replace(/_/g, "");
        return phoneNumber;
    }


    function trimChar(string, charToRemove) {
        string = $.trim(string);
        while (string.charAt(0) == charToRemove) {
            string = string.substring(1);
        }

        while (string.charAt(string.length - 1) == charToRemove) {
            string = string.substring(0, string.length - 1);
        }

        return string;
    }


    /**
     *
     * To get channel URL
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function getChannelURL(channel, channelIcon, toolTipPosition, widgetId) {
        var extraClass = "";
        if (isTrue(channel.is_agent)) {
            channel.url = "javascript:;";
            channel.target = "";
        } else {
            if (channel.channel_type == "Whatsapp") {
                if (isTrue(channel.has_welcome_message) && !isEmpty(channel.chat_welcome_message)) {
                    channel.url = "javascript:;";
                    channel.target = "";
                    extraClass += " has-chaty-box chaty-whatsapp-form";
                    startMakingWhatsAppPopup(channel, widgetId);
                } else {
                    var preSetMessage = "";
                    if (!isEmpty(channel.pre_set_message)) {
                        preSetMessage = decodeURI(channel.pre_set_message);
                        var pageTitle = $("title").text();
                        if (!isEmpty(pageTitle)) {
                            preSetMessage = preSetMessage.replace(/{title}/g, pageTitle);
                        } else {
                            preSetMessage = preSetMessage.replace(/{title}/g, '');
                        }
                        preSetMessage = preSetMessage.replace(/{url}/g, window.location);
                        preSetMessage = encodeURIComponent(preSetMessage);
                    }
                    if (isChatyInMobile) {
                        channel.target = "";
                        channel.url = "https://wa.me/" + channel.value + "?text=" + preSetMessage;
                    } else {
                        channel.target = "_blank";
                        if (!isTrue(channel.is_use_web_version)) {
                            channel.url = "https://web.whatsapp.com/?phone=" + channel.value + "&text=" + preSetMessage;
                        } else {
                            channel.url = "https://wa.me/" + channel.value + "?text=" + preSetMessage;
                        }
                    }
                }
            } else if (channel.channel_type == "WeChat") {
                if (!isEmpty(channel.qr_code_image_url)) {
                    startMakingWeChatChannel(channel, widgetId);
                    channel.url = "javascript:;";
                    channel.target = "";
                    extraClass += " has-chaty-box chaty-qr-code-form";
                }
            } else if (channel.channel_type == "Contact_Us") {
                startMakingContactForm(channel, widgetId);
                channel.url = "javascript:;";
                channel.target = "";
                extraClass += " has-chaty-box chaty-contact-us-form";
            } else if (channel.channel_type == "Email") {
                if (!isEmpty(channel.mail_subject)) {
                    var mailSubject = decodeURI(channel.mail_subject);
                    var pageTitle = $("title").text();
                    if (!isEmpty(pageTitle)) {
                        mailSubject = mailSubject.replace(/{title}/g, pageTitle);
                    } else {
                        mailSubject = mailSubject.replace(/{title}/g, '');
                    }
                    mailSubject = mailSubject.replace(/{url}/g, window.location);
                    mailSubject = encodeURIComponent(mailSubject);
                    channel.url += "?subject=" + mailSubject;
                }
            } else if (channel.channel_type == "Viber") {
                channel.value = trimChar(channel.value, "+");
                if (isChatyInMobile && !isNaN(channel.value)) {
                    // channel.value = channel.value.replace("+", "");
                    if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
                        channel.value = "+" + channel.value;
                    }
                }
                channel.url = "viber://chat?number=" + channel.value;
                channel.target = "";
            } else if (channel.channel_type == "Vkontakte") {
                channel.url = "https://vk.me/" + $.trim(channel.value);
            }
        }

        var onClickFn = "";
        if (!isEmpty(channel.click_event)) {
            onClickFn = 'onclick="' + channel.click_event + '"';
            channel.target = "";
            channel.url = "javascript:;";
        }
        return "<a href='" + channel.url + "' " + onClickFn + " target='" + channel.target + "' class='chaty-tooltip pos-" + toolTipPosition + extraClass + "' data-form='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-hover='" + channel.hover_text + "'>" + channelIcon + "</a>";
    }

    function startMakingContactForm(channel, widgetId) {
        var formHtml = "";
        var widgetIndex = getWidgetIndex(widgetId);
        if (widgetIndex == null) {
            widgetIndex = -1;
        }
        formHtml += "<div style='display:none;' class='chaty-outer-forms chaty-contact-form-box chaty-form-" + widgetId + "' data-channel='" + channel.channel_type + "' id='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-widget='" + widgetId + "' data-index='" + widgetIndex + "'>";
        formHtml += "<div class='chaty-form'>";
        formHtml += "<div class='chaty-form-body'>";
        formHtml += "<div role='button' class='close-chaty-form'><div class='chaty-close-button'></div></div>";
        formHtml += "<form class='chaty-ajax-contact-form' id='chaty-ajax-contact-form-" + widgetIndex + "' method='post' data-channel='" + channel.channel_type + "' data-widget='" + widgetId + "' data-token='" + channel.widget_token + "' data-index='" + channel.widget_index + "'>";
        formHtml += "<div class='chaty-contact-form-body'>";
        formHtml += "<div class='chaty-contact-form-title'>" + channel.contact_form_settings.contact_form_title + "</div>";
        formHtml += "<div class='chaty-contact-inputs'>";
        $.each(channel.contact_fields, function (key, contactField) {
            formHtml += "<div class='chaty-contact-input'>";
            var isRequired = isTrue(contactField.is_required) ? "is-required" : "";
            if (contactField.type == "textarea") {
                formHtml += "<textarea type='" + contactField.type + "' class='chaty-textarea-field " + isRequired + " field-" + contactField.field + "' placeholder='" + contactField.placeholder + "' name='" + contactField.field + "' id='" + contactField.field + "-" + widgetId + "' ></textarea>"
            } else {
                formHtml += "<input type='" + contactField.type + "' class='chaty-input-field " + isRequired + " field-" + contactField.field + "' placeholder='" + contactField.placeholder + "' name='" + contactField.field + "' id='" + contactField.field + "-" + widgetId + "' />"
            }
            formHtml += "</div>";
        });
        formHtml += "<div class='chaty-contact-form-button'><button type='submit' id='chaty-submit-button-" + widgetId + "' class='chaty-submit-button'>" + channel.contact_form_settings.button_text + "</button></div>";
        formHtml += "</div>"; // chaty-contact-inputs
        formHtml += "</div>"; // chaty-contact-form-body
        formHtml += "</form>";
        formHtml += "</div>";
        formHtml += "</div>";
        formHtml += "</div>";
        $("body").append(formHtml);
    }

    /**
     *
     * to make WhatsApp popup form
     * Added On: 11/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function startMakingWhatsAppPopup(channel, widgetId) {
        var formHtml = "";
        var widgetIndex = getWidgetIndex(widgetId);
        if (widgetIndex == null) {
            widgetIndex = -1;
        }
        var formAction = "https://web.whatsapp.com/send";
        var formTarget = "";
        if (!isChatyInMobile) {
            if (isTrue(channel.is_use_web_version)) {
                formAction = "https://web.whatsapp.com/send";
            } else {
                formAction = "https://wa.me/" + channel.value;
            }
            formTarget = "_blank";
        } else {
            formAction = "https://wa.me/" + channel.value;
        }
        formHtml += "<div style='display:none;' class='chaty-outer-forms chaty-whatsapp-form chaty-form-" + widgetId + "' data-channel='" + channel.channel_type + "' id='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-widget='" + widgetId + "' data-index='" + widgetIndex + "'>";
        formHtml += "<div class='chaty-whatsapp-form'>";
        formHtml += "<div class='chaty-whatsapp-body'>";
        formHtml += "<div role='button' class='close-chaty-form is-whatsapp-btn'><div class='chaty-close-button'></div></div>";
        formHtml += "<div class='chaty-whatsapp-message'></div>";
        formHtml += "</div>";
        formHtml += "<div class='chaty-whatsapp-footer'>";
        formHtml += "<form action='" + formAction + "' target='" + formTarget + "' class='whatsapp-chaty-form " + (isTrue(channel.is_default_open) ? "add-analytics" : "") + "' data-widget='" + widgetId + "' data-channel='" + channel.channel_type + "'>";
        formHtml += "<div class='chaty-whatsapp-data'>";
        formHtml += "<div class='chaty-whatsapp-field'>";
        formHtml += "<input name='text' type='text' class='csass-whatsapp-input' />";
        formHtml += "</div>";
        formHtml += "<div class='chaty-whatsapp-button'>";
        formHtml += "<button type='submit' >";
        formHtml += "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path fill='#ffffff' d='M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z'></path></svg>";
        formHtml += "</button>";
        formHtml += "</div>";
        formHtml += "</div>";
        if (!isChatyInMobile && isTrue(channel.is_use_web_version)) {
            formHtml += "<input type='hidden' name='phone' value='" + channel.value + "' />";
        }
        formHtml += "</form>";
        formHtml += "</div>";
        formHtml += "</div>";
        formHtml += "</div>";
        $("body").append(formHtml);
        $("#chaty-form-" + widgetId + "-" + channel.channel_type + " .chaty-whatsapp-message").html(channel.chat_welcome_message);
        if (!isEmpty(channel.pre_set_message)) {
            var preSetMessage = channel.pre_set_message;
            var pageTitle = $("title").text();
            if (!isEmpty(pageTitle)) {
                preSetMessage = preSetMessage.replace(/{title}/g, pageTitle);
            } else {
                preSetMessage = preSetMessage.replace(/{title}/g, '');
            }
            preSetMessage = preSetMessage.replace(/{url}/g, window.location);
            $("#chaty-form-" + widgetId + "-" + channel.channel_type + " .csass-whatsapp-input").val(preSetMessage);
        }
        $("#chaty-form-" + widgetId + "-" + channel.channel_type).show();
    }

    function htmlDecode(input) {
        var doc = new DOMParser().parseFromString(input, "text/html");
        return doc.documentElement.textContent;
    }

    /**
     *
     * To get widget index
     * Added On: 11/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function getWidgetIndex(widgetId) {
        var widgetIndex = null;
        if (widgetData.length) {
            $.each(widgetData, function (key, widgetRecord) {
                if (widgetRecord.id == widgetId) {
                    widgetIndex = key;
                }
            });
        }
        return widgetIndex;
    }

    /**
     *
     * to make WhatsApp popup form
     * Added On: 11/02/2021
     * Added By: Chirag Thummar
     *
     * */
    function startMakingWeChatChannel(channel, widgetId) {
        var formHtml = "";
        var widgetIndex = getWidgetIndex(widgetId);
        if (widgetIndex == null) {
            widgetIndex = -1;
        }
        formHtml += "<div style='display:none;' class='chaty-outer-forms chaty-form-" + widgetId + "' data-channel='" + channel.channel_type + "' id='chaty-form-" + widgetId + "-" + channel.channel_type + "' data-widget='" + widgetId + "' data-index='" + widgetIndex + "'>";
        formHtml += "<div class='chaty-form'>";
        formHtml += "<div class='chaty-form-body'>";
        formHtml += "<div role='button' class='close-chaty-form is-whatsapp-btn'><div class='chaty-close-button'></div></div>";
        formHtml += "<div class='qr-code-image'><img src='" + channel.qr_code_image_url + "' alt='" + channel.title + "' /></div>";
        formHtml += "</div>";
        formHtml += "</div>";
        formHtml += "</div>";
        $("body").append(formHtml);
    }

    /**
     *
     * get tooltip position for channel
     * Added On: 09/29/2021
     * Added By: Chirag Thummar
     *
     * */
    function isEmpty(varVal) {
        if (varVal == null || varVal == "" || $.trim(varVal) == "") {
            return true
        }
        return false;
    }

    /**
     *
     * To get channel icon
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function getChannelIcon(channel) {
        if (channel.custom_image_url != "" && channel.custom_image_url != "null") {
            return "<span class='chaty-icon channel-icon-" + channel.channel_type + "'><span class='chaty-svg chaty-svg-img'><img src='" + channel.custom_image_url + "' alt='" + channel.hover_text + "' /></span></span>";
        }
        return "<span class='chaty-icon channel-icon-" + channel.channel_type + "'><span class='chaty-svg'>" + channel.svg_icon + "</span></span>";
    }

    /**
     *
     * check for empty or null items
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function isValueEmpty(value) {
        if (value == "" || $.trim(value) == "" || value == null || value == "null") {
            return true;
        }
        return false;
    }

    /**
     *
     * To get widget position
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function getWidgetPosition(widgetRecord) {
        if (widgetRecord.position == "custom") {
            return widgetRecord.custom_position;
        }
        return widgetRecord.position;
    }

    /**
     *
     * get tooltip position for channel
     * Added On: 09/29/2021
     * Added By: Chirag Thummar
     *
     * */
    function getToolTipPosition(widgetRecord) {
        if (widgetRecord.settings.icon_view != "vertical") {
            return "top";
        }
        var toolTipPosition = getWidgetPosition(widgetRecord.settings);
        if (toolTipPosition == "right") {
            return "left";
        }
        return "right";
    }

    /**
     *
     * Check for Triggers if exists
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */

    function checkForchatyTriggers() {
        if ($(".chaty.auto-hide-chaty").length) {
            chatyHideTimeInterval = setInterval(function () {
                chatyHideIntervalTime++;
                var currentTime = chatyHideIntervalTime;
                if ($(".chaty.auto-hide-chaty.hide-after-" + chatyHideIntervalTime).length) {
                    var widgetId = $(".chaty.auto-hide-chaty.hide-after-" + currentTime).data("id");
                    $(".chaty-form-" + widgetId).removeClass("active");
                    $(".chaty.auto-hide-chaty.hide-after-" + currentTime).removeClass("active");
                    $("#chaty-widget-0" + widgetId).removeClass("auto-hide-chaty");
                }
                if ($(".chaty.auto-hide-chaty").length == 0) {
                    clearInterval(chatyHideTimeInterval);
                }
            }, 1000);
        }
        if (chatyHasTimeDelay) {
            chatyTimeInterval = setInterval(function () {
                chatyIntervalTime++;
                if ($(".chaty.delay-time-" + chatyIntervalTime).length) {
                    //$(".chaty.delay-time-"+chatyIntervalTime).addClass("active");
                    var widgetId = $(".chaty.delay-time-" + chatyIntervalTime).data("id");
                    removeTriggerRules(widgetId);
                }
            }, 1000);
        }

        if (chatyHasPageScroll) {
            $(window).on("scroll", function () {
                if (chatyHasPageScroll) {
                    var scrollHeight = $(document).height() - $(window).height();
                    var scrollPos = $(window).scrollTop();
                    if (scrollHeight != 0) {
                        var scrollPer = parseInt((scrollPos / scrollHeight) * 100);
                        if (lastScrollPer <= scrollPer) {
                            var startFrom = lastScrollPer;
                            lastScrollPer = scrollPer;
                            for (var i = startFrom; i <= scrollPer; i++) {
                                if ($.inArray(i, chatyPageScrolls) == -1) {
                                    if ($(".chaty.on-chaty-scroll.page-scroll-" + i).length) {
                                        $(".chaty.on-chaty-scroll.page-scroll-" + i).each(function () {
                                            //$(this).addClass("active");
                                            var widgetId = $(this).data("id");
                                            $(this).removeClass("on-chaty-scroll");
                                            removeTriggerRules(widgetId);
                                        });
                                    }
                                }
                            }
                            lastScrollPer = scrollPer;
                        }
                    }
                }
            });
            var hasScrollbar = window.innerWidth > document.documentElement.clientWidth;
            if (!hasScrollbar) {
                /*$(".chaty.on-chaty-scroll:not(.on-chaty-delay):not(.on-chaty-exit-intent)").each(function(){
                    $(this).addClass("active");
                    var widgetId = $(this).data("id");
                    removeTriggerRules(widgetId);
                });*/
            }
        }

        //if(chatyHasExitIntent) {

        //}
    }

    /**
     *
     * Display widgets on Exit intent
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */

    function mobileExitIntent() {
        if (window.history && window.history.pushState && chatyHasExitIntent) {
            function whenGoingBack() {
                if(chatyHasExitIntent) {
                    var hashLocation = location.hash;
                    var hashSplit = hashLocation.split("#!/");
                    var hashName = hashSplit[1];
                    if (hashName !== '') {
                        var hash = window.location.hash;
                        if (hash === '') {
                            showWidgetsOnExitIntent();
                        }
                    }
                }
            }

            var pageState = 100;
            if (window.history.state && window.history.state.page) {
                pageState = window.history.state.page;
            }
            window.history.pushState({page: pageState + 1}, '');
            window.history.pushState({page: pageState + 2}, '');

            window.onpopstate = function () {
                whenGoingBack();
            };
            window.history.onpopstate = function () {
                whenGoingBack();
            };
            window.addEventListener('popstate', function () {
                whenGoingBack();
            });
            document.addEventListener('backbutton', function () {
                whenGoingBack();
            });
            window.addEventListener('backbutton', function () {
                whenGoingBack();
            });
            $(window).on('popstate', function () {
                whenGoingBack();
            });
        }
    }

    /**
     *
     * Display widgets on Exit intent
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */

    function bindExitIntentFunction() {
        if (isChatyInMobile) {
            // Back button was pressed.
            mobileExitIntent();
        } else {
            $(document).mouseleave(function (e) {
                function addEvent(obj, evt, fn) {
                    if (obj.addEventListener) {
                        obj.addEventListener(evt, fn, false);
                        showWidgetsOnExitIntent();
                    } else if (obj.attachEvent) {
                        obj.attachEvent("on" + evt, fn);
                    }
                }

                addEvent(document, 'mouseout', function (evt) {
                    if (evt.toElement == null && evt.relatedTarget == null) {
                        showWidgetsOnExitIntent();
                    }
                });
            });
        }
    }

    /**
     *
     * Display widgets on Exit intent
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */

    function showWidgetsOnExitIntent() {
        if (chatyHasExitIntent && $(".on-chaty-exit-intent").length) {
            $(".on-chaty-exit-intent").each(function () {
                //$(this).addClass("active");
                var widgetId = $(this).data("id");
                $(this).removeClass("on-chaty-exit-intent");
                removeTriggerRules(widgetId);
                $("#chaty-widget-" + widgetId + " .chaty-widget").append("<div class='chaty-exit-intent'></div>");
                setTimeout(function () {
                    $(".chaty-exit-intent").addClass("animate");
                    setTimeout(function () {
                        $(".chaty-exit-intent").removeClass("animate");
                    }, 2500);
                }, 500);
            });
        }
    }

    /**
     *
     * Remove Trigger Rules if all rules executed
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function removeTriggerRules(widgetId) {

        updateWidgetViews(widgetId);

        $(".chaty-widget-" + widgetId).removeClass("on-chaty-delay");
        $(".chaty-widget-" + widgetId).removeClass("on-chaty-exit-intent");
        $(".chaty-widget-" + widgetId).removeClass("on-chaty-scroll");

        if (!$(".chaty.on-chaty-delay").length) {
            clearInterval(chatyTimeInterval);
            chatyHasTimeDelay = false;
        }
        if (!$(".chaty.on-chaty-exit-intent").length) {
            chatyHasExitIntent = false;
        }
        if (!$(".chaty.on-chaty-scroll").length) {
            chatyHasPageScroll = false;
        }
    }

    /**
     *
     * Remove Empty On hover class when text is empty
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function removeEmptyTooltip() {
        $(".chaty-tooltip").each(function () {
            if ($(this).data("hover") == "") {
                $(this).removeClass("left").removeClass("right").removeClass("top").removeClass("chaty-tooltip");
            }
        })
    }

    /**
     *
     * Set widget icon
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function getWidgetIcon(widgetRecord, widgetId) {
        /* set default icon if icon is blank */
        if (widgetRecord.widget_icon == "") {
            widgetRecord.widget_icon = "chat-base";
        } else if (widgetRecord.widget_icon == "chat-image" && isEmpty(widgetRecord.widget_icon_url)) {
            /* if custom icon is selected than check for image URL, if not exists then update icon with default icon */
            widgetRecord.widget_icon = "chat-base";
        }

        if (widgetRecord.widget_icon == "chat-image") {
            return "<span class='chaty-svg' style='background-color: " + widgetRecord.widget_color + "'><img src='" + widgetRecord.widget_icon_url + "' alt='Chaty Widget' /></span>";
        } else {
            return '<span class="chaty-svg">' + getSvgIcon(widgetRecord.widget_icon, widgetRecord.widget_color) + "</span>";
        }
    }

    /**
     *
     * check for widget animations if applicable
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkForWidgetAnimation(widgetRecord, widgetId) {
        var clickStatus = checkChatyCookieExpired(widgetId, 'c-widget');
        if (clickStatus && widgetRecord.attention_effect != "none" && widgetRecord.attention_effect != "") {
            $("#chaty-widget-" + widgetId).attr("data-animation", widgetRecord.attention_effect);
            if ($("#chaty-widget-" + widgetId + " .chaty-widget").hasClass("has-single")) {
                $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-channel .chaty-svg").addClass("chaty-animation-" + widgetRecord.attention_effect);
            } else {
                $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-cta-main .chaty-cta-button").addClass("chaty-animation-" + widgetRecord.attention_effect);
            }
        }
    }

    /**
     *
     * check for pending message if all criteria matches to display it
     * Added On: 10/04/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkForPendingMessage(widgetRecord, widgetId) {
        var clickStatus = checkChatyCookieExpired(widgetId, 'c-widget');

        if (clickStatus && isTrue(widgetRecord.is_pending_mesg_enabled) && parseInt(widgetRecord.pending_mesg_count) > 0) {
            if ($("#chaty-widget-" + widgetId + " .chaty-widget").hasClass("has-single")) {
                if (widgetRecord.attention_effect == "sheen" || widgetRecord.attention_effect == "spin" || widgetRecord.attention_effect == "pulse") {
                    $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-channel").append("<span class='ch-pending-msg'>" + widgetRecord.pending_mesg_count + "</span>");
                } else {
                    $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-channel .chaty-svg").append("<span class='ch-pending-msg'>" + widgetRecord.pending_mesg_count + "</span>");
                }
            } else {
                if (widgetRecord.attention_effect == "jump" || widgetRecord.attention_effect == "waggle" || widgetRecord.attention_effect == "blink" || widgetRecord.attention_effect == "pulse-icon") {
                    $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-cta-main .chaty-cta-button").append("<span class='ch-pending-msg'>" + widgetRecord.pending_mesg_count + "</span>");
                } else {
                    $("#chaty-widget-" + widgetId + " .chaty-i-trigger .chaty-cta-main").append("<span class='ch-pending-msg'>" + widgetRecord.pending_mesg_count + "</span>");
                }
            }
        }
    }

    /**
     *
     * Add Prefix 0 to Number
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */

    function addPrefixToNum(num) {
        num = num.toString();
        while (num.length < 2) num = "0" + num;
        return num;
    }

    /**
     *
     * Check for time Schedule
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkForDayAndTimeSchedule(widgetRecord) {
        var displayStatus = true;
        if (isTrue(widgetRecord.triggers.has_day_hours_scheduling_rules) && widgetRecord.triggers.day_hours_scheduling_rules.length > 0) {
            var displayRules = widgetRecord.triggers.day_hours_scheduling_rules;
            if (displayRules.length > 0) {
                displayStatus = false;
                var localDate = new Date();
                localDate = changeTimezone(localDate, widgetRecord.triggers.day_time_diff);
                var utcHours = localDate.getHours();
                var utcMin = localDate.getMinutes();
                var utcDay = localDate.getDay();
                for (var rule = 0; rule < displayRules.length; rule++) {
                    var hourStatus = 0;
                    var minStatus = 0;
                    var checkForTime = 0;
                    if (displayRules[rule].days == -1) {
                        checkForTime = 1;
                    } else if (displayRules[rule].days >= 0 && displayRules[rule].days <= 6) {
                        if (displayRules[rule].days == utcDay) {
                            checkForTime = 1;
                        }
                    } else if (displayRules[rule].days == 7) {
                        if (utcDay >= 0 && utcDay <= 4) {
                            checkForTime = 1;
                        }
                    } else if (displayRules[rule].days == 8) {
                        if (utcDay >= 1 && utcDay <= 5) {
                            checkForTime = 1;
                        }
                    } else if (displayRules[rule].days == 9) {
                        if (utcDay == 5 || utcDay == 6) {
                            checkForTime = 1;
                        }
                    }
                    if (checkForTime == 1) {
                        if (utcHours > displayRules[rule].start_hours && utcHours < displayRules[rule].end_hours) {
                            hourStatus = 1;
                        } else if (utcHours == displayRules[rule].start_hours && utcHours < displayRules[rule].end_hours) {
                            if (utcMin >= displayRules[rule].start_min) {
                                hourStatus = 1;
                            }
                        } else if (utcHours > displayRules[rule].start_hours && utcHours == displayRules[rule].end_hours) {
                            if (utcMin <= displayRules[rule].end_min) {
                                hourStatus = 1;
                            }
                        } else if (utcHours == displayRules[rule].start_hours && utcHours == displayRules[rule].end_hours) {
                            if (utcMin >= displayRules[rule].start_min && utcMin <= displayRules[rule].end_min) {
                                hourStatus = 1;
                            }
                        }

                        if (hourStatus == 1) {
                            if (utcMin >= displayRules[rule].start_min && utcMin <= displayRules[rule].end_min) {
                                minStatus = 1;
                            }
                        }
                    }

                    if (hourStatus == 1 && checkForTime == 1) {
                        displayStatus = 1;
                    }
                    if (displayStatus == 1) {
                        rule = displayRules.length + 1;
                    }
                }
            }
        }
        return displayStatus;
    }

    /**
     *
     * get tooltip position for channel
     * Added On: 09/29/2021
     * Added By: Chirag Thummar
     *
     * */
    function isTrue(varVal) {
        if (varVal == "1" || varVal == 1 || varVal == true || varVal == "true" || varVal == "yes" || varVal == "on") {
            return true
        }
        return false;
    }

    /**
     *
     * To get time diffrence between dates
     * Added On: 04/18/2022
     * Added By: Chirag Thummar
     *
     * */

    function changeTimezone(date, ianatz) {
        if (isNaN(ianatz)) {
            var invdate = new Date(date.toLocaleString('en-US', {
                timeZone: ianatz
            }));
            var diff = date.getTime() - invdate.getTime();
            return new Date(date.getTime() - diff); // needs to substract
        } else {
            var newDate = new Date();
            newDate = newDate.toLocaleString('en-US', {timeZone: 'UTC'});
            newDate = new Date(newDate);
            if (ianatz.indexOf("+") != -1) {
                var newTimeZone = ianatz.replace("+", "");
                var extraHours = parseInt(newTimeZone);
                var extraMin = parseFloat(newTimeZone % extraHours) * 60;
                extraMin = newDate.getUTCMinutes() + extraMin;
                if (extraMin > 59) {
                    extraHours = extraHours + parseInt(extraMin / 60);
                    extraMin = extraMin % 60;
                }
                newDate.setUTCHours(newDate.getUTCHours() + extraHours, extraMin);
            } else if (ianatz.indexOf("-") != -1) {
                var newTimeZone = ianatz.replace("-", "");
                var extraHours = parseInt(newTimeZone);
                var extraMin = parseFloat(newTimeZone % extraHours) * 60;
                extraMin = newDate.getUTCMinutes() - extraMin;
                if (extraMin < 0) {
                    extraHours = extraHours - parseInt(extraMin / 60);
                    extraMin = extraMin % 60;
                }
                newDate.setUTCHours(newDate.getUTCHours() - extraHours, -extraMin);
            }
            var diff = date.getTime() - newDate.getTime();
            return new Date(date.getTime() - diff); // needs to substract
        }
    }

    /**
     *
     * Check for time Schedule
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */

    function checkForTimeSchedule(widgetRecord) {
        if (widgetRecord.triggers.has_date_scheduling_rules) {
            var chtStartDate = widgetRecord.triggers.date_scheduling_rules.start_date_time;
            var chtEndDate = widgetRecord.triggers.date_scheduling_rules.end_date_time;

            var localDate = new Date();

            localDate = changeTimezone(localDate, widgetRecord.triggers.time_diff);

            var currentTime = localDate.getFullYear() + "-" + (addPrefixToNum(localDate.getMonth() + 1)) + "-" + addPrefixToNum(localDate.getDate()) + " " + addPrefixToNum(localDate.getHours()) + ":" + addPrefixToNum(localDate.getMinutes()) + ":" + addPrefixToNum(localDate.getSeconds());

            if (chtEndDate == "") {
                if (chtStartDate <= currentTime) {
                    return true;
                }
            }

            if (chtStartDate == "") {
                if (chtEndDate >= currentTime) {
                    return true;
                }
            }

            if (chtStartDate != "" && chtEndDate != "") {
                if (chtStartDate <= currentTime && chtEndDate >= currentTime) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    /**
     *
     * Check for visitos's country
     * Added On: 10/21/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkForUserCountry(widgetRecord) {
        if (isTrue(widgetRecord.triggers.has_countries) && !isEmpty(widgetRecord.triggers.countries) && widgetRecord.triggers.countries.length) {
            clientCountry = getUserCountry();
            if (clientCountry != "-") {
                if ($.inArray(clientCountry, widgetRecord.triggers.countries) == -1) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     *
     * To get user id from cookie or storage
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function getUserCountry() {
        clientCountry = "";
        if (typeof Storage !== "undefined" && window.sessionStorage.getItem("chaty_user_country_code") != null) {
            clientCountry = window.sessionStorage.getItem("chaty_user_country_code");
        } else {
            if (chatyCheckCookie('chaty_user_country_code')) {
                clientCountry = chatyGetCookie('chaty_user_country_code');
            }
        }
        return clientCountry;
    }

    /**
     *
     * To save user id in cookie, will be created different for users and by browsers
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function setUserCountry(userCountry) {
        if (typeof Storage !== "undefined") {
            if (window.sessionStorage.getItem("chaty_user_country_code") == null) {
                window.sessionStorage.setItem("chaty_user_country_code", userCountry);
            }
        } else {
            if (!chatyCheckCookie('chaty_user_country_code')) {
                chatySetCookie('chaty_user_country_code', userCountry, 365);
            }
        }
    }

    /**
     *
     * To ger widget's setting stored cookie Array
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkForChatyCookieString(widgetId, cookieStr) {
        var cookieString = chatyGetCookie("chatyWidget_" + widgetId);
        var cookieArray = [];
        if (cookieString != null && cookieString != "") {
            cookieArray = JSON.parse(cookieString);
        }
        if (cookieArray.length > 0) {
            for (var i = 0; i < cookieArray.length; i++) {
                if (cookieArray[i]['k'] == cookieStr) {
                    return cookieArray[i]['v'];
                }
            }
        }
        return null;
    }

    /**
     *
     * To save widget's setting in cookie Array
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function saveChatyCookieString(widgetId, cookieStr) {
        var cookieString = chatyGetCookie("chatyWidget_" + widgetId);
        var cookieArray = [];
        if (cookieString != null && cookieString != "") {
            cookieArray = JSON.parse(cookieString);
        }
        var cookieFound = false;
        if (cookieArray.length > 0) {
            for (var i = 0; i < cookieArray.length; i++) {
                if (cookieArray[i]['k'] == cookieStr) {
                    cookieFound = true;
                    cookieArray[i]['v'] = new Date();
                }
            }
        }
        if (!cookieFound) {
            cookieArray.push({"k": cookieStr, "v": new Date()});
        }
        cookieString = JSON.stringify(cookieArray);
        chatySetCookie("chatyWidget_" + widgetId, cookieString, "7");
    }


    /**
     *
     * To check widget's setting cookie status stored in Array
     * Added On: 10/01/2021
     * Added By: Chirag Thummar
     *
     * */
    function checkChatyCookieExpired(widgetId, cookieStr) {
        var cookieValue = checkForChatyCookieString(widgetId, cookieStr);
        if (cookieValue != null && cookieValue != "") {
            cookieValue = new Date(cookieValue);
            var diffTime = Math.abs(new Date() - cookieValue);
            var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays >= 2) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     *
     * To save data in browser cookie
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function chatySetCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/; SameSite=Lax";
    }

    /**
     *
     * To get data from browser cookie using cookie name
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function chatyGetCookie(cookieName) {
        var cookieName = cookieName + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(cookieName) == 0) {
                return c.substring(cookieName.length, c.length); // return data if cookie exists
            }
        }
        return null; // return null if cookie doesn't exists
    }

    /**
     *
     * To check cookie exists or not in browser
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function chatyCheckCookie(cookieName) {
        var cookie = chatyGetCookie(cookieName);
        if (cookie != "" && cookie !== null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * To remove cookie from browser
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function chatyDeleteCookie(cookieName) {
        document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    /**
     *
     * To get current date from Browser
     * Added On: 09/28/2021
     * Added By: Chirag Thummar
     *
     * */
    function getCurrentDate() {
        today = new Date();
        dd = today.getDate();
        mm = today.getMonth() + 1;
        yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        return yyyy + '-' + mm + '-' + dd;
    }

    /**
     *
     * Add log message to console
     *
     * */
    function addChatyLog(message) {
        if (chatyEnv != "app") {
            console.log(message);
        }
    }
}));

function launch_chaty(widget_number) {
    if (widget_number == undefined || widget_number == "widget_index") {
        widget_number = 1;
    }
    if (jQuery("#chaty-widget-_"+widget_number).length) {
        jQuery("#chaty-widget-_"+widget_number+" .chaty-cta-button .open-chaty").trigger("click");
    }
}

function close_chaty() {
    if (jQuery(".chaty.active .chaty-open").length) {
        jQuery(".chaty.active .chaty-open").each(function () {
            jQuery(this).find(".chaty-cta-close").trigger("click");
        })
    }
}