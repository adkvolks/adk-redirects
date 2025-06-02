<?php
/**
 * _RESOURCES \\ PHP \\ CUSTOM-POST-TYPE \\ ADK-REDIRECTS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;
if(!defined("ABSPATH")) { exit; }

// ====================================================================================================
// Register Custom Post Type
// ====================================================================================================
add_action("init", function() {
    $args = array(
        "labels" => array(
            "name"                  => __(TITLE, TEXTDOMAIN),
		    "singular_name"         => __("Redirect", TEXTDOMAIN),
		    "menu_name"             => __("Redirects", TEXTDOMAIN),
		    "name_admin_bar"        => __("Redirect", TEXTDOMAIN),
		    "add_new"               => __("Add Redirect", TEXTDOMAIN),
		    "add_new_item"          => __("Add New Redirect", TEXTDOMAIN),
		    "new_item"              => __("New Redirect", TEXTDOMAIN),
		    "edit_item"             => __("Edit Redirect", TEXTDOMAIN),
		    "view_item"             => __("View Redirect", TEXTDOMAIN),
		    "all_items"             => __("All Redirects", TEXTDOMAIN),
		    "search_items"          => __("Search Redirects", TEXTDOMAIN),
		    "parent_item_colon"     => __("Parent Redirects:", TEXTDOMAIN),
		    "not_found"             => __("No redirects found.", TEXTDOMAIN),
		    "not_found_in_trash"    => __("No redirects found in Trash.", TEXTDOMAIN),
		    "featured_image"        => __("Redirect Featured Image", TEXTDOMAIN),
		    "set_featured_image"    => __("Set Featured Image", TEXTDOMAIN),
		    "remove_featured_image" => __("Remove Featured Image", TEXTDOMAIN),
		    "use_featured_image"    => __("Use as featured image", TEXTDOMAIN),
		    "archives"              => __("Redirect archives", TEXTDOMAIN),
		    "insert_into_item"      => __("Insert into redirect", TEXTDOMAIN),
		    "uploaded_to_this_item" => __("Uploaded to this redirect", TEXTDOMAIN),
		    "filter_items_list"     => __("Filter redirect list", TEXTDOMAIN),
		    "items_list_navigation" => __("Redirect list navigation", TEXTDOMAIN),
		    "items_list"            => __("Redirect list", TEXTDOMAIN)
        ),
        "public"              => true,
        "hierarchical"        => false,
        "exclude_from_search" => true,
        "publicly_queryable"  => false,
        "show_ui"             => true,
        "show_in_menu"        => true,
        "show_in_nav_menus"   => false,
        "show_in_admin_bar"   => false,
        "show_in_rest"        => false,
        "menu_position"       => 25,
        "menu_icon"           => 'data:image/svg+xml;base64,' . base64_encode(ICON),
        "supports"            => array("title"),
        "has_archive"         => false,
        "rewrite"             => false,
        "query_var"           => false,
        "can_export"          => true,
        "delete_with_user"    => false        
    );
    register_post_type("adk-redirects", $args);
});


// ====================================================================================================
// Sort Admin by Title
// ====================================================================================================
add_action("pre_get_posts", function($query) {
    if($query->is_admin && $query->get("post_type") == "adk-redirects") { 
        $query->set("orderby", "title");
        $query->set("order", "ASC");
    }
    
    return $query;
});


// ====================================================================================================
// Add Column in Admin Area
// ====================================================================================================
add_filter("manage_adk-redirects_posts_columns", function($columns) {
    $new_array = array();
    $inserted = false;

    foreach ($columns as $key => $value) {
        $new_array[$key] = $value;
        if ($key === "title" && !$inserted) {
            $new_array["redirect"] = "Redirect Location";
            $inserted = true;
        }
    }

    return $new_array;
});


// ====================================================================================================
// Add ellipsis to Redirect Location column to cut off URLs. 
// ====================================================================================================
add_action("manage_adk-redirects_posts_custom_column", function($column, $post_id) {
    if($column == "redirect") {
        $value = get_post_meta($post_id, 'adk-redirect-post-meta-direction', true);
        echo "<span style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 100%;display: block;'>" . $value . "</span>";
    }
}, 10, 2);