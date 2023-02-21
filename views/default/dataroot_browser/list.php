<?php

use Elgg\Project\Paths;

$current_dir = ltrim(Paths::sanitize(elgg_extract('current_dir', $vars)), '/');

// breadcrumb
echo elgg_view('dataroot_browser/breadcrumb', $vars);

$root_dir = elgg_get_data_path() . $current_dir;
if (!is_dir($root_dir)) {
	echo elgg_view_message('error', elgg_echo('dataroot_browser:list:invalid_dir'));
	return;
}

// go through all folders/file in this dir
$dir_items = [];
$file_items = [];

$dir_classes = [
	'dataroot-browser-folder',
];
$file_classes = [
	'dataroot-browser-file',
];

$posix_getpwuid = is_callable('posix_getpwuid');

$base_url = 'admin/administer_utilities/dataroot_browser';

$dh = new DirectoryIterator($root_dir);
foreach ($dh as $file) {
	$cells = [];
	
	if ($file->isDot()) {
		continue;
	}
	
	$last_modified = date('Y/m/d H:i:s', $file->getMTime());
	
	if ($posix_getpwuid) {
		$owner = posix_getpwuid($file->getOwner());
		$owner = elgg_extract('name', $owner, $file->getOwner());
	} else {
		$owner = $file->getOwner();
	}
	
	$writeable = elgg_echo('option:no');
	if ($file->isWritable()) {
		$writeable = elgg_echo('option:yes');
	}
	
	$file_path = $current_dir . $file->getFilename();
	$file_path = trim($file_path, '/');
	
	if ($file->isDir()) {
		if ($file->isReadable()) {
			$cells[] = elgg_format_element('td', ['class' => $dir_classes], elgg_view('output/url', [
				'href' => elgg_http_add_url_query_elements($base_url, [
					'dir' => $file_path,
				]),
				'text' => $file,
				'is_trusted' => true,
				'icon' => 'folder',
			]));
		} else {
			$cells[] = elgg_format_element('td', [], $file->getFilename());
		}
		
		$cells[] = elgg_format_element('td', [], $last_modified);
		$cells[] = elgg_format_element('td', [], '&nbsp;');
		$cells[] = elgg_format_element('td', [], $owner);
		$cells[] = elgg_format_element('td', ['class' => 'center'], $writeable);
		$cells[] = elgg_format_element('td', ['class' => 'center'], '&nbsp;');
		
		// add to correct table section
		$dir_items[$file->getFilename()] = elgg_format_element('tr', [], implode('', $cells));
	} else {
		$size = elgg_format_bytes($file->getSize());
		
		$cells[] = elgg_format_element('td', ['class' => $file_classes], elgg_view('output/url', [
			'text' => $file,
			'href' => elgg_generate_action_url('dataroot_browser/download', [
				'file' => $file_path,
			]),
			'title' => elgg_echo('download'),
			'is_action' => true,
			'is_trusted' => true,
			'icon' => 'file',
		]));
		$cells[] = elgg_format_element('td', [], $last_modified);
		$cells[] = elgg_format_element('td', [], $size);
		$cells[] = elgg_format_element('td', [], $owner);
		$cells[] = elgg_format_element('td', ['class' => 'center'], $writeable);
		$cells[] = elgg_format_element('td', ['class' => 'center'], elgg_view('output/url', [
			'href' => elgg_generate_action_url('dataroot_browser/delete_file', [
				'file' => $file_path,
			]),
			'text' => elgg_view_icon('delete'),
			'is_trusted' => true,
			'confirm' => elgg_echo('deleteconfirm'),
		]));
		
		// add to correct table section
		$file_items[$file->getFilename()] = elgg_format_element('tr', [], implode('', $cells));
	}
}

if (empty($dir_items) && empty($file_items)) {
	echo elgg_view_message('notice', elgg_echo('dataroot_browser:list:no_content'));
	return;
}

// build table
$table_contents = [];

// table header
$cells = [];
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:name'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:modified'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:size'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:owner'));
$cells[] = elgg_format_element('th', ['class' => 'center'], elgg_echo('dataroot_browser:list:writeable'));
$cells[] = elgg_format_element('th', ['class' => 'center'], elgg_echo('delete'));

$header_row = elgg_format_element('tr', [], implode('', $cells));
$table_contents[] = elgg_format_element('thead', [], $header_row);

// add rows
$rows = '';
if (!empty($dir_items)) {
	uksort($dir_items, 'strnatcasecmp');
	
	$rows .= implode('', $dir_items);
}

if (!empty($file_items)) {
	uksort($file_items, 'strnatcasecmp');
	
	$rows .= implode('', $file_items);
}

$table_contents[] = elgg_format_element('tbody', [], $rows);

// draw table
$table_attributes = [
	'class' => 'elgg-table',
];
echo elgg_format_element('table', $table_attributes, implode('', $table_contents));
