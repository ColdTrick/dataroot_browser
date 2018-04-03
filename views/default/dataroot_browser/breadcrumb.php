<?php

echo elgg_view_menu('dataroot_browser:breadcrumb', [
	'current_dir' => elgg_extract('current_dir', $vars),
	'class' => [
		'elgg-menu-hz',
		'elgg-breadcrumbs',
	],
]);
