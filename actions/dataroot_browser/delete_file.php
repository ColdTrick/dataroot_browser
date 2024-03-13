<?php

use Elgg\Project\Paths;

$file = ltrim(Paths::sanitize(get_input('file', null, false), false), '/');

if (empty($file)) {
	return elgg_error_response(elgg_echo('dataroot_browser:actions:delete_file:error:input'));
}

$file_path = elgg_get_data_path() . $file;

if (!file_exists($file_path) || is_dir($file_path)) {
	return elgg_error_response(elgg_echo('dataroot_browser:actions:delete_file:error:exists'));
}

if (!unlink($file_path)) {
	return elgg_error_response(elgg_echo('dataroot_browser:actions:delete_file:error:delete'));
}

return elgg_ok_response('', elgg_echo('dataroot_browser:actions:delete_file:success'));
