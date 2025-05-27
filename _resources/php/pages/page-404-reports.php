<?php
/**
 * _RESOURCES \\ PHP \\ SETTINGS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

// ====================================================================================================
// Create Admin Page
// ====================================================================================================
add_action("admin_menu", function() {
    add_submenu_page(
        "edit.php?post_type=adk-redirects",
        "ADK \\\\ REDIRECTS \\\\ 404 REPORTS",
        "404 Reports",
        "manage_options",
        "adk-redirects-404-reports",
        "ADK\REDIRECTS\\render_404_reports"
    );
});


function render_404_reports() {
    remove_url_entries();
    $wrap    = "<div class='wrap'>%%</div>";
    $heading = "<h1>". __("404 Reports", TEXTDOMAIN) ."</h1>";
    $desc    = "<p>". __("Here's a report detailing the 404 errors encountered on the website. This information is provided for your review to identify and address broken links or missing resources. The table below lists the specific URLs that generated a \"Not Found\" error. Investigating these entries will help ensure a seamless user experience.", TEXTDOMAIN) ."</p>";
    $table   = generate_404_table();

    __string($heading . $desc . $table, $wrap, NULL, 1);
}


function generate_404_table() {
    global $wpdb;

    // Query the 404_logs table
    $results = $wpdb->get_results($wpdb->prepare("
        SELECT
            id, url,
            GROUP_CONCAT(DISTINCT referrer ORDER BY referrer SEPARATOR ';') AS all_referrers,
            MIN(timestamp) AS first_detected,
            MAX(timestamp) AS last_detected,
            COUNT(*) AS count
        FROM ". TABLE_404_LOGS ."
        GROUP BY url
        ORDER BY last_detected DESC;
    "));

    // Query returned zero results
    if(!$results)
        return __("<p><strong>It appears that no 404 errors have been logged in the database.</strong></p>", TEXTDOMAIN);

    // Generate Table HTML
    $table = "<table class='ADK-404-TABLE wp-list-table widefat fixed striped table-view-list posts'>%%</table>";
    $thead = "<thead><tr><th width='300px'>". __("URL", TEXTDOMAIN) ."</th><th width='22px'></th><th style='text-align: center'>". __("First Detected", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Last Detected", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Count", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Delete", TEXTDOMAIN) ."</th></tr></thead>";
    $tfoot = "<tfoot><tr><th>". __("URL", TEXTDOMAIN) ."</th><th></th><th style='text-align: center'>". __("First Detected", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Last Detected", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Count", TEXTDOMAIN) ."</th><th style='text-align: center'>". __("Delete", TEXTDOMAIN) ."</th></tr></tfoot>";
    $tbody = "<tbody>%%</tbody>";

    // Loop through results 
    $rows = "";
    foreach ($results as $row) {
        $rows .= "
            <tr>
                <td class='ADK-404-URL-SHORT'>". $row->url ."</td>
                <td align='center'><a href='#ADK-404-URL-LONG__". $row->id ."' class='ADK-404-TOGGLE'><span class='ADK-404-ICON dashicons dashicons-visibility'></span></a></td>
                <td align='center'>". date("M d, Y H:i", strtotime($row->first_detected)) ."</td>
                <td align='center'>". date("M d, Y H:i", strtotime($row->last_detected)) ."</td>
                <td align='center'>". $row->count ."</td>
                <td align='center'><a href='". $_SERVER["REQUEST_URI"] ."&rm404=". $row->id ."' class='button' onclick='return confirm(`Are you sure you want to delete this record?`)'>Delete</a></td>
            </tr>
            <tr id='ADK-404-URL-LONG__". $row->id ."' class='ADK-404-URL-LONG'>
                <td colspan='6'><strong>". $row->url ."</strong><br />". str_replace(";", "<br />", $row->all_referrers) ."</td>
            </tr>
        ";
    }

    // Return HTML
    $tbody = __string($rows, $tbody);
    return __string($thead . $tbody . $tfoot, $table);
}


function remove_url_entries() {
    global $wpdb;

    // Check if ID is in query string
    if(!isset($_GET["rm404"]) || $_GET["rm404"] == 0)
        return;
    
    // Get URL from ID
    $url = $wpdb->get_var(
        $wpdb->prepare("SELECT url FROM ". TABLE_404_LOGS ." WHERE id=%d", intval($_GET["rm404"]))
    );

    // Remove Entries
    $wpdb->get_var($wpdb->prepare("DELETE FROM ". TABLE_404_LOGS ." WHERE url='%s'", $url)); 
}