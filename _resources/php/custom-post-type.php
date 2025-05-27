<?php
/**
 * _RESOURCES \\ PHP \\ CUSTOM POST TYPE
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

// ====================================================================================================
// Create Custom Post Type
// ====================================================================================================
add_action("init", function() {
    $args = array(
        "labels" => array(
            "name" => __("Redirects"),
            "singular_name" => __("Redirect"),
            "menu_name" => __("Redirects"),
            "add_new" => __("Add Redirect"),
            "add_new_item" => __("Add Redirect"),
            "not_found" => __("No Redirects Found")
        ),
        "public" => true,
        "has_archive" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "menu_icon" => 'data:image/svg+xml;base64,' . base64_encode(ICON),
        "supports" => array("title"),
        "rewrite" => false,
        "show_in_rest" => true,
        "exclude_from_search" => true
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
// Add Columns in Admin Area
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

add_action("manage_adk-redirects_posts_custom_column", function($column, $post_id) {
    if($column == "redirect") {
        $value = get_post_meta($post_id, '_redirect_direction', true);
        echo "<span style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 100%;display: block;'>" . $value . "</span>";
    }
}, 10, 2);