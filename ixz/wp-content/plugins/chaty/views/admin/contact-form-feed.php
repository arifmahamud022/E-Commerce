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

global $wpdb;
$tableName = $wpdb->prefix.'chaty_contact_form_leads';

$paged   = filter_input(INPUT_GET, 'paged');
$current = isset($paged)&&!empty($paged)&&is_numeric($paged)&&$paged > 0 ? $paged : 1;
$current = intval($current);

$searchFor  = "all_time";
$searchList = [
    'today'        => 'Today',
    'yesterday'    => 'Yesterday',
    'last_7_days'  => 'Last 7 Days',
    'last_30_days' => 'Last 30 Days',
    'this_week'    => 'This Week',
    'this_month'   => 'This Month',
    'all_time'     => 'All Time',
    'custom'       => 'Custom Date',
];

$searchFor = filter_input(INPUT_GET, 'search_for');
if (isset($searchFor) && !empty($searchFor) && isset($searchList[$searchFor])) {
    $searchFor = esc_attr($searchFor);
} else {
    $searchFor = "all_time";
}

$startDate = "";
$endDate   = "";
if ($searchFor == "today") {
    $startDate = date("Y-m-d");
    $endDate   = date("Y-m-d");
} else if ($searchFor == "yesterday") {
    $startDate = date("Y-m-d", strtotime("-1 days"));
    $endDate   = date("Y-m-d", strtotime("-1 days"));
} else if ($searchFor == "last_7_days") {
    $startDate = date("Y-m-d", strtotime("-7 days"));
    $endDate   = date("Y-m-d");
} else if ($searchFor == "last_30_days") {
    $startDate = date("Y-m-d", strtotime("-30 days"));
    $endDate   = date("Y-m-d");
} else if ($searchFor == "this_week") {
    $startDate = date("Y-m-d", strtotime('monday this week'));
    $endDate   = date("Y-m-d");
} else if ($searchFor == "this_month") {
    $startDate = date("Y-m-01");
    $endDate   = date("Y-m-d");
} else if ($searchFor == "custom") {
    $startDate = filter_input(INPUT_GET, 'start_date');
    if (!empty($startDate)) {
        $startDate = esc_attr($startDate);
    } else {
        $startDate = "";
    }

    $endDate = filter_input(INPUT_GET, 'end_date');
    if (!empty($endDate)) {
        $endDate = esc_attr($endDate);
    } else {
        $endDate = "";
    }
}//end if

$hasSearch = filter_input(INPUT_GET, 'search');
$hasSearch = isset($hasSearch)&&!empty($hasSearch) ? $hasSearch : false;

$query  = "SELECT count(id) as total_records FROM ".$tableName;
$search = "";

$condition      = "";
$conditionArray = [];
if ($hasSearch !== false) {
    $search           = $hasSearch;
    $hasSearch        = '%'.esc_sql($hasSearch).'%';
    $condition       .= " (name LIKE %s OR email LIKE %s OR phone_number LIKE %s OR message LIKE %s)";
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
    $conditionArray[] = $hasSearch;
}

$startDate = esc_attr($startDate);
$endDate   = esc_attr($endDate);
if (!empty($startDate) && !empty($endDate)) {
    if (!empty($condition)) {
        $condition .= " AND ";
    }

    $cStartDate       = date("Y-m-d 00:00:00", strtotime($startDate));
    $cEndDate         = date("Y-m-d 23:59:59", strtotime($endDate));
    $condition       .= " created_on >= %s AND created_on <= %s";
    $conditionArray[] = $cStartDate;
    $conditionArray[] = $cEndDate;
}

if (!empty($condition)) {
    $query .= " WHERE ".$condition;
}

$query .= " ORDER BY ID DESC";

if (!empty($conditionArray)) {
    $query = $wpdb->prepare($query, $conditionArray);
}

$totalRecords = $wpdb->get_var($query);
$perPage      = 15;
$totalPages   = ceil($totalRecords / $perPage);

$query = "SELECT * FROM ".$tableName;
if (!empty($condition)) {
    $query .= " WHERE ".$condition;
}

if ($current > $totalPages) {
    $current = 1;
}

$startFrom = (($current - 1) * $perPage);

$query .= " ORDER BY ID DESC";
$query .= " LIMIT $startFrom, $perPage";

if (!empty($conditionArray)) {
    $query = $wpdb->prepare($query, $conditionArray);
}
?>
<style>
    #wpwrap {
        position: inherit;
    }
