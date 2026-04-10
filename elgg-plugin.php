<?php

use ColdTrick\DatarootBrowser\Controllers\Actions\Download;

return [
	'plugin' => [
		'version' => '7.0.4',
	],
	'actions' => [
		'dataroot_browser/delete_file' => [
			'access' => 'admin',
		],
		'dataroot_browser/download' => [
			'access' => 'admin',
			'controller' => Download::class,
		],
	],
	'events' => [
		'register' => [
			'menu:admin_header' => [
				'\ColdTrick\DatarootBrowser\Menus\AdminHeader::registerDatarootBrowser' => [],
			],
			'menu:dataroot_browser:breadcrumb' => [
				'\ColdTrick\DatarootBrowser\Menus\Breadcrumb::registerPath' => [],
			],
			'menu:entity' => [
				'\ColdTrick\DatarootBrowser\Menus\EntityMenu::register' => [],
			],
			'menu:entity_explorer' => [
				'\ColdTrick\DatarootBrowser\Menus\EntityExplorer::register' => [],
			],
			'menu:user_hover' => [
				'\ColdTrick\DatarootBrowser\Menus\UserHover::register' => [],
			],
		],
	],
];
