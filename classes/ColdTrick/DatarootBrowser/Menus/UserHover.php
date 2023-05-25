<?php

namespace ColdTrick\DatarootBrowser\Menus;

use ColdTrick\DatarootBrowser\EntityMenuItem;
use Elgg\Menu\MenuItems;

/**
 * Add menu items to the user_hover menu
 */
class UserHover {
	
	use EntityMenuItem;
	
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
			
			$menu_item = self::getEntityMenuItem($user);
			if ($menu_item instanceof \ElggMenuItem) {
				$menu_item->setSection('admin');
				
				$user_dirs[$user->guid] = $menu_item;
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
