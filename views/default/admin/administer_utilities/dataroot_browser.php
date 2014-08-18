<?php
$current_dir = get_input("dir");

echo elgg_view("dataroot_browser/list", array("current_dir" => $current_dir));
