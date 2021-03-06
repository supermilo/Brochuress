<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

class WarpHelperModules extends WarpHelper {

	/*
		Function: count
			Retrieve the active module count at a position

		Returns:
			Int
	*/
	function count($positions) {
        
        $positions = explode('+', $positions);
		$widgets   = $this->warp->system->getWidgets();
        $count     = 0;

        foreach ($positions as $pos) {
			$pos = trim($pos);
			
			if (isset($widgets[$pos])) {
			    foreach ($widgets[$pos] as $widget) {
			        if ($widget->display) {
			            $count +=1;
			        }
			    }
			}
			
			if (!$count && ($this->warp->system->isPreview($pos) || $pos == 'menu')) {
				$count += 1;
			}
		}

        return $count;
	}

	/*
		Function: render
			Shortcut to render a position

		Returns:
			String
	*/
	function render($position, $args = array()) {

		// set position in arguments
		$args['position'] = $position;

		return $this->warp->template->render('modules', $args);
	}

	/*
		Function: register
			Register a position

		Returns:
			Void
	*/
	function register($positions) {
        
        $positions = (array) $positions;
        
        foreach ($positions as $name) {
            register_sidebar(array(
		    'name' => $name,
            'id' => $name,
            'description' => '',
            'before_widget' => '<!--widget-%1$s<%2$s>-->',
            'after_widget' => '<!--widget-end-->',
            'before_title' => '<!--title-start-->',
            'after_title' => '<!--title-end-->',
		    ));
        }
	}

}