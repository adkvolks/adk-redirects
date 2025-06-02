<?php
/**
 * _RESOURCES \\ PHP \\ SCRIPTS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;
if(!defined("ABSPATH")) { exit; }

// ====================================================================================================
// Enqueue Styles in Admin Area
// ====================================================================================================
add_action("admin_head", function() {
    wp_enqueue_style("adk-redirects-admin-css" , PLUGIN_URL . "/_resources/css/styles.css");
});


// ====================================================================================================
// Enqueue JS in Admin Area
// ====================================================================================================
add_action("admin_enqueue_scripts", function() {
    wp_enqueue_script("adk-redirects-admin-js", PLUGIN_URL . "/_resources/js/scripts.js", array(), '1.0.0', true );
});