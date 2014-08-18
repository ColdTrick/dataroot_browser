<?php
/**
 * All helper functions are bundled here
 */

/**
 * Convert a byte size into something readable
 *
 * @param int $size the size to convert
 *
 * @return string
 */
function dataroot_browser_format_size($size) {
	$sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
	
	if ($size == 0) {
		return("n/a");
	} else {
		return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
	}
}