<?php

namespace ColdTrick\DatarootBrowser;

class EntityMenu {
	
	/**
	 * Add a menu item to the entity menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:entity'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function register(\Elgg\Hook $hook) {
		
		if (!elgg_is_admin_logged_in()) {
			return;
		}
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return;
		}
		
		try {
			$edl = new \Elgg\EntityDirLocator($entity->guid);
		} catch (\InvalidArgumentException $e) {
			elgg_log($e, 'ERROR');
			return;
		}
		$path = $edl->getPath();
		
		if (!is_dir(elgg_get_data_path() . $path)) {
			return;
		}
		
		$return_value = $hook->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'dataroot-browser',
			'text' => elgg_echo('dataroot_browser:menu:user_hover'),
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
				'dir' => $path,
			]),
			'icon' => 'folder-open',
			'is_trusted' => true,
		]);
		
		return $return_value;
	}
}
