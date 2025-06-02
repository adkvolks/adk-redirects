<?php
/**
 * _RESOURCES \\ PHP \\ FUNCTIONS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

if(!function_exists("__string")) {
    /**
     *  Utility function  for formatting and outputting strings, providing flexibility for default values and simple templating.
     * 
     * @param string $string
     * @param string $wrapper
     * @param string $replacement
     * @param bool $echo
     * 
     * @return string|bool
     */
    function __string($string, $wrapper=NULL, $replacement=NULL, $echo=false) {
        // Empty Check
        if(empty($string) && empty($replacement))
            return false;

        // Replacement Check
        if(empty($string) && !empty($replacement))
            $string = $replacement; 

        // Wrapper Check
        if(!empty($wrapper))
            $string = str_replace("%%", $string, $wrapper);

        // Echo or return variable
        if($echo) {
            echo $string;
            return true;
        } else {
            return $string;
        }
    }
}


if(!function_exists("sanitize_website_urls")) {
    /**
     * Sanitizes the website URLs before saving.
     *
     * @param array $urls Array of website URLs.
     * @return array Sanitized array of website URLs.
     */
    function sanitize_website_urls($urls) {
        if(!is_array($urls)) 
            return array();

        $sanitized_urls = array();
        foreach($urls as $url) {
            $sanitized_url = esc_url_raw(trim($url));
            if (!empty($sanitized_url)) 
                $sanitized_urls[] = $sanitized_url;
        }
        return array_values(array_filter($sanitized_urls));
    }
}