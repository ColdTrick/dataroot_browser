<?php

use Elgg\Project\Paths;

$current_dir = Paths::sanitize(get_input('dir'));

echo elgg_view('dataroot_browser/list', [
	'current_dir' => $current_dir,
]);
