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

$showFirstChatyBox = get_option("show_first_chaty_box");
if ($showFirstChatyBox == 1) {
    update_option("show_first_chaty_box", 2);
    ?>
    <div class="first-chaty-popup">
        <div class="first-chaty-popup-overlay"></div>
        <div class="first-chaty-popup-content">
            <div class="first-chaty-popup-data">
                <a href="#" class="close-first-popup">
                    <img src="<?php echo CHT_PLUGIN_URL ?>admin/assets/images/x.svg" alt="chaty" />
                </a>
                <img src="<?php echo CHT_PLUGIN_URL ?>admin/assets/images/logo-color.svg" alt="chaty" />
                <div class="first-title"><?php esc_html_e("Your first widget is up!", "chaty"); ?> 🎉</div>
                <div class="first-des"><?php printf(esc_html__("Yay - we’re happy you chose Chaty for your website. If you run into anything, the %s is always here for you.", "chaty"), "<a target='_blank' href='https://premio.io/help/chaty/?utm_source=firstwidget'><b>".esc_html__("help center", "chaty")."</b></a>"); ?></div>
                <div class="first-button">
                    <a href="<?php echo admin_url("admin.php?page=chaty-app") ?>"><?php esc_html_e("Go to Dashboard", "chaty"); ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    $showFirstChatyLeadBox = get_option("show_first_chaty_lead_box");
    if ($showFirstChatyLeadBox == 1) {
        update_option("show_first_chaty_lead_box", 2);
        ?>
        <div class="first-chaty-popup">
            <div class="first-chaty-popup-overlay"></div>
            <div class="first-chaty-popup-content chaty-lead">
                <div class="first-chaty-popup-data">
                    <a href="#" class="close-first-popup">
                        <img src="<?php echo CHT_PLUGIN_URL ?>admin/assets/images/x.svg" alt="chaty" />
                    </a>
                    <img src="<?php echo CHT_PLUGIN_URL ?>admin/assets/images/logo-color.svg" alt="chaty" />
                    <div class="first-title"><?php esc_html_e("Congratulations", "chaty"); ?> 👏</div>
                    <div class="first-des p-50">
                        <p>You just got your first lead from Chaty. Click on the <b>Show me</b> button to display your contact form leads</p>
                        <p><b>Upgrade to Chaty Pro 🚀</b> to get leads to your email along with advanced triggers & targeting & more cool features</p>
                    </div>
                    <div class="show-lead-btn">
                        <a href="<?php echo admin_url("admin.php?page=chaty-contact-form-feed") ?>" class="">Show me the new lead</a><span class="dashicons dashicons-arrow-right"></span>
                    </div>
                    <div class="first-button lead-btn">
                        <a target="_blank" href="<?php echo admin_url("admin.php?page=chaty-app-upgrade") ?>"><?php esc_html_e("Upgrade to Pro", "chaty"); ?><span>🚀</span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }//end if
}//end if
?>
<script>
    jQuery(document).ready(function(){
        jQuery(document).on("click", ".close-first-popup", function(e){
            e.preventDefault();
            jQuery(this).closest(".first-chaty-popup").hide();
        });
        jQuery(document).on("click", ".first-chaty-popup-overlay", function(e){
            jQuery(".first-chaty-popup").hide();
        });
        jQuery(document).on("click", ".first-chaty-popup-content", function(e){
            e.stopPropagation();
        });
    })
</script>
