<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// set attributes
$attributes = $node->attr();
$attributes['type']  = 'text';
$attributes['name']  = $name;
$attributes['value'] = $value;

printf('<input %s />', $control->attributes($attributes, array('label', 'description', 'default')));