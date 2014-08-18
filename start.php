<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . "/lib/functions.php");

// register default elgg events
elgg_register_event_handler("init", "system", "dataroot_browser_init");

/**
 * Called during system initialization
 *
 * @return void
 */
function dataroot_browser_init() {
	// CSS
	elgg_extend_view("css/admin", "dataroot_browser/css/admin");
	
	// menu item
	elgg_register_admin_menu_item("administer", "dataroot_browser", "administer_utilities");
	
	// register actions
	elgg_register_action("dataroot_browser/delete_file", dirname(__FILE__) . "/actions/delete_file.php", "admin");
}
