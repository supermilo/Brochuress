<?php 
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// set header
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) @ob_start('ob_gzhandler');
header('Content-type: application/x-javascript');
header('Cache-Control: max-age=86400');

// include file
if (isset($_GET['id']) && $_GET['id']) {

	$id   = (string) preg_replace('/[^A-Z0-9_\.-]/i', '', $_GET['id']);
	$file = dirname(__FILE__).'/js-'.$id.'.js';

	if (is_file($file)) {
		include($file);
	}
}