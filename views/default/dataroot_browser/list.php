<?php

$current_dir = elgg_extract('current_dir', $vars);
$current_dir = sanitise_filepath($current_dir);

$root_dir = elgg_get_data_path() . $current_dir;
if (!is_dir($root_dir)) {
	echo elgg_format_element('div', [], elgg_echo('dataroot_browser:list:invalid_dir'));
	return;
}

$dir_data = scandir($root_dir);

// breadcrumb
echo elgg_view('dataroot_browser/breadcrumb', [
	'current_dir' => $current_dir,
]);

// go through all folders/file in this dir
$dir_items = [];
$file_items = [];

$dir_classes = [
	'dataroot_browser_name',
	'dataroot_browser_folder',
];
$file_classes = [
	'dataroot_browser_name',
	'dataroot_browser_file',
];

$posix_getpwuid = is_callable('posix_getpwuid');

$base_url = 'admin/administer_utilities/dataroot_browser';
$download_url = 'action/dataroot_browser/download';
$delete_url = 'action/dataroot_browser/delete_file';

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
			]));
		} else {
			$cells[] = $file->getFilename();
		}
		$cells[] = elgg_format_element('td', [], $last_modified);
		$cells[] = elgg_format_element('td', [], '&nbsp;');
		$cells[] = elgg_format_element('td', [], $owner);
		$cells[] = elgg_format_element('td', [], $writeable);
		$cells[] = elgg_format_element('td', [], '&nbsp;');
		
		// add to correct table section
		$dir_items[] = elgg_format_element('tr', [], implode('', $cells));
	} else {
		
		$size = dataroot_browser_format_size($file->getSize());
		
		$cells[] = elgg_format_element('td', ['class' => $file_classes], elgg_view('output/url', [
			'text' => $file,
			'href' => elgg_http_add_url_query_elements($download_url, [
				'file' => $file_path,
			]),
			'title' => elgg_echo('download'),
			'is_action' => true,
			'is_trusted' => true,
		]));
		$cells[] = elgg_format_element('td', [], $last_modified);
		$cells[] = elgg_format_element('td', [], $size);
		$cells[] = elgg_format_element('td', [], $owner);
		$cells[] = elgg_format_element('td', [], $writeable);
		$cells[] = elgg_format_element('td', [], elgg_view('output/url', [
			'href' => elgg_http_add_url_query_elements($delete_url, [
				'file' => $file_path,
			]),
			'text' => elgg_view_icon('delete'),
			'is_trusted' => true,
			'confirm' => true,
		]));
		
		// add to correct table section
		$file_items[] = elgg_format_element('tr', [], implode('', $cells));
	}
}

// build table
$table_contents = [];

// table header
$cells = [];
$cells[] = elgg_format_element('th', ['class' => 'dataroot_browser_name'], elgg_echo('dataroot_browser:list:name'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:modified'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:size'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:owner'));
$cells[] = elgg_format_element('th', [], elgg_echo('dataroot_browser:list:writeable'));
$cells[] = elgg_format_element('th', [], elgg_echo('delete'));

$header_row = elgg_format_element('tr', [], implode('', $cells));
$table_contents[] = elgg_format_element('thead', [], $header_row);

// add rows
$rows = '';
if (!empty($dir_items)) {
	$rows .= implode('', $dir_items);
}

if (!empty($file_items)) {
	$rows .= implode('', $file_items);
}

$table_contents[] = elgg_format_element('tbody', [], $rows);

// draw table
$table_attributes = [
	'id' => 'dataroot_browser_list',
	'class' => 'elgg-table',
];
echo elgg_format_element('table', $table_attributes, implode('', $table_contents));
