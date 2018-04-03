<?php

namespace ColdTrick\DatarootBrowser;

class PageMenu {
	
	/**
	 * Register admin menu item
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:page'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerDatarootBrowser(\Elgg\Hook $hook) {
		
		if (!elgg_is_admin_logged_in() || !elgg_in_context('admin')) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'dataroot_browser',
			'text' => elgg_echo('admin:administer_utilities:dataroot_browser'),
			'href' => '/admin/administer_utilities/dataroot_browser',
			'section' => 'administer',
			'parent_name' => 'administer_utilities',
		]);
		
		return $return;
	}
}
