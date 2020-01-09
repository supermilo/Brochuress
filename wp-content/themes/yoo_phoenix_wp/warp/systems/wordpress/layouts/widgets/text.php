<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

$out = trim($oldoutput);

if (preg_match('/^<div class="textwidget">/i', $out)) {
	$out = substr($out, 24, -6);
}

echo $out;