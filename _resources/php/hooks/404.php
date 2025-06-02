<?php
/**
 * _RESOURCES \\ PHP \\ HOOKS \\ 404
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

    // Request URL Information
    $request = [
        "path" =>   $_SERVER["REQUEST_URI"],
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
        $post_meta_domain    = get_post_meta(get_the_id(), "adk-redirect-post-meta-domain", true);
        $post_meta_path      = get_post_meta(get_the_id(), "adk-redirect-post-meta-path", true);
        $post_meta_type      = get_post_meta(get_the_id(), "adk-redirect-post-meta-type", true);
        $post_meta_direction = get_post_meta(get_the_id(), "adk-redirect-post-meta-direction", true);

        if($request["domain"] != $post_meta_domain)
            continue;

        // Redirect if match
        if($post_meta_type == "matches" && $request["path"] == $post_meta_path) 
            header("Location: ". $post_meta_direction,TRUE,301);

        $pattern = '#^'. $post_meta_path .'(?:/?(?:index(?:\.[a-zA-Z0-9]+)?)?)?$#i';
        if($post_meta_type == "folder" && preg_match($pattern, $request["path"])) 
            header("Location: ". $post_meta_direction,TRUE,301);

        if($post_meta_type == "contains" && str_contains($request["path"], $post_meta_path))
            header("Location: ". $post_meta_direction,TRUE,301);

        if($post_meta_type == "starts" && str_starts_with($request["path"], $post_meta_path)) 
            header("Location: ". $post_meta_direction,TRUE,301);

        if($post_meta_type == "ends" && str_ends_with($request["path"], $post_meta_path)) 
            header("Location: ". $post_meta_direction,TRUE,301);

	endwhile; wp_reset_postdata(); endif;
    
});

