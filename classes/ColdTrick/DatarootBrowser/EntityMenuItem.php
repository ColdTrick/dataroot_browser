<?php

namespace ColdTrick\DatarootBrowser;

/**
 * Helper trait to get the dataroot browser menu item
 */
trait EntityMenuItem {
	
	/**
	 * Get the menu items that links to the dataroot folder of the entity
	 *
	 * @param \ElggEntity $entity entity to get the menu item for
	 *
	 * @return \ElggMenuItem|null
	 */
	protected static function getEntityMenuItem(\ElggEntity $entity): ?\ElggMenuItem {
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
		
		return \ElggMenuItem::factory([
			'name' => 'dataroot-browser',
			'icon' => 'folder-open',
			'text' => elgg_echo('dataroot_browser:menu:user_hover'),
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/dataroot_browser', [
				'dir' => $path,
			]),
			'is_trusted' => true,
		]);
	}
}
