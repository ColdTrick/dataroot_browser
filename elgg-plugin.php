<?php

use ColdTrick\DatarootBrowser\Bootstrap;

return [
	'plugin' => [
		'version' => '4.0.1',
	],
	'hooks' => [
		'register' => [
			'menu:dataroot_browser:breadcrumb' => [
				'\ColdTrick\DatarootBrowser\Breadcrumb::registerPath' => [],
			],
			'menu:entity' => [
				'\ColdTrick\DatarootBrowser\EntityMenu::register' => [],
			],
			'menu:page' => [
				'\ColdTrick\DatarootBrowser\PageMenu::registerDatarootBrowser' => [],
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
