<?php

namespace ColdTrick\DatarootBrowser;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class EntityMenu {
	
	/**
	 * Add a menu item to the entity menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		
		if (!elgg_is_admin_logged_in()) {
			return null;
		}
		
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return null;
		}
		
		try {
			$edl = new \Elgg\EntityDirLocator($entity->guid);
		} catch (\InvalidArgumentException $e) {
			elgg_log($e, 'ERROR');
			return null;
		}
		
		$path = $edl->getPath();
		
		if (!is_dir(elgg_get_data_path() . $path)) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'dataroot-browser',
			'icon' => 'folder-open',
			'text' => elgg_echo('dataroot_browser:menu:user_hover'),
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
				'dir' => $path,
			]),
			'is_trusted' => true,
		]);
		
		return $return_value;
	}
}
