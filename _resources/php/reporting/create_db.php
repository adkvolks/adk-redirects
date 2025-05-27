<?php
/**
 * _RESOURCES \\ PHP \\ REPORTING \\ CREATE
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

add_action("plugins_loaded", function() {
    // Step 1: Check if reporting is enabled
    $option_404_report = get_option("redirect_settings_404_report", 0);

    if(!$option_404_report)
        return;


    // Step 2: Check if wp_404_logs table exists
    global $wpdb;
    $table_name = $wpdb->prefix . "404_logs";
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");

    if($table_exists == $table_name)
        return;

    // Step 3: Doesn't Exist, Create It
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        url text NOT NULL,
        referrer text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    update_option("redirect_settings_db_version", "1.0");
});
