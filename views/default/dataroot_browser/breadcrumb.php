<?php

$current_dir = elgg_extract('current_dir', $vars);
$current_dir = sanitise_filepath($current_dir);

$dir_parts = explode('/', trim($current_dir, '/'));

$dir_links = [];
$base_url = 'admin/administer_utilities/dataroot_browser';

// add link to dataroot
$dir_links[] = elgg_view('output/url', [
	'text' => elgg_echo('dataroot_browser:list:root_dir'),
	'href' => $base_url,
]);

// add parts
$temp_dir = '';
foreach ($dir_parts as $part) {
	$temp_dir .= $part . '/';
	$dir_links[] = elgg_view('output/url', [
		'text' => $part,
		'href' => elgg_http_add_url_query_elements($base_url, [
			'dir' => trim($temp_dir, '/'),
		]),
	]);
}

$output = elgg_echo('dataroot_browser:list:current_dir') . ': ';
$output .= implode(' / ', $dir_links);

// add up link?
if ($current_dir != '/') {
	$parent_dir = substr($current_dir, 0, strrpos(rtrim($current_dir, '/'), '/'));
	$output .= elgg_view('output/url', [
		'text' => '',
		'title' => elgg_echo('up'),
		'href' => elgg_http_add_url_query_elements($base_url, [
			'dir' => $parent_dir,
		]),
		'class' => 'dataroot_browser_up mls',
	]);
}

echo elgg_format_element('div', ['class' => 'mbm'], $output);
