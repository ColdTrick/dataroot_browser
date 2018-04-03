<?php

use ColdTrick\DatarootBrowser\Bootstrap;

return [
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'dataroot_browser/delete_file' => [
			'access' => 'admin',
		],
		'dataroot_browser/download' => [
			'access' => 'admin',
		],
	],
];
