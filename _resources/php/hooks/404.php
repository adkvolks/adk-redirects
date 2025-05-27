<?php
/**
 * _RESOURCES \\ PHP \\ HOOK
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

// ====================================================================================================
// Intercept 404 Page
// ====================================================================================================
add_action("template_redirect", function() {
    if(!is_404())
        return;

    // Check for Redirect
    hook_check_redirect();

    // Report 404
    hook_log_404();
    
});


/**
 * Loops through custom post type and checks if current URL matches any, if so then redirect.
 * 
 * @return void
 */
function hook_check_redirect() {
    // Request URL Information
    $request = [
        "path" => $_SERVER["REQUEST_URI"],
        "domain" => $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://" . $_SERVER["SERVER_NAME"],
    ];
    
    // Loop Through Custom Post Type
    $args = array(
	    "post_type"      => "adk-redirects",
	    "posts_per_page" => -1,
        "post_status"    => "publish"
    );

    $custom_posts = new \WP_Query($args);
    if($custom_posts->have_posts()) : while($custom_posts->have_posts()) : $custom_posts->the_post();
        $cpt_domain   = get_post_meta(get_the_id(), "_redirect_input_domain", true);
        $cpt_path     = get_post_meta(get_the_id(), "_redirect_input_path", true);
        $cpt_type     = get_post_meta(get_the_id(), "_redirect_input_type", true);
        $cpt_redirect = get_post_meta(get_the_id(), "_redirect_direction", true);

        if($request["domain"] != $cpt_domain)
            continue;

        // Redirect if match
        if($cpt_type == "matches" && $request["path"] == $cpt_path) 
            header("Location: ". $cpt_redirect,TRUE,301);

        $pattern = '#^'. $cpt_path .'(?:/?(?:index(?:\.[a-zA-Z0-9]+)?)?)?$#i';
        if($cpt_type == "folder" && preg_match($pattern, $request["path"])) 
            header("Location: ". $cpt_redirect,TRUE,301);

        if($cpt_type == "contains" && str_contains($request["path"], $cpt_path))
            header("Location: ". $cpt_redirect,TRUE,301);

        if($cpt_type == "starts" && str_starts_with($request["path"], $cpt_path)) 
            header("Location: ". $cpt_redirect,TRUE,301);

        if($cpt_type == "ends" && str_ends_with($request["path"], $cpt_path)) 
            header("Location: ". $cpt_redirect,TRUE,301);

	endwhile; wp_reset_postdata(); endif;
}


/**
 * Adds a record to the database with information about the URL that is 404. Rate limit to 22 per day.
 * 
 * @return void
 */
function hook_log_404() {
    // Check if 404 Capture is Paused
    $option_404_pause = get_option("redirect_settings_404_pause", 0);
    if($option_404_pause)
        return;

    // Variables
    global $wpdb;
    $url          = $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $limit_count  = 21;
    $current_time = current_time("mysql");
    $cutoff_time  = date('Y-m-d H:i:s', strtotime('-86400 seconds', strtotime($current_time)));
    $referrer     = (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : ""); 

    // Rate Limiting - No more than 21 in 1 Day
    $log_count = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM ". TABLE_404_LOGS ." WHERE url = %s AND timestamp > %s", $url, $cutoff_time)
    );
    if($log_count > $limit_count) 
        return;

    // Insert into log
    $wpdb->insert(
        TABLE_404_LOGS,
        array("timestamp" => $current_time,"url" => esc_url_raw($url), "referrer" => esc_url_raw($referrer)),
        array("%s","%s")
    );
}