<?php 
	admin_gatekeeper();

	$current_dir = get_input("dir");
	
	set_context("admin");
	set_page_owner(get_loggedin_userid());
	
	// Build elements
	$title_text = elgg_echo("dataroot_browser:menu:title");
	$title = elgg_view_title($title_text);
	
	$body = elgg_view("dataroot_browser/list", array("current_dir" => $current_dir));
	
	// Build page
	$page_data = $title . $body;
	
	page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));


?>