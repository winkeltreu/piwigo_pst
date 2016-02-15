<?PHP

/*
Version 1.0
Plugin Name: Protect Search and Tags
Plugin URI:
Author: winkeltreu
Description: This plugin restricts access to search and tags to registered users.
 */

// Chech whether we are indeed included by Piwigo.
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// Define the path to our plugin.
define('PST_PATH', PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

// Hook on to an event to show the administration page.
add_event_handler('get_admin_plugin_menu_links', 'PST_admin_menu');

// Hook on tags where classic user status is required
add_event_handler('loc_begin_search', 'PST_search_tag_page');
add_event_handler('loc_begin_tags', 'PST_search_tag_page');
add_event_handler('loc_begin_index', 'PST_index_page');

// Add an entry to the 'Plugins' menu.
function PST_admin_menu($menu) {
 array_push(
   $menu,
   array(
     'NAME'  => 'ProtectSearchTags',
     'URL'   => get_admin_plugin_menu_link(dirname(__FILE__)).'/admin.php'
   )
 );
 return $menu;
}

function PST_index_page() {
    // load common.inc.php
    $requests = explode('/', $_SERVER['REQUEST_URI']);

    if (in_array('tags', $requests) || in_array('search', $requests))
        if (!(is_classic_user() || is_admin() || is_webmaster()))
            redirect(get_absolute_root_url()."identification.php");
}

function PST_search_tag_page() {
    if (!(is_classic_user() || is_admin() || is_webmaster()))
        redirect(get_absolute_root_url()."identification.php");
}


?>
