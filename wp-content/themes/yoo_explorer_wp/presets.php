<?php
/**
* @package   Explorer
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
 * Presets
 */

$default_preset = array();

$warp->config->addPreset('default', 'Business', array_merge($default_preset,array(
	'color' => 'default'
)));

$warp->config->addPreset('adventure', 'Adventure',  array_merge($default_preset,array(
	'color' => 'adventure'
)));

$warp->config->addPreset('travel', 'Travel',  array_merge($default_preset,array(
	'color' => 'travel'
)));

$warp->config->addPreset('sports', 'Sports',  array_merge($default_preset,array(
	'color' => 'sports'
)));

$warp->config->addPreset('blogging', 'Blogging',  array_merge($default_preset,array(
	'color' => 'blogging'
)));

$warp->config->applyPreset();