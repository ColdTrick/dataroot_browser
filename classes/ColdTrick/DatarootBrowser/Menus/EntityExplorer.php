<?php

namespace ColdTrick\DatarootBrowser\Menus;

use ColdTrick\DatarootBrowser\EntityMenuItem;
use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity_explorer menu
 */
class EntityExplorer {
	
	use EntityMenuItem;
	
	/**
	 * Add the dataroot menu item
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity_explorer'
	 *
	 * @return MenuItems|null
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return null;
		}
		
		$menu_item = self::getEntityMenuItem($entity);
		if (!$menu_item instanceof \ElggMenuItem) {
			return null;
		}
		
		/* @var $result MenuItems */
		$result = $event->getValue();
		
		$menu_item->setLinkClass(['elgg-button', 'elgg-button-action']);
		
		$result[] = $menu_item;
		
		return $result;
	}
}
