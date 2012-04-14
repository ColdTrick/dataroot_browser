<?php 

	function dataroot_browser_init(){		
		elgg_extend_view("css/admin", "dataroot_browser/css/admin");
		elgg_register_admin_menu_item("administer", "dataroot_browser", "administer_utilities");
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
	elgg_register_event_handler('init','system','dataroot_browser_init');
	
	// register actions
	elgg_register_action("dataroot_browser/delete_file", dirname(__FILE__) . "/actions/delete_file.php", "admin");