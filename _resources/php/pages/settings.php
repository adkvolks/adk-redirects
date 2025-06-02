<?php
/**
 * _RESOURCES \\ PHP \\ PAGES \\ SETTINGS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;
if(!defined("ABSPATH")) { exit; }

// ====================================================================================================
// Register Setting, Add Section and Field
// ====================================================================================================
add_action("admin_init", function() {

    // Register Setting
    register_setting(
        "adk-redirect-settings-group",
        "adk-redirect-option-domains",
        array("type" => "string", "sanitize_callback" => "ADK\REDIRECTS\sanitize_website_urls")
    );

    // Add Section
    add_settings_section(
        "adk-redirect-settings-section",
        __("Additional Domains", TEXTDOMAIN),
        function() { esc_html_e("Add any other domain names that currently direct traffic to this website. Make sure their DNS settings are configured the same as the primary domain. Short domains can be useful to include here.", TEXTDOMAIN); },
        "adk-redirects-page-settings"
    );

    // Add Field
    add_settings_field(
        "adk-redirect-option-domains",
        "",
        "ADK\REDIRECTS\\page_field_domains",
        "adk-redirects-page-settings",
        "adk-redirect-settings-section"
    );

});


// ====================================================================================================
// Create Admin Page
// ====================================================================================================
add_action("admin_menu", function() {
    add_submenu_page(
        "edit.php?post_type=adk-redirects",
        __(TITLE . " Settings", TEXTDOMAIN),
        __("Settings", TEXTDOMAIN),
        "manage_options",
        "adk-redirects-page-settings",
        "ADK\REDIRECTS\\page_settings",
        'data:image/svg+xml;base64,' . base64_encode(ICON)
    );
});

/**
 * Callback function to render the content of the submenu page.
 */
function page_settings() {
    printf("<div class='wrap'>");
        printf("<h1>". __(TITLE . " Settings", TEXTDOMAIN) ."</h1>");
        printf("<form method='post' action='options.php'>");
            settings_fields("adk-redirect-settings-group");
            do_settings_sections("adk-redirects-page-settings");
            submit_button();
        printf("</form>");
    printf("</div>");
}


/**
 * Callback to render the website URLs input fields.
 */
function page_field_domains() {
    $urls = get_option("adk-redirect-option-domains", array("")); // Default to one empty field

    echo '<div id="AdkRedirectsDomains">';
    if(!empty($urls)) : 
        foreach($urls as $index => $url) :
            display_field_domain($index, $url);
        endforeach; 
    else :
        display_field_domain(0, "");
    endif;
    echo '</div>';

    echo '<div style="text-align: right"><button type="button" class="button" id="AdkRedirects-Add-URL" style="width: 102px">' . esc_html__( 'Add New URL', TEXTDOMAIN ) . '</button></div>';
}

/**
 * Display Single URL Field
 * 
 * @param int $number
 * @param string $value
 * 
 * @return void
 */
function display_field_domain($number, $value) {
    $label = "<label for='website_url_". $number ."'>". __("URL ", TEXTDOMAIN) . ($number + 1) ."</label>";
    $input = "<input type='text' id='website_url_". $number ."' name='adk-redirect-option-domains[]' value='". esc_attr($value) ."' class='regular-text'>";
    $button = "<button type='button' class='button AdkRedirects-Remove-URL'>". __("Remove", TEXTDOMAIN) ."</button>";

    __string($label . $input . $button, "<div class='AdkRedirectsDomains__row'>%%</div>", NULL, true);
}