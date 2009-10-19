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
	function index($cat = 'news') {
		switch ($cat) {
			case 'news':
			case 'twitter':
				$posts = $this->Post->find('twitter');
				$this->set(compact('posts'));
				break;
			default:
				Assert::true(false, '404');
				break;
		}
	}
}
?>