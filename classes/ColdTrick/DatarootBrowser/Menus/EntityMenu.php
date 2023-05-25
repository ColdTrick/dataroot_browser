<?php

namespace ColdTrick\DatarootBrowser\Menus;

use ColdTrick\DatarootBrowser\EntityMenuItem;
use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class EntityMenu {
	
	use EntityMenuItem;
	
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
		
		$menu_item = self::getEntityMenuItem($entity);
		if (!$menu_item instanceof \ElggMenuItem) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = $menu_item;
		
		return $return_value;
	}
}
