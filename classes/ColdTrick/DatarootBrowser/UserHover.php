<?php

namespace ColdTrick\DatarootBrowser;

class UserHover {
	
	/**
	 * Add a menu item to the user hover dropdown
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:user_hover'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register(\Elgg\Hook $hook) {
		static $user_dirs = [];
		
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		$user = $hook->getEntityParam();
		if (!$user instanceof \ElggUser) {
			return;
		}
		
		// save in a static for performance when viewing user listings
		if (!isset($user_dirs[$user->guid])) {
			$user_dirs[$user->guid] = false;
			
			try {
				$edl = new \Elgg\EntityDirLocator($user->guid);
			} catch (\InvalidArgumentException $e) {
				elgg_log($e, 'ERROR');
				return;
			}
			$path = $edl->getPath();
			
			if (is_dir(elgg_get_data_path() . $path)) {
				$user_dirs[$user->guid] = \ElggMenuItem::factory([
					'name' => 'dataroot-browser',
					'text' => elgg_echo('dataroot_browser:menu:user_hover'),
					'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
						'dir' => $path,
					]),
					'icon' => 'folder-open',
					'is_trusted' => true,
					'section' => 'admin',
				]);
			}
		}
		
		if (empty($user_dirs[$user->guid])) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = $user_dirs[$user->guid];
		
		return $return_value;
	}
}
