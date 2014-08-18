<?php ?>

#dataroot_browser_list th {
	font-weight: bold;
	text-align: center;
	white-space: nowrap;
	padding: 0 5px;
}

#dataroot_browser_list tr:hover {
	background-color: #cecece;
}

#dataroot_browser_list tr:hover td {
	color: #333333;
}

#dataroot_browser_list td {
	padding: 0 5px;
	text-align: center;
	white-space: nowrap;
	color: #CCCCCC;
}

#dataroot_browser_list .dataroot_browser_name {
	text-align: left;
	padding-left: 20px;
	white-space: normal;
	word-wrap: break-word;
	color: #333333;
	width: 100%;
}

#dataroot_browser_list .dataroot_browser_folder {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/dataroot_browser/_graphics/folder.png) no-repeat left top;
}

#dataroot_browser_list .dataroot_browser_file {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/dataroot_browser/_graphics/file.png) no-repeat left top;
}

.dataroot_browser_up {
	display: inline-block;
	width: 16px;
	height: 16px;
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/dataroot_browser/_graphics/up.png) no-repeat left top;
}
