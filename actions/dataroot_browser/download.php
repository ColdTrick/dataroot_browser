<?php

use Elgg\Project\Paths;
use Elgg\Filesystem\MimeTypeDetector;

$file = ltrim(Paths::sanitize(get_input('file'), false), '/');

// no file
if (empty($file)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$file_path = elgg_get_data_path() . $file;
// file doesn't exist or is directory
if (!file_exists($file_path) || is_dir($file_path)) {
	return elgg_error_response(elgg_echo('notfound'));
}

$contents = file_get_contents($file_path);
// empty file
if (empty($contents)) {
	return elgg_error_response(elgg_echo('notfound'));
}

$filename = basename($file_path);
$mtd = new MimeTypeDetector();

header("Pragma: public");
header("Content-type: {$mtd->getType($file_path)}");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Content-Length: " . strlen($contents));

echo $contents;

exit();
