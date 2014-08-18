<?php

$file = get_input("file");

if (!empty($file)) {
	if (!stristr($file, "/.") && !stristr($file, "/..")) {
		$file_path = str_replace("//", "/", elgg_get_data_path() . $file);
		
		if (file_exists($file_path) && !is_dir($file_path)) {
			if (unlink($file_path)) {
				system_message(elgg_echo("dataroot_browser:actions:delete_file:success"));
			} else {
				register_error(elgg_echo("dataroot_browser:actions:delete_file:error:delete"));
			}
		} else {
			register_error(elgg_echo("dataroot_browser:actions:delete_file:error:exists"));
		}
	} else {
		register_error(elgg_echo("dataroot_browser:actions:delete_file:error:path"));
	}
} else {
	register_error(elgg_echo("dataroot_browser:actions:delete_file:error:input"));
}

forward(REFERER);