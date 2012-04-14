<?php 

	$english = array(
		'dataroot_browser' => "Dataroot Browser",
	
		'admin:administer_utilities:dataroot_browser' => "Dataroot Browser",
		
		'dataroot_browser:list:current_dir' => "Current",
		'dataroot_browser:list:invalid_dir' => "Invalid directory. Restart browsing",
	
		'dataroot_browser:list:name' => "Name",
		'dataroot_browser:list:size' => "Size",
		'dataroot_browser:list:owner' => "Owner",
		'dataroot_browser:list:writeable' => "Writeable",
		'dataroot_browser:list:modified' => "Last modified",
	
		// actions
		// delete file
		'dataroot_browser:actions:delete_file:error:input' => "Incorrect input to delete a file",
		'dataroot_browser:actions:delete_file:error:path' => "The filename has directory elements, this is not allowed",
		'dataroot_browser:actions:delete_file:error:exists' => "The filename doesn't exists on the system or is a directory",
		'dataroot_browser:actions:delete_file:error:delete' => "An unknown error has occured while deleting the file",
		'dataroot_browser:actions:delete_file:success' => "The file was successfully deleted",
		
	);
	
	add_translation("en", $english);
