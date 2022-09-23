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
?>
<div style="display: none">
    <?php
    $embeddedMessage = "";
    $settings        = [
        'media_buttons'    => false,
        'wpautop'          => false,
        'drag_drop_upload' => false,
        'textarea_name'    => 'chat_editor_channel',
        'textarea_rows'    => 4,
        'quicktags'        => false,
        'tinymce'          => [
            'toolbar1' => 'bold, italic, underline',
            'toolbar2' => '',
            'toolbar3' => '',
        ],
    ];
    wp_editor($embeddedMessage, "chat_editor_channel", $settings);
    ?>
</div>

<?php $proID = $this->is_pro() ? "pro" : ""; ?>
<section class="section one chaty-setting-form" id="<?php echo esc_attr($proID) ?>" xmlns="http://www.w3.org/1999/html">
    <?php
    // if($this->widget_index != "" || $this->get_total_widgets() > 0) {
    $chtWidgetTitle = get_option("cht_widget_title");
    if (isset($_GET['widget_title']) && empty(!$_GET['widget_title'])) {
        $chtWidgetTitle = filter_input(INPUT_GET, 'widget_title');
    }
    ?>
    <div class="chaty-input">
        <label for="cht_widget_title"><?php esc_html_e('Name', 'chaty'); ?></label>
        <input id="cht_widget_title" type="text" name="cht_widget_title" value="<?php echo esc_attr($chtWidgetTitle) ?>">
    </div>
    <?php
    // } ?>
    <h1 class="section-title">
        <strong><?php esc_html_e('Step', 'chaty'); ?> 1:</strong> <?php esc_html_e('Choose your channels', 'chaty'); ?>
    </h1>
    <?php
    $socialApp = get_option('cht_numb_slug');
    $socialApp = trim($socialApp, ",");
    $socialApp = explode(",", $socialApp);
    $socialApp = array_unique($socialApp);
    $imageUrl  = plugin_dir_url("")."chaty/admin/assets/images/chaty-default.png";
    ?>
    <input type="hidden" id="default_image" value="<?php echo esc_url($imageUrl)  ?>" />
    <div class="channels-icons" id="channel-list">
        <?php if ($this->socials) :
            foreach ($this->socials as $key => $social) :
                $value       = get_option('cht_social'.'_'.$social['slug']);
                $activeClass = '';
                foreach ($socialApp as $keySoc) :
                    if ($keySoc == $social['slug']) {
                        $activeClass = 'active';
                    }
                endforeach; ?>
                <div class="icon icon-sm chat-channel-<?php echo esc_attr($social['slug']); ?> <?php echo esc_attr($activeClass) ?>" data-social="<?php echo esc_attr($social['slug']); ?>" data-label="<?php echo esc_attr($social['title']); ?>" >
                    <span class="icon-box">
                        <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <?php echo $social['svg']; ?>
                        </svg>
                        <?php if ($social['slug'] == "Contact_Us") {
                            echo "<span>".esc_attr("Contact Form")."</span>";
                        } ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if (!$this->is_pro()) : ?>
    <div class="popover" style="">
        <a class="upgrade-link" target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
            You can use any two channels in the free version.<br/>Get unlimited channels in the Pro plan
            <strong><?php esc_html_e('Upgrade Now', 'chaty'); ?></strong>
        </a>
    </div>
    <?php endif; ?>
    <input type="hidden" class="add_slug" name="cht_numb_slug" placeholder="test" value="<?php echo esc_attr(get_option('cht_numb_slug')); ?>" id="cht_numb_slug" >

    <div class="channels-selected" id="channels-selected-list">
        <ul id="channels-selected-list" class="channels-selected-list channels-selected">
            <?php if ($this->socials) {
                $social = get_option('cht_numb_slug');
                $social = explode(",", $social);
                $social = array_unique($social);
                foreach ($social as $keySoc) {
                    foreach ($this->socials as $key => $social) {
                        if ($social['slug'] != $keySoc) {
                            // compare social media slug
                            continue;
                        }

                        include "channel.php";
                        ?>
                    <?php } ?>
                <?php } ?>
            <?php }; ?>
            <?php
            $isPro    = $this->is_pro();
            $proClass = ($isPro) ? "pro" : "free";
            $text     = get_option("cht_close_button_text");
            $text     = ($text === false) ? "Hide" : $text;
            ?>
            <!-- close setting strat -->
            <li class="chaty-cls-setting" data-id="" id="chaty-social-close">
                <div class="channels-selected__item pro 1 available">
                    <div class="chaty-default-settings ">
                        <div class="move-icon">
                            <img src="<?php echo esc_url(plugins_url()."/chaty/admin/assets/images/move-icon.png") ?>" style="opacity:0"; />
                        </div>
                        <div class="icon icon-md active" data-label="close">
                            <span id="image_data_close">
                                <svg viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="26" cy="26" rx="26" ry="26" fill="#A886CD"></ellipse><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(18.35 15.6599) scale(0.998038 1.00196) rotate(45)" fill="white"></rect><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(37.5056 18.422) scale(0.998038 1.00196) rotate(135)" fill="white"></rect></svg>
                            </span>
                            <span class="default_image_close" style="display: none;">
                                 <svg viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg"><ellipse cx="26" cy="26" rx="26" ry="26" fill="#A886CD"></ellipse><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(18.35 15.6599) scale(0.998038 1.00196) rotate(45)" fill="white"></rect><rect width="27.1433" height="3.89857" rx="1.94928" transform="translate(37.5056 18.422) scale(0.998038 1.00196) rotate(135)" fill="white"></rect></svg>
                            </span>
                        </div>
                        <div class="channels__input-box cls-btn-settings active">
                            <input type="text" class="channels__input" name="cht_close_button_text" value="<?php echo esc_attr($text) ?>" data-gramm_editor="false" >
                        </div>
                        <div class="input-example cls-btn-settings active">
                            <?php esc_html_e('On hover Close button text', 'chaty'); ?>
                        </div>
                    </div>
                </div>
            </li>
            <!-- close setting end -->
        </ul>
        <div class="clear clearfix"></div>
        <div class="channels-selected__item disabled" style="opacity: 0; display: none;">

        </div>

        <input type="hidden" id="is_pro_plugin" value="<?php echo esc_attr($this->is_pro() ? "1" : "0"); ?>" />
        <?php if ($this->is_pro() && $this->is_expired()) : ?>
            <div class="popover">
                <a target="_blank" href="<?php echo esc_url($this->getUpgradeMenuItemUrl()); ?>">
                    <?php esc_html_e('Your Pro Plan has expired. ', 'chaty'); ?>
                    <strong><?php esc_html_e('Upgrade Now', 'chaty'); ?></strong>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="chaty-sticky-buttons">
        <!-- form sticky save button -->
        <button class="btn-save-sticky">
            <span><?php esc_html_e('Save', 'chaty'); ?></span>
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.5 0.5H0.5V27.5H27.5V6.5L21.5 0.5ZM14 24.5C11.51 24.5 9.5 22.49 9.5 20C9.5 17.51 11.51 15.5 14 15.5C16.49 15.5 18.5 17.51 18.5 20C18.5 22.49 16.49 24.5 14 24.5ZM18.5 9.5H3.5V3.5H18.5V9.5Z" fill="white"/>
            </svg>
        </button>

        <!-- chaty help button -->
        <a class="btn-help"><?php esc_html_e('help', 'chaty'); ?><span>?</span></a>

        <!-- chaty preview button -->
        <a href="javascript:;" class="preview-help-btn"><?php esc_html_e('Preview', 'chaty'); ?></a>
    </div>

</section>
<script>
    var PRO_PLUGIN_URL = "<?php echo esc_url(CHT_PRO_URL) ?>";
</script>