</style>
<style>
    body {
        background: #f0f0f1 !important;
    }
    #wpfooter {
        position: relative;
    }
    .chaty-updates-form {
        width: 768px;
        padding: 70px 40px;
        box-shadow: 0px 20px 25px rgb(0 0 0 / 10%), 0px 10px 10px rgb(0 0 0 / 4%);
        display: flex;
        margin: 100px auto 0;
        font-family: Rubik, sans-serif;
        align-items: center;
    }
    .update-title {
        font-style: normal;
        font-weight: 500;
        font-size: 26px;
        line-height: 150%;
        align-items: center;
        color: #334155;
        position: relative;
        padding: 0 0 10px 0;
    }
    .updates-form-form-left {
        padding: 0px 20px 0px 0;
    }
    .updates-form-form-right p {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 150%;
        position: relative;
        padding: 0 0 20px 0;
        color: #475569;
        margin: 30px 0;
    }
    .update-title:after {
        content: "";
        border: 1px solid #3C85F7;
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 90px;
    }
</style>
<div class="wrap">
    <?php
    $result = $wpdb->get_results($query);
    ?>
    <div>
        <?php if ($result || !empty($search) || $searchFor != 'all_time') { ?>
            <h1 class="wp-heading">Contact Form Leads
                <div class="lead-search-box">
                    <form action="<?php echo admin_url("admin.php") ?>" method="get">
                        <label class="screen-reader-text" for="post-search-input">Search:</label>
                        <select class="search-input" name="search_for" style="" id="date-range">
                            <?php foreach ($searchList as $key => $value) { ?>
                                <option <?php selected($key, $searchFor) ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($value) ?></option>
                            <?php } ?>
                        </select>
                        <input type="search" class="search-input" name="search" value="<?php echo esc_attr($search) ?>" class="">
                        <input type="submit" id="search-submit" class="button" value="Search">
                        <input type="hidden" name="page" value="chaty-contact-form-feed" />
                        <div class="date-range <?php echo ($searchFor == "custom" ? "active" : "") ?>">
                            <input type="search" class="search-input" name="start_date" id="start_date" value="<?php echo esc_attr($startDate) ?>" autocomplete="off" placeholder="Start date">
                            <input type="search" class="search-input" name="end_date" id="end_date" value="<?php echo esc_attr($endDate) ?>" autocomplete="off" placeholder="End date">
                        </div>
                    </form>
                </div>
            </h1>
        <?php }//end if
        ?>
        <form action="" method="post">
            <?php if ($result) { ?>
                <div class="tablenav top">
                    <div class="alignleft actions bulkactions">
                        <select name="action" id="bulk-action-selector-top">
                            <option value="">Bulk Actions</option>
                            <option value="delete_message">Delete</option>
                        </select>
                        <input type="submit" id="doaction" class="button action" value="Apply">
                    </div>
                </div>
                <style>
                    body {
                        background: #ffffff;
                    }
                    #wpwrap {
                        position: inherit;
                    }
                </style>
            <?php } ?>
            <?php
            if ($result) {
                ?>
                <table border="0" class="responstable">
                    <tr>
                        <th style="width:1%"><?php esc_html_e('Bulk', 'chaty');?></th>
                        <th><?php esc_html_e('ID', 'chaty');?></th>
                        <th><?php esc_html_e('Widget Name', 'chaty');?></th>
                        <th><?php esc_html_e('Name', 'chaty');?></th>
                        <th><?php esc_html_e('Email', 'chaty');?></th>
                        <th><?php esc_html_e('Phone number', 'chaty');?></th>
                        <th><?php esc_html_e('Message', 'chaty');?></th>
                        <th><?php esc_html_e('Date', 'chaty');?></th>
                        <th class="text-center"><?php esc_html_e('URL', 'chaty');?></th>
                        <th class="text-center"><?php esc_html_e('Delete', 'chaty');?></th>
                    </tr>
                    <?php
                    foreach ($result as $res) {
                        if ($res->widget_id == 0) {
                            $widgetName = "Default";
                        } else {
                            $widgetName = get_option("cht_widget_title_".$res->widget_id);
                            if (empty($widgetName)) {
                                $widgetName = "Widget #".($res->widget_id + 1);
                            }
                        }
                        ?>
                        <tr data-id="<?php echo esc_attr($res->id) ?>">
                            <td><input type="checkbox" value="<?php echo esc_attr($res->id) ?>" name="chaty_leads[]"></td>
                            <td><?php echo esc_attr($res->id) ?></td>
                            <td><?php echo esc_attr($widgetName) ?></td>
                            <td><?php echo esc_attr($res->name) ?></td>
                            <td><?php echo esc_attr($res->email) ?></td>
                            <td><?php echo esc_attr($res->phone_number) ?></td>
                            <td><?php echo esc_attr($res->message) ?></td>
                            <td><?php echo esc_attr($res->created_on) ?></td>
                            <td class="text-center"><a class="url" target="_blank" href="<?php echo esc_url($res->ref_page) ?>"><span class="dashicons dashicons-external"></span></a></td>
                            <td class="text-center"><a class="remove-record" href="#"><span class="dashicons dashicons-trash"></span></a></td>
                        </tr>
                    <?php }//end foreach
                    ?>
                </table>
                <?php
                if ($totalPages > 1) {
                    $baseURL = admin_url("admin.php?paged=%#%&page=chaty-contact-form-feed");
                    if (!empty($search)) {
                        $baseURL .= "&search=".esc_attr($search);
                    }

                    echo '<div class="custom-pagination">';
                    echo paginate_links(
                        [
                            'base'         => $baseURL,
                            'total'        => $totalPages,
                            'current'      => $current,
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'list',
                            'end_size'     => 3,
                            'mid_size'     => 1,
                            'prev_next'    => true,
                            'prev_text'    => sprintf('%1$s', '<span class="dashicons dashicons-arrow-left-alt2"></span>'),
                            'next_text'    => sprintf('%1$s', '<span class="dashicons dashicons-arrow-right-alt2"></span>'),
                            'add_args'     => false,
                            'add_fragment' => '',
                        ]
                    );
                    echo "</div>";
                }//end if
                ?>
                <div class="leads-buttons">
                    <a href="<?php echo admin_url("?download_chaty_file=chaty_contact_leads&nonce=".wp_create_nonce("download_chaty_contact_leads")) ?>" class="wpappp_buton" id="wpappp_export_to_csv" value="Export to CSV">Download &amp; Export to CSV</a>
                    <input type="button" class="wpappp_buton" id="chaty_delete_all_leads" value="Delete All Data">
                </div>
            <?php  } else if (!empty($search) || $searchFor != "all_time") { ?>
                <div class="chaty-updates-form">
                    <div class="updates-form-form-right">
                        <div class="update-title">Contact Form Leads</div>
                        <p>No records are found</p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="chaty-updates-form">
                    <div class="updates-form-form-left">
                        <?php wp_enqueue_script("lottie-player", CHT_PLUGIN_URL."admin/assets/js/lottie-player.js") ?>
                        <lottie-player src="<?php echo esc_url(CHT_PLUGIN_URL."admin/assets/js/animation.json") ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
                    </div>
                    <div class="updates-form-form-right">
                        <div class="update-title">Contact Form Leads</div>
                        <p>Your contact form leads will appear here once you get some leads. Please make sure you've added the contact form channel to your Chaty channels in order to collect leads</p>
                    </div>
                </div>
            <?php }//end if
            ?>
            <input type="hidden" name="remove_chaty_leads" value="<?php echo wp_create_nonce("remove_chaty_leads") ?>">
            <input type="hidden" name="paged" value="<?php echo esc_attr($current) ?>">
            <input type="hidden" name="search" value="<?php echo esc_attr($search) ?>">
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        var selectedURL = '<?php echo admin_url("admin.php?page=chaty-contact-form-feed&remove_chaty_leads=".wp_create_nonce("remove_chaty_leads")."&action=delete_message&paged={$current}&search=".esc_attr($search)."&chaty_leads=") ?>';
        jQuery(document).on("click", ".remove-record", function(e){
            e.preventDefault();
            var redirectRemoveURL = selectedURL+jQuery(this).closest("tr").data("id");
            if(confirm("Are you sure you want to delete Record with ID# "+jQuery(this).closest("tr").data("id"))) {
                window.location = redirectRemoveURL;
            }
        });jQuery(document).on("click", "#chaty_delete_all_leads", function(e){
            e.preventDefault();
            var redirectRemoveURL = selectedURL+"remove-all";
            if(confirm("Are you sure you want to delete all Record from the database?")) {
                window.location = redirectRemoveURL;
            }
        });
        jQuery("#date-range").on("change", function(){
            if(jQuery(this).val() == "custom") {
                jQuery(".date-range").addClass("active");
            } else {
                jQuery(".date-range").removeClass("active");
            }
        });
        if(jQuery("#start_date").length) {
            jQuery("#start_date").datepicker({
                dateFormat: 'yy-mm-dd',
                altFormat: 'yy-mm-dd',
                maxDate: 0,
                onSelect: function(d,i){
                    var minDate = jQuery("#start_date").datepicker('getDate');
                    minDate.setDate(minDate.getDate()); //add two days
                    jQuery("#end_date").datepicker("option", "minDate", minDate);
                    if(jQuery("#end_date").val() <= jQuery("#start_date").val()) {
                        jQuery("#end_date").val(jQuery("#start_date").val());
                    }

                    if(jQuery("#end_date").val() == "") {
                        jQuery("#end_date").val(jQuery("#start_date").val());
                    }
                }
            });
        }
        if(jQuery("#end_date").length) {
            jQuery("#end_date").datepicker({
                dateFormat: 'yy-mm-dd',
                altFormat: 'yy-mm-dd',
                maxDate: 0,
                minDate: 0,
                onSelect: function(d,i){
                    if(jQuery("#start_date").val() == "") {
                        jQuery("#start_date").val(jQuery("#end_date").val());
                    }
                }
            });
        }
    });
</script>
