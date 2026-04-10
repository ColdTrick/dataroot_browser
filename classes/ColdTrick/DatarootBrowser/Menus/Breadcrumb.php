<?php

namespace ColdTrick\DatarootBrowser\Menus;

use Elgg\Menu\MenuItems;
use Elgg\Project\Paths;

/**
 * Register menu items to the dataroot_browser:breadcrumb menu
 */
class Breadcrumb {
	
	/**
	 * Register the dataroot breadcrumb
	 *
	 * @param \Elgg\Event $event 'register', 'menu:dataroot_browser:breadcrumb'
	 *
	 * @return null|MenuItems
	 */
	public static function registerPath(\Elgg\Event $event): ?MenuItems {
		$dir = ltrim(Paths::sanitize($event->getParam('current_dir')), '/');
		
		$dataroot = elgg_get_data_path();
		
		/** @var MenuItems $return */
		$return = $event->getValue();
		$return->fill([]);
		
		// root
		$return[] = \ElggMenuItem::factory([
			'name' => 'root',
			'text' => elgg_echo('dataroot_browser:list:root_dir'),
			'href' => elgg_generate_url('admin', [
				'segments' => 'administer_utilities/dataroot_browser',
			]),
			'priority' => 1,
		]);
		
		// path
		if (empty($dir) || !is_dir($dataroot . $dir)) {
			return $return;
		}
		
		$path = explode('/', trim($dir, '/'));
		$stack = [];
		foreach ($path as $index => $part) {
			$stack[] = $part;
			
			$return[] = \ElggMenuItem::factory([
				'name' => "dataroot_browser_{$index}",
				'text' => $part,
				'href' => elgg_generate_url('admin', [
					'segments' => 'administer_utilities/dataroot_browser',
					'dir' => implode('/', $stack),
				]),
				'priority' => 10 + $index,
			]);
		}
		
		return $return;
	}
}
