<?php
/**
 * Plugin Name:       Adk Redirects
 * Description:       Adk Redirects is a streamlined WordPress plugin engineered to provide website administrators with robust control over URL redirection. This plugin facilitates the creation and management of permanent 301 redirects, essential for maintaining search engine rankings and ensuring a seamless user experience during site migrations, content updates, or URL structure changes.
 * Requires at least: 6.8.0
 * Requires PHP:      8.0
 * Version:           1.0.0
 * Author:            Jonathan Volks
 * Text Domain:       adk-redirects 
 *
 * @link    https://github.com/adkvolks/adk-redirects
 * @package adk-redirects
 */
namespace ADK\REDIRECTS;
if(!defined("ABSPATH")) { exit; }

// ====================================================================================================
// Constants
// ====================================================================================================
define("ADK\REDIRECTS\DIRECTORY",  WP_PLUGIN_DIR . "/adk-redirects/");
define("ADK\REDIRECTS\PLUGIN_URL", plugin_dir_url(__FILE__));
define("ADK\REDIRECTS\SITE_URL",   get_site_url());
define("ADK\REDIRECTS\TEXTDOMAIN", "adk-redirects");
define("ADK\REDIRECTS\ICON",       '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="640" height="640" viewBox="0 0 640 640"><g id="icomoon-ignore"></g><path fill="#ffffff" d="M435.2 431.040c-29.132 30.489-70.114 49.442-115.522 49.442-88.189 0-159.68-71.491-159.68-159.68 0-0.282 0.001-0.564 0.002-0.846v0.044c0-88.366 71.634-160 160-160 36.201 0 69.592 12.022 96.402 32.292l-0.402-0.292v-32h64v208c0 26.509 21.491 48 48 48s48-21.491 48-48v0-48c-0.104-141.306-114.679-255.817-256-255.817-141.385 0-256 114.615-256 256s114.615 256 256 256c41.761 0 81.186-9.999 116.013-27.735l-1.453 0.671 28.8 57.28c-41.758 21.38-91.096 33.909-143.36 33.909-176.731 0-320-143.269-320-320s143.269-320 320-320c176.623 0 319.824 143.093 320 319.674v0.017h-0.32v48c0.001 0.099 0.001 0.216 0.001 0.334 0 61.856-50.144 112-112 112-38.456 0-72.384-19.381-92.552-48.908l-0.249-0.386zM320 416c53.019 0 96-42.981 96-96s-42.981-96-96-96v0c-53.019 0-96 42.981-96 96s42.981 96 96 96v0z"></path></svg>');
define("ADK\REDIRECTS\DOMAINS",    get_option("adk-redirect-option-domains", []));
define("ADK\REDIRECTS\TITLE",      __("Adk Redirects", TEXTDOMAIN));


// ====================================================================================================
// Required Files
// ====================================================================================================
// Utility Functions & Admin CSS/JS
require_once(DIRECTORY . "_resources/php/functions.php");
require_once(DIRECTORY . "_resources/php/scripts.php");

// WP Custom Post Type
require_once(DIRECTORY . "_resources/php/custom-post-type/adk-redirects.php");
require_once(DIRECTORY . "_resources/php/custom-post-type/metabox.php");

// Hooks
require_once(DIRECTORY . "_resources/php/hooks/404.php");

// WP Pages
require_once(DIRECTORY . "_resources/php/pages/settings.php");

// Uninstall
require_once(DIRECTORY . "_resources/php/database/uninstall.php");

