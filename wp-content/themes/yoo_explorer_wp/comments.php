<?php
/**
* @package   Explorer
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// find related file in /warp/systems/wordpress/layouts/comments.php
$warp = Warp::getInstance();
echo $warp->template->render('comments');