<?php
/**
 * Posts Controller
 * Copyright (c)  GREENPEACE INTERNATIONAL 2009
 *
 * Licensed under The General Public Licence v3 onwards.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Greenpeace International
 * @license     GPL3 onwards - http://www.opensource.org/licenses/gpl-license.php
 */
class PostsController extends AppController {
	var $name = 'Posts';
/**
 * Post Index - Read rss feed from "Making waves" blog
 *
 * @return void
 * @access public
 */
	function index($cat="news") {
		switch($cat) {
		  case "news":
		  case "twitter":
			  $cacheKey = 'posts_index_'.$cat;
				$posts = Cache::read($cacheKey);
				
				if (!$posts) {
					App::import('Core', 'Xml');
					$rss = Set::reverse(new XML(Configure::read('App.'.$cat.'Feed')));
		
					$posts = array();
					if (isset($rss["Rss"]["Channel"]["Item"]) && !empty($rss["Rss"]["Channel"]["Item"])) {
						$posts = $rss["Rss"]["Channel"]["Item"];
						Cache::write($cacheKey, $posts);
					}
				}
				
				if (isset($this->params['requested'])) {
					return $posts;
			  } else {
					$this->set(compact('posts'));
				}
		  break;
		  default:
		  	Assert::notEmpty(null, '404');
		  break;
		}
	}
}
?>