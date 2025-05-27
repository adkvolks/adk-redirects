<?php
/**
 * _RESOURCES \\ PHP \\ METABOX
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

// ====================================================================================================
// Create Meta Box
// ====================================================================================================
add_action("add_meta_boxes", function() {
    add_meta_box(
        "ADK-REDIRECTS-METABOX-URL",
        "URL Information",
        "ADK\REDIRECTS\meta_box_render_URL",
        "adk-redirects",
        "normal", 
        "default"
    );

    add_meta_box(
        "ADK-REDIRECTS-METABOX-NOTES",
        "Notes",
        "ADK\REDIRECTS\meta_box_render_notes",
        "adk-redirects",
        "normal", 
        "default"
    );
});


// Render Form
function meta_box_render_url($post) {
    $redirect_input_domain = get_post_meta($post->ID, "_redirect_input_domain", true);
    $redirect_input_path   = get_post_meta($post->ID, "_redirect_input_path", true);
    $redirect_input_type   = get_post_meta($post->ID, "_redirect_input_type", true);
    $redirect_direction    = get_post_meta($post->ID, "_redirect_direction", true);

    // Additional Domains
    $additional_domains_html = "";
    $additional_domains_array = get_option("redirect_settings_website_urls");
    foreach($additional_domains_array as $domain) {
        $additional_domains_html .= "<option value='$domain' ". ($redirect_input_domain == $domain ? "SELECTED" : "") .">$domain</option>";
    }

    // URL Input
    printf("
        <div class='redirectsAdmin'>
            <fieldset class='row'>
                <div class='column shrink-1 grow-0'>
                    <label for='redirect_input_domain'>Domain:</label>
                    <select name='redirect_input_domain'>
                        <option value='". SITE_URL ."' ". ($redirect_input_domain == SITE_URL ? "SELECTED" : "") .">". SITE_URL ."</option>
                        $additional_domains_html
                    </select>
                </div>

                <div class='column shrink-1 grow-1'>
                    <label for='redirect_input_path'>Path:</label>
                    <input type='text' id='redirect_input_path' name='redirect_input_path' value='". esc_attr($redirect_input_path)  ."' />
                </div>

                <div class='column shrink-1 grow-0'>
                    <label for='redirect_input_type'>Type:</label>
                    <select name='redirect_input_type'>
                        <option value='matches'  ". ($redirect_input_type == "matches"  ? "SELECTED" : "") .">Matches Exactly</option>
                        <option value='folder'   ". ($redirect_input_type == "folder"   ? "SELECTED" : "") .">Matches Folder</option>
                        <option value='contains' ". ($redirect_input_type == "contains" ? "SELECTED" : "") .">Contains Within</option>
                        <option value='starts'   ". ($redirect_input_type == "starts"   ? "SELECTED" : "") .">Starts With</option>
                        <option value='ends'     ". ($redirect_input_type == "ends"     ? "SELECTED" : "") .">Ends With</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <label for='redirect_direction'>Redirect URL:</label>
                <input type='text' id='redirect_direction' name='redirect_direction' value='". esc_attr($redirect_direction)  ."' />
            </fieldset>
        </div>
    ");
}

function meta_box_render_notes($post) {
    $redirect_notes = get_post_meta($post->ID, "_redirect_notes", true);
    printf("
        <div class='redirectsAdmin'>
            <fieldset class='row'>
                <textarea name='redirect_notes' rows='6' style='margin-bottom: 0;'>". $redirect_notes ."</textarea>
            </fieldset>
        </div>
    ");
}


// ====================================================================================================
// Save the meta box data
// ====================================================================================================
add_action("save_post", function($post_id) {
    if (!current_user_can("edit_post", $post_id)) 
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) 
        return $post_id;
    
    if(isset($_POST["redirect_input_domain"])) {
        $value = sanitize_text_field($_POST["redirect_input_domain"]);
        update_post_meta($post_id, "_redirect_input_domain", $value);
    }

    if(isset($_POST["redirect_input_path"])) {
        $value = sanitize_text_field($_POST["redirect_input_path"]);
        update_post_meta($post_id, "_redirect_input_path", $value);
    }

    if(isset($_POST["redirect_input_type"])) {
        $value = sanitize_text_field($_POST["redirect_input_type"]);
        update_post_meta($post_id, "_redirect_input_type", $value);
    }

    if(isset( $_POST["redirect_direction"])) {
        $value = sanitize_text_field($_POST["redirect_direction"]);
        update_post_meta($post_id, "_redirect_direction", $value);
    }

    if(isset( $_POST["redirect_notes"])) {
        $value = sanitize_text_field($_POST["redirect_notes"]);
        update_post_meta($post_id, "_redirect_notes", $value);
    }

    return $post_id;
});

