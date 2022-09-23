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
<section class="section" id="launch-section">
    <h1 class="section-title">
        <?php esc_html_e('Launch it!', 'chaty');?>
    </h1>

    <div class="form-horizontal">
        <input type="hidden" name="cht_active" value="0"  >
        <div class="form-horizontal__item flex-center">
            <label class="form-horizontal__item-label"><?php esc_html_e('Active', 'chaty');?>:</label>
            <div>
                <label class="switch">
                    <span class="switch__label"><?php esc_html_e('Off', 'chaty');?></span>
                    <?php
                    $chtActive = get_option('cht_active');
                    if ($chtActive === false) {
                        $chtActive = 1;
                    }
                    ?>
                    <input data-gramm_editor="false" type="checkbox" name="cht_active" class="cht_active" value="1" <?php checked($chtActive, 1) ?>>
                    <span class="switch__styled"></span>
                    <span class="switch__label"><?php esc_html_e('On', 'chaty');?></span>
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce("chaty_plugin_nonce")) ?>">
</section>
<?php
$createdOn = get_option('cht_created_on');
if ($createdOn === false) {
    $createdOn = "";
}

if (get_option('cht_active') === false) {
    $createdOn = date("Y-m-d");
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#toplevel_page_chaty-app li").removeClass("current");
            jQuery("#toplevel_page_chaty-app li:eq(2)").addClass("current")
        });
    </script>
    <?php
}
?>
<input type="hidden" name="cht_created_on" value="<?php echo esc_attr($createdOn) ?>" />
