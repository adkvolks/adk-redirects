<?php
/**
 * _RESOURCES \\ PHP \\ HOOKS \\ UNINSTALL
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

// ====================================================================================================
// When Plugin Uninstalled, Delete Table and Options
// ====================================================================================================
register_uninstall_hook(__FILE__, "uninstall");

function uninstall() {
    global $wpdb;

    // Checking if Table Exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '". TABLE_404_LOGS ."'");

    // Drop Table
    if($table_exists == TABLE_404_LOGS) {
        $sql = "DROP TABLE IF EXISTS `$table_name`;"; // Using backticks for table name for safety
        $wpdb->query($sql);
    }

    // Delete Options
    delete_option("redirect_settings_404_report");
    delete_option("redirect_settings_404_pause");
    delete_option("redirect_settings_db_version");
    delete_option("redirect_settings_website_urls");
}