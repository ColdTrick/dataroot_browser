<?php

$current_dir = elgg_extract("current_dir", $vars) . "/";
$root_dir = str_replace("//", "/", elgg_get_data_path() . $current_dir);

$dir_data = scandir($root_dir);

echo "<div>";

if ($dir_data !== false) {
	
	echo elgg_echo("dataroot_browser:list:current_dir") . ": " . $current_dir;
	
	if ($current_dir != "/") {
		$parent_dir = substr($current_dir, 0, strrpos(elgg_extract("current_dir", $vars), "/"));
		echo elgg_view("output/url", array(
			"href" => "admin/administer_utilities/dataroot_browser?dir=" . urlencode($parent_dir),
			"class" => "dataroot_browser_up mls",
			"title" => elgg_echo("up"),
			"text" => ""
		));
	}
	echo "<br /><br />";
	
	$dir_items = "";
	$file_items = "";
	
	$posix_getpwuid = is_callable("posix_getpwuid");
	
	foreach ($dir_data as $file) {
		if (($file == ".") || ($file == "..")) {
			continue;
		}
		
		$stats = stat($root_dir . $file);
		
		$last_modified = date("Y/m/d H:i:s", $stats["mtime"]);
		
		if ($posix_getpwuid) {
			$owner = posix_getpwuid($stats["uid"]);
			$owner = elgg_extract("name", $owner, $stats["uid"]);
		} else {
			$owner = $stats["uid"];
		}
		
		$writeable = elgg_echo("option:no");
		if (is_writeable($root_dir . $file)) {
			$writeable = elgg_echo("option:yes");
		}
		
		if (is_dir($root_dir . $file)) {
			$dir_items .= "<tr>";
			$dir_items .= "<td class='dataroot_browser_name dataroot_browser_folder'>";
			if (is_readable($root_dir . $file)) {
				$dir_items .= elgg_view("output/url", array(
					"href" => "admin/administer_utilities/dataroot_browser?dir=" . urlencode($current_dir . $file),
					"text" => $file,
					"is_trusted" => true
				));
			} else {
				$dir_items .= $file;
			}
			$dir_items .= "</td>";
			$dir_items .= "<td>" . $last_modified . "</td>";
			$dir_items .= "<td>&nbsp;</td>";
			$dir_items .= "<td>" . $owner . "</td>";
			$dir_items .= "<td>" . $writeable . "</td>";
			$dir_items .= "<td>&nbsp;</td>";
			$dir_items .= "</tr>";
		} else {
			
			$size = dataroot_browser_format_size($stats["size"]);
			
			$file_items .= "<tr>";
			$file_items .= "<td class='dataroot_browser_name dataroot_browser_file'>";
			$file_items .= elgg_view("output/url", array(
				"text" => $file,
				"href" => "action/dataroot_browser/download?file=" . urlencode($current_dir . $file),
				"title" => elgg_echo("download"),
				"is_action" => true,
				"is_trusted" => true
			));
			$file_items .= "</td>";
			$file_items .= "<td>" . $last_modified . "</td>";
			$file_items .= "<td>" . $size . "</td>";
			$file_items .= "<td>" . $owner . "</td>";
			$file_items .= "<td>" . $writeable . "</td>";
			$file_items .= "<td>";
			$file_items .= elgg_view("output/url", array(
				"href" => "action/dataroot_browser/delete_file?file=" . urlencode($current_dir . $file),
				"text" => elgg_view_icon("delete"),
				"is_trusted" => true,
				'confirm' => true
			));
			$file_items .= "</td>";
			$file_items .= "</tr>";
		}
	}
	
	echo "<table id='dataroot_browser_list' class='elgg-table'>";
	echo "<tr>";
	echo "<th class='dataroot_browser_name'>" . elgg_echo("dataroot_browser:list:name") . "</th>";
	echo "<th>" . elgg_echo("dataroot_browser:list:modified") . "</th>";
	echo "<th>" . elgg_echo("dataroot_browser:list:size") . "</th>";
	echo "<th>" . elgg_echo("dataroot_browser:list:owner") . "</th>";
	echo "<th>" . elgg_echo("dataroot_browser:list:writeable") . "</th>";
	echo "<th>" . elgg_echo("delete") . "</th>";
	echo "</tr>";
	
	if ($dir_items) {
		echo $dir_items;
	}
	
	if ($file_items) {
		echo $file_items;
	}
	echo "</table>";
	
} else {
	echo elgg_echo("dataroot_browser:list:invalid_dir");
}
echo "</div>";
