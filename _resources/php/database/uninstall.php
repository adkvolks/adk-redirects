<?php
/**
 * _RESOURCES \\ PHP \\ DATABASE \\ UNINSTALL
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
    // Delete all posts of your custom post type
    $posts = get_posts(array(
        "post_type"      => "adk-redirects",
        "posts_per_page" => -1,
        "post_status" => "any"
    ));

    foreach($posts as $post) {
        wp_delete_post($post->ID, true);
    }

    // Deregister the custom post type
    unregister_post_type("adk-redirects");

    // Delete Options
    delete_option("adk-redirect-option-domains");
}