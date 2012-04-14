<?php 

	function dataroot_browser_init(){
		
		extend_view("css", "dataroot_browser/css");
		
		register_page_handler('dataroot_browser','dataroot_browser_page_handler');
	}
	
	function dataroot_browser_pagesetup(){
		if (get_context() == 'admin' && isadminloggedin()) {
			global $CONFIG;
			add_submenu_item(elgg_echo('dataroot_browser:menu:title'), $CONFIG->wwwroot . 'pg/dataroot_browser/');
		}
	}
	
	function dataroot_browser_page_handler($page){
		global $CONFIG;
		
		// only interested in one page for now
		include($CONFIG->pluginspath . "dataroot_browser/pages/browse.php");
	}
	
	function dataroot_browser_format_size($size) {
		$sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		if ($size == 0) { 
			return('n/a'); 
		} else {
			return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); 
		}
	}
	
	// register default elgg events
	register_elgg_event_handler('init','system','dataroot_browser_init');
	register_elgg_event_handler('pagesetup','system','dataroot_browser_pagesetup');
	
	// register actions
	register_action("dataroot_browser/delete_file", false, dirname(__FILE__) . "/actions/delete_file.php", true);
?>