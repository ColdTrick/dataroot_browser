<?php

namespace ColdTrick\DatarootBrowser;

class UserHover {
	
	/**
	 * Add a menu item to the user hover dropdown
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current menu items
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register($hook, $type, $return_value, $params) {
		static $user_dirs;
		
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		if (empty($params) || !is_array($params)) {
			return;
		}
		
		$user = elgg_extract('entity', $params);
		if (!($user instanceof \ElggUser)) {
			return;
		}
		
		if (!isset($user_dirs)) {
			$user_dirs = [];
		}
		
		// save in a static for performance when viewing user listings
		if (!isset($user_dirs[$user->getGUID()])) {
			$user_dirs[$user->getGUID()] = false;
			
			$edl = new \Elgg\EntityDirLocator($user->getGUID());
			$path = $edl->getPath();
			
			if (is_dir(elgg_get_data_path() . $path)) {
				$path = substr($path, 0, -1);
				
				$user_dirs[$user->getGUID()] = \ElggMenuItem::factory([
					'name' => 'dataroot-browser',
					'text' => elgg_echo('dataroot_browser:menu:user_hover'),
					'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
						'dir' => $path,
					]),
					'is_trusted' => true,
					'section' => 'admin',
				]);
			}
		}
		
		if (empty($user_dirs[$user->getGUID()])) {
			return;
		}
		
		$return_value[] = $user_dirs[$user->getGUID()];
		
		return $return_value;
	}
}