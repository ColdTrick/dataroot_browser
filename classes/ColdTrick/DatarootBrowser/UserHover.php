<?php

namespace ColdTrick\DatarootBrowser;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the user_hover menu
 */
class UserHover {
	
	/**
	 * Add a menu item to the user hover dropdown
	 *
	 * @param \Elgg\Event $event 'register', 'menu:user_hover'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		static $user_dirs = [];
		
		if (!elgg_is_admin_logged_in()) {
			return null;
		}
		
		$user = $event->getEntityParam();
		if (!$user instanceof \ElggUser) {
			return null;
		}
		
		// save in a static for performance when viewing user listings
		if (!isset($user_dirs[$user->guid])) {
			$user_dirs[$user->guid] = false;
			
			try {
				$edl = new \Elgg\EntityDirLocator($user->guid);
			} catch (\InvalidArgumentException $e) {
				elgg_log($e, 'ERROR');
				return null;
			}
			
			$path = $edl->getPath();
			
			if (is_dir(elgg_get_data_path() . $path)) {
				$user_dirs[$user->guid] = \ElggMenuItem::factory([
					'name' => 'dataroot-browser',
					'icon' => 'folder-open',
					'text' => elgg_echo('dataroot_browser:menu:user_hover'),
					'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
						'dir' => $path,
					]),
					'is_trusted' => true,
					'section' => 'admin',
				]);
			}
		}
		
		if (empty($user_dirs[$user->guid])) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		$return_value[] = $user_dirs[$user->guid];
		
		return $return_value;
	}
}
