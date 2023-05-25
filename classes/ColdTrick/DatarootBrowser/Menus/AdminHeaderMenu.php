<?php

namespace ColdTrick\DatarootBrowser\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin_header menu
 */
class AdminHeaderMenu {
	
	/**
	 * Register admin menu item
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return null|MenuItems
	 */
	public static function registerDatarootBrowser(\Elgg\Event $event): ?MenuItems {
		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return null;
		}
		
		/* @var $return MenuItems */
		$return = $event->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'dataroot_browser',
			'text' => elgg_echo('admin:administer_utilities:dataroot_browser'),
			'href' => '/admin/administer_utilities/dataroot_browser',
			'parent_name' => 'administer_utilities',
		]);
		
		return $return;
	}
}
