<?php

namespace ColdTrick\DatarootBrowser;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// plugin hooks
		$hooks = $this->elgg()->hooks;
		$hooks->registerHandler('register', 'menu:dataroot_browser:breadcrumb', '\ColdTrick\DatarootBrowser\Breadcrumb::registerPath');
		$hooks->registerHandler('register', 'menu:entity', '\ColdTrick\DatarootBrowser\EntityMenu::register');
		$hooks->registerHandler('register', 'menu:page', '\ColdTrick\DatarootBrowser\PageMenu::registerDatarootBrowser');
		$hooks->registerHandler('register', 'menu:user_hover', '\ColdTrick\DatarootBrowser\UserHover::register');
	}
}
