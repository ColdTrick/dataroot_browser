<?php

$file = get_input('file');
$file = sanitise_filepath($file, false);

// no file
if (empty($file)) {
	forward(REFERER);
}

$file_path = elgg_get_data_path() . $file;
// file doesn't exist or is directory
if (!file_exists($file_path) || is_dir($file_path)) {
	forward(REFERER);
}

$contents = file_get_contents($file_path);
// empty file
if (empty($contents)) {
	forward(REFERER);
}

$filename = basename($file_path);

$mimetype = 'application/octet-stream';
if (is_callable('finfo_open')) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mimetype = finfo_file($finfo, $file_path);
}

header("Pragma: public");
header("Content-type: {$mimetype}");
header("Content-Disposition: attachment; filename=\"{$filename}\"");
header("Content-Length: " . strlen($contents));

echo $contents;

exit();
