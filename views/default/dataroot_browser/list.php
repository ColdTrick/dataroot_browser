<?php 
	$current_dir = $vars["current_dir"] . "/";
	$root_dir = str_replace("//", "/", elgg_get_config("dataroot") . $current_dir);
	
	$dir_data = scandir($root_dir);
	
	echo "<div>";
	if($dir_data !== false){
		
		echo elgg_echo("dataroot_browser:list:current_dir") . ": " . $current_dir;
		if($current_dir != "/"){
			$parent_dir = substr($current_dir, 0, strrpos($vars["current_dir"], "/"));
			echo " <a class='dataroot_browser_up' href='" . $vars["url"] . "admin/administer_utilities/dataroot_browser?dir=" . urlencode($parent_dir) . "'></a>";
		}
		echo "<br /><br />";
		
		$dir_items = "";
		$file_items = "";
		
		foreach($dir_data as $file){
			if($file != "." && $file != ".."){
				if(is_dir($root_dir . $file)){
					$dir_items .= "<tr>";
					$dir_items .= "<td class='dataroot_browser_name dataroot_browser_folder' colspan='6'>";
					$dir_items .= "<a href='" . $vars["url"] . "admin/administer_utilities/dataroot_browser?dir=" . urlencode($current_dir . $file) . "'>" . $file . "</a>";
					$dir_items .= "</td>";
					$dir_items .= "</tr>";
				} else {
					
					$stats = stat($root_dir. $file);
					if(is_callable("posix_getpwuid")){
						$owner = posix_getpwuid($stats["uid"]);
					} else {
						$owner = $stats["uid"];
					}
					$size = dataroot_browser_format_size($stats["size"]);
					$last_modified = date ("Y/m/d H:i:s", $stats["mtime"]);
					if(is_writeable($root_dir. $file)){
						$writeable = "yes";
					} else {
						$writeable = "no";
					} 
					
					$file_items .= "<tr>";
					$file_items .= "<td class='dataroot_browser_name dataroot_browser_file'>";
					$file_items .= $file;
					$file_items .= "</td>";
					$file_items .= "<td>" . $last_modified . "</td>";
					$file_items .= "<td>" . $size . "</td>";
					$file_items .= "<td>" . $owner["name"] . "</td>";
					$file_items .= "<td>" . $writeable . "</td>";
					$file_items .= "<td>";
					$file_items .= "<a href='" . elgg_add_action_tokens_to_url($vars["url"] . "action/dataroot_browser/delete_file?file=" . urlencode($current_dir . $file)) . "' onclick='return confirm(\"" . addslashes(elgg_echo("question:areyousure")) . "\");' >" . elgg_view_icon("delete") . "</a>";
					$file_items .= "</td>";
					$file_items .= "</tr>";
				}
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
		if($dir_items){
			echo $dir_items;
		}
		
		if($file_items){
			echo $file_items;
		}
		echo "</table>";
		
	} else {
		echo elgg_echo("dataroot_browser:list:invalid_dir");
	}
	echo "</div>";
	