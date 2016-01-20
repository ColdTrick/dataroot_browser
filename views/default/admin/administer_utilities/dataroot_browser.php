<?php

$current_dir = get_input('dir');
$current_dir = sanitise_filepath($current_dir);

echo elgg_view('dataroot_browser/list', [
	'current_dir' => $current_dir,
]);
