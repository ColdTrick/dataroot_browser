<?php

$file = get_input('file');
$file = sanitise_filepath($file, false);

if (empty($file)) {
	register_error(elgg_echo('dataroot_browser:actions:delete_file:error:input'));
	forward(REFERER);
}

$file_path = elgg_get_data_path() . $file;

if (!file_exists($file_path) || is_dir($file_path)) {
	register_error(elgg_echo('dataroot_browser:actions:delete_file:error:exists'));
	forward(REFERER);
}

if (unlink($file_path)) {
	system_message(elgg_echo('dataroot_browser:actions:delete_file:success'));
} else {
	register_error(elgg_echo('dataroot_browser:actions:delete_file:error:delete'));
}

forward(REFERER);
