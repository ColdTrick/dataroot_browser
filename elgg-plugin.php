<?php

return [
	'plugin' => [
		'version' => '5.0',
	],
	'events' => [
		'register' => [
			'menu:dataroot_browser:breadcrumb' => [
				'\ColdTrick\DatarootBrowser\Breadcrumb::registerPath' => [],
			],
			'menu:entity' => [
				'\ColdTrick\DatarootBrowser\EntityMenu::register' => [],
			],
			'menu:admin_header' => [
				'\ColdTrick\DatarootBrowser\AdminHeaderMenu::registerDatarootBrowser' => [],
			],
			'menu:user_hover' => [
				'\ColdTrick\DatarootBrowser\UserHover::register' => [],
			],
		],
	],
	'actions' => [
		'dataroot_browser/delete_file' => [
			'access' => 'admin',
		],
		'dataroot_browser/download' => [
			'access' => 'admin',
		],
	],
];
