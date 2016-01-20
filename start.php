<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default elgg events
elgg_register_event_handler('init', 'system', 'dataroot_browser_init');

/**
 * Called during system initialization
 *
 * @return void
 */
function dataroot_browser_init() {
	// CSS
	elgg_extend_view('css/admin', 'css/dataroot_browser/admin');
	
	// menu item
	elgg_register_admin_menu_item('administer', 'dataroot_browser', 'administer_utilities');
	
	// plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', '\ColdTrick\DatarootBrowser\UserHover::register');
	
	// register actions
	elgg_register_action('dataroot_browser/delete_file', dirname(__FILE__) . '/actions/delete_file.php', 'admin');
	elgg_register_action('dataroot_browser/download', dirname(__FILE__) . '/actions/download.php', 'admin');
}
