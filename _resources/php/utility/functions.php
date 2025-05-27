<?php
/**
 * _RESOURCES \\ PHP \\ UTILITY \\ FUNCTIONS
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;

if(!function_exists("__string")) {
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