<?php
/**
 * _RESOURCES \\ PHP \\ CUSTOM-POST-TYPE \\ METABOX
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;
if(!defined("ABSPATH")) { exit; }

// ====================================================================================================
// Create Meta Box
// ====================================================================================================
add_action("add_meta_boxes", function() {
    add_meta_box(
        "adk-redirects-metabox-url",
        __("URL Information", TEXTDOMAIN),
        "ADK\REDIRECTS\meta_box_render_URL",
        "adk-redirects",
        "normal", 
        "default"
    );

    add_meta_box(
        "adk-redirects-metabox-notes",
        __("Notes", TEXTDOMAIN),
        "ADK\REDIRECTS\meta_box_render_notes",
        "adk-redirects",
        "normal", 
        "default"
    );
});


// Render Form
function meta_box_render_url($post) {
    $post_meta_domain    = get_post_meta($post->ID, "adk-redirect-post-meta-domain", true);
    $post_meta_path      = get_post_meta($post->ID, "adk-redirect-post-meta-path", true);
    $post_meta_type      = get_post_meta($post->ID, "adk-redirect-post-meta-type", true);
    $post_meta_direction = get_post_meta($post->ID, "adk-redirect-post-meta-direction", true);

    // Additional Domains
    $additional_domains_html = "";
    foreach(DOMAINS as $domain) {
        $additional_domains_html .= "<option value='$domain' ". ($post_meta_domain == $domain ? "SELECTED" : "") .">$domain</option>";
    }

    // URL Input
    printf("
        <div class='AdkRedirectsForm'>
            <fieldset class='AdkRedirectsForm__row'>
                <div class='AdkRedirectsForm__column'>
                    <label for='adk-redirect-post-meta-domain'>". __("Domain:", TEXTDOMAIN) ."</label>
                    <select name='adk-redirect-post-meta-domain'>
                        <option value='". esc_attr(SITE_URL) ."' ". ($post_meta_domain == SITE_URL ? "SELECTED" : "") .">". SITE_URL ."</option>
                        $additional_domains_html
                    </select>
                </div>

                <div class='AdkRedirectsForm__column AdkRedirectsForm__grow'>
                    <label for='adk-redirect-post-meta-path'>". __("Path:", TEXTDOMAIN) ."</label>
                    <input type='text' id='adk-redirect-post-meta-path' name='adk-redirect-post-meta-path' value='". esc_attr($post_meta_path)  ."' />
                </div>

                <div class='AdkRedirectsForm__column'>
                    <label for='adk-redirect-post-meta-type'>". __("Type:", TEXTDOMAIN) ."</label>
                    <select name='adk-redirect-post-meta-type'>
                        <option value='matches'  ". ($post_meta_type == "matches"  ? "SELECTED" : "") .">". __("Matches Exactly", TEXTDOMAIN) ."</option>
                        <option value='folder'   ". ($post_meta_type == "folder"   ? "SELECTED" : "") .">". __("Matches Folder", TEXTDOMAIN) ."</option>
                        <option value='contains' ". ($post_meta_type == "contains" ? "SELECTED" : "") .">". __("Contains Within", TEXTDOMAIN) ."</option>
                        <option value='starts'   ". ($post_meta_type == "starts"   ? "SELECTED" : "") .">". __("Starts With", TEXTDOMAIN) ."</option>
                        <option value='ends'     ". ($post_meta_type == "ends"     ? "SELECTED" : "") .">". __("Ends With", TEXTDOMAIN) ."</option>
                    </select>
                </div>
            </fieldset>

            <fieldset>
                <label for='adk-redirect-post-meta-direction'>". __("Redirect URL:", TEXTDOMAIN) ."</label>
                <input type='text' id='adk-redirect-post-meta-direction' name='adk-redirect-post-meta-direction' value='". esc_attr($post_meta_direction)  ."' />
            </fieldset>
        </div>
    ");
}

function meta_box_render_notes($post) {
    $post_meta_notes = get_post_meta($post->ID, "adk-redirects-post-meta-notes", true);
    printf("
        <div class='AdkRedirectsForm'>
            <fieldset class='AdkRedirectsForm__row'>
                <textarea name='adk-redirects-post-meta-notes' rows='6' style='margin-bottom: 0;'>". $post_meta_notes ."</textarea>
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
    
    if(isset($_POST["adk-redirect-post-meta-domain"])) {
        $value = sanitize_text_field($_POST["adk-redirect-post-meta-domain"]);
        update_post_meta($post_id, "adk-redirect-post-meta-domain", $value);
    }

    if(isset($_POST["adk-redirect-post-meta-path"])) {
        $value = sanitize_text_field($_POST["adk-redirect-post-meta-path"]);
        update_post_meta($post_id, "adk-redirect-post-meta-path", $value);
    }

    if(isset($_POST["adk-redirect-post-meta-type"])) {
        $value = sanitize_text_field($_POST["adk-redirect-post-meta-type"]);
        update_post_meta($post_id, "adk-redirect-post-meta-type", $value);
    }

    if(isset( $_POST["adk-redirect-post-meta-direction"])) {
        $value = sanitize_text_field($_POST["adk-redirect-post-meta-direction"]);
        update_post_meta($post_id, "adk-redirect-post-meta-direction", $value);
    }

    if(isset( $_POST["adk-redirects-post-meta-notes"])) {
        $value = sanitize_text_field($_POST["adk-redirects-post-meta-notes"]);
        update_post_meta($post_id, "adk-redirects-post-meta-notes", $value);
    }

    return $post_id;
});

