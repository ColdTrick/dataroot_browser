<?php
/**
 * All pluginhooks are bundled here
 */

/**
 * Add a menu item to the user hover dropdown
 *
 * @param string         $hook         the name off the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current menu items
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function dataroot_browser_register_user_hover_menu_hook($hook, $type, $return_value, $params) {
	static $user_dirs;
	
	if (!elgg_is_admin_logged_in()) {
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$user = elgg_extract("entity", $params);
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $return_value;
	}
	
	if (!isset($user_dirs)) {
		$user_dirs = array();
	}
	
	// save in a static for performance when viewing user listings
	if (!isset($user_dirs[$user->getGUID()])) {
		$user_dirs[$user->getGUID()] = false;
		
		$fh = new ElggFile();
		$fh->owner_guid = $user->getGUID();
		$fh->setFilename("dummy");
		
		$path = $fh->getFilenameOnFilestore();
		$path = substr($path, 0, -5);
		
		if (is_dir($path)) {
			$path = str_ireplace(elgg_get_data_path(), "", $path);
			$path = substr($path, 0, -1);
		
			$user_dirs[$user->getGUID()] = ElggMenuItem::factory(array(
				"name" => "dataroot-browser",
				"text" => elgg_echo("dataroot_browser:menu:user_hover"),
				"href" => "admin/administer_utilities/dataroot_browser?dir=" . urlencode($path),
				"is_trusted" => true,
				"section" => "admin"
			));
		}
	}
	
	if ($user_dirs[$user->getGUID()]) {
		$return_value[] = $user_dirs[$user->getGUID()];
	}
	
	return $return_value;
}
