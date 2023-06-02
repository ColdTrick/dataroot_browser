<?php

return [
	'plugin' => [
		'version' => '6.0',
	],
	'actions' => [
		'dataroot_browser/delete_file' => [
			'access' => 'admin',
		],
		'dataroot_browser/download' => [
			'access' => 'admin',
		],
	],
	'events' => [
		'register' => [
			'menu:dataroot_browser:breadcrumb' => [
				'\ColdTrick\DatarootBrowser\Menus\Breadcrumb::registerPath' => [],
			],
			'menu:entity' => [
				'\ColdTrick\DatarootBrowser\Menus\EntityMenu::register' => [],
			],
			'menu:entity_explorer' => [
				'\ColdTrick\DatarootBrowser\Menus\EntityExplorer::register' => [],
			],
			'menu:admin_header' => [
				'\ColdTrick\DatarootBrowser\Menus\AdminHeaderMenu::registerDatarootBrowser' => [],
			],
			'menu:user_hover' => [
				'\ColdTrick\DatarootBrowser\Menus\UserHover::register' => [],
			],
		],
	],
];
