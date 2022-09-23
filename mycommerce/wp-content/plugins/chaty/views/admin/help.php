<?php
/**
 * Chaty Popups
 *
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 * */

if (defined('ABSPATH') === false) {
    exit;
}
?>
<div class="chaty-help-form">
    <form action="<?php echo esc_url(admin_url('admin-ajax.php')) ?>" method="post" id="chaty-help-form">
        <div class="chaty-help-header">
            <b>Gal Dubinski</b> Co-Founder at Premio
        </div>
        <div class="chaty-help-content">
            <p><?php esc_html_e("Hello! Are you experiencing any problems with Chaty? Please let me know :)", 'chaty') ?></p>
            <div class="chaty-form-field">
                <input type="text" name="user_email" id="user_email" placeholder="<?php esc_html_e("Email", 'chaty') ?>">
            </div>
            <div class="chaty-form-field">
                <textarea type="text" name="textarea_text" id="textarea_text" placeholder="<?php esc_html_e("How can I help you?", 'chaty') ?>"></textarea>
            </div>
            <div class="form-button">
                <button type="submit" class="chaty-help-button" ><?php esc_html_e("Chat") ?></button>
                <input type="hidden" name="action" value="wcp_admin_send_message_to_owner"  >
                <input type="hidden" id="nonce" name="nonce" value="<?php echo esc_attr(wp_create_nonce("chaty_send_message_to_owner")) ?>">
            </div>
        </div>
    </form>
</div>
<div class="chaty-help-btn">
    <a class="chaty-help-tooltip" href="javascript:;"><img src="<?php echo esc_url(CHT_PLUGIN_URL."admin/assets/images/owner.png") ?>" alt="<?php esc_html_e("Need help?", 'chaty') ?>"  /></a>
    <span class="tooltiptext"><?php esc_html_e("Need help?", 'chaty') ?></span>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#chaty-help-form").submit(function(){
            jQuery(".chaty-help-button").attr("disabled",true);
            jQuery(".chaty-help-button").text("<?php esc_html_e("Sending Request...") ?>");
            formData = jQuery(this).serialize();
            jQuery.ajax({
                url: "<?php echo esc_url(admin_url('admin-ajax.php')) ?>",
                data: formData,
                type: "post",
                success: function(responseText){
                    jQuery("#chaty-help-form").find(".error-message").remove();
                    jQuery("#chaty-help-form").find(".input-error").removeClass("input-error");
                    responseArray = jQuery.parseJSON(responseText);
                    if(responseArray.error == 1) {
                        jQuery(".chaty-help-button").attr("disabled",false);
                        jQuery(".chaty-help-button").text("<?php esc_html_e("Chat", 'chaty') ?>");
                        for(i=0;i<responseArray.errors.length;i++) {
                            jQuery("#"+responseArray.errors[i]['key']).addClass("input-error");
                            jQuery("#"+responseArray.errors[i]['key']).after('<span class="error-message">'+responseArray.errors[i]['message']+'</span>');
                        }
                    } else if(responseArray.status == 1) {
                        jQuery(".chaty-help-button").text("<?php esc_html_e("Done!", 'chaty') ?>");
                        setTimeout(function(){
                            jQuery(".chaty-help-header").remove();
                            jQuery(".chaty-help-content").html("<p class='success-p'><?php esc_html_e("Your message is sent successfully.", 'chaty') ?></p>");
                        },1000);
                    } else if(responseArray.status == 0) {
                        jQuery(".folder-help-content").html("<p class='error-p'><?php printf(esc_html__("There is some problem in sending request. Please send us mail on %s", 'folders'), "<a href='mailto:contact@premio.io'>contact@premio.io</a>"); ?></p>");
                    }
                }
            });
            return false;
        });
        jQuery(".chaty-help-tooltip").click(function(e){
            e.stopPropagation();
            jQuery(".chaty-help-form").toggleClass("active");
        });
        jQuery(".chaty-help-form").click(function(e){
            e.stopPropagation();
        });
        jQuery("body").click(function(){
            jQuery(".chaty-help-form").removeClass("active");
        });
    });
</script>
