<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
	Class: WarpObject
		Object base class, only for PHP4 compatibility
*/
class WarpObject {

	/*
		Function: Constructor
			Class Constructor.
	*/
	function __construct() {}

	/*
		Function: Constructor
			Class Constructor (PHP4 compatibility).
	*/
	function WarpObject() {
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

}